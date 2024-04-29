<?php
    require_once __DIR__.'../../../../models/modelo/core.modelo.php';

	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: /dashboard');
	}

    $objModelo = new CoreModelo();

    $_SESSION['navbar'] = "Testing Reporte";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Testing Reporte</title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

    <link rel="stylesheet" href="../../css/testing/testing.css">

    <style>
        body{
            padding-top: 60px !important;
       }
    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>



<?php

    $fechai         = null;
    $fechaf         = null;
    $anio           = null;
    $semana         = null;
    $aniosemana     = null;
    $partida        = null;
    $proveedor      = null;
    $cliente        = null;
    $articulotela   = null;
    $programa       = null;
    $color          = null;
    $estado         = null;
    $codtela        = null;

    // FILTROS
    if(isset($_POST["operacion"]) || isset($_GET["partida"]) ){

        $aniosemana     = isset($_POST["aniosemana"]) ? explode("-W",$_POST["aniosemana"]) : null;

        // var_dump($aniosemana);
        if($aniosemana != null){

            if(count($aniosemana) > 1 ){
                $anio = $aniosemana[0];
                $semana = $aniosemana[1];
            }
        }
       

        $fechai         = isset($_POST["fechai"]) ? $_POST["fechai"] : null;
        $fechaf         = isset($_POST["fechaf"]) ? $_POST["fechaf"] : null;
        // $anio           = isset($_POST["anio"]) ? $_POST["anio"] : null;
        // $semana         = isset($_POST["semana"]) ? $_POST["semana"] : null;

        $partida = "";
        if(isset($_GET["partida"])){
            $partida = $_GET["partida"];
        }else{
            $partida        = isset($_POST["partida"]) ? $_POST["partida"] : null;
        }


        $proveedor      = isset($_POST["proveedor"]) ? join("','",$_POST["proveedor"])  : null;
        $cliente        = isset($_POST["cliente"]) ? $_POST["cliente"] : null;
        $articulotela   = isset($_POST["articulotela"]) ? join("','",$_POST["articulotela"]) : null;
        $programa       = isset($_POST["programa"]) ? join("','",$_POST["programa"]) : null;
        $color          = isset($_POST["color"]) ? join("','",$_POST["color"]) : null;
        $estado         = isset($_POST["estado"]) ? $_POST["estado"] : null;
        $codtela        = isset($_POST["codtela"]) ? $_POST["codtela"] : null;

        $parametros = [
            $fechai,$fechaf,$anio,$semana,$partida,
            $proveedor,$cliente,$articulotela,$programa,
            $color,$estado,$codtela
        ];

        // echo $cliente;

        // var_dump($parametros);

        $response = $objModelo->getAll("USYSTEX.SPU_GET_TESTING",$parametros);
        // $response = [];
        // GUARDAMOS EN SESION PARA EXPORTAR
        $_SESSION["reportetesting"] = $response;

        $datostela      = null;
        $datosgenerales = null;
        $cont = 0;


        // FOREACH
        foreach($response as $fila){

            $cont++;
            $fecha  = date("d-m", strtotime($fila['FECHA']));
            $fechalarga  = date("d/m/Y", strtotime($fila['FECHA']));
            $proveedor          = substr($fila['PROVEEDOR'],0,10);
            $color              = substr($fila['COLOR'],0,10);
            $descripciontela    = $fila['DESCRIPCIONTELA'];
            $programa           = substr($fila['PROGRAMA'],0,7);
            $codcolor           = substr($fila['CODCOLOR'],0,7);
            $ruta               = substr($fila['RUTA'],0,7);
            $rutaerp               = substr($fila['RUTAERP'],0,7);
            $simboloestado      = $fila["SIMBOLOESTADO"] == "" ? $fila["ESTADOSISTEMA"] : $fila["SIMBOLOESTADO"];
            $colorestado        = $fila["COLORESTADO"];
            $agrupado           = $fila["PARTIDAAGRUPADA"] != "" ? "A" : "";
            $coloragrupado      = $fila["PARTIDAAGRUPADA"] != "" ? "bg-success-light" : "";
            $negrita            = $fila["PARTIDA"] == $fila["PARTIDAAGRUPADA"] ? "font-weight-bold text-dark" : "";


            $colorcomplemento   = $simboloestado == "C" ? 'bg-complemento' : "";
            $colormuestra       = $simboloestado == "MU" ? 'bg-muestra' : "";

            
            
            // RESULTADO PARTIDA
            $resultadopartida = "";

            if($fila["RESULTADOPARTIDA"] == "A"){
                $resultadopartida = "Aprb";
            }else if($fila["RESULTADOPARTIDA"] == "C"){
                $resultadopartida = "Anc";
            }else if($fila["RESULTADOPARTIDA"] == "R"){
                $resultadopartida = "Rech";
            }else{
                $resultadopartida = $fila["RESULTADOPARTIDA"];
            }

            //  DATOS DE TELA
            $datostela .= "
                <div class='td-tela ' data-filasombreado='{$cont}' style='width: 30px;cursor:pointer'  data-fila='{$cont}'>
                    <input value='{$cont} $agrupado' data-valor='' class='$colorcomplemento $colormuestra w-100  h-100 input-hover sombreado{$cont}' readonly />
                </div><div class='td-tela ' style='width: 40px;cursor:pointer'  data-idtesting='{$fila['IDTESTING']}'  data-fila='{$cont}'>
                    <input value='{$simboloestado}' data-valor='{$simboloestado}' data-fila='{$cont}' data-idtesting='{$fila['IDTESTING']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' data-lote='{$fila['LOTE_PRODUTO']}' class='$colorcomplemento $colormuestra $colorcomplemento $colormuestra w-100 changeestatus${cont} changeestatus $colorestado  h-100 input-hover sombreado{$cont}' readonly />
                </div><div class='td-tela columnakilos' style='width: 40px;cursor:pointer'  data-fila='{$cont}'>
                    <input value='{$fila['KILOS']}' data-valor='{$fila['KILOS']}' class='$colorcomplemento $colormuestra  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 60px;' data-toggle='tooltip' data-placement='top' title='{$fila['PROGRAMA']}' > <input  data-valor='{$fila['PROGRAMA']}' value='{$programa}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 75px;'>  <input data-valor='{$fila['CODTELA']}' value='{$fila['CODTELA']}' class='$colorcomplemento $colormuestra  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                </div><div class='td-tela {$coloragrupado}' data-filasombreado='{$cont}' style='width: 50px;padding-top:5px'>  
                    <a class='verpartida $negrita' data-partida='{$fila['PARTIDA']}' data-idtesting='{$fila['IDTESTING']}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-ruta='/TSC-WEB/auditoriatela/VerAuditoriaTela.php?partida={$fila['PARTIDA']}&codtel={$fila['CODTELA']}&codprv={$fila['CODPRV']}&numvez={$fila['NUMVEZ']}&parte=1&codtad=1'>{$fila['PARTIDA']}</a>
                </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' >  <input data-valor='{$resultadopartida}'  value='{$resultadopartida}' class='$colorcomplemento $colormuestra w-100 sombreado{$cont}  h-100 input-hover' readonly /> 
                </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 40px;' data-toggle='tooltip' data-placement='top' title='{$fechalarga} '>  <input value='{$fecha}' data-valor='{$fecha}'  class='$colorcomplemento $colormuestra w-100 sombreado{$cont}  h-100 input-hover' readonly /> 
                </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 65px;' data-toggle='tooltip' data-placement='top' title='{$fila['PROVEEDOR']}' >
                    <input value='{$proveedor}' data-valor='{$fila['PROVEEDOR']}' class='$colorcomplemento $colormuestra  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 100px;' data-toggle='tooltip' data-placement='top' title='{$fila['DESCRIPCIONTELALARGA']} '>    
                    <input value='{$descripciontela}' data-valor='{$fila['DESCRIPCIONTELALARGA']}' class='$colorcomplemento $colormuestra  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' title='{$fila['COLOR']} '>    
                    <input value='{$color}' data-valor='{$fila['COLOR']}' class='$colorcomplemento $colormuestra  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                </div><div class='td-tela' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' title='{$fila['CODCOLOR']} '>  <input data-valor='{$fila['CODCOLOR']}' value='{$codcolor}' class='$colorcomplemento $colormuestra  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                </div><div class='td-tela' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' title='{$fila['RUTA']}'>       <input data-valor='{$fila['RUTA']}' value='{$ruta}' class='$colorcomplemento $colormuestra  w-100  h-100 input-hover sombreado{$cont}' readonly />
                </div><div class='td-tela' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' title='{$fila['RUTAERP']}'>    <input data-valor='{$fila['RUTAERP']}' value='{$rutaerp}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                </div><br> 
            ";

            $revirado1primera =  (float)$fila['REVIRADO1PRIMERAL'];
            $revirado2primera =  (float)$fila['REVIRADO2PRIMERAL'];
            $revirado3primera =  (float)$fila['REVIRADO3PRIMERAL'];

            $revirado1tercera =  (float)$fila['REVIRADO1TERCERAL'];
            $revirado2tercera =  (float)$fila['REVIRADO2TERCERAL'];
            $revirado3tercera =  (float)$fila['REVIRADO3TERCERAL'];


            // ENCOGIMIENTO PRIMERA
            $datosgenerales .= "
                <div class='td ' data-filasombreado='{$cont}'>          <input value='{$fila['HILOPRIMERA']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TRAMAPRIMERA']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADBEFORE']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADAFTER']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOBEFORE']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOAFTER']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLIACABADOS']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLILAVADO']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['SOLIDES']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['REVIRADOPRIMERA']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><!--
            ";

            // ENCOGIMIENTO PRIMERA TSC
            $reviradoprimeratsc = (float)$fila['REVIRADOPRIMERATSC'];

            $datosgenerales .= "
                --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>       <input value='{$fila['HILOPRIMERATSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TRAMAPRIMERATSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADBEFORETSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADAFTERTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOBEFORETSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOAFTERTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLIACABADOSTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLILAVADOTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['SOLIDESTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$reviradoprimeratsc}%' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><!--
            ";

            // PRIMERA LAVADA
            $hiloprimeralavada    = (float)$fila['HILOPRIMERAL'];
            $tramaprimeralavada   = (float)$fila['TRAMAPRIMERAL'];

            $datosgenerales .= "
                --><div class='td sombreado{$cont}' data-filasombreado='{$cont}' style='width: 25px;'>
                <button class='$colorcomplemento $colormuestra w-100 h-100 openlavado openlavado1-${cont}' data-idlavada='{$fila['IDREALLAVADAPRIMERA']}' data-fila='${cont}'  data-lavada='1' data-idtesting='{$fila['IDTESTING']}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' typpe='button'> <i class='fas fa-bars'></i></button>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover   hilo1${cont}'  value='{$hiloprimeralavada}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover trama1${cont}'  value='{$tramaprimeralavada}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  densidad1${cont}'  value='{$fila['DENSIDADPRIMERAL']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  inclinacion1${cont}'  value='{$fila['INCLINACIONPRIMERAL']}°'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  ancho1${cont}'  value='{$fila['ANCHOTOTALPRIMERAL']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  ancho1${cont}'  value='{$fila['ANCHOUTILPRIMERAL']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado11${cont}'  value='{$revirado1primera}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado21${cont}'  value='{$revirado2primera}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado31${cont}'  value='{$revirado3primera}%'>
                </div><!--
            ";

            // ENCOGIMIENTO TERCERA 
            $datosgenerales .= "
                --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>       <input value='{$fila['HILOTERCERA']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TRAMATERCERA']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADBEFORE']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADAFTER']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOBEFORE']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOAFTER']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />   
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLIACABADOS']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLILAVADO']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['SOLIDES']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['REVIRADOTERCERA']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><!--
            ";

            $encogimientoterceratsc = (float)$fila['REVIRADOTERCERATSC'];
            // ENCOGIMIENTO TERCERA TSC
            $datosgenerales .= "
                --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>        <input value='{$fila['HILOTERCERATSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['TRAMATERCERATSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['DENSIDADBEFORETSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['DENSIDADAFTERTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />   
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['ANCHOREPOSOBEFORETSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['ANCHOREPOSOAFTERTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['INCLIACABADOSTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['INCLILAVADOTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />   
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['SOLIDESTSC']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$encogimientoterceratsc}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><!--
            ";
            
            // ENCOGIMIENTO TERCERA TOLERANCIA
            $datosgenerales .= "
                --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>       <input value='{$fila['HILOTERCERATOL']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TRAMATERCERATOL']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADBEFORETOL']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADAFTERTOL']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOBEFORETOL']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOAFTERTOL']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLIACABADOSTOL']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />   
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLILAVADOTOL']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />   
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['SOLIDES']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />   
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['REVIRADOTERCERATOL']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />    
                </div><!--
            ";

            $solideztercera = (float)$fila['SOLIDEZTERCERAL']; 

            // TERCERA LAVADA

            $hiloterceralavada    = (float)$fila['HILOTERCERAL'];
            $tramaterceralavada   = (float)$fila['TRAMATERCERAL'];

            $datosgenerales .= "
                --><div style='width: 25px;' class='td sombreado{$cont}' data-filasombreado='{$cont}'><button class='$colorcomplemento $colormuestra w-100 h-100 openlavado openlavado3-${cont}' data-idlavada='{$fila['IDREALLAVADATERCERA']}' data-fila='${cont}'  data-lavada='3' data-idtesting='{$fila['IDTESTING']}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' typpe='button'> <i class='fas fa-bars'></i></button>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover   hilo3${cont}'  value='{$hiloterceralavada}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  trama3${cont}'  value='{$tramaterceralavada}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  densidad3${cont}'  value='{$fila['DENSIDADTERCERAL']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  inclinacion3${cont}'  value='{$fila['INCLINACIONTERCERAL']}°'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  ancho3${cont}'  value='{$fila['ANCHOTOTALTERCERAL']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  ancho3${cont}'  value='{$fila['ANCHOUTILTERCERAL']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado13${cont}'  value='{$revirado1tercera}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado23${cont}'  value='{$revirado2tercera}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado33${cont}'  value='{$revirado3tercera}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  solidez3${cont}'  value='{$solideztercera}'>
                </div><!--
            ";

            // TOLERANCIAS BEFORE
            $datosgenerales .= "
                --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input value='{$fila['TOLERANCIABEFOREMAS']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input value='{$fila['TOLERANCIABEFOREMENOS']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><!--
            ";

            // TOLERANCIAS AFTER
            $datosgenerales .= "
                --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>       <input value='{$fila['TOLERANCIAAFTERMAS']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TOLERANCIAAFTERMENOS']}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly /> 
                </div><!--
            ";

            // PORCENTAJE

            // Encog. De Paños Lavados
            $datosgenerales .= "
            --><div style='width: 25px;' class='td sombreado{$cont}' data-filasombreado='{$cont}'><button class='$colorcomplemento $colormuestra w-100 h-100 openencogimiento' data-fila='${cont}'   data-idtesting='{$fila['IDTESTING']}' data-lote='{$fila['LOTE_PRODUTO']}' 
            data-hilo='{$fila['HILOENCOGIMIENTO']}' data-trama='{$fila['TRAMAENCOGIMIENTO']}' data-ibefore='{$fila['INCLINACIONBEFORE']}' data-iafter='{$fila['INCLINACIONAFTER']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' typpe='button'> <i class='fas fa-bars'></i></button>
            </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100  input-hover  hiloencogimiento${cont}'  value='{$fila['HILOENCOGIMIENTO']}%'>
            </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100  input-hover  tramaencogimiento${cont}'  value='{$fila['TRAMAENCOGIMIENTO']}%'>
            </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100  input-hover  inclibefore${cont}'  value='{$fila['INCLINACIONBEFORE']}'> 
            </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100  input-hover  incliafter${cont}'  value='{$fila['INCLINACIONAFTER']}'>
            </div><!--";

            // $fechaliberacion    = $fila['FECHALIBERACION']  == "" ? "-" : date("d/m/Y", strtotime($fila['FECHALIBERACION']));// $fila['FECHALIBERACION'];
            $fechaliberacionlarga    = $fila['FECHALIBERACION']  == "" ? "-" : date("d/m/Y", strtotime($fila['FECHALIBERACION']));// $fila['FECHALIBERACION'];
            $fechaliberacion    = $fila['FECHALIBERACION']  == "" ? "-" : date("d-m", strtotime($fila['FECHALIBERACION']));// $fila['FECHALIBERACION'];


            $usuario            = $fila['USUARIO']          == "" ? "-" : $fila['USUARIO'];
            $nombreusuario      = $fila['NOMBREUSUARIO'];
            $observaciones      = $fila['OBSERVACIONES']    == "" ? "-" : $fila['OBSERVACIONES'];

            // #######################
            // ### RESIDUALES PAÑO ###
            // #######################
            
            $hiloresidual           = (float)$fila['HILORESIDUAL'];
            $tramaresidual          = (float)$fila['TRAMARESIDUAL'];
            $inclinacionresidual    = (float)$fila['INCLINACIONRESIDUAL'];
            $revirado1residual      = (float)$fila['REVIRADO1RESIDUAL'];
            $revirado2residual      = (float)$fila['REVIRADO2RESIDUAL'];
            $revirado3residual      = (float)$fila['REVIRADO3RESIDUAL'];

            $datosgenerales .= "
                --><div style='width: 25px;' class='td sombreado{$cont}' data-filasombreado='{$cont}'><button class='$colorcomplemento $colormuestra w-100 h-100 openresidual openresidual-${cont}' data-idresidual='{$fila['IDRESIDUALPANO']}' data-fila='${cont}' data-idtesting='{$fila['IDTESTING']}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' typpe='button'> <i class='fas fa-bars'></i></button>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover   hilo${cont}'  value='{$hiloresidual}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  trama${cont}'  value='{$tramaresidual}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  inclinacion${cont}'  value='{$inclinacionresidual}°'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado1${cont}'  value='{$revirado1residual}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado2${cont}'  value='{$revirado2residual}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado3${cont}'  value='{$revirado3residual}%'>
                </div><!--
            ";

            // 1RA LAVADA SECADA TAMBOR

            $hiloprimeralavadatam    = (float)$fila['HILOPRIMERALTAM'];
            $tramaprimeralavadatam   = (float)$fila['TRAMAPRIMERALTAM'];

            $revirado1primeratam =  (float)$fila['REVIRADO1PRIMERALTAM'];
            $revirado2primeratam =  (float)$fila['REVIRADO2PRIMERALTAM'];
            $revirado3primeratam =  (float)$fila['REVIRADO3PRIMERALTAM'];


            $datosgenerales .= "
                --><div style='width: 25px;' class='td sombreado{$cont}' data-filasombreado='{$cont}'><button class='$colorcomplemento $colormuestra w-100 h-100 openlavado openlavado3-${cont}' data-idlavada='{$fila['IDREALLAVADATERCERA']}' data-fila='${cont}'  data-lavada='3' data-idtesting='{$fila['IDTESTING']}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' typpe='button'> <i class='fas fa-bars'></i></button>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover   hilo3${cont}'  value='{$hiloprimeralavadatam}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  trama3${cont}'  value='{$tramaprimeralavadatam}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  densidad3${cont}'  value='{$fila['DENSIDADPRIMERALTAM']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  inclinacion3${cont}'  value='{$fila['INCLINACIONPRIMERALTAM']}°'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  ancho3${cont}'  value='{$fila['ANCHOTOTALPRIMERALTAM']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  ancho3${cont}'  value='{$fila['ANCHOUTILPRIMERALTAM']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado13${cont}'  value='{$revirado1primeratam}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado23${cont}'  value='{$revirado2primeratam}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado33${cont}'  value='{$revirado3primeratam}%'>
                </div><!--
            ";

            $hiloterceralavadatam       = (float)$fila['HILOTERCERALTAM'];
            $tramaterceralavadatam      = (float)$fila['TRAMATERCERALTAM'];

            $revirado1terceratam        =  (float)$fila['REVIRADO1TERCERALTAM'];
            $revirado2terceratam        =  (float)$fila['REVIRADO2TERCERALTAM'];
            $revirado3terceratam        =  (float)$fila['REVIRADO3TERCERALTAM'];
            $solidezterceratam          =  (float)$fila['SOLIDEZTERCERALTAM']; //$fila['SOLIDEZTERCERAL'];

            // 3RA LAVADA SECADA TAMBOR
            $datosgenerales .= "
                --><div style='width: 25px;' class='td sombreado{$cont}' data-filasombreado='{$cont}'><button class='$colorcomplemento $colormuestra w-100 h-100 openlavado openlavado3-${cont}' data-idlavada='{$fila['IDREALLAVADATERCERA']}' data-fila='${cont}'  data-lavada='3' data-idtesting='{$fila['IDTESTING']}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' typpe='button'> <i class='fas fa-bars'></i></button>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover   hilo3${cont}'  value='{$hiloterceralavadatam}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  trama3${cont}'  value='{$tramaterceralavadatam}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  densidad3${cont}'  value='{$fila['DENSIDADTERCERALTAM']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  inclinacion3${cont}'  value='{$fila['INCLINACIONTERCERALTAM']}°'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  ancho3${cont}'  value='{$fila['ANCHOTOTALTERCERALTAM']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  ancho3${cont}'  value='{$fila['ANCHOUTILTERCERALTAM']}'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado13${cont}'  value='{$revirado1terceratam}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado23${cont}'  value='{$revirado2terceratam}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra w-100 h-100 input-hover  revirado33${cont}'  value='{$revirado3terceratam}%'>
                </div><!--
            ";


            // DATOS EXTRA
            $datosgenerales .= "
            --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'  data-toggle='tooltip' data-placement='top' title='{$fechaliberacionlarga}' > <input value='{$fechaliberacion}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />   
            </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}' data-toggle='tooltip' data-placement='top' title='{$nombreusuario}' >      <input value='{$usuario}' class='$colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
            </div><div class='td sombreado{$cont}'  data-fila='${cont}'  style='width:100px !important;cursor:pointer;'><input data-fila='${cont}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' data-observaciones='{$fila['OBSERVACIONES']}' data-idtesting='{$fila['IDTESTING']}' value='{$observaciones}' class='observaciones observaciones${cont} $colorcomplemento $colormuestra w-100  h-100 input-hover' readonly />  
            </div><!--";

            // // SALTO DE LINEA
            $datosgenerales .= "--><br>";

        }


    }

?>  





    <!-- MUESTRA DATOS -->
    <?php if(isset($_POST["operacion"]) || isset($_GET["partida"])  ): ?> 

        <!-- FORM ENVIO -->
        <form action="/tsc/controllers/auditex-testing/testing.controller.php" method="POST" id="frmarchivo">
            <input type="hidden" name="operacion" value="setexportartesting">
            <input type="hidden" name="filtros"   id="txtfiltros">
        </form>

        <!-- FORM LIMPIAR -->
        <form method="POST" id="frmvolver">
            <!-- <input type="hidden" name="operacion" value="setexportartesting"> -->
        </form>
        <!-- CONTAINER -->
        <div class="container-fluid mt-3"> 

            <div class="row">

                <div class="col-md-12">

                    <label for="" id="lblfiltros" class="text-white"></label>

                    <button class="btn btn-sm  btn-danger float-right " id="btnvolverbuscar" type="button">
                        <i class="fas fa-arrow-left"></i>Volver a Buscar
                    </button>

                    <button class="btn btn-sm btn-warning float-right mr-2" id="btnocultarcolumnas"  type="button">
                                <i class="fas fa-arrow-left"></i> Ocultar Columnas
                    </button>

                    <button class="btn btn-sm  btn-success float-right mr-2" id="btnexportar" type="button">
                        <i class="fas fa-file-excel"></i>
                        Exportar
                    </button>   

                </div>

            </div>

            <!-- TABLA  -->
            <div class="card mt-3 ">

                <div class="container-general float-left w-100">


                    <div class="header float-left w-750 width" id="header1" >

                        <div class="bg-primary text-white text-center w-750 width" style="padding:0px">
                            INFORMACIÓN DE LA PARTIDA
                        </div>

                            <div class="th-tela bg-primary " style="width: 30px;"> <label class="text-white">N°</label>
                            </div><div class="th-tela bg-primary " style="width: 40px;"> <label class="text-white">Status</label>
                            </div><div class="th-tela bg-primary columnakilos " style="width: 40px;"> <label class="text-white">Kilos</label>
                            </div><div class="th-tela bg-primary" style="width: 60px;"> <label class="text-white">Programa</label>
                            </div><div class="th-tela bg-primary" style="width: 75px;"> <label class="text-white">Cod Tela</label> 
                            </div><div class="th-tela bg-primary" style="width: 50px;"> <label class="text-white">Partida</label> 
                            </div><div class="th-tela bg-primary" style="width: 50px;"> <label class="text-white">Resultado</label> 
                            </div><div class="th-tela bg-primary" style="width: 40px;"> <label class="text-white">Fecha</label> 
                            </div><div class="th-tela bg-primary" style="width: 65px;"> <label class="text-white">Proveedor</label> 
                            </div><div class="th-tela bg-primary" style="width: 100px;"> <label class="text-white">Tipo de Tela</label> 
                            </div><div class="th-tela bg-primary" style="width: 50px;"> <label class="text-white">Color</label> 
                            </div><div class="th-tela bg-primary" style="width: 50px;"> <label class="text-white">Cod Color</label> 
                            </div><div class="th-tela bg-primary" style="width: 50px;"> <label class="text-white">Lavado</label> 
                            </div><div class="th-tela bg-primary" style="width: 50px;"> <label class="text-white">Ruta ERP</label> 

                            </div>
                    </div>

                    <div class="header float-left calc-750 calc" id="header2">

                        <div class="bg-danger text-white text-center" style="width: 400px;padding:0px;display: inline-block;">
                            ENCOGIMIENTO ESTÁNDAR PRIMERA
                        </div><!--
                        --><div class="bg-warning text-white text-center" style="width: 400px;padding:0px;display: inline-block;">
                            ENCOGIMIENTO TSC - TEXTIL PRIMERA
                        </div><!--
                        --><div class="bg-success-light text-white text-center" style="width: 384px;padding:0px;display: inline-block;">
                        DATOS REALES TSC - 1RA LAVADA
                        </div><!--
                        --><div class="bg-danger text-white text-center" style="width: 401px;padding:0px;display: inline-block;">
                            ENCOGIMIENTO ESTÁNDAR TERCERA
                        </div><!--
                        --><div class="bg-warning text-white text-center" style="width: 400px;padding:0px;display: inline-block;">
                        ENCOGIMIENTO TSC - TEXTIL TERCERA
                        </div><!--
                        --><div class="bg-info text-white text-center" style="width: 400px;padding:0px;display: inline-block;">
                            TOLERANCIAS
                        </div><!--
                        --><div class="bg-success-light text-white text-center" style="width: 425px;padding:0px;display: inline-block;">
                            DATOS REALES TSC - 3RA LAVADA
                        </div><!--
                        --><div class="bg-danger text-white text-center" style="width: 160px;padding:0px;display: inline-block;">
                            <!-- Tolerancias B/W + - 5% --> TOL-DENSIDAD
                        </div><!--
                        --><div class="bg-success-light text-white text-center" style="width: 185px;padding:0px;display: inline-block;">
                            Encog. De Paños Lavados
                        </div><!--
                        --><div class="bg-warning text-white text-center" style="width: 265px;padding:0px;display: inline-block;">
                            Residual Paño
                        </div><!--
                        --><div class="bg-success-light text-white text-center" style="width: 384px;padding:0px;display: inline-block;">
                        1RA LAVADA(SECADA TAMBOR)
                        </div><!--
                        --><div class="bg-warning text-white text-center" style="width: 384px;padding:0px;display: inline-block;">
                        3RA LAVADA(SECADA TAMBOR)
                        </div><!--
                        --><div class="bg-info text-white text-center" style="width: 180px;padding:0px;display: inline-block;">
                            Datos Extra
                        </div>

                        <br>

                        <!-- ENCOGIMIENTO PRIMERA -->
                        <div class="bg-danger th">
                            <label class="verticalText text-white">Hilo</label>
                            <!-- Hilo -->
                        </div><div class="bg-danger th">
                            <label class="verticalText text-white">Trama</label>
                            <!-- Trama -->
                        </div><div class="bg-danger th"><label class="verticalText text-white">Densidad B/W</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Densidad (A/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Ancho (B/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Ancho (A/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Incli Acabados (B/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Incli Acabados (A/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Solides</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Revirado</label></div><!--
                        ENCOGIMIENTO PRIMERA TSC--><div class="bg-warning th"><label class="verticalText text-white">Hilo</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Trama</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Densidad B/W</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Densidad (A/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Ancho (B/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Ancho (A/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Incli Acabados (B/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Incli Acabados (A/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Solides</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Revirado</label></div><!-- 
                        REALES TSC PRIMERA --><div class="bg-success-light th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Hilo</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Trama</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Densidad B/W</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">º de Inclinacion</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Ancho Total (B/W)</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Ancho Util (B/W)</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Revirado 1</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Revirado 2</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Revirado 3</label></div><!--
                        ENCOGIMIENTO TERCERA --><div class="bg-danger th"><label class="verticalText text-white">Hilo</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Trama</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Densidad B/W</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Densidad (A/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Ancho (B/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Ancho (A/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Incli Acabados (B/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Incli Acabados (A/W)</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Solides</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">Revirado</label></div><!--
                        ENCOGIMIENTO TERCERA TSC--><div class="bg-warning th"><label class="verticalText text-black">Hilo</label>
                        </div><div class="bg-warning th"><label class="verticalText text-black">Trama</label>
                        </div><div class="bg-warning th"><label class="verticalText text-black">Densidad B/W</label>
                        </div><div class="bg-warning th"><label class="verticalText text-black">Densidad (A/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-black">Ancho (B/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-black">Ancho (A/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-black">Incli Acabados (B/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-black">Incli Acabados (A/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-black">Solides</label>
                        </div><div class="bg-warning th"><label class="verticalText text-black">Revirado</label></div><!--
                        TOLERANCIA ENCOGIMIENTO TERCERA --><div class="bg-info th"><label class="verticalText text-black">Hilo</label>
                        </div><div class="bg-info th"><label class="verticalText text-black">Trama</label>
                        </div><div class="bg-info th"><label class="verticalText text-black">Densidad B/W</label>
                        </div><div class="bg-info th"><label class="verticalText text-black">Densidad (A/W)</label>
                        </div><div class="bg-info th"><label class="verticalText text-black">Ancho (B/W)</label>
                        </div><div class="bg-info th"><label class="verticalText text-black">Ancho (A/W)</label>
                        </div><div class="bg-info th"><label class="verticalText text-black">Incli Acabados (B/W)</label>
                        </div><div class="bg-info th"><label class="verticalText text-black">Incli Acabados (A/W)</label>
                        </div><div class="bg-info th"><label class="verticalText text-black">Solides</label>
                        </div><div class="bg-info th"><label class="verticalText text-black">Revirado</label></div><!--
                        REALES TSC TERCERA --><div class="bg-success-light th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Hilo</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Trama</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Densidad A/W</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">º de Inclinacion</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Ancho Total (A/W)</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Ancho Util (A/W)</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Revirado 1</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Revirado 2</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Revirado 3</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Solidez</label></div><!--
                        TOLERANCIAS BEFORE --><div class="bg-danger th"><label class="text-white">B/W +5%</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">B/W -5%</label></div><!--                
                        TOLERANCIAS AFTER --><div class="bg-danger th"><label class="text-white">A/W +5%</label>
                        </div><div class="bg-danger th"><label class="verticalText text-white">A/W -5%</label></div><!--
                        Encog. De Paños Lavados --><div class="bg-success-light th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                        </div><div class="bg-success-light th"><label class="text-white">Hilo</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Trama</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">° INCLINACIÓN B/W</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">° INCLINACIÓN A/W</label></div><!-- 
                        RESIDUALES PAÑO --><div class="bg-warning th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Hilo</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Trama</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">º de Inclinacion</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Revirado 1</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Revirado 2</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Revirado 3</label></div><!--
                        1RA LAVADA SECADO TAMBOR--><div class="bg-success-light th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Hilo</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Trama</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Densidad A/W</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">º de Inclinacion</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Ancho Total (A/W)</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Ancho Util (A/W)</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Revirado 1</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Revirado 2</label>
                        </div><div class="bg-success-light th"><label class="verticalText text-white">Revirado 3</label></div><!--
                        3RA LAVADA SECADO TAMBOR--><div class="bg-warning th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Hilo</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Trama</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Densidad A/W</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">º de Inclinacion</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Ancho Total (A/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Ancho Util (A/W)</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Revirado 1</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Revirado 2</label>
                        </div><div class="bg-warning th"><label class="verticalText text-white">Revirado 3</label></div><!--
                        FECHA DE LIBERACIÓN --><div class="bg-info th"><label class="text-white">F. LIBERACIÓN</label>
                        </div><!-- LIBERADO POR --><div class="bg-info th"><label class="text-white">LIBERADO POR</label>
                        </div><!-- OBSERVACIONES TSC --><div class="bg-info th" style="width:100px !important"><label class="text-white">OBSERVACIONES</label>
                        </div>

                    </div>

                    <!-- BODY DATOS TELA -->
                    <div id="container-datos-tela" class="float-left w-750 width">

                            <?php
                                if(isset($datostela)){
                                    echo $datostela;
                                }
                            ?>

                    </div>

                    <!-- CONTENEDOR DE DATOS DE GENERALES -->
                    <div id="container-datos-generales" class="float-left calc-750 calc">

                            <?php
                                if(isset($datosgenerales)){
                                    echo $datosgenerales;
                                }
                                // echo $datosgenerales;
                            ?>

                    </div>

                </div>
                
        
            </div>

        </div>

    <?php else: ?>

        <!-- CONTAINER -->
        <div class="container">

            <!-- FILTROS PARA EL REPORTE -->
            <div class="card p-0">

                <form class="card-body" id="frmbusqueda" method="post" autocomplete="off"> 

                    <div class="row">

                        <div class="col-md-6">
                            <label for="">Proveedor</label>
                            <select name="proveedor[]" id="cboproveedor" class="custom-select custom-select-sm select2" multiple="multiple" data-placeholder="Seleccione Proveedor" data-dropdown-css-class="select2-danger" style="width: 100%;"></select>
                        </div>

                        <div class="col-md-6">
                            <label for="">Cliente</label>
                            <select name="cliente" id="cbocliente" class="custom-select custom-select-sm select2" data-placeholder="Seleccione Cliente" style="width: 100%;"></select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="">Artículo de tela</label>
                            <select name="articulotela[]" id="cboarticulo" class="custom-select custom-select-sm select2articulotela"  multiple="multiple" data-placeholder="Seleccione Articulo" data-dropdown-css-class="select2-danger" style="width: 100%;"></select>
                        </div>

                        <div class="col-md-6">
                            <label for="">Programa</label>
                            <select name="programa[]" id="cboprograma" class="custom-select custom-select-sm select2programa"  multiple="multiple" data-placeholder="Seleccione Programa" data-dropdown-css-class="select2-danger" style="width: 100%;"></select>
                        </div>
                        

                        <div class="col-md-6">
                            <label for="">Color</label>
                            <select name="color[]" id="cbocolor" class="custom-select custom-select-sm select2"  multiple="multiple" data-placeholder="Seleccione Color" data-dropdown-css-class="select2-danger" style="width: 100%;" ></select>
                        </div>

                        <div class="col-md-6">
                            <label for="">Estatus</label>
                            <select name="estado" id="cboestatus" class="custom-select custom-select-sm">
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="">Partida</label>
                            <input type="text" class="form-control form-control-sm" name="partida" id="partida" value="<?=$partida?>">
                        </div>

                        <div class="col-md-6">
                            <label for="">Codigo Tela</label>
                            <input type="text" class="form-control form-control-sm" name="codtela" id="txtcodtela" value="<?=$codtela?>">
                        </div>

                        <div class="col-md-6">
                            <label for="">Desde</label>
                            <input type="date" class="form-control form-control-sm" name="fechai" id="txtfechain" value="<?=$fechai?>">
                        </div>

                        <div class="col-md-6">
                            <label for="">Hasta</label>
                            <input type="date" class="form-control form-control-sm" name="fechaf" id="txtfechafn" value="<?=$fechaf?>">
                            <input type="hidden" class="form-control form-control-sm" name="operacion" value="reporte">

                        </div>

                        <div class="col-md-6">
                            <label for="">Año - Semana </label>
                            <input type="week" class="form-control form-control-sm" name="aniosemana" id="txtaniosemana">
                        </div>

                        <div class="col-md-12">

                            <button class="btn btn-sm  btn-primary float-right ml-2" type="submit">Buscar</button>

                        </div>
                    
                    </div>

                </form>

            </div>  

        </div>

    <?php endif; ?>






<div class="loader"></div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>


<script >
    let mostrar = true;
    const frmvolver         = document.getElementById("frmvolver");
    let IDLAVADA    = null;
    let TIPOLAVADA  = null;
    let FILA        = null;
    let BOLSAS              = [];
    let DETALLEBOLSAS       = [];
    let IDTESTING   = null;
    let PARTIDA     = null;
    let LOTE        = null;
    let ESTADOSTESTING = [];
    let FILASOMBREADA = null;
    let OCULTARCOLUMNAS = true;


    let lblproveedor            = "";
    let lblcliente              = "";
    let lblarticulodetela       = "";
    let lblprograma             = "";
    let lblcolor                = "";
    let lblestado               = "";
    let lblpartida              = "";
    let lblcodigotela           = "";
    let lblfechainicio          = "";
    let lblfechafin             = "";
    let lblsemana               = "";
    let lblfiltros              = "";

    // EXPORTAR
    $("#btnexportar").click(function(){
            
        // let html = $("#contenedortable").html();
        // $("#tablecontainerhtml").val(html);
        // $("#txtfiltros").val(lblfiltros);
        $("#frmarchivo").submit();

    });

    // LOAD
    window.addEventListener("load",()=>{

        $(".select2").select2();

        // TOOLTIP
        $(".td-tela").tooltip("enable")
        $(".td").tooltip("enable");

        // EVENTO DE FOCUS
        FocusInput();

        // FILTROS
        lblproveedor            = "<?php echo isset($_POST["proveedor"]) ? join(",",$_POST["proveedor"]) : 'TODOS'; ?>";
        lblcliente              = "<?php echo (isset($_POST["cliente"])) ?  $_POST["cliente"] : 'TODOS'; ?>";
        lblcliente              = lblcliente == "" ? 'TODOS' : lblcliente;
        lblarticulodetela       = "<?php echo isset($_POST["articulotela"]) ? $_POST["articulotela"] : 'TODOS'; ?>";
        lblprograma             = "<?php echo isset($_POST["programa"]) ? $_POST["programa"] : 'TODOS'; ?>";
        lblcolor                = "<?php echo isset($_POST["color"]) ? $_POST["color"] : 'TODOS'; ?>";
        lblestado               = "<?php echo isset($_POST["estado"]) ? $_POST["estado"] : 'TODOS'; ?>";
        lblpartida              = "<?php echo isset($_POST["partida"]) ? $_POST["partida"] : 'TODOS'; ?>";
        lblcodigotela           = "<?php echo isset($_POST["codtela"]) ? $_POST["codtela"] : 'TODOS'; ?>";
        lblfechainicio          = "<?php echo isset($_POST["fechai"]) ? $_POST["fechai"] : 'TODOS'; ?>";
        lblfechafin             = "<?php echo isset($_POST["fechaf"]) ? $_POST["fechaf"] : 'TODOS'; ?>";
        lblsemana               = "<?php echo isset($_POST["aniosemana"]) ? $_POST["aniosemana"] : 'TODOS'; ?>";

        // FILTROS PARA REPORTE
        lblfiltros = `PROVEEDOR: ${lblproveedor} / CLIENTE: ${lblcliente} / ARTICULO DE TELA: ${lblarticulodetela} / PROGRAMA: ${lblprograma} / COLOR: ${lblcolor} / ESTADO: ${lblestado} / PARTIDA: ${lblpartida} / CODIGO DE TELA: ${lblcodigotela} / FECHA DE INICIO: ${lblfechainicio} / FECHA DE FIN: ${lblfechafin} / SEMANA: ${lblsemana}`;

        // OCULTAMOS CARGA
        $(".loader").fadeOut("slow");

        // FILTROS
        $("#txtfiltros").val(lblfiltros);
        // $("#lblfiltros").text(lblfiltros);


    });

    // GET PROVEEDORES
    async function getproveedores(){
        let response = await get("auditex-testing","testing","getproveedorestela",{});
        setComboSimple("cboproveedor",response,"DESCRIPCIONPROVEEDOR","IDPROVEEDOR",false);
    }
    
    // GET PROVEEDORES
    async function getclientes(){
        let response = await get("auditex-testing","testing","getclientes",{});
        setComboSimple("cbocliente",response,"DESCRIPCIONCLIENTE","IDCLIENTE",true);
    }

    // GET COLORES
    async function getcolores(){
        let response = await get("auditex-testing","testing","getcolores",{});
        setComboSimple("cbocolor",response,"DESCOLOR","DESCOLOR");
    }

    //   GET ESTADOS TESTING
    async function getEstadoTesting(){
        ESTADOSTESTING = await get("auditex-testing","testing","getestadostesting",{});
        setComboSimple("cboestatus",ESTADOSTESTING,"ESTADO","IDESTADO");

        // console.log(ESTADOSTESTING);
    }

    // MOSTRAR OCULTAR
    $("#btnmostrar").click(function(){
        mostrar = !mostrar;

        if(mostrar){
            $(".busquedas").removeClass("d-none");
            $(this).html("<i class='fas fa-eye-slash'></i>");
        }else{
            $(".busquedas").addClass("d-none");
            $(this).html("<i class='fas fa-eye'></i>");
        }
        
    });


    // DATOS SEGUN CLIENTE
    $("#cbocliente").change(async function(){

        let id = $(this).val();
        await getarticulostela(id);
        await getprogramacliente(id);

        
    });

    // GET ARTICULOS  DE TELA
    async function getarticulostela(idcliente){
        let response = await get("auditex-testing","testing","getarticulostela",{
            idcliente
        });
        setComboSimple("cboarticulo",response,"DESTEL","DESTEL");
    }

    // GET PROGRAMA CLIENTE
    async function getprogramacliente(idcliente){

        let response = await get("auditex-testing","testing","getprogramacliente",{
            idcliente
        });

        setComboSimple("cboprograma",response,"PROGRAMA","PROGRAMA");

    }

    // SCROOL TOP
    $("#container-datos-generales").scroll(function(){
        $("#container-datos-tela").scrollTop( $("#container-datos-generales").scrollTop() );
        $("#header2").scrollLeft( $("#container-datos-generales").scrollLeft())
    })

    $("#container-datos-tela").scroll(function(){
        $("#header1").scrollLeft( $("#container-datos-tela").scrollLeft())
    });

    function PintarDireccionales(scrool = false){
        $(".input-hover").removeClass("bg-sombreado");
        // $(".td-tela").removeClass("bg-sombreado");

        $(`.sombreado${FILASOMBREADA}`).addClass("bg-sombreado");

        // if(scrool){
        //     $("#container-datos-generales").scrollTop(scrool);
        //     $("#container-datos-tela").scrollTop(scrool);
        // }
    }

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    
    $("#btnocultarcolumnas").click(function(){

        OCULTARCOLUMNAS = !OCULTARCOLUMNAS;

        $("#btnocultarcolumnas").html(
            OCULTARCOLUMNAS ? `<i class="fas fa-arrow-left"></i>Ocultar Columna` : `<i class="fas fa-arrow-right"></i>Mostrar Columna`
        );

        // MOSTRAMOS
        if(OCULTARCOLUMNAS){

            $(".calc").removeClass("calc-655");
            $(".calc").addClass("calc-750");

            $(".width").removeClass("w-655");
            $(".width").addClass("w-750");
           

            $(".columnakilos").removeClass("d-none");


        }else{ // OCULTAMOS

            $(".calc").removeClass("calc-750");
            $(".calc").addClass("calc-655");

            $(".width").removeClass("w-750");
            $(".width").addClass("w-655");

            $(".columnakilos").addClass("d-none");

        }

    });

    function FocusInput(){
        $(".input-hover").focus(function (e){
            // e.tabIndex();   
            // console.log(e);

            

            FILASOMBREADA = $(this).parent().data("filasombreado");
            PintarDireccionales();

        });

    }

    //  VER DATOS DE PARTIDA O AGRUPAR PARTIDA
    $("#container-datos-tela").on('click','.verpartida', async function(){

        let  ruta           = $(this).data("ruta");
        window.open(ruta,"_blank");
   
    });

    // ASIGNAR COMENTARIO
    $("#container-datos-generales").on('click','.observaciones',async function(){

        let observaciones = $(this).data("observaciones");
        let obs = await Obtener("Ingrese observaciones","textarea",observaciones);

    });

    // VOLVER
    $("#btnvolverbuscar").click(function(){
        frmvolver.submit();
    });


</script>    

<?php if(!isset($_POST["operacion"])): ?>
    <script>

        const frmbusqueda       = document.getElementById("frmbusqueda");


        window.addEventListener('load',async ()=>{

            
            // SELECT 2 PROGRAMA
            $(".select2programa").select2({
                placeholder : "Seleccione cliente",
                language: {
                    noResults: function() {
                        return 'SELECCIONE UN CLIENTE PRIMERO';
                    },
                },
            });

            // SELECT 2 ARTICULO TELA
            $(".select2articulotela").select2({
                placeholder : "Seleccione cliente",
                language: {
                    noResults: function() {
                        return 'SELECCIONE UN CLIENTE PRIMERO';
                    },
                },
            });

            // PROVEEDORES DE TELA
            await getproveedores();

            // CLIENTES
            await getclientes();

            // COLORES
            await getcolores();

            // ESTADOS TESTING
            await getEstadoTesting();

        });


        // BUSQUEDA
        frmbusqueda.addEventListener('submit',(e)=>{
            // e.preventDefault();
            MostrarCarga();
        });

    </script>

<?php endif; ?>


</body>
</html>