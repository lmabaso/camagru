<?php
$dbServicename = "localhost";
$dbUsername = "root";
$dbPassword = "zxcvb12345";
$dbName = "camagru";

//connect to mysql and create register/login database

$conn = mysqli_connect($dbServicename, $dbUsername, $dbPassword);
$sql = "CREATE DATABASE camagru";
if (mysqli_query($conn, $sql))
	echo "Database Camagru create success --- ";
else
{
	echo $conn->error . "--- ";
	mysqli_close($conn);
	return ;
}

mysqli_close($conn);

//create users table

$conn = mysqli_connect($dbServicename, $dbUsername, $dbPassword, $dbName);
$sql = "CREATE TABLE users (
	user_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
	user_name varchar(256) not null,
	user_username varchar(256) not null,
	user_salt varchar(256) not null,
	user_email varchar(256) not null,
	user_pwd varchar(256) not null
);";
if (mysqli_query($conn, $sql))
echo "Table create success --- ";
else
{
	echo $conn->error . " --- ";
	mysqli_close($conn);
	return ;
}

$conn = mysqli_connect($dbServicename, $dbUsername, $dbPassword, $dbName);
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

//create table for shop items and cart

// $dbName = "shop";
// $conn = mysqli_connect($dbServicename, $dbUsername, $dbPassword, $dbName);
// $sql = "CREATE TABLE items (
// 	sh_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
// 	sh_name varchar(256) not null,
// 	sh_image varchar(256) not null,
// 	sh_price float(11, 2) not null,
// 	sh_category varchar(256) not null
// );";
// if (mysqli_query($conn, $sql))
// 	echo "Table (cart) create success";
// else
// {
// 	echo "Table (cart) create failure" . $conn->error;
// 	mysqli_close($conn);
// 	return ;
// }
// mysqli_close($conn);

//add items to table

// $dbName = "shop";
// $conn = mysqli_connect($dbServicename, $dbUsername, $dbPassword, $dbName);
// $files = scandir('../images/monsters');
// foreach ($files as $v)
// {
// 	if ($v != ".." && $v != "." && $v != ".DS_Store")
// 	{
// 		$name = $v;
// 		$image = 'images/monsters/'.$v;
// 		$price = 5;
// 		$category = "monster";
// 		$sql = "INSERT INTO items (sh_name, sh_image, sh_price, sh_category) VALUES ('$name','$image' ,'$price', '$category');";
// 		if (mysqli_query($conn, $sql))
// 			echo $v." added to table\n";
// 		else
// 		{
// 			echo "Table create failure" . $conn->error;
// 			mysqli_close($conn);
// 			return ;
// 		}
// 	}
// }
// $files = scandir('../images/traps');
// foreach ($files as $v)
// {
// 	if ($v != ".." && $v != "." && $v != ".DS_Store")
// 	{
// 		$name = $v;
// 		$image = 'images/traps/'.$v;
// 		$price = 5;
// 		$category = "trap";
// 		$sql = "INSERT INTO items (sh_name, sh_image, sh_price, sh_category) VALUES ('$name','$image' ,'$price', '$category');";
// 		if (mysqli_query($conn, $sql))
// 			echo $v." added to table\n";
// 		else
// 		{
// 			echo "Table create failure" . $conn->error;
// 			mysqli_close($conn);
// 			return ;
// 		}
// 	}
// }
// $files = scandir('../images/pendulum');
// foreach ($files as $v)
// {
// 	if ($v != ".." && $v != "." && $v != ".DS_Store")
// 	{
// 		$name = $v;
// 		$image = 'images/pendulum/'.$v;
// 		$price = 5;
// 		$category = "monster/trap";
// 		$sql = "INSERT INTO items (sh_name, sh_image, sh_price, sh_category) VALUES ('$name','$image' ,'$price', '$category');";
// 		if (mysqli_query($conn, $sql))
// 			echo $v." added to table\n";
// 		else
// 		{
// 			echo "Table create failure" . $conn->error;
// 			mysqli_close($conn);
// 			return ;
// 		}
// 	}
// }
mysqli_close($conn);
?>
