<?php
	include('connection.php');
	$response=new stdClass();

	$response->state=true;
	$html=
		'<tr class="table-1">
			<th>Est Cliente</th>
			<th>Prenda</th>
			<th>Color</th>
			<th>Color Rep</th>
			<th>Talla</th>
			<th>Comentarios</th>
		</tr>';
	$sql="BEGIN SP_RLE_SELECT_POPLFOTOSEST(:PO,:PACLIS,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$html.=
		'<tr class="table-1">
			<td class="td-a" onclick="show_estilo(\''.$row['ESTCLI'].'\')">'.$row['ESTCLI'].'</td>
			<td>'.utf8_encode($row['DESPRE']).'</td>
			<td>'.utf8_encode($row['DESCOL']).'</td>
			<td><textarea class="tex-descolrep" id="descolrep'.$row['PO'].'-'.$row['PL'].'-'.$row['ESTCLI'].'">'.utf8_encode($row['DESCOLREP']).'</textarea></td>
			<td>'.utf8_encode($row['DESTAL']).'</td>
			<td><textarea class="tex-coment" id="com'.$row['PO'].'-'.$row['PL'].'-'.$row['ESTCLI'].'">'.utf8_encode($row['COMENTARIOS']).'</textarea></td>
		</tr>';
	}
	$response->html=$html;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>