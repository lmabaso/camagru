<?php
include_once 'header.php';

if (Input::exists())
{
	if (Token::check(Input::get('token')))
	{
		$validate = new Validate();
		$validation = $validate->check($_POST, array('email' => array('required' => true, 'valid_email' => 'email')));
		if ($validation->passed())
		{
            $stuff = DB::getInstance();
            $salt = Hash::salt(32);
            $str = "qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM";
			$str = str_shuffle($str);
            $str = substr($str, 0, 10);
            // $stuff->update('users', Input::get('email'), array('user_pwd' => Hash::make($str), 'user_salt' => $salt));
            $stuff->query("UPDATE users SET user_pwd = ?, user_salt = ? WHERE user_email = ?", array('user_pwd' => Hash::make($str), 'user_salt' => $salt, 'user_email' => Input::get('email')));
            $message = 
            "
            HI ". Input::get('name') ."
            Password Reset
            
            Your new password is : ". $str;

			mail(Input::get('email'), "Camagru email confirmation", $message, "Camagru");
            
            echo Session::flash('success', 'Please open your email');
            Redirect::to('index.php');
		}
		else
		{
			foreach ($validation->errors() as $error)
				echo $error . '</br>';
		}
	}
}
?>
<section class="main-container">
	<div class="main-wrapper">
		<h2>Forgot password</h2>
		<form class="signup-form" action="" method="POST">
            <input type="text" name="email" placeholder="e-mail" autocomplete="off">
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?> " >
            <button type="submit" name="submit">change</button>
		</form>
	</div>
</section>
<?php
include_once 'footer.php';
?>
