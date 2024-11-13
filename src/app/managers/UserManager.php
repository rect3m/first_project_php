<?php

declare(strict_types=1);

namespace App\Managers;

use PDO;

class UserManager
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->query('SELECT id, username AS name FROM users');

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function updatePassword(int $userId, string $newPassword): bool
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUserById(int $userId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null; // Повертаємо null, якщо користувач не знайдений
    }
}
