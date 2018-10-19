<?php
include_once 'header.php';

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'name' => array('required' => true)
		));
		if ($validation->passed()) {
			try {
                $user->update(array(
                    'user_name' => Input::get('name')
                ));
                Session::flash('success', 'You have successfully updated your details.');
                Redirect::to('index.php');
            } catch(Exception $e) {
                die($e->getMessage());
            }
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
        <h2>Update</p>
        <form class="signup-form" action="" method="POST">
            <input type="text" name="name" placeholder="name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off">
            <!-- <input type="password" name="pwd" placeholder="password" autocomplete="off"> -->
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?> " >
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</section>
<?php
include_once 'footer.php';
?>
