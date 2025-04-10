<?php
session_start();
require_once __DIR__ . './funcs/authorisation_check.php';
if (isUserAuthorized()){
    require_once('../pages/main.html'); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_unset();
    header("Location: ./../");
}
