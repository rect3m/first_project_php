<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Завдання</title>
  <link rel="stylesheet" href="/styles/styles.css">
</head>
<body>
<h1>Завдання</h1>
<h2>Список завдань</h2>
<table>
  <thead>
  <tr>
    <th>Айді</th>
    <th>Назва</th>
    <th>Опис</th>
    <th>Статус</th>
    <th>Дії</th>
  </tr>
  </thead>
  <tbody>
  <?php if (!empty($tasks)): ?>
	  <?php foreach ($tasks as $task): ?>
      <tr>
        <td><?= htmlspecialchars($task->id) ?></td>
        <td><?= htmlspecialchars($task->title) ?></td>
        <td><?= htmlspecialchars($task->description ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($task->status) ?></td>
        <td>
          <!-- Посилання для редагування, видалення та призначення -->
          <a href="/tasks/edit/<?= $task->id ?>">Edit</a> |
          <a href="/tasks/delete/<?= $task->id ?>"
             onclick="return confirm('Are you sure?')">Delete</a> |
        </td>
      </tr>
	  <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="5">Завдань не знайдено</td>
    </tr>
  <?php endif; ?>
  </tbody>
</table>

<div class="horizontal">
  <form action="/tasks/create" method="GET">
    <button type="submit">Створити завдання</button>
  </form>

  <form action="/home" method="GET">
    <button type="submit">Назад в головне меню</button>
  </form>
</div>
</body>
</html>
