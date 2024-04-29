<?php

    require_once '../../models/modelo/core.modelo.php';

    $objModelo = new CoreModelo();

    if(isset($_GET["operacion"])){

        // MUESTRA USUARIOS
        if($_GET["operacion"] == "getusuarios"){
            $reponse = $objModelo->select("SELECT * FROM AUDITEX.REGISTRO_METALES_USUARIOS WHERE ESTADO = '1'");
            echo json_encode($reponse);
        }

        //  LISTAR REGISTROS
        if($_GET["operacion"] == "getregistros"){

            $reponse = $objModelo->select(
                "
                SELECT
                        RMT.IDREGISTRO, RMT.PO, RMT.BOL, RMT.FECHA,
                        RMT.IDUSUARIO, RMT.METODO, RMT.NOTAS, RMT.VALIDADOACABADOS,
                        RMT.VALIDADOCALIDAD, USU.DNI, USU.NOMBRES, USU.RUTAIMAGEN,
                        RMT.F_REGISTRO
                FROM  AUDITEX.REGISTRO_METALES RMT
                INNER JOIN  AUDITEX.REGISTRO_METALES_USUARIOS USU
                ON USU.IDUSUARIO = RMT.IDUSUARIO ORDER BY RMT.F_REGISTRO DESC
                "
            );
            echo json_encode($reponse);

        }


    }

    // POST
    if(isset($_POST["operacion"])){

        // REGISTRA
        if($_POST["operacion"] == "registrar"){

            $parameters = $_POST["parameters"];
            array_splice($parameters,0,1);

            $reponse = $objModelo->setAll("AUDITEX.SPU_REGISTRO_METALES_REGIS",$parameters,"Registrado correctamente");
            echo json_encode($reponse);
        }

        // REGISTRA
        if($_POST["operacion"] == "eliminar"){

            $parameters = $_POST["parameters"];
            //array_splice($parameters,0,1);

            $reponse = $objModelo->setAll("AUDITEX.SPU_REGISTRO_METALES_ELI",$parameters,"Eliminado correctamente");
            echo json_encode($reponse);
        }


        // REGISTRA
        if($_POST["operacion"] == "modificar"){

            $parameters = $_POST["parameters"];
            //array_splice($parameters,0,1);

            $reponse = $objModelo->setAll("AUDITEX.SPU_REGISTRO_METALES_MODF",$parameters,"Modificado correctamente");
            echo json_encode($reponse);
        }

    }

?>