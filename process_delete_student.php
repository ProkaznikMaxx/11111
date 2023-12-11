<?php
$resultMessage = '';
$alertClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $studentId = $_POST["student"];

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Запрос для удаления студента
    $deleteQuery = "DELETE FROM students WHERE student_id = $studentId";
    $deleteResult = $conn->query($deleteQuery);

    if ($deleteResult === TRUE) {
        $resultMessage = "Студент успешно удален.";
        $alertClass = "alert-success";
    } else {
        $resultMessage = "Ошибка при удалении студента: " . $conn->error;
        $alertClass = "alert-danger";
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
            <a href="load_grades.php" class="btn btn-primary btn-block mt-3">Ок</a>
        </div>
    </div>
</div>

</body>
</html>
