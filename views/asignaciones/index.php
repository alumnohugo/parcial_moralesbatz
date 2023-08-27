<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioAsignaciones">
        <input type="Hidden" name="asig_id" id="asig_id">

        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <label for="select">Alumnos del curso </label>
                <select class="form-control" name="asig_alumno" id="asig_alumno">


                    <option value="">Seleccione el nombre del alumno</option>
                    <?php foreach ($alumnos as $alumno) { ?>
                        <option value="<?= $alumno['alumno_id']  ?>"><?= $alumno['alumno_nombre']  ?><?= " " ?><?= $alumno['alumno_apellido']  ?></option>
                    <?php  }  ?>
                </select>
            </div>
        </div>
        <div class="row mb-4 mt-3">
            <div class="col-lg-12">
                <label for="select">Materias</label>
                <select class="form-control" name="asig_materia" id="asig_materia">
                 
                    <option value="">Seleccione una materia </option>
                    <?php foreach ($materias as $materia) { ?>
                        <option value="<?= $materia['materia_id']  ?>"><?= $materia['materia_nombre']  ?></option>
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