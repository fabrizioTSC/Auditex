<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

		$clarec=array();
		$i=0;
		$sql="SELECT * FROM clasificacionrecuperacion where ESTADO='A'";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$total=0;
		while($row=oci_fetch_array($stmt)){
			$operador=new stdClass();
			$operador->CODCLAREC=$row['CODCLAREC'];
			$operador->DESCLAREC=utf8_encode($row['DESCLAREC']);

			$sql="SELECT CANPRE FROM fichaauditoriarecuperaciondet where codfic=".$_POST['codfic'].
				" and codtad=".$_POST['codtad']." and parte=".$_POST['parte']." and numvez=".$_POST['numvez']." and codclarec=".$row['CODCLAREC'];
			$stmt2=oci_parse($conn, $sql);
			$result2=oci_execute($stmt2);
			$row2=oci_fetch_array($stmt2);
			if (oci_num_rows($stmt2)==0) {
				$operador->CANPRE=0;
			}else{
				$operador->CANPRE=$row2['CANPRE'];
				$total+=(int)$row2['CANPRE'];
			}

			$clarec[$i]=$operador;
			$i++;
		}
		$response->clarec=$clarec;
		$response->total=$total;

		$response->state=true;
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>