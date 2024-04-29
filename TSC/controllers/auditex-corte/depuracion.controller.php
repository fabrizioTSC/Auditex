<?php
    session_start();
    // HELLO
    require_once '../../models/modelo/core.modelo.php';
    require_once '../../models/modelo/correos.modelo.php';
    require_once '../../models/modelo/depuracion-corte.modelo.php';

    $objModelo = new CoreModelo();
    $objCorreo = new CorreosModelo();
    $objDepuracionM = new DepuracionCorte();

    if(isset($_GET["operacion"])){


        // DEFECTOS DE LA FICHA
        if($_GET["operacion"] == "getdefectosficha"){

            $id = $_GET["iddepuracion"];

            $response = $objModelo->select("
                SELECT AUDITEX.GETDEFECTOSDEPURACION({$id})DEFECTOS FROM DUAL
            ");

            echo json_encode($response[0]);
        }


        // CABECERA FICHA
        if($_GET["operacion"] == "getficha"){

            $responssige = $objModelo->setAllSQLSIGE("uspCargaPaquetesFichaSige",[$_GET['ficha']],'Correcto');
            // echo json_encode($responssige);


            $response = $objModelo->get("AUDITEX.SPU_GETDEPURACIONFICHA",[
                $_GET["ficha"]
            ]);

            echo json_encode($response);
        }

        // DETALLE FICHA
        if($_GET["operacion"] == "getfichadetalle"){

            // EJECUTAMOS CARGA DE LOS PAQUETES DE CORTE
            // $responssige = $objModelo->setAllSQL("uspCargaPaquetesFichaSige",[$_GET['ficha']],'Correcto');
            // var_dump(json_encode($responssige));

            $response = $objModelo->getAll("AUDITEX.SPU_GETDETALLEDEPURACION",[
                $_GET["ficha"]
            ]);
                
            $cont = 0;
            foreach($response as $fila){

                $cont++;
                $defectoagrupado    = "{$fila['CANTDEFECTOS']} - {$fila['SUMADEFECTOS']}";
                $defectoagrupado    = $defectoagrupado != "0 - " ? $defectoagrupado : " - ";
                $observacion        =  substr($fila['OBSERVACION'],0,10);
                // $defectoagrupado = $defectoagrupado == " - " ? "" : $defectoagrupado;
                $tonoc = $fila['TONOC'] == "" ? "0" : $fila["TONOC"];
                $tonob = $fila['TONOB'] == "" ? "0" : $fila["TONOB"];

                echo "<tr>";
                echo "<td>{$cont}</td>";
                echo "<td>{$fila['ORDEM_CONFECCAO']} </td>";
                echo "<td>{$fila['DESCR_TAMANHO']} </td>";
                echo "<td>{$fila['QTDE_PECAS_PROG']} </td>";
                echo "<td>  
                        <div class='w-75 h-100 float-left'> $defectoagrupado </div>";

                if($_GET["estado"] != "1"){
                    echo "
                    <div class='w-25 h-100 float-left'>
                        <button data-numeropaquete='{$fila['ORDEM_CONFECCAO']}' data-correlativo='{$cont}' data-idpaquete='{$fila['IDDEPURACIONPAQ']}' class='bg-danger adddefecto inhabilitar' type='button'> <i class='fas fa-plus' style='color:white'></i> </button>
                    </div>
                    ";
                }        

                // if($fila["ESTADO"] != "1"){
                    
                // } 

                        
                echo "</td>";
                echo "<td class='maxdefectos{$cont}'>{$fila['SUMADEFECTOS']}</td>";
                echo "<td> 
                    <div class='w-75 h-100 float-left addtonos addtonosC{$cont}' data-tipo='1' data-tono='C'  data-fila='{$cont}' style='cursor:pointer'>{$tonoc}</div> ";
                    if($_GET["estado"] != "1"){
                        echo "
                        <div class='w-25 h-100 float-left'>
                            <button  data-idpaquete='{$fila['IDDEPURACIONPAQ']}' data-fila='{$cont}' data-tono='C' class='bg-danger addtonos inhabilitar' data-tipo='-1' type='button'> 
                                <i class='fas fa-minus fa-xs' style='color:white'></i> 
                            </button>
                        </div>";
                    } 
                    
                echo "</td>";
                echo "<td>
                    <div class='w-75 h-100 float-left addtonos addtonosD{$cont}' data-tipo='1' data-tono='D' data-fila='{$cont}' style='cursor:pointer'>{$tonob}</div> ";

                    if($_GET["estado"] != "1"){
                        echo "<div class='w-25 h-100 float-left'>
                            <button  data-idpaquete='{$fila['IDDEPURACIONPAQ']}' data-fila='{$cont}' data-tono='D' class='bg-danger addtonos inhabilitar' data-tipo='-1' type='button'> 
                                <i class='fas fa-minus' style='color:white'></i> 
                            </button>
                        </div>";
                    } 

                    
                echo "</td>";
                echo "<td>{$fila['USUARIO']} </td>";
                echo "<td class='addobservacion' style='cursor:pointer;white-space:nowrap;text-overflow: ellipsis;' data-observacion='{$fila['OBSERVACION']}' data-idpaquete='{$fila['IDDEPURACIONPAQ']}'> {$observacion} </td>";
                echo "</tr>";

            }

            // echo json_encode($response);

        }

        // DEFECTOS SEGUN PAQUETE
        if($_GET["operacion"] == "getdefectospaquete"){

            $response = $objModelo->getAll("AUDITEX.SPU_GETDEFECTOSPAQUETES",[
                $_GET["idpaquete"]
            ]);

            $cont= 0;
            foreach($response as $fila){
                $cont++;
                echo "<tr>";
                echo "<td>{$fila['DESDEF']}</td>";
                echo "
                <td >
                    <button type='button' class='btnoperacion' data-fila='{$cont}' data-id='{$fila['IDDEPURACIONDEF']}' data-op='1'>  <i class='fas fa-plus'></i> </button>
                    <button type='button' class='filadef{$cont}'> {$fila['CANTIDAD']}</button>
                    <button type='button' class='btnoperacion' data-fila='{$cont}' data-id='{$fila['IDDEPURACIONDEF']}' data-op='-1'> <i class='fas fa-minus'></i> </button>
                </td>";
                echo "<td>
                    <button class='btn btn-sm btn-info m-0 btnguardar' type='button' data-fila='{$cont}' data-id='{$fila['IDDEPURACIONDEF']}'> <i class='fas fa-save'></i>  </button>
                </td>";
                echo "</tr>";
            }
        }

        // GET RESUMEN FICHA DEPURACION
        if($_GET["operacion"] == "getresumenfichadepuracion"){

            $response = $objModelo->getAll("AUDITEX.SPU_GETRESUMENDEPURACION",[
                $_GET["ficha"]
            ]);

            $total = 0;
            foreach($response as $fila){
                // $cont++;
                echo "<tr>";
                    echo "<td>{$fila['DESCR_TAMANHO']}</td>";
                    echo "<td>{$fila['SUMADEFECTOS']}</td>";
                echo "</tr>";
                $total +=  $fila['SUMADEFECTOS'];
            }

            echo "<tr>";
                echo "<td class='font-weight-bold'>TOTAL:</td>";
                echo "<td class='font-weight-bold'>{$total}</td>";
            echo "</tr>";
        }

        // DEFECTOS QUE NO ESTN REGISTRADOS EN UN PAQUETE
        if($_GET["operacion"] == "getdefectosnotinpaquete"){
            $response = $objModelo->getAll("AUDITEX.SPU_GETDEFECTOSNOTINPAQUETES",[
                $_GET["idpaquete"]
            ]);

            echo json_encode($response);
        }

    }

    //  POST
    if(isset($_POST["operacion"])){ 

        // REGISTRAMOS DEPURACION
        if($_POST["operacion"] == "setdepuracion"){

            $parameters = $_POST["parameters"];
            // CAMBIAMOS VARIABLE DE USUARIO
            $parameters[2] = $_SESSION["user"];

            $response = $objModelo->get("AUDITEX.SPU_SETDEPURACION",$parameters);
            echo json_encode($response);
        }

        // REGISTRAMO DEFECTOS
        if($_POST["operacion"] == "setdefectosdepuracion"){

            $parameters = $_POST["parameters"];

            $response = $objModelo->setAll("AUDITEX.SPU_SETDEFECTOPAQ",$parameters,"Defecto registrado");
            echo json_encode($response);

        }

        // REGISTRAMO PAQUETES
        if($_POST["operacion"] == "setpaquetesdepuracion"){

            $parameters = $_POST["parameters"];
            $parameters[3] = $_SESSION["user"];

            $response = $objModelo->get("AUDITEX.SPU_SETPAQUETEDEP",$parameters);
            echo json_encode($response);

        }

        // ELIMINAMOS DEFECTO
        if($_POST["operacion"] == "deletedefecto"){

            $parameters = $_POST["parameters"];

            $response = $objModelo->setAll("AUDITEX.SPU_DELETEDEFECTODEPU",$parameters,"Eliminado");
            echo json_encode($response);

        }

        // ENVIAR CORREO
        if($_POST["operacion"] == "setcorreo"){
            
            $ficha = $_POST["parameters"][0];

            // ACTUALIZAMOS ESTADO DE LA FICHA EN LA TABLA DE DEPURACION
            $reponseup          = $objModelo->setAll("AUDITEX.SPU_UPESTADODEPURACION",[$ficha,$_SESSION["user"]],"Correcto");

            // DATOS DE LA FICHA PARA EL CORREO
            $datoscorreo        = $objModelo->get("AUDITEX.SPU_GETDEPURACIONCORREO",[$ficha,$_SESSION["user"]]);

            // DATOS PARA CORREO
            $datoscorreo1   = $objModelo->getAll("AUDITEX.SPU_SETCORREO1",[$ficha]);
            $datoscorreo2   = $objModelo->get("AUDITEX.SPU_SETCORREO2",[$ficha]);
            $datoscorreo3   = $objModelo->getAll("AUDITEX.SPU_SETCORREO3",[$ficha]);

            // RESUMEN DE DEFECTOS SEGUN FICHA
            $resumendefectos          = $objModelo->getAll("AUDITEX.SPU_DEPURACION_RESUMEN_DEF",[$ficha]);



            // CORREOS
            $correosenviar      = $objModelo->getAll("AUDITEX.SPU_GETCORREOSENVIO",[1]);

            $tablaresumen  = $objDepuracionM->getResumenDepuracion($datoscorreo1,$datoscorreo2["MAXPAQ"],$datoscorreo3);
            $tabladefectos = $objDepuracionM->getResumenDefectos($resumendefectos);
            $cuerpocorreo  = $objDepuracionM->getCuerpoCorreo($datoscorreo,$tablaresumen,$tabladefectos);
            $correosarray  = $objDepuracionM->getUsersCorreo($correosenviar,$datoscorreo['CODCLI']);

            $remitente = array_values($correosarray["remitente"]);

            // echo $cuerpocorreo;

            $response = $objCorreo->EnviarCorreo(
                $remitente[0]["CORREO"]     ,       // USUARIO ENVIA CORREO
                $remitente[0]["CLAVE"]      ,       // CLAVE ENVIA CORREO
                "Depuracion Ficha {$datoscorreo['FICHA']}"  ,       // ASUNTO
                $cuerpocorreo,                                      // CUERPO CORREO
                $correosarray["destinatario"],                      // DESTINATARIOS, 
                $correosarray["copiado"],                           // COPIADOS 
                "Depuración de corte"                               // ALIAS USUARIO ENVIA
            );

            echo json_encode($response);

        }

    }

?>