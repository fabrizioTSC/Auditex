<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="SELECT * FROM FICHAAUDITORIA fa".
			" inner join AUDITORIAENVIO ae on ae.CODENV=fa.CODENV".
			" inner join TALLER t on t.CODTLL=ae.CODTLL".
			" where fa.CODFIC=".$_POST['codfic']." and fa.CODTAD=6 and fa.ESTADO='P' order by fa.CODFIC,fa.PARTE,fa.NUMVEZ";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$row=oci_fetch_array($stmt);
		if (oci_num_rows($stmt)==0) {
			$sql="SELECT * FROM AUDITORIAENVIO WHERE CODFIC=".$_POST['codfic']." and CODTLL='".$_POST['codtll']."'";
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt);
			$row=oci_fetch_array($stmt);

			$sql="INSERT INTO FICHAAUDITORIA VALUES (".
			$_POST['codfic'].",6,1,1,".
			$row['CODENV'].",'".
			$_POST['codusu']."',SYSDATE,null,1,'D',0,0,".
			$row['CANTOT'].",".
			$row['CANPRE'].",0,0,0,'P',null,null)";
				$response->sql=$sql;
				
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
			if ($result) {
				$response->state=true;
				$sql="select * from auditoriaenvio ae
					inner join taller tl
					on ae.codtll=tl.codtll
					inner join cliente cli
					on ae.codcli=cli.codcli
					inner join color cl
					on ae.CODCOL=cl.CODCOL
					WHERE ae.CODTLL='".$_POST['codtll']."' and ae.CODFIC=".$_POST['codfic'];
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt);
				$row=oci_fetch_array($stmt);
				
				$taller=new stdClass();
				$taller->DESTLL=utf8_encode($row['DESTLL']);
				$taller->DESCLI=utf8_encode($row['DESCLI']);
				$taller->DESCOL=utf8_encode($row['DESCOL']);
				$response->taller=$taller;
			}else{
				$response->state=false;
				$error->detail="No se pudo crear la FichaAuditoria!";
				$response->error=$error;
			}
			
		}else{
			$response->state=true;
			$sql="select * from auditoriaenvio ae
				inner join taller tl
				on ae.codtll=tl.codtll
				inner join cliente cli
				on ae.codcli=cli.codcli
				inner join color cl
				on ae.CODCOL=cl.CODCOL
				WHERE ae.CODTLL='".$_POST['codtll']."' and ae.CODFIC=".$_POST['codfic'];
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt);
			$row=oci_fetch_array($stmt);

			$taller=new stdClass();
			$taller->DESTLL=utf8_encode($row['DESTLL']);
			$taller->DESCLI=utf8_encode($row['DESCLI']);
			$taller->DESCOL=utf8_encode($row['DESCOL']);
			$response->taller=$taller;
		}

		$secuen=$_POST['secuen'];
		if ($_POST['secuen']==0||$_POST['secuen']=="0") {
			$sql="SELECT * FROM AuditoriaProceso where codfic=".$_POST['codfic'];
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt);
			$row=oci_fetch_array($stmt);
			$secuen=oci_num_rows($stmt)+1;

			$sql="INSERT INTO AuditoriaProceso values (".$_POST['codfic'].",".$secuen.",6,1,1,".
			$_POST['turno'].",'".$_POST['codtll']."',SYSDATE,null,'".$_POST['codusu']."')";
			
			$response->sql=$sql;

			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
			if ($result) {
				$response->extra="Exito";
			}else{
				$response->extra="Fallo";
			}
		}
		$response->secuen=$secuen;
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