<?php
include_once 'header.php';
if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
?>
<section class="main-container">
	<div class="main-wrapper">
        <h2>New Post</p>
        <div class="booth"> 
            <video id="video" width="400" height="300"></video>
            <canvas id="canvas" width="400" height="300"></canvas>
            <div style="display:flex">
                <button  onclick="capture()" id="capture" style="display:block">capture</button>
                <button  onclick="upload()" id="upload" style="display:none">upload</button>
                <button onclick="newcap()" id="new" style="display:none">New photo</button>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
</section>
<?php
include_once 'footer.php';
?>
