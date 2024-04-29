<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	
	$ficha=array();
	$obj=new stdClass();
	$obj->CODCOL="0";
	$obj->COLOR="(TODOS)";
	$ficha[0]=$obj;
	$i=1;
	if ($_POST['pedido']!="0") {
		$sql="BEGIN SP_AF_SELECT_FICHAREPDESMEDCOL(:ESTTSC,:PEDIDO,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
		oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODCOL=$row['DSCCOL'];
			$obj->COLOR=$row['DSCCOL'];
			$ficha[$i]=$obj;
			$i++;
		}
	}
	$response->state=true;
	$response->ficha=$ficha;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>