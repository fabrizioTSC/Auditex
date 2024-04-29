
<?php
session_start();

require_once '../../models/modelo/core.modelo.php';
// require_once '../../models/modelo/gestion-produccion/gestion-produccion.modelo.php'; 



$objModelo = new CoreModelo(); 
  
    // METODO GET
    if (isset($_GET["operacion"])) {

        // Listar Grilla Principal
        if ($_GET["operacion"] == "getvalidateestabilidaddimensional") {

                $partida    = $_GET["partida"];
                $codtela    = $_GET["codtela"];
                $codprov    = $_GET["codprov"];
                $codtad     = $_GET["codtad"];
                $numvez     = $_GET["numvez"];
                $parte      = $_GET["parte"];


                $response = $objModelo->get("AUDITEX.SPU_VALIDAR_EST_DIM", [
                    $partida,$codtela,$codprov,$codtad,$numvez,$parte
                ]);

                echo json_encode($response);


            }

        }

?>