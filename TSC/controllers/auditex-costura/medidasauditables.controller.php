<?php

    session_start();
    require_once '../../models/modelo/core.modelo.php';
// require_once '../../models/modelo/auditex-lavanderia/lavanderia.modelo.php';


    $objModelo = new CoreModelo();
    // $objLavanderiaM = new LavanderiaModelo();

    if( isset($_GET["operacion"])){

        if($_GET["operacion"] == "getmedidas"){

            $estilo = $_GET["estilotsc"];
            $response = $objModelo->getAll("AUDITEX.PQ_MEDIDAS.SPU_GETMEDIDASESTILO",[4,$estilo]);
            echo json_encode($response);

        }


        if($_GET["operacion"] == "getobservacion"){

            $ficha  = $_GET["ficha"];
            $parte  = $_GET["parte"];
            $numvez = $_GET["numvez"];
            $codtad = $_GET["codtad"];



            $response = $objModelo->get("AUDITEX.PQ_MEDIDAS.SPU_GETOBSERVACIONMEDIDAS",[1,$ficha,$parte,$numvez,$codtad]);
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

        // AGREGAR OBSERVACION DE MEDIDA
        if($_POST["operacion"] == "setobservacion"){


            $parameters = [
                1,
                $_POST["ficha"],
                $_POST["parte"],
                $_POST["numvez"],
                $_POST["codtad"],
                $_POST["observacion"]
            ];

            $response = $objModelo->setAll("AUDITEX.PQ_MEDIDAS.SPU_SETOBSERVACIONMEDIDAS",$parameters,"Correcto");
            echo json_encode($response);

        }


    }    
   


?>