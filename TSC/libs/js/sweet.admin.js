// MOSTRAR CARGA
function MostrarCarga(mensaje = "Cargando..."){

    Swal.fire({
        title: mensaje,
        html: 'Esto puede tardar unos segundos',
        //timer: 2000,
        allowEscapeKey: false,
        allowOutsideClick: false,
        timerProgressBar: true,
        onBeforeOpen: () => {
            Swal.showLoading()
        }
    })    
}

function OcultarCarga() {
    Swal.hideLoading();
    Swal.clickConfirm();
}

// MENSAJE GENERAL
function setMensaje(response,autocierre,reload){

    let retornar = false;
    // console.log(response);
    if(response.success){
        retornar = true;
        Informar(response.rpt,autocierre,reload);
    }else{
        Advertir(response.rpt);
        retornar = false;
    }

    return retornar;

}

// INFORMAR
function Informar(mensaje,autocierre = false,reload = false){

    if(reload){
        setTimeout(()=>{
            location.reload();
        },autocierre+100);
    }

    if(autocierre){

        Swal.fire({
            icon: 'success',
            title: mensaje,
            text: 'Textile Sourcing Company',
            timer: autocierre,
            allowEscapeKey: false,
            allowOutsideClick: false
            // timerProgressBar: true,
        })

    }else{
        Swal.fire(mensaje,"Textile Sourcing Company","success");
    }
       
}

// INFORMAR MENSAJE
function InformarMensaje(mensaje){
    Swal.fire({
        icon: 'info',
        title: mensaje,
        text: 'Textile Sourcing Company'
        // timerProgressBar: true,
    })
}

// ADVERTIR
function Advertir(mensaje){
    Swal.fire(mensaje,"Textile Sourcing Company","warning")
}

//PREGUNTAR
async function Preguntar(pregunta){
    let resultado = await Swal.fire({
        title: pregunta,
        text: "Textile Sourcing Company",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar'
    });

    return resultado;
}

// OBTENER DATOS
async function Obtener(mensaje,tipo,value=""){

    // let valor = null;

    const { value: valor } = await Swal.fire({
        title: mensaje,
        input: tipo,
        inputValue: value,
        showCancelButton: true,
        inputValidator: (value) => {
          if (!value) {
            return 'Complete el campo'
          }
        }
      })

    return valor;

}

  
// TOAST
function InformarMini(mensaje, tiempo = false) {


    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: tiempo ? tiempo : 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: mensaje
    })
}

// TOAST ADVERTIR
function AdvertirMini(mensaje, tiempo = false) {


    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: tiempo ? tiempo : 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'error',
        title: mensaje
    })
}


 // OPCIONES SELECT
 async function getSelectValue(datos,id,valor,mensaje = "Seleccione"){

    let lista = {};

    // CONVERTIRMOS ARRAY A VALOR
    datos.forEach((obj)=>{
        lista[obj[id]] = obj[valor];
    });

    const {value:data} = await Swal.fire({
        title: mensaje,
        input: 'select',
        inputOptions: lista,
        inputPlaceholder: 'Seleccione',
        showCancelButton: true,
        inputValidator: (value) => {
            return new Promise((resolve) => {
              if (value == "") {
                resolve('Seleccione primero')
              }else{
                resolve();
              }
            })
          }
    })

    return data;
}