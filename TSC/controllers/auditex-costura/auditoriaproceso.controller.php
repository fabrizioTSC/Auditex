<?php
    session_start();

    require_once '../../models/modelo/core.modelo.php';
    require_once '../../models/modelo/auditex-costura/auditoriafinal.modelo.php';


    // require_once '../../models/modelo/reporteexcel.modelo.php';
    // require_once '../../models/modelo/sistema.modelo.php';


    $objModelo  = new CoreModelo("erp");
    $objAuditoriaF = new AuditoriaFinalModelo();
    $objExcelModelo = new ExcelAjustes();

    // $objExcelModelo = new ExcelAjustes();


    // GET
    if(isset($_GET["operacion"])){

        // getDataAudPro
        if($_GET["operacion"] == "getDataAudPro"){

            $responsedefectos       = $objModelo->getAll("AUDITEX.SP_AT_SELECT_DEFECTOS_V2",[]);
            $responseoperaciones    = $objModelo->getAll("AUDITEX.SP_AT_SELECT_OPERACIONES_V2",[]);
            $responseoperarios      = $objModelo->getAllSQL("HelpDeskTsc.usp_GetDatosMaestro",[17]);

            echo json_encode(
                [
                    "defectos" => $responsedefectos,
                    "operaciones" => $responseoperaciones,
                    "operadores" => $responseoperarios
                ]
            );

        }


        if($_GET["operacion"] == "verificaoperacionregistrada"){

            $response = $objModelo->get("AUDITEX.PQ_AUDITORIAPROCESO.SPU_VERIFICAOPERACION",[
                $_GET["ficha"],$_GET["secuencia"],$_GET["idoperacion"]
            ]);
            echo json_encode($response);

        }

        if($_GET["operacion"] == "verificadefectoregistrada"){

            $response = $objModelo->get("AUDITEX.PQ_AUDITORIAPROCESO.SPU_VERIFICADEFECTO",[
                $_GET["ficha"],$_GET["secuencia"],$_GET["idoperacion"],$_GET["iddefecto"],$_GET["numvez"]
            ]);
            echo json_encode($response);

        }

        // TIPOS DE SERVICIO
        if($_GET["operacion"] == "getTalleres"){

            $response = $objModelo->getAll("AUDITEX.SP_APC_SELECT_TALLERES",[]);
            echo json_encode($response);

        }

        // FICHAS AUDITAR
        if($_GET["operacion"] == "getfichasauditar"){

            // CODTLL
            $codtll = $_GET["codtll"];

            // ELIMINAMOS SI NO TIENE REGISTRADO
            $responsereload = $objModelo->setAll("AUDITEX.RELOADSIGETOAUDITEX_COSTURA",[$codtll],"Recargado correctamente");


            // CARGAMOS SIGE
            $responsecargasige = $objModelo->setAllSQL("uspCargaAuditoriaEnvioTallerToAuditex",[$codtll,null],"Correcto");

            // RESPONSE FICHAS

            $response = $objModelo->getAll("AUDITEX.SP_APC_SELECT_FICHASXTALLER",[$codtll]);

            echo json_encode(
                [
                    "responsesige"      => $responsecargasige,
                    "responselista"     => $response,
                    "responsereload"    => $responsereload
                ]
            );

        }


        // GET OPERACIONES AGREGADAS
        if($_GET["operacion"] == "getoperacionesagregadas"){

            $response = $objModelo->getAll("AUDITEX.PQ_AUDITORIAPROCESO.SPU_GETOPERACIONESAGREGADAS",[$_GET["ficha"],$_GET["secuencia"]]);
            echo json_encode($response);

        }

        // GET OPERACIONES AGREGADAS
        if($_GET["operacion"] == "getdefectosagregados"){

            $response = $objModelo->getAll("AUDITEX.PQ_AUDITORIAPROCESO.SPU_GETDEFECTOSOPERACION",[$_GET["ficha"],$_GET["secuencia"],$_GET["ope"],$_GET["numvez"],$_GET["secuenciaoperacion"] ]);
            echo json_encode($response);

        }

        // GET DATOS AUDITORIA PROCESO
        if($_GET["operacion"] == "getauditoriproceso"){

            $response = $objModelo->get("AUDITEX.PQ_AUDITORIAPROCESO.SPU_GETDATOSAUDITORIA",[$_GET["ficha"],$_GET["secuencia"],$_GET["taller"]]);
            echo json_encode($response); 

        }

        // GET AUDITORES
        if($_GET["operacion"] == "getauditores"){

            $response = $objModelo->getAll("AUDITEX.PQ_AUDITORIAPROCESO.SPU_GETAUDITORES",[]);
            echo json_encode($response); 

        }

        // GET CLIENTES
        if($_GET["operacion"] == "getclientes"){

            $response = $objModelo->getAll("AUDITEX.PQ_AUDITORIAPROCESO.SPU_GETCLIENTES",[]);
            echo json_encode($response); 

        }

        // GET REPORTE
        if($_GET["operacion"] == "getreporte"){

            $response = $objModelo->getAll("AUDITEX.PQ_AUDITORIAPROCESO.SPU_GETREPORTE",[

                $_GET["sede"],$_GET["tiposervicio"],$_GET["taller"],$_GET["auditor"],$_GET["cliente"],
                $_GET["po"],$_GET["pedido"],$_GET["color"],$_GET["fechai"],$_GET["fechaf"]

            ]);


            $_SESSION["data_reporte_auditex_costura"] = $response;

            $cont = 0;
            foreach($response as $fila){

                $cont++;

                echo "<tr>";

                echo "<td >{$cont}</td>";
                echo "<td >{$fila['FICHA']}</td>";
                echo "<td >{$fila['PO']}</td>";
                echo "<td >{$fila['PEDIDO']}</td>";
                echo "<td >{$fila['ESTTSC']}</td>";
                echo "<td >{$fila['ESTCLI']}</td>";
                echo "<td >{$fila['OPERACION']}</td>";
                echo "<td >{$fila['NUMVEZ']}</td>";
                echo "<td >{$fila['ESTADO']}</td>";
                echo "<td >{$fila['FECHAFIN']}</td>";
                echo "<td >{$fila['USUARIOFIN']}</td>";
                echo "<td >{$fila['TALLER']}</td>";
                echo "<td >{$fila['CLIENTE']}</td>";
                echo "<td >{$fila['DESDEFECTOS']}</td>";
                echo "<td >{$fila['CANDEFECTOS']}</td>";
                echo "<td >{$fila['PARTIDA']}</td>";
                echo "<td >{$fila['COLOR']}</td>";
                echo "<td >{$fila['TIPOTELA']}</td>";


                echo "</tr>";

            }


            // echo json_encode($response); 

        }


        // GET OPERACIONES AGREGADAS
        if($_GET["operacion"] == "eliminardefecto"){

            $response = $objModelo->setAll("AUDITEX.PQ_AUDITORIAPROCESO.SPU_ELIMINARDEFECTO",
                [
                    $_GET["ficha"],$_GET["secuencia"],$_GET["codoperacion"],$_GET["coddef"],$_GET["numvez"]
                ],
                "Eliminado Correctamente"
            );
            echo json_encode($response);

        }

        // EXPORTAR
        if($_GET["operacion"] == "set-exportar"){


            // REFORMATEAMOS DATOS
            $datanueva = $_SESSION["data_reporte_auditex_costura"];
            $i = 0;
            // foreach($datanueva as $fila){

            //     $valores = explode(",",$fila["CANTAUDITADA"]);
            //     $totalauditado = 0;
            //     foreach($valores as $val){
            //         $totalauditado += (float)$val;
            //     }
            //     $datanueva[$i]["TOTAUDITADA"] = $totalauditado;
            //     $i++;

            // }


            $objExcelModelo->Exportar_Simple("reporte_auditoria_proceso", $datanueva /* $_SESSION["data_reporte_fichas_pedido"]*/,
            [
                ["TITULO" => "FICHA","WIDTH" => 21,"CONTENIDO" => "FICHA"],
                ["TITULO" => "PO","WIDTH" => 17,"CONTENIDO" => "PO"],
                ["TITULO" => "PEDIDO","WIDTH" => 10,"CONTENIDO" => "PEDIDO"],
                ["TITULO" => "ESTILO TSC","WIDTH" => 18,"CONTENIDO" => "ESTTSC"],
                ["TITULO" => "ESTILO CLIENTE","WIDTH" => 18,"CONTENIDO" => "ESTCLI"],
                ["TITULO" => "OPERACIÓN","WIDTH" => 40,"CONTENIDO" => "OPERACION"],
                ["TITULO" => "NUM VEZ","WIDTH" => 8,"CONTENIDO" => "NUMVEZ"],
                ["TITULO" => "ESTADO","WIDTH" => 10,"CONTENIDO" => "ESTADO"],
                // ["TITULO" => "FECHA INICIO","WIDTH" => 10,"CONTENIDO" => "FECHAFIN"],
                ["TITULO" => "FECHA FIN","WIDTH" => 20,"CONTENIDO" => "FECHAFIN"],
                ["TITULO" => "USUARIO FIN","WIDTH" => 20,"CONTENIDO" => "USUARIOFIN"],
                ["TITULO" => "TALLER","WIDTH" => 35,"CONTENIDO" => "TALLER"],
                ["TITULO" => "CLIENTE","WIDTH" => 35,"CONTENIDO" => "CLIENTE"],
                ["TITULO" => "DEFECTOS","WIDTH" => 40,"CONTENIDO" => "DESDEFECTOS"],
                ["TITULO" => "CANT DEFECTOS","WIDTH" => 25,"CONTENIDO" => "CANDEFECTOS"],
                ["TITULO" => "PARTIDA","WIDTH" => 30,"CONTENIDO" => "PARTIDA"],
                ["TITULO" => "COLOR","WIDTH" => 25,"CONTENIDO" => "COLOR"],
                ["TITULO" => "TIPO TELA","WIDTH" => 25,"CONTENIDO" => "TIPOTELA"],
            ],
            5,
            [
                ["UBICACION" => "A1","VALOR" => "Reporte General de Auditoria Proceso","TITULO" => true],
                // ["UBICACION" => "B1","VALOR" => $_GET["filtros"],"TITULO" => false],
                ["UBICACION" => "A3","VALOR" => "FILTROS","TITULO" => true],
                ["UBICACION" => "B3","VALOR" => $_GET["filtros"],"TITULO" => false],
                // ["UBICACION" => "C1","VALOR" => "PEDIDO FIN","TITULO" => true],
                // ["UBICACION" => "D1","VALOR" => $_GET["pedidof"],"TITULO" => false],

                // ["UBICACION" => "A2","VALOR" => "ESTILO CLIENTE","TITULO" => true],
                // ["UBICACION" => "B2","VALOR" => $_GET["estilos"],"TITULO" => false],

                // ["UBICACION" => "A3","VALOR" => "TOTAL DEL PEDIDO","TITULO" => true],
                // ["UBICACION" => "B3","VALOR" => $_GET["totalpedido"],"TITULO" => false],

                // ["UBICACION" => "A4","VALOR" => "TOTAL DE AUDITADO","TITULO" => true],
                // ["UBICACION" => "B4","VALOR" => $_GET["totalauditado"],"TITULO" => false],

                // ["UBICACION" => "A5","VALOR" => "DIFERENCIA","TITULO" => true],
                // ["UBICACION" => "B5","VALOR" => "=B3-B4","TITULO" => false],
            ],
            // [
            //     ["COLUMNA" =>  "F"],
            //     ["COLUMNA" =>  "I"],
            // ]
            );

        }


    }

    // POST
    if(isset($_POST["operacion"])){

        // VALIDATE INICIO
        if($_POST["operacion"] == "validateinicio"){

            $parameters = $_POST["parameters"];

            $response = $objModelo->setAll("AUDITEX.SP_APC_UPDATE_INIFIC",$parameters,"Correcto");
            echo json_encode($response);

        }

        // TERMINAR AUDITORIA DE OPERACION
        if($_POST["operacion"] == "terminaroperacion"){

            $parameters = $_POST["parameters"];

            $response = $objModelo->setAll("AUDITEX.PQ_AUDITORIAPROCESO.SPU_SETFINAUDOPERACION",$parameters,"Operación Terminada correctamente");
            echo json_encode($response);
        }

        // REPORTE DE CLASIFICACIÓN DE FICHAS
        if($_POST["operacion"] == "get-reporte-clasificacion-fichas"){

            $data = $_POST["data"];
            $data = json_decode($data);
            // var_dump($data);

            // echo json_decode($data);

            $objAuditoriaF->getReporteGeneral("ReporteClasificacionDeFichas",$data->{"cabecera"},$data->{"cuerpo"},$data->{"labels"});



        }


    }

?>