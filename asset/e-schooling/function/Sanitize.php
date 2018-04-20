<?php

function escape( $string ){
    $string = filter_var($string, FILTER_SANITIZE_STRING);
    return htmlentities( $string, ENT_QUOTES, 'UTF-8');
}
?>