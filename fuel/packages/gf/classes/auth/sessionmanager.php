<?php

namespace Gf\Auth;

//use Crossjoin\Browscap\Browscap;
use Fuel\Core\Session;
use Gf\Exception\AppException;
use Gf\Platform;
use Gf\Utils;

/**
 * Makes a record of the current users login!
 * When using multiple logins and cookie based sessions, we lose control of the users login. because the session is
 * stored in the users browser. Using database sessions help to solve that problem by tracking each session with the
 * userid. This class fills in the gap between sessions and login history.
 *
 * @package Nb
 */
class SessionManager {
    public $sessionTable = 'sessions';
    public $historyTable = 'user_login_history';
    public $db = 'default';
    public static $instance;

    /**
     * @return SessionManager
     */
    public static function instance () {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct () {

    }

    /**
     * Creates snapshot for the current user's session and login details.
     * $session that is passed into as the first argument should be the returned array of LOGIN
     * for medium and medium_os
     * The user will be shown, you logged in from medium on medium_os
     *
     * @param      $session
     * @param null $medium    -> Browser
     * @param null $medium_os -> Operating system
     * @param null $platform  -> the platform used.
     *
     * @return int
     * @throws \Exception
     */
    public function create_snapshot (Array $session, $medium = null, $medium_os = null, $platform = null) {
        list($user_id, $user, $session_id) = $session;

        $platform = Platform::$web;
        if (Utils::phpVersion() >= 5.6) {
            $medium_os = 'Unknown';
            $medium = 'Unknown';
        } else {
            $medium_os = 'Unknown';
            $medium = 'Unknown';
        }

        $exists = $this->get([
            'user_id'    => $user_id,
            'session_id' => $session_id,
        ]);
        if ($exists)
            return 0;

        return $this->insert([
            'user_id'    => $user_id,
            'session_id' => $session_id,
            'medium'     => $medium,
            'medium_os'  => $medium_os,
            'platform'   => $platform,
            'ip_address' => \Input::real_ip(),
            'login_at'   => Utils::timeNow(),
            'active'     => 1,
        ]);
    }

    public function get ($where, $select = null) {
        $data = \DB::select_array($select)
            ->from($this->historyTable)
            ->where($where)
            ->execute($this->db)
            ->as_array();

        return (count($data)) ? $data : false;
    }

    public function get_one ($where, $select = null) {
        $data = $this->get($where, $select);

        return count($data) ? $data[0] : false;
    }

    public function logout_from_everywhere ($user_id) {
        $active_sessions = $this->get([
            'user_id' => $user_id,
            'active'  => 1,
        ]);
        if (!$active_sessions)
            return true;

        return $this->update([
            'user_id' => $user_id,
            'active'  => 1,
        ], [
            'active' => 0,
        ]);
    }

    /**
     * Sets the session as inactive. and removes the session.
     * thus results in a logout.
     * IMPORTANT:   This function should be called after \Nb\Auth\Auth::logout is called.     *
     * NOTE:        session is already removed When Fuel's Auth::logout is called.
     *              This function sets the session has inactive.
     *              but also removes the session if it exists.
     *
     * @param      $session_id
     * @param null $user_id
     *
     * @return object
     * @throws \Exception
     */
    public function discard_session ($session_id = null, $user_id = null) {
        $session_id = Session::key();

        $where = [
            'session_id' => $session_id,
        ];
        if (!is_null($user_id))
            $where['user_id'] = $user_id;

        return $this->update($where, [
            'active' => false,
        ]);
    }

    private function remove ($where) {
        return \DB::delete($this->historyTable)
            ->where($where)
            ->execute($this->db);
    }

    private function insert ($set) {
        list($id) = \DB::insert($this->historyTable)
            ->set($set)
            ->execute($this->db);

        return $id;
    }

    private function update ($where, $fields) {
        return \DB::update($this->historyTable)
            ->set($fields)
            ->where($where)
            ->execute($this->db);
    }
}