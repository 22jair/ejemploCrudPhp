<?php
include __DIR__ . '/../controller/UnidadMedidaController.php';

$controller = new UnidadMedidaController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $controller->porId($_GET['id']);
        } else {
            $controller->listar();
        }
        break;
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'), true);
        $controller->agregar($_POST);
        break;
    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'), true);
        $controller->actualizar($_PUT);
        break;
    case 'DELETE':                
        if(isset($_GET['id'])){
            $controller->eliminar($_GET['id']);
        }      
        break;
}
