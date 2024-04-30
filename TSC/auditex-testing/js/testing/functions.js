// SET REVIRADO
function setRevirado(ac,bd,out){

    let x = ac - bd;
    let y = ac + bd;

    let response = x / y;
    response *=  200;
    response = response.toFixed(1);
    // console.log(response);

    // VALOR VERDADERO
    $(`#${out}`).data("valor",response);
    // VALOR MUESTRA

    // let responsehtml = response > 0  ? response.toString().substr(0,3) : response.toString().substr(0,5);

    // $(`#${out}`).html(response);
    $(`#${out}`).val(response);

}

// SET HILO - TRAMA
function setHiloTrama(cls,out){

    let suma = 0;
    let clase = document.getElementsByClassName(cls);
    let total = clase.length;

    for(let i = 0; i < total; i++ ){

        let val = clase[i].value != "" ? clase[i].value : "0";

        suma += parseFloat(val);
    }

    suma = suma / total;
    suma = suma / CALCULAPORCENTAJE;
    suma *= 100;
    suma -= 100;

    suma = suma.toFixed(1);

    // VALOR VERDADERO
    $(`#${out}`).data("valor",suma);
    // VALOR MUESTRA

    // console.log(suma);

    // let responsehtml = suma > 0  ? suma.toString().substr(0,3) : suma.toString().substr(0,5);

    // $(`#${out}`).html(suma);
    $(`#${out}`).val(suma);


}


// GET PROMEDIO
function getPromedio(cls,out){

    let suma = 0;
    let clase = document.getElementsByClassName(cls);
    let total = clase.length;

    for(let i = 0; i < total; i++ ){
        let val = clase[i].value != "" ? clase[i].value : "0";
        suma += parseFloat(val);
    }
    // console.log(suma);
    suma = suma / total;

    suma = suma.toFixed(1);


    // VALOR VERDADERO
    $(`#${out}`).data("valor",suma);
    // VALOR MUESTRA

    // let responsehtml = suma > 0  ? suma.toString().substr(0,3) : suma.toString().substr(0,5);

    // $(`#${out}`).html(suma);
    $(`#${out}`).val(suma);


}   

// TESTING
function getTesting(){

    MostrarCarga("Cargando...");

    let panel1 = document.getElementById("panel1");
    let panel2 = document.getElementById("panel2");
    let panel3 = document.getElementById("panel3");

    let fechai = null,fechaf = null,semana = null,anio = null,partida = null;
    let proveedor       = null;
    let cliente         = null;
    let articulotela    = null;
    let programa        = null;
    let color           = null;
    let estado          = null;
    let codtela         = null;


    // FILTRO 1
    if(panel1.classList.contains("active")){
        fechai  = $("#txtfechai").val();
        fechaf  = $("#txtfechaf").val();
    }
    
    // FILTRO 2
    if(panel2.classList.contains("active")){
        semana  = $("#txtsemana").val().trim();
        anio    = $("#txtanio").val().trim();
    }

    // FILTRO 3
    if(panel3.classList.contains("active")){


        proveedor       = $("#cboproveedor").val();
        cliente         = $("#cbocliente").val();
        articulotela    = $("#cboarticulo").val();
        programa        = $("#cboprograma").val();
        color           = $("#cbocolor").val();
        estado          = $("#cboestatus").val();
        codtela         = $("#txtcodtela").val();
        fechai          = $("#txtfechain").val();
        fechaf          = $("#txtfechafn").val();


        // PARTIDA
        partida = $("#txtpartida").val().trim() == "" ? null : $("#txtpartida").val().trim();
        // PROVEEDOR
        proveedor = proveedor.join("','");
        //proveedor = proveedor != "" ? "'" + proveedor + "'" : null;
        // CLIENTE
        cliente   = cliente != "" ? cliente : null;
        // ARTICULO DE TELA
        articulotela    = articulotela.join("','");
        //articulotela    = articulotela != "" ? "'" + articulotela + "'" : null;
        // PROGRAMA
        programa        = programa.join("','");
        //programa        = programa != "" ? "'" + programa + "'" : null;
        // COLOR 
        color           = color.join("','");
        //color           = color != "" ? "'" + color + "'" : null;
        // ESTADO
        estado          = estado != "" ? estado : null;


    }


    post("auditex-testing","testing","gettesting",[
        fechai,     fechaf,     anio,       semana,
        partida,    proveedor,  cliente,    articulotela,
        programa,   color,      estado,     codtela
    ]).then(response => {

        // DATOS TELA
        $("#container-datos-tela").html(response.datostela);

        // DATOS GENERALES
        $("#container-datos-generales").html(response.datosgenerales);

        if(response.datostela != ""){

            // TOOLTIP
            if(response.cant > 1){
                $(".td-tela").tooltip("enable")
                $(".td").tooltip("enable");
            }

            // EVENTO DE FOCUS
            FocusInput();

            // InformarMini("Cargado");
            OcultarCarga();

        }else{
            // console.log(codtela);
            if(codtela != "" && codtela != null){
                AdvertirMini("El código de tela no existe");
            }else if(partida != "" &&  partida != null){
                AdvertirMini("Partida no existe");
            }else {
                AdvertirMini("No se encontraron registros");
            }

        }

    }).catch(error => {
        AdvertirMini("Error al buscar, contacte a sistemas");
        console.log(error);
    })

}

// GET PROVEEDORES
async function getproveedores(){
    let response = await get("auditex-testing","testing","getproveedorestela",{});
    setComboSimple("cboproveedor",response,"DESCRIPCIONPROVEEDOR","IDPROVEEDOR",false);
}

// GET PROVEEDORES
async function getclientes(){
    let response = await get("auditex-testing","testing","getclientes",{});
    setComboSimple("cbocliente",response,"DESCRIPCIONCLIENTE","IDCLIENTE",true);
}

// GET PROGRAMA CLIENTE
async function getprogramacliente(idcliente){

    let response = await get("auditex-testing","testing","getprogramacliente",{
        idcliente
    });

    setComboSimple("cboprograma",response,"PROGRAMA","PROGRAMA");

}

// GET ARTICULOS  DE TELA
async function getarticulostela(idcliente){
    let response = await get("auditex-testing","testing","getarticulostela",{
        idcliente
    });
    setComboSimple("cboarticulo",response,"DESTEL","DESTEL");
}

// GET COLORES
async function getcolores(){
    let response = await get("auditex-testing","testing","getcolores",{});
    setComboSimple("cbocolor",response,"DESCOLOR","DESCOLOR");
}

//  GET ESTADOS TESTING
async function getEstadoTesting(){
    try{
        ESTADOSTESTING = await get("auditex-testing","testing","getestadostesting",{});
        setComboSimple("cboestatus",ESTADOSTESTING,"ESTADO","IDESTADO");
    }catch(error){
        Advertir("Error en la funcion getEstadoTesting()");
    }
    

    // console.log(ESTADOSTESTING);
}

// GET BOLSA
async function getbolsa(idlavada,numerobolsa,idresidualpano = null,idlavadatambor = null){

     console.log('idlavada',idlavada);

     let intIdlavada;

     if (idlavada !== undefined && idlavada !== null && idlavada !== '') {
         intIdlavada = parseInt(idlavada);
     } else {
         intIdlavada = null;
     }

    console.log('intIdlavada', intIdlavada); 

    let response;
    try{
        console.log(intIdlavada,numerobolsa,idresidualpano,idlavadatambor);

        response = await get("auditex-testing","testing","getbolsa",{
            idlavada: intIdlavada,numerobolsa,idresidualpano,idlavadatambor
        });

    }catch(error){
        Advertir("Error en la funcion getbolsa()");
    }
    
   
    // CREAMOS BOLSA
    let bolsa = {
        idbolsa: null,
        idreallavada: null,
        idresidualpano:null,
        numerobolsa,
        valorac: null,
        valorbd: null,
    }

    // SI LA BOLSA EXISTE
    if(response){

        // ASIGNAMOS IDBOLSA
        $("#idbolsa"+numerobolsa).val(response.IDBOLSA);



        bolsa.idbolsa           = response.IDBOLSA;
        bolsa.idreallavada      = response.IDREALLAVADA;
        bolsa.valorac           = response.VALORAC;
        bolsa.valorbd           = response.VALORBD;
        bolsa.idresidualpano    = response.IDRESIDUALPANO;


        // ASIGNAMOS VALORES
        $(`#bolsa${numerobolsa}ac`).val(response.VALORAC);
        $(`#bolsa${numerobolsa}bd`).val(response.VALORBD);


        // CALCULAMOS REVIRADO
        let ac = parseFloat($(`#bolsa${numerobolsa}ac`).val().trim());
        let bd = parseFloat($(`#bolsa${numerobolsa}bd`).val().trim());

        setRevirado(ac,bd,`reviradobolsa${numerobolsa}`);
        let responsedetalle;
        try{
            responsedetalle =  await getbolsadetalle(response.IDBOLSA);

        }catch(error){
            Advertir("Error en la funcion getEstadoTesting()");
        }

        let hilo    = document.getElementsByClassName(`bolsa${numerobolsa}hilo`);
        let trama   = document.getElementsByClassName(`bolsa${numerobolsa}trama`);

        responsedetalle.forEach((obj,index)=>{

            let detallebolsa = {
                numerobolsa,
                hilo:null,
                trama:null,
                iddetallebolsa:null,
                idbolsa:response.IDBOLSA
            }

            hilo[index].value = obj.HILO;
            trama[index].value = obj.TRAMA;
            detallebolsa.orden = hilo[index].dataset.orden ; //obj.ORDEN;

            // ASIGNAMOS
            detallebolsa.hilo =  obj.HILO;
            detallebolsa.trama =  obj.TRAMA;
            detallebolsa.iddetallebolsa =  obj.IDDETALLEBOLSA;

            // console.log(`bolsa${numerobolsa}hilo_orden${detallebolsa.orden}`,"ID",detallebolsa.iddetallebolsa);

            // ASIGNAMOS ID
            $(`#bolsa${numerobolsa}hilo_orden${detallebolsa.orden}`).data("id",detallebolsa.iddetallebolsa);
            $(`#bolsa${numerobolsa}trama_orden${detallebolsa.orden}`).data("id",detallebolsa.iddetallebolsa);

            

            // ASIGNAMOS VALOR
            DETALLEBOLSAS.push(detallebolsa);

        });

        // TRAMA
        setHiloTrama(`bolsa${numerobolsa}trama`,`totalbolsa${numerobolsa}trama`);
        // HILO
        setHiloTrama(`bolsa${numerobolsa}hilo`,`totalbolsa${numerobolsa}hilo`);
    }else{


        // ASIGNAMOS IDBOLSA
        $("#idbolsa"+numerobolsa).val("");


        // SI LA BOLSA NO EXISTE
        for(let i = 0; i < 3; i++){

            let detallebolsa = {
                numerobolsa,
                hilo:null,
                trama:null,
                iddetallebolsa:null,
                idbolsa:null,
                orden: i + 1
            }

            // DETALLE
            $(`#bolsa${numerobolsa}hilo_orden${detallebolsa.orden}`).data("id","");
            $(`#bolsa${numerobolsa}trama_orden${detallebolsa.orden}`).data("id","");


            // ASIGNAMOS VALOR
            DETALLEBOLSAS.push(detallebolsa);

        }

    }

    // AGREGAMOS
    BOLSAS.push(bolsa);


}

// GET BOLSA DETALLE
async function getbolsadetalle(idbolsa){
    let intIdbolsa = idbolsa === null ? null : parseInt(idbolsa);
    return await get("auditex-testing","testing","getdetallebolsa",{
        idbolsa : intIdbolsa
    });

}

// REEMPLAZAR VALORES BOLSAS
function replacebolsa(numerobolsa,ac,bd){

    let bolsa = BOLSAS.find(obj => obj.numerobolsa == numerobolsa);
    let index = BOLSAS.indexOf(bolsa);

    BOLSAS[index].valorac = ac;
    BOLSAS[index].valorbd = bd;

}


// REEMPLAZAR VALORES BOLSAS
function replacebolsadetalle(input,numerobolsa,hilo = true){

    // console.log(orden);
    let orden = $(input).data("orden");
    let detalle = DETALLEBOLSAS.find(obj =>  obj.orden == orden && obj.numerobolsa == numerobolsa);
    let index   = DETALLEBOLSAS.indexOf(detalle);

    if(hilo){
        DETALLEBOLSAS[index].hilo       = $(input).val().trim();
    }else{
        DETALLEBOLSAS[index].trama      = $(input).val().trim();
    }

}


// GUARDAR LAVADAS
$("#btnguardarlavada").click(async function(){

    let idbolsa1 = $("#idbolsa1").val();
    let idbolsa2 = $("#idbolsa2").val();
    let idbolsa3 = $("#idbolsa3").val();

    if(idbolsa1 != "" && idbolsa2 != "" && idbolsa3 != ""){

        // ACTUALIZAMOS
        let responseupdate  = await get("auditex-testing","testing","setupdatelavada",{
            idbolsa:idbolsa1
        });

        if(responseupdate){

            if(TAMBOR == "0"){

                // ACTUALIZAMOS  DATOS EN GRILLA
                if(TIPOLAVADA == "R"){

                    $(`.hilo${FILA}`).val(         parseFloatSistema(responseupdate.HILO)+"%");
                    $(`.trama${FILA}`).val(        parseFloatSistema(responseupdate.TRAMA)+"%");
                    $(`.revirado1${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO1)+"%");
                    $(`.revirado2${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO2)+"%");
                    $(`.revirado3${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO3)+"%");

                    // ACTUALIZAMOS DATA
                    $(`.openresidual-${FILA}`).data("idresidual",IDLAVADA);

                }else{

                    $(`.hilo${TIPOLAVADA}${FILA}`).val(         parseFloatSistema(responseupdate.HILO)+"%");
                    $(`.trama${TIPOLAVADA}${FILA}`).val(        parseFloatSistema(responseupdate.TRAMA)+"%");
                    $(`.revirado1${TIPOLAVADA}${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO1)+"%");
                    $(`.revirado2${TIPOLAVADA}${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO2)+"%");
                    $(`.revirado3${TIPOLAVADA}${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO3)+"%");

                    // ACTUALIZAMOS DATA
                    $(`.openlavado${TIPOLAVADA}-${FILA}`).data("idlavada",IDLAVADA);

                }


            }

            if(TAMBOR == "1"){

                $(`.hilo${TIPOLAVADA}${FILA}tambor`).val(         parseFloatSistema(responseupdate.HILO)+"%");
                $(`.trama${TIPOLAVADA}${FILA}tambor`).val(        parseFloatSistema(responseupdate.TRAMA)+"%");
                $(`.revirado1${TIPOLAVADA}${FILA}tambor`).val(    parseFloatSistema(responseupdate.REVIRADO1)+"%");
                $(`.revirado2${TIPOLAVADA}${FILA}tambor`).val(    parseFloatSistema(responseupdate.REVIRADO2)+"%");
                $(`.revirado3${TIPOLAVADA}${FILA}tambor`).val(    parseFloatSistema(responseupdate.REVIRADO3)+"%");

                // ACTUALIZAMOS DATA
                $(`.openlavadotambor${TIPOLAVADA}-${FILA}`).data("idlavadatambor",IDLAVADA);

            }

            // OCULTAMOS
            $("#modallavado").modal("hide");

            Informar("Datos actualizados",700);


        }else{
            Advertir("Ocurrio un error ");
        }

    }else{
        Advertir("No se registrarón todas las bolsas, favor registre todas las bolsas");
    }

    


    // if(DETALLEBOLSAS.length == 9 && BOLSAS.length == 3){

    //     MostrarCarga("Registrando...");
    
    //     // REGISTRAMOS TESTING
    //     await setTesting();

    //     // REGISTRAMOS LAVADA
    //     await setLavada(TIPOLAVADA);

    //     let idbolsa = null;
    //     // REGISTRAMOS BOLSAS
    //     for(let obj of BOLSAS){

    //         try{
    //             // REEMPLAZAMOS ID LAVADA
    //             if(TIPOLAVADA == "R"){
    //                 obj.idresidualpano = IDLAVADA;
    //             }else{
    //                 obj.idreallavada = IDLAVADA;
    //             }
                

    //             // GUARDAR BOLSAS
    //             // let responsebolsa = await get("auditex-testing","testing","setbolsas",obj);
    //             let responsebolsa = await saveBolsa(obj);
    //             let detallebolsa = DETALLEBOLSAS.filter(fil => fil.numerobolsa == obj.numerobolsa);
    //             idbolsa = responsebolsa.ID; 

    //             // RECORREMOS
    //             for(let det of detallebolsa){
    //                 det.idbolsa = idbolsa; 
    //                 await saveDetailBolsa(det);
    //             }
    //         }catch(error){

    //             localStorage.setItem("bolsas",JSON.stringify(BOLSAS));
    //             localStorage.setItem("detallebolsas",JSON.stringify(DETALLEBOLSAS));

    //             Advertir("Ocurrio un error al registrar Bolsa");
    //             console.log(error);

    //         }

    //     }

    //     // ACTUALIZAMOS
    //     let responseupdate  = await get("auditex-testing","testing","setupdatelavada",{
    //         idbolsa
    //     });

    //     // ACTUALIZAMOS  DATOS EN GRILLA
    //     if(TIPOLAVADA == "R"){

    //         $(`.hilo${FILA}`).val(         parseFloatSistema(responseupdate.HILO)+"%");
    //         $(`.trama${FILA}`).val(        parseFloatSistema(responseupdate.TRAMA)+"%");
    //         $(`.revirado1${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO1)+"%");
    //         $(`.revirado2${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO2)+"%");
    //         $(`.revirado3${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO3)+"%");

    //         // ACTUALIZAMOS DATA
    //         $(`.openresidual-${FILA}`).data("idresidual",IDLAVADA);

    //     }else{

    //         $(`.hilo${TIPOLAVADA}${FILA}`).val(         parseFloatSistema(responseupdate.HILO)+"%");
    //         $(`.trama${TIPOLAVADA}${FILA}`).val(        parseFloatSistema(responseupdate.TRAMA)+"%");
    //         $(`.revirado1${TIPOLAVADA}${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO1)+"%");
    //         $(`.revirado2${TIPOLAVADA}${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO2)+"%");
    //         $(`.revirado3${TIPOLAVADA}${FILA}`).val(    parseFloatSistema(responseupdate.REVIRADO3)+"%");

    //         // ACTUALIZAMOS DATA
    //         $(`.openlavado${TIPOLAVADA}-${FILA}`).data("idlavada",IDLAVADA);

    //     }
        

    //     InformarMini("Registrado correctamente");
    //     // OCULTAMOS MODAL
    //     $("#modallavado").modal("hide");

    // }else{
    //     Advertir("No se generaron las 3 bolsas, recarge la página y vuelva a ingresar los datos");
    // }


});

// GUARDAR DETALLE DE BOLSAS
async function saveDetailBolsa(det){
    let responsedetalle = await get("auditex-testing","testing","setdetallebolsas",det);
    if(responsedetalle.ID == "0"){
        await saveDetailBolsa(det);                
    }

    return responsedetalle;
}

// GUARDAR BOLSAS
async function saveBolsa(obj){
    // let responsedetalle = await get("auditex-testing","testing","setdetallebolsas",det);
    // if(responsedetalle.ID == "0"){
    //     await saveDetailBolsa(det);                
    // }
    let responsebolsa = await get("auditex-testing","testing","setbolsas",obj);
    if(responsebolsa.ID == "0"){
        await saveBolsa(obj);                
    }

    return responsebolsa;
}

// PARSE FLOAT SISTEMA
function parseFloatSistema(valor){

    return valor != null ? parseFloat(valor != "" ? valor : "0") : 0;

}

// REGISTRAR TESTING
async function setTesting(){

    if(IDTESTING == "" || IDTESTING == null){

        // get("auditex-testing","testing","settesting",{
        //     partida:PARTIDA,
        //     lote:LOTE
        // }).then(response => {
    
        //     IDTESTING = response.ID;
    
        // }).catch(error => {
        //     AdvertirMini("Error registrando testing");
        //     console.log(error);
        // })
        try{
            let response = await get("auditex-testing","testing","settesting",{
                partida:PARTIDA,
                lote:LOTE,
                kilos:KILOS,
                idproveedor: IDPROVEEDOR
            });
        
            IDTESTING = response.ID;
        }catch(error){
            Advertir("Error en la funcion setTesting()");
        }
        
    
        

    } 

}

// REGISTRAR TIPO DE LAVADA O RESIDUAL
async function setLavada(tipolavada,tambor){


    if(IDLAVADA == "" || IDLAVADA == null){

        try{

            let response = await  get("auditex-testing","testing","setlavada",{
                idtesting:IDTESTING,
                tipolavada,
                tambor
            });

            IDLAVADA = response.ID;

        }catch(error){
            Advertir("Error en la funcion setLavada()");
        }

    }

}

// GUARDAR LAVADAS
$("#btnguardarencogimiento").click(async function(){

    MostrarCarga("Registrando...");
    
    // REGISTRAMOS TESTING
    await setTesting();

    // DATOS BEFORE
    let hilobefore      = parseFloatSistema($(`#hiloencogimientobefore`).val().trim());
    let tramabefore     = parseFloatSistema($(`#tramaencogimientobefore`).val().trim());

    // REGISTRA ENCOGIMIENTOS
    let responsebefore = await  get("auditex-testing","testing","setencogimientos",{
        idtesting:IDTESTING,
        tipo:'B',
        hilo:hilobefore,
        trama:tramabefore
    });

    // console.log(responsebefore,"BEFORE");

    // DATOS AFTER
    let hiloafter      = parseFloatSistema($(`#hiloencogimientoafter`).val().trim());
    let tramaafter     = parseFloatSistema($(`#tramaencogimientoafter`).val().trim());

    let responseafter = await  get("auditex-testing","testing","setencogimientos",{
        idtesting:IDTESTING,
        tipo:'A',
        hilo:hiloafter,
        trama:tramaafter
    });

    // console.log(responseafter,"AFTER");

    // ACTUALIZAMOS ENCOGIMIENTOS
     let responseupdate = await get("auditex-testing","testing","updateencogimientos",{
        idtesting:IDTESTING,
        hilo:   parseFloatSistema($("#hilorealencogimiento").val().trim() ),
        trama:  parseFloatSistema($("#tramarealencogimiento").val().trim() ),
        inclib: parseFloatSistema($("#inclinacionbefore").val().trim() ),
        inclia: parseFloatSistema($("#inclinacionafter").val().trim() )
    });

    // console.log(updateen);
    // ASIGNAMOS DATOS
    $(`.hiloencogimiento${FILA}`).val(         parseFloatSistema(responseupdate.HILOENCOGIMIENTO)+"%");
    $(`.tramaencogimiento${FILA}`).val(        parseFloatSistema(responseupdate.TRAMAENCOGIMIENTO)+"%");

    $(`.inclibefore${FILA}`).val(    parseFloatSistema(responseupdate.INCLINACIONBEFORE));
    $(`.incliafter${FILA}`).val(    parseFloatSistema(responseupdate.INCLINACIONAFTER));

    InformarMini("Registrado correctamente");

    // OCULTAMOS MODAL
    $("#modalencogimiento").modal("hide");


});


// CAMBIAR ESTADOS
$("#container-datos-tela").on('click','.changeestatus',async function(){

    IDTESTING = parseInt($(this).data("idtesting"), 10);
    FILA = $(this).data("fila");
    PARTIDA = $(this).data("partida");
    LOTE = $(this).data("lote");
    KILOS = $(this).data("kilos");
    IDPROVEEDOR =  $(this).data("idproveedor");

    console.log('FILA', $(this).data("idcliente"));



    let estado = await getSelectValue(ESTADOSTESTING,"IDESTADO","ESTADO","Seleccione estado");
    ESTADONUEVO = estado;

    if(estado){

        let response = await Preguntar("Confirme para cambiar estado");

        if(response.value){


            // SI ES UN RECHAZO O UN APROBADO NO CONFORME
            if(estado == 3 || estado == 2){

                $("#cbomotivosdevolucion").val("").trigger("change");

                // MOSTRAMOS DEVOLUCIONES REGISTRADAS
                if(IDTESTING != "" && IDTESTING != null){

                    let response = await  get("auditex-testing","testing","getmotivosrechazosbyid",{
                        id:IDTESTING
                    });

                    let array = [];


                    for(let obj of response){
                        array.push(obj.IDFAMMOTIVO);
                    }

                    $("#cbomotivosdevolucion").val(array).trigger("change");
                    // console.log(response);

                }


                // $("#modalmotivos").modal("show");
                $("#modalmotivos").modal({
                    backdrop: 'static', 
                    keyboard: false,
                    show:true
                });

                // let motivo = await getSelectValue(MOTIVOSDEVOLUCION,"ID","DESCRIPCION","Seleccione motivo");
                

            }else{

                MostrarCarga("Cargando...");

                // REGISTRAMOS TESTING
                await setTesting(); 

                let rptestado = await  get("auditex-testing","testing","setestadotesting",{
                    idtesting:IDTESTING,estado,user:USUARIO
                });

                console.log('REMOVIENDO ESTILOS');
    
                // REMOVEMOS CLASES
                $(`.changeestatus${FILA}`).removeClass("bg-success");
                $(`.changeestatus${FILA}`).removeClass("bg-warning");
                $(`.changeestatus${FILA}`).removeClass("bg-danger");
                $(`.changeestatus${FILA}`).removeClass("bg-secondary");
                $(`.changeestatus${FILA}`).removeClass("bg-pendiente-calidad");
                $(`.changeestatus${FILA}`).removeClass("bg-complemento");
                $(`.changeestatus${FILA}`).removeClass("bg-pendiente");
    
    
                $(`.changeestatus${FILA}`).val(rptestado.SIMBOLO);
                $(`.changeestatus${FILA}`).addClass(rptestado.COLOR);

                
    
                InformarMini("Actualizado correctamente");


            }

        }
    }

});


// ASIGNAR COMENTARIO
$("#container-datos-generales").on('click','.observaciones',async function(){

    IDTESTING =parseInt($(this).data("idtesting"), 10);
    FILA = $(this).data("fila");
    PARTIDA = $(this).data("partida");
    LOTE = $(this).data("lote");
    KILOS = $(this).data("kilos");
    IDPROVEEDOR =  $(this).data("idproveedor");



    // REGISTRAMOS TESTING
    await setTesting();

    let observaciones = $(this).data("observaciones");

    // 
    let obs = await Obtener("Ingrese observaciones","textarea",observaciones);
    // console.log(response);

    console.log('IDTESTING',IDTESTING);

    if(obs){

        let responseobs = await get("auditex-testing","testing","setobstesting",{
            idtesting:IDTESTING,
            obs
        });

        setMensaje(responseobs,1000);

        if(responseobs.success){
            $(`.observaciones${FILA}`).val(obs);
            $(`.observaciones${FILA}`).data("observaciones",obs);
        }

        // console.log(responseobs);

    }


});


// QUITAR VALOR
function replacevalor(valor,string,vreplace = ""){
    return valor.replace(string,vreplace);
}


function FocusInput(){
    $(".input-hover").focus(function (e){
        // e.tabIndex();   
        // console.log(e);

        

        FILASOMBREADA = $(this).parent().data("filasombreado");
        PintarDireccionales();

    });

    // $(".input-hover").keyup(function (e){
    //     // console.log(e.keyCode)
    //     if(e.keyCode == 39){
    //         console.log(this);
    //         $(this).next('.input-hover').focus();
    //     }else{
    //         $(this).prev('.input-hover').focus();
    //     }
    // })
}

// function mover(event, to) {
//     let list = $('.input-hover');
//     let index = list.index($(event.target));
//     index = (index + to) % list.length;
//     list.eq(index).focus();
// }


// MOSTRAR PARTIDA AGRUPADAS
async function getPartidasAgrupadas(partida){

    let response = await get("auditex-testing","testing","getpartidasagrupadas",{
       partida
    },true);

    $("#tbodyagrupador").html(response);

}

// AGRUPAMOS PARTIDAS
async function setAgruparPartidas(){

    MostrarCarga();

    let partidacopia = $("#txtpartidacopia").val().trim();

    let response = await get("auditex-testing","testing","setagruparpartida",{
        idtesting:      IDTESTING,
        partidaorigen:  PARTIDA,
        partidacopia,
        lote:           LOTE,
        kilos:          KILOS,
        idproveedor:    IDPROVEEDOR
    }); 

    // console.log(response);
    if(response.success){
        frmagrupador.reset();
        await getPartidasAgrupadas(PARTIDA);
        InformarMini(response.rpt);
    }else{
        Advertir(response.rpt);
    }

}

// COPIAMOS
$("#container-datos-tela").on('click',"input",function(){
    copyToClipboard(this);
});


// GET MOTIVOS DE DEVOLUCION
async function getMotivosDevolucion(){

    // MOTIVOSDEVOLUCION
    MOTIVOSDEVOLUCION = await get("auditex-testing","testing","getmotivosrechazos",{}); 
    setComboSimple("cbomotivosdevolucion",MOTIVOSDEVOLUCION,"DESCRIPCION","ID",false);
}


// REGISTRAR BOLSAS INDIVIDUAL
async function saveBolsasIndividual(form){

    MostrarCarga("Cargando...");

    // TESTING
    await setTesting();

    // REGISTRAMOS LAVADA
    await setLavada(TIPOLAVADA,TAMBOR);

    let numerobolsa = form.children[0].value;
    let idbolsa     = form.children[1].value;

    let valorac     = $(`#bolsa${numerobolsa}ac`).val();
    let valorbd     = $(`#bolsa${numerobolsa}bd`).val();

    let idreallavada        = null;
    let idresidualpano      = null;
    let idreallavadatambor  = null;


    if(TAMBOR == "0"){

        if(TIPOLAVADA == "R"){
            idresidualpano = IDLAVADA;
        }else{
            idreallavada = IDLAVADA;
        }

    }else{
        idreallavadatambor = IDLAVADA;
    }


    // GUARDAMOS BOLSAS
    let response = await saveBolsa({
        idbolsa,idreallavada,idresidualpano,numerobolsa,valorac,valorbd,idreallavadatambor
    });

    idbolsa = response.ID;
    IDBOLSA = idbolsa;

    // GUARDAMOS DETALLE DE BOLSAS
    for(let item of [1,2,3]){

        // bolsa1hilo_orden1
        let iddetallebolsa  = $(`#bolsa${numerobolsa}hilo_orden${item}`).data("id");
        let hilo            = $(`#bolsa${numerobolsa}hilo_orden${item}`).val();
        let trama           = $(`#bolsa${numerobolsa}trama_orden${item}`).val();

        let responsedetail = await saveDetailBolsa({
            iddetallebolsa,idbolsa,hilo,trama,orden:item
        });


    }

    $("#idbolsa"+numerobolsa).val(idbolsa);

    if(TIPOLAVADA == "R"){

        // ACTUALIZAMOS DATA
        $(`.openresidual-${FILA}`).data("idresidual",IDLAVADA);

    }else{

        // ACTUALIZAMOS DATA
        $(`.openlavado${TIPOLAVADA}-${FILA}`).data("idlavada",IDLAVADA);

    }

    Informar("Registrado correctamente",700);

}


// SET CONCESION
$("#container-datos-generales").on('change','.setconcesion',async function(){

    MostrarCarga("Cargando...");

    IDTESTING =parseInt($(this).data("idtesting"), 10);
    FILA = $(this).data("fila");
    PARTIDA = $(this).data("partida");
    LOTE = $(this).data("lote");
    KILOS = $(this).data("kilos");
    IDPROVEEDOR =  $(this).data("idproveedor");

    // console.log( $(this).prop("checked") );
    let estado = $(this).prop("checked") ? "1" : "0";


    // REGISTRAMOS TESTING
    await setTesting(); 

    let response = await  get("auditex-testing","testing","setconcesion",{
        idtesting:IDTESTING,estado
    });



    InformarMini("Actualizado correctamente");


            

        

});