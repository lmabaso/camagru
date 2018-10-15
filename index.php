<?php 
require_once 'Control/Core/init.php';

$user = DB::getInstance()->query('SELECT user_name FROM userz WHERE user_name= ?', array('alex'));

if (!$user->count())
    echo 'no user';
else
    echo 'OK';
?>