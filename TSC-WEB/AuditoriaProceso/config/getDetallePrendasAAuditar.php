<?php
	ini_set('max_execution_time', 120);
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codtll'])) {
		$sql="select * from TALLER t ".
			"inner join AUDITORIAENVIO ae on t.CODTLL=ae.CODTLL ".
			"inner join FICHAAUDITORIA fa on ae.CODENV=fa.CODENV ".
			" where t.CODTLL=".$_POST['codtll']." and fa.CODFIC=".$_POST['codfic'].
			" and fa.NUMVEZ=".$_POST['numvez']." and fa.PARTE=".$_POST['parte'].
			" and fa.CODTAD=".$_POST['codtad']." and fa.CODAQL=".$_POST['codaql'];
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$fichas=array();
		$defectos=array();
		$operaciones=array();
		$fichatallas=array();
		$defectosPasados=array();
		$i=0;

		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$ficha=new stdClass();
			$ficha=$row;
			$fichas[$i]=$ficha;
			$i++;
		}

		if (oci_num_rows($stmt)==0) {			
			$response->state=false;
			$response->description="No hay fichas para el taller";
		}else{
			/* FICHA TALLA */
			$sqlFichaTalla="SELECT ft.*,t.DESTAL FROM FICHATALLA ft ".
			"inner join TALLA t ".
			"on ft.CODTAL=t.CODTAL where CODFIC=".$_POST['codfic']." and ft.ESTADO='A'";
			$stmtft=oci_parse($conn, $sqlFichaTalla);
			$resultFichaTalla=oci_execute($stmtft);
			while ($row=oci_fetch_array($stmtft,OCI_ASSOC)) {
				$fichatalla=new stdClass();
				$fichatalla=$row;
				array_push($fichatallas,$fichatalla);
			}
			/* DEFECTOS */
			$sqlDefectos="SELECT * FROM DEFECTO where ESTADO='A' order by CODDEF";
			$stmtd=oci_parse($conn, $sqlDefectos);
			$resultDefecto=oci_execute($stmtd);
			while($row=oci_fetch_array($stmtd,OCI_ASSOC)){
				$defecto=new stdClass();
				$defecto->coddef=$row['CODDEF'];
				$defecto->desdef=utf8_encode($row['DESDEF']);
				array_push($defectos,$defecto);
			}
			/* OPERACIONES */
			$sqlOperaciones="SELECT * FROM OPERACION where ESTADO='A' order by CODOPE";
			$stmto=oci_parse($conn, $sqlOperaciones);
			$resulto=oci_execute($stmto);
			while($row=oci_fetch_array($stmto,OCI_ASSOC)){				
				$defecto=new stdClass();
				$defecto->codope=$row['CODOPE'];
				$defecto->desope=utf8_encode($row['DESOPE']);
				array_push($operaciones,$defecto);
			}
			/* DEFECTOS PASADOS */
			$sqlDefPas="SELECT addef.*,defe.DESDEF,oper.DESOPE FROM AUDITORIADETALLEDEFECTO addef".
			" inner join DEFECTO defe".
			" on addef.CODDEF=defe.CODDEF".
			" inner join OPERACION oper".
			" on addef.CODOPE=oper.CODOPE".
			" where CODFIC=".$_POST['codfic'].
			" and NUMVEZ=".$_POST['numvez']." and PARTE=".$_POST['parte'].
			" and CODTAD=".$_POST['codtad'];
			$stmtdp=oci_parse($conn, $sqlDefPas);
			$resultDefPas=oci_execute($stmtdp);
			while($row=oci_fetch_array($stmtdp,OCI_ASSOC)){				
				$defectoPas=new stdClass();
				$defectoPas=$row;
				array_push($defectosPasados,$defectoPas);
			}
			$response->state=true;
			$response->fichas=$fichas;
			$response->defectos=$defectos;
			$response->operaciones=$operaciones;
			$response->fichatallas=$fichatallas;
			$response->defectosPasados=$defectosPasados;
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