<?php include "header.php"; ?>
<main>
  <section>
    <h2>Контакты</h2>
    <p><strong>Телефон:</strong> 8-800-100-5000</p>
    <p><strong>Email:</strong> support@zenitbank.ru</p>
    <p><strong>Адрес:</strong> Москва, ул. Финансовая, д. 10</p>
    <h3>Написать нам:</h3>
    <form method="post" action="contact-handler.php">
      <input type="text" name="name" placeholder="Ваше имя" required><br>
      <input type="email" name="email" placeholder="Ваш email" required><br>
      <textarea name="message" placeholder="Сообщение" required></textarea><br>
      <button type="submit">Отправить</button>
    </form>
  </section>
</main>
<?php include "footer.php"; ?>
