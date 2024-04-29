<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codtll'])) {
		//INFORMACION INICIAL
		$sql="BEGIN SP_INSP_SELECT_INFREP(:CODTLL,:CANPRE,:CANPREDEF,:TOTDEF,:CODFIC,:PEDIDO,:DESCLI); END;";		
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":CODTLL", $_POST['codtll']);
		oci_bind_by_name($stmt,":CANPRE", $canpre,40);
		oci_bind_by_name($stmt,":CANPREDEF", $canpredef,40);
		oci_bind_by_name($stmt,":TOTDEF", $totdef,40);
		oci_bind_by_name($stmt,":CODFIC", $codfic,40);
		oci_bind_by_name($stmt,":PEDIDO", $pedido,40);
		oci_bind_by_name($stmt,":DESCLI", $descli,40);
		$result=oci_execute($stmt);

		$data=new stdClass();
		$data->CANPRE=$canpre;
		$data->CANPREDEF=$canpredef;
		$response->data=$data;

		$response->datadef=$totdef;

		$detCliente=new stdClass();
		$detCliente->CODFIC=$codfic;
		$detCliente->PEDIDO=$pedido;
		$detCliente->DESCLI=utf8_encode($descli);		
		$response->detCliente=$detCliente;
		
		//DETALLES DEL REPORTE
		$sumDetalle=0;
		$detDefecto=new stdClass();

		$sql="BEGIN SP_INSP_SELECT_INFREPDET1(:CODTLL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$detalle=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODSUBFAMILIA=$row['CODSUBFAMILIA'];
			$obj->DSCSUBFAMILIA=utf8_encode($row['DSCSUBFAMILIA']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$sumDetalle+=(int) $row['CANTIDAD'];
			$detalle[$i]=$obj;
			$i++;
		}
		$detDefecto->detalle1=$detalle;		
		
		$sql="BEGIN SP_INSP_SELECT_INFREPDET2(:CODTLL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$detalle=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODSUBFAMILIA=$row['CODFAMILIA'];
			$obj->DSCSUBFAMILIA=utf8_encode($row['DSCFAMILIA']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$sumDetalle+=(int) $row['CANTIDAD'];
			$detalle[$i]=$obj;
			$i++;
		}
		$detDefecto->detalle2=$detalle;

		$detDefecto->sumDetalle=$sumDetalle;

		//DETALLE OPERACIONES
		$codope_aux=0;
		$desope_aux="";
		$sumOpe=0;
		$sql="BEGIN SP_INSP_SELECT_INFREPDETOPES(:CODTLL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$operaciones=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODOPE=$row['CODOPE'];
			$obj->DESOPE=utf8_encode($row['DESOPE']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$sumOpe+=(int) $row['CANTIDAD'];
			$operaciones[$i]=$obj;
			$i++;
			if ($i==1) {
				$codope_aux=$row['CODOPE'];
				$desope_aux=utf8_encode($row['DESOPE']);
			}
		}
		$response->nomDetOpe=$desope_aux;
		$response->operaciones=$operaciones;
		$response->sumOpe=$sumOpe;

		//DETALLE DE LA PRIMERA OPERACION
		$sql="BEGIN SP_INSP_SELECT_INFREPDETOPE(:CODTLL,:CODOPE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		oci_bind_by_name($stmt, ':CODOPE', $codope_aux);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$detalleOpe=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$detalleOpe[$i]=$obj;
			$i++;
		}
		$response->detalleOpe=$detalleOpe;

		//DETALLE DEFECTOS
		$coddef_aux=0;
		$desdef_aux="";
		$sumDef=0;		
		$sql="BEGIN SP_INSP_SELECT_INFREPDETDEFS(:CODTLL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$defectos=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$sumDef+=(int) $row['CANTIDAD'];
			$defectos[$i]=$obj;
			$i++;
			if ($i==1) {
				$coddef_aux=$row['CODDEF'];
				$desdef_aux=utf8_encode($row['DESDEF']);
			}
		}
		$response->defectos=$defectos;
		$response->sumDef=$sumDef;
		$response->nomDetDef=$desdef_aux;

		//DETALLE DEL PRIMER DEFECTO
		$sql="BEGIN SP_INSP_SELECT_INFREPDETDEF(:CODTLL,:CODDEF,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		oci_bind_by_name($stmt, ':CODDEF', $coddef_aux);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$detalleDef=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODOPE=$row['CODOPE'];
			$obj->DESOPE=utf8_encode($row['DESOPE']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$detalleDef[$i]=$obj;
			$i++;
		}
		$response->detalleDef=$detalleDef;

		//DETALLE DE HOMBRE VS MAQUINA
		$tothommaq=0;
		$sql="BEGIN SP_INSP_SELECT_INFREPDETHM(:CODTLL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$hommaq=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTIPODEF=$row['CODTIPODEF'];
			$obj->DSCTIPODEF=utf8_encode($row['DSCTIPODEF']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$tothommaq+=$row['CANTIDAD'];
			$hommaq[$i]=$obj;
			$i++;
		}
		$response->tothommaq=$tothommaq;
		$response->hommaq=$hommaq;

		///DETALLE DE DEFECTOS DE MAQUINA
		$totdefmaq=0;
		$sql="BEGIN SP_INSP_SELECT_INFREPDETDSM(:CODTLL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$detdefmaq=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$totdefmaq+=$row['CANTIDAD'];
			$detdefmaq[$i]=$obj;
			$i++;
			if ($i==1) {
				$coddef_aux=$row['CODDEF'];
				$desdef_aux=utf8_encode($row['DESDEF']);
			}
		}
		$response->detdefmaq=$detdefmaq;
		$response->totdefmaq=$totdefmaq;
		$response->desdefmaq=$desdef_aux;

		//DETALLE DEL PRIMER DEFECTO DE MAQUINA
		$totopemaq=0;
		$sql="BEGIN SP_INSP_SELECT_INFREPDETDM(:CODTLL,:CODDEF,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		oci_bind_by_name($stmt, ':CODDEF', $coddef_aux);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$detopemaq=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODOPE=$row['CODOPE'];
			$obj->DESOPE=utf8_encode($row['DESOPE']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$totopemaq+=$row['CANTIDAD'];
			$detopemaq[$i]=$obj;
			$i++;
		}
		$response->detopemaq=$detopemaq;
		$response->totopemaq=$totopemaq;

		$response->detDefecto=$detDefecto;
		$response->state=true;
		
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