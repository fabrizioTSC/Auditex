<?php
	include('connection.php');
	$response=new stdClass();

	function format_percent($value){
		$value=str_replace(",",".",$value);
		if ($value[0]==".") {
			return "0".$value;
		}else{
			return $value;
		}
	}

	$sql="BEGIN SP_APNC_SELECT_OBJANIO(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$html=
	'<tbody>
		<tr>
			<th>AÑO</th>
			<th>OBJETIVO</th>
		</tr>';
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$html.=
		'<tr>
			<td>'.$row['ANIO'].'</td>
			<td><input type="number" class="ipt-objanio" id="anio-'.$row['ANIO'].'" value="'.format_percent($row['OBJETIVO']).'"></td>
		</tr>';
	}
	$response->state=true;
	$html.=
	'</tbody>';
	$response->html=$html;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>