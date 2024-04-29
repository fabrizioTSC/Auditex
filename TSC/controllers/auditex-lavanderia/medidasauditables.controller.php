<?php

    session_start();
    require_once '../../models/modelo/core.modelo.php';
// require_once '../../models/modelo/auditex-lavanderia/lavanderia.modelo.php';


    $objModelo = new CoreModelo();
    // $objLavanderiaM = new LavanderiaModelo();

    if( isset($_GET["operacion"])){

        if($_GET["operacion"] == "getmedidas"){

            $estilo = $_GET["estilotsc"];
            $response = $objModelo->getAll("AUDITEX.PQ_MEDIDAS.SPU_GETMEDIDASESTILO",[1,$estilo]);
            echo json_encode($response);

        }

    }    


    if( isset($_POST["operacion"])){

        if($_POST["operacion"] == "setmedidas"){

            // $estilo = $_GET["estilotsc"];
            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_MEDIDAS.SPU_SETMEDIDAS",$parameters,"Correcto");
            echo json_encode($response);

        }

    }    
   


?>