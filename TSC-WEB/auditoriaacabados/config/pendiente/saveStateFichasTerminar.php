<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['fichas'])) {
		$fichas="";
		for ($i=0; $i <count($_POST['fichas']) ; $i++) { 
			if ($i==count($_POST['fichas'])-1) {
				$fichas.="'".$_POST['fichas'][$i]."'";
			}else{
				$fichas.="'".$_POST['fichas'][$i]."',";
			}
		}

		$sqlUpdate="UPDATE fichacosturaavance set ESTADO='T',FECTER=SYSDATE".
		" WHERE CODFIC IN (".$fichas.")";
		$stmt=oci_parse($conn, $sqlUpdate);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
		if ($result) {
			$sql="SELECT * from fichacosturaavance where CODTLL='".$_POST['codtll']."'".
			" AND CODFIC IN (".$fichas.")";
			
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt);
			$fichasArray=array();
			$i=0;
			while($row=oci_fetch_array($stmt,OCI_ASSOC)){
				$fichasArray[$i]=" INTO fichacosturamovimiento values ('".$row['CODFIC']."',".$row['PARTE'].",SYSDATE,'".$_POST['usumov']."',".
				"3,".$row['CANPAR'].",'".$row['CODTLL']."','A')";
				$i++;
			}
			$parteSql="";
			for ($i=0; $i <count($fichasArray) ; $i++) {
				$parteSql.=$fichasArray[$i];
			}
			$sqlInsert="INSERT ALL ".$parteSql." SELECT * FROM DUAL";

			$stmt=oci_parse($conn, $sqlInsert);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
			if ($result) {
				$response->state=true;
			}else{
				$response->state=false;
				$error->detail="No se pudo crear nuevos registros!";
				$response->error=$error;				
			}
		}else{
			$response->state=false;
			$error->detail="No se pudo actualizar fichas!";
			$response->error=$error;
		}
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