<?php
	include('connection.php');
	$response=new stdClass();

	$fichas=array();
	$html='';
	$sql="BEGIN SP_ACH_SELECT_FICCONHUM(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->NUMVEZ=$row['NUMVEZ'];
		$obj->PARTE=$row['PARTE'];
		$obj->CODUSU=$row['CODUSU'];
		$obj->CANTIDAD=$row['CANTIDAD'];
		array_push($fichas, $obj);
		$html.=
		'<tr onclick="show_consulta_ficha('.$row['NUMVEZ'].','.$row['PARTE'].')">
			<td>'.$row['DESCLI'].'</td>
			<td>'.str_replace(",",".",$row['HUMMAX']).'%</td>
			<td>'.$row['CODUSU'].'</td>
			<td>'.$row['FECINIAUDF'].'</td>
			<td>'.str_replace(",",".",$row['HUMPRO']).'%</td>
			<td>'.$row['CANDEF'].'</td>
			<td>'.$row['CANTIDAD'].'</td>
		</tr>';
	}
	$response->fichas=$fichas;
	$response->html=$html;
	if (oci_num_rows($stmt)==0) {			
		$response->state=false;
		$response->detail="Ficha no encontrada!";
	}else{
		$response->state=true;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>