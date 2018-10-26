<?php

class Controller {
    public static function createView($view) {
        require_once 'Control/Core/init.php';
        require_once "Views/$view.php";
    }
}
?>