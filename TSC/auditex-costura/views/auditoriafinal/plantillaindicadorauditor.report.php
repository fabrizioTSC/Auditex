<?php
    session_start();

    // IMAGEN
    $imagenindicador = $_POST["imagen"];
    $imagenpareto = $_POST["imagenpareto"];


    // DATA
    $DATAGENERAL        = json_decode($_POST["datageneral"]);
    $DATAPARETO         = json_decode($_POST["datapareto"]);
    $TITULOINDICADOR    = $_POST["tituloindicador"];



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

    <div>

        <h3 class="text-center font-weight-bold">
            INDICADORES POR AUDITOR - COSTURA FINAL
        </h3>
        <h5 class="text-center font-weight-bold">
            <?= $TITULOINDICADOR; ?>
        </h5>

    </div>


    <div style="height:300px">
        <img class="image" src="<?= $imagenindicador; ?>" alt="">
    </div>

    <div>

        <table class="table">

            <thead>
                <tr class="filafija">

                    <th class="columnas">AUDITOR</th>
                    <th class="columnas">FICHAS AUDITADAS</th>
                    <th class="columnas">FICHAS APROBADAS</th>
                    <th class="columnas">FICHAS RECHAZADAS</th>
                    <th class="columnas">TOTAL PRENDAS</th>
                    <th class="columnas">PRENDAS APROBADAS</th>
                    <th class="columnas">PRENDAS RECHAZADAS</th>

                </tr>
            </thead>
            <tbody>

                    <?php foreach($DATAGENERAL as $col): ?>
                        <tr>
                            <td class="text-center"><?= $col->{"CODUSU"};  ?></td>
                            <td class="text-center"><?= $col->{"FICHASAUD"};  ?></td>
                            <td class="text-center"><?= $col->{"FICHASAPRO"};  ?></td>
                            <td class="text-center"><?= $col->{"FICHASAREC"};  ?></td>
                            <td class="text-center"><?= $col->{"PRENDASTOT"};  ?></td>
                            <td class="text-center"><?= $col->{"PRENDASAPRO"};  ?></td>
                            <td class="text-center"><?= $col->{"PRENDASAREC"};  ?></td>

                        </tr>
                    <?php endforeach; ?>

            </tbody>


        </table>

    </div>

    <div class="page_break"></div>

    <div>

        <h3 class="text-center font-weight-bold">
            DIAGRAMA DE PARETO GENERAL - DEFECTOS
        </h3>

    </div>

    <div style="height:300px">
        <img class="image" src="<?= $imagenpareto; ?>" alt="">
    </div>

    <div>

        <table class="table">

            <thead>
                <tr class="filafija">
                    <th class="descripcion">MOTIVOS</th>
                    <th class="descripcion">FRECUENCIA</th>
                    <th class="descripcion">%</th>
                    <th class="descripcion">% ACUMULADO</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach($DATAPARETO as $col): ?>
                    <tr>
                        <td><?= $col->{"descripcion"};  ?></td>
                        <td class="text-center"><?= $col->{"valor"};  ?></td>
                        <td class="text-center"><?= $col->{"porcentaje"};  ?>%</td>
                        <td class="text-center"><?= $col->{"acumulado"};  ?>%</td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

    </div>

</div>

