<?php
set_time_limit(480);
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
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("INDICADORES DE CLASIFICACIÓN DE FICHAS"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();

// Image(archivo,posicionX,posicionY,ancho,alto,tipo_imagen);

$file_path=$file_path_dir.$_GET['name'].'-1.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],22,$array[0]/2 ,$array[1]/2,'PNG');
$file_path=$file_path_dir.$_GET['name'].'-2.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , 105,22,$array[0]/2 ,$array[1]/2,'PNG');
$pdf->Ln($array[1]/2);
$altura_ant=$array[1]/2;

$file_path=$file_path_dir.$_GET['name'].'-3.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],22+5+$altura_ant,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$altura_ant+=$array[1];

$file_path=$file_path_dir.$_GET['name'].'-4.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],22+5+$altura_ant,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

/////////// PAGINA 2

$pdf->AddPage();
$pdf->SetFont('Arial','',13);

$file_path=$file_path_dir.$_GET['name'].'-5.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$altura_ant=$array[1];

$file_path=$file_path_dir.$_GET['name'].'-6.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10+5+$altura_ant,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$altura_ant+=$array[1];

$file_path=$file_path_dir.$_GET['name'].'-7.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10+5+$altura_ant,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

/////////// PAGINA 3

$pdf->AddPage();
$pdf->SetFont('Arial','',13);

$file_path=$file_path_dir.$_GET['name'].'-8.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$altura_ant=$array[1];

$file_path=$file_path_dir.$_GET['name'].'-9.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10+5+$altura_ant,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$altura_ant+=$array[1];


$file_path=$file_path_dir.$_GET['name'].'-10.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10+5+$altura_ant,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);


/////////// PAGINA 4

$pdf->AddPage();
$pdf->SetFont('Arial','',13);

$file_path=$file_path_dir.$_GET['name'].'-11.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$altura_ant=$array[1];

$file_path=$file_path_dir.$_GET['name'].'-12.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10+5+$altura_ant,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$altura_ant+=$array[1];


$file_path=$file_path_dir.$_GET['name'].'-13.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10+5+$altura_ant,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);


/////////// PAGINA 5

$pdf->AddPage();
$pdf->SetFont('Arial','',13);

$file_path=$file_path_dir.$_GET['name'].'-14.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$altura_ant=$array[1];


$pdf->AddPage();
$pdf->SetFont('Arial','',13);

$ar_header=[];
$ar_clasi1=[];
$ar_clasi2=[];
$ar_clasi3=[];
$ar_clasi4=[];
$ar_clasi5=[];
$ar_clasi6=[];
$ar_clasi7=[];
$ar_clasi8=[];
$ar_clasi9=[];
$ar_sum=[];

$auxh=0;
$aux1=0;
$aux2=0;
$aux3=0;
$aux4=0;
$aux5=0;
$aux6=0;
$aux7=0;
$aux8=0;
$aux9=0;

function get_content_array($id){
	global $ar_clasi1;
	global $ar_clasi2;
	global $ar_clasi3;
	global $ar_clasi4;
	global $ar_clasi5;
	global $ar_clasi6;
	global $ar_clasi7;
	global $ar_clasi8;
	global $ar_clasi9;

	switch ($id) {
		case "1":
			return $ar_clasi1;
			break;
		case '2':
			return $ar_clasi2;
			break;
		case '3':
			return $ar_clasi3;
			break;
		case '4':
			return $ar_clasi4;
			break;
		case '5':
			return $ar_clasi5;
			break;
		case '6':
			return $ar_clasi6;
			break;
		case '7':
			return $ar_clasi7;
			break;
		case '8':
			return $ar_clasi8;
			break;
		case '9':
			return $ar_clasi9;
			break;			
		default:
			return [];			
			break;
	}		
}

function proceMes($value){
	switch($value){
		case "01": return "Ene.";
			break;
		case "02": return "Feb.";
			break;
		case "03": return "Mar.";
			break;
		case "04": return "Abr.";
			break;
		case "05": return "May.";
			break;
		case "06": return "Jun.";
			break;
		case "07": return "Jul.";
			break;
		case "08": return "Ago.";
			break;
		case "09": return "Set.";
			break;
		case "10": return "Oct.";
			break;
		case "11": return "Nov.";
			break;
		case "12": return "Dic.";
			break;
		default:break;
	}
}

function add_to_array($codclarec,$value,$val_sum){
	global $aux1;
	global $aux2;
	global $aux3;
	global $aux4;
	global $aux5;
	global $aux6;
	global $aux7;
	global $aux8;
	global $aux9;
	global $ar_clasi1;
	global $ar_clasi2;
	global $ar_clasi3;
	global $ar_clasi4;
	global $ar_clasi5;
	global $ar_clasi6;
	global $ar_clasi7;
	global $ar_clasi8;
	global $ar_clasi9;

	switch ($codclarec) {
		case "1":
			$ar_clasi1[$aux1]=$value;
			$aux1++;
			break;
		case '2':
			$ar_clasi2[$aux2]=$value;
			$aux2++;
			break;
		case '3':
			$ar_clasi3[$aux3]=$value;
			$aux3++;
			break;
		case '4':
			$ar_clasi4[$aux4]=$value;
			$aux4++;
			break;
		case '5':
			$ar_clasi5[$aux5]=$value;
			$aux5++;
			break;
		case '6':
			$ar_clasi6[$aux6]=$value;
			$aux6++;
			break;
		case '7':
			$ar_clasi7[$aux7]=$value;
			$aux7++;
			break;
		case '8':
			$ar_clasi8[$aux8]=$value;
			$aux8++;
			break;
		case '9':
			$ar_clasi9[$aux9]=$value;
			$aux9++;
			break;			
		default:
			break;
	}
}
$ar_header[$auxh]=$_GET['t'];	
$auxh++;

$clasi=[];
$k=0;
$sql="BEGIN SP_AT_SELECT_CLAREC(:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	add_to_array($row['CODCLAREC'],$row['DESCLAREC'],0);
	$clasi[$k]=$row['CODCLAREC'];
	$k++;
}

$ant_name="";
$sumaux=0;
$j=0;
$sql="BEGIN SP_AT_INDICADOR_CLASIFICHA(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if ($ant_name=="") {
		$ant_name=$row['ANHO'];
		$ar_header[$auxh]=$ant_name;
		$auxh++;
		$sumaux+=(int)$row['CANPRE'];
	}else{
		if ($ant_name!=$row['ANHO']) {
			$ant_name=$row['ANHO'];
			$ar_header[$auxh]=$ant_name;
			$auxh++;
			$ar_sum[$j]=$sumaux;
			$j++;
			$sumaux=(int)$row['CANPRE'];	
		}else{
			$sumaux+=(int)$row['CANPRE'];
		}
	}
	add_to_array($row['CODCLAREC'],$row['CANPRE'],$row['CANPRE']);
}
$ar_sum[$j]=$sumaux;
$j++;

$ant_name="";
$sumaux=0;
$sql="BEGIN SP_AT_INDICADOR_CLASIFICHA(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if (!is_null($row['DESCLAREC'])) {
		if ($ant_name=="") {
			$ant_name=$row['ANHO_MES'];
			$ar_header[$auxh]=proceMes(substr($ant_name,4,5));
			$auxh++;
			$sumaux+=$row['CANPRE'];
		}else{
			if ($ant_name!=$row['ANHO_MES']) {
				$ant_name=$row['ANHO_MES'];
				$ar_header[$auxh]=proceMes(substr($ant_name,4,5));
				$auxh++;	
				$ar_sum[$j]=$sumaux;
				$j++;
				$sumaux=$row['CANPRE'];			
			}else{
				$sumaux+=(int)$row['CANPRE'];
			}
		}
		add_to_array($row['CODCLAREC'],$row['CANPRE'],$row['CANPRE']);
	}
}
$ar_sum[$j]=$sumaux;
$j++;

$ant_name="";
$sumaux=0;
$sql="BEGIN SP_AT_INDICADOR_CLASIFICHA(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
$opcion=2;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if ($ant_name=="") {
		$ant_name=$row['NUMERO_SEMANA'];
		$ar_header[$auxh]="S. ".$ant_name;
		$auxh++;
		$sumaux+=$row['CANPRE'];
	}else{
		if ($ant_name!=$row['NUMERO_SEMANA']) {
			$ant_name=$row['NUMERO_SEMANA'];
			$ar_header[$auxh]="S. ".$ant_name;
			$auxh++;	
			$ar_sum[$j]=$sumaux;
			$j++;
			$sumaux=$row['CANPRE'];			
		}else{
			$sumaux+=(int)$row['CANPRE'];
		}
	}
	add_to_array($row['CODCLAREC'],$row['CANPRE'],$row['CANPRE']);
}
$ar_sum[$j]=$sumaux;
$j++;

$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$first_col_width=40;
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/(count($ar_header)-1);

for ($i=0; $i < count($ar_header); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,"DETALLE GENERAL",1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$ar_header[$i],1,0,'L',true);
	}
}

$pdf->Ln();
$pdf->SetFillColor(190,220,190);

for ($j=0; $j < count($clasi); $j++) { 
	$array=get_content_array($clasi[$j]);

	for ($i=0; $i < count($array); $i++) { 
		if ($i==0) {
			$pdf->SetTextColor(0);
			$pdf->Cell($first_col_width,6,$array[$i],1,0,'L',true);
		}else{
			$pdf->SetTextColor(0);
			$pdf->Cell($width_by_cell,6,number_format($array[$i]),1,0,'R');
		}
	}
	$pdf->Ln();

	$l=0;
	for ($i=0; $i < count($array); $i++) { 
		if ($i==0) {
			$pdf->SetTextColor(0);
			$pdf->Cell($first_col_width,6,"% ".$array[$i],1,0,'L',true);
		}else{
			$pdf->SetTextColor(0);
			$pdf->Cell($width_by_cell,6,(round(((int)$array[$i])*10000/((int)$ar_sum[$l]))/100)."%",1,0,'R');			
			$l++;
		}
	}
	$pdf->Ln();
}

$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$pdf->Cell($first_col_width,6,"TOTAL",1,0,'L',true);
for ($i=0; $i < count($ar_sum); $i++) { 
	$pdf->SetTextColor(255);
	$pdf->Cell($width_by_cell,6,number_format($ar_sum[$i]),1,0,'R',true);
}

$pdf->Output('D','Indicar de Clasificacion de Fichas - '.str_replace("/","-",$_GET['t']).'.pdf',true);
//$pdf->Output('','',true);

oci_close($conn);

//// DELETE FILES
$file_path = "../assets/tmp/"; 
for($i=0;$i<8;$i++){
    unlink($file_path.$_GET['name']."-".($i+1).".png");
}
?>