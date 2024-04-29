<?php
	include('connection.php');

	// EJECUTAMOS CARGA DEL SIGE
    require_once '../../../tsc/models/modelo/core.modelo.php';

	$response=new stdClass();
	$error=new stdClass();
	$objModelo = new CoreModelo();

	$fichatipoauditoria = isset($_POST["fichatipoauditoria"]) ? $_POST["fichatipoauditoria"] : "N";
	$codfic="";
	if(isset($_POST['codfic'])){
		$codfic=$_POST['codfic'];
	}
	$numvez="";
	if(isset($_POST['numvez'])){
		$numvez=$_POST['numvez'];
	}
	$parte="";
	if(isset($_POST['parte'])){
		$parte=$_POST['parte'];
	}
	$codtad="";
	if(isset($_POST['codtad'])){
		$codtad=$_POST['codtad'];
	}
	$codaql="";
	if(isset($_POST['codaql'])){
		$codaql=$_POST['codaql'];
	}
	$tipreq=0;
	if(isset($_POST['typeRequest'])){
		$tipreq=$_POST['typeRequest'];
	}else{
		if(isset($_POST['requestFicha'])){	

			$ficha = $_POST['codfic'];

			// ELIMINAMOS SI NO TIENE REGISTRADO
			$responsereload = $objModelo->setAll("AUDITEX.RELOADSIGETOAUDITEX_COSTURA",[null,$ficha],"Recargado correctamente");

			// CARGAMOS SIGE
			// $responsecargasige = $objModelo->setAllSQLSIGE("uspCargaAuditoriaEnvioToAuditexV2",[$ficha],"Correcto");


			$sql="BEGIN SP_AFC_VAL_FICINFTEL(:CODFIC,:CONTADOR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt,':CONTADOR',$contador,40);
			$result=oci_execute($stmt);
			$partidaclass=new stdClass();
			//if ($contador>0) {	
				$sql="BEGIN SP_AFC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$row=oci_fetch_assoc($OUTPUT_CUR);
				$partidaclass->partida=$row['PARTIDA'];
				$partidaclass->tiptel=$row['ARTICULO'];
				$partidaclass->color=$row['COLOR'];
				$partidaclass->codtel=$row['CODTEL'];
				$partidaclass->DESTLL=utf8_encode($row['DESTLL']);

				$sql="BEGIN SP_AFC_GET_INFOPARTIDA2(:PARTIDA,:CODTEL,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt,':PARTIDA',$partidaclass->partida);
				oci_bind_by_name($stmt,':CODTEL',$partidaclass->codtel);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$row=oci_fetch_assoc($OUTPUT_CUR);
				if($row){
					$partidaclass->codprv=$row['CODPRV'];
					$partidaclass->numvez=$row['NUMVEZ'];
					$partidaclass->parte=$row['PARTE'];
					$partidaclass->codtad=$row['CODTAD'];
				}else{
					$partidaclass->codprv="";
					$partidaclass->numvez="";
					$partidaclass->parte="";
					$partidaclass->codtad="";
				}
				// $partidaclass->codprv=$row['CODPRV'];
				// $partidaclass->numvez=$row['NUMVEZ'];
				// $partidaclass->parte=$row['PARTE'];
				// $partidaclass->codtad=$row['CODTAD'];
			//}
			$response->partida=$partidaclass;

			$sql="BEGIN SP_AT_SELECT_AUDDETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':CODFIC',$codfic);
			oci_bind_by_name($stmt,':NUMVEZ',$numvez);
			oci_bind_by_name($stmt,':PARTE',$parte);
			oci_bind_by_name($stmt,':CODTAD',$codtad);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			$defectos=[];
			$i=0;
			while($row=oci_fetch_assoc($OUTPUT_CUR)){
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

			// $fichatallas=[];
			// $sql="BEGIN SP_AT_SELECT_FICHATALLAS(:CODFIC,:OUTPUT_CUR); END;";
			// $stmt=oci_parse($conn, $sql);
			// oci_bind_by_name($stmt,':CODFIC',$codfic);
			// $OUTPUT_CUR=oci_new_cursor($conn);
			// oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
			// $result=oci_execute($stmt);
			// oci_execute($OUTPUT_CUR);
			// while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			// 	$fichatalla=new stdClass();
			// 	$fichatalla->CANPRE=$row['CANPRE'];
			// 	$fichatalla->DESTAL=utf8_encode($row['DESTAL']);
			// 	array_push($fichatallas,$fichatalla);
			// }
			// $response->fichatallas=$fichatallas;

			$fichatallas=[];
			$sql="BEGIN SP_AT_SELECT_FICHATALLAS_N2_V2(:CODFIC,:PARTE,:VEZ,:TIPOAUDITORIA,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':CODFIC',$codfic);
			oci_bind_by_name($stmt,':PARTE',$parte);
			oci_bind_by_name($stmt,':VEZ',$numvez);
			oci_bind_by_name($stmt,':TIPOAUDITORIA',$fichatipoauditoria);

			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				$fichatalla=new stdClass();
				$fichatalla->CANPRE=$row['CANPRE'];
				$fichatalla->CANT=$row['CANT'];
				$fichatalla->DESTAL=utf8_encode($row['DESTAL']);
				array_push($fichatallas,$fichatalla);
			}
			$response->fichatallas=$fichatallas;

		}
	}


	$ficha = $_POST['codfic'];

	// ELIMINAMOS SI NO TIENE REGISTRADO
	$responsereload = $objModelo->setAll("AUDITEX.RELOADSIGETOAUDITEX_COSTURA",[null,$ficha],"Recargado correctamente");

	// CARGAMOS SIGE
	// $responsecargasige = $objModelo->setAllSQLSIGE("uspCargaAuditoriaEnvioToAuditexV2",[$ficha],"Correcto");

	$data=new stdClass();
	$sql="BEGIN SP_AFC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$codfic);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$data->DESCLI=utf8_encode($row['DESCLI']);
	}
	$response->data=$data;


	$sql="BEGIN SP_AT_SELECT_FICHA_V2(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:TIPREQ,:TIPOAUDITORIA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$codfic);
	oci_bind_by_name($stmt,':NUMVEZ',$numvez);
	oci_bind_by_name($stmt,':PARTE',$parte);
	oci_bind_by_name($stmt,':CODTAD',$codtad);
	oci_bind_by_name($stmt,':CODAQL',$codaql);
	oci_bind_by_name($stmt,':TIPREQ',$tipreq);
	oci_bind_by_name($stmt,':TIPOAUDITORIA',$fichatipoauditoria);


	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	if(isset($_POST['typeRequest'])){
		$fichas=[];
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){

			$ficha=new stdClass();
			$ficha->CODFIC=$row['CODFIC'];
			$ficha->AQL=$row['AQL'];
			$ficha->CODAQL=$row['CODAQL'];
			$ficha->CODTAD=$row['CODTAD'];
			$ficha->NUMVEZ=$row['NUMVEZ'];
			$ficha->PARTE=$row['PARTE'];
			// $ficha->DESTLL=utf8_encode($row['DESTLL']);
			$ficha->DESTLL = $row['DESTLL'];

			$ficha->CODTLL=$row['CODTLL'];
			$ficha->CODUSU=$row['CODUSU'];
			$ficha->CANPAR=$row['CANPAR'];
			$ficha->FECINIAUD=$row['FECINIAUD'];
			$ficha->CANTIDAD=$row['CANTOT'];
			$ficha->CANPRE=$row['CANTOT'];
			$ficha->CANPAR=$row['CANPAR'];
			// $ficha->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
			$ficha->COMENTARIOS = $row['COMENTARIOS'];

			$ficha->CANAUD=$row['CANAUD'];
			$ficha->RESULTADO=$row['RESULTADO'];
			// $ficha->OBSERVACIONES=$row['OBSERVACIONES'];


			$fichas[$i]=$ficha;
			$i++;
		}
		if (oci_num_rows($OUTPUT_CUR)==0) {
			$response->state=false;
			$error->detail="No existe ficha!";
			$response->error=$error;
			$response->fichas=$fichas;
		}else{
			$response->state=true;
			$response->fichas=$fichas;
		}		
	}else{
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$ficha=new stdClass();
		$ficha->ESTADO=$row['ESTADO'];
		// $ficha->DESTLL=utf8_encode($row['DESTLL']);
		$ficha->DESTLL	=	$row['DESTLL'];

		$ficha->CANPRE=$row['CANTOT'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
		$ficha->AQL=$row['AQL'];
		$ficha->CANAUD=$row['CANAUD'];
		$ficha->RESULTADO=$row['RESULTADO'];
		// agregado
		$ficha->OBSERVACIONES=$row['OBSERVACIONES'];
	
		$response->state=true;
		$response->ficha=$ficha;		
	}

	$sql="BEGIN SP_AT_SELECT_FICPENAUD(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$codfic);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$ficpen=[];
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->PARTE=$row['PARTE'];
		$obj->NUMVEZ=$row['NUMVEZ'];
		$obj->CANPAR=$row['CANPAR'];
		$obj->DESTLL=utf8_encode($row['DESTLL']);
		array_push($ficpen,$obj);
	}
	$response->ficpen=$ficpen;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>