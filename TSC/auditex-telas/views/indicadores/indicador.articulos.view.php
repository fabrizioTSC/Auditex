<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';


    //session_start();
    //if (!isset($_SESSION['user'])) {
    //    header('Location: index.php');
    //}

    // $objModelo = new CoreModelo();

    $_SESSION['navbar'] = "Auditex Telas - I. Articulos";
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
                <label for="" class="text-white" >Proveedor</label>
                <select name="" id="cboproveedor" class="custom-select custom-select-sm select2" style="width: 100%;" ></select>
            </div>

            <div class="col-md-4">
                <label for="" class="text-white" >Cliente</label>
                <select name="" id="cbocliente" class="custom-select custom-select-sm select2" style="width: 100%;" ></select>
            </div>

            <div class="col-md-4">
                <label for="" class="text-white" >Programa</label>
                <select name="" id="cboprograma" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
            </div>

            <div class="col-md-4">
                <label for="" class="text-white" >Telas</label>
                <select name="" id="cbotelas" class="custom-select custom-select-sm select2" style="width: 100%;" ></select>
            </div>

            <div class="col-md-4">
                <label for="" class="text-white" >Color</label>
                <select name="" id="cbocolor" class="custom-select custom-select-sm select2" style="width: 100%;" ></select>
            </div>

            <div class="col-md-4">
                <label for="" class="text-white" >F. Inicio</label>
                <input id="txtfechainicio" required type="date" class="form-control form-control-sm" value="<?= $fechainicioanio; ?>">
            </div>

            <div class="col-md-4">
                <label for="" class="text-white" >F. Fin</label>
                <input id="txtfechafin" required type="date" class="form-control form-control-sm" value="<?= $fechahoy; ?>">
            </div>

            <div class="col-md-2">
                <label for="" class="text-white" >&nbsp;</label>
                <button class="btn btn-sm btn-block btn-secondary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>

        </form>

        <div class="row mt-2">
            <!--<div class="row justify-content-center mt-2">-->
                <div class="col-md-4 mb-2">

                    <div class="card">                      
                        <div class="card-body">
                        <div class="card-subtitle mb-2 text-muted">Indicador Tono</div>
                            <div id="pie-chartcanvas-container">
                                <canvas id="pie-chartcanvas"></canvas>
                            </div>
                        </div>
                    </div>

               </div>
            <!-- </div>-->
            <!--<div class="row justify-content-center mt-2">-->
                <div class="col-md-4 mb-2">

                    <div class="card">
                        <div class="card-body">
                        <div class="card-subtitle mb-2 text-muted">Indicador Apariencia</div>
                            <div id="pie-chartcanvas-container-1">
                                <canvas id="pie-chartcanvas-1"></canvas>
                            </div>
                        </div>
                    </div>

               </div>
            <!-- </div>-->
           
            <div class="col-md-4 mb-2">

                <div class="card">
                    <div class="card-body">
                    <div class="card-subtitle mb-2 text-muted">Indicador Defecto</div>
                        <div id="pie-chartcanvas-container-2">
                            <canvas id="pie-chartcanvas-2"></canvas>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 mb-2">

                <div class="card">
                    <div class="card-body">
                    <div class="card-subtitle mb-2 text-muted">Indicador Estabilidad Dimensional</div>
                        <div id="pie-chartcanvas-container-3">
                            <canvas id="pie-chartcanvas-3"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        

    </div>

    <!-- MODAL INDICADOR -->
    <div class="modal fade" id="modalResumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="lbltitulomodal">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    <label for="" class="font-weight-bold" >Áreas:</label>
                    <div id="chart-1-detalle-container" style="height:200px">
                        <canvas id="chart-1-detalle-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-1-detalle-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Áreas</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-1-detalle-tbody">
                        </tbody>
                    </table>

                    <hr>

                </div>

                <div class="col-12">
                    <label for="" class="font-weight-bold">Motivos:</label>
                    <div id="chart-2-detalle-container" style="height:200px">
                        <canvas id="chart-2-detalle-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-2-detalle-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Motivos</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-2-detalle-tbody">
                        </tbody>
                    </table>

                    <hr>
                </div>

                <div class="col-12">
                    <label for="" class="font-weight-bold" >Detalle De Articulos:</label>
                    <div id="chart-3-detalle-container" style="height:200px">
                        <canvas id="chart-3-detalle-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-3-detalle-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Articulos</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-3-detalle-tbody">
                        </tbody>
                    </table>

                    <hr>
                </div>

                <div class="col-12">

                    <label for="" class="font-weight-bold" >Detalle Motivos:</label>
                    <div class="table-responsive" style="max-height: 300px;overflow:auto">

                        <table class="table table-bordered table-sm">
                            <thead class="thead-light f-11 sticky-top">
                                <tr>
                                    <th class="border-table">#</th>
                                    <th class="border-table">Partida</th>
                                    <th class="border-table">Proveedor</th>
                                    <th class="border-table">Cliente</th>
                                    <th class="border-table">Programa</th>
                                    <th class="border-table">Cod. Tela</th>
                                    <th class="border-table">Dsc. Tela</th>
                                    <th class="border-table">Color</th>
                                    <th class="border-table">Area</th>
                                    <th class="border-table">Rec1</th>
                                    <th class="border-table">Rec2</th>
                                    <th class="border-table">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="tbodytablareporte1" class="f-10">

                            </tbody>
                        </table>

                    </div>

                    <hr>


                </div>

                <!-- INDICADOR GENERAL -->
                <div class="col-12">
                    <div id="chartgeneral-container" style="height:300px">
                        <canvas id="chartgeneral"></canvas>
                    </div>

                    <div class="w-100">

                        <table class="table table-bordered table-hover table-sm">
                            <thead id="theadindicador" class="f-11 thead-light">

                            </thead>
                            <tbody id="tbodyindicador" class="f-10">

                            </tbody>
                        </table>

                    </div>

                </div>

            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
    </div>

    <!-- MODAL INDICADOR2 -->
    <div class="modal fade" id="modalResumen-1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="lbltitulomodal-1">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    <label for="" class="font-weight-bold" >Áreas:</label>
                    <div id="chart-1-detalle-1-container" style="height:200px">
                        <canvas id="chart-1-detalle-1-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-1-detalle-1-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Áreas</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-1-detalle-1-tbody">
                        </tbody>
                    </table>

                    <hr>

                </div>

                <div class="col-12">
                    <label for="" class="font-weight-bold">Motivos:</label>
                    <div id="chart-2-detalle-1-container" style="height:200px">
                        <canvas id="chart-2-detalle-1-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-2-detalle-1-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Motivos</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-2-detalle-1-tbody">
                        </tbody>
                    </table>

                    <hr>
                </div>

                <div class="col-12">
                    <label for="" class="font-weight-bold" >Detalle De Articulos:</label>
                    <div id="chart-3-detalle-1-container" style="height:200px">
                        <canvas id="chart-3-detalle-1-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-3-detalle-1-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Articulos</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-3-detalle-1-tbody">
                        </tbody>
                    </table>

                    <hr>
                </div>

                <div class="col-12">

                    <label for="" class="font-weight-bold" >Detalle Motivos:</label>
                    <div class="table-responsive" style="max-height: 300px;overflow:auto">

                        <table class="table table-bordered table-sm">
                            <thead class="thead-light f-11 sticky-top">
                                <tr>
                                    <th class="border-table">#</th>
                                    <th class="border-table">Partida</th>
                                    <th class="border-table">Proveedor</th>
                                    <th class="border-table">Cliente</th>
                                    <th class="border-table">Programa</th>
                                    <th class="border-table">Cod. Tela</th>
                                    <th class="border-table">Dsc. Tela</th>
                                    <th class="border-table">Color</th>
                                    <th class="border-table">Area</th>
                                    <th class="border-table">Apariencia</th>
                                    <th class="border-table">Recomendación</th>
                                    <th class="border-table">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="tbodytablareporte1-1" class="f-10">

                            </tbody>
                        </table>

                    </div>

                    <hr>


                </div>

                <!-- INDICADOR GENERAL -->
                <div class="col-12">
                    <div id="chartgeneral-1-container" style="height:300px">
                        <canvas id="chartgeneral-1"></canvas>
                    </div>

                    <div class="w-100">

                        <table class="table table-bordered table-hover table-sm">
                            <thead id="theadindicador-1" class="f-11 thead-light">

                            </thead>
                            <tbody id="tbodyindicador-1" class="f-10">

                            </tbody>
                        </table>

                    </div>

                </div>

            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
    </div>

    <!-- MODAL INDICADOR3 -->
    <div class="modal fade" id="modalResumen-2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="lbltitulomodal-2">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    <label for="" class="font-weight-bold" >Áreas:</label>
                    <div id="chart-1-detalle-2-container" style="height:200px">
                        <canvas id="chart-1-detalle-2-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-1-detalle-2-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Áreas</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-1-detalle-2-tbody">
                        </tbody>
                    </table>

                    <hr>

                </div>

                <div class="col-12">
                    <label for="" class="font-weight-bold">Motivos:</label>
                    <div id="chart-2-detalle-2-container" style="height:200px">
                        <canvas id="chart-2-detalle-2-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-2-detalle-2-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Motivos</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-2-detalle-2-tbody">
                        </tbody>
                    </table>


                    <hr>
                </div>

                <div class="col-12">
                    <label for="" class="font-weight-bold" >Detalle De Articulos:</label>
                    <div id="chart-3-detalle-2-container" style="height:200px">
                        <canvas id="chart-3-detalle-2-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-3-detalle-2-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Articulos</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-3-detalle-2-tbody">
                        </tbody>
                    </table>

                    <hr>
                </div>

                <div class="col-12">

                    <label for="" class="font-weight-bold" >Detalle Motivos:</label>
                    <div class="table-responsive" style="max-height: 300px;overflow:auto">

                        <table class="table table-bordered table-sm">
                            <thead class="thead-light f-11 sticky-top">
                                <tr>
                                    <th class="border-table">#</th>
                                    <th class="border-table">Partida</th>
                                    <th class="border-table">Proveedor</th>
                                    <th class="border-table">Cliente</th>
                                    <th class="border-table">Programa</th>
                                    <th class="border-table">Cod. Tela</th>
                                    <th class="border-table">Dsc. Tela</th>
                                    <th class="border-table">Color</th>
                                    <th class="border-table">Area</th>
                                    <th class="border-table">Defecto</th>
                                    <th class="border-table">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="tbodytablareporte1-2" class="f-10">

                            </tbody>
                        </table>

                    </div>

                    <hr>


                </div>

                <!-- INDICADOR GENERAL -->
                <div class="col-12">
                    <div id="chartgeneral-2-container" style="height:300px">
                        <canvas id="chartgeneral-2-"></canvas>
                    </div>

                    <div class="w-100">

                        <table class="table table-bordered table-hover table-sm">
                            <thead id="theadindicador-2" class="f-11 thead-light">

                            </thead>
                            <tbody id="tbodyindicador-2" class="f-10">

                            </tbody>
                        </table>

                    </div>

                </div>

            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
    </div>

    <!-- MODAL INDICADOR4 -->
    <div class="modal fade" id="modalResumen-3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="lbltitulomodal-3">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">

                <div class="col-12">
                    <label for="" class="font-weight-bold" >Áreas:</label>
                    <div id="chart-1-detalle-3-container" style="height:200px">
                        <canvas id="chart-1-detalle-3-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-1-detalle-3-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Áreas</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-1-detalle-3-tbody">
                        </tbody>
                    </table>

                    <hr>

                </div>

                <div class="col-12">
                    <label for="" class="font-weight-bold">Motivos:</label>
                    <div id="chart-2-detalle-3-container" style="height:200px">
                        <canvas id="chart-2-detalle-3-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-2-detalle-3-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Motivos</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-2-detalle-3-tbody">
                        </tbody>
                    </table>


                    <hr>
                </div>

                <div class="col-12">
                    <label for="" class="font-weight-bold" >Detalle De Articulos:</label>
                    <div id="chart-3-detalle-3-container" style="height:200px">
                        <canvas id="chart-3-detalle-3-"></canvas>
                    </div>

                    <!-- TABLA -->
                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chart-3-detalle-3-table">
                        <thead class="thead-sistema">
                            <tr>    
                                <th>Articulos</th>
                                <th>Kilos</th>
                                <th>% Kilos</th>
                                <th>% Acumulado</th>
                                <th># Frecuencia</th>
                            </tr>
                        </thead>
                        <tbody id="chart-3-detalle-3-tbody">
                        </tbody>
                    </table>

                    <hr>
                </div>

                <div class="col-12">

                    <label for="" class="font-weight-bold" >Detalle Motivos:</label>
                    <div class="table-responsive" style="max-height: 300px;overflow:auto">

                        <table class="table table-bordered table-sm">
                            <thead class="thead-light f-11 sticky-top">
                                <tr>
                                    <th class="border-table">#</th>
                                    <th class="border-table">Partida</th>
                                    <th class="border-table">Proveedor</th>
                                    <th class="border-table">Cliente</th>
                                    <th class="border-table">Programa</th>
                                    <th class="border-table">Cod. Tela</th>
                                    <th class="border-table">Dsc. Tela</th>
                                    <th class="border-table">Color</th>
                                    <th class="border-table">Caracteristica</th>
                                    <th class="border-table">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="tbodytablareporte1-3" class="f-10">

                            </tbody>
                        </table>

                    </div>

                    <hr>


                </div>

                <!-- INDICADOR GENERAL -->
                <div class="col-12">
                    <div id="chartgeneral-3-container" style="height:300px">
                        <canvas id="chartgeneral-3"></canvas>
                    </div>

                    <div class="w-100">

                        <table class="table table-bordered table-hover table-sm">
                            <thead id="theadindicador-3" class="f-11 thead-light">

                            </thead>
                            <tbody id="tbodyindicador-3" class="f-10">

                            </tbody>
                        </table>

                    </div>

                </div>

            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
    </div>

    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>
    <!-- <script src="/tsc/libs/Chartjs/chartjs-plugin-labels.js"></script> -->
    <script src="/tsc/libs/admin/generales/getmantindicadores.admin.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script> -->

    <script>

        const frmbusqueda = document.getElementById("frmbusqueda");
        let CONFIINDICADOR = [];
        let TITULOS = [];

        let APROBADAS       = [];
        let APROBADASNOCONF = [];
        let RECHAZADAS      = [];


        let PROVEEDORES     = [];
        let CLIENTES     = [];
        let PROGRAMAS     = [];
        let TELAS     = [];
        let COLORES     = [];



        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {

            await GetDatosParaBusquedas();
            await SetGraficoGeneral();

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });

        // BUSQUEDA
        frmbusqueda.addEventListener('submit',async (e)=>{

            e.preventDefault();
            await SetGraficoGeneral();
        });

        async function GetDatosParaBusquedas(){

            let response        = await get("auditex-tela","indicadores","get-data-filtros-indicador",{});
            PROVEEDORES = response.proveedores;
            CLIENTES = response.clientes;
            PROGRAMAS = response.programas;
            TELAS = response.telas;
            COLORES = response.colores;



            setComboSimple('cboproveedor',PROVEEDORES,'PROVEEDOR','CODPRV');
            setComboSimple('cbocliente',CLIENTES,'CLIENTE','CODCLI');
            setComboSimple('cboprograma',PROGRAMAS,'PROGRAMA','PROGRAMA');
            setComboSimple('cbotelas',TELAS,'CODTEL','CODTEL');
            setComboSimple('cbocolor',COLORES,'DSCCOL','DSCCOL');
        }

        // CLIENTES
        $("#cbocliente").change(function(){

            let valor = $("#cbocliente").val();
            let filtro = [];
            if(valor != ""){
                filtro =   PROGRAMAS.filter(obj => obj.CODCLI == valor);
            }else{
                filtro =   PROGRAMAS;
            }
            setComboSimple('cboprograma',filtro,'PROGRAMA','PROGRAMA');

        });

        // TELAS
        $("#cboprograma").change(function(){

            let valor = $("#cboprograma").val();
            let filtro = [];
            if(valor != ""){
                filtro =   TELAS.filter(obj => obj.PROGRAMA == valor);
            }else{
                filtro =   TELAS;
            }
            setComboSimple('cbotelas',filtro,'CODTEL','CODTEL');

        });

        // COLOR
        $("#cbotelas").change(function(){

            let valor = $("#cbotelas").val();
            let filtro = [];
            if(valor != ""){
                filtro =   COLORES.filter(obj => obj.CODTEL == valor);
            }else{
                filtro =   COLORES;
            }
            setComboSimple('cbocolor',filtro,'DSCCOL','DSCCOL');

        });

        // SET GRAFICO GENERAL
        async function SetGraficoGeneral(){

            MostrarCarga();

            let response        = await get("auditex-tela","indicadores","get-data-indicadorgeneral",{

                opcion:         1,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()

            });

            let response1        = await get("auditex-tela","indicadores","get-data-indicadorgeneral",{

                opcion:         29,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()

            });

            let response2        = await get("auditex-tela","indicadores","get-data-indicadorgeneral",{

                opcion:         28,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()

            });

            let response3        = await get("auditex-tela","indicadores","get-data-indicadorgeneral",{

                opcion:         31,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()

            });

            // PESOAUDtono
            let aprobadas       = response.filter(obj => obj.RESULTADO == 'A');
            let concecionada    = response.filter(obj => obj.RESULTADO == 'C');
            let rechazadas      = response.filter(obj => obj.RESULTADO == 'R');

            
            aprobadas       = aprobadas     ? aprobadas.reduce((acumulador, actual) => acumulador       + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            concecionada    = concecionada  ? concecionada.reduce((acumulador, actual) => acumulador    + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            rechazadas      = rechazadas    ? rechazadas.reduce((acumulador, actual) => acumulador      + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;

            $(`#pie-chartcanvas`).remove();
            $(`#pie-chartcanvas-container`).append(`<canvas id='pie-chartcanvas'></canvas>`);

            let canvas  = document.getElementById("pie-chartcanvas");
            var ctx     = canvas.getContext("2d"); 
            //
            // PESOAUDapar
            let aprobadas1       = response1.filter(obj => obj.RESULTADO == 'A');
            let concecionada1    = response1.filter(obj => obj.RESULTADO == 'C');
            let rechazadas1      = response1.filter(obj => obj.RESULTADO == 'R');

            aprobadas1       = aprobadas1     ? aprobadas1.reduce((acumulador, actual) => acumulador       + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            concecionada1    = concecionada1  ? concecionada1.reduce((acumulador, actual) => acumulador    + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            rechazadas1     = rechazadas1    ? rechazadas1.reduce((acumulador, actual) => acumulador      + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            
            $(`#pie-chartcanvas-1`).remove();
            $(`#pie-chartcanvas-container-1`).append(`<canvas id='pie-chartcanvas-1'></canvas>`);

            let canvas1  = document.getElementById("pie-chartcanvas-1");
            var ctx1     = canvas1.getContext("2d"); 
            //

            // PESOAUDdefec
            let aprobadas2       = response2.filter(obj => obj.RESULTADO == 'A');
            let concecionada2    = response2.filter(obj => obj.RESULTADO == 'C');
            let rechazadas2      = response2.filter(obj => obj.RESULTADO == 'R');

            aprobadas2       = aprobadas2     ? aprobadas2.reduce((acumulador, actual) => acumulador       + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            concecionada2    = concecionada2  ? concecionada2.reduce((acumulador, actual) => acumulador    + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            rechazadas2      = rechazadas2    ? rechazadas2.reduce((acumulador, actual) => acumulador      + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;

            $(`#pie-chartcanvas-2`).remove();
            $(`#pie-chartcanvas-container-2`).append(`<canvas id='pie-chartcanvas-2'></canvas>`);


            let canvas2  = document.getElementById("pie-chartcanvas-2");
            var ctx2     = canvas2.getContext("2d"); 

            //

            // PESOAUDestd
            let aprobadas3       = response3.filter(obj => obj.RESULTADO == 'A');
            let concecionada3    = response3.filter(obj => obj.RESULTADO == 'C');
            let rechazadas3      = response3.filter(obj => obj.RESULTADO == 'R');

            aprobadas3       = aprobadas3     ? aprobadas3.reduce((acumulador, actual) => acumulador       + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            concecionada3    = concecionada3  ? concecionada3.reduce((acumulador, actual) => acumulador    + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            rechazadas3     = rechazadas3    ? rechazadas3.reduce((acumulador, actual) => acumulador      + parseFloat(actual.PESOAUD != null ? actual.PESOAUD : 0), 0) : 0;
            
            $(`#pie-chartcanvas-3`).remove();
            $(`#pie-chartcanvas-container-3`).append(`<canvas id='pie-chartcanvas-3'></canvas>`);

            let canvas3  = document.getElementById("pie-chartcanvas-3");
            var ctx3     = canvas3.getContext("2d"); 
            //

            var options = {
                responsive: true,
                title: {
                    display: false,
                    position: "top",
                    text: "Pie Chart",
                    fontSize: 18,
                    fontColor: "#111"
                },
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                    fontColor: "#333",
                    fontSize: 12
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {

                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = ((currentValue/total) * 100);

                            return percentage.toFixed(2) + "%";
                        }
                    }
                }
            };
            
            //tono

            var data1 = {
                labels: ["Aprobadas", "Rechazadas", "Aprobadas no conforme"],
                datasets: [
                    {
                        data: [aprobadas,rechazadas,concecionada],
                        backgroundColor: [
                            "#4bc0c0",
                            "#ff6384",
                            "#ff9f40",
                        ],
                        borderWidth: [1, 1, 1, 1, 1]
                    }
                ]
            };

            var chart = new Chart(ctx, {
                type: "pie",
                data: data1,
                options: options
            });
            //

            //apar
            var data2 = {
                labels: ["Aprobadas", "Rechazadas", "Aprobadas no conforme"],
                datasets: [
                    {
                        data: [aprobadas1,rechazadas1,concecionada1],
                        backgroundColor: [
                            "#4bc0c0",
                            "#ff6384",
                            "#ff9f40",
                        ],
                        borderWidth: [1, 1, 1, 1, 1]
                    }
                ]
            };

            var chart1 = new Chart(ctx1, {
                type: "pie",
                data: data2,
                options: options
            });
            //
            //defecto
            var data3 = {
                labels: ["Aprobadas", "Rechazadas", "Aprobadas no conforme"],
                datasets: [
                    {
                        data: [aprobadas2,rechazadas2,concecionada2],
                        backgroundColor: [
                            "#4bc0c0",
                            "#ff6384",
                            "#ff9f40",
                        ],
                        borderWidth: [1, 1, 1, 1, 1]
                    }
                ]
            };

            var chart2 = new Chart(ctx2, {
                type: "pie",
                data: data3,
                options: options
            });
            //

            //DEF
            var data4 = {
                labels: ["Aprobadas", "Rechazadas", "Aprobadas no conforme"],
                datasets: [
                    {
                        data: [aprobadas3,rechazadas3,concecionada3],
                        backgroundColor: [
                            "#4bc0c0",
                            "#ff6384",
                            "#ff9f40",
                        ],
                        borderWidth: [1, 1, 1, 1, 1]
                    }
                ]
            };

            var chart3 = new Chart(ctx3, {
                type: "pie",
                data: data4,
                options: options
            });
            //

            canvas.onclick = async function(evt) {
                var activePoints = chart.getElementsAtEvent(evt);
                if (activePoints[0]) {
                    var chartData = activePoints[0]['_chart'].config.data;
                    var idx = activePoints[0]['_index'];

                    var label = chartData.labels[idx];
                    var value = chartData.datasets[0].data[idx];
                    $("#lbltitulomodal").text(label);
                    MostrarCarga();


                    // ##########################
                    // ### MOSTRAMOS DETALLES ###
                    // ##########################
                    let filtro = null;
                    if(label == "Aprobadas") {filtro = "A";}
                    if(label == "Rechazadas") {filtro = "R";}
                    if(label == "Aprobadas no conforme") {filtro = "C";}

                    // // AREAS
                    // let responseareas           = await GetDataDetalle(filtro,14,'DESREC1','PESOAUD','CODREC1','CANTIDAD','chart-1-detalle-','RECOMENDACIONES','','');
                    // // MOTIVOS
                    // let responseareasmotivos    = await GetDataDetalle(filtro,15,'DESREC2','PESOAUD','CODREC2','CANTIDAD','chart-2-detalle-','MOTIVOS',responseareas.mayor1des,'');
                    // // ARTICULOS
                    // let responsearticulos       = await GetDataDetalle(filtro,16,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',responseareas.mayor1des,responseareasmotivos.mayor1des);


                    // AREAS
                    let responseareas           = await GetDataDetalle(filtro,14,'DESREC1','PESOAUD','CODREC1','CANTIDAD','chart-1-detalle-','RECOMENDACIONES','','');
                    // MOTIVOS
                    let responseareasmotivos    = await GetDataDetalle(filtro,15,'DESREC2','PESOAUD','CODREC2','CANTIDAD','chart-2-detalle-','MOTIVOS',responseareas.mayor1des,'');
                    // ARTICULOS
                    let responsearticulos       = await GetDataDetalle(filtro,16,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',responseareas.mayor1des,responseareasmotivos.mayor1des);

                    // ARTICULOS A DETALLE
                    await ArmarTablaArticulos(filtro,responseareas.mayor1des,responseareasmotivos.mayor1des);
                    // ARMAMOS INDICADOR
                    await SetIndicadorGeneral(responseareasmotivos.mayor1des);
                    OcultarCarga();
                    $("#modalResumen").modal("show");
                }
            };

            canvas1.onclick = async function(evt) {
                var activePoints = chart1.getElementsAtEvent(evt);
                if (activePoints[0]) {
                    var chartData = activePoints[0]['_chart'].config.data;
                    var idx = activePoints[0]['_index'];

                    var label = chartData.labels[idx];
                    var value = chartData.datasets[0].data[idx];
                    $("#lbltitulomodal-1").text(label);
                    MostrarCarga();


                    // ##########################
                    // ### MOSTRAMOS DETALLES ###
                    // ##########################
                    let filtro = null;
                    if(label == "Aprobadas") {filtro = "A";}
                    if(label == "Rechazadas") {filtro = "R";}
                    if(label == "Aprobadas no conforme") {filtro = "C";}

                    // // AREAS
                    // let responseareas           = await GetDataDetalle(filtro,21,'DSCAREAD','PESOAUD','CODAREAD','CANTIDAD','chart-1-detalle-','AREAS','','');
                    // // DEFFECTOS
                    // let responseareasmotivos    = await GetDataDetalle(filtro,22,'DESAPA','PESOAUD','CODAPA','CANTIDAD','chart-2-detalle-','DEFECTOS',responseareas.mayor1des,'');
                    // // ARTICULOS
                    // let responsearticulos       = await GetDataDetalle(filtro,23,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',responseareas.mayor1des,responseareasmotivos.mayor1des);
                    
                    // AREAS
                    let responseareas           = await GetDataDetalle1(filtro,21,'DSCAREAD','PESOAUD','CODAREAD','CANTIDAD','chart-1-detalle-1-','AREAS','','');
                    // DEFFECTOS
                    let responseareasmotivos    = await GetDataDetalle1(filtro,22,'DESAPA','PESOAUD','CODAPA','CANTIDAD','chart-2-detalle-1-','DEFECTOS',responseareas.mayor1des,'');
                    // ARTICULOS
                    let responsearticulos       = await GetDataDetalle1(filtro,23,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-1-','ARTICULOS',responseareas.mayor1des,responseareasmotivos.mayor1des);
                    
                    
                    // ARTICULOS A DETALLE
                    await ArmarTablaArticulos1(filtro,responseareas.mayor1des,responseareasmotivos.mayor1des);
                    // ARMAMOS INDICADOR
                    await SetIndicadorGeneral1(responseareasmotivos.mayor1des);
                    OcultarCarga();
                    $("#modalResumen-1").modal("show");
                }
            };

            canvas2.onclick = async function(evt) {
                var activePoints = chart2.getElementsAtEvent(evt);
                if (activePoints[0]) {
                    var chartData = activePoints[0]['_chart'].config.data;
                    var idx = activePoints[0]['_index'];

                    var label = chartData.labels[idx];
                    var value = chartData.datasets[0].data[idx];
                    $("#lbltitulomodal-2").text(label);
                    MostrarCarga();


                    // ##########################
                    // ### MOSTRAMOS DETALLES ###
                    // ##########################
                    let filtro = null;
                    if(label == "Aprobadas") {filtro = "A";}
                    if(label == "Rechazadas") {filtro = "R";}
                    if(label == "Aprobadas no conforme") {filtro = "C";}

                    // AREAS
                    // let responseareas           = await GetDataDetalle(filtro,2,'DSCAREAD','PESOAUD','CODAREAD','CANTIDAD','chart-1-detalle-','AREAS','','');
                    // // DEFFECTOS
                    // let responseareasmotivos    = await GetDataDetalle(filtro,3,'DESDEF','PESOAUD','CODDEF','CANTIDAD','chart-2-detalle-','DEFECTOS',responseareas.mayor1des,'');
                    // // ARTICULOS
                    // let responsearticulos       = await GetDataDetalle(filtro,4,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',responseareas.mayor1des,responseareasmotivos.mayor1des);


                    // AREAS
                    let responseareas           = await GetDataDetalle2(filtro,2,'DSCAREAD','PESOAUD','CODAREAD','CANTIDAD','chart-1-detalle-2-','AREAS','','');
                    // DEFFECTOS
                    let responseareasmotivos    = await GetDataDetalle2(filtro,3,'DESDEF','PESOAUD','CODDEF','CANTIDAD','chart-2-detalle-2-','DEFECTOS',responseareas.mayor1des,'');
                    // ARTICULOS
                    let responsearticulos       = await GetDataDetalle2(filtro,4,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-2-','ARTICULOS',responseareas.mayor1des,responseareasmotivos.mayor1des);

                    // ARTICULOS A DETALLE
                    await ArmarTablaArticulos2(filtro,responseareas.mayor1des,responseareasmotivos.mayor1des);
                    // ARMAMOS INDICADOR
                    await SetIndicadorGeneral2(responseareasmotivos.mayor1des);

                    // NUEO INDICADOR
                    await SetIndicadorToneladas2(responseareasmotivos.mayor1des);

                    OcultarCarga();
                    $("#modalResumen-2").modal("show");
                }
            };

            canvas3.onclick = async function(evt) {
                var activePoints = chart3.getElementsAtEvent(evt);
                if (activePoints[0]) {
                    var chartData = activePoints[0]['_chart'].config.data;
                    var idx = activePoints[0]['_index'];

                    var label = chartData.labels[idx];
                    var value = chartData.datasets[0].data[idx];
                    $("#lbltitulomodal-3").text(label);
                    MostrarCarga();


                    // ##########################
                    // ### MOSTRAMOS DETALLES ###
                    // ##########################
                    let filtro = null;
                    if(label == "Aprobadas") {filtro = "A";}
                    if(label == "Rechazadas") {filtro = "R";}
                    if(label == "Aprobadas no conforme") {filtro = "C";}

                    // // AREAS
                    // let responseareas           = await GetDataDetalle(filtro,14,'DESREC1','PESOAUD','CODREC1','CANTIDAD','chart-1-detalle-','RECOMENDACIONES','','');
                    // // MOTIVOS
                    // let responseareasmotivos    = await GetDataDetalle(filtro,15,'DESREC2','PESOAUD','CODREC2','CANTIDAD','chart-2-detalle-','MOTIVOS',responseareas.mayor1des,'');
                    // // ARTICULOS
                    // let responsearticulos       = await GetDataDetalle(filtro,16,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',responseareas.mayor1des,responseareasmotivos.mayor1des);


                    // AREAS
                    let responseareas           = await GetDataDetalle3(filtro,32,'DESESTDIM','PESOAUD','CODESTDIM','CANTIDAD','chart-1-detalle-3-','CARACTERISTICAS','','');
                    // MOTIVOS
                    let responseareasmotivos    = await GetDataDetalle3(filtro,33,'DSCCOL','PESOAUD','CODCOL','CANTIDAD','chart-2-detalle-3-','COLOR',responseareas.mayor1des,'');
                    // ARTICULOS
                    let responsearticulos       = await GetDataDetalle3(filtro,34,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-3-','ARTICULOS',responseareas.mayor1des,responseareasmotivos.mayor1des);

                    // ARTICULOS A DETALLE
                    await ArmarTablaArticulos3(filtro,responseareas.mayor1des,responseareasmotivos.mayor1des);
                    // ARMAMOS INDICADOR
                    await SetIndicadorGeneral3(responseareas.mayor1des);
                    OcultarCarga();
                    $("#modalResumen-3").modal("show");
                }
            };

            OcultarCarga();


        }

        // GET DATA DETALLE
        async function GetDataDetalle(filtro,opcion = 14,descripcion_grap = '',valor_grap = '',codigo_grap = '',cantidad_grap = '',chart_grap = '',titulo_grap = '',filtro2 = '',filtro3 = ''){

            // DATA DETALLE 1
            let response      = await get("auditex-tela","indicadores","get-data-indicadorgeneral-detalle",{
                opcion,
                filtro,
                filtro2,
                filtro3,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()
            });

            // DATA FORMATEADA
            let dataformateada = formatDataIndicadoresTextilBloques(response,descripcion_grap,valor_grap,codigo_grap,cantidad_grap);
            // console.log('data formateada',dataformateada);
            let dataretornada = setGraficoBarraIndicadoresTextilBloques(chart_grap, dataformateada,titulo_grap);


            let canvas  = dataretornada.canvas;
            let chart   = dataretornada.chart;

            canvas.onclick = async function(evt) {
                var activePoints = chart.getElementsAtEvent(evt);
                if (activePoints[0]) {
                    var chartData = activePoints[0]['_chart'].config.data;
                    var idx = activePoints[0]['_index'];

                    var label = chartData.labels[idx];
                    var value = chartData.datasets[0].data[idx];

                    // TRAEMOS MOTIVOS
                    if(titulo_grap == "RECOMENDACIONES"){

                        // MOSTRAMOS DATA MAS DETALLADA
                        // await GetDataDetalle(filtro,15,'DESREC2','PESOAUD','CODREC2','CANTIDAD','chart-2-detalle-','MOTIVOS',label,'');
                        await GetDataDetalle(filtro,15,'DESREC2','PESOAUD','CODREC2','CANTIDAD','chart-2-detalle-','MOTIVOS',label,'');


                    }

                    // TRAEMOS ARTICULOS
                    if(titulo_grap == "MOTIVOS"){
                        // await GetDataDetalle(filtro,16,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',filtro2,label);
                        await GetDataDetalle(filtro,16,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',filtro2,label);


                        // ARTICULOS A DETALLE
                        await ArmarTablaArticulos(filtro,filtro2,label);

                        // ARMAMOS INDICADOR
                        await SetIndicadorGeneral(label);
                    }                   

                }
            };

            // RETORNAMOS DATA
            return dataformateada;

        }
        // GET DATA DETALLE1
        async function GetDataDetalle1(filtro,opcion = 21,descripcion_grap = '',valor_grap = '',codigo_grap = '',cantidad_grap = '',chart_grap = '',titulo_grap = '',filtro2 = '',filtro3 = ''){

            // DATA DETALLE 1
            let response      = await get("auditex-tela","indicadores","get-data-indicadorgeneral-detalle",{
                opcion,
                filtro,
                filtro2,
                filtro3,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()
            });

            // DATA FORMATEADA
            let dataformateada = formatDataIndicadoresTextilBloques(response,descripcion_grap,valor_grap,codigo_grap,cantidad_grap);
            // console.log('data formateada',dataformateada);
            let dataretornada = setGraficoBarraIndicadoresTextilBloques(chart_grap, dataformateada,titulo_grap);


            let canvas  = dataretornada.canvas;
            let chart   = dataretornada.chart;

            canvas.onclick = async function(evt) {
                var activePoints = chart.getElementsAtEvent(evt);
                if (activePoints[0]) {
                    var chartData = activePoints[0]['_chart'].config.data;
                    var idx = activePoints[0]['_index'];

                    var label = chartData.labels[idx];
                    var value = chartData.datasets[0].data[idx];

                    // TRAEMOS MOTIVOS
                    if(titulo_grap == "AREAS"){

                        // MOSTRAMOS DATA MAS DETALLADA
                        // await GetDataDetalle(filtro,22,'DESAPA','PESOAUD','CODAPA','CANTIDAD','chart-2-detalle-','DEFECTOS',label,'');
                        await GetDataDetalle1(filtro,22,'DESAPA','PESOAUD','CODAPA','CANTIDAD','chart-2-detalle-1-','DEFECTOS',label,'');


                    }

                    // TRAEMOS ARTICULOS
                    if(titulo_grap == "DEFECTOS"){
                        // await GetDataDetalle(filtro,23,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',filtro2,label);
                        await GetDataDetalle1(filtro,23,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-1-','ARTICULOS',filtro2,label);


                        // ARTICULOS A DETALLE
                        await ArmarTablaArticulos1(filtro,filtro2,label);

                        // ARMAMOS INDICADOR
                        await SetIndicadorGeneral1(label);
                    }

                }
            };

            // RETORNAMOS DATA
            return dataformateada;

        }
        // GET DATA DETALLE2
        async function GetDataDetalle2(filtro,opcion = 2,descripcion_grap = '',valor_grap = '',codigo_grap = '',cantidad_grap = '',chart_grap = '',titulo_grap = '',filtro2 = '',filtro3 = ''){

            // DATA DETALLE 1
            let response      = await get("auditex-tela","indicadores","get-data-indicadorgeneral-detalle",{
                opcion,
                filtro,
                filtro2,
                filtro3,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()
            });

            // DATA FORMATEADA
            let dataformateada = formatDataIndicadoresTextilBloques(response,descripcion_grap,valor_grap,codigo_grap,cantidad_grap);
            // console.log('data formateada',dataformateada);
            let dataretornada = setGraficoBarraIndicadoresTextilBloques(chart_grap, dataformateada,titulo_grap);


            let canvas  = dataretornada.canvas;
            let chart   = dataretornada.chart;

            canvas.onclick = async function(evt) {
                var activePoints = chart.getElementsAtEvent(evt);
                if (activePoints[0]) {
                    var chartData = activePoints[0]['_chart'].config.data;
                    var idx = activePoints[0]['_index'];

                    var label = chartData.labels[idx];
                    var value = chartData.datasets[0].data[idx];

                    // TRAEMOS MOTIVOS
                    if(titulo_grap == "AREAS"){

                        // MOSTRAMOS DATA MAS DETALLADA
                        // await GetDataDetalle(filtro,3,'DESDEF','PESOAUD','CODDEF','CANTIDAD','chart-2-detalle-','DEFECTOS',label,'');
                        await GetDataDetalle2(filtro,3,'DESDEF','PESOAUD','CODDEF','CANTIDAD','chart-2-detalle-2-','DEFECTOS',label,'');


                    }

                    // TRAEMOS ARTICULOS
                    if(titulo_grap == "DEFECTOS"){
                        // await GetDataDetalle(filtro,4,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',filtro2,label);
                        await GetDataDetalle2(filtro,4,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-2-','ARTICULOS',filtro2,label);



                        // ARTICULOS A DETALLE
                        await ArmarTablaArticulos2(filtro,filtro2,label);

                        // ARMAMOS INDICADOR
                        await SetIndicadorGeneral2(label);

                        // NUEO INDICADOR
                        await SetIndicadorToneladas2(label);

                    }

                }
            };

            // RETORNAMOS DATA
            return dataformateada;

        }
        // GET DATA DETALLE3
        async function GetDataDetalle3(filtro,opcion = 32,descripcion_grap = '',valor_grap = '',codigo_grap = '',cantidad_grap = '',chart_grap = '',titulo_grap = '',filtro2 = '',filtro3 = ''){

            // DATA DETALLE 1
            let response      = await get("auditex-tela","indicadores","get-data-indicadorgeneral-detalle",{
                opcion,
                filtro,
                filtro2,
                filtro3,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()
            });

            // DATA FORMATEADA
            let dataformateada = formatDataIndicadoresTextilBloques(response,descripcion_grap,valor_grap,codigo_grap,cantidad_grap);
            // console.log('data formateada',dataformateada);
            let dataretornada = setGraficoBarraIndicadoresTextilBloques(chart_grap, dataformateada,titulo_grap);


            let canvas  = dataretornada.canvas;
            let chart   = dataretornada.chart;

            canvas.onclick = async function(evt) {
                var activePoints = chart.getElementsAtEvent(evt);
                if (activePoints[0]) {
                    var chartData = activePoints[0]['_chart'].config.data;
                    var idx = activePoints[0]['_index'];

                    var label = chartData.labels[idx];
                    var value = chartData.datasets[0].data[idx];

                    // TRAEMOS MOTIVOS
                    if(titulo_grap == "CARACTERISTICAS"){

                        // MOSTRAMOS DATA MAS DETALLADA
                        // await GetDataDetalle(filtro,15,'DESREC2','PESOAUD','CODREC2','CANTIDAD','chart-2-detalle-','MOTIVOS',label,'');
                        await GetDataDetalle3(filtro,33,'DSCCOL','PESOAUD','CODCOL','CANTIDAD','chart-2-detalle-3-','COLOR',label,'');

                        await SetIndicadorGeneral3(label);
                    }

                    // TRAEMOS ARTICULOS
                    if(titulo_grap == "COLOR"){
                        // await GetDataDetalle(filtro,16,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-','ARTICULOS',filtro2,label);
                        await GetDataDetalle3(filtro,34,'DESTEL','PESOAUD','CODTEL','CANTIDAD','chart-3-detalle-3-','ARTICULOS',filtro2,label);


                        // ARTICULOS A DETALLE
                        await ArmarTablaArticulos3(filtro,filtro2,label);

                        // ARMAMOS INDICADOR
                        //await SetIndicadorGeneral(label);
                    }

                }
            };

            // RETORNAMOS DATA
            return dataformateada;

        }


        // SET TABLA ARTICULOS
        async function ArmarTablaArticulos(filtro,filtro2,filtro3){

            let rpt = await get("auditex-tela","indicadores","get-data-indicadorgeneral-detalle",{
                    opcion:17,
                    filtro,
                    filtro2,
                    filtro3,
                    proveedor:      $("#cboproveedor").val(),
                    cliente:        $("#cbocliente").val(),
                    programa:       $("#cboprograma").val(),
                    telas:          $("#cbotelas").val(),
                    color:          $("#cbocolor").val(),
                    fechainicio:    $("#txtfechainicio").val(),
                    fechafin:       $("#txtfechafin").val()
                });

                let tr = "";
                let count = 0;
                for(let item of rpt){
                    count++;
                    tr += `
                        <tr>
                            <td> ${count} </td>
                            <td> ${item.PARTIDA} </td>
                            <td> ${item.PROVEEDOR} </td>
                            <td> ${item.CLIENTE} </td>
                            <td> ${item.PROGRAMA} </td>
                            <td> ${item.CODTEL} </td>
                            <td> ${item.DESTEL} </td>
                            <td> ${item.COLOR} </td>
                            <td> ${item.AREA} </td>
                            <td> ${item.DESREC1} </td>
                            <td> ${item.DESREC2} </td>
                            <td> ${item.CANTIDAD} </td>
                        </tr>
                    `;
                }

                $("#tbodytablareporte1").html(tr);
        }

        // SET TABLA ARTICULOS1
        async function ArmarTablaArticulos1(filtro,filtro2,filtro3){

            let rpt = await get("auditex-tela","indicadores","get-data-indicadorgeneral-detalle",{
                    opcion:24,
                    filtro,
                    filtro2,
                    filtro3,
                    proveedor:      $("#cboproveedor").val(),
                    cliente:        $("#cbocliente").val(),
                    programa:       $("#cboprograma").val(),
                    telas:          $("#cbotelas").val(),
                    color:          $("#cbocolor").val(),
                    fechainicio:    $("#txtfechainicio").val(),
                    fechafin:       $("#txtfechafin").val()
                });

                let tr = "";
                let count = 0;
                for(let item of rpt){
                    count++;
                    tr += `
                        <tr>
                            <td> ${count} </td>
                            <td> ${item.PARTIDA} </td>
                            <td> ${item.PROVEEDOR} </td>
                            <td> ${item.CLIENTE} </td>
                            <td> ${item.PROGRAMA} </td>
                            <td> ${item.CODTEL}</td>
                            <td> ${item.DESTEL} </td>
                            <td> ${item.COLOR} </td>
                            <td> ${item.AREA} </td>
                            <td> ${item.DESAPA} </td>
                            <td> ${item.DESREC1} </td>
                            <td> ${item.CANTIDAD} </td>
                        </tr>
                    `;
                }

                $("#tbodytablareporte1-1").html(tr);
        }

         // SET TABLA ARTICULOS2
        async function ArmarTablaArticulos2(filtro,filtro2,filtro3){

                let rpt = await get("auditex-tela","indicadores","get-data-indicadorgeneral-detalle",{
                        opcion:5,
                        filtro,
                        filtro2,
                        filtro3,
                        proveedor:      $("#cboproveedor").val(),
                        cliente:        $("#cbocliente").val(),
                        programa:       $("#cboprograma").val(),
                        telas:          $("#cbotelas").val(),
                        color:          $("#cbocolor").val(),
                        fechainicio:    $("#txtfechainicio").val(),
                        fechafin:       $("#txtfechafin").val()
                    });

                    let tr = "";
                    let count = 0;
                    for(let item of rpt){
                        count++;
                        tr += `
                            <tr>
                                <td> ${count} </td>
                                <td> ${item.PARTIDA} </td>
                                <td> ${item.PROVEEDOR} </td>
                                <td> ${item.CLIENTE} </td>
                                <td> ${item.PROGRAMA} </td>
                                <td> ${item.CODTEL} </td>
                                <td> ${item.DESTEL} </td>
                                <td> ${item.COLOR} </td>
                                <td> ${item.AREA} </td>
                                <td> ${item.DEFECTO} </td>
                                <td> ${item.CANTIDAD} </td>
                            </tr>
                        `;
                    }

                    $("#tbodytablareporte1-2").html(tr);
        }

                // SET TABLA ARTICULOS3
        async function ArmarTablaArticulos3(filtro,filtro2,filtro3){

            let rpt = await get("auditex-tela","indicadores","get-data-indicadorgeneral-detalle",{
                    opcion:35,
                    filtro,
                    filtro2,
                    filtro3,
                    proveedor:      $("#cboproveedor").val(),
                    cliente:        $("#cbocliente").val(),
                    programa:       $("#cboprograma").val(),
                    telas:          $("#cbotelas").val(),
                    color:          $("#cbocolor").val(),
                    fechainicio:    $("#txtfechainicio").val(),
                    fechafin:       $("#txtfechafin").val()
                });

                let tr = "";
                let count = 0;
                for(let item of rpt){
                    count++;
                    tr += `
                        <tr>
                            <td> ${count} </td>
                            <td> ${item.PARTIDA} </td>
                            <td> ${item.PROVEEDOR} </td>
                            <td> ${item.CLIENTE} </td>
                            <td> ${item.PROGRAMA} </td>
                            <td> ${item.CODTEL} </td>
                            <td> ${item.DESTEL} </td>
                            <td> ${item.COLOR} </td>
                            <td> ${item.ESTDIM} </td>
                            <td> ${item.CANTIDAD} </td>
                        </tr>
                    `;
                }

                $("#tbodytablareporte1-3").html(tr);
        }


        // ARMAR INDICADOR GENERAL
        async function SetIndicadorGeneral(filtro3){

            let data = await get("auditex-tela","indicadores","get-data-indicadores-tono",{
                filtro3,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()
            });

            let anios   = data.anio;
            let meses   = data.meses;
            let semanas = data.semanas;

            let dataconcat  = [].concat(anios,meses,semanas);


            // ##############################
            // ### VARIABLES PARA GRAFICO ###
            // ##############################
            TITULOS = [];
            APROBADAS = [];
            APROBADASNOCONF = [];
            RECHAZADAS = [];


            // CABECERA
            let tr = "<tr>";
            tr += "<th style='min-width:100px'>DETALLE GENERAL</th>";
            for(let item of dataconcat){
                TITULOS.push(item.COLUMNA);
                tr += `<th style='min-width:80px border-table' class="text-center">${item.COLUMNA}</th>`;
            }
            tr += "</tr>";

            $("#theadindicador").html(tr);

            // FILAS
            let traprobadas = "";
            let traprobadasnoconf = "";
            let trrechazadas = "";
            // console.log(dataconcat,'dataconcat');

            traprobadas         += "<tr> <th class='border-table thead-sistema-3'>APROBADAS</th>";
            traprobadasnoconf   += "<tr> <th class='border-table thead-sistema-3'>APROB. NO CONF</th>";
            trrechazadas        += "<tr> <th class='border-table thead-sistema-3'>RECHAZADAS</th>";

            for(let item of TITULOS){

                let buscado = dataconcat.find(obj => obj.COLUMNA == item);
                APROBADAS.push(buscado.APROBADAS);
                APROBADASNOCONF.push(buscado.APROBADANOCONFORME);
                RECHAZADAS.push(buscado.RECHAZADAS);


                traprobadas         += `<td class="text-center border-table bg-white">${format_miles(buscado.APROBADAS)}</td>`;
                traprobadasnoconf   += `<td class="text-center border-table bg-white">${format_miles(buscado.APROBADANOCONFORME)}</td>`;
                trrechazadas        += `<td class="text-center border-table bg-white">${format_miles(buscado.RECHAZADAS)}</td>`;
            }

            traprobadas += "</tr>";
            traprobadasnoconf += "</tr>";
            trrechazadas += "</tr>";

            $("#tbodyindicador").html(traprobadas+traprobadasnoconf+trrechazadas);
            SetGraficoIndicadorGeneral(filtro3);


        }

        // ARMAR INDICADOR GENERAL1
        async function SetIndicadorGeneral1(filtro3){

            let data = await get("auditex-tela","indicadores","get-data-indicadores-apariencia",{
                filtro3,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()
            });

            let anios   = data.anio;
            let meses   = data.meses;
            let semanas = data.semanas;

            let dataconcat  = [].concat(anios,meses,semanas);


            // ##############################
            // ### VARIABLES PARA GRAFICO ###
            // ##############################
            TITULOS = [];
            APROBADAS = [];
            APROBADASNOCONF = [];
            RECHAZADAS = [];


            // CABECERA
            let tr = "<tr>";
            tr += "<th style='min-width:100px'>DETALLE GENERAL</th>";
            for(let item of dataconcat){
                TITULOS.push(item.COLUMNA);
                tr += `<th style='min-width:80px border-table' class="text-center">${item.COLUMNA}</th>`;
            }
            tr += "</tr>";

            $("#theadindicador-1").html(tr);

            // FILAS
            let traprobadas = "";
            let traprobadasnoconf = "";
            let trrechazadas = "";
            // console.log(dataconcat,'dataconcat');

            traprobadas         += "<tr> <th class='border-table thead-sistema-3'>APROBADAS</th>";
            traprobadasnoconf   += "<tr> <th class='border-table thead-sistema-3'>APROB. NO CONF</th>";
            trrechazadas        += "<tr> <th class='border-table thead-sistema-3'>RECHAZADAS</th>";

            for(let item of TITULOS){

                let buscado = dataconcat.find(obj => obj.COLUMNA == item);
                APROBADAS.push(buscado.APROBADAS);
                APROBADASNOCONF.push(buscado.APROBADANOCONFORME);
                RECHAZADAS.push(buscado.RECHAZADAS);


                traprobadas         += `<td class="text-center border-table bg-white">${format_miles(buscado.APROBADAS)}</td>`;
                traprobadasnoconf   += `<td class="text-center border-table bg-white">${format_miles(buscado.APROBADANOCONFORME)}</td>`;
                trrechazadas        += `<td class="text-center border-table bg-white">${format_miles(buscado.RECHAZADAS)}</td>`;
            }

            traprobadas += "</tr>";
            traprobadasnoconf += "</tr>";
            trrechazadas += "</tr>";

            $("#tbodyindicador-1").html(traprobadas+traprobadasnoconf+trrechazadas);
            SetGraficoIndicadorGeneral1(filtro3);


        }

         // ARMAR INDICADOR GENERAL2
        async function SetIndicadorGeneral2(filtro3){

                let data = await get("auditex-tela","indicadores","get-data-indicadores",{
                    filtro3,
                    proveedor:      $("#cboproveedor").val(),
                    cliente:        $("#cbocliente").val(),
                    programa:       $("#cboprograma").val(),
                    telas:          $("#cbotelas").val(),
                    color:          $("#cbocolor").val(),
                    fechainicio:    $("#txtfechainicio").val(),
                    fechafin:       $("#txtfechafin").val()
                });

                let anios   = data.anio;
                let meses   = data.meses;
                let semanas = data.semanas;

                let dataconcat  = [].concat(anios,meses,semanas);


                // ##############################
                // ### VARIABLES PARA GRAFICO ###
                // ##############################
                TITULOS = [];
                APROBADAS = [];
                APROBADASNOCONF = [];
                RECHAZADAS = [];


                // CABECERA
                let tr = "<tr>";
                tr += "<th style='min-width:100px'>DETALLE GENERAL</th>";
                for(let item of dataconcat){
                    TITULOS.push(item.COLUMNA);
                    tr += `<th style='min-width:80px border-table' class="text-center">${item.COLUMNA}</th>`;
                }
                tr += "</tr>";

                $("#theadindicador-2").html(tr);

                // FILAS
                let traprobadas = "";
                let traprobadasnoconf = "";
                let trrechazadas = "";
                // console.log(dataconcat,'dataconcat');

                traprobadas         += "<tr> <th class='border-table thead-sistema-3'>APROBADAS</th>";
                traprobadasnoconf   += "<tr> <th class='border-table thead-sistema-3'>APROB. NO CONF</th>";
                trrechazadas        += "<tr> <th class='border-table thead-sistema-3'>RECHAZADAS</th>";

                for(let item of TITULOS){

                    let buscado = dataconcat.find(obj => obj.COLUMNA == item);
                    APROBADAS.push(buscado.APROBADAS);
                    APROBADASNOCONF.push(buscado.APROBADANOCONFORME);
                    RECHAZADAS.push(buscado.RECHAZADAS);


                    traprobadas         += `<td class="text-center border-table bg-white">${format_miles(buscado.APROBADAS)}</td>`;
                    traprobadasnoconf   += `<td class="text-center border-table bg-white">${format_miles(buscado.APROBADANOCONFORME)}</td>`;
                    trrechazadas        += `<td class="text-center border-table bg-white">${format_miles(buscado.RECHAZADAS)}</td>`;
                }

                traprobadas += "</tr>";
                traprobadasnoconf += "</tr>";
                trrechazadas += "</tr>";

                $("#tbodyindicador-2").html(traprobadas+traprobadasnoconf+trrechazadas);
                SetGraficoIndicadorGeneral2(filtro3);


        }

        // ARMAR INDICADOR GENERAL3       
        async function SetIndicadorGeneral3(filtro3){

            let data = await get("auditex-tela","indicadores","get-data-indicadores-estdim",{
                filtro3,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()
            });

            let anios   = data.anio;
            let meses   = data.meses;
            let semanas = data.semanas;

            let dataconcat  = [].concat(anios,meses,semanas);


            // ##############################
            // ### VARIABLES PARA GRAFICO ###
            // ##############################
            TITULOS = [];
            APROBADAS = [];
            APROBADASNOCONF = [];
            RECHAZADAS = [];


            // CABECERA
            let tr = "<tr>";
            tr += "<th style='min-width:100px'>DETALLE GENERAL</th>";
            for(let item of dataconcat){
                TITULOS.push(item.COLUMNA);
                tr += `<th style='min-width:80px border-table' class="text-center">${item.COLUMNA}</th>`;
            }
            tr += "</tr>";

            $("#theadindicador-3").html(tr);

            // FILAS
            let traprobadas = "";
            let traprobadasnoconf = "";
            let trrechazadas = "";
            // console.log(dataconcat,'dataconcat');

            traprobadas         += "<tr> <th class='border-table thead-sistema-3'>APROBADAS</th>";
            traprobadasnoconf   += "<tr> <th class='border-table thead-sistema-3'>APROB. NO CONF</th>";
            trrechazadas        += "<tr> <th class='border-table thead-sistema-3'>RECHAZADAS</th>";

            for(let item of TITULOS){

                let buscado = dataconcat.find(obj => obj.COLUMNA == item);
                APROBADAS.push(buscado.APROBADAS);
                APROBADASNOCONF.push(buscado.APROBADANOCONFORME);
                RECHAZADAS.push(buscado.RECHAZADAS);


                traprobadas         += `<td class="text-center border-table bg-white">${format_miles(buscado.APROBADAS)}</td>`;
                traprobadasnoconf   += `<td class="text-center border-table bg-white">${format_miles(buscado.APROBADANOCONFORME)}</td>`;
                trrechazadas        += `<td class="text-center border-table bg-white">${format_miles(buscado.RECHAZADAS)}</td>`;
            }

            traprobadas += "</tr>";
            traprobadasnoconf += "</tr>";
            trrechazadas += "</tr>";

            $("#tbodyindicador-3").html(traprobadas+traprobadasnoconf+trrechazadas);
            SetGraficoIndicadorGeneral3(filtro3);


        }

        // SET GRAFICO INDICADOR GENERAL
        function SetGraficoIndicadorGeneral(titulochart){

            //QUITAMOS CANVAS
            $(`#chartgeneral`).remove();
            $(`#chartgeneral-container`).append(`<canvas id='chartgeneral'></canvas>`);

            var ctx = document.getElementById('chartgeneral').getContext('2d');


            // CREAMOS CHART
            var mixedChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [
                        {
                            label: 'APROBADAS',
                            data: APROBADAS,
                            order: 1,
                            backgroundColor: 'red',
                        },
                        {
                            label: 'APROB. NO CONF',
                            data: APROBADASNOCONF,
                            type: 'line',
                            fill: false,
                            backgroundColor: 'yellow',
                            lineTension: 0,  
                            borderColor: 'yellow',
                            borderWidth: 3,
                        },
                        {
                            label: 'RECHAZADAS',
                            data: RECHAZADAS,
                            type: 'line',
                            fill: false,
                            backgroundColor: '#000',
                            lineTension: 0,  
                            borderColor: '#000',
                            borderWidth: 3,
                        },
                    ],
                    labels: TITULOS
                },
                options: {
                    maintainAspectRatio: false,
                    // legend: {

                    // },
                    title:{
                        display : true,
                        text : titulochart
                    },
                    // scales: {
                    //     yAxes: [
                    //         {
                    //             id: 'A',
                    //             type: 'linear',
                    //             position: 'left',
                    //             ticks: {
                    //                 min: 0,
                    //                 max: 120,
                    //                 stepSize: 1,
                    //                 display:true

                    //             },
                    //             gridLines: {
                    //                 display: true,
                    //                 drawBorder: true,
                    //                 color: ['none',CONFIINDICADOR[1].COLORFONDO,CONFIINDICADOR[2].COLORFONDO]
                    //             },
                    //             afterBuildTicks: function(humdaysChart) {
                    //                 humdaysChart.ticks = [];
                    //                 humdaysChart.ticks.push(0);
                    //                 humdaysChart.ticks.push( parseFloat(CONFIINDICADOR[0].VALORFIN) );
                    //                 humdaysChart.ticks.push( parseFloat(CONFIINDICADOR[1].VALORFIN) );
                    //                 humdaysChart.ticks.push(100);
                    //             }
                    //         },
                    //         {
                    //             id: 'B',
                    //             type: 'linear',
                    //             position: 'right',
                    //             ticks: {
                    //                 min: 0,
                    //                 max: 120,
                    //                 display:false
                    //             },
                    //             gridLines: {
                    //                 display: false
                    //             }
                    //         },
                    //     ]
                    // },
                    tooltips: {
                        enabled: false,
                    },
                    legend:{
                        display:  true,
                        position: 'bottom',
                        labels:{
                            usePointStyle: true
                        }
                    },
                    plugins: {
                        datalabels: {
                            color: 'black',
                            font:{
                                weight:'bold'
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        onComplete : function () {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            

                            this.data.datasets.forEach(function (dataset) {

                                for (var i = 0; i < dataset.data.length; i++) {

                                    for (var key in dataset._meta) {

                                        // console.log("Dataset",dataset);

                                        var model = dataset._meta[key].data[i]._model;
                                        var valor = 0;
                                        valor = dataset.data[i]; //+ "%";
                                        ctx.fillText(valor, model.x , model.y - 5);                                    

                                    }
                                }


                            });
                        }
                    }
                    // animation: {
                    //     duration: 1500,
                    //     onComplete : function () {
                    //         var ctx = this.chart.ctx;
                    //         ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                    //         ctx.fillStyle = "black";
                    //         ctx.textAlign = 'center';
                    //         ctx.textBaseline = 'bottom';
                            

                    //         this.data.datasets.forEach(function (dataset) {

                    //             for (var i = 0; i < dataset.data.length; i++) {

                    //                 for (var key in dataset._meta) {

                    //                     // console.log("Dataset",dataset);

                    //                     var model = dataset._meta[key].data[i]._model;
                    //                     var valor = 0;
                    //                     valor = dataset.data[i] + "%";


                                        
                    //                     // if(dataset.yAxisID == "B"){     // KILOS APROBADOS NO CONFORMES
                    //                         ctx.fillText(valor, model.x , model.y - 5);                                    
                    //                     // }
                    //                     // else if(dataset.yAxisID == "C"){ // RECHAZADOS

                    //                     //     console.log("X",model.x,"Y",model.y);
                                            
                    //                     //     // ctx.fillText(valor, model.x, 369);

                    //                     //     ctx.fillText(valor, model.x, 359);


                    //                     // }else if(dataset.yAxisID == "D"){ // OTROS
                    //                     //     ctx.fillText(valor, model.x , model.y - 5);
                    //                     // }else{
                    //                     //     ctx.fillText(valor, model.x, model.y - 5);                                    
                    //                     // }


                    //                 }
                    //             }


                    //         });
                    //     }
                    // }
                }
            });

        }
        // SET GRAFICO INDICADOR GENERAL1
        function SetGraficoIndicadorGeneral1(titulochart){

            //QUITAMOS CANVAS
            $(`#chartgeneral-1`).remove();
            $(`#chartgeneral-1-container`).append(`<canvas id='chartgeneral-1'></canvas>`);

            var ctx = document.getElementById('chartgeneral-1').getContext('2d');


            // CREAMOS CHART
            var mixedChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [
                        {
                            label: 'APROBADAS',
                            data: APROBADAS,
                            order: 1,
                            backgroundColor: 'red',
                        },
                        {
                            label: 'APROB. NO CONF',
                            data: APROBADASNOCONF,
                            type: 'line',
                            fill: false,
                            backgroundColor: 'yellow',
                            lineTension: 0,  
                            borderColor: 'yellow',
                            borderWidth: 3,
                        },
                        {
                            label: 'RECHAZADAS',
                            data: RECHAZADAS,
                            type: 'line',
                            fill: false,
                            backgroundColor: '#000',
                            lineTension: 0,  
                            borderColor: '#000',
                            borderWidth: 3,
                        },
                    ],
                    labels: TITULOS
                },
                options: {
                    maintainAspectRatio: false,
                    // legend: {

                    // },
                    title:{
                        display : true,
                        text : titulochart
                    },
                    // scales: {
                    //     yAxes: [
                    //         {
                    //             id: 'A',
                    //             type: 'linear',
                    //             position: 'left',
                    //             ticks: {
                    //                 min: 0,
                    //                 max: 120,
                    //                 stepSize: 1,
                    //                 display:true

                    //             },
                    //             gridLines: {
                    //                 display: true,
                    //                 drawBorder: true,
                    //                 color: ['none',CONFIINDICADOR[1].COLORFONDO,CONFIINDICADOR[2].COLORFONDO]
                    //             },
                    //             afterBuildTicks: function(humdaysChart) {
                    //                 humdaysChart.ticks = [];
                    //                 humdaysChart.ticks.push(0);
                    //                 humdaysChart.ticks.push( parseFloat(CONFIINDICADOR[0].VALORFIN) );
                    //                 humdaysChart.ticks.push( parseFloat(CONFIINDICADOR[1].VALORFIN) );
                    //                 humdaysChart.ticks.push(100);
                    //             }
                    //         },
                    //         {
                    //             id: 'B',
                    //             type: 'linear',
                    //             position: 'right',
                    //             ticks: {
                    //                 min: 0,
                    //                 max: 120,
                    //                 display:false
                    //             },
                    //             gridLines: {
                    //                 display: false
                    //             }
                    //         },
                    //     ]
                    // },
                    tooltips: {
                        enabled: false,
                    },
                    legend:{
                        display:  true,
                        position: 'bottom',
                        labels:{
                            usePointStyle: true
                        }
                    },
                    plugins: {
                        datalabels: {
                            color: 'black',
                            font:{
                                weight:'bold'
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        onComplete : function () {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            

                            this.data.datasets.forEach(function (dataset) {

                                for (var i = 0; i < dataset.data.length; i++) {

                                    for (var key in dataset._meta) {

                                        // console.log("Dataset",dataset);

                                        var model = dataset._meta[key].data[i]._model;
                                        var valor = 0;
                                        valor = dataset.data[i]; //+ "%";
                                        ctx.fillText(valor, model.x , model.y - 5);                                    

                                    }
                                }


                            });
                        }
                    }
                    // animation: {
                    //     duration: 1500,
                    //     onComplete : function () {
                    //         var ctx = this.chart.ctx;
                    //         ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                    //         ctx.fillStyle = "black";
                    //         ctx.textAlign = 'center';
                    //         ctx.textBaseline = 'bottom';
                            

                    //         this.data.datasets.forEach(function (dataset) {

                    //             for (var i = 0; i < dataset.data.length; i++) {

                    //                 for (var key in dataset._meta) {

                    //                     // console.log("Dataset",dataset);

                    //                     var model = dataset._meta[key].data[i]._model;
                    //                     var valor = 0;
                    //                     valor = dataset.data[i] + "%";


                                        
                    //                     // if(dataset.yAxisID == "B"){     // KILOS APROBADOS NO CONFORMES
                    //                         ctx.fillText(valor, model.x , model.y - 5);                                    
                    //                     // }
                    //                     // else if(dataset.yAxisID == "C"){ // RECHAZADOS

                    //                     //     console.log("X",model.x,"Y",model.y);
                                            
                    //                     //     // ctx.fillText(valor, model.x, 369);

                    //                     //     ctx.fillText(valor, model.x, 359);


                    //                     // }else if(dataset.yAxisID == "D"){ // OTROS
                    //                     //     ctx.fillText(valor, model.x , model.y - 5);
                    //                     // }else{
                    //                     //     ctx.fillText(valor, model.x, model.y - 5);                                    
                    //                     // }


                    //                 }
                    //             }


                    //         });
                    //     }
                    // }
                }
            });

        }
        // SET GRAFICO INDICADOR GENERAL2
        function SetGraficoIndicadorGeneral2(titulochart){

            //QUITAMOS CANVAS
            $(`#chartgeneral-2-`).remove();
            $(`#chartgeneral-2-container`).append(`<canvas id='chartgeneral-2-'></canvas>`);

            var ctx = document.getElementById('chartgeneral-2-').getContext('2d');


            // CREAMOS CHART
            var mixedChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [
                        {
                            label: 'APROBADAS',
                            data: APROBADAS,
                            order: 1,
                            backgroundColor: 'red',
                        },
                        {
                            label: 'APROB. NO CONF',
                            data: APROBADASNOCONF,
                            type: 'line',
                            fill: false,
                            backgroundColor: 'yellow',
                            lineTension: 0,  
                            borderColor: 'yellow',
                            borderWidth: 3,
                        },
                        {
                            label: 'RECHAZADAS',
                            data: RECHAZADAS,
                            type: 'line',
                            fill: false,
                            backgroundColor: '#000',
                            lineTension: 0,  
                            borderColor: '#000',
                            borderWidth: 3,
                        },
                    ],
                    labels: TITULOS
                },
                options: {
                    maintainAspectRatio: false,
                    // legend: {

                    // },
                    title:{
                        display : true,
                        text : titulochart
                    },
                    
                    tooltips: {
                        enabled: false,
                    },
                    legend:{
                        display:  true,
                        position: 'bottom',
                        labels:{
                            usePointStyle: true
                        }
                    },
                    plugins: {
                        datalabels: {
                            color: 'black',
                            font:{
                                weight:'bold'
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        onComplete : function () {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            

                            this.data.datasets.forEach(function (dataset) {

                                for (var i = 0; i < dataset.data.length; i++) {

                                    for (var key in dataset._meta) {

                                        // console.log("Dataset",dataset);

                                        var model = dataset._meta[key].data[i]._model;
                                        var valor = 0;
                                        valor = dataset.data[i]; //+ "%";
                                        ctx.fillText(valor, model.x , model.y - 5);                                    

                                    }
                                }


                            });
                        }
                    }
                    
                }
            });

        }
        // SET GRAFICO INDICADOR GENERAL3
        function SetGraficoIndicadorGeneral3(titulochart){

            //QUITAMOS CANVAS
            $(`#chartgeneral-3`).remove();
            $(`#chartgeneral-3-container`).append(`<canvas id='chartgeneral-3'></canvas>`);

            var ctx = document.getElementById('chartgeneral-3').getContext('2d');


            // CREAMOS CHART
            var mixedChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [
                        {
                            label: 'APROBADAS',
                            data: APROBADAS,
                            order: 1,
                            backgroundColor: 'red',
                        },
                        {
                            label: 'APROB. NO CONF',
                            data: APROBADASNOCONF,
                            type: 'line',
                            fill: false,
                            backgroundColor: 'yellow',
                            lineTension: 0,  
                            borderColor: 'yellow',
                            borderWidth: 3,
                        },
                        {
                            label: 'RECHAZADAS',
                            data: RECHAZADAS,
                            type: 'line',
                            fill: false,
                            backgroundColor: '#000',
                            lineTension: 0,  
                            borderColor: '#000',
                            borderWidth: 3,
                        },
                    ],
                    labels: TITULOS
                },
                options: {
                    maintainAspectRatio: false,
                    // legend: {

                    // },
                    title:{
                        display : true,
                        text : titulochart
                    },
  
                    tooltips: {
                        enabled: false,
                    },
                    legend:{
                        display:  true,
                        position: 'bottom',
                        labels:{
                            usePointStyle: true
                        }
                    },
                    plugins: {
                        datalabels: {
                            color: 'black',
                            font:{
                                weight:'bold'
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        onComplete : function () {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            

                            this.data.datasets.forEach(function (dataset) {

                                for (var i = 0; i < dataset.data.length; i++) {

                                    for (var key in dataset._meta) {

                                        // console.log("Dataset",dataset);

                                        var model = dataset._meta[key].data[i]._model;
                                        var valor = 0;
                                        valor = dataset.data[i]; //+ "%";
                                        ctx.fillText(valor, model.x , model.y - 5);                                    

                                    }
                                }


                            });
                        }
                    }

                }
            });

        }
        
        // ARMAMOS NUEVO INDICADOR 
        async function SetIndicadorToneladas2(filtro3){
            // PRUEBA NUEVO INDICADOR
            // console.log('HOLA MUNDO NUEVO');

            let data = await get("auditex-tela","indicadores","get-data-indicadores-defectos-toneladas",{
                filtro3,
                proveedor:      $("#cboproveedor").val(),
                cliente:        $("#cbocliente").val(),
                programa:       $("#cboprograma").val(),
                telas:          $("#cbotelas").val(),
                color:          $("#cbocolor").val(),
                fechainicio:    $("#txtfechainicio").val(),
                fechafin:       $("#txtfechafin").val()
            });

            console.log('HOLA MUNDO NUEVO',data);

        }
    </script>

</body>

</html>