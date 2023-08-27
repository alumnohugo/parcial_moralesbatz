<?php
namespace Model;

class  Asignacion extends ActiveRecord{
    protected static $tabla = 'permiso';
    protected static $columnasDB = ['permiso_usuario','permiso_rol','permiso_situacion'];
    protected static $idTabla = 'permiso_id';


    public $permiso_id;
    public $permiso_usuario;
    public $permiso_rol;
    public $permiso_situacion;
    
    public function __construct($args =[])
    {
        $this->permiso_id = $args['permiso_id'] ?? null;
        $this->permiso_usuario = $args['permiso_usuario'] ?? '';
        $this->permiso_rol = $args['permiso_rol'] ?? '';
        $this->permiso_situacion = $args['permiso_situacion'] ??  1;
        
        
    }
}

?>