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


    public static function guardarApi()
    {
        try {
            $nombre = $_POST['usu_nombre'];
            $apellido = $_POST['usu_apellido'];
            $usuario = $_POST['usu_catalogo'];
            $password = $_POST['usu_password'];
    
            // Aquí se valida si ya existe un usuario con el mismo nombre de usuario
            $usuarioExistente = Usuario::fetchFirst("SELECT * FROM usuario WHERE usu_catalogo = '$usuario'");
            if ($usuarioExistente) {
                echo json_encode([
                    'mensaje' => 'El nombre de usuario ya está en uso',
                    'codigo' => 0
                ]);
                return;
            }
    
            // Aquí se crea un nuevo objeto Usuario para guardar en la base de datos
            $nuevoUsuario = new Usuario([
                'usu_nombre' => $nombre,
                'usu_apellido' => $apellido,
                'usu_catalogo' => $usuario,
                'usu_password' => password_hash($password, PASSWORD_DEFAULT),
                'usu_situacion' => 1
            ]);
    
            $resultado = $nuevoUsuario->guardar();
    
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