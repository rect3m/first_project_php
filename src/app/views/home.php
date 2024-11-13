<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Головна сторінка</title>
  <link rel="stylesheet" href="/styles/styles.css">

</head>
<body>
<?php if (isset($_SESSION['username'])): ?>
  <div class="horizontal">
    <h1>Ласкаво просимо до системи управління завданнями -</h1>
    <h1><?= htmlspecialchars($_SESSION['username']) ?>!</h1>
  </div>
<?php endif; ?>

<ul>
  <div class="horizontal">
    <form action="/tasks" method="GET">
      <button type="submit">Список завдань</button>
    </form>
    <form action="/change/password" method="GET">
      <button type="submit">Зміна паролю</button>
    </form>
    <form action="/logout" method="GET">
      <button type="submit">Вийти з аккаунту</button>
    </form>
  </div>
</ul>
</body>
</html>
