// GET MAQUINAS AGREGADAS
async function getMaquinasAgregadas(idficha,tipo){


    let response  = await get("auditex-lavanderia","lavadoprenda","get-maquinas-agregadas",{
        idficha
    });

    let datos = [];

    for(let item of response){

        if(tipo == "PLANTA"){
            datos.push(item.IDLAVADORA);
        }

        if(tipo == "SERVICIO"){
            datos.push(item.IDTALLER);
        }

    }


                // MAQUINA O TALLER
    if( tipo == "SERVICIO" ){

        // document.getElementById(`lbl${id}`).innerText = "SERVICIO";
        let response = await get("auditex-lavanderia", "lavadoprenda", "get-talleres-lavanderia", {});
        setComboSimple("cbomaquinalavado",response,"DESCRIPCIONCORTA","IDTALLER",false,false);
        // OcultarCarga();
    }
    
    if(tipo == "PLANTA"){

        // document.getElementById(`lbl${id}`).innerText = "PLANTA";
        let response = await get("auditex-lavanderia", "lavadoprenda", "get-maquinas-lavanderia", {});
        setComboSimple("cbomaquinalavado",response,"DESC","IDLAVADORA",false,false);
        // OcultarCarga();

    }

    $("#cbomaquinalavado").val(datos).trigger("change");


}


// REGISTRO DE VALIDACION DE DOCUMENTACION
function saveValidacionDocumentacion(IDFICHA,estado = null,usuario){

    MostrarCarga();

    let chkfichatecnica     = document.getElementById("chkfichatecnica").checked ? '1' : '0';
    let chkprocesotransfer  = document.getElementById("chkprocesotransfer").checked ? '1' : '0';
    let chkprocesoestampado = document.getElementById("chkprocesoestampado").checked ? '1' : '0';
    let chkprocesobordado   = document.getElementById("chkprocesobordado").checked ? '1' : '0';
    let chkcodmaquinalavado   = document.getElementById("chkcodmaquinalavado").checked ? 'SERVICIO' : 'PLANTA';
    let cbocodigolavado     = document.getElementById("cbocodigolavado").value;
    let observacion         = document.getElementById("txtobservaciondocumentacion").value;

    // REGISTRO DE MAQUINAS DE LAVADOS
    let maquinasseleccionadas   = document.getElementById("cbomaquinalavado").selectedOptions;


    let parameters = [
        IDFICHA,            chkcodmaquinalavado,   cbocodigolavado,
        chkfichatecnica,    chkprocesotransfer, chkprocesoestampado, chkprocesobordado,
        estado,             observacion,        usuario
    ];

    // REGISTRO DE CABECERAS 
    post("auditex-lavanderia","lavadoprenda","set-lavadoprenda-validaciondocumento",parameters)
        .then(response => {

            if(response.success){
                // OcultarCarga();

                
                if(maquinasseleccionadas.length > 0){

                    for(let item of maquinasseleccionadas){

                        let idtaller    = "";
                        let idlavadora  = "";

                        if(chkcodmaquinalavado == "PLANTA"){
                            idlavadora = item.value;
                        }else{
                            idtaller = item.value;
                        }

                        let parameters = 
                        [
                            IDFICHA,    idtaller, idlavadora,usuario
                        ];
                        
                        post("auditex-lavanderia","lavadoprenda","set-maquinas-lavados",parameters)
                        .then(response => {


                            if(!response.success){
                                Advertir("Error registrando");
                            }

                        })
                        .catch(error => {   
                            Advertir("Ocurrio un error");
                        });



                        // console.log(item.value);
                    }

                }


                Informar("Item aprobado",1500);
                changeNavs( $("#nav_2") );
                $("#container-save-item1").addClass("d-none");

            }else{
                Advertir(response.rpt);
            }

            // console.log(response);
        })
        .catch(error => {   
            Advertir("Ocurrio un error");
        });

}



// REGISTRO DE DEFECTOS
function saveDefectos(IDFICHA,usuario){
    MostrarCarga();

    let cbodefectos                 = document.getElementById("cbodefectos").value;
    let txtcantidaddefectos         = document.getElementById("txtcantidaddefectos").value;
    let txtcomentariodefectos       = document.getElementById("txtcomentariodefectos").value;

    let parameters = [
        1,IDFICHA,            cbodefectos,   txtcantidaddefectos, txtcomentariodefectos,usuario
    ];

    console.log(parameters);

    post("auditex-lavanderia","lavadoprenda","set-lavadoprenda-defectos",parameters)
        .then(async (response) => {

            if(response.success){

                await getDefectos(IDFICHA);
                await getDefectosAgregados(IDFICHA);
                frmregistrodefectos.reset();
                
                OcultarCarga();
            }else{
                Advertir(response.rpt);
            }

            // console.log(response);
        })
        .catch((error) => {
            Advertir("Ocurrio un error");
        });
}

function moddefectos(suma,idficha,cantidad,iddfecto){

    MostrarCarga("Actualizando");
    let cantidadnew = cantidad + suma;
    updateDefectos(idficha,iddfecto,cantidadnew);

}

// MODIFICAR DEFECTOS
function updateDefectos(IDFICHA,iddfecto,cantidad){

    let parameters = [
        2,IDFICHA,            iddfecto,   cantidad,null
    ];

    post("auditex-lavanderia","lavadoprenda","set-lavadoprenda-defectos",parameters)
        .then(async (response) => {

            if(response.success){

                await getDefectos(IDFICHA);
                await getDefectosAgregados(IDFICHA);
                frmregistrodefectos.reset();
                
                OcultarCarga();
            }else{
                Advertir(response.rpt);
            }

            // console.log(response);
        })
        .catch((error) => {
            Advertir("Ocurrio un error");
        });

}

// OBTENEER LOS DEFECTOS
async function getDefectos(idficha){

    let response = await get("auditex-lavanderia","lavadoprenda","get-defectos",{idficha});
    setComboSimple("cbodefectos",response,"DESDEF","CODDEF");

}

// OBTENEER LOS DEFECTOS
async function getDefectosAgregados(idficha){

    // let datatable = 

    let response = await get("auditex-lavanderia","lavadoprenda","get-defectos-agregados",{idficha},true);

    $("#tbodydefectosagregados").html(response);
    $("#tbodydefectosresultado").html(response);


    // PARA ITEM DEFECTOS
    // ArmarDataTable_New("defectosagregados",response,false,false,false,false,false,true);

    // PARA ITEM RESULTADO
    // ArmarDataTable_New("defectosresultado",response,false,false,false,false,false,true);



}


// CERRAR REGISTROS
function cerrarregistrodefectos(idficha,comentario,usuario){

    MostrarCarga();

    post("auditex-lavanderia","lavadoprenda","set-lavadoprenda-cerrardefecto",[idficha,comentario,usuario])
            .then(async (response) => {

                if(response){

                    await getDefectosAgregados(idficha);


                    $("#lblDefectos").text("2. Defectos: "+response.RESULTADO);

                    if(response.BOL == 1){
                        Informar("Item " + response.RESULTADO,1500);
                    }

                    if(response.BOL == 0){
                        Advertir("Item " + response.RESULTADO + ", (La Cantidad de defectos supera la cantidad permitida)") ;
                    }
                    
                    changeNavs( $("#nav_3") );

                    $("#btn-save-item-agregar-2").remove();  
                    $("#container-save-item2").addClass("d-none");  


                    
                    // OcultarCarga();
                }else{
                    Advertir("Ocurrio un error al cerrar");
                }

                // console.log(response);
            })
            .catch((error) => {
                // console.log("erro",error);
                Advertir("Ocurrio un error");
            });

}

// CAMBIA NAVS
function changeNavs(nav){

    $(".opcionesnav").removeClass("active");
    $(".containerdatos").addClass("d-none");

    let container = $(nav).data("container");

    $("#container_"+container).removeClass("d-none");
    $(nav).addClass("active");

}