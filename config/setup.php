<?php

include_once 'database.php';
//connect to mysql and create register/login database

$conn = mysqli_connect($dbServicename, $dbUsername, $dbPassword);



$sql = "CREATE DATABASE camagru";
if (mysqli_query($conn, $sql))
	echo "Database Camagru create success --- ";
else
{
	if ($conn->error === "Can't create database 'camagru'; database exists") {
		$sql = "DROP DATABASE `camagru`;";
		if (mysqli_query($conn, $sql))
			echo "Database Camagru drop success --- ";
		else
		{
			echo $conn->error . "--- ";
			mysqli_close($conn);
			return ;
		}
		$sql = "CREATE DATABASE camagru";
		if (mysqli_query($conn, $sql))
			echo "Database Camagru create success --- ";
	}
	else {
		echo $conn->error . "--- ";
		mysqli_close($conn);
		return ;
	}
	
}

mysqli_close($conn);

//create users table

$conn = mysqli_connect($dbServicename, $dbUsername, $dbPassword, $dbName);
$sql = "CREATE TABLE users (
	user_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
	user_name varchar(256) null,
	user_username varchar(256) null,
	user_salt varchar(256) null,
	user_email varchar(256) null,
	user_pwd varchar(256) null,
	token varchar(256) null,
	user_isvalidated boolean not null DEFAULT '0'
);";
if (mysqli_query($conn, $sql))
echo "Table create success --- ";
else
{
	echo $conn->error . " --- ";
	mysqli_close($conn);
	return ;
}

$sql = "CREATE TABLE pictures (
	id int(11) not null AUTO_INCREMENT PRIMARY KEY,
	user_id int(11) not null,
	pic_dir varchar(256)
);";

if (mysqli_query($conn, $sql))
echo "Table create success --- ";
else
{
	echo $conn->error . " --- ";
	mysqli_close($conn);
	return ;
}

$sql = "CREATE TABLE likes (
	id int(11) not null AUTO_INCREMENT PRIMARY KEY,
	pic_id int(11) not null,
	user_id int(11) not null
);";

if (mysqli_query($conn, $sql))
echo "Table create success --- ";
else
{
	echo $conn->error . " --- ";
	mysqli_close($conn);
	return ;
}

$sql = "CREATE TABLE comments (
	id int(11) not null AUTO_INCREMENT PRIMARY KEY,
	pic_id int(11) not null,
	user_id int(11) not null,
	comment text not null
);";

if (mysqli_query($conn, $sql))
echo "Table create success --- ";
else
{
	echo $conn->error . " --- ";
	mysqli_close($conn);
	return ;
}


$sql = "CREATE TABLE user_sessions (
	user_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
	user_user_id varchar(256) not null,
	user_hash varchar(256) not null
);";
if (mysqli_query($conn, $sql))
echo "Table create success --- ";
else
{
	echo $conn->error . " --- ";
	mysqli_close($conn);
	return ;
}
mysqli_close($conn);

//create admin profile;
$conn = mysqli_connect($dbServicename, $dbUsername, $dbPassword, $dbName);
$hashedPwd = password_hash("admin123", PASSWORD_DEFAULT);
$sql = "INSERT INTO users (user_name, user_email, user_pwd) VALUES ('admin','admin' ,'$hashedPwd');";
if (mysqli_query($conn, $sql))
	echo "ADMIN created";
mysqli_close($conn);


?>
