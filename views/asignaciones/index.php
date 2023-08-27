<div class="row justify-content-center mb-5">
    <h1>Asignaciones de roles</h1>
    <form class="col-lg-8 border bg-light p-3" id="formularioAsignaciones">
        <input type="Hidden" name="permiso_id" id="permiso_id">

        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <label for="select">USUARIOS </label>
                <select class="form-control" name="permiso_usuario" id="permiso_usuario">


                    <option value="">Seleccione un usuario</option>
                    <?php foreach ($usuarios as $usuario) { ?>
                        <option value="<?= $usuario['usu_id']  ?>"><?= $usuario['usu_nombre']  ?></option>
                    <?php  }  ?>
                </select>
            </div>
        </div>
        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <label for="select">ROLES</label>
                <select class="form-control" name="permiso_rol" id="permiso_rol">
                 
                    <option value="">Seleccione un rol</option>
                    <?php foreach ($rols as $rol) { ?>
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