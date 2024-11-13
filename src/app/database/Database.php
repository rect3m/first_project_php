<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=localhost;dbname=task_manager',
                'rect2m',
                'R04051971r'
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Підключення не вдалося: ' . $e->getMessage());
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
