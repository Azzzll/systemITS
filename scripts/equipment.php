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
            l.workplace AS location_workplace,
            es.status_name AS status,
            e.receipt_date
          FROM equipment e
          LEFT JOIN equipment_category ec ON e.category_id = ec.category_id
          LEFT JOIN equipment_type et ON e.type_id = et.type_id
          LEFT JOIN location l ON e.location_id = l.location_id
          LEFT JOIN equipment_status es ON e.status_id = es.status_id
          WHERE e.status_id != 3
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
    <link href="/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        .status-in-use { color: #28a745; font-weight: bold; }
        .status-in-repair { color: #ffc107; font-weight: bold; }
        .dropdown-menu-right { right: 0; left: auto; }
        .alert-message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        #equipmentTable {
            width: 100% !important;
            table-layout: auto;
        }
        #equipmentTable th, #equipmentTable td {
            white-space: nowrap;
        }
        /* Узкие столбцы */
        .col-id { width: 50px; }
        .col-department { width: 120px; }
        .container {
            max-width: 95%;
            padding: 15px;
        }
        .dataTables_wrapper .dataTables_filter {
            float: right;
        }
        .dataTables_wrapper .dataTables_length {
            float: left;
        }
        .dataTables_wrapper .dataTables_info {
            float: left;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right;
        }
        .badge-status {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Логотип и кнопка слева -->
            <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="/img/TAom.png" alt="Логотип ТАУ" width="40" height="40" class="d-inline-block align-text-top">
            </a>
            <a class="btn btn-outline-light me-3" href="https://taom.academy" target="_blank">Официальный сайт ТАУ</a>

            <!-- Кнопка для мобильных устройств (раскрытие меню) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Навигация и кнопка "Выйти" справа -->
            <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto"> <!-- добавляем ms-auto, чтобы сдвинуть навигацию вправо -->
                <li class="nav-item">
                <a class="nav-link" href="main.php">Заявки</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="FAQ.php">База знаний</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#create-request" data-bs-toggle="collapse" data-bs-target="#requestForm">Создать обращение</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="equipment.php">Оборудование</a>
                </li>
            </ul>
            <div class="d-flex ms-3"> <!-- добавляем отступ, чтобы отделить кнопку "Выйти" -->
                <a href="autorization.php?logout=1" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите выйти?')">
                Выйти
                </a>
            </div>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show alert-message" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <h1 class="mb-4">Таблица оборудования</h1>
        
        <div class="mb-4">
            <a href="add_equipment.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Добавить новое оборудование
            </a>
            <a href="reports.php" class="btn btn-info ml-2">
                <i class="bi bi-file-earmark-text"></i> Отчеты
            </a>
        </div>

        <div class="table-responsive">
            <table id="equipmentTable" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="col-id">ID</th>
                        <th>Раздел</th>
                        <th>Тип</th>
                        <th>Инв. №</th>
                        <th>Сер. №</th>
                        <th>Марка</th>
                        <th>Модель</th>
                        <th class="col-department">Подразделение</th>
                        <th>Аудитория</th>
                        <th>Рабочее место</th>
                        <th>Статус</th>
                        <th>Дата поступления</th>
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
                                <td><?= htmlspecialchars($row['location_department'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['location_audience'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['location_workplace'] ?? '') ?></td>
                                <td>
                                    <span class="badge badge-status 
                                        <?= $row['status'] == 'В эксплуатации' ? 'badge-success' : 
                                        ($row['status'] == 'На ремонте' ? 'badge-warning' : 'badge-danger') ?>">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($row['receipt_date']) ?></td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group" role="group">
                                            <a href="view_equipment.php?id=<?= $row['equipment_id'] ?>" 
                                            class="btn btn-info btn-sm" title="Просмотр">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="edit_equipment.php?id=<?= $row['equipment_id'] ?>" 
                                            class="btn btn-warning btn-sm" title="Редактировать">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" 
                                                        id="dropdownMenuButton" data-toggle="dropdown" 
                                                        aria-haspopup="true" aria-expanded="false">
                                                    <i class="bi bi-gear"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" 
                                                    data-target="#moveModal" data-id="<?= $row['equipment_id'] ?>" 
                                                    data-department="<?= htmlspecialchars($row['location_department'] ?? '') ?>" 
                                                    data-audience="<?= htmlspecialchars($row['location_audience'] ?? '') ?>" 
                                                    data-workplace="<?= htmlspecialchars($row['location_workplace'] ?? '') ?>">
                                                        <i class="bi bi-arrow-left-right"></i> Переместить
                                                    </a>
                                                    <?php if ($row['status'] == 'В эксплуатации'): ?>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" 
                                                        data-target="#repairModal" data-id="<?= $row['equipment_id'] ?>">
                                                            <i class="bi bi-tools"></i> Отправить в ремонт
                                                        </a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" 
                                                        data-target="#writeoffModal" data-id="<?= $row['equipment_id'] ?>" 
                                                        data-name="<?= htmlspecialchars($row['manufacture']).' '.htmlspecialchars($row['model']) ?>">
                                                            <i class="bi bi-trash"></i> Списать
                                                        </a>
                                                    <?php elseif ($row['status'] == 'На ремонте'): ?>
                                                        <a class="dropdown-item return-from-repair" href="#" 
                                                        data-toggle="modal" data-target="#completeRepairModal"
                                                        data-id="<?= $row['equipment_id'] ?>">
                                                            <i class="bi bi-arrow-return-left"></i> Вернуть с ремонта
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="13" class="text-center">Нет данных об оборудовании</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mb-4">
            <a href="./main.php" class="btn btn-secondary mt-4 ml-4">
                Назад
            </a>
        </div>
    </div>

    <!-- Модальное окно перемещения -->
    <div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="moveModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="moveModalLabel">Перемещение оборудования</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="moveForm" method="post">
                    <input type="hidden" name="action" value="move">
                    <input type="hidden" name="equipment_id" id="moveEquipmentId">
                    <div class="modal-body">
                        <h5>Текущее местоположение</h5>
                        <div class="form-group">
                            <label>Подразделение</label>
                            <input type="text" class="form-control" id="currentDepartment" readonly>
                        </div>
                        <div class="form-group">
                            <label>Аудитория</label>
                            <input type="text" class="form-control" id="currentAudience" readonly>
                        </div>
                        <div class="form-group">
                            <label>Рабочее место</label>
                            <input type="text" class="form-control" id="currentWorkplace" readonly>
                        </div>

                        <h5 class="mt-4">Новое местоположение</h5>
                        <div class="form-group">
                            <label for="newDepartment">Подразделение <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="newDepartment" name="new_department" required>
                        </div>
                        <div class="form-group">
                            <label for="newAudience">Аудитория</label>
                            <input type="text" class="form-control" id="newAudience" name="new_audience">
                        </div>
                        <div class="form-group">
                            <label for="newWorkplace">Рабочее место</label>
                            <input type="text" class="form-control" id="newWorkplace" name="new_workplace">
                        </div>
                        <div class="form-group">
                            <label for="moveDate">Дата перемещения <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="moveDate" name="move_date" required>
                        </div>
                        <div class="form-group">
                            <label for="moveNotes">Примечания</label>
                            <textarea class="form-control" id="moveNotes" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Переместить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Модальное окно ремонта -->
    <div class="modal fade" id="repairModal" tabindex="-1" role="dialog" aria-labelledby="repairModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="repairModalLabel">Заявка на ремонт</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="repairForm" method="post">
                    <input type="hidden" name="action" value="repair">
                    <input type="hidden" name="equipment_id" id="repairEquipmentId">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="problemDescription">Описание проблемы <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="problemDescription" name="problem_description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="repairStartDate">Дата начала ремонта <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="repairStartDate" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="expectedEndDate">Прогнозируемая дата окончания</label>
                            <input type="date" class="form-control" id="expectedEndDate" name="expected_end_date">
                        </div>
                        <div class="form-group">
                            <label for="repairLocation">Место ремонта</label>
                            <input type="text" class="form-control" id="repairLocation" name="repair_location">
                        </div>
                        <div class="form-group">
                            <label for="repairNotes">Примечания</label>
                            <textarea class="form-control" id="repairNotes" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Отправить в ремонт</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Модальное окно списания -->
    <div class="modal fade" id="writeoffModal" tabindex="-1" role="dialog" aria-labelledby="writeoffModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="writeoffModalLabel">Списание оборудования</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="writeoffForm" method="post">
                    <input type="hidden" name="action" value="writeoff">
                    <input type="hidden" name="equipment_id" id="writeoffEquipmentId">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="equipmentName">Оборудование</label>
                            <input type="text" class="form-control" id="equipmentName" readonly>
                        </div>
                        <div class="form-group">
                            <label for="writeoffDate">Дата списания <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="writeoffDate" name="writeoff_date" required>
                        </div>
                        <div class="form-group">
                            <label for="writeoffReason">Причина списания <span class="text-danger">*</span></label>
                            <select class="form-control" id="writeoffReason" name="reason" required>
                                <option value="износ">Износ</option>
                                <option value="поломка">Поломка</option>
                                <option value="моральное устаревание">Моральное устаревание</option>
                                <option value="другое">Другое</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="writeoffNotes">Примечания</label>
                            <textarea class="form-control" id="writeoffNotes" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-danger">Списать оборудование</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Модальное окно завершения ремонта -->
    <div class="modal fade" id="completeRepairModal" tabindex="-1" role="dialog" aria-labelledby="completeRepairModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="completeRepairModalLabel">Завершение ремонта</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="completeRepairForm" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="complete_repair">
                        <input type="hidden" name="equipment_id" id="completeRepairEquipmentId">
                        <input type="hidden" name="repair_id" id="completeRepairId">
                        
                        <div class="form-group">
                            <label for="repairEndDate">Дата возврата в эксплуатацию <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="repairEndDate" name="end_date" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="repairActions">Выполненные работы <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="repairActions" name="actions" rows="3" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="repairParts">Использованные запчасти</label>
                            <textarea class="form-control" id="repairParts" name="parts" rows="2"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="repairNotes">Примечания</label>
                            <textarea class="form-control" id="repairNotes" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Завершить ремонт</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

    <script>
    $(document).ready(function() {
        // Инициализация DataTable
        $('#equipmentTable').DataTable({
            "scrollX": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Russian.json"
            },
            "dom": '<"top"lf>rt<"bottom"ip><"clear">',
            "pageLength": 25,
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": [12] }, // Отключаем сортировку для колонки с действиями
                { "width": "50px", "targets": [0] }, // Узкий столбец для ID
                { "width": "120px", "targets": [7] } // Узкий столбец для Подразделения
            ]
        });

        // Обработчик для модального окна перемещения
        $('#moveModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var equipmentId = button.data('id');
            var department = button.data('department');
            var audience = button.data('audience');
            var workplace = button.data('workplace');
            
            var modal = $(this);
            modal.find('#moveEquipmentId').val(equipmentId);
            modal.find('#currentDepartment').val(department || 'Не указано');
            modal.find('#currentAudience').val(audience || 'Не указано');
            modal.find('#currentWorkplace').val(workplace || 'Не указано');
            
            // Установка текущей даты по умолчанию
            var today = new Date().toISOString().split('T')[0];
            modal.find('#moveDate').val(today);
        });

        // Обработчик для модального окна ремонта
        $('#repairModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var equipmentId = button.data('id');
            
            var modal = $(this);
            modal.find('#repairEquipmentId').val(equipmentId);
            
            // Установка текущей даты по умолчанию
            var today = new Date().toISOString().split('T')[0];
            modal.find('#repairStartDate').val(today);
        });

        // Обработчик для модального окна списания
        $('#writeoffModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var equipmentId = button.data('id');
            var equipmentName = button.data('name');
            
            var modal = $(this);
            modal.find('#writeoffEquipmentId').val(equipmentId);
            modal.find('#equipmentName').val(equipmentName);
            
            // Установка текущей даты по умолчанию
            var today = new Date().toISOString().split('T')[0];
            modal.find('#writeoffDate').val(today);
        });

        // Обработчик для модального окна завершения ремонта
        $('#completeRepairModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var equipmentId = button.data('id');
            
            var modal = $(this);
            modal.find('#completeRepairEquipmentId').val(equipmentId);
            
            // Установка текущей даты по умолчанию
            var today = new Date().toISOString().split('T')[0];
            modal.find('#repairEndDate').val(today);
            
            // Получаем активный ремонт для оборудования
            $.post('equipment_actions.php', {
                action: 'get_active_repair',
                equipment_id: equipmentId
            }, function(response) {
                if (response.success) {
                    modal.find('#completeRepairId').val(response.repair_id);
                } else {
                    alert('Ошибка: ' + response.error);
                }
            }, 'json');
        });

        // Обработчик для формы перемещения
        $('#moveForm').submit(function(e) {
            e.preventDefault();
            $.post('equipment_actions.php', $(this).serialize(), function(response) {
                if (response.success) {
                    $('#moveModal').modal('hide');
                    showAlert(response.message, true);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert('Ошибка: ' + response.error);
                }
            }, 'json');
        });

        // Обработчик для формы ремонта
        $('#repairForm').submit(function(e) {
            e.preventDefault();
            $.post('equipment_actions.php', $(this).serialize(), function(response) {
                if (response.success) {
                    $('#repairModal').modal('hide');
                    showAlert(response.message, true);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert('Ошибка: ' + response.error);
                }
            }, 'json');
        });

        // Обработчик для формы завершения ремонта
        $('#completeRepairForm').submit(function(e) {
            e.preventDefault();
            $.post('equipment_actions.php', $(this).serialize(), function(response) {
                if (response.success) {
                    $('#completeRepairModal').modal('hide');
                    showAlert(response.message, true);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert('Ошибка: ' + response.error);
                }
            }, 'json');
        });

        // Обработчик для формы списания
        $('#writeoffForm').submit(function(e) {
            e.preventDefault();
            $.post('equipment_actions.php', $(this).serialize(), function(response) {
                if (response.success) {
                    $('#writeoffModal').modal('hide');
                    showAlert(response.message, true);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert('Ошибка: ' + response.error);
                }
            }, 'json');
        });

        // Функция для показа сообщения
        function showAlert(message, isSuccess) {
            const alert = $('<div class="alert alert-' + (isSuccess ? 'success' : 'danger') + 
                        ' alert-dismissible fade show alert-message" role="alert">' +
                        message +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>');
            
            $('.container').prepend(alert);
            
            setTimeout(() => {
                alert.alert('close');
            }, 5000);
        }
    });
    </script>
</body>
</html>
<?php mysqli_close($link); ?>