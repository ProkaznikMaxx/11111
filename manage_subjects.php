<!-- manage_subjects.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление предметами</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* Стили для уведомления с иконкой */
        .alert-with-icon {
            display: flex;
            align-items: center;
        }

        .alert-icon {
            margin-right: 10px;
        }
    </style>
</head>
<body class="bg-light">

    <div class="d-flex justify-content-start mb-4" style="margin-left: 15px; margin-top: 15px;">
        <a href="edit.php" class="btn btn-primary">Назад</a>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Управление предметами</h2>

        <!-- Форма для добавления предмета -->
        <form method="post" action="process_subjects.php">
            <div class="mb-3">
                <label for="subjectNameAdd" class="form-label">Название предмета для добавления</label>
                <input type="text" class="form-control" id="subjectNameAdd" name="subjectNameAdd" required>
            </div>

            <button type="submit" class="btn btn-primary">Добавить предмет</button>
        </form>

        <hr>

        <!-- Форма для удаления предмета -->
        <form method="post" action="process_subjects.php" onsubmit="return validateDeleteForm()">
            <div class="mb-3">
                <label for="subjectIdDelete" class="form-label">Выберите предмет для удаления</label>
                <select class="form-select" id="subjectIdDelete" name="subjectIdDelete" required>
                    <!-- Добавлено по умолчанию выбранное поле, но неактивное (disabled) -->
                    <option value='' disabled selected>Выберите предмет</option>
                    <?php
                    // Подключение к базе данных
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "111";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Ошибка подключения: " . $conn->connect_error);
                    }

                    // Запрос для получения списка предметов
                    $subjectsQuery = "SELECT * FROM subjects";
                    $subjectsResult = $conn->query($subjectsQuery);
                    
                    // Заполнение выпадающего списка предметов
                    while ($subject = $subjectsResult->fetch_assoc()) {
                        echo "<option value='" . $subject['subject_id'] . "'>" . $subject['SubjectName'] . "</option>";
                    }

                    // Закрытие соединения
                    $conn->close();
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-danger">Удалить предмет</button>
        </form>

        <!-- Блок с уведомлением -->
        <?php
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
            $alertType = isset($_GET['success']) ? 'success' : 'danger';
            $alertIcon = isset($_GET['success']) ? 'check' : 'exclamation';
            echo "<div class='alert alert-$alertType alert-dismissible fade show alert-with-icon' role='alert'>
                    <i class='bi bi-$alertIcon-circle-fill alert-icon'></i>
                    $message
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>

    </div>

    <script>
        // Функция для валидации формы удаления предмета
        function validateDeleteForm() {
            var subjectSelected = $("#subjectIdDelete").val() !== '';

            if (!subjectSelected) {
                alert("Пожалуйста, выберите предмет для удаления.");
                return false;
            }

            return true;
        }
    </script>


    
    <!-- Bootstrap JS (Popper.js и Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
