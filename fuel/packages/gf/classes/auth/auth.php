<?php

namespace Gf\Auth;

use Fuel\Core\Session;
use Gf\Exception;
use Gf\Auth\SessionManager;

/**
 * Class Auth
 * A new version of the Auth class
 *
 * @package Gf
 */
class Auth {
    /**
     * Uses multiple instances for respective users.
     *
     * @var array
     */
    public static $instances = [];
    public $user_instance;
    public $user;
    public $profile_fields;
    public $user_id;
    protected $auth_instance;

    /**
     * IF user's id is not passed, the current logged-in user instance will be created.
     * what if you want to create a instance without a user? set $user_id as 0
     *
     * @param int|string $user_id
     *
     * @return Auth
     */
    public static function instance ($user_id = 'current_user') {
        $user_id = is_null($user_id) ? 'current_user' : $user_id;
        if (!isset(static::$instances[$user_id])) {
            static::$instances[$user_id] = new static($user_id);
        }

        return static::$instances[$user_id];
    }

    protected function __construct ($user_id) {
        $this->auth_instance = \Auth\Auth::instance();
        $this->user_instance = Users::instance();
        $this->user_id = ($user_id == 'current_user') ? $this->logged_in_user_id() : $user_id;

        if (!$this->user_id) {
            $this->user = false;
            $this->profile_fields = false;
            $this->user_id = false;
        } else {
            $user = $this->user_instance->get([
                'id' => $this->user_id,
            ]);
            $user = $this->user_instance->parse($user);
            $this->user = ($user) ? $user[0] : null;
            if ($this->user)
                $this->profile_fields = $this->user['profile_fields'];
        }
    }

    /**
     * Tells if the current set user is of group
     *
     * @param $group_id
     *
     * @return bool
     */
    public function member ($group_id) {
        return ($this->user['group'] == $group_id);
    }

    public function get_one ($where = [], $select = null) {
        $a = $this->get($where, $select);

        return (count($a)) ? $a[0] : false;
    }

    /**
     * Alias for
     * Users::instance()->get
     *
     * @param array $where
     * @param null  $select
     * @param bool  $limit
     * @param int   $offset
     *
     * @return bool|array
     */
    public function get ($where = [], $select = null, $limit = false, $offset = 0) {
        return $this->user_instance->get($where, $select, $limit, $offset);
    }

    public function get_session_id () {
        return Session::key('session_id');
    }

    /**
     * Helper method.
     * Get a user by its ID, if id is not given, returns the USER for which the instance was created.
     *
     * @param null $id
     *
     * @return null
     */
    public function get_user ($id = null) {
        if (is_null($id)) {
            return $this->user;
        } else {
            list($user) = $this->user_instance->get([
                'id' => $id,
            ]);

            return $user;
        }
    }

    /**
     * Returns the current logged in user id.!
     * NOT THE ONE THAT IS PASSED TO THE INSTANCE.
     * to get the user id passed to the instance @see $this->user_id
     * If this function is called via external API. and if the user token is available.
     * That user's id will be returned.
     *
     * @return mixed
     */
    public function logged_in_user_id () {
        $user_id = null;

//        if (is_api) {
//            $get_token = \Input::get('token', false);
//            $post_token = \Input::json('token', false);
//            if (!$get_token and !$post_token)
//                return $user_id;
//
//            $token = $get_token;
//            if ($post_token)
//                $token = $post_token;
//
//            $session = SessionManager::instance()
//                                     ->get_one([
//                                         'session_id' => $token,
//                                         'active'     => 1,
//                                     ]);
//            if ($session) {
//                $user_id = $session['user_id'];
//            }
//        }
//        else {
        $user_id = $this->auth_instance->get('id');

//        }

        return $user_id;
    }

    /**
     * Set profile attributes to the current set user.
     *
     * @param $attributes
     *
     * @return bool|int
     */
    public function set_profile_fields ($attributes) {
        if (!$this->user_id)
            return false;
        $this->profile_fields = array_merge($this->profile_fields, $attributes);

        return $this->user_instance->set_profile_fields($this->user_id, $this->profile_fields, true);
    }

    /**
     * get profile attribute value for a give attribute for the set user.
     *
     * @param      $attribute
     * @param bool $default
     *
     * @return bool
     */
    public function get_profile_fields ($attribute, $default = false) {
        return (isset($this->profile_fields[$attribute])) ? $this->profile_fields[$attribute] : $default;
    }

    /**
     * Sets property for a user, which is "column" in the database.
     *
     * @param $set
     *
     * @return bool|int
     */
    public function set_property ($set) {
        if (!$this->user_id)
            return false;
        $this->user = array_merge($this->user, $set);

        return $this->user_instance->set_property($this->user_id, $set);
    }

    /**
     * Get property value of the current logged in user.
     *
     * @param $property_name
     *
     * @return bool
     * @throws \Exception
     */
    public function get_property ($property_name) {
        if (!$this->user_id)
            throw new Exception\AppException('User id was not set');

        return (isset($this->user[$property_name])) ? $this->user[$property_name] : false;
    }

    /**
     * Set password for the current set user.
     *
     * @param $password
     *
     * @throws Exception\UserException
     */
    public function set_password ($password) {
        if (!$this->user_id)
            throw new Exception\UserException('User id was not set');

        $this->user_instance->set_password([
            'id' => $this->user_id,
        ], $password);
    }

    /**
     * Validates if the username,mobile,email are matched by the provided password.
     * returns the user if its validated.
     *
     * @param $username_email
     * @param $password
     *
     * @return bool
     */
    public function validate ($username_email, $password) {
        $user_table = $this->user_instance->usersTable;
        $pass_hash = $this->user_instance->hash_password($password);

        $user = \DB::query("
            select *
            from $user_table as users
            where 
            (users.username = '$username_email'
            or users.email = '$username_email')
            and users.password = '$pass_hash'
        ")
            ->execute($this->user_instance->db)
            ->as_array();

        return count($user) ? $user[0] : false;
    }

    /**
     * on successful login returns array [user_id, user, session_id]
     *
     * @param $username_mobile_email
     * @param $password
     *
     * @return array
     * @throws \Exception
     */
    public function login ($username_mobile_email, $password) {
        if ($user = $this->validate($username_mobile_email, $password)) {
//            if (is_api) {
//                if ($user['account_active'] == 0)
//                    throw new Exception\UserException('Your account is not active. please contact support for more information.');
//                $session_key = \Str::random('unique');
//                Users::instance()
//                    ->update_user([
//                        'id' => $user['id'],
//                    ], [
//                        'last_login' => \Utils::timeNow(),
//                    ]);
//
//                return [
//                    $user['id'],
//                    $this->get_one([
//                        'id' => $user['id'],
//                    ]),
//                    $session_key,
//                ];
//            } else {
//            if ($user['account_active'] == 0)
//                throw new Exception\UserException('Your account is not active. please contact the site administrator for more information.');

            $this->auth_instance->login($user['username'], $password);

            return [
                $user['id'],
                $this->get_one([
                    'id' => $user['id'],
                ]),
                \Session::key(),
            ];
//            }
        } else {
            throw new Exception\UserException('The mobile/e-mail password did not match, please try again.');
        }
    }

    /**
     * on successful login returns array [user_id, user, session_id]
     *
     * @param null $user_id
     *
     * @return array
     * @throws \Exception
     */
    public function force_login ($user_id = null) {
        if (is_null($user_id))
            $user_id = $this->user_id;

        if (!$user_id)
            throw new Exception\AppException('No user to login!');

//        if (is_api) {
//            $session_key = \Str::random('unique');
//
//            Users::instance()
//                ->update_user([
//                    'id' => $user_id,
//                ], [
//                    'last_login' => \Utils::timeNow(),
//                ]);
//
//            return [
//                $user_id,
//                $this->get_one([
//                    'id' => $user_id,
//                ]),
//                $session_key,
//            ];
//        } else {
        $this->auth_instance->force_login($user_id);

        return [
            $user_id,
            $this->get_one([
                'id' => $user_id,
            ]),
            \Session::key(),
        ];
//        }
    }

    /**
     * Logout the current logged in user
     * This has no effect on this $user_id passed to this instance. this function will logout only the current user.
     * If you want to logout a specific user @see SessionManager
     *
     * @param null $session_id
     *
     * @return bool
     * @throws \Exception
     */
    public function logout ($session_id = null) {

//        if (is_api) {
//            if (is_null($session_id)) {
//                $session_id = \Input::get('token', false);
//                $post_token = \Input::json('token', false);
//                if ($post_token)
//                    $session_id = $post_token;
//
//                if (!$session_id)
//                    throw new Exception\AppException('Session id is not provided.');
//            }
//            SessionManager::instance()
//                ->discard_session($session_id);
//        } else {
        \Auth::instance()
            ->logout();

        \Gf\Auth\SessionManager::instance()
            ->discard_session();

//        }

        return true;
    }
}