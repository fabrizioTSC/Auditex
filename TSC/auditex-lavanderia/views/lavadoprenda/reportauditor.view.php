<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';



    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo  = new CoreModelo();
    $objSistema = new SistemaModelo();

    $_SESSION['navbar'] = "Auditex Lavanderia Prenda - Reporte Auditor";

    $datareporte = [];
    $txtfechai  = null;
    $txtfechaf  = null;


    if(isset($_GET["operacion"])){

        $txtfechai = isset($_GET["txtfechai"]) ? $_GET["txtfechai"] : null;
        $txtfechaf = isset($_GET["txtfechaf"]) ? $_GET["txtfechaf"] : null;


        $datareporte = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETREPORTES_PRENDAS",[2,$txtfechai,$txtfechaf,null,null,null]);
        $_SESSION["data_reporte_auditor_lavanderia_prendas"] = $datareporte;

        

    }





?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Lavanderia Prenda - Reporte Auditor</title>
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


    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>


    <div class="container-fluid mt-3">

        <!-- FILTROS -->
        <!-- <div class="card mb-2"> -->

            <!-- <div class="card-body"> -->

                <form class="row mb-2" id="frmreporte" method="GET">

                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <label for="">Desde:</label>
                        <input type="date" name="txtfechai"  class="form-control form-control-sm" id="txtfechai" value="<?= $txtfechai; ?>">
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <label for="">Hasta:</label>
                        <input type="date" name="txtfechaf"  class="form-control form-control-sm" id="txtfechaf" value="<?= $txtfechaf; ?>">

                        <!-- OPERACION -->
                        <input type="hidden" name="operacion" value="true">

                    </div>
                    
                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-sm btn-block btn-sistema" type="submit" id="btnbuscar">Buscar</button>
                    </div>

                    <?php if(isset($_GET["operacion"])): ?>
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-sm btn-block btn-success" type="button" id="btnexportar">Exportar</button>
                        </div>
                    <?php endif; ?>

                </form>

            <!-- </div> -->

        <!-- </div> -->

        <!-- CABECERA -->
        <div class="table-responsive">

            <table class="table table-bordered table-sm  text-center m-0 table-fichas">
                <thead class="thead-sistema-new">
                    <tr class="thead-fichas">
                        <th class="w-bajo align-vertical" >USUARIO</th>
                        <th class="w-bajo-2 align-vertical">FECHA</th>
                        <th class="w-bajo-2 align-vertical">AUDITORIA</th>
                        <th class="w-bajo-2 align-vertical">CANT. APRO</th>
                        <th class="w-bajo align-vertical">CANT. RECH.</th>
                        <th class="w-bajo-2 align-vertical">CANT. PRENDAS/PARTE</th>
                        <th class="w-bajo align-vertical">CANT. PRENDAS MUESTRA</th>
                        <th class="w-bajo align-vertical">CANT. DEFECTOS</th>
                    </tr>
                </thead>
                <tbody class="bg-white">

                    <?php  foreach($datareporte as $fila): ?>

                        <tr >

                            <?php 
                                $fecha       = date("d/m/Y", strtotime($fila['FECHA']));
                            ?>

                            <td class="w-bajo" > <?= $fila["USUARIOCIERRE"]; ?> </td>
                            <td class="w-bajo-2"> <?= $fecha; ?> </td>
                            <td class="w-bajo-2"> <?= $fila["AUDITORIAS"]; ?> </td>
                            <td class="w-bajo-2"> <?= $fila["APROBADOS"]; ?> </td>
                            <td class="w-bajo"> <?= $fila["RECHAZADOS"]; ?> </td>
                            <td class="w-bajo-2"> <?= number_format($fila["PRENDAS"]); ?> </td>
                            <td class="w-bajo"> <?= number_format($fila["AUDITADAS"]); ?> </td>
                            <td class="w-bajo"> <?= $fila["CANTDEFECTOS"]; ?>  </td>


                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>        


    </div>


    <script>
        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {


            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");

            $("#btnexportar").click(function(){

                window.open("/tsc/controllers/auditex-lavanderia/lavadoprenda.controller.php?operacion=get-report-auditor","_blank");

            });
        });
    </script>

</body>

</html>