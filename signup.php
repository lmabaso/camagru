<?php
include_once 'header.php';
?>
<section class="main-container">
	<div class="main-wrapper">
		<h2>Signup</h2>
		<form class="signup-form" action="resource/signup.php" method="POST">
			<input type="text" name="username" placeholder="username">
			<input type="text" name="email" placeholder="e-mail">
			<input type="password" name="pwd" placeholder="password">
			<button type="submit" name="submit">Sign up</button>
		</form>
	</div>
</section>
<?php
include_once 'footer.php';
?>
