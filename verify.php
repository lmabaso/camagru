<?php

require_once 'config/Core/init.php';

$stuff = DB::getInstance();

$result = $stuff->get('users', array('token', '=', Input::get('token')));
$result1 = $stuff->get('users', array('user_email', '=', Input::get('email')));
if ($result->results()[0]->user_isvalidated == 1)
{
    echo Session::flash('fail', 'User already verified account.');
}
else if ($result1->results()[0]->user_id === $result->results()[0]->user_id)
{
    $stuff->update('users', $result1->results()[0]->user_id, array('user_isvalidated' => 1));
    echo Session::flash('success', 'Successfully verified your account you can log in now.');
}
else 
{
    echo Session::flash('fail', 'Problem Verifying your account.');
}
Redirect::to('index.php');