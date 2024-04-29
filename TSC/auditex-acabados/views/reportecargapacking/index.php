<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';



    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo = new CoreModelo();
    $_SESSION['navbar'] = "Reporte de Carga de Packing";



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Acabados</title>
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

        table{
            table-layout: fixed;
        }


        th,td{
            padding: 0 !important;
        }
        tbody{
            font-size: 12px !important;
        }
        .bg-medida-tolerancias{
            background: #e5ffc9;
        }

        label{
            color:#fff;
        }

    </style>

    <!-- <link rel="stylesheet" href="../../css/encogimientocorte/molde.css"> -->

</head>

<body>
    <div class="loader"></div>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>

    <!--  -->
    <div class="container-fluid mt-3">

    
        <!-- REPORTE GENERADO -->
                
            

        

            <?php

                $fechainicio    = isset($_POST["txtfechai"]) ? $_POST["txtfechai"] : null;
                $fechafin       = isset($_POST["txtfechaf"]) ? $_POST["txtfechaf"] : null;
                $po             = isset($_POST["txtpo"]) ? $_POST["txtpo"] : null;

                $fechainicio    = $fechainicio == "" ? null : $fechainicio;
                $fechafin       = $fechafin == "" ? null : $fechafin;
                $po             = $po == "" ? null : $po;

                $response = [];

                if($fechafin != null || $fechainicio != null || $po != null){
                    $response = $objModelo->getAll("PQ_PACKINGACABADOS_TMP.SPU_GETREPORTEPACKING",[$fechainicio,$fechafin,$po]);
                }

            ?>  


            <!-- <div class="row justify-content-center bg-white" >    -->

                <form id="frmbusqueda"  autocomplete="off"  class="row" method="POST" >

                    <input type="hidden" name="startreport">


                    <div class="col-md-3">
                        <label for="">Fecha Inicio</label>
                        <input type="date" class="form-control form-control-sm" name="txtfechai" value="<?= $fechainicio ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="">Fecha Fin</label>
                        <input type="date" class="form-control form-control-sm" name="txtfechaf" value="<?= $fechafin ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="">PO</label>
                        <input type="text" class="form-control form-control-sm" name="txtpo" value="<?= $po ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-sm btn-block btn-primary" type="submit">BUSCAR</button>
                        <!-- <input type="text" class="form-control form-control-sm" name="txtfechaf"> -->
                    </div>

                </form>

                <!--  -->
                <div class="mt-2 bg-white">

                    <table class="table table-bordered table-hover table-sm text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>PEDIDO</th>
                                <th>COLOR</th>
                                <th>PO</th>
                                <th>TIPO</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>
                        <tbody> 
                    
                            <?php foreach($response as $item): ?>

                                <tr>
                                    <td><?= $item["PEDIDO"]  ?></td>
                                    <td><?= $item["DSC_COLOR"]  ?></td>
                                    <td><?= $item["PO_CLI"]  ?></td>
                                    <td><?= $item["TIPO"]  ?></td>
                                    <td><?= $item["FECHACARGA"]  ?></td>


                                    <!-- <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td> -->
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>

              

            


            <!-- </div> -->


        



        
    </div>


        


    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>

    <script>

        // const frmbusqueda = document.getElementById("frmbusqueda");                                                
        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", () => {

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });







    </script>


</body>

</html>