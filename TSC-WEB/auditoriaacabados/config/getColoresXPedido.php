<?php
	set_time_limit(480);
	include('connection.php');
	$response=new stdClass();

	$html='';
	$sql="BEGIN SP_ACA_SELECT_COLSXPED(:PEDIDO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$html.=
		'<tr>
			<td>'.utf8_encode($row['DSCCOL']).'</td>
			<td class="td-c"><input type="checkbox" id="che-'.utf8_encode($row['DSCCOL']).'" class="ipt-check"></td>
		</tr>';
	}

	if (oci_num_rows($OUTPUT_CUR)!=0) {
		$response->state=true;
		$response->html=$html;
	}else{
		$response->state=false;
		$response->detail="No hay colores disponibles!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>