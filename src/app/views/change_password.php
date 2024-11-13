<!-- public/views/home.php -->
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Зміна паролю</title>
  <link rel="stylesheet" href="/styles/styles.css">
</head>
<body>
<h1>Зміна паролю</h1>
<form method="POST" action="/change/password">
  <div class="vertical">
    <div class="horizontal">
      <label>Теперішній пароль:
        <input type="password" name="current_password" required>
      </label>
    </div>

    <div class="horizontal">
      <label class="label-new-ps">Новий пароль:
        <input type="password" name="new_password" required>
      </label>
    </div>

    <div class="horizontal">
      <label class="label-confirm-ps">Підтвердіть новий пароль:
        <input type="password" name="confirm_password" required>
      </label>
    </div>

    <button type="submit">Змінити пароль</button>
  </div>
</form>
</body>
</html>
