<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление группами</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="d-flex justify-content-start mb-4" style="margin-left: 15px; margin-top: 15px;">
    <a href="edit.php" class="btn btn-primary">Назад</a>
</div>

<div class="container-fluid mt-5">
    <h2 class="text-center mb-4">Управление группами</h2>

    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <h4 class="mb-3">Добавить новую группу</h4>
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
                        echo '<div class="alert alert-warning" role="alert">Группа с таким именем уже существует в базе данных.</div>';
                    } else {
                        // Группа с таким именем не существует, можно добавить
                        $sql = "INSERT INTO groups (GroupName) VALUES ('$groupName')";

                        if ($conn->query($sql) === TRUE) {
                            echo '<div class="alert alert-success" role="alert">Группа успешно добавлена в базу данных.</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Ошибка при добавлении группы: ' . $conn->error . '</div>';
                        }
                    }
                } elseif (isset($_POST['groupToDelete'])) {
                    // Удаление группы и связанных студентов из базы данных
                    $groupNameToDelete = $_POST['groupToDelete'];
                    $sqlDeleteGrades = "DELETE FROM grades WHERE student_id IN (SELECT student_id FROM students WHERE group_id = (SELECT group_id FROM groups WHERE GroupName = '$groupNameToDelete'))";
                    $sqlDeleteStudents = "DELETE FROM students WHERE group_id = (SELECT group_id FROM groups WHERE GroupName = '$groupNameToDelete')";
                    $sqlDeleteGroup = "DELETE FROM groups WHERE GroupName = '$groupNameToDelete'";

                    if ($conn->query($sqlDeleteGrades) === TRUE && $conn->query($sqlDeleteStudents) === TRUE && $conn->query($sqlDeleteGroup) === TRUE) {
                        echo '<div class="alert alert-success" role="alert">Группа, студенты и связанные оценки успешно удалены из базы данных.</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Ошибка при удалении группы: ' . $conn->error . '</div>';
                    }
                }
            }

            // Запрос для получения списка групп
            $sqlGroups = "SELECT GroupName FROM groups";
            $resultGroups = $conn->query($sqlGroups);
            ?>
            <form action="process_group.php" method="post" class="mb-4">
                <div class="mb-3">
                    <label for="groupName" class="form-label">Название группы:</label>
                    <input type="text" class="form-control col-12" id="groupName" name="groupName" required>
                </div>
                <button type="submit" class="btn btn-success">Добавить группу</button>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <form action="process_group.php" method="post" onsubmit="return confirm('Вы уверены, что хотите удалить группу?');">
                <h4 class="mb-3">Удалить группу</h4>
                <?php
                // Вывод опций для каждой группы
                echo '<div class="mb-3">';
                echo '<label for="groupToDelete" class="form-label">Выберите группу для удаления:</label>';
                echo '<select class="form-select col-12" id="groupToDelete" name="groupToDelete" required>';
                echo '<option value="" disabled selected>Выберите группу</option>';
                while ($row = $resultGroups->fetch_assoc()) {
                    echo '<option value="' . $row['GroupName'] . '">' . $row['GroupName'] . '</option>';
                }
                echo '</select>';
                echo '</div>';
                ?>
                <button type="submit" class="btn btn-danger">Удалить группу</button>
            </form>
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
