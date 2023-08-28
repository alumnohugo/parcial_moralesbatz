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
        u.usu_situacion AS usu_estado,
        u.usu_password FROM
        permiso p
    INNER JOIN
        usuario u ON p.permiso_usuario = u.usu_id
    INNER JOIN
        rol r ON p.permiso_rol = r.rol_id
    WHERE
        p.permiso_situacion = 1;
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
            $permiso_id = $_POST['permiso_id'];
            $newPassword = $_POST['usu_password'];
            $nuevaContrasenaHasheada = password_hash($newPassword, PASSWORD_DEFAULT);
    
            $_POST['usu_password'] = $nuevaContrasenaHasheada;
    
            $permiso = new Asignacion([
                'permiso_id' => $permiso_id,
                'usu_password' => $nuevaContrasenaHasheada
            ]);
            $resultado = $permiso->actualizar();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Contraseña modificada correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al modificar la contraseña',
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
