import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const formulario = document.querySelector('form');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');
const divPassword = document.getElementById('usu_password');
const divUsuario = document.getElementById('permiso_usuario');
const divRol = document.getElementById('permiso_rol');

divPassword.parentElement.style.display = 'none';

btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';

let contador = 1;
const datatable = new DataTable('#tablaAsignaciones', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'USUARIO',
            data: 'permiso_usuario'
        },
        {
            title: 'PERMISO',
            data: 'permiso_rol'
        },
        {
            title: 'ESTADO',
            data: 'usu_estado',
            render: (data, type, row, meta) => {
                if (data.trim() === '2') {
                    return 'Activo';
                } else if (data.trim() === '3') {
                    return 'Desactivado';
                } else if (data.trim() === '1') {
                    return 'Pendiente';
                } else {
                    return ''; 
                }
            }
        },
        {
            title: 'MODIFICAR PASSWORD',
            data: 'permiso_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-usuario='${row.permiso_usuario}' data-rol='${row.permiso_rol}' data-password='${row.usu_password}'>Modificar</button>`
        },
        {
            title: 'ELIMINAR',
            data: 'permiso_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
        {
            title: 'ACTIVAR / DESACTIVAR',
            data: 'usu_estado',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                if (data.trim() === '1') {
                    return `<button class="btn btn-success" data-id='${row['usu_id']}' >Activar</button>`;
                } else if (data.trim() === '2') {
                    return `<button class="btn btn-info" data-id='${row['usu_id']}' >Desactivar</button>`;
                } else if (data.trim() === '3') {
                    return `<button class="btn btn-success" data-id='${row['usu_id']}' >activar</button>`;
                }
            }
            
        },
    ]
});

const guardar = async (evento) => {
    evento.preventDefault();

    const permiso_usuario = formulario.permiso_usuario.value;
    const permiso_rol = formulario.permiso_rol.value;

    if (permiso_usuario === '' || permiso_rol === '') {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario);
    body.delete('permiso_id');
    const url = '/parcial_moralesbatz/API/asignaciones/guardar';
    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success';
                buscar();
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
                break;

            default:
                break;
        }
        Toast.fire({
            icon,
            text: mensaje
        });
    } catch (error) {
        console.log(error);
    }
};

const buscar = async () => {
    let permiso_usuario = formulario.permiso_usuario.value;
    let permiso_rol = formulario.permiso_rol.value;
    const url = `/parcial_moralesbatz/API/asignaciones/buscar?permiso_usuario=${permiso_usuario}&permiso_rol=${permiso_rol}`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        datatable.clear().draw();
        if (data) {
            contador = 1;
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }

    } catch (error) {
        console.log(error);
    }
}

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const usuario = button.dataset.usuario;
    const rol = button.dataset.rol;
    const password = button.dataset.password;

    const dataset = {
        id,
        usuario,
        rol,
        password
    };
    // console.log(dataset)
    // return
    colocarDatos(dataset);
    const body = new FormData(formulario);
    body.append('permiso_id', id);
    body.append('usu_password', password);
    body.append('permiso_usuario', usuario); 
    body.append('permiso_rol', rol); 
};

const colocarDatos = (dataset) => {
    formulario.permiso_id.value = dataset.id;
    formulario.permiso_usuario.value = dataset.usuario;
    formulario.permiso_rol.value = dataset.rol;
    // const passwordInput = formulario.usu_password;
    // formulario.usu_password.value = dataset.password;
    // passwordInput.readOnly = true;

    divPassword.parentElement.style.display = ' block';
    
    btnGuardar.disabled = true;
    btnGuardar.parentElement.style.display = 'none';
    btnBuscar.disabled = true;
    btnBuscar.parentElement.style.display = 'none';
    btnModificar.disabled = false;
    btnModificar.parentElement.style.display = '';
    btnCancelar.disabled = false;
    btnCancelar.parentElement.style.display = '';
}

const modificar = async () => {
    if (!formulario.permiso_usuario.value || !formulario.permiso_rol.value) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los campos antes de modificar la contraseña'
        });
        return;
    }

 
    const body = new FormData(formulario);
    body.delete('permiso_id');
    const url = '/parcial_moralesbatz/API/asignaciones/guardar';
    const config = {
        method: 'POST',
        body
    };


    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        // console.log(data)
        // return

        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
              
                formulario.reset();
                icon = 'success';
                buscar()
                cancelarAccion();
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
                break;

            default:
                break;
        }
        Toast.fire({
            icon,
            text: mensaje
        });
    } catch (error) {
        console.log(error);
    }
};

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id
    // console.log(id)
    if(await confirmacion('warning','¿Desea eliminar este registro?')){
        const body = new FormData()
        body.append('permiso_id', id)
        const url = '/parcial_moralesbatz/API/asignaciones/eliminar';
        const headers = new Headers();
        headers.append("X-Requested-With","fetch");
        const config = {
            method : 'POST',
            body
        }
        try {
            const respuesta = await fetch(url, config)
            const data = await respuesta.json();
            // console.log(data)
            // return
            const {codigo, mensaje,detalle} = data;
    
            let icon = 'info'
            switch (codigo) {
                case 1:
                    icon = 'success'
                    buscar();
                    break;
            
                case 0:
                    icon = 'error'
                    console.log(detalle)
                    break;
            
                default:
                    break;
            }
    
            Toast.fire({
                icon,
                text: mensaje
            })
    
        } catch (error) {
            console.log(error);
        }
    }
}
const cancelarAccion = () => {
    divPassword.parentElement.style.display = 'none';
    btnGuardar.disabled = false
    btnGuardar.parentElement.style.display = ''
    btnBuscar.disabled = false
    btnBuscar.parentElement.style.display = ''
    btnModificar.disabled = true
    btnModificar.parentElement.style.display = 'none'
    btnCancelar.disabled = true
    btnCancelar.parentElement.style.display = 'none'
   
}
const activar = async (e) => {
    const button = e.target;
    const id = button.dataset.id
    
    console.log(id)
    if(await confirmacion('warning','¿Desea activar este usuario?')){
        const body = new FormData()
        body.append('usu_id', id)
        const url = '/parcial_moralesbatz/API/asignaciones/activar';
        const headers = new Headers();
        headers.append("X-Requested-With","fetch");
        const config = {
            method : 'POST',
            body
        }
        try {
            
            const respuesta = await fetch(url, config)    
            const data = await respuesta.json();
            const {codigo, mensaje} = data;
            // console.log(data)
            // return
            let icon = 'info'
            switch (codigo) {
                case 1:
                    icon = 'success'
                    buscar();
                    break;
            
                case 0:
                    icon = 'error'
                    console.log(mensaje)
                    break;
            
                default:
                    break;
            }
    
            Toast.fire({
                icon,
                text: mensaje
            })
    
        } catch (error) {
            console.log(error);
        }
    }
}

const desactivar = async (e) => {
    const button = e.target;
    const id = button.dataset.id
    
    console.log(id)
    if(await confirmacion('warning','¿Desea desactivar este usuario?')){
        const body = new FormData()
        body.append('usu_id', id)
        const url = '/parcial_moralesbatz/API/asignaciones/desactivar';
        const headers = new Headers();
        headers.append("X-Requested-With","fetch");
        const config = {
            method : 'POST',
            body
        }
        try {
            
            const respuesta = await fetch(url, config)    
            const data = await respuesta.json();
            const {codigo, mensaje} = data;
    
            let icon = 'info'
            switch (codigo) {
                case 1:
                    icon = 'success'
                    buscar();
                    break;
            
                case 0:
                    icon = 'error'
                    console.log(mensaje)
                    break;
            
                default:
                    break;
            }
    
            Toast.fire({
                icon,
                text: mensaje
            })
    
        } catch (error) {
            console.log(error);
        }
    }
}
buscar();
datatable.on('click','.btn-success', activar )
datatable.on('click','.btn-info', desactivar )
datatable.on('click','.btn-danger', eliminar )
formulario.addEventListener('submit', guardar);
btnCancelar.addEventListener('click', cancelarAccion)
btnBuscar.addEventListener('click', buscar);
datatable.on('click','.btn-warning', traeDatos )
btnModificar.addEventListener('click', modificar)
