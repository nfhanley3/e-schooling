<?php

/**
 * Created by PhpStorm.
 * User: febikam
 * Date: 11/27/2016
 * Time: 10:24 AM
 */
class Redirect {

    public static function to($location = null){

        if ($location){
            if (is_numeric($location)){
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include '../includes/errors/404.php';
                        exit();
                    break;

                }
            }
            header('Location: ' . $location);
            exit();
        }
    }
}