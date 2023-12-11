<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Обработка операции</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php
            // Подключение к базе данных
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "111";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Проверка подключения
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['groupName'])) {
                    // Добавление новой группы в базу данных
                    $groupName = $_POST['groupName'];

                    // Проверка, существует ли группа с таким именем
                    $checkGroupExists = "SELECT group_id FROM groups WHERE GroupName = '$groupName'";
                    $result = $conn->query($checkGroupExists);

                    if ($result->num_rows > 0) {
                        echo '<div class="alert alert-warning text-center" role="alert">Группа с таким именем уже существует в базе данных.</div>';
                    } else {
                        // Группа с таким именем не существует, можно добавить
                        $sql = "INSERT INTO groups (GroupName) VALUES ('$groupName')";

                        if ($conn->query($sql) === TRUE) {
                            echo '<div class="alert alert-success text-center" role="alert">Группа успешно добавлена в базу данных.</div>';
                        } else {
                            echo '<div class="alert alert-danger text-center" role="alert">Ошибка при добавлении группы: ' . $conn->error . '</div>';
                        }
                    }
                } elseif (isset($_POST['groupToDelete'])) {
                    // Удаление группы и связанных студентов и их участия в мероприятиях из базы данных
                    $groupNameToDelete = $_POST['groupToDelete'];

                    // Удаление участия студентов в мероприятиях
                    $sqlDeleteParticipation = "DELETE FROM eventparticipation WHERE student_id IN (SELECT student_id FROM students WHERE group_id = (SELECT group_id FROM groups WHERE GroupName = '$groupNameToDelete'))";

                    // Удаление оценок студентов
                    $sqlDeleteGrades = "DELETE FROM grades WHERE student_id IN (SELECT student_id FROM students WHERE group_id = (SELECT group_id FROM groups WHERE GroupName = '$groupNameToDelete'))";

                    // Удаление студентов
                    $sqlDeleteStudents = "DELETE FROM students WHERE group_id = (SELECT group_id FROM groups WHERE GroupName = '$groupNameToDelete')";

                    // Удаление группы
                    $sqlDeleteGroup = "DELETE FROM groups WHERE GroupName = '$groupNameToDelete'";

                    // Выполнение запросов
                    if ($conn->query($sqlDeleteParticipation) === TRUE && $conn->query($sqlDeleteGrades) === TRUE && $conn->query($sqlDeleteStudents) === TRUE && $conn->query($sqlDeleteGroup) === TRUE) {
                        echo '<div class="alert alert-success text-center" role="alert">Группа, студенты, их участие и связанные оценки успешно удалены из базы данных.</div>';
                    } else {
                        echo '<div class="alert alert-danger text-center" role="alert">Ошибка при удалении группы: ' . $conn->error . '</div>';
                    }
                }
            }

            // Запрос для получения списка групп
            $sqlGroups = "SELECT GroupName FROM groups";
            $resultGroups = $conn->query($sqlGroups);
            ?>

            <div class="text-center mt-3">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['groupName']) || isset($_POST['groupToDelete'])) {
                        echo '<a href="group.php" class="btn btn-primary">Ок</a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-eMN1JMEs1KaNEP4EuvrXe3NZzYMy2VwAFYzjBfE7FLAXKxztaK9zOTfEPWhYdjNH"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyUsQKH5L9kN2U1z4U7igXlJj73EN"
        crossorigin="anonymous"></script>

</body>
</html>
