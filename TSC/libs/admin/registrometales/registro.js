// LISTAR USUARIOS
async function getUsuarios(){
    let response = await get("landsend","registrometales","getusuarios",{});
    setComboSimple("cbousuario",response,"NOMBRES","IDUSUARIO");
}

// LISTAR REGISTROS
async function getRegistros(){
    let response = await get("landsend","registrometales","getregistros");
    // console.log(response);
    let tr = "";
    
    response.forEach((obj)=>{
        tr += `
            <tr>
                <td nowrap> ${obj.PO} </td>
                <td nowrap> ${obj.FECHA} </td>
                <td nowrap> ${obj.NOMBRES} </td>
                <td nowrap> ${obj.METODO} </td>
                <td nowrap> ${obj.NOTAS} </td>
                <td nowrap> 

                    <a href='#' style='color:red' data-id='${obj.IDREGISTRO}' title='Eliminar' class='mr-1 eliminar'> 
                        <i class='fas fa-trash'></i>
                    </a>

                    <a href='#' class='ml-1 modificar' 
                        data-id='${obj.IDREGISTRO}' 
                        data-bol='${obj.BOL}' 
                        data-po='${obj.PO}' 
                        data-fecha='${obj.FECHA}' 
                        data-usuario='${obj.IDUSUARIO}' 
                        data-nota='${obj.NOTAS}' 
                        data-aca='${obj.VALIDADOACABADOS}' 
                        data-cal='${obj.VALIDADOCALIDAD}' 
  
                        title='Modificar'>  
                        <i class='fas fa-edit'></i>
                    </a>

                </td>
            </tr>
        `;
    });


    ArmarDataTable("datos",tr,false,true,false,true);
}

// REGISTRAR METAL
async function setRegistro(){
    
    var datosj = [
        ObjetoValidacion(IDREGISTRO,"",false),
        ObjetoValidacion(null,"txtpo",true),
        ObjetoValidacion(null,"txtbol",false),
        ObjetoValidacion(null,"txtfecha",false),
        ObjetoValidacion(null,"cbousuario",true),
        ObjetoValidacion($("#rdbmetodo").prop("checked") ? "Hand held" : "" ,"rdbmetodo",false),
        ObjetoValidacion(null,"txtnota",false),
        ObjetoValidacion($("#chkacabados").prop("checked") ? "1" : "0" ,"chkacabados",false),
        ObjetoValidacion($("#chkcalidad").prop("checked") ? "1" : "0" ,"chkcalidad",false),
    ];


    var datos = ValidarFormulario(datosj);

    if(datos){
        MostrarCarga("Cargando...");
        await post("landsend","registrometales",IDREGISTRO == null ?"registrar" : "modificar",datos)
            .then(async (response) =>{
                // setMensaje(response);
                // console.log(response);
                if(response.success){
                    await getRegistros();
                    Resetear();
                    InformarMini(response.rpt);
                }else{
                    AdvertirMini(response.rpt);
                }

            })
            .catch( error =>{
                AdvertirMini(error);
            })

    }else{
        AdvertirMini("Complete los campos obligatorios");
    }

}

// EVENTO ENVIAR
frmregistro.addEventListener("submit",async (e)=>{
    e.preventDefault();
    await setRegistro();
})

// RESETAR
function Resetear(){
    $("#txtpo").val("");
    $("#txtbol").val("");
    $("#cbousuario").val("0");
    $("#txtnota").val("NONE");
    $("#btnregistrar").text("Registrar");
    IDREGISTRO = null;


}

// ELIMINAR SELECCIONAMOS
$("#tbodydatos").on('click','.eliminar',async function(){

    let id = $(this).data("id");
    let respuesta = await Preguntar("Confirme para eliminar");
    //console.log(id);
    if(respuesta.value){
        Eliminar(id);
    }

});

// ELIMINAR MODIFICAR
$("#tbodydatos").on('click','.modificar',async function(){

    IDREGISTRO = $(this).data("id");

    let bol = $(this).data("bol");
    let po = $(this).data("po");
    let fecha = $(this).data("fecha");
    let idusuario = $(this).data("usuario");
    let notas = $(this).data("nota");
    let aca = $(this).data("aca");
    let cal = $(this).data("cal");
    

    $("#txtbol").val(bol);
    $("#txtpo").val(po);
    $("#txtfecha").val(fecha);
    $("#cbousuario").val(idusuario);
    $("#txtnota").val(notas);
    $("#chkacabados").prop("checked", aca == "1" ? true : false);
    $("#chkcalidad").prop("checked", cal == "1" ? true : false);

    $("#btnregistrar").text("Modificar");


});


// ELIMINAR
function Eliminar(id){

    post("landsend","registrometales","eliminar",[id])
        .then(async (response)=> {
            if(response.success){
                await getRegistros();
                InformarMini(response.rpt);
            }else{
                AdvertirMini(response.rpt);
            }
        })
        .catch(error => {
            AdvertirMini("Ocurrio un error al eliminar");
            console.log(error);
        })

}