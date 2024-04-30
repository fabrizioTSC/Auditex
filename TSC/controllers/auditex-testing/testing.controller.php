<?php
    session_start();
    // set_time_limit(0);
    // ini_set('max_execution_time', '0');
    require_once '../../models/modelo/core.modelo.php';
    require_once '../../models/modelo/auditex-testing/testing.modelo.php';

    // require_once __DIR__.'/../../vendor/autoload.php';

    $objModelo = new CoreModelo();
    $objTestingModelo = new TestingModelo();
    // use PhpOffice\PhpSpreadsheet\Spreadsheet;
    // use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    if(isset($_POST["operacion"])){


        // GET TESTING DATOS
        if($_POST["operacion"] == "gettesting"){

            // EJECUTAMOS PROCESO PARA CARGA DE PARTIDAS
            $responsecargasige = $objModelo->setAllSQLSIGE("uspCargaPartidaSigeToAuditex",[],"Correcto");

            $parametros = $_POST["parameters"];
            //$response = $objModelo->getAll("USYSTEX.SPU_GET_TESTING",$parametros);
            $response = $objModelo->getAllSQL("AUDITEX.SPU_GET_TESTING",$parametros);

            $_SESSION["reportetesting"] = $response;

            $datostela ="";
            $datosgenerales ="";

            $cont = 0;         

            // ARMAMOS TABLA
            foreach($response as $fila){
                $cont++;
                $fecha  = date("d-m", strtotime($fila['FECHA']));
                $fechalarga  = date("d/m/Y", strtotime($fila['FECHA']));

                //$fechaliberacion  = date("d/m/Y", strtotime($fila['FECHA']));


                $proveedor          = substr($fila['PROVEEDOR'],0,10);
                $color              = substr($fila['COLOR'],0,10);
                $descripciontela    = $fila['DESCRIPCIONTELA'];//substr($fila['DESCRIPCIONTELA'],0,10);
                $programa           = substr($fila['PROGRAMA'],0,7);
                // $codcolor           = substr($fila['CODCOLOR'],0,7);
                $codcolor           = $fila['CODCOLOR'];

                $ruta               = substr($fila['RUTA'],0,7);
                $rutaerp               = substr($fila['RUTAERP'],0,7);
                $simboloestado      = $fila["SIMBOLOESTADO"] == "" ? $fila["ESTADOSISTEMA"] : $fila["SIMBOLOESTADO"];
                $colorestado        = $fila["COLORESTADO"];

                $agrupado                = $fila["PARTIDAAGRUPADA"] != "" ? "A" : "";
                $coloragrupado           = $fila["PARTIDAAGRUPADA"] != "" ? "bg-success-light" : "";

                $negrita            = $fila["PARTIDA"] == $fila["PARTIDAAGRUPADA"] ? "font-weight-bold text-dark" : "";


                $colorcomplemento            = $simboloestado == "C" ? 'bg-complemento' : "";
                $colormuestra                = $simboloestado == "MU" ? 'bg-muestra' : "";
                $colorpartidapendiente       = $fila["FECHAFINAUDITORIATEXTIL"] == "" ? 'bg-pendientetextil' : "";



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

                // <label class='changeestatus{$cont} $colorestado $colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100' style='cursor:pointer'>{$simboloestado}</label>
                //  DATOS DE TELA
                $datostela .= "
                    <div class='td-tela ' data-filasombreado='{$cont}' style='width: 30px;cursor:pointer'  data-fila='{$cont}'>
                        <input value='{$cont} $agrupado' data-valor='' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover sombreado{$cont}' readonly />
                    </div><div class='td-tela ' style='width: 40px;cursor:pointer'  data-idtesting='{$fila['IDTESTING']}'  data-fila='{$cont}'>
                        <input value='{$simboloestado}' data-valor='{$simboloestado}' data-fila='{$cont}' data-idtesting='{$fila['IDTESTING']}' data-kilos='{$fila['KILOS']}' data-idproveedor='{$fila['CODPRV']}' data-partida='{$fila['PARTIDA']}' data-lote='{$fila['LOTE_PRODUTO']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente $colorcomplemento $colormuestra  $colorpartidapendiente w-100 changeestatus{$cont} changeestatus $colorestado  h-100 input-hover sombreado{$cont}' readonly />
                    </div><div class='td-tela columnakilos' style='width: 40px;cursor:pointer'  data-fila='{$cont}'>
                        <input value='{$fila['KILOS']}' data-valor='{$fila['KILOS']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                    </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 60px;' data-toggle='tooltip' data-placement='top' title='{$fila['PROGRAMA']}' > <input  data-valor='{$fila['PROGRAMA']}' value='{$programa}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                    </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 75px;'>  <input data-valor='{$fila['CODTELA']}' value='{$fila['CODTELA']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                    </div><div class='td-tela {$coloragrupado}' data-filasombreado='{$cont}' style='width: 50px;padding-top:5px'>  
                        <a class='verpartida $negrita' data-partida='{$fila['PARTIDA']}' data-idproveedor='{$fila['CODPRV']}' data-idtesting='{$fila['IDTESTING']}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-ruta='/TSC-WEB/auditoriatela/VerAuditoriaTela.php?partida={$fila['PARTIDA']}&codtel={$fila['CODTELA']}&codprv={$fila['CODPRV']}&numvez={$fila['NUMVEZ']}&parte=1&codtad=1'>{$fila['PARTIDA']}</a>
                    </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' >  <input data-valor='{$resultadopartida}'  value='{$resultadopartida}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 sombreado{$cont}  h-100 input-hover' readonly /> 
                    </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 40px;' data-toggle='tooltip' data-placement='top' title='{$fechalarga} '>  <input value='{$fecha}' data-valor='{$fecha}'  class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 sombreado{$cont}  h-100 input-hover' readonly /> 
                    </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 65px;' data-toggle='tooltip' data-placement='top' title='{$fila['PROVEEDOR']}' >
                        <input value='{$proveedor}' data-valor='{$fila['PROVEEDOR']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                    </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 100px;' data-toggle='tooltip' data-placement='top' title='{$fila['DESCRIPCIONTELALARGA']} '>    
                        <input value='{$descripciontela}' data-valor='{$fila['DESCRIPCIONTELALARGA']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                    </div><div class='td-tela ' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' title='{$fila['COLOR']} '>    
                        <input value='{$color}' data-valor='{$fila['COLOR']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                    </div><div class='td-tela' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' title='{$fila['CODCOLOR']} '>  <input data-valor='{$fila['CODCOLOR']}' value='{$codcolor}' class='$colorcomplemento $colormuestra  $colorpartidapendiente  w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                    </div><div class='td-tela' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' title='{$fila['RUTA']}'>       <input data-valor='{$fila['RUTA']}' value='{$ruta}' class='$colorcomplemento $colormuestra  $colorpartidapendiente  w-100  h-100 input-hover sombreado{$cont}' readonly />
                    </div><div class='td-tela' data-filasombreado='{$cont}' style='width: 50px;' data-toggle='tooltip' data-placement='top' title='{$fila['RUTAERP']}'>    <input data-valor='{$fila['RUTAERP']}' value='{$rutaerp}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover sombreado{$cont}' readonly /> 
                    </div><br> 
                ";

                // $datostela .= "<br>";

                // $revirado1primera =  intval($fila['REVIRADO1PRIMERAL']);
                $revirado1primera =  (float)$fila['REVIRADO1PRIMERAL'];
                $revirado2primera =  (float)$fila['REVIRADO2PRIMERAL'];
                $revirado3primera =  (float)$fila['REVIRADO3PRIMERAL'];

                $revirado1tercera =  (float)$fila['REVIRADO1TERCERAL'];
                $revirado2tercera =  (float)$fila['REVIRADO2TERCERAL'];
                $revirado3tercera =  (float)$fila['REVIRADO3TERCERAL'];


                // ENCOGIMIENTO PRIMERA
                $datosgenerales .= "
                    <div class='td ' data-filasombreado='{$cont}'>          <input value='{$fila['HILOPRIMERA']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TRAMAPRIMERA']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADBEFORE']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADAFTER']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOBEFORE']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOAFTER']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLIACABADOS']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLILAVADO']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['SOLIDES']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['REVIRADOPRIMERA']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><!--
                ";

                // ENCOGIMIENTO PRIMERA TSC
                $reviradoprimeratsc = (float)$fila['REVIRADOPRIMERATSC'];
                // $reviradoprimeratsc = $fila['REVIRADOPRIMERATSC'];

                $datosgenerales .= "
                    --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>       <input value='{$fila['HILOPRIMERATSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TRAMAPRIMERATSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADBEFORETSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADAFTERTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOBEFORETSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOAFTERTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLIACABADOSTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLILAVADOTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['SOLIDESTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$reviradoprimeratsc}%' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><!--
                ";

                // PRIMERA LAVADA
                $hiloprimeralavada    = (float)$fila['HILOPRIMERAL'];
                $tramaprimeralavada   = (float)$fila['TRAMAPRIMERAL'];

                $datosgenerales .= "
                    --><div class='td sombreado{$cont}' data-filasombreado='{$cont}' style='width: 25px;'>
                            <button class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 openlavado openlavado1-{$cont}' 
                                    data-tambor='0'
                                    data-idlavada='{$fila['IDREALLAVADAPRIMERA']}' 
                                    data-fila='{$cont}'  
                                    data-lavada='1' 
                                    data-idtesting='{$fila['IDTESTING']}' 
                                    data-lote='{$fila['LOTE_PRODUTO']}' 
                                    data-kilos='{$fila['KILOS']}' 
                                    data-idcliente='{$fila['CODCLI']}' 
                                    data-partida='{$fila['PARTIDA']}'  
                                    data-idproveedor='{$fila['CODPRV']}' 
                                    type='button'> 
                                <i class='fas fa-bars'></i>
                            </button>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover   hilo1{$cont}'  value='{$hiloprimeralavada}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover trama1{$cont}'  value='{$tramaprimeralavada}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  densidad1{$cont}'  value='{$fila['DENSIDADPRIMERAL']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  inclinacion1{$cont}'  value='{$fila['INCLINACIONPRIMERAL']}°'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  ancho1{$cont}'  value='{$fila['ANCHOTOTALPRIMERAL']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  anchoutil1{$cont}'  value='{$fila['ANCHOUTILPRIMERAL']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado11{$cont}'  value='{$revirado1primera}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado21{$cont}'  value='{$revirado2primera}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado31{$cont}'  value='{$revirado3primera}%'>
                    </div><!--
                ";

                // ENCOGIMIENTO TERCERA 
                $datosgenerales .= "
                    --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>       <input value='{$fila['HILOTERCERA']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TRAMATERCERA']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADBEFORE']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADAFTER']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOBEFORE']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOAFTER']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />   
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLIACABADOS']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLILAVADO']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['SOLIDES']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['REVIRADOTERCERA']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><!--
                ";

                $encogimientoterceratsc = (float)$fila['REVIRADOTERCERATSC'];
                // ENCOGIMIENTO TERCERA TSC
                $datosgenerales .= "
                    --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>        <input value='{$fila['HILOTERCERATSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['TRAMATERCERATSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['DENSIDADBEFORETSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['DENSIDADAFTERTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />   
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['ANCHOREPOSOBEFORETSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['ANCHOREPOSOAFTERTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['INCLIACABADOSTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['INCLILAVADOTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />   
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$fila['SOLIDESTSC']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>     <input value='{$encogimientoterceratsc}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><!--
                ";
                
                // ENCOGIMIENTO TERCERA TOLERANCIA
                $datosgenerales .= "
                    --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>       <input value='{$fila['HILOTERCERATOL']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TRAMATERCERATOL']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADBEFORETOL']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['DENSIDADAFTERTOL']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOBEFORETOL']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['ANCHOREPOSOAFTERTOL']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLIACABADOSTOL']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />   
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['INCLILAVADOTOL']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />   
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['SOLIDES']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />   
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['REVIRADOTERCERATOL']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />    
                    </div><!--
                ";

                $solideztercera = (float)$fila['SOLIDEZTERCERAL']; //$fila['SOLIDEZTERCERAL'];

                // TERCERA LAVADA

                $hiloterceralavada    = (float)$fila['HILOTERCERAL'];
                $tramaterceralavada   = (float)$fila['TRAMATERCERAL'];

                $datosgenerales .= "
                    --><div style='width: 25px;' class='td sombreado{$cont}' data-filasombreado='{$cont}'>
                            <button class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 openlavado openlavado3-{$cont}' 
                                data-tambor='0'
                                data-idlavada='{$fila['IDREALLAVADATERCERA']}' 
                                data-fila='{$cont}'
                                data-lavada='3'
                                data-idtesting='{$fila['IDTESTING']}' 
                                data-lote='{$fila['LOTE_PRODUTO']}' 
                                data-kilos='{$fila['KILOS']}' 
                                data-idcliente='{$fila['CODCLI']}'  
                                data-idproveedor='{$fila['CODPRV']}'   
                                data-partida='{$fila['PARTIDA']}' 
                                type='button'> 
                                <i class='fas fa-bars'></i>
                            </button>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover   hilo3{$cont}'  value='{$hiloterceralavada}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  trama3{$cont}'  value='{$tramaterceralavada}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  densidad3{$cont}'  value='{$fila['DENSIDADTERCERAL']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  inclinacion3{$cont}'  value='{$fila['INCLINACIONTERCERAL']}°'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  ancho3{$cont}'  value='{$fila['ANCHOTOTALTERCERAL']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  anchoutil3{$cont}'  value='{$fila['ANCHOUTILTERCERAL']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado13{$cont}'  value='{$revirado1tercera}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado23{$cont}'  value='{$revirado2tercera}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado33{$cont}'  value='{$revirado3tercera}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  solidez3{$cont}'  value='{$solideztercera}'>
                    </div><!--
                ";

                // TOLERANCIAS BEFORE
                $datosgenerales .= "
                    --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input value='{$fila['TOLERANCIABEFOREMAS']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input value='{$fila['TOLERANCIABEFOREMENOS']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><!--
                ";

                // TOLERANCIAS AFTER
                $datosgenerales .= "
                    --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>       <input value='{$fila['TOLERANCIAAFTERMAS']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'>    <input value='{$fila['TOLERANCIAAFTERMENOS']}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly /> 
                    </div><!--
                ";

                // PORCENTAJE
                // $datosgenerales .= "--><div class='td'>%</div><!--";

                // Encog. De Paños Lavados
                $datosgenerales .= "
                --><div style='width: 25px;' class='td sombreado{$cont}' data-filasombreado='{$cont}'><button class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 openencogimiento' data-fila='{$cont}'   data-idtesting='{$fila['IDTESTING']}' data-lote='{$fila['LOTE_PRODUTO']}' 
                data-hilo='{$fila['HILOENCOGIMIENTO']}' data-trama='{$fila['TRAMAENCOGIMIENTO']}' data-ibefore='{$fila['INCLINACIONBEFORE']}' data-iafter='{$fila['INCLINACIONAFTER']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' data-idproveedor='{$fila['CODPRV']}' typpe='button'> <i class='fas fa-bars'></i></button>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100  input-hover  hiloencogimiento{$cont}'  value='{$fila['HILOENCOGIMIENTO']}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100  input-hover  tramaencogimiento{$cont}'  value='{$fila['TRAMAENCOGIMIENTO']}%'>
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100  input-hover  inclibefore{$cont}'  value='{$fila['INCLINACIONBEFORE']}'> 
                </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100  input-hover  incliafter{$cont}'  value='{$fila['INCLINACIONAFTER']}'>
                </div><!--";

                $fechaliberacionlarga    = $fila['FECHALIBERACION']  ;
                $fechaliberacionlarga = $fila['FECHALIBERACION'];
                $hora = date('H:i:s', strtotime($fechaliberacionlarga));
                $fechaliberacion    = $fila['FECHALIBERACION']  == "" ? "-" : date("d-m", strtotime($fila['FECHALIBERACION']));// $fila['FECHALIBERACION'];
           

                $usuario            = $fila['USUARIO']          == "" ? "-" : $fila['USUARIO'];
                $nombreusuario      = $fila['NOMBREUSUARIO'];
                $observaciones      = $fila['OBSERVACIONES']    == "" ? "-" : $fila['OBSERVACIONES'];
                // $observaciones      = substr($observaciones,0,10);


                // #######################
                // ### RESIDUALES PAÑO ###
                // #######################

                $hiloresidual       = (float)$fila['HILORESIDUAL'];
                $tramaresidual       = (float)$fila['TRAMARESIDUAL'];
                $inclinacionresidual       = (float)$fila['INCLINACIONRESIDUAL'];
                $revirado1residual       = (float)$fila['REVIRADO1RESIDUAL'];
                $revirado2residual       = (float)$fila['REVIRADO2RESIDUAL'];
                $revirado3residual       = (float)$fila['REVIRADO3RESIDUAL'];




                $datosgenerales .= "
                    --><div style='width: 25px;' class='td sombreado{$cont}' data-filasombreado='{$cont}'>
                        <button
                            class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 openresidual openresidual-{$cont}'
                            data-idresidual='{$fila['IDRESIDUALPANO']}' 
                            data-fila='{$cont}' 
                            data-idtesting='{$fila['IDTESTING']}' 
                            data-lote='{$fila['LOTE_PRODUTO']}' 
                            data-kilos='{$fila['KILOS']}' 
                            data-partida='{$fila['PARTIDA']}' 
                            data-idcliente='{$fila['CODCLI']}' 
                            data-idproveedor='{$fila['CODPRV']}' 
                            type='button'> 
                                <i class='fas fa-bars'></i>
                        </button>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover   hilo{$cont}'  value='{$hiloresidual}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  trama{$cont}'  value='{$tramaresidual}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  inclinacion{$cont}'  value='{$inclinacionresidual}°'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado1{$cont}'  value='{$revirado1residual}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado2{$cont}'  value='{$revirado2residual}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado3{$cont}'  value='{$revirado3residual}%'>
                    </div><!--
                ";



                // ######################
                // ### PRIMERA TAMBOR ###
                // ######################

                $hiloprimeralavadatam    = (float)$fila['HILOPRIMERALTAM'];
                $tramaprimeralavadatam   = (float)$fila['TRAMAPRIMERALTAM'];

                $revirado1primeratam =  (float)$fila['REVIRADO1PRIMERALTAM'];
                $revirado2primeratam =  (float)$fila['REVIRADO2PRIMERALTAM'];
                $revirado3primeratam =  (float)$fila['REVIRADO3PRIMERALTAM'];


                $datosgenerales .= "
                    --><div class='td sombreado{$cont}' data-filasombreado='{$cont}' style='width: 25px;'>
                    <button class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 
                            openlavadotambor 
                            openlavadotambor1-{$cont}'
                            data-tambor='1'
                            data-idlavadatambor='{$fila['IDREALLAVADAPRIMERATAM']}'
                            data-fila='{$cont}'
                            data-lavada='1'
                            data-idtesting='{$fila['IDTESTING']}' 
                            data-lote='{$fila['LOTE_PRODUTO']}' 
                            data-kilos='{$fila['KILOS']}' 
                            data-idcliente='{$fila['CODCLI']}' 
                            data-partida='{$fila['PARTIDA']}'  
                            data-idproveedor='{$fila['CODPRV']}' 
                            type='button'> <i class='fas fa-bars'></i></button>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover   hilo1{$cont}tambor'  value='{$hiloprimeralavadatam}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover trama1{$cont}tambor'  value='{$tramaprimeralavadatam}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  densidad1{$cont}tambor'  value='{$fila['DENSIDADPRIMERALTAM']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  inclinacion1{$cont}tambor'  value='{$fila['INCLINACIONPRIMERALTAM']}°'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  ancho1{$cont}tambor'  value='{$fila['ANCHOTOTALPRIMERALTAM']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  anchoutil1{$cont}tambor'  value='{$fila['ANCHOUTILPRIMERALTAM']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado11{$cont}tambor'  value='{$revirado1primeratam}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado21{$cont}tambor'  value='{$revirado2primeratam}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado31{$cont}tambor'  value='{$revirado3primeratam}%'>
                    </div><!--
                ";

                // ######################
                // ### TERCERA TAMBOR ###
                // ######################

                $hiloterceralavadatam       = (float)$fila['HILOTERCERALTAM'];
                $tramaterceralavadatam      = (float)$fila['TRAMATERCERALTAM'];

                $revirado1terceratam        =  (float)$fila['REVIRADO1TERCERALTAM'];
                $revirado2terceratam        =  (float)$fila['REVIRADO2TERCERALTAM'];
                $revirado3terceratam        =  (float)$fila['REVIRADO3TERCERALTAM'];
                $solidezterceratam          =  (float)$fila['SOLIDEZTERCERALTAM']; //$fila['SOLIDEZTERCERAL'];


                $datosgenerales .= "
                    --><div style='width: 25px;' class='td sombreado{$cont}' data-filasombreado='{$cont}'>
                        <button class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 
                            openlavadotambor 
                            openlavadotambor3-{$cont}' 
                            data-tambor='1'
                            data-idlavadatambor='{$fila['IDREALLAVADATERCERATAM']}' 
                            data-fila='{$cont}'  
                            data-lavada='3' 
                            data-idtesting='{$fila['IDTESTING']}' 
                            data-lote='{$fila['LOTE_PRODUTO']}' 
                            data-kilos='{$fila['KILOS']}' 
                            data-idcliente='{$fila['CODCLI']}'  
                            data-idproveedor='{$fila['CODPRV']}'   
                            data-partida='{$fila['PARTIDA']}' 
                            type='button'> 
                            <i class='fas fa-bars'></i>
                        </button>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover   hilo3{$cont}tambor'  value='{$hiloterceralavadatam}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  trama3{$cont}tambor'  value='{$tramaterceralavadatam}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  densidad3{$cont}tambor'  value='{$fila['DENSIDADTERCERALTAM']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  inclinacion3{$cont}tambor'  value='{$fila['INCLINACIONTERCERALTAM']}°'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  ancho3{$cont}tambor'  value='{$fila['ANCHOTOTALTERCERALTAM']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  anchoutil3{$cont}tambor'  value='{$fila['ANCHOUTILTERCERALTAM']}'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado13{$cont}tambor'  value='{$revirado1terceratam}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado23{$cont}tambor'  value='{$revirado2terceratam}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='text' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  revirado33{$cont}tambor'  value='{$revirado3terceratam}%'>
                    </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}'> <input type='tel' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100 h-100 input-hover  solidez3{$cont}tambor'  value='{$solidezterceratam}'>
                    </div><!--
                ";

                 // DATOS EXTRA 264165 fecha liberacion
                //  $datosgenerales .= "
                //  --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'  data-toggle='tooltip' data-placement='top' title='{$fechaliberacionlarga}' > <input value='{$fechaliberacion}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />   
                //  </div><div class='td sombreado{$cont}' data-filasombreado='{$cont}' data-toggle='tooltip' data-placement='top' title='{$nombreusuario}' >      <input value='{$usuario}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                //  </div><div class='td sombreado{$cont}'  data-fila='{$cont}'  style='width:100px !important;cursor:pointer;'><input data-fila='{$cont}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' data-observaciones='{$fila['OBSERVACIONES']}' data-idtesting='{$fila['IDTESTING']}' value='{$observaciones}' class='observaciones observaciones{$cont} $colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                //  </div><!--";

                // $checkedconcesion = $fila['CONCESION'] == "" ? "0" : "1";
                $checkedconcesion = $fila['CONCESION']  == "1" ? "checked" : "";

                // DATOS EXTRA
                $datosgenerales .= "
                 --><div class='td sombreado{$cont}' data-filasombreado='{$cont}'  data-toggle='tooltip' data-placement='top' title='{$fechaliberacionlarga}' > <input value='{$fechaliberacion}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />   
                 </div>
                 <div class='td sombreado{$cont}' data-filasombreado='{$cont}' data-toggle='tooltip' data-placement='top' title='{$nombreusuario} ' >
                 
                 <input value='{$usuario}' class='$colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                 </div><div class='td sombreado{$cont}'  data-fila='{$cont}'  style='width:100px !important;cursor:pointer;'><input data-fila='{$cont}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' data-observaciones='{$fila['OBSERVACIONES']}' data-idproveedor='{$fila['CODPRV']}' data-idtesting='{$fila['IDTESTING']}' value='{$observaciones}' class='observaciones observaciones{$cont} $colorcomplemento $colormuestra  $colorpartidapendiente w-100  h-100 input-hover' readonly />  
                 </div><div class='td sombreado{$cont}'  data-fila='{$cont}' ><input type='checkbox' data-fila='{$cont}' data-lote='{$fila['LOTE_PRODUTO']}' data-kilos='{$fila['KILOS']}' data-partida='{$fila['PARTIDA']}' data-idproveedor='{$fila['CODPRV']}' data-idtesting='{$fila['IDTESTING']}'  {$checkedconcesion} class='form-control form-control-sm setconcesion{$cont} setconcesion'  />  
                 </div><!--";

                // // SALTO DE LINEA
                $datosgenerales .= "--><br>";

            }

            // echo $datostela;

            echo json_encode(
                array(
                    "datostela" => $datostela,
                    "datosgenerales" => $datosgenerales,
                    "cant" => $cont,
                    "responsecargasige" => $responsecargasige
                )
            );


        }

        // REPORTE
        if($_POST["operacion"] == "setexportartesting"){

            $filtros = $_POST["filtros"];

            $objTestingModelo->getExcel("testingreporte",$_SESSION["reportetesting"],$filtros);
        }

    }


    if(isset($_GET["operacion"])){

        // GET BOLSAS
        if($_GET["operacion"] == "getbolsa"){

            $response = $objModelo->getSQL("AUDITEX.SPU_GETBOLSAS_NEW_V2",[
                $_GET["idlavada"],$_GET["idresidualpano"],$_GET["numerobolsa"],$_GET["idlavadatambor"]
            ]);
            echo json_encode($response);

        }

        // GET DETALLE DE BOLSA
        if($_GET["operacion"] == "getdetallebolsa"){

            $response = $objModelo->getAllSQL("AUDITEX.SPU_GETDETALLEBOLSAS",[
                $_GET["idbolsa"]
            ]);
            echo json_encode($response);

        }

        // PROVEEDORES DE TELA
        if($_GET["operacion"] == "getproveedorestela"){

            $response = $objModelo->getAllSQL("AUDITEX.SPU_GETPROVEEDORESTELA",[]);
            echo json_encode($response);

        }

        // CLIENTES
        if($_GET["operacion"] == "getclientes"){

            $response = $objModelo->getAllSQL("AUDITEX.GET_CLIENTES",[]);
            echo json_encode($response);

        }

        // PROGRAMAS SEGUN CLIENTE
        if($_GET["operacion"] == "getprogramacliente"){

            $response = $objModelo->getAllSQL("AUDITEX.SPU_GETPROGRAMACLIENTE",[
                // $_GET["cli9"],$_GET["cli4"],$_GET["cli2"]
                $_GET["idcliente"]
            ]);
            echo json_encode($response);

        }

        // TIPOS DE TELA
        if($_GET["operacion"] == "gettipostela"){

            $response = $objModelo->getAllSQL("AUDITEX.SPU_GETTIPOSTELA_TESTING",[]);
            echo json_encode($response);

        }

        // ARTICULOS DE TELA
        if($_GET["operacion"] == "getarticulostela"){

            $response = $objModelo->getAllSQL("AUDITEX.SPU_GETARTICULOCLIENTE",[
                $_GET["idcliente"]
            ]);

            echo json_encode($response);

        }

        // COLORES
        if($_GET["operacion"] == "getcolores"){

            $response = $objModelo->select(
                "
                    SELECT 
                        DISTINCT
                        -- DSCCOL IDCOLOR,
                        CODCOL DESCOLOR
                    FROM AUDITEX.PARTIDATELA
                "
            );
            echo json_encode($response);

        }

        // ENCOGIMIENTOS SEGUN TESTING
        if($_GET["operacion"] == "getencogimientos"){

            $response = $objModelo->getSQL("AUDITEX.GET_ENCOGIMIENTOS",[
                $_GET["idtesting"],$_GET["tipo"]
            ]);

            echo json_encode($response);

        }

        // GET DATOS ENCOGIMIENTOS 
        if($_GET["operacion"] == "getencogimientoreal"){

            $response = $objModelo->getSQL("AUDITEX.SPU_GETENCOGIMIENTOREAL",[
                $_GET["idtesting"]
            ]);

            echo json_encode($response);

        }

        // GET ESTADO TESTING
        if($_GET["operacion"] == "getestadostesting"){

            $response = $objModelo->getAllSQL("AUDITEX.SPU_GETESTADOS_TESTING",[]);
            echo json_encode($response);

        }
        
        // MOSTRAMOS DATOS
        if($_GET["operacion"] == "getpartidasagrupadas"){

            $response = $objModelo->getAllSQL("AUDITEX.SPU_GETPARTIDASAGRUPADAS",[$_GET["partida"]]);

            foreach($response as $fila){

                $agrupada =  $fila['PARTIDA'] == $fila['PARTIDAAGRUPADA'] ? "text-primary" : "";

                echo "<tr>";
                echo "<td class='{$agrupada}'> 
                    {$fila['PARTIDA']} ";

                if($agrupada != ""){
                    echo " - PARTIDA MADRE";
                }

                echo "</td>";

                if($agrupada == ""){
                    echo "<td> <a class='desagrupar' href='#' data-partidamadre='{$fila['PARTIDAAGRUPADA']}' data-id='{$fila['IDTESTING']}' >Desagrupar</a> </td>";
                }else{
                    echo "<td></td>";
                }

                echo "</tr>";

            }

        }

        // MOTIVOS DE DEVOLUCION
        if($_GET["operacion"] == "getmotivosrechazos"){

            $response = $objModelo->getAllSQL("AUDITEX.SPU_GETMOTIVOS_DEVO",[]);
            echo json_encode($response);

        }

        // MOTIVOS DE DEVOLUCION
        if($_GET["operacion"] == "getmotivosrechazosbyid"){

            $response = $objModelo->getAllSQL("AUDITEX.SPU_GETMOTIVODEVO_TESTING",[$_GET["id"]]);
            echo json_encode($response);

        }

        // #################
        // ### REGISTROS ###
        // #################


        // REGISTRO TESTING
        if($_GET["operacion"] == "settesting"){

            $response = $objModelo->getSQL("AUDITEX.SPU_TESTING_CREATE_NEW",[
                $_GET["partida"],$_GET["lote"],$_GET["kilos"],$_GET["idproveedor"]
            ]);

            echo json_encode($response);

        }

         // REGISTRO LAVADA
         if($_GET["operacion"] == "setlavada"){

            $response = $objModelo->getSQL("AUDITEX.SPU_LAVADA_CREATE_V2",[
                $_GET["idtesting"],$_GET["tipolavada"],$_GET["tambor"]
            ]);

            echo json_encode($response);

        }

        // REGISTRAR BOLSAS
        if($_GET["operacion"] == "setbolsas"){

            $response = $objModelo->getSQL("AUDITEX.SPU_BOLSAS_CREATE_NEW_V2",[
                $_GET["idbolsa"],               $_GET["idreallavada"],      $_GET["idresidualpano"],
                $_GET["idreallavadatambor"],    $_GET["numerobolsa"],       $_GET["valorac"],
                $_GET["valorbd"]
            ]);

            echo json_encode($response);

        }

        // REGISTRAR DETALLE DE BOLSAS
        if($_GET["operacion"] == "setdetallebolsas"){

            $response = $objModelo->getSQL("AUDITEX.SPU_DETALLE_BOLSAS_CREATE",[
                $_GET["iddetallebolsa"],$_GET["idbolsa"],$_GET["hilo"],$_GET["trama"],$_GET["orden"]
            ]);

            echo json_encode($response);


        }

        // ACTUALIZAMOS LAVADA
        if($_GET["operacion"] == "setupdatelavada"){

            $response = $objModelo->getSQL("AUDITEX.SPU_UPDATE_REALESLAVADA",[
                $_GET["idbolsa"]
            ]);

            echo json_encode($response);


        }

        // REGISTRAMOS ENCOGIMIENTOS
        if($_GET["operacion"] == "setencogimientos"){


            $response = $objModelo->setAllSQL("AUDITEX.SPU_ENCOGIMIENTOS_CREATE",[
                $_GET["idtesting"],$_GET["tipo"],$_GET["hilo"],$_GET["trama"]
            ],"correcto");

            echo json_encode($response);

        }

        // ACTUALIZAMOS ENCOGIMIENTOS EN TESTING
        if($_GET["operacion"] == "updateencogimientos"){

            $response = $objModelo->getSQL("AUDITEX.TESTING_ENCOGI_UPDATE",[

                $_GET["idtesting"], $_GET["hilo"],
                $_GET["trama"],     $_GET["inclib"],
                $_GET["inclia"]

            ]);

            echo json_encode($response);

        }

        // ACTUALIZAMOS LAVADAS
        if($_GET["operacion"] == "setupdatelavadamanual"){


            $response = $objModelo->getSQL("AUDITEX.SPU_REAL_TSC_LAVADA_UPD_V2",[
                $_GET["idreallavada"],  $_GET["idtesting"],     $_GET["tipolavada"],    $_GET["hilo"],
                $_GET["trama"],         $_GET["densidad"],      $_GET["inclinacion"],   $_GET["anchototal"],
                $_GET["revirado1"],     $_GET["revirado2"],     $_GET["revirado3"],     $_GET["solidez"],
                $_GET["anchoutil"],     $_GET["tambor"]
            ]);

            echo json_encode($response);

        }

        // ACTUALIZAMOS RESIDUAL PAÑO
        if($_GET["operacion"] == "setupdateresidualpanomanual"){

            $response = $objModelo->getSQL("AUDITEX.SPU_RESIDUAL_PANO_UPDATE",[
                $_GET["idresidualpano"],    $_GET["idtesting"],     $_GET["hilo"],
                $_GET["trama"],             $_GET["inclinacion"],   $_GET["revirado1"],
                $_GET["revirado2"],         $_GET["revirado3"]
            ]);

            echo json_encode($response);

        }


        // ACTUALIZAMOS ESTADO
        if($_GET["operacion"] == "setestadotesting"){

            $response = $objModelo->getSQL("AUDITEX.SPU_UPDATEESTADO_TESTING",[
                $_GET["idtesting"],$_GET["estado"],$_GET["user"]
            ]);

            echo json_encode($response);

        }

        // ASIGNAR CONCESION
        if($_GET["operacion"] == "setconcesion"){

            $response = $objModelo->setAllSQL("AUDITEX.SPU_SETCONCESION_TESTING",[
                $_GET["idtesting"],$_GET["estado"]
            ],"Realizado correctamente");

            echo json_encode($response);

        }

        // ACTUALIZAMOS OBSERVACIONES
        if($_GET["operacion"] == "setobstesting"){

            $response = $objModelo->setAllSQL("AUDITEX.SPU_UPDATEOBS_TESTING",[
                $_GET["idtesting"],$_GET["obs"]
            ],"Modificado correctamente");
            

            echo json_encode($response);

        }

        // AGRUPAMOS PARTIDA
        if($_GET["operacion"] == "setagruparpartida"){

            $idtesting      = $_GET["idtesting"];
            $partidaorigen  = $_GET["partidaorigen"];
            $partidacopia   = $_GET["partidacopia"];
            $kilos          = $_GET["lote"];
            $lote           = $_GET["kilos"];
            $idproveedor    = $_GET["idproveedor"];




            $response = $objModelo->setAllSQL("AUDITEX.SPU_AGRUPAR_TESTING_NEW",[
                $idtesting, $partidaorigen,$partidacopia,$kilos,$lote,$idproveedor
            ],"Agrupado correctamente");

            echo json_encode($response);

        }

        // DESAGRUPAR PARTIDAS
        if($_GET["operacion"] == "setdesagruparpartidas"){

            $response = $objModelo->setAllSQL("AUDITEX.SPU_DESAGRUPAR_PARTIDA",
                [$_GET["id"]],"Desagrupada correctamente"
            );  

            echo json_encode($response);

        }

        // REGISTRAR MOTIVOS
        if($_GET["operacion"] == "savemotivostesting"){

            $idtesting      = $_GET["idtesting"];
            $idfammotivo    = $_GET["idfammotivo"];

            $response = $objModelo->setAllSQL("AUDITEX.SPU_SETMOTIVODEVO_TESTING",[$idtesting,$idfammotivo],"registrado");
            echo json_encode($response);

        }

        // ELIMINAMOS MOTIVOS ANTES DE ACTUALIZAS
        if($_GET["operacion"] == "deletemotivostesting"){

            $idtesting      = $_GET["idtesting"];

            $response = $objModelo->setAllSQL("AUDITEX.SPU_DELETEMOTIVODEVO_TESTING",[$idtesting],"Eliminado");
            echo json_encode($response);

        }


    }

?>