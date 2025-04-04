<?php
session_start();
include 'db_equipment.php';

$query = "SELECT 
            e.equipment_id, 
            ec.name AS category, 
            et.name AS type, 
            e.inventory_number, 
            e.serial_number,
            e.manufacture,
            e.model,
            l.department AS location_department,
            l.audience AS location_audience,
            l.workplace AS location_workplace
          FROM equipment e
          LEFT JOIN equipment_category ec ON e.category_id = ec.category_id
          LEFT JOIN equipment_type et ON e.type_id = et.type_id
          LEFT JOIN location l ON e.location_id = l.location_id
          ORDER BY e.equipment_id DESC";

$result = mysqli_query($link, $query);

if (!$result) {
    die("Ошибка выполнения запроса: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Таблица оборудования</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-5">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?>">
            <?= $_SESSION['message'] ?>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>

    <h1 class="mb-4">Таблица оборудования</h1>
    
    <div class="mb-4">
        <a href="add_equipment.php" class="btn btn-success">Добавить новое оборудование</a>
    </div>

    <div class="table-responsive">
        <table id="equipmentTable" class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Раздел</th>
                    <th>Тип</th>
                    <th>Инв. №</th>
                    <th>Сер. №</th>
                    <th>Марка</th>
                    <th>Модель</th>
                    <th>Подразделение</th>
                    <th>Аудитория</th>
                    <th>Рабочее место</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['equipment_id']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= htmlspecialchars($row['type']) ?></td>
                            <td><?= htmlspecialchars($row['inventory_number']) ?></td>
                            <td><?= htmlspecialchars($row['serial_number']) ?></td>
                            <td><?= htmlspecialchars($row['manufacture']) ?></td>
                            <td><?= htmlspecialchars($row['model']) ?></td>
                            <td><?= htmlspecialchars($row['location_department']) ?></td>
                            <td><?= htmlspecialchars($row['location_audience']) ?></td>
                            <td><?= htmlspecialchars($row['location_workplace']) ?></td>
                           <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="view_equipment.php?id=<?= $row['equipment_id'] ?>" class="btn btn-info btn-sm mr-2" title="Просмотр">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="edit_equipment.php?id=<?= $row['equipment_id'] ?>" class="btn btn-warning btn-sm mr-2" title="Редактировать">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="delete_equipment.php?id=<?= $row['equipment_id'] ?>" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить это оборудование?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Нет данных об оборудовании</td>
                    </tr>
                <?php endif; ?>
 </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

</body>
</html>

<?php mysqli_close($link); ?>