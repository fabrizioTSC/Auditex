<?php 

    require_once '../../models/modelo/auditex-audfinal/cargapacking.modelo.php';
    require_once '../../models/modelo/core.modelo.php';
    

    $objCargar = new CargaPackingModelo();
    $objModelo = new CoreModelo();


    if(isset($_POST["operacion"])){


        // CARGAR PACKING
        if($_POST["operacion"] == "cargapacking"){
            
            $archivo            = $_FILES["archivo"]["tmp_name"];
            $valores            = $objCargar->ReadExcel($archivo);
            $datagroup          = $valores["datagroup"];
            $po                 = $_POST["po"];

            // VERIFICAMOS
            // $cargado = $objModelo->get("PQ_PACKINGACABADOS_TMP.SPU_GETDATOSPO",["2",$po]);

            // if($cargado["CANT"] == 0){

                // ELIMINAMOS LO QUE SE CARGO
                $objModelo->setAll("PQ_PACKINGACABADOS_TMP.SPU_SETDATOS",[
                    2,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    $po
                ],"eliminado");


                // REGISTRAMOS LOS DATOS
                foreach($datagroup as $fila){

                    $objModelo->setAll("PQ_PACKINGACABADOS_TMP.SPU_SETDATOS",[
                        1,
                        $fila["pedido"],
                        null,
                        null,
                        null,
                        null,
                        $fila["talla"],
                        null,
                        $fila["color"],
                        $fila["cantidad"],
                        null,
                        null,
                        null,
                        $po
                    ],"registrado");

                }

                // LUEGO DE REGISTRAR MOSTRAMOS DATOS
                $response = $objModelo->getAll("PQ_PACKINGACABADOS_TMP.SPU_GETDATOSPO",["1",$po]);
                echo json_encode(
                    [
                        "estado"    => true,
                        "data"      => $response
                    ]
                );

            // }else{

            //     $data = $objModelo->getAll("PQ_PACKINGACABADOS_TMP.SPU_GETDATOSPO",["1",$po]);


            //     echo json_encode(
            //         [
            //             "estado"    => false,
            //             "mensaje"   => "La PO ya esta cargada",
            //             "data"      => $data
            //         ]
            //     );
            // }





            


        }

        // ACTUALIZAMOS ESTADO A CARGADO
        if($_POST["operacion"] == "confirmarpacking"){

            $parameters = $_POST["parameters"];
            $po         = $parameters[0];

            // ELIMINAMOS LO QUE SE CARGO
            $response = $objModelo->setAll("PQ_PACKINGACABADOS_TMP.SPU_SETDATOS",[
                3,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $po
            ],"Estado confirmado");

            echo json_encode($response);

        }


    }



?>