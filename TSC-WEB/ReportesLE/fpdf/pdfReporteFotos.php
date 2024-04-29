<?php
set_time_limit(480);

function transform_to_array($text){
	$ar_send=[];
	$array=explode(" ", $text);
	$comment='';
	$max_tam_array=40;
	for ($i=0; $i < count($array); $i++) { 
		if (strlen($comment.$array[$i])>$max_tam_array) {
			array_push($ar_send, $comment);
			$comment=$array[$i];
		}else{
			if ($comment=='') {
				$comment.=$array[$i];
			}else{
				$comment.=' '.$array[$i];
			}
		}
	}
	array_push($ar_send, $comment);
	return $ar_send;
}

function get_array_descol($descolrep){
	$aux=explode("-",$descolrep);
	$text="";
	$ar_send=[];
	for ($i=0; $i < count($aux); $i++) { 
		//7 colores por fila
		if ($i>6) {
			array_push($ar_send,substr($text, 0,strlen($text)-1));
			$text=$aux[$i]."-";
		}else{
			$text.=$aux[$i]."-";
		}
	}
	array_push($ar_send,substr($text, 0,strlen($text)-1));
	return $ar_send;
}

require('fpdf181/fpdf.php');
class PDF extends FPDF {
	const A4_HEIGHT = 297;
	const A4_WIDTH = 210;
	const MAX_WIDTH = 	2450;
	const MAX_WIDTH_TO_WHITE = 190;
	const MAX_HEIGHT_TO_WHITE = 277;

	function get_max_width_to_white($orientation) {
		if ($orientation=='P') {
			return self::MAX_WIDTH_TO_WHITE;
		}else{
			return self::MAX_HEIGHT_TO_WHITE;
		}		
	}

	function recal_wh($imgFilename,$w,$h) {
		list($width, $height) = getimagesize($imgFilename);
		$min_p=$w/$h;
		$max_p=$width/$height;
		$final_w=$w;
		$final_h=$h;
		if ($min_p<$max_p) {
			$final_w=$w*$width/$width;
			$final_h=$w*$height/$width;
		}else{
			$final_w=$h*$width/$height;
			$final_h=$h*$height/$height;
		}
		return array($final_w,$final_h);
	}
}
include("../config/connection.php");

$orientation_page='L';
$logo_width=52;
$margin_logo=4;
$logo_height=8;
$pdf = new PDF();

$sql="BEGIN SP_RLE_SELECT_POPLFOTOSEST(:PO,:PACLIS,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':PO', $_GET['po']);
oci_bind_by_name($stmt, ':PACLIS', $_GET['paclis']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$sql="BEGIN  SP_RLE_SELECT_POPLFOTOSESTREP(:PO,:PACLIS,:ESTCLI,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_GET['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_GET['paclis']);
	oci_bind_by_name($stmt, ':ESTCLI', $row['ESTCLI']);
	$OUTPUT_CUR2=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR2,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR2);
	$row2=oci_fetch_assoc($OUTPUT_CUR2);

/*
	$obj->PO=$row['PO'];
	$obj->ESTCLI=$row['ESTCLI'];
	$obj->FECGEN=$row['FECGEN'];
	$obj->FECAPR=$row['FECAPR'];
	$obj->CODUSU=$row['CODUSU'];
	$obj->FORM=utf8_encode($row['FORM']);
	$obj->VERSION=utf8_encode($row['VERSION']);
	$obj->FECHA=$row['FECHA'];
	$obj->VENDOR=utf8_encode($row['VENDOR']);
	$obj->FACTORY=$row['FACTORY'];
	$obj->CODAQL=$row['CODAQL'];
	$obj->CANTIDAD=$row['CANTIDAD'];
	$obj->CODWARDES=$row['CODWARDES'];
	$obj->CANAUD=$row['CANAUD'];
	$obj->CANDEFMAX=$row['CANDEFMAX'];
	$obj->CANDEF=$row['CANDEF'];
	$obj->DESPRE=utf8_encode($row['DESPRE']);
	$obj->DESCOL=utf8_encode($row['DESCOL']);
	$obj->CODAUD=$row['CODAUD'];
	$obj->NUMCAJ=$row['NUMCAJ'];
	$obj->RESULTADO=utf8_encode($row['RESULTADO']);
	$obj->CARINSPULL=utf8_encode($row['CARINSPULL']);
	$obj->CARINSMOISTURE=utf8_encode($row['CARINSMOISTURE']);
	$obj->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
	$obj->AQL=str_replace(",",".",$row['AQL']);
	$obj->NOMAUD=utf8_encode($row['NOMAUD']);
	$obj->CATEGORIA=utf8_encode($row['CATEGORIA']);
	$obj->DESCOLREP=utf8_encode($row['DESCOLREP']);
	$obj->FINALAUDIT=utf8_encode($row['FINALAUDIT']);
	$obj->PREFINAL=utf8_encode($row['PREFINAL']);
	$obj->INLINE=utf8_encode($row['INLINE']);
	$obj->INLINEVEZ=utf8_encode($row['INLINEVEZ']);
	$obj->REAUDIT=utf8_encode($row['REAUDIT']);
	$obj->REAUDITVEZ=utf8_encode($row['REAUDITVEZ']);
	$obj->CERTIFIEDAUD=utf8_encode($row['CERTIFIEDAUD']);
	$obj->TRAINEE=utf8_encode($row['TRAINEE']);
	$obj->PRECERTIFIEDAUD=utf8_encode($row['PRECERTIFIEDAUD']);
	$obj->CORRELATIONAUD=utf8_encode($row['CORRELATIONAUD']);
	$obj->LEAUDITOR=utf8_encode($row['LEAUDITOR']);*/


	$pdf->AddPage($orientation_page,'A4');
	$pdf->SetAutoPageBreak(true, 1);
	$pdf->SetFont('Arial','B',18);
	$x=$pdf->GetX();
	$pdf->SetX($x);
	$pdf->Cell($logo_width+$margin_logo*2,12,'',0,'L');
	$pdf->Cell(30,12,'',0,'L');
	$pdf->Cell($pdf->get_max_width_to_white($orientation_page)-$logo_width-$margin_logo*2,16,'FINAL INSPECTION PHOTOS',0,'L');
	$pdf->Ln();
	$pdf->SetY(22);
	$pdf->SetFont('Arial','B',10);
	$array_space=[21,61,5,21,21,30,5,16,20,75];
	$pdf->Cell(4,5,'',0,'L');
	$pdf->Cell(35,5,'FORM:  '.utf8_encode($row2['FORM']),0,'L');
	$pdf->Cell(48,5,'Version:  '.utf8_encode($row2['VERSION']),0,'L');
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell($array_space[3],5,'  STYLE #','LTRB',0,'L',true);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell($array_space[5]+$array_space[4],5,$row2['ESTCLI'],'B',0,'L');
	$pdf->Cell($array_space[6],5,'','',0,'L');
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell($array_space[7],5,'P.O. #','LTRB',0,'C',true);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell($array_space[8],5,$_GET['po'],'B',0,'L');
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$array_space=[21,61,5,21,21,30,5,16,20,75];
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell($array_space[0],5,'AUDITOR','LTRB',0,'C',true);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell($array_space[1],5,utf8_encode($row2['NOMAUD']),'B',0,'L');
	$pdf->Cell($array_space[2],5,'','',0,'L');
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell($array_space[3]+$array_space[4],5,'  ITEM DESCRIPTION','LTRB',0,'L',true);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell($array_space[5]+$array_space[6]+$array_space[7]+$array_space[8]+$array_space[9],5,utf8_encode($row2['DESPRE']),'B',0,'L');

	$pdf->Ln();
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell($array_space[0],5,'VENDOR','LTRB',0,'C',true);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell($array_space[1],5,utf8_encode($row2['VENDOR']),'B',0,'L');
	$pdf->Cell($array_space[2],5,'','',0,'L');

	$pdf->SetTextColor(255,255,255);
	$pdf->Cell($array_space[3],5,'  COLOR','LTRB',0,'L',true);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell($array_space[4]+$array_space[5]+$array_space[6]+$array_space[7]+$array_space[8]+$array_space[9],5,utf8_encode($row2['DESCOLREP']),'B',0,'L');

	$pdf->Ln(10);

	$fotos=[];
	$sql="BEGIN SP_RLE_SELECT_POPLFOTOSREPPRE(:PO,:PACLIS,:TIPO,:ESTCLI,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_GET['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_GET['paclis']);
	oci_bind_by_name($stmt, ':TIPO', $_GET['tipo']);
	oci_bind_by_name($stmt, ':ESTCLI', $row['ESTCLI']);
	$OUTPUT_CUR3=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR3,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR3);
	while($row3=oci_fetch_assoc($OUTPUT_CUR3)){
		if ($row3['SELREPORTE']=="1") {
			$url='http://textilweb.tsc.com.pe:81/tsc-web/auditoriafinal/assets/imgcalint/';
			if($row3['BLOQUE']=="2"){
				$url='http://textilweb.tsc.com.pe:81/tsc-web/auditoriafinal/assets/imgconhum/';
			}
			$obj=new stdClass();
			$obj->RUTIMA=$url.$row3['RUTIMA'];
			$obj->TITULO=$row3['TITULO'];
			array_push($fotos, $obj);
		}
	}

	$pdf->SetFillColor(210,210,210);
	$pdf->SetTextColor(0,0,0);
	$array_space=[10,55,5];
	$pdf->Cell($array_space[0],6,'1','LTRB',0,'C',true);
	if (isset($fotos[0])) {
		$pdf->Cell($array_space[1],6,$fotos[0]->TITULO,'LTRB',0,'C',true);
	}else{
		$pdf->Cell($array_space[1],6,'','LTRB',0,'C',true);
	}
	$pdf->Cell($array_space[2],6,'','',0,'C');
	$pdf->Cell($array_space[0],6,'2','LTRB',0,'C',true);
	if (isset($fotos[1])) {
		$pdf->Cell($array_space[1],6,$fotos[1]->TITULO,'LTRB',0,'C',true);
	}else{
		$pdf->Cell($array_space[1],6,'','LTRB',0,'C',true);
	}
	$pdf->Cell($array_space[2],6,'','',0,'C');
	$pdf->Cell($array_space[0],6,'3','LTRB',0,'C',true);
	if (isset($fotos[2])) {
		$pdf->Cell($array_space[1],6,$fotos[2]->TITULO,'LTRB',0,'C',true);
	}else{
		$pdf->Cell($array_space[1],6,'','LTRB',0,'C',true);
	}
	$pdf->Cell($array_space[2],6,'','',0,'C');
	$pdf->Cell($array_space[0],6,'4','LTRB',0,'C',true);
	if (isset($fotos[3])) {
		$pdf->Cell($array_space[1],6,$fotos[3]->TITULO,'LTRB',0,'C',true);
	}else{
		$pdf->Cell($array_space[1],6,'','LTRB',0,'C',true);
	}
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$height_img=70;
	$pdf->Cell($array_space[0]+$array_space[1],$height_img,'','LTRB',0,'C',true);
	$pdf->Cell($array_space[2],50,'','',0,'C');
	$pdf->Cell($array_space[0]+$array_space[1],$height_img,'','LTRB',0,'C',true);
	$pdf->Cell($array_space[2],50,'','',0,'C');
	$pdf->Cell($array_space[0]+$array_space[1],$height_img,'','LTRB',0,'C',true);
	$pdf->Cell($array_space[2],50,'','',0,'C');
	$pdf->Cell($array_space[0]+$array_space[1],$height_img,'','LTRB',0,'C',true);
	$pdf->Ln($height_img+5);
	$pdf->SetFillColor(210,210,210);
	$pdf->SetTextColor(0,0,0);
	$array_space=[10,55,5];
	$pdf->Cell($array_space[0],6,'5','LTRB',0,'C',true);
	if (isset($fotos[4])) {
		$pdf->Cell($array_space[1],6,$fotos[4]->TITULO,'LTRB',0,'C',true);
	}else{
		$pdf->Cell($array_space[1],6,'','LTRB',0,'C',true);
	}
	$pdf->Cell($array_space[2],6,'','',0,'C');
	$pdf->Cell($array_space[0],6,'6','LTRB',0,'C',true);
	if (isset($fotos[5])) {
		$pdf->Cell($array_space[1],6,$fotos[5]->TITULO,'LTRB',0,'C',true);
	}else{
		$pdf->Cell($array_space[1],6,'','LTRB',0,'C',true);
	}
	$pdf->Cell($array_space[2],6,'','',0,'C');
	$pdf->Cell($array_space[0],6,'7','LTRB',0,'C',true);
	if (isset($fotos[6])) {
		$pdf->Cell($array_space[1],6,$fotos[6]->TITULO,'LTRB',0,'C',true);
	}else{
		$pdf->Cell($array_space[1],6,'','LTRB',0,'C',true);
	}
	$pdf->Cell($array_space[2],6,'','',0,'C');
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell($array_space[0]+$array_space[1],6,'COMMENTS','LTRB',0,'C',true);
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell($array_space[0]+$array_space[1],$height_img,'','LTRB',0,'C',true);
	$pdf->Cell($array_space[2],50,'','',0,'C');
	$pdf->Cell($array_space[0]+$array_space[1],$height_img,'','LTRB',0,'C',true);
	$pdf->Cell($array_space[2],50,'','',0,'C');
	$pdf->Cell($array_space[0]+$array_space[1],$height_img,'','LTRB',0,'C',true);
	$pdf->Cell($array_space[2],50,'','',0,'C');
	$pdf->Cell($array_space[0]+$array_space[1],$height_img,'','LTRB',0,'C',true);
	$pdf->Ln();
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$y=14;
	$pdf->SetXY(210,$y);
	$pdf->Cell(15,5,'DATE','',0,'R');
	$pdf->Cell(58,5,$row2['FECHA'],'B',0,'C',true);
	$pdf->Ln();
	$y+=6;
	$pdf->SetXY(210,$y);
	$pdf->Cell(15,5,'SIZE','',0,'R');
	$pdf->Cell(58,5,$row2['DESTAL'],'B',0,'C',true);
	$pdf->Ln();

	/*COMENTARIOS*/
	$pdf->SetFont('Arial','',9);
	$y=127;
	$h_add=5;
	$comment1=$row2['COMENTARIOS'];
	$array_comments=transform_to_array($comment1);
	for ($i=0; $i < count($array_comments); $i++) {
		$y+=$h_add;
		$pdf->SetXY(223,$y);
		$pdf->Cell(60,5,$array_comments[$i],'',0,'L');
		$pdf->Ln();
	}

	/*IMAGENES*/
	$posx=12;
	$posy=50;
	if (isset($fotos[0])) {
		$file_path=$fotos[0]->RUTIMA;
		$max_w_img=61;
		$max_h_img=66;
		$ar_wh=$pdf->recal_wh($file_path,$max_w_img,$max_h_img);
		$pdf->Image($file_path, $posx,$posy,$ar_wh[0],$ar_wh[1],'JPG');
	}
	$posx+=70;
	if (isset($fotos[1])) {
		$file_path=$fotos[1]->RUTIMA;
		$max_w_img=61;
		$max_h_img=66;
		$ar_wh=$pdf->recal_wh($file_path,$max_w_img,$max_h_img);
		$pdf->Image($file_path, $posx,$posy,$ar_wh[0],$ar_wh[1],'JPG');
	}
	$posx+=70;
	if (isset($fotos[2])) {
		$file_path=$fotos[2]->RUTIMA;
		$max_w_img=61;
		$max_h_img=66;
		$ar_wh=$pdf->recal_wh($file_path,$max_w_img,$max_h_img);
		$pdf->Image($file_path, $posx,$posy,$ar_wh[0],$ar_wh[1],'JPG');
	}
	$posx+=70;
	if (isset($fotos[3])) {
		$file_path=$fotos[3]->RUTIMA;
		$max_w_img=61;
		$max_h_img=66;
		$ar_wh=$pdf->recal_wh($file_path,$max_w_img,$max_h_img);
		$pdf->Image($file_path, $posx,$posy,$ar_wh[0],$ar_wh[1],'JPG');
	}
	$posx=12;
	$posy=131;
	if (isset($fotos[4])) {
		$file_path=$fotos[4]->RUTIMA;
		$max_w_img=61;
		$max_h_img=66;
		$ar_wh=$pdf->recal_wh($file_path,$max_w_img,$max_h_img);
		$pdf->Image($file_path, $posx,$posy,$ar_wh[0],$ar_wh[1],'JPG');
	}
	$posx+=70;
	if (isset($fotos[5])) {
		$file_path=$fotos[5]->RUTIMA;
		$max_w_img=61;
		$max_h_img=66;
		$ar_wh=$pdf->recal_wh($file_path,$max_w_img,$max_h_img);
		$pdf->Image($file_path, $posx,$posy,$ar_wh[0],$ar_wh[1],'JPG');
	}
	$posx+=70;
	if (isset($fotos[6])) {
		$file_path=$fotos[6]->RUTIMA;
		$max_w_img=61;
		$max_h_img=66;
		$ar_wh=$pdf->recal_wh($file_path,$max_w_img,$max_h_img);
		$pdf->Image($file_path, $posx,$posy,$ar_wh[0],$ar_wh[1],'JPG');
	}	
	/*LOGO LE*/
	$file_path='../assets/img/logo_le.jpeg';
	$pdf->Image($file_path, 14,14,$logo_width,$logo_height,'JPG');

}
//$pdf->Output('D','Reporte_Defectos.pdf',true);
$pdf->Output('','',true);

oci_close($conn);

?>