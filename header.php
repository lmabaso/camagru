<?php

echo '<!DOCTYPE html>
	<html>
	<head>
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<header>
		<nav>
			<div class="main-wrapper">
				<ul>
					<li><a href="index.php">Home </a></li>
				</ul>
				<ul>
					<li><a href="game.php">Game </a></li>
				</ul>';
if (isset($_SESSION['u_name']))
{
	echo	'<ul>
			<li><a href="shop.php">Shop</a></li>
			</ul>
			<div class="nav-login">';
	if ($_SESSION['u_name'] == "admin")
		echo 	'<ul>
					<li><a href="admin.php">Admin</a></li>
				</ul>';
	echo	'<div class="active">Cart - Items : ';
	echo	count($_SESSION["shopping_cart"]);
	echo	'</div>';
	echo	'<div class="active">Total - R ';
	echo	$_SESSION['total'];
	echo	'</div>';
	echo	'<div class="active">Logged in as :  ';
	echo	$_SESSION["u_name"];
	echo	'</div>';
	echo    '<form action="resource/logout.php" method="POST">
			<button name="submit">Logout</button>
			</form>';
}
else
{

	echo '<div class="nav-login"><form action="resource/login.php" method="POST">
			<input type="text" name="username" placeholder="Username/e-mail">
			<input type="password" name="pwd" placeholder="password">
			<button name="submit">Login</button>
			</form>';
}
echo '<a href="signup.php">Sign up</a>
</div>
</div>
</nav>
</header>';
?>
