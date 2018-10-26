<?php

class Photo {
    private $_db;
    private $_data;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function upload($fields = array()) {
        if (!$this->_db->insert('pictures', $fields)) {
            throw new Exception('There was a problem creating new account');
        }
    }

    public function find($user = null) {
        if ($user) {
            $field = (is_numeric($user)) ? 'user_id' : 'user_username';
            $data = $this->_db->get('pictures', array($field, '=', $user));
            if ($data->count()) {
                $this->_data = $data;    
                return (true);
            }
        }
        return (false);
    }

    public function data() {
        return ($this->_data);
    }
}
