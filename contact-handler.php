<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $to = "admin@zenitbank.ru"; // заменить на реальный email
    $subject = "Новое сообщение от $name";
    $body = "Имя: $name\nEmail: $email\n\nСообщение:\n$message";

    if (mail($to, $subject, $body)) {
        echo "Сообщение успешно отправлено.";
    } else {
        echo "Ошибка при отправке сообщения.";
    }
} else {
    header("Location: contacts.php");
    exit();
}
?>
