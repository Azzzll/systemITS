<?php
session_start();
include 'db_equipment.php';

// Обработка добавления категории или типа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['action'])) {
        $name = trim($_POST['name']);
        $action = $_POST['action'];

        // Проверка на пустое значение
        if (empty($name)) {
            $_SESSION['error'] = 'Пожалуйста, заполните поле';
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }

        $name = mysqli_real_escape_string($link, $name);

        if ($action === 'add_category') {
            // Проверяем, не существует ли уже такой категории
            $check = mysqli_query($link, "SELECT category_id FROM equipment_category WHERE name = '$name'");
            if (mysqli_num_rows($check) > 0) {
                $row = mysqli_fetch_assoc($check);
                $_SESSION['message'] = 'Категория уже существует';
                $_SESSION['message_type'] = 'info';
            } else {
                // Добавляем новую категорию
                if (mysqli_query($link, "INSERT INTO equipment_category (name) VALUES ('$name')")) {
                    $_SESSION['message'] = 'Категория успешно добавлена';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['error'] = 'Ошибка при добавлении категории: ' . mysqli_error($link);
                }
            }
        } 
        elseif ($action === 'add_type') {
            // Проверяем, не существует ли уже такого типа
            $check = mysqli_query($link, "SELECT type_id FROM equipment_type WHERE name = '$name'");
            if (mysqli_num_rows($check) > 0) {
                $row = mysqli_fetch_assoc($check);
                $_SESSION['message'] = 'Тип уже существует';
                $_SESSION['message_type'] = 'info';
            } else {
                // Добавляем новый тип
                if (mysqli_query($link, "INSERT INTO equipment_type (name) VALUES ('$name')")) {
                    $_SESSION['message'] = 'Тип успешно добавлен';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['error'] = 'Ошибка при добавлении типа: ' . mysqli_error($link);
                }
            }
        }
        
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Добавление оборудования</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .alert-message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .is-invalid {
            border-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Добавление новых категорий и типов</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show alert-message" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show alert-message" role="alert">
                <?php echo $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Добавить новую категорию</h5>
                <form method="post" id="categoryForm" onsubmit="return validateForm(this)">
                    <div class="input-group mb-3">
                        <input type="text" name="name" id="new_category" placeholder="Введите название категории" class="form-control" required>
                        <input type="hidden" name="action" value="add_category">
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                    <div class="invalid-feedback" id="categoryError" style="display: none;">Пожалуйста, заполните поле</div>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Добавить новый тип</h5>
                <form method="post" id="typeForm" onsubmit="return validateForm(this)">
                    <div class="input-group mb-3">
                        <input type="text" name="name" id="new_type" placeholder="Введите название типа" class="form-control" required>
                        <input type="hidden" name="action" value="add_type">
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                    <div class="invalid-feedback" id="typeError" style="display: none;">Пожалуйста, заполните поле</div>
                </form>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="add_equipment.php" class="btn btn-secondary">Назад</a>
        </div>
    </div>

    <script>
        // Валидация формы перед отправкой
        function validateForm(form) {
            const input = form.querySelector('input[type="text"]');
            const errorId = form.id === 'categoryForm' ? 'categoryError' : 'typeError';
            const errorElement = document.getElementById(errorId);
            
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                errorElement.style.display = 'block';
                
                // Показываем сообщение вверху страницы
                showAlert('Пожалуйста, заполните поле', false);
                return false;
            }
            
            input.classList.remove('is-invalid');
            errorElement.style.display = 'none';
            return true;
        }
        
        // Функция для показа сообщения
        function showAlert(message, isSuccess) {
            const alert = $('<div class="alert alert-' + (isSuccess ? 'success' : 'danger') + 
                         ' alert-dismissible fade show alert-message" role="alert">' +
                         message +
                         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                         '</div>');
            
            $('.container').prepend(alert);
            
            setTimeout(() => {
                alert.alert('close');
            }, 5000);
        }
        
        // Автоматическое скрытие сообщений через 5 секунд
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Удаляем класс ошибки при вводе текста
            $('input[type="text"]').on('input', function() {
                if ($(this).val().trim()) {
                    $(this).removeClass('is-invalid');
                    $(this).nextAll('.invalid-feedback').hide();
                }
            });
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
if (isset($link)) {
    mysqli_close($link); 
}
?>