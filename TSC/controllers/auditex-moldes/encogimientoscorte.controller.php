
<?php
session_start();
ini_set('memory_limit', '-1');

require_once '../../models/modelo/core.modelo.php';
require_once '../../models/modelo/auditex-moldes/encogimientoscorte.modelo.php';


$objModelo = new CoreModelo();
$objEncogimientosCorteM = new EncogimientosCorteModelo();
// $objTestingModelo = new TestingModelo();

    // OPERACIOMES POST
    if (isset($_POST["operacion"])) {


        // REGISTRAMOS DATOS FINALES DE PRUEBA DE ENCOGIMIENTO
        if ($_POST["operacion"] == "setpruebaencogimiento") {


            // DIRECTORIO
			$directorio = '../../public/auditex-moldes/tmpencogimientos/';


            // REGISTRAMOS DATOS
            $ficha              = $_POST["ficha"];
            $usuario            = $_POST["usuario"];
            $estilotsc          = $_POST["estilotsc"];

            $hilotendencia      = $_POST["hilotendencia"];
            $tramatendencia     = $_POST["tramatendencia"];

            $hiloevaluacion     = $_POST["hiloevaluacion"];
            $tramaevaluacion    = $_POST["tramaevaluacion"];
            $mangaevaluacion    = $_POST["mangaevaluacion"];


            // MOVEMOS IMAGEN PRINCIPAL
            $extension = explode(".",$_FILES["imgprincipal"]["name"]);
            $extension = end($extension);
            $date = date('YmdHis');
            $nombreimagenprincipal = "ficha{$ficha}_imgprincipal_date{$date}.{$extension}";

            // ARCHIVO TEMPORAL QUE VAMOS A MOVER
            $archivotemporal = $_FILES["imgprincipal"]["tmp_name"]; 
                    
            // ABRIMOS EL DIRECTORIO
            $dir=opendir($directorio); 
            // RUTA DEL DESTINO CON NOMBRE                           
            $ubicacion = $directorio.'/'.$nombreimagenprincipal; 

            // MOVEMOS
            if(move_uploaded_file($archivotemporal, $ubicacion))
            {

                 // REGISTRAMOS DATOS DE LA PRUEBA DE ENCOGIMIENTO
                $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                    9,$ficha,$estilotsc,null,null,null,null,null,null,null,null,null,null,$usuario,null,
                    $hilotendencia,$tramatendencia,$hiloevaluacion,$tramaevaluacion,$mangaevaluacion,$nombreimagenprincipal
                    ,null,null,null,null
                ]);


                $cantimagenes = 0;
                $cantimagenessubidas = 0;
                $mensaje = "";

                foreach($_FILES["imagenes"]['tmp_name'] as $key => $tmp_name)
                {
                    $cantimagenes++;
                    //Validamos que el archivo exista
                    if($_FILES["imagenes"]["name"][$key]) {

                        // NOMBRE DE LA IMAGEN
                        // $nombre = $_FILES["imagenes"]["name"][$key]; 
                        $extension = explode(".",$_FILES["imagenes"]["name"][$key]);
                        $extension = end($extension);
                        $date = date('YmdHis');
                        $nombre = "ficha{$ficha}_key{$key}_date{$date}.{$extension}";


                        // ARCHIVO TEMPORAL QUE VAMOS A MOVER
                        $archivotemporal = $_FILES["imagenes"]["tmp_name"][$key]; 
                        
                        // ABRIMOS EL DIRECTORIO
                        $dir=opendir($directorio); 
                        // RUTA DEL DESTINO CON NOMBRE                           
                        $ubicacion = $directorio.'/'.$nombre; 
                        
                        // MOVEMOS
                        if(move_uploaded_file($archivotemporal, $ubicacion))
                        {

                            // REGISTRAMOS RUTA DE LA IMAGEN
                            $response = $objModelo->setAll("AUDITEX.PQ_MOLDES.SPU_SETIMGPRUEBAENCOGIMIENTO", [
                                $ficha,$nombre,$usuario
                            ],"Registrado Correctamente");

                            if($response["success"]){
                                $cantimagenessubidas++;
                            }

                        }
                        
                    }
                }  

                echo json_encode(
                    [
                        "success" => $cantimagenessubidas == $cantimagenes ? true : false,
                        "mensaje" => $cantimagenessubidas == $cantimagenes ? "Realizado correctamente" : "Se subieron {$cantimagenessubidas} imagenes de {$cantimagenes}"
                    ]
                );

            }else{

                echo json_encode(
                    [
                        "success" => false,
                        "mensaje" => "No se pudo subir imagen principal"
                    ]
                );

            }


        }


        // EXPORTAMOS REPORTE
        if($_POST["operacion"] == "setexportarmoldes"){

            $objEncogimientosCorteM->getExcelMoldes("reporteencogimientos",$_SESSION["molde_reporte"]);

        }

    }

    // METODO GET
    if (isset($_GET["operacion"])) {


        // EXPORTAMOS REPORTE
        if($_GET["operacion"] == "setexportarmoldes"){

            // $objEncogimientosCorteM->getExcelMoldes("reporteencogimientos",$_SESSION["molde_reporte"]);
            // var_dump($_SESSION["molde_reporte"]);

            // $fecini         = $_GET["frFechaI"]        != "" ? $_GET["frFechaI"] : "";
            // $fecfin         = $_GET["frFechaF"]        != "" ? $_GET["frFechaF"] : "";
            // $cliente        = $_GET["cliente"]         != "" ? $_GET["cliente"] : "";
            // $partida        = $_GET["partida"]         != "" ? $_GET["partida"] : "";
            // $ficha          = $_GET["ficha"]           != "" ? $_GET["ficha"] : "";
            // $estcli         = $_GET["estcli"]          != "" ? $_GET["estcli"] : "";
            // $articulo       = $_GET["articulo"]        != "" ? $_GET["articulo"] : "";
            // $programa       = $_GET["programa"]        != "" ? $_GET["programa"] : "";

            // // $estatus        = isset($_GET["estatus"])          ? join("','",$_GET["estatus"]) : "";
            // $estatus        = isset($_GET["estatus"])          ? $_GET["estatus"] : "";




            // $esttsc         = $_GET["esttsc"]          != "" ? $_GET["esttsc"] : "";
            // $color          = $_GET["color"]           != "" ? $_GET["color"] : "";
            // $encogimiento   = $_GET["encogimiento"]    != "" ? $_GET["encogimiento"] : "";

            // $fecinilib      = $_GET["frFechaILiberacion"]        != "" ? $_GET["frFechaILiberacion"] : "";
            // $fecfinlib      = $_GET["frFechaFLiberacion"]        != "" ? $_GET["frFechaFLiberacion"] : "";

            // $usuliberacion = $_GET["usuliberacion"]              != "" ? $_GET["usuliberacion"] : ""; 
            

            // $responsefichas = $objModelo->getAll("USYSTEX.SPGET_RPT_MOLDESCORTE_001_NEW", [
            //     $fecini,    $fecfin,    $cliente, $partida, $ficha, $estcli, $articulo, $programa, $estatus, $esttsc, $color, $encogimiento,
            //     $fecinilib, $fecfinlib,$usuliberacion
            // ]);

            $objEncogimientosCorteM->getExcelMoldes("reporteencogimientos",$_SESSION["molde_reporte"]);
            // $objEncogimientosCorteM->getExcelMoldes("reporteencogimientos",$responsefichas);


    


        }

        // OBTENEMOS DATA PARA REGISTRO
        if($_GET["operacion"] == "getreporte_new"){

            $fecini = $_GET["frFechaI"];
            $fecfin = $_GET["frFechaF"];
            $cliente = $_GET["cliente"];
            $partida = $_GET["partida"];
            $ficha = $_GET["ficha"];
            $estcli = $_GET["estcli"];
            $articulo = $_GET["articulo"];
            $programa = $_GET["programa"];
            $estatus = $_GET["estatus"];
            $esttsc = $_GET["esttsc"];
            $color = $_GET["color"];
            $encogimiento = $_GET["encogimiento"];
            
            $response = $objModelo->getAll("USYSTEX.SPGET_RPT_MOLDESCORTE_001_NEW", [
                $fecini, $fecfin, $cliente, $partida, $ficha, $estcli, $articulo, $programa, $estatus, $esttsc, $color, $encogimiento
            ]);

            // GUARDAMOS EN VARIABLE DE SESION
            $_SESSION["molde_reporte"] = $response;


            $datosficha = "";
            $datoscuerpo = "";
            $cont = 0;

            foreach($response as $fila){

                $cont++;
                $fechaemision = date("d/m/Y", strtotime($fila['FECHAEMISION']));
                $fechaliberacion = $fila['FECHA_LIBERACION'] != "" ? date("d/m/Y", strtotime($fila['FECHA_LIBERACION'])) : "";


                $pruebaencogimiento = $fila['PRUEBA_ENCOGIMIENTO'] == "" ? false : true;

                $checked = $pruebaencogimiento ? "<input type='checkbox' data-estilotsc='{$fila['ESTILOTSC']}'  data-partida='{$fila['PARTIDA']}' data-fila='{$cont}' data-ficha='{$fila['FICHA']}' class='checkpruebaencogimiento' checked />" : "<input type='checkbox' data-fila='{$cont}'  data-estilotsc='{$fila['ESTILOTSC']}'  data-partida='{$fila['PARTIDA']}' data-ficha='{$fila['FICHA']}' class='checkpruebaencogimiento'/>" ;


                echo "<tr class='text-center'>";
                echo "<td class='border-table-left'>{$cont}</td>";
                echo "<td style='width: 500px;' >{$fila['FICHA']}</td>";

                $estadomoldaje_simbolo  = $fila['SIMBOLOMOLDAJE'];
                $estadomoldaje_color    = $fila['COLORESTADOMOLDAJE'];


                echo "<td style='cursor:pointer;' data-idestado='{$fila['IDESTADOMOLDE']}' class='estmoldaje estmoldaje{$cont} {$estadomoldaje_color}' data-estilotsc='{$fila['ESTILOTSC']}' data-fila='{$cont}' data-ficha='{$fila['FICHA']}'>
                    {$estadomoldaje_simbolo}
                </td>";
                echo "<td >{$checked}</td>";
                echo "<td data-toggle='popover' title='Descripción estado' data-estilotsc='{$fila['ESTILOTSC']}' data-content='{$fila['DESCRIPCIONESTADO']}' style='cursor:pointer' class='{$fila['COLORESTADO']}'>{$fila['SIMBOLOESTADO']}</td>";

                echo "<td>{$fechaemision}</td>";

                if($fechaliberacion != ""){
                    echo "<td>
                        <button type='button' data-ficha='{$fila['FICHA']}' class='btn btn-sm btn-info buttons-table fechaliberacion'>{$fechaliberacion}</button>
                    </td>";
                }else{
                    echo "<td></td>";
                }
                

                $fantasiacliente = $fila['FANTASIA_CLIENTE'] == "" ? "CLI" : $fila['FANTASIA_CLIENTE'];
                echo "
                <td>
                    <button type='button' class='btn btn-sm btn-warning buttons-table' data-toggle='popover' title='Cliente' data-content='{$fila['CLIENTE']}'>{$fantasiacliente}</button>
                </td>";

                echo "<td>{$fila['PROGRAMA']}</td>";
                echo "<td>{$fila['PEDIDO_VENDA']}</td>";
                echo "<td>{$fila['ESTILOCLIENTE']}</td>";
                echo "<td>{$fila['ESTILOTSC']}</td>";



                $articulo = strlen($fila['ARTICULO']) > 6 ?  substr($fila['ARTICULO'],0,6) : $fila['ARTICULO'];                
                echo "<td>
                    <button type='button' class='btn btn-sm btn-info buttons-table' data-toggle='tooltip' data-placement='right' title='{$fila['ARTICULO']}'>{$articulo}</button>
                </td>";

                $color = strlen($fila['COLOR']) > 6 ? substr($fila['COLOR'],0,6) : $fila['COLOR'];
                echo "<td>
                    <button type='button' class='btn btn-sm btn-danger buttons-table' data-toggle='tooltip' data-placement='right' title='{$fila['COLOR']}'>{$color}</button>
                </td>";

                echo "<td>
                    <a target='_blank' href='/TSC-WEB/auditoriatela/VerAuditoriaTela.php?partida={$fila['PARTIDA']}&codtel={$fila['CODTELA']}&codprv={$fila['CODPRV']}&numvez={$fila['NUMVEZ']}&parte=1&codtad=1'>    {$fila['PARTIDA']} </a>
                </td>";
                echo "<td>{$fila['QTDE_PROGRAMADA']}</td>";

                $rutaprenda = strlen($fila['RUTA_PRENDA']) > 6 ?  substr($fila['RUTA_PRENDA'],0,6) : $fila['RUTA_PRENDA'];                
                echo "<td>
                    <button type='button' class='btn btn-sm btn-danger buttons-table' data-toggle='tooltip' data-placement='right' title='{$fila['RUTA_PRENDA']}'>{$rutaprenda}</button>
                </td>";

                // ENCOGIMIENTOS TSC
                echo "<td>{$fila['HILOTERCERATSC']}</td>";
                echo "<td>{$fila['TRAMATERCERATSC']}</td>";
                echo "<td>{$fila['DENSIDADBEFORETSC']}</td>";
                echo "<td>{$fila['ANCHOREPOSOBEFORETSC']}</td>";
                echo "<td>{$fila['INCLIACABADOSTSC']}</td>";
                echo "<td class='border-table-right'>{$fila['REVIRADOTERCERATSC']}</td>";

                // ENCOGIMIENTOS ESTANDAR
                echo "<td>{$fila['HILOTERCERA']}</td>";
                echo "<td>{$fila['TRAMATERCERA']}</td>";
                echo "<td>{$fila['DENSIDADBEFORE']}</td>";
                echo "<td>{$fila['ANCHOREPOSOBEFORE']}</td>";
                echo "<td class='border-table-right'>{$fila['REVIRADOTERCERA']}</td>";

                // REALES PRIMERA
                echo "<td>{$fila['HILOPRIMERAL']}%</td>";
                echo "<td>{$fila['TRAMAPRIMERAL']}%</td>";
                echo "<td>{$fila['DENSIDADPRIMERAL']}</td>";
                echo "<td>{$fila['REVIRADO1PRIMERAL']}%</td>";
                echo "<td>{$fila['REVIRADO2PRIMERAL']}%</td>";
                echo "<td>{$fila['REVIRADO3PRIMERAL']}%</td>";
                echo "<td class='border-table-right'>{$fila['INCLINACIONPRIMERAL']}</td>";

                // REALES TERCERA
                echo "<td>{$fila['HILOTERCERAL']}%</td>";
                echo "<td>{$fila['TRAMATERCERAL']}%</td>";
                echo "<td>{$fila['DENSIDADTERCERAL']}</td>";
                echo "<td>{$fila['REVIRADO1TERCERAL']}%</td>";
                echo "<td>{$fila['REVIRADO2TERCERAL']}%</td>";
                echo "<td>{$fila['REVIRADO3TERCERAL']}%</td>";
                echo "<td class='border-table-right'>{$fila['INCLINACIONTERCERAL']}</td>";

                $observaciones = strlen($fila['OBSERVACIONES']) > 30 ?  substr($fila['OBSERVACIONES'],0,30) : $fila['OBSERVACIONES'];                


                echo "
                <td class='border-table-right'>
                    <button type='button' class='btn btn-sm btn-primary buttons-table' data-toggle='popover' title='Comentario de Texting' data-content='{$fila['OBSERVACIONES']}'>{$observaciones}</button>
                </td>";

                echo "<td>{$fila['HILOENCOGIMIENTO']}</td>";
                echo "<td>{$fila['TRAMAENCOGIMIENTO']}</td>";
                echo "<td>{$fila['INCLINACIONBEFORE']}</td>";
                echo "<td class='border-table-right'>{$fila['INCLINACIONAFTER']}</td>";

                $molde_usar_hilo    = $fila['MOLDE_USAR_HILO'];
                $molde_usar_trama   = $fila['MOLDE_USAR_TRAMA'];
                $molde_usar_manga   = $fila['MOLDE_USAR_MANGA'];

                if($molde_usar_hilo != "" || $molde_usar_trama != "" || $molde_usar_manga != ""){

                    echo "<td>
                        
                        <button type='button' class='btn btn-sm btn-success btn-block selectmoldeusar hilousar{$cont} font-sistema p-0' title='Asignar molde a usar'
                            data-estilotsc='{$fila['ESTILOTSC']}'
                            data-estilocliente='{$fila['ESTILOCLIENTE']}'
                            data-ficha='{$fila['FICHA']}'
                            data-fila='{$cont}'
                            >
                            {$molde_usar_hilo}%
                        </button>
                    </td>";
                    echo "<td class='tramausar{$cont}'>{$molde_usar_trama}%</td>";
                    echo "<td class='mangausar{$cont} border-table-right'>{$molde_usar_manga}%</td>";

                }else{
                    echo "
                    <td>
                        <button type='button' class='btn btn-sm btn-primary btn-block selectmoldeusar hilousar{$cont} font-sistema p-0' title='Asignar molde a usar'
                            data-estilotsc='{$fila['ESTILOTSC']}'
                            data-estilocliente='{$fila['ESTILOCLIENTE']}'
                            data-ficha='{$fila['FICHA']}'
                            data-fila='{$cont}'
                            >
                            <i class='fas fa-plus'></i>                            
                        </button>
                    </td>
                    <td class='tramausar{$cont}'></td>
                    <td class='border-table-right mangausar{$cont}'></td>
                    ";
                }

                    
                    $displaypruebaencogimiento = !$pruebaencogimiento ? "d-none" : "";

                    $hiloprueba     = $fila['RESULTADO_PRUEBA_HILO_USADO'];
                    $tramaprueba    = $fila['RESULTADO_PRUEBA_TRAMA_USADO'];
                    $mangaprueba    = $fila['RESULTADO_PRUEBA_MANGA_USADO'];

                    $pruebacolumna = "";

                    if($mangaprueba != "" || $hiloprueba != "" || $tramaprueba != ""){

                        $string = "{$hiloprueba}% - {$tramaprueba}% - {$mangaprueba}%";

                        $pruebacolumna = "
                            <button type='button' class='pruebaencogimiento{$cont} btn btn-sm btn-success btn-block font-sistema p-0 selectpruebaencogimiento selectpruebaencogimiento{$cont} $displaypruebaencogimiento' title='Asignar prueba de encogimiento'
                                data-estilotsc='{$fila['ESTILOTSC']}'

                                data-hilousado='{$hiloprueba}'
                                data-tramausado='{$tramaprueba}'
                                data-mangausado='{$mangaprueba}'

                                data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                data-ficha='{$fila['FICHA']}'
                                data-fila='{$cont}'
                                >
                                {$string}                      
                            </button>
                        ";
                    }else{
                        $pruebacolumna = "
                            <button type='button' class='pruebaencogimiento{$cont} btn btn-sm btn-primary btn-block font-sistema p-0 selectpruebaencogimiento selectpruebaencogimiento{$cont} $displaypruebaencogimiento' title='Asignar prueba de encogimiento'
                                data-estilotsc='{$fila['ESTILOTSC']}'

                                data-hilousado='{$hiloprueba}'
                                data-tramausado='{$tramaprueba}'
                                data-mangausado='{$mangaprueba}'

                                data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                data-ficha='{$fila['FICHA']}'
                                data-fila='{$cont}'
                                >
                                <i class='fas fa-plus'></i>                            
                            </button>
                        ";
                    }


                    echo "<td>{$pruebacolumna}</td>";

                    $resultado_prueba_observacion = $fila['RESULTADO_PRUEBA_OBSERVACION'] == "" ? "Sin Observación" : substr($fila['RESULTADO_PRUEBA_OBSERVACION'],0,12);

                    echo "
                    <td>
                        <button 
                            type='button' data-ficha='{$fila['FICHA']}' 
                            data-fila='{$cont}' 
                            data-estilotsc='{$fila['ESTILOTSC']}'
                            class='btn btn-sm btn-warning buttons-table addobservacionencogimiento addobservacionencogimiento{$cont} $displaypruebaencogimiento pruebaencogimiento{$cont}'  
                            data-observacion='{$fila['RESULTADO_PRUEBA_OBSERVACION']}'>
                            {$resultado_prueba_observacion}
                        </button>
                    </td>";
                    echo "<td class='border-table-right'>
                        <button type='button' data-ficha='{$fila['FICHA']}' data-partida='{$fila['PARTIDA']}' data-estilotsc='{$fila['ESTILOTSC']}' class='btn btn-primary btn-sm font-sistema btn-block buttons-table resultadopruebaencogimiento $displaypruebaencogimiento pruebaencogimiento{$cont}'>
                            <i class='fas fa-eye'></i>
                        </button>
                    </td>";

                echo "<td>12</td>";
                echo "<td>14</td>";
                echo "<td class='border-table-right'>14</td>";

                $observacion_liberacion = $fila['OBSERVACION_LIBERACION'] == "" ? "Agregar" : substr($fila['OBSERVACION_LIBERACION'],0,12);

                echo "
                <td>
                    <button 
                        type='button' data-ficha='{$fila['FICHA']}' 
                        data-fila='{$cont}' 
                        data-estilotsc='{$fila['ESTILOTSC']}'
                        class='btn btn-sm btn-warning buttons-table observacionliberacion observacionliberacion{$cont} '  
                        data-observacion='{$fila['OBSERVACION_LIBERACION']}'>
                        {$observacion_liberacion}
                    </button>
                </td>";

                $usuarioliberado = $fila['NOMBREUSUARIO'];
                echo "<td class='border-table-right usuarioliberado{$cont}'>{$usuarioliberado}</td>";

                echo "</tr>";

            }

        }


        // DATOS DE LA FICHA PARA LA PRUEBA DE ENCOGIMIENTO
        if($_GET["operacion"] == "getdatosfichapruebaencogimiento"){

            $opcion = $_GET["opcion"];
            $ficha = $_GET["ficha"];
            $partida = $_GET["partida"];

            // DATOS DE LA FICHA
            if($opcion == 1){

                $response = $objModelo->get("USYSTEX.SPGET_RPT_MOLDESCORTE_002_NEW",[$opcion,$ficha,$partida]);
                echo json_encode($response);
            }

            // DATOS DE LAS PARTIDAS
            if($opcion == 2){

                $response = $objModelo->getAll("USYSTEX.SPGET_RPT_MOLDESCORTE_002_NEW",[$opcion,$ficha,$partida]);
                echo json_encode($response);

            }

            // DATOS DE TODAS LAS PARTIDAS
            if($opcion == 3){

                $response = $objModelo->getAll("USYSTEX.SPGET_RPT_MOLDESCORTE_002_NEW",[$opcion,$ficha,$partida]);


                // ARMAMOS
                foreach($response as $fila){

                    echo "<tr>";

                    echo "<td class='border-table text-center'>{$fila['PARTIDA']}</td>";
                    echo "<td class='border-table text-center'>{$fila['COLOR']}</td>";

                    echo "<td class='border-table text-center'>{$fila['HILOTERCERA']}</td>";
                    echo "<td class='border-table text-center'>{$fila['TRAMATERCERA']}</td>";

                    echo "<td class='border-table text-center'>{$fila['HILOTERCERATSC']}</td>";
                    echo "<td class='border-table text-center'>{$fila['TRAMATERCERATSC']}</td>";

                    echo "<td class='border-table text-center'>{$fila['HILOTERCERAL']}%</td>";
                    echo "<td class='border-table text-center'>{$fila['TRAMATERCERAL']}%</td>";

                    echo "</tr>";


                }

            }

            // DATOS DE LAS PARTIDAS
            if($opcion == 4){

                $response = $objModelo->get("USYSTEX.SPGET_RPT_MOLDESCORTE_002_NEW",[$opcion,$ficha,$partida]);
                echo json_encode($response);

            }

        }

        // MOSTRAMOS LAS FICHAS QUE SE HAN BUSCADO
        if($_GET["operacion"] == "getfichasreporte"){

            $lista = $_SESSION["molde_reporte"];
            $array = array();

            foreach($lista as $fila){
                $array[] = [
                    "ficha"     => $fila["FICHA"],
                    "estilo"    => $fila["ESTILOTSC"],
                    "programa"    => $fila["PROGRAMA"],
                    "lote_produto"    => $fila["LOTE_PRODUTO"],
                ];
            }

            echo json_encode($array);

        }

        if ($_GET["operacion"] == "getprevisualizacion") {
            $ficha = $_GET["FICHA"];

            $response = $objModelo->get("USYSTEX.SPGET_RPT_MOLDESCORTE_002", [
                $ficha
            ]);
    
            echo json_encode($response); 
            
        }


        // Listar Grilla de moldes disponibles
        if ($_GET["operacion"] == "getreportemoldesdisponible") {

            $estilotsc  = $_GET["estilotsc"];
            $ficha      = $_GET["ficha"];

            $response = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_GETMOLDESUSAR", [
                $estilotsc,$ficha
            ]);

            $cont = 0;

            // var_dump($response);

            foreach ($response as $item) {
                $cont++;
                $selecciontsc =  $item['CANT'];
                $check = "";



                // $hilo       = (float)$item['HILO'] != null ? (float)$item['HILO'] : "";
                // $trama      = (float)$item['TRAMA'] != null ? (float)$item['TRAMA'] : "";

                if($item["HILO"] == "0"){
                    $hilo      = "0";
                }else{
                    $hilo      = (float)$item['HILO'] != null ? (float)$item['HILO'] : "";
                }

                if($item["TRAMA"] == "0"){
                    $trama      = "0";
                }else{
                    $trama      = (float)$item['TRAMA'] != null ? (float)$item['TRAMA'] : "";
                }

                if($item["MANGA"] == "0"){
                    $manga      = "0";
                }else{
                    $manga      = (float)$item['MANGA'] != null ? (float)$item['MANGA'] : "";
                }

                // echo " MANGA 123". $manga. " MANGA";
                // echo "magaa: ".$item['MANGA'] . "fa";

                if ($selecciontsc > 0) {
                    $checksel = "<input class='checkmoldeusar'
                            data-hilo='{$hilo}'
                            data-trama='{$trama}'
                            data-manga='{$manga}'

                            name='radiosel' type='radio' checked='true' />";
                } else {
                    $checksel = "<input
                            data-hilo='{$hilo}'
                            data-trama='{$trama}'
                            data-manga='{$manga}'
                        class='checkmoldeusar' name='radiosel' type='radio'/>";
                    // data-ficha='{$item['FICHA']}'
                }

                // Nombre del campo de mi SP
                echo "<tr>";
                echo "  <td>{$cont}</td>";
                echo "  <td>{$hilo}%</td>";
                echo "  <td>{$trama}%</td>";
                // echo "  <td>{$manga}%</td>";
                echo "  <td>{$manga}%</td>";

                echo "  <td>{$checksel}</td>";
                echo "</tr>";

            }

            
            // ELIMINAR MOLDE USAR
            echo "<tr>";
                echo "
                <td colspan='4'>
                    Eiminar Encogimiento asignado 
                </td>";
                echo "  <td>
                    <input
                        data-hilo='0'
                        data-trama='0'
                        data-manga='0'
                    class='checkmoldeusar' name='radiosel' type='radio'/>
                </td>";
            echo "</tr>";
        }

        // ASIGNA ESTADO DE MOLDAJE
        if ($_GET["operacion"] == "set-actualizarestatusmolde") {

            $ficha = $_GET["ficha"];
            $estilotsc = $_GET["estilotsc"];
            $estado = $_GET["estado"];
            $usuario = $_GET["usuario"];
            $loteficha = $_GET["loteficha"];
            // $usuario = $_SESSION["user"];

            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                1,$ficha,$estilotsc,null,$estado,null,null,null,null,null,null,null,null,$usuario,null,null,null,null,null,null,null
                ,null,null,null,$loteficha
            ]);

            echo json_encode($response);
        }

        // MUESTRA SI LLEVA PRUEBA DE ENCOGIMIENTO
        if ($_GET["operacion"] == "set-actualizarpruebaencogimiento") {

            // $ficha = $_GET["ficha"];
            // $pruebaencogimiento = $_GET["check"];
            // $usuario = $_SESSION["user"];
            $ficha          = $_GET["ficha"];
            $estilotsc      = $_GET["estilotsc"];
            // $estado     = $_GET["estado"];
            $usuario        = $_GET["usuario"];
            $pruebaencogimiento = $_GET["check"];
            $partida        = $_GET["partida"];
            $loteficha = $_GET["loteficha"];


            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                2,$ficha,$estilotsc,$pruebaencogimiento,null,null,null,null,null,null,null,null,null,$usuario,$partida,null,null,null,null,null,null
                ,null,null,null,$loteficha
            ]);

            echo json_encode($response);
        }

        // REGISTRA DATOS DE MOLDE USAR
        if ($_GET["operacion"] == "set-actualizarmoldedisponible") {


            $ficha = $_GET["ficha"];
            $estilotsc = $_GET["estilotsc"];
            $hilo = $_GET["hilo"];
            $trama = $_GET["trama"];
            $manga = $_GET["manga"];
            $usuario = $_GET["usuario"];
            $loteficha = $_GET["loteficha"];
            // $response = $objModelo->setAll("USYSTEX.SPSET_MOLDESCORTE_003", [
            //     $ficha, $estilotsc, $hilo, $trama, $manga, $usuario
            // ], 'Registro actualizado correctamente.');

            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                3,$ficha,$estilotsc,null,null,null,$hilo,$trama,$manga,null,null,null,null,$usuario,null,null,null,null,null,null,null
                ,null,null,null,$loteficha
            ]);

            echo json_encode($response);

        }

        // REGISTRAMOS DATOS DE PRUEBA DE ENCOGIMIENTO
        if ($_GET["operacion"] == "set-actualizarencogimientousado") {

            $ficha      = $_GET["ficha"];
            $estilotsc  = $_GET["estilotsc"];
            $hilo       = $_GET["hilou"];
            $trama      = $_GET["tramau"];
            $manga      = $_GET["mangau"];
            $usuario    = $_GET["usuario"];
            $loteficha = $_GET["loteficha"];


            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                4,$ficha,$estilotsc,null,null,null,null,null,null,$hilo,$trama,$manga,null,$usuario,null,null,null,null,null,null,null
                ,null,null,null,$loteficha
            ]);

            echo json_encode($response);
        }

        // ACTUALIZA OBSERVACION DE PRUEBA DE ENCOGIMIENTOS
        if ($_GET["operacion"] == "set-actualizarobservacion") {

            $ficha          = $_GET["ficha"];
            $estilotsc      = $_GET["estilotsc"];
            $observacion    = $_GET["observacion"];
            $usuario        = $_GET["usuario"];
            $loteficha = $_GET["loteficha"];

            // $response = $objModelo->setAll("USYSTEX.SPSET_MOLDESCORTE_005", [
            //     $ficha, $observacion, $usuario
            // ], 'Registro actualizado correctamente.');

            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                5,$ficha,$estilotsc,null,null,null,null,null,null,null,null,null,$observacion,$usuario,null,null,null,null,null,null,null
                ,null,null,null,$loteficha
            ]);

            echo json_encode($response);
        }

        // Actualiza observación liberación
        if ($_GET["operacion"] == "set-actualizarobservacionliberacion") {

            $ficha          = $_GET["ficha"];
            $estilotsc      = $_GET["estilotsc"];
            $observacion    = $_GET["observacion"];
            $usuario        = $_GET["usuario"];
            $loteficha = $_GET["loteficha"];
            
            // $response = $objModelo->setAll("USYSTEX.SPSET_MOLDESCORTE_006", [
            //     $ficha, $observacion, $usuario
            // ], 'Registro actualizado correctamente.');
            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                6,$ficha,$estilotsc,null,null,$observacion,null,null,null,null,null,null,null,$usuario,null,null,null,null,null,null,null
                ,null,null,null,$loteficha
            ]);

            echo json_encode($response);
        }

        // OBTENEMOS HISTORIAL DE CAMBIOS DE ESTADO
        if ($_GET["operacion"] == "get-historialestados") {

            $ficha          = $_GET["ficha"];
            // $loteficha = $_GET["loteficha"];

            $response = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                7,$ficha,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null
                ,null,null,null,null
            ]);

            foreach($response as $fila){
                echo "<tr>";
                echo "<td>{$fila['ESTADO']}</td>";
                echo "<td>{$fila['FECHA']}</td>";
                echo "<td>{$fila['USUARIO']}</td>";
                echo "</tr>";

            }

        }

        // OBTENEMOS HISTORIAL DE VERSION DE MOLDES
        if ($_GET["operacion"] == "get-historial-versionmoldes") {

            $ficha          = $_GET["ficha"];
            // $loteficha = $_GET["loteficha"];

            $response = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                13,$ficha,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null
                ,null,null,null,null
            ]);




            foreach($response as $fila){

                echo "<tr>";
                echo "<td>{$fila['VERSIONMOLDE']}</td>";
                echo "<td>{$fila['FECHA']}</td>";
                echo "<td>{$fila['USUARIO']}</td>";
                echo "</tr>";

            }

        }

        // OBTENEMOS HISTORIAL DE MOLDE USAR
        if ($_GET["operacion"] == "get-historial-moldeusar") {

            $ficha          = $_GET["ficha"];
            // $loteficha = $_GET["loteficha"];


            $response = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                14,$ficha,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null
                ,null,null,null,null
            ]);

            foreach($response as $fila){

                $hilo   = $fila["HILO"] != "" ? (float)$fila["HILO"] : "";
                $trama  = $fila["TRAMA"] != "" ? (float)$fila["TRAMA"] : "";
                $manga  = $fila["MANGA"] != "" ? (float)$fila["MANGA"] : "";

                if($hilo == ""&& $trama == "" && $manga == "0"){

                    echo "<tr>";
                    echo "<td colspan='3'>Eliminado</td>";
                    // echo "<td>{$trama}</td>";
                    // echo "<td>{$manga}</td>";
                    echo "<td>{$fila['FECHA']}</td>";
                    echo "<td>{$fila['USUARIO']}</td>";
                    echo "</tr>";

                }else{

                    echo "<tr>";
                    echo "<td>{$hilo}</td>";
                    echo "<td>{$trama}</td>";
                    echo "<td>{$manga}</td>";
                    echo "<td>{$fila['FECHA']}</td>";
                    echo "<td>{$fila['USUARIO']}</td>";
                    echo "</tr>";

                }


                

            }

        }

        // REGISTRAMOS PARTIDAS AGRUPADAS
        if ($_GET["operacion"] == "setpartidasagrupadas") {

            $ficha          = $_GET["ficha"];
            $partida        = $_GET["partida"];
            $usuario          = $_GET["usuario"];
            $estilotsc          = $_GET["estilotsc"];
            $loteficha = $_GET["loteficha"];



            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                8,$ficha,$estilotsc,null,null,null,null,null,null,null,null,null,null,$usuario,$partida,null,null,null,null,null,null
                ,null,null,null,$loteficha
            ]);

            echo json_encode($response);

        }


        // DATOS DE FICHA PARA LA PRUEBA DE ENCOGIMIENTOS
        if ($_GET["operacion"] == "getdatospruebaencogimientos") {

            $ficha          = $_GET["ficha"];
            // $loteficha = $_GET["loteficha"];


            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                10,$ficha,null,null,null,null,null,null,null,null,null,null,null,null,null,
                null,null,null,null,null,null
                ,null,null,null,null
            ]);

            echo json_encode($response);

        }

        // ASIGNA MOLDE DE PAÑO USAR
        if ($_GET["operacion"] == "set-moldepanousar") {

            $ficha = $_GET["ficha"];
            $estilotsc = $_GET["estilotsc"];

            $hilo = $_GET["hilo"];
            $trama = $_GET["trama"];
            $usuario = $_GET["usuario"];
            $loteficha = $_GET["loteficha"];
            // $usuario = $_SESSION["user"];

            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                11,$ficha,$estilotsc,null,null,null,null,null,null,null,null,null,null,$usuario,null,null,null,null,null,null,null
                ,$hilo,$trama,null,$loteficha
            ]);

            echo json_encode($response);
        }


        // ASIGNA MOLDE PARA PRIMERA LAVADA
        if ($_GET["operacion"] == "set-moldeprimeralavada") {

            $ficha = $_GET["ficha"];
            $estilotsc = $_GET["estilotsc"];

            $hilo           = $_GET["hilo"];
            $trama          = $_GET["trama"];
            $densidad       = $_GET["densidad"];
            $inclinacionbw  = $_GET["inclinacionbw"];
            $inclinacionaw  = $_GET["inclinacionaw"];
            $revirado       = $_GET["revirado"];


            $usuario = $_GET["usuario"];
            $loteficha = $_GET["loteficha"];
            // $usuario = $_SESSION["user"];

            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                15,$ficha,$estilotsc,null,null,null,null,null,$revirado,$densidad,$inclinacionbw,$inclinacionaw,null,$usuario,null,null,null,null,null,null,null
                ,$hilo,$trama,null,$loteficha
            ]);

            echo json_encode($response);
        }

        // ASIGNA VERSION DE MOLDE
        if ($_GET["operacion"] == "set-versionmolde") {

            $ficha = $_GET["ficha"];
            $estilotsc = $_GET["estilotsc"];

            $versionmolde = $_GET["versionmolde"];
            // $trama = $_GET["trama"];


            $usuario = $_GET["usuario"];
            $loteficha = $_GET["loteficha"];
            // $usuario = $_SESSION["user"];

            $response = $objModelo->get("AUDITEX.PQ_MOLDES.SPU_SETPROGENERAL", [
                12,$ficha,$estilotsc,null,null,null,null,null,null,null,null,null,null,$usuario,null,null,null,null,null,null,null
                ,null,null,$versionmolde,$loteficha
            ]);

            echo json_encode($response);
        }


        // Actualiza de información de previsulaización
        if ($_GET["operacion"] == "set-actualizarimagen") {

            $item = $_GET["item"];
            $ficha = $_GET["ficha"];
            $ruta = $_GET["ruta"];
            $usuario = $_SESSION["user"];

            $response = $objModelo->setAll("USYSTEX.SPSET_MOLDESCORTE_007", [
                $ficha, $item, $ruta, $usuario
            ], 'Registro actualizado correctamente.');

            echo json_encode($response);
        }

        // Actualiza de información de previsulaización
        if ($_GET["operacion"] == "set-actualizarprevisualizacion") {

            $ficha = $_GET["FICHA"];
            $color = $_GET["color"];
            $partida1 = $_GET["partida1"];
            $estilopru = $_GET["estilopru"];
            $molde = $_GET["molde"];
            $largo = $_GET["largo"];
            $ancho = $_GET["ancho"];
            $hilo = $_GET["hilo"];
            $trama = $_GET["trama"];
            $manga = $_GET["manga"];
            $usuario = $_SESSION["user"];

            $response = $objModelo->setAll("USYSTEX.SPSET_MOLDESCORTE_008", [
                $ficha, $color, $partida1, $estilopru, $molde, $largo, $ancho, $hilo, $trama, $manga, $usuario
            ], 'Registro actualizado correctamente.');

            echo json_encode($response);
        }

        
        // OBTENEMOS LOS ESTADOS DE MOLDAJE
        if($_GET["operacion"] == "getestadosmoldaje"){

            $response = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_GETESTADOS",[]);
            echo json_encode($response);

        }

        // OBTENEMOS LOS ESTADOS DE MOLDAJE
        if($_GET["operacion"] == "getusuariosliberacion"){

            $response = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_GETUSULIBERACION",[]);
            echo json_encode($response);

        }

        // OBTENEMOS LOS ESTADOS DE MOLDAJE
        if($_GET["operacion"] == "getclientes"){

            $response = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_GETCLIENTES",[]);
            echo json_encode($response);

        }

        // IMAGENES SEGUN FICHAS
        if($_GET["operacion"] == "getimagenespruebaencogimiento"){

            $ficha = $_GET["ficha"];
            $response = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_GETIMGPRUEBAENCOGIMIENTO",[$ficha]);
            echo json_encode($response);

        }

    }



?> 