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
           
            $contrasenia = $_POST['usu_password'];
          
            $contraseniaHasheada = password_hash($contrasenia, PASSWORD_DEFAULT);
             
            $_POST['usu_password'] = $contraseniaHasheada;
               
            $usuario = new Usuario($_POST);
              
            $resultado = $usuario->crear();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
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

    public static function estadisticaUsu(Router $router){
        $router->render('usuarios/estadistica', []);
    
    }
    public static function detalleUsuariosAPI(){

        $sql = "SELECT usu_estado, COUNT(usu_id) AS cantidad_usuarios
        FROM usuario
        GROUP BY usu_estado";

        try {
            
            $usuarios = Usuario::fetchArray($sql);
    
            echo json_encode($usuarios);
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