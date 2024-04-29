
<?php
session_start();

require_once '../../models/modelo/core.modelo.php';
// require_once '../../models/modelo/gestion-produccion/gestion-produccion.modelo.php'; 



$objModelo = new CoreModelo(); 
  
    // METODO GET
    if (isset($_GET["operacion"])) {

        // Listar Grilla Principal
        if ($_GET["operacion"] == "getreporte") {  
            $partida = $_GET["partida"]; 
            $response = $objModelo->getAll("AUDITEX.SP_AUDITEL_REP_UPDATETELA", [  
                $partida
            ]);

            $_SESSION["tmppartida"] = $response; 

            foreach ($response as $item) {
 
                $check = "";

                if ($check == "1") {
                    $check = "<input    class='checkprueba' 
                                        data-partida='{$item['PARTIDA']}'
                                        data-vez='{$item['NUMVEZ']}' 
                                        data-parte='{$item['PARTE']}' 
                                        type='checkbox' checked='true' />";
                } else {
                    $check = "<input    class='checkprueba'
                                        data-partida='{$item['PARTIDA']}'
                                        data-vez='{$item['NUMVEZ']}' 
                                        data-parte='{$item['PARTE']}' 
                                        type='checkbox'  />";
                }

                // Nombre del campo de mi SP
                echo "<tr>"; 
                echo "<td class='font10'>{$check}";
                echo "<td class='font10'>{$item['PARTIDA']}</td>";  
                echo "<td class='font10'>{$item['NUMVEZ']}</td>"; 
                echo "<td class='font10'>{$item['PARTE']}</td>";
                echo "<td class='font10'>{$item['CODTEL']}</td>";
                echo "<td class='font10'>{$item['SITUACION']}</td>";
                echo "<td class='font10'>{$item['COLOR']}</td>";
                echo "<td class='font10'>{$item['DESPRV']}</td>"; 
                echo "<td class='font10'>{$item['RUTA']}</td>";
                echo "<td class='font10'>{$item['ARTICULO']}</td>";
                echo "<td class='font10'>{$item['COMPOSICION']}</td>";
                echo "<td class='font10'>{$item['RENDIMIENTO']}</td>";
                echo "<td class='font10'>{$item['PESO']}</td>";
                echo "<td class='font10'>{$item['PROGRAMA']}</td>";
                echo "<td class='font10'>{$item['X_FACTORY']}</td>";
                echo "</tr>";
            }

        }
  
        // Actualiza molde disponible 

        if ($_GET["operacion"] == "set-actualizarfechatela") {
            $partida = $_GET["partida"];
            $vez = $_GET["vez"];
            $parte = $_GET["parte"];
            $fecha = $_GET["fecha"];
            $usuario = $_SESSION["user"];
            $response = $objModelo->setAll("AUDITEX.SPSET_UPDATE_FECHASTELAS", [
                $partida, $vez, $parte, $fecha, $usuario
            ], 'Registro actualizado correctamente.');
        }
    }
?> 