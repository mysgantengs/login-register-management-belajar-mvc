<?php

require_once __DIR__. "/../vendor/autoload.php";

use Mys\percobaan\MVC\APP\Router;
use Mys\percobaan\MVC\Controller\HomeController;
use Mys\percobaan\MVC\Controller\UsersController;
use Mys\percobaan\MVC\Config\Database;

use Mys\percobaan\MVC\Middleware\MthNotMiddleware;
use Mys\percobaan\MVC\Middleware\MthMiddleware;

Database::getConnections("prod");

// Router::Add('GET', '/Product/([0-9a-zA-Z]*)/Jenis/([0-9a-zA-Z]*)', ProductController::class, 'Product');
Router::Add('GET', '/', HomeController::class, 'index', []);
Router::Add('GET', '/Users/Register', UsersController::class, 'Register', [MthNotMiddleware::class]);
Router::Add('POST', '/Users/Register', UsersController::class, 'PostRegister', [MthNotMiddleware::class]);
Router::Add('GET', '/Users/Login', UsersController::class, 'Login', [MthNotMiddleware::class]);
Router::Add('POST', '/Users/Login', UsersController::class, 'PostLogin', [MthNotMiddleware::class]);
Router::Add('GET', '/Users/Logout', HomeController::class, 'Logout', [MthMiddleware::class]);
Router::Add('GET', '/Users/UpdatePassword', UsersController::class, 'UpdatePassword', []);
Router::Add('POST', '/Users/UpdatePassword', UsersController::class, 'PostUpdatePassword', []);


Router::Run();

















