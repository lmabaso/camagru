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
    echo "<p> Please Login or register to procced";
}
echo "</div>
</section>";
include_once 'footer.php';
?>
