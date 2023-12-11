<?php
// Подключение к базе данных
$conn = new mysqli("localhost", "root", "", "111");

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение group_id из параметра запроса
$group_id = isset($_GET['group_id']) ? $_GET['group_id'] : null;

// Ваш оставшийся PHP-код для вывода рейтингов по выбранной группе
// ...
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моя веб-страница</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
     <style>

    body .table th {
    background-color: #007bff;
    color: #fff;
    text-align: center; /* Добавлено: выравнивание по центру */
    white-space: normal; /* Добавлено: разрешение переноса слов на новую строку */
    word-wrap: break-word; /* Добавлено: перенос слов на новую строку */
    }

    body .table th,
    body .table td {
    text-align: center;
    padding: 10px;
    border: 1px solid #ccc;
    }


    body .table th:nth-child(odd) {
    background: #007bff;
    }

    body .container {
        max-width: 1170px;
        margin: 15px;
        padding: 0 15px;
    }

    body .mtb-3 {
        margin-top: 3rem;
        margin-bottom: 3rem;
    }

    body .table {
        width: 100%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        border-collapse: collapse;
        white-space: nowrap;
        margin: 0;
        border: 1px solid #ccc;
    }

    body .table td {
        text-align: center;
        padding: 10px;
        border: 1px solid #ccc;
    }

    body .table th {
        background-color: #007bff;
        color: #fff;
    }

    body .table th:nth-child(odd) {
        background: #007bff;
    }

    body .table tr:nth-child(even) {
        background: none; /* Изменено: убрана подсветка у тела таблицы */
    }

    body .table tr {
        transition: all .3s;
    }

    body .table tr:hover {
        background-color: #ccc;
    }

    body .table td:not(:last-child) {
        border-right: 1px solid #ccc;
    }
    .table-responsive{
    overflow-x: auto;
    }
    body .table th {
        background-color: #007bff;
        color: #fff;
        text-align: center;
        white-space: normal;
        word-wrap: break-word;
    }

    /* ... (остальные стили) */

    body .table-responsive::-webkit-scrollbar {
        width: 12px;
    }

    body .table-responsive::-webkit-scrollbar-thumb {
        background-color: #ccc; /* Цвет "бегунка" скролла */
        border-radius: 8px; /* Радиус закругления углов "бегунка" */
    }

    body .table-responsive::-webkit-scrollbar-track {
        background-color: #fff; /* Цвет фона скролла */
        border-radius: 10px; /* Радиус закругления углов фона скролла */
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1); /* Тень вокруг фона скролла */
    }

  
    </style>
</head>
<body class="bg-light">

<div class="d-flex justify-content-start mb-4" style="margin-left: 15px; margin-top: 15px;">
    <a href="index1.php" class="btn btn-primary">На главную</a>
</div>

 <h2 class='text-center mb-3'>Таблица успеваемости студентов</h2>
    <div class="mt-3 table-responsive"> 

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

// Получение group_id из параметра запроса
$group_id = isset($_GET['group_id']) ? $_GET['group_id'] : null;

$subjectsQuery = "SELECT DISTINCT SubjectName FROM subjects";
$subjectsResult = $conn->query($subjectsQuery);

$subjects = [];
while ($subject = $subjectsResult->fetch_assoc()) {
    $subjects[] = $subject['SubjectName'];
}

// Получение событий
$eventsQuery = "SELECT DISTINCT EventName FROM events";
$eventsResult = $conn->query($eventsQuery);

$allEvents = [];

// Проверяем, были ли успешно получены результаты
if ($eventsResult !== false) {
    while ($event = $eventsResult->fetch_assoc()) {
        $allEvents[] = $event['EventName'];
    }
} else {
    // Обработка ошибки запроса
    echo "Ошибка выполнения запроса: " . $conn->error;
    // Или просто завершите выполнение скрипта, если это критическая ошибка
    die();
}

$sql = "SELECT
    students.student_id AS Идентификатор_студента,
    students.Surname AS Фамилия,
    students.Name AS Имя,
    students.Middlename AS Отчество,
    " . generateSubjectColumns($subjects) . ",
    AVG(grades.AverageGrade) AS Средний_балл,
    COUNT(DISTINCT eventparticipation.participation_id) AS Количество_мероприятий   
FROM students
LEFT JOIN grades ON students.student_id = grades.student_id
LEFT JOIN eventparticipation ON students.student_id = eventparticipation.student_id
LEFT JOIN subjects ON grades.subject_id = subjects.subject_id
GROUP BY Идентификатор_студента, Фамилия, Имя, Отчество
ORDER BY Средний_балл DESC, Количество_мероприятий DESC, COUNT(grades.AverageGrade) DESC";

// Выполнение SQL-запроса
$result = $conn->query($sql);

// Проверка результата запроса
 if ($result === false) {
            echo "Ошибка выполнения запроса: " . $conn->error;
        } else {
            echo "<div class='container mt-3 horizontal-scrollable'>";
            echo "<table class='table table-striped table-bordered mt-4'>
            <thead>
                <tr>
                    <th scope='col'>Позиция</th>
                    <th scope='col'>ID Cтудента</th>
                    <th scope='col'>Фамилия</th>
                    <th scope='col'>Имя</th>
                    <th scope='col'>Отчество</th>";

    // Проверка наличия предметов
    if (!empty($subjects)) {
        // Добавляем столбцы для каждого предмета
        foreach ($subjects as $subject) {
            echo "<th scope='col'>$subject</th>";
        }
    }

    // Добавляем столбец для среднего балла
    echo "<th scope='col'>Средний балл</th>";

    echo "<th scope='col'>Кол-во мероприятий</th>
        </tr>
    </thead>
    <tbody>";

    $rowNumber = 1;

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <th scope='row' class='text-center'>" . $rowNumber . "</th>
            <td class='text-center'>" . $row["Идентификатор_студента"] . "</td>
            <td class='text-center'>" . $row["Фамилия"] . "</td>
            <td class='text-center'>" . $row["Имя"] . "</td>
            <td class='text-center'>" . $row["Отчество"] . "</td>";

        // Выводим оценки для каждого предмета, если они есть
        if (!empty($subjects)) {
            foreach ($subjects as $subject) {
                $grade = isset($row[$subject]) ? rtrim(rtrim($row[$subject], '0'), '.') : '';
                echo "<td class='text-center'>$grade</td>";
            }
        }

        // Выводим средний балл
        echo "<td class='text-center'>" . ($row["Средний_балл"] === '' ? '' : number_format($row["Средний_балл"], 2, '.', '')) . "</td>
            <td class='text-center'>" . $row["Количество_мероприятий"] . "</td>
        </tr>";

        $rowNumber++;
    }
    echo "</tbody></table>";
    echo "</div>";
}

// Функция для генерации динамических столбцов для каждого предмета
function generateSubjectColumns($subjects) {
    $columns = "";
    foreach ($subjects as $subject) {
        $columns .= "COALESCE(MAX(CASE WHEN subjects.SubjectName = '$subject' THEN grades.AverageGrade END), '') AS '$subject',";
    }
    return rtrim($columns, ",");
}
?>
</div>
<h2 class='text-center mb-4' style='margin-top: 3rem;'>Таблица посещаемости мероприятий</h2>
<div class="mt-3 table-responsive">
    <?php
    $sql2 = "SELECT
        students.student_id AS Идентификатор_студента,
        students.Surname AS Фамилия,
        students.Name AS Имя,
        students.Middlename AS Отчество";

    // Проверяем наличие мероприятий
    if (count($allEvents) > 0) {
        // Добавляем столбцы для мероприятий
        $sql2 .= ", " . implode(", ", array_map(function ($event) {
            return "SUM(CASE WHEN events.EventName = '$event' THEN 1 ELSE 0 END) AS `$event`";
        }, $allEvents));

        // Добавляем столбец с количеством посещений
        $sql2 .= ", COALESCE(COUNT(DISTINCT eventparticipation.participation_id), 0) AS Количество_посещений";
    }

    $sql2 .= " FROM students
        LEFT JOIN eventparticipation ON students.student_id = eventparticipation.student_id";

    // Добавляем JOIN для мероприятий, если они есть
    if (count($allEvents) > 0) {
        $sql2 .= " LEFT JOIN events ON eventparticipation.event_id = events.event_id";
    }

    $sql2 .= " GROUP BY students.student_id";

    // Добавляем условие сортировки только при наличии мероприятий
    if (count($allEvents) > 0) {
        $sql2 .= " ORDER BY Количество_посещений DESC";
    }

    $result2 = $conn->query($sql2);

    // Проверяем наличие ошибок в запросе
    if ($result2 === false) {
        echo "Ошибка выполнения запроса: " . $conn->error;
    } elseif ($result2->num_rows > 0) {
        // ваш код для обработки результатов
    } else {
        echo "Нет данных для отображения.";
    }

    if ($result2->num_rows > 0) {
        echo "<div class='container mt-3 horizontal-scrollable'>";
        echo "<table class='table table-striped table-bordered mt-4 scrollable-table'>
            <thead>
                <tr>
                    <th scope='col'>Позиция</th>
                    <th scope='col'>ID студента</th>
                    <th scope='col'>Фамилия</th>
                    <th scope='col'>Имя</th>
                    <th scope='col'>Отчество</th>";

        foreach ($allEvents as $event) {
            echo "<th scope='col'>$event</th>";
        }

        echo "<th scope='col'>Количество посещений</th>
          </tr>
      </thead>
      <tbody>";

        $rowNumber2 = 1;

        while ($row2 = $result2->fetch_assoc()) {
            echo "<tr>
                <th scope='row' class='text-center'>" . $rowNumber2 . "</th>
                <td class='text-center'>" . $row2["Идентификатор_студента"] . "</td>
                <td class='text-center'>" . $row2["Фамилия"] . "</td>
                <td class='text-center'>" . $row2["Имя"] . "</td>
                <td class='text-center'>" . $row2["Отчество"] . "</td>";

            foreach ($allEvents as $event) {
                echo "<td class='text-center'>" . ($row2[$event] !== '0' ? '+' : '') . "</td>";
            }

            echo "<td class='text-center'>" . $row2["Количество_посещений"] . "</td>
            </tr>";

            $rowNumber2++;
        }

        echo "</tbody></table>";
        echo "</div>";
    }

    // Закрываем соединение с базой данных
    $conn->close();
    ?>
</div>
</div>
</body>
</html>