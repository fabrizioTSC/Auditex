
<?php
session_start();

require_once '../../models/modelo/core.modelo.php';
// require_once '../../models/modelo/gestion-produccion/gestion-produccion.modelo.php'; 



$objModelo = new CoreModelo(); 
  
    // METODO GET
    if (isset($_GET["operacion"])) {

        if ($_GET["operacion"] == "get-data-reporte-partidas") {

            $fechainicio = $_GET["fechainicio"];
            $fechafin    = $_GET["fechafin"];


            $response = $objModelo->getAll("AUDITEX.SPU_GETREPORTEPARTIDAS",[$fechainicio,$fechafin]);
            echo json_encode($response);

        }



    }



?>