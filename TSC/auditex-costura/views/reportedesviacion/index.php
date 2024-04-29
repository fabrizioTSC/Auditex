<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';



    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo = new CoreModelo();
    $_SESSION['navbar'] = "Reporte de Desviación de Medidas - Costura";



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Costura</title>
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
                
                <label for="" class="col col-md-2 text-white font-weight-bold ">ESTILO TSC:</label>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" id="txtestilo" autofocus required>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-block btn-secondary" type="submit">BUSCAR</button>
                </div>

            </form>

            <form action="" id="frmfichas" method="POST" class="row justify-content-center d-none" >

                <div class="col-md-12">
                    <label for="" class="text-white">FICHAS</label>
                    <select name="fichas[]" id="cbofichas" class="custom-select custom-select-sm select2" data-placeholder="[TODOS]"  multiple style="width: 100%;"></select>
                </div>

                <input type="hidden" name="startreport">
                <input type="hidden" name="estilotsc" id="txtestilofichas">


                <div class="col-md-3">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-secondary" type="submit">EJECUTAR REPORTE</button>
                </div>

            </form>

        
        <?php else: ?>

            <?php

                $fichas     = isset($_POST["fichas"]) ? implode(",",$_POST["fichas"]) : null;
                $estilotsc  = $_POST["estilotsc"];

                // EXTRAEMOS DATOS
                $infoestilo             = $objModelo->get("AUDITEX.PQ_MEDIDAS.SPU_GETDATOSMEDIDASREPORTE",[2,1,$estilotsc,$fichas]);
                $tallasestilo           = $objModelo->getAll("AUDITEX.PQ_MEDIDAS.SPU_GETDATOSMEDIDASREPORTE",[2,2,$estilotsc,$fichas]);
                $medidasestilo          = $objModelo->getAll("AUDITEX.PQ_MEDIDAS.SPU_GETDATOSMEDIDASREPORTE",[2,3,$estilotsc,$fichas]);
                $desviacionesestilo     = $objModelo->getAll("AUDITEX.PQ_MEDIDAS.SPU_GETDATOSMEDIDASREPORTE",[2,4,$estilotsc,$fichas]);
                $dataestilo             = $objModelo->getAll("AUDITEX.PQ_MEDIDAS.SPU_GETDATOSMEDIDASREPORTE",[2,5,$estilotsc,$fichas]);


            ?>  


            <div class="row justify-content-center">   

                <!-- DATA GENERAL -->
                <div class="col-md-12 text-white font-weight-bold mb-2">
                    <label class="float-left w-100" style="margin-bottom: 0px !important;">ESTILO TSC: <?= $infoestilo["ESTTSC"] ?> </label>
                    <label class="float-left w-100" style="margin-bottom: 0px !important;">FICHAS: <?= $fichas == null ? "TODAS" : $fichas;  ?> </label> 
                    <label class="float-left w-100" style="margin-bottom: 0px !important;">ESTILO CLIENTE: <?= $infoestilo["ESTCLI"] ?> </label> 
                    <label class="float-left w-100" style="margin-bottom: 0px !important;">CLIENTE: <?= $infoestilo["DESCLI"] ?> </label> 
                    <a class="btn btn-sm btn-danger" href="/tsc/auditex-generales/views/desviacionmedidas/pdf.report.php?area=COSTURA&estilotsc=<?= $infoestilo["ESTTSC"] ?>&fichas=<?= $fichas == null ? "TODAS" : $fichas;  ?>&estilocliente=<?= $infoestilo["ESTCLI"] ?>&cliente=<?= $infoestilo["DESCLI"] ?>" target="_blank">
                        <i class="fas fa-file-pdf"></i>
                        EXPORTAR
                    </a>
                    <hr class="float-left w-100" style="border-color:#fff">
                </div>

                <!-- ARMAMOS MEDIDAS -->
                <?php $indicemedida = 0;  ?>
                <?php foreach($medidasestilo as $medida): ?>


                    <div class="col-md-12">
                        <h5 class="text-white font-weight-bold">
                            COD: <?= $medida["CODIGO_MEDIDA"] ?>
                            -
                            <?= $medida["DESCRIPCION_MEDIDA"] ?> 
                        </h5>
                    </div>

                    <div class="col-md-3 text-center">
                        <h6 class="text-white" id="txtfuera_<?= $medida["CODIGO_MEDIDA"] ?>"></h6>
                        <h6 class="text-white" id="txtdentro_<?= $medida["CODIGO_MEDIDA"] ?>" ></h6>
                    </div>

                    <div class="col-md-12">

                        
                        <div class="card">
                            <div class="card-body p-0">

                        

                                <table class="table table-sm table-bordered text-center m-0" >
                                    <thead class="bg-sistema text-white">
                                        <?php $cont = 0;$totaltotal = 0; $totaldentrotolerancia = 0; $totalfueratolerancia = 0;$dentrotolerancia = false; ?>
                                        <tr>
                                            <th class="border-table">DESV.</th>
                                            <?php foreach($tallasestilo as $talla): ?>
                                                
                                                <?php $tallasestilo[$cont]["TOTALTALLA"] = 0; ?>
                                                <th class="border-table"> <?= $talla["TALLA"] ?> </th>

                                                <?php $cont++; ?>
                                            <?php endforeach; ?>
                                            <th class="border-table">TOTAL</th>
                                            <th class="border-table">%</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                                
                                        <?php foreach($desviacionesestilo as $desvi): ?>
                                            <tr>
                                                <td class="border-table"> <?= $desvi["MEDIDA"] ?> </td>                                            
                                                <?php $totaldesvi = 0; $cont = 0; ?>
                                                <?php foreach($tallasestilo as $talla): ?>

                                                    <?php 

                                                        $d_filt = array_filter($dataestilo,array( 
                                                            new MedidasReporteFilterValor($medida["CODIGO_MEDIDA"],$talla["IDTALLA"],$desvi["MEDIDA"]),"getFiltroValor")
                                                        );     
                                                        $totaldesvi += count($d_filt);

                                                        $tallasestilo[$cont]["TOTALTALLA"] += count($d_filt);
                                                        $cont++;
                                                        $clasebg = "";

                                                        // TOLERANCIAS
                                                        if(
                                                            (
                                                                $desvi["DC_MEDDEC"] != null &&  $desvi["DC_HASTA"] != null
                                                            )    
                                                                &&
                                                            (
                                                                (float)$medida["TOLERANCIAMAS"] >= (float)$desvi["DC_MEDDEC"]     
                                                                && 
                                                                (float)$desvi["DC_MEDDEC"] >= (float)$medida["TOLERANCIAMENOS"] 
                                                            )
                                                                || 
                                                            (
                                                                $desvi["MEDIDA"] == 0
                                                            )
                                                        ){
                                                            $clasebg =    "bg-medida-tolerancias";
                                                            $dentrotolerancia = true;
                                                        }else{
                                                            $dentrotolerancia = false;
                                                        }


                                                    ?>

                                                    <!--  -->

                                                <td class="border-table <?= $clasebg; ?> "> <?=  count($d_filt)  ?> </td>

                                                <?php endforeach; ?>
                                                <?php $totaltotal += $totaldesvi;  ?>

                                                <!-- TOTALES -->
                                                <td class="border-table" style="background: #ccc;"> <?= $totaldesvi ?> </td>
                                                <td class="border-table" style="background: #ccc;">
                                                    <?php 
                                                        $porcentaje = round( ( (float)$medida["TOTALMED"] > 0 ?  $totaldesvi / (float)$medida["TOTALMED"] : 0) * 100,2);

                                                        if($dentrotolerancia){
                                                            $totaldentrotolerancia  += $porcentaje;
                                                        }else{
                                                            $totalfueratolerancia   += $porcentaje;
                                                        }

                                                    ?>
                                                    
                                                    <?=
                                                        $porcentaje;
                                                    ?>%
                                                </td>



                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                    <tfoot style="background:#333" class="text-white">
                                        <tr>
                                            <th class="border-table">TOTAL</th>
                                            <?php foreach($tallasestilo as $talla): ?>
                                                <th class="border-table"> <?= $talla["TOTALTALLA"] ?> </th>
                                            <?php endforeach; ?>
                                            <th class="border-table"> <?= $totaltotal ; ?> </th>
                                            <th class="border-table"> 100% </th>
                                        </tr>
                                    </tfoot>

                                </table>
                                                


                            </div>  
                        </div>
                        <br>  

                                    
                        <?php   
                            $medidasestilo[$indicemedida]["TOLDENTRO"]  = $totaldentrotolerancia;
                            $medidasestilo[$indicemedida]["TOLFUERA"]   = $totalfueratolerancia;

                            $indicemedida++;
                        ?>


                        <script>
                            document.getElementById("txtdentro_<?= $medida['CODIGO_MEDIDA'] ?>").innerText = "<?= $totaldentrotolerancia ?>% dentro de la Tolerancia";
                            document.getElementById("txtfuera_<?= $medida['CODIGO_MEDIDA'] ?>").innerText  = "<?= $totalfueratolerancia ?>% fuera de la Tolerancia";
                        </script>



                    </div>


                <?php endforeach; ?>


            </div>

            <?php
                
                $_SESSION["infoestilo_desviacion"]          = $infoestilo;
                $_SESSION["tallasestilo_desviacion"]        = $tallasestilo;
                $_SESSION["medidasestilo_desviacion"]       = $medidasestilo;
                $_SESSION["desviacionesestilo_desviacion"]  = $desviacionesestilo;
                $_SESSION["dataestilo_desviacion"]          = $dataestilo;

            ?>

            <form action=""  method="POST" class="row justify-content-center " >

                <div class="col-md-3">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-secondary" type="submit">
                        <i class="fas fa-arrow-left"></i>
                        VOLVER
                    </button>
                </div>

            </form>

        <?php endif; ?>

        



        
    </div>


        


    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>

    <script>

        const frmbusqueda = document.getElementById("frmbusqueda");                                                
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

            $("#txtestilofichas").val(estilotsc);

            $(".loader").fadeIn();
            getsync("auditex-costura","reportedesviacion","getfichasestilo",{estilotsc},function(e){

                let response = JSON.parse(e);
                console.log(response);
                if(response.length > 0){
                    setComboSimple("cbofichas",response,"FICHA","FICHA",true,false,"TODOS");
                    $("#frmfichas").removeClass("d-none");
                    $(".loader").fadeOut("slow");
                }else{
                    $(".loader").fadeOut("slow");
                    $("#frmfichas").addClass("d-none");
                    Advertir("El estilo no tiene fichas registradas");
                }


            });


        }





    </script>


</body>

</html>