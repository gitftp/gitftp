<?php
namespace Craftpip\OAuth;

/**
 * Class Auth
 *
 * @deprecated
 * @package Craftpip\OAuth
 */
class Auth extends Db {

    /**
     * user this class for a specific user, or the current logged in user.
     * Or nothing ?
     *
     * @param null $user_id
     */

    public function __construct($user_id = NULL) {
        $this->auth = \Auth::instance();
        if (is_null($user_id)) {
            if ($this->auth->check())
                list(, $this->user_id) = $this->auth->get_user_id();
        } else {
            $this->user_id = $user_id;
        }

        if ($this->user_id !== 0)
            $this->updateWrapper(); // updates user data in modal.
    }

    /**
     * Set current logged in user_id.
     */
    public function setId($user_id) {
        $this->user_id = $user_id;
        $this->updateWrapper();
    }

    /**
     * Get Attributes of a user,
     * @param null $key
     * @return bool
     */
    public function getAttr($key = NULL) {
        try {
            if (is_null($key))
                return $this->user_attr;
            else
                return (!empty($this->user_attr[$key])) ? $this->user_attr[$key] : FALSE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    /**
     * Set a new Attribute, update if exist, or create if doesnt exist.
     * @param $key
     * @param $value
     */
    public function setAttr($key, $value) {
        $this->user_attr[$key] = $value;
        $this->updateAttr();
    }

    /**
     * If the Attribute exists.
     * @param $key
     * @return bool
     */
    public function existAttr($key) {
        return (array_key_exists($key, $this->user_attr)) ? TRUE : FALSE;
    }

    /**
     * remove key from user's attributes. which are stored in Users profile_field property.
     *
     * @param $key
     * @return bool
     */
    public function removeAttr($key) {
        if ($this->existAttr($key)) {
            unset($this->user_attr[$key]);
            $this->updateAttr();
        } else {
            return FALSE;
        }
    }

    /**
     * Get property of THE USER. 'id, username, email, created_at, updated_at, etc'
     *
     * @param $name
     * @return bool
     */
    public function getProperty($name) {
        try {
            return $this->user[$name];
        } catch (Exception $e) {
            return FALSE;
        }
    }

    /**
     * Get Token in form of array('toekn', 'secret') of a provider.
     *
     * @param null $name
     * @return array|bool
     */
    public function getToken($name) {
        $a = \DB::select()->from($this->providersTable)->where('parent_id', $this->user_id);
        if (!is_null($name)) {
            $name = $this->_parseProviderName($name);
            $a = $a->and_where('provider', $name);
        }
        $b = $a->execute()->as_array();
        if (count($b))
            return unserialize($b[0]['access_token']);
        else
            return FALSE;
    }
}