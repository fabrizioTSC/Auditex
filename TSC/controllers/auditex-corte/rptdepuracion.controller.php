<?php
    session_start();

    require_once '../../models/modelo/core.modelo.php';
    require_once '../../models/modelo/auditex-corte/depuracionpiezas.modelo.php';



    $objModelo = new CoreModelo();
    $objDepuracionM = new DepuracionPiezasModelo();


    if(isset($_GET["operacion"])){
        if($_GET["operacion"] == "getreportegeneral"){
            $sede = $_GET["sede"];
            $tiposervicio = $_GET["tiposervicio"];
            $proveedor = $_GET["proveedor"];
            $taller = $_GET["taller"];
            $cliente = $_GET["cliente"];
            $articulo = $_GET["articulo"];
            $programa = $_GET["programa"];
            $ficha = $_GET["ficha"];
            $color = $_GET["color"];
            $fechai = $_GET["fechai"];
            $fechaf = $_GET["fechaf"];
            $codtela = $_GET["codtela"];

            $response = $objModelo->getAll("AUDITEX.DEPURACION_GETREPORTGENERAL",[
                $sede,      $tiposervicio,  $proveedor,
                $taller,    $cliente,       $articulo,
                $programa,  $ficha,         $color,
                $fechai,    $fechaf,        $codtela
            ]); 

            // GUARDAMOS EN TEMPORAL
            $_SESSION["reportedepuracionpiezas"] = $response;

            // TOTALES
            $totalficha         = 0;    
            $totaldepurada      = 0;        
            $totalkgdepurada    = 0;      
            $totalporcentaje    = 0;      


            if($response){
                //
                $cont = 0;
                // FOR EACH
                foreach($response as $fila){
                    $cont++;
                    $peso           = (float)$fila['PESO'];
                    $fechainicio    = date("d/m/Y", strtotime($fila['FINICIO']));
                    $fechafin       = $fila['FFIN'];
                    $fechafin       = $fechafin != "" ? date("d/m/Y", strtotime($fila['FFIN'])) : ""; 

                    $porcentaje = (float)$fila['PIEZASDEP']  / (float)$fila['CANTFICHA'];
                    $porcentaje = $porcentaje * 100;
                    $porcentaje = round($porcentaje,2);

                    $totalficha         +=  (float)$fila['CANTFICHA'];
                    $totaldepurada      +=  (float)$fila['PIEZASDEP'];
                    $totalkgdepurada    +=  $peso;
                    // $totalporcentaje    += $porcentaje;


                    $cantficha = number_format($fila['CANTFICHA']);

                    echo "<tr>";
                    echo "<td>{$cont}</td>";
                    echo "<td>{$fila['FICHA']}</td>";
                    echo "<td>{$fila['CLIENTE']}</td>";
                    echo "<td>{$fila['PEDIDO_VENDA']}</td>";
                    echo "<td>{$fila['ESTILOCLIENTE']}</td>";
                    echo "<td>{$fila['ESTILOTSC']}</td>";
                    echo "<td>{$fila['COLOR']}</td>";
                    echo "<td>{$fila['PARTIDA']}</td>";
                    echo "<td>{$fila['PROGRAMA']}</td>";
                    echo "<td>{$cantficha}</td>";
                    // echo "<td>{$fila['CANTFICHA']}</td>";
                    echo "<td>{$fechainicio}</td>";
                    echo "<td>{$fechafin}</td>";
                    echo "<td>{$fila['PIEZASDEP']}</td>";
                    echo "<td>{$fila['DEFECTOS']}</td>";
                    echo "<td>{$peso}</td>";
                    echo "<td>{$porcentaje}%</td>";
                    echo "<td>{$fila['USUARIO']}</td>";
                    echo "</tr>";
                }


                $totalporcentaje = $totaldepurada / $totalficha;
                $totalporcentaje = $totalporcentaje * 100;
                $totalporcentaje = round($totalporcentaje,2);


                $totalficha = number_format($totalficha);
                $totaldepurada = number_format($totaldepurada);


                // TOTALES
                echo "<tr style='font-size:15px !important;'>";
                echo "<td colspan='9' class='bg-primary text-white font-weight-bold' style='vertical-align:middle' >TOTAL</td>";

                echo "<td style='display: none;' ></td>";
                echo "<td style='display: none;' ></td>";
                echo "<td style='display: none;' ></td>";
                echo "<td style='display: none;' ></td>";
                echo "<td style='display: none;' ></td>";
                echo "<td style='display: none;' ></td>";
                echo "<td style='display: none;' ></td>";
                echo "<td style='display: none;' ></td>";

                echo "<td class='bg-success text-white font-weight-bold' style='vertical-align:middle'>{$totalficha}</td>";
                echo "<td colspan='2' class='bg-primary text-white font-weight-bold' style='vertical-align:middle'>Sumatoria de piezas depuradas</td>";
                echo "<td style='display: none;' ></td>";
                echo "<td class='bg-success text-white font-weight-bold' style='vertical-align:middle'>{$totaldepurada}</td>";
                echo "<td class='bg-success text-white font-weight-bold' style='vertical-align:middle'></td>";
                echo "<td class='bg-success text-white font-weight-bold' style='vertical-align:middle'>{$totalkgdepurada}</td>";
                echo "<td class='bg-success text-white font-weight-bold' style='vertical-align:middle'>{$totalporcentaje}%</td>";
                echo "<td ></td>";
                echo "</tr>";

            }
        }
    }

    // POST
    if(isset($_POST["operacion"])){

        // REPORTE
        if($_POST["operacion"] == "setexportardepuracion"){

            $objDepuracionM->getExcel("reportedepuracionpiezas",$_SESSION["reportedepuracionpiezas"]);
        }

    }

?>        