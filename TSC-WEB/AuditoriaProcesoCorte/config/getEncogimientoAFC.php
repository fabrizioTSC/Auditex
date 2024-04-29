<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AFC_VAL_DESORDEN(:ESTTSC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	if (oci_num_rows($OUTPUT_CUR)!=0) {
		$response->desorden=true;
	}else{
		$response->desorden=false;
	}

	$head=
	'<tr>
		<th>COD.</th>
		<th>DESCRIPCIÓN</th>
		<th>P/C</th>
		<th>CRITICA</th>
		<th>MARGEN (1)</th>
		<th>MARGEN (2)</th>';
	$hc=0;
	$sql="BEGIN SP_AFC_SELECT_ENCHEAD(:ESTTSC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':HILO', $_POST['hilo']);
	oci_bind_by_name($stmt, ':TRAVEZ', $_POST['travez']);
	oci_bind_by_name($stmt, ':LARGMANGA', $_POST['largmanga']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$head.=
		'<th>'.$row['DESTAL'].'</th>';
		$hc++;
	}
	$head.=
	'</tr>';


	$body='';
	$i=0;
	$j=0;
	$sql="BEGIN SP_AFC_SELECT_ENCBODY(:ESTTSC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':HILO', $_POST['hilo']);
	oci_bind_by_name($stmt, ':TRAVEZ', $_POST['travez']);
	oci_bind_by_name($stmt, ':LARGMANGA', $_POST['largmanga']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		if ($i==0) {
			if ($j!=0) {
				$body.=
		'</tr>';
			}
			$j++;
			$body.=
		'<tr>
			<td>'.utf8_encode($row['DESMEDCOR']).'</td>
			<td>'.utf8_encode($row['DESMED']).'</td>
			<td>'.$row['PARTE'].'</td>
			<td>'.$row['AUDITABLE'].'</td>
			<td>'.$row['TOLERANCIAMENOS'].'</td>
			<td>'.$row['TOLERANCIAMAS'].'</td>';
		}
		$body.=
			'<td>'.$row['MEDIDA'].'</td>';
		$i++;
		if ($i==$hc) {
			$i=0;
		}
	}
	if (oci_num_rows($stmt)!=0) {
		$response->state=true;
		$response->body=$body;
		$response->head=$head;
	}else{
		$response->state=false;
		$response->detail='No hay encogimiento';
	}	

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>