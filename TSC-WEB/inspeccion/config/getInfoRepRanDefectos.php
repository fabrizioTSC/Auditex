<?php
	include("connection.php");
	$response=new stdClass();

	$titulo="";

	$anio="";
	if(isset($_POST['anio'])){
		$anio=$_POST['anio'];
	}
	$mes="";
	if(isset($_POST['mes'])){
		$mes=$_POST['mes'];
	}
	$semana="";
	if(isset($_POST['semana'])){
		$semana=$_POST['semana'];
	}
	$fecini="";
	if(isset($_POST['fecini'])){
		$fecini=$_POST['fecini'];
	}
	$fecfin="";
	if(isset($_POST['fecfin'])){
		$fecfin=$_POST['fecfin'];
	}

	if ($_POST['option']=="1") {
		$titulo.=$_POST['anio']." / ";
	}
	if ($_POST['option']=="2") {
		$titulo.=$_POST['anio']." / Semana ".$_POST['semana'];
	}
	if ($_POST['option']=="3") {
		$ar_fecini=explode("-", $_POST['fecini']);
		$ar_fecfin=explode("-", $_POST['fecfin']);

		$titulo.="De ".$ar_fecini[2]."-".$ar_fecini[1]."-".$ar_fecini[0]." a ".$ar_fecfin[2]."-".$ar_fecfin[1]."-".$ar_fecfin[0];

		$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
		$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
	}

	$talleres=[];
	$i=0;
	$sql="BEGIN SP_INSP_REP_RANKINGLTDEFAUX(:OPCION,:ANIO,:MES,:SEMANA,:FECINI,:FECFIN,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':OPCION', $_POST['option']);
	oci_bind_by_name($stmt, ':ANIO', $anio);
	oci_bind_by_name($stmt, ':MES', $mes);
	oci_bind_by_name($stmt, ':SEMANA', $semana);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->LINEA=$row['LINEA'];
		$obj->TURNO=$row['TURNO'];
		$obj->PRE_DEF=$row['PRE_DEF'];
		$obj->PRE_INS=$row['PRE_INS'];
		$obj->POR_DEF=str_replace(",",".",$row['POR_DEF']);
		$talleres[$i]=$obj;
		$i++;
	}
	$response->talleres=$talleres;

	$response->titulo=$titulo;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>