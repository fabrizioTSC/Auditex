<?php
    session_start();

    // IMAGEN
    $imagenindicador = $_POST["imagen"];

    // DATA
    $DATA = json_decode($_POST["data"]);

    // PARETOS
    $pareto1 = json_decode($_POST["pareto1"]);
    $pareto2 = json_decode($_POST["pareto2"]);

    $pareto3 = json_decode($_POST["pareto3"]);
    $pareto4 = json_decode($_POST["pareto4"]);
    $pareto5 = json_decode($_POST["pareto5"]);
    $pareto6 = json_decode($_POST["pareto6"]);



?>


<head>

    <title>Indicador de Resultados</title>

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

    </style>

</head>


<!-- GENERAL -->
<div >

    <div class="text-center">

        <h4 class="text-center font-weight-bold">
            INDICADOR GENERAL DE RESULTADOS DE AUDITORÍA LAVANDERIA EN <?=  $DATA->{"tipolavado"}  ?> 
        </h4>
        
        <label class="text-center font-weight-bold">
            <?=  $DATA->{"titulofiltro"}  ?>
        </label>
        <br>
        <label class="text-center font-weight-bold">
            Auditorias Aprobadas y Rechazadas
        </label>

    </div>

    <div style="height:300px">
        <img class="image" src="<?= $imagenindicador; ?>" alt="">
    </div>

    <br>
    <br>

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
                    <th class="descripcion" style="text-align: left;"># AUD. APROB. 1RA</th>
                    <?php foreach($DATA->{"aprobadas_cant"} as $col): ?>
                        <td class="text-center"><?= $col ; ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th class="descripcion" style="text-align: left;"># AUD. RECH.</th>
                    <?php foreach($DATA->{"rechazadas_cant"} as $col): ?>
                        <td class="text-center"><?= $col ; ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th class="descripcion" style="text-align: left;"># AUDITORIAS</th>
                    <?php foreach($DATA->{"total_cant"} as $col): ?>
                        <td class="text-center"><?= $col ; ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th class="descripcion" style="text-align: left;">% APRO. 1RA</th>
                    <?php foreach($DATA->{"aprobadas_por_cant"} as $col): ?>
                        <td class="text-center" style="background:<?= $col->{'backcolor'}?>;color: <?= $col->{'fontcolor'}?>;" ><?= $col->{"valor"} ; ?>%</td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th class="descripcion" style="text-align: left;">% RECH.</th>
                    <?php foreach($DATA->{"rechazadas_por_cant"} as $col): ?>
                        <td class="text-center" ><?= $col ; ?>%</td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th class="descripcion" style="text-align: left;">PREND. APROB. 1RA</th>
                    <?php foreach($DATA->{"aprobadas_pren"} as $col): ?>
                        <td class="text-center"><?= $col ; ?></td>
                    <?php endforeach; ?>
                </tr>


                <tr>
                    <th class="descripcion" style="text-align: left;">PREND. RECH.</th>
                    <?php foreach($DATA->{"rechazadas_pren"} as $col): ?>
                        <td class="text-center"><?= $col ; ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th class="descripcion" style="text-align: left;">TOTAL PRENDAS</th>
                    <?php foreach($DATA->{"total_pren"} as $col): ?>
                        <td class="text-center"><?= $col ; ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th class="descripcion" style="text-align: left;">% APRO. 1RA</th>
                    <?php foreach($DATA->{"aprobadas_por_pren"} as $col): ?>
                        <td class="text-center"><?= $col ; ?>%</td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th class="descripcion" style="text-align: left;">% RECH.</th>
                    <?php foreach($DATA->{"rechazadas_por_pren"} as $col): ?>
                        <td class="text-center"><?= $col ; ?>%</td>
                    <?php endforeach; ?>
                </tr>

            </tbody>


        </table>

    </div>  


    <div class="page_break"></div>




    <!-- PARETO 1 -->

    <div class="text-center">
        <h4>DIAGRAMA DE PARETO GENERAL - NIVEL N°1</h4>
        <label><?= $pareto1->{"lbl"}; ?></label>
    </div>

    <div style="height:300px">
        <img class="image" src="<?= $pareto1->{"img"}; ?>" alt="">
    </div>

    <br>
    <br>

    <!-- TABLA PARETO 1 -->
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
                
                <?php foreach($pareto1->{"data"} as $col): ?>
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

    <div class="page_break"></div>

    <!-- PARETO 2 -->
    <div class="text-center">
        <h4>DIAGRAMA DE PARETO GENERAL - NIVEL N°1</h4>
        <label><?= $pareto2->{"lbl"}; ?></label>
    </div>
    <div style="height:300px">
        <img class="image" src="<?= $pareto2->{"img"}; ?>" alt="">
    </div>

    <br>
    <br>

    <!-- TABLA PARETO 2 -->
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

                <?php foreach($pareto2->{"data"} as $col): ?>
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

    <div class="page_break"></div>

    <!-- PARETO 3 -->

    <div class="text-center">
        <h4>DIAGRAMA DE PARETO GENERAL - NIVEL N°2</h4>
        <label><?= $pareto1->{"lbl"}; ?></label>
        <br>
        <label><?= $pareto3->{"lbl"}; ?></label>
    </div>

    <div style="height:300px">
        <img class="image" src="<?= $pareto3->{"img"}; ?>" alt="">
    </div>

    <br>
    <br>
    <!-- TABLA PARETO 3 -->
    <div>

        <table class="table">

            <thead>
                <tr class="filafija">
                    <th class="descripcion">MOTIVOS</th>
                    <th class="descripcion">FRECUENCIA</th>
                    <th class="descripcion">%</th>
                    <th class="descripcion">% ACUMULADO</th>
                    <th class="descripcion">% DEL GENERAL</th>

                </tr>
            </thead>

            <tbody>
                
                <?php foreach($pareto3->{"data"} as $col): ?>
                    <tr>
                        <td><?= $col->{"descripcion"};  ?></td>
                        <td class="text-center"><?= $col->{"valor"};  ?></td>
                        <td class="text-center"><?= $col->{"porcentaje"};  ?>%</td>
                        <td class="text-center"><?= $col->{"acumulado"};  ?>%</td>
                        <td class="text-center"><?= $col->{"delgeneral"};  ?>%</td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
                        

    </div>

    <div class="page_break"></div>


    <!-- PARETO 4 -->
    <div class="text-center">
        <h4>DIAGRAMA DE PARETO GENERAL - NIVEL N°2</h4>
        <label><?= $pareto1->{"lbl"}; ?></label>
        <br>
        <label><?= $pareto4->{"lbl"}; ?></label>
    </div>
    <div style="height:300px">
        <img class="image" src="<?= $pareto4->{"img"}; ?>" alt="">
    </div>

    <br>
    <br>

    <!-- TABLA PARETO 4 -->
    <div>

        <table class="table">

            <thead>
                <tr class="filafija">
                    <th class="descripcion">MOTIVOS</th>
                    <th class="descripcion">FRECUENCIA</th>
                    <th class="descripcion">%</th>
                    <th class="descripcion">% ACUMULADO</th>
                    <th class="descripcion">% DEL GENERAL</th>

                </tr>
            </thead>

            <tbody>
                
                <?php foreach($pareto4->{"data"} as $col): ?>
                    <tr>
                        <td><?= $col->{"descripcion"};  ?></td>
                        <td class="text-center"><?= $col->{"valor"};  ?></td>
                        <td class="text-center"><?= $col->{"porcentaje"};  ?>%</td>
                        <td class="text-center"><?= $col->{"acumulado"};  ?>%</td>
                        <td class="text-center"><?= $col->{"delgeneral"};  ?>%</td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
                        

    </div>

    <div class="page_break"></div>


    <!-- PARETO 5 -->

    <div class="text-center">
        <h4>DIAGRAMA DE PARETO GENERAL - NIVEL N°2</h4>
        <label><?= $pareto2->{"lbl"}; ?></label>
        <br>
        <label><?= $pareto5->{"lbl"}; ?></label>
    </div>

    <div style="height:300px">
        <img class="image" src="<?= $pareto5->{"img"}; ?>" alt="">
    </div>

    <br>
    <br>

    <!-- TABLA PARETO 5 -->
    <div>

        <table class="table">

            <thead>
                <tr class="filafija">
                    <th class="descripcion">MOTIVOS</th>
                    <th class="descripcion">FRECUENCIA</th>
                    <th class="descripcion">%</th>
                    <th class="descripcion">% ACUMULADO</th>
                    <th class="descripcion">% DEL GENERAL</th>

                </tr>
            </thead>

            <tbody>
                
                <?php foreach($pareto5->{"data"} as $col): ?>
                    <tr>
                        <td><?= $col->{"descripcion"};  ?></td>
                        <td class="text-center"><?= $col->{"valor"};  ?></td>
                        <td class="text-center"><?= $col->{"porcentaje"};  ?>%</td>
                        <td class="text-center"><?= $col->{"acumulado"};  ?>%</td>
                        <td class="text-center"><?= $col->{"delgeneral"};  ?>%</td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
                        

    </div>

    <div class="page_break"></div>


    <!-- PARETO 6 -->
    <div class="text-center">
        <h4>DIAGRAMA DE PARETO GENERAL - NIVEL N°2</h4>
        <label><?= $pareto2->{"lbl"}; ?></label>
        <br>
        <label><?= $pareto6->{"lbl"}; ?></label>
    </div>

    <div style="height:300px">
        <img class="image" src="<?= $pareto6->{"img"}; ?>" alt="">
    </div>

    <br>
    <br>

    <!-- TABLA PARETO 6 -->
    <div>

        <table class="table">

            <thead>
                <tr class="filafija">
                    <th class="descripcion">MOTIVOS</th>
                    <th class="descripcion">FRECUENCIA</th>
                    <th class="descripcion">%</th>
                    <th class="descripcion">% ACUMULADO</th>
                    <th class="descripcion">% DEL GENERAL</th>

                </tr>
            </thead>

            <tbody>
                
                <?php foreach($pareto6->{"data"} as $col): ?>
                    <tr>
                        <td><?= $col->{"descripcion"};  ?></td>
                        <td class="text-center"><?= $col->{"valor"};  ?></td>
                        <td class="text-center"><?= $col->{"porcentaje"};  ?>%</td>
                        <td class="text-center"><?= $col->{"acumulado"};  ?>%</td>
                        <td class="text-center"><?= $col->{"delgeneral"};  ?>%</td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
                        

    </div>


</div>

