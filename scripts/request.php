<?php
session_start();
require_once __DIR__ . './funcs/authorisation_check.php';
if (isUserAuthorized()){
    require_once('../pages/request.html');
}


