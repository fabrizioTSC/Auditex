<?php

    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';


    session_start();


    $infoestilo             = $_SESSION["infoestilo_desviacion"];
    $tallasestilo           = $_SESSION["tallasestilo_desviacion"];
    $medidasestilo          = $_SESSION["medidasestilo_desviacion"];
    $desviacionesestilo     = $_SESSION["desviacionesestilo_desviacion"];
    $dataestilo             = $_SESSION["dataestilo_desviacion"];

    // // IMAGEN
    // $imagenindicador = $_POST["imagen"];

    // // DATA
    // $DATA = json_decode($_POST["data"]);

?>


<head>

    <style>

        /* body{
            font-family: Arial ;
        } */

        .text-center{
            text-align: center !important;
        }

        .font-weight-bold{
            font-weight: bold !important;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px !important;
        }

        table thead {
            background: #204d86;
            color:#fff;
        }

        table{
            width: 100% !important;
            table-layout: fixed;
        }

        .bg-1{
            background: #cccccc;
        }

        .bg-2{
            background: #e3e1e1;
        }

        .bg-3{
            background: #204d86;
            color:#fff;
        }

        .page_break { 
                /* page-break-before: always;  */
            page-break-before: always;
            break-after: always;
            page-break-inside: avoid;
        }

        .filafija .descripcion {
            width: 60px !important;
            overflow: auto !important;
            vertical-align: middle !important;
        }

        .filafija .columnas {
            width: 10px !important;
            overflow: auto !important;
            vertical-align: middle !important;
        }

        
        /* .text-center{
            text-align: center !important;
        } */


        .image{
            width: 100%;
            height: 100%;
            float: left;
            /* height: 300px !important; */
        }

        .float-left{
            float: left !important;
        }

        .text-white{
            color: #fff;
        }

        .bg-sistema{
            background-color: #922b21 !important;
        }

        .bg-medida-tolerancias{
            background: #e5ffc9;
        }

    </style>

</head>


<!-- GENERAL -->
<div >

    <!-- DATA GENERAL -->
    <div>

        <h3 class="text-center font-weight-bold">
            REPORTE DE DESVIACIÓN DE MEDIDAS - <?= $_GET["area"] ?>
        </h3>

       <label class="font-weight-bold">ESTILO TSC:</label>  <?= $_GET["estilotsc"] ?> <br>
       <label class="font-weight-bold">FICHAS:</label>   <?= $_GET["fichas"] ?> <br>
       <label class="font-weight-bold">ESTILO CLIENTE:</label>   <?= $_GET["estilocliente"] ?> <br>
       <label class="font-weight-bold">CLIENTE:</label>   <?= $_GET["cliente"] ?> <br>

    </div>


    <!--  -->
    <?php foreach($medidasestilo as $medida): ?>


        <div class="">
            <h5 class="font-weight-bold">
                COD: <?= $medida["CODIGO_MEDIDA"] ?>
                -
                <?= $medida["DESCRIPCION_MEDIDA"] ?>
            </h5>
        </div>

        <div class="text-center">
            <label class="" id="txtfuera_<?= $medida["CODIGO_MEDIDA"] ?>"> <?= $medida["TOLFUERA"] ?>% fuera de tolerancia</label>   <br>
            <label class="" id="txtdentro_<?= $medida["CODIGO_MEDIDA"] ?>"> <?= $medida["TOLDENTRO"] ?>% dentro de tolerancia</label>
        </div>

        <div class="">

            <table class="text-center" >
                <thead class="bg-sistema text-white">
                    <?php $cont = 0;$totaltotal = 0; $totaldentrotolerancia = 0; $totalfueratolerancia = 0;$dentrotolerancia = false; ?>
                    <tr>
                        <th class="border-table">DESV.</th>
                        <?php foreach($tallasestilo as $talla): ?>
                            
                            <?php $tallasestilo[$cont]["TOTALTALLA"] = 0; ?>
                            <th class="border-table"> <?= $talla["TALLA"] ?> </th>

                            <?php $cont++; ?>
                        <?php endforeach; ?>
                        <th class="border-table">TOTAL</th>
                        <th class="border-table">%</th>
                    </tr>

                </thead>
                <tbody>
                            
                    <?php foreach($desviacionesestilo as $desvi): ?>
                        <tr>
                            <td class="border-table"> <?= $desvi["MEDIDA"] ?> </td>                                            
                            <?php $totaldesvi = 0; $cont = 0; ?>
                            <?php foreach($tallasestilo as $talla): ?>

                                <?php 

                                    $d_filt = array_filter($dataestilo,array( 
                                        new MedidasReporteFilterValor($medida["CODIGO_MEDIDA"],$talla["IDTALLA"],$desvi["MEDIDA"]),"getFiltroValor")
                                    );     
                                    $totaldesvi += count($d_filt);

                                    $tallasestilo[$cont]["TOTALTALLA"] += count($d_filt);
                                    $cont++;
                                    $clasebg = "";

                                    // TOLERANCIAS
                                    if(
                                        (
                                            $desvi["DC_MEDDEC"] != null &&  $desvi["DC_HASTA"] != null
                                        )    
                                            &&
                                        (
                                            (float)$medida["TOLERANCIAMAS"] >= (float)$desvi["DC_MEDDEC"]     
                                            && 
                                            (float)$desvi["DC_MEDDEC"] >= (float)$medida["TOLERANCIAMENOS"] 
                                        )
                                            || 
                                        (
                                            $desvi["MEDIDA"] == 0
                                        )
                                    ){
                                        $clasebg =    "bg-medida-tolerancias";
                                        $dentrotolerancia = true;
                                    }else{
                                        $dentrotolerancia = false;
                                    }


                                ?>

                                <!--  -->

                            <td class="border-table <?= $clasebg; ?> "> <?=  count($d_filt)  ?> </td>

                            <?php endforeach; ?>
                            <?php $totaltotal += $totaldesvi;  ?>

                            <!-- TOTALES -->
                            <td class="border-table" style="background: #ccc;"> <?= $totaldesvi ?> </td>
                            <td class="border-table" style="background: #ccc;">
                                <?php 
                                    $porcentaje = round( ( (float)$medida["TOTALMED"] > 0 ?  $totaldesvi / (float)$medida["TOTALMED"] : 0) * 100,2);

                                    if($dentrotolerancia){
                                        $totaldentrotolerancia  += $porcentaje;
                                    }else{
                                        $totalfueratolerancia   += $porcentaje;
                                    }

                                ?>
                                
                                <?=
                                    $porcentaje;
                                ?>%
                            </td>



                        </tr>
                    <?php endforeach; ?>

                </tbody>
                <tfoot style="background:#333" class="text-white">
                    <tr>
                        <th class="border-table">TOTAL</th>
                        <?php foreach($tallasestilo as $talla): ?>
                            <th class="border-table"> <?= $talla["TOTALTALLA"] ?> </th>
                        <?php endforeach; ?>
                        <th class="border-table"> <?= $totaltotal ; ?> </th>
                        <th class="border-table"> 100% </th>
                    </tr>
                </tfoot>

            </table>

            <div class="page_break"></div>

        </div>

        


    <?php endforeach; ?>


</div>

