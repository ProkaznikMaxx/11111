<!-- add_delete_event.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление и удаление мероприятия</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="d-flex justify-content-start mb-4" style="margin-left: 15px; margin-top: 15px;">
        <a href="edit.php" class="btn btn-primary">Назад</a>
    </div>

    <div class="container mt-0">
        <h2 class="text-center mb-4">Добавление и удаление мероприятия</h2>

        <!-- Форма для добавления мероприятия -->
        <form method="post" action="process_add_delete_event.php">
            <h3 class="mb-3">Добавление мероприятия</h3>
            <div class="mb-3">
                <label for="eventname">Название мероприятия</label>
                <input type="text" class="form-control" id="eventname" name="eventname" required>
            </div>      
            <div class="mb-3">
                <label for="eventdate">Дата мероприятия</label>
                <input type="date" class="form-control" id="eventdate" name="eventdate" required>
            </div>
            <button type="submit" name="add_event" class="btn btn-success">Добавить мероприятие</button>
        </form>

        <hr>

        <!-- Форма для удаления мероприятия -->
        <form method="post" action="process_add_delete_event.php">
            <h3 class="mb-3">Удаление мероприятия</h3>
            <div class="mb-3">
                <label for="event">Выберите мероприятие для удаления</label>
                <select class="form-select" id="event" name="event" required>
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

                    // Запрос для получения списка мероприятий
                    $eventsQuery = "SELECT * FROM events";
                    $eventsResult = $conn->query($eventsQuery);

                    // Заполнение выпадающего списка мероприятий
                    while ($event = $eventsResult->fetch_assoc()) {
                        echo "<option value='" . $event['event_id'] . "'>" . $event['event_id'] . " - " . $event['EventName'] . " (" . $event['EventDate'] . ")</option>";
                    }

                    // Закрытие соединения
                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" name="delete_event" class="btn btn-danger">Удалить мероприятие</button>
        </form>
    </div>

       <?php
    // ... (ваш существующий код)

    // Подключение к базе данных (поместите этот код в начало файла, если его еще нет)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }
    ?>

    <!-- Ваш существующий код в manage_subjects.php -->

    <!-- Добавьте следующий код после вашего существующего кода в manage_subjects.php -->

    <!-- Форма для участия и отмены участия в мероприятии -->
    <div class="container mt-5">
    <h2 class="text-center mb-4">Участие в мероприятиях</h2>

    <!-- Форма для участия и отмены участия в мероприятии -->
    <form method="post" action="process_participate_event.php">
        <h3 class="mb-3">Участие в мероприятии</h3>
        <div class="mb-3">
            <label for="event_participation">Выберите мероприятие</label>
            <select class="form-select" id="event_participation" name="event_participation" required>
                <option value="" selected disabled>Выберите мероприятие...</option>
                <?php
                // Запрос для получения списка мероприятий
                $eventsQuery = "SELECT * FROM events";
                $eventsResult = $conn->query($eventsQuery);

                // Проверяем, есть ли ошибки в запросе
                if (!$eventsResult) {
                    die("Ошибка в запросе: " . $conn->error);
                }

                // Заполнение выпадающего списка мероприятий
                while ($event = $eventsResult->fetch_assoc()) {
                    echo "<option value='" . $event['event_id'] . "'>" . $event['EventName'] . " (" . $event['EventDate'] . ")</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="student_participation">Выберите студента</label>
            <select class="form-select" id="student_participation" name="student_participation" required>
                <option value="" selected disabled>Выберите студента...</option>
                <?php
                // Запрос для получения списка студентов
                $studentsQuery = "SELECT * FROM students";
                $studentsResult = $conn->query($studentsQuery);

                // Проверяем, есть ли ошибки в запросе
                if (!$studentsResult) {
                    die("Ошибка в запросе: " . $conn->error);
                }

                // Заполнение выпадающего списка студентов
                while ($student = $studentsResult->fetch_assoc()) {
                    echo "<option value='" . $student['student_id'] . "'>" . $student['Surname'] . " " . $student['Name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="participation_action">Выберите действие</label>
            <select class="form-select" id="participation_action" name="participation_action" required>
                <option value="" selected disabled>Выберите действие...</option>
                <option value="add">Принять участие</option>
                <option value="cancel">Отменить участие</option>
            </select>
        </div>

        <button type="submit" name="manage_participation" class="btn btn-success">Выполнить действие</button>
    </form>
</div>
</body>
</html>
