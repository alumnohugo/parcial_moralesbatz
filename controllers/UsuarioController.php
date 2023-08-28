<?php

namespace Controllers;
use Exception;
use Model\Usuario;
use MVC\Router;

class UsuarioController{
    public static function index(Router $router) {
        $usuario = Usuario::all();
        $router->render('usuarios/index', [
            'usuarios' => $usuario,
        ]);
  
       
    }


    public static function guardarApi() {
        try {
            $usuario = $_POST['usu_usuario'];
            $contrasenia = $_POST['usu_password'];
    
            // Verificar si el usuario ya existe
            $usuarioExistente = Usuario::fetchFirst("SELECT * FROM usuario WHERE usu_usuario = '$usuario'");
            if ($usuarioExistente) {
                echo json_encode([
                    'mensaje' => 'El nombre de usuario ya está en uso',
                    'codigo' => 0
                ]);
                return;
            }
    
            // Hashear la contraseña
            $contraseniaHasheada = password_hash($contrasenia, PASSWORD_DEFAULT);
            $_POST['usu_password'] = $contraseniaHasheada;
    
            // Crear un nuevo usuario
            $usuario = new Usuario($_POST);
            $resultado = $usuario->crear();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al guardar el registro',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    

    

   

}
 
?>