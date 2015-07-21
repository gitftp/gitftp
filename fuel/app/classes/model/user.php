<?php
// not used.
// todo : delete
class Model_User extends Model {
    private $table = 'users';
    public $user_id;
    private $username;
    private $password;

    public function __construct($user_id = NULL) {
        if (!is_null($user_id)) {
            $this->user_id = $user_id;
        } else {
            list(,$user_id) = Auth::get_user_id();
            $this->user_id = $user_id;
        }
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function login($username, $password) {
        if (Auth::login($username, $password)) {
            return TRUE;
        } else {
            throw new Exception('Username or password do not match');
        }
    }

    public function force_login($user_id) {
        if (Auth::force_login($user_id))
            return TRUE;
        else
            return FALSE;
    }

    public function register($username, $password, $email, $group = 1, $properties = array()) {
        $defaultProperties = array(
            'repo_limit' => 2,
            'verified'   => 0,
        );

        Auth::create_user($username, $password, $email, $group, $properties);
    }


    public function update($values, $username = NULL) {
        Auth::update($values, $username);
    }

    public function getProperty($name = NULL, $default = NULL) {
        $a = Auth::get();
        print_r($a);
    }

    public function setProperty() {
        // todo : we are here
    }

    public function check(){
        return \Auth::instance()->check();
    }
}

