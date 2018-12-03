<?php

include_once 'database.php';
require_once 'Core/init.php';

try 
{
	$_db = new PDO("mysql:host=". Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/password'));
	$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE ". Config::get('mysql/db');
	$_db->exec($sql);
	echo "Database Camagru create success --- ";
}
catch (PDOException $e)
{
	if ($e->getMessage() == "SQLSTATE[HY000]: General error: 1007 Can't create database 'camagru'; database exists")
	{
		$sql = "DROP DATABASE ". Config::get('mysql/db');
		$_db->exec($sql);
		echo "Database Camagru drop success --- ";
		try
		{
			$sql = "CREATE DATABASE ". Config::get('mysql/db');
			$_db->exec($sql);
			echo "Database Camagru create success --- ";
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	else
	{
		echo $e->getMessage();
	}
}

$_db = null;

try
{
	$_db = DB::getInstance();
	$sql = "CREATE TABLE users (
		user_id int(11)  not null AUTO_INCREMENT PRIMARY KEY,
		user_name varchar(256) null,
		user_username varchar(256) null,
		user_salt varchar(256) null,
		user_email varchar(256) null,
		user_pwd varchar(256) null,
		token varchar(256) null,
		user_isvalidated boolean not null DEFAULT '0',
		user_notification boolean not null DEFAULT '1'
		);";
	$_db->query($sql, array());
	echo "Table users create success --- ";
}
catch (PDOException $e)
{
	echo $e->getMessage();
	$_db = null;
}

try
{
	$_db = DB::getInstance();
	$sql = "CREATE TABLE pictures (
		id int(11) not null AUTO_INCREMENT PRIMARY KEY,
		user_id int(11) not null,
		pic_dir varchar(256)
	);";
	$_db->query($sql, array());
	echo "Table pictures create success --- ";
}
catch (PDOException $e)
{
	echo $e->getMessage();
	$_db = null;
}

try
{
	$_db = DB::getInstance();
	$sql = "CREATE TABLE likes (
		id int(11) not null AUTO_INCREMENT PRIMARY KEY,
		pic_id int(11) not null,
		user_id int(11) not null
	);";
	$_db->query($sql, array());
	echo "Table likes create success --- ";
}
catch (PDOException $e)
{
	echo $e->getMessage();
	$_db = null;
}

try
{
	$_db = DB::getInstance();
	$sql = "CREATE TABLE comments (
		id int(11) not null AUTO_INCREMENT PRIMARY KEY,
		pic_id int(11) not null,
		user_id int(11) not null,
		comment text not null
	);";
	$_db->query($sql, array());
	echo "Table comments create success --- ";
}

catch (PDOException $e)
{
	echo $e->getMessage();
	$_db = null;
}

// $sql = "CREATE TABLE user_sessions (
// 	user_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
// 	user_user_id varchar(256) not null,
// 	user_hash varchar(256) not null
// );";
// if (mysqli_query($conn, $sql))
// echo "Table create success --- ";
// else
// {
// 	echo $conn->error . " --- ";
// 	mysqli_close($conn);
// 	return ;
// }
// mysqli_close($conn);


?>
