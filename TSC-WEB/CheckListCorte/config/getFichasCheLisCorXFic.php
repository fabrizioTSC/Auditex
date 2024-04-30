<?php
include('connection.php');
$response = new stdClass();
$error = new stdClass();

// Para auditoria final de costura
$fichas = array();
$i = 0;

$codfic = $_POST['codfic'];

$sql = "EXEC AUDITEX.SP_CLC_SELECT_FICAUDXCOD ?";
$stmt = sqlsrv_prepare($conn, $sql, array(&$codfic));
$result = sqlsrv_execute($stmt);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	$ficha = new stdClass();
	$ficha->CODFIC = $row['CODFIC'];
	$ficha->CODUSU = $row['CODUSU'];
	$ficha->CODTAD = $row['CODTAD'];
	$ficha->PARTE = $row['PARTE'];
	$ficha->NUMVEZ = $row['NUMVEZ'];
	$ficha->CANPAR = $row['CANPAR'];
	$ficha->PARTIDA = $row['PARTIDA'];
	$ficha->ARTICULO = utf8_encode($row['ARTICULO']);
	$ficha->COLOR = $row['COLOR'];
	$ficha->CODTEL = $row['CODTEL'];
	$ficha->CODENV = $row['CODENV'];
	$fichas[$i] = $ficha;
	$i++;
}

if ($i == 0) {
	$response->state = false;
	$response->description = "No hay fichas!";
} else {
	$response->state = true;
	$response->fichas = $fichas;
}

sqlsrv_close($conn);
header('Content-Type: application/json');
echo json_encode($response);
?>