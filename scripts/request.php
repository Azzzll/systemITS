<?php
session_start();

require_once __DIR__ . './funcs/authorisation_check.php';
if (isUserAuthorized()){
    require_once('../pages/request.html');
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auditoria = $_POST['auditoria'];
    $contact = $_POST['contact'];
    $tema = $_POST['tema'];
    $description = $_POST['description'];
    
}
var_dump($_SESSION);



