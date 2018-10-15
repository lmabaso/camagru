<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "zxcvb12345";
$dbName = "register";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
if (mysqli_connect_errno())
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
