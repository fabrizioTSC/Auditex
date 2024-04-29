<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';



    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo  = new CoreModelo();
    $objSistema = new SistemaModelo();

    $_SESSION['navbar'] = "Auditex Lavanderia Prenda - Apertura de Items";

    $datareporte = [];
    $txtficha  = null;
    // $txtfechaf  = null;


    if(isset($_GET["operacion"])){

        $txtficha = isset($_GET["txtficha"]) ? $_GET["txtficha"] : null;
        // $txtfechaf = isset($_GET["txtfechaf"]) ? $_GET["txtfechaf"] : null;


        $datareporte = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETAPERTURA_FICHAS",[1,$txtficha]);
        // $_SESSION["data_reporte_auditor_lavanderia_prendas"] = $datareporte;

        

    }





?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Lavanderia Prenda - Apertura de Items</title>
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


                <form class="row mb-2" id="frmreporte" method="GET">

                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <label for="">Ficha:</label>
                        <input type="number" name="txtficha"  class="form-control form-control-sm" id="txtficha" value="<?= $txtficha; ?>" required autofocus>

                        <input type="hidden" name="operacion" value="true">

                    </div>
                    
                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-sm btn-block btn-sistema" type="submit" id="btnbuscar">Buscar</button>
                    </div>


                </form>



        <!-- CABECERA -->
        <div class="table-responsive">

            <table class="table table-bordered table-sm  text-center m-0 table-fichas">
                <thead class="thead-sistema-new">
                    <tr class="thead-fichas">
                        <th class="w-bajo align-vertical"   rowspan="2">FICHA</th>
                        <th class="w-bajo-2 align-vertical" rowspan="2">PARTE</th>
                        <th class="w-bajo-2 align-vertical" rowspan="2">VEZ</th>
                        <th class="w-bajo-2 align-vertical" rowspan="2">CANTIDAD</th>

                        <th class="w-bajo align-vertical"   colspan="3">      ESTADO VALIDACIÓN DOCUMENTACIÓN</th>
                        <th class="w-bajo-2 align-vertical" colspan="3">    ESTADO DEFECTOS</th>
                        <th class="w-bajo align-vertical"   colspan="3">      ESTADO MEDIDAS</th>
                        <th class="w-bajo align-vertical"   colspan="3">      ESTADO FINAL</th>
                    </tr>

                    <tr>
                        <th>USUARIO</th>
                        <th>FECHA</th>
                        <th>ESTADO</th>


                        <th>USUARIO</th>
                        <th>FECHA</th>
                        <th>ESTADO</th>


                        <th>USUARIO</th>
                        <th>FECHA</th>
                        <th>ESTADO</th>


                        <th>USUARIO</th>
                        <th>FECHA</th>
                        <th>ESTADO</th>

                    </tr>
                </thead>
                <tbody class="bg-white">

                    <?php foreach($datareporte as $fila): ?>


                        <?php 

                                $fechaitem1 = $fila["FECHA_ITEM1"] != "" ? date("d/m/Y", strtotime($fila['FECHA_ITEM1'])) : "";
                                $fechaitem2 = $fila["FECHA_ITEM2"] != "" ? date("d/m/Y", strtotime($fila['FECHA_ITEM2'])) : "";
                                $fechaitem3 = $fila["FECHA_ITEM3"] != "" ? date("d/m/Y", strtotime($fila['FECHA_ITEM3'])) : "";


                                $fechacierre = $fila["FECHACIERRE"] != "" ? date("d/m/Y", strtotime($fila['FECHACIERRE'])) : "";



                        ?>

                        <tr>
                            <td> <?= $fila["FICHA"]; ?> </td>
                            <td> <?= $fila["PARTE"]; ?> </td>
                            <td> <?= $fila["NUMVEZ"]; ?> </td>
                            <td> <?= $fila["CANTIDAD"]; ?> </td>



                            <td> <?= $fila["USUARIO_ITEM1"]; ?> </td>
                            <td> <?= $fechaitem1; ?> </td>
                            <td> 

                                <?php if($fila["ESTADO_ITEM1"]  != ""): ?>

                                    <button class="btn btn-sm btn-sistema p-0" type="button" onclick="setApertura(1,<?= $fila['IDFICHA']; ?> )">
                                        <?= $fila["ESTADO_ITEM1"]; ?> 
                                    </button>

                                <?php endif; ?>

                            </td>



                            <td> <?= $fila["USUARIO_ITEM2"]; ?> </td>
                            <td> <?= $fechaitem2; ?> </td>
                            <td>

                                <?php if($fila["ESTADO_ITEM2"]  != ""): ?>

                                    <button class="btn btn-sm btn-sistema p-0" type="button" onclick="setApertura(2,<?= $fila['IDFICHA']; ?> )">
                                        <?= $fila["ESTADO_ITEM2"]; ?> 
                                    </button>
                                    
                                <?php endif; ?>

                            </td>



                            <td> <?= $fila["USUARIO_ITEM3"]; ?> </td>
                            <td> <?= $fechaitem3; ?> </td>
                            <td> 

                                <?php if($fila["ESTADO_ITEM3"]  != ""): ?>

                                    <button class="btn btn-sm btn-sistema p-0" type="button" onclick="setApertura(3,<?= $fila['IDFICHA']; ?> )">
                                        <?= $fila["ESTADO_ITEM3"]; ?> 
                                    </button>

                                <?php endif; ?>

                            </td>



                            <td> <?= $fila["USUARIOCIERRE"]; ?> </td>
                            <td> <?= $fechacierre; ?> </td>
                            <td> 
                                <?= $fila["ESTADO"]; ?> 
                            </td>




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



        });

        // PREGUNTAMOS
        function setApertura(opcion,idficha){

            Preguntar("Confirme para aperturar")
                .then(response => {
                    
                    if(response.value){

                        MostrarCarga();

                        post("auditex-lavanderia","lavadoprenda","set-apertura",[opcion,idficha])
                            .then(response => {

                                if(response.success){
                                    location.reload();
                                }else{
                                    Advertir(response.rpt);
                                }

                                // console.log(response);
                                
                            })
                            .catch(error => {   
                                Advertir("Ocurrio un error");
                            });

                    }

                }).catch(error =>{

                });

        }

    </script>

</body>

</html>