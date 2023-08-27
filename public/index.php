<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\UsuarioController;
use Controllers\AsignacionController;

use Model\Usuario;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

$router->get('/usuarios', [UsuarioController::class,'index']);
$router->post('/API/usuarios/guardar', [UsuarioController::class,'guardarApi']);

$router->get('/asignaciones', [AsignacionController::class,'index']);
$router->post('/API/asignaciones/guardar', [AsignacionController::class,'guardarApi']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
