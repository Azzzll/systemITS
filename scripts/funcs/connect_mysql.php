<?php
function connectToDB(){
    $server = 'MySQL-8.0'; 
    $user = 'root';
    $password = '';
    $db_name = 'its_db';
    $db = mysqli_connect($server, $user, $password, $db_name);
    return $db;
}