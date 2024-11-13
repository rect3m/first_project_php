<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use App\Database\Database;
use App\Router\Router;

$db = new Database();

$router = new Router($db);
$router->resolve();
