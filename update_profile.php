<?php
session_start();
require_once 'db.php'; // Подключение к БД

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$newUsername = trim($_POST['new_username']);
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

if ($newPassword !== $confirmPassword) {
    die("Пароли не совпадают.");
}

if (strlen($newPassword) < 6) {
    die("Пароль должен содержать минимум 6 символов.");
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Обновление логина и пароля
$stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
$stmt->execute([$newUsername, $hashedPassword, $userId]);

// Обновляем сессию
$_SESSION['user'] = $newUsername;

header("Location: profile.php");
exit();
