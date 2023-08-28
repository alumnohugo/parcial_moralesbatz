<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;

class DetalleController
{
    public static function estadistica(Router $router)
    {
            $router->render('usuarios/estadistica', []);
        
    }

    public static function detalleUsuariosAPI()
    {

        $sql = "SELECT
        CASE
            WHEN usu_situacion = 2 THEN 'Activo'
            WHEN usu_situacion = 3 THEN 'Inactivo'
        END AS Estado,
        COUNT(usu_id) AS Cantidad
    FROM usuario
    WHERE usu_situacion IN (2, 3)
    GROUP BY Estado ";

        try {

            $productos = Usuario::fetchArray($sql);

            echo json_encode($productos);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}