<?php
$resultMessage = '';
$alertClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $middlename = $_POST["middlename"];
    $groupId = $_POST["group"]; // Используем group_id, предположим, что так назван элемент в форме.

    // Подключение к базе данных
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "111";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Проверка наличия студента с таким ФИО
    $checkQuery = "SELECT * FROM students WHERE Surname = '$surname' AND Name = '$name' AND Middlename = '$middlename'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Студент с таким ФИО уже существует
        $resultMessage = "Студент с таким ФИО уже существует.";
        $alertClass = "alert-warning";
    } else {
        // Запрос для добавления студента без указания student_id
        $addQuery = "INSERT INTO students (Surname, Name, Middlename, group_id) VALUES ('$surname', '$name', '$middlename', '$groupId')";
        $addResult = $conn->query($addQuery);

        if ($addResult === TRUE) {
            $resultMessage = "Студент успешно добавлен.";
            $alertClass = "alert-success";
        } else {
            $resultMessage = "Ошибка при добавлении студента: " . $conn->error;
            $alertClass = "alert-danger";
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
            <a href="add_delete_student.php" class="btn btn-primary btn-block mt-3">Ок</a>
        </div>
    </div>
</div>

</body>
</html>
