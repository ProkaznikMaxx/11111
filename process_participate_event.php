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

    if (isset($_POST["manage_participation"])) {
        $eventId = $_POST["event_participation"];
        $studentId = $_POST["student_participation"];
        $action = $_POST["participation_action"];

        // Проверка, выбрано ли мероприятие и студент
        if (empty($eventId) || empty($studentId)) {
            $resultMessage = "Выберите мероприятие и студента.";
            $alertClass = "alert-danger";
        }

        // Проверка, выбрано ли действие
        elseif (empty($action)) {
            $resultMessage = "Выберите действие.";
            $alertClass = "alert-danger";
        } else {
            // Проверка, участвует ли студент уже в этом мероприятии
            $checkParticipationQuery = "SELECT * FROM eventparticipation WHERE event_id = ? AND student_id = ?";
            $checkParticipationStmt = $conn->prepare($checkParticipationQuery);
            $checkParticipationStmt->bind_param("ii", $eventId, $studentId);
            $checkParticipationStmt->execute();
            $checkParticipationResult = $checkParticipationStmt->get_result();

            if ($checkParticipationResult->num_rows > 0 && $action === "add") {
                $resultMessage = "Студент уже участвует в выбранном мероприятии.";
                $alertClass = "alert-warning";
            } elseif ($checkParticipationResult->num_rows === 0 && $action === "cancel") {
                $resultMessage = "Студент не участвует в выбранном мероприятии.";
                $alertClass = "alert-warning";
            } else {
                // Выполнение действия
                if ($action === "add") {
                    // Записи нет, выполнение вставки
                    $insertParticipationQuery = "INSERT INTO eventparticipation (event_id, student_id) VALUES (?, ?)";
                    $insertParticipationStmt = $conn->prepare($insertParticipationQuery);
                    $insertParticipationStmt->bind_param("ii", $eventId, $studentId);
                    $insertParticipationStmt->execute();

                    $resultMessage = "Участие студента успешно добавлено.";
                    $alertClass = "alert-success";
                } elseif ($action === "cancel") {
                    // Выполнение отмены
                    $deleteParticipationQuery = "DELETE FROM eventparticipation WHERE event_id = ? AND student_id = ?";
                    $deleteParticipationStmt = $conn->prepare($deleteParticipationQuery);
                    $deleteParticipationStmt->bind_param("ii", $eventId, $studentId);
                    $deleteParticipationStmt->execute();

                    $resultMessage = "Участие студента успешно отменено.";
                    $alertClass = "alert-success";
                }
            }
        }
    }

    // Закрываем соединение
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
