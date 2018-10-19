<?php

class Hash {
    public static function make($string, $salt = '') {
        return (hash('sha256', $string));
        // return (hash('sha256', $string . $salt));
    }

    public static function salt($legnth) {
        // return (mcrypt_create_iv($legnth));
        return (time());
    }

    public static function unique() {
        return (self::make(uniqid()));
    }
}