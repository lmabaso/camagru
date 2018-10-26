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
			'photo' => array('required' => true)
        ));
        if ($validation->passed())
        {
            $data = substr(Input::get('photo'), strpos(Input::get('photo'), ",") + 1);
            $decode = base64_decode($data);
            $name = "imgs/".Input::get('token')."-".time().".png";
            $fp = fopen($name, 'wb');
            if (!fwrite($fp, $decode))
            {
				echo "<script>alert('Unable to find image. Please upload/take an image.');</script>";
            }
            fclose($fp);

            $filter = Input::get('super_img');

            $dest = imagecreatefrompng($name);
            $src = imagecreatefrompng($filter);
            imagecopymerge($dest, $src, 200, 20, 0, 0, 150, 150, 100);
            imagepng($dest, $name);
            $pic = new Photo();

            $pic->upload(array(
                'user_id' => escape($user->data()->user_id),
                'pic_dir' => $name
            ));
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
        <h2>New Post</p>
        <div class="booth"> 
            <div id="inner-box"></div>
            <video id="video" width="400" height="300"></video>
            <canvas id="canvas" width="400" height="300"></canvas>
            <div style="display:flex">
                <button  onclick="capture('capture')" id="capture" style="display:block">capture</button>
                <button  onclick="capture('save')" id="upload" style="display:none">save changes</button>
                <button onclick="capture('new')" id="new" style="display:none">New photo</button>
            </div>
            <div style="display:flex">
                <select name="filter" id ="filter">
                    <option value=""></option>
                    <option value="imgs/overlay/Glasses.png">Glasses</option>
                    <option value="imgs/overlay/headgear.png">headgear</option>
                    <option value="imgs/overlay/">3</option>
                    <option value="">4</option>
                </select>
                <button onclick="superimpose()">Apply Effect</button>
            </div>
            <form method="post"  action="createpost.php">
                <input type="hidden" id="super_img" name="super_img" value="" />
                <input type="hidden" id="photo" name="photo" value="" />
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?> ">
                <input type="submit" name="submit" id="photoform" value="Upload" disabled />
            </form>
        </div>
    </div>
    <script src="main.js"></script>
</section>
<?php
include_once 'footer.php';
?>
