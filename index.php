<?php 
include_once 'header.php';

if (Session::exists('success')){
    echo Session::flash('success');
}
if (Session::exists('fail')){
    echo Session::flash('fail');
}
echo '<section class="main-container">
        <div class="main-wrapper">
            <h2>Home</h2>';
if ($user->isLoggedIn()) {
    echo "<a href='createpost.php'>create post</a>";
}
else {
    echo "<p> Please Login or register to procced";
}
?>

        
     
    </div>
</section>
<?php
include_once 'footer.php';
?>
