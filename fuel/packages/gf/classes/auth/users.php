<?php

namespace Gf\Auth;

use Auth\Auth as Fuel_Auth;
use Fuel\Core\Str;
use Fuel\Core\Validation;
use Gf\Exception\AppException;
use Gf\Exception\UserException;
use Gf\Utils;

/**
 * Class Users
 * A new version of the Auth class
 *
 * @package Nb
 */
class Users {
    public $usersTable = 'users';
    public $providersTable = 'users_providers';
    public $db = 'default';

    public static $administrator = 100;       // no level

    public $groups = [
        100 => 'administrator',
    ];

    public static $instance;

    /**
     * @return Users
     */
    public static function instance () {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function group_name ($group_id) {
        return isset($this->groups[$group_id]) ? $this->groups[$group_id] : false;
    }

    /**
     * @return mixed
     * @deprecated
     * @see \Gf\Utils::sqlGetFoundRows()
     */
    public function get_found_rows_query () {
        $a = \DB::query("SELECT FOUND_ROWS() as c;")
            ->execute($this->db)
            ->as_array();

        return $a[0]['c'];
    }

    public function parse ($data) {
        $single = false;
        if (isset($data['id'])) {
            $data = [$data];
            $single = true;
        }

        foreach ($data as $k => $a) {
            if (isset($a['email']))
                $data[$k]['gravatar'] = "https://www.gravatar.com/avatar/" . md5($a['email']) . "?d=mm";

            if (isset($a['password'])) unset($data[$k]['password']);

            if (isset($a['profile_fields']) and gettype($a['profile_fields']) == 'string') {
                $data[$k]['profile_fields'] = unserialize($a['profile_fields']);
            }
        }

        return $single ? $data[0] : $data;
    }

    public function get_one ($where = [], $select = null) {
        $a = $this->get($where, $select);

        return ($a) ? $a[0] : false;
    }

    /**
     * get user data
     *
     * @param array $where
     * @param null  $select
     * @param bool  $limit
     * @param int   $offset
     * @param bool  $count_total
     *
     * @return bool|array
     */
    public function get (Array $where = [], $select = null, $limit = false, $offset = 0, $count_total = true) {
        $query = \DB::select_array($select)->from($this->usersTable);
        $query->where($where);
        if ($limit) {
            $query->limit($limit);
            if ($offset)
                $query->offset($offset);
        }
        $compile_query = $query->compile($this->db);
        if ($count_total)
            $compile_query = Utils::sqlCalcRowInsert($compile_query);

        $results = \DB::query($compile_query)
            ->execute($this->db)
            ->as_array();

        return count($results) ? $results : false;
    }

    /**
     * Set profile fields at once.
     *
     * @param      $user_id
     * @param      $profile_fields
     * @param bool $overwrite
     *
     * @return int
     */
    public function set_profile_fields ($user_id, $profile_fields, $overwrite = false) {
        if (!$overwrite) {
            $fields = $this->get(['id' => $user_id,], ['profile_fields',]);
            $fields = $this->parse($fields);
            $fields = $fields[0]['profile_fields'];
            $profile_fields = array_merge($fields, $profile_fields);
        }

        return $this->update_user(['id' => $user_id], [], $profile_fields);
    }

    public function set_property ($user_id, $set) {
        return $this->update_user(['id' => $user_id], $set);
    }

    /**
     * Set users password.
     *
     * @param array  $where
     * @param string $password
     *
     * @return int
     */
    public function set_password ($where, $password) {
        $hash = $this->hash_password($password);

        return $this->update_user($where, ['password' => $hash,]);
    }

    public function hash_password ($a) {
        return Fuel_Auth::instance()
            ->hash_password($a);
    }

    /**
     * Creates a user.
     *
     * @param      $username
     * @param      $email
     * @param      $password
     * @param      $group
     * @param      $properties
     * @param      $profile_fields
     *
     * @return int
     * @throws \Exception
     */
    public function create_user ($username = null, $email, $password, $group, $properties, $profile_fields) {
        $insert = [];

        if (is_null($username)) {
            $username = Utils::parseUsernameFromEmail($email, false);
            $username = strtolower($username);
            $username = str_replace('.', '', $username);
            $username = str_replace(' ', '', $username);
            while ($exists = $this->get(['username' => $username], ['id'])) {
                $username = Str::increment($username);
            }
        } else {
            $username = trim($username);
        }

        $email = trim($email);

        $validation = Validation::instance();
        $validation->add_field('email', 'Email', 'required|trim|valid_email');
        $validation_data = [
            'email' => $email,
        ];
        $success = $validation->run($validation_data);
        if (!$success) {
            throw new UserException('The entered email seems to be invalid');
        }

        $username_exists = $this->get(['username' => $username,]);
        if ($username_exists) throw new AppException("A user with username $username already exists");

        $email_exists = $this->get(['email' => $email,]);
        if ($email_exists) throw new UserException("The e-mail id $email is already taken.");

        $insert['username'] = $username;
        $insert['email'] = $email;
        $insert['group'] = $group;
        $insert['password'] = Fuel_Auth::instance()
            ->hash_password($password);

        if (isset($properties['account_active'])) $insert['account_active'] = $properties['account_active'];

        $insert['created_at'] = Utils::timeNow();
        $properties['account_active'] = isset($properties['account_active']) ? $properties['account_active'] : 0;
        $insert['profile_fields'] = serialize($profile_fields);

        return $this->insert($insert);
    }

    /**
     * Update a user.
     *
     * @param      $where
     * @param      $properties
     * @param      $attributes
     * @param null $parent_id
     *
     * @return int
     * @throws \Exception
     */
    public function update_user ($where, $properties = [], $attributes = [], $parent_id = null) {

        if (isset($properties['username'])) throw new UserException('Updating username is not allowed.');

        $validation = Validation::instance();
        $validation_properties = [];

        if (isset($properties['email'])) {
            $validation_properties['email'] = $properties['email'];
            $validation->add_field('email', 'Email', 'required|trim|valid_email');
        }

        if (count($validation_properties)) {
            $success = $validation->run($validation_properties);
            if (!$success) throw new UserException('Validation failed');
        }

        if (isset($properties['email'])) {
            $email_exists = $this->get(['email' => $properties['email']]);
            if ($email_exists and isset($where['id']) and $email_exists[0]['id'] != $where['id']) throw new UserException("The e-mail id {$properties['email']} is already registered with us.");
        }

        $properties['updated_at'] = Utils::timeNow();

        // merge attributes with the old attributes.
        $user = $this->get($where, ['profile_fields']);
        if (!$user) throw new UserException("The user does not exists.");

        $profile_fields = unserialize($user[0]['profile_fields']);
        $profile_fields = array_merge($profile_fields, $attributes);

        $properties['profile_fields'] = $profile_fields;

        return $this->update($where, $properties);
    }

    /**
     * @param array $where
     *
     * @return int|object
     */
    public function remove ($where) {
        return \DB::delete($this->usersTable)
            ->where($where)
            ->execute();
    }

    private function insert ($set) {
        if (!\Str::is_serialized($set['profile_fields'])) $set['profile_fields'] = serialize($set['profile_fields']);
        list($id) = \DB::insert($this->usersTable)
            ->set($set)
            ->execute($this->db);

        return $id;
    }

    /**
     * Update user table.
     *
     * @param $where
     * @param $fields
     *
     * @return int|object
     */
    private function update ($where, $fields) {
        if (isset($fields['profile_fields']) && !\Str::is_serialized($fields['profile_fields'])) $fields['profile_fields'] = serialize($fields['profile_fields']);

        return \DB::update($this->usersTable)
            ->set($fields)
            ->where($where)
            ->execute($this->db);
    }
}