<?php

$server = 'MySQL-8.0'; 
$user = 'root';
$password = '';
$db_name = 'its_db';
$link = mysqli_connect($server, $user, $password, $db_name);

if (!$link) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

mysqli_set_charset($link, "utf8mb4");
