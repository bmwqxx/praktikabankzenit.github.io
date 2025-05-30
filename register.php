<?php
session_start();
require_once 'db.php';

$errors = [];

// Генерация CSRF-токена
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Проверка CSRF-токена
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Ошибка безопасности: неверный CSRF токен.");
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "Пожалуйста, заполните все поля.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Пользователь с таким именем или email уже существует.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            $stmt->execute();

            $_SESSION['user'] = $username;
            $_SESSION['user_id'] = $conn->insert_id;

            // Удаляем токен после успешной регистрации
            unset($_SESSION['csrf_token']);

            header("Location: index.php");
            exit();
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .error-list {
            color: red;
            margin-bottom: 10px;
            text-align: left;
        }

        .home-link {
            color: white;
            text-decoration: none;
        }

        .home-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="top-stripe">
        <h1><a href="index.php" style="color: white; text-decoration: none;">ПАО БАНК ЗЕНИТ</a></h1>
</div>

<main>
    <div class="content">
        <h2>Регистрация</h2>
        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <!-- CSRF токен -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <button type="submit">Зарегистрироваться</button>
        </form>
        <p>Уже зарегистрированы? <a href="login.php">Войти</a></p>
    </div>
</main>
<div class="footer">
    &copy; <?= date("Y") ?> ПАО Банк Зенит
</div>
</body>
</html>
