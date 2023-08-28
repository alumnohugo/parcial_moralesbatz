<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioAsignaciones">
        <h1>Asignación de roles</h1>
        <input type="Hidden" name="permiso_id" id="permiso_id">

     
        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <div id="usu_password"  class="col">
                    <label for="usu_password">precione modificar para cambiar la contrasena</label>
                    <input type="password" name="usu_password" id="usu_password" class="form-control">
                </div>
            </div>
        </div>

    
        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <div id="permiso_usuario"  class="col">
                    <label for="select">USUARIOS</label>
                    <select class="form-control" name="permiso_usuario" id="permiso_usuario">
                        <option value="">Seleccione un usuario</option>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <option value="<?= $usuario['usu_id']  ?>"><?= $usuario['usu_nombre']  ?></option>
                        <?php  }  ?>
                    </select>
                </div>
            </div>
        </div>

      
        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <label for="select">ROLES</label>
                <select class="form-control" name="permiso_rol" id="permiso_rol">
                    <option value="">Seleccione un rol</option>
                    <?php foreach ($roles as $rol) { ?>
                        <option value="<?= $rol['rol_id']  ?>"><?= $rol['rol_nombre']  ?></option>
                    <?php  }  ?>
                </select>
            </div>
        </div>

     
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioAsignaciones" id="btnGuardar" data-saludo="hola" data-saludo2="hola2" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
            </div>
            <div class="col">
                <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
            </div>
            <div class="col">
                <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
            </div>
        </div>
    </form>
</div>


<div class="row justify-content-center ">
    <div class="col table-responsive" style="max-width: 70%; padding: 10px;">

        <table id="tablaAsignaciones" class="table table-bordered table-hover  ">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/asignaciones/index.js')  ?>"></script>