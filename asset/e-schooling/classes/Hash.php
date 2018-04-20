<?php

/**
 * Created by PhpStorm.
 * User: febikam
 * Date: 11/27/2016
 * Time: 10:24 AM
 */
class Hash {

    public static function make($string, $salt = ''){
        return hash('sha256', $string.$salt);
    }

    public static function salt($length){
        return mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
    }

    public static function unique(){
        return self::make(uniqid());
    }
}