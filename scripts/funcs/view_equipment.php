<?php
include 'db_equipment.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Неверный ID оборудования");
}

$equipment_id = intval($_GET['id']);

$query = "SELECT 
            e.*,
            ec.name AS category_name,
            et.name AS type_name,
            l.department AS location_department,
            l.audience AS location_audience,
            l.workplace AS location_workplace,
            l.prev_department AS prev_location_department,
            l.prev_audience AS prev_location_audience,
            l.prev_workplace AS prev_location_workplace
          FROM equipment e
          LEFT JOIN equipment_category ec ON e.category_id = ec.category_id
          LEFT JOIN equipment_type et ON e.type_id = et.type_id
          LEFT JOIN location l ON e.location_id = l.location_id
          WHERE e.equipment_id = $equipment_id";

$result = mysqli_query($link, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Оборудование не найдено");
}

$row = mysqli_fetch_assoc($result);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Просмотр оборудования #<?= htmlspecialchars($row['equipment_id']) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Просмотр оборудования #<?= htmlspecialchars($row['equipment_id']) ?></h1>
        <div>
            <a href="edit_equipment.php?id=<?= $row['equipment_id'] ?>" class="btn btn-primary">Редактировать</a>
            <a href="delete_equipment.php?id=<?= $row['equipment_id'] ?>" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить это оборудование?')">Удалить</a>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            Основная информация
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Раздел:</strong> <?= htmlspecialchars($row['category_name']) ?></p>
                    <p><strong>Тип:</strong> <?= htmlspecialchars($row['type_name']) ?></p>
                    <p><strong>Инвентарный №:</strong> <?= htmlspecialchars($row['inventory_number']) ?></p>
                    <p><strong>Серийный №:</strong> <?= htmlspecialchars($row['serial_number']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Марка:</strong> <?= htmlspecialchars($row['manufacture']) ?></p>
                    <p><strong>Модель:</strong> <?= htmlspecialchars($row['model']) ?></p>
                    <p><strong>Описание:</strong> <?= htmlspecialchars($row['description']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Местоположение
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Текущее местоположение</h5>
                    <p><strong>Подразделение:</strong> <?= htmlspecialchars($row['location_department']) ?></p>
                    <p><strong>Аудитория:</strong> <?= htmlspecialchars($row['location_audience']) ?></p>
                    <p><strong>Рабочее место:</strong> <?= htmlspecialchars($row['location_workplace']) ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Предыдущее местоположение</h5>
                    <p><strong>Подразделение:</strong> <?= htmlspecialchars($row['prev_location_department']) ?></p>
                    <p><strong>Аудитория:</strong> <?= htmlspecialchars($row['prev_location_audience']) ?></p>
                    <p><strong>Рабочее место:</strong> <?= htmlspecialchars($row['prev_location_workplace']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Технические характеристики
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Диагональ:</strong> <?= htmlspecialchars($row['diagonal']) ?></p>
                    <p><strong>Фокусное расстояние:</strong> <?= htmlspecialchars($row['focal_length']) ?></p>
                    <p><strong>Поддержка PoE:</strong> <?= $row['poe'] ? 'Да' : 'Нет' ?></p>
                    <p><strong>CPU:</strong> <?= htmlspecialchars($row['cpu']) ?></p>
                    <p><strong>RAM:</strong> <?= htmlspecialchars($row['ram']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Накопители:</strong> <?= htmlspecialchars($row['storage']) ?></p>
                    <p><strong>Блок питания:</strong> <?= htmlspecialchars($row['power_supply']) ?></p>
                    <p><strong>Корпус:</strong> <?= htmlspecialchars($row['frame']) ?></p>
                    <p><strong>Длина/формат:</strong> <?= htmlspecialchars($row['length']) ?></p>
                    <p><strong>Кол-во портов:</strong> <?= htmlspecialchars($row['port_count']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Сетевые данные
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>DNS-name:</strong> <?= htmlspecialchars($row['dns_name']) ?></p>
                    <p><strong>MAC-address:</strong> <?= htmlspecialchars($row['mac_address']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Порт 1:</strong> <?= htmlspecialchars($row['port_1']) ?></p>
                    <p><strong>Порт 2:</strong> <?= htmlspecialchars($row['port_2']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="equipment.php" class="btn btn-secondary">Назад к списку</a>
    </div>
</div>
</body>
</html>