<?php

declare(strict_types=1);

namespace App\Managers;

use App\Database\Database;
use App\Models\Task;
use PDO;

class TaskManager
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function addTask(string $title, ?string $description, int $creator_id): Task
    {
        return Task::create($this->db, $title, $description, $creator_id);
    }

    public function updateTask(Task $task): bool
    {
        return $task->update($this->db);
    }

    public function deleteTask(Task $task): bool
    {
        return $task->delete($this->db);
    }

    public function getTasksByUser(int $user_id): array
    {
        $stmt = $this->db->prepare('SELECT * FROM tasks WHERE creator_id = ? OR assigned_to_id = ?');
        $stmt->execute([$user_id, $user_id]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn ($taskData) => new Task(
            (int) $taskData['id'],
            $taskData['title'],
            $taskData['description'],
            $taskData['status'],
            (int) $taskData['creator_id'],
            $taskData['assigned_to_id'] ? (int) $taskData['assigned_to_id'] : null,
            $taskData['created_at'],
            $taskData['updated_at']
        ), $tasks);
    }

    public function getTaskById(int $id): ?Task
    {
        $stmt = $this->db->prepare('SELECT * FROM tasks WHERE id = ?');
        $stmt->execute([$id]);
        $taskData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $taskData ? new Task(
            (int) $taskData['id'],
            $taskData['title'],
            $taskData['description'],
            $taskData['status'],
            (int) $taskData['creator_id'],
            $taskData['assigned_to_id'] ? (int) $taskData['assigned_to_id'] : null,
            $taskData['created_at'],
            $taskData['updated_at']
        ) : null;
    }
}
