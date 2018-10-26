<?php
class DB {
    private static $_instance = null;
    private $_pdo;
    private $_query;
    private $_error = false;
    private $_results;
    private $_count = 0;

    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname='. Config::get('mysql/db') , Config::get('mysql/username'), Config::get('mysql/password'));
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die ($e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$_instance )) {
            self::$_instance = new DB();
        }
        return (self::$_instance);
    }

    public function query($sql, $params = array()) {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if ($this->_query->execute()) {
                if (strstr($sql, "SELECT"))
                    $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }
            else {
                $this->_error = true;
            }
        }
        return ($this);
    }

    private function action($action, $table, $where = array()) {
        if (count($where) === 3){
            $operators = array('=', '>', '<', '>=', '<=');
            $field      = $where[0];
            $operator   = $where[1];
            $value   = $where[2];
            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error()){
                    return ($this);
                }
            }
        }
        return (false); 
    }

    public function insert($table, $field = array()) {

        if (count($field)) {
            $keys = array_keys($field);
            $values = '';
            $x = 1;
            foreach ($field as $fields) {
                $values .= "?";
                if ($x < count($field))
                    $values .= ", ";
                $x++;
            }
            $sql = "INSERT INTO {$table} (`". implode('`,`', $keys) ."`) VALUES ({$values})";
            if (!$this->query($sql, $field)->error()) {
                return (true);
            }
        }
        return (false);
    }

    public function update($table, $id, $fields) { //double check error on multipule updates
        $set = '';
        $x = 1;
        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($x < count($fields))
            {
                $set .= ", ";
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE user_id = {$id}";
        if (!$this->query($sql, $fields)->error()) {
            return (true);
        }
        return (false);
    }

    public function count() {
        return ($this->_count);
    }

    public function results() {
        return ($this->_results);
    }

    public function first() {
        return ($this->results()[0]);
    }

    public function get($table, $where) {
        return ($this->action('SELECT *', $table, $where));
    }

    public function delete($table, $where) {
        return ($this->action('DELETE', $table, $where));
    }

    public function error() {
        return ($this->_error);
    }
}
