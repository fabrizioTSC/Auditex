<?php

    require_once '../../models/modelo/core.modelo.php';

    // $objModelo = new CoreModelo("sige_auditex");
    $objModelo = new CoreModelo("bd_genesys","sige_auditex");


    if(isset($_GET["operacion"])){


        // REPORTE LANDS END
        if($_GET["operacion"] == "getdatosreportelandsend-cantidad"){

            $po = $_GET["po"];
            $pl = $_GET["paclis"];

            // RESPONSE GENERAL
            $response = [];


            // PRIMERO VERIFICAMOS SI ES SIGE O SYSTEXTIL
            $responsesige = $objModelo->getSQLSIGE("AuditoriaFinal.uspSetAudiFinal",[74,null,$pl,$po]);


            // SI ES SIGE
            if($responsesige){

                $response = [
                    "state"     => true,
                    "detail"    => "Reporte confirmado",
                    "estado"    => "C",
                    "sistema"   => "sige"
                ];

            }else{
            // SI ES SISTEXTIL
                $responsecantidad = $objModelo->get("AUDITEX.SP_RLE_SELECT_ESTCALINT_V2",[$po,$pl]);
                if ($responsecantidad) {
                    $response = [
                        "state"     => true,
                        "detail"    => "Reporte confirmado",
                        "estado"    => $responsecantidad["ESTADO"],
                        "sistema"   => "sistextil"
                    ];
                }else{
                    $response = [
                        "state" => false,
                        "detail" => "No se pudo confirmar el reporte",
                        "sistema"   => "sistextil"
                    ];
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);

        }

        if($_GET["operacion"] == "getdatosreportelandsend-medidas"){

            $po         = $_GET["po"];
            $pl         = $_GET["paclis"];
            $sistema    = $_GET["sistema"];

            $responsecantidad = [];

            if($sistema == "sige"){
                $responsecantidad["state"] = true;
                $responsecantidad["sistema"] = "sige";
            }else{

                $responsecantidad = $objModelo->get("AUDITEX.SP_RLE_SELECT_REPMEDPDF",[$po,$pl]);

                if($responsecantidad){
                    $responsecantidad["state"] = true;
                    $responsecantidad["sistema"] = "sistextil";
                }
    

            }


	        header('Content-Type: application/json');
            echo json_encode($responsecantidad);

        }

        if($_GET["operacion"] == "getdatosreportelandsend-defectos-humedad"){

            $po         = $_GET["po"];
            $pl         = $_GET["paclis"];
            $sistema    = $_GET["sistema"];

            $responsecantidad = [];

            if($sistema == "sige"){

                $response = [
                    "state" => true,
                    "estado" => "C",
                    "estadohum" => "C",
                    "sistema"   => "sige"

                ];

            }else{

                $responsecantidad = $objModelo->get("AUDITEX.SP_RLE_SELECT_ESTDEF_V2",[$po,$pl]);

                $response = [];
                if ($responsecantidad) {
                    $response = [
                        "state" => true,
                        "estado" => $responsecantidad["ESTCONDEF"],
                        "estadohum" => $responsecantidad["ESTCONHUM"],
                        "sistema"   => "sistextil"
    
                    ];
                }else{
                    $response = [
                        "state" => false,
                        "detail" => "No se pudo encontrar el estado del reporte",
                        "sistema"   => "sistextil"
                    ];
                }

            }



	        header('Content-Type: application/json');
            echo json_encode($response);

        }

        if($_GET["operacion"] == "getdatosreportelandsend-metal"){


            $po                 = $_GET["po"];
            $sistema            = $_GET["sistema"];
            $responsecantidad   = [];


            if($sistema == "sige"){
                $responsecantidad["state"] = true;
                $responsecantidad["sistema"] = "sige";
            }else{

                $responsecantidad = $objModelo->get("AUDITEX.SP_RLE_SELECT_ESTDETMET_V2",[$po]);
                if($responsecantidad){
                    $responsecantidad["state"] = true;
                    $responsecantidad["sistema"] = "sistextil";
                }

            }


	        header('Content-Type: application/json');
            echo json_encode($responsecantidad);

        }

        if($_GET["operacion"] == "getestilosclientepopacking" ){

            $po                 = $_GET["po"];
            $pl                 = $_GET["paclis"];
            $response           = $objModelo->getAllSQLSIGE("AuditoriaFinal.uspSetAudiFinal",[73,null,$pl,$po]);

            header('Content-Type: application/json');
            echo json_encode($response);

        }

    }


?>