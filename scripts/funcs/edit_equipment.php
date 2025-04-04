<?php
session_start();
include 'db_equipment.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Неверный ID оборудования";
    header("Location: equipment.php");
    exit();
}

$equipment_id = intval($_GET['id']);

// Получаем данные оборудования
$query = "SELECT 
            e.*,
            l.department AS location_department,
            l.audience AS location_audience,
            l.workplace AS location_workplace,
            l.prev_department AS prev_department,
            l.prev_audience AS prev_audience,
            l.prev_workplace AS prev_workplace
          FROM equipment e
          LEFT JOIN location l ON e.location_id = l.location_id
          WHERE e.equipment_id = $equipment_id";

$result = mysqli_query($link, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    $_SESSION['error'] = "Оборудование не найдено";
    header("Location: equipment.php");
    exit();
}

$equipment = mysqli_fetch_assoc($result);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Редактировать оборудование #<?= htmlspecialchars($equipment['equipment_id']) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .dynamic-add { margin-top: 5px; }
        .dynamic-add input { margin-right: 5px; }
        .form-section { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .form-section h4 { color: #007bff; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Редактировать оборудование #<?= htmlspecialchars($equipment['equipment_id']) ?></h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="equipment_proccess.php" method="post" id="equipmentForm">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="equipment_id" value="<?= $equipment['equipment_id'] ?>">

        <div class="form-section">
            <br><h4>Основные данные</h4>

            <div class="form-group">
                <label for="category_id">Раздел:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Выберите раздел</option>
                    <?php
                    include 'db_equipment.php';
                    $categories = mysqli_query($link, "SELECT category_id, name FROM equipment_category");
                    while ($cat = mysqli_fetch_assoc($categories)) {
                        $selected = $cat['category_id'] == $equipment['category_id'] ? 'selected' : '';
                        echo "<option value='{$cat['category_id']}' $selected>{$cat['name']}</option>";
                    }
                    mysqli_close($link);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="type_id">Тип:</label>
                <select class="form-control" id="type_id" name="type_id" required>
                    <option value="">Выберите тип</option>
                    <?php
                    include 'db_equipment.php';
                    $types = mysqli_query($link, "SELECT type_id, name FROM equipment_type");
                    while ($type = mysqli_fetch_assoc($types)) {
                        $selected = $type['type_id'] == $equipment['type_id'] ? 'selected' : '';
                        echo "<option value='{$type['type_id']}' $selected>{$type['name']}</option>";
                    }
                    mysqli_close($link);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="serial_number">Серийный №:</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number" 
                       value="<?= htmlspecialchars($equipment['serial_number']) ?>" required>
            </div>

            <div class="form-group">
                <label for="inventory_number">Инвентарный №:</label>
                <input type="text" class="form-control" id="inventory_number" name="inventory_number" 
                       value="<?= htmlspecialchars($equipment['inventory_number']) ?>" required>
            </div>

            <div class="form-group">
                <label for="manufacture">Марка:</label>
                <input type="text" class="form-control" id="manufacture" name="manufacture" 
                       value="<?= htmlspecialchars($equipment['manufacture']) ?>" required>
            </div>

            <div class="form-group">
                <label for="model">Модель:</label>
                <input type="text" class="form-control" id="model" name="model" 
                       value="<?= htmlspecialchars($equipment['model']) ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Примечание / описание:</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= 
                    htmlspecialchars($equipment['description']) ?></textarea>
            </div>
        </div>

        <!-- Остальные секции формы аналогично add_equipment.php, но с предзаполненными значениями -->
        <!-- Для краткости покажу только часть, остальное по аналогии -->

        <div class="form-section">
            <h4>Местоположение</h4>
            
            <div class="form-group">
                <label for="location_department">Подразделение:</label>
                <input type="text" class="form-control" id="location_department" name="location_department"
                       value="<?= htmlspecialchars($equipment['location_department'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="location_audience">Аудитория:</label>
                <input type="text" class="form-control" id="location_audience" name="location_audience"
                       value="<?= htmlspecialchars($equipment['location_audience'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="location_workplace">Рабочее место:</label>
                <input type="text" class="form-control" id="location_workplace" name="location_workplace"
                       value="<?= htmlspecialchars($equipment['location_workplace'] ?? '') ?>">
            </div>

            <h5>Предыдущее местоположение</h5>
            <div class="form-group">
                <label for="prev_department">Подразделение:</label>
                <input type="text" class="form-control" id="prev_department" name="prev_department"
                       value="<?= htmlspecialchars($equipment['prev_department'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="prev_audience">Аудитория:</label>
                <input type="text" class="form-control" id="prev_audience" name="prev_audience"
                       value="<?= htmlspecialchars($equipment['prev_audience'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="prev_workplace">Рабочее место:</label>
                <input type="text" class="form-control" id="prev_workplace" name="prev_workplace"
                       value="<?= htmlspecialchars($equipment['prev_workplace'] ?? '') ?>">
            </div>
        </div>


        <div class="form-section">
            <h4>Характеристики</h4>
            <div class="form-group">
                <label for="diagonal">Диагональ:</label>
                <input type="text" class="form-control" id="diagonal" name="diagonal"
                        value="<?= htmlspecialchars($equipment['diagonal']) ?>">
            </div>

            <div class="form-group">
                <label for="focal_length">Фокусное расстояние:</label>
                <input type="text" class="form-control" id="focal_length" name="focal_length"
                        value="<?= htmlspecialchars($equipment['focal_length']) ?>">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="poe" name="poe" value="1" 
                       <?= $equipment['poe'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="poe">Поддержка PoE</label>
            </div>

            <div class="form-group">
                <label for="cpu">CPU:</label>
                <input type="text" class="form-control" id="cpu" name="cpu" 
                       value="<?= htmlspecialchars($equipment['cpu']) ?>">
            </div>

            <div class="form-group">
                < <label for="ram">RAM:</label>
                <input type="text" class="form-control" id="ram" name="ram" 
                       value="<?= htmlspecialchars($equipment['ram']) ?>">
            </div>

            <div class="form-group">
                <label for="storage">Накопители:</label>
                <input type="text" class="form-control" id="storage" name="storage" 
                       value="<?= htmlspecialchars($equipment['storage']) ?>">
            </div>

            <div class="form-group">
                <label for="power_supply">Блок питания:</label>
                <input type="text" class="form-control" id="power_supply" name="power_supply" 
                       value="<?= htmlspecialchars($equipment['power_supply']) ?>">
            </div>

            <div class="form-group">
                <label for="frame">Корпус:</label>
                <input type="text" class="form-control" id="frame" name="frame" 
                       value="<?= htmlspecialchars($equipment['frame']) ?>">
            </div>

            <div class="form-group">
                <label for="length">Длина / формат:</label>
                <input type="text" class="form-control" id="length" name="length" 
                       value="<?= htmlspecialchars($equipment['length']) ?>">
            </div>

            <div class="form-group">
                <label for="port_count">Кол-во портов:</label>
                <input type="number" class="form-control" id="port_count" name="port_count" min="0" 
                       value="<?= htmlspecialchars($equipment['port_count']) ?>">
            </div>

            <div class="form-group">
                <label for="port_1">Порт 1:</label>
                <input type="text" class="form-control" id="port_1" name="port_1" 
                       value="<?= htmlspecialchars($equipment['port_1']) ?>">
            </div>

            <div class="form-group">
                <label for="port_2">Порт 2:</label>
                <input type="text" class="form-control" id="port_2" name="port_2" 
                       value="<?= htmlspecialchars($equipment['port_2']) ?>">
            </div>
        </div>

        <div class="form-section">
            <h4>Сетевые данные</h4>
            <div class="form-group">
                <label for="dns_name">DNS-name:</label>
                <input type="text" class="form-control" id="dns_name" name="dns_name" 
                       value="<?= htmlspecialchars($equipment['dns_name']) ?>">
            </div>

            <div class="form-group">
                <label for="mac_address">MAC-address:</label>
                <input type="text" class="form-control" id="mac_address" name="mac_address" 
                       value="<?= htmlspecialchars($equipment['mac_address']) ?>">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Сохранить изменения</button>
            <a href="equipment.php" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>