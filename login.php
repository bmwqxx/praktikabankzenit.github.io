<?php
session_start();
require_once 'db.php';

$error = "";

// Генерация CSRF-токена при первом открытии страницы
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Обработка формы входа
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Проверка CSRF-токена
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Ошибка безопасности: неверный CSRF токен.");
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $username;
        $_SESSION['user_id'] = $user['id'];
        
        // Обновим токен после успешного входа
        unset($_SESSION['csrf_token']);

        header("Location: profile.php");
        exit();
    } else {
        $error = "Неверное имя пользователя или пароль.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .top-stripe {
            background-color: #003d80;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: bold;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 340px;
            text-align: center;
        }
        form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            font-size: 16px;
        }
        form button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #003d80;
            color: white;
            border: 1px solid #003d80;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        form button:hover {
            background-color: #002f6c;
        }
        .footer {
            background-color: #003d80;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        a {
            color: #003d80;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="top-stripe">
        <h1><a href="index.php" style="color: white; text-decoration: none;">ПАО БАНК ЗЕНИТ</a></h1>
    </div>
    <main>
        <div class="content">
            <h2>Вход</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Имя пользователя" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <!-- CSRF токен -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <button type="submit">Войти</button>
            </form>
            <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
        </div>
    </main>
    <div class="footer">
        &copy; <?= date("Y") ?> ПАО Банк Зенит
    </div>
</body>
</html>
