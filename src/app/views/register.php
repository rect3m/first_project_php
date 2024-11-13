<!-- public/views/register.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Реєстрація</title>
  <link rel="stylesheet" href="/styles/styles.css">
</head>
<body>
<form method="POST" action="/register">
  <h1>Реєстрація</h1>
  <div class="vertical">
    <div class="horizontal">
      <label class="label-login">Логін:</label>
      <input type="text" name="username" required>
    </div>
    <div class="horizontal">
      <label class="label-mail">Пошта:</label><br>
      <input type="email" name="email" required>
    </div>
    <div class="horizontal">
      <label>Пароль:</label>
      <input type="password" name="password" required>
    </div>

    <button type="submit">Зареєструватись</button>
  </div>
</form>
<div class="horizontal">
  <form action="/" method="GET">
    <button type="submit">Увійти</button>
  </form>
</div>
</body>
</html>
