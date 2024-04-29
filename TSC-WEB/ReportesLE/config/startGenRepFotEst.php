<?php
	include('connection.php');
	$response=new stdClass();

	$response->state=true;
	$html=
		'<tr>
			<th>Foto</th>
			<th>Est Cliente</th>
			<th>Pedido</th>
			<th>Color</th>
			<th>Bloque</th>
			<th>Parte</th>
			<th>Vez</th>
			<th>Obs Imagen</th>
			<th>Titulo Rep</th>
			<th>Sel</th>
		</tr>';
	$sql="BEGIN SP_RLE_SELECT_POPLFOTOSREP(:PO,:PACLIS,:ESTCLI,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	oci_bind_by_name($stmt, ':ESTCLI', $_POST['estcli']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$check='';
		if($row['SELREPORTE']=="1"){
			$check='checked';
		}
		$url='http://textilweb.tsc.com.pe:81/tsc-web/auditoriafinal/assets/imgcalint/';
		if($row['BLOQUE']=="2"){
			$url='http://textilweb.tsc.com.pe:81/tsc-web/auditoriafinal/assets/imgconhum/';
		}
		$html.=
		'<tr>
			<td><img src="'.$url.$row['RUTIMA'].'"/></td>
			<td>'.$row['ESTCLI'].'</td>
			<td>'.$row['PEDIDO'].'</td>
			<td>'.utf8_encode($row['DESCOL']).'</td>
			<td>'.$row['DESBLOQUE'].'</td>
			<td>'.$row['PARTE'].'</td>
			<td>'.$row['NUMVEZ'].'</td>
			<td>'.$row['OBSIMAGEN'].'</td>
			<td><input class="ipt-tex" id="tex'.$row['PEDIDO'].';'.$row['DESCOL'].';'.$row['RUTIMA'].'" type="text" value="'.$row['TITULO'].'"/></td>
			<td><input class="ipt-che" id="che'.$row['PEDIDO'].';'.$row['DESCOL'].';'.$row['RUTIMA'].'" type="checkbox" '.$check.'/></td>
		</tr>';
	}
	$response->html=$html;

	$sql="BEGIN SP_RLE_SELECT_POPLFOTOSESTREP(:PO,:PACLIS,:ESTCLI,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	oci_bind_by_name($stmt, ':ESTCLI', $_POST['estcli']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->PO=$row['PO'];
		$obj->PL=$row['PL'];
		$obj->ESTCLI=$row['ESTCLI'];
		$obj->DESPRE=utf8_encode($row['DESPRE']);
		$obj->DESCOL=utf8_encode($row['DESCOL']);
		$obj->DESCOLREP=utf8_encode($row['DESCOLREP']);
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$obj->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
		$obj->FORM=utf8_encode($row['FORM']);
		$obj->VERSION=utf8_encode($row['VERSION']);
		$obj->FECHA=$row['FECHA'];
		$obj->VENDOR=utf8_encode($row['VENDOR']);
		$obj->CODAUD=$row['CODAUD'];
		$response->data=$obj;
	}
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>