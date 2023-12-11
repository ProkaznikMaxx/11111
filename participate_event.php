<!-- participate_event.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Участие в мероприятиях</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

   

    <div class="container mt-5">
        <h2 class="text-center mb-4">Участие в мероприятиях</h2>

        <!-- Форма для участия в мероприятии -->
        <form method="post" action="process_participate_event.php">
            <h3 class="mb-3">Участие в мероприятии</h3>
            <div class="mb-3">
                <label for="eventparticipation">Выберите мероприятие</label>
                <select class="form-select" id="eventparticipation" name="eventparticipation" required>
                    <?php
                    // Вывод запроса для отладки
                    echo "Запрос для мероприятий: $eventsQuery";

                    // Запрос для получения списка мероприятий
                    $eventsQuery = "SELECT * FROM events"; // Ваш текущий запрос

                    // Вывод запроса для отладки
                    echo "Запрос для мероприятий: $eventsQuery";

                    // Запрос для получения списка мероприятий
                    $eventsResult = $conn->query($eventsQuery);

                    // Проверяем, есть ли ошибки в запросе
                    if (!$eventsResult) {
                        die("Ошибка в запросе для мероприятий: " . $conn->error);
                    }

                    // Заполнение выпадающего списка мероприятий
                    while ($event = $eventsResult->fetch_assoc()) {
                        echo "<option value='" . $event['event_id'] . "'>" . $event['EventName'] . " (" . $event['EventDate'] . ")</option>";
                    }

                    // Запрос для получения списка мероприятий
                    $eventsResult = $conn->query($eventsQuery);

                    // Проверяем, есть ли ошибки в запросе
                    if (!$eventsResult) {
                        die("Ошибка в запросе для мероприятий: " . $conn->error);
                    }

                    // Заполнение выпадающего списка мероприятий
                    while ($event = $eventsResult->fetch_assoc()) {
                        echo "<option value='" . $event['event_id'] . "'>" . $event['EventName'] . " (" . $event['EventDate'] . ")</option>";
                    }

                    // Запрос для получения списка мероприятий
                    $eventsResult = $conn->query($eventsQuery);

                    // Проверяем, есть ли ошибки в запросе
                    if (!$eventsResult) {
                        die("Ошибка в запросе для мероприятий: " . $conn->error);
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
                    <?php
                    // Запрос для получения списка студентов
                    $studentsResult = $conn->query($studentsQuery);

                    // Проверяем, есть ли ошибки в запросе
                    if (!$studentsResult) {
                        die("Ошибка в запросе для студентов: " . $conn->error);
                    }

                    // Заполнение выпадающего списка студентов
                    while ($student = $studentsResult->fetch_assoc()) {
                        echo "<option value='" . $student['student_id'] . "'>" . $student['Surname'] . " " . $student['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="participate_event" class="btn btn-success">Принять участие</button>
        </form>

    </div>
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

<div class="container mt-5">
    <h2 class="text-center mb-4">Участие в мероприятиях</h2>

    <!-- Форма для участия в мероприятии -->
    <form method="post" action="process_participate_event.php">
        <h3 class="mb-3">Участие в мероприятии</h3>
        <div class="mb-3">
            <label for="event_participation">Выберите мероприятие</label>
            <select class="form-select" id="event_participation" name="event_participation" required>
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

        <button type="submit" name="participate_event" class="btn btn-success">Принять участие</button>
    </form>
</div>
</body>
</html>
