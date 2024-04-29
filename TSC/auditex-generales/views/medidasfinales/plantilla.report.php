<?php

    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';


    session_start();


    $data = $_SESSION["data_reportefinal"];
    $numpre = $_SESSION["numpre_reportefinal"];
    $datamedidas = $_SESSION["datamedidas_reportefinal"];

    $arraynumpre = [];
    for($i = 1; $i <= $numpre["NUMPRE"]; $i++){
        $arraynumpre[] = $i;
    }

    $columnas = array_keys($data[0]);

    // $infoestilo             = $_SESSION["infoestilo_desviacion"];
    // $tallasestilo           = $_SESSION["tallasestilo_desviacion"];
    // $medidasestilo          = $_SESSION["medidasestilo_desviacion"];
    // $desviacionesestilo     = $_SESSION["desviacionesestilo_desviacion"];
    // $dataestilo             = $_SESSION["dataestilo_desviacion"];

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

        th,td{
            padding: 0 !important;
        }
       
        .bg-medida-tolerancias{
            background: #e5ffc9;
        }

        .bg-critica{
            background: #ffff82 !important;
        }

        .bg-prendas{
            background: #e1e1e1;
        }

        .bg-thead{
            background:#99ff99 ;
        } 


        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            /* font-size: 12px !important; */
        }

        thead{
            font-size: 11px ;
        }

        tbody{
            font-size: 10px ;
        }

        /* table, th, td {
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
        } */

        .page_break { 
            page-break-before: always;
            break-after: always;
            page-break-inside: avoid;
        }

        @page {
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-top: 0;
            margin-bottom: 0;
        }

        /* .filafija .descripcion {
            width: 60px !important;
            overflow: auto !important;
            vertical-align: middle !important;
        }

        .filafija .columnas {
            width: 10px !important;
            overflow: auto !important;
            vertical-align: middle !important;
        }

        


        .image{
            width: 100%;
            height: 100%;
            float: left;
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
        } */

    </style>

</head>


<!-- GENERAL -->
<div >

    <!-- DATA GENERAL -->
    <div>

        <h3 class="text-center font-weight-bold">
            REPORTE DE MEDIDAS FINALES - <?= $_GET["area"] ?>
        </h3>

       <label class="font-weight-bold">ESTILO TSC:</label>  <?= $_GET["estilotsc"] ?>  /
       <label class="font-weight-bold">ESTILO CLI:</label>  <?= $_GET["estilocli"] ?> /
       <label class="font-weight-bold">CLIENTE:</label>  <?= $_GET["cliente"] ?> <br >
       <label class="font-weight-bold">PEDIDO / COLOR:</label>   <?= $_GET["pedido"] ?> <br>

    </div>


    <div>

        <table class="table table-sm table-bordered bg-white text-center table-reporte">

            <thead class="bg-thead">
                <tr>
                    <?php  foreach($columnas as $columna): ?>

                        <?php
                            $with = 100;
                            $newcolumn = str_replace("'","",$columna);

                            if($newcolumn == "COD"){
                                $with = 25;
                            }

                            if($newcolumn == "DESCRIPCIÓN"){
                                $with = 200;
                            }

                            if($newcolumn == "CRITICA"){
                                $with = 45;
                            }

                        ?>

                        <th class="border-table" style="max-width: <?= $with  ?>px;min-width: <?= $with  ?>px">
                            <?= $newcolumn ?>
                        </th>
                            
                        <!-- PRENDAS -->
                        <?php if($columna != "COD" && $columna != "DESCRIPCIÓN" && $columna != "CRITICA" && $columna != "TOL(+)" && $columna != "TOL(-)"): ?>

                            <?php  foreach($arraynumpre as $pren): ?>
                                <th  style="max-width: 30px;min-width: 30px" class="border-table" >
                                    <?= $pren ?>
                                </th>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    

                    <?php endforeach; ?>
                </tr>
            </thead>

            <tbody>
                <?php  foreach($data as $fila): ?>

                    <?php  $bg = $fila["CRITICA"] == "CRITICA" ? "bg-critica" : ""; ?>

                    <tr class="<?= $bg ?>"  height="40">

                        <?php  foreach($columnas as $columna): ?>

                            <?php
                                $newcolumn = str_replace("'","",$columna);

                                $fontsize = "10px";

                                if($newcolumn == "DESCRIPCIÓN"){
                                    $fontsize = "8.5px";
                                    // $with = 200;
                                }

                                if($newcolumn == "CRITICA"){
                                    $fontsize = "8.5px";
                                }

                            ?>

                            <td style="font-size:<?= $fontsize; ?>" >
                                <?= $fila[$columna]  ?>
                            </td>

                            <!-- PRENDAS -->
                            <?php if($columna != "COD" && $columna != "DESCRIPCIÓN" && $columna != "CRITICA" && $columna != "TOL(+)" && $columna != "TOL(-)"): ?>

                                <?php  foreach($arraynumpre as $pren): ?>

                                    <?php
                                        $newcolumn = str_replace("'","",$columna);
                                        $datafiltrada = array_filter($datamedidas,array( new MedidasFinalesReporteFilterValor($fila["COD"],$newcolumn,$pren),"getFiltroValor"));     
                                    ?>  

                                    <td  style="max-width: 30px;min-width:30px" class="border-table font-weight-bold  <?= $bg == "" ? "bg-prendas" : ""  ?> "  >


                                        <?php foreach($datafiltrada as $dt): ?>
                                            <?= $dt["VALOR"] == "0" ? "OK" : $dt["VALOR"] ?>
                                        <?php endforeach; ?> 

                                    </th>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </tr>
                

                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

