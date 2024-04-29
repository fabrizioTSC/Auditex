<?php
	include('connection.php');
	$response=new stdClass();

	$table='';
	$sql="BEGIN SP_AFC_SELECT_ENCOGIMIENTO(:ESTTSC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$table.=
		'<tr onclick="show_medidas(\''.str_replace(",",".",$row['HILO']).'\',\''.str_replace(",",".",$row['TRAVEZ']).'\',\''.str_replace(",",".",$row['LARGMANGA']).'\')">
			<td>'.str_replace(",",".",$row['HILO']).'</td>
			<td>'.str_replace(",",".",$row['TRAVEZ']).'</td>
			<td>'.str_replace(",",".",$row['LARGMANGA']).'</td>
		</tr>';
	}
	if (oci_num_rows($OUTPUT_CUR)!=0) {
		$response->state=true;
		$response->detail=$table;
	}else{
		$response->state=false;
		$response->detail='No hay encogimientos';
	}	

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>