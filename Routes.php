<?php

Route::set('index.php', function() {
    Index::createView('index');
    // Index::test();
});

Route::set('login.php', function() {
    Login::createView('login');
});

Route::set('signup.php', function() {
    Signup::createView('signup');
});

Route::set('logout.php', function() {
    Logout::createView('logout');
});

Route::set('profile.php', function() {
    Profile::createView('profile');
});

Route::set('changepassword.php', function() {
    ChangePassword::createView('changepassword');
});

Route::set('createpost.php', function() {
    CreatePost::createView('createpost');
});

Route::set('updateinfo.php', function() {
    UpdateInfo::createView('updateinfo');
});
?>