<?php
header("Pragma: public");
header("Expires: 0");
$filename = "Check List Corte - ".$_GET['codfic'].".xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../connection.php");

function process_res($text){
	if ($text=="1") {
		return "SI";
	}else{
		return "NO";
	}
}
function process_resultado($text){
	if ($text=="A") {
		return "Aprobado";
	}else{
		if ($text=="P") {
			return "Pendiente";
		}else{
			if ($text=="" || $text==null) {
				return "-";
			}else{
				return "Rechazado";
			}	
		}	
	}	
}
?>

<h3>CHECK LIST CORTE</h3>
<table>
	<tr>
		<td>Ficha: <?php echo $_GET['codfic']; ?></td>
		<td>Taller: <?php echo $_GET['tal']; ?></td>
	</tr>
	<tr>
		<td>Pedido: <?php echo $_GET['pedido']; ?></td>
		<td>Estilo TSC: <?php echo $_GET['esttsc']; ?></td>
	</tr>
	<tr>
		<td>Estilo Cliente: <?php echo $_GET['estcli']; ?></td>
		<td>Ruta prenda: <?php echo $_GET['ruttel']; ?></td>
	</tr>
	<tr>
		<td>Partida: <?php echo $_GET['partida']; ?></td>
		<td>Cod. Tela: <?php echo $_GET['codtel']; ?></td>
	</tr>
	<tr>
		<td>Color: <?php echo $_GET['color']; ?></td>
		<td>Cant. Pedido: <?php echo $_GET['canpre']; ?></td>
	</tr>
	<tr>
		<td>Cliente: <?php echo $_GET['cli']; ?></td>
		<td></td>
	</tr>
</table>
<?php
    $sql = "EXEC AUDITEX.SP_CLC_SELECT_RESULTADOS @CODFIC = ?, @CODTAD = ?, @NUMVEZ = ?, @PARTE = ?";
    $params = array($_GET['codfic'], $_GET['codtad'], $_GET['numvez'], $_GET['parte']);
    $stmt = sqlsrv_query($conn, $sql, $params);

    $resdoc = "";
    $resten = "";
    $restiz = "";

    if ($stmt) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $resdoc = process_resultado($row['RESDOC']);
            $resten = process_resultado($row['RESTEN']);
            $restiz = process_resultado($row['RESTIZ']);
        }
        sqlsrv_free_stmt($stmt);
    } else {
        echo "Error executing statement.";
    }
?>


<h4>Resultados</h4>
<div>1. Validacion de documentacion: <?php echo $resdoc; ?></div>
<div>2. Validacion del tizado/moldes: <?php echo $restiz; ?></div>
<div>3. Validacion del tendido: <?php echo $resten; ?></div>

<h4>1. Validacion de documentacion</h4>
<table>
	<tr>
		<th style="border:1px #333 solid;">Descripcion</th>
		<th style="border:1px #333 solid;">Resultado</th>
	</tr>
	<?php
// Preparar y ejecutar el procedimiento almacenado
$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHEDOCGUA ?, ?, ?, ?";
$params = array(
    array($_GET['codfic'], SQLSRV_PARAM_IN),
    array($_GET['codtad'], SQLSRV_PARAM_IN),
    array($_GET['numvez'], SQLSRV_PARAM_IN),
    array($_GET['parte'], SQLSRV_PARAM_IN)
);

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Procesar los resultados obtenidos
echo '<table>';
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td style="border:1px #333 solid;">' . utf8_encode($row['DESDOC']) . '</td>';
    echo '<td style="border:1px #333 solid;">' . process_res($row['RESDOC']) . '</td>';
    echo '</tr>';
}
echo '</table>';

// Verificar y mostrar observaciones si existen
if (!empty($_GET['obs1'])) {
    echo '<div>Observacion</div>';
    echo '<div>' . htmlspecialchars($_GET['obs1']) . '</div>';
}

// Limpiar después de la ejecución
sqlsrv_free_stmt($stmt);
?>

<h4>2. Validacion del tizado/moldes</h4>
<table>
	<tr>
		<th style="border:1px #333 solid;">Descripcion</th>
		<th style="border:1px #333 solid;">Veces</th>
		<th style="border:1px #333 solid;">Resultado</th>
	</tr>
	<?php
// Preparar y ejecutar el procedimiento almacenado
$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHETIZGUA ?, ?, ?, ?";
$params = array(
    array($_GET['codfic'], SQLSRV_PARAM_IN),
    array($_GET['codtad'], SQLSRV_PARAM_IN),
    array($_GET['numvez'], SQLSRV_PARAM_IN),
    array($_GET['parte'], SQLSRV_PARAM_IN)
);

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Procesar los resultados obtenidos
echo '<table>';
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td style="border:1px #333 solid;">' . utf8_encode($row['DESTIZ']) . '</td>';
    echo '<td style="border:1px #333 solid;">' . str_replace(",", ".", $row['VECES']) . '</td>';
    echo '<td style="border:1px #333 solid;">' . process_res($row['RESTIZ']) . '</td>';
    echo '</tr>';
}
echo '</table>';

// Verificar y mostrar observaciones si existen
if (!empty($_GET['obs2'])) {
    echo '<div>Observacion</div>';
    echo '<div>' . htmlspecialchars($_GET['obs2']) . '</div>';
}

// Limpiar después de la ejecución
sqlsrv_free_stmt($stmt);
?>

<h4>3. Validacion del tendido</h4>
<table>
	<tr>
		<th style="border:1px #333 solid;">Descripcion</th>
		<th style="border:1px #333 solid;">Resultado</th>
	</tr>
	<?php
// Preparar y ejecutar el procedimiento almacenado
$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHETENGUA ?, ?, ?, ?";
$params = array(
    array($_GET['codfic'], SQLSRV_PARAM_IN),
    array($_GET['codtad'], SQLSRV_PARAM_IN),
    array($_GET['numvez'], SQLSRV_PARAM_IN),
    array($_GET['parte'], SQLSRV_PARAM_IN)
);

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Procesar los resultados obtenidos
echo '<table>';
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo '<tr>';
    echo '<td style="border:1px #333 solid;">' . utf8_encode($row['DESTEN']) . '</td>';
    echo '<td style="border:1px #333 solid;">' . process_res($row['RESTEN']) . '</td>';
    echo '</tr>';
}
echo '</table>';

// Verificar y mostrar observaciones si existen
if (!empty($_GET['obs3'])) {
    echo '<div>Observacion</div>';
    echo '<div>' . htmlspecialchars($_GET['obs3']) . '</div>';
}

// Limpiar después de la ejecución
sqlsrv_free_stmt($stmt);
?>
