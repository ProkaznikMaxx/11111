<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ввод оценок</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body class="bg-light">

    <div class="d-flex justify-content-start mb-4" style="margin-left: 15px; margin-top: 15px;">
        <a href="edit.php" class="btn btn-primary">Назад</a>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Ввод оценок</h2>

        <!-- Форма для ввода оценок -->
        <form method="post" action="process_grades.php" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="student">Студент</label>
                <select class="form-select" id="student" name="student" required onchange="addPlaceholderOption(this, 'Выберите студента')">
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

                    // Запрос для получения списка студентов
                    $studentsQuery = "SELECT * FROM students";
                    $studentsResult = $conn->query($studentsQuery);

                    // Заполнение выпадающего списка студентов
                    echo "<option value='default' selected disabled>Выберите студента</option>";
                    while ($student = $studentsResult->fetch_assoc()) {
                        echo "<option value='" . $student['student_id'] . "'>" . $student['student_id'] . " - " . $student['Surname'] . " " . $student['Name'] . " " . $student['Middlename'] . "</option>";
                    }

                    // Закрытие соединения
                    $conn->close();
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="subject">Предмет</label>
                <select class="form-select" id="subject" name="subject" required onchange="addPlaceholderOption(this, 'Выберите предмет')">
                    <?php
                    // Подключение к базе данных
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Ошибка подключения: " . $conn->connect_error);
                    }

                    // Запрос для получения списка предметов
                    $subjectsQuery = "SELECT * FROM subjects";
                    $subjectsResult = $conn->query($subjectsQuery);

                    // Заполнение выпадающего списка предметов
                    echo "<option value='default' selected disabled>Выберите предмет</option>";
                    while ($subject = $subjectsResult->fetch_assoc()) {
                        echo "<option value='" . $subject['subject_id'] . "'>" . $subject['SubjectName'] . "</option>";
                    }

                    // Закрытие соединения
                    $conn->close();
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="grade">Оценка</label>
                <select class="form-select" id="grade" name="grade">
                    <option value="0" disabled selected>Выберите оценку</option>
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить оценку</button>
            
        </form>

    </div>

</body>
</html>