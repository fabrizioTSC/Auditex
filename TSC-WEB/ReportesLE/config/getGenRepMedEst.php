<?php
	include('connection.php');
	$response=new stdClass();

	function format_tol($case,$value){
		if ($value=="0") {
			return $value;
		}else{
			if ($case==1) {
				return "-".$value;
			}else{
				return "+".$value;
			}
		}
	}
	function change_text($text){
		$tam=strlen($text);
		$new_text='';
		$i=0;
		while($i<$tam){
			if ($text[$i]=='"') {
				$new_text.='*';
			}else{
				$new_text.=$text[$i];
			}
			$i++;
		}
		return $new_text;
	}

	$response->state=true;
	$html=
		'<tr>
			<th>Descripción</th>
			<th>Tol.</th>
			<th>Cod Medida</th>
			<th>Sel</th>
		</tr>';
	$sql="BEGIN SP_RLE_SELECT_POPLMEDESTDET(:PO,:PACLIS,:ESTCLI,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	oci_bind_by_name($stmt, ':ESTCLI', $_POST['estcli']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$check="";
		if ($row['MEDSEL']=="1") {
			$check="checked";
		}
		$html.=
		'<tr>
			<td class="td-a" onclick="show_tallas('.$row['CODMED'].',\''.utf8_encode(change_text($row['DESMED'])).'\')">'.utf8_encode($row['DESMED']).'</td>
			<td>'.format_tol(1,$row['TOLERANCIAMENOS']).' '.format_tol(2,$row['TOLERANCIAMAS']).'</td>
			<td>'.$row['CODMED'].'</td>
			<td><input class="ipt-che" id="che'.$row['CODMED'].'" type="checkbox" '.$check.'/></td>
		</tr>';
	}
	$response->html=$html;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>