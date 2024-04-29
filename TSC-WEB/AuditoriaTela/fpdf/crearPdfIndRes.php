<?php
set_time_limit(240);
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
	return floatval($value);
}

function format_number_miles($value){
	if (strpos($value,"%")!==false) {
		return $value;
	}else{
		return number_format($value);
	}
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
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("INDICADORES DE RESULTADOS DE AUDITORÍA TELAS"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',10);

$file_path=$file_path_dir.$_GET['n'].'.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();
$pdf->Image($file_path , $array[2],22,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);


$headers=[];
$headers[0]="DETALLE GENERAL";
$aud_tot=[];
$aud_tot[0]="# TOT. KG.";
$aud_apr=[];
$aud_apr[0]="# TOT. KG. APR.";
$aud_anc=[];
$aud_anc[0]="# TOT. KG. ANC";
$aud_rec=[];
$aud_rec[0]="# TOT. KG. REC.";
$por_apr=[];
$por_apr[0]="% KG. APR.";
$por_anc=[];
$por_anc[0]="% KG. ANC";
$por_rec=[];
$por_rec[0]="% KG. REC.";
$num_tot=[];
$num_tot[0]="# TOT. AUD.";
$num_apr=[];
$num_apr[0]="# TOT. AUD. APR.";
$num_anc=[];
$num_anc[0]="# TOT. AUD. ANC";
$num_rec=[];
$num_rec[0]="# TOT. AUD. REC.";
$por_num_apr=[];
$por_num_apr[0]="% AUD. APR.";
$por_num_anc=[];
$por_num_anc[0]="% AUD. ANC";
$por_num_rec=[];
$por_num_rec[0]="% AUD. REC.";
$l=1;

$ar_fecha=explode("-",$_GET['fecha']);
$fecha=$ar_fecha[2].$ar_fecha[1].$ar_fecha[0];

$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':BLOQUE', $_GET['bloque']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]=$row['ANHO'];
	$aud_tot[$l]=number_format(str_replace(",",".",$row['PESTOT']));
	$aud_apr[$l]=number_format(str_replace(",",".",$row['PESAPR']));
	$aud_anc[$l]=number_format(str_replace(",",".",$row['PESCON']));
	$aud_rec[$l]=number_format(str_replace(",",".",$row['PESREC']));
	if ($row['PESTOT']!=0) {
		$por_apr[$l]=(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
		$por_anc[$l]=(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
		$por_rec[$l]=(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
	}else{
		$por_apr[$l]="0%";
		$por_anc[$l]="0%";
		$por_rec[$l]="0%";
	}
	$num_tot[$l]=number_format(str_replace(",",".",$row['CANTOT']));
	$num_apr[$l]=number_format(str_replace(",",".",$row['CANAPR']));
	$num_anc[$l]=number_format(str_replace(",",".",$row['CANCON']));
	$num_rec[$l]=number_format(str_replace(",",".",$row['CANREC']));
	if ($row['CANTOT']!=0) {
		$por_num_apr[$l]=(round(str_replace(",",".",$row['CANAPR'])*10000/str_replace(",",".",$row['CANTOT']))/100)."%";
		$por_num_anc[$l]=(round(str_replace(",",".",$row['CANCON'])*10000/str_replace(",",".",$row['CANTOT']))/100)."%";
		$por_num_rec[$l]=(round(str_replace(",",".",$row['CANREC'])*10000/str_replace(",",".",$row['CANTOT']))/100)."%";
	}else{
		$por_num_apr[$l]="0%";
		$por_num_anc[$l]="0%";
		$por_num_rec[$l]="0%";
	}
	$l++;
}

$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':BLOQUE', $_GET['bloque']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]=format_text_month($row['MES']);
	$aud_tot[$l]=number_format(str_replace(",",".",$row['PESTOT']));
	$aud_apr[$l]=number_format(str_replace(",",".",$row['PESAPR']));
	$aud_anc[$l]=number_format(str_replace(",",".",$row['PESCON']));
	$aud_rec[$l]=number_format(str_replace(",",".",$row['PESREC']));
	if ($row['PESTOT']!=0) {
		$por_apr[$l]=(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
		$por_anc[$l]=(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
		$por_rec[$l]=(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
	}else{
		$por_apr[$l]="0%";
		$por_anc[$l]="0%";
		$por_rec[$l]="0%";
	}
	$num_tot[$l]=number_format(str_replace(",",".",$row['CANTOT']));
	$num_apr[$l]=number_format(str_replace(",",".",$row['CANAPR']));
	$num_anc[$l]=number_format(str_replace(",",".",$row['CANCON']));
	$num_rec[$l]=number_format(str_replace(",",".",$row['CANREC']));
	if ($row['CANTOT']!=0) {
		$por_num_apr[$l]=(round(str_replace(",",".",$row['CANAPR'])*10000/str_replace(",",".",$row['CANTOT']))/100)."%";
		$por_num_anc[$l]=(round(str_replace(",",".",$row['CANCON'])*10000/str_replace(",",".",$row['CANTOT']))/100)."%";
		$por_num_rec[$l]=(round(str_replace(",",".",$row['CANREC'])*10000/str_replace(",",".",$row['CANTOT']))/100)."%";
	}else{
		$por_num_apr[$l]="0%";
		$por_num_anc[$l]="0%";
		$por_num_rec[$l]="0%";
	}
	$l++;
}

$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':BLOQUE', $_GET['bloque']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=2;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]='Sem. '.$row['NUMERO_SEMANA'];
	$aud_tot[$l]=number_format(str_replace(",",".",$row['PESTOT']));
	$aud_apr[$l]=number_format(str_replace(",",".",$row['PESAPR']));
	$aud_anc[$l]=number_format(str_replace(",",".",$row['PESCON']));
	$aud_rec[$l]=number_format(str_replace(",",".",$row['PESREC']));
	if ($row['PESTOT']!=0) {
		$por_apr[$l]=(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
		$por_anc[$l]=(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
		$por_rec[$l]=(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
	}else{
		$por_apr[$l]="0%";
		$por_anc[$l]="0%";
		$por_rec[$l]="0%";
	}
	$num_tot[$l]=number_format(str_replace(",",".",$row['CANTOT']));
	$num_apr[$l]=number_format(str_replace(",",".",$row['CANAPR']));
	$num_anc[$l]=number_format(str_replace(",",".",$row['CANCON']));
	$num_rec[$l]=number_format(str_replace(",",".",$row['CANREC']));
	if ($row['CANTOT']!=0) {
		$por_num_apr[$l]=(round(str_replace(",",".",$row['CANAPR'])*10000/str_replace(",",".",$row['CANTOT']))/100)."%";
		$por_num_anc[$l]=(round(str_replace(",",".",$row['CANCON'])*10000/str_replace(",",".",$row['CANTOT']))/100)."%";
		$por_num_rec[$l]=(round(str_replace(",",".",$row['CANREC'])*10000/str_replace(",",".",$row['CANTOT']))/100)."%";
	}else{
		$por_num_apr[$l]="0%";
		$por_num_anc[$l]="0%";
		$por_num_rec[$l]="0%";
	}
	$l++;
}

$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$first_col_width=35;
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
for ($i=0; $i < count($aud_tot); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_tot[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_tot[$i],1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($aud_apr); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_apr[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_apr[$i],1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($aud_anc); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_anc[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_anc[$i],1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($aud_rec); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_rec[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_rec[$i],1,0,'R');
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_apr); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_apr[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$porcen=getPercentValue($por_apr[$i]);
		if ($porcen<number_format($_GET['ran2'])) {			
			$pdf->SetFillColor(220,20,30);
		}else{
			if($porcen>=number_format($_GET['ran1'])){
				$pdf->SetFillColor(90,195,40);
			}else{
				$pdf->SetFillColor(220,160,10);				
			}
		}
		$pdf->Cell($width_by_cell,6,$por_apr[$i],1,0,'R',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_anc); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_anc[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_anc[$i],1,0,'R');
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_rec); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_rec[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_rec[$i],1,0,'R');
	}
}
$pdf->Ln();
$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
for ($i=0; $i < count($num_tot); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$num_tot[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$num_tot[$i],1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($num_apr); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$num_apr[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$num_apr[$i],1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($num_anc); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$num_anc[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$num_anc[$i],1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($num_rec); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$num_rec[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$num_rec[$i],1,0,'R');
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_num_apr); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_num_apr[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$porcen=getPercentValue($por_num_apr[$i]);
		if ($porcen<number_format($_GET['ran2'])) {			
			$pdf->SetFillColor(220,20,30);
		}else{
			if($porcen>=number_format($_GET['ran1'])){
				$pdf->SetFillColor(90,195,40);
			}else{
				$pdf->SetFillColor(220,160,10);				
			}
		}
		$pdf->Cell($width_by_cell,6,$por_num_apr[$i],1,0,'R',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_num_anc); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_num_anc[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_num_anc[$i],1,0,'R');
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_num_rec); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_num_rec[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_num_rec[$i],1,0,'R');
	}
}
$pdf->Ln();

//echo $fecha." - ".$_GET['codusu']." - ".$_GET['codusueje']." - ".$_GET['bloque']."<br>";
if ($_GET['codprv']=="0") {
	$headers=[];
	$headers[0]="PROVEEDORES";
	$headers[1]="DETALLE GENERAL";
	$h=2;
	$body=[];
	$b=0;
	$ant_prv="";
	$sql="BEGIN SP_AUDTEL_INDRESPRVAUX(:FECHA,:OPCION,:CODUSU,:CODUSUEJE,:BLOQUE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
	oci_bind_by_name($stmt, ':BLOQUE', $_GET['bloque']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$val=true;
		$tam=count($headers);
		$j=0;
		while($val==true and $j<$tam){
			if ($headers[$j]==$row['ANHO']) {
				$val=false;
			}
			$j++;
		}
		if ($val) {
			$headers[$h]=$row['ANHO'];
			$h++;
		}
		if (utf8_encode($row['DESCLI'])!=$ant_prv) {
			$ant_prv=utf8_encode($row['DESCLI']);
			if ($row['PESTOT']!=0) {			
				$body[$b]=array($ant_prv,
					array(
						array("# TOT. KG.",str_replace(",",".",$row['PESTOT'])),
						array("# TOT. KG. APR.",str_replace(",",".",$row['PESAPR'])),
						array("# TOT. KG. ANC",str_replace(",",".",$row['PESCON'])),
						array("# TOT. KG. REC.",str_replace(",",".",$row['PESREC'])),
						array("% KG. APR.",(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%"),
						array("% KG. ANC",(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%"),
						array("% KG. REC.",(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%")
					)
				);
			}else{		
				$body[$b]=array($ant_prv,
					array(
						array("# TOT. KG.",str_replace(",",".",$row['PESTOT'])),
						array("# TOT. KG. APR.",str_replace(",",".",$row['PESAPR'])),
						array("# TOT. KG. ANC",str_replace(",",".",$row['PESCON'])),
						array("# TOT. KG. REC.",str_replace(",",".",$row['PESREC'])),
						array("% KG. APR.","0%"),
						array("% KG. ANC","0%"),
						array("% KG. REC.","0%")
					)
				);
			}
			$b++;
		}else{
			$aux=$body[$b-1][1][0];
			$aux[count($aux)]=str_replace(",",".",$row['PESTOT']);
			$body[$b-1][1][0]=$aux;
			$aux=$body[$b-1][1][1];
			$aux[count($aux)]=str_replace(",",".",$row['PESAPR']);
			$body[$b-1][1][1]=$aux;
			$aux=$body[$b-1][1][2];
			$aux[count($aux)]=str_replace(",",".",$row['PESCON']);
			$body[$b-1][1][2]=$aux;
			$aux=$body[$b-1][1][3];
			$aux[count($aux)]=str_replace(",",".",$row['PESREC']);
			$body[$b-1][1][3]=$aux;
			if ($row['PESTOT']!=0) {
				$aux=$body[$b-1][1][4];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b-1][1][4]=$aux;
				$aux=$body[$b-1][1][5];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b-1][1][5]=$aux;
				$aux=$body[$b-1][1][6];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b-1][1][6]=$aux;
			}else{			
				$aux=$body[$b-1][1][4];
				$aux[count($aux)]="0%";
				$body[$b-1][1][4]=$aux;
				$aux=$body[$b-1][1][5];
				$aux[count($aux)]="0%";
				$body[$b-1][1][5]=$aux;
				$aux=$body[$b-1][1][6];
				$aux[count($aux)]="0%";
				$body[$b-1][1][6]=$aux;
			}
		}
	}

	$ant_prv="";
	$b=0;
	$sql="BEGIN SP_AUDTEL_INDRESPRVAUX(:FECHA,:OPCION,:CODUSU,:CODUSUEJE,:BLOQUE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
	oci_bind_by_name($stmt, ':BLOQUE', $_GET['bloque']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$val=true;
		$tam=count($headers);
		$j=0;
		while($val==true and $j<$tam){
			if ($headers[$j]==format_text_month($row['MES'])) {
				$val=false;
			}
			$j++;
		}
		if ($val) {
			$headers[$h]=format_text_month($row['MES']);
			$h++;
		}
		if (utf8_encode($row['DESCLI'])!=$ant_prv) {
			$ant_prv=utf8_encode($row['DESCLI']);
			$aux=$body[$b][1][0];
			$aux[count($aux)]=str_replace(",",".",$row['PESTOT']);
			$body[$b][1][0]=$aux;
			$aux=$body[$b][1][1];
			$aux[count($aux)]=str_replace(",",".",$row['PESAPR']);
			$body[$b][1][1]=$aux;
			$aux=$body[$b][1][2];
			$aux[count($aux)]=str_replace(",",".",$row['PESCON']);
			$body[$b][1][2]=$aux;
			$aux=$body[$b][1][3];
			$aux[count($aux)]=str_replace(",",".",$row['PESREC']);
			$body[$b][1][3]=$aux;
			if ($row['PESTOT']!=0) {
				$aux=$body[$b][1][4];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b][1][4]=$aux;
				$aux=$body[$b][1][5];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b][1][5]=$aux;
				$aux=$body[$b][1][6];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b][1][6]=$aux;
			}else{			
				$aux=$body[$b][1][4];
				$aux[count($aux)]="0%";
				$body[$b][1][4]=$aux;
				$aux=$body[$b][1][5];
				$aux[count($aux)]="0%";
				$body[$b][1][5]=$aux;
				$aux=$body[$b][1][6];
				$aux[count($aux)]="0%";
				$body[$b][1][6]=$aux;
			}/*
			if ($row['PESTOT']!=0) {			
				$body[$b]=array($ant_prv,
					array(
						array("# TOT. KG.",str_replace(",",".",$row['PESTOT'])),
						array("# TOT. KG. APR.",str_replace(",",".",$row['PESAPR'])),
						array("# TOT. KG. ANC",str_replace(",",".",$row['PESCON'])),
						array("# TOT. KG. REC.",str_replace(",",".",$row['PESREC'])),
						array("% KG. APR.",(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%"),
						array("% KG. ANC",(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%"),
						array("% KG. REC.",(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%")
					)
				);
			}else{		
				$body[$b]=array($ant_prv,
					array(
						array("# TOT. KG.",str_replace(",",".",$row['PESTOT'])),
						array("# TOT. KG. APR.",str_replace(",",".",$row['PESAPR'])),
						array("# TOT. KG. ANC",str_replace(",",".",$row['PESCON'])),
						array("# TOT. KG. REC.",str_replace(",",".",$row['PESREC'])),
						array("% KG. APR.","0%"),
						array("% KG. ANC","0%"),
						array("% KG. REC.","0%")
					)
				);
			}*/
			$b++;
		}else{
			$aux=$body[$b-1][1][0];
			$aux[count($aux)]=str_replace(",",".",$row['PESTOT']);
			$body[$b-1][1][0]=$aux;
			$aux=$body[$b-1][1][1];
			$aux[count($aux)]=str_replace(",",".",$row['PESAPR']);
			$body[$b-1][1][1]=$aux;
			$aux=$body[$b-1][1][2];
			$aux[count($aux)]=str_replace(",",".",$row['PESCON']);
			$body[$b-1][1][2]=$aux;
			$aux=$body[$b-1][1][3];
			$aux[count($aux)]=str_replace(",",".",$row['PESREC']);
			$body[$b-1][1][3]=$aux;
			if ($row['PESTOT']!=0) {
				$aux=$body[$b-1][1][4];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b-1][1][4]=$aux;
				$aux=$body[$b-1][1][5];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b-1][1][5]=$aux;
				$aux=$body[$b-1][1][6];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b-1][1][6]=$aux;
			}else{			
				$aux=$body[$b-1][1][4];
				$aux[count($aux)]="0%";
				$body[$b-1][1][4]=$aux;
				$aux=$body[$b-1][1][5];
				$aux[count($aux)]="0%";
				$body[$b-1][1][5]=$aux;
				$aux=$body[$b-1][1][6];
				$aux[count($aux)]="0%";
				$body[$b-1][1][6]=$aux;
			}
		}
	}

	$ant_prv="";
	$b=0;
	$sql="BEGIN SP_AUDTEL_INDRESPRVAUX(:FECHA,:OPCION,:CODUSU,:CODUSUEJE,:BLOQUE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=2;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
	oci_bind_by_name($stmt, ':BLOQUE', $_GET['bloque']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$val=true;
		$tam=count($headers);
		$j=0;
		while($val==true and $j<$tam){
			if ($headers[$j]=="Sem. ".$row['NUMERO_SEMANA']) {
				$val=false;
			}
			$j++;
		}
		if ($val) {
			$headers[$h]="Sem. ".$row['NUMERO_SEMANA'];
			$h++;
		}
		if (utf8_encode($row['DESCLI'])!=$ant_prv) {
			$ant_prv=utf8_encode($row['DESCLI']);
			$aux=$body[$b][1][0];
			$aux[count($aux)]=str_replace(",",".",$row['PESTOT']);
			$body[$b][1][0]=$aux;
			$aux=$body[$b][1][1];
			$aux[count($aux)]=str_replace(",",".",$row['PESAPR']);
			$body[$b][1][1]=$aux;
			$aux=$body[$b][1][2];
			$aux[count($aux)]=str_replace(",",".",$row['PESCON']);
			$body[$b][1][2]=$aux;
			$aux=$body[$b][1][3];
			$aux[count($aux)]=str_replace(",",".",$row['PESREC']);
			$body[$b][1][3]=$aux;
			if ($row['PESTOT']!=0) {
				$aux=$body[$b][1][4];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b][1][4]=$aux;
				$aux=$body[$b][1][5];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b][1][5]=$aux;
				$aux=$body[$b][1][6];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b][1][6]=$aux;
			}else{			
				$aux=$body[$b][1][4];
				$aux[count($aux)]="0%";
				$body[$b][1][4]=$aux;
				$aux=$body[$b][1][5];
				$aux[count($aux)]="0%";
				$body[$b][1][5]=$aux;
				$aux=$body[$b][1][6];
				$aux[count($aux)]="0%";
				$body[$b][1][6]=$aux;
			}
			$b++;
		}else{
			$aux=$body[$b-1][1][0];
			$aux[count($aux)]=str_replace(",",".",$row['PESTOT']);
			$body[$b-1][1][0]=$aux;
			$aux=$body[$b-1][1][1];
			$aux[count($aux)]=str_replace(",",".",$row['PESAPR']);
			$body[$b-1][1][1]=$aux;
			$aux=$body[$b-1][1][2];
			$aux[count($aux)]=str_replace(",",".",$row['PESCON']);
			$body[$b-1][1][2]=$aux;
			$aux=$body[$b-1][1][3];
			$aux[count($aux)]=str_replace(",",".",$row['PESREC']);
			$body[$b-1][1][3]=$aux;
			if ($row['PESTOT']!=0) {
				$aux=$body[$b-1][1][4];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESAPR'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b-1][1][4]=$aux;
				$aux=$body[$b-1][1][5];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESCON'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b-1][1][5]=$aux;
				$aux=$body[$b-1][1][6];
				$aux[count($aux)]=(round(str_replace(",",".",$row['PESREC'])*10000/str_replace(",",".",$row['PESTOT']))/100)."%";
				$body[$b-1][1][6]=$aux;
			}else{			
				$aux=$body[$b-1][1][4];
				$aux[count($aux)]="0%";
				$body[$b-1][1][4]=$aux;
				$aux=$body[$b-1][1][5];
				$aux[count($aux)]="0%";
				$body[$b-1][1][5]=$aux;
				$aux=$body[$b-1][1][6];
				$aux[count($aux)]="0%";
				$body[$b-1][1][6]=$aux;
			}
		}
	}


	$pdf->Ln();

	$pdf->SetFont('Arial','',6);
	$pdf->SetFillColor(10,70,150);
	$pdf->SetTextColor(255);

	$first_col_width=20;
	$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width*2)/(count($headers)-2);

	for ($i=0; $i < count($headers); $i++) { 
		if ($i<2) {
			$pdf->Cell($first_col_width,6,$headers[$i],1,0,'L',true);
		}else{
			$pdf->Cell($width_by_cell,6,$headers[$i],1,0,'L',true);
		}
	}
	$pdf->Ln();

	$pdf->SetTextColor(0);
	$colorfondo=0;
	for ($i=0; $i < count($body); $i++) {
		if ($i%2==0) {
			$pdf->SetFillColor(200);
			$colorfondo=0;
		}else{
			$pdf->SetFillColor(255);
			$colorfondo=1;
		}
		$pdf->Cell($first_col_width,42,$body[$i][0],1,0,'L',true);
		for ($j=0; $j < count($body[$i][1]); $j++) {
			for ($k=0; $k < count($body[$i][1][$j]); $k++) {
				if ($colorfondo==0) {
					$pdf->SetFillColor(200);
				}else{
					$pdf->SetFillColor(255);
				}
				if ($j==4 && $k>0) {
					if (getPercentValue($body[$i][1][$j][$k])<number_format($_GET['ran2'])) {			
						$pdf->SetFillColor(220,20,30);
					}else{
						if(getPercentValue($body[$i][1][$j][$k])>=number_format($_GET['ran1'])){
							$pdf->SetFillColor(90,195,40);
						}else{
							$pdf->SetFillColor(220,160,10);				
						}
					}
				}
				if ($k==0) {
					$pdf->Cell($first_col_width,6,$body[$i][1][$j][$k],1,0,'L',true);
				}else{
					$pdf->Cell($width_by_cell,6,format_number_miles($body[$i][1][$j][$k]),1,0,'R',true);
				}
			}
			$pdf->Ln();
			if ($j!=count($body[$i][1])-1) {
				$pdf->Cell($first_col_width,12,"",0,0,'L',false);
			}
		}
	}
	$pdf->Ln();
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
$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':BLOQUE', $_GET['bloque']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=3;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if ($i==0) {
		$coddefuno=$row['CODAREA'];
	}
	if ($i==1) {
		$coddefdos=$row['CODAREA'];
	}
	$obj=new stdClass();
	$obj->CODFAMILIA=$row['CODAREA'];
	$obj->DSCFAMILIA=utf8_encode($row['DESAREA']);
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
$headers=[utf8_decode("ÁREA"),"FRECUENCIA","%","% ACUMULADO"];
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
$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':BLOQUE', $_GET['bloque']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=4;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if ($i==0) {
		$coddefunoM=$row['CODAREA'];
	}
	if ($i==1) {
		$coddefdosM=$row['CODAREA'];
	}
	$obj=new stdClass();
	$obj->CODFAMILIA=$row['CODAREA'];
	$obj->DSCFAMILIA=utf8_encode($row['DESAREA']);
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
$headers=[utf8_decode("ÁREA"),"FRECUENCIA","%","% ACUMULADO"];
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
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. ".utf8_decode($_GET['t4_1'])." (1er Mayor ".utf8_decode("Área").")",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-4.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);


$defuno=[];
$i=0;
$sumDefectosU=0;
$sql="BEGIN SP_AUDTEL_INDRESULTADOS2(:CODPRV,:CODUSU,:CODUSUEJE,:FECHA,:CODAREA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODAREA', $coddefuno);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$obj=new stdClass();
	$obj->CODDEF=$row['CODDEF'];
	$obj->DESDEF=utf8_encode($row['DESDEF']);
	if ($row['CANDEF']==null) {
		$sumDefectosU+=0;
		$obj->SUMA=0;
	}else{
		$sumDefectosU+=(int)$row['CANDEF'];
		$obj->SUMA=$row['CANDEF'];
	}
	$defuno[$i]=$obj;
	$i++;
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
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. ".utf8_decode($_GET['t4_2'])." (2da Mayor ".utf8_decode("Área").")",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-5.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDefectosD=0;
$sql="BEGIN SP_AUDTEL_INDRESULTADOS2(:CODPRV,:CODUSU,:CODUSUEJE,:FECHA,:CODAREA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODAREA', $coddefdos);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$obj=new stdClass();
	$obj->CODDEF=$row['CODDEF'];
	$obj->DESDEF=utf8_encode($row['DESDEF']);
	$obj->SUMA=$row['CANDEF'];
	$defuno[$i]=$obj;
	$i++;
	$sumDefectosD+=(int)$row['CANDEF'];
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
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. ".utf8_decode($_GET['t5_1'])." (1er Mayor ".utf8_decode("Área").")",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-6.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDefectosUM=0;
$sql="BEGIN SP_AUDTEL_INDRESULTADOS2(:CODPRV,:CODUSU,:CODUSUEJE,:FECHA,:CODAREA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODAREA', $coddefunoM);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$obj=new stdClass();
	$obj->CODDEF=$row['CODDEF'];
	$obj->DESDEF=utf8_encode($row['DESDEF']);
	if ($row['CANDEF']==null) {
		$sumDefectosUM+=0;
		$obj->SUMA=0;
	}else{
		$sumDefectosUM+=(int)$row['CANDEF'];
		$obj->SUMA=$row['CANDEF'];
	}
	$defuno[$i]=$obj;
	$i++;
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
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. ".utf8_decode($_GET['t5_2'])." (2da Mayor ".utf8_decode("Área").")",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-7.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDefectosDM=0;
$sql="BEGIN SP_AUDTEL_INDRESULTADOS2(:CODPRV,:CODUSU,:CODUSUEJE,:FECHA,:CODAREA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODAREA', $coddefdosM);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$obj=new stdClass();
	$obj->CODDEF=$row['CODDEF'];
	$obj->DESDEF=utf8_encode($row['DESDEF']);
	$obj->SUMA=$row['CANDEF'];
	$defuno[$i]=$obj;
	$i++;
	$sumDefectosDM+=(int)$row['CANDEF'];
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