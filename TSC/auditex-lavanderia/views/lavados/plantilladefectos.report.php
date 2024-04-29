<?php
    session_start();

    // IMAGEN
    $imagenindicador = $_POST["imagen"];

    // DATA
    $DATA = json_decode($_POST["data"]);

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
            INDICADORES DE DEFECTOS DE AUDITORÍA LAVANDERIA <?=  $DATA->{"tipolavado"}  ?>
        </h3>
        <h4 class="text-center font-weight-bold">
            <?=  $DATA->{"titulofiltro"}  ?>
        </h4>
        <h4 class="text-center font-weight-bold">
            DEFECTO: <?=  $DATA->{"defectolbl"}  ?>
        </h4>

    </div>

    <div style="height:300px">
        <img class="image" src="<?= $imagenindicador; ?>" alt="">

    </div>


    <div>
        <table class="table">

            <thead>
                <tr class="filafija">
                    <td class="descripcion">DETALLE GENERAL</td>

                    <?php foreach($DATA->{"titulo"} as $col): ?>

                        <th class="columnas"><?= str_replace("'","",$col) ; ?></th>

                    <?php endforeach; ?>

                </tr>
            </thead>
            <tbody>

                <tr>
                    <td class="descripcion"># DEF</td>
                    <?php foreach($DATA->{"defectos"} as $col): ?>
                        <td class="text-center"><?= $col ; ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <td class="descripcion"># PRE. MUE.</td>
                    <?php foreach($DATA->{"muestras"} as $col): ?>
                        <td class="text-center"><?= $col ; ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <td class="descripcion"># DEF. TOT</td>
                    <?php foreach($DATA->{"defectostot"} as $col): ?>
                        <td class="text-center"><?= $col ; ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <td class="descripcion">% DEF</td>
                    <?php foreach($DATA->{"defectosporcentaje"} as $col): ?>
                        <td class="text-center"><?= $col ; ?>%</td>
                    <?php endforeach; ?>
                </tr>

            </tbody>


        </table>
    </div>



</div>

