<?php
session_start();

require_once '../../models/modelo/core.modelo.php';
require_once '../../models/modelo/auditex-lavanderia/lavanderia.modelo.php';



    $objModelo = new CoreModelo();
    $objLavanderiaM = new LavanderiaModelo();


    // GET
    if(isset($_GET["operacion"])){


        // REGISTRAR
        if($_GET["operacion"] == "set-lavadopanio"){

            $opcion     = $_GET["opcion"];
            $idficha    = $_GET["idficha"];
            $ficha      = $_GET["ficha"];
            $cantficha  = $_GET["cantficha"];
            $cantpartir = $_GET["cantpartir"];
            $parte      = $_GET["parte"];
            $numvez     = $_GET["numvez"];
            $usuario    = $_GET["usuario"];


            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_SETAUDITORIAPANIO",[
                $opcion,$idficha,$ficha,$cantficha,$cantpartir,$parte,$numvez,$usuario
            ]);

            echo json_encode($response);

        }


        // GET DEFECTOS PARA AGREGAR
        if($_GET["operacion"] == "get-defectos"){

            // SPU_GETDATOS
            $idficha = $_GET["idficha"];
            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[6,$idficha,null]);
            echo json_encode($response);
        }

        
        // GET DEFECTO AGREGADOS
        if($_GET["operacion"] == "get-defectos-agregados"){

            // SPU_GETDATOS
            $idficha    = $_GET["idficha"];
            $response   = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[7,$idficha,null]);
            // $usuario    =

            foreach($response as $fila){

                echo "<tr>";

                echo "<td nowrap>{$fila['CODDEFAUX']}</td>";
                echo "<td nowrap>{$fila['DESDEF']}</td>";
                echo "<td nowrap>";

                if($fila['ESTADO'] == "" || $fila['ESTADO'] == "EN PROCESO"){
                    echo "
                    <button 
                            class='btn btn-danger btn-sm' 
                            onclick='updateDefectos(-1,{$fila['IDFICHA']},{$fila['IDDEFECTO']},{$fila['CANTIDAD']})'
                        > 
                        <i class='fas fa-minus'></i> 
                    </button>";
                }

                echo " <button> 
                            {$fila['CANTIDAD']}
                        </button>
                ";
                        
                if($fila['ESTADO'] == "" || $fila['ESTADO'] == "EN PROCESO"){
                    echo "
                    <button 
                            class='btn btn-danger btn-sm' 
                            onclick='updateDefectos(1,{$fila['IDFICHA']},{$fila['IDDEFECTO']},{$fila['CANTIDAD']})'
                        > 
                        <i class='fas fa-plus'></i> 
                    </button>";
                }

                echo "</td>";
                echo "<td nowrap>{$fila['OBSERVACION']}</td>";

                echo "</tr>";


            }
        }

        // TALLERES DE LAVADO
        if($_GET["operacion"] == "get-talleres-lavanderia"){

            // $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[11,null,null]);
            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[12,null]);
            echo json_encode($response);

        }

        // GET DATOS DE MAQUINAS DE LAVADOS
        if($_GET["operacion"] == "get-maquinas-agregadas"){

            $idficha = $_GET["idficha"];
            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETFICHASPANO",[12,$idficha,null]);
            echo json_encode($response);

        }
        
        // MAQUINAS DE LAVADO
        if($_GET["operacion"] == "get-maquinas-lavanderia"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[1,null]);
            echo json_encode($response);

        }

        // ################
        // ### REPORTES ###
        // ################

        // DEFECTOS
        if($_GET["operacion"] == "get-report-defectos"){

            $objLavanderiaM->getReporteDefectos_Prendas("Reporte_Defectos_Panos",$_SESSION["data_reporte_defectos_lavanderia_panos"]);

        }

        // AUDITOR
        if($_GET["operacion"] == "get-report-auditor"){

            $objLavanderiaM->getReporteAuditor_Prendas("Reporte_Auditor_Panos",$_SESSION["data_reporte_auditor_lavanderia_panos"]);
        }

        // GENERAL
        if($_GET["operacion"] == "get-report-general"){

            $objLavanderiaM->getReporteGeneralPrendas("Reporte_General_Panos",$_SESSION["reportegenerallavadopanos"]);

        }


        // ###################
        // ### INDICADORES ###
        // ###################

        // GET MUESTRA SEGUN DEFECTO
        if($_GET["operacion"] == "get-muestra-indicador-defectos"){

            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_INDICADORDEFECTOSMUES_PAN",[
                $_GET["opcion"],$_GET["anio"],$_GET["semana"],$_GET["fechainicio"],$_GET["fechafin"],
                $_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            echo json_encode($response);

        }

         // GET INIDICADOR DEFECTOS
         if($_GET["operacion"] == "get-indicador-defectos-detalle"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_INDICADORDEFECTOSD_PANOS",[
                $_GET["opcion"],$_GET["anio"],$_GET["semana"],$_GET["fechainicio"],$_GET["fechafin"],
                $_GET["sede"],$_GET["tiposervicio"],$_GET["taller"],$_GET["iddefecto"]
            ]);

            echo json_encode($response);

        }
        
        // DEFECTOS
        if($_GET["operacion"] == "get-indicador-defectos"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_INDICADORDEFECTOS_PANOS",[
                $_GET["opcion"],$_GET["anio"],$_GET["semana"],$_GET["fechainicio"],$_GET["fechafin"],
                $_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            echo json_encode($response);
        }

         // GET INIDICADOR DE RESULTADOS
         if($_GET["operacion"] == "get-indicador-resultados"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_INDICADORRESULTADO_PANIO",[
                $_GET["opcion"],$_GET["fecha"],$_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            echo json_encode($response);

        }

         // INDICADOR RESULTADS - DEFECTOS
         if($_GET["operacion"] == "get-indicador-resultados-defectos"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_INDRESULTADODEFECTO_PANO",[
                $_GET["opcion"],$_GET["idfamdefecto"],$_GET["fecha"],$_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            echo json_encode($response);

        }

        // REPORTE GENERAL
        if($_GET["operacion"] == "getreportegeneral"){



            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETREPORTES_PANOS",[
                1,$_GET["fechai"],$_GET["fechaf"],$_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            $_SESSION["reportegenerallavadopanos"] = $response;

            echo json_encode($response);


        }


    }

    // POST
    if(isset($_POST["operacion"])){


        // REGISTRAR VALIDACION DE DOCUMENTOS
        if($_POST["operacion"] == "set-lavadopanio-validaciondocumento"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETAUDITORIAPANIO_DOC",$parameters,"Registrado correctamente");
            echo json_encode($response);
        }

        // REGISTRAR VERIFICACION
        if($_POST["operacion"] == "set-lavadopanio-verificacion"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETAUDITORIAPANIO_VER",$parameters,"Registrado correctamente");
            echo json_encode($response);
        }

        // REGISTRO DE DEFECTOS DETALLE
        if($_POST["operacion"] == "set-defectos-detalle"){
            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETAUDITORIAPANIO_DEF_DET",$parameters,"Registrado correctamente");
            echo json_encode($response);
        }

        // CERRAR REGISTRO DE DEFECTOS
        if($_POST["operacion"] == "set-lavadopanio-cerrardefecto"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_SETCERRARDEFECTO_PANOS",$parameters);
            echo json_encode($response);
        }

        // REGISTRO DE ETAPAS DE PAÑOS
        if($_POST["operacion"] == "set-etapas-fichas"){

            // SPU_SETFICHAETAPAPANOS
            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETFICHAETAPAPANOS",$parameters,"Agregado correctamente");
            echo json_encode($response);
        }


        // REGISTRO DE MAQUINA DE LAVADO
        if($_POST["operacion"] == "set-maquinas-lavados"){
            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETMAQUINAS_PANIO",$parameters,"Realizado correctamente");
            echo json_encode($response);
        }



    }



?>