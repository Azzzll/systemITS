<?php
// Если не авторизирован то рекдирект на страницу входа
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./index.php");
    exit();
}
// Обработка выхода из профиля
if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("Location: ./");
    exit();
}
require_once "home.html";
$user = $_SESSION['user'];
echo 'Добро пожаловать, ' . htmlspecialchars($user['name']) . ' ' . htmlspecialchars($user['surname']) . '!';
echo '<br>';
echo '<br>';
?>
<html>
    <form method="POST" action="home.php">
                <button type="submit" name="logout">Выйти</button>
    </form>
</html>
