<?php
	date_default_timezone_set('America/Lima');
    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';

    session_start();
    // if (!isset($_SESSION['user'])) {
    //     header('Location: index.php');
    // }

    $objModelo = new CoreModelo();
    $objSistema = new SistemaModelo();

    if(!isset($_GET["fecha"])){
        $fecha = date("Y-m-d");
    }else{
        $fecha = $_GET["fecha"];
    }
    $fechaComoEntero = strtotime($fecha);

    // PARAMETROS MONITOR
    $parametrosmonitor = $objModelo->getAll("AUDITEX.PQ_MONITORGERENCIAL.SPU_GETPARAMETROS",[]);
    $param1 = $parametrosmonitor[0]["VALOR"];
    $param2 = $parametrosmonitor[1]["VALOR"];
    $param3 = $parametrosmonitor[1]["VALOR"];
    $param4 = $parametrosmonitor[1]["VALOR"];



    // LINEAS
    $lineas = $objModelo->getAll("AUDITEX.PQ_MONITORGERENCIAL.SPU_GETLINEAS",[1,$fecha]);

    $totallineas            = count($lineas);
    $repetidos              = ceil($totallineas / 6);
    $alto                   = floor(76 / $repetidos);

    // DATA GENERAL
    $datageneral = $objModelo->get("AUDITEX.PQ_MONITORGERENCIAL.SPU_GETDATAGENERAL",[$fecha]);
    $prendasdefectos        = $datageneral["PRENDASDEFECTOS"] != "" ? (float)$datageneral["PRENDASDEFECTOS"] : 0;
    $prendasreproceso       = $datageneral["PRENDASREPROCESO"] != "" ? (float)$datageneral["PRENDASREPROCESO"] : 0;
    $prendasinspeccionadas  = $datageneral["PRENDASINSPECCIONADAS"] != "" ? (float)$datageneral["PRENDASINSPECCIONADAS"] : 0;

    $prendasdefectos_por    = $prendasinspeccionadas > 0 ? round(($prendasdefectos * 100) / $prendasinspeccionadas) : 0;
    $prendasreproceso_por   = $prendasinspeccionadas > 0 ? round(($prendasreproceso * 100) / $prendasinspeccionadas) : 0;

    // CLASE
    $clase_defectuosas = "";
    $clase_reproceso = "";


    if($prendasdefectos_por < $param3){
        $clase_defectuosas = "bg-success-gerencia";
    }

    if($prendasdefectos_por >= $param3 && $prendasdefectos_por < $param4){
        $clase_defectuosas = "bg-warning-gerencia";
    }

    if($prendasdefectos_por >= $param4 ){
        $clase_defectuosas = "bg-danger-gerencia";
    }


    if($prendasreproceso_por < $param3){
        $clase_reproceso = "bg-success-gerencia";
    }

    if($prendasreproceso_por >= $param3 && $prendasreproceso_por < $param4){
        $clase_reproceso = "bg-warning-gerencia";
    }

    if($prendasreproceso_por >= $param4 ){
        $clase_reproceso = "bg-danger-gerencia";
    }


    // CALCULAMOS GENERAL
    $eficacia_planta    = 0;
    $eficiencia_planta  = 0;
    $eficacia_planta_ant    = 0;
    $eficiencia_planta_ant  = 0;
    $cantlineas         = 0;

    foreach($lineas as $linea){

        if($linea["TURNO"] != null){
            $cantlineas++;
            $eficacia_planta    += $linea["EFICACIA"];
            $eficiencia_planta  += $linea["EFICIENCIA"];
            $eficacia_planta_ant    += $linea["EFICACIA_ANT"];
            $eficiencia_planta_ant  += $linea["EFICIENCIA_ANT"];

        }

    }

    $eficacia_planta    = round($eficacia_planta / $cantlineas);
    $eficiencia_planta  = round($eficiencia_planta / $cantlineas);
    $eficacia_planta_ant    = round($eficacia_planta_ant / $cantlineas);
    $eficiencia_planta_ant  = round($eficiencia_planta_ant / $cantlineas);

    $clase_eficacia_planta = "";
    $img_eficacia_planta = "";

    $clase_eficiencia_planta = "";
    $img_eficiencia_planta = "";

    

    // #### EFICACIAS ######

    // ROJO
    if($eficacia_planta < $param1){
        $clase_eficacia_planta = "bg-danger-gerencia";       
    }

    // AMARILLO
    if($eficacia_planta >= $param1 && $eficacia_planta < $param2){
        $clase_eficacia_planta = "bg-warning-gerencia";       
    }

    // VERDE
    if($eficacia_planta >= $param2 ){
        $clase_eficacia_planta = "bg-success-gerencia";       
    }


    // IMAGEN
    if($eficacia_planta_ant < $eficacia_planta){
        $img_eficacia_planta = "arrow-up-new.png";
    }

    if($eficacia_planta_ant > $eficacia_planta){
        $img_eficacia_planta = "arrow-down-new.png";
    }

    if($eficacia_planta_ant == $eficacia_planta){
        $img_eficacia_planta = "equal.png";
    }

     // #### EFICIENCIA ######

    // ROJO
    if($eficiencia_planta < $param1){
        $clase_eficiencia_planta = "bg-danger-gerencia";       
    }

    // AMARILLO
    if($eficiencia_planta >= $param1 && $eficiencia_planta < $param2){
        $clase_eficiencia_planta = "bg-warning-gerencia";       
    }

    // VERDE
    if($eficiencia_planta >= $param2 ){
        $clase_eficiencia_planta = "bg-success-gerencia";       
    }


    // IMAGEN
    if($eficiencia_planta_ant < $eficiencia_planta){
        $img_eficiencia_planta = "arrow-up-new.png";
    }

    if($eficiencia_planta_ant > $eficiencia_planta){
        $img_eficiencia_planta = "arrow-down-new.png";
    }

    if($eficiencia_planta_ant == $eficiencia_planta){
        $img_eficiencia_planta = "equal.png";
    }


    $lineas_nuevo = [];
    $cont   = 0;
    $conti  = 0;
    $maxlineas = 6;
    $array = [];
    $agregado = 5;

    for($i = 0 ; $i < $totallineas; $i++){

        $array[] = $lineas[$i];

        if($i == $agregado){
            $lineas_nuevo[] = $array;
            $array = [];
            $agregado += $maxlineas;
        }
    }

    if(count($array) > 0){

        if(count($array) == 6){
            $lineas_nuevo[] = $array;
        }

        if(count($array) < $maxlineas){

            for($j = count($array); $j < $maxlineas; $j++ ){

                $array[] = [
                    "LINEA" => null,
                    "EFICACIA" => 0,
                    "EFICACIA_ANT" => 0
                ];

            }

            $lineas_nuevo[] = $array;
        }


    }




    


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Monitor Gerencial</title>

     <!-- STYLE -->
     <?php require_once '../../../plantillas/style.view.php'; ?>

     <!-- Font Awesome -->
    <!-- <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    rel="stylesheet"
    /> -->
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.0/mdb.min.css"
    rel="stylesheet"
    />

     <style>


            html, body{
                width: 100%;
                margin: 0px;
                background-image: none !important;
                background-color: #151a30 !important;
                font-family: 'Roboto', sans-serif;
            }

            .header-container{
                background-color: #222b45 !important;
                border:.0625rem solid #101426 !important;
                border-radius: .25rem !important;
                color:#fff ;
            }



            .bg-success-gerencia{
                /* background-color: #00b74a !important; */
                background-color: green !important;

                border:.0625rem solid #101426 !important;
                border-radius: .25rem !important;
                color:#fff ;
            }

            .bg-danger-gerencia{
                /* background-color: #f93154 !important; */
                background-color: red !important;

                border:.0625rem solid #101426 !important;
                border-radius: .25rem !important;
                color:#fff ;
            }

             .bg-warning-gerencia{
                /* background-color: #ffa900 !important; */
                background-color: yellow !important;

                border:.0625rem solid #101426 !important;
                border-radius: .25rem !important;
                color:#000 ;
            }

            .bg-null{
                background-color: #959697 !important;
                /* background-color: yellow !important; */

                border:.0625rem solid #101426 !important;
                border-radius: .25rem !important;
                color:#000 ;
            }

            .title-letra{
                /* font-size: 7.5vh; */
                font-size: 6.8vh;

            }

            .bg-warning-gerencia{
                color:#000;
                background-color: yellow;
            }

            .bg-success-gerencia{
                color:#fff;
                background-color: green;
            }

            .bg-danger-gerencia{
                color:#fff;
                background-color: red;
            }

            .title-label{
                font-size: 3vh;
            }
            .title-label-lineas{
                font-size:2.5vh;
            }

            .title-label-2{
                font-size: 3.5vh;
            }

            .title-label-3{
                font-size: 3vh;
            }

            .title-label-eficacias{
                font-size: 3.6vh;
            }


     </style>

</head>
<body>

    <div class="loader"></div>

    <div class="container-fluid p-3" style="height:100vh">

        <!-- HEADER -->
        <div class="row" id="header-id">

            <div class="header-container col mr-2">


                <div class="row">


                    <label for="" class="font-weight-bold col-3 col-label title-label-2">Turno:</label>
                    <label for="" class="font-weight-bold col-9 col-label title-label-2">1</label>


                </div>

                <div class="row">
                    <label for="" class="font-weight-bold col-4 col-label title-label-2">Fecha:</label>
                    <div class="col-8">
                        <input type="date" name="" id="frmfecha" class="form-control" value="<?= $fecha; ?>">
                    </div>

                </div>  

                <div class="row">
                    <label for="" class="font-weight-bold col-12 col-label title-label-2">
                        Sem: <?= date("W", $fechaComoEntero);?> - Mes: <?= $objSistema->getNameMonthShort($fecha);?>
                    </label>

                </div>


            </div>
        
            <div class="header-container col mr-2">

                <div class="row text-center">

                    <div class="col-12">
                        <label class="font-weight-bold title-label-2">
                            Eficacia Planta
                        </label>
                    </div>
                    <div class="col-6 text-center">
                        <img class="h-100 w-50" src="/tsc/public/img/<?= $img_eficacia_planta ?>" alt="">
                    </div>
                    <div class="col-6">
                        <label class="font-weight-bold title-letra w-100">
                            <span class="badge w-100 <?=$clase_eficacia_planta?>"><?= $eficacia_planta;?>%</span>
                        </label>
                    </div>

                </div>
            </div>

            <div class="header-container col mr-2">

                <div class="row text-center">

                    <div class="col-12">
                        <label class="font-weight-bold title-label-2">
                            Eficiencia Planta
                        </label>
                    </div>

                    <div class="col-6 text-center">
                        <img class="h-100 w-50" src="/tsc/public/img/<?= $img_eficiencia_planta  ?>" alt="">
                    </div>
                    <div class="col-6 text-center">
                        <label class="font-weight-bold title-letra w-100">
                            <span class="badge w-100 <?=$clase_eficiencia_planta ?>"><?= $eficiencia_planta;?>%</span>
                        </label>
                    </div>
                </div>

            </div>

            <div class="header-container col mr-2">

                <div class="row text-center">

                    <div class="col-12">
                        <label class="font-weight-bold title-label-3">
                            Prendas Defectuosas
                        </label>
                    </div>

                    <div class="col-12">
                        <label class="font-weight-bold title-letra w-100">
                            <span class="badge w-100 <?= $clase_defectuosas ?>">
                                <?= $prendasdefectos ?>(<?= $prendasdefectos_por ?>%)
                            </span>
                        </label>
                    </div>

                </div>


            </div>

            <div class="header-container col">

                <div class="row text-center">

                    <div class="col-12">
                        <label class="font-weight-bold title-label-3">
                            Reproceso de Costura
                        </label>
                    </div>

                    <div class="col-12">

                        <label class="font-weight-bold title-letra w-100">
                            <span class="badge w-100 <?= $clase_reproceso ?>">
                                <?= $prendasreproceso ?>(<?= $prendasreproceso_por ?>%)
                            </span>
                        </label>

                    </div>

                </div>

            </div>

            
        </div>

        <!-- TITULO EFICIENCIAS -->
        <div class="row mt-2 mb-2" id="titulo-id">

            <div class="col-12 text-center header-container pt-2 pb-1">
                <label class="font-weight-bold title-label-eficacias"> Eficacias Por Línea</label>                
            </div>



        </div>
            

        <!-- EFICACIAS -->
        <?php foreach($lineas_nuevo as $lineas_new): ?>

            <div class="row filaseficacias">
                <?php $contcolumnas = 0; ?>
                <?php foreach($lineas_new as $linea): ?>

                    <?php

                        // $parametrosmonitor = "";
                        $contcolumnas++;
                        $clase = "";
                        $img = "";
                        $valoreficacia      = round($linea["EFICACIA"]);
                        $valoreficacia_ant  = round($linea["EFICACIA_ANT"]);

                        if($valoreficacia != null){
                            // ROJO
                            if($valoreficacia < $param1){
                                $clase = "bg-danger-gerencia";       
                            }

                            // AMARILLO
                            if($valoreficacia >= $param1 && $valoreficacia < $param2){
                                $clase = "bg-warning-gerencia";       
                            }

                            // VERDE
                            if($valoreficacia >= $param2 ){
                                $clase = "bg-success-gerencia";       
                            }


                            // IMAGEN
                            if($valoreficacia_ant < $valoreficacia){
                                $img = "arrow-up-new.png";
                            }

                            if($valoreficacia_ant > $valoreficacia){
                                $img = "arrow-down-new.png";
                            }

                            if($valoreficacia_ant == $valoreficacia){
                                $img = "equal.png";
                            }
                        }


                        if($valoreficacia == null){
                            $clase = "bg-null";       

                        }



                    ?>

                    <div class="<?= $clase; ?> col mb-2 <?= $contcolumnas < $maxlineas ? "mr-2" : ""; ?>" >


                        <div class="row">

                            <?php if($valoreficacia != null): ?>

                                <div class="col-12 text-center">
                                    <label class="font-weight-bold title-label-lineas">
                                        Línea <?= $linea["LINEA"] ?>
                                    </label>
                                </div>

                                <div class="col-5 text-center">
                                    <img class="h-100 w-100" src="/tsc/public/img/<?= $img ;?>" alt="">
                                </div>

                                <div class="col-7 text-center">
                                    <label class="font-weight-bold title-letra w-100">
                                        <?= $valoreficacia; ?>%
                                    </label>
                                </div>
                            <?php  endif; ?>


                            <?php if($valoreficacia == null): ?>

                                <?php if($linea["LINEA"] != null):  ?>

                                    <div class="col-12 text-center">
                                        <label class="font-weight-bold title-label">
                                            Línea <?= $linea["LINEA"] ?>
                                        </label>
                                    </div>

                                    <div class="col-5">
                                    </div>

                                    <div class="col-7 text-center">
                                        <label class="font-weight-bold title-letra w-100">
                                            0%
                                        </label>
                                    </div>


                                <?php  endif; ?>

                            <?php  endif; ?>


                        </div>


                    </div>


                <?php endforeach; ?>

            </div>
  

        <?php endforeach ?>

       

    </div>

    


    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>


    <!-- MDB -->
    <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.0/mdb.min.js"
    ></script>

    <script>

        const frmfecha = document.getElementById("frmfecha");
        const minutos = 5;
        let header = "";
        let titulo = "";


        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load",  () => {

            frmfecha.addEventListener('change',()=>{

                let valor = frmfecha.value;
                if(valor != "" && valor != "<?= $fecha; ?>"){
                    window.location = "reporte.view.php?fecha="+valor;
                    $(".loader").fadeIn("slow");
                }


            });

            // CALCULAMOS ALTO DE LAS EFICACIAS
            calc();

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");

            // RECARGAMOS
            setTimeout(function(){
				window.location.reload();
                $(".loader").fadeIn("slow");
	        },minutos*60*1000);

        });

        function calc(){

            header = $("#header-id").height()
            titulo = $("#titulo-id").height()

            let suma = parseFloat(header) + parseFloat(titulo);

            // $(".filaseficacias").css({
            //     height: "calc(100vh - "+ suma  +"px) / 4"
            // })



        }


    </script>

</body>
</html>