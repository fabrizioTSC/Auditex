<?php
    session_start();

    require_once '../../models/modelo/core.modelo.php';
    // require_once '../../models/modelo/sistema.modelo.php';



    $objModelo  = new CoreModelo();
    // $objSistema = new SistemaModelo();


    // GET
    if(isset($_GET["operacion"])){


        if( $_GET["operacion"] == "set-ficha" ) {

            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_SETLAVADOPANIOCORTE",[
                $_GET["opcion"],$_GET["ficha"],$_GET["usuario"]
            ]);
            echo json_encode($response);

        }

        if( $_GET["operacion"] == "verificapano" ) {

            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_VERIFICAPANO",[
                $_GET["ficha"]
            ]);
            echo json_encode($response);

        }
      
    }


    // post
    if(isset($_POST["operacion"])){


        if( $_POST["operacion"] == "set-ficha" ) {

            $parameters = $_POST["parameters"];
            $response = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_SETLAVADOPANIOCORTE",$parameters);
            echo json_encode($response);

        }
      

        // REGISTRO DE ETAPAS
        if($_POST["operacion"] == "set-etapas"){

            $parameters = $_POST["parameters"];

            $response = $objModelo->setAll("AUDITEX.PQ_LAVANDERIA.SPU_SETETAPAS_PANOS",$parameters,"Realizado correctamente");
            echo json_encode($response);

        }

        // REGISTRO DE TONOS
        if($_POST["operacion"] == "set-tonos"){

            $parameters = $_POST["parameters"];

            $response = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_SETETAPASTONOS_PANOS",$parameters);

            // SI ES PARA MOSTRAR LOS TONOS
            if($parameters[0] == 3){

                foreach($response as $fila){

                    echo "<div class='col-3 mb-1'>";
                    echo "      <a class='btn btn-sistema btn-block btn-sm cursor-pointer tonosquitar' title='Quitar Tono' 
                            data-id='{$fila['IDTONO']}' 
                            data-idetapa='{$fila['IDETAPA']}'
                            data-etapa='{$fila['ETAPA']}'
                            >";
                    echo "          {$fila['TONO']} ";
                    echo "      </a>";
                    echo "</div> ";

                }

            }else{
                echo json_encode($response);                
            }

        }

    }

?>        