<?php 
include_once 'header.php';

echo '<section class="main-container">
        <div class="main-wrapper">
            <h2>Home</h2>';

if (Session::exists('success'))
{
    echo Session::flash('success');
}
if (Session::exists('fail'))
{
    echo Session::flash('fail');
}
if ($user->isLoggedIn())
{
    Redirect::to('home.php');
}
else
{
    $stuff = DB::getInstance();
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
        // echo '<input type="submit" name="like" value="like"><br/>';
        $res1 = $stuff->query('SELECT * FROM comments WHERE pic_id=?', array($pic->id))->results();
        foreach ($res1 as $com)
        {
            echo '<div>';
            $user->find($com->user_id);
            echo $user->data()->user_username . " said<br />";
            echo '&ensp;&ensp;'.$com->comment;
            echo '</div>';
        }
        // echo '<input type="text" name="commenta" value="" placeholder="comment..." />';
        // echo '<input type="submit" name="comment" value="comment">';
        echo '</form>';
        echo '</div>';
    }
}
echo "</div>
</section>";
include_once 'footer.php';
?>
