<?php
    session_start();

    require_once '../../models/modelo/core.modelo.php';
    require_once '../../models/modelo/sistema.modelo.php';

    // INDICADOR MODELO
    // require_once '../../models/modelo/auditex-testing/testingindicador.modelo.php';



    $objModelo  = new CoreModelo();
    $objSistema = new SistemaModelo();
    // $objTestingIndicadorModelo = new TestingIndicadorModelo();


    // POST
    if(isset($_POST["operacion"])){

        // INDICADOR GENERAL
        if($_POST["operacion"] == "getindicadorgeneral"){
            
            $parameters = $_POST["parameters"];
           // $response = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_GETINDICADOR",$parameters);
             $response = $objModelo->getSQL("AUDITEX.PQ_MOLDES_SPU_GETINDICADOR",$parameters);
            $_SESSION["indicadorgeneral_moldes"] = $response;
            echo json_encode($response);

        }

        // INDICADOR GENERAL
        if($_POST["operacion"] == "getindicadorgeneral-cantfichas"){
            
            $parameters = $_POST["parameters"];
            $response = $objModelo->getSQL("AUDITEX.PQ_MOLDES_SPU_GETINDICADORCANTFICHAS",$parameters);
            $_SESSION["indicadorgeneral_moldes_cantidad"] = $response;
            echo json_encode($response);

        }


        // INDICADOR CLIENTES
         if($_POST["operacion"] == "getindicadorclientes"){
            
            $parameters = $_POST["parameters"];
            $response = $objModelo->getSQL("AUDITEX.PQ_MOLDES_SPU_GETINDICADOR_CLIENTES",$parameters);

            $_SESSION["indicadorclientes_moldes"] = $response;
            echo json_encode($response);

        }

        // INDICADOR CLIENTES
        if($_POST["operacion"] == "getindicadorclientes-cantfichas"){
            
            $parameters = $_POST["parameters"];
            $response = $objModelo->getSQL("AUDITEX.PQ_MOLDES_SPU_GETINDICADOR_CLICANTFICHAS",$parameters);

            $_SESSION["indicadorclientes_moldes_cantidad"] = $response;
            echo json_encode($response);

        }

        // GUARDAR IMAGENES PARA EL INDICADOR
        if($_POST["operacion"] == "saveimagenes"){

            // 
            $parameters = $_POST["parameters"];
            $rutageneral = '../../auditex-moldes/tmp/encogimientocorte/pdfindicadores/';
            $fechagenera = date("YmdHisu");
            try{

                // GUARDAMOS DATOS INDICADOR GENERAL
                $name = $fechagenera.'_general_tmp.png';
                $objSistema->SaveImg($parameters[0],$name,$rutageneral);


                
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



?>        