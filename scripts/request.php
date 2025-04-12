<?php
require_once __DIR__ . './funcs/authorisation_check.php';
require_once __DIR__ . './funcs/connect_mysql.php';
session_start();
connectToDB();
$mysqli = connectToDB();

if (isUserAuthorized()){
    require_once('../pages/request.html');
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auditoria = $_POST['auditoria'];
    $contact = $_POST['contact'];
    $tema = $_POST['tema'];
    $description = $_POST['description'];
    $userID = $_SESSION['user_id'];
    $status = 'Новая';

    if (!empty($description)) {
        try {
            // Подготовленный запрос MySQLi
            $stmt = $mysqli->prepare("
                INSERT INTO requests 
                (user_id, description, audience, topic, contact, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            
            // Привязка параметров
            $stmt->bind_param("isssss", $userID, $description, $auditoria, $tema, $contact, $status);
            if ($stmt->execute()) {
                echo 'запрос отправлен';
                // header("Location: ./");
                exit();
            } else {
                echo 'Ошибка выполнения запроса';
            }
        } 
        catch (Exception $e) {
            echo 'Произошла ошибка. Пожалуйста, попробуйте позже.';
        } 
        /* finally {
            $stmt->close();
            $mysqli->close();
        } */
    }
}




