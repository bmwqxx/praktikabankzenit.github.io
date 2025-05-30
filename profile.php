<?php 
session_start(); 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ПАО БАНК ЗЕНИТ</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
  <h1><a href="index.php" style="color:white; text-decoration:none;">ПАО БАНК ЗЕНИТ</a></h1>
  <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['user']) ?>!</p>
  <a href="logout.php" style="color:white; font-weight:bold;">Выйти</a>
</header>

<nav>
  <ul>
    <li><a href="index.php">Главная</a></li>
    <li><a href="about.php">О банке</a></li>
    <li><a href="services.php">Услуги</a></li>
    <li><a href="youth.php">Молодёжи</a></li>
    <li><a href="education.php">Грамотность</a></li>
    <li><a href="contacts.php">Контакты</a></li>
    <li><a href="profile.php">Личный кабинет</a></li>
  </ul>
</nav>

<main>
  
  <section>
    <h2>Личный кабинет</h2>
    <p>Имя пользователя: <strong><?= htmlspecialchars($_SESSION['user']) ?></strong></p>
    <p>Ваш уникальный ID: <strong><?= $_SESSION['user_id'] ?></strong></p>
  </section>
</main>

<footer>
  <p>Следите за нами в соцсетях: <a href="#">VK</a> | <a href="#">Telegram</a> | <a href="#">YouTube</a></p>
</footer>
</body>
</html>
