<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';


    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    // $objModelo = new CoreModelo();

    $_SESSION['navbar'] = "Modificar Medidas Auditables - Acabados";



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
    </style>

    <!-- <link rel="stylesheet" href="../../css/encogimientocorte/molde.css"> -->

</head>

<body>
    <div class="loader"></div>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>

    <!--  -->
    <div class="container-fluid mt-3">

    


        <form id="frmbusqueda"  autocomplete="off"  class="row">
            
            <label for="" class="col col-md-2 text-white font-weight-bold ">ESTILO TSC:</label>
            <div class="col-md-2">
                <input type="text" class="form-control form-control-sm" id="txtestilo" autofocus required>
            </div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-block btn-secondary" type="submit">BUSCAR</button>
            </div>
            <label for="" class="col col-md-3 text-white font-weight-bold " id="lblestilocliente">ESTILO CLIENTE:</label>
            <label for="" class="col col-md-3 text-white font-weight-bold " id="lblcliente">CLIENTE:</label>


            <!-- <div class="col-md-2">
                <input type="text" class="form-control form-control-sm" id="txtestilo" autofocus required>
            </div> -->

        </form>

        <div class="table-responsive mt-2 bg-white" style="max-height:75vh">

            <table class="table table-bordered table-sm text-center m-0">
                <thead class="thead-sistema-2">
                    <tr>
                        <th>CODIGO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>AUDITABLE</th>
                    </tr>
                </thead>
                <tbody id="tbodymedidas">

                </tbody>
            </table>

        </div>

        <div class="row justify-content-center mt-2">
            <div class="col-md-2">
                <button class="btn btn-block btn-sm btn-secondary font-weight-bold" type="button" id="btnguardar">GUARDAR</button>
            </div>
        </div>


        
    </div>


        


    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>

    <script>

        let frmbusqueda = document.getElementById("frmbusqueda");

        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", () => {

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });

        // ENVIAMOS DATOS
        frmbusqueda.addEventListener('submit',(e)=>{

            e.preventDefault();
            getMedidas();

        })

        // OBTENEMOS LAS MEDIDAS
        function getMedidas(){

            let estilotsc = document.getElementById("txtestilo").value.trim();

            $(".loader").fadeIn();

            get("auditex-acabados", "medidasauditables", "getmedidas", {
                estilotsc
                // opcion:1,
                // idficha,
                // ficha,
                // parte,
                // numvez,
                // cantficha:cantidad,
                // cantpartir:cantidad,
                // usuario

            }).then(response => {

                // console.log(response);

                let tr = "";

                if(response.length > 0 ){


                    // <label for="" class="col col-md-3 text-white font-weight-bold " id="lblestilocliente">ESTILO CLIENTE:</label>
                    // <label for="" class="col col-md-3 text-white font-weight-bold " id="lblcliente">CLIENTE:</label>

                    $("#lblestilocliente").text("ESTILO CLIENTE: " + response[0].ESTCLI);
                    $("#lblcliente").text("CLIENTE: " + response[0].DESCLI );


                    for(let item of response){

                        // let check = <input type="checkbox" data-clicked="0" class="check-save" data-codmed="2">
                        let check = item.AUDITABLE == "A" ? " checked='true' " : "";
                        // console.log(item.CRITICA);
                        tr += `

                            <tr>

                                <td>${item.CODMED}</td>
                                <td>${item.DESMED}</td>
                                <td>
                                    <input type="checkbox" ${check} class='checksauditables' data-codigo='${item.CODMED}' data-estilotsc='${item.ESTTSC}'  >
                                </td>

                            </tr>

                        `;

                    }

                    $("#tbodymedidas").html(tr);
                    $(".loader").fadeOut("slow");

                }else{

                    $(".loader").fadeOut("slow");

                    Advertir("No se cargaron medidas auditables para este estilo");
                }

                


                // window.location = `registropanio.view.php?ficha=${ficha}&id=${response.ID}`;

            }).catch(error => {

            });

        }



        $("#btnguardar").click(async function(){

            let checks = $(".checksauditables");
            // console.log(checks);

            $(".loader").fadeIn();


            for(let item of checks){

                let codigomedida    = $(item).data("codigo");
                let estilotsc       = $(item).data("estilotsc");
                let check           = $(item).prop("checked") ? "A" : null;


                // console.log(codigomedida,estilotsc,check);

                let response = await post("auditex-acabados","medidasauditables","setmedidas",[2,estilotsc,codigomedida,check]);  
                // console.log(response);

            }


            $(".loader").fadeOut("slow");
            Informar("Realizado Correctamente",1500);


        });

    </script>


</body>

</html>