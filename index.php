<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0 0 15px; /* Изменено: добавлен отступ снизу на 15px */
        }
    </style>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Авторизация</h2>
                    </div>
                    <div class="card-body">
                        <form action="login_process.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Имя пользователя:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Войти</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
