<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';


    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo = new CoreModelo();

    $_SESSION['navbar'] = "Auditex Lavanderia Paño";

    // SELECTS
    $codigosdelavados   = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[1,null]);
    $codigossecadoras   = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[2,null]);
    $tiposlavados       = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[3,null]);

    //  FICHA INICIO
    $fichainicio    = isset($_GET["ficha"]) ? $_GET["ficha"]    : false;
    $IDFICHA        = isset($_GET["id"])    ? $_GET["id"]       : false;

    $datafichas     = [];
    $llevalavado    = false;
    $dataficha      = null;
    $estado_final   = "";
    $etapasfichas   = [];
    $item_validacion_documentacion      = null;
    $item_verificacion                  = null;
    $item_defectos                      = null;

    // TAB SELECCIONADO
    $TAB_ITEM       = isset($_GET["tab"])    ? $_GET["tab"]       : "1";


    // DOCUMENTOS 
    $chkmuestraaprobada         = "";
    $chkreportecorte            = "";
    $chkcomplementorectilineo   = "";
    $cbomaquinalavado           = "";
    $cbomaquinasecadora         = "";
    $cbotipolavado              = "";
    $comentariodocumentos       = "";
    $estado_documentos          = "";
    $tipomaquina_documentos     = "PLANTA";
    $link_fechatecnica          = [];
    $chkcodmaquinalavado        = "";


    // VERIFICACION
    $densidadbefore_verificacion    = "";
    $densidadafter_verificacion     = "";
    $largopanoasignado_verificacion = "";

    $matching_verificacion          = "";
    $tacto_verificacion             = "";
    $aparienciapano_verificacion    = "";
    $nivelpilling_verificacion      = "";
    $observacion_verificacion       = "";
    $estado_verificacion            = "";

    // DEFECTOS
    $estado_defectos                = "";
    $comentario_defectos            = "";

    // MEDIDA DE PAÑOS
    $etapas_medidas                 = [];
    $data_medidas                   = null;
    $estado_medidas                 = "";
    $observacion_medidas            = "";
    
    

    if($fichainicio){

        // EJECUTAMOS PARA CARGA DE DATOS SI NO EXISTE
        $responseficha = $objModelo->setAll("USYSTEX.SPU_SETPARTIDA_AUDITEX",[$fichainicio],"ok");

        // EMPEZAMOS BUSQUEDA
        $datafichas     = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[1,null,$fichainicio]);

        if( count($datafichas) > 0 ){
            $llevalavado = $datafichas[0]["LAVADO"] > 0 ? true : false;
        }

        // BUSCAMOS ETAPAS
        $etapasfichas   = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[3,null,$fichainicio]);

        if( count($etapasfichas) > 0 ){

            $chkreportecorte = "checked";

        }

        

    }

    if($IDFICHA){
        // DATOS DE LA FICHA REGISTRADA
        $dataficha = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[2,$IDFICHA,$fichainicio]);

        // DENSIDADES
        $densidadbefore_verificacion    = $dataficha["DENSIDAD_BEFORE"];
        $densidadafter_verificacion     = $dataficha["DENSIDAD_AFTER"];

        // ESTADO FINAL
        $estado_final                   = $dataficha["RESULTADOFINAL"];


        // ITEM DE VALIDACION DE DOCUMENTACION
        $item_validacion_documentacion   = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[4,$IDFICHA,$fichainicio]);

        if($item_validacion_documentacion){

            $chkmuestraaprobada         = $item_validacion_documentacion["MUESTRAAPROBADA"] == "1" ? "checked" : "";


                         
            $chkreportecorte            = $item_validacion_documentacion["REPORTEDECORTE"] == "1" ? "checked" : "";


            $chkcomplementorectilineo   = $item_validacion_documentacion["COMPLEMENTORECTILINEO"] == "1" ? "checked" : "";
            // $cbomaquinalavado           = $item_validacion_documentacion["IDLAVADORA"] != "" ? $item_validacion_documentacion["IDLAVADORA"] : "";
            // $cbomaquinasecadora         = $item_validacion_documentacion["IDSECADORA"] != "" ? $item_validacion_documentacion["IDSECADORA"] : "";
            $cbotipolavado              = $item_validacion_documentacion["IDTIPOLAVADO"]  != "" ? $item_validacion_documentacion["IDTIPOLAVADO"] : "";
            $comentariodocumentos       = $item_validacion_documentacion["COMENTARIO"]  != "" ? $item_validacion_documentacion["COMENTARIO"] : "";
            $estado_documentos          = $item_validacion_documentacion["ESTADO"] != "" ? $item_validacion_documentacion["ESTADO"] : "";
            $tipomaquina_documentos     = $item_validacion_documentacion["TIPOLAVADORA"] == "" ? "PLANTA" : $item_validacion_documentacion["TIPOLAVADORA"]; 
            $chkcodmaquinalavado        = $item_validacion_documentacion["TIPOLAVADORA"] == "SERVICIO" ? "checked" : "";

        }

        // ITEM DE VERIFICACION
        $item_verificacion              = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[5,$IDFICHA,$fichainicio]);

        if($item_verificacion){

            $densidadbefore_verificacion    = $item_verificacion["DENSIDAD_BEFORE"];
            $densidadafter_verificacion     = $item_verificacion["DENSIDAD_AFTER"];
            $largopanoasignado_verificacion = $item_verificacion["LARGOPANO_ASIGNADO"];

            $matching_verificacion          = $item_verificacion["MATCHING"] == "1" ? "checked" : "";
            $tacto_verificacion             = $item_verificacion["TACTO_CONTRAMUESTRA"] == "1" ? "checked" : "";
            $aparienciapano_verificacion    = $item_verificacion["APARIENCIA_PANO"] == "1" ? "checked" : "";
            $nivelpilling_verificacion      = $item_verificacion["NIVEL_PILLING_CONTRAMUESTRA"] == "1" ? "checked" : "";

            $observacion_verificacion       = $item_verificacion["COMENTARIO"];
            $estado_verificacion            = $item_verificacion["ESTADO"];

        }

        // ITEM DE DEFECTOS
        $item_defectos                  = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[8,$IDFICHA,$fichainicio]);

        if($item_defectos){

            $estado_defectos                = $item_defectos["ESTADO"];
            $comentario_defectos            = $item_defectos["COMENTARIO"];

        }

        // CABECERA DE MEDIDA DE PAÑOS
        $data_medidas       = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[10,$IDFICHA,$fichainicio]);

        // ITEM DE MEDIDAS DE PAÑO
        $etapas_medidas     = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[9,$IDFICHA,$fichainicio]);

        if($data_medidas){
            $estado_medidas         = $data_medidas["ESTADO"];
            $observacion_medidas    = $data_medidas["COMENTARIO"];
        }

        $link_fechatecnica = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHATECNICA",[ $dataficha["PEDIDO"] ]);


    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Lavanderia Paño</title>
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


            <!-- BUSQUEDA -->
            <?php if(!$IDFICHA): ?>

                <div class="container">

                    <form  id="frmbusqueda" autocomplete="off" method="GET" class="row justify-content-md-center">

                        <label for="" class="col-2 col-label font-weight-bold">Ficha:</label>

                        <div class="col-8">
                            <input type="number" class="form-control form-control-sm" name="ficha" value="<?= $fichainicio; ?>"  autofocus required>
                        </div>

                        <div class="col-2">
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

                    <label for="" class="mt-2 col-md-12 col-label font-weight-bold">Seleccione auditoria a consultar </label>
                    <label for="" class="mt-1 col-md-12 col-label font-weight-bold">Cantidad Ficha: <?= count($datafichas) > 0 ? $datafichas[0]["CANTOTALFICHA"] : "";  ?> </label>

                    <div class="row justify-content-center">

                        <div class="col-md-12 col-lg-10">

                            <div class="table-responsive" style="background: #fff;">

                                <table class="table table-sm table-bordered m-0 table-fichas text-center table-hover">
                                    <thead class="thead-sistema-new thead-fichas">
                                        <tr>
                                            <!-- <th  class="border-table w-bajo align-vertical" >Usuario</th> -->
                                            <!-- <th  class="border-table w-bajo-2 text-center" >Ficha</th> -->
                                            <!-- <th  class="border-table w-bajo-2 text-center align-vertical">Parte</th>
                                            <th  class="border-table w-bajo-2 text-center align-vertical">Vez</th>   
                                            <th  class="border-table w-bajo-2 text-center align-vertical">Cant. Part</th>
                                            <th  class="border-table w-bajo-2 text-center align-vertical">FEC. INICIO</th>
                                            <th  class="border-table w-bajo-2 text-center align-vertical">FEC. FIN</th>
                                            <th  class="border-table w-bajo text-center align-vertical">Resultado</th>  -->
                                            <!-- <th  class="border-table w-bajo-2 "></th> -->

                                            <th  class="border-table w-bajo align-vertical" >USUARIO</th>
                                            <th  class="border-table w-bajo-2 text-center align-vertical">PARTE</th>
                                            <th  class="border-table w-bajo-2 text-center align-vertical">VEZ</th>   
                                            <th  class="border-table w-bajo-2 text-center align-vertical">CANT. PART</th>

                                            <th  class="border-table w-bajo-2 text-center align-vertical">FEC. INICIO</th>
                                            <th  class="border-table w-bajo-2 text-center align-vertical">FEC. FIN</th>

                                            <th  class="border-table w-bajo text-center align-vertical">RESULTADO</th> 

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach($datafichas as $dficha): ?>

                                            <?php if($llevalavado): ?>

                                                <tr 
                                                    class="cursor-pointer selectfichas"
                                                        data-ficha="<?= $dficha["CODFIC"]; ?>"
                                                        data-parte="<?= $dficha["PARTE"]; ?>"
                                                        data-numvez="<?= $dficha["NUMVEZ"]; ?>"
                                                        data-canttotal="<?= $dficha["CANTIDADPARTIDA"]; ?>"
                                                        data-cantficha="<?= $dficha["CANTOTALFICHA"]; ?>"
                                                        data-idficha="<?= $dficha["IDFICHA"]; ?>"
                                                        data-resultado="<?= $dficha["RESULTADOFINAL"]; ?>"

                                                    >
                                                    <td class="text-center"> <?= $dficha["USUARIOCREA"]; ?> </td>
                                                    <td class="text-center"> <?= $dficha["PARTE"]   == "" ? 1 : $dficha["PARTE"]; ?> </td>
                                                    <td class="text-center"> <?= $dficha["NUMVEZ"]  == "" ? 1 : $dficha["NUMVEZ"]; ?> </td>
                                                    <td class="text-center"> <?= $dficha["CANTIDADPARTIDA"]; ?> </td>


                                                    <td class="text-center" nowrap> <?= $dficha["FECHACREA"]; ?> </td>
                                                    <td class="text-center" nowrap> <?= $dficha["FECHACIERRE"]; ?> </td>

                                                    <td class="text-center"> <?= $dficha["RESULTADOFINAL"]; ?> </td>

                                                    
                                                </tr>

                                            <?php  else: ?>

                                                <tr>
                                                    <td colspan="7">La Ficha no lleva Lavado de Paño</td>  
                                                </tr>

                                            <?php  endif; ?>

                                            

                                        <?php endforeach;?>

                                    </tbody>
                                </table>

                            </div>

                        </div>

                        <div class="col-md-2 col-lg-3  mt-2 ">
                            <button class="btn d-none btn-block btn-sm btn-sistema btn-opciones" id="btniniciar" type="button">Iniciar</button>  
                        </div>
                        <div class="col-md-2 col-lg-3 mt-2">
                            <button class="btn d-none btn-block btn-sm btn-warning btn-opciones" id="btnpartir" type="button">Partir</button>  
                        </div>

                    </div>



                </div>

                                    

            <?php endif; ?>

                                            
           

            



            <!-- DATOS DE LA FICHA -->
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
                                <a href="#"  data-toggle="collapse" data-target=".multi-collapse" >Mostrar Datos</a>
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
                                <a href="registropanio.view.php?ficha=<?= $fichainicio;?>" class="btn btn-sm  btn-warning">
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

                    <h4 class="text-white font-weight-bold" >
                        1. VALIDACIÓN DE DOCUMENTACIÓN: <?= $estado_documentos ?>
                    </h4>

                    <div class="row">
                        <label class="col-label col-md-2">Etapas de Ficha:</label>

                        <?php foreach($etapasfichas as $etapa): ?>
                            <div class="col-6 col-sm-2 col-md-2 col-lg-1">
                                <button class="btn btn-sm btn-block btn-sistema"><?= $etapa["ETAPA"] ?></button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <form action="" class="row justify-content-center" id="frmvalidaciondocumentacion">

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
                                                    </span>
                                                    <a class="float-right text-white mr-5" href="<?= $fila["RUTAARCHIVO"] ?>" target="_blank" title="Ruta de Ficha Técnica">  
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>

                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                </table>


                            </div>

                        <?php endif; ?>

                        <!-- MUESTRA APROBADA -->
                        <div class="col-8">
                            <label for="">Muestra aprobada:</label>
                        </div>

                        <div class="col-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="chkmuestraaprobada" <?= $chkmuestraaprobada; ?> >
                                <label class="custom-control-label" for="chkmuestraaprobada" id="lblchkmuestraaprobada"> 
                                    <?= $chkmuestraaprobada == "" ? "NO" : "SI"; ?>
                                </label>
                            </div>
                        </div>

                        <!-- REPORTE DE CORTE -->
                        <div class="col-8">
                            <label for="">Reporte de Corte:</label>
                        </div>

                        <div class="col-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="chkreportecorte" <?= $chkreportecorte; ?> >
                                <label class="custom-control-label" for="chkreportecorte" id="lblchkreportecorte"> 
                                    <?= $chkreportecorte == "" ? "NO" : "SI"; ?>
                                </label>
                            </div>
                        </div>

                        <!-- COMPLEMENTO RECTILINEO -->
                        <div class="col-8">
                            <label for="">Complemento Rectilíneo:</label>
                        </div>

                        <div class="col-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="chkcomplementorectilineo" <?= $chkcomplementorectilineo; ?> >
                                <label class="custom-control-label" for="chkcomplementorectilineo" id="lblchkcomplementorectilineo"> 
                                    <?= $chkcomplementorectilineo == "" ? "NO" : "SI"; ?>
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
                                <!-- <option value="">[SELECCIONE]</option> -->
                               
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
                        <?php if($estado_documentos != "APROBADO"): ?> 

                            <div class="col-md-4 form-group-sm" id="container-save-item1">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-sm btn-block btn-sistema" type="submit">Guardar</button>
                            </div>
                            
                        <?php endif; ?>

                    </form>


                </div>

                <!-- VERIFICACIÓN -->
                <div class="container-fluid containerdatos d-none" id="container_verificacion">

                    <h4 class="text-white font-weight-bold" >
                        2. VERIFICACIÓN: <?= $estado_verificacion ?>
                    </h4>

                    <form action="" class="row justify-content-center" id="frmverificacion" autocomplete="off">

                        <!-- DENSIDAD STD B/W -->
                        <div class="col-4">
                            <label for="">Densidad STD B/W:</label>
                            <input id="txtdensidadbefore" type="text" class="form-control form-control-sm" value="<?= $densidadbefore_verificacion ; ?>" readonly>
                        </div>

                        <!-- DENSIDAD STD A/W -->
                        <div class="col-4">
                            <label for="">Densidad STD A/W:</label>
                            <input id="txtdensidadafter" type="text" class="form-control form-control-sm" value="<?= $densidadafter_verificacion  ; ?>" readonly>
                        </div>

                        <!-- LARGO DE PAÑO ASIG: -->
                        <div class="col-4">
                            <label for="">Largo paño asig:</label>
                            <input id="txtlargopanoasig" type="tel" class="form-control form-control-sm" value="<?= $largopanoasignado_verificacion  ; ?>" required>
                        </div>


                        <!-- MATCHING -->
                        <div class="col-8 mt-2">
                            <label for="">Matching:</label>
                        </div>

                        <div class="col-4 mt-2">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="matching_verificacion" <?= $matching_verificacion; ?> >
                                <label class="custom-control-label" for="matching_verificacion" id="lblmatching_verificacion"> 
                                    <?= $matching_verificacion == "" ? "NO" : "SI"; ?>
                                </label>
                            </div>
                        </div>

                        <!-- TACTO -->
                        <div class="col-8 ">
                            <label for="">Tacto / Contramuestra:</label>
                        </div>

                        <div class="col-4 mt-1">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="tacto_verificacion" <?= $tacto_verificacion; ?> >
                                <label class="custom-control-label" for="tacto_verificacion" id="lbltacto_verificacion"> 
                                    <?= $tacto_verificacion == "" ? "NO" : "SI"; ?>
                                </label>
                            </div>
                        </div>

                        <!-- APARIENCIA DE PAÑO -->
                        <div class="col-8 ">
                            <label for="">Apariencia de Paño:</label>
                        </div>

                        <div class="col-4 mt-1">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="aparienciapano_verificacion" <?= $aparienciapano_verificacion; ?> >
                                <label class="custom-control-label" for="aparienciapano_verificacion" id="lblaparienciapano_verificacion"> 
                                    <?= $aparienciapano_verificacion == "" ? "NO" : "SI"; ?>
                                </label>
                            </div>
                        </div>

                        <!-- NIVEL DE PILLING / CONTRAMUESTRA -->
                        <div class="col-8 ">
                            <label for="">Nivel de Pilling / Contramuestra:</label>
                        </div>

                        <div class="col-4 mt-1">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input checks"  id="nivelpilling_verificacion" <?= $nivelpilling_verificacion; ?> >
                                <label class="custom-control-label" for="nivelpilling_verificacion" id="lblnivelpilling_verificacion"> 
                                    <?= $nivelpilling_verificacion == "" ? "NO" : "SI"; ?>
                                </label>
                            </div>
                        </div>

                        <!-- OBSERVACION -->
                        <div class="col-md-10 form-group-sm mt-3">
                            <label for="">OBSERVACIÓN:</label>
                            <textarea id="txtobservacion_verificacion" class="form-control form-control-sm" id="" rows="2"><?= $observacion_verificacion; ?> </textarea>
                        </div>

                        <!-- REGISTRAR -->
                        <?php if($estado_verificacion != "APROBADO"): ?> 

                            <div class="col-md-4 form-group-sm" id="container-save-item2">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-sm btn-block btn-sistema" type="submit">Guardar</button>
                            </div>
                            
                        <?php endif; ?>



                    </form>


                </div>

                <!-- DEFECTOS -->
                <div class="container-fluid containerdatos d-none" id="container_defectos">

                    <h4 class="text-white font-weight-bold" >
                        3. DEFECTOS: <?= $estado_defectos ?>
                        <!-- 3. DEFECTOS:  -->
                    </h4>

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

                        <?php if($estado_defectos == "" || $estado_defectos == "EN PROCESO" || $estado_defectos == "PENDIENTE") :?>

                            <div class="col-md-1" >
                                <button id="btn-save-item-agregar-3" class="btn btn-sm btn-block btn-sistema" type="submit">
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
                            <textarea id="txtobservaciondefectos" class="form-control form-control-sm" id="" rows="2"><?= $comentario_defectos;?></textarea>
                        </div>
                    </div>
                    
                    
                    <?php if($estado_defectos == "" || $estado_defectos == "EN PROCESO" || $estado_defectos == "PENDIENTE") :?>

                        <div class="row justify-content-center" id="container-save-item3">
                            <div class="col-md-3 mt-2">
                                <button class="btn btn-sm btn-sistema btn-block" id="btncerrarregistrodefectos" type="button">Guardar</button>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>

                <!-- MEDIDAS DE PAÑOS -->
                <div class="container-fluid containerdatos d-none" id="container_medidas">

                    <h4 class="text-white font-weight-bold" >4. MEDIDAS DE PAÑO: <?= $estado_medidas ?> </h4>


                    <!-- ETAPAS REGISTRADAS -->
                    <div class="row justify-content-md-center">

                        <?php foreach($etapas_medidas as $etapa): ?>

                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 mb-2">
                                    <div class="card">

                                        <div class="card-body p-0">
                                            

                                            <form  class="frmetapas row justify-content-center" autocomplete="off">

                                                <div class="col-12">

                                                    <table class="table table-bordered table-sm tablainput">

                                                        <thead class="thead-sistema-new text-center">
                                                            <tr>
                                                                <th colspan="4" class="p-0">ETAPA <?= $etapa["ETAPA"]; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="4" class="p-0">ANTES DE LAVAR</th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2" class="p-0">Medida Real Corte</th>
                                                                <th colspan="2" class="p-0">Medida Real Fisico</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Largo</th>
                                                                <th>Ancho</th>
                                                                <!-- <th>Despues</th> -->


                                                                <th>Largo</th>
                                                                <th>Ancho</th>
                                                                <!-- <th>Despues</th> -->

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr >
                                                                <td height="30">
                                                                    <input type="text" class="inputtabla text-center" value="<?= $etapa["LARGO_MEDIDAREAL_CORTE"]; ?>"  disabled>
                                                                </td>
                                                                <td height="30">
                                                                    <input type="text" class="inputtabla text-center" value="<?= $etapa["ANCHO_MEDIDAREAL_CORTE"]; ?>"  disabled>
                                                                </td>
                                                                
                                                                <td height="30">
                                                                    <input type="text" class="inputtabla text-center" value="<?= $etapa["ANCHO_MEDIDAREAL_FISICO"]; ?>" disabled>
                                                                </td>
                                                                <td height="30">
                                                                    <input type="text" class="inputtabla text-center" value="<?= $etapa["LARGO_MEDIDAREAL_FISICO"]; ?>"  disabled>
                                                                </td>
                                                                
                                                            </tr>

                                                            <!-- CANTIDA PAÑOS -->
                                                            <tr>
                                                                <td height="30" >
                                                                    CANT. PAÑOS
                                                                </td>
                                                                <td height="30" colspan="3">
                                                                    <input type="text" class="inputtabla text-center" value="<?= $etapa["NUM_PANOS"] ?>" id="txtnumpanos<?= $etapa["ETAPA"]; ?>" disabled>                                                                    
                                                                </td>
                                                            </tr>

                                                            <!-- TONOS -->
                                                            <tr>
                                                                <td height="30">
                                                                    TONOS
                                                                </td>
                                                                <td colspan="3">

                                                                    <?php 
                                                                        $tonos = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_SETETAPASTONOS_PANOS",[3,null,$etapa["IDETAPA"],null]);
                                                                    ?>  

                                                                        <?php foreach($tonos as $tono): ?>

                                                                            <a 
                                                                                class="btn btn-sistema  btn-sm cursor-pointer tonosquitar" 
                                                                                title="Quitar Tono" 
                                                                                data-id="<?= $tono["IDTONO"] ?>" 
                                                                                data-idetapa="<?= $etapa["IDETAPA"] ?>" 
                                                                                data-etapa="<?= $etapa["ETAPA"] ?>" 

                                                                                >
                                                                                <?= $tono["TONO"] ?>
                                                                            </a>

                                                                        <?php endforeach; ?>

                                                                </td>  
                                                            </tr>

                                                            <!-- OBSERVACIONES -->
                                                            <tr>
                                                                <td height="30">
                                                                    OBSERVACIONES
                                                                </td>
                                                                <td colspan="3">
                                                                        <?= $etapa["OBSERVACION"]; ?>
                                                                </td>
                                                            </tr>


                                                            <!-- DESPUES LAVADO -->
                                                            <tr>
                                                                <th colspan="4" class="p-0 thead-sistema-new text-center">MEDIDAS DESPUES DE LAVADO</th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2" class="p-0 thead-sistema-new text-center">LARGO</th>
                                                                <th colspan="2" class="p-0 thead-sistema-new text-center">ANCHO</th>

                                                            </tr>

                                                            <tr>
                                                                <td colspan="2" height="30">
                                                                    <input type="text" class="inputtabla text-center" value="<?= $etapa["LARGOAFTER"]; ?>" id="txtlargodespues_<?= $etapa["ETAPA"]; ?>" >
                                                                </td>
                                                                <td colspan="2" height="30">
                                                                    <input type="text" class="inputtabla text-center" value="<?= $etapa["ANCHOAFTER"]; ?>" id="txtanchodespues_<?= $etapa["ETAPA"]; ?>" >
                                                                </td>
                                                            </tr>

                                                            <tr > 
                                                                <td>OBS:</td>
                                                                <td colspan="3">
                                                                    <input type="text" class="inputtabla text-center" value="<?= $etapa["OBSERVACION_LAVADO"]; ?>" id="txt_observacionlavado_<?= $etapa["ETAPA"]; ?>" >
                                                                </td>
                                                            </tr>


                                                        </tbody>

                                                    </table>

                                                </div>

                                                
                                                <!-- OBSERVACIONES -->
                                                <!-- <label class="col-label col-12 text-dark">Observaciones: </label>
                                                <div class="col-12">
                                                    <textarea class="form-control form-control-sm" rows="1" disabled ><?= $etapa["OBSERVACION"]; ?></textarea>
                                                </div> -->
                                                    
                                                <!-- MEDIDAS LAVADOS -->
                                                

                                                <!-- <label class="col-label col-8 text-dark">Cant. Paños: </label>
                                                <div class="col-4">
                                                    <input type="text" class="form-control form-control-sm" value="<?= $etapa["NUM_PANOS"] ?>" id="txtnumpanos<?= $etapa["ETAPA"]; ?>" disabled>
                                                </div> -->
                                                

                                                <input type="hidden" name="" value="<?= $etapa["IDETAPA"]; ?>">

                                                <?php if($estado_medidas == ""): ?>

                                                    <div class="col-md-4">
                                                        <label for=""></label>
                                                        <button class="btn btn-sm btn-success btn-block" type="submit">
                                                            Guardar
                                                        </button>
                                                    </div>

                                                <?php  endif; ?> 
                                                



                                            </form>
                                        </div>                                
                                    </div>

                                </div>



                        <?php endforeach; ?>

                    </div>

                    <form class="row justify-content-md-center" id="frmcierremedidas">

                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <label for="">Estado</label>
                            <select name="" id="cboestadoasignado_medidas" class="custom-select custom-select-sm" required>
                                    <option <?= $estado_medidas == "" ? "selected" : ""; ?> value="">[SELECCIONE]</option>  
                                    <option <?= $estado_medidas == "APROBADO" ? "selected" : ""; ?> value="APROBADO">APROBADO</option>  
                                    <option <?= $estado_medidas == "APROBADO NO CONFORME" ? "selected" : ""; ?> value="APROBADO NO CONFORME">APROBADO NO CONFORME</option>
                                    <option <?= $estado_medidas == "RECHAZADO" ? "selected" : ""; ?> value="RECHAZADO">RECHAZADO</option>  
                            </select>
                        </div>                                                            
                        <div class="col-md-4"></div>
                        
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="">Observación</label>
                            <textarea  id="txtobservacion_medidas" class="form-control form-control-sm" rows="2"><?= $observacion_medidas ?></textarea>
                        </div>
                        <div class="col-md-3"></div>


                        <?php if($estado_medidas == ""): ?>

                            <div class="col-md-3">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-sistema btn-block btn-sm" type="submit">
                                    Guardar
                                </button>
                            </div>   

                        <?php endif; ?>

                    </form>
                        


                </div>

                 <!-- MEDIDAS DE PAÑOS -->
                <div class="container-fluid containerdatos d-none" id="container_resultados">

                    <h4 class="text-white font-weight-bold" >5. RESULTADOS: <?= $estado_final; ?></h4>


                    <div class="row">

                        <div class="col-md-12 mb-4">

                            <label for="" class="font-weight-bold">
                                1. Validación de Documentación: <?= $estado_documentos; ?>
                            </label>
                            <br>
                            <label class="font-weight-bold ml-5">
                                Comentario: <?= $comentariodocumentos; ?>
                            </label>     

                        </div>      

                        <div class="col-md-12 mb-4">
                            <label for="" class="font-weight-bold">
                                2. Verificación: <?= $estado_verificacion; ?>
                            </label>

                            <br>

                            <label class="font-weight-bold ml-5">
                                Comentario:  <?= $observacion_verificacion; ?>
                            </label>  
                        </div>     

                        <div class="col-md-12 ">
                            <label for="" class="font-weight-bold">
                                3. Defectos: <?= $estado_defectos; ?>
                            </label>

                            <br>

                            <label class="font-weight-bold ml-5">
                                Comentario: <?= $comentario_defectos; ?>
                            </label>  
                        </div>   

                    </div>

                    <div class="row justify-content-md-center mb-4">
                                                
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
                                4. Medidas: <?= $estado_medidas; ?>
                            </label>
                            <br>
                            <label class="font-weight-bold ml-5">
                                Comentario: <?= $observacion_medidas ; ?>
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
                                    <li class="font-weight-bold w-25 list-group-item opcionesnav p-0" data-container="verificacion" id="nav_2">
                                        2. <br> Verificación
                                    </li>
                                    <li class="font-weight-bold w-25 list-group-item opcionesnav p-0" data-container="defectos" id="nav_3">
                                        3. <br> Defectos
                                    </li>
                                    <li class="font-weight-bold w-25 list-group-item opcionesnav p-0" data-container="medidas" id="nav_4">
                                        4. <br> Medidas
                                    </li>
                                    <li class="font-weight-bold w-25 list-group-item opcionesnav p-0" data-container="resultados" id="nav_5">
                                        5. <br> Resultado
                                    </li>
                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?> 

      
    </div>


        
    <!-- PROPIOS -->
    <script src="../../js/lavados/panio/funciones.js"></script>

    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>

    <script>

        let FICHA               = null;
        let PARTE               = null;
        let NUMVEZ              = null;
        let CANTIDAD            = null;
        let CANTIDADTOTAL       = null;
        let IDFICHA             = null;
        let NUMPRENDA           = 1;
        let PRENDAADICIONAL     = 0;
        

        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {

            // ACTIVAMOS TAB
            changeNavs( $("#nav_<?= $TAB_ITEM;?>") );

            await   getDefectos("<?= $IDFICHA; ?>");
            await   getDefectosAgregados("<?= $IDFICHA; ?>");



            // GET MAQUINAS AGREGADAS
            await getMaquinasAgregadas("<?= $IDFICHA;?>","<?= $tipomaquina_documentos;?>");

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });


    </script>



    <script>    

        // VARIABLES
        const frmvalidaciondocumentacion    = document.getElementById("frmvalidaciondocumentacion");
        const frmverificacion               = document.getElementById("frmverificacion");
        const frmregistrodefectos           = document.getElementById("frmregistrodefectos");
        const frmetapas                     = document.getElementsByClassName("frmetapas");
        const frmcierremedidas              = document.getElementById("frmcierremedidas");
        let   chkcodmaquinalavado           = document.getElementById("chkcodmaquinalavado");
        let     checks                  = document.getElementsByClassName("checks");

        

        // #################
        // ### FUNCIONES ###
        // #################

        // INICIAR AUDITORIA
        function IniciarAuditoria(idficha,ficha,parte,numvez,cantidad,usuario){

            MostrarCarga();

            get("auditex-lavanderia", "lavadopanio", "set-lavadopanio", {
                opcion:1,
                idficha,
                ficha,
                parte,
                numvez,
                cantficha:cantidad,
                cantpartir:cantidad,
                usuario

            }).then(response => {

                window.location = `registropanio.view.php?ficha=${ficha}&id=${response.ID}`;

            }).catch(error => {

            });

        }



        // #################
        // ### EVENTOS ###
        // #################

        // SELECCIONAMOS FICHA PARA INICIAR AUDITORIA
        $(".selectfichas").click(function (){

            $(".btn-opciones").addClass("d-none");

            let resultado   = $(this).data("resultado");

            FICHA           = $(this).data("ficha");
            PARTE           = $(this).data("parte");
            NUMVEZ          = $(this).data("numvez");
            CANTIDAD        = $(this).data("cantficha");
            IDFICHA         = $(this).data("idficha");
            CANTIDADTOTAL   = $(this).data("canttotal");


            // console.log(ficha,parte,numvez,canttotal,cantficha,idficha);

            if(resultado == ""){

                $(".btn-opciones").removeClass("d-none");

                
            }else{
                MostrarCarga();
                window.location = `registropanio.view.php?ficha=${FICHA}&id=${IDFICHA}`;
            }


        });

        // INICIAR AUDITORIA (REGISTRAR)
        $("#btniniciar").click(async function(){

            let usuario     = "<?= $_SESSION["user"]; ?>"; 

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
                        get("auditex-lavanderia", "lavadopanio", "set-lavadopanio", {
                            opcion:2,
                            ficha,
                            parte,
                            numvez,
                            cantficha,
                            cantpartir,
                            usuario,
                            idficha

                        }).then(response => {

                            window.location = `registropanio.view.php?ficha=${ficha}&id=${response.ID}`;

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

        // OPCIONES
        $(".opcionesnav").click(function(){
            changeNavs(this);
        });

        // CERRAR REGISTRO DE DEFECTOS
        $("#btncerrarregistrodefectos").click(function(){

            let comentario = document.getElementById("txtobservaciondefectos").value;
            cerrarregistrodefectos("<?= $IDFICHA;?>",comentario,"<?= $_SESSION["user"];  ?>");

        });

        // REGISTRO DE VALIDACION DE DOCUMENTACION
        if (frmvalidaciondocumentacion  != null){

            frmvalidaciondocumentacion.addEventListener('submit',(e)=>{
                e.preventDefault();
                setValidacionDocumentacion("<?= $IDFICHA; ?>","<?= $_SESSION["user"]; ?>");
            });

        }
        

        // REGISTRO DE VERIFICACION
        if(frmverificacion != null){

            frmverificacion.addEventListener('submit',(e)=>{
                e.preventDefault();
                setVerificacion("<?= $IDFICHA; ?>","<?= $_SESSION["user"]; ?>");

            });

        }

        // REGISTRO DE ETAPAS
        if(frmregistrodefectos != null){

            frmregistrodefectos.addEventListener('submit',(e)=>{
                e.preventDefault();

                let cbodefectos                 = document.getElementById("cbodefectos").value;
                let txtcantidaddefectos         = document.getElementById("txtcantidaddefectos").value;

                saveDefectos("<?= $IDFICHA; ?>",cbodefectos,txtcantidaddefectos,"<?= $_SESSION["user"]; ?>");
            });

        }


        

        // INGRESO DE ETAPAS
        if(frmetapas != null){

            // MODIFICAR ETAPAS AGREGAMOS EVENTOS
            for(let forms of frmetapas){
                forms.addEventListener('submit',(e)=>{
                    e.preventDefault();
                    saveEtapas(forms);
                });
            }

        }

        // CIERE DE ETAPAS
        if(frmcierremedidas != null){

            frmcierremedidas.addEventListener('submit',(e)=>{
                e.preventDefault();

                MostrarCarga();

                let estado      = $("#cboestadoasignado_medidas").val();
                let observacion = $("#txtobservacion_medidas").val().trim();

                if(estado != ""){

                    post("auditex-lavanderia","lavadopanio","set-etapas-fichas",[
                        2,                  <?= $IDFICHA; ?>,   null,       null,
                        null,               estado,             observacion,       "<?php echo $_SESSION["user"];?>"
                    ])    
                        .then(response =>{

                            if(response.success){
                                // OcultarCarga();
                                window.location = `registropanio.view.php?ficha=<?= $fichainicio; ?>&id=<?= $IDFICHA; ?>&tab=5`;

                                // changeNavs( $("#nav_5") );

                            }else{
                                Advertir("Ocurrio un error al realizar registro");
                            }


                        })
                        .catch(error =>{

                            console.log("ERROR",error);
                            Advertir("Ocurrio un error :c");
                        });

                }else{  
                    Advertir("Ingrese un estado");
                }

                

            });

        }

        if(chkcodmaquinalavado != null){

            chkcodmaquinalavado.addEventListener('change',async (e)=>{

                MostrarCarga();
                let id      =   chkcodmaquinalavado.id;
                let activo  =   chkcodmaquinalavado.checked;

                if(activo){

                    document.getElementById(`lbl${id}`).innerText = "SERVICIO";
                    let response = await get("auditex-lavanderia", "lavadopanio", "get-talleres-lavanderia", {});
                    setComboSimple("cbomaquinalavado",response,"DESCRIPCIONCORTA","IDTALLER",false,false);
                    OcultarCarga();
                }else{

                    document.getElementById(`lbl${id}`).innerText = "PLANTA";
                    let response = await get("auditex-lavanderia", "lavadopanio", "get-maquinas-lavanderia", {});
                    setComboSimple("cbomaquinalavado",response,"DESC","IDLAVADORA",false,false);
                    OcultarCarga();

                }

            });

        }

        // MODIFICAR ETAPAS
        function saveEtapas (form){

            MostrarCarga();

            // console.log(form);
            // MostrarCarga();
            // let txtlargoantes       = form[0].value.trim();
            let txtlargodespues     = form[5].value.trim();
            // let txtanchoantes       = form[2].value.trim();
            let txtanchodespues     = form[6].value.trim();
            let observacion         = form[7].value.trim();


            // let txtcantpanos        = form[4].value.trim();
            // let txtobservaciones    = form[6].value.trim();
            let idetapa             = form[8].value.trim();


            post("auditex-lavanderia","lavadopanio","set-etapas-fichas",[
                1,                  <?= $IDFICHA; ?>,   idetapa,    txtlargodespues,
                txtanchodespues,    null,               observacion,       "<?php echo $_SESSION["user"];?>"
            ])    
                .then(response =>{

                    // console.log("RESPONSE",response);
                    if(response.success){
                        OcultarCarga();
                    }else{
                        Advertir("Ocurrio un error al realizar registro");
                    }


                })
                .catch(error =>{

                    console.log("ERROR",error);
                    Advertir("Ocurrio un error :c");
                });


        }

        // CAMBIAR CHECKS
        for(let check of checks){

            check.addEventListener('change',(e)=>{
                let id      =   check.id;
                let activo  =   check.checked;

                document.getElementById(`lbl${id}`).innerText = activo ? "SI" : "NO";
                // console.log(id,activo);
            });


        }


        // IDFICHA
    </script>


</body>

</html>