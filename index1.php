<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моя веб-страница</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .container {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            height: 100vh;
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
            margin-bottom: 1rem; /* Добавим немного отступа снизу для текста */
            overflow: hidden;
            text-overflow: ellipsis; /* Если текст слишком длинный, скрываем его с помощью многоточия */
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Ограничиваем количество отображаемых строк текста */
            -webkit-box-orient: vertical;
        }

        @media (max-width: 767px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
            }
        }

        @media (min-width: 768px) and (max-width: 990px) {
            .card {
                width: 45%;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-1">
        <div class="card rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Таблицы</h4>
            </div>
            <div class="card-body">
                <p class="fw-bold">Описание:</p>
                <p>На этой странице вы можете просмотреть рейтинг студентов и получить дополнительную информацию о их успехах.</p>
                <a href="ratings.php" class="btn btn-primary">Смотреть</a>
            </div>
        </div>

        <div class="card rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Добавить / Редактировать</h4>
            </div>
            <div class="card-body">
                <p class="fw-bold">Описание:</p>
                <p>Добавьте новые записи или отредактируйте существующие в таблице. Здесь вы можете также осуществлять сортировку и фильтрацию данных для удобства использования.</p>
                <a href="edit.php" class="btn btn-primary">Редактировать</a>
            </div>
        </div>
    </div>
</body>
</html>
