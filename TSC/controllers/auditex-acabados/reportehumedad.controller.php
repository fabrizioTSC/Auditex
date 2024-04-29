<?php

    session_start();
    require_once '../../models/modelo/core.modelo.php';


    $objModelo = new CoreModelo();

    if( isset($_POST["operacion"])){

        if($_POST["operacion"] == "getreportehumedadfechas"){

            // $fechainicio    = $_POST["fechainicio"];
            // $fechafin       = $_POST["fechafin"];
            $parameters = $_POST["parameters"];

            $response = $objModelo->getAll("AUDITEX.SP_ACA_SELECT_CONREPCONHUM_V3",$parameters);
            $_SESSION["data_reporte_humedad_fechas"] = $response;
            echo json_encode($response);

        }

    }

?>