<?php
	include('connection.php');
	$response=new stdClass();

	$war=[];
	$sql="BEGIN SP_RLE_SELECT_WARDES(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODWARDES=$row['CODWARDES'];
		$obj->DESWARDES=utf8_encode($row['DESWARDES']);
		array_push($war, $obj);
	}
	$response->war=$war;

	$aud=[];
	$sql="BEGIN SP_RLE_SELECT_REPLEAUDITOR(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODAUD=$row['CODAUD'];
		$obj->NOMAUD=utf8_encode($row['NOMAUD']);
		array_push($aud, $obj);
	}
	$response->aud=$aud;

	$sql="BEGIN SP_RLE_SELECT_POPLCAL(:PO,:PACLIS,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->PO=$row['PO'];
		$obj->ESTCLI=$row['ESTCLI'];
		$obj->FECGEN=$row['FECGEN'];
		$obj->FECAPR=$row['FECAPR'];
		$obj->CODUSU=$row['CODUSU'];
		$obj->FORM=utf8_encode($row['FORM']);
		$obj->VERSION=utf8_encode($row['VERSION']);
		$obj->FECHA=$row['FECHA'];
		$obj->VENDOR=utf8_encode($row['VENDOR']);
		$obj->FACTORY=$row['FACTORY'];
		$obj->CODAQL=$row['CODAQL'];
		$obj->CANTIDAD=$row['CANTIDAD'];
		$obj->CODWARDES=$row['CODWARDES'];
		$obj->CANAUD=$row['CANAUD'];
		$obj->CANDEFMAX=$row['CANDEFMAX'];
		$obj->CANDEF=$row['CANDEF'];
		$obj->DESPRE=utf8_encode($row['DESPRE']);
		$obj->DESCOL=utf8_encode($row['DESCOL']);
		$obj->CODAUD=$row['CODAUD'];
		$obj->NUMCAJ=$row['NUMCAJ'];
		$obj->RESULTADO=utf8_encode($row['RESULTADO']);
		$obj->CARINSPULL=utf8_encode($row['CARINSPULL']);
		$obj->CARINSMOISTURE=utf8_encode($row['CARINSMOISTURE']);
		$obj->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
		$obj->AQL=str_replace(",",".",$row['AQL']);
		$obj->NOMAUD=utf8_encode($row['NOMAUD']);

		$obj->CATEGORIA=utf8_encode($row['CATEGORIA']);
		$obj->DESCOLREP=utf8_encode($row['DESCOLREP']);
		$obj->FINALAUDIT=utf8_encode($row['FINALAUDIT']);
		$obj->PREFINAL=utf8_encode($row['PREFINAL']);
		$obj->INLINE=utf8_encode($row['INLINE']);
		$obj->INLINEVEZ=utf8_encode($row['INLINEVEZ']);
		$obj->REAUDIT=utf8_encode($row['REAUDIT']);
		$obj->REAUDITVEZ=utf8_encode($row['REAUDITVEZ']);
		$obj->CERTIFIEDAUD=utf8_encode($row['CERTIFIEDAUD']);
		$obj->TRAINEE=utf8_encode($row['TRAINEE']);
		$obj->PRECERTIFIEDAUD=utf8_encode($row['PRECERTIFIEDAUD']);
		$obj->CORRELATIONAUD=utf8_encode($row['CORRELATIONAUD']);
		$obj->LEAUDITOR=utf8_encode($row['LEAUDITOR']);
		$response->data=$obj;
	}
	$response->state=true;

	$html=
		'<tr>
			<th>Defect Code</th>
			<th>Defect Description</th>
			<th>Qty</th>
			<th>Qty Report</th>
			<th>Corrective Action</th>
		</tr>';
	$sql="BEGIN SP_RLE_SELECT_POPLCALDEF(:PO,:PACLIS,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$html.=
		'<tr>
			<td>'.$row['CODDEFCLI'].'</td>
			<td>'.utf8_encode($row['DESDEF']).'</td>
			<td>'.$row['CANDEF'].'</td>
			<td><input type="number" class="ipt-candefrep" id="def'.$row['CODDEF'].'" value="'.$row['CANDEFREP'].'"></td>
			<td><textarea class="tex-coracti" id="coract'.$row['CODDEF'].'">'.$row['CORRECTIVEACTION'].'</textarea></td>
		</tr>';
	}
	$response->html=$html;

	$htmlcol=
		'<tr>
			<th>Color Description</th>
			<th>Color Code</th>
		</tr>';
	$sql="BEGIN SP_RLE_SELECT_POPLCOL(:PO,:PACLIS,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$htmlcol.=
		'<tr>
			<td>'.utf8_encode($row['DESCOL']).'</td>
			<td><input type="text" class="ipt-descolrep" id="col-'.$row['DESCOL'].'" value="'.utf8_encode($row['DESCOLREP']).'"></td>
		</tr>';
	}
	$response->htmlcol=$htmlcol;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>