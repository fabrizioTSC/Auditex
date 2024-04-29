<?php
    session_start();

    // HELLO
    require_once '../../models/modelo/core.modelo.php';
    // require_once '../../models/modelo/correos.modelo.php';
    // require_once '../../models/modelo/depuracion-corte.modelo.php';

    $objModelo = new CoreModelo();
    // $objCorreo = new CorreosModelo();
    // $objDepuracionM = new DepuracionCorte();

    if(isset($_GET["operacion"])){

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
                3,$sede,$tiposervicio,$codtaller,$auditor,$tipofiltro,$anio,$mes,$semana,$fechai,$fechaf
            ]);

            $response_defecto = $objModelo->getAll("AUDITEX.PQ_INDICADORES_AUDITOR.SPU_GETDATOS_INDICADOR",[
                4,$sede,$tiposervicio,$codtaller,$auditor,$tipofiltro,$anio,$mes,$semana,$fechai,$fechaf
            ]);

            echo json_encode([
                "response_auditor" => $response_auditor,
                "response_defecto" => $response_defecto
            ]);


        }


    }


?>