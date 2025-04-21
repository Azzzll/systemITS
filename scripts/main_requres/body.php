<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Основная страница</title>
    <link href="../bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style_mail.css">
    <link rel="stylesheet" href="../css/style_request.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <div class="parent-container">
        
        <button class="btn btn-link dropdown-toggle d-flex align-items-center text-dark text-decoration-none py-2"
                type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../img/icono.png" width="20" class="rounded-circle me-2">
            <span>
                <?php 
                echo($_SESSION['surname']); echo(' ');
                echo($_SESSION['first_name']); echo(' ');
                echo($_SESSION['last_name']);
                 ?>
            </span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <form id="loginForm" action="../scripts/main.php" method="POST">
            <li>            
                <button type="submit" style="border: 0; width: 100%; text-align: left; background-color:unset;">Выйти</button>
            </li>
            </form>
        </ul>
    </form>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 bg-light sidebar py-3">
                <div class="d-flex flex-column align-items-start">
                    <?php 
                    if ($_SESSION['role_id'] == '1' or $_SESSION['role_id'] == '2'){
                        echo '<a href="../scripts/request.php" class="btn btn-primary w-100 mb-2">Новая заявка</a>';
                    }
                    if ($_SESSION['role_id'] == '2'){
                        echo '<button class="btn btn-secondary w-100 mb-2">Неназначенные заявки</button>'; 
                    }
                    if ($_SESSION['role_id'] == '2' or $_SESSION['role_id'] == '1'){
                    echo '<button class="btn btn-secondary w-100 mb-2">Мои заявки</button>';
                    }
                    if ($_SESSION['role_id'] == '3'){
                        echo '<button class="btn btn-secondary w-100 mb-2">Назначить заявку</button>';
                    }
                    if ($_SESSION['role_id'] == '2' or $_SESSION['role_id'] == '3'){
                        echo '<button class="btn btn-secondary w-100 mb-2">Архив заявок</button>';
                        echo '<button class="btn btn-primary w-100 mb-2">База оборудования</button>';
                    }
                    ?>
                    <br><a href="../" class="btn btn-secondary">Назад</a>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 px-md-4">
                <?php
                require_once __DIR__ . './../funcs/authorisation_check.php';
                if (isUserAuthorized()){
                    require_once('table.php');
                    
                }
                ?>
            </main>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="requestModalLabel">Просмотр заявки</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Форма просмотра заявки -->
                    <form id="requestForm">
                        <div class="form-section">
                            <h2 class="text-center mb-3">Просмотр заявки</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="requestId" class="form-label">ID</label>
                                        <input type="text" id="requestId" disabled class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestAuditorium" class="form-label">Аудитория</label>
                                        <input type="text" id="requestAuditorium" disabled class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestApplicant" class="form-label">ФИО</label>
                                        <input type="text" id="requestApplicant" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="requestTopic" class="form-label">Тема</label>
                                        <input type="text" id="requestTopic" disabled class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestStatus" class="form-label">Статус</label>
                                        <input type="text" id="requestStatus" disabled class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestDate" class="form-label">Дата</label>
                                        <input type="text" id="requestDate" disabled class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="requestPriority" class="form-label">Важность</label>
                                        <input type="text" id="requestPriority" disabled class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="requestDescription" class="form-label">Описание</label>
                                <textarea id="requestDescription" disabled class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="requestComment" class="form-label">Комментарий</label>
                                <textarea id="requestComment" placeholder="Комментарий" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="v-line"></div>
                        <div class="form-section">
                            <div class="action-table">
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
        
    </div>
    
    <!-- Scripts -->
    <script src="../bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="../bootstrap/script.js"></script>
</body>
</html>