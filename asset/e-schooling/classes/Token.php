<?php
/**
 * Created by PhpStorm.
 * User: febikam
 * Date: 11/27/2016
 * Time: 10:25 AM
 */
class Token {

    public static function generate() {
        return Session::put(Config::get('session/token_name'), bin2hex(openssl_random_pseudo_bytes(32)));
    }

    public static function check($token) {
        $tokenName = Config::get('session/token_name');

        if (Session::exists($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);
            return true;
        }

        return false;
    }
}