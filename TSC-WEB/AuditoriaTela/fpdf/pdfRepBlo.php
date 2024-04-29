<?php
set_time_limit(240);

function format_signo($valor){
	if ($valor=="1") {
		return "+";
	}else{
		return "-";
	}
}

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
	function myCell($w,$h,$x,$t,$tam){
		$height=$h/3;
		$first=$height+2;
		$second=3*$height+3;
		$len=strlen($t);
		$tam_text=$tam;
		if ($len>$tam_text) {
			$text=str_split($t,$tam_text);
			$this->SetX($x);
			$this->Cell($w,$first,$text[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$text[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,'L',0);
		}
	}
}
include("../config/connection.php");

$file_path_dir='../assets/tmp/';
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("REPORTE DE ANALISIS"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',13);

$ar_fecha=explode("-",$_GET['fecini']);
$fecini=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];

$ar_fecha=explode("-",$_GET['fecfin']);
$fecfin=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];

$file_path=$file_path_dir.$_GET['n'].'-1.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,"KG ".$_GET['tit1']." POR BLOQUES",0,0,'C');
$pdf->Ln();
$pdf->Image($file_path , $array[2],36,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->SetFont('Arial','',9);

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[70,30,30,30,30];

$pdf->Cell($ar_header_width[0],6,"Bloque",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtoncol']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareacol']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
oci_bind_by_name($stmt, ':RANGO', $_GET['rangocol']);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpesblo'])/100;	
	$pdf->Cell($ar_header_width[0],6,$row['BLOQUE'],1,0);
	$pdf->Cell($ar_header_width[1],6,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[2],6,$por1."%",1,0);
	$pdf->Cell($ar_header_width[3],6,$por2."%",1,0);
	$pdf->Cell($ar_header_width[4],6,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}
$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,$_GET['sumcanblo'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();

//PAGINA 2
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"TONO",0,0,'C');
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'-2.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],20,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[70,30,30,30,30];

$pdf->Cell($ar_header_width[0],6,"Defecto",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtoncol']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareacol']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
oci_bind_by_name($stmt, ':RANGO', $_GET['rangocol']);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
$sumpes=0;
$sumcan=0;
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpeston'])/100;	
	$pdf->Cell($ar_header_width[0],6,utf8_encode($row['DESTON']),1,0);
	$pdf->Cell($ar_header_width[1],6,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[2],6,$por1."%",1,0);
	$pdf->Cell($ar_header_width[3],6,$por2."%",1,0);
	$pdf->Cell($ar_header_width[4],6,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,$_GET['sumcanton'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();


//PAGINA 3
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"TONO - COLOR",0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"TONO: ".$_GET['lbltoncol'],0,0,'C');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[70,30,30,30,30];

$pdf->Cell($ar_header_width[0],6,"Cod. Color",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtoncol']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareacol']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
oci_bind_by_name($stmt, ':RANGO', $_GET['rangocol']);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=12;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
$sumpes=0;
$sumcan=0;
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpestoncol'])/100;	
	$pdf->Cell($ar_header_width[0],6,utf8_encode($row['CODCOL']),1,0);
	$pdf->Cell($ar_header_width[1],6,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[2],6,$por1."%",1,0);
	$pdf->Cell($ar_header_width[3],6,$por2."%",1,0);
	$pdf->Cell($ar_header_width[4],6,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,$_GET['sumcantoncol'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();


//PAGINA 4
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"TONO - TELA",0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"TONO: ".$_GET['lbltontel'],0,0,'C');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[70,30,30,30,30];

$pdf->Cell($ar_header_width[0],6,"Tela",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtontel']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareacol']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
oci_bind_by_name($stmt, ':RANGO', $_GET['rangocol']);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=13;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
$sumpes=0;
$sumcan=0;
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpestontel'])/100;
	$ar_text=str_split(utf8_encode($row['DESTEL']),35);
	$h=6;
	if (count($ar_text)>1) {
		$h=9;
	}
	$x=$pdf->GetX();
	$pdf->myCell($ar_header_width[0],$h,$x,utf8_encode($row['DESTEL']),35);
	//$pdf->Cell($ar_header_width[0],6,utf8_encode($row['DESTEL']),1,0);
	$pdf->Cell($ar_header_width[1],$h,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[2],$h,$por1."%",1,0);
	$pdf->Cell($ar_header_width[3],$h,$por2."%",1,0);
	$pdf->Cell($ar_header_width[4],$h,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,$_GET['sumcantontel'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();

//PAGINA 5
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"APARIENCIA",0,0,'C');
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'-3.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],20,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[70,30,30,30,30];

$pdf->Cell($ar_header_width[0],6,"Area",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtontel']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareacol']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
oci_bind_by_name($stmt, ':RANGO', $_GET['rangocol']);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=2;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
$sumpes=0;
$sumcan=0;
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpesapa'])/100;
	$h=6;
	/*$ar_text=str_split(utf8_encode($row['DESTEL']),35);
	if (count($ar_text)>1) {
		$h=9;
	}
	$x=$pdf->GetX();
	$pdf->myCell($ar_header_width[0],$h,$x,utf8_encode($row['']));*/
	$pdf->Cell($ar_header_width[0],$h,utf8_encode($row['DSCAREAD']),1,0);
	$pdf->Cell($ar_header_width[1],$h,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[2],$h,$por1."%",1,0);
	$pdf->Cell($ar_header_width[3],$h,$por2."%",1,0);
	$pdf->Cell($ar_header_width[4],$h,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,$_GET['sumcanapa'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();

//PAGINA 6
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"APARIENCIA DEFECTO",0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"COD. AREA: ".$_GET['lblarea'],0,0,'C');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[32,70,22,22,22,22];

$pdf->Cell($ar_header_width[0],6,"Area",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"Defecto",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[5],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtontel']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareacol']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
oci_bind_by_name($stmt, ':RANGO', $_GET['rangocol']);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=21;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpesapadef'])/100;
	$h=6;
	/*$ar_text=str_split(utf8_encode($row['DESTEL']),35);
	if (count($ar_text)>1) {
		$h=9;
	}
	$x=$pdf->GetX();
	$pdf->myCell($ar_header_width[0],$h,$x,utf8_encode($row['']));*/
	$pdf->Cell($ar_header_width[0],$h,utf8_encode($row['DSCAREAD']),1,0);
	$pdf->Cell($ar_header_width[1],$h,utf8_encode($row['DESAPA']),1,0);
	$pdf->Cell($ar_header_width[2],$h,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[3],$h,$por1."%",1,0);
	$pdf->Cell($ar_header_width[4],$h,$por2."%",1,0);
	$pdf->Cell($ar_header_width[5],$h,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0]+$ar_header_width[1]+$ar_header_width[2]+$ar_header_width[3],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[5],6,$_GET['sumcanapadef'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();

//PAGINA 7
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"APARIENCIA - COLOR",0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"COD. APARIENCIA: ".$_GET['lblareacol'],0,0,'C');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[70,30,30,30,30];

$pdf->Cell($ar_header_width[0],6,"Cod. Color",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtontel']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareacol']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
oci_bind_by_name($stmt, ':RANGO', $_GET['rangocol']);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=22;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpesapacol'])/100;
	$h=6;
	/*$ar_text=str_split(utf8_encode($row['DESTEL']),35);
	if (count($ar_text)>1) {
		$h=9;
	}
	$x=$pdf->GetX();
	$pdf->myCell($ar_header_width[0],$h,$x,utf8_encode($row['']));*/
	$pdf->Cell($ar_header_width[0],$h,utf8_encode($row['CODCOL']),1,0);
	$pdf->Cell($ar_header_width[1],$h,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[2],$h,$por1."%",1,0);
	$pdf->Cell($ar_header_width[3],$h,$por2."%",1,0);
	$pdf->Cell($ar_header_width[4],$h,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,$_GET['sumcanapacol'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();

//PAGINA 8
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"APARIENCIA - TELA",0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"COD. APARIENCIA: ".$_GET['lblareatel'],0,0,'C');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[90,25,25,25,25];

$pdf->Cell($ar_header_width[0],6,"Cod. Color",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtontel']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareatel']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
oci_bind_by_name($stmt, ':RANGO', $_GET['rangocol']);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=23;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpesapatel'])/100;
	$h=6;
	/*$ar_text=str_split(utf8_encode($row['DESTEL']),35);
	if (count($ar_text)>1) {
		$h=9;
	}
	$x=$pdf->GetX();
	$pdf->myCell($ar_header_width[0],$h,$x,utf8_encode($row['']));*/
	$pdf->Cell($ar_header_width[0],$h,utf8_encode($row['DESTEL']),1,0);
	$pdf->Cell($ar_header_width[1],$h,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[2],$h,$por1."%",1,0);
	$pdf->Cell($ar_header_width[3],$h,$por2."%",1,0);
	$pdf->Cell($ar_header_width[4],$h,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"",1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,$_GET['sumcanapatel'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();

//PAGINA 9
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"ESTABILIDAD DIMENSIONAL",0,0,'C');
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'-4.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],20,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[60,30,25,25,25,25];

$pdf->Cell($ar_header_width[0],6,"Caracteristica",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"Fuera Lim.",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[5],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtontel']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareatel']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
oci_bind_by_name($stmt, ':RANGO', $_GET['rangocol']);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=3;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpesed'])/100;
	$h=6;
	/*$ar_text=str_split(utf8_encode($row['DESTEL']),35);
	if (count($ar_text)>1) {
		$h=9;
	}
	$x=$pdf->GetX();
	$pdf->myCell($ar_header_width[0],$h,$x,utf8_encode($row['']));*/
	$pdf->Cell($ar_header_width[0],$h,utf8_encode($row['DESESTDIM']),1,0);
	$pdf->Cell($ar_header_width[1],$h,utf8_encode($row['RANGO']),1,0);
	$pdf->Cell($ar_header_width[2],$h,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[3],$h,$por1."%",1,0);
	$pdf->Cell($ar_header_width[4],$h,$por2."%",1,0);
	$pdf->Cell($ar_header_width[5],$h,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0]+$ar_header_width[1]+$ar_header_width[2]+$ar_header_width[3],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[5],6,$_GET['sumcaned'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();

//PAGINA 10
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"ESTABILIDAD DIMENSIONAL - COLOR",0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"ESTABILIDAD DIMENSIONAL: ".$_GET['lblestdimcol'],0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"RANGO: ".format_signo($_GET['rangocol']),0,0,'C');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[60,30,25,25,25,25];

$pdf->Cell($ar_header_width[0],6,"Cod. Color",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"Fuera Lim.",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[5],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtontel']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareatel']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimcol']);
$rango=format_signo($_GET['rangocol']);
oci_bind_by_name($stmt, ':RANGO', $rango);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=32;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpesedcol'])/100;
	$h=6;
	/*$ar_text=str_split(utf8_encode($row['DESTEL']),35);
	if (count($ar_text)>1) {
		$h=9;
	}
	$x=$pdf->GetX();
	$pdf->myCell($ar_header_width[0],$h,$x,utf8_encode($row['']));*/
	$pdf->Cell($ar_header_width[0],$h,utf8_encode($row['CODCOL']),1,0);
	$pdf->Cell($ar_header_width[1],$h,utf8_encode($row['RANGO']),1,0);
	$pdf->Cell($ar_header_width[2],$h,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[3],$h,$por1."%",1,0);
	$pdf->Cell($ar_header_width[4],$h,$por2."%",1,0);
	$pdf->Cell($ar_header_width[5],$h,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0]+$ar_header_width[1]+$ar_header_width[2]+$ar_header_width[3],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[5],6,$_GET['sumcanedcol'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();

//PAGINA 11
$pdf->AddPage();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);

$pdf->Cell($pdf->get_max_width_to_white(),6,"ESTABILIDAD DIMENSIONAL - TELA",0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"ESTABILIDAD DIMENSIONAL: ".$_GET['lblestdimtel'],0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"RANGO: ".format_signo($_GET['rangotel']),0,0,'C');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$ar_header_width=[65,25,25,25,25,25];

$pdf->Cell($ar_header_width[0],6,"Cod. Color",1,0,'L',true);
$pdf->Cell($ar_header_width[1],6,"Fuera Lim.",1,0,'L',true);
$pdf->Cell($ar_header_width[2],6,"kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[3],6,"% por kg Aud.",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"% kg ".$_GET['tit2'],1,0,'L',true);
$pdf->Cell($ar_header_width[5],6,"# ".$_GET['tit2'],1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(200);
$pdf->SetTextColor(0);

$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODUSUEJE', $_GET['codusueje']);
oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
oci_bind_by_name($stmt, ':CODAREA', $_GET['codarea']);
oci_bind_by_name($stmt, ':CODTON', $_GET['codtontel']);
oci_bind_by_name($stmt, ':CODAPA', $_GET['codareatel']);
oci_bind_by_name($stmt, ':CODESTDIM', $_GET['codestdimtel']);
$rango=format_signo($_GET['rangotel']);
oci_bind_by_name($stmt, ':RANGO', $rango);
oci_bind_by_name($stmt, ':CODDEF', $_GET['coddef']);
$opcion=33;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$por1=round(floatval($row['PESTOT'])*10000/$_GET['sumtotpesgen'])/100;
	$por2=round(floatval($row['PESTOT'])*10000/$_GET['sumpesedtel'])/100;
	$h=6;
	$ar_text=str_split(utf8_encode($row['DESTEL']),30);
	if (count($ar_text)>1) {
		$h=9;
	}
	$x=$pdf->GetX();
	$pdf->myCell($ar_header_width[0],$h,$x,utf8_encode($row['DESTEL']),30);
	//$pdf->Cell($ar_header_width[0],$h,utf8_encode($row['DESTEL']),1,0);
	$pdf->Cell($ar_header_width[1],$h,utf8_encode($row['RANGO']),1,0);
	$pdf->Cell($ar_header_width[2],$h,number_format(str_replace(",",".",$row['PESTOT']),2),1,0);
	$pdf->Cell($ar_header_width[3],$h,$por1."%",1,0);
	$pdf->Cell($ar_header_width[4],$h,$por2."%",1,0);
	$pdf->Cell($ar_header_width[5],$h,str_replace(",",".",$row['CANTOT']),1,0);
	$pdf->Ln();
}

$pdf->SetFillColor(50,50,30);
$pdf->SetTextColor(255);

$pdf->Cell($ar_header_width[0]+$ar_header_width[1]+$ar_header_width[2]+$ar_header_width[3],6,"Total",1,0,'L',true);
$pdf->Cell($ar_header_width[4],6,"100%",1,0,'L',true);
$pdf->Cell($ar_header_width[5],6,$_GET['sumcanedtel'],1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(45,6,"kg Auditados",1,0,'L',true);
$pdf->Cell(50,6,number_format((round($_GET['sumtotpesgen']*100)/100),2),1,0,'L',true);
$pdf->Cell(45,6,"# auditorias",1,0,'L',true);
$pdf->Cell(50,6,(round($_GET['sumtotcangen']*100)/100),1,0,'L',true);
$pdf->Ln();

$pdf->Output('D','Reporte por bloques - '.str_replace("/","-",$_GET['t']).'.pdf',true);
//$pdf->Output('','',true);

oci_close($conn);

//// DELETE FILES
/*$files = glob("../assets/tmp/*"); 
foreach($files as $file){
    if(is_file($file) && strpos($file,$_GET['n'])){
        unlink($file);
    }
}*/

?>