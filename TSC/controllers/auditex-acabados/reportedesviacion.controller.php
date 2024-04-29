<?php

    session_start();
    require_once '../../models/modelo/core.modelo.php';


    $objModelo = new CoreModelo();

    if( isset($_GET["operacion"])){

        if($_GET["operacion"] == "getfichasestilo"){

            $estilo = $_GET["estilotsc"];
            $response = $objModelo->getAll("AUDITEX.PQ_MEDIDAS.SPU_GETMEDIDASESTILO",[7,$estilo]);
            echo json_encode($response);

        }

    }    





?>