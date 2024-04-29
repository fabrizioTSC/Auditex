<?php

    require_once '../../models/modelo/core.modelo.php';

    $objModelo = new CoreModelo();

    if(isset($_GET["operacion"])){

        //  LISTAR CABECERAS CORREOS
        if($_GET["operacion"] == "getheadcorreos"){

            $reponse = $objModelo->select(
                "
                    SELECT * FROM AUDITEX.HEAD_CORREOS WHERE ESTADO = '1' ORDER BY PROCESO ASC
                "
            );
            echo json_encode($reponse);

        }

        //  LISTAR CORREOS DE LOS USUARIOS
        if($_GET["operacion"] == "getcorreos"){

            $reponse = $objModelo->select(
                "
                    SELECT IDCORREO,NOMBRE,CORREO||''||DOMINIO CORREO FROM AUDITEX.CORREOS ORDER BY CORREO ASC
                "
            );

            echo json_encode($reponse);

        }

        //  LISTAR DETALLE DE LOS CORREOS
        if($_GET["operacion"] == "getdetailcorreos"){

            // $id = isset($_GET["idenvio"]) ? $_GET["idenvio"] : "0";
            $id = $_GET["idenvio"] != "" ? $_GET["idenvio"] : "0";

            // echo $id;
            $response = $objModelo->select(
                "
                    SELECT
                            DC.IDENVIO,
                            -- DC.IDDETAILCORREO,
                            DC.IDCORREO,
                            DC.TIPO,
                            CO.IDCORREO,
                            CO.CORREO,
                            CO.NOMBRE,
                            CO.DOMINIO
                    FROM AUDITEX.DETAIL_CORREOS DC
                    INNER JOIN AUDITEX.CORREOS CO ON
                    CO.IDCORREO = DC.IDCORREO
                    WHERE DC.IDENVIO = {$id}
                    GROUP BY 
                        DC.IDENVIO,
                        -- DC.IDDETAILCORREO,
                        DC.IDCORREO,
                        DC.TIPO,
                        CO.IDCORREO,
                        CO.CORREO,
                        CO.NOMBRE,
                        CO.DOMINIO
                        ORDER BY DC.TIPO ASC
                "
            );

            // 
            foreach($response as $fila){

                $tipo = "";

                if($fila->TIPO == "C") { $tipo = "COPIADO"; }
                if($fila->TIPO == "R") { $tipo = "DESTINATARIO"; }
                if($fila->TIPO == "E") { $tipo = "REMITENTE"; }

                echo "<tr>";
                // echo "<td> {$fila->TIPO} </td>";
                echo "<td> {$tipo} </td>";

                echo "<td> {$fila->NOMBRE} </td>";
                echo "<td> {$fila->CORREO}{$fila->DOMINIO} </td>";
                echo "<td>";
                echo "      <a href='#' 
                    data-id='{$fila->IDENVIO}' 
                    data-idcorreo='{$fila->IDCORREO}' 
                    data-tipo='{$fila->TIPO}'
                    class='addfiltro'> <i class='fas fa-plus'><i>  </a>";
                echo "</td>";
                echo "<tr>";
            }

        }

        // LISTA DE FILTROS SEGUN CORREO
        if($_GET["operacion"] == "getfiltroscorreo"){


            $idenvio    = $_GET["idenvio"];
            $idcorreo   = $_GET["idcorreo"];
            $tipo       = $_GET["tipo"];
            
            $response = $objModelo->select(
                "
                    SELECT IDDETAILCORREO,FILTRO FROM AUDITEX.DETAIL_CORREOS 
                    WHERE IDENVIO = {$idenvio} AND IDCORREO = {$idcorreo}
                    AND TIPO = '{$tipo}' AND FILTRO IS NOT NULL
                "
            );

            foreach($response as $fila){
                echo "<tr>";
                // echo "<td>{$}</td>";
                echo "<td>{$fila->FILTRO}</td>";
                echo "<td> <a href='#' class='btn btn-danger btn-sm deletecorreo' data-id='{$fila->IDDETAILCORREO}'> <i class='fas fa-trash'></i> </a> </td>";
                echo "</tr>";
            }

        }


    }

    // POST
    if(isset($_POST["operacion"])){

        
        // REGISTRAMOS CORREOS PARA DETALLE
        if($_POST["operacion"] == "setdetailcorreo"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.SPU_SETDETAILCORREOS",$parameters,"Registro correcto");
            echo json_encode($response);
        }

        // ELIMINAMOS CORREO
        if($_POST["operacion"] == "deletedetailcorreo"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.SPU_DELETEDCORREO",$parameters,"Eliminado correcto");
            echo json_encode($response);

        }

    }

   

?>