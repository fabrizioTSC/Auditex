<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';


    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }


    $_SESSION['navbar'] = "Auditex Rep Rango De Fechas";

    $fechahoy = date("Y-m-d");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?=  $_SESSION['navbar']; ?> </title>
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

</head>

<body>
    <div class="loader"></div>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>

    <!--  -->
    <div class="container mt-3">

        <form id="frmbusqueda" action="" autocomplete="off"  class="row justify-content-md-center">


            <div class="col-md-3">
                <label class="text-white">Fecha Inicio</label>
                <input type="date" class="form-control form-control-sm" id="txtfechaInicio" value="<?= $fechahoy; ?>" required>
            </div>

            <div class="col-md-3">
                <label class="text-white">Fecha Fin</label>
                <input type="date" class="form-control form-control-sm" id="txtfechaFin" value="<?= $fechahoy; ?>"  required>
            </div>
            <div class="col-md-3">
                <label class="text-white">&nbsp;</label>
                <button class="btn btn-block btn-sm btn-secondary" type="submit" >
                    Buscar
                </button>
            </div>
            <div class="col-md-3">
                <label class="text-white">&nbsp;</label>
                <a class="btn btn-block btn-sm btn-danger" href="./pdfhumedadfechas.report.php" target="_blank" >
                    Exporta PDF
                    <i class="fas fa-file-pdf"></i>
                </a>
            </div>


        </form>

        <div class="bg-white mt-2">

            <table class="table table-sm table-bordered ">
                <thead class="thead-light text-center">
                    <tr>
                        <th class="border-table">Ficha</th>
                        <th class="border-table">Pedido</th>
                        <th class="border-table">Color</th>
                        <th class="border-table">Prenda</th>
                        <th class="border-table">Fecha</th>
                    </tr>
                </thead>
                <tbody id="tbodyreporte">
                    
                </tbody>
            </table>

        </div>


        
    </div>



    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>

    <script>

        let frmbusqueda = document.getElementById("frmbusqueda");

        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
            BuscarRegistros();
        });

        // ENVIAMOS DATOS
        frmbusqueda.addEventListener('submit',(e)=>{

            e.preventDefault();
            // MostrarCarga();
            BuscarRegistros();

        })


        function BuscarRegistros(){

            let fechainicio = $("#txtfechaInicio").val();
            let fechafin = $("#txtfechaFin").val();


            post("auditex-acabados", "reportehumedad", "getreportehumedadfechas",
                [ fechainicio ,fechafin]
            ).then(response => {

                // console.log("response",response);
                let tr = "";
                for(let item of response){

                    tr += `
                        <tr>
                            <td> ${item.CODFIC} </td>
                            <td> ${item.PEDIDO} </td>
                            <td> ${item.DSCCOL} </td>
                            <td> ${item.DESPRE} </td>
                            <td> ${item.FECFINAUD} </td>
                        </tr>
                    `;

                }

                $("#tbodyreporte").html(tr);

            }).catch(error => {

            });


        }

    </script>


</body>

</html>