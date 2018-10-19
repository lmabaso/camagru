<?php
echo getcwd();
require_once 'Control/Core/init.php';

$user = new User();
$user->logout();
Redirect::to('index.php');