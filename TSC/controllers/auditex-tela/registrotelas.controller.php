<?php
session_start();
require_once '../../models/modelo/core.modelo.php';


$objModelo = new CoreModelo(); 

    // METODO GET
    if (isset($_POST["operacion"])) {

        if($_POST["operacion"] == "setcargatela"){


            $parameters = $_POST["parameters"];


            $datacabecera   = $parameters[0];
            $estabilidades  = $parameters[1];


            // ACTUALIZAMOS TELA
            $respuestaregistrotela = $objModelo->setAll("AUDITEX.SP_AUDTEL_UPDATE_TELAAUX_V2",[
                $datacabecera["codtela"],           $datacabecera["descripciontela"],   $datacabecera["codigoprv"],
                $datacabecera["composicionfinal"],  $datacabecera["rendimientopeso"],   $datacabecera["ruta"]
            ],"Cabecera Registrada");

            // ACTUALIZAMOS ESTABILIDAD DIMENSIONAL
            foreach($estabilidades as $fila ){

                $respuestaestabilidad = $objModelo->setAll("AUDITEX.SP_AUDTEL_UPDATE_TELESTDIM_V2",[
                    $datacabecera["codtela"],           $fila["codestim"],                  $fila["valor"],
                    $fila["tolerancia"],                $datacabecera["idproveedor"],       $fila["tolerancia_negativa"]
                ],"Estabilidad Registrada");

                // var_dump($respuestaestabilidad);
            }

            echo json_encode($respuestaregistrotela);


        }


    }
?>