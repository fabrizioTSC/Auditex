<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="BEGIN SP_AT_SELECT_FICHA(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:TIPREQ,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		$numvez=0;
		oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
		$parte=0;
		oci_bind_by_name($stmt, ':PARTE', $parte);
		$codtad=0;
		oci_bind_by_name($stmt, ':CODTAD', $codtad);
		$codaql=0;
		oci_bind_by_name($stmt, ':CODAQL', $codaql);
		$tipreq=1;
		oci_bind_by_name($stmt, ':TIPREQ', $tipreq);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		
		if (isset($_POST['typepost'])) {
			$fichas=array();
			$i=0;
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				$ficha=new stdClass();
				$ficha=$row;
				$fichas[$i]=$ficha;
				$i++;
			}
			$response->fichas=$fichas;
		}else{
			$row=oci_fetch_assoc($OUTPUT_CUR);
			$ficha=new stdClass();
			$ficha=$row;
			$response->ficha=$ficha;
		}

		$count=oci_num_rows($OUTPUT_CUR);
		if ($count==0) {
			$response->state=false;
			$error->code=2;
			$error->description="No existe ficha";
			$response->error=$error;
		}else{
			$response->state=true;
		}
		
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->error=$error;
	}
	header('Content-Type: application/json');
	echo json_encode($response);
?>