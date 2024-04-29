<?php
	include('connection.php');
	$response=new stdClass();

	$response->state=true;
	$html1='<th>Talla</th>';
	$html2='<td>Medida</td>';
	$sql="BEGIN SP_RLE_SELECT_POPLMEDESTTXM(:PO,:PACLIS,:ESTCLI,:CODMED,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	oci_bind_by_name($stmt, ':ESTCLI', $_POST['estcli']);
	oci_bind_by_name($stmt, ':CODMED', $_POST['codmed']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$html1.='<th>'.utf8_encode($row['DESTAL']).'</th>';
		$html2.='<td class="td-a" onclick="show_colors(\''.$row['CODTAL'].'\',\''.utf8_encode($row['DESTAL']).'\')">'.$row['MEDIDA'].'</td>';
	}
	$response->html='<tr>'.$html1.'</tr><tr>'.$html2.'</tr>';
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>