<?php
	// set_time_limit(240);
	// include("connection.php");
	// $response=new stdClass();

	// $ar_fecha=explode('-', $_POST['fecini']);
	// $fecini=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];

	// $ar_fefin=explode('-', $_POST['fecfin']);
	// $fecfin=$ar_fefin[0].$ar_fefin[1].$ar_fefin[2];

	// $detalle=[];
	// $i=0;
	// $sql="BEGIN SP_AUDTEL_REP_DENS_ANCHO_PRG(:FECINI,:FECFIN,:CODPRV,:CODCLI,:OPCION,:CODTEL,:CODCOL,:CODPRO,:OUTPUT_CUR); END;";
	// $stmt=oci_parse($conn, $sql);
	// oci_bind_by_name($stmt, ':FECINI', $fecini);
	// oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	// oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	// oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	// $opcion=1;
	// oci_bind_by_name($stmt, ':OPCION', $opcion);
	// oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	// oci_bind_by_name($stmt, ':CODCOL', $_POST['codcol']);
	// oci_bind_by_name($stmt, ':CODPRO', $_POST['codpro']);
	// $OUTPUT_CUR=oci_new_cursor($conn);
	// oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	// $result=oci_execute($stmt);
	// oci_execute($OUTPUT_CUR);
	// while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	// 	$obj=new stdClass();
	// 	$obj->PARTIDA=$row['PARTIDA'];
	// 	$obj->CODTEL=$row['CODTEL'];
	// 	$obj->CODPRV=$row['CODPRV'];
	// 	$obj->PROVEEDOR=utf8_encode($row['PROVEEDOR']);
	// 	$obj->CODCLI=$row['CODCLI'];
	// 	$obj->CLIENTE=utf8_encode($row['CLIENTE']);
	// 	$obj->PROGRAMA=utf8_encode($row['PROGRAMA']);
	// 	$obj->DESTEL=utf8_encode($row['DESTEL']);
	// 	$obj->CODCOL=utf8_encode($row['CODCOL']);
	// 	$obj->VALORTSC=str_replace(",",".",$row['VALORTSC']);
	// 	$obj->VALORPRV=str_replace(",",".",$row['VALORPRV']);
	// 	$obj->VALORWTS=str_replace(",",".",$row['VALORWTS']);
	// 	$obj->VALOR=str_replace(",",".",$row['VALOR']);
	// 	$obj->LI=str_replace(",",".",$row['LI']);
	// 	$obj->LS=str_replace(",",".",$row['LS']);
	// 	$obj->VALORTSCANCHO=str_replace(",",".",$row['VALORTSCANCHO']);
	// 	$obj->VALORPRVANCHO=str_replace(",",".",$row['VALORPRVANCHO']);
	// 	$obj->VALORWTSANCHO=str_replace(",",".",$row['VALORWTSANCHO']);
	// 	$obj->VALORANCHO=str_replace(",",".",$row['VALORANCHO']);
	// 	$obj->LIANCHO=str_replace(",",".",$row['LIANCHO']);
	// 	$obj->LSANCHO=str_replace(",",".",$row['LSANCHO']);
	// 	$obj->FECFINAUD=$row['FECFINAUD'];
	// 	$obj->PESO=$row['PESO'];
	// 	$obj->GR_DESV=str_replace(",",".",$row['GR_DESV']);
	// 	$obj->POR_GR_DESV=str_replace(",",".",$row['POR_GR_DESV']);
	// 	$obj->KG_AFEC=str_replace(",",".",$row['KG_AFEC']);
	// 	$obj->KG_AFEC_MAS=str_replace(",",".",$row['KG_AFEC_MAS']);
	// 	$obj->VALORTSCENCANCHO3=str_replace(",",".",$row['VALORTSCENCANCHO3']);
	// 	$obj->VALORENCANCHO3=str_replace(",",".",$row['VALORENCANCHO3']);
	// 	$obj->LIENCANCHO3=str_replace(",",".",$row['LIENCANCHO3']);
	// 	$obj->LSENCANCHO3=str_replace(",",".",$row['LSENCANCHO3']);
	// 	$obj->VALORTSCENCLARGO3=str_replace(",",".",$row['VALORTSCENCLARGO3']);
	// 	$obj->VALORENCLARGO3=str_replace(",",".",$row['VALORENCLARGO3']);
	// 	$obj->LIENCLARGO3=str_replace(",",".",$row['LIENCLARGO3']);
	// 	$obj->LSENCLARGO3=str_replace(",",".",$row['LSENCLARGO3']);
	// 	$obj->VALORTSCREV3=str_replace(",",".",$row['VALORTSCREV3']);
	// 	$obj->VALORREV3=str_replace(",",".",$row['VALORREV3']);
	// 	$obj->LIREV3=str_replace(",",".",$row['LIREV3']);
	// 	$obj->LSREV3=str_replace(",",".",$row['LSREV3']);
	// 	$obj->VALORTSCINCACA3=str_replace(",",".",$row['VALORTSCINCACA']);
	// 	$obj->VALORINCACA3=str_replace(",",".",$row['VALORINCACA']);
	// 	$obj->LIINCACA3=str_replace(",",".",$row['LIINCACA']);
	// 	$obj->LSINCACA3=str_replace(",",".",$row['LSINCACA']);
	// 	$obj->VALORTSCINCLAV3=str_replace(",",".",$row['VALORTSCINCLAV']);
	// 	$obj->VALORINCLAV3=str_replace(",",".",$row['VALORINCLAV']);
	// 	$obj->LIINCLAV3=str_replace(",",".",$row['LIINCLAV']);
	// 	$obj->LSINCLAV3=str_replace(",",".",$row['LSINCLAV']);
	// 	$detalle[$i]=$obj;
	// 	$i++;
	// }
	// $response->detalle=$detalle;

	// oci_close($conn);
	// header('Content-Type: application/json');
	// echo json_encode($response);


	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	$ar_fecha=explode('-', $_POST['fecini']);
	$fecini=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];

	$ar_fefin=explode('-', $_POST['fecfin']);
	$fecfin=$ar_fefin[0].$ar_fefin[1].$ar_fefin[2];

	$detalle=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_DENS_ANCHO_PRG_N(:FECINI,:FECFIN,:CODPRV,:CODCLI,:OPCION,:CODTEL,:CODCOL,:CODPRO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODCOL', $_POST['codcol']);
	oci_bind_by_name($stmt, ':CODPRO', $_POST['codpro']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->PARTIDA=$row['PARTIDA'];
		$obj->CODTEL=$row['CODTEL'];
		$obj->CODPRV=$row['CODPRV'];
		$obj->PROVEEDOR=utf8_encode($row['PROVEEDOR']);
		$obj->CODCLI=$row['CODCLI'];
		$obj->CLIENTE=utf8_encode($row['CLIENTE']);
		$obj->PROGRAMA=utf8_encode($row['PROGRAMA']);
		$obj->DESTEL=utf8_encode($row['DESTEL']);
		$obj->CODCOL=utf8_encode($row['CODCOL']);
		$obj->VALORTSC=str_replace(",",".",$row['VALORTSC']);
		$obj->VALORPRV=str_replace(",",".",$row['VALORPRV']);
		$obj->VALORWTS=str_replace(",",".",$row['VALORWTS']);
		$obj->VALOR=str_replace(",",".",$row['VALOR']);
		$obj->LI=str_replace(",",".",$row['LI']);
		$obj->LS=str_replace(",",".",$row['LS']);
		$obj->VALORTSCANCHO=str_replace(",",".",$row['VALORTSCANCHO']);
		$obj->VALORPRVANCHO=str_replace(",",".",$row['VALORPRVANCHO']);
		$obj->VALORWTSANCHO=str_replace(",",".",$row['VALORWTSANCHO']);
		$obj->VALORANCHO=str_replace(",",".",$row['VALORANCHO']);
		$obj->LIANCHO=str_replace(",",".",$row['LIANCHO']);
		$obj->LSANCHO=str_replace(",",".",$row['LSANCHO']);
		$obj->FECFINAUD=$row['FECFINAUD'];
		$obj->PESO=$row['PESO'];
		$obj->GR_DESV=str_replace(",",".",$row['GR_DESV']);
		$obj->POR_GR_DESV=str_replace(",",".",$row['POR_GR_DESV']);
		$obj->KG_AFEC=str_replace(",",".",$row['KG_AFEC']);
		$obj->KG_AFEC_MAS=str_replace(",",".",$row['KG_AFEC_MAS']);
		$obj->VALORTSCENCANCHO3=str_replace(",",".",$row['VALORTSCENCANCHO3']);
		$obj->VALORENCANCHO3=str_replace(",",".",$row['VALORENCANCHO3']);
		$obj->LIENCANCHO3=str_replace(",",".",$row['LIENCANCHO3']);
		$obj->LSENCANCHO3=str_replace(",",".",$row['LSENCANCHO3']);
		$obj->VALORTSCENCLARGO3=str_replace(",",".",$row['VALORTSCENCLARGO3']);
		$obj->VALORENCLARGO3=str_replace(",",".",$row['VALORENCLARGO3']);
		$obj->LIENCLARGO3=str_replace(",",".",$row['LIENCLARGO3']);
		$obj->LSENCLARGO3=str_replace(",",".",$row['LSENCLARGO3']);
		$obj->VALORTSCREV3=str_replace(",",".",$row['VALORTSCREV3']);
		$obj->VALORREV3=str_replace(",",".",$row['VALORREV3']);
		$obj->LIREV3=str_replace(",",".",$row['LIREV3']);
		$obj->LSREV3=str_replace(",",".",$row['LSREV3']);
		$obj->VALORTSCINCACA3=str_replace(",",".",$row['VALORTSCINCACA']);
		$obj->VALORINCACA3=str_replace(",",".",$row['VALORINCACA']);
		$obj->LIINCACA3=str_replace(",",".",$row['LIINCACA']);
		$obj->LSINCACA3=str_replace(",",".",$row['LSINCACA']);
		$obj->VALORTSCINCLAV3=str_replace(",",".",$row['VALORTSCINCLAV']);
		$obj->VALORINCLAV3=str_replace(",",".",$row['VALORINCLAV']);
		$obj->LIINCLAV3=str_replace(",",".",$row['LIINCLAV']);
		$obj->LSINCLAV3=str_replace(",",".",$row['LSINCLAV']);

		// ################
		// ### AGREGADO ###
		// ################


		$obj->VALORTSCENCANCHOAFTER=str_replace(",",".",$row['VALORTSCENCANCHOAFTER']);
		$obj->VALORPRVENCANCHOAFTER=str_replace(",",".",$row['VALORPRVENCANCHOAFTER']);
		$obj->VALORWTSENCANCHOAFTER=str_replace(",",".",$row['VALORWTSENCANCHOAFTER']);
		$obj->VALORENCANCHOAFTER=str_replace(",",".",$row['VALORENCANCHOAFTER']);
		$obj->LIENCANCHOAFTER=str_replace(",",".",$row['LIENCANCHOAFTER']);
		$obj->LSENCANCHOAFTER=str_replace(",",".",$row['LSENCANCHOAFTER']);


		$obj->VALORTSCENCDENSIDADAFTER=str_replace(",",".",$row['VALORTSCENCDENSIDADAFTER']);
		$obj->VALORPRVENCDENSIDADAFTER=str_replace(",",".",$row['VALORPRVENCDENSIDADAFTER']);
		$obj->VALORWTSENCDENSIDADAFTER=str_replace(",",".",$row['VALORWTSENCDENSIDADAFTER']);
		$obj->VALORENCDENSIDADAFTER=str_replace(",",".",$row['VALORENCDENSIDADAFTER']);
		$obj->LIENCDENSIDADAFTER=str_replace(",",".",$row['LIENCDENSIDADAFTER']);
		$obj->LSENCDENSIDADAFTER=str_replace(",",".",$row['LSENCDENSIDADAFTER']);


		$detalle[$i]=$obj;
		$i++;
	}
	$response->detalle=$detalle;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);


?>