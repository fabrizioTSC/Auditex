<?php
    session_start();
    ini_set('memory_limit', '-1');
    require_once '../../models/modelo/core.modelo.php';
    // require_once '../../models/modelo/reporteexcel.modelo.php';
    // require_once '../../models/modelo/sistema.modelo.php';


    $objModelo  = new CoreModelo();
    // $objExcelModelo = new ExcelAjustes();


    // POST
    if(isset($_GET["operacion"])){


        if($_GET["operacion"] == "getreporte"){

            $sede           = $_GET["sede"] == "" ? null : $_GET["sede"];
            $tiposervicio   = $_GET["tiposervicio"] == "" ? null : $_GET["tiposervicio"];
            $taller         = $_GET["taller"] == "" ? null : $_GET["taller"];
            $auditor        = $_GET["auditor"] == "" ? null : $_GET["auditor"];
            $cliente        = $_GET["cliente"] == "" ? null : $_GET["cliente"];
            $pedido         = $_GET["pedido"] == "" ? null : $_GET["pedido"];
            $color          = $_GET["color"] == "" ? null : $_GET["color"];
            $fechai         = $_GET["fechai"] == "" ? null : $_GET["fechai"];
            $fechaf         = $_GET["fechaf"] == "" ? null : $_GET["fechaf"];



            $response = $objModelo->getAll("AUDITEX.PQ_AUDITORIAFINAL.SPU_GETREPORTECLASIFICACION",[
                $sede,$tiposervicio,$taller,$auditor,
                $cliente,$pedido,$color,$fechai,$fechaf
            ]);
            echo json_encode($response);
            

        }


    }

?>