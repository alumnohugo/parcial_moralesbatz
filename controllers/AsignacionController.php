<?php

namespace Controllers;
use Exception;
use Model\Asignacion;
// use Model\Rol;
use MVC\Router;

class AsignacionController{
    public static function index(Router $router) {
       
        $usuario= Asignacion::all();
        $rol= Asignacion::all();
        $usuarios = static::usuarios();
        $roles = static::roles();
        $router->render('asignaciones/index', [
            'permiso_usuario' => $usuario,
            'permiso_rol' => $rol,
            'usuarios' => $usuarios, 
            'roles' => $roles
       ]);
     
    
    }    
     
    public static function guardarApi(){
        // var_dump($_POST);
        // exit;
    
        
        try {
            $asignacion = new Asignacion($_POST);
           
            $resultado = $asignacion->crear();
           
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
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    
    public static function buscarApi()
    {
      
        $usu_nombre = $_GET['permiso_usuario'];
        $rol_nombre = $_GET['permiso_rol'];
       

        $sql = "SELECT
        u.usu_nombre AS usuario,
        r.rol_nombre AS rol,
        u.usu_situacion AS situacion_usuario,
        u.usu_password AS password
    FROM
        permiso p
    JOIN
        usuario u ON p.permiso_usuario = u.usu_id
    JOIN
        rol r ON p.permiso_rol = r.rol_id
    WHERE
        p.permiso_situacion = 1 ";

        if ($usu_nombre != '') {
            $sql .= " and LOWER(permiso_usuario) like LOWER ('%$usu_nombre%') ";
        }

        if ($rol_nombre != '') {
            $sql .= " and LOWER (permiso_rol) like LOWER ('%$rol_nombre%') ";
        }
        
        
        try {
            
            $asignacion = Asignacion::fetchArray($sql);
            header('Content-Type: application/json');

            echo json_encode($asignacion);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    public  static function roles()
    {
        
        
        $sql = "SELECT * FROM rol WHERE rol_situacion = 1 ";
        
        
        
        try {
            
            $roles = Asignacion::fetchArray($sql);
 
            if ($roles){
                
                return $roles; 
            }else {
                return 0;
            }
        } catch (Exception $e) {
            
        }
    }
    


    public  static function usuarios()
    {
        
        
        $sql = "SELECT * FROM usuario ";
        
        
        
        try {
            
            $usuarios = Asignacion::fetchArray($sql);
 
            if ($usuarios){
                
                return $usuarios; 
            }else {
                return 0;
            }
        } catch (Exception $e) {
            
        }
    }
    
}
