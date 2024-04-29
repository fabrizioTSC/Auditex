<?php

    // require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    // require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';



    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    // $objModelo  = new CoreModelo();
    // $objSistema = new SistemaModelo();

    $_SESSION['navbar'] = "Auditex Lavanderia Paño - Reporte General";




?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Lavanderia Prenda - Reporte General</title>
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
            font-size: 13px !important;
        }

        .table-fichas > tbody{
            font-size: 11px !important;
        }

        .table-fichas > td{
            padding: 0px !important;
        }

        .thead-fichas .w-bajo{
            width: 55px !important;
            overflow: auto;
        }

        /* .thead-fichas .{
            width: 70px !important;
            overflow: auto;
        } */

        /* .thead-fichas .{
            width: 90px !important;
            overflow: auto;
        } */

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




    <div class="container-fluid mt-3">

        <!-- FILTROS -->


        <form class="row mb-2" id="frmbusqueda" autocomplete="off">  


            <div class="col-md-2">
                <label for="">Fecha Inicio</label>
                <input type="date" class="form-control form-control-sm" id="txtfechai" name="txtfechai">
            </div>

            <div class="col-md-2">
                <label for="">Fecha Fin</label>
                <input type="date" class="form-control form-control-sm" id="txtfechaf" name="txtfechaf">
            </div>

            <div class="col-md-2">
                <label for="">Sede</label>
                <select name="cbosede" id="cbosede" style="width: 100%;" class="custom-select custom-select-sm select2"></select>
            </div>

            <div class="col-md-2">
                <label for="">Tipo Servicio</label>
                <select name="cbotiposervicio" id="cbotiposervicio" style="width: 100%;" class="custom-select custom-select-sm select2"></select>
            </div>

            <div class="col-md-4">
                <label for="">Taller - Maquina</label>
                <select name="cbotaller" id="cbotaller" style="width: 100%;" class="custom-select custom-select-sm select2" ></select>
            </div>

            <div class="col-md-2">
                <label for="">&nbsp;</label>
                <button class="btn btn-sm btn-block btn-secondary font-weight-bold"" type="submit" >BUSCAR</button>
            </div>


            <div class="col-md-2">
                <label for="">&nbsp;</label>
                <!-- <button class="btn btn-sm btn-block btn-success" type="button" id="btnexportar">EXPORTAR</button> -->
                <a class="btn btn-sm btn-block btn-success font-weight-bold" target="_blank" href="../../../controllers/auditex-lavanderia/lavadopanio.controller.php?operacion=get-report-general" id="btnexportar">EXPORTAR</a>

            </div>

        </form>



        <!-- CABECERA -->
        <div class="table-responsive">

            <table class="table table-bordered table-sm  text-center m-0 table-fichas">
                <thead class="thead-sistema-new">
                    <tr class="thead-fichas">
                        <th class="align-vertical"  nowrap>FICHA</th>
                        <th class=" align-vertical" nowrap>CLIENTE</th>
                        <th class=" align-vertical" nowrap>PEDIDO</th>
                        <th class=" align-vertical" nowrap>EST. CLIENTE</th>
                        <th class="align-vertical"  nowrap>EST. TSC</th>
                        <th class=" align-vertical" nowrap>PARTIDA</th>
                        <th class="align-vertical" nowrap>COLOR</th>
                        <th class="align-vertical" nowrap>PARTE</th>
                        <th class="align-vertical" nowrap>VEZ</th>
                        <th class=" align-vertical" nowrap>USUARIO</th>
                        <th class="align-vertical" nowrap>FECHA</th>
                        <th class="align-vertical" nowrap>CANT FICHA</th>
                        <th class="align-vertical" nowrap>CANT PARTE</th>
                        <th class=" align-vertical" nowrap>CANT MUESTRA</th>
                        <th class=" align-vertical" nowrap>RESULTADO</th>
                        <th class=" align-vertical" nowrap>DEFECTOS</th>
                        <th class=" align-vertical" nowrap>CAN. DEFECTOS</th>
                        <th class=" align-vertical" nowrap>C. MAX DEFECTOS</th>
                        <th class=" align-vertical" nowrap>COD DEFECTOS</th>
                        <th class=" align-vertical" nowrap>TIPO DE SERVICIO</th>
                        <th class=" align-vertical" nowrap>MAQUINA/TALLER</th>
                        <th class=" align-vertical" nowrap>TALLER DE COSTURA</th>
                    </tr>
                </thead>
                <tbody class="bg-white" id="tbodyreporte">

                   

                </tbody>
            </table>

        </div>        


    </div>

    
    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>


    <script>

        const frmbusqueda = document.getElementById("frmbusqueda");

        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {


            $(".changescombos").change(function(){
                getTallerMaquina();
            }); 

            await getSedes();
            await getTipoServicios();

            getTallerMaquina();


            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });


        // GET SEDES
        async function getSedes(){

            let response = await get("auditex-generales","generales","getsedes",{ });
            setComboSimple("cbosede",response,"DESSEDE","CODSEDE",true,false,"TODOS");
            // console.log(response);
        }

        // GET SEDES
        async function getTipoServicios(){

            let response = await get("auditex-generales","generales","gettiposervicios",{ });
            setComboSimple("cbotiposervicio",response,"DESTIPSERV","CODTIPSERV",true,false,"TODOS");
        }

        // GET TALLER O MAQUINA
        function getTallerMaquina(){

            let idsede          = $("#cbosede").val() == "" ? null : $("#cbosede").val();
            let tiposervicio    = $("#cbotiposervicio").val() == "" ? null : $("#cbotiposervicio").val();

            // if(tiposervicio != null){
                MostrarCarga();
                get("auditex-lavanderia","lavadoprenda","get-taller-maquina",{ idsede,tiposervicio})
                .then(response =>{

                    setComboSimple("cbotaller",response,"DESCRIPCION","ID",true,false,"TODOS");
                    OcultarCarga();
                })
                .catch(error => {
                    Advertir("Error en ajax");
                });
                
            // }else{
            //     $("#cbotaller").html("<option value=''>[TODOS]</option>");
            // }

            


        }

        // BUSQUEDA
        frmbusqueda.addEventListener('submit',(e)=>{
            
            e.preventDefault();
            MostrarCarga();
            let filtros = {
                fechai: $("#txtfechai").val(),
                fechaf: $("#txtfechaf").val(),
                sede:  $("#cbosede").val(),
                tiposervicio:  $("#cbotiposervicio").val(),
                taller:  $("#cbotaller").val()
            }

            let tr = "";

            get("auditex-lavanderia","lavadopanio","getreportegeneral",filtros)
                .then(response =>{
                    
                    if(response){

                        
                        for(let fila of response){
                            
                            tr +=  `

                                <tr >


                                    <td class="w-bajo" nowrap> ${fila["CODFIC"]}  </td>
                                    <td class="" nowrap> ${fila["DESCLI"]} </td>
                                    <td class="" nowrap> ${fila["PEDIDO"]} </td>
                                    <td class="" nowrap> ${fila["ESTCLI"]} </td>
                                    <td class="w-bajo" nowrap>  ${fila["ESTTSC"]} </td>
                                    <td class="" nowrap> ${fila["PARTIDA"]} </td>
                                    <td class="w-bajo" nowrap>  ${fila["COLOR"]} </td>
                                    <td class="w-bajo" nowrap>  ${fila["PARTE"]} </td>
                                    <td class="w-bajo" nowrap>  ${fila["NUMVEZ"]}  </td>
                                    <td class="" nowrap>  ${fila["USUARIOCIERRE"]}  </td>
                                    <td class="w-bajo" nowrap>  ${fila["FECHACIERRE"]} </td>
                                    <td class="w-bajo" nowrap> ${fila["CANTOTALFICHA"]} </td>
                                    <td class="w-bajo" nowrap>  ${fila["CANTIDADPARTIDA"]} </td>
                                    <td class="" nowrap>  ${fila["SAMPLESIZE"]} </td>
                                    <td class="" nowrap>  ${fila["RESULTADOFINAL"]} </td>
                                    <td class="" nowrap>  ${fila["DES_DEFECTOS"]} </td>
                                    <td class="w-bajo-4" nowrap>  ${fila["CAN_DEFECTOS"]} </td>
                                    <td class="w-bajo-4" nowrap>  ${fila["RECHAZADO"]} </td>
                                    <td class="" nowrap>  ${fila["COD_DEFECTOS"]} </td>
                                    <td class="" nowrap> ${fila["TIPO"]}  </td>
                                    <td class="" nowrap> ${fila["MAQUINATALLER"]}  </td>
                                    <td class="" nowrap>  ${fila["TALLERCOSTURA"]} </td>

                                </tr>

                            `;

                        }

                        $("#tbodyreporte").html(tr);
                        OcultarCarga();

                    }else{
                        Advertir("Error obteniendo datos de reporte");
                    }

                })
                .catch(error => {
                    Advertir("Error en ajax");
                });
            // console.log();


        });

    </script>

</body>

</html>