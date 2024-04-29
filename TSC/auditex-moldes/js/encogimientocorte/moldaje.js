// FUNCION QUE SE EJECUTA CUANDO ENVIAMOS EL FORMULARIO
frmbusqueda.addEventListener('submit', async (e) => {
    MostrarCarga("Cargando...");
    // e.preventDefault();
    // await BuscarEnCorte();
});

// REGISTRO DE PRUEBA DE ENCOGIMIENTOS
if (frmpruebaencogimiento != null) {

    frmpruebaencogimiento.addEventListener('submit',async (e)=>{

        e.preventDefault();
        await GuardarEncogimientoUsado();
    
    });

}


// REGISTRO DE OBSERVACIONES DE ENCOGIMIENTOS
if(frmobservacionencogimiento != null){

    frmobservacionencogimiento.addEventListener('submit',async (e)=>{

        e.preventDefault();
        await GuardarObservacion();
    
    });

}


// REGISTRAMOS OBSERVACION DE LIBERACION
if(frmobservacionliberacion != null){

    frmobservacionliberacion.addEventListener('submit',async (e)=>{
        e.preventDefault();
        await GuardarObservacionLiberacion();
    });

}


// ASIGNAMOS ESTADO DE MOLDAJE
if (frmestadosmoldaje  != null){

    frmestadosmoldaje.addEventListener('submit',async (e)=>{
        e.preventDefault();
        await setEstadoMoldaje();
    });
    
}

// REGISTRO DE PRUEBA DE ENCOGIMIENTO
if(frmresultadopruebaencogimiento != null){

    frmresultadopruebaencogimiento.addEventListener('submit',async (e)=>{
        e.preventDefault();                
        await setSaveResultadoPruebaEncogimiento(frmresultadopruebaencogimiento);
    });

}



// FUNCIONES

// FUNCION GENERAL QUE BUSCA LOS DATOS GENERALES
async function BuscarEnCorte() {

    MostrarCarga("Cargando...");

    let fecini = $("#txtfechai").val();
    let fecfin = $("#txtfechaf").val();
    let cliente = $("#txtcliente").val();
    let partida = $("#txtpartida").val();
    let ficha = $("#txtficha").val();
    let estcli = $("#txtestilocliente").val();
    let articulo = $("#txtarticulo").val();
    let programa = $("#txtprograma").val();
    let estatus = $("#cboestatusbusqueda").val();
    let esttsc = $("#txtestilotsc").val();
    let color = $("#txtcolor").val();
    let encogimiento = $("#txtencogimiento").val();

    var resFechaI = fecini.split("-");
    var reversedFechaI = resFechaI.reverse();
    var FechaI = reversedFechaI.join('-');

    var resFechaF = fecfin.split("-");
    var reversedFechaF = resFechaF.reverse();
    var FechaF = reversedFechaF.join('-');

    var frFechaI = FechaI.replaceAll("-", "/");
    var frFechaF = FechaF.replaceAll("-", "/");

    let response = await get("auditex-moldes", "encogimientoscorte", "getreporte_new", {
        frFechaI,
        frFechaF,
        cliente,
        partida,
        ficha,
        estcli,
        articulo,
        programa,
        estatus,
        esttsc,
        color,
        encogimiento
    });



    // setTable(response);

    OcultarCarga();

}

// ARMAMOS  TABLA
function setTable(data){

    // DESTRUIMOS
    $('#tabledatos').bootstrapTable('destroy');

    // ASIGNAMOS DATOS
    if(data != null){
        $("#tbodydatos").html(data);
    }

    // CONSTRUIMOS
    $('#tabledatos').bootstrapTable({
        height: 400,
        fixedColumns: true,
        fixedNumber: 17,
    });



    // POPOVER
    $('[data-toggle="popover"]').popover()

    // TOOL TIP
    $('[data-toggle="tooltip"]').tooltip()
    

}

// FUNCION QUE BUSCA LOS ENCOGIMIENTOS DISPONIBLES SEGUN ESTILO
async function BuscarEstiloDisponible(estilotsc) {

    // EJECUTAMOS SOLICITUD
    let response = await get("auditex-moldes", "encogimientoscorte", "getreportemoldesdisponible", {
        estilotsc,ficha:FICHA
    }, true);


    // LLENAMOS DATOS EN LA TABLA
    $("#tbodymoldeusar").html(response);
}

// BUSCAMOS FICHA DEL REPORTE
async function getFichasReporte(tbody = "tbodyfichasasociadas"){

    let response = await get("auditex-moldes", "encogimientoscorte", "getfichasreporte", {});
    let tr = "";
    let fila = 0;


    for(let item of response){

        fila++;

        tr += "<tr>";
        tr += "<td>" +item.ficha+"</td>";
        tr += "<td>" +item.estilo+"</td>";

        tr += "<td>" +item.programa+"</td>";


        if(FICHA == item.ficha){
            tr += `<td> <input class='checkfichas${tbody}' type='checkbox' data-estilotsc='${item.estilo}' data-ficha='${item.ficha}' data-lote='${item.lote_produto}' data-fila='${fila}' checked='true' disabled='true'> </td>`;
        }else{
            tr += `<td> <input class='checkfichas${tbody}' data-estilotsc='${item.estilo}' data-ficha='${item.ficha}' data-lote='${item.lote_produto}' data-fila='${fila}' type='checkbox'> </td>`;
        }

        tr += "</tr>";

    }


    $(`#${tbody}`).html(tr);

}


// FUNCION QUE ACTUALIZA 
async function GuardarEncogimiento(hilo, trama, manga,ficha,estilotsc,loteficha) {

    let data = {
        ficha,
        usuario:USUARIO,
        hilo:   hilo == "" ? null : hilo,
        trama:  trama == "" ? null : trama ,
        manga:  manga,
        estilotsc,
        loteficha
    }

    // console.log(hilo, trama, manga,ficha,estilotsc);
    // console.log(data);

    // EJECUTAMOS SOLICITUD
    let response = await get("auditex-moldes", "encogimientoscorte", "set-actualizarmoldedisponible", data);


    // console.log(response);

}

// GUARDAR ENCOGIMIENTO USADO
async function GuardarEncogimientoUsado() {
    

    let hilou   = $("#txthilo_pruebaencogimiento").val();
    let tramau  = $("#txttrama_pruebaencogimiento").val();
    let mangau  = $("#txtmanga_pruebaencogimiento").val(); 

    let response = await get("auditex-moldes", "encogimientoscorte", "set-actualizarencogimientousado", {
        ficha: FICHA,
        usuario:USUARIO,
        estilotsc: ESTILOTSC,
        hilou,
        tramau,
        mangau,
        loteficha:LOTEFICHA
    });

    $(`.selectpruebaencogimiento${FILA}`).data(`hilousado`,hilou);
    $(`.selectpruebaencogimiento${FILA}`).data(`tramausado`,tramau);
    $(`.selectpruebaencogimiento${FILA}`).data(`mangausado`,mangau);



    $(`.selectpruebaencogimiento${FILA}`).text(`${hilou}% / ${tramau}% / ${mangau}%`);
    $(`.selectpruebaencogimiento${FILA}`).removeClass(`btn-primary`);
    $(`.selectpruebaencogimiento${FILA}`).addClass(`btn-success`);

    $("#modalpruebaencogimiento").modal("hide");
    // console.log(response);

} 
 
// FUNCION QUE ACTUALIZA 
async function GuardarObservacion() {

    let observacion = $("#txtobservacionencogimiento").val().trim();

    // EJECUTAMOS SOLICITUD
    let response = await get("auditex-moldes", "encogimientoscorte", "set-actualizarobservacion", {
        ficha: FICHA,
        usuario:USUARIO,
        estilotsc: ESTILOTSC,
        loteficha:LOTEFICHA,
        observacion
    });


    let ultimaobs = observacion.substring(0,12); 

    // MOSTRAMOS COMENTARIO
    // $(".addobservacionencogimiento"+FILA).text(ultimaobs);
    // $(".addobservacionencogimiento"+FILA).text("Mos");

    $(".addobservacionencogimiento"+FILA).data("observacion",observacion);
    $(".addobservacionencogimiento"+FILA).text("Mostrar");


    $("#modalobservacionencogimiento").modal('hide');

}


// FUNCION QUE ACTUALIZA 
async function GuardarObservacionLiberacion() {

    MostrarCarga();

    // GUARDAMOS RADIOS
    // let radios      = $(".checkmoldeusar");
    let checkfichas = $(".checkfichastbodyfichasasociadasobservacion");
    let observacion = $("#txtobservacionliberacion").val().trim();


    // let hilo = $(radioseleccionado).data("hilo");
    // let trama = $(radioseleccionado).data("trama");
    // let manga = $(radioseleccionado).data("manga");

    
    // DATA DE LAS FICHAS SELECCIONADAS
    for(let item of checkfichas){

        if ($(item).prop("checked")) {
            
            let ficha       = $(item).data("ficha");
            let estilotsc   = $(item).data("estilotsc");
            let loteficha   = $(item).data("lote");

            // console.log(ficha,estilotsc);

            await get("auditex-moldes", "encogimientoscorte", "set-actualizarobservacionliberacion", {
                ficha,
                usuario:USUARIO,
                estilotsc,
                observacion,
                loteficha
            });

        }

    }



    $("#modalobservacionliberacion").modal("hide");

    OcultarCarga();

}

// OBTENEMOS LOS ESTADOS DE MOLDAJE
async function getestadosmoldaje(valor = null){

    let response = await await get("auditex-moldes", "encogimientoscorte", "getestadosmoldaje",{});

    setComboSimple("cboestadosmoldaje",response,"ESTADO","IDESTADOMOLDE");
    setComboSimple("cboestatusbusqueda",response,"ESTADO","IDESTADOMOLDE",true,false,'SIN ASIGNAR',0);

    if(valor != null){
        // $("#cboestatusbusqueda").val(valor);

        $("#cboestatusbusqueda").val(valor).trigger("change");

    }
    console.log("RESPONSE MOLDAJE",response);

}


// USUARIOS QUE LIBERARON
async function getusuarioliberacion(valor = null){

    let response = await await get("auditex-moldes", "encogimientoscorte", "getusuariosliberacion",{});
    setComboSimple("cbousuliberacion",response,"USUARIO_LIBERACION","USUARIO_LIBERACION",true);

    if(valor != null){
        $("#cbousuliberacion").val(valor);
    }

}

// GET PROVEEDORES
async function getclientes(valor = null){

    let response = await get("auditex-moldes","encogimientoscorte","getclientes",{});
    setComboSimple("cboclientes",response,"DESCRIPCIONCLIENTE","IDCLIENTE",true);

    if(valor != null){
        $("#cboclientes").val(valor);
    }

}


// ASIGNAMOS ESTADO DE MOLDES
async function setEstadoMoldaje(){

    MostrarCarga("Cargando...");

    // Actualiza estatus moldaje
    let ficha       = FICHA;
    let estilotsc   = ESTILOTSC;
    let estado      = $("#cboestadosmoldaje").val();
    let usuario     = USUARIO;
    let loteficha   = LOTEFICHA;


    let response = await get("auditex-moldes", "encogimientoscorte", "set-actualizarestatusmolde", {
        ficha,
        estado,
        estilotsc,
        usuario,
        loteficha
    });

    // $(".usuarioliberado"+FILA).text(response.NOMBREUSUARIO);
    $(".usuarioliberado"+FILA).text(response.USUARIO);
    $(".usuarioliberado"+FILA).data("title",response.NOMBREUSUARIO);





    $(".fechaliberaciontd"+FILA).html(
        `
            <button type='button' data-ficha='${FICHA}' class='btn btn-sm btn-info buttons-table fechaliberacion'>${response.FECHA}</button>
        `
    );

    // <button type='button' data-ficha='{$fila['FICHA']}' class='btn btn-sm btn-info buttons-table fechaliberacion'>{$fechaliberacion}</button>


    $(".estmoldaje"+FILA).text(response.SIMBOLO);
    $(".estmoldaje"+FILA).data("idestado",response.IDESTADOMOLDE);

    // QUITAMOS CLASES ANTERIORES
    $(".estmoldaje"+FILA).removeClass("bg-warning");
    $(".estmoldaje"+FILA).removeClass("bg-estado2");
    $(".estmoldaje"+FILA).removeClass("bg-estado3");
    $(".estmoldaje"+FILA).removeClass("bg-success");
    $(".estmoldaje"+FILA).removeClass("bg-danger");
    $(".estmoldaje"+FILA).removeClass("bg-estado6");
    $(".estmoldaje"+FILA).removeClass("bg-estado7");
    $(".estmoldaje"+FILA).removeClass("bg-estado8");
    $(".estmoldaje"+FILA).removeClass("bg-estado9");
    $(".estmoldaje"+FILA).removeClass("bg-estado10");
    $(".estmoldaje"+FILA).removeClass("bg-estado11");
    $(".estmoldaje"+FILA).removeClass("bg-estado12");
    $(".estmoldaje"+FILA).removeClass("bg-estado13");




    // AGREGAMOS COLOR
    $(".estmoldaje"+FILA).addClass(response.COLOR);


    $("#modalestadomoldaje").modal("hide");

    OcultarCarga();

}

// BUSCAMOS DATOS DE LA FICHA PARA DATOS DE ENCOGIMIENTO
async function getDatosPruebaEncogimiento(){



    // DATOS DE FICHA PARA LA PRUEBA DE ENCOGIMIENTOS
    let dataficha = await get("auditex-moldes", "encogimientoscorte", "getdatosfichapruebaencogimiento", {
        opcion:4,ficha:FICHA,partida:PARTIDA
    });

    $("#lblarticulo").text(dataficha.ARTICULO);
    $("#lblcolor").text(dataficha.COLOR);
    $("#lblruta").text(dataficha.RUTA_PRENDA);
    $("#lblcliente").text(dataficha.CLIENTE);
    $("#lblestilodeprueba").text(dataficha.ESTILOTSC +" / "+ dataficha.ESTILOCLIENTE);

    $("#txtmoldeusar").val(`Hilo: ${dataficha.RESULTADO_PRUEBA_HILO_USADO}%, Trama: ${dataficha.RESULTADO_PRUEBA_TRAMA_USADO}%, Manga: ${dataficha.RESULTADO_PRUEBA_MANGA_USADO}%,`);
    // DATOS DE TENDENCIA
    $("#txthilotendencia").val(dataficha.HILOTENDENCIA);
    $("#txttramatendencia").val(dataficha.TRAMATENDENCIA);


    // DATOS DE EVALUACION
    $("#txthiloevaluacion").val(  (dataficha.HILOEVALUACION  != "" && dataficha.HILOEVALUACION  != null) ? parseFloat(dataficha.HILOEVALUACION) : "");
    $("#txttramaevaluacion").val( (dataficha.TRAMAEVALUACION != "" && dataficha.HILOEVALUACION  != null) ? parseFloat(dataficha.TRAMAEVALUACION) : "");
    $("#txtmangaevaluacion").val( (dataficha.MANGAEVALUACION != "" && dataficha.HILOEVALUACION  != null) ? parseFloat(dataficha.MANGAEVALUACION) : "");


    $("#imggeneralcarga").attr("src","/tsc/public/auditex-moldes/tmpencogimientos/"+dataficha.IMGPRINCIPAL);



    // DATOS PARA ARMAR LAS PARTIDAS AGRUAPDAS
    let response = await get("auditex-moldes", "encogimientoscorte", "getdatosfichapruebaencogimiento", {
        opcion:3,ficha:FICHA,partida:PARTIDA
    },true);

    $("#tbodyresultadoprueba").html(response);

    // OBTENEMOS IMAGENES
    await getimageencogimientos();



}


// REGISTRO DE DATOS
async function setSaveResultadoPruebaEncogimiento(form){

    MostrarCarga();

    let hilotendencia   = $("#txthilotendencia").val().trim();
    let tramatendencia  = $("#txttramatendencia").val().trim();

    let hiloevaluacion  = $("#txthiloevaluacion").val().trim();
    let tramaevaluacion = $("#txttramaevaluacion").val().trim();
    let mangaevaluacion = $("#txtmangaevaluacion").val().trim();


    let fm = new FormData(form);
    // OPERACION
    fm.append("operacion","setpruebaencogimiento");

    // DATOS GENERALES
    fm.append("ficha",FICHA);
    fm.append("estilotsc",ESTILOTSC);
    fm.append("usuario",USUARIO);

    // DATOS PARA REGISTRO DE EVALUACION
    fm.append("hilotendencia",hilotendencia);
    fm.append("tramatendencia",tramatendencia);
    fm.append("hiloevaluacion",hiloevaluacion);
    fm.append("tramaevaluacion",tramaevaluacion);
    fm.append("mangaevaluacion",mangaevaluacion);


    let response = await MoverArchivos("auditex-moldes","encogimientoscorte",fm);

    OcultarCarga();

    if(!response.success){
        Advertir(response.mensaje);
    }else{
        frmresultadopruebaencogimiento.reset();
        $("#modalresultadoprueba").modal("hide");
    }
    // console.log(response);


}

// MOSTRAMOS INPUT PARA REGISTRAR
// $("#btnpartidas").click(function(){

//     let opcion = $(this).data("mostrar");

//     if(opcion == "0"){
//         $("#fila-add-partida").show("slow");
//         $(this).data("mostrar","1");
//         $("#txtpartidaadd").val("");
//         $("#txtpartidaadd").focus();
//     }

//     if(opcion == "1"){
//         $("#fila-add-partida").hide("slow");
//         $(this).data("mostrar","0");
//         $("#txtpartidaadd").val("");
//     }    
// });

// REGISTRAMOS PARTIDAS
$("#btnaddpartida").click(async function(){

    MostrarCarga();

    let partida = $("#txtpartidaadd").val().trim();

    if(partida != ""){

        let response = await get("auditex-moldes", "encogimientoscorte", "setpartidasagrupadas", {
            ficha: FICHA,
            usuario:USUARIO,
            estilotsc: ESTILOTSC,
            partida,
            loteficha:LOTEFICHA
        });


        // DATOS PARA ARMAR LAS PARTIDAS AGRUAPDAS
        let responsehtml = await get("auditex-moldes", "encogimientoscorte", "getdatosfichapruebaencogimiento", {
            opcion:3,ficha:FICHA,partida:PARTIDA
        },true);

        // RECARGAMOS
        $("#tbodyresultadoprueba").html(responsehtml);

        // LIMPIAMOS
        $("#txtpartidaadd").val("");

        OcultarCarga();

    }else{
        Advertir("Ingrese la partida");
    }


});

// PARA SELECCIONAR TODAS LAS FICHAS
$("#chkselectallfichas").change(function(){

    let estado = $(this).prop("checked");
    let fichas = $(".checkfichastbodyfichasasociadas")
    // console.log(estado);

    for(let ficha of fichas){
        let disabled = $(ficha).prop("disabled");

        // ACTIVAMOS O DESACTIVAMOS SEGUN EL CHECK
        if(estado){

            $(ficha).prop("checked",true);

        }else{

            if(!disabled){
                $(ficha).prop("checked",false);
            }

        }
      }

});

// PARA SELECCIONAR TODAS LAS FICHAS
$("#chkselectallfichas_moldepano").change(function(){

    let estado = $(this).prop("checked");
    let fichas = $(".checkfichastbodyfichasasociadas_moldepano")
    // console.log(estado);

    for(let ficha of fichas){
        let disabled = $(ficha).prop("disabled");

        // ACTIVAMOS O DESACTIVAMOS SEGUN EL CHECK
        if(estado){

            $(ficha).prop("checked",true);

        }else{

            if(!disabled){
                $(ficha).prop("checked",false);
            }

        }
      }

});


// PARA SELECCIONAR TODAS LAS FICHAS
$("#chkselectallfichas_primeralavada").change(function(){

    let estado = $(this).prop("checked");
    let fichas = $(".checkfichastbodyfichasasociadas_moldeprimeralavada")
    // console.log(estado);

    for(let ficha of fichas){
        let disabled = $(ficha).prop("disabled");

        // ACTIVAMOS O DESACTIVAMOS SEGUN EL CHECK
        if(estado){

            $(ficha).prop("checked",true);

        }else{

            if(!disabled){
                $(ficha).prop("checked",false);
            }

        }
      }

});

// PARA SELECCIONAR TODAS LAS FICHAS
$("#chkselectallfichas_versionmolde").change(function(){

    let estado = $(this).prop("checked");
    let fichas = $(".checkfichastbodyfichasasociadas_versionmolde")
    // console.log(estado);

    for(let ficha of fichas){
        let disabled = $(ficha).prop("disabled");

        // ACTIVAMOS O DESACTIVAMOS SEGUN EL CHECK
        if(estado){

            $(ficha).prop("checked",true);

        }else{

            if(!disabled){
                $(ficha).prop("checked",false);
            }

        }
      }

});


// PARA SELECCIONAR TODAS LAS FICHAS
$("#chkselectallfichasobservacion").change(function(){

    let estado = $(this).prop("checked");
    let fichas = $(".checkfichastbodyfichasasociadasobservacion")
    // console.log(estado);

    for(let ficha of fichas){
        let disabled = $(ficha).prop("disabled");

        // ACTIVAMOS O DESACTIVAMOS SEGUN EL CHECK
        if(estado){

            $(ficha).prop("checked",true);

        }else{

            if(!disabled){
                $(ficha).prop("checked",false);
            }

        }
      }

});


// SELECCIONAMOS FICHAS
$(".selectrow").click(function(){

    let row = $(this).data("fila");

    $(".rows").removeClass("background-row");
    $(".selectrow"+row).addClass("background-row");

});



// GUARDAR MOLDE PANO USAR 
if (frmmoldepanousar != null) {

    frmmoldepanousar.addEventListener('submit',async (e)=>{
        e.preventDefault();
    
    
        // VERIFICAMOS
        let checkfichas = $(".checkfichastbodyfichasasociadas_moldepano");
    
        MostrarCarga();
    
        let hilo    = $("#txthilomoldepanousar").val().trim();
        let trama   = $("#txttramamoldepanousar").val().trim();
    
    
        // DATA DE LAS FICHAS SELECCIONADAS
        for(let item of checkfichas){
    
            if ($(item).prop("checked")) {
                // radioseleccionado = radio;
                let ficha       = $(item).data("ficha");
                let estilotsc   = $(item).data("estilotsc");
                let fila        = $(item).data("fila");
                let loteficha   = $(item).data("lote");

    
    
                let response = await get("auditex-moldes", "encogimientoscorte", "set-moldepanousar", {
                    ficha,
                    usuario:USUARIO,
                    estilotsc,
                    hilo,
                    trama,
                    loteficha
                });
            
                if(response){
    
                    if(hilo == "" && trama == ""){
    
                        $(".hilopanousar"+fila).removeClass("btn-success");
                        $(".hilopanousar"+fila).addClass("btn-primary");
                
                        $(".hilopanousar"+fila).text("");
                        $(".hilopanousar"+fila).append("<i class='fas fa-plus'></i>");
                        $(".tramapanousar"+fila).text("");
    
                    }else{
                        $(".hilopanousar"+fila).removeClass("btn-primary");
                        $(".hilopanousar"+fila).addClass("btn-success");
                
                        $(".hilopanousar"+fila).text(hilo+"%");
                        $(".tramapanousar"+fila).text(trama+"%");
                    }
    
                    
    
    
                    $(".hilopanousar"+fila).data("hilo",hilo);
                    $(".hilopanousar"+fila).data("trama",trama);
            
            
                    // OcultarCarga();
            
            
                }else{
                    Advertir("Ocurrio un error al regisrar");
                }
                
            }
    
        }
    
        $("#modalmoldepanousar").modal("hide");
        OcultarCarga();
        
    
    
    
    });
    

}



// PRIMERA LAVADA
if (frmmoldeprimeralavada != null) {

    frmmoldeprimeralavada.addEventListener('submit',async (e)=>{
        e.preventDefault();
    
    
        // VERIFICAMOS
        let checkfichas = $(".checkfichastbodyfichasasociadas_moldeprimeralavada");
    
        MostrarCarga();
    
        let hilo            = $("#txthilomoldeprimeralavada").val().trim();
        let trama           = $("#txttramamoldeprimeralavada").val().trim();
        let densidad        = $("#txtdensidadmoldeprimeralavada").val().trim();
        let inclinacionbw   = $("#txtinclinacionbwmoldeprimeralavada").val().trim();
        let inclinacionaw   = $("#txtinclinacionawmoldeprimeralavada").val().trim();
        let revirado        = $("#txtreviradomoldeprimeralavada").val().trim();

    
    
        // DATA DE LAS FICHAS SELECCIONADAS
        for(let item of checkfichas){
    
            if ($(item).prop("checked")) {
                // radioseleccionado = radio;
                let ficha       = $(item).data("ficha");
                let estilotsc   = $(item).data("estilotsc");
                let fila        = $(item).data("fila");
                let loteficha   = $(item).data("lote");

    
    
                let response = await get("auditex-moldes", "encogimientoscorte", "set-moldeprimeralavada", {
                    ficha,
                    usuario:USUARIO,
                    estilotsc,

                    hilo,
                    trama,
                    densidad,
                    inclinacionbw,
                    inclinacionaw,
                    revirado,

                    loteficha
                });
            
                if(response){
    
                    if(hilo == "" && trama == ""){
    
                        $(".primeralavadahilo"+fila).removeClass("btn-success");
                        $(".primeralavadahilo"+fila).addClass("btn-primary");
                
                        $(".primeralavadahilo"+fila).text("");
                        $(".primeralavadahilo"+fila).append("<i class='fas fa-plus'></i>");
                        $(".primeralavadatrama"+fila).text("");
                        $(".primeralavadadensidad"+fila).text("");
                        $(".primeralavadainclib"+fila).text("");
                        $(".primeralavadainclia"+fila).text("");
                        $(".primeralavadarevirado"+fila).text("");


    
                    }else{
                        $(".primeralavadahilo"+fila).removeClass("btn-primary");
                        $(".primeralavadahilo"+fila).addClass("btn-success");
                
                        $(".primeralavadahilo"+fila).text(hilo);
                        $(".primeralavadatrama"+fila).text(trama);
                        $(".primeralavadadensidad"+fila).text(densidad);
                        $(".primeralavadainclib"+fila).text(inclinacionbw);
                        $(".primeralavadainclia"+fila).text(inclinacionaw);
                        $(".primeralavadarevirado"+fila).text(revirado);
                    }
    
                    
    
    
                    $(".primeralavadahilo"+fila).data("hilo",hilo);
                    $(".primeralavadahilo"+fila).data("trama",trama);
                    $(".primeralavadahilo"+fila).data("densidad",densidad);
                    $(".primeralavadahilo"+fila).data("inclinacionbw",inclinacionbw);
                    $(".primeralavadahilo"+fila).data("inclinacionaw",inclinacionaw);
                    $(".primeralavadahilo"+fila).data("revirado",revirado);

            
            
                    // OcultarCarga();
            
            
                }else{
                    Advertir("Ocurrio un error al regisrar");
                }
                
            }
    
        }
    
        $("#modalmoldeprimeralavada").modal("hide");
        OcultarCarga();
        
    
    
    
    });
    

}


// VERSION DE MOLDE
if(frmversionmolde != null){

    frmversionmolde.addEventListener('submit',async (e)=>{

        e.preventDefault();
    
        MostrarCarga();
    
    
        // VERIFICAMOS
        let checkfichas = $(".checkfichastbodyfichasasociadas_versionmolde");
        let versionmolde    = $("#txtversionmolde").val().trim();
    
    
        // DATA DE LAS FICHAS SELECCIONADAS
        for(let item of checkfichas){
    
            if ($(item).prop("checked")) {
                let ficha       = $(item).data("ficha");
                let estilotsc   = $(item).data("estilotsc");
                let fila        = $(item).data("fila");
                let loteficha        = $(item).data("lote");

    
    
                let response = await get("auditex-moldes", "encogimientoscorte", "set-versionmolde", {
                    ficha,
                    usuario:USUARIO,
                    estilotsc,
                    versionmolde,
                    loteficha
                });
            
                if(response){
    
                    if(versionmolde == ""){
                        $(".versionmolde"+fila).removeClass("btn-success");
                        $(".versionmolde"+fila).addClass("btn-primary");
    
                        $(".versionmolde"+fila).text("");
                        $(".versionmolde"+fila).append("<i class='fas fa-plus'></i>");
    
                        
                    }else{
                        $(".versionmolde"+fila).removeClass("btn-primary");
                        $(".versionmolde"+fila).addClass("btn-success");
    
                    $(".versionmolde"+fila).text(versionmolde);
    
                    }
    
                   
            
                    $(".versionmolde"+fila).data("moldeversion",versionmolde);
    
    
            
                }else{
                    Advertir("Ocurrio un error al regisrar");
                }
                
            }
    
        }
    
        $("#modalversionmolde").modal("hide");
        OcultarCarga();
    
    
    
        
    
    });

}
