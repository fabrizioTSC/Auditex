<?php
	set_time_limit(360);
	include('connection.php');
	function format1($text){
		if ($text=="") {
			return 0;
		}else{
			return format2($text);
		}
	}
	function format2($text){
		$new_value="";
		for ($i=0; $i < strlen($text); $i++) { 
			if ($text[$i]=="0" 
				|| $text[$i]=="1"
				|| $text[$i]=="2"
				|| $text[$i]=="3"
				|| $text[$i]=="4"
				|| $text[$i]=="5"
				|| $text[$i]=="6"
				|| $text[$i]=="7"
				|| $text[$i]=="8"
				|| $text[$i]=="9"
				|| $text[$i]==".") {
				$new_value.=$text[$i];
			}
		}
		return $new_value;
	}

	$response=new stdClass();
	$array=json_decode($_POST['array']);
	$ar_estdim=json_decode($_POST['array_estdim']);

	$tel=0;
	$dettel=0;
	for ($i=1; $i < count($array); $i++) {
		$sql="BEGIN SP_AUDTEL_INSERT_TELA(:CODTEL,:DESTEL,:CODTELPRV,:COMPOS); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTEL', $array[$i][0]);
		oci_bind_by_name($stmt, ':DESTEL', $array[$i][2]);
		oci_bind_by_name($stmt, ':CODTELPRV', $array[$i][1]);
		oci_bind_by_name($stmt, ':COMPOS', $array[$i][3]);
		$result=oci_execute($stmt);
		if($result){
			$tel++;
			$sql="select * from TELESTDIM where codtel='".$array[$i][0]."'";
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt);
			$row=oci_fetch_assoc($stmt);
			if(oci_num_rows($stmt)==0){
				$sql="Insert all ";
				for ($k=0; $k < count($ar_estdim); $k++) { 
					$sql.="into TELESTDIM(CODTEL,CODESTDIM,VALOR,TOLERANCIA) Values('".$array[$i][0]."',".$ar_estdim[$k].",".format1($array[$i][4+$k*2]).",".format1($array[$i][5+$k*2]).") ";
				}
				$sql.="select * from dual";
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
				if ($result) {
					$dettel++;
				}
			}
		}
		if ($i==1) {
			$response->sql=$sql;
		}
	}
	$response->state=true;
	$response->tel=$tel;
	$response->dettel=$dettel;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>