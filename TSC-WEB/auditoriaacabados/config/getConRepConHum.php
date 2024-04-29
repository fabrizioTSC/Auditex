<?php
	set_time_limit(480);
	include('connection.php');
	$response=new stdClass();

	function format_value($text){
		$text=str_replace(",",".",$text);
		if ($text[0]==".") {
			return "0".$text;
		}else{
			return $text;
		}
	}

	$html='';
	$sql="BEGIN SP_ACA_SELECT_CONREPCONHUM(:PEDIDO,:COLORES,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':COLORES', $_POST['colores']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$i=1;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$html.=
		'<tr>
			<td>'.$i.'</td>
			<td>'.utf8_encode($row['CODFIC']).'</td>
			<td>'.utf8_encode($row['DSCCOL']).'</td>
			<td>'.utf8_encode($row['FECFINAUD']).'</td>
			<td>'.utf8_encode($row['CODUSU']).'</td>
			<td>'.format_value($row['HUMPRO']).'</td>
			<td><a href="ConsultarAudAca.php?codfic='.utf8_encode($row['CODFIC']).'">Ver reporte</a></td>
		</tr>';
		$i++;
	}

	if (oci_num_rows($OUTPUT_CUR)!=0) {
		$response->state=true;
		$response->html=$html;
	}else{
		$response->state=false;
		$response->detail="No hay fichas disponibles!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>