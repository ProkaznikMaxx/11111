<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$resultMessage = '';
$alertClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    if (isset($_POST["add_event"])) {
        // Добавление мероприятия
        $eventName = $_POST["eventname"];
        $eventDate = $_POST["eventdate"];

        $addQuery = "INSERT INTO events (EventName, EventDate) VALUES ('$eventName', '$eventDate')";
        $addResult = $conn->query($addQuery);

        if ($addResult === TRUE) {
            $resultMessage = "Мероприятие успешно добавлено.";
            $alertClass = "alert-success";
        } else {
            $resultMessage = "Ошибка при добавлении мероприятия: " . $conn->error;
            $alertClass = "alert-danger";
        }
    } elseif (isset($_POST["delete_event"])) {
        // Удаление мероприятия
        $eventId = $_POST["event"];

        $deleteQuery = "DELETE FROM events WHERE event_id = $eventId";
        $deleteResult = $conn->query($deleteQuery);

        if ($deleteResult === TRUE) {
            $resultMessage = "Мероприятие успешно удалено.";
            $alertClass = "alert-success";
        } else {
            $resultMessage = "Ошибка при удалении мероприятия: " . $conn->error;
            $alertClass = "alert-danger";
        }
    } elseif (isset($_POST["participate_event"])) {
        // Участие в мероприятии
        $eventIdParticipation = $_POST["event_participation"];
        $studentsParticipation = isset($_POST["students_participation"]) ? $_POST["students_participation"] : [];

        foreach ($studentsParticipation as $studentIdParticipation) {
            $insertParticipationQuery = "INSERT INTO eventparticipation (event_id, student_id) VALUES ($eventIdParticipation, $studentIdParticipation)";
            $conn->query($insertParticipationQuery);
        }

        $resultMessage = "Участие в мероприятии успешно принято.";
        $alertClass = "alert-success";
    } elseif (isset($_POST["cancel_participation"])) {
        // Отмена участия в мероприятии
        $eventIdCancelParticipation = $_POST["event_cancel_participation"];
        $studentsCancelParticipation = isset($_POST["students_cancel_participation"]) ? $_POST["students_cancel_participation"] : [];

        foreach ($studentsCancelParticipation as $studentIdCancelParticipation) {
            $deleteParticipationQuery = "DELETE FROM eventparticipation WHERE event_id = $eventIdCancelParticipation AND student_id = $studentIdCancelParticipation";
            $conn->query($deleteParticipationQuery);
        }

        $resultMessage = "Отмена участия в мероприятии успешно выполнена.";
        $alertClass = "alert-success";
    }

    // Закрытие соединения
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Ваш заголовок страницы</title>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="alert <?php echo $alertClass; ?> text-center" role="alert">
                <?php echo $resultMessage; ?>
            </div>
            <a href="add_delete_event.php" class="btn btn-primary btn-block mt-3">Ок</a>
        </div>
    </div>
</div>

</body>
</html>
