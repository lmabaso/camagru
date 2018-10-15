<?php

if (isset($_POST['submit']))
{
	include_once 'database.php';

	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['pwd']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	
	if (empty($username) || empty($password) || empty($email))
	{
		header("Location: ../signup.php?signup=empty");
		exit();
	}
	else
	{
		if (!preg_match("/^[a-zA-Z]*$/", $username))
		{
			header("Location: ../signup.php?signup=invalid");
			exit();
		}
		else {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				header("Location: ../signup.php?signup=email");
				exit();
			}
			else
			{
				$sql = "SELECT * FROM users WHERE user_name='$username'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				if ($resultCheck > 0)
				{
					header("Location: ../signup.php?signup=usertaken");
					exit();
				}
				else
				{
					$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
					$sql = "INSERT INTO users (user_name, user_email, user_pwd) VALUES ('$username','$email' ,'$hashedPwd');";
					mysqli_query($conn, $sql);
					header("Location: ../signup.php?signup=success");
					exit();
				}
			}
		}
	}
}
else
{
	header("Location: ../signup.php");
	exit();
}