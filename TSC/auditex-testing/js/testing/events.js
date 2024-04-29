// BOLSA 1
$(".bolsa1hilo").keyup(function(){
    setHiloTrama("bolsa1hilo","totalbolsa1hilo");
    getPromedio("totalhilo","promediohilo");

    // HILO
    // replacebolsadetalle($(this),1,true);
});

$(".bolsa1trama").keyup(function(){
    setHiloTrama("bolsa1trama","totalbolsa1trama");
    getPromedio("totaltrama","promediotrama");

    // TRAMA
    // replacebolsadetalle($(this),1,false);
});

// BOLSA 2
$(".bolsa2hilo").keyup(function(){
    setHiloTrama("bolsa2hilo","totalbolsa2hilo");
    getPromedio("totalhilo","promediohilo");

    // HILO
    // replacebolsadetalle($(this),2,true);

});

$(".bolsa2trama").keyup(function(){
    setHiloTrama("bolsa2trama","totalbolsa2trama");
    getPromedio("totaltrama","promediotrama");

    // TRAMA
    // replacebolsadetalle($(this),2,false);
});

// BOLSA 3
$(".bolsa3hilo").keyup(function(){
    setHiloTrama("bolsa3hilo","totalbolsa3hilo");
    getPromedio("totalhilo","promediohilo");

    // HILO
    // replacebolsadetalle($(this),3,true);
});

$(".bolsa3trama").keyup(function(){
    setHiloTrama("bolsa3trama","totalbolsa3trama");
    getPromedio("totaltrama","promediotrama");

    // TRAMA
    // replacebolsadetalle($(this),3,false);
});

// REVIRADO 1   
$(".bolsa1acbd").keyup(function(){

    let ac = parseFloat($("#bolsa1ac").val().trim());
    let bd = parseFloat($("#bolsa1bd").val().trim());

    // REPLACE VALORES BOLSAS
    //replacebolsa(1,ac,bd);
    setRevirado(ac,bd,"reviradobolsa1");

});

// REVIRADO 2
$(".bolsa2acbd").keyup(function(){

    let ac = parseFloat($("#bolsa2ac").val().trim());
    let bd = parseFloat($("#bolsa2bd").val().trim());

    // replacebolsa(2,ac,bd);
    setRevirado(ac,bd,"reviradobolsa2");

});

// REVIRADO 3 
$(".bolsa3acbd").keyup(function(){

    let ac = parseFloat($("#bolsa3ac").val().trim());
    let bd = parseFloat($("#bolsa3bd").val().trim());

    // replacebolsa(3,ac,bd);
    setRevirado(ac,bd,"reviradobolsa3");

});


// HILO ENCOGIMIENTOS
$(".hiloencogimiento").keyup(function (){

    setEncogimientos("hilo");
        // let hilobefore  = parseFloatSistema($("#hiloencogimientobefore").val().trim());
        // let hiloafter   = parseFloatSistema($("#hiloencogimientoafter").val().trim());

        // let valor = hilobefore + hiloafter;
        // valor = valor / 2;
        // valor = valor / 25.5;
        // valor *= 100;
        // valor -= 100;


        // $("#hilocalculadoencogimiento").val(valor.toFixed(1) );

});

// TRAMA ENCOGIMIENTOS
$(".tramaencogimiento").keyup(function (){  

    setEncogimientos("trama");

    // let tramabefore  = parseFloatSistema($("#tramaencogimientobefore").val().trim());
    // let tramaafter   = parseFloatSistema($("#tramaencogimientoafter").val().trim());

    // let valor = tramabefore + tramaafter;
    // valor = valor / 2;
    // valor = valor / 25.5;
    // valor *= 100;
    // valor -= 100;

    // $("#tramacalculadoencogimiento").val(valor.toFixed(1) );

});

///////////////////////////////////


// BOLSA 1
$(".bolsa1hilo").focusout(function(){
    setHiloTrama("bolsa1hilo","totalbolsa1hilo");
    getPromedio("totalhilo","promediohilo");

});

$(".bolsa1trama").focusout(function(){
    setHiloTrama("bolsa1trama","totalbolsa1trama");
    getPromedio("totaltrama","promediotrama");

});

// BOLSA 2
$(".bolsa2hilo").focusout(function(){
    setHiloTrama("bolsa2hilo","totalbolsa2hilo");
    getPromedio("totalhilo","promediohilo");

});

$(".bolsa2trama").focusout(function(){
    setHiloTrama("bolsa2trama","totalbolsa2trama");
    getPromedio("totaltrama","promediotrama");

});

// BOLSA 3
$(".bolsa3hilo").focusout(function(){
    setHiloTrama("bolsa3hilo","totalbolsa3hilo");
    getPromedio("totalhilo","promediohilo");
});

$(".bolsa3trama").focusout(function(){
    setHiloTrama("bolsa3trama","totalbolsa3trama");
    getPromedio("totaltrama","promediotrama");
});

// REVIRADO 1   
$(".bolsa1acbd").focusout(function(){

    let ac = parseFloat($("#bolsa1ac").val().trim());
    let bd = parseFloat($("#bolsa1bd").val().trim());

    // REPLACE VALORES BOLSAS
    setRevirado(ac,bd,"reviradobolsa1");

});

// REVIRADO 2
$(".bolsa2acbd").focusout(function(){

    let ac = parseFloat($("#bolsa2ac").val().trim());
    let bd = parseFloat($("#bolsa2bd").val().trim());

    setRevirado(ac,bd,"reviradobolsa2");

});

// REVIRADO 3 
$(".bolsa3acbd").focusout(function(){

    let ac = parseFloat($("#bolsa3ac").val().trim());
    let bd = parseFloat($("#bolsa3bd").val().trim());

    setRevirado(ac,bd,"reviradobolsa3");

});


// HILO ENCOGIMIENTOS
$(".hiloencogimiento").focusout(function (){
    setEncogimientos("hilo");
});

// TRAMA ENCOGIMIENTOS
$(".tramaencogimiento").focusout(function (){  
    setEncogimientos("trama");
});



function setEncogimientos(tipo){

    let before  = parseFloatSistema($(`#${tipo}encogimientobefore`).val().trim());
    let after   = parseFloatSistema($(`#${tipo}encogimientoafter`).val().trim());

    // let valor = before + after;
    // valor = valor / 2;
    // valor = valor / 25.5;
    // valor *= 100;
    // valor -= 100;
    valor = after / before;
    valor *= 100;
    valor -= 100;


    $(`#${tipo}calculadoencogimiento`).val(valor.toFixed(1) );
}


//  VER DATOS DE PARTIDA O AGRUPAR PARTIDA
$("#container-datos-tela").on('click','.verpartida', async function(){

    let  ruta       = $(this).data("ruta");
    IDTESTING       = $(this).data("idtesting");
    PARTIDA         = $(this).data("partida");
    LOTE            = $(this).data("lote");
    KILOS           = $(this).data("kilos");
    IDPROVEEDOR     =  $(this).data("idproveedor");


    let response = await getSelectValue([
        {   id:"V",
            title:"Ver datos de partida"
        },
        {   id:"A",
            title:"Agrupar partidas"
        },
    ],"id","title","Seleccione operación");

    // SELECCIONAMOS
    if( response == "V"){
        window.open(ruta,"_blank");
    }

    if(response == "A"){

        // CARGAMOS DATOS
        await getPartidasAgrupadas(PARTIDA);
        $("#modalagrupador").modal("show");
    }

    // FILASOMBREADA = $(this).parent().data("filasombreado");
    // PintarDireccionales();

});


// AGRUPAMOS 
frmagrupador.addEventListener('submit', async function(e){

    e.preventDefault();
    await setAgruparPartidas();
});


// DESAGRUPAR
$("#tbodyagrupador").on('click','.desagrupar',function(e){

    let id = $(this).data("id");
    let partida = $(this).data("partidamadre");


    Preguntar("Confirme para desagrupar")
        .then(response => {

            // DESAGRUPAMOS
            if(response.value){

                MostrarCarga("Cargando");

                get("auditex-testing","testing","setdesagruparpartidas",{
                    id
                }).then(res => {

                        if(res.success){
                            getPartidasAgrupadas(partida).then(rpt => {
                                InformarMini(res.rpt);
                            }).catch(error => {

                            });

                        }else{
                            Advertir(res.rpt);
                        }

                }).catch(error => {
                    console.log(error);
                    Advertir("Error al desagrupar");
                });

            }

        })
        .catch(error => {
            Advertir("Ocurrio un error :(");
            console.log(error);
        });
    // console.log(id);

});


// GUARDAR MOTIVOS
$("#btnguardarmotivo").click(async function (){

    let motivos = $("#cbomotivosdevolucion").val();

    // REGISTRAMOS MOTIVOS
    if(motivos.length > 0){

        MostrarCarga("Cargando...");

        // REGISTRAMOS TESTING
        await setTesting(); 
        console.log("USUARIO:",USUARIO);
        let rptestado = await  get("auditex-testing","testing","setestadotesting",{
            idtesting:IDTESTING,estado:ESTADONUEVO,'user':USUARIO
        });

        // ELIMINAMOS ANTES DE REGISTRAR
        let responsedelete = await  get("auditex-testing","testing","deletemotivostesting",{
            idtesting:IDTESTING
        });


        // REGISTRAMOS MOTIVOS
        for(let mot of motivos){
            let response = await get("auditex-testing","testing","savemotivostesting",{
                idtesting:IDTESTING,
                idfammotivo:mot
            });

            // console.log(response);
        }
        
        // LIMPIAMOS
        $("#cbomotivosdevolucion").val("").trigger("change");

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

        // OCULTAMOS MODAL
        $("#modalmotivos").modal("hide");

    
        InformarMini("Actualizado correctamente");

    }else{
        Advertir("Seleccione un motivo");
    }

});



