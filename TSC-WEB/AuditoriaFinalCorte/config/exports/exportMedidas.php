<?php
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_registro_medidas-Ficha_".$_GET['codfic'].".xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../connection.php");

function process_res($text){
	switch ($text) {
		case '':
			return 'Ninguno';
			break;
		case 'A':
			return 'Aprobado';
			break;
		case 'C':
			return 'Aprobado no conforme';
			break;		
		default:
			break;
	}
}

$response=new stdClass();

$hilo = $_GET['hilo']  == "vacio" ? null : $_GET['hilo'];
$travez = $_GET['travez']  == "vacio" ? null : $_GET['travez'];
$largamanga = $_GET['largamanga']  == "vacio" ? null : $_GET['largamanga'];

//////////// COMENTADO POR EL MOMENTO
$sql="BEGIN SP_AFC_SELECT_PREDETFICMED_JV2(:CODFIC,:HILO,:TRAVEZ,:largamanga,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
oci_bind_by_name($stmt, ':HILO', $hilo);
oci_bind_by_name($stmt, ':TRAVEZ', $travez);
oci_bind_by_name($stmt, ':largamanga', $largamanga);

$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
$detalle=[];
$i=0;
$numpre=0;
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$obj=new stdClass();
	$obj->NUMPRE=$row['NUMPRE'];
	$obj->VALOR="'".$row['VALOR'];
	$obj->CODTAL=$row['CODTAL'];
	$obj->CODMED=$row['CODMED'];
	$obj->TOLVAL=$row['TOLVAL'];
	$obj->DESMEDCOR=utf8_encode($row['DESMEDCOR']);
	$obj->DESMED=utf8_encode($row['DESMED']);
	$detalle[$i]=$obj;
	$i++;
	if((int)$row['NUMPRE']>$numpre){
		$numpre=$row['NUMPRE'];
	}
}
$response->detalle=$detalle;
$response->numpre=$numpre;

if (oci_num_rows($stmt)>0) {
	$sql="BEGIN SP_AFC_SELECT_PREDETTALFIC_JV2(:CODFIC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
	oci_bind_by_name($stmt, ':HILO', $hilo);
	oci_bind_by_name($stmt, ':TRAVEZ', $travez);
	oci_bind_by_name($stmt, ':LARGMANGA', $largamanga);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$talla=[];
	$i=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$talla[$i]=$obj;
		$i++;
	}
	$response->talla=$talla;

	$sql="BEGIN SP_AFC_SELECT_PREDETTAL_JV2(:CODFIC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
	oci_bind_by_name($stmt, ':HILO', $hilo);
	oci_bind_by_name($stmt, ':TRAVEZ', $travez);
	oci_bind_by_name($stmt, ':LARGMANGA', $largamanga);

	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$detalletalla=[];
	$i=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODMED=$row['CODMED'];
		$obj->CODTAL=$row['CODTAL'];
		$obj->MEDIDA=utf8_encode($row['MEDIDA']);
		$obj->DESMED=utf8_encode($row['DESMED']);
		$detalletalla[$i]=$obj;
		$i++;
	}
	$response->detalletalla=$detalletalla;
}

$sql="BEGIN SP_AFC_SELECT_FICDATA(:CODFIC,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
?>
<div style="font-size: 20px;font-weight: bold;">Registro de medidas</div>
<br>
<div style="font-weight: bold;">Cod. Ficha: <?php echo $_GET['codfic']; ?></div>
<br>
<?php
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	echo '<div style="font-weight: bold;">Resultado: '.process_res($row['RESULTADOMED']).'</div>';
	if ($row['OBSRESULTADOMED']!="") {
		echo 
	'<div style="font-weight: bold;">Observacion: '.$row['OBSRESULTADOMED'].'</div>';
	}
	echo '<br>';
}
if($_GET['largamanga']=="0"){
?>
<div style="font-weight: bold;">Hilo: <?php echo $_GET['hilo']/100; ?> - Travez: <?php echo $_GET['travez']/100; ?></div>
<?php
}else{
?>
<div style="font-weight: bold;">Hilo: <?php echo $_GET['hilo']/100; ?> - Travez: <?php echo $_GET['travez']/100; ?> - Largamanga: <?php echo $_GET['largamanga']/100; ?></div>
<?php
}
?>
<br>
<?php
	$ar_total=array();
	$l=0;
	$ar_total[$l]= array('');
	$l++;
	$ar_total[$l]= array('Prenda');
	$l++;
	for ($j = 0; $j < $response->numpre; $j++) {
		for ($i = 0; $i < count($response->talla); $i++) {
			$ar_total[$l]= array($j+1);
			$l++;
		}
	}
	$l=0;
	$ar_aux=$ar_total[$l];
	$tam=count($ar_aux);
	$ar_aux[$tam]="Medida";
	$ar_total[$l]=$ar_aux;
	$l++;
	$ar_aux=$ar_total[$l];
	$tam=count($ar_aux);
	$ar_aux[$tam]="Talla";
	$ar_total[$l]=$ar_aux;
	$l++;
	for ($j = 0; $j < $response->numpre; $j++) {
		for ($i = 0; $i < count($response->talla); $i++) {
			$ar_aux=$ar_total[$l];
			$tam=count($ar_aux);
			$ar_aux[$tam]=$response->talla[$i]->DESTAL;
			$ar_total[$l]=$ar_aux;
			$l++;
		}
	}
	$ant_nom=$response->detalle[0]->DESMED;
	for ($i = 0; $i < count($response->detalle); $i++) {
		if ($response->detalle[$i]->DESMED!=$ant_nom) {
			$l=0;
			$ar_aux=$ar_total[$l];
			$tam=count($ar_aux);
			$ar_aux[$tam]=$response->detalle[$i]->DESMEDCOR;
			$ar_total[$l]=$ar_aux;
			$l++;
			$ar_aux=$ar_total[$l];
			$tam=count($ar_aux);
			$ar_aux[$tam]=$response->detalle[$i]->DESMED;
			$ar_total[$l]=$ar_aux;
			$l++;
			$ant_nom=$response->detalle[$i]->DESMED;
		}
		if ($i==0) {
			$l=0;
			$ar_aux=$ar_total[$l];
			$tam=count($ar_aux);
			$ar_aux[$tam]=$response->detalle[$i]->DESMEDCOR;
			$ar_total[$l]=$ar_aux;
			$l++;
			$ar_aux=$ar_total[$l];
			$tam=count($ar_aux);
			$ar_aux[$tam]=$response->detalle[$i]->DESMED;
			$ar_total[$l]=$ar_aux;
			$l++;
		}
		$ar_aux=$ar_total[$l];
		$tam=count($ar_aux);
		$ar_aux[$tam]=$response->detalle[$i]->VALOR;
		$ar_total[$l]=$ar_aux;
		$l++;
	}
?>
<table>
	<thead>
		<tr>
<?php
	for ($i=0; $i < count($ar_total); $i++) {
			if ($i==2) {
?>
	</thead>
	<tbody>
<?php
			}
?>
		<tr>
<?php
		for ($k=0; $k < count($ar_total[$i]); $k++) { 
			if ($i<2) {
?>
			<th style="border:1px solid #333;"><?php echo $ar_total[$i][$k]; ?></th>
<?php
			}else{
?>
			<td style="border:1px solid #333;"><?php echo $ar_total[$i][$k]; ?></td>
<?php
			}
		}
?>
		</tr>
<?php
	}
?>
	</tbody>
</table>
<br>
<?php
	$ar_detalle=array();
	$l=0;
	for ($i = 0; $i < count($response->talla); $i++) {
		$ar_detalle[$l]= array('');
		$l++;
	}
	$l=0;
	for ($i = 0; $i < count($response->talla); $i++) {
		$ar_aux=$ar_detalle[$l];
		$tam=count($ar_aux);
		$ar_aux[$tam]=$response->talla[$i]->DESTAL;
		$ar_detalle[$l]=$ar_aux;
		$l++;
	}
	$ant_nom=$response->detalle[0]->DESMED;
	for ($i = 0; $i < count($response->detalle); $i++) {
		if ($response->detalle[$i]->DESMED!=$ant_nom) {
			$l=0;
			for ($k = 0; $k < count($response->detalletalla); $k++) {
				if ($response->detalletalla[$k]->DESMED==$ant_nom) {
					$ar_aux=$ar_detalle[$l];
					$tam=count($ar_aux);
					$ar_aux[$tam]=$response->detalletalla[$k]->MEDIDA;
					$ar_detalle[$l]=$ar_aux;
					$l++;
				}
			}
			$ant_nom=$response->detalle[$i]->DESMED;
		}
	}
	$ant_nom=$response->detalle[count($response->detalle)-1]->DESMED;
	$l=0;
	for ($k = 0; $k < count($response->detalletalla); $k++) {
		if ($response->detalletalla[$k]->DESMED==$ant_nom) {
			$ar_aux=$ar_detalle[$l];
			$tam=count($ar_aux);
			$ar_aux[$tam]=$response->detalletalla[$k]->MEDIDA;
			$ar_detalle[$l]=$ar_aux;
			$l++;
		}
	}
?>
<table>
	<tbody>
		<tr>
<?php
	for ($i=0; $i < count($ar_detalle); $i++) {
?>
		<tr>
<?php
		for ($k=0; $k < count($ar_detalle[$i]); $k++) {
			if ($k==0) {
?>
			<td><?php echo $ar_detalle[$i][$k]; ?></td>
<?php
			}else{
?>
			<td style="border:1px solid #333;"><?php echo $ar_detalle[$i][$k]; ?></td>
<?php
			}
		}
?>
		</tr>
<?php
	}
?>
	</tbody>
</table>