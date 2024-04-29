<?php
    session_start();

    require_once '../../models/modelo/core.modelo.php';
    require_once '../../models/modelo/sistema.modelo.php';



    $objModelo  = new CoreModelo();
    $objSistema = new SistemaModelo();


    if(isset($_POST["operacion"])){

        // OBTI
        if($_POST["operacion"] == "getindicadorgeneral"){
            
            $parameters = $_POST["parameters"];
            $response = $objModelo->getAll("AUDITEX.SPU_GETINDICADORDEPURACION_NEW",$parameters);
            echo json_encode($response);

        }

        // GUARDAR IMAGENES PARA EL INDICADOR
        if($_POST["operacion"] == "saveimagenes"){

            // 
            $parameters = $_POST["parameters"];
            $rutageneral = '../../auditex-corte/tmp/depuracion/pdfindicadores/';
            $fechagenera = date("YmdHisu");
            try{

                // GUARDAMOS DATOS INDICADOR GENERAL
                $name = $fechagenera.'_general_tmp.png';
                $objSistema->SaveImg($parameters[0],$name,$rutageneral);

                // GUARDAMOS DATOS PARETO 1
                $name = $fechagenera.'_pareto1_tmp.png';
                $objSistema->SaveImg($parameters[1],$name,$rutageneral);

                // GUARDAMOS DATOS PARETO 2
                $name = $fechagenera.'_pareto2_tmp.png';
                $objSistema->SaveImg($parameters[2],$name,$rutageneral);

                // GUARDAMOS DATOS PARETO 3
                $name = $fechagenera.'_pareto3_tmp.png';
                $objSistema->SaveImg($parameters[3],$name,$rutageneral);

                // GUARDAMOS DATOS PARETO 4
                $name = $fechagenera.'_pareto4_tmp.png';
                $objSistema->SaveImg($parameters[4],$name,$rutageneral);

                // GUARDAMOS DATOS PARETO 5
                $name = $fechagenera.'_pareto5_tmp.png';
                $objSistema->SaveImg($parameters[5],$name,$rutageneral);

                // GUARDAMOS DATOS PARETO 6
                $name = $fechagenera.'_pareto6_tmp.png';
                $objSistema->SaveImg($parameters[6],$name,$rutageneral);

                // GUARDAMOS TABLA GENERAL
                $name = $fechagenera.'_tblgeneral_tmp.png';
                $objSistema->SaveImg($parameters[7],$name,$rutageneral);

                
                echo json_encode(array(
                    "success"   => true,
                    "mensaje"   => $fechagenera
                ));

            }catch(Exception $ex){
                echo json_encode(array(
                    "success"   => false,
                    "mensaje"   => $ex
                ));
            }
            

        }

    }

    // GET
    if(isset($_GET["operacion"])){

        // PORCENTAJE DE INDICADORES
        if($_GET["operacion"] == "getmantindicador"){

            $response = $objModelo->getAll("AUDITEX.GETMANTINDICADORES",[
                $_GET["id"]
            ]);

            echo json_encode($response);
        }

        // SEDES
        if($_GET["operacion"] == "getsedes"){

            $response = $objModelo->getAll("AUDITEX.SP_AT_SELECT_SEDES",[]);
            echo json_encode($response);

        }

        // TIPO DE SERVICIO
        if($_GET["operacion"] == "gettiposervicios"){

            $response = $objModelo->getAll("AUDITEX.SP_AT_SELECT_TIPSERS",[]);
            echo json_encode($response);

        }

        // TALLERES
        if($_GET["operacion"] == "gettalleres"){

            $response = $objModelo->getAll("AUDITEX.GETTALLERES",[]);
            echo json_encode($response);

        }

        // GET PARETOS
        if($_GET["operacion"] == "getparametros"){

            $response = $objModelo->getAll("AUDITEX.SPU_GETPARETODEPURACIONPIEZAS",[
                $_GET["opcion"],$_GET["sede"],$_GET["tiposervicio"],
                $_GET["taller"],$_GET["fecha"],$_GET["proveedor"],
                $_GET["cliente"],$_GET["codtela"],$_GET["parametro"]
            ]);

            echo json_encode($response);

        }

    }

?>        