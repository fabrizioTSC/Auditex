<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';


    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    // $objModelo = new CoreModelo();

    $_SESSION['navbar'] = "Auditex Lavanderia";



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Lavanderia</title>
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
    </style>

    <!-- <link rel="stylesheet" href="../../css/encogimientocorte/molde.css"> -->

</head>

<body>
    <div class="loader"></div>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>

    <!--  -->
    <div class="container mt-3">

        
        <!-- <div class="card"> -->

            <!-- <div class="card-body"> -->

                <form id="frmbusqueda" action="" autocomplete="off" method="POST" class="row justify-content-md-center">

                    <div class="col-md-8">

                        <table class="table table-sm table-bordered">
                            <thead class="text-center thead-sistema-new">
                                <tr>
                                    <th colspan="2" class="border-table">LAVADO</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr>
                                    <td class="font-weight-bold">Lavado Prenda</td>
                                    <td class="text-center">
                                        <input id="radioprenda" class="radios" type="radio" name="tipolavadao" checked>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="font-weight-bold" >Lavado Paño</td>
                                    <td class="text-center">
                                        <input id="radiopanio" class="radios" type="radio" name="tipolavadao">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    
                                </tr> -->
                            </tbody>
                        </table>


                    </div>

                    <div class="col-md-6 mt-2">
                        <button class="btn btn-sm btn-block btn-sistema font-weight-bold " type="submit" >INICIAR</button>
                    </div>

                    


                </form>

            <!-- </div> -->
        <!-- </div> -->

        
    </div>


        


    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>

    <script>

        let frmbusqueda = document.getElementById("frmbusqueda");

        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });

        // ENVIAMOS DATOS
        frmbusqueda.addEventListener('submit',(e)=>{

            e.preventDefault();

            MostrarCarga();
            // OBTENEMOS DATOS
            //let ficha           = document.getElementById("txtficha").value.trim();
            let lavadoprenda    = document.getElementById("radioprenda").checked;
            let tipo = lavadoprenda ? "prenda" : "panio";
            window.location = `registro${tipo}.view.php`;

        })

    </script>


</body>

</html>