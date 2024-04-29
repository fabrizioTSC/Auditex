<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';


    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    // $objModelo = new CoreModelo();

    $_SESSION['navbar'] = "Auditex Telas - Reporte Partidas";
    $fechahoy               = date('Y-m-d');//new DateTime();
    $anioactual             = date("Y");
    $fechainicioanio        = "{$anioactual}-01-01";
    $fechasemanaanterior    = date("Y-m-d",strtotime($fechahoy."- 7 days"));


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $_SESSION['navbar'] ?> </title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

    <style>
        body{
            padding-top: 50px !important;
        }

        .radios{
            cursor: pointer !important;
        }

        .f-11{
            font-size: 11px !important;
        }

        .f-10{
            font-size: 10px !important;
        }

    </style>

    <!-- <link rel="stylesheet" href="../../css/encogimientocorte/molde.css"> -->

</head>

<body>
    <div class="loader"></div>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>

    <!--  -->
    <div class="container mt-3">

        <form class="row" action="" id="frmbusqueda">

            <div class="col-md-4">
                <label for="" class="text-white" >Fecha Inicio</label>
                <input id="txtfechainicio" required type="date" class="form-control form-control-sm" value="<?= $fechasemanaanterior ?>">
            </div>

            <div class="col-md-4">
                <label for="" class="text-white" >Fecha Fin</label>
                <input id="txtfechafin" required type="date" class="form-control form-control-sm" value="<?= $fechahoy ?>">
            </div>


            <div class="col-md-4">
                <label for="" class="text-white" >&nbsp;</label>
                <button class="btn btn-sm btn-block btn-secondary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>

        </form>

        <div class="card mt-2">
            <div class="card-body">

                <table class="table table-bordered table-hover table-sm text-center " id="tableReporte">
                    <thead>
                        <tr>
                            <th>Fecha Registro</th>
                            <th>Partida</th>
                            <th>Cod. Tela</th>
                            <th>Situción</th>
                            <th>Color</th>
                            <th>Proveedor</th>
                            <th>Ruta</th>
                            <th>Artículo</th>
                            <th>Composición</th>
                            <th>Rendimiento</th>
                            <th>Peso</th>
                            <th>Programa</th>
                            <th>X Factory</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyReporte">

                    </tbody>
                </table>

            </div>
        </div>


    </div>




    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>
    <!-- <script src="/tsc/libs/Chartjs/chartjs-plugin-labels.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script> -->


    <script>

        const frmbusqueda = document.getElementById("frmbusqueda");

        window.addEventListener('load',()=> {

            $(".loader").fadeOut("slow");
        });

        frmbusqueda.addEventListener('submit',async (e)=> {

            e.preventDefault();


            let fechainicio = $("#txtfechainicio").val();
            let fechafin    = $("#txtfechafin").val();

            
            let data = await get("auditex-tela","reportepartidas","get-data-reporte-partidas",{
                fechainicio,fechafin
            });

            let tr = "";

            for(let item of data){

                tr += `
                    <tr>
                        <td>${item.FECHACARGA}</td>
                        <td>${item.PARTIDA}</td>
                        <td>${item.CODTEL}</td>
                        <td>${item.SITUACION}</td>
                        <td>${item.COLOR}</td>
                        <td>${item.PROVEEDOR}</td>
                        <td>${item.RUTA}</td>
                        <td>${item.ARTICULO}</td>
                        <td>${item.COMPOSICION}</td>
                        <td>${item.RENDIMIENTO}</td>
                        <td>${item.PESO}</td>
                        <td>${item.PROGRAMA}</td>
                        <td>${item.FECEMB}</td>
                    </tr>
                `;

            }

            ArmarDataTable_New("Reporte",tr,false,true,true,true,false);
            // $("#");

            // console.log('data',data);

        });


    </script>

</body>

</html>