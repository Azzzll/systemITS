<?php
include 'db_equipment.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Неверный ID оборудования");
}

$equipment_id = intval($_GET['id']);

// Удаляем оборудование
$query = "DELETE FROM equipment WHERE equipment_id = $equipment_id";
if (mysqli_query($link, $query)) {
    $_SESSION['message'] = "Оборудование успешно удалено";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['error'] = "Ошибка при удалении оборудования: " . mysqli_error($link);
}

mysqli_close($link);
header("Location: equipment.php");
exit();
?>