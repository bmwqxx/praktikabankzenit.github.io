<?php
$host = "localhost";
$dbname = "zenitbank";
$user = "root"; // замени, если другой
$pass = "";     // замени, если есть пароль

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
?>
