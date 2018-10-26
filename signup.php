<?php
include_once 'header.php';

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 256,
				'unique' => 'users'
			),
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 256
			),
			'email' => array(
				'required' => true,
				'min' => 6,
				'max' => 256,
				'unique' => 'users',
				'valid_email' => 'email'
			),
			'pwd' => array(
				'required' => true,
				'min' => 6
			),
			'pwd_again' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'pwd'
			),
		));
		if ($validation->passed()) {
			$user = new User();
			$salt = Hash::salt(32);
			$str = "qwertyuiopasdfghjklzxcvbnm1234567890";
			$str = str_shuffle($str);
			$str = substr($str, 0, 10);
			try {
				$user->create(array(
					'user_username' => Input::get('username'),
					'user_name' => Input::get('name'),
					'user_email' => input::get('email'),
					'user_pwd' => Hash::make(Input::get('pwd')),
					'user_salt' => $salt,
					'token' => $str
				));
			} catch (Exception $e){
				die ($e->getMessage());
			}
			$message = 
			"
			Confirm Your Email

			Click on the link below to verify your account
			http:/localhost:8080/camagru/verify.php?
			";

			mail(Input::get('email'), "Camagru email confirmation");

			echo Session::flash('success', 'Please verify you email address.');
			Redirect::to('index.php');
		} else {
			foreach ($validation->errors() as $error) {
				echo $error . '</br>';
			}
		}
	}
}
?>
<section class="main-container">
	<div class="main-wrapper">
		<h2>Signup</h2>
		<form class="signup-form" action="" method="POST">
			<input type="text" name="username" placeholder="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
			<input type="text" name="name" placeholder="name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off">
			<input type="text" name="email" placeholder="e-mail" autocomplete="off">
			<input type="password" name="pwd" placeholder="password" autocomplete="off">
			<input type="password" name="pwd_again" placeholder="password again" autocomplete="off">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?> " >
			<button type="submit" name="submit">Sign up</button>
		</form>
	</div>
</section>
<?php
include_once 'footer.php';
?>
