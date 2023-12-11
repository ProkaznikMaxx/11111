<!-- mark_attendance.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отметка о присутствии на мероприятии</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="d-flex justify-content-start mb-4" style="margin-left: 15px; margin-top: 15px;">
        <a href="index.php" class="btn btn-primary">Назад</a>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Отметка о присутствии на мероприятии</h2>

        <!-- Форма для отметки о присутствии -->
        <form method="post" action="process_mark_attendance.php">
            <div class="mb-3">
                <label for="student">Выберите студента</label>
                <!-- Выпадающий список со студентами -->
            </div>
            <div class="mb-3">
                <label for="event">Выберите мероприятие</label>
                <!-- Выпадающий список с мероприятиями -->
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="eventparticipation" name="eventparticipation">
                <label class="form-check-label" for="eventparticipation">
                    Был(а) на мероприятии
                </label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Отметить присутствие</button>
        </form>
    </div>

</body>
</html>
