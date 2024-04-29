<?php
    session_start();
    ini_set('memory_limit', '-1');
    require_once '../../models/modelo/core.modelo.php';
    require_once '../../models/modelo/reporteexcel.modelo.php';
    // require_once '../../models/modelo/sistema.modelo.php';


    $objModelo  = new CoreModelo();
    $objExcelModelo = new ExcelAjustes();


    // POST
    if(isset($_GET["operacion"])){



        // TIPOS DE SERVICIO
        if($_GET["operacion"] == "getreporte"){

            $response = $objModelo->getAll("AUDITEX.PQ_FICHASPEDIDOS.SPU_GETFICHASPEDIDO",[$_GET["pedidoi"],$_GET["pedidof"]]);
            $_SESSION["data_reporte_fichas_pedido"] = $response;
            echo json_encode($response);

        }

        // EXPORTAR
        if($_GET["operacion"] == "set-exportar"){


            // REFORMATEAMOS DATOS
            $datanueva = $_SESSION["data_reporte_fichas_pedido"];
            $i = 0;
            foreach($datanueva as $fila){

                $valores = explode(",",$fila["CANTAUDITADA"]);
                $totalauditado = 0;
                foreach($valores as $val){
                    $totalauditado += (float)$val;
                }
                $datanueva[$i]["TOTAUDITADA"] = $totalauditado;
                $i++;

            }


            $objExcelModelo->Exportar_Simple("reporte_fichas_pedidos", $datanueva /* $_SESSION["data_reporte_fichas_pedido"]*/,
            [
                ["TITULO" => "PO","WIDTH" => 21,"CONTENIDO" => "PO"],
                ["TITULO" => "FICHA","WIDTH" => 17,"CONTENIDO" => "FICHA"],
                ["TITULO" => "PEDIDO","WIDTH" => 10,"CONTENIDO" => "PEDIDO"],
                ["TITULO" => "COLOR","WIDTH" => 20,"CONTENIDO" => "COLOR"],
                ["TITULO" => "CLIENTE","WIDTH" => 30,"CONTENIDO" => "DESCLI"],
                ["TITULO" => "CANT FICHA","WIDTH" => 10,"CONTENIDO" => "CANPRE"],
                ["TITULO" => "USUARIOS","WIDTH" => 40,"CONTENIDO" => "USUARIOS"],
                ["TITULO" => "CANT AUDITADA","WIDTH" => 30,"CONTENIDO" => "CANTAUDITADA"],
                ["TITULO" => "TOT AUDITADA","WIDTH" => 10,"CONTENIDO" => "TOTAUDITADA"],
                ["TITULO" => "LINEA / TALLER","WIDTH" => 25,"CONTENIDO" => "LINEATALLER"],
                ["TITULO" => "FECHA FIN AUD.","WIDTH" => 40,"CONTENIDO" => "FECHAFINAUD"],
                ["TITULO" => "EST. TSC","WIDTH" => 10,"CONTENIDO" => "ESTTSC"],
                ["TITULO" => "EST. CLIENTE","WIDTH" => 10,"CONTENIDO" => "ESTCLI"],
                ["TITULO" => "TIPO PRENDA","WIDTH" => 20,"CONTENIDO" => "DESPRE"],
                ["TITULO" => "PARTIDA","WIDTH" => 10,"CONTENIDO" => "PARTIDA"],
                ["TITULO" => "PROGRAMA","WIDTH" => 30,"CONTENIDO" => "PROGRAMA"],
                ["TITULO" => "TIPO TELA","WIDTH" => 25,"CONTENIDO" => "TIPOTELA"],
            ],
            6,
            [
                ["UBICACION" => "A1","VALOR" => "PEDIDO INICIO","TITULO" => true],
                ["UBICACION" => "B1","VALOR" => $_GET["pedidoi"],"TITULO" => false],
                ["UBICACION" => "C1","VALOR" => "PEDIDO FIN","TITULO" => true],
                ["UBICACION" => "D1","VALOR" => $_GET["pedidof"],"TITULO" => false],

                ["UBICACION" => "A2","VALOR" => "ESTILO CLIENTE","TITULO" => true],
                ["UBICACION" => "B2","VALOR" => $_GET["estilos"],"TITULO" => false],

                ["UBICACION" => "A3","VALOR" => "TOTAL DEL PEDIDO","TITULO" => true],
                ["UBICACION" => "B3","VALOR" => $_GET["totalpedido"],"TITULO" => false],

                ["UBICACION" => "A4","VALOR" => "TOTAL DE AUDITADO","TITULO" => true],
                ["UBICACION" => "B4","VALOR" => $_GET["totalauditado"],"TITULO" => false],

                ["UBICACION" => "A5","VALOR" => "DIFERENCIA","TITULO" => true],
                ["UBICACION" => "B5","VALOR" => "=B3-B4","TITULO" => false],
            ],
            [
                ["COLUMNA" =>  "F"],
                ["COLUMNA" =>  "I"],
            ]
            );

        }


    }

?>