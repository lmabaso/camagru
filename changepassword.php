<?php
include_once 'header.php';

if (!$user->isLoggedIn())
{
    Redirect::to('index.php');
}
if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
            'old_pwd' => array('required' => true),
            'new_pwd' => array(
                'required' => true,
                'min' => 6
            ),
            'pwd_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'new_pwd'
            )
		));
        if ($validation->passed())
        {
            try
            {
                if ($user->data()->user_pwd === Hash::make(Input::get('old_pwd'), $user->data()->user_salt))
                {
                    $salt = Hash::salt(32);
                    $user->update(array(
                        'user_pwd' => Hash::make(Input::get('new_pwd'), $salt),
                        'user_salt' => $salt
                    ));
                    Session::flash('success', 'You have successfully updated your password.');
                }
                else
                {
                    Session::flash('fail', 'You have unsuccessfully updated your password.');
                }
                Redirect::to('index.php');
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }
			Redirect::to('index.php');
        }
        else
        {
            foreach ($validation->errors() as $error)
            {
				echo $error . '</br>';
			}
		}
	}
}
?>
<section class="main-container">
	<div class="main-wrapper">
        <h2>Change Password</p>
        <form class="signup-form" action="" method="POST">
            <input type="password" name="old_pwd" placeholder="current password" autocomplete="off">
            <input type="password" name="new_pwd" placeholder="new password" autocomplete="off">
			<input type="password" name="pwd_again" placeholder="new password again" autocomplete="off">
            <!-- <input type="password" name="pwd" placeholder="password" autocomplete="off"> -->
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?> " >
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</section>
<?php
include_once 'footer.php';
?>
