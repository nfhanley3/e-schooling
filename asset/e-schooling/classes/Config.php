<?php

/**
 * Created by PhpStorm.
 * User: febikam
 * Date: 11/27/2016
 * Time: 10:22 AM
 */
class Config
{
    public static function get( $path = null ){
        if( $path ){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $bit){
                if(isset($config[$bit])){
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }
}