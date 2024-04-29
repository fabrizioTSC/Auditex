
<?php
session_start();

require_once '../../models/modelo/core.modelo.php';
// require_once '../../models/modelo/gestion-produccion/gestion-produccion.modelo.php'; 



$objModelo = new CoreModelo(); 
  
    // METODO GET
    if (isset($_GET["operacion"])) {

        // Listar Grilla Principal
        if ($_GET["operacion"] == "get-data-indicadorgeneral") {

            $opcion         = $_GET["opcion"];
            $proveedor      = $_GET["proveedor"];
            $cliente        = $_GET["cliente"];
            $programa       = $_GET["programa"];
            $telas          = $_GET["telas"];
            $color          = $_GET["color"];
            $fechainicio    = $_GET["fechainicio"];
            $fechafin       = $_GET["fechafin"];

            $response = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                $opcion,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,null,null,null
            ]);

            echo json_encode($response);

        }

        // Listar Grilla detalle
        if ($_GET["operacion"] == "get-data-indicadorgeneral-detalle") {

            $opcion         = $_GET["opcion"];
            $proveedor      = $_GET["proveedor"];
            $cliente        = $_GET["cliente"];
            $programa       = $_GET["programa"];
            $telas          = $_GET["telas"];
            $color          = $_GET["color"];
            $fechainicio    = $_GET["fechainicio"];
            $fechafin       = $_GET["fechafin"];
            $filtro         = $_GET["filtro"];
            $filtro2        = $_GET["filtro2"];
            $filtro3        = $_GET["filtro3"];


            $response = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                $opcion,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro,$filtro2,$filtro3
            ]);

            echo json_encode($response);

        }

        // GET DATOS PARA INDICADOR DEFECTOS
        if($_GET["operacion"] == "get-data-indicadores"){

            // $filtro1 = $_GET["filtro1"];
            $filtro1 = "";
            $filtro3 = $_GET["filtro3"];

            $proveedor      = $_GET["proveedor"];
            $cliente        = $_GET["cliente"];
            $programa       = $_GET["programa"];
            $telas          = $_GET["telas"];
            $color          = $_GET["color"];
            $fechainicio    = $_GET["fechainicio"];
            $fechafin       = $_GET["fechafin"];

            $response_anios     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                6,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            $response_meses     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                7,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            $response_semanas   = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                8,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            echo json_encode(
                [
                    "anio"      => $response_anios,
                    "meses"     => $response_meses,
                    "semanas"   => $response_semanas
                ]
            );

        }

        // GET DATOS TELAS PARA INDICADOR
        if($_GET["operacion"] == "get-data-filtros-indicador"){

            $proveedores    = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [9,null,null,null,null,null,null,null,null,null,null]);
            $clientes       = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [10,null,null,null,null,null,null,null,null,null,null]);
            $programas      = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [11,null,null,null,null,null,null,null,null,null,null]);
            $telas          = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [12,null,null,null,null,null,null,null,null,null,null]);
            $colores        = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [13,null,null,null,null,null,null,null,null,null,null]);

            echo json_encode(
                [
                    "proveedores"      =>$proveedores,
                    "clientes"      =>$clientes,
                    "programas"      =>$programas,
                    "telas"      =>$telas,
                    "colores"      =>$colores
                ]
            );

        }

        // GET DATOS PARA INDICADOR TONO
        if($_GET["operacion"] == "get-data-indicadores-tono"){

            // $filtro1 = $_GET["filtro1"];
            $filtro1 = "";

            $filtro3 = $_GET["filtro3"];
            $proveedor      = $_GET["proveedor"];
            $cliente        = $_GET["cliente"];
            $programa       = $_GET["programa"];
            $telas          = $_GET["telas"];
            $color          = $_GET["color"];
            $fechainicio    = $_GET["fechainicio"];
            $fechafin       = $_GET["fechafin"];

            $response_anios     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                18,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            $response_meses     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                19,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            $response_semanas   = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                20,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            echo json_encode(
                [
                    "anio"      => $response_anios,
                    "meses"     => $response_meses,
                    "semanas"   => $response_semanas
                ]
            );

        }

        // GET DATOS PARA INDICADOR TONO
        if($_GET["operacion"] == "get-data-indicadores-apariencia"){

            $filtro3 = $_GET["filtro3"];
            $filtro1 = "";

            $proveedor      = $_GET["proveedor"];
            $cliente        = $_GET["cliente"];
            $programa       = $_GET["programa"];
            $telas          = $_GET["telas"];
            $color          = $_GET["color"];
            $fechainicio    = $_GET["fechainicio"];
            $fechafin       = $_GET["fechafin"];

            $response_anios     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                25,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            $response_meses     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                26,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            $response_semanas   = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                27,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            echo json_encode(
                [
                    "anio"      => $response_anios,
                    "meses"     => $response_meses,
                    "semanas"   => $response_semanas
                ]
            );

        }


        // GET DATOS PARA INDICADOR DEFECTOS
        if($_GET["operacion"] == "get-data-indicadores-defectos-toneladas"){

            // $filtro1 = $_GET["filtro1"];
            $filtro1 = "";
            $filtro3 = $_GET["filtro3"];

            $proveedor      = $_GET["proveedor"];
            $cliente        = $_GET["cliente"];
            $programa       = $_GET["programa"];
            $telas          = $_GET["telas"];
            $color          = $_GET["color"];
            $fechainicio    = $_GET["fechainicio"];
            $fechafin       = $_GET["fechafin"];

            $response_anios     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                30,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            // $response_meses     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
            //     7,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            // ]);

            // $response_semanas   = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
            //     8,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            // ]);

            echo json_encode(
                [
                    "anio"      => $response_anios,
                    // "meses"     => $response_meses,
                    // "semanas"   => $response_semanas
                ]
            );

        }

        // GET DATOS PARA INDICADOR EST DIM
        if($_GET["operacion"] == "get-data-indicadores-estdim"){

            $filtro3 = $_GET["filtro3"];
            $filtro1 = "";

            $proveedor      = $_GET["proveedor"];
            $cliente        = $_GET["cliente"];
            $programa       = $_GET["programa"];
            $telas          = $_GET["telas"];
            $color          = $_GET["color"];
            $fechainicio    = $_GET["fechainicio"];
            $fechafin       = $_GET["fechafin"];

            $response_anios     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                36,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            $response_meses     = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                37,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            $response_semanas   = $objModelo->getAll("AUDITEX.PQ_TEXTIL_INDICADOR.GETDATOSREPORTEGENERAL", [
                38,$proveedor,$cliente,$programa,$telas,$color,$fechainicio,$fechafin,$filtro1,null,$filtro3
            ]);

            echo json_encode(
                [
                    "anio"      => $response_anios,
                    "meses"     => $response_meses,
                    "semanas"   => $response_semanas
                ]
            );

        }
    }



?>