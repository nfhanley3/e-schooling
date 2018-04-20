<?php

session_start();

$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'eschooling'
    ],
    'remember' => [
        'cookie_name' => 'hash',
        'cookie_expiry' => 64000,
    ],
    'lostpassword' => [
        'lost_pass' => ''
    ],
    'session' => [
        'session_name' => 'user',
        'token_name' => 'token'
    ]

];

spl_autoload_register( function ($class){
    require_once '../classes/' . $class . '.php';
});

require_once '../function/sanitize.php';


/* if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = Database::getInstance()->get('users_session', array('hash', '=', $hash));

    if ($hashCheck->count()){
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
} */