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

            $parametros = array(
                'I_PROVEEDOR' => $parameters[0] !== "" ? $parameters[0] : null,
                'I_CLIENTE' => $parameters[1] !== "" ? $parameters[1] : null,
                'I_PROGRAMA' => $parameters[2] !== "" ? $parameters[2] : null,
                'I_CODTELA' => $parameters[3] !== "" ? $parameters[3] : null,
                'I_TIPOTELA' => $parameters[4] !== "" ? $parameters[4] : null,
                'I_FECHA' => $parameters[5] !== "" ? $parameters[5] : null 
            );

            $response = $objModelo->getAllSQL_Indicador("AUDITEX.SPU_GETINDICADORTESTING",$parametros);
            echo json_encode($response);

        }

        // INDICADOR PROVEEDORES
        if($_POST["operacion"] == "getindicadorproveedores"){
            
            $parameters = $_POST["parameters"];

            $parametros = array(
                'I_PROVEEDOR' => $parameters[0] !== "" ? $parameters[0] : null,
                'I_CLIENTE' => $parameters[1] !== "" ? $parameters[1] : null,
                'I_PROGRAMA' => $parameters[2] !== "" ? $parameters[2] : null,
                'I_CODTELA' => $parameters[3] !== "" ? $parameters[3] : null,
                'I_TIPOTELA' => $parameters[4] !== "" ? $parameters[4] : null,
                'I_FECHA' => $parameters[5] !== "" ? $parameters[5] : null 
            );
            $response = $objModelo->getAllSQL_Indicador("AUDITEX.SPU_GETINDICADORTESTINGPROV",$parametros);
            echo json_encode($response);

        }

        // INDICADOR CLIENTES
         if($_POST["operacion"] == "getindicadorclientes"){
            $parameters = $_POST["parameters"];

            $parametros = array(
                'I_PROVEEDOR' => $parameters[0] !== "" ? $parameters[0] : null,
                'I_CLIENTE' => $parameters[1] !== "" ? $parameters[1] : null,
                'I_PROGRAMA' => $parameters[2] !== "" ? $parameters[2] : null,
                'I_CODTELA' => $parameters[3] !== "" ? $parameters[3] : null,
                'I_TIPOTELA' => $parameters[4] !== "" ? $parameters[4] : null,
                'I_FECHA' => $parameters[5] !== "" ? $parameters[5] : null 
            );
            $response = $objModelo->getAllSQL_Indicador("AUDITEX.SPU_GETINDICADORTESTINGCLI",$parametros);
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
            $parametros = array(
                'I_OPCION' => $_GET["opcion"] !== "" ? $_GET["opcion"] : null,
                'I_PARAMETRO' =>$_GET["parametro"]!== "" ?$_GET["parametro"] : null,
                'I_PROVEEDOR' => $_GET["proveedor"] !== "" ? $_GET["proveedor"] : null,
                'I_CLIENTE' => $_GET["cliente"] !== "" ? $_GET["cliente"] : null,
                'I_PROGRAMA' => $_GET["programa"]!== "" ? $_GET["programa"] : null,
                'I_CODTELA' => $_GET["codtela"] !== "" ? $_GET["codtela"] : null,
                'I_TIPOTELA' => $_GET["tipotela"] !== "" ? $_GET["tipotela"] : null ,
                'I_FECHA' => $_GET["fecha"] !== "" ? $_GET["fecha"] : null 
            );

            $response = $objModelo->getAllSQL_Indicador("AUDITEX.SPU_GETPARETOS_TESTING",$parametros);

            echo json_encode($response);

        }

        // GET INDICADOR 2
        if($_GET["operacion"] == "getindicadordimensional"){
            $parametros = array(
                'I_FECHAI' => $_GET["fechai"] !== "" ? $_GET["fechai"] : null,
                'I_FECHAF' =>$_GET["fechaf"]!== "" ?$_GET["fechaf"] : null,
                'I_PROVEEDOR' => $_GET["proveedor"] !== "" ? $_GET["proveedor"] : null,
                'I_CLIENTE' => $_GET["cliente"] !== "" ? $_GET["cliente"] : null,
            );

            $response = $objModelo->getAllSQL_Indicador("AUDITEX.SPU_TESTING_INDI_ESTABI",$parametros);

            echo json_encode($response);

        }

        // GET INDICADOR 2 DATOS
        if($_GET["operacion"] == "getindicadordimensionaldatos"){
            $parametros = array(
                'I_FECHAI' => $_GET["fechai"] !== "" ? $_GET["fechai"] : null,
                'I_FECHAF' =>$_GET["fechaf"]!== "" ?$_GET["fechaf"] : null,
                'I_PROVEEDOR' => $_GET["proveedor"] !== "" ? $_GET["proveedor"] : null,
                'I_CLIENTE' => $_GET["cliente"] !== "" ? $_GET["cliente"] : null,
            );

            $response = $objModelo->getAllSQL_Indicador("AUDITEX.SPU_TESTING_INDI_ESTABI_D",$parametros);
            echo json_encode($response);

        }


    }


?>        