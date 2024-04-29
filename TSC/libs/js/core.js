// CONCATENA PARA UN TITULO
function Concat(titulo,texto){
    // console.log(titulo,texto)
    return ` <strong>${titulo}:</strong>  ${texto}`;
}


// AGREGA Y REMUEVE CLASES
function AddRemoveClass(input,class1,class2){
    $(`#${input}`).removeClass(class1);
    $(`#${input}`).addClass(class2);
}



// AGREGA ELEMTOS PARA VALIDACION
function ValidarFormulario(arraydatos){

    var array           = [];
    var valor           = "";
    var input           = "";
    var response        = true; 
    // console.log(arraydatos)

    for(let key of  arraydatos){
        // console.log(key)

        valor = key.data;
        input = key.input;

        // console.log()
        // SI ES OBLIGATORIO
        if(key.type){

            if(valor == null || valor == 0 || valor == ""){
                valor = $(`#${input}`).val().trim();
                if(valor == null || valor == 0 || valor == ""){
                    response = false;
                    $(`#${input}`).addClass("is-invalid");
                }else{
                    $(`#${input}`).removeClass("is-invalid");
                }
            }else{
                $(`#${input}`).removeClass("is-invalid");
            }

        }else{
            // SI NO TIENE VALOR AGREGAMOS EL DE SU INPUT
            if(valor == null){
                if(input != ""){
                    valor = $(`#${input}`).val().trim();
                }
            }
            // AGREGAMOS VALOR
        }

        array.push(valor);


    }

    return response ? array :false;



}

// CREA UN OBJETO CON LOS VALORES ASIGNAMOS
function ObjetoValidacion(valor,input,tipo){
    return   {
        data : valor,          
        input: input,
        type : tipo
    };
}

// TRY CATCH PARA FUNCIONES
async function TryCatch(fx){

    let result = {};

    try{
        result.success = true;
        result.rpt = await fx;
    }catch(error){

        result.success = false;
        result.rpt = error;
    }

    return result;
}
