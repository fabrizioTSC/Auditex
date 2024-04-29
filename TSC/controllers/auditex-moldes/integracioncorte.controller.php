<?php
    session_start();

    require_once '../../models/modelo/core.modelo.php';
    require_once '../../models/modelo/sistema.modelo.php';




    $objModelo  = new CoreModelo();
    // $objSistema = new SistemaModelo();
    // $objTestingIndicadorModelo = new TestingIndicadorModelo();


    // _GET
    if(isset($_GET["operacion"])){

        // INDICADOR GENERAL
        if($_GET["operacion"] == "getencogimientos"){


            $ficha      = $_GET["ficha"];
            $archivo   = $_GET["archivo"];


            // $parameters = $_POST["parameters"];
            $response = $objModelo->get("AUDITEX.SPU_GETENCOGIMIENTOMOLDES",
                [$ficha]
            );

            // var_dump($response);

            echo "<table>";

            // CABECERA
            echo "<thead>";

            echo "<tr>";
            echo "<th>HILO</th>";
            echo "<th>TRAVEZ</th>";
            echo "<th>LARG. MANGA</th>";
            echo "<th>OPERACIÓN</th>";
            echo "</tr>";


            echo "</thead>";

            // CUERPO
            echo "<tbody>";

                if($response){


                    // SI NO TIENE ASIGNADO
                    if($response["MOLDE_USAR_HILO"] == "" && $response["MOLDE_USAR_TRAMA"] == "" ){

                        echo "<tr>";

                        echo "<td colspan='4'>SIN ASIGNACIÓN DE MOLDES</td>";
    
                        echo "</tr>";

                    }else{

                        $hiloUsar   = $response['MOLDE_USAR_HILO'];
                        $tramaUsar  = $response['MOLDE_USAR_TRAMA'];
                        $mangaUsar  = $response['MOLDE_USAR_MANGA'];

                        $hiloUsar   = $hiloUsar != null ? str_replace(",", ".", $hiloUsar) : $hiloUsar;
                        $tramaUsar  = $tramaUsar != null ? str_replace(",", ".", $tramaUsar) : $tramaUsar;
                        $mangaUsar  = $mangaUsar != null ? str_replace(",", ".", $mangaUsar) : $mangaUsar;



                        echo "<tr>";
    
                        echo "<td>{$hiloUsar} </td>";
                        echo "<td>{$tramaUsar} </td>";
                        echo "<td>{$mangaUsar} </td>";
                        echo "<td>
                                <a href='{$archivo}.php?codfic={$ficha}&hilo={$hiloUsar}&travez={$tramaUsar}&largmanga={$mangaUsar}'>VER AUD</a>
                        </td>";
    
                        echo "</tr>";
                    }


                }else{

                    echo "<tr>";

                    echo "<td colspan='4'>SIN REGISTRO DE MOLDES</td>";

                    echo "</tr>";


                }

                

            echo "</tbody>";






            echo "</table>";



            // $_SESSION["indicadorgeneral_moldes"] = $response;
            // echo json_encode($response);

        }

      


    }



?>        