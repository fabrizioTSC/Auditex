// GET MAQUINAS AGREGADAS
async function getMaquinasAgregadas(idficha,tipo){


    let response  = await get("auditex-lavanderia","lavadopanio","get-maquinas-agregadas",{
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
        let response = await get("auditex-lavanderia", "lavadopanio", "get-talleres-lavanderia", {});
        setComboSimple("cbomaquinalavado",response,"DESCRIPCIONCORTA","IDTALLER",false,false);
        // OcultarCarga();
    }
    
    if(tipo == "PLANTA"){

        // document.getElementById(`lbl${id}`).innerText = "PLANTA";
        let response = await get("auditex-lavanderia", "lavadopanio", "get-maquinas-lavanderia", {});
        setComboSimple("cbomaquinalavado",response,"DESC","IDLAVADORA",false,false);
        // OcultarCarga();

    }

    
    $("#cbomaquinalavado").val(datos).trigger("change");


}

// CAMBIA NAVS
function changeNavs(nav){

    $(".opcionesnav").removeClass("active");
    $(".containerdatos").addClass("d-none");

    let container = $(nav).data("container");

    $("#container_"+container).removeClass("d-none");
    $(nav).addClass("active");

}

// OBTENEER LOS DEFECTOS
async function getDefectos(idficha){

    let response = await get("auditex-lavanderia","lavadopanio","get-defectos",{idficha});
    setComboSimple("cbodefectos",response,"DESDEF","CODDEF");

}

// OBTENEER LOS DEFECTOS
async function getDefectosAgregados(idficha){

    // let datatable = 

    let response = await get("auditex-lavanderia","lavadopanio","get-defectos-agregados",{idficha},true);

    $("#tbodydefectosagregados").html(response);
    $("#tbodydefectosresultado").html(response);


    // PARA ITEM DEFECTOS
    // ArmarDataTable_New("defectosagregados",response,false,false,false,false,false,true);

    // PARA ITEM RESULTADO
    // ArmarDataTable_New("defectosresultado",response,false,false,false,false,false,true);



}



// REGISTRO DE VALIDACION DE DOCUMENTACION
function setValidacionDocumentacion(IDFICHA,usuario){

    MostrarCarga();

    let chkfichatecnica                 = $("#chkfichatecnica").prop("checked") ? "1" : "0"; 
    let chkmuestraaprobada              = $("#chkmuestraaprobada").prop("checked") ? "1" : "0";
    let chkreportecorte                 = $("#chkreportecorte").prop("checked") ? "1" : "0";
    let chkcomplementorectilineo        = $("#chkcomplementorectilineo").prop("checked") ? "1" : "0";
    // let cbomaquinalavado                = $("#cbomaquinalavado").val();
    // let cbomaquinasecadora              = $("#cbomaquinasecadora").val();
    let cbocodigolavado                 = $("#cbocodigolavado").val();
    let txtobservaciondocumentacion     = $("#txtobservaciondocumentacion").val();
    let chkcodmaquinalavado   = document.getElementById("chkcodmaquinalavado").checked ? 'SERVICIO' : 'PLANTA';



    // REGISTRO DE MAQUINAS DE LAVADOS
    let maquinasseleccionadas   = document.getElementById("cbomaquinalavado").selectedOptions;



    let parameters = [
        IDFICHA,            chkcodmaquinalavado,    cbocodigolavado,
        chkfichatecnica,    chkmuestraaprobada, chkreportecorte, chkcomplementorectilineo,
        usuario,            'APROBADO',             txtobservaciondocumentacion
    ];

    post("auditex-lavanderia","lavadopanio","set-lavadopanio-validaciondocumento",parameters)
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
                        
                        post("auditex-lavanderia","lavadopanio","set-maquinas-lavados",parameters)
                        .then(response => {
            
                            if(!response.success){
                                Advertir("Error registrando");
                            }
            
                        })
                        .catch(error => {   
                            Advertir("Ocurrio un error");
                        });
            

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


// REGISTRO DE VALIDACION DE DOCUMENTACION
function setVerificacion(IDFICHA,usuario){

    MostrarCarga();

    let matching_verificacion               = $("#matching_verificacion").prop("checked") ? "1" : "0"; 
    let tacto_verificacion                  = $("#tacto_verificacion").prop("checked") ? "1" : "0";
    let aparienciapano_verificacion         = $("#aparienciapano_verificacion").prop("checked") ? "1" : "0";
    let nivelpilling_verificacion           = $("#nivelpilling_verificacion").prop("checked") ? "1" : "0";

    let txtdensidadbefore               = $("#txtdensidadbefore").val();
    let txtdensidadafter                = $("#txtdensidadafter").val();
    let txtlargopanoasig                = $("#txtlargopanoasig").val();
    let txtobservacion_verificacion     = $("#txtobservacion_verificacion").val();

    

    let parameters = [
        IDFICHA,            txtdensidadbefore,   txtdensidadafter, txtlargopanoasig,
        matching_verificacion,    tacto_verificacion, aparienciapano_verificacion, nivelpilling_verificacion,
        usuario,            'APROBADO',             txtobservacion_verificacion
    ];

    post("auditex-lavanderia","lavadopanio","set-lavadopanio-verificacion",parameters)
        .then(response => {

            if(response.success){
                Informar("Item aprobado",1500);
                changeNavs( $("#nav_3") );
                $("#container-save-item2").addClass("d-none");

            }else{
                Advertir(response.rpt);
            }

        })
        .catch(error => {   
            Advertir("Ocurrio un error");
        });

}


// REGISTRO DE DEFECTOS
function saveDefectos(IDFICHA,cbodefectos,txtcantidaddefectos,usuario){
    MostrarCarga();

    
    let txtcomentariodefectos       = document.getElementById("txtcomentariodefectos").value;

    let parameters = [
        IDFICHA,            cbodefectos,   txtcantidaddefectos, txtcomentariodefectos,usuario
    ];

    post("auditex-lavanderia","lavadopanio","set-defectos-detalle",parameters)
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


// UPDATE DEFECTOS
function updateDefectos(cant_new,IDFICHA,iddfecto,cantidad){


    let cantidad_new = parseFloat(cantidad) + parseFloat(cant_new);
    saveDefectos(IDFICHA,iddfecto,cantidad_new,null)


    
}

// CERRAR REGISTROS
function cerrarregistrodefectos(idficha,comentario,usuario){

    MostrarCarga();

    post("auditex-lavanderia","lavadopanio","set-lavadopanio-cerrardefecto",[idficha,comentario,usuario])
            .then(async (response) => {

                if(response){

                    await getDefectosAgregados(idficha);


                    // $("#lblDefectos").text("2. Defectos: "+response.RESULTADO);

                    if(response.BOL == 1){
                        Informar("Item " + response.RESULTADO,1500);
                    }

                    if(response.BOL == 0){
                        Advertir("Item " + response.RESULTADO + ", (La Cantidad de defectos supera la cantidad permitida)") ;
                    }
                    
                    changeNavs( $("#nav_4") );

                    $("#btn-save-item-agregar-3").remove();  
                    $("#container-save-item3").addClass("d-none");  


                    
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