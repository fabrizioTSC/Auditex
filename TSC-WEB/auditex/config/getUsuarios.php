<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['request'])) {
		$usuarios=array();
		$i=0;
		$sql="BEGIN SP_AT_SELECT_USUARIOS(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			if($row['CODROL']!="4"){
				$obj=new stdClass();
				$obj->CODUSU=$row['CODUSU'];
				$obj->NOMUSU=utf8_encode($row['NOMUSU']);
				$obj->ALIUSU=utf8_encode($row['ALIUSU']);
				$obj->CODROL=$row['CODROL'];
				$usuarios[$i]=$obj;
				$i++;
			}
		}
		$response->state=true;
		$response->usuarios=$usuarios;
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->err=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>