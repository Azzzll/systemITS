<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'its_db';

$link = mysqli_connect($host, $username, $password, $database);

if (!$link) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

mysqli_set_charset($link, "utf8mb4");
