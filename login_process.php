<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "1111";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Проверка пользователя в базе данных
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row["role"];

        // Устанавливаем роль пользователя в сессии
        $_SESSION["role"] = $role;

        // Перенаправление на соответствующую страницу
        if ($role == "admin") {
            header("Location: index1.php");
        } elseif ($role == "user") {
            header("Location: ratings.php");
        } else {
            // Если у пользователя нет определенной роли, обработайте это по вашему усмотрению
            echo "Неопределенная роль пользователя.";
        }
    } else {
        echo "Неверное имя пользователя или пароль.";
    }

    $stmt->close();
}

$conn->close();
?>
