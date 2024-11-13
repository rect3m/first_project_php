<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\TaskStatus;
use App\Managers\TaskManager;
use App\Managers\UserManager;
use App\Models\Task;

class TaskController
{
    private TaskManager $taskManager;

    private UserManager $userManager;

    public function __construct(TaskManager $taskManager, UserManager $userManager)
    {
        $this->taskManager = $taskManager;
        $this->userManager = $userManager;
    }

    public function listTasks(): void
    {
        $tasks = $this->taskManager->getTasksByUser(1); // Наприклад, ID поточного користувача
        require __DIR__ . '/../views/tasks_list.php';
    }

    public function createTask(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? null;
            $creator_id = 1; // ID поточного користувача (можна взяти з сесії)

            $this->taskManager->addTask($title, $description, $creator_id);
            header('Location: /tasks');
            exit;
        }

        require __DIR__ . '/../views/task_form.php';
    }

    public function editTask(int $id): void
    {
        $task = $this->taskManager->getTaskById($id);
        $users = $this->userManager->getAllUsers();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task->title = $_POST['title'] ?? $task->title;
            $task->description = $_POST['description'] ?? $task->description;
            $task->assigned_to_id = isset($_POST['assigned_to_id']) ? (int) $_POST['assigned_to_id'] : $task->assigned_to_id;

            // Отримання статусу як рядка з enum TaskStatus
            $status = $_POST['status'] ?? $task->status;
            $task->status = TaskStatus::tryFrom($status)?->value ?? $task->status;

            $this->taskManager->updateTask($task);
            header('Location: /tasks');
            exit;
        }

        require __DIR__ . '/../views/task_form.php';
    }

    public function deleteTask(int $id): void
    {
        $task = $this->taskManager->getTaskById($id);
        if ($task) {
            $this->taskManager->deleteTask($task);
        }
        header('Location: /tasks');
        exit;
    }
}
