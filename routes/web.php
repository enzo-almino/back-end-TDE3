<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controllers/PacoteController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ReservaController.php';
require_once __DIR__ . '/../controllers/AdminController.php';

$route = $_GET['route'] ?? (empty($_SESSION['usuario_id']) ? 'auth' : 'pacotes');
$action = $_GET['action'] ?? 'index';

switch ($route) {
    case 'pacotes':
        $controller = new PacoteController($pdo);

        match ($action) {
            'criar'   => $controller->criar(),
            'editar'  => $controller->editar(),
            'excluir' => $controller->excluir(),
            default   => $controller->index(),
        };
        break;

    case 'reservas':
        $controller = new ReservaController($pdo);

        match ($action) {
            'reservar' => $controller->reservar(),
            'todas'    => $controller->todas(),
            'excluir'  => $controller->excluir(),
            default    => $controller->minhas(),
        };
        break;

    case 'auth':
        $controller = new AuthController($pdo);

        match ($action) {
            'cadastro' => $controller->cadastro(),
            'logout'   => $controller->logout(),
            default    => $controller->login(),
        };
        break;

    case 'admin':
        $controller = new AdminController($pdo);

        match ($action) {
            'promover' => $controller->promover(),
            default    => $controller->usuarios(),
        };
        break;

    default:
        echo "Página não encontrada.";
        break;
}
