 <?php
 class Validate {
     private $_passed = false;
     private $_error = array();
     private $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array()) {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                $value = trim($source[$item]);
                $item = escape($item);
                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if (!empty($value)) {
                    if ($rule === 'min')
                    {
                        if (strlen($value) < $rule_value) {
                            $this->addError("{$item} must be a minimum of {$rule_value} charectors");
                        }
                    }
                    else if ($rule === 'max')
                    {
                        if (strlen($value) > $rule_value) {
                            $this->addError("{$item} must be a maximum of {$rule_value} charectors");
                        }
                    }
                    else if ($rule === 'matches')
                    {
                        if ($value != $source[$rule_value]) {
                            $this->addError("{$rule_value} must match {$item}");
                        }
                    }
                    else if ($rule === 'unique')
                    { 
                        $check = $this->_db->get($rule_value, array("user_" . $item, '=', $value));
                        if ($check->count()) {
                            $this->addError("{$item} already exists");
                        }
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return ($this);
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return ($this->_errors);
    }

    public function passed() {
        return ($this->_passed);
    }
 }