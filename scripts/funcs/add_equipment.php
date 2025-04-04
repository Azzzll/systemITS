<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Добавить оборудование</title>
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
    <h1>Добавить оборудование</h1>


    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <a href="add_category.php" class="btn btn-primary">+ Добавить новый раздел или тип оборудования</a>

    <form action="equipment_proccess.php" method="post" id="equipmentForm">
        <input type="hidden" name="action" value="add"> <!-- --->

        <div class="form-section">
            <br><h4>Основные данные</h4>

            <div class="form-group">
                <label for="category_id">Раздел:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value=""> Выберите раздел </option>
                    <?php
                    include 'db_equipment.php';
                    $categories = mysqli_query($link, "SELECT category_id, name FROM equipment_category");
                    while ($cat = mysqli_fetch_assoc($categories)) {
                        echo "<option value='{$cat['category_id']}'>{$cat['name']}</option>";
                    }
                    mysqli_close($link);
                    ?>
                </select>
            </div>

            <div class="form-group">
            <label for="type_id">Тип:</label>
                <select class="form-control" id="type_id" name="type_id" required>
                    <option value=""> Выберите тип </option>
                    <?php
                    include 'db_equipment.php';
                    $types = mysqli_query($link, "SELECT type_id, name FROM equipment_type");
                    while ($type = mysqli_fetch_assoc($types)) {
                        echo "<option value='{$type['type_id']}'>{$type['name']}</option>";
                    }
                    mysqli_close($link);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="serial_number">Серийный №:</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number" required>
            </div>

            <div class="form-group">
                <label for="inventory_number">Инвентарный №:</label>
                <input type="text" class="form-control" id="inventory_number" name="inventory_number" required>
            </div>

            <div class="form-group">
                <label for="manufacture">Марка:</label>
                <input type="text" class="form-control" id="manufacture" name="manufacture" required>
            </div>

            <div class="form-group">
                <label for="model">Модель:</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>

            <div class="form-group">
                <label for="description">Примечание / описание:</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
        </div>

        <div class="form-section">
            <h4>Местоположение</h4>
            
            <div class="form-group">
                <label for="location_department">Подразделение:</label>
                <input type="text" class="form-control" id="location_department" name="location_department">
            </div>

            <div class="form-group">
                <label for="location_audience">Аудитория:</label>
                <input type="text" class="form-control" id="location_audience" name="location_audience">
            </div>

            <div class="form-group">
                <label for="location_workplace">Рабочее место:</label>
                <input type="text" class="form-control" id="location_workplace" name="location_workplace">
            </div>

            <h5>Предыдущее местоположение</h5>
            <div class="form-group">
                <label for="prev_department">Подразделение:</label>
                <input type="text" class="form-control" id="prev_department" name="prev_department">
            </div>

            <div class="form-group">
                <label for="prev_audience">Аудитория:</label>
                <input type="text" class="form-control" id="prev_audience" name="prev_audience">
            </div>

            <div class="form-group">
                <label for="prev_workplace">Рабочее место:</label>
                <input type="text" class="form-control" id="prev_workplace" name="prev_workplace">
            </div>
        </div>

        <div class="form-section">
            <h4>Характеристики</h4>
            
            <div class="form-group">
                <label for="diagonal">Диагональ:</label>
                <input type="text" class="form-control" id="diagonal" name="diagonal">
            </div>

            <div class="form-group">
                <label for="focal_length">Фокусное расстояние:</label>
                <input type="text" class="form-control" id="focal_length" name="focal_length">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="poe" name="poe" value="1">
                <label class="form-check-label" for="poe">Поддержка PoE</label>
            </div>

            <div class="form-group">
                <label for="cpu">CPU:</label>
                <input type="text" class="form-control" id="cpu" name="cpu">
            </div>

            <div class="form-group">
                <label for="ram">RAM:</label>
                <input type="text" class="form-control" id="ram" name="ram">
            </div>

            <div class="form-group">
                <label for="storage">Накопители:</label>
                <input type="text" class="form-control" id="storage" name="storage">
            </div>

            <div class="form-group">
                <label for="power_supply">Блок питания:</label>
                <input type="text" class="form-control" id="power_supply" name="power_supply">
            </div>

            <div class="form-group">
                <label for="frame">Корпус:</label>
                <input type="text" class="form-control" id="frame" name="frame">
            </div>

            <div class="form-group">
                <label for="length">Длина / формат:</label>
                <input type="text" class="form-control" id="length" name="length">
            </div>

            <div class="form-group">
                <label for="port_count">Кол-во портов:</label>
                <input type="number" class="form-control" id="port_count" name="port_count" min="0">
            </div>

            <div class="form-group">
                <label for="port_1">Порт 1:</label>
                <input type="text" class="form-control" id="port_1" name="port_1">
            </div>

            <div class="form-group">
                <label for="port_2">Порт 2:</label>
                <input type="text" class="form-control" id="port_2" name="port_2">
            </div>
        </div>

        <div class="form-section">
            <h4>Сетевые данные</h4>
            
            <div class="form-group">
                <label for="dns_name">DNS-name:</label>
                <input type="text" class="form-control" id="dns_name" name="dns_name">
            </div>

            <div class="form-group">
                <label for="mac_address">MAC-address:</label>
                <input type="text" class="form-control" id="mac_address" name="mac_address">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="equipment.php" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
// Добавление нового раздела
function addNewCategory() {
    const newCat = $('#new_category').val().trim();
    if (!newCat) return;

    $.post('add_category.php', { name: newCat }, function(data) {
        if (data.success) {
            $('#category_id').append(`<option value="${data.id}" selected>${newCat}</option>`);
            $('#new_category').val('');
        } else {
            alert('Ошибка: ' + (data.error || 'Не удалось добавить раздел'));
        }
    }, 'json');
}

// Добавление нового типа
function addNewType() {
    const newType = $('#new_type').val().trim();
    if (!newType) return;

    $.post('add_type.php', { name: newType }, function(data) {
        if (data.success) {
            $('#type_id').append(`<option value="${data.id}" selected>${newType}</option>`);
            $('#new_type').val('');
        } else {
            alert('Ошибка: ' + (data.error || 'Не удалось добавить тип'));
        }
    }, 'json');
}
</script>
</body>
</html>