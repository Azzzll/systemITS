<?php
require_once __DIR__ . './funcs/connect_mysql.php';
ob_start();
session_start();
$db = connectToDB();
require_once __DIR__ . './funcs/authorisation_check.php';

if ( isUserAuthorized()) {
    require_once('./main_page_requres/body.php');  
} else{
    echo 'authorization error';
}


?>
