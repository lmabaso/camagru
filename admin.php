<!DOCTYPE html>
<?php
include_once 'header.php';
$dbServicename = "localhost";
$dbUsername = "root";
$dbPassword = "zxcvb12345";
$dbName = "register";
$conn = mysqli_connect($dbServicename, $dbUsername, $dbPassword, $dbName);
if ($_POST['submit'] === "OK")
{
	$username = mysqli_real_escape_string($conn, $_POST['user']);
	
	$sql = "DELETE FROM users WHERE user_name='$username'";
	mysqli_query($conn, $sql);
	$sql = "SELECT * FROM users WHERE user_name='$username'";
	$result = mysqli_query($conn, $sql);
	$resultCheck = mysqli_num_rows($result);
	if ($resultCheck > 0)
	{
		header("Location: admin.php?delete=success");
		exit();
	}
	else
	{
		header("Location: admin.php?delete=fail");
		exit();
	}
}
?>
<section class="main-container">
	<div class="main-wrapper">
		<h2>Admin Page</h2>
		<form  method="POST" action="admin.php?action=delete">
			<input name="user" type="text"/>
			<input class="del_btn" type="submit" name="submit" value="OK"  />
		</form>
	</div>
</section>
<?php
include_once 'footer.php';
?>