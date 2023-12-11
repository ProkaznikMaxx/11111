<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление учебным процессом</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <!-- Ваши стили -->
    <style>
        body {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: stretch;
            max-width: 800px;
            width: 100%;
        }

        .card {
            width: 45%;
            margin: 10px 0;
            height: 30%;
            overflow: hidden;
        }

        .card-body {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-body p {
            margin-bottom: 1rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        @media (max-width: 767px) {
            .card {
                width: 90%;
            }
        }

        @media (min-width: 768px) and (max-width: 990px) {
            .card {
                width: 45%;
            }
        }

        /* Добавленные стили для кнопки "Назад" */
        .back-button {
            margin-left: 15px;
            margin-top: 15px;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Кнопка "Назад" в верхнем левом углу -->
    <a href="index1.php" class="btn btn-primary back-button">На главную</a>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Управление учебным процессом</h2>

        <!-- Блок "Оценки" -->
        <div class="card rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Оценки</h4>
            </div>
            <div class="card-body">
                <p class="fw-bold">Описание:</p>
                <p>Управление оценками студентов.</p>
                <a href="load_grades.php" class="btn btn-primary">Перейти</a>
            </div>
        </div>

        <!-- Блок "Предметы" -->
        <div class="card rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Предметы</h4>
            </div>
            <div class="card-body">
                <p class="fw-bold">Описание:</p>
                <p>Управление списком предметов.</p>
                <a href="manage_subjects.php" class="btn btn-primary">Перейти</a>
            </div>
        </div>

        <!-- Блок "Студенты" -->
        <div class="card rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Студенты</h4>
            </div>
            <div class="card-body">
                <p class="fw-bold">Описание:</p>
                <p>Управление списком студентов.</p>
                <a href="add_delete_student.php" class="btn btn-primary">Перейти</a>
            </div>
        </div>

        <!-- Блок "Мероприятия" -->
        <div class="card rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Мероприятия</h4>
            </div>
            <div class="card-body">
                <p class="fw-bold">Описание:</p>
                <p>Управление посещением мероприятий.</p>
                <a href="add_delete_event.php" class="btn btn-primary">Перейти</a>
            </div>
        </div>
    

         <!-- Блок "Группы" -->
        <div class="card rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Группы</h4>
            </div>
            <div class="card-body">
                <p class="fw-bold">Описание:</p>
                <p>Управление списком групп.</p>
                <a href="group.php" class="btn btn-primary">Перейти</a>
            </div>
        </div>

    </div>
</body>
</html>
