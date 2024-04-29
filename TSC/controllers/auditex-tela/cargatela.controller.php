<?php
session_start();
require_once '../../models/modelo/core.modelo.php';


$objModelo = new CoreModelo(); 

    // METODO GET
    if (isset($_POST["operacion"])) {

        if($_POST["operacion"] == "guardartela"){


            $parameters = $_POST["parameters"];
            // var_dump($parameters);

            $response = $objModelo->setAll("AUDITEX.SPU_CODTELESTDM_NEW",$parameters,"Cabecera Registrada");
            echo json_encode($response);


        }


    }
?>