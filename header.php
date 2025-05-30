<?php session_start(); ?>
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
  <div class="header-top">
<h1><a href="index.php" style="color: white; text-decoration: none;">ПАО БАНК ЗЕНИТ</a></h1>

  </div>

  <div class="user-info">
    <?php if (isset($_SESSION['user'])): ?>
      <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['user']) ?>!</p>
      <a href="logout.php">Выйти</a>
    <?php else: ?>
      <p><a href="login.php">Войти</a> | <a href="register.php">Регистрация</a></p>
    <?php endif; ?>
  </div>
</header>

<nav>
  <ul>
    <li><a href="index.php">Главная</a></li>
    <li><a href="about.php">О банке</a></li>
    <li><a href="services.php">Услуги</a></li>
    <li><a href="youth.php">Для молодёжи</a></li>
    <li><a href="education.php">Грамотность</a></li>
    <li><a href="contacts.php">Контакты</a></li>
    <?php if (isset($_SESSION['user'])): ?>
      <li><a href="profile.php">Личный кабинет</a></li>
    <?php endif; ?>
  </ul>
</nav>
