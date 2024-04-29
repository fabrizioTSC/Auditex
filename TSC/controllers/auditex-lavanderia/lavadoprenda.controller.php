<?php
session_start();

require_once '../../models/modelo/core.modelo.php';
require_once '../../models/modelo/auditex-lavanderia/lavanderia.modelo.php';


    $objModelo = new CoreModelo();
    $objLavanderiaM = new LavanderiaModelo();

    // GET
    if(isset($_GET["operacion"])){


        // REGISTRAR
        if($_GET["operacion"] == "set-lavadoprenda"){

            $opcion     = $_GET["opcion"];
            $idficha    = $_GET["idficha"];
            $ficha      = $_GET["ficha"];
            $cantficha  = $_GET["cantficha"];
            $cantpartir = $_GET["cantpartir"];
            $parte      = $_GET["parte"];
            $numvez     = $_GET["numvez"];
            $usuario    = $_GET["usuario"];


            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_SETAUDITORIAPRENDA",[
                $opcion,$idficha,$ficha,$cantficha,$cantpartir,$parte,$numvez,$usuario
            ]);

            echo json_encode($response);

        }

        // GET DEFECTOS PARA AGREGAR
        if($_GET["operacion"] == "get-defectos"){

            // SPU_GETDATOS
            $idficha = $_GET["idficha"];
            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[5,$idficha]);
            echo json_encode($response);
        }

        // GET DEFECTO AGREGADOS
        if($_GET["operacion"] == "get-defectos-agregados"){

            // SPU_GETDATOS
            $idficha = $_GET["idficha"];
            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[6,$idficha]);

            foreach($response as $fila){

                echo "<tr>";

                echo "<td nowrap>{$fila['CODDEFAUX']}</td>";
                echo "<td nowrap>{$fila['DESDEF']}</td>";
                echo "<td nowrap>";

                if($fila['RESULTADO'] == "" || $fila['RESULTADO'] == "EN PROCESO"){
                    echo "
                    <button class='btn btn-danger btn-sm' onclick='moddefectos(-1,{$fila['IDFICHA']},{$fila['CANTIDAD']},{$fila['IDDEFECTO']})'> 
                        <i class='fas fa-minus'></i> 
                    </button>";
                }

                echo " <button> 
                            {$fila['CANTIDAD']}
                        </button>
                ";
                        
                if($fila['RESULTADO'] == "" || $fila['RESULTADO'] == "EN PROCESO"){
                    echo "
                    <button class='btn btn-danger btn-sm' onclick='moddefectos(1,{$fila['IDFICHA']},{$fila['CANTIDAD']},{$fila['IDDEFECTO']})'> 
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

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[12,null]);
            echo json_encode($response);

        }

        // GET DATOS DE MAQUINAS DE LAVADOS
        if($_GET["operacion"] == "get-maquinas-agregadas"){

            $idficha = $_GET["idficha"];
            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[13,$idficha]);
            echo json_encode($response);

        }

        // MAQUINAS DE LAVADO
        if($_GET["operacion"] == "get-maquinas-lavanderia"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[1,null]);
            echo json_encode($response);

        }

        // VERIFICA MEDIDAS
        if($_GET["operacion"] == "get-verifica-medidas"){

            $idficha = $_GET["idficha"];
            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[14,$idficha]);
            echo json_encode($response);

        }

        // VERIFICA MEDIDAS SIGE
        if($_GET["operacion"] == "get-verifica-medidas-sige"){

            $estilotsc = $_GET["estilotsc"];
            $response = $objModelo->getSQLSIGE("uspGetSetMedidasAuditex",[1,$estilotsc,0]);
            echo json_encode($response);
            // $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETDATOS",[14,$idficha]);
            // echo json_encode($response);

        }

        // GET TEMPORADAS SIGE
        if($_GET["operacion"] == "get-temporadas-sige"){

            $estilotsc = $_GET["estilotsc"];
            $response = $objModelo->getAllSQLSIGE("uspGetSetMedidasAuditex",[2,$estilotsc,0]);
            echo json_encode($response);

        }

        // REGISTRAMOS MEDIDAS EN TEMPORAL SIGE
        if($_GET["operacion"] == "set-medidas-sige"){

            $estilotsc      = $_GET["estilotsc"];
            $codtemporada   = $_GET["codtemporada"];

            $response = $objModelo->setAllSQLSIGE("uspGetSetMedidasAuditex",[3,$estilotsc,0,$codtemporada],"Correcto");
            echo json_encode($response);
        }

        // ################
        // ### REPORTES ###
        // ################

        // DEFECTOS
        if($_GET["operacion"] == "get-report-defectos"){

            $objLavanderiaM->getReporteDefectos_Prendas("Reporte_Defectos_Prendas",$_SESSION["data_reporte_defectos_lavanderia_prendas"]);

        }

        // AUDITOR
        if($_GET["operacion"] == "get-report-auditor"){

            $objLavanderiaM->getReporteAuditor_Prendas("Reporte_Auditor_Prendas",$_SESSION["data_reporte_auditor_lavanderia_prendas"]);

        }

        // GENERAL
        if($_GET["operacion"] == "get-report-general"){

            $objLavanderiaM->getReporteGeneralPrendas("Reporte_General_Prendas",$_SESSION["reportegenerallavadoprenda"]);

        }

        // ###################
        // ### INDICADORES ###
        // ###################

        // GET MUESTRA SEGUN DEFECTO
        if($_GET["operacion"] == "get-muestra-indicador-defectos"){

            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_INDICADORDEFECTOSMUES_PREN",[
                $_GET["opcion"],$_GET["anio"],$_GET["semana"],$_GET["fechainicio"],$_GET["fechafin"],
                $_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            echo json_encode($response);

        }

        // DEFECTOS
        if($_GET["operacion"] == "get-indicador-defectos"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_INDICADORDEFECTOS_PRENDAS",[
                $_GET["opcion"],$_GET["anio"],$_GET["semana"],$_GET["fechainicio"],$_GET["fechafin"],
                $_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            echo json_encode($response);
        }

        // GET INIDICADOR DEFECTOS
        if($_GET["operacion"] == "get-indicador-defectos-detalle"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_INDICADORDEFECTOSD_PRENDAS",[
                $_GET["opcion"],$_GET["anio"],$_GET["semana"],$_GET["fechainicio"],$_GET["fechafin"],
                $_GET["sede"],$_GET["tiposervicio"],$_GET["taller"],$_GET["iddefecto"]
            ]);

            echo json_encode($response);

        }

        // GET TALLER O MAQUINA LAVADO
        if($_GET["operacion"] == "get-taller-maquina"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETMAQUINAS_TALLER",[
                $_GET["idsede"],$_GET["tiposervicio"]
            ]);

            echo json_encode($response);

        }

        // GET INIDICADOR DE RESULTADOS
        if($_GET["operacion"] == "get-indicador-resultados"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_INDICADORRESULTADO_PRENDA",[
                $_GET["opcion"],$_GET["fecha"],$_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            echo json_encode($response);

        }

        // INDICADOR RESULTADS - DEFECTOS
        if($_GET["operacion"] == "get-indicador-resultados-defectos"){

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_INDRESULTADODEFECTO_PRENDA",[
                $_GET["opcion"],$_GET["idfamdefecto"],$_GET["fecha"],$_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            echo json_encode($response);

        }

        // REPORTE GENERAL
        if($_GET["operacion"] == "getreportegeneral"){


            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETREPORTES_PRENDAS",[
                1,$_GET["fechai"],$_GET["fechaf"],$_GET["sede"],$_GET["tiposervicio"],$_GET["taller"]
            ]);

            $_SESSION["reportegenerallavadoprenda"]  = $response;

            echo json_encode($response);


        }


    }

    // POST
    if(isset($_POST["operacion"])){


        // REGISTRAR VALIDACION DE DOCUMENTOS
        if($_POST["operacion"] == "set-lavadoprenda-validaciondocumento"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETVALIDACIONPRENDAS",$parameters,"Registrado correctamente");
            echo json_encode($response);
        }

        // REGISTRAMOS DEFECTOS 
        if($_POST["operacion"] == "set-lavadoprenda-defectos"){
            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETDEFECTOSPRENDAS",$parameters,"Agregado correctamente");
            echo json_encode($response);
        }

        // CERRAR REGISTRO DE DEFECTOS
        if($_POST["operacion"] == "set-lavadoprenda-cerrardefecto"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_SETCERRARDEFECTO_PRENDAS",$parameters);
            echo json_encode($response);
        }

        // MODIFICAR EL VALOR DE LAS MEDIDAS
        if($_POST["operacion"] == "set-medidas-det"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_UPDATE_MEDIDAS_DETALLE",$parameters,"Modificado correctamente");
            echo json_encode($response);

        }

        // GENERAR MEDIDAS
        if($_POST["operacion"] == "set-generar-medidas"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_SETMEDIDAS",$parameters);
            echo json_encode($response);

        }


        // APERTURA DE FICHAS
        if($_POST["operacion"] == "set-apertura"){

            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETAPERTURA_FICHAS",$parameters,"Realizado correctamente");
            echo json_encode($response);

        }


        // REGISTRO DE MAQUINA DE LAVADO
        if($_POST["operacion"] == "set-maquinas-lavados"){
            $parameters = $_POST["parameters"];
            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETMAQUINAS_PRENDAS",$parameters,"Realizado correctamente");
            echo json_encode($response);
        }


        // REPORTE GENERAL INDICADOR
        if($_POST["operacion"] == "get-reporte-general-indicador"){

            // EXPORTAMOS
            $data = $_POST["data"];
            $data = json_decode($data);  
            $objLavanderiaM->getReporteIndicador_Prendas("Indicador de defectos",$data);

        }


    }



?>