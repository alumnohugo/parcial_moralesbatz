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
            'roles' => $roles,
            'usu_password' => $usuario
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
    
   
    public static function buscarAPI()
    {
        $usu_id = $_GET['usu_id'];
        $rol_id = $_GET['rol_id'];

        $sql = "SELECT
        p.permiso_id,
        u.usu_nombre AS permiso_usuario,
        u.usu_id,
        r.rol_nombre AS permiso_rol,
        r.rol_id,
        u.usu_situacion AS usu_estado
    FROM
        usuario u
    LEFT JOIN
        permiso p ON u.usu_id = p.permiso_usuario
    LEFT JOIN
        rol r ON p.permiso_rol = r.rol_id
    WHERE
        u.usu_situacion IN (1, 2, 3) OR p.permiso_situacion IN (1, 2, 3) OR p.permiso_id IS NULL
     ";
    
    if ($usu_id != '') {
        $sql .= " AND usuarios.usu_id = '$usu_id'";
    }
    
    if ($rol_id != '') {
        $sql .= " AND roles.rol_id = '$rol_id'";
    }

        try {

            $permisos = Asignacion::fetchArray($sql);

            echo json_encode($permisos);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    public static function modificarAPI()
    {
        try {
           
            $datos = $_POST;
            var_dump($_POST);
            exit;
           
            if (!isset($datos['permiso_id'])) {
                echo json_encode([
                    'mensaje' => 'El ID del permiso es necesario para actualizar',
                    'codigo' => 0
                ]);
                return;
            }
    
        
            $permiso = new Asignacion($datos);
         
            $resultado = $permiso->actualizar();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al actualizar el registro',
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
    
    
    public static function eliminarAPI()
    {
        try {
            $permiso_id = $_POST['permiso_id'];
            $permiso = Asignacion::find($permiso_id);
    
            $permiso->permiso_rol = null;
            $permiso->permiso_situacion = 0;
            
            $resultado = $permiso->actualizar();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Roles quitados correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al quitar los roles',
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
    
    public static function activarAPI(){
        try {
            $usu_id = $_POST['usu_id'];
            $sql = "UPDATE usuario
            SET usu_situacion = CASE
                WHEN usu_situacion IN (1, 3) THEN 2
                ELSE usu_situacion
            END
            WHERE usu_id = $usu_id
            AND usu_situacion IN (1, 2, 3)";
            $params = array(':usu_id' => $usu_id);
            $resultado = Asignacion::SQL($sql, $params);
    
            if ($resultado == 1) {
                echo json_encode([
                    'mensaje' => 'Usuario activado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al activar el usuario',
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
    
    
    public static function desactivarAPI(){
        try {
            $usu_id = $_POST['usu_id'];
            $sql = "UPDATE usuario
            SET usu_situacion = CASE
                WHEN usu_situacion = 2 THEN 3
                ELSE usu_situacion
            END
            WHERE usu_id = $usu_id
            AND usu_situacion IN (1, 2, 3);
            ";
            $params = array(':usu_id' => $usu_id);
            $resultado = Asignacion::SQL($sql, $params);
    
            if ($resultado == 1) {
                echo json_encode([
                    'mensaje' => 'Usuario desactivado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al desactivar el usuario',
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
