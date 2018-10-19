<?php
include_once 'header.php';

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

?>
<section class="main-container">
	<div class="main-wrapper">
        <h2>Profile</p>
        
        <h3><?php echo escape($user->data()->user_username) ?></h3>
        <p>Name: <?php echo escape($user->data()->user_name) ?></p>
        <p>Email: <?php echo escape($user->data()->user_email) ?></p>
        <p><a href="updateinfo.php">Update Profile</a></p>
        <p><a href="changepassword.php">Change Password</a></p>
    </div>

</section>
<?php
include_once 'footer.php';
?>
