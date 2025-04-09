<?php
session_start();
$server = 'MySQL-8.0'; // Имя или адрес сервера
$user = 'root'; // Имя пользователя БД
$password = ''; // Пароль пользователя
$db_name = 'its_db'; // Название БД
$db = mysqli_connect($server, $user, $password, $db_name);



$result = mysqli_query($db, "SHOW COLUMNS FROM users");
$columns = [];
while ($row = mysqli_fetch_assoc($result)) {
    $columns[] = $row['Field'];
}

$error = '';
$username = trim($_SESSION['username']);
    $password = trim($_SESSION['password']);
    if (!empty($username) && !empty($password)) {
        // Используем подготовленные выражения для безопасности
        $stmt = $db->prepare("SELECT user_id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Проверяем пароль
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                require_once('../pages/main.html'); 

                
                exit;
            } else {
                echo('Неверный пароль');
            }
        } else {
            echo('Пользователь не найден');
        } 
    } else {
        $error = 'Заполните все поля';
    }