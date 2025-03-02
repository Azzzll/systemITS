<?php
require_once "./login.html";
session_start();
if (isset($_SESSION['user'])) {
    header("Location: ./home.php");
    exit();
}

$dsn = "sqlite:./ITSrequests.db";

// Проверка подключения
try {
    $pdo = new \PDO($dsn);
    echo 'Connected to the SQLite database successfully!';
}   catch (\PDOException $e) {
    echo $e->getMessage();
}


$stmt = $pdo->query("SELECT * FROM Пользователи");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Начало таблицы
echo '<table border="1">';
echo '<tr>';
// Автоматически получаем названия столбцов
foreach ($users[0] as $column => $value) {
    echo '<th>' . htmlspecialchars($column) . '</th>';
}
echo '</tr>';
// Вывод данных
foreach ($users as $user) {
    echo '<tr>';
    foreach ($user as $value) {
        echo '<td>' . htmlspecialchars($value) . '</td>';
    }
    echo '</tr>';
}
echo '</table>';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Данные из формы
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Поиск пользователя по email
    $sql = "SELECT * FROM Пользователи WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверка, найден ли пользователь
    if ($user) {
        if($password == $user['password_hash']){
            // Редирект если правильный пароль и логин
            $_SESSION['user'] = [
                'id' => $user['user_id'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'patronymic' => $user['patronymic'],
                'email' =>   $user['email']
            ];
            header("Location: ./home.php");

        }   else {
            echo "Неверный логин или пароль.";
        }
    }   else {
        echo "Неверный логин или пароль.";
    }
}


