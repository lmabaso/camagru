<?php

class Token {
    public static function generate() {
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    public static function check($token) {
        $tokenName = Config::get('session/token_name');
        if (Session::exists($tokenName)) {
            if (strcmp(trim($token), Session::get($tokenName)) === 0) {
                Session::delete($tokenName);
                return (true);
            }
        }
        return (false);
    }
}