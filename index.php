<?php 

require_once 'Routes.php';
require_once 'Control/Core/init.php';

function __autoload($class) {
    if (file_exists('Model/Classes/' . $class . '.class.php')) {
        require_once 'Model/Classes/' . $class . '.class.php';
    } else if (file_exists('Control/Classes/' . $class . '.class.php')) {
        require_once 'Control/Classes/' . $class . '.class.php';
    }
}
?>
