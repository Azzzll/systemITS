<?php
require_once __DIR__ . './funcs/connect_mysql.php';
ob_start();
session_start();
$db = connectToDB();


require_once __DIR__ . './funcs/authorisation_check.php';
if (isUserAuthorized()){
    require_once('./main_requres/body.php');  
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_unset();
    header("Location: ../");
}
?>
