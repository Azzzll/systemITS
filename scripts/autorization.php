<?php
session_start(); 
$server = 'MySQL-8.0'; 
$user = 'root';
$password = '';
$db_name = 'its_db';
$db = mysqli_connect($server, $user, $password, $db_name);
require_once('../pages/autorization.html');

$result = mysqli_query($db, "SHOW COLUMNS FROM users");
$columns = [];
while ($row = mysqli_fetch_assoc($result)) {
    $columns[] = $row['Field'];
}

var_dump($_SESSION['tema']);
echo ($_SESSION['tema']);
// Обработка формы авторизации
$error = ''; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if (!empty($username) && !empty($password)) {
        // Используем подготовленные выражения для безопасности
        $stmt = $db->prepare("SELECT user_id, password, last_name, first_name, surname FROM users WHERE email = ?");        
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
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['surname'] = $user['surname'];
                $_SESSION['last_name'] = $user['last_name'];
                header("Location: ./main.php");
                
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
    
}
