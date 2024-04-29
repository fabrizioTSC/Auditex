<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';



    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo  = new CoreModelo();
    $objSistema = new SistemaModelo();

    $_SESSION['navbar'] = "Auditex Lavanderia Prenda";




    // SELECTS
    $codigosdelavados   = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[1,null]);
    // $codigossecadoras   = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[2,null]);
    $tiposlavados       = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[3,null]);


    //  FICHA INICIO
    $fichainicio    = isset($_GET["ficha"]) ? $_GET["ficha"]    : false;
    $IDFICHA        = isset($_GET["id"])    ? $_GET["id"]       : false;


    // TAB SELECCIONADO
    $TAB_ITEM       = isset($_GET["tab"])    ? $_GET["tab"]       : "1";



    $datafichas     = [];
    $llevalavado    = true;
    $dataficha      = null;
    $estilotsc      = null;
    $fichasige      = "0";

    if($fichainicio){


        // EJECUTAMOS PARA CARGA DE DATOS SI NO EXISTE
        $responseficha = $objModelo->setAll("USYSTEX.SPU_SETPARTIDA_AUDITEX",[$fichainicio],"ok");

        // EMPEZAMOS BUSQUEDA
        $datafichas = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPRENDA",[1,null,$fichainicio]);

        if( count($datafichas) > 0 ){
            $llevalavado = $datafichas[0]["LAVADO"] > 0 ? true : false;
        }
    }

    if($IDFICHA){
        $dataficha = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPRENDA",[2,$IDFICHA,$fichainicio]);
        $estilotsc = $dataficha["ESTTSC"];
        $fichasige = $dataficha["FICHASIGE"];
    }

    $validacionmedidas_id   = null;

    // DATOS
    $datosdefectos          = [];
    $estadodefectos         = null;
    $comentariodefectos     = null;
    $tipomaquina_documentos = "PLANTA";

    $link_fechatecnica  = [];


    // ##################################
    // ## OBTENEMOS DATOS REGISTRADOS ###
    // ##################################

    if($IDFICHA){


        // VALIDACION DE DOCUEMENTACION
        $datosvalidacion = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[4,$IDFICHA]);

        $chkprocesotransfer     = "";
        $chkprocesoestampado    = "";
        $chkprocesobordado      = "";
        $chkcodmaquinalavado    = "";
        $maquinalavado    = "";



        // $cbomaquinalavado       = "";
        // $cbomaquinasecadora     = "";
        $cbotipolavado          = "";
        $comentariodocumentos   = "";

        // ESTADOS
        $estadodocumentos       = "";
        $estadofinal            = $dataficha != null ? $dataficha["RESULTADOFINAL"]  : "";


        if($datosvalidacion){
            $chkprocesotransfer     = $datosvalidacion["PROCESO_TRANSFER"]  == "1" ? "checked"  : "";
            $chkprocesoestampado    = $datosvalidacion["PROCESO_ESTAMPADO"] == "1" ? "checked"  : "";
            $chkprocesobordado      = $datosvalidacion["PROCESO_BORDADO"]   == "1" ? "checked"  : "";

            // $cbomaquinalavado       = $datosvalidacion["IDLAVADORA"];
            // $cbomaquinasecadora     = $datosvalidacion["IDSECADORA"];
            $cbotipolavado          = $datosvalidacion["IDTIPOLAVADO"];
            $estadodocumentos       = $datosvalidacion["ESTADO"];
            $comentariodocumentos   = $datosvalidacion["COMENTARIO"];
            $tipomaquina_documentos = $datosvalidacion["TIPOLAVADORA"] == "" ? "PLANTA" : $datosvalidacion["TIPOLAVADORA"];
            $chkcodmaquinalavado    = $datosvalidacion["TIPOLAVADORA"] == "SERVICIO" ? "checked" : "";
            $maquinalavado          = $datosvalidacion["TIPOLAVADORA"];

        }

        // DATOS DEFECTOS
        $datosdefectos = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[11,$IDFICHA]);

        if($datosdefectos){

            $estadodefectos         = $datosdefectos != null ? $datosdefectos["ESTADO"] : "";
            $comentariodefectos     = $datosdefectos != null ? $datosdefectos["COMENTARIO"] : "";

        }


        // VALIDACION DE MEDIDAS
        $validacionmedidas              = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[7,$IDFICHA]);
        $validacionmedidas_generado     = isset($_GET["generar"]) ? true : false;


        // CABECERA
        $validacionmedidas_start            = false;
        $valimedidas_llevaregistro          =  "";
        $valimedidas_numeroprendas          =  "";
        $valimedidas_ampliado               =  "";
        $valimedidas_numeroprendasadi       =  "";
        $valimedidas_comentario             =  "";
        $valimedidas_estado                 =  "";
        $valimedidas_numeroprendas_array    = [];

        // DETALLE
        $validacionmedidas_detalle_tallas       = [];
        $validacionmedidas_detalle_cmedidas     = [];

        


        if($validacionmedidas){

            // VALIDACION DE MEDIDAS DETALLE
            $validacionmedidas_detalle  = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[8,$IDFICHA]);

            // VALIDACION DE MEDIDAS DETALLE (AGRUPADO)
            $validacionmedidas_detalle_group  = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[9,$IDFICHA]);

            // DETALLE DE MEDIDAS PARA REGISTRAR
            $medidasregistras                  = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[10,$IDFICHA]);

            $validacionmedidas_id           =  $validacionmedidas["IDHEADMEDIDA"];
            $validacionmedidas_start        =  true;
            $valimedidas_llevaregistro      =  $validacionmedidas["LLEVAREGISTRO"] == "1" ? "checked"  : "";
            $valimedidas_numeroprendas      =  $validacionmedidas["NUMEROPRENDAS"];
            $valimedidas_numeroprendasadi   =  $validacionmedidas["NUMEROPRENDAS_ADI"];
            $valimedidas_comentario         =  $validacionmedidas["COMENTARIO"];
            $valimedidas_estado             =  $validacionmedidas["ESTADO"];
            $valimedidas_ampliado           =  $validacionmedidas["AMPLIADO"];

            // OBTENEMOS DETALLES DISCTINC (TALLAS)
            $validacionmedidas_detalle_tallas       = $objSistema->unique_multidim_array($validacionmedidas_detalle,"IDTALLA");

            // OBTENEMOS DETALLES DISCTINC (CODIGO MEDIDAS)
            $validacionmedidas_detalle_cmedidas     = $objSistema->unique_multidim_array($validacionmedidas_detalle,"CODIGO_MEDIDA");



            for($i = 1; $i <= $valimedidas_numeroprendas + $valimedidas_numeroprendasadi; $i++){

                // $valimedidas_numeroprendas_array[] = $i;

                if($i <= $valimedidas_numeroprendas){

                    $valimedidas_numeroprendas_array[] = [
                        "ADICIONAL" => "0",
                        "PRENDAS" => $i
                    ];

                }else{

                    $valimedidas_numeroprendas_array[] = [
                        "ADICIONAL" => "1",
                        "PRENDAS" => $i
                    ];

                }
                


            }

        }

        // DATOS PARA FICHA TECNICA
        $link_fechatecnica = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHATECNICA",[ $dataficha["PEDIDO"] ]);

    }




?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Lavanderia Prenda</title>
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
        

        .table-fichas{
            table-layout: fixed;
        }

        .table-fichas > td,th{
            padding: 0px !important;
        }

        .thead-fichas .w-bajo{
            width: 50px !important;
            overflow: auto;
        }

        .thead-fichas .w-bajo-duplicado{
            width: 100px !important;
            overflow: auto;
        }

        .thead-fichas .w-medio{
            width: 150px !important;
            overflow: auto;
        }

        .thead-fichas .w-bajo-2{
            width: 20px !important;
            overflow: auto;
        }

        .container-data-general{
            font-size: 12px !important;
            font-weight: bold !important;
        }

        label{
            margin-bottom: 0px !important;
        }

        .table-medidas{
            /* table-layout: fixed; */
            border-collapse: collapse;
            text-align: center !important;
            font-size: 11px !important;
        }

        .table-medidas, td, th {
            border: 1.8px solid black;
        }

        .bg-medida-0{
            background: #c7ffcb !important;
            color: #000 !important;
        }

        .bg-medida-tolerancias{
            background: #ecf5a7 !important;
            /* color: #000 !important; */
        }

        .cuerpo-medidas{
            max-height: 300px !important;
            overflow: auto !important;
        }

        .page-item.active .page-link{
            color: #fff !important;
            background-color: #922b21  !important;
            border-color: #922b21 !important;
        }

        .page-link{
            color: #000 !important;
        }

        .custom-control-label::before ,.custom-control-label::after{width:20px; height:20px}

    </style>

</head>

<body>
    <div class="loader"></div>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>

    <!--  -->
    <div class="container-fluid mt-3">


            <?php if(!$IDFICHA): ?>
                <!-- BUSQUEDA -->
                <div class="container">


                        <form  id="frmbusqueda" autocomplete="off" method="GET" class="row justify-content-md-center">

                            <label for="" class="col-md-2 col-2 col-label font-weight-bold"  >FICHA:</label>

                            <div class="col-md-8 col-6">
                                <input type="number" class="form-control form-control-sm font-weight-bold" style="font-size: 16px !important;"  name="ficha" value="<?= $fichainicio; ?>"  autofocus required>
                            </div>

                            <div class="col-md-2 col-4">
                                <button class="btn btn-sm btn-block btn-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>


                        </form>


                </div>

            <?php endif; ?>
            

            <!-- SELECCION DE FICHAS -->
            <?php if($fichainicio && !$IDFICHA): ?>


                <div class="container">

                    <label for="" class="mt-2 col-md-12 col-label font-weight-bold">SELECCIONE AUDITORIA A CONSULTAR</label>
                    <label for="" class="mt-1 col-md-12 col-label font-weight-bold">CANTIDAD FICHA: 
                        <?=
                            count($datafichas) > 0 ? $datafichas[0]["CANTOTALFICHA"] : "";  
                        ?> 
                    </label>

                    <div class="row justify-content-center">

                        <div class="col-md-12 col-lg-10 mt-3">

                            <div class="table-responsive" style="background: #fff;">

                                <table class="table table-sm table-bordered m-0  text-center table-hover font-weight-bold ">
                                    <thead class="thead-sistema-new ">
                                        <tr>
                                            <th  class="border-table w-bajo align-vertical" >USUARIO</th>
                                            <!-- <th  class="border-table w-bajo-2 text-center" >Ficha</th> -->
                                            <th  class="border-table w-bajo-2 text-center align-vertical">PARTE</th>
                                            <th  class="border-table w-bajo-2 text-center align-vertical">VEZ</th>   
                                            <th  class="border-table w-bajo-2 text-center align-vertical">CANT. PART</th>

                                            <th  class="border-table w-bajo-2 text-center align-vertical">FEC. INICIO</th>
                                            <th  class="border-table w-bajo-2 text-center align-vertical">FEC. FIN</th>

                                            <th  class="border-table w-bajo text-center align-vertical">RESULTADO</th> 
                                            <th  class="border-table w-bajo text-center align-vertical">COMENTARIO DEFECTOS</th> 
                                            <!-- <th  class="border-table w-bajo-2 "></th> -->
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach($datafichas as $dficha): ?>

                                            

                                                <tr 
                                                    class="cursor-pointer selectfichas"
                                                        data-ficha="<?= $dficha["CODFIC"]; ?>"
                                                        data-parte="<?= $dficha["PARTE"]; ?>"
                                                        data-numvez="<?= $dficha["NUMVEZ"]; ?>"
                                                        data-canttotal="<?= $dficha["CANTIDADPARTIDA"]; ?>"
                                                        data-cantficha="<?= $dficha["CANTOTALFICHA"]; ?>"
                                                        data-idficha="<?= $dficha["IDFICHA"]; ?>"
                                                        data-resultado="<?= $dficha["RESULTADO"]; ?>"
                                                        data-usuario="<?= $dficha["USUARIOCREA"]; ?>"
                                                    >
                                                    <td class="text-center" nowrap> <?= $dficha["USUARIOCREA"]; ?> </td>
                                                    <td class="text-center" nowrap> <?= $dficha["PARTE"]   == "" ? 1 : $dficha["PARTE"]; ?> </td>
                                                    <td class="text-center" nowrap> <?= $dficha["NUMVEZ"]  == "" ? 1 : $dficha["NUMVEZ"]; ?> </td>
                                                    <td class="text-center" nowrap> <?= $dficha["CANTIDADPARTIDA"]; ?> </td>

                                                    <td class="text-center" nowrap> <?= $dficha["FECHACREA"]; ?> </td>
                                                    <td class="text-center" nowrap> <?= $dficha["FECHACIERRE"]; ?> </td>


                                                    <td class="text-center" nowrap> <?= $dficha["RESULTADO"]; ?> </td>
                                                    <td class="text-center" nowrap> <?= $dficha["COMENTARIO"]; ?> </td>


                                                    
                                                </tr>

                                            

                                            



                                        <?php endforeach;?>

                                    </tbody>
                                </table>

                            </div>

                        </div>

                        <div class="col-md-2 col-lg-3  mt-2 ">
                            <button class="btn d-none btn-block btn-sm btn-sistema btn-opciones font-weight-bold " id="btniniciar" type="button">INICIAR</button>  
                        </div>
                        <div class="col-md-2 col-lg-3 mt-2">
                            <button class="btn d-none btn-block btn-sm btn-warning btn-opciones font-weight-bold" id="btnpartir" type="button">PARTIR</button>  
                        </div>

                    </div>

                    

                
                </div>

                                                    
            
            <?php endif; ?> 


            
            <?php if($IDFICHA): ?>

                <!-- DATOS DE LA FICHA -->
                <div class="row container-data-general">

                    <div class="col-6">

                        <div class="row">

                            <!-- FICHA -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">FICHA / NUMVEZ:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $fichainicio;?> / <?= $dataficha["NUMVEZFICHA"];?></label> 
                            </div>

                            <!-- PEDIDO -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">PEDIDO:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["PEDIDO"];?></label> 
                            </div>

                            <!-- ESTILO CLIENTE -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">ESTILO CLIENTE:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["ESTCLI"];?></label> 
                            </div>

                            <!-- ESTILO TSC -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">ESTILO TSC:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["ESTTSC"];?></label> 
                            </div>

                            <!-- PARTIDA -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">PARTIDA:</label>
                            </div>
                            <?php 
                                $rutapartida   = "/TSC-WEB/auditoriatela/VerAuditoriaTela.php?partida={$dataficha['PARTIDA']}&codtel={$dataficha['CODTEL']}&codprv={$dataficha['CODPRV']}&numvez={$dataficha['NUMVEZ']}&parte=1&codtad=1";
                            ?>
                            <div class="col-md-8">
                                <a href="<?= $rutapartida;?>" target="_blank">
                                    <!-- <label for=""><?= $dataficha["PARTIDA"];?></label>  -->
                                    <?= $dataficha["PARTIDA"];?>

                                </a>   
                            </div>

                            <!--  AQL   -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">AQL:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["AQL"];?>%</label> 
                            </div>

                            <!--  AUDITOR   -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">AUDITOR:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["USUARIOCREA"];?></label> 
                            </div>

                            <!-- MOSTRAR DATOS -->
                            <div class="col-md-12">
                                <a href="#"  data-toggle="collapse" data-target=".multi-collapse" id="lblmostrardatos">Mostrar Datos</a>
                            </div>



                        </div>


                    </div>

                    <div class="col-6">

                        <div class="row">

                            <!-- TIPO DE TELA -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">TIPO DE TELA:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["DESTEL"];?></label>
                            </div>

                            <!-- COLOR -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">COLOR:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["COLOR"];?></label>
                            </div>

                            <!-- CLIENTE -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">CLIENTE:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["DESCLI"];?></label>
                            </div>

                            <!-- CANT. TOT. FICHA -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">CANT. TOT. FICHA:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["CANTOTALFICHA"];?></label>
                            </div>

                            <!-- CANT. PART -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">CANT. PART:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["CANTIDADPARTIDA"];?></label>
                            </div>

                            <!-- SAMPLESIZE -->
                            <div class="col-md-4">
                                <label class="font-weight-bold">CANTIDAD MUESTRA:</label>
                            </div>
                            <div class="col-md-8">
                                <label for=""><?= $dataficha["SAMPLESIZE"];?></label> 
                            </div>

                            <!--  DEFECTOS PERMITIDOS   -->
                            <div class="col-md-4 ">
                                <label class="font-weight-bold">MAX DEFECTOS:</label>
                            </div>
                            <div class="col-md-8 ">
                                <label for=""><?= $dataficha["RECHAZADO"] - 1;?></label> 
                            </div>
                            

                        </div>

                    </div>

                    <!-- TALLERRES POR PROCESOS -->
                    <div class="col-md-12 collapse multi-collapse">

                        <div class="row">

                            

                            <!-- TALLER DE CORTE -->
                            <div class="col-md-2">
                                <label class="font-weight-bold">TALLER DE CORTE:</label>
                            </div>
                            <div class="col-md-10">
                                <a href="/TSC-WEB/auditoriafinalcorte/ConsultarEditarAuditoria.php?codfic=<?= $fichainicio;?>&solocorte=1" target="_blank" ><?= $dataficha["TALLERCORTE"];?></a>
                            </div>

                            <!-- TALLER DE COSTURA -->
                            <div class="col-md-2">
                                <label class="font-weight-bold">TALLER DE COSTURA:</label>
                            </div>
                            <div class="col-md-10">
                                <a href="/TSC-WEB/auditex/ConsultarEditarAuditoria.php?codfic=<?= $fichainicio;?>&solocorte=1" target="_blank" ><?= $dataficha["TALLERCOSTURA"];?></a>
                            </div>

                            <!-- TRANSFER -->
                            <div class="col-md-2">
                                <label class="font-weight-bold">TRANSFER:</label>
                            </div>
                            <div class="col-md-10">
                                <!-- <a href="/TSC-WEB/auditex/ConsultarEditarAuditoria.php?codfic=<?= $fichainicio;?>" target="_blank" ><?= $dataficha["TALLERCOSTURA"];?></a> -->
                            </div>

                            <!-- ESTAMPADO -->
                            <div class="col-md-2">
                                <label class="font-weight-bold">ESTAMPADO:</label>
                            </div>
                            <div class="col-md-10">
                                <!-- <a href="/TSC-WEB/auditex/ConsultarEditarAuditoria.php?codfic=<?= $fichainicio;?>" target="_blank" ><?= $dataficha["TALLERCOSTURA"];?></a> -->
                            </div>

                            <!-- BORDADO -->
                            <div class="col-md-2">
                                <label class="font-weight-bold">BORDADO:</label>
                            </div>
                            <div class="col-md-10">
                                <!-- <a href="/TSC-WEB/auditex/ConsultarEditarAuditoria.php?codfic=<?= $fichainicio;?>" target="_blank" ><?= $dataficha["TALLERCOSTURA"];?></a> -->
                            </div>

                            <!-- VOLVER -->
                            <div class="col-md-12 mt-2">
                                <a href="registroprenda.view.php?ficha=<?= $fichainicio;?>" class="btn btn-sm  btn-warning">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>

                        </div>

                    </div>

                </div>


                <!-- SEPARADOS -->
                <hr class="hr">
                <!-- END SEPARADOR  -->


                <!-- VALIDACION DE DOCUMENTOS -->
                <div class="container-fluid containerdatos" id="container_documentacion">

                    <h4 class="text-white font-weight-bold" >1. VALIDACIÓN DE DOCUMENTACIÓN<?= ": ".$estadodocumentos; ?> </h4>

                    <form class="row justify-content-md-center" id="frmvalidaciondocumentos">

                        <!-- FICHA TECNICA -->
                        <div class="col-8">
                            <label for="">Ficha Técnica:</label>
                        </div>

                        <div class="col-4">
                            <div class="custom-control custom-switch">

                                <?php if($dataficha["FTEC"] > 0) : ?> 

                                    <input type="checkbox" class="custom-control-input checks"  id="chkfichatecnica" checked>
                                    <label class="custom-control-label" for="chkfichatecnica" id="lblchkfichatecnica">SI</label>

                                <?php else: ?> 
                                    <input type="checkbox" class="custom-control-input checks"  id="chkfichatecnica">
                                    <label class="custom-control-label" for="chkfichatecnica" id="lblchkfichatecnica">NO</label>
                                <?php endif; ?> 
                                

                            </div>
                        </div>

                        <!-- LINK DE LA FICHA TECNICA -->
                        <?php  if($link_fechatecnica): ?>                                    

                            <div class="col-12 mt-1">

                                <table class="table table-bordered table-hover table-sm">
                                    <thead class="thead-sistema-new">
                                        <tr>
                                            <?php foreach($link_fechatecnica as $fila): ?>

                                                <td>
                                                    <span class="float-left">
                                                        <?= $fila["NOMBREAREAS"] ?>
                                                        <a class="text-white ml-1" href="<?= $fila["RUTAARCHIVO"] ?>" target="_blank" title="Ruta de Ficha Técnica">  
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </span>
                                                </td>

                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                </table>


                            </div>

                        <?php endif; ?>

                        

                        <!-- PROCESO TRANSFER -->
                        <div class="col-8">
                            <label for="">Proceso Transfer:</label>
                        </div>

                        <div class="col-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="chkprocesotransfer" <?= $chkprocesotransfer; ?> >
                                <label class="custom-control-label" for="chkprocesotransfer" id="lblchkprocesotransfer"> 
                                    <?= $chkprocesotransfer == "" ? "NO" : "SI"; ?>
                                </label>
                            </div>
                        </div>

                        <!-- PROCESO ESTAMPADO -->
                        <div class="col-8">
                            <label for="">Proceso Estampado:</label>
                        </div>

                        <div class="col-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="chkprocesoestampado" <?= $chkprocesoestampado; ?>>
                                <label class="custom-control-label" for="chkprocesoestampado" id="lblchkprocesoestampado">
                                    <?= $chkprocesoestampado == "" ? "NO" : "SI"; ?>
                                </label>
                            </div>
                        </div>

                        <!-- PROCESO BORDADO -->
                        <div class="col-8">
                            <label for="">Proceso Bordado:</label>
                        </div>

                        <div class="col-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="chkprocesobordado" <?= $chkprocesobordado; ?>>
                                <label class="custom-control-label" for="chkprocesobordado" id="lblchkprocesobordado">
                                    <?= $chkprocesobordado == "" ? "NO" : "SI"; ?>
                                </label>
                            </div>
                        </div>

                        <!-- COD DE MAQUINA DE LAVADO -->
                        <div class="col-8">
                            <label for="">Cód de máquina de lavado:</label>
                        </div>

                        <div class="col-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checksmaquinalavado"  id="chkcodmaquinalavado" <?= $chkcodmaquinalavado; ?>>
                                <label class="custom-control-label" for="chkcodmaquinalavado" id="lblchkcodmaquinalavado">
                                    <?= $tipomaquina_documentos ?>
                                </label>
                            </div>
                        </div>

                        <!-- SEPARADOR -->
                        <div class="col-md-12">
                            <hr>
                        </div>

                        <!-- CODIGO DE MAQUINA DE LAVADA -->
                        <div class="col-md-6 form-group-sm">
                            <label for="">CÓD. DE MÁQUINA LAV:</label>
                            <select name="" id="cbomaquinalavado" class="custom-select custom-select-sm select2" style="width: 100%;" multiple="multiple" data-placeholder="Seleccione">    

                            
                            </select>
                        </div>


                        <!-- CODIGO DE LAVADO -->
                        <div class="col-md-6 form-group-sm">
                            <label for="">CÓD. DE LAVADO:</label>
                            <select name="" id="cbocodigolavado" class="custom-select custom-select-sm select2" style="width: 100%;"> 
                                <option value="">[SELECCIONE]</option>
                                <?php foreach($tiposlavados as $fila): ?>
                                    <option value="<?= $fila["IDTIPOLAVADO"];?>" <?= $fila["IDTIPOLAVADO"] == $cbotipolavado ? "selected" : ""; ?> >
                                        <?= $fila["CODIGO"] ." - ". $fila["DESCRIPCION"]; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- OBSERVACION -->
                        <div class="col-md-10 form-group-sm">
                            <label for="">OBSERVACIÓN:</label>
                            <textarea id="txtobservaciondocumentacion" class="form-control form-control-sm" id="" rows="2"><?= $comentariodocumentos; ?> </textarea>
                        </div>

                        <!-- REGISTRAR -->
                        <?php if($estadodocumentos != "APROBADO"): ?> 

                            <div class="col-md-4 form-group-sm" id="container-save-item1">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-sm btn-block btn-sistema" type="submit">Guardar</button>
                            </div>
                            
                        <?php endif; ?>

                    </form>

                </div>

                <!-- DEFECTOS -->
                <div class="container-fluid containerdatos d-none" id="container_defectos">

                    <h4 class="text-white font-weight-bold" id="lblDefectos">2. DEFECTOS<?= ": ".$estadodefectos; ?> </h4> 
                                        
                    <form class="row justify-content-md-center" id="frmregistrodefectos" autocomplete="off">

                        <label class="col-lg-1  col-sm-2 col-md-2 col-form-label">Defectos:</label>
                        
                        <div class="col-lg-3 col-sm-4 col-md-4">
                            <select name="" id="cbodefectos" class="custom-select custom-select select2"></select>
                        </div>

                        <label class="col-lg-1 col-sm-2 col-md-2 col-form-label">Cantidad:</label>
                        
                        <div class="col-lg-1 col-sm-4 col-md-4">
                            <input type="number" class="form-control form-control-sm" id="txtcantidaddefectos" required>
                        </div>

                        <label class="col-lg-1 col-form-label col-sm-2 col-md-2">Comentario:</label>

                        <div class="col-lg-4 col-sm-10 col-md-10">
                            <input type="text" class="form-control form-control-sm" id="txtcomentariodefectos" >
                        </div>

                        <?php if($estadodefectos == "" || $estadodefectos == "EN PROCESO" || $estadodefectos == "PENDIENTE") :?>

                            <div class="col-md-1" >
                                <button id="btn-save-item-agregar-2" class="btn btn-sm btn-block btn-sistema" type="submit">
                                    Guardar
                                </button>
                            </div>

                        <?php endif; ?>
                                    
                    </form>           
                    
                    <hr>

                    <div class="table-responsive">
                                
                        <table class="table table-bordered table-sm text-center responsive nowrap" id="tabledefectosagregados" style="width:100%">
                            <thead class="thead-sistema-new">
                                <tr>
                                    <th class="border-table" data-priority="1"> CÓDIGO</th>
                                    <th class="border-table">DEFECTO</th>
                                    <th class="border-table" data-priority="2">CANTIDAD</th>
                                    <th class="border-table">OBSERVACION</th>
                                </tr>
                            </thead>                                            
                            <tbody id="tbodydefectosagregados">

                            </tbody>
                        </table>

                    </div>

                    <!-- OBSERVACION -->
                    <div class="row justify-content-center">
                        <div class="col-md-10 form-group-sm">
                            <label for="">OBSERVACIÓN:</label>
                            <textarea id="txtobservaciondefectos" class="form-control form-control-sm" id="" rows="2"><?= $comentariodefectos;?></textarea>
                        </div>
                    </div>
                    
                    
                    <?php if($estadodefectos == "" || $estadodefectos == "EN PROCESO" || $estadodefectos == "PENDIENTE") :?>

                        <div class="row justify-content-center" id="container-save-item2">
                            <div class="col-md-3 mt-2">
                                <button class="btn btn-sm btn-sistema btn-block" id="btncerrarregistrodefectos" type="button">Guardar</button>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>

                <!-- VALIDACION DE MEDIDAS -->
                <div class="container-fluid containerdatos d-none" id="container_medidas">

                    <h4 class="text-white font-weight-bold" id="lblValidacionMedidas">
                        3. VALIDACIÓN DE MEDIDAS:
                        <?= $valimedidas_estado; ?>
                    </h4>

                    <!-- SI NO TIENE REGISTRO -->
                    <?php  if(!$validacionmedidas): ?>

                        <form class="row" autocomplete="off" >

                            <div class="col-md-3">

                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox"  class="cursor-pointer " id="chkvalidacionmedidas" <?= $valimedidas_llevaregistro; ?> <?= $validacionmedidas_start ? "disabled" : ""; ?>  >
                                        </div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" value="Registro" readonly>
                                </div>

                            </div>


                            <div class="col-md-3">

                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox"  class="cursor-pointer " id="chkfichasige" ?>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" value="Ficha SIGE" readonly>
                                </div>

                            </div>

                            <!-- PRENDAS POR TALLA -->
                            <label class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-md-1 col-label prendasportalla">Prendas por Talla:</label>

                            <div class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-md-1 prendasportalla">
                                <input id="txtnumeroprendas_medida" type="number" class="form-control form-control-sm" value="<?= $valimedidas_numeroprendas ; ?>" <?= $validacionmedidas_start ? "readonly" : ""; ?>>
                            </div>

                            <!-- ADICIONALES -->
                            <label class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-1 col-label ">Prendas Adicionales:</label>

                            <div class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-1 ">
                                <input id="txtadicionales_medida" type="number" class="form-control form-control-sm" value="<?= $valimedidas_numeroprendasadi ; ?>"  >
                            </div>

                            <!-- BTN GENERAR MEDIDAS -->
                            <div class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-sm-4 col-lg-2 prendasportalla mt-1">
                                <button class="btn btn-sm btn-block btn-sistema font-weight-bold " type="button" id="btngenerarmedidas">GENERAR</button>
                            </div>


                        </form>

                        <!-- ASIGNACION DE ESTADO -->
                        <form class="row justify-content-center" id="frmsinvalidacion">

                            <div class="col-md-4"></div>

                            <!-- ESTADO ASIGNADO -->
                            <div class="col-md-4 sinvalidacionmedidas">
                                <label for="">Estado Asignado</label>
                                <select name="" id="cboestadoasignado" class="custom-select custom-select-sm">
                                    <option <?= $valimedidas_estado == "" ? "selected" : ""; ?> value="">[SELECCIONE]</option>  
                                    <option <?= $valimedidas_estado == "APROBADO" ? "selected" : ""; ?> value="APROBADO">APROBADO</option>  
                                    <option <?= $valimedidas_estado == "APROBADO NO CONFORME" ? "selected" : ""; ?> value="APROBADO NO CONFORME">APROBADO NO CONFORME</option>
                                    <option <?= $valimedidas_estado == "RECHAZADO" ? "selected" : ""; ?> value="RECHAZADO">RECHAZADO</option>  
                                </select>
                            </div>

                            <div class="col-md-4"></div>

                            <div class="col-md-2"></div>
                            <!-- COMENTARIO -->
                            <div class="col-8 mt-2 sinvalidacionmedidas">
                                <label for="">Comentario de medidas:</label>
                                <textarea class="form-control form-control-sm" name="" id="txtcomentariomedidas"  rows="2"><?= $valimedidas_comentario;?></textarea>                                                                            
                            </div>
                            <div class="col-md-2"></div>

                            <div class="col-md-3 mt-2 sinvalidacionmedidas">
                                <button class="btn btn-sm btn-block btn-sistema" type="submit">Finalizar</button>
                            </div>

                        </form>

                    <?php endif; ?>


                    <!-- MOSTRAMOS RESUMEN SI YA TIENE REGISTRO -->
                    <?php if($validacionmedidas && !$validacionmedidas_generado): ?>


                        <form class="row" autocomplete="off" >

                            <div class="col-md-3">

                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox"  class="cursor-pointer " id="chkvalidacionmedidas" <?= $valimedidas_llevaregistro; ?> <?= $validacionmedidas_start ? "disabled" : ""; ?>  >
                                        </div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" value="Registro" readonly>
                                </div>

                            </div>

                            <!-- PRENDAS POR TALLA -->
                            <label class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-md-1 col-label prendasportalla">Prendas por Talla:</label>

                            <div class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-md-1 prendasportalla">
                                <input id="txtnumeroprendas_medida" type="number" class="form-control form-control-sm" value="<?= $valimedidas_numeroprendas ; ?>" <?= $validacionmedidas_start ? "readonly" : ""; ?>>
                            </div>

                            <!-- ADICIONALES -->
                            <label class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-md-1 col-label ">Prendas Adicionales:</label>

                            <div class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-md-1 ">
                                <input id="txtadicionales_medida" type="number" class="form-control form-control-sm" value="<?= $valimedidas_numeroprendasadi ; ?>"  >
                            </div>


                            
                                <!-- BTN GENERAR PRENDA ADICIONALES -->
                                <div class=" <?= $valimedidas_llevaregistro == "checked" ? "" : "d-none"; ?> col-md-2 prendasportalla mt-1">
                                    <button class="btn btn-sm btn-block btn-sistema" type="button" id="btngenerarmedidas">GENERAR</button>
                                </div>

                            
                            

                        </form>

                        <hr class="hr">

                        <!-- SI LLEVA MEDIDAS -->

                        <?php  if($valimedidas_llevaregistro == "checked"): ?>

                            <!-- CABECERA  -->
                            <div class="table-responsive" >
                                <table class="table-medidas m-0">

                                    <thead class="thead-sistema-new">
                                        <tr >
                                            <th style="min-width:50px !important; " class="align-vertical" rowspan="2"  >Prenda</th>  
                                            <th style="min-width:50px !important;" class="align-vertical" >Medida</th>
                                            <!-- CODIGO DE MEDIDAS -->
                                            <?php foreach($validacionmedidas_detalle_cmedidas as $codigo): ?>  
                                                <th style="min-width:150px" class=" align-vertical"><?= $codigo["CODIGO_MEDIDA"];?></th>
                                            <?php endforeach; ?>
                                            
                                        </tr>
                                        <tr >
                                            <th style="width:50px" class="align-vertical" >Talla</th>  

                                            <?php foreach($validacionmedidas_detalle_cmedidas as $codigo): ?>  
                                                <th style="min-width:150px" class=" align-vertical"><?= $codigo["DESCRIPCION_MEDIDA"];?></th>
                                            <?php endforeach; ?>
                                            
                                        </tr> 
                                    </thead>

                                    <tbody>

                                        <?php foreach($validacionmedidas_detalle_tallas as $talla): ?>  
                                        
                                            <?php foreach($valimedidas_numeroprendas_array as $prendas): ?>  
                                                
                                                <tr class="">

                                                    <td style="width:3rem !important;" class=" bg-secondary text-white"><?= $prendas["PRENDAS"]; ?></td>
                                                    <td style="width:3.5rem !important;" class=" bg-secondary text-white"><?= $talla["TALLA"]; ?></td>


                                                    <?php foreach($validacionmedidas_detalle_cmedidas as $codigo): ?>  

                                                        <?php 

                                                            $d_filt = array_filter($validacionmedidas_detalle,array( 
                                                                new MedidasFilterValor($codigo["CODIGO_MEDIDA"],$talla["IDTALLA"],$prendas["PRENDAS"]),"getFiltroValor")
                                                            );     


                                                        ?>


                                                        <?php foreach($d_filt as $f): ?>  
                                                            
                                                            <?php

                                                                $clasebgnuevo = "bg-white";

                                                                if($f["VALOR"] == "0"){
                                                                    $clasebgnuevo = "bg-medida-0";
                                                                }else{

                                                                    if($f["VALOR"] != "" && $f["VALOR"] != null){

                                                                        $tolerancimas   = (float)$f["TOLERANCIAMAS"];
                                                                        $tolerancimenos = (float)$f["TOLERANCIAMENOS"];
                                                                        $tolerancimenos = -$tolerancimenos;
                                                                        $valordecimal   = (float)$f["VALORDECIMAL"];

                                                                        if($tolerancimas >= $valordecimal && $valordecimal >= $tolerancimenos){
                                                                            $clasebgnuevo = "bg-medida-tolerancias";
                                                                        }else{
                                                                            $clasebgnuevo = "bg-white";
                                                                        }

                                                                    }   


                                                                }
                                                                
                                                            ?>

                                                            <td style="width:200px" class="align-vertical <?= $clasebgnuevo; ?>">

                                                                <label class='text-dark font-weight-bold'>
                                                                    <?= $f["VALOR"]; ?>
                                                                </label>

                                                            </td>

                                                        <?php endforeach; ?>




                                                    <?php endforeach; ?>

                                                    

                                                    

                                                </tr> 

                                            <?php endforeach; ?>

                                            

                                        <?php endforeach; ?>

                                    </tbody>
                                        

                                </table>
                            </div>

                            

                            <!-- MEDIDAS STANDAR -->
                            <table class="table-medidas m-0 mt-3">
                                <tbody>
                                    <?php foreach($validacionmedidas_detalle_tallas as $talla): ?>

                                        <tr class="thead-fichas">
                                            <!-- <td class="w-bajo bg-secondary text-white"><?= $talla["TALLA"]; ?></td> -->
                                            <td class="w-bajo-duplicado bg-secondary text-white"><?= $talla["TALLA"]; ?></td>

                                            <?php 
                                                $datafiltrada = array_filter($validacionmedidas_detalle_group,array( new SistemaModeloFilter($talla["IDTALLA"],"IDTALLA"),"getFiltro"));     
                                            ?>

                                            <?php foreach($datafiltrada as $filtro): ?>

                                                <td class="w-medio align-vertical bg-white font-weight-bold">
                                                    <?php
                                                        // $filtro["MEDIDA"];
                                                    ?>
                                                    <?= $filtro["MEDIDA_NEW"];?>

                                                </td>

                                            <?php endforeach; ?>

                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>                                                                
                            </table>  
                        
                        <?php else: ?>

                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <textarea class="form-control form-control-sm" rows="3"><?= $valimedidas_comentario;?></textarea>
                                </div>
                            </div>


                        <?php endif; ?>

                    <?php  endif; ?>


                    <!-- INICIA REGISTRO -->
                    <?php if($validacionmedidas && $validacionmedidas_generado): ?> 


                        <div class="row justify-content-md-center">

                            <div class="col-md-2 col-2">
                                <label>
                                    Tallas:
                                </label>   

                            </div>

                            <div class="col-md-8 col-10">
                                    
                                <nav aria-label="">
                                    <?php $activetallas = true; ?>
                                    <ul class="pagination pagination-sm">
                                        <?php foreach($validacionmedidas_detalle_tallas as $talla): ?>  
                                            
                                            <li class="page-item litallas <?=  $activetallas ? "active" : ""; ?>" id="li_collapse_<?= $talla["TALLA"]; ?>" >
                                                <a class="pl-3 pr-3 page-link atallas cursor-pointer" data-talla="<?= $talla["TALLA"]; ?>"  id="a_collapse_<?= $talla["TALLA"]; ?>" ><?= $talla["TALLA"]; ?></a>
                                            </li>

                                            <?php $activetallas = false; ?>
                                        <?php endforeach; ?>
                                    </ul>

                                </nav>    

                            </div>

                            <div class="col-md-2 col-12">
                                <a class="cursor-pointer" id="btnampliarpulgadas"> <?= $valimedidas_ampliado == "0" ? "Ampliar" : "Reducir"; ?> Pulgadas</a>   
                            </div>

                            <div class="col-md-2 col-3">
                                <label for="" class="font-weight-bold" id="lbltallaactiva">TALLA: <?= $validacionmedidas_detalle_tallas[0]["TALLA"]; ?> </label>
                                <label> - Prendas</label>   
                            </div>

                            <div class="col-md-10 col-9">
                                <nav aria-label="">
                                    <ul class="pagination pagination-sm">
                                        <?php foreach($valimedidas_numeroprendas_array as $prendas): ?>  
                                            
                                            <li id="li_prendas_<?= $prendas["PRENDAS"]; ?>" class=" liprendas page-item <?= $prendas["PRENDAS"] == "1" ? "active" : ""; ?>"  >
                                                <a class="pl-3 pr-3 page-link aprendas cursor-pointer" data-adicional="<?= $prendas["ADICIONAL"]; ?>" data-numprenda="<?= $prendas["PRENDAS"]; ?>" ><?= $prendas["PRENDAS"]; ?></a>
                                            </li>

                                        <?php endforeach; ?>
                                    </ul>
                                </nav>
                            </div>

                            <div class="col-md-12">
                                                                                
                                <?php $activetallas = true; ?>
                                
                                <!-- CREAMOS REGISTROS POR TALLA -->
                                <?php foreach($validacionmedidas_detalle_tallas as $talla): ?>  

                                    

                                    <div class="collapse <?=  $activetallas ? "show" : ""; ?>  multi-collapse divtallas" id="div_collapse_<?= $talla["TALLA"]; ?>">

                                        <?php

                                            // $objSistemafiltro = new SistemaModeloFilter();
                                            $datafiltrada = array_filter($validacionmedidas_detalle_group,array( new SistemaModeloFilter($talla["IDTALLA"],"IDTALLA"),"getFiltro"));     
                                            

                                        ?>    

                                        <!-- CABECERA  -->
                                        <div class="table-responsive" >

                                            <table class="table-medidas m-0">
                                                
                                                <thead class="thead-sistema-new">

                                                    <tr class="thead-fichas">
                                                        <th style="min-width: 50px;" class="align-vertical">C. Med</th>
                                                        <!-- CODIGO DE MEDIDAS -->
                                                        <?php foreach($datafiltrada as $codigo): ?>  
                                                            <th style="min-width: 150px;" class=" align-vertical"><?= $codigo["CODIGO_MEDIDA"];?></th>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                    <tr class="thead-fichas">
                                                        <th style="min-width: 50px;" class="align-vertical">Medida</th>  
                                                        <?php foreach($datafiltrada as $codigo): ?>  
                                                            <th style="min-width: 150px;" class=" align-vertical"><?= $codigo["MEDIDA_NEW"];?></th>
                                                        <?php endforeach; ?>
                                                    </tr> 
                                                    <tr class="thead-fichas">
                                                        <th style="min-width: 50px;" class=" align-vertical">Desc.</th>  
                                                        <?php foreach($datafiltrada as $codigo): ?>  
                                                            <th style="min-width: 150px;" class="align-vertical"><?= $codigo["DESCRIPCION_MEDIDA"];?></th>
                                                        <?php endforeach; ?>
                                                    </tr> 
                                                </thead>
                                                <tbody>
                                                    <?php foreach($medidasregistras as $med): ?>  
                                                        <tr class="thead-fichas">

                                                            <td class="bg-secondary text-white <?= $med["MEDIDA"] == "0" ? "bg-medida-0" : "";?> ">
                                                                <?= $med["MEDIDA"];?>
                                                            </td>


                                                            <!-- CODIGO DE MEDIDAS -->
                                                            <?php foreach($datafiltrada as $codigo): ?>  

                                                                <?php $clase =  "selectmedidastallas_".$codigo["CODIGO_MEDIDA"]."_".$talla["TALLA"]; ?>

                                                                <?php
                                                                    $clasebg = "";

                                                                    if($med["MEDIDA"] == "0"){
                                                                        $clasebg = "bg-medida-0";
                                                                    }else{
                                                                        if(
                                                                            (
                                                                                $med["DC_MEDDEC"] != null &&  $med["DC_HASTA"] != null
                                                                            )    
                                                                                &&
                                                                            (
                                                                                (float)$codigo["TOLERANCIAMAS"] >= (float)$med["DC_MEDDEC"]     
                                                                                && 
                                                                                (float)$med["DC_MEDDEC"] >= (float)$codigo["TOLERANCIAMENOS"] 
                                                                            )
                                                                        ){
                                                                            $clasebg =    "bg-medida-tolerancias";
                                                                        }else{
                                                                            $clasebg =    "bg-white";
                                                                        }
                                                                    }
                                                                ?>

                                                                <td 
                                                                    data-idtalla="<?= $talla["IDTALLA"]; ?>" 
                                                                    data-talla="<?= $talla["TALLA"]; ?>" 
                                                                    data-codigo="<?= $codigo["CODIGO_MEDIDA"]; ?>" 
                                                                    data-medida="<?= $med["MEDIDA"]; ?>"


                                                                    class="
                                                                         align-vertical selectmedidastallas cursor-pointer 
                                                                        <?= $clase; ?> 
                                                                        <?= 
                                                                            $clasebg;
                                                                        ?>  
                                                                    " 
                                                                    >

                                                                        <?php 
                                                                            $data_por_medidas = array_filter($validacionmedidas_detalle,array( 
                                                                                new MedidasFilter($codigo["CODIGO_MEDIDA"],$talla["IDTALLA"],$med["MEDIDA"]),"getFiltro")
                                                                            );     
                                                                        ?>

                                                                        <?php foreach($data_por_medidas as $item): ?>

                                                                            <label class=" <?= $item["ADICIONAL"] == "1" ? "text-danger" : "text-dark"; ?> font-weight-bold label<?= $item["NUMEROPRENDA"] ?> mr-1 "> <?= $item["NUMEROPRENDA"] ?> </label>

                                                                        <?php endforeach; ?>


                                                                </td>
                                                            <?php endforeach; ?>
                                                        </tr>
                                                    <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        

                                    </div>

                                    <?php $activetallas = false; ?>

                                    
                                <?php endforeach; ?>

                                                                                

                            </div>

                            <div class="col-md-2"></div>
                            <!-- ESTADO ASIGNADO -->
                            <div class="col-md-3">
                                <label for="">Estado Asignado</label>                                                                          
                                <select name="" id="cboestadoasignado" class="custom-select custom-select-sm">
                                    <option <?= $valimedidas_estado == "" ? "selected" : ""; ?> value="">[SELECCIONE]</option>  
                                    <option <?= $valimedidas_estado == "APROBADO" ? "selected" : ""; ?> value="APROBADO">APROBADO</option>  
                                    <option <?= $valimedidas_estado == "APROBADO NO COFORME" ? "selected" : ""; ?> value="APROBADO NO COFORME">APROBADO NO COFORME</option>
                                    <option <?= $valimedidas_estado == "RECHAZADO" ? "selected" : ""; ?> value="RECHAZADO">RECHAZADO</option>  
                                </select>
                            </div>

                            <div class="col-md-7"></div>                                                

                            <!-- COMENTARIO -->
                            <div class="col-md-8 mt-2">
                                <label for="">Comentario de medidas:</label>
                                <textarea class="form-control form-control-sm" name="" id="txtcomentariomedidas"  rows="2"><?= $valimedidas_comentario;?></textarea>                                                                            
                            </div>

                        </div>

                        <!-- VOLVER -->
                        <div class="row justify-content-md-center">
                                                                            
                            <div class="col-md-2 mt-2">
                                <button class="btn btn-secondary btn-block btn-sm" type="button" id="btnvolverprendas">Volver</button>
                            </div>                                                                          

                        </div>

                        <!-- GUARDAR COMENTARIO -->
                        <div class="row justify-content-md-center">
                            
                            <?php if($valimedidas_estado == ""): ?>

                                <div class="col-md-2 mt-2">
                                    <button class="btn btn-secondary btn-block btn-sm" type="button" id="btnguardarcomentariomedidas">Guardar</button>
                                </div>      

                            <?php endif; ?>                                                                    

                        </div>


                        <!-- FINALIZAR -->
                        <div class="row justify-content-md-center">
                            
                            <?php if($valimedidas_estado == ""): ?> 
                                <div class="col-md-2 mt-2">
                                    <button class="btn btn-secondary btn-block btn-sm" type="button" id="btnfinalizarmedidas">Finalizar</button>
                                </div>                                                                            
                            <?php endif; ?>

                        </div>
                        
                    <?php endif; ?>
                    
                    
                </div>

                <!-- RESULTADOS -->
                <div class="container-fluid containerdatos d-none" id="container_resultados">

                    <h4 class="text-white font-weight-bold" id="lblResultados">
                        4. RESULTADOS: <?= $estadofinal; ?>
                    </h4> 

                    <div class="row">

                        <div class="col-md-12 mb-4">

                            <label for="" class="font-weight-bold">
                                1. Validación de Documentación: <?= $estadodocumentos; ?>
                            </label>
                            <br>
                            <label class="font-weight-bold ml-5">
                                Comentario: <?= $comentariodocumentos; ?>
                            </label>     

                        </div>      

                        <div class="col-md-12 ">

                            <label for="" class="font-weight-bold">
                                2. Defectos: <?= $estadodefectos; ?>
                            </label>

                            <br>

                            <label class="font-weight-bold ml-5">
                                Comentario: <?= $comentariodefectos; ?>
                            </label>  
                        </div>     


                    </div>

                    <div class="row justify-content-md-center mb-4" >
                                                
                        <div class="col-md-8">

                            <div class="table-responsive">

                                <table class="table table-bordered table-sm text-center responsive nowrap" id="tabledefectosresultado" style="width:100%">
                                    <thead class="thead-sistema-new">
                                        <tr>
                                            <th class="border-table" data-priority="1"> CÓDIGO</th>
                                            <th class="border-table">DEFECTO</th>
                                            <th class="border-table" data-priority="2">CANTIDAD</th>
                                            <th class="border-table">OBSERVACION</th>
                                        </tr>
                                    </thead>                                            
                                    <tbody id="tbodydefectosresultado">

                                    </tbody>
                                </table>

                            </div>

                            

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="font-weight-bold">
                                3. Validación de Medidas: <?= $valimedidas_estado; ?>  
                            </label>

                            <br>

                            <label class="font-weight-bold ml-5">
                                Comentario: <?= $valimedidas_comentario; ?>
                            </label> 
                        </div>  
                    </div>

                </div>


                <!-- TABS FIJOS BOTTOM -->
                <div class="row fixed-bottom justify-content-md-center">

                    <div class="col-lg-8 col-md-12 col-sm-12 col-12">

                        <div class="card" >

                            <div class="card-body p-0">


                                 <ul class="list-group list-group-horizontal text-center">
                                    <li class="font-weight-bold w-25 list-group-item opcionesnav active p-0" data-container="documentacion" id="nav_1">
                                        1 <br> Val. Doc
                                    </li>
                                    <li class="font-weight-bold w-25 list-group-item opcionesnav p-0" data-container="defectos" id="nav_2">
                                        2. <br> Defectos
                                    </li>
                                    <li class="font-weight-bold w-25 list-group-item opcionesnav p-0" data-container="medidas" id="nav_3">
                                        3. <br> V. Medida
                                    </li>
                                    <li class="font-weight-bold w-25 list-group-item opcionesnav p-0" data-container="resultados" id="nav_4">
                                        4. <br> Resultado
                                    </li>
                                </ul>

                            </div>

                        </div>

                    </div>

                </div>




            <?php endif; ?>

    </div>

    <!-- MODAL TEMPORADAS -->
    <div class="modal fade" id="modaltemporadas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SELECCIÓN DE TEMPORADA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>Cliente</th>
                            <th>Temporada</th>
                        </tr>
                    </thead>
                    <tbody id="tbodytemporada">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
            </div>
        </div>
    </div>


    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>

    <!-- MDB -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script> -->


    <!-- PROPIOS -->
    <script src="../../js/lavados/prenda/funciones.js"></script>

    <script>


        //let     frmbusqueda     = document.getElementById("frmbusqueda");
        let     checks                  = document.getElementsByClassName("checks");
        let     chkcodmaquinalavado     = document.getElementById("chkcodmaquinalavado");
        
        // try{
            const   frmvalidaciondocumentos = document.getElementById("frmvalidaciondocumentos");
            const   frmregistrodefectos     = document.getElementById("frmregistrodefectos");
            const   frmsinvalidacion        = document.getElementById("frmsinvalidacion");
        // }catch{
        //     console.log("error");
        //     const   frmvalidaciondocumentos = null;
        //     const   frmregistrodefectos     = null;
        // }
        
        let FICHA               = null;
        let PARTE               = null;
        let NUMVEZ              = null;
        let CANTIDAD            = null;
        let CANTIDADTOTAL       = null;
        let IDFICHA             = null;
        let NUMPRENDA           = 1;
        let PRENDAADICIONAL     = 0;
        let TALLA               = "<?=  isset($_GET["talla"])  ? $_GET["talla"] : ''; ?>"  == "" ? null : "<?=  isset($_GET["talla"])  ? $_GET["talla"] : ''; ?>";
        // let IDHEADMEDIDA        = ;

        

        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {

            // ACTIVAMOS TAB
            changeNavs( $("#nav_<?= $TAB_ITEM;?>") );

            // OBTENEMOS DEFECTOS PARA AGREGAR
            await getDefectos("<?= $IDFICHA;?>");

            // OBTENEMOS DEFECTOS AGREGADOS
            await getDefectosAgregados("<?= $IDFICHA;?>");

            // GET MAQUINAS AGREGADAS
            await getMaquinasAgregadas("<?= $IDFICHA;?>","<?= $tipomaquina_documentos;?>");

            // MOSTRAMOS TALLAS
            if(TALLA != null){
                changeTallas( $("#a_collapse_"+TALLA ) );
            }




            $("#lblmostrardatos").click(function(){

                let string = $("#lblmostrardatos").text();
                $("#lblmostrardatos").text(string == "Mostrar Datos" ? "Ocultar Datos" : "Mostrar Datos");

            });


            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });

        

        // OPCIONES
        $(".opcionesnav").click(function(){
            changeNavs(this);
        });


        // CAMBIAR CHECKS
        for(let check of checks){

            check.addEventListener('change',(e)=>{
                let id      =   check.id;
                let activo  =   check.checked;

                document.getElementById(`lbl${id}`).innerText = activo ? "SI" : "NO";
                // console.log(id,activo);
            });
            

        }

        if(chkcodmaquinalavado != null){

            chkcodmaquinalavado.addEventListener('change',async (e)=>{

                MostrarCarga();
                let id      =   chkcodmaquinalavado.id;
                let activo  =   chkcodmaquinalavado.checked;

                if(activo){

                    document.getElementById(`lbl${id}`).innerText = "SERVICIO";
                    let response = await get("auditex-lavanderia", "lavadoprenda", "get-talleres-lavanderia", {});
                    setComboSimple("cbomaquinalavado",response,"DESCRIPCIONCORTA","IDTALLER",false,false);
                    OcultarCarga();
                    
                }else{

                    document.getElementById(`lbl${id}`).innerText = "PLANTA";
                    let response = await get("auditex-lavanderia", "lavadoprenda", "get-maquinas-lavanderia", {});
                    setComboSimple("cbomaquinalavado",response,"DESC","IDLAVADORA",false,false);
                    OcultarCarga();

                }

            });

        }

        

        // INICIAR AUDITORIA
        function IniciarAuditoria(idficha,ficha,parte,numvez,cantidad,usuario){

            MostrarCarga();
            
            get("auditex-lavanderia", "lavadoprenda", "set-lavadoprenda", {
                opcion:1,
                idficha,
                ficha,
                parte,
                numvez,
                cantficha:cantidad,
                cantpartir:cantidad,
                usuario

            }).then(response => {

                // console.log("RESPONSE",response);
                window.location = `registroprenda.view.php?ficha=${ficha}&id=${response.ID}`;

            }).catch(error => {

            });

        }


        // INICIAR AUDITORIA (REGISTRAR)
        $("#btniniciar").click(async function(){

            // let ficha       = $(this).data("ficha");
            // let parte       = $(this).data("parte");
            // let numvez      = $(this).data("numvez");
            // let cantidad    = $(this).data("cantidad");
            let usuario     = "<?= $_SESSION["user"]; ?>"; 
            // let idficha     = $(this).data("idficha");

            IniciarAuditoria(IDFICHA,FICHA,PARTE,NUMVEZ,CANTIDAD,usuario);

        });

        // PARTIR FICHAS
        $("#btnpartir").click(function(){

            let canttotal   = CANTIDADTOTAL;
            let cantficha   = CANTIDAD;
            let ficha       = FICHA;
            let parte       = PARTE;
            let numvez      = NUMVEZ;
            let idficha     = IDFICHA;
            let usuario     = "<?= $_SESSION["user"]; ?>"; 

            let cantmax =  cantficha == "" ? parseFloat(canttotal) : parseFloat(cantficha);

            Obtener("Ingrese cantidad para particionar","number")
            .then(response => {


                // SOLO SI INGRESO INFORMACION
                if(response){

                    let cantpartir = parseFloat(response);

                    // REALIZAMOS PARTICION
                    if(cantpartir < cantmax){

                        MostrarCarga();
                        get("auditex-lavanderia", "lavadoprenda", "set-lavadoprenda", {
                            opcion:2,
                            ficha,
                            parte,
                            numvez,
                            cantficha,
                            cantpartir,
                            usuario,
                            idficha

                        }).then(response => {

                            // console.log("RESPONSE partir",response);
                            window.location = `registroprenda.view.php?ficha=${ficha}&id=${response.ID}`;

                        }).catch(error => {
                            Advertir("Ocurrio un error al particionar ficha");
                        });



                    }else{
                        Advertir("La cantidad no puede ser mayor o igual a la cantidad total");
                    }

                }


            }).catch(error => {

            });

        });

        // VER AUDITORIA
        $(".verauditoria").click(async function(){

            let ficha       = $(this).data("ficha");
            let id          = $(this).data("id");

            // IniciarAuditoria(ficha,parte,numvez,cantidad,usuario);
            MostrarCarga();
            window.location = `registroprenda.view.php?ficha=${ficha}&id=${id}`;
        });


        // SELECCIONAMOS FICHA PARA INICIAR AUDITORIA
        $(".selectfichas").click(function (){

            $(".btn-opciones").addClass("d-none");

            // let resultado   = $(this).data("resultado");
            let usuario   = $(this).data("usuario");


            FICHA           = $(this).data("ficha");
            PARTE           = $(this).data("parte");
            NUMVEZ          = $(this).data("numvez");
            CANTIDAD        = $(this).data("cantficha");
            IDFICHA         = $(this).data("idficha");
            CANTIDADTOTAL   = $(this).data("canttotal");


            // console.log(ficha,parte,numvez,canttotal,cantficha,idficha);

            if(usuario == ""){

                $(".btn-opciones").removeClass("d-none");


            }else{
                MostrarCarga();
                window.location = `registroprenda.view.php?ficha=${FICHA}&id=${IDFICHA}`;
            }


        });


        // PARTICIONAR FICHA
        $(".particionarficha").click(function(){

            let canttotal = $(this).data("canttotal");
            let cantficha = $(this).data("cantficha");
            let ficha       = $(this).data("ficha");
            let parte       = $(this).data("parte");
            let numvez      = $(this).data("numvez");
            let idficha     = $(this).data("idficha");
            let usuario     = "<?= $_SESSION["user"]; ?>"; 


            let cantmax =  cantficha == "" ? canttotal : cantficha;

            Obtener("Ingrese cantidad para particionar","number")
            .then(response => {


                // SOLO SI INGRESO INFORMACION
                if(response){

                    let cantpartir = parseFloat(response);

                    // REALIZAMOS PARTICION
                    if(cantpartir < cantmax){

                        MostrarCarga();
                        get("auditex-lavanderia", "lavadoprenda", "set-lavadoprenda", {
                            opcion:2,
                            ficha,
                            parte,
                            numvez,
                            cantficha,
                            cantpartir,
                            usuario,
                            idficha

                        }).then(response => {

                            // console.log("RESPONSE partir",response);
                            window.location = `registroprenda.view.php?ficha=${ficha}&id=${response.ID}`;

                        }).catch(error => {
                            Advertir("Ocurrio un error al particionar ficha");
                        });



                    }else{
                        Advertir("La cantidad no puede ser mayor o igual a la cantidad total");
                    }

                }


            }).catch(error => {

            });
            

        });

        // CERRAR REGISTRO DE DEFECTOS
        $("#btncerrarregistrodefectos").click(function(){

            let comentario = document.getElementById("txtobservaciondefectos").value;
            cerrarregistrodefectos("<?= $IDFICHA;?>",comentario,"<?= $_SESSION["user"]; ?>");

        });

        if(frmvalidaciondocumentos != null){

            // EVENTOS DE REGISTRO DE VALIDACION DE DOCUMENTOS
            frmvalidaciondocumentos.addEventListener('submit',(e)=>{
                e.preventDefault();
                saveValidacionDocumentacion("<?= $IDFICHA;?>","APROBADO","<?= $_SESSION["user"]; ?>");
            });

        }

        if(frmregistrodefectos != null){

            // EVENTO DE REGISTRO DE DEFECTOS
            frmregistrodefectos.addEventListener('submit',(e)=>{
                e.preventDefault();
                saveDefectos("<?= $IDFICHA;?>","<?= $_SESSION["user"]; ?>");
            });

        }

        // REGISTRAR VALIDACION SIN MEDIDAS
        if(frmsinvalidacion != null){

            frmsinvalidacion.addEventListener('submit',(e)=>{
                e.preventDefault();

                let estado = $("#cboestadoasignado").val();
                let comentario = $("#txtcomentariomedidas").val().trim();

                if(estado != ""){

                    MostrarCarga();

                    // FINALIZAMOS REGISTROS
                    cerrarMedidas(
                        [5,<?= $validacionmedidas_id; ?> ,<?= $IDFICHA; ?>,null,null,comentario,"<?= $_SESSION["user"]; ?>",null,estado,null]
                    );
                    // OCULTAMOS CARGA
                    OcultarCarga();

                }else{
                    Advertir("Ingrese estado");
                }
                


            });

        }

        
        $("#chkvalidacionmedidas").change(function(){

            let checked = $(this).prop("checked");

            // PARA AGREGAR MEDIDAS
            if(checked){
                $(".prendasportalla").removeClass("d-none");

                $(".sinvalidacionmedidas").addClass("d-none");

            }else{

                $(".prendasportalla").addClass("d-none");

                $(".sinvalidacionmedidas").removeClass("d-none");

            }

            

        });
        

        // PARA SELECCIONAR TALLAS
        $(".atallas").click(function(){

            changeTallas(this);

        });


        // CAMBIAMOS TALLAS
        function changeTallas(control){

            // RESTEAMOS PRENDAS A PRENDA (1)
            NUMPRENDA = 1;
            PRENDAADICIONAL = 0;
            $(".liprendas").removeClass("active");
            $("#li_prendas_"+NUMPRENDA).addClass("active");


            $(".litallas").removeClass("active");
            $(".divtallas").collapse("hide");

            TALLA  = $(control).data("talla");
            $("#lbltallaactiva").text("TALLA: " + TALLA);

            $("#li_collapse_"+TALLA).addClass("active");
            $("#div_collapse_"+TALLA).collapse("show");

        }


        // PARA SELECCIONAR PRENDAS
        $(".aprendas").click(function(){

            $(".liprendas").removeClass("active");
            // $(".divtallas").collapse("hide");

            // let talla = $(this).data("talla");
            NUMPRENDA           = $(this).data("numprenda");
            PRENDAADICIONAL     = $(this).data("adicional");


            $("#li_prendas_"+NUMPRENDA).addClass("active");
            // $("#div_collapse_"+talla).collapse("show");

        });

        

            

                // ASINAMOS TALLA
                $(".selectmedidastallas").click(function(){

                    let codigo      = $(this).data("codigo");
                    let talla       = $(this).data("talla");
                    let idtalla     = $(this).data("idtalla");
                    let medida      = $(this).data("medida");
                    let control     = $(this);

                    // REMOVEMOS
                    setMedidaDetalle(codigo,idtalla,NUMPRENDA,medida,function(){


                        let clase = `.selectmedidastallas_${codigo}_${talla}`;

                        let clasemedida = $(clase);


                        // RECORREMOS LAS CLASES
                        for(let item of clasemedida){

                            let children = $(item).children();

                            if(children.length > 0){

                                // RECORREMOS CHILDREN
                                for(let child of children){

                                    if( $(child).hasClass(`label${NUMPRENDA}`) ){
                                        $(child).remove();
                                    }
                                }

                            }

                        }

                        // AGREGAMOS
                        if(PRENDAADICIONAL == "0"){
                            $(control).append(`<label class='text-dark font-weight-bold label${NUMPRENDA} mr-1 '>${NUMPRENDA}</label>`);                    
                        }else{
                            $(control).append(`<label class='text-danger font-weight-bold label${NUMPRENDA} mr-1 '>${NUMPRENDA}</label>`);
                        }

                        OcultarCarga();

                        // console.log("teminado");



                    });


                });


        // REGISTRAMOS MEDIDA DETALLE
        function setMedidaDetalle(codigomedida,idtalla,numeroprenda,valor,callback){

            MostrarCarga();


            post("auditex-lavanderia", "lavadoprenda", "set-medidas-det",
                [ <?= $validacionmedidas_id; ?> ,codigomedida,idtalla,numeroprenda,valor,"<?= $_SESSION["user"]; ?>"]
            ).then(response => {

                if(response.success){
                    callback();
                }else{
                    Advertir("Ocurrio un error");
                }



            }).catch(error => {

            });

        }

        // GENERAR MEDIDAS
        $("#btngenerarmedidas").click(function(){

            let numeroprendas       = $("#txtnumeroprendas_medida").val().trim();
            let num_adicionales     = $("#txtadicionales_medida").val().trim();
            let llevaregistro       = $("#chkvalidacionmedidas").prop("checked") ? "1" : "0";
            let chkfichasige        = "<?= $fichasige; ?>";
            if(chkfichasige == "1"){
                chkfichasige            = true;
            }else{
                chkfichasige            = $("#chkfichasige").prop("checked") ? true : false;
            }

            MostrarCarga();

            if(numeroprendas != ""){


                // SI ES FICHA SIGE
                if(chkfichasige){


                    VerificaMedidasSIGE()
                    .then(response =>{

                        if(response.cant == "1" ){

                            // MOSTRAMOS MODAL PARA SELECCIONAR TEMPORADA
                            let estilotsc = '<?= $estilotsc; ?>';
                            // estilotsc = estilotsc.split("-")[0];
                            get("auditex-lavanderia", "lavadoprenda", "get-temporadas-sige",{ estilotsc })
                                .then(temporadas => {

                                    let tr = ``;

                                    for(let tem of temporadas){

                                        tr += `
                                            <tr data-temcli='${tem.Cod_TemCli}' data-temporada='${tem.Nom_TemCli}'  class="selecttemporada" >
                                                <td>${tem.Des_Cliente}</td>
                                                <td>${tem.Nom_TemCli}</td>
                                            </tr>
                                        `;

                                    }

                                    $("#tbodytemporada").html(tr);
                                    $("#modaltemporadas").modal("show");

                                    Informar("Temporadas Cargadas",1500);

                                });

                        }

                        if(response.cant  == 0){
                            Advertir("El Estilo no tiene las medidas cargadas");
                        }

                    })
                    .catch(error => {

                        Advertir("Error verificando medidas");

                    })


                }else{
                // SI NO ES FICHA SIGE
                    VerificaMedidas()
                    .then(response =>{

                        if(response.CANTIDAD > 0 ){

                            post("auditex-lavanderia", "lavadoprenda", "set-generar-medidas",
                                [1,<?= $validacionmedidas_id; ?> ,<?= $IDFICHA; ?>,numeroprendas,num_adicionales,null,"<?= $_SESSION["user"]; ?>",llevaregistro,null]
                            ).then(response => {
                                window.location = `registroprenda.view.php?ficha=<?= $fichainicio; ?>&id=<?= $IDFICHA; ?>&tab=3&generar=1`;
                            }).catch(error => {
                                Advertir("Error en Ajax");
                            });

                        }

                        if(response.CANTIDAD  == 0){
                            Advertir("El Estilo no tiene las medidas cargadas");
                        }

                    })
                    .catch(error => {

                        Advertir("Error verificando medidas");

                    })
                }

            }else{
                Advertir("Ingrese numero de prendas")
            }

        });

        // VOLVER A LAS MEDIDAS
        $("#btnvolverprendas").click(function(){

            MostrarCarga();
            window.location = `registroprenda.view.php?ficha=<?= $fichainicio; ?>&id=<?= $IDFICHA; ?>&tab=3`;

        });

        // AMPLIAR Y RECUDIR PULGADAS
        $("#btnampliarpulgadas").click(function (){

            MostrarCarga();

            post("auditex-lavanderia", "lavadoprenda", "set-generar-medidas", 
                    [2,<?= $validacionmedidas_id; ?> ,null,null,0,null,null,null,null,null]
                ).then(response => {

                    // console.log(response);

                    // if(response.success){
                        // OcultarCarga();
                        // location.reload();
                        window.location = `registroprenda.view.php?ficha=<?= $fichainicio; ?>&id=<?= $IDFICHA; ?>&tab=3&generar=1&talla=${TALLA}`;
                        // window.location = `registroprenda.view.php?ficha=<?= $fichainicio; ?>&id=<?= $IDFICHA; ?>&tab=3&generar=1`;
                    // }else{
                        // Advertir("Ocurrio un error al generar las medidas");
                    // }



                }).catch(error => {
                    Advertir("Error en Ajax");
                });
        });

        // GUARDAR COMENTARIO
        $("#btnguardarcomentariomedidas").click(function(){

            let comentario = $("#txtcomentariomedidas").val().trim();

            MostrarCarga();

            post("auditex-lavanderia", "lavadoprenda", "set-generar-medidas", 
                    [3,<?= $validacionmedidas_id; ?> ,null,null,0,comentario,null,null,null,null]
                ).then(response => {

                    // console.log(response);

                    // if(response.success){
                        OcultarCarga();
                    // }else{
                        // Advertir("Ocurrio un error al generar las medidas");
                    // }



                }).catch(error => {
                    Advertir("Error en Ajax");
                });

        });

        $("#tbodytemporada").on('click','.selecttemporada',async function(){

            let codtemporada = $(this).data("temcli");
            let temporada = $(this).data("temporada");
            let estilotsc = '<?= $estilotsc; ?>';


            let rpt = await Preguntar("Confirme para registrar medidas de la temporada "+ temporada);

            if(rpt.value){

                let response = await get("auditex-lavanderia", "lavadoprenda", "set-medidas-sige",{ estilotsc,codtemporada });
                if(response.success){

                    MostrarCarga();

                    let numeroprendas       = $("#txtnumeroprendas_medida").val().trim();
                    let num_adicionales     = $("#txtadicionales_medida").val().trim();
                    let llevaregistro       = $("#chkvalidacionmedidas").prop("checked") ? "1" : "0";

                    post("auditex-lavanderia", "lavadoprenda", "set-generar-medidas",
                        [1,<?= $validacionmedidas_id; ?> ,<?= $IDFICHA; ?>,numeroprendas,num_adicionales,null,"<?= $_SESSION["user"]; ?>",llevaregistro,null,'1']
                    ).then(response => {
                        window.location = `registroprenda.view.php?ficha=<?= $fichainicio; ?>&id=<?= $IDFICHA; ?>&tab=3&generar=1`;
                    }).catch(error => {
                        Advertir("Error en Ajax");
                    });

                }else{
                    Advertir("Ocurrio un problema al migrar medidas");
                }
                // console.log("response 123",response);

            }
            // console.log(temcli);

        });

        // FINALIZAR MEDIDAS
        $("#btnfinalizarmedidas").click(function (){

            let estado = $("#cboestadoasignado").val();
            let comentario = $("#txtcomentariomedidas").val().trim();

            //  VALIDAMOS ESTADO
            if(estado != ""){

                MostrarCarga();

                post("auditex-lavanderia", "lavadoprenda", "set-generar-medidas",
                        [4,<?= $validacionmedidas_id; ?> ,null,null,0,comentario,null,null,null,null]
                    ).then(response => {

                        if(response.length == 0){

                            // FINALIZAMOS REGISTROS
                            cerrarMedidas(
                                [5,<?= $validacionmedidas_id; ?> ,<?= $IDFICHA; ?>,null,null,comentario,"<?= $_SESSION["user"]; ?>",null,estado,null]
                            );
                            // OCULTAMOS CARGA
                            OcultarCarga();

                        }else{

                            let mensaje = "";

                            for(let item of response){
                                mensaje += `
                                    Talla Faltante ${item.TALLA}:  ${item.CANTFALTANTE}
                                `;
                            }

                            Preguntar(mensaje + " Confirme para cerrar registro")
                                .then(response => {

                                    if(response.value){

                                        // FINALIZAMOS REGISTROS
                                        cerrarMedidas(
                                            [5,<?= $validacionmedidas_id; ?> ,<?= $IDFICHA; ?>,null,null,comentario,"<?= $_SESSION["user"]; ?>",null,estado,null]
                                        );
                                        // OCULTAMOS CARGA
                                        OcultarCarga();

                                    }

                                }).catch(error => {
                                    Advertir("Error al preguntar");
                                })

                        }


                    }).catch(error => {
                        Advertir("Error en Ajax");
                    });
            
            }else{
                Advertir("Ingrese un estado para cerrar el registro");
            }


        });

        function cerrarMedidas(parameters){
            post("auditex-lavanderia", "lavadoprenda", "set-generar-medidas", 
                    parameters
                ).then(response => {

                    if(response){
                        window.location = `registroprenda.view.php?ficha=<?= $fichainicio; ?>&id=<?= $IDFICHA; ?>&tab=4`;
                        OcultarCarga();
                    }else{

                        Advertir("Ocurrio un error al finalizar registro");


                    }

                    // console.log("response cerrar medidas",response);


                }).catch(error => {
                    Advertir("Error en Ajax");
                });
        }

        // VEFIFICA SI TIENE MEDIDAS CARGADAS
        async function VerificaMedidas(){

            return await get("auditex-lavanderia", "lavadoprenda", "get-verifica-medidas",{ idficha: '<?= $IDFICHA; ?>' });

        }

        // VEFIFICA SI TIENE MEDIDAS CARGADAS SIGE
        async function VerificaMedidasSIGE(){

            return await get("auditex-lavanderia", "lavadoprenda", "get-verifica-medidas-sige",{ estilotsc: '<?= $estilotsc; ?>' });

        }


    </script>


</body>

</html>