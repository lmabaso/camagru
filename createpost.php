<?php
include_once 'header.php';
if (!$user->isLoggedIn())
{
    Redirect::to('index.php');
}
if (Input::exists())
{
    if(Input::get('Delete'))
    {
        $pic = new Photo();
        $pic->delete(array(Input::get('pic_id')));
    }
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
            list($weight, $height) = getimagesize($filter);
            imagecopy($dest, $src, (400/2)-($weight/2), 300 * 0.2, 0, 0, $weight, $height);
            imagepng($dest, $name);
            imagedestroy($dest);
            imagedestroy($src);
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
    <div style="display: inline">
	<div class="main-wrapper">
        <h2>New Post</h2>
        <div>
            <button onclick="capture('camera')" id="cam">Use Camera</button>
            <button onclick="capture('upload')" id="upl"><label  for="uploadpic" id="upl"> Upload image from file </label></button>
            <input type="file"  id="uploadpic" style="display:none" value="">
        </div>
        <div class="booth" id="camera" style="display: none">
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
                    <option value="imgs/overlay/clear.png">Select</option>
                    <option value="imgs/overlay/Glasses.png">Glasses</option>
                    <option value="imgs/overlay/headgear.png">headgear</option>
                    <option value="imgs/overlay/dogface.png">Dog ears</option>
                    <option value="imgs/overlay/eyes.png">Eyes</option>
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
    <div style="margin-top: 30px">

        <?php
            $stuff = DB::getInstance();
            $res = $stuff->query('SELECT * FROM pictures WHERE user_id=? ORDER BY id DESC ', array($user->data()->user_id));
            foreach ($res->results() as $pic)
            {
                echo '<div class="booth">';
                echo '<form action="" method="POST">';
                // $user->find($pic->user_id);
                echo '<input type="hidden" name="pic_id" value="'. $pic->id .'"/>';
                echo '<label>You posted this</label><br />';
                echo '<img src="'. $pic->pic_dir.'">';
                $res1 = $stuff->query('SELECT * FROM likes WHERE pic_id=?', array($pic->id));
                echo $res1->count() . " like(s) and ";
                $res1 = $stuff->query('SELECT * FROM comments WHERE pic_id=?', array($pic->id));
                echo $res1->count() . " comments<br/>";
                echo '<input type="submit" name="Delete" value="Delete"><br/>';
                $res1 = $stuff->query('SELECT * FROM comments WHERE pic_id=?', array($pic->id))->results();
                foreach ($res1 as $com)
                {
                    echo '<div>';
                    $user->find($com->user_id);
                    echo $user->data()->user_username . " said<br />";
                    echo '&ensp;&ensp;'.$com->comment;
                    echo '</div>';
                }
                echo '</form>';
                echo '</div>';
            }
        ?>
        </div>
    </div>
    <script src="main.js"></script>
</section>
<?php
include_once 'footer.php';
?>
