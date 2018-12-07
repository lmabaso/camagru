<?php
include_once 'header.php';

if (Input::exists())
{
	if (Token::check(Input::get('token')))
	{
		$validate = new Validate();
		$validation = $validate->check($_POST, array('username' => array('required' => true, 'invalid' => 'username'), 'pwd' => array('required' => true)));
		if ($validation->passed())
		{
			$user = new User();
            $login = $user->login(Input::get('username'), Input::get('pwd'));
			if ($login)
			{
				echo Session::flash('success', 'Your loggin was succesfully');
				Redirect::to('index.php');
			}
			else
			{
                echo Session::flash('fail', 'Your login was unsuccesfull');
			}
		}
		else
		{
			foreach ($validation->errors() as $error)
				echo $error . '</br>';
		}
	}
	if (Session::exists('success'))
	{
		echo Session::flash('success');
	}
	if (Session::exists('fail'))
	{
		echo Session::flash('fail');
	}
}
?>
<section class="main-container">
	<div class="main-wrapper">
		<h2>Login</h2>
		<form class="signup-form" action="" method="POST">
			<input type="text" name="username" placeholder="Username/e-mail" autocomplete="off">
			<input type="password" name="pwd" placeholder="password" autocomplete="off">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?> " >
			<a href="forgotpassword.php">Forgot password</a>
            <button type="submit" name="submit">Login</button>
		</form>
	</div>
</section>
<?php
include_once 'footer.php';
?>
