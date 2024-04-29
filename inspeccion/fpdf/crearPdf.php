<?php
set_time_limit(120);
function format_text_month($text){
	switch ($text) {
		case '01':
			$text='Ene.';
			break;
		case '02':
			$text='Feb.';
			break;
		case '03':
			$text='Mar.';
			break;
		case '04':
			$text='Abr.';
			break;
		case '05':
			$text='May.';
			break;
		case '06':
			$text='Jun.';
			break;
		case '07':
			$text='Jul.';
			break;
		case '08':
			$text='Ago.';
			break;
		case '09':
			$text='Set.';
			break;
		case '10':
			$text='Oct.';
			break;
		case '11':
			$text='Nov.';
			break;
		case '12':
			$text='Dic.';
			break;
		default:
			# code...
			break;
	}
	return $text;
}

function getPercentValue($value){
	$value=str_replace("%","",$value);
	return (float)$value;
}

require('fpdf181/fpdf.php');
class PDF extends FPDF {
	const DPI = 96;
	const MM_IN_INCH = 25.4;
	const A4_HEIGHT = 297;
	const A4_WIDTH = 210;
	const WIDTH_MARGIN = 5;
	// tweak these values (in pixels)
	const MAX_WIDTH = 	2450;
	const MAX_WIDTH_TO_WHITE = 190;

	function resizeToFit($imgFilename) {
		list($width, $height) = getimagesize($imgFilename);
		$width=2100;
		$height=1050;
		$widthScale = self::A4_WIDTH/self::MAX_WIDTH;
		$scale = $widthScale;
		$posX=(self::A4_WIDTH-($scale * $width)-self::WIDTH_MARGIN)/2;
		return array(round($scale * $width),round($scale * $height),$posX);
		//return array(round($this->pixelsToMM($scale * $width)),round($this->pixelsToMM($scale * $height)));
	}
	function get_max_width_to_white() {
		return self::MAX_WIDTH_TO_WHITE;
	}
}
include("../config/connection.php");

$file_path_dir='../assets/tmp/';
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("INDICADORES DE RESULTADOS DE INSPECCIÓN DE COSTURA"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',13);

$file_path=$file_path_dir.$_GET['n'].'.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();
/*
$sql="select * from taller";
$stmt=oci_parse($conn, $sql);
$result=oci_execute($stmt);

$pdf->Ln();

$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(128,0,0);
$pdf->SetLineWidth(.3);
$pdf->Cell(50,6,"COD. TALLER",1,0,'C');
$pdf->Cell(110,6,"NOMBRE",1,0,'C');
$pdf->Ln();

$i=0;
while($row=oci_fetch_array($stmt) and $i<10){
    $pdf->Cell(50,6,$row[0],'LR');
    $pdf->Cell(110,6,$row[1],'LR');
    $pdf->Ln();
	$i++;
}
$pdf->Cell(160,0,'','T');
*/
$pdf->Image($file_path , $array[2],22,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);


$headers=[];
$headers[0]="DETALLE GENERAL";
$pre_apr=[];
$pre_apr[0]="PRENDAS APRO.";
$pre_rec=[];
$pre_rec[0]="PRENDAS RECH.";
$pre_tot=[];
$pre_tot[0]="TOTAL PRENDAS";
$por_pre_apr=[];
$por_pre_apr[0]="% APRO.";
$por_pre_rec=[];
$por_pre_rec[0]="% RECH.";
$l=1;

$ar_fecha=explode("-",$_GET['fecha']);
$fecha=$ar_fecha[2].$ar_fecha[1].$ar_fecha[0];

$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]=$row['ANHO'];
	$pre_apr[$l]=number_format($row['PRE_SINDEF']);
	$pre_rec[$l]=number_format($row['PRE_DEF']);
	$pre_tot[$l]=number_format($row['PRE_TOT']);
	$por_pre_apr[$l]=(round($row['PRE_SINDEF']*10000/$row['PRE_TOT'])/100)."%";
	$por_pre_rec[$l]=(round($row['PRE_DEF']*10000/$row['PRE_TOT'])/100)."%";
	$l++;
}

$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]=format_text_month($row['MES']);
	$pre_apr[$l]=number_format($row['PRE_SINDEF']);
	$pre_rec[$l]=number_format($row['PRE_DEF']);
	$pre_tot[$l]=number_format($row['PRE_TOT']);
	$por_pre_apr[$l]=(round($row['PRE_SINDEF']*10000/$row['PRE_TOT'])/100)."%";
	$por_pre_rec[$l]=(round($row['PRE_DEF']*10000/$row['PRE_TOT'])/100)."%";
	$l++;
}

$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=2;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]='Sem. '.$row['NUMERO_SEMANA'];
	$pre_apr[$l]=number_format($row['PRE_SINDEF']);
	$pre_rec[$l]=number_format($row['PRE_DEF']);
	$pre_tot[$l]=number_format($row['PRE_TOT']);
	$por_pre_apr[$l]=(round($row['PRE_SINDEF']*10000/$row['PRE_TOT'])/100)."%";
	$por_pre_rec[$l]=(round($row['PRE_DEF']*10000/$row['PRE_TOT'])/100)."%";
	$l++;
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$first_col_width=40;
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/(count($headers)-1);

for ($i=0; $i < count($headers); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$headers[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$headers[$i],1,0,'L',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
for ($i=0; $i < count($pre_apr); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_apr[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_apr[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($pre_rec); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_rec[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_rec[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($pre_tot); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_tot[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_tot[$i],1,0);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_pre_apr); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_pre_apr[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$porcen=getPercentValue($por_pre_apr[$i]);
		if ($porcen<85) {			
			$pdf->SetFillColor(220,20,30);
		}else{
			if($porcen>=95){
				$pdf->SetFillColor(90,195,40);
			}else{
				$pdf->SetFillColor(220,160,10);				
			}
		}
		$pdf->Cell($width_by_cell,6,$por_pre_apr[$i],1,0,'L',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_pre_rec); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_pre_rec[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_pre_rec[$i],1,0);
	}
}

/////////// PAGINA 2

$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 1"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t2']),0,0,'C');

$file_path=$file_path_dir.$_GET['n'].'-2.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],22,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDU=0;
$coddefuno=0;
$coddefdos=0;
$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=3;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if ($i==0) {
		$coddefuno=$row['CODFAMILIA'];
	}
	if ($i==1) {
		$coddefdos=$row['CODFAMILIA'];
	}
	$obj=new stdClass();
	$obj->CODFAMILIA=$row['CODFAMILIA'];
	$obj->DSCFAMILIA=utf8_encode($row['DSCFAMILIA']);
	$obj->SUMA=$row['SUMA'];
	$defuno[$i]=$obj;
	$i++;
	$sumDU+=(int)$row['SUMA'];
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[80,40,30,40];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) { 
	$porcen=round($defuno[$i]->SUMA*10000/$sumDU)/100;
	$sumPorce+=$porcen;
	if ($sumPorce>100) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DSCFAMILIA),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Ln();
}

/////////////PAGINA 3
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 1"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t3']),0,0,'C');

$file_path=$file_path_dir.$_GET['n'].'-3.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],22,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defunomes=[];
$i=0;
$sumDUM=0;
$coddefunoM=0;
$coddefdosM=0;
$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=4;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if ($i==0) {
		$coddefunoM=$row['CODFAMILIA'];
	}
	if ($i==1) {
		$coddefdosM=$row['CODFAMILIA'];
	}
	$obj=new stdClass();
	$obj->CODFAMILIA=$row['CODFAMILIA'];
	$obj->DSCFAMILIA=utf8_encode($row['DSCFAMILIA']);
	$obj->SUMA=$row['SUMA'];
	$defunomes[$i]=$obj;
	$i++;
	$sumDUM+=(int)$row['SUMA'];
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[80,40,30,40];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defunomes); $i++) { 
	$porcen=round($defunomes[$i]->SUMA*10000/$sumDUM)/100;
	$sumPorce+=$porcen;
	if ($sumPorce>100) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defunomes[$i]->DSCFAMILIA),1,0);
	$pdf->Cell($width_by_cell[1],6,$defunomes[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Ln();
}

/////////////////PAGINA 4
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 2"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t4']),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. ".utf8_decode($_GET['t4_1'])." (1er Mayor Defecto)",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-4.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);


$defuno=[];
$i=0;
$sumDefectosU=0;
$sumaOtros=0;
$activate=false;
$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODFAM', $coddefuno);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if($i<15){
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		if ($row['SUMA']==null) {
			$sumDefectosU+=0;
			$obj->SUMA=0;
		}else{
			$sumDefectosU+=(int)$row['SUMA'];
			$obj->SUMA=$row['SUMA'];
		}
		$defuno[$i]=$obj;
		$i++;
	}else{
		$sumDefectosU+=(int)$row['SUMA'];
		$activate=true;
		$sumaOtros+=(int)$row['SUMA'];
	}
}
if($activate){
	$obj=new stdClass();
	$obj->CODDEF="0";
	$obj->DESDEF="OTROS";
	$obj->SUMA=$sumaOtros;
	$defuno[$i]=$obj;
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[75,25,25,25,10,30];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO","","% DEL GENERAL"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);
$pdf->Cell($width_by_cell[4],6,$headers[4],0,0);
$pdf->Cell($width_by_cell[5],6,$headers[5],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
	$pdf->SetFillColor(10,70,150);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) { 
	$porcen=round($defuno[$i]->SUMA*10000/$sumDefectosU)/100;
	$porcen2=round($defuno[$i]->SUMA*10000/$sumDU)/100;
	$sumPorce+=$porcen;
	if ($sumPorce>100 || $i==count($defuno)-1) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DESDEF),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Cell($width_by_cell[4],6,"",0,0);
	$pdf->SetFillColor(210,210,210);
	$pdf->Cell($width_by_cell[5],6,$porcen2."%",1,0,'L',true);
	$pdf->SetFillColor(0,0,0);
	$pdf->Ln();
}

/////////////////PAGINA 5
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 2"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t4']),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. ".utf8_decode($_GET['t4_2'])." (2do Mayor Defecto)",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-5.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDefectosD=0;
$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODFAM', $coddefdos);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if($i<15){
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		if ($row['SUMA']==null) {
			$sumDefectosD+=0;
			$obj->SUMA=0;
		}else{
			$sumDefectosD+=(int)$row['SUMA'];
			$obj->SUMA=$row['SUMA'];
		}
		$defuno[$i]=$obj;
		$i++;
	}else{
		$sumDefectosD+=(int)$row['SUMA'];
		$activate=true;
		$sumaOtros+=(int)$row['SUMA'];
	}
}
if($activate){
	$obj=new stdClass();
	$obj->CODDEF="0";
	$obj->DESDEF="OTROS";
	$obj->SUMA=$sumaOtros;
	$defuno[$i]=$obj;
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[75,25,25,25,10,30];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO","","% DEL GENERAL"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);
$pdf->Cell($width_by_cell[4],6,$headers[4],0,0);
$pdf->Cell($width_by_cell[5],6,$headers[5],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) { 
	$porcen=round($defuno[$i]->SUMA*10000/$sumDefectosD)/100;
	$porcen2=round($defuno[$i]->SUMA*10000/$sumDU)/100;
	$sumPorce+=$porcen;
	if ($sumPorce>100 || $i==count($defuno)-1) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DESDEF),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Cell($width_by_cell[4],6,"",0,0);
	$pdf->SetFillColor(210,210,210);
	$pdf->Cell($width_by_cell[5],6,$porcen2."%",1,0,'L',true);
	$pdf->SetFillColor(0,0,0);
	$pdf->Ln();
}

/////////////////PAGINA 6
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 2"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t5']),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. ".utf8_decode($_GET['t5_1'])." (1er Mayor Defecto)",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-6.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDefectosUM=0;
$sumaOtros=0;
$activate=false;
$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODFAM', $coddefunoM);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if($i<15){
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		if ($row['SUMA']==null) {
			$sumDefectosUM+=0;
			$obj->SUMA=0;
		}else{
			$sumDefectosUM+=(int)$row['SUMA'];
			$obj->SUMA=$row['SUMA'];
		}
		$defuno[$i]=$obj;
		$i++;
	}else{
		$sumDefectosUM+=(int)$row['SUMA'];
		$activate=true;
		$sumaOtros+=(int)$row['SUMA'];
	}
}
if($activate){
	$obj=new stdClass();
	$obj->CODDEF="0";
	$obj->DESDEF="OTROS";
	$obj->SUMA=$sumaOtros;
	$defuno[$i]=$obj;
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[75,25,25,25,10,30];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO","","% DEL GENERAL"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);
$pdf->Cell($width_by_cell[4],6,$headers[4],0,0);
$pdf->Cell($width_by_cell[5],6,$headers[5],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) { 
	$porcen=round($defuno[$i]->SUMA*10000/$sumDefectosUM)/100;
	$porcen2=round($defuno[$i]->SUMA*10000/$sumDUM)/100;
	$sumPorce+=$porcen;
	if ($sumPorce>100 || $i==count($defuno)-1) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DESDEF),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Cell($width_by_cell[4],6,"",0,0);
	$pdf->SetFillColor(210,210,210);
	$pdf->Cell($width_by_cell[5],6,$porcen2."%",1,0,'L',true);
	$pdf->SetFillColor(0,0,0);
	$pdf->Ln();
}

/////////////////PAGINA 7
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 2"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t5']),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. ".utf8_decode($_GET['t5_2'])." (2do Mayor Defecto)",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-7.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDefectosDM=0;
$sumaOtros=0;
$activate=false;
$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODFAM', $coddefdosM);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if($i<15){
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->SUMA=$row['SUMA'];
		$defuno[$i]=$obj;
		$i++;
		$sumDefectosDM+=(int)$row['SUMA'];
	}else{
		$sumDefectosDM+=(int)$row['SUMA'];
		$activate=true;
		$sumaOtros+=(int)$row['SUMA'];
	}
}
if($activate){
	$obj=new stdClass();
	$obj->CODDEF="0";
	$obj->DESDEF="OTROS";
	$obj->SUMA=$sumaOtros;
	$defuno[$i]=$obj;
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[75,25,25,25,10,30];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO","","% DEL GENERAL"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);
$pdf->Cell($width_by_cell[4],6,$headers[4],0,0);
$pdf->Cell($width_by_cell[5],6,$headers[5],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) { 
	$porcen=round($defuno[$i]->SUMA*10000/$sumDefectosDM)/100;
	$porcen2=round($defuno[$i]->SUMA*10000/$sumDUM)/100;
	$sumPorce+=$porcen;
	if ($sumPorce>100 || $i==count($defuno)-1) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DESDEF),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Cell($width_by_cell[4],6,"",0,0);
	$pdf->SetFillColor(210,210,210);
	$pdf->Cell($width_by_cell[5],6,$porcen2."%",1,0,'L',true);
	$pdf->SetFillColor(0,0,0);
	$pdf->Ln();
}

$pdf->Output('D','Indicar de Resultados - '.str_replace("/","-",$_GET['t']).'.pdf',true);
//$pdf->Output('','',true);

oci_close($conn);

//// DELETE FILES
$files = glob("../assets/tmp/*"); 
foreach($files as $file){
    if(is_file($file) && strpos($file,$_GET['n'])){
        unlink($file);
    }
}
?>