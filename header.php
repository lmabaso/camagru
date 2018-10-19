<?php
require_once 'Control/Core/init.php';

$user = new User();
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
						</ul>';
if ($user->isLoggedIn())
{
	echo '<div class="nav-login">';
	echo '<a href="profile.php">' .escape($user->data()->user_name) . '</a>';
	echo '<form action="logout.php" method="POST">
		 	<button name="submit">Logout</button>
		  </form>';
}
else
{
echo '<div class="nav-login">';
echo '<a href="login.php">Login</a>';
echo '<a href="signup.php">Sign up</a>';
}
echo '</div>
	</div>
</nav>
</header>';
?>
