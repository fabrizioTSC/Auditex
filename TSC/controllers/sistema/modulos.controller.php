<?php

    require_once '../../models/modelo/core.modelo.php';

    $objModelo = new CoreModelo();

    if(isset($_GET["operacion"])){

        //  GET MODULOS
        if($_GET["operacion"] == "getmodulos"){

            $opcion = $_GET["opcion"];
            $filtro = $_GET["filtro"] == "" ? null : $_GET["filtro"];

            $reponse = $objModelo->getAll("AUDITEX.PQ_MODAUDITEX.SPU_GETMODULOSAUDITEX",[$opcion,$filtro]);
            echo json_encode($reponse);

        }

    }

    // POST
    if(isset($_POST["operacion"])){

        
        // REGISTRAMOS CORREOS PARA DETALLE
        if($_POST["operacion"] == "setmodulospri"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_MODAUDITEX.SPU_SETCREACIONMODULOS123",$parameters,"Registro correcto");
            echo json_encode($response);
        }


    }

   

?>