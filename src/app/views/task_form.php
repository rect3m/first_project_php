<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= isset($task) ? 'Редагування завдання' : 'Створення завдання' ?></title>
  <link rel="stylesheet" href="/styles/styles.css">
</head>
<body>
<h1><?= isset($task) ? 'Редагування завдання' : 'Створення завдання' ?></h1>

<form method="post">
  <div class="vertical">
    <div class="horizontal">
      <label>
        Назва:
        <input type="text" name="title" value="<?= htmlspecialchars($task->title ?? '') ?>"
               required>
      </label>
    </div>

    <div class="horizontal">
      <label>
        Опис:
        <textarea name="description"><?= htmlspecialchars($task->description ?? '') ?></textarea>
      </label>
    </div>

    <div class="horizontal">
      <label>
        Статус:
        <select name="status">
			<?php

            use App\Enums\TaskStatus;

  foreach (TaskStatus::cases() as $status):
      ?>
              <option
                  value="<?= htmlspecialchars($status->value) ?>" <?= (isset($task) && $task->status === $status->value) ? 'selected' : '' ?>>
				  <?= htmlspecialchars($status->name) ?>
              </option>
			<?php endforeach; ?>
        </select>
      </label>
    </div>

	  <?php if (isset($task)): // Показувати це поле тільки при редагуванні?>
        <div class="horizontal">
          <label>
            Належить користувачу:
            <select name="assigned_to_id">
				<?php foreach ($users as $user): ?>
                  <option
                      value="<?= htmlspecialchars($user['id']) ?>" <?= (isset($task) && $task->assigned_to_id == $user['id']) ? 'selected' : '' ?>>
					  <?= htmlspecialchars($user['name']) ?>
                  </option>
				<?php endforeach; ?>
            </select>
          </label>
        </div>
	  <?php endif; ?>

    <div class="horizontal">
      <button
          type="submit"><?= isset($task) ? 'Редагувати завдання' : 'Створити завдання' ?></button>
    </div>
  </div>
</form>

<div class="horizontal">
  <form action="/tasks" method="GET">
    <button type="submit">Назад до списку</button>
  </form>
</div>
</body>
</html>
