<?php

use PhpOffice\PhpSpreadsheet\Shared\Date;

    session_start();

    // IMAGEN

    $canvasancho                = $_POST["canvasancho"];
    $canvasanchoafter           = $_POST["canvasanchoafter"];
    $canvasdensidad             = $_POST["canvasdensidad"];
    $canvasdensidadafter        = $_POST["canvasdensidadafter"];
    $canvasanchoterceralavada   = $_POST["canvasanchoterceralavada"];
    $canvaslargoterceralavada   = $_POST["canvaslargoterceralavada"];
    $canvasreviradotercera      = $_POST["canvasreviradotercera"];
    $canvasinclinacionbefore    = $_POST["canvasinclinacionbefore"];
    $canvasinclinacionafter     = $_POST["canvasinclinacionafter"];
    $filtroslbl                 = $_POST["filtroslbl"];



    // DATA
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

        .text-left{
            text-align: left !important;
        }

        .text-right{
            text-align: right !important;
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

    </style>

</head>


<!-- GENERAL -->
<div >

    <div class="text-right" style="font-size:10px">
        <label >
            <?= $_SESSION["user"]; ?> - <?=  date("d/m/Y H:i:s") ?>
        </label>
    </div>

    <div>

        <h3 class="text-center font-weight-bold">
            INDICADOR DE ESTABILIDAD DIMENSIONAL
        </h3>

        <h4 class="text-center font-weight-bold">
            <?= $filtroslbl; ?>
        </h4>

    </div>



    <h5>ANCHO BEFORE</h5>
    <div style="height:300px">
        <img class="image" src="<?= $canvasancho; ?>" alt="">
    </div>


    <h5>ANCHO AFTER</h5>
    <div style="height:300px">
        <img class="image" src="<?= $canvasanchoafter; ?>" alt="">
    </div>


    <!-- BREAK -->
    <div class="page_break"></div>


    <h5>DENSIDAD BEFORE</h5>
    <div style="height:300px">
        <img class="image" src="<?= $canvasdensidad; ?>" alt="">
    </div>

    <h5>DENSIDAD AFTER</h5>
    <div style="height:300px">
        <img class="image" src="<?= $canvasdensidadafter; ?>" alt="">
    </div>

    <!-- BREAK -->
    <div class="page_break"></div>


    <h5>%ENC ANCHO 3RA LAV</h5>
    <div style="height:300px">
        <img class="image" src="<?= $canvasanchoterceralavada; ?>" alt="">
    </div>

    <h5>%ENC LARGO 3RA LAV</h5>
    <div style="height:300px">
        <img class="image" src="<?= $canvaslargoterceralavada; ?>" alt="">
    </div>

    <!-- BREAK -->
    <div class="page_break"></div>

    <h5>% REVIRADO 3RA LAV</h5>
    <div style="height:300px">
        <img class="image" src="<?= $canvasreviradotercera; ?>" alt="">
    </div>

    <h5>INCLINACIÓN BEFORE</h5>
    <div style="height:300px">
        <img class="image" src="<?= $canvasinclinacionbefore; ?>" alt="">
    </div>

    <!-- BREAK -->
    <div class="page_break"></div>

    <h5>INCLINACIÓN AFTER</h5>
    <div style="height:300px">
        <img class="image" src="<?= $canvasinclinacionafter; ?>" alt="">
    </div>


</div>

