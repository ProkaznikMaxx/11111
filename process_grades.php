<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";
$alertClass = "";

$checkStmt = null; // Добавлено предварительное определение
$conn = null; // Добавлено определение соединения

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы и подключение к базе данных
    $studentId = $_POST["student"];
    $subjectId = $_POST["subject"];
    $gradeValue = $_POST["grade"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Проверка, существует ли запись для данной комбинации student_id и subject_id
    $checkQuery = "SELECT * FROM grades WHERE student_id = ? AND subject_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ii", $studentId, $subjectId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Запись существует, обновляем оценку
        $updateQuery = "UPDATE grades SET AverageGrade = ? WHERE student_id = ? AND subject_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("dii", $gradeValue, $studentId, $subjectId);
        $updateResult = $updateStmt->execute();

        if ($updateResult === TRUE) {
            $message = "Оценка успешно обновлена.";
            $alertClass = "alert-success";
        } else {
            $message = "Ошибка при обновлении оценки: " . $updateStmt->error;
            $alertClass = "alert-danger";
        }

        // Закрываем соединение
        $updateStmt->close();
    } else {
        // Запись не существует, добавляем новую запись
        $insertQuery = "INSERT INTO grades (student_id, subject_id, AverageGrade) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("idd", $studentId, $subjectId, $gradeValue);
        $insertResult = $insertStmt->execute();

        if ($insertResult === TRUE) {
            $message = "Оценка успешно добавлена.";
            $alertClass = "alert-success";
        } else {
            $message = "Ошибка при добавлении оценки: " . $insertStmt->error;
            $alertClass = "alert-danger";
        }

        // Закрываем соединение
        $insertStmt->close();
    }

    // Закрываем соединение
    $checkStmt->close();
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
                <?php echo $message; ?>
            </div>
            <a href="load_grades.php" class="btn btn-primary btn-block mt-3">Ок</a>
        </div>
    </div>
</div>

</body>
</html>
