<?php
namespace Craftpip\OAuth;

/**
 * Class Db
 * base db class for Craftpip\Oauth\Auth
 *
 * @package Craftpip\Oauth
 */
class Db extends \Auth\Auth_Login_Simpleauth {

    public $usersTable = 'users';
    public $providersTable = 'users_providers';
    public $user_id = 0;
    public $user = array();
    public $user_attr = array();

    /**
     * Get user that has a match, username, or email.
     *
     * @param $key
     * @return bool
     */
    public function getByUsernameEmail($key) {
        $data = \DB::select()->from($this->usersTable)
            ->where('username', $key)
            ->or_where('email', $key)
            ->execute();

        if (count($data) == 1)
            return $data[0];
        else
            return FALSE;
    }

    /**
     * Get user provider by provider USER ID
     */
    public function getUserByProviderUID($uid){
        $data = \DB::select()->from($this->providersTable)
            ->where('uid', (String)$uid)
            ->execute()->as_array();

        if(count($data) == 0)
            return false;

        $user_id = $data[0]['parent_id'];
        return $this->getUser($user_id);
    }

    /**
     * Get user that has a match, username, or email.
     *
     * @param $key
     * @return bool
     */
    public function getByEmail($key) {
        $data = \DB::select()->from($this->usersTable)
            ->where('username', $key)
            ->or_where('email', $key)
            ->execute();

        if (count($data) == 1)
            return $data[0];
        else
            return FALSE;
    }

    /**
     * Get user by id. If id is not provided, Current user data will be returned.
     *
     * @param null $user_id
     * @return bool
     */
    public function getUser($user_id = NULL) {
        if (is_null($user_id))
            return $this->user;

        $data = \DB::select()->from($this->usersTable)
            ->where('id', $user_id)
            ->execute();

        if (count($data) == 1)
            return $data[0];
        else
            return FALSE;
    }

    /**
     * Directly set current user password.
     * @param $string
     */
    public function setPassword($string) {
        $a = \DB::update($this->usersTable)->where('id', $this->user_id)
            ->set(array(
                'password' => $this->hash_password((string)$string)
            ))
            ->execute();
    }

    /**
     * Get Users linked providers.
     *
     * @param null $name -> which provider ?
     * @param null $key -> get a column from the provider table
     * @return bool
     */
    public function getProviders($name = NULL, $key = NULL) {
        $a = \DB::select()->from($this->providersTable)->where('parent_id', $this->user_id);
        if (!is_null($name)) {
            $name = $this->_parseProviderName($name);
            $a = $a->and_where('provider', $name);
        }
        $b = $a->execute()->as_array();
        if (is_null($key)) {
            return $b;
        } else {
            if (count($b))
                return $b[0][$key];
            else
                return FALSE;
        }
    }

    /**
     * Update a provider for selected user.
     * @param $name
     * @param $set
     * @return object
     */
    public function updateProvider($name, $set) {
        $name = $this->_parseProviderName($name);
        $a = \DB::update($this->providersTable)->where('parent_id', $this->user_id)
            ->and_where('provider', $name)
            ->set($set)->execute();

        return $a;
    }

    /**
     * Create a new provider for the selected user.
     * @param $name
     * @param $set
     * @param null $user_id
     * @return object
     */
    public function insertProvider($name, $set, $user_id = NULL) {
        if (is_null($user_id))
            $user_id = $this->user_id;

        $set['parent_id'] = $user_id;
        $name = $this->_parseProviderName($name);
        $set['provider'] = $name;
        $a = \DB::insert($this->providersTable)
            ->set($set)->execute();

        return $a;
    }

    /**
     * Delete a provider by its name
     *
     * @param $name
     */
    public function removeProvider($name) {
        $name = $this->_parseProviderName($name);
        $a = \DB::delete($this->providersTable)
            ->where('parent_id', $this->user_id)
            ->and_where('provider', $name)->execute();
    }

    /**
     * Parse provider name is right capitalization.
     * github -> GitHub,
     * bitbucket -> Bitbucket
     *
     * @param $name
     * @return string
     */
    public function _parseProviderName($name) {
        if (strtolower($name) == 'github')
            $name = 'GitHub';
        if (strtolower($name) == 'bitbucket')
            $name = 'Bitbucket';

        return $name;
    }

    protected function updateWrapper() {
        $users = \DB::select()->from($this->usersTable)->where('id', $this->user_id)->execute()->as_array();
        if (count($users)) {
            $this->user = $users[0];
            $this->user_attr = unserialize($this->user['profile_fields']);
        } else {

        }
    }

    protected function updateAttr() {
        $a = \DB::update($this->usersTable)->where('id', $this->user_id)
            ->set(array(
                'profile_fields' => serialize($this->user_attr)
            ))->execute();
    }

    public function removeUser($user_id) {
        try {
            $a = \DB::delete($this->usersTable)->where('id', $user_id);
            $b = \DB::delete($this->providersTable)->where('parent_id', $user_id);

            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

}