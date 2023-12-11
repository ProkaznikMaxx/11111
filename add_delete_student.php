<!-- add_delete_student.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление и удаление студента</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="d-flex justify-content-start mb-4" style="margin-left: 15px; margin-top: 15px;">
        <a href="edit.php" class="btn btn-primary">Назад</a>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Добавление и удаление студента</h2>

        <!-- Форма для добавления студента -->
        <form method="post" action="process_add_student.php">
            <h3 class="mb-3">Добавление студента</h3>
            <div class="mb-3">
                <label for="surname">Фамилия</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>
            <div class="mb-3">
                <label for="name">Имя</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="middlename">Отчество</label>
                <input type="text" class="form-control" id="middlename" name="middlename" required>
            </div>
            <div class="mb-3">
                <label for="group">Группа</label>
                <select class="form-select" id="group" name="group" required>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "111";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Ошибка подключения: " . $conn->connect_error);
                    }

                    $groupsQuery = "SELECT * FROM groups";
                    $groupsResult = $conn->query($groupsQuery);

                    echo "<option value='' selected disabled>Выберите группу</option>";
                    while ($group = $groupsResult->fetch_assoc()) {
                        echo "<option value='" . $group['group_id'] . "'>" . $group['GroupName'] . "</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Добавить студента</button>
        </form>

        <hr>

        <!-- Форма для удаления студента -->
        <form method="post" action="process_delete_student.php">
            <h3 class="mb-3">Удаление студента</h3>
            <div class="mb-3">
                <label for="student">Выберите студента для удаления</label>
                <select class="form-select" id="student" name="student" required>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "111";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Ошибка подключения: " . $conn->connect_error);
                    }

                    $studentsQuery = "SELECT students.student_id, students.Surname, students.Name, students.Middlename, groups.GroupName FROM students JOIN groups ON students.group_id = groups.group_id";
                    $studentsResult = $conn->query($studentsQuery);

                    echo "<option value='' selected disabled>Выберите студента</option>";
                    while ($student = $studentsResult->fetch_assoc()) {
                        echo "<option value='" . $student['student_id'] . "'>" . $student['student_id'] . " - " . $student['Surname'] . " " . $student['Name'] . " " . $student['Middlename'] . " (" . $student['GroupName'] . ")</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Удалить студента</button>
        </form>
    </div>

</body>
</html>
