<?php
session_start();

function isUserAuthorized(): bool{
    $server = 'MySQL-8.0'; 
    $user = 'root'; 
    $password = ''; 
    $db_name = 'its_db'; 
    if (isset($_SESSION['username']) && isset($_SESSION['password'])){
        $db = mysqli_connect($server, $user, $password, $db_name);
        $result = mysqli_query($db, "SHOW COLUMNS FROM users");
        $columns = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }

        // Используем подготовленные выражения для безопасности
        $stmt = $db->prepare("SELECT user_id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Проверяем пароль
            if (password_verify($_SESSION['password'], $user['password'])) {
                return true;
                exit;
            } else {
                return false;
            }
        } 
        else {
            return false;
        } 
    }
    else{
        return false;
    }    
}
