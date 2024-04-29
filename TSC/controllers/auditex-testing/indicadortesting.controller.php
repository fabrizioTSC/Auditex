<?php
    session_start();

    require_once '../../models/modelo/core.modelo.php';
    require_once '../../models/modelo/sistema.modelo.php';
    // INDICADOR MODELO
    require_once '../../models/modelo/auditex-testing/testingindicador.modelo.php';



    $objModelo  = new CoreModelo();
    $objSistema = new SistemaModelo();
    $objTestingIndicadorModelo = new TestingIndicadorModelo();


    // POST
    if(isset($_POST["operacion"])){

        // INDICADOR GENERAL
        if($_POST["operacion"] == "getindicadorgeneral"){
            
            $parameters = $_POST["parameters"];
            $response = $objModelo->getAll("AUDITEX.SPU_GETINDICADORTESTING",$parameters);
            echo json_encode($response);

        }

        // INDICADOR PROVEEDORES
        if($_POST["operacion"] == "getindicadorproveedores"){
            
            $parameters = $_POST["parameters"];
            $response = $objModelo->getAll("AUDITEX.SPU_GETINDICADORTESTINGPROV",$parameters);
            echo json_encode($response);

        }

        // INDICADOR CLIENTES
         if($_POST["operacion"] == "getindicadorclientes"){
            
            $parameters = $_POST["parameters"];
            $response = $objModelo->getAll("AUDITEX.SPU_GETINDICADORTESTINGCLI",$parameters);
            echo json_encode($response);

        }

        // GUARDAR IMAGENES PARA EL INDICADOR
        if($_POST["operacion"] == "saveimagenes"){

            // 
            $parameters = $_POST["parameters"];
            $rutageneral = '../../auditex-testing/tmp/testing/pdfindicadores/';
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

                // // GUARDAMOS TABLA GENERAL
                // $name = $fechagenera.'_tblgeneral_tmp.png';
                // $objSistema->SaveImg($parameters[7],$name,$rutageneral);

                
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

        // EXPORTAR A EXCEL
        if($_POST["operacion"] == "exportarexcel"){

            $lblfiltros         = $_POST["lblfiltros"];
            $data               = $_POST["data"];
            $datadecode         = json_decode($data);

            // header('Content-Type: application/json');
            // echo json_encode($data);
            // var_dump($data);

            $objTestingIndicadorModelo->getExcel("indicadortesting",$lblfiltros,$datadecode);
        }

    }

    // GET
    if(isset($_GET["operacion"])){

        // GET PARETOS
        if($_GET["operacion"] == "getparetos"){

            $response = $objModelo->getAll("AUDITEX.SPU_GETPARETOS_TESTING",[
                $_GET["opcion"],$_GET["parametro"],$_GET["proveedor"],
                $_GET["cliente"],$_GET["programa"],$_GET["codtela"],
                $_GET["tipotela"],$_GET["fecha"]
            ]);

            echo json_encode($response);

        }

        // GET INDICADOR 2
        if($_GET["operacion"] == "getindicadordimensional"){

            $response = $objModelo->getAll("AUDITEX.SPU_TESTING_INDI_ESTABI",[
                $_GET["fechai"],$_GET["fechaf"],$_GET["proveedor"],
                $_GET["cliente"]
            ]);

            echo json_encode($response);

        }

        // GET INDICADOR 2 DATOS
        if($_GET["operacion"] == "getindicadordimensionaldatos"){

            $response = $objModelo->getAll("AUDITEX.SPU_TESTING_INDI_ESTABI_D",[
                $_GET["fechai"],$_GET["fechaf"],$_GET["proveedor"],
                $_GET["cliente"]
            ]);

            echo json_encode($response);

        }


    }


?>        