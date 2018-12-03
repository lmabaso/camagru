<?php
include_once 'header.php';

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists())
{
    
    if (Input::get('submit'))
    {
        if ($user->data()->user_notification == 1)
        {  
            $user->update(array(
                'user_notification' => 0
            ));
        }
        else if ($user->data()->user_notification == 0)
        {
            $user->update(array(
                'user_notification' => 1
            ));
        }
        Redirect::to('profile.php');
    }
}
?>
<section class="main-container">
	<div class="main-wrapper">
        <h2>Profile</h2>
        
        <h3><?php echo escape($user->data()->user_username) ?></h3>
        <p>Name: <?php echo escape($user->data()->user_name) ?></p>
        <p>Email: <?php echo escape($user->data()->user_email) ?></p>
        <p><a href="updateusername.php">Update Username</a></p>
        <p><a href="updateemail.php">Update Email</a></p>
        <p><a href="changepassword.php">Change Password</a></p>
        <form action="" method="POST">
            <input type="submit" name="submit" value="<?php echo ($user->data()->user_notification == 1 ? "Don't get notifications" : "Get notificaations")  ?>"><br/>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?> " >
        </form>
    </div>

</section>
<?php
include_once 'footer.php';
?>
