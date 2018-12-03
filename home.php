<?php
include_once 'header.php';
$stuff = DB::getInstance();
if (!$user->isLoggedIn())
{
    Redirect::to('index.php');
}
if (Input::exists())
{
    if (Input::get('like'))
    {
        $res1 = $stuff->query('SELECT * FROM likes WHERE user_id=? AND pic_id=?', array($user->data()->user_id, Input::get('pic_id')));
        if (!$res1->count())
        {
            try
            {
                $stuff->insert('likes', array('user_id' => $user->data()->user_id,'pic_id' => Input::get('pic_id')));
                // $res1 = $stuff->query('SELECT * FROM pictures WHERE id=?', array(Input::get('pic_id')));
                $res = $stuff->get('pictures', array('id', '=', Input::get('pic_id')));
                $rs = $stuff->get('users', array('user_id', '=', $res->results()[0]->user_id));
                $message = 
                "
                Hi ". $rs->results()[0]->user_name ."

                ". (($user->data()->user_name == $rs->results()[0]->user_name) ? "You" : $user->data()->user_username ) ." liked your picture
                http://localhost:8080/camagru/";
                if ($rs->results()[0]->user_notification == 1)
                {
                    mail($rs->results()[0]->user_email, "Camagru like Notification", $message,  "Camagru");
                }
            }
            catch (Exception $e)
            {
                die ($e->getMessage());
            }
           
        }
        else if ($res1->count() === 1)
        {
            try
            {
                $stuff->query('DELETE FROM likes  WHERE user_id=? AND pic_id=?', array($user->data()->user_id, Input::get('pic_id')));   
            }
            catch (Exception $e)
            {
                die ($e->getMessage());
            }
        }
        
    }
    else if (input::get('comment'))
    {
        $validate = new Validate();
        $validation = $validate->check($_POST, array('commenta' => array('required' => true, 'min' => 1)));
        if ($validation->passed())
        {
            try
            {
                $stuff->insert('comments', array('user_id' => $user->data()->user_id, 'pic_id' => Input::get('pic_id'), 'comment' => Input::get('commenta')));
                $res = $stuff->get('pictures', array('id', '=', Input::get('pic_id')));
                $rs = $stuff->get('users', array('user_id', '=', $res->results()[0]->user_id));
                $message = 
                "
                Hi " . $rs->results()[0]->user_name . "

                " . (($user->data()->user_name == $rs->results()[0]->user_name) ? "You" : $user->data()->user_username ) . " comented on your picture
                http://localhost:8080/camagru/";
                if ($rs->results()[0]->user_notification == 1)
                {
                    mail($rs->results()[0]->user_email, "Camagru comment Notification", $message, "Camagru");
                }
            }
            catch (Exception $e)
            {
                die ($e->getMessage());
            }
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
        <h2>Gallery</h2>       
    </div>
    <a href='createpost.php'>create post</a><br />
<?php



$res = $stuff->query('SELECT * FROM pictures');
$limit = 5;
$total = $res->count();
$pages = ceil($total/$limit);
if (!Input::get('page'))
{
    $page = 1;
}
else
{
    $page = Input::get('page');
}
$start_limit = ($page - 1) * $limit;
$res = $stuff->query('SELECT * FROM pictures ORDER BY id DESC LIMIT '. $start_limit . ',' . $limit);
foreach ($res->results() as $pic)
{
    echo '<div class="booth">';
    echo '<form action="" method="POST">';
    $user->find($pic->user_id);
    echo '<input type="hidden" name="pic_id" value="'. $pic->id .'"/>';
    echo '<label>'. $user->data()->user_username . ' posted this</label><br />';
    echo '<img src="'. $pic->pic_dir.'">';
    $res1 = $stuff->query('SELECT * FROM likes WHERE pic_id=?', array($pic->id));
    echo $res1->count() . " like(s) and ";
    $res1 = $stuff->query('SELECT * FROM comments WHERE pic_id=?', array($pic->id));
    echo $res1->count() . " comments<br/>";
    echo '<input type="submit" name="like" value="like"><br/>';
    $res1 = $stuff->query('SELECT * FROM comments WHERE pic_id=?', array($pic->id))->results();
    foreach ($res1 as $com)
    {
        echo '<div>';
        $user->find($com->user_id);
        echo $user->data()->user_username . " said<br />";
        echo '&ensp;&ensp;'.$com->comment;
        echo '</div>';
    }
    echo '<input type="text" name="commenta" value="" placeholder="comment..." />';
    echo '<input type="submit" name="comment" value="comment">';
    echo '</form>';
    echo '</div>';
}
?>
</section>
<?php
echo '<div style="text-align: center">';
echo '<a href="'."?page=1 ".'">&laquo;</a>';
for ($page = 1; $page <= $pages; $page++)
{
    echo '<a href="?page=' . $page . ' ">' .$page . '</a> ';
}
echo '<a href="'."?page=$pages".'">&raquo;</a>';
echo '</div>';
include_once 'footer.php';
?>