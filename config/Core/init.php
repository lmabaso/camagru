<?php
define('ROOT_DIR', dirname(__FILE__));
include_once ROOT_DIR .'/../database.php';
session_start();

$GLOBALS['config'] = array(
	'mysql'	=> array(
		'host' => $dbServicename,
		'username' => $dbUsername,
		'password' => $dbPassword,
		'db' => $dbName
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expire' => '604800'
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

spl_autoload_register(function ($class) {
    require_once (ROOT_DIR .'/../../Model/Classes/' . $class . '.class.php');
});
require_once ROOT_DIR .'/../../Control/Funtions/Sanitize.php';