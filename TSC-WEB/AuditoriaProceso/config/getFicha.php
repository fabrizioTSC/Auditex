<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="";
		if(isset($_POST['typeRequest'])){
			if($_POST['typeRequest']==1){
				$sql="SELECT * FROM FICHAAUDITORIA fa".
				" inner join AUDITORIAENVIO ae on ae.CODENV=fa.CODENV".
				" inner join TALLER t on t.CODTLL=ae.CODTLL".
				" where fa.CODFIC=".$_POST['codfic']." and fa.ESTADO='P' order by fa.CODFIC,fa.PARTE,fa.NUMVEZ";	
			}else{
				$sql="SELECT * FROM FICHAAUDITORIA where CODFIC=".$_POST['codfic']." and ESTADO='T'";
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
			}
		}else{
			$sql="select * from FICHAAUDITORIA fa ".
			" inner join AUDITORIAENVIO ae on ae.CODENV=fa.CODENV".
			" inner join TALLER t on t.CODTLL=ae.CODTLL".
			" where fa.CODFIC=".$_POST['codfic']." and fa.NUMVEZ=".$_POST['numvez'].
			" and fa.PARTE=".$_POST['parte']." and fa.CODTAD=".$_POST['codtad']." and fa.CODAQL=".$_POST['codaql'];
			
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt);
			$row=oci_fetch_array($stmt);
			$ficha=new stdClass();
			$ficha->ESTADO=$row['ESTADO'];
			$ficha->DESTLL=utf8_encode($row['DESTLL']);
			$ficha->CANPRE=$row['CANPRE'];
			$ficha->CANPAR=$row['CANPAR'];
			$ficha->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
			$ficha->AQL=$row['AQL'];
			$ficha->CANAUD=$row['CANAUD'];
			$ficha->RESULTADO=$row['RESULTADO'];
			
			$response->state=true;
			$response->ficha=$ficha;
			
			if (isset($_POST['requestFicha'])) {
				$sqlDefectos="SELECT * FROM AUDITORIADETALLEDEFECTO auddd".
				" inner join DEFECTO d on d.CODDEF=auddd.CODDEF".
				" inner join OPERACION o on o.CODOPE=auddd.CODOPE".
				" where auddd.CODFIC=".$_POST['codfic']." and auddd.NUMVEZ=".$_POST['numvez'].
				" and auddd.PARTE=".$_POST['parte']." and auddd.CODTAD=".$_POST['codtad'];
				
				$stmtd=oci_parse($conn, $sqlDefectos);
				$resultDefecto=oci_execute($stmtd);
				$defectos=array();
				$i=0;
				while($row=oci_fetch_array($stmtd,OCI_ASSOC)){
					$defecto=new stdClass();
					$defecto->coddef=$row['CODDEF'];
					$defecto->desdef=utf8_encode($row['DESDEF']);
					$defecto->codope=$row['CODOPE'];
					$defecto->desope=utf8_encode($row['DESOPE']);
					$defecto->candef=$row['CANDEF'];
					$defectos[$i]=$defecto;
					$i++;
				}
				$response->defectos=$defectos;
			}
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