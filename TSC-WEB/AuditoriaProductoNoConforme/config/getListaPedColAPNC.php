<?php
	include('connection.php');
	$response=new stdClass();

	function format_percent($value){
		$value=str_replace(",",".",$value);
		if ($value[0]==".") {
			return "0".$value."%";
		}else{
			return $value."%";
		}
	}

	$data=array();
	$i=0;
	$sql="BEGIN SP_APNC_SELECT_PEDCOLCONV2(:PEDIDO,:DESCOL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':DESCOL',$_POST['descol']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->NUMVEZ=$row['NUMVEZ'];
		$obj->PARTE=$row['PARTE'];
		$obj->CODUSU=$row['CODUSU'];
		$obj->CANDEF=$row['CANDEF'];
		$obj->CANTIDAD=$row['CANTIDAD'];
		$obj->CANMUE=$row['CANMUE'];
		$obj->FECINIAUDF=$row['FECINIAUDF'];
		$obj->PORNOCON=format_percent($row['PORNOCON']);
		$data[$i]=$obj;
		$i++;
	}
	$response->data=$data;

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>