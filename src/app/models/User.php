<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Database;
use PDO;

class User
{
    public int $id;

    public string $username;

    public string $email;

    public string $password;

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // Реєстрація користувача
    public function register(): bool
    {
        $stmt = $this->db->getPdo()->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
        return $stmt->execute([
            'username' => $this->username,
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_DEFAULT),
        ]);
    }

    // Авторизація користувача
    public function login(string $username, string $password): bool
    {
        $stmt = $this->db->getPdo()->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $this->id = (int) $user['id'];
            $this->username = $user['username'];
            $this->email = $user['email'];
            return true;
        }

        return false;
    }
}
