<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';



    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo = new CoreModelo();
    $objSistema = new SistemaModelo();
    $_SESSION['navbar'] = "Reporte de Medidas Finales - Interna";



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Interna</title>
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

        /* table{
            table-layout: fixed;
        } */


        th,td{
            padding: 0 !important;
            vertical-align: middle !important;
        }
        thead{
            font-size: 12px ;
        }
        tbody{
            font-size: 11px ;
        }
        .bg-medida-tolerancias{
            background: #e5ffc9;
        }

        .bg-critica{
            background: #ffff82 !important;
        }

        .bg-prendas{
            background: #e1e1e1;
        }

        .bg-thead{
            background:#99ff99 ;
        } 

        /* .table-reporte{
            table-layout: fixed;
        }*/

        .container-table{
            max-height: 470px !important;
            overflow-x: hidden;
        }

        .div1{
            width: 590px;
        }

        .div2{
            width: calc( 100% - 590px);
        }

        .vertical-align{
            vertical-align: middle !important;
        }


        #table-header{
            overflow-x: auto !important;
        }

        #table-body{
            overflow-x: hidden !important;
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
        <?php if(!isset($_POST["startreport"])): ?>
                
                <form id="frmbusqueda"  autocomplete="off"  class="row">
                    
                    <!-- <label for="" class="col col-md-2 text-white font-weight-bold ">ESTILO TSC:</label> -->
                    <div class="col-md-3">
                        <select name="" id="cbotipoestilo" class="custom-select custom-select-sm">
                            <option value="8">ESTILO TSC</option>  
                            <option value="9">ESTILO CLIENTE</option>  
                        </select>
                        <!-- <input type="text" class="form-control form-control-sm" id="txtestilo" autofocus required> -->
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" id="txtestilo" autofocus required>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-sm btn-block btn-secondary" type="submit">BUSCAR</button>
                    </div>
    
                </form>
    
                <form action="" id="frmfichas" method="POST" class="row justify-content-center d-none" >
    
                    <div class="col-md-12">
                        <label for="" class="text-white">PEDIDO/COLOR</label>
                        <select name="fichas" id="cbofichas" class="custom-select custom-select-sm select2"   style="width: 100%;"></select>
                    </div>
    
                    <input type="hidden" name="startreport">
                    <input type="hidden" name="estilotsc" id="txtestilotsc">
                    <input type="hidden" name="estilocli" id="txtestilocli">
                    <input type="hidden" name="cliente" id="txtcliente">
                    <!-- <input type="hidden" name="opcion"  id="txtopcion"> -->
    
    
                    <div class="col-md-3">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-sm btn-block btn-secondary" type="submit">EJECUTAR REPORTE</button>
                    </div>
    
                </form>
    
            
        <?php else: ?>

            <?php

                $pedido = $_POST["fichas"];

                $estilotsc  = $_POST["estilotsc"];
                $estilocli  = $_POST["estilocli"];
                $cliente    = $_POST["cliente"];


                // $opcion = $_POST["opcion"];

                $color = "";

                // obtenemos los estilos
                // $ESTILOS =  $objModelo->get("AUDITEX.PQ_MEDIDAS.SPU_GETESTILOS",[$opcion,$estilo]);
                // $estilotsc = $ESTILOS["ESTTSC"];
                // $estilocli = $ESTILOS["ESTCLI"];


                $data           = $objModelo->getAll("AUDITEX.PQ_MEDIDAS.SPU_GETREPORTEMEDIDASFINALES",[1,$pedido,$color,$estilotsc]);
                $numpre         = $objModelo->get("AUDITEX.PQ_MEDIDAS.SPU_GETREPORTEMEDIDASFINALES",[2,$pedido,$color,$estilotsc]);
                $datamedidas    = $objModelo->getAll("AUDITEX.PQ_MEDIDAS.SPU_GETREPORTEMEDIDASFINALES",[3,$pedido,$color,$estilotsc]);

                echo $pedido ." - ". $color ." - ". $estilotsc;
                // var_dump($data);

                $_SESSION["data_reportefinal"] = $data;
                $_SESSION["numpre_reportefinal"] = $numpre;
                $_SESSION["datamedidas_reportefinal"] = $datamedidas;


                $arraynumpre = [];
                for($i = 1; $i <= $numpre["NUMPRE"]; $i++){
                    $arraynumpre[] = $i;
                }

                $columnas = array_keys($data[0]);
                
                // var_dump($data);
            ?>

            <label class="text-white">Estilo TSC: <?= $estilotsc?> </label>  /
            <label class="text-white">Estilo Cliente: <?= $estilocli?> </label>  /
            <label class="text-white">Cliente: <?= $cliente?> </label>  <br>
            <label class="text-white">Pedido / Color: <?= $pedido?> </label>  
                
            
            <div class="table-responsive container-table ">

                <!-- PRIMERA THEAD -->
                <div class="div1 float-left sticky-top">

                    <table class="table table-sm table-bordered bg-white text-center table-reporte mb-0 ">
                        <thead class="bg-thead">
                            <tr height="40">

                                <?php  foreach($columnas as $columna): ?>

                                    <?php
                                        $with = 70;
                                        $newcolumn = str_replace("'","",$columna);

                                        if($newcolumn == "COD"){
                                            $with = 30;
                                        }

                                        if($newcolumn == "DESCRIPCIÓN"){
                                            $with = 360;
                                        }

                                        if($newcolumn == "CRITICA"){
                                            $with = 60;
                                        }

                                    ?>

                                    <th class="border-table" style="max-width: <?= $with  ?>px;min-width: <?= $with  ?>px">
                                        <?= $newcolumn ?>
                                    </th>

                                    <?php
                                        if($newcolumn == "TOL(-)"){
                                            // $with = 60;
                                            break;
                                        }
                                    ?>

                                <?php endforeach; ?>

                            </tr>
                        </thead>
                    </table>
                
                </div>

                <!-- SEGUNDO THEAD -->
                <div class="div2 float-left sticky-top" id="table-header">

                    <table class="table table-sm table-bordered bg-white text-center table-reporte mb-0 ">
                        <thead class="bg-thead">
                            <tr height="40">

                                <?php  foreach($columnas as $columna): ?>

                                    <?php
                                        $with = 70;
                                        $newcolumn = str_replace("'","",$columna);

                                    ?>

                                    <?php if($newcolumn != "COD" && $newcolumn != "DESCRIPCIÓN" && $newcolumn != "CRITICA" && $newcolumn != "TOL(+)" && $newcolumn != "TOL(-)" ): ?>

                                        <th class="border-table" style="max-width: <?= $with  ?>px;min-width: <?= $with  ?>px">
                                            <?= $newcolumn ?>
                                        </th>

                                        <!-- PRENDAS -->
                                        <?php  foreach($arraynumpre as $pren): ?>
                                            <th  style="max-width: 30px;min-width: 30px" class="border-table" >
                                                <?= $pren ?>
                                            </th>
                                        <?php endforeach; ?>


                                    <?php endif; ?>

                                    

                                <?php endforeach; ?>

                            </tr>
                        </thead>
                    </table>

                </div>

                <!-- PRIMER CUERPO -->
                <div class="div1 float-left">

                    <table class="table table-sm table-bordered bg-white text-center table-reporte">
                        <tbody >
                            <?php  foreach($data as $fila): ?>

                                <?php  $bg = $fila["CRITICA"] == "CRITICA" ? "bg-critica" : ""; ?>

                                

                                <tr class="<?= $bg ?>" height="40">

                                    <?php  foreach($columnas as $columna): ?>

                                        <?php
                                                $with = 70;
                                                $fontsize = "11px";
                                                $newcolumn = str_replace("'","",$columna);

                                                if($newcolumn == "COD"){
                                                    $with = 30;
                                                }

                                                if($newcolumn == "DESCRIPCIÓN"){
                                                    $with = 360;
                                                    $fontsize = "10px";
                                                }

                                                if($newcolumn == "CRITICA"){
                                                    $with = 60;
                                                }

                                        ?>


                                        <?php
                                            if($columna != "COD" && $columna != "DESCRIPCIÓN" && $columna != "CRITICA" && $columna != "TOL(+)" && $columna != "TOL(-)"){
                                                break;
                                            }
                                        ?>

                                        <td style="max-width: <?= $with  ?>px;min-width: <?= $with  ?>px;font-size:<?= $fontsize; ?>">
                                            <?= $fila[$columna]  ?>
                                        </td>

                                    <?php endforeach; ?>

                                </tr>
                            

                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>

                <!-- SEGUNDO CUERPO -->
                <div class="div2 float-left" id="table-body">
                    
                    <table class="table table-sm table-bordered bg-white text-center table-reporte">
                        <tbody>
                            <?php  foreach($data as $fila): ?>

                                <?php  $bg = $fila["CRITICA"] == "CRITICA" ? "bg-critica" : ""; ?>

                                

                                <tr class="<?= $bg ?>" height="40">

                                    <?php  foreach($columnas as $columna): ?>

                                        <?php
                                                $with = 70;
                                                $newcolumn = str_replace("'","",$columna);


                                        ?>

                                        <?php if($columna != "COD" && $columna != "DESCRIPCIÓN" && $columna != "CRITICA" && $columna != "TOL(+)" && $columna != "TOL(-)"): ?>


                                            <td style="max-width: <?= $with  ?>px;min-width: <?= $with  ?>px">
                                                <?= $fila[$columna]  ?>
                                            </td>

                                            <!-- PRENDAS -->
                                            <?php if($columna != "COD" && $columna != "DESCRIPCIÓN" && $columna != "CRITICA" && $columna != "TOL(+)" && $columna != "TOL(-)"): ?>

                                                <?php  foreach($arraynumpre as $pren): ?>

                                                    <?php
                                                        $newcolumn = str_replace("'","",$columna);
                                                        $datafiltrada = array_filter($datamedidas,array( new MedidasFinalesReporteFilterValor($fila["COD"],$newcolumn,$pren),"getFiltroValor"));     
                                                    ?>  

                                                    <td  style="max-width: 30px;min-width:30px" class="border-table font-weight-bold  <?= $bg == "" ? "bg-prendas" : ""  ?> "  >


                                                        <?php foreach($datafiltrada as $dt): ?>
                                                            <?= $dt["VALOR"] == "0" ? "OK" : $dt["VALOR"] ?>
                                                        <?php endforeach; ?> 

                                                    </th>

                                                <?php endforeach; ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                        

                                    <?php endforeach; ?>

                                </tr>
                            

                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>

                

            </div>

            <form action=""  method="POST" class="row justify-content-center mt-1" >

                <div class="col-md-3">
                    <!-- <label for="">&nbsp;</label> -->
                    <button class="btn btn-sm btn-block btn-secondary" type="submit">
                        <i class="fas fa-arrow-left"></i>
                        VOLVER
                    </button>
                </div>

                <div class="col-md-3">
                    <!-- <label for="">&nbsp;</label> -->
                    <a class="btn btn-sm btn-block btn-danger" href="/tsc/auditex-generales/views/medidasfinales/pdf.report.php?area=INTERNA&estilotsc=<?= $estilotsc?>&estilocli=<?= $estilocli?>&pedido=<?= $pedido ?>&cliente=<?= $cliente ?>" target="_blank">
                        <i class="fas fa-file-pdf"></i>
                        EXPORTAR
                    </a>
                </div>

            </form>


        <?php endif; ?>

    
        

    </div>


    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>

    <script>

        const frmbusqueda = document.getElementById("frmbusqueda");          
        let esttsc = "";
        let estcli = "";
        let cliente = "";
        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", () => {

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });


        if(frmbusqueda != null){

            frmbusqueda.addEventListener('submit',(e)=>{
                e.preventDefault();
                let estilo = $("#txtestilo").val();
                getFichas(estilo);


            });

        }

        function getFichas(estilotsc){

            let opcion = $("#cbotipoestilo").val();

            $("#txtestilotsc").val("");
            $("#txtestilocli").val("");
            $("#txtcliente").val("");


            esttsc = "";
            estcli = "";


            // $("#txtestilofichas").val(estilotsc);
            // $("#txtopcion").val(opcion);

            $(".loader").fadeIn();
            getsync("auditex-interna","reportedesviacion","getfichasestilo",{opcion,estilotsc},function(e){

                let response = JSON.parse(e);
                // console.log(response);
                if(response.length > 0){
                    setComboSimple("cbofichas",response,"FICHA","FICHA",true,{"ESTTSC":"ESTTSC","ESTCLI":"ESTCLI","CLIENTE":"CLIENTE"});
                    $("#frmfichas").removeClass("d-none");
                    $(".loader").fadeOut("slow");
                }else{
                    $(".loader").fadeOut("slow");
                    $("#frmfichas").addClass("d-none");
                    Advertir("El estilo no tiene fichas registradas");
                }


            });


        }

        $("#cbofichas").change(function(){

            esttsc = $(this).find(':selected').data('esttsc');
            estcli = $(this).find(':selected').data('estcli');
            cliente = $(this).find(':selected').data('cliente');


            $("#txtestilotsc").val(esttsc);
            $("#txtestilocli").val(estcli);
            $("#txtcliente").val(cliente);


        });


        <?php if(isset($_POST["startreport"])): ?>

            let card_body   =  document.querySelector('#table-body');
            let card_header =  document.querySelector('#table-header');

            card_header.addEventListener('scroll',()=>{

                let scrollLeft = card_header.scrollLeft;
                card_body.scrollLeft = scrollLeft;

            } );

        <?php endif; ?>



    </script>


</body>

</html>