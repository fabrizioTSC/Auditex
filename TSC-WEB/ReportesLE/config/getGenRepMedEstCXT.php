<?php
	include('connection.php');
	$response=new stdClass();

	$response->state=true;

	$sql="BEGIN SP_RLE_SELECT_MEDPUL(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$select='<select change_id>';
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$select.='<option value="'.$row['VALPUL'].'">'.$row['VALPUL'].'</option>';
	}
	$select.='</select>';

	$html=
		'<tr>
			<th>Color</th>
			<th>Desviación</th>
			<th>Desv. Rep.</th>
			<th>Sel</th>
		</tr>';
	$sql="BEGIN SP_RLE_SELECT_POPLMEDESTCXT(:PO,:PACLIS,:ESTCLI,:CODMED,:CODTAL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	oci_bind_by_name($stmt, ':ESTCLI', $_POST['estcli']);
	oci_bind_by_name($stmt, ':CODMED', $_POST['codmed']);
	oci_bind_by_name($stmt, ':CODTAL', $_POST['codtal']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$check="";
		if ($row['MEDDETSEL']=="1") {
			$check="checked";
		}
		$select_replace='id="sel-'.$row['NUMPRE'].'-'.utf8_encode($row['DESCOL']).'"';
		$new_select=str_replace('change_id',$select_replace, $select);
		$new_select=str_replace('value="'.$row['VALORREP'].'"','value="'.$row['VALORREP'].'" selected', $new_select);
		$html.=
		'<tr>
			<td>'.utf8_encode($row['DESCOL']).'</td>
			<td>'.$row['VALOR'].'</td>
			<td>'.$new_select.'</td>
			<td><input class="ipt-col" id="col-'.$row['NUMPRE'].'-'.utf8_encode($row['DESCOL']).'" type="checkbox" '.$check.'/></td>
		</tr>';
	}
	$response->html=$html;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>