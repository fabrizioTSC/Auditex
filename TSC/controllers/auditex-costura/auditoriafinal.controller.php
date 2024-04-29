<?php
    session_start();

    require_once '../../models/modelo/core.modelo.php';

    $objModelo  = new CoreModelo();

    // GET
    if(isset($_GET["operacion"])){


        if($_GET["operacion"] == "gettallafichas"){

            $tipoauditoria = isset($_GET["tipoauditoria"]) ? $_GET["tipoauditoria"] : "N";

            $response = $objModelo->getAll("AUDITEX.SPU_GETTALLASFICHAS_AUDI_V2",[
                $_GET["opcion"],$_GET["ficha"],$_GET["vez"],$_GET["parte"],$tipoauditoria
            ]);
            echo json_encode($response);

        }

        // GET INFO TALLAS OPERACIONES
        if($_GET["operacion"] == "gettallafichas_operaciones"){

            // ELIMINAMOS OPERACIONES PENDIENTES



            // TALLAS
            $responsetallas = $objModelo->getAll("AUDITEX.PQ_AUDITORIAFINAL_ESPECIAL.SPU_GETDATOS_FICHAS",[
                4,$_GET["ficha"], $_GET["parte"],$_GET["vez"], null
            ]);

            // RESPONSE OPERACIONES DISPONIBLES
            $responseoperaciones = $objModelo->getAll("AUDITEX.PQ_AUDITORIAFINAL_ESPECIAL.SPU_GETDATOS_FICHAS",[2,$_GET["ficha"],$_GET["parte"],$_GET["vez"],null]);


            echo json_encode([
                "responsetallas"  => $responsetallas,
                "responseoperaciones" => $responseoperaciones,
            ]);

        }

        // GET FICHAS
        if($_GET["operacion"] == "getficha"){

            $ficha = $_GET["ficha"];

            // EJECUTAMOS CARGA DE SIGE ANTES
            $responsesige = $objModelo->setAllSQL("dbo.uspCargarDatosAuditex",[1,$ficha],"Cargado correctamente");

            // BUSCAMOS FICHA
            $responseficha = $objModelo->getAll("AUDITEX.PQ_AUDITORIAFINAL_ESPECIAL.SPU_GETDATOS_FICHAS",[1,$ficha,null,null,null]);

            echo json_encode([
                "responsesige"  => $responsesige,
                "responseficha" => $responseficha,
            ]);

        }


        // DEFECTOS DE LA FICHA
        if($_GET["operacion"] == "getindicadorauditor"){

            $sede           = $_GET["sede"]             == "" ? null : $_GET["sede"];
            $tiposervicio   = $_GET["tiposervicio"]     == "" ? null : $_GET["tiposervicio"];
            $codtaller      = $_GET["codtaller"]        == "" ? null : $_GET["codtaller"];
            $auditor        = $_GET["auditor"]          == "" ? null : $_GET["auditor"];
            $tipofiltro     = $_GET["tipofiltro"]       == "" ? null : $_GET["tipofiltro"];
            $anio           = $_GET["anio"]             == "" ? null : $_GET["anio"];
            $mes            = $_GET["mes"]              == "" ? null : $_GET["mes"];
            $semana         = $_GET["semana"]           == "" ? null : $_GET["semana"];
            $fechai         = $_GET["fechai"]           == "" ? null : $_GET["fechai"];
            $fechaf         = $_GET["fechaf"]           == "" ? null : $_GET["fechaf"];

            $response_auditor = $objModelo->getAll("AUDITEX.PQ_INDICADORES_AUDITOR.SPU_GETDATOS_INDICADOR",[
                7,$sede,$tiposervicio,$codtaller,$auditor,$tipofiltro,$anio,$mes,$semana,$fechai,$fechaf
            ]);

            $response_defecto = $objModelo->getAll("AUDITEX.PQ_INDICADORES_AUDITOR.SPU_GETDATOS_INDICADOR",[
                8,$sede,$tiposervicio,$codtaller,$auditor,$tipofiltro,$anio,$mes,$semana,$fechai,$fechaf
            ]);

            echo json_encode([
                "response_auditor" => $response_auditor,
                "response_defecto" => $response_defecto
            ]);


        }

        // GET OPERACIONES AGREGADAS
        if($_GET["operacion"] == "getoperacionesagregadas"){

            $ficha  = $_GET["ficha"];
            $parte  = $_GET["parte"];
            $vez    = $_GET["vez"];

            $response = $objModelo->getAll("AUDITEX.PQ_AUDITORIAFINAL_ESPECIAL.SPU_GETDATOS_FICHAS",[3,$ficha,$parte,$vez,null]);
            echo json_encode($response);

        }

    }

    // POST
    if(isset($_POST["operacion"])){

        // SET TALLA FICHAS
        if($_POST["operacion"] == "settallafichas_generales"){

            $parameters             = $_POST["parameters"];
            // var_dump($parameters);

            $response = $objModelo->setAll("AUDITEX.PQ_AUDITORIAFINAL_ESPECIAL.SPU_SETPARTIRFICHA",
            [
                $parameters[0], $parameters[1], $parameters[2], $parameters[3],
                $parameters[4], $parameters[5], $parameters[6], $parameters[7],
                $parameters[8]
            ]
            ,"Correcto");

            // REGISTRAMOS TALLAS
            $tallas = $parameters[9];
            foreach($tallas as $item){

                $objModelo->setAll("AUDITEX.PQ_AUDITORIAFINAL_ESPECIAL.SPU_SETFICHASTALLAS",[
                    $parameters[0],$parameters[1], $parameters[2],$item["talla"],$item["cantidad"]
                ],"Correcto");

            }
            echo json_encode($response);

        }


        // SET TALLA FICHAS
        if($_POST["operacion"] == "settallafichas"){

            $parameters = [
                $_POST["ficha"] ,
                $_POST["vez"] ,
                $_POST["parte"] ,
                $_POST["idtalla"] ,
                $_POST["cant"]
            ];

            $response = $objModelo->setAll("AUDITEX.SPU_SETFICHASTALLAS",$parameters,"Correcto");
            echo json_encode($response);

        }

        // SET MEDIDAS COSTURA
        if($_POST["operacion"] == "setmedidascostura"){

            $estilotsc = $_POST["estilotsc"];
            $response = $objModelo->setAllSQLSIGE("uspGetSetMedidasAuditex",[4,$estilotsc,0],"correcto");
            echo json_encode($response);

        }

        // SAVE OPERACION
        if($_POST["operacion"] == "saveoperacion"){

            // REGISTRAR O ELIMINAR OPERACIONES
            $parameters             = $_POST["parameters"];
            $responseset            = $objModelo->setAll("AUDITEX.PQ_AUDITORIAFINAL_ESPECIAL.SPU_SETOPERACIONESFICHAS",$parameters,"Registrado correctamente");

            // 1,FICHA, NUMVEZ,PARTE,codoperacion,operacion,cantidad

            $ficha  = $parameters[1];
            $vez    = $parameters[2];
            $parte  = $parameters[3];

            // RESPONSE OPERACIONES DISPONIBLES
            $responseoperaciones    = $objModelo->getAll("AUDITEX.PQ_AUDITORIAFINAL_ESPECIAL.SPU_GETDATOS_FICHAS",[2,$ficha,$parte,$vez,null]);


            // OPERACIONES AGREGADAS
            $responseoperacionesagregadas = $objModelo->getAll("AUDITEX.PQ_AUDITORIAFINAL_ESPECIAL.SPU_GETDATOS_FICHAS",[3,$ficha,$parte,$vez,null]);


            echo json_encode([
                "responseset" => $responseset,
                "responseoperaciones" => $responseoperaciones,
                "responseoperacionesagregadas" => $responseoperacionesagregadas
            ]);
        }


    }


?>