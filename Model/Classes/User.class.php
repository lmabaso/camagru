<?php
class User {
    private $_db;
    private $_data;
    private $_sessionName;
    private $_isLoggedIn;

    public function __construct($user = null) {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    $this->_isLoggedIn = false;
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating new account');
        }
    }

    public function update($fields = array(), $id = null) {
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->user_id;
        }

        if (!$this->_db->update('users', $id, $fields)) {
            throw new Exception('There was a problem updating profile.');
        }
    }

    public function find($user = null) {
        if ($user) {
            $field = (is_numeric($user)) ? 'user_id' : 'user_username';
            $data = $this->_db->query('SELECT * FROM users WHERE '. $field . '= ? OR user_email = ?', array($user, $user));
            if ($data->count()) {
                $this->_data = $data->first();    
                return (true);
            }
        }
        return (false);
    }

    public function login($username = null, $password = null) {
        $user = $this->find($username);
        if ($user) {
            if ($this->data()->user_isvalidated == 1 && $this->data()->user_pwd === Hash::make($password, $this->data()->user_salt)) {
                Session::put($this->_sessionName, $this->data()->user_id);
                return (true);
            }
        }
        return (false);
    }

    public function logout() {
        Session::delete($this->_sessionName);
    }

    public function data() {
          return ($this->_data);
    }

    public function isLoggedIn() {
        return ($this->_isLoggedIn);
    }
}
