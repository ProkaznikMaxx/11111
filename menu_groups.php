<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Меню групп</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        /* Ваши стили здесь */

        .group-container {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .group-title {
            font-size: 24px; /* Увеличил размер надписи */
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center; /* Выравнивание по центру */
        }

        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container mt-3">

        <!-- Надпись "Меню групп" -->
        <h2 class="group-title">Меню групп</h2>

        <?php
        // Подключение к базе данных
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "111";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверка подключения
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        $groupsQuery = "SELECT * FROM Groups"; // Учтите регистр: "Groups" вместо "groups"
        $groupsResult = $conn->query($groupsQuery);

        while ($group = $groupsResult->fetch_assoc()) {
            echo "<div class='group-container'>";
            echo "<h3 class='group-title'>Группа: '{$group['GroupName']}'</h3>";
            // Создайте ссылку с параметром запроса group_id и значением текущей группы
            echo '<a href="ratings.php?group_id=' . $group['group_id'] . '">Просмотреть студентов</a>';

            echo "</div>";
        }

        // Закрытие соединения с базой данных
        $conn->close();
        ?>

    </div>

</body>
</html>
