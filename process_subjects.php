<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "111";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$message = "";
$alertClass = "";

// Обработка добавления предмета
if (isset($_POST['subjectNameAdd'])) {
    $subjectName = $_POST['subjectNameAdd'];

    // Проверка, есть ли такой предмет в базе данных
    $checkQuery = "SELECT * FROM subjects WHERE SubjectName = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $subjectName);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Предмет уже существует
        $message = "Предмет с таким именем уже существует. Нельзя добавить повторно.";
        $alertClass = "alert-warning";
    } else {
        // Добавление предмета
        $insertQuery = "INSERT INTO subjects (SubjectName) VALUES (?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("s", $subjectName);

        if ($insertStmt->execute()) {
            $message = "Предмет успешно добавлен.";
            $alertClass = "alert-success";
        } else {
            $message = "Ошибка добавления предмета: " . $insertStmt->error;
            $alertClass = "alert-danger";
        }

        // Закрываем подготовленный запрос
        $insertStmt->close();
    }

    // Закрываем подготовленный запрос
    $checkStmt->close();
}

// Обработка удаления предмета
if (isset($_POST['subjectIdDelete'])) {
    $subjectId = $_POST['subjectIdDelete'];

    // Начнем транзакцию
    $conn->begin_transaction();

    try {
        // Удаление предмета
        $deleteSubjectQuery = "DELETE FROM subjects WHERE subject_id = ?";
        $deleteSubjectStmt = $conn->prepare($deleteSubjectQuery);
        $deleteSubjectStmt->bind_param("i", $subjectId);

        if (!$deleteSubjectStmt->execute()) {
            throw new Exception("Ошибка удаления предмета: " . $deleteSubjectStmt->error);
        }

        // Удаление оценок с указанным subject_id
        $deleteGradesQuery = "DELETE FROM grades WHERE subject_id = ?";
        $deleteGradesStmt = $conn->prepare($deleteGradesQuery);
        $deleteGradesStmt->bind_param("i", $subjectId);

        if (!$deleteGradesStmt->execute()) {
            throw new Exception("Ошибка удаления оценок: " . $deleteGradesStmt->error);
        }

        // Фиксация транзакции
        $conn->commit();

        $message = "Предмет и связанные оценки успешно удалены.";
        $alertClass = "alert-success";
    } catch (Exception $e) {
        // Откат транзакции в случае ошибки
        $conn->rollback();

        $message = "Ошибка удаления предмета: " . $e->getMessage();
        $alertClass = "alert-danger";
    }

    // Закрываем подготовленные запросы
    $deleteSubjectStmt->close();
    $deleteGradesStmt->close();
}

// Закрытие соединения
$conn->close();
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
            <a href="manage_subjects.php" class="btn btn-primary btn-block mt-3">Ок</a>
        </div>
    </div>
</div>

</body>
</html>
        