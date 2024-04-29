<?php
    session_start();
    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    $objModelo = new CoreModelo();

    // IMAGEN
    // $imagenindicador = $_POST["imagen"];

    // DATA
    // $DATA = json_decode($_POST["data"]);
    // $pedido     = $_GET["pedido"];
    // $colores    = $_GET["colores"];


    $FICHAS = $_SESSION["data_reporte_humedad_fechas"];
    $contador = 0;
?>


<head>

    <style>

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
            background: #f0f0f0;
            color:#000;
        }

        table{
            width: 30% !important;
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

        .font-family{
            font-family: Arial, Helvetica, sans-serif;
        }

        .w-30{
            width: 30% !important;
            float: left;
        }

        .w-70{
            width: 60% !important;
            float: left;
        }

        .border-bottom{
            border-bottom: 2px solid black;
        }

    </style>

</head>


<div class="font-family">

    <?php foreach($FICHAS as $fila): ?>

        <!-- CONTADOR -->
        <?php $contador++; ?>

        <div >

            <!-- <div> -->
                <!-- <img src="../../../public/img/tsclogosolo.png" alt=""> -->
                <!-- <img src="tsclogosolo.png" alt=""> -->
            <!-- </div> -->

            <div>
                <h3 class="text-center font-weight-bold">
                    CONTROL DE HUMEDAD
                </h3>
            </div>

            <div class="w-30">
                <label for="">FICHA</label>
            </div>

            <div class="w-70 border-bottom">
                <label for=""> <?= $fila["CODFIC"]; ?> </label>
            </div>
            <br>
            <br>
            <div class="w-30">
                <label for="">CLIENTE</label>
            </div>
            <div class="w-70 border-bottom">
                <label for=""> <?= $fila["DESCLI"]; ?> </label>
            </div>
            <br>
            <br>
            <div class="w-30">
                <label for="">PEDIDO / COLOR</label>
            </div>
            <div class="w-70 border-bottom">
                <label for=""> <?= $fila["PEDIDO"]; ?> / <?= $fila["DSCCOL"]; ?> </label>
            </div>
            <br>
            <br>
            <div class="w-30">
                <label for="">EST TSC / ESTILO CLIENTE</label>
            </div>
            <div class="w-70 border-bottom">
                <label for=""> <?= $fila["ESTTSC"]; ?> / <?= $fila["ESTCLI"]; ?> </label>
            </div>
            <br>
            <br>
            <div class="w-30">
                <label for="">PRENDA</label>
            </div>
            <div class="w-70 border-bottom">
                <label for=""> <?= $fila["DESPRE"]; ?> </label>
            </div>
            <br>
            <br>            
            <br>
            <br>

            <div class="w-30">
                <label for="">TALLER CORTE</label>
            </div>
            <div class="w-70 border-bottom">
                <label for=""> <?= $fila["TALLERCORTE"]; ?> </label>
            </div>
            <br>
            <br>
            <div class="w-30">
                <label for="">TALLER COSTURA</label>
            </div>
            <div class="w-70 border-bottom">
                <label for=""> <?= $fila["TALLERCOSTURA"]; ?> </label>
            </div>

            <br>
            <hr>

            <div>
                <label for="" style="font-weight: bold;" >CONTROL DE HUMEDAD</label>
            </div>
            <br>

            <div style="width: 20% !important;float:left "> 
                <label for="">Temperatura Amb:</label>
            </div>
            <div style="width: 20% !important;float:left " class="border-bottom text-center">
                <label for=""> <?= $fila["TEMAMB"] == null ? '-' : $fila["TEMAMB"]; ?> </label>
            </div>

            <div style="width: 20% !important;float:left ">
                <label for="">Humedad Amb:</label>
            </div>
            <div style="width: 20% !important;float:left " class="border-bottom text-center">
                <label for=""> <?= $fila["HUMAMB"] == null ? '-' : $fila["HUMAMB"];; ?> </label>
            </div>

            <br>
            <br>
            <div style="width: 20% !important;float:left ">
                <label for="">Humedad Max:</label>
            </div>
            <div style="width: 20% !important;float:left " class="border-bottom text-center">
                <label for=""> <?= $fila["HUMMAX"]; ?> </label>
            </div>
            <br>
            <br>

            <!-- DETALLE -->
            <?php

                $DETALLE = $objModelo->getAll("AUDITEX.SP_ACH_SELECT_DETHUM",[$fila["CODFIC"],$fila["CODTAD"],$fila["NUMVEZ"],$fila["PARTE"]]);

            ?>

            <table class="text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>HUMEDAD</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($DETALLE as $det): ?>
                    <tr>
                        <td><?= $det["IDREG"]; ?> </td>
                        <td><?= $det["HUMEDAD"]; ?> </td>
                    </tr>


                    <?php endforeach; ?>
                </tbody>
            </table>

            <br>

            <div>
                <label for="">Resultado:</label>
                <label for="" style="border:2px solid black"> <?= $fila["RESULTADO"] == "A" ? "Aprobado" : "Rechazado"; ?> </label>

                <label for="">Promedio:</label>
                <label for="" style="border:2px solid black"> <?= $fila["HUMPRO"]; ?> </label>

            </div>

        </div>

        <?php if($contador < count($FICHAS)): ?>
            <div class="page_break"></div>
        <?php endif; ?>
        


    <?php endforeach; ?>





</div>

