import { validarFormulario, Toast,} from "../funciones";

const formulario = document.querySelector('form')
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');


btnModificar.disabled = true;
btnModificar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnCancelar.parentElement.style.display = 'none';
btnBuscar.disabled = true;
btnBuscar.parentElement.style.display = 'none';



const guardar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario, ['usu_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario);
    body.delete('usu_id');
    const url = '/parcial_moralesbatz/API/usuarios/guardar';
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
                // buscar();
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

formulario.addEventListener('submit', guardar);

