<?php

class Userwrapper extends \Auth\Auth_Login_Simpleauth {

    public $user_id = 0;
    private $table = 'users';
    public $user;
    public $user_attr;

    public function __construct($user_id = NULL) {
        $this->auth = \Auth::instance();
        if (is_null($user_id)) {
            if ($this->auth->check())
                list(, $this->user_id) = $this->auth->get_user_id();
        } else {
            $this->user_id = $user_id;
        }

        if ($this->user_id !== 0)
            $this->updateWrapper();
    }

    private function updateWrapper() {
        $users = DB::select()->from($this->table)->where('id', $this->user_id)->execute()->as_array();
        if (count($users)) {
            $this->user = $users[0];
            $this->user_attr = unserialize($this->user['profile_fields']);
        } else {

        }

    }

    public function setPassword($string) {
        $a = DB::update($this->table)->where('id', $this->user_id)
            ->set(array(
                'password' => $this->hash_password((string)$string)
            ))
            ->execute();
    }

    private function updateAttr() {
        $a = DB::update($this->table)->where('id', $this->user_id)
            ->set(array(
                'profile_fields' => serialize($this->user_attr)
            ))->execute();
    }

    public function DBgetByUsernameEmail($key) {
        $data = DB::select()->from($this->table)
            ->where('username', $key)
            ->or_where('email', $key)
            ->execute();

        if (count($data) == 1)
            return $data[0];
        else
            return FALSE;
    }

    public function getUser() {
        return $this->user;
    }

    public function getAttr($key = NULL) {
        try {
            if (is_null($key))
                return $this->user_attr;
            else
                return $this->user_attr[$key];
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public function setAttr($key, $value) {
        $this->user_attr[$key] = $value;
        $this->updateAttr();
    }

    public function existAttr($key) {
        return (array_key_exists($key, $this->user_attr)) ? TRUE : FALSE;
    }

    public function removeAttr($key) {
        if ($this->existAttr($key)) {
            unset($this->user_attr[$key]);
            $this->updateAttr();
        } else {
            return FALSE;
        }
    }

    public function getProperty($name) {
        try {
            return $this->user[$name];
        } catch (Exception $e) {
            return FALSE;
        }
    }

}