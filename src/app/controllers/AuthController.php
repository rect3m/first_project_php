<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Database;
use App\Managers\UserManager;
use App\Models\User;

class AuthController
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function loginPage(): void
    {
        require __DIR__ . '/../views/login.php';
    }

    public function login(): void
    {
        // Отримуємо дані з форми
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Перевіряємо, чи не пусті значення
        if (!empty($username) && !empty($password)) {
            // Створюємо новий об'єкт користувача
            $user = new User($this->db);

            // Викликаємо метод логінації
            if ($user->login($username, $password)) {
                // Якщо успішно, ініціюємо сесію і перенаправляємо на сторінку завдань
                session_start();
                $_SESSION['user_id'] = $user->id;

                $_SESSION['username'] = $user->username;
                header('Location: /home');
                exit();
            }
            echo 'Неправильний логін або пароль';

        } else {
            echo 'Будь ласка, заповніть всі поля.';
        }
    }

    public function registerPage(): void
    {
        require __DIR__ . '/../views/register.php';
    }

    public function register(): void
    {
        // Отримуємо дані з форми
        $username = $_POST['username'] ?? '';

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Перевіряємо, чи не пусті значення
        if (!empty($username) && !empty($email) && !empty($password)) {
            // Створюємо новий об'єкт користувача
            $user = new User($this->db);
            $user->username = $username;
            $user->email = $email;
            $user->password = $password;

            // Викликаємо метод реєстрації
            if ($user->register()) {
                // Якщо успішно, перенаправляємо на головну сторінку або сторінку входу
                header('Location: /home');
                exit();
            }

            echo 'Помилка реєстрації. Спробуйте ще раз.';

        } else {
            echo 'Будь ласка, заповніть всі поля.';
        }
    }

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
        exit();
    }

    public function changePassword(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userManager = new UserManager($this->db->getPdo());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Перевірка на збіг нового пароля з підтвердженням
            if ($newPassword !== $confirmPassword) {
                echo 'Passwords do not match.';
                return;
            }

            // Отримуємо поточного користувача для перевірки поточного пароля
            $user = $userManager->getUserById($userId);
            if (!password_verify($currentPassword, $user['password'])) {
                echo 'Current password is incorrect.';
                return;
            }

            // Оновлення пароля
            if ($userManager->updatePassword($userId, $newPassword)) {
                header('Location: /home');
            } else {
                echo 'Failed to change password.';
            }
        }

        require __DIR__ . '/../views/change_password.php';
    }
}
