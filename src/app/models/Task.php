<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Database;
use App\Enums\TaskStatus;
use PDO;

class Task
{
    public int $id;

    public string $title;

    public ?string $description;

    public string $status;

    public int $creator_id;

    public ?int $assigned_to_id;

    public string $created_at;

    public string $updated_at;

    // Конструктор
    public function __construct(
        int $id,
        string $title,
        ?string $description,
        string $status,
        int $creator_id,
        ?int $assigned_to_id,
        string $created_at,
        string $updated_at
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->creator_id = $creator_id;
        $this->assigned_to_id = $assigned_to_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Створення нового завдання
    public static function create(
        PDO $db,
        string $title,
        ?string $description,
        int $creator_id
    ): self {
        $status = 'pending';  // Початковий статус
        $stmt = $db->prepare('INSERT INTO tasks (title, description, status, creator_id) VALUES (?, ?, ?, ?)');
        $stmt->execute([$title, $description, $status, $creator_id]);

        return new self(
            (int) $db->lastInsertId(),
            $title,
            $description,
            $status,
            $creator_id,
            null,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        );
    }

    // Оновлення завдання

    public function delete(PDO $db): bool
    {
        $stmt = $db->prepare('DELETE FROM tasks WHERE id = ?');
        return $stmt->execute([$this->id]);
    }

    // Видалення завдання
    
    public function changeStatus(PDO $db, string $status): bool
    {
        $this->status = $status;
        return $this->update($db);
    }

    // Зміна статусу завдання

    public function update(PDO $db): bool
    {
        $stmt = $db->prepare('UPDATE tasks SET title = ?, description = ?, status = ?, assigned_to_id = ?, updated_at = ? WHERE id = ?');
        return $stmt->execute([
            $this->title,
            $this->description,
            $this->status,
            $this->assigned_to_id,
            date('Y-m-d H:i:s'),
            $this->id,
        ]);
    }
}
