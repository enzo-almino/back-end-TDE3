<?php

require_once __DIR__ . '/../controllers/PacoteController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ReservaController.php';

$route = $_GET['route'] ?? (empty($_SESSION['usuario_id']) ? 'auth' : 'pacotes');
$action = $_GET['action'] ?? 'index';

switch ($route) {
    case 'pacotes':
        $controller = new PacoteController();

        match ($action) {
            'criar'   => $controller->criar(),
            'editar'  => $controller->editar(),
            'excluir' => $controller->excluir(),
            default   => $controller->index(),
        };
        break;

    case 'reservas':
        $controller = new ReservaController();

        match ($action) {
            'reservar' => $controller->reservar(),
            default    => $controller->minhas(),
        };
        break;

    case 'auth':
        $controller = new AuthController();

        match ($action) {
            'cadastro' => $controller->cadastro(),
            'logout'   => $controller->logout(),
            default    => $controller->login(),
        };
        break;

    default:
        echo "Página não encontrada.";
        break;
}
