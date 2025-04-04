<?php
session_start();
include 'db_equipment.php';

header('Content-Type: text/html; charset=utf-8');

// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Неверный метод запроса";
    header("Location: add_equipment.php");
    exit();
}

// Получаем действие
$action = $_POST['action'] ?? '';
if (!in_array($action, ['add', 'edit'])) {
    $_SESSION['error'] = "Неизвестное действие";
    header("Location: add_equipment.php");
    exit();
}

// Для действия 'edit' получаем ID оборудования
if ($action === 'edit') {
    $equipment_id = isset($_POST['equipment_id']) ? intval($_POST['equipment_id']) : 0;
    if ($equipment_id <= 0) {
        $_SESSION['error'] = "Неверный ID оборудования";
        header("Location: equipment.php");
        exit();
    }
}

// Функция для очистки данных
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Обработка данных формы
$category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
$type_id = isset($_POST['type_id']) ? intval($_POST['type_id']) : 0;
$serial_number = isset($_POST['serial_number']) ? cleanInput($_POST['serial_number']) : '';
$inventory_number = isset($_POST['inventory_number']) ? cleanInput($_POST['inventory_number']) : '';
$manufacture = isset($_POST['manufacture']) ? cleanInput($_POST['manufacture']) : '';
$model = isset($_POST['model']) ? cleanInput($_POST['model']) : '';

// Проверка обязательных полей
if (empty($category_id) || empty($type_id) || empty($serial_number) || empty($inventory_number) || empty($manufacture) || empty($model)) {
    $_SESSION['error'] = "Заполните все обязательные поля (раздел, тип, серийный №, инвентарный №, марка, модель)";
    header("Location: " . ($action === 'add' ? "add_equipment.php" : "edit_equipment.php?id=$equipment_id"));
    exit();
}

// Проверяем существование категории и типа
$check_category = mysqli_query($link, "SELECT category_id FROM equipment_category WHERE category_id = $category_id");
if (!$check_category || mysqli_num_rows($check_category) == 0) {
    $_SESSION['error'] = "Выбранный раздел не существует";
    header("Location: " . ($action === 'add' ? "add_equipment.php" : "edit_equipment.php?id=$equipment_id"));
    exit();
}

$check_type = mysqli_query($link, "SELECT type_id FROM equipment_type WHERE type_id = $type_id");
if (!$check_type || mysqli_num_rows($check_type) == 0) {
    $_SESSION['error'] = "Выбранный тип не существует";
    header("Location: " . ($action === 'add' ? "add_equipment.php" : "edit_equipment.php?id=$equipment_id"));
    exit();
}

// Обработка местоположения
$location_department = isset($_POST['location_department']) ? cleanInput($_POST['location_department']) : null;
$location_audience = isset($_POST['location_audience']) ? cleanInput($_POST['location_audience']) : null;
$location_workplace = isset($_POST['location_workplace']) ? cleanInput($_POST['location_workplace']) : null;
$prev_department = isset($_POST['prev_department']) ? cleanInput($_POST['prev_department']) : null;
$prev_audience = isset($_POST['prev_audience']) ? cleanInput($_POST['prev_audience']) : null;
$prev_workplace = isset($_POST['prev_workplace']) ? cleanInput($_POST['prev_workplace']) : null;

// Для редактирования сначала получаем текущий location_id
$current_location_id = null;
if ($action === 'edit') {
    $current_query = mysqli_query($link, "SELECT location_id FROM equipment WHERE equipment_id = $equipment_id");
    if ($current_query && mysqli_num_rows($current_query) > 0) {
        $current_row = mysqli_fetch_assoc($current_query);
        $current_location_id = $current_row['location_id'];
    }
}

// Добавляем/обновляем местоположение в таблице location
$location_id = null;
if ($location_department || $location_audience || $location_workplace || $prev_department || $prev_audience || $prev_workplace) {
    if ($action === 'edit' && $current_location_id) {
        // Обновляем существующую запись местоположения
        $location_query = "UPDATE location SET
            department = " . ($location_department ? "'" . mysqli_real_escape_string($link, $location_department) . "'" : "NULL") . ",
            audience = " . ($location_audience ? "'" . mysqli_real_escape_string($link, $location_audience) . "'" : "NULL") . ",
            workplace = " . ($location_workplace ? "'" . mysqli_real_escape_string($link, $location_workplace) . "'" : "NULL") . ",
            prev_department = " . ($prev_department ? "'" . mysqli_real_escape_string($link, $prev_department) . "'" : "NULL") . ",
            prev_audience = " . ($prev_audience ? "'" . mysqli_real_escape_string($link, $prev_audience) . "'" : "NULL") . ",
            prev_workplace = " . ($prev_workplace ? "'" . mysqli_real_escape_string($link, $prev_workplace) . "'" : "NULL") . "
            WHERE location_id = $current_location_id";
        
        if (mysqli_query($link, $location_query)) {
            $location_id = $current_location_id;
        } else {
            $_SESSION['error'] = "Ошибка при обновлении местоположения: " . mysqli_error($link);
            header("Location: edit_equipment.php?id=$equipment_id");
            exit();
        }
    } else {
        // Добавляем новую запись местоположения
        $location_query = "INSERT INTO location (
            department, 
            audience, 
            workplace,
            prev_department,
            prev_audience,
            prev_workplace
        ) VALUES (
            " . ($location_department ? "'" . mysqli_real_escape_string($link, $location_department) . "'" : "NULL") . ",
            " . ($location_audience ? "'" . mysqli_real_escape_string($link, $location_audience) . "'" : "NULL") . ",
            " . ($location_workplace ? "'" . mysqli_real_escape_string($link, $location_workplace) . "'" : "NULL") . ",
            " . ($prev_department ? "'" . mysqli_real_escape_string($link, $prev_department) . "'" : "NULL") . ",
            " . ($prev_audience ? "'" . mysqli_real_escape_string($link, $prev_audience) . "'" : "NULL") . ",
            " . ($prev_workplace ? "'" . mysqli_real_escape_string($link, $prev_workplace) . "'" : "NULL") . "
        )";
        
        if (mysqli_query($link, $location_query)) {
            $location_id = mysqli_insert_id($link);
        } else {
            $_SESSION['error'] = "Ошибка при сохранении местоположения: " . mysqli_error($link);
            header("Location: " . ($action === 'add' ? "add_equipment.php" : "edit_equipment.php?id=$equipment_id"));
            exit();
        }
    }
} elseif ($action === 'edit' && $current_location_id) {
    // Удаляем запись местоположения, если она была, но теперь все поля пустые
    mysqli_query($link, "DELETE FROM location WHERE location_id = $current_location_id");
}

// Подготавливаем данные для вставки/обновления в equipment
$equipment_data = [
    'category_id' => $category_id,
    'type_id' => $type_id,
    'serial_number' => "'" . mysqli_real_escape_string($link, $serial_number) . "'",
    'inventory_number' => "'" . mysqli_real_escape_string($link, $inventory_number) . "'",
    'manufacture' => "'" . mysqli_real_escape_string($link, $manufacture) . "'",
    'model' => "'" . mysqli_real_escape_string($link, $model) . "'",
    'description' => isset($_POST['description']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['description'])) . "'" : "NULL",
    'dns_name' => isset($_POST['dns_name']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['dns_name'])) . "'" : "NULL",
    'mac_address' => isset($_POST['mac_address']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['mac_address'])) . "'" : "NULL",
    'diagonal' => isset($_POST['diagonal']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['diagonal'])) . "'" : "NULL",
    'focal_length' => isset($_POST['focal_length']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['focal_length'])) . "'" : "NULL",
    'poe' => isset($_POST['poe']) ? 1 : 0,
    'cpu' => isset($_POST['cpu']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['cpu'])) . "'" : "NULL",
    'ram' => isset($_POST['ram']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['ram'])) . "'" : "NULL",
    'storage' => isset($_POST['storage']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['storage'])) . "'" : "NULL",
    'power_supply' => isset($_POST['power_supply']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['power_supply'])) . "'" : "NULL",
    'frame' => isset($_POST['frame']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['frame'])) . "'" : "NULL",
    'length' => isset($_POST['length']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['length'])) . "'" : "NULL",
    'port_count' => isset($_POST['port_count']) ? intval($_POST['port_count']) : "NULL",
    'port_1' => isset($_POST['port_1']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['port_1'])) . "'" : "NULL",
    'port_2' => isset($_POST['port_2']) ? "'" . mysqli_real_escape_string($link, cleanInput($_POST['port_2'])) . "'" : "NULL",
    'location_id' => $location_id ? $location_id : "NULL"
];

if ($action === 'add') {
    // Формируем запрос на добавление
    $columns = implode(', ', array_keys($equipment_data));
    $values = implode(', ', array_values($equipment_data));
    $query = "INSERT INTO equipment ($columns) VALUES ($values)";
} else {
    // Формируем запрос на обновление
    $updates = [];
    foreach ($equipment_data as $key => $value) {
        $updates[] = "$key = $value";
    }
    $updates_str = implode(', ', $updates);
    $query = "UPDATE equipment SET $updates_str WHERE equipment_id = $equipment_id";
}

// Выполняем запрос
if (mysqli_query($link, $query)) {
    $_SESSION['message'] = "Оборудование " . ($action === 'add' ? 'успешно добавлено' : 'успешно обновлено');
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['error'] = "Ошибка при " . ($action === 'add' ? 'добавлении' : 'обновлении') . " данных: " . mysqli_error($link);
}

mysqli_close($link);
header("Location: equipment.php");
exit();
?>