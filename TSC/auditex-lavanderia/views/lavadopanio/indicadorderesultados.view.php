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

    $_SESSION['navbar'] = "Indicador de Resultados";
    $showreport = isset($_POST["showreport"]) ? true : false;
    $fecha = "";
    $sede = "";
    $tiposervicio = "";
    $taller = "";

    $sedelbl = "";
    $tiposerviciolbl = "";
    $tallerlbl = "";

    $sede_filtro = "";
    $tiposervicio_filtro = "";
    $taller_filtro = "";

    if($showreport){
        $fecha          = isset($_POST["fecha"]) ? $_POST["fecha"] : null;
        $sede           = isset($_POST["cbosede"]) ? $_POST["cbosede"] : null;
        $tiposervicio   = isset($_POST["cbotiposervicio"]) ? $_POST["cbotiposervicio"] : null;
        $taller         = isset($_POST["cbotaller"])  ? join("','",$_POST["cbotaller"]) : null;


        $datosbusqueda          = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOSFILTROINDICADOR",[$sede,$tiposervicio,$taller]);

        
        $sedelbl                = $datosbusqueda["SEDE"];
        $tiposerviciolbl        = $datosbusqueda["TIPOSERVICIO"];
        $tallerlbl              = $datosbusqueda["TALLER"];
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
        
        .table-indicador > thead{
            table-layout: fixed;

        }

        .table-indicador > thead{
            font-size: 12px !important;
        }

        .table-indicador > tbody{
            font-size: 11px !important;
        }

        .table-indicador > td,th{
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
                        <select name="cbosede" id="cbosede" class="custom-select select2" style="width: 100%;"></select>
                    </div>

                    <div class="form-group col-12 col-md-8">
                        <label for="">Tipo de Servicio</label>
                        <select name="cbotiposervicio" id="cbotiposervicio" class="custom-select select2" style="width: 100%;"></select>
                    </div>

                    <div class="form-group col-12 col-md-8">
                        <label for="">Taller</label>
                        <select name="cbotaller[]" id="cbotaller" class="custom-select select2" style="width: 100%;" data-placeholder="SELECCIONE" multiple></select>
                    </div>


                    <div class="form-group col-12 col-md-8">
                        <label for="">Fecha</label>
                        <input type="date" class="form-control form-control-sm" name="fecha" id="fecha" value="<?=  date("Y-m-d");?>">
                        <!-- <select name="" id="" class="custom-select"></select> -->
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

            <div class="row justify-content-center">


                <div class="col-md-2">
                    <a class="btn btn-sm btn-block btn-warning" href="indicadorderesultados.view.php">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-sm btn-block btn-danger" id="btnexportarpdf">Descargar PDF</button>
                </div>

               

            </div>

            <div class="row justify-content-center">
                
                <div class="col-8 text-center">
                    <label for="" class="font-weight-bold">INDICADORES DE RESULTADOS DE AUDITORÍA LAVANDERIA PAÑOS - GENERAL</label>
                    <br>
                    <label for="">
                        SEDE: <?= $sedelbl; ?> / TIPO SERVICIO: <?= $tiposerviciolbl; ?>  / TALLER: <?= $tallerlbl; ?> 
                    </label>
                    <h6 class="text-white">Auditorias Aprobadas y Rechazadas</h6>
                </div>

                <!--  CHART GENERAL -->
                <div class="col-8 bg-white" style="min-height: 500px;">

                    <canvas id="chartgeneral"></canvas>

                </div>

                <!-- TABLA -->
                <div class="col-8 mt-2">

                    <table class="table table-sm table-bordered table-indicador">

                        <thead id="theadindicador" class="thead-sistema">

                        </thead>
                        <tbody id="tbodyindicador">

                        </tbody>

                    </table>

                </div>

                <!-- ################### -->
                <!-- ##### PARETOS ##### -->
                <!-- ################### -->


                    <!-- NIVEL 1 -->

                        <!-- DIAGRAMA DE PARETO NIVEL 1 (SEMANA) -->
                        <div class="col-md-8 text-white mt-2 text-center " style="font-size: 13px !important;">
                            <hr>
                            <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°1</label>
                            <label class="w-100 font-weight-bold" id="lblpareto1">
                                <?php
                                    if($showreport){
                                        // CREAMOS FECHA
                                        // $fecha = $_POST["fecha"];
                                        $fechaComoEntero = strtotime($fecha);
                                        echo date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);
                                    }
                                ?>
                            </label>
                        </div>

                        <!-- GRAFICO PARETO 1 -->
                        <div class="card col-md-8 p-0 text-center" >
                            <div class="card-body p-0">
                                <div class="form-group" id="chartpareto1container" style="height: 400px;">
                                    <canvas id="chartpareto1" ></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- TABLA PARETO 1 -->
                        <div class="card col-md-6 mt-1  p-0" >
                            <div class="table-responsive">
                                
                                <table class="table table-sm  text-center table-bordered-sistema table-indicador m-0" id="chartpareto1table">
                                        <thead class="thead-sistema">
                                            <tr>    
                                                <th>MOTIVOS</th>
                                                <th>FRECUENCIA</th>
                                                <th>%</th>
                                                <th>% ACUMULADO</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chartpareto1tbody"></tbody>
                                </table>
                                
                            </div>
                        </div>

                        
                        <!-- DIAGRAMA DE PARETO NIVEL 1 (MES) -->
                        <div class="col-md-8 text-white mt-2 text-center" style="font-size: 13px !important;">
                            <hr>
                            <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°1</label>
                            <label class="w-100 font-weight-bold" id="lblpareto2">
                                <?php
                                    if($showreport){
                                        // setlocale(LC_TIME, "spanish");			
                                        // CREAMOS FECHA
                                        // $fecha = $_POST["fecha"];
                                        echo date("Y", $fechaComoEntero) ." - " . $objSistema->getNameMonth($fecha);
                                    }
                                ?>
                            </label>
                        </div>

                        <!-- GRAFICO PARETO 2 -->
                        <div class="card col-md-8 p-0" >
                            <div class="card-body p-0">
                                <div class="form-group" id="chartpareto2container" style="height: 400px;">
                                    <canvas id="chartpareto2" ></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- TABLA PARETO 2 -->
                        <div class="card col-md-6 mt-1  p-0" >
                            <div class="table-responsive">
                                
                                <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chartpareto2table">
                                        <thead class="thead-sistema">
                                            <tr>    
                                                <th>MOTIVOS</th>
                                                <th>FRECUENCIA</th>
                                                <th>%</th>
                                                <th>% ACUMULADO</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chartpareto2tbody"></tbody>
                                </table>
                                
                            </div>
                        </div>

                    <!-- ############### -->
                    <!-- ### NIVEL 2 ### -->
                    <!-- ############### -->

                                    
                        <!-- DIAGRAMA DE PARETO NIVEL 2 - PRIMER MAYOR DEFECTO - SEMANAL-->
                        <div class="col-md-8 text-white mt-2 text-center" style="font-size: 13px !important;">
                            <hr>
                            <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                            <label for=""  class="w-100 font-weight-bold">
                                <?php
                                    if($showreport){
                                        $fechaComoEntero = strtotime($fecha);
                                        echo date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);
                                    }
                                ?>
                            </label>
                            <label class="w-100 font-weight-bold" id="lblpareto3"></label>
                        </div>

                        <!-- GRAFICO PARETO 2 -  PRIMER MAYOR DEFECTO - SEMANAL -->
                        <div class="card col-md-8 p-0" >
                            <div class="card-body p-0">
                                <div class="form-group" id="chartpareto3container" style="height: 400px;">
                                    <canvas id="chartpareto3" ></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- TABLA PARETO 2 -  PRIMER MAYOR DEFECTO - SEMANAL -->
                        <div class="card col-md-6 mt-1  p-0" >
                            <div class="table-responsive">
                                
                                <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chartpareto3table">
                                        <thead class="thead-sistema">
                                            <tr>    
                                                <th>MOTIVOS</th>
                                                <th>FRECUENCIA</th>
                                                <th>%</th>
                                                <th>% ACUMULADO</th>
                                                <th>% DEL GENERAL</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chartpareto3tbody"></tbody>
                                </table>
                                
                            </div>
                        </div>




                        <!-- DIAGRAMA DE PARETO NIVEL 2 - SEGUNDO MAYOR DEFECTO - SEMANAL -->
                        <div class="col-md-8 text-white mt-2 text-center" style="font-size: 13px !important;">
                            <hr>
                            <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                            <label class="w-100 font-weight-bold" >
                                <?php
                                    if($showreport){
                                        // CREAMOS FECHA
                                        $fecha = $_POST["fecha"];
                                        $fechaComoEntero = strtotime($fecha);
                                        echo date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);
                                    }
                                ?>
                            </label>
                            <label class="w-100 font-weight-bold" id="lblpareto4"></label>
                        </div>

                        <!-- GRAFICO PARETO 2 -  SEGUNDO MAYOR DEFECTO - SEMANAL -->
                        <div class="card col-md-8 p-0" >
                            <div class="card-body p-0">
                                <div class="form-group" id="chartpareto4container" style="height: 400px;">
                                    <canvas id="chartpareto4" ></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- TABLA PARETO 2 -  SEGUNDO MAYOR DEFECTO - SEMANAL -->
                        <div class="card col-md-6 mt-1  p-0" >
                            <div class="table-responsive">
                                
                                <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chartpareto4table">
                                        <thead class="thead-sistema">
                                            <tr>    
                                                <th>MOTIVOS</th>
                                                <th>FRECUENCIA</th>
                                                <th>%</th>
                                                <th>% ACUMULADO</th>
                                                <th>% DEL GENERAL</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chartpareto4tbody"></tbody>
                                </table>
                                
                            </div>
                        </div>




                        <!-- DIAGRAMA DE PARETO NIVEL 2 - PRIMER MAYOR DEFECTO - MENSUAL -->
                        <div class="col-md-8 text-white mt-2 text-center" style="font-size: 13px !important;">
                            <hr>
                            <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                            <label class="w-100 font-weight-bold" >
                                <?php
                                    if($showreport){
                                        // setlocale(LC_TIME, "spanish");			
                                        // CREAMOS FECHA
                                        // $fecha = $_POST["fecha"];
                                        // $fechaComoEntero = strtotime($fecha);
                                        // $mes = strftime("%B", strtotime($fechaComoEntero));
                                        
                                        echo date("Y", $fechaComoEntero) ." - " .$objSistema->getNameMonth($fecha);
                                    }
                                ?>
                            </label>
                            <label class="w-100 font-weight-bold" id="lblpareto5"></label>

                        </div>

                        <!-- GRAFICO PARETO 2 -  PRIMER MAYOR DEFECTO - MENSUAL -->
                        <div class="card col-md-8 p-0" >
                            <div class="card-body p-0">
                                <div class="form-group" id="chartpareto5container" style="height: 400px;">
                                    <canvas id="chartpareto5" ></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- TABLA PARETO 2 -  PRIMER MAYOR DEFECTO - MENSUAL -->
                        <div class="card col-md-6 mt-1  p-0" >
                            <div class="table-responsive">
                                
                                <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chartpareto5table">
                                        <thead class="thead-sistema">
                                            <tr>    
                                                <th>MOTIVOS</th>
                                                <th>FRECUENCIA</th>
                                                <th>%</th>
                                                <th>% ACUMULADO</th>
                                                <th>% DEL GENERAL</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chartpareto5tbody"></tbody>
                                </table>
                                
                            </div>
                        </div>

                    


                        <!-- DIAGRAMA DE PARETO NIVEL 2 - SEGUNDO MAYOR DEFECTO - MENSUAL -->
                        <div class="col-md-8 text-white mt-2 text-center" style="font-size: 13px !important;">
                            <hr>
                            <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                            <label class="w-100 font-weight-bold">
                                <?php
                                    if($showreport){
                                        // setlocale(LC_TIME, "spanish");			
                                        // CREAMOS FECHA
                                        // $fecha = $_POST["fecha"];
                                        // $fechaComoEntero = strtotime($fecha);
                                        // $mes = strftime("%B", strtotime($fechaComoEntero));
                                        // echo date("Y", $fechaComoEntero) ." - " . ucwords($mes);
                                        // $fecha = $_POST["fecha"];
                                        echo date("Y", $fechaComoEntero) ." - " .$objSistema->getNameMonth($fecha);
                                    }
                                ?>
                            </label>
                            <br>
                            <label class="w-100 font-weight-bold" id="lblpareto6"></label>
                        </div>

                        <!-- GRAFICO PARETO 2 -  SEGUNDO MAYOR DEFECTO - MENSUAL -->
                        <div class="card col-md-8 p-0" >
                            <div class="card-body p-0">
                                <div class="form-group" id="chartpareto6container" style="height: 400px;">
                                    <canvas id="chartpareto6" ></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- TABLA PARETO 2 -  SEGUNDO MAYOR DEFECTO - MENSUAL -->
                        <div class="card col-md-6 mt-1  p-0" >
                            <div class="table-responsive">
                                
                                <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chartpareto6table">
                                        <thead class="thead-sistema">
                                            <tr>    
                                                <th>MOTIVOS</th>
                                                <th>FRECUENCIA</th>
                                                <th>%</th>
                                                <th>% ACUMULADO</th>
                                                <th>% DEL GENERAL</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chartpareto6tbody"></tbody>
                                </table>
                                
                            </div>
                        </div>      

            </div>


        <?php endif; ?>


    </div>

    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>


    <script src="../../js/lavados/panio/indicadorresultados.js"></script>
    

    <script>

        let CONFIINDICADOR = [];

        let TITULOS = [];

        let APROBADAS_CANT = [];
        let RECHAZADAS_CANT = [];
        let TOTAL_CANT = [];
        let APROBADAS_CANT_POR = [];
        let APROBADAS_CANT_POR2 = [];
        let RECHAZADAS_CANT_POR = [];

        let APROBADAS_PREN = [];
        let RECHAZADAS_PREN = [];
        let TOTAL_PREN = [];
        let APROBADAS_PREN_POR = [];
        let RECHAZADAS_PREN_POR = [];
        let BACKCOLORGRAFICO = [];

        let datopareto1;
        let datopareto2;
        let datopareto3;
        let datopareto4;
        let datopareto5;
        let datopareto6;



        let primermayodefecto1 = "";
        let segundomayodefecto1 = "";
        let primermayodefecto2 = "";
        let segundomayodefecto2 = "";


        

        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {

            CONFIINDICADOR = await getMantIndicadores(3);


            // SEDES
            await getSedes();

            await getTipoServicios();

            <?php if(!$showreport): ?>
                getTallerMaquina();
            <?php else: ?>

                let fecha = "<?= $fecha?>";
                let sede =  "<?= $sede?>";
                let tiposervicio =  "<?= $tiposervicio?>";
                let taller =  "<?= $taller?>";

                await getDatosIndicador(fecha,sede,tiposervicio,taller);

                // EXPORTAR PDF
                $("#btnexportarpdf").click(function(){
                    
                    var form = document.createElement("form");
                    form.method = "POST";
                    form.action = "../lavados/pdfindicadorresultados.report.php"   ;
                    form.target = "_blank";


                    // GRAFICO
                    var imagen = document.createElement("input");  
                    imagen.value= document.getElementById("chartgeneral").toDataURL("image/png");
                    imagen.name = "imagen";
                    form.appendChild(imagen);

                    // DATA
                    let datos = {
                        titulo: TITULOS,
                        aprobadas_cant: APROBADAS_CANT,
                        rechazadas_cant: RECHAZADAS_CANT,
                        total_cant: TOTAL_CANT,
                        aprobadas_por_cant: APROBADAS_CANT_POR,
                        rechazadas_por_cant: RECHAZADAS_CANT_POR,

                        aprobadas_pren: APROBADAS_PREN,
                        rechazadas_pren: RECHAZADAS_PREN,
                        total_pren: TOTAL_PREN,
                        aprobadas_por_pren: APROBADAS_PREN_POR ,
                        rechazadas_por_pren: RECHAZADAS_PREN_POR ,
                        titulofiltro: "SEDE: <?= $sedelbl; ?> / TIPO SERVICIO: <?= $tiposerviciolbl; ?>  / TALLER: <?= $tallerlbl; ?> ",
                        tipolavado: "PAÑOS"

                        // defectolbl: DEFECTOINDICADOR
                    }

                    

                    var data = document.createElement("input");  
                    data.value =  JSON.stringify(datos);
                    data.name = "data";
                    form.appendChild(data);


                    // DATOS PARETOS 1
                    var pareto1 = document.createElement("input");  
                    pareto1.value =  JSON.stringify(
                        {
                            img :document.getElementById("chartpareto1").toDataURL("image/png"),
                            data: datopareto1,
                            lbl:document.getElementById("lblpareto1").innerText
                        }
                        
                    )
                    pareto1.name = "pareto1";
                    form.appendChild(pareto1);

                    // DATOS PARETOS 2
                    var pareto2 = document.createElement("input");  
                    pareto2.value =  JSON.stringify(
                        {
                            img :document.getElementById("chartpareto2").toDataURL("image/png"),
                            data: datopareto2,
                            lbl:document.getElementById("lblpareto2").innerText
                        }
                    )
                    pareto2.name = "pareto2";
                    form.appendChild(pareto2);

                    // DATOS PARETOS 3
                    var pareto3 = document.createElement("input");  
                    pareto3.value =  JSON.stringify(
                        {
                            img :document.getElementById("chartpareto3").toDataURL("image/png"),
                            data: datopareto3,
                            lbl:document.getElementById("lblpareto3").innerText
                        }
                    )
                    pareto3.name = "pareto3";
                    form.appendChild(pareto3);

                    // DATOS PARETOS 4
                    var pareto4 = document.createElement("input");  
                    pareto4.value =  JSON.stringify(
                        {
                            img :document.getElementById("chartpareto4").toDataURL("image/png"),
                            data: datopareto4,
                            lbl:document.getElementById("lblpareto4").innerText
                        }
                    )
                    pareto4.name = "pareto4";
                    form.appendChild(pareto4);

                    // DATOS PARETOS 5
                    var pareto5 = document.createElement("input");  
                    pareto5.value =  JSON.stringify(
                        {
                            img :document.getElementById("chartpareto5").toDataURL("image/png"),
                            data: datopareto5,
                            lbl:document.getElementById("lblpareto5").innerText
                        }
                    )
                    pareto5.name = "pareto5";
                    form.appendChild(pareto5);

                    // DATOS PARETOS 6
                    var pareto6 = document.createElement("input");  
                    pareto6.value =  JSON.stringify(
                        {
                            img :document.getElementById("chartpareto6").toDataURL("image/png"),
                            data: datopareto6,
                            lbl:document.getElementById("lblpareto6").innerText
                        }
                    )
                    pareto6.name = "pareto6";
                    form.appendChild(pareto6);


                    // AGREGAMOS INPUT AL FORMULARIO
                    document.body.appendChild(form);

                    // ENVIAMOS FORMULARIO
                    form.submit();

                    // REMOVEMOS FORMULARIO
                    document.body.removeChild(form);


                });




            <?php endif; ?>

            


            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");

        });


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
                    
            


            }





    </script>

</body>

</html>