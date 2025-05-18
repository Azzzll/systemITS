<!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="dataTable">
        <?php
        if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3) {
            // Получаем список исполнителей (users с role_id = 2)
            $executors_query = $db->prepare("SELECT user_id, first_name, surname, last_name FROM users WHERE role_id = 2");
            $executors_query->execute();
            $executors = $executors_query->get_result()->fetch_all(MYSQLI_ASSOC);
            
            // Обработка назначения исполнителя
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_executor'])) {
                $request_id = intval($_POST['request_id']);
                $executor_id = intval($_POST['executor_id']);
                
                $update_stmt = $db->prepare("UPDATE requests SET executor = ? WHERE request_id = ?");
                $update_stmt->bind_param("ii", $executor_id, $request_id);
                $update_stmt->execute();
                header("Location: ./main.php");
            }
            
            // Выбираем заявки в зависимости от роли
            if ($_SESSION['role_id'] == 3) {
                // Администратор - все заявки
                $stmt = $db->prepare("SELECT request_id, user_id, topic, priority, executor, status, created_at FROM requests");
            } elseif ($_SESSION['role_id'] == 2) {
                // Исполнитель - назначенные ему заявки
                $stmt = $db->prepare("SELECT request_id, user_id, topic, priority, executor, status, created_at FROM requests WHERE executor = ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
            } else {
                // Обычный пользователь - только свои заявки
                $stmt = $db->prepare("SELECT request_id, user_id, topic, priority, executor, status, created_at FROM requests WHERE user_id = ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                echo '<style>
                    .requests-table tr:hover {
                        cursor: pointer;
                    }
                </style>';
                
                // Модальное окно с добавлением селектора исполнителей
                
                echo '
                <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="requestModalLabel">Просмотр заявки</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Форма просмотра заявки -->
                    <form id="requestForm" method="POST">
                        <div class="form-section">
                            <h2 class="text-center mb-3">Просмотр заявки</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="request_id" class="form-label">ID</label>
                                        <input type="text" id="request_id" name="request_id" class="form-control" style="background-color: rgb(233, 236, 239);">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestAuditorium" class="form-label">Аудитория</label>
                                        <input type="text" id="requestAuditorium" disabled="" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestApplicant" class="form-label">ФИО</label>
                                        <input type="text" id="requestApplicant" disabled="" class="form-control" >
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestExecutor" class="form-label">Исполнитель</label>
                                                    <select id="requestExecutor" name="executor_id" class="form-control" required>
                                                        <option value="">Выберите исполнителя</option>';
                
                foreach ($executors as $executor) {
                    $last_name = htmlspecialchars($executor['last_name']);
                    $first_name = htmlspecialchars($executor['first_name']);
                    $surname = htmlspecialchars($executor['surname']);
                    $user_id = htmlspecialchars($executor['user_id']);
                    echo "<option value='{$user_id}'>{$last_name} {$first_name} {$surname}</option>";
                }
                
                echo '                              </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="requestTopic" class="form-label">Тема</label>
                                        <input type="text" id="requestTopic" disabled="" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestStatus" class="form-label">Статус</label>
                                        <input type="text" id="requestStatus" disabled="" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestDate" class="form-label">Дата</label>
                                        <input type="text" id="requestDate" disabled="" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestPriority" class="form-label">Важность</label>
                                        <input type="text" id="requestPriority" disabled="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="requestDescription" class="form-label">Описание</label>
                                <textarea id="requestDescription" disabled="" class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="requestComment" class="form-label">Комментарий</label>
                                <textarea id="requestComment" placeholder="Комментарий" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="v-line"></div>
                        <div class="form-section">
                            <div class="action-table">
                                <button type="submit" name="assign_executor" class="btn btn-primary btn-lg">Назначить</button>
                                <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Действие</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Принять</a></li>
                                    <li><a class="dropdown-item" href="#">Решена</a></li>
                                    <li><a class="dropdown-item" href="#">Отклонить</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
                    </div>
                </div>';
                
                
                echo '<table class="table table-bordered table-striped requests-table">';
                echo '<thead><tr>';
                echo '<th>ID</th>';
                echo '<th>Тема</th>';
                echo '<th>Дата создания</th>';
                echo '<th>Статус</th>';
                echo '<th>Исполнитель</th>';
                echo '</tr></thead>';
                echo '<tbody>';
                
                while ($row = $result->fetch_assoc()) {
                    echo '<tr data-bs-toggle="modal" data-bs-target="#requestModal" 
                            data-request_id="' . htmlspecialchars($row['request_id']) . '"
                            data-topic="' . htmlspecialchars($row['topic']) . '"
                            data-createdat="' . htmlspecialchars($row['created_at']) . '"
                            data-status="' . htmlspecialchars($row['status']) . '"
                            data-priority="' . htmlspecialchars($row['priority']) . '"
                            data-executor="' . htmlspecialchars($row['executor']) . '"
                            style="cursor: pointer;">';
                    echo '<td>' . htmlspecialchars($row['request_id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['topic']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                    // Находим ФИО исполнителя
                    $executor_name = '';
                    foreach ($executors as $executor) {
                        if ($executor['user_id'] == $row['executor']) {
                            $executor_name = htmlspecialchars($executor['last_name']) . ' ' . 
                                            htmlspecialchars($executor['first_name']) . ' ' . 
                                            htmlspecialchars($executor['surname']);
                            break;
                        }
                    }
                echo '<td>' . ($executor_name ?: 'Не назначен') . '</td>';

                    echo '</tr>';
                }
                
                echo '</tbody></table>';
                
                // JavaScript для заполнения модального окна
                echo '
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const modal = document.getElementById("requestModal");
                    if (modal) {
                        modal.addEventListener("show.bs.modal", function(event) {
                            const button = event.relatedTarget;
                            document.getElementById("request_id").value = button.getAttribute("data-request_id");
                            document.getElementById("requestTopic").value = button.getAttribute("data-topic");
                            document.getElementById("requestDate").value = button.getAttribute("data-createdat");
                            document.getElementById("requestStatus").value = button.getAttribute("data-status");
                            // Уже есть правильное значение в data-атрибуте
                            const executorId = button.getAttribute("data-executor");
                            if (executorId) {
                                document.getElementById("requestExecutor").value = executorId;
                            }
                        });
                    }
                });
                </script>';
            }
        }
        ?>
    </table>
</div>