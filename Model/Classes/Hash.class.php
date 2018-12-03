<?php

class Hash {
    public static function make($string, $salt = '') {
        return (hash('sha256', $string));
        // return (hash('sha256', $string . $salt));
    }

    public static function salt($legnth) {
        $str = "qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM ";
		$str = str_shuffle($str);
		$str = substr($str, 0, $legnth);
        return ($str);
    }

    public static function unique() {
        return (self::make(uniqid()));
    }
}