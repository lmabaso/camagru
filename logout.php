<?php

require_once 'config/Core/init.php';

$user = new User();
$user->logout();
Redirect::to('index.php');