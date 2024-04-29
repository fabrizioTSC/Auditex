<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sql="";
	if(isset($_POST['typeRequest'])){
		/*
		if($_POST['typeRequest']=="1"){
			$sql="SELECT * FROM FICHAAUDITORIACORTE fa".
			" inner join AUDITORIAENVIO ae on ae.CODENV=fa.CODENV".
			" inner join TALLER t on t.CODTLL=ae.CODTLL".
			" where fa.CODFIC=".$_POST['codfic']." and fa.ESTADO='P' order by fa.CODFIC,fa.PARTE,fa.NUMVEZ";	
		}else{
			$sql="SELECT * FROM FICHAAUDITORIACORTE where CODFIC=".$_POST['codfic']." and ESTADO='T'";
		}
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$fichas=array();
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$ficha=new stdClass();
			$ficha=$row;
			$fichas[$i]=$ficha;
			$i++;
		}
		if (oci_num_rows($stmt)==0) {
			$response->state=false;
			$error->detail="No hay fichas pendientes!";
			$response->error=$error;
		}else{
			$response->state=true;
			$response->fichas=$fichas;
		}*/
	}else{
		$sql="BEGIN SP_AFC_SELECT_DETFICAUDCOR(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
		oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$ficha=new stdClass();
		$ficha->ESTADO=$row['ESTADO'];
		$ficha->DESTLL=utf8_encode($row['DESTLL']);
		$ficha->CANPRE=$row['CANPRE'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
		$ficha->AQL=$row['AQL'];
		$ficha->CANAUD=$row['CANAUD'];
		$ficha->RESULTADO=$row['RESULTADO'];
		$response->ficha=$ficha;		
		if (isset($_POST['requestFicha'])) {
			$defectos=array();
			$i=0;
			$sql="BEGIN SP_AFC_SELECT_AUDFINCORDETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			while($row=oci_fetch_assoc($OUTPUT_CUR)){
				$defecto=new stdClass();
				$defecto->coddef=$row['CODDEF'];
				$defecto->desdef=utf8_encode($row['DESDEF']);
				$defecto->candef=$row['CANDEF'];
				$defectos[$i]=$defecto;
				$i++;
			}
			$response->defectos=$defectos;
		}		
		$response->state=true;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>