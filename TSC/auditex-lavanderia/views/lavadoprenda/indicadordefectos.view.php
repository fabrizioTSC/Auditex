<?php
	date_default_timezone_set('America/Lima');

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';



    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo  = new CoreModelo();
    $objSistema = new SistemaModelo();

    $_SESSION['navbar'] = "Indicador Defectos";
    $showreport = isset($_POST["showreport"]) ? true : false;

    $sedelbl = "";
    $tiposerviciolbl = "";
    $tallerlbl = "";

    $sede_filtro = "";
    $tiposervicio_filtro = "";
    $taller_filtro = "";



    if($showreport){

        // var_dump($_POST["cbotaller"]);



        // FILTRO
        $sede_filtro           = isset($_POST["cbosede"])  ? $_POST["cbosede"] : "";
        $sede_filtro           = $sede_filtro !=  "" ?  $_POST["cbosede"] : null;

        $tiposervicio_filtro   = isset($_POST["cbotiposervicio"])  ? $_POST["cbotiposervicio"] : "";
        $tiposervicio_filtro   = $tiposervicio_filtro !=  "" ?  $_POST["cbotiposervicio"] : null;

        $taller_filtro         = isset($_POST["cbotaller"])  ? join("','",$_POST["cbotaller"]) : null;

        // REGISTRAMOS EN TEMPORAL
        // if($taller_filtro != null){

        //     $taller_a = $_POST["cbotaller"];

        //     foreach($taller_a as $fila){

        //         $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETTEMPORAL",[$fila],"AGREGADO");
        //         var_dump($response);

        //     }

        // }


        // var_dump($taller_filtro);

        $datosbusqueda          = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOSFILTROINDICADOR",[$sede_filtro,$tiposervicio_filtro,$taller_filtro]);

        
        $sedelbl                = $datosbusqueda["SEDE"];
        $tiposerviciolbl        = $datosbusqueda["TIPOSERVICIO"];
        $tallerlbl              = $datosbusqueda["TALLER"];

        // $sedelbl           = $sedelbl !=  "" ?  $_POST["cbosede"] : "(TODOS)";

        // $tiposerviciolbl   = isset($_POST["cbotiposervicio"])  ? $_POST["cbotiposervicio"] : "(TODOS)";
        // $tiposerviciolbl   = $tiposerviciolbl !=  "" ?  $_POST["cbotiposervicio"] : "(TODOS)";


        // $tallerlbl         = isset($_POST["cbotaller"])  ? join("','",$_POST["cbotaller"]) : "(TODOS)";
        


    }


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['navbar'] ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

    <style>
        body{
            padding-top: 50px !important;
            /* color:#fff !important; */

        }

        .font-size-11{
            font-size: 11.5px !important;
        }

        .hr{
            border: 1px solid #fff;
        }

        .custom-switch{
            float:right !important;
        }

        .containerdatos{
            margin-bottom: 100px !important;
        }

        .list-group-item.active{
            background-color: #922b21 !important;
        }

        .opcionesnav{
            cursor: pointer;
        }

        label,h1,h2,h3,h4,h5,h6{
            color:#fff !important;
        }

        .swal2-popup > label,h1,h2,h3,h4,h5,h6{ 
            color: #595959 !important;
        }

        

        #tbodydefectosagregados{
            color:#fff;
        }

        #tbodydefectosresultado{
            color:#fff;
        }
        
        .table-defectos > thead{
            table-layout: fixed;

        }

        .table-defectos > thead{
            font-size: 12px !important;
        }

        .table-defectos > tbody{
            font-size: 11px !important;
        }

        .table-defectos > td,th{
            padding: 0px !important;
        }

        .table-fichas > thead{
            font-size: 12px !important;
        }

        .table-fichas > tbody{
            font-size: 11px !important;
        }

        .table-fichas > td,th{
            padding: 0px !important;
        }

        .thead-fichas .w-bajo{
            width: 55px !important;
            overflow: auto;
        }

        .thead-fichas .w-bajo-2{
            width: 70px !important;
            overflow: auto;
        }

        .thead-fichas .w-bajo-3{
            width: 90px !important;
            overflow: auto;
        }

        .thead-fichas .w-bajo-4{
            width: 100px !important;
            overflow: auto;
        }
        

        label{
            margin-bottom: 0px !important;
        }



    </style>


</head>

<body>
    <div class="loader"></div>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>


    <div class="container-fluid mt-3">

        <!-- FILTRO INICIAL -->
        <?php if(!$showreport) : ?>
        
            <div class="container">

                <form action="" class="row justify-content-center" method="POST">

                    <div class="form-group col-12 col-md-8">
                        <label for="">Sede</label>
                        <select name="cbosede" id="cbosede" class="custom-select custom-select-sm select2 changescombos" style="width: 100%;" ></select>
                    </div>

                    <div class="form-group col-12 col-md-8">
                        <label for="">Tipo de Servicio</label>
                        <select name="cbotiposervicio" id="cbotiposervicio" class="custom-select select2 changescombos" style="width: 100%;" ></select>
                    </div>

                    <div class="form-group col-12 col-md-8">
                        <label for="">Taller</label>
                        <select name="cbotaller[]" id="cbotaller" class="custom-select select2" style="width: 100%;" multiple  data-placeholder="[TODOS]"></select>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="">&nbsp;</label>
                        <input type="hidden" name="showreport" value="true">
                        <button class="btn btn-sm btn-block btn-secondary" type="submit">Mostrar Indicadores</button>
                    </div>

                </form>

            </div>
        
        <?php endif; ?>

        <!-- SHOW INDICADOR -->
        <?php if($showreport): ?>

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-md-8 text-center">
                        <label for="" class="font-weight-bold">INDICADOR DE DEFECTOS DE LAVADO EN PRENDA</label>   
                    </div>

                    <div class="col-md-8 text-center">
                        <label for="" class="font-weight-bold">
                            SEDE: <?= $sedelbl; ?> / TIPO SERVICIO: <?= $tiposerviciolbl; ?>  / TALLER: <?= $tallerlbl; ?> 
                        </label>   
                    </div>

                    <!-- TABS -->
                    <div class="col-md-10">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="aniosemana-tab" onclick="opcion = 1;" data-toggle="tab" href="#aniosemana" role="tab" aria-controls="aniosemana" aria-selected="true">Año/Semana</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="rangofechas-tab" onclick="opcion = 2;" data-toggle="tab" href="#rangofechas" role="tab" aria-controls="rangofechas" aria-selected="false">Rango de Fechas</a>
                            </li>
                        </ul>
                    </div>

                    <!-- FILTROS -->
                    <div class="col-md-10 mt-3">

                        <div class="tab-content" id="myTabContent">

                            <!-- SEMANA -->
                            <div class="tab-pane fade show active" id="aniosemana" role="tabpanel" aria-labelledby="aniosemana-tab">
                                <div class="row">

                                    <div class="col-md-10">
                                        <input type="week" name="" id="txtsemanaanio" class="form-control form-control-sm">                                        
                                    </div>

                                    <div class="col-md-2">
                                        <button class="btn btn-sm btn-block btn-sistema btnbuscarreporte" type="button">Buscar</button>
                                    </div>

                                </div>
                            </div>

                            <!-- RANGO DE FECHAS -->
                            <div class="tab-pane fade" id="rangofechas" role="tabpanel" aria-labelledby="rangofechas-tab">

                                <div class="row">

                                    <label for="" class="col-md-1 col-label">Desde:</label>
                                    <div class="col-md-4">
                                        <input type="date" name="" id="txtfechainicio" class="form-control form-control-sm">
                                    </div>

                                    <label for="" class="col-md-1 col-label">Hasta:</label>
                                    <div class="col-md-4">
                                        <input type="date" name="" id="txtfechafin" class="form-control form-control-sm">
                                    </div>

                                    <div class="col-md-2">
                                        <button class="btn btn-sm btn-block btn-sistema btnbuscarreporte" type="button">Buscar</button>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- TABLA -->
                    <div class="col-md-12 mt-3">
                        <table class="table table-sm table-bordered table-hover table-fichas">
                            <thead class="thead-sistema">
                                <tr>
                                    <th>DEFECTO</th>
                                    <th>MUESTRA</th>
                                    <th>TOTAL</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody id="tbodydefectos">

                            </tbody>
                        </table>
                    </div>

                    <!-- EXPORTAR -->
                    <div class="col-md-3 mt-2">
                        <button class="btn btn-sm btn-block btn-success" type="button" id="btnexportargeneral">Exportar</button>
                    </div>

                    <!-- VOLVER -->
                    <div class="col-md-3 mt-2">
                        <button class="btn btn-sm btn-block btn-secondary" type="button" id="btnvolverinicio">
                            <i class="fas fa-arrow-left"></i>
                            Volver
                        </button>
                    </div>

                </div>
            </div>



        <?php endif; ?>


    </div>

    <!-- MODAL CON INDICADOR -->
    <div class="modal fade" id="modalindicador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    SEDE: <?= $sedelbl; ?> / TIPO SERVICIO: <?= $tiposerviciolbl; ?>  / TALLER: <?= $tallerlbl; ?> 
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <h4 class="text-center" id="lbldefectoindicador"></h4>
                </div>

                <div class="form-group" id="chartgeneralcontainer" style="height: 400px;">
                    <canvas id="chartgeneral" ></canvas>
                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-sm table-defectos">
                        <thead id="theaddefectodetalle" class="thead-sistema">

                        </thead>
                        <tbody id="tbodydefectodetalle">

                        </tbody>
                    </table>

                </div>                

            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
                <button type="button" class="btn btn-danger" id="btnexportarpdf" type="button">Descargar PDF</button>
            </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>


    <script>
        let opcion      = "1";
        let ARRAYDATOS  = [];
        let anio            = "";
        let semana          = "";
        let fechainicio     = "";
        let fechafin        = "";
        let sede            = "<?= $sede_filtro ?>";
        let tiposervicio    = "<?= $tiposervicio_filtro ?>";
        let taller          = "<?= $taller_filtro ?>";
        let TITULOS         = [];
        let DEFECTOS        = [];
        let MUESTRAS        = [];
        let DEFECTOSTOT             = [];
        let DEFECTOSPORCENTAJE      = [];
        let DEFECTOINDICADOR = "";

        // $sedelbl = "";
        // $tiposerviciolbl = "";
        // $tallerlbl = "";


        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {

            // BUSCAR REPORTE
            $(".btnbuscarreporte").click(async function(){
                await getReporte();
            });

            // MOSTRAR DETALLE
            $("#tbodydefectos").on('click','.showdetail',function(){

                let id      = $(this).data("id");
                let detalle = $(`.detalle_${id}`);

                if(detalle.hasClass("d-none")){
                    $(this).html("<i class='fas fa-minus'></i>");
                    detalle.removeClass("d-none");
                }else{
                    $(this).html("<i class='fas fa-plus'></i>");
                    detalle.addClass("d-none");
                }

            });

            // MOSTRAMOS INDICADOR POR DEFECTO
            $("#tbodydefectos").on('click','.selectdefecto',async function(){

                MostrarCarga();

                let iddefecto       = $(this).data("id");
                DEFECTOINDICADOR    = $(this).data("defecto");
                let parameters = {
                    opcion : 1,anio,semana,fechainicio,fechafin,sede,tiposervicio,taller,iddefecto
                };

                

                let anios_data   = await get("auditex-lavanderia","lavadoprenda","get-indicador-defectos-detalle",parameters);
                parameters.opcion = 2;
                let meses_data     = await get("auditex-lavanderia","lavadoprenda","get-indicador-defectos-detalle",parameters);
                parameters.opcion = 3;
                let semanas_data  = await get("auditex-lavanderia","lavadoprenda","get-indicador-defectos-detalle",parameters);


                let dataconcat  = [].concat(anios_data,meses_data,semanas_data);



                // setTableIndicador(anios_data,meses_data,semanas_data);
                setTableIndicador(dataconcat);
                $("#lbldefectoindicador").text("DEFECTO: " + DEFECTOINDICADOR);


                $("#modalindicador").modal("show");


                OcultarCarga();

                // console.log(anios_data,meses_data,semanas_data);


            });

            // EXPORTAR 
            $("#btnexportargeneral").click(function(){

                var form = document.createElement("form");
                form.method = "POST";
                form.action = "../../../controllers/auditex-lavanderia/lavadoprenda.controller.php";   
                form.target = "_blank";

                var operacion = document.createElement("input");  
                operacion.value= "get-reporte-general-indicador";
                operacion.name = "operacion";
                form.appendChild(operacion);

                var data = document.createElement("input");  
                data.value =  JSON.stringify(ARRAYDATOS);
                data.name = "data";
                form.appendChild(data);

                // var imagen = document.createElement("input");  
                // imagen.value= document.getElementById("chartgeneral").toDataURL("image/png");
                // imagen.name = "imagen";
                // form.appendChild(imagen);

                // AGREGAMOS INPUT AL FORMULARIO
                document.body.appendChild(form);

                // ENVIAMOS FORMULARIO
                form.submit();

                // REMOVEMOS FORMULARIO
                document.body.removeChild(form);
                        

                // console.log(ARRAYDATOS);

            });

            // EXPORTA PDF
            $("#btnexportarpdf").click(function(){

                var form = document.createElement("form");
                form.method = "POST";
                form.action = "../lavados/pdfindicadordefectos.report.php"   ;
                form.target = "_blank";


                // GRAFICO
                var imagen = document.createElement("input");  
                imagen.value= document.getElementById("chartgeneral").toDataURL("image/png");
                imagen.name = "imagen";
                form.appendChild(imagen);

                // DATA
                let datos = {
                    titulo: TITULOS,
                    defectos: DEFECTOS,
                    muestras: MUESTRAS,
                    defectostot: DEFECTOSTOT,
                    defectosporcentaje: DEFECTOSPORCENTAJE,
                    titulofiltro: "SEDE: <?= $sedelbl; ?> / TIPO SERVICIO: <?= $tiposerviciolbl; ?>  / TALLER: <?= $tallerlbl; ?> ",
                    defectolbl: DEFECTOINDICADOR,
                    tipolavado:"PRENDAS"
                }

                // let DEFECTOS        = [];
                // let MUESTRAS        = [];
                // let DEFECTOSTOT             = [];
                // let DEFECTOSPORCENTAJE      = [];

                var data = document.createElement("input");  
                data.value =  JSON.stringify(datos);
                data.name = "data";
                form.appendChild(data);

                // AGREGAMOS INPUT AL FORMULARIO
                document.body.appendChild(form);

                // ENVIAMOS FORMULARIO
                form.submit();

                // REMOVEMOS FORMULARIO
                document.body.removeChild(form);


            });

            // VOLVER
            $("#btnvolverinicio").click(function(){
                window.location = "indicadordefectos.view.php";
            });

            // 
            $(".changescombos").change(function(){
                getTallerMaquina();
            });

            // SEDES
            await getSedes();

            await getTipoServicios();
            
            <?php if(!$showreport): ?>
                getTallerMaquina();
            <?php endif; ?>

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");

        });

        // GET REPORTE GENERAL
        async function getReporte(){

            MostrarCarga();

            let inputf = $("#txtsemanaanio").val();
            anio            = "";
            semana          = "";
            fechainicio     = $("#txtfechainicio").val();
            fechafin        = $("#txtfechafin").val();
            // sede            = "";
            // tiposervicio    = "";
            // taller          = "";



            if(inputf != "" && inputf != null){
                anio    = inputf.split("-W")[0];
                semana  = inputf.split("-W")[1];
            }

           // OBTENEMOS MUESTRA
           let muestratotal = await get("auditex-lavanderia","lavadoprenda","get-muestra-indicador-defectos",{
                opcion,anio,semana,fechainicio,fechafin,     sede,tiposervicio,taller
           });

            //    console.log("MUESTRA TOTAL",muestratotal);
            

            let response = await get("auditex-lavanderia","lavadoprenda","get-indicador-defectos",{
                opcion,anio,semana,fechainicio,fechafin,
                sede,tiposervicio,taller
            });

            if(response){
                    
                ARRAYDATOS = [];

                // AGREGAMOS DEFECTOS
                for(let item of response){

                    // BUSCAMOS 
                    if(!ARRAYDATOS.find( (obj)  => obj.iddefecto == item.CODDEF )){

                        let json = {};
                        
                        json.iddefecto      = item.CODDEF;
                        json.defecto        = item.DESDEF;
                        // json.muestratotal   = format_miles( item.MUESTRATOTAL);
                        json.muestratotal   = muestratotal.MUESTRA;

                        // AGREGAMOS TALLERES
                        let talleres   = response.filter(obj => obj.CODDEF == item.CODDEF).map((object)=>{

                            var obj = {};
                            obj.taller     = object.TALLER;
                            obj.muestra     = format_miles( parseFloat(object.MUESTRA) );
                            obj.cantidad    = parseFloat(object.CANTIDAD);
                            obj.porcentaje  = (object.CANTIDAD / object.MUESTRA) * 100;
                            return obj;

                        });

                        // OBTENEMOS SUMA DE DEFECTOS
                        let totaldef = talleres.reduce(function (a, b) {
                            return a + parseFloat(b.cantidad);
                        },0);

                        json.cantidad   = totaldef;

                        // ORDENAMOS 
                        talleres.sort((a,b) => (a.porcentaje < b.porcentaje) ? 1 : ((b.porcentaje < a.porcentaje) ? -1 : 0 ));
                        json.talleres = talleres;

                        

                        // CALCULAMOS TOTAL DE DEFECTOS
                        // json.porcentaje  = (json.cantidad / item.MUESTRATOTAL) * 100;
                        json.porcentaje  = (json.cantidad / muestratotal.MUESTRA) * 100;


                        // AGREGAMOS 
                        ARRAYDATOS.push(json);
                    }
                }

                // ORDENAMOS
                ARRAYDATOS.sort((a,b) => (a.porcentaje < b.porcentaje) ? 1 : ((b.porcentaje < a.porcentaje) ? -1 : 0 ));

                // ARMAMOS TABLA
                let tr = "";
                let cont = 0;

                for(let item of ARRAYDATOS ){

                    cont++;

                    // CABECERA
                    tr += `
                        <tr class="bg-white " >
                            <td class="border-table">
                                <button data-id='${item.iddefecto}' class='btn btn-sm btn-primary p-0 showdetail' style='min-width:10px' type='button'>  
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button data-defecto='${item.defecto}' data-id='${item.iddefecto}' class='btn btn-sm btn-warning p-0 selectdefecto' style='min-width:10px' type='button'>  
                                    <i class="fas fa-chart-line"></i>
                                </button>
                                ${cont}. ${item.defecto}
                            </td>
                            <td class="text-center border-table">${item.muestratotal}</td>
                            <td class="text-center border-table">${item.cantidad}</td>
                            <td class="text-center border-table">${item.porcentaje.toFixed(2)}%</td>
                        </tr>
                    `;

                    // DETALLE
                    for(let obj of item.talleres){

                        tr += `
                            <tr class="bg-secondary-sistema d-none detalle_${item.iddefecto}" >
                                <td class="border-table">
                                    ${obj.taller}
                                </td>
                                <td class="text-center border-table">${obj.muestra}</td>
                                <td class="text-center border-table">${obj.cantidad}</td>
                                <td class="text-center border-table">${obj.porcentaje.toFixed(2)}%</td>
                            </tr>
                        `;

                    }

                }

                $("#tbodydefectos").html(tr);

                OcultarCarga();

            }else{
                Advertir("Ocurrio un error");
            }

        }

        // ARMAR TABLA
        function setTableIndicador(data){

            // ##############################
            // ### VARIABLES PARA GRAFICO ###
            // ##############################
            TITULOS     = [];
            DEFECTOS    = [];
            MUESTRAS        = [];
            DEFECTOSTOT             = [];
            DEFECTOSPORCENTAJE      = [];
            let valores = [];
            let colores = [];


            // CABECERA
            let tr = "<tr>";
            tr += "<th style='min-width:100px'>DETALLE GENERAL</th>";
            for(let item of data){
                TITULOS.push(item.COLUMNA);
                tr += `<th style='min-width:80px' class="text-center">${item.COLUMNA}</th>`;
            }
            tr += "</tr>";

            $("#theaddefectodetalle").html(tr);

            
            

            // ###############
            // ### DETALLE ###
            // ###############

            let trdefectos = "";
            let trmuestras = "";
            let trdeftotal = "";
            let trporcentaje = "";

            trdefectos += "<tr> <th class='border-table'># DEF</th>";
            trmuestras += "<tr> <th class='border-table'># PRE. MUE.</th>";
            trdeftotal += "<tr> <th class='border-table'># DEF. TOT</th>";
            trporcentaje += "<tr> <th class='border-table'>% DEF.</th>";


            for(let item of data){
               

                trdefectos += `<td class="text-center border-table">${format_miles(item.TOTALDEFECTO)}</td>`;
                trmuestras += `<td class="text-center border-table">${format_miles(item.MUESTRA)}</th>`;
                trdeftotal += `<td class="text-center border-table">${format_miles(item.TOTAL)}</td>`;

                let porcentaje = parseFloat(item.TOTALDEFECTO) > 0 ?parseFloat(item.TOTALDEFECTO) / parseFloat(item.MUESTRA) : 0;
                porcentaje = porcentaje * 100;

                valores.push(porcentaje.toFixed(2));

                DEFECTOS.push(format_miles(item.TOTALDEFECTO));
                MUESTRAS.push(format_miles(item.MUESTRA));
                DEFECTOSTOT.push(format_miles(item.TOTAL));
                DEFECTOSPORCENTAJE.push(format_miles(porcentaje.toFixed(2)));

            //     MUESTRAS        = [];
            // DEFECTOSTOT             = [];
            // DEFECTOSPORCENTAJE      = [];

                if(item.TIPO == 1){
                    colores.push("#1f71c5");
                }

                if(item.TIPO == 2){
                    colores.push("#46c711");
                }

                if(item.TIPO == 3){
                    colores.push("#ead431");
                }

                trporcentaje += `<td class="text-center border-table">${porcentaje.toFixed(2)}%</td>`;


            }

            trdefectos += "</tr>";
            trmuestras += "</tr>";
            trdeftotal += "</tr>";
            trporcentaje += "</tr>";


            setGrafico("chartgeneral","chartgeneralcontainer",TITULOS,
                {
                    data:valores,
                    color:colores 
                }
            );


            $("#tbodydefectodetalle").html(trdefectos+trmuestras+trdeftotal+trporcentaje);

        }

        // GRAFICO
        function setGrafico(chartname, contenedorchart,titulos,datos, titulochart = false, mostrarleyenda = false) {


            //QUITAMOS CANVAS
            $(`#${chartname}`).remove();
            $(`#${contenedorchart}`).append(`<canvas id='${chartname}'></canvas>`);

            var ctx = document.getElementById(chartname).getContext('2d');
            
            // TITULO
            let title = {};
            if(titulochart){
                title.display = true;
                title.text = titulochart;
            }



            // CREAMOS CHART
            var mixedChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [
                        {
                            label: '% Liberadas',
                            data: datos.data,
                            order: 1,
                            // backgroundColor: "#28a745",
                            backgroundColor:datos.color,
                        },
                        // {
                        //     label: '% Pendientes',
                        //     data: datos.pendientes,
                        //     type: 'line',
                        //     fill: false,
                        //     yAxisID: 'B',
                        //     lineTension: 0,  
                        //     borderColor: '#dc3545',
                        //     borderWidth: 3,
                        // },

                    ],
                    labels: titulos
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display:  mostrarleyenda,
                        position: 'top',
                    },
                    title,
                    // scales: {
                    //     yAxes: [
                    //         {
                    //             id: 'A',
                    //             type: 'linear',
                    //             position: 'left',
                    //             ticks: {
                    //                 min: 0,
                    //                 max: 120,
                    //                 stepSize: 20,
                    //                 display:true

                    //             },
                    //         },
                    //         {
                    //             id: 'B',
                    //             type: 'linear',
                    //             position: 'right',
                    //             ticks: {
                    //                 min: 0,
                    //                 max: 120,
                    //                 display:false
                    //             },
                    //             gridLines: {
                    //                 display: false
                    //             }
                    //         },
                    //     ]
                    // },
                    tooltips: {
                        enabled: false,
                    },
                    legend:{
                        labels:{
                            usePointStyle: true
                        }
                    },
                    plugins: {
                        datalabels: {
                            color: 'black',
                            font:{
                                weight:'bold'
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        onComplete : function () {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            

                            this.data.datasets.forEach(function (dataset) {

                                for (var i = 0; i < dataset.data.length; i++) {

                                    for (var key in dataset._meta) {

                                        // console.log("Dataset",dataset);

                                        var model = dataset._meta[key].data[i]._model;
                                        var valor = 0;
                                        valor = dataset.data[i] + "%";

                                        ctx.fillText(valor, model.x , model.y - 5);  

                                    }
                                }


                            });
                        }
                    }
                }
            });

        }

        // GET SEDES
        async function getSedes(){

            let response = await get("auditex-generales","generales","getsedes",{ });
            setComboSimple("cbosede",response,"DESSEDE","CODSEDE",true,false,"TODOS");
            // console.log(response);
        }

        // GET SEDES
        async function getTipoServicios(){

            let response = await get("auditex-generales","generales","gettiposervicios",{ });
            setComboSimple("cbotiposervicio",response,"DESTIPSERV","CODTIPSERV",true,false,"TODOS");
        }

        // GET TALLER O MAQUINA
        function getTallerMaquina(){

            let idsede          = $("#cbosede").val() == "" ? null : $("#cbosede").val();
            let tiposervicio    = $("#cbotiposervicio").val() == "" ? null : $("#cbotiposervicio").val();

            // if(tiposervicio != null){
                MostrarCarga();
                get("auditex-lavanderia","lavadoprenda","get-taller-maquina",{ idsede,tiposervicio})
                .then(response =>{

                    setComboSimple("cbotaller",response,"DESCRIPCION","ID",false);
                    OcultarCarga();
                })
                .catch(error => {
                    Advertir("Error en ajax");
                });
                
            // }else{
            //     $("#cbotaller").html("<option value=''>[TODOS]</option>");
            // }

            


        }


    </script>

</body>

</html>