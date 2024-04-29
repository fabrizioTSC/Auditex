<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_PCVA_UPDATE_ENDVERCAJLOVEZ(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:LOTE,:NUMVEZLOTE,:RES); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':COLOR',$_POST['color']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':LOTE',$_POST['lote']);
	oci_bind_by_name($stmt,':NUMVEZLOTE',$_POST['numvezlote']);
	oci_bind_by_name($stmt,':RES',$res,40);
	$result=oci_execute($stmt);
	$res=trim($res);
	$response->res=$res;

	if ($result) {
		if ($res=="0") {
			$response->state=false;
			$response->detail="No se pudo terminar el lote, hay cajas pendientes o no habian cajas para terminar este lote";
		}else{
			$lotes=[];
			$sql="BEGIN SP_PCVA_SELECT_LISTALOTE(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
			oci_bind_by_name($stmt,':COLOR',$_POST['color']);
			oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				$obj=new stdClass();
				$obj->NROLOTE=$row['NROLOTE'];
				$obj->NUMVEZLOTE=$row['NUMVEZLOTE'];
				$obj->DESCEL=utf8_encode($row['DESCEL']);
				$obj->NUMCAJLOTE=$row['NUMCAJLOTE'];
				$obj->NUMCAJAUDLOTE=$row['NUMCAJAUDLOTE'];
				$obj->ESTADO=$row['ESTADO'];
				$obj->RESULTADO=$row['RESULTADO'];
				$obj->CODUSU=$row['CODUSU'];
				$obj->FECINI=$row['FECINI'];
				$obj->FECFIN=$row['FECFIN'];
				array_push($lotes,$obj);
			}
			$response->lotes=$lotes;
			$response->state=true;
			if ($res=="A") {
				$response->detail="Auditoria Aprobada del lote ".$_POST['lote']." - vez ".$_POST['numvezlote'];
			}else{
				$response->detail="Auditoria Rechazada del lote ".$_POST['lote']." - vez ".$_POST['numvezlote'];
			}
		}
	}else{
		$response->state=false;
		$response->detail="No se pudo terminar el lote";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>