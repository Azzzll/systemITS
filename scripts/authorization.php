<?php
session_start(); 
require_once __DIR__ . './funcs/authorisation_check.php';
// qwdefwefds
// awdfscssxx
// rasmuslerdorf
$server = 'MySQL-8.0'; // Имя или адрес сервера
$user = 'root'; // Имя пользователя БД
$password = ''; // Пароль пользователя
$db_name = 'its_db'; // Название БД
$db = mysqli_connect($server, $user, $password, $db_name);
if (isUserAuthorized()){
    header("Location: ./main.php");
}
else{
    require_once('../pages/authorization.html');
}

$result = mysqli_query($db, "SHOW COLUMNS FROM users");
$columns = [];
while ($row = mysqli_fetch_assoc($result)) {
    $columns[] = $row['Field'];
}


// Обработка формы авторизации
$error = ''; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if (!empty($username) && !empty($password)) {
        // Используем подготовленные выражения для безопасности
        $stmt = $db->prepare("SELECT user_id, password, last_name, first_name, role_id, surname FROM users WHERE email = ?");        
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Проверяем пароль
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $username;
                $_SESSION['role_id'] = $user['role_id'];
                $_SESSION['password'] = $password;
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['surname'] = $user['surname'];
                $_SESSION['last_name'] = $user['last_name'];
                header("Location: ./main.php");
                
                exit;
            } else {
                echo('Неверный пароль или логин');
            }
        } else {
            echo('Неверный пароль или логин');
        } 
    } else {
        $error = 'Заполните все поля';
    }
    
}

// Если пользователь уже авторизован
// if (isset($_SESSION['user_id'])) {
//     header('Location: profile.php');
//     exit;
//  }