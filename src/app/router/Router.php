<?php

declare(strict_types=1);

namespace App\Router;

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\TaskController;
use App\Database\Database;
use App\Managers\TaskManager;
use App\Managers\UserManager;

class Router
{
    private array $routes = [];

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;

        $pdo = $this->db->getPdo();
        $taskManager = new TaskManager($pdo);
        $userManager = new UserManager($pdo);

        $taskController = new TaskController($taskManager, $userManager);

        // Додаємо маршрути
        $this->addRoute('GET', '/home', [HomeController::class, 'index']);
        $this->addRoute('GET', '/', [AuthController::class, 'loginPage']);
        $this->addRoute('POST', '/login', [AuthController::class, 'login']);
        $this->addRoute('GET', '/register', [AuthController::class, 'registerPage']);
        $this->addRoute('POST', '/register', [AuthController::class, 'register']);
        $this->addRoute('GET', '/logout', [AuthController::class, 'logout']);
        $this->addRoute('GET', '/change/password', [AuthController::class, 'changePassword']);
        $this->addRoute('POST', '/change/password', [AuthController::class, 'changePassword']);

        // Використовуємо один екземпляр TaskController для всіх маршрутів
        $this->addRoute('GET', '/tasks', [$taskController, 'listTasks']);
        $this->addRoute('GET', '/tasks/create', [$taskController, 'createTask']);
        $this->addRoute('POST', '/tasks/create', [$taskController, 'createTask']);
        $this->addRoute('GET', '/tasks/edit/{id}', [$taskController, 'editTask']);
        $this->addRoute('POST', '/tasks/edit/{id}', [$taskController, 'editTask']);
        $this->addRoute('GET', '/tasks/delete/{id}', [$taskController, 'deleteTask']);
        $this->addRoute('POST', '/tasks/assign/{id}', [$taskController, 'assignTask']);
    }

    public function addRoute(string $method, string $path, array $action): void
    {
        $this->routes[$method][$path] = $action;
    }

    public function resolve(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Перевірка на статичний файл (CSS, JS, зображення тощо)
        if (preg_match('/\.(?:css|js|jpg|jpeg|png|gif)$/', $path)) {
            // Якщо файл існує, повертаємо його напряму
            $filePath = __DIR__ . '/styles/styles.css' . $path; // Вкажіть правильний шлях до публічної папки
            if (file_exists($filePath)) {
                header('Content-Type: ' . mime_content_type($filePath));
                readfile($filePath);
                return;
            }
            echo '404 Not Found';
            return;

        }

        // Обробка звичайних маршрутів
        foreach ($this->routes[$method] as $routePath => $action) {
            // Заміна параметрів у маршруті на регулярні вирази
            $routeRegex = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
            $routeRegex = '#^' . $routeRegex . '$#';

            if (preg_match($routeRegex, $path, $matches)) {
                array_shift($matches); // Видаляємо перший елемент, оскільки це повне співпадіння
                [$controller, $action] = $action;

                // Створення об'єкта контролера, якщо потрібно
                if (is_string($controller)) {
                    $controller = new $controller($this->db);
                }

                // Перетворення всіх параметрів на int, якщо це можливо
                $matches = array_map(
                    fn ($param) => is_numeric($param) ? (int) $param : $param,
                    $matches
                );

                // Виклик методу контролера з параметрами
                $controller->{$action}(...$matches);
                return;
            }
        }

        echo '404 Not Found';
    }
}
