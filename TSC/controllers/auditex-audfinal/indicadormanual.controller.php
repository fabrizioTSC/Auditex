<?php 

    require_once '../../models/modelo/auditex-audfinal/cargapacking.modelo.php';
    require_once '../../models/modelo/core.modelo.php';
    

    $objCargar = new CargaPackingModelo();
    $objModelo = new CoreModelo();


    if(isset($_POST["operacion"])){


        // ACTUALIZAMOS ESTADO A CARGADO
        if($_POST["operacion"] == "setindicador"){

            $parameters = $_POST["parameters"];
            // $po         = $parameters[0];

            // ELIMINAMOS LO QUE SE CARGO
            $response = $objModelo->setAll("PQ_PACKINGACABADOS_TMP.SPU_SETAUDFINAL",$parameters,"Correcto");
            echo json_encode($response);

        }


    }



?>