<?php
    session_start();

    require_once '../../models/modelo/core.modelo.php';
    // require_once '../../models/modelo/sistema.modelo.php';


    $objModelo  = new CoreModelo();


    // GET
    if(isset($_GET["operacion"])){

        // SEDES
        if($_GET["operacion"] == "getsedes"){

            $response = $objModelo->getAll("AUDITEX.PQ_GENERALES.SPU_GETSEDES",[1]);
            echo json_encode($response);

        }

        // TIPOS DE SERVICIO
        if($_GET["operacion"] == "gettiposervicios"){

            $response = $objModelo->getAll("AUDITEX.PQ_GENERALES.SPU_GETTIPOSSERVICIOS",[1]);
            echo json_encode($response);

        }

        // TALLERES
        if($_GET["operacion"] == "gettalleres"){

            $response = $objModelo->getAll("AUDITEX.PQ_GENERALES.SPU_GETTALLERES",[1]);
            echo json_encode($response);

        }

        // TALLERES
        if($_GET["operacion"] == "gettalleres_new"){

            $sede = $_GET["sede"] != "" ? $_GET["sede"] : "";
            $tiposervicio = $_GET["tiposervicio"] != "" ? $_GET["tiposervicio"] : "";

            $response = $objModelo->getAll("AUDITEX.PQ_GENERALES.SPU_GETTALLERES_NEW",[1,$sede,$tiposervicio]);
            echo json_encode($response);

        }

        // CLIENTES
        if($_GET["operacion"] == "getclientes"){

            $response = $objModelo->getAll("AUDITEX.PQ_GENERALES.SPU_GETCLIENTES",[1]);
            echo json_encode($response);

        }

        // AUDITORES
         if($_GET["operacion"] == "getauditores"){

            $response = $objModelo->getAll("AUDITEX.PQ_GENERALES.SPU_GETAUDITORES",[1]);
            echo json_encode($response);

        }

        // AUDITORES CORTE PROCESO
        if($_GET["operacion"] == "getauditorescorteproceso"){

            $response = $objModelo->getAll("AUDITEX.PQ_INDICADORES_AUDITOR.SPU_GETAUDITORESCORTEPROCESO",[]);
            echo json_encode($response);

        }

        // AUDITORES CORTE FINAL
        if($_GET["operacion"] == "getauditorescortefinal"){

            $response = $objModelo->getAll("AUDITEX.PQ_INDICADORES_AUDITOR.SPU_GETAUDITORESCORTEFINAL",[]);
            echo json_encode($response);

        }


        // AUDITORES COSTURA FINAL
        if($_GET["operacion"] == "getauditorescosturafinal"){

            $response = $objModelo->getAll("AUDITEX.PQ_INDICADORES_AUDITOR.SPU_GETAUDITORESCOSTURAFINAL",[]);
            echo json_encode($response);

        }

    }

    // POST
    if(isset($_POST["operacion"])){

        // ELIMINAR AUDITORIAS
        if($_POST["operacion"] == "setdeleteauditorias"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_MODAUDITEX.SPU_SETELIMINARAUDITORIAS",$parameters,"Eliminado correctamente");
            echo json_encode($response);

        }


    }

?>