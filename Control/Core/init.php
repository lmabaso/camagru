<?php
session_start();

$GLOBALS['config'] = array(
	'mysql'	=> array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'zxcvb12345',
		'db' => 'camagru'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expire' => '604800'
	),
	'session' => array(
		'session_name' => 'user'
	)
);

spl_autoload_register(function ($class) {
    require_once ('Model/Classes/' . $class . '.class.php');
});

require_once 'Control/Funtions/Sanitize.php';