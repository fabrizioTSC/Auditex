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

function add_signo($state,$value){
	if ($value=="0") {
		return $value;
	}else{
		if ($state==1) {
			return '-'.$value;
		}else{
			return '+'.$value;
		}
	}
}

function trasnform_format($value){
	if ($value!="") {
		if ($value[0]!="-" && $value!="0") {
			return "+".$value;
		}else{
			return $value;
		}
	}else{
		return $value;
	}
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

function get_array_colmed($array){
	if ($array==" ") {
		return [""];
	}else{
		$ar_send=[];
		$aux=explode("-",$array);
		array_push($ar_send,$aux[0]);
		$max_tam=10;
		$aux2=explode(" ",$aux[1]);
		$text="";
		for ($i=0; $i < count($aux2); $i++) { 
			if (strlen($text." ".$aux2[$i])>$max_tam) {
				array_push($ar_send,$text);
				$text="";
			}else{
				$text.=" ".$aux2[$i];
			}
		}
		array_push($ar_send,$text);
		return $ar_send;
	}
}

function transform_comments($comment){
	$ar_send=[];
	$array=explode(" ",$comment);
	$text='';
	$tam_max=45;
	for ($i=0; $i < count($array); $i++) { 
		if (strlen($text." ".$array[$i])>$tam_max) {
			array_push($ar_send, $text);
			$text=$array[$i];
		}else{
			$text.=" ".$array[$i];
		}
	}
	if ($text!="") {
		array_push($ar_send, $text);
	}	
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
$logo_width=44;
$margin_logo=0;
$logo_height=8;
$pdf = new PDF();

$sql="BEGIN SP_RLE_SELECT_POPLMEDEST(:PO,:PACLIS,:OUTPUT_CUR); END;";
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

	//$colores=['Y6F-FRESH LAVANDER','JQ4-LIGTH BLUE RADIANCE','UH3-SALT WASHED PINK','I5W-SEA BREEZE BLUE'];

	$hojas=[];	
	$sql="BEGIN SP_RLE_SELECT_POPLMEDESTREP(:PO,:PACLIS,:ESTCLI,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_GET['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_GET['paclis']);
	oci_bind_by_name($stmt, ':ESTCLI', $row['ESTCLI']);
	$OUTPUT_CUR3=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR3,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR3);
	while($row3=oci_fetch_assoc($OUTPUT_CUR3)){		
		$obj=new stdClass();
		$obj->NHOJA=$row3['NHOJA'];
		$obj->COMENTARIOS=utf8_encode($row3['COMENTARIOS']);
		$obj->DESCOLREP=utf8_encode($row3['DESCOLREP']);
		$obj->DESTAL=utf8_encode($row3['DESTAL']);
		$ar_colores=[];
		$ar_descol=explode(" / ", $row3['DESCOL']);
		$ar_descolrep=explode(" / ", $row3['DESCOLREP']);
		for ($i=0; $i < count($ar_descol); $i++) { 
			array_push($ar_colores,$ar_descolrep[$i]."-".$ar_descol[$i]);
		}
		for ($i=0; $i <4-count($ar_descol) ; $i++) { 
			array_push($ar_colores,' ');
		}
		$obj->colores=$ar_colores;
		array_push($hojas, $obj);
	}

	for ($i=0; $i < count($hojas); $i++) {
		$colores=$hojas[$i]->colores;
		$pdf->AddPage($orientation_page,'A4');
		$pdf->SetAutoPageBreak(true, 1);
		$pdf->SetFont('Arial','B',16);
		$x=$pdf->GetX();
		$pdf->SetX($x);
		$pdf->SetY(1);
		$pdf->Cell($logo_width+$margin_logo*2,12,'',0,'L');
		$pdf->Cell(30,12,'',0,'L');
		$pdf->Cell($pdf->get_max_width_to_white($orientation_page)-$logo_width-$margin_logo*2,16,'MEASUREMENT SPECIFICATION CHART',0,'L');
		$pdf->Ln();
		$pdf->SetY(15);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(4,5,'',0,'L');
		$pdf->Cell(30,5,'FORM:  '.utf8_encode($row2['FORM']),0,'L');
		$pdf->Cell(60,5,'Version:  '.utf8_encode($row2['VERSION']),0,'L');
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$array_space=[21,61,5,21,21,30,5,16,20];
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell($array_space[0],5,utf8_decode('CA´s Name'),'LTRB',0,'C',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell($array_space[1],5,utf8_encode($row2['NOMAUD']),'B',0,'L');
		$pdf->Cell($array_space[2],5,'','',0,'L');
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell($array_space[3]+$array_space[4],5,'ITEM DESCRIPTION','LTRB',0,'C',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell($array_space[5]+$array_space[6]+$array_space[7]+$array_space[8],5,utf8_encode($row2['DESPRE']),'B',0,'L');
		$pdf->Ln();
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell($array_space[0],5,'VENDOR','LTRB',0,'C',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell($array_space[1],5,utf8_encode($row2['VENDOR']),'B',0,'L');
		$pdf->Cell($array_space[2],5,'','',0,'L');
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell($array_space[3],5,'STYLE #','LTRB',0,'C',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell($array_space[5]+$array_space[4],5,$row['ESTCLI'],'B',0,'L');
		$pdf->Cell($array_space[6],5,'','',0,'L');
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell($array_space[7],5,'P.O. #','LTRB',0,'C',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell($array_space[8],5,$_GET['po'],'B',0,'L');
		$pdf->Ln(10);

		$start_x=5;
		$start_y=35;
		$x;
		$y;
		$array_space=[8,57,5];
		$ant_desmed='';
		$m=0;
		$n=0;
		$numpre=3;
		$tamrowmark=$array_space[1]/($numpre*count($colores));
		$pulgadas=['+1 1/2','+1 3/8','+1 1/4','+1 1/8','+1','+7/8','+3/4','+5/8','+1/2','+3/8','+1/4','+1/8','0'
					,'-1/8','-1/4','-3/8','-1/2','-5/8','-3/4','-7/8','-1','-1 1/8','-1 1/4','-1 3/8','-1 1/2'];

		$ar_cuadros=[];
		$sql="BEGIN SP_RLE_SELECT_POPLMEDDETHOJREP(:PO,:PACLIS,:ESTCLI,:HOJA,:OUTPUT_CUR); END;";
		$stmt4=oci_parse($conn, $sql);
		oci_bind_by_name($stmt4, ':PO', $_GET['po']);
		oci_bind_by_name($stmt4, ':PACLIS', $_GET['paclis']);
		oci_bind_by_name($stmt4, ':ESTCLI', $row['ESTCLI']);
		oci_bind_by_name($stmt4, ':HOJA', $hojas[$i]->NHOJA);
		$OUTPUT_CUR4=oci_new_cursor($conn);
		oci_bind_by_name($stmt4, ':OUTPUT_CUR', $OUTPUT_CUR4,-1,OCI_B_CURSOR);
		$result4=oci_execute($stmt4);
		oci_execute($OUTPUT_CUR4);
		while($row4=oci_fetch_assoc($OUTPUT_CUR4)){
			if ($ant_desmed!=utf8_encode($row4['DESMED'])) {
				if ($ant_desmed!="" && $n!=12) {
					for ($u=0; $u < 12-$n; $u++) { 
						for ($o=0; $o < count($pulgadas); $o++) {
							if ($pulgadas[$o]=="0") {
								$pdf->SetFillColor(210,210,210);
								$pdf->SetTextColor(0,0,100);
							}else{
								$pdf->SetFillColor(255,255,255);
								$pdf->SetTextColor(0,0,100);
							}
							$pdf->Cell($tamrowmark,$height_row,'','LTRB',0,'C',true);
							$pdf->SetXY($start_x,$start_y+$height_row*($o+1));
						}
						$start_x+=$tamrowmark;
						$pdf->SetXY($start_x,$start_y);
					}
				}
				$n=0;
				$start_x+=5;
				if($m>=4){
					if($m==4){
						$start_x=10;
					}
					$start_y=120;
				}else{
					$start_y=35;
				}
				$height_row=3;
				$pdf->SetXY($start_x,$start_y);
				$pdf->SetFont('Arial','B',7);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell($array_space[0],$height_row,'POM','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',7);
				$pdf->SetFillColor(255,255,255);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[1],$height_row,ucfirst(strtolower(utf8_encode($row4['DESMED']))),'LTRB',0,'C',true);
				$start_y+=$height_row;
				$pdf->SetXY($start_x,$start_y);
				$pdf->SetFont('Arial','B',7);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell($array_space[0],$height_row,'Size','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',7);
				$pdf->SetFillColor(255,255,255);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[1],$height_row,utf8_encode($row4['DESTAL']),'LTRB',0,'C',true);
				$start_y+=$height_row;
				$pdf->SetXY($start_x,$start_y);
				$pdf->SetFont('Arial','B',7);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell($array_space[0],$height_row,'Spec','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',7);
				$pdf->SetFillColor(255,255,255);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[1],$height_row,utf8_encode($row4['MEDIDA']),'LTRB',0,'C',true);
				$start_y+=$height_row;
				$pdf->SetXY($start_x,$start_y);
				$pdf->SetFont('Arial','B',7);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell($array_space[0],$height_row,'Tol','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',7);
				$pdf->SetFillColor(255,255,255);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[1],$height_row,add_signo(1,$row4['TOLERANCIAMENOS']).' '.add_signo(2,$row4['TOLERANCIAMAS']),'LTRB',0,'C',true);
				$start_y+=$height_row;
				$pdf->SetXY($start_x,$start_y);
				$height_row=2.5;
				$pdf->SetFont('Arial','B',5);
				$pdf->SetFillColor(210,210,210);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[0],$height_row*3,'COLOR','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',5);
				$pdf->SetFillColor(210,210,210);
				$pdf->SetTextColor(0,0,0);
				$x=$pdf->GetX();
				$y=$pdf->GetY();
				for ($p=0; $p < count($colores); $p++) { 
					$pdf->SetXY($x,$y);
					$pdf->Cell($array_space[1]/count($colores),$height_row*3,'','LTRB',0,'C',true);
					$pdf->SetXY($x,$y);
					$array=get_array_colmed($colores[$p]);
					if (isset($array[0])) {
						$pdf->Cell($array_space[1]/count($colores),$height_row,$array[0],'',0,'C');
					}
					$pdf->SetXY($x,$y+$height_row);
					if (isset($array[1])) {
						$pdf->Cell($array_space[1]/count($colores),$height_row,$array[1],'',0,'C');
					}
					$pdf->SetXY($x,$y+$height_row*2);
					if (isset($array[2])) {
						$pdf->Cell($array_space[1]/count($colores),$height_row,$array[2],'',0,'C');
					}
					$x+=$array_space[1]/count($colores);
				}
				$start_y+=$height_row*3;
				$pdf->SetXY($start_x,$start_y);
				$height_row=2.5;
				$pdf->SetFont('Arial','B',5);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				for ($o=0; $o < count($pulgadas); $o++) {
					$pdf->Cell($array_space[0],$height_row,$pulgadas[$o],'LTRB',0,'C',true);
					$pdf->SetXY($start_x,$start_y+$height_row*($o+1));
				}
				$ant_desmed=utf8_encode($row4['DESMED']);
				$start_x+=$array_space[0];
				$pdf->SetXY($start_x,$start_y);
				$m++;
				array_push($ar_cuadros, $m);
			}
			//Detalle
			for ($o=0; $o < count($pulgadas); $o++) {
				if ($pulgadas[$o]=="0") {
					$pdf->SetFillColor(210,210,210);
					$pdf->SetTextColor(0,0,100);
				}else{
					$pdf->SetFillColor(255,255,255);
					$pdf->SetTextColor(0,0,100);
				}
				if(trasnform_format($row4['VALORREP'])==$pulgadas[$o]){
					$pdf->Cell($tamrowmark,$height_row,'X','LTRB',0,'C',true);
				}else{
					$pdf->Cell($tamrowmark,$height_row,'','LTRB',0,'C',true);
				}
				$pdf->SetXY($start_x,$start_y+$height_row*($o+1));
			}
			$start_x+=$tamrowmark;
			$pdf->SetXY($start_x,$start_y);
			$n++;
		}
		if ($n!=12) {
			for ($u=0; $u < 12-$n; $u++) { 
				for ($o=0; $o < count($pulgadas); $o++) {
					if ($pulgadas[$o]=="0") {
						$pdf->SetFillColor(210,210,210);
						$pdf->SetTextColor(0,0,100);
					}else{
						$pdf->SetFillColor(255,255,255);
						$pdf->SetTextColor(0,0,100);
					}
					$pdf->Cell($tamrowmark,$height_row,'','LTRB',0,'C',true);
					$pdf->SetXY($start_x,$start_y+$height_row*($o+1));
				}
				$start_x+=$tamrowmark;
				$pdf->SetXY($start_x,$start_y);
			}
		}

		$draw=false;
		$new_x=220;
		$new_y=35;
		for ($w=0; $w < 7; $w++) { 
			if (!isset($ar_cuadros[$w])) {
				if ($w==0) {
					$new_x=10;
					$new_y=35;
				}
				if ($w==1) {
					$new_x=80;
					$new_y=35;
				}
				if ($w==2) {
					$new_x=150;
					$new_y=35;
				}
				if ($w==3) {
					$new_x=220;
					$new_y=35;
				}
				if ($w==4) {
					$new_x=10;
					$new_y=120;
				}
				if ($w==5) {
					$new_x=80;
					$new_y=120;
				}
				if ($w==6) {
					$new_x=150;
					$new_y=120;
				}
				$draw=true;
			}else{
				$draw=false;
			}
			if ($draw) {
				$height_row=3;
				$pdf->SetXY($new_x,$new_y);
				$pdf->SetFont('Arial','B',7);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell($array_space[0],$height_row,'POM','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',7);
				$pdf->SetFillColor(255,255,255);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[1],$height_row,'','LTRB',0,'C',true);
				$new_y+=$height_row;
				$pdf->SetXY($new_x,$new_y);
				$pdf->SetFont('Arial','B',7);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell($array_space[0],$height_row,'Size','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',7);
				$pdf->SetFillColor(255,255,255);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[1],$height_row,'','LTRB',0,'C',true);
				$new_y+=$height_row;
				$pdf->SetXY($new_x,$new_y);
				$pdf->SetFont('Arial','B',7);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell($array_space[0],$height_row,'Spec','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',7);
				$pdf->SetFillColor(255,255,255);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[1],$height_row,'','LTRB',0,'C',true);
				$new_y+=$height_row;
				$pdf->SetXY($new_x,$new_y);
				$pdf->SetFont('Arial','B',7);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				$pdf->Cell($array_space[0],$height_row,'Tol','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',7);
				$pdf->SetFillColor(255,255,255);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[1],$height_row,'','LTRB',0,'C',true);
				$new_y+=$height_row;
				$pdf->SetXY($new_x,$new_y);
				$height_row=2.5;
				$pdf->SetFont('Arial','B',5);
				$pdf->SetFillColor(210,210,210);
				$pdf->SetTextColor(0,0,0);
				$pdf->Cell($array_space[0],$height_row*3,'COLOR','LTRB',0,'C',true);
				$pdf->SetFont('Arial','',5);
				$pdf->SetFillColor(210,210,210);
				$pdf->SetTextColor(0,0,0);
				$x=$pdf->GetX();
				$y=$pdf->GetY();
				for ($p=0; $p < count($colores); $p++) { 
					$pdf->SetXY($x,$y);
					$pdf->Cell($array_space[1],$height_row*3,'','LTRB',0,'C',true);
					$pdf->SetXY($x,$y);
				}
				$new_y+=$height_row*3;
				$pdf->SetXY($new_x,$new_y);
				$height_row=2.5;
				$pdf->SetFont('Arial','B',5);
				$pdf->SetFillColor(0,0,0);
				$pdf->SetTextColor(255,255,255);
				for ($o=0; $o < count($pulgadas); $o++) {
					$pdf->Cell($array_space[0],$height_row,$pulgadas[$o],'LTRB',0,'C',true);
					$pdf->SetXY($new_x,$new_y+$height_row*($o+1));
				}
				$new_x+=$array_space[0];
				$pdf->SetXY($new_x,$new_y);
				//Detalle
				for ($o=0; $o < count($pulgadas); $o++) {
					if ($pulgadas[$o]=="0") {
						$pdf->SetFillColor(210,210,210);
						$pdf->SetTextColor(0,0,100);
					}else{
						$pdf->SetFillColor(255,255,255);
						$pdf->SetTextColor(0,0,100);
					}
					for ($l=0; $l < count($colores)*$numpre; $l++) { 
						$pdf->Cell($tamrowmark,$height_row,'','LTRB',0,'C',true);
					}
					$pdf->SetXY($new_x,$new_y+$height_row*($o+1));
				}
				//$new_x+=$tamrowmark;
			}
		}

		$new_x=220;
		$new_y=120;
		$height_row=3;
		$pdf->SetXY($new_x,$new_y);
		$pdf->SetFont('Arial','B',7);
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell($array_space[0]+$array_space[1],$height_row,'COMMENTS','LTRB',0,'C',true);
		$new_y+=$height_row;
		$pdf->SetXY($new_x,$new_y);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell($array_space[0]+$array_space[1],79,'','LTRB',0,'C',true);
		$height_row=5;
		$new_x+=2;
		$new_y+=2;
		$pdf->SetXY($new_x,$new_y);
		$ar_comments=transform_comments($hojas[$i]->COMENTARIOS);
		for ($g=0; $g < count($ar_comments) ; $g++) { 
			$pdf->Cell($array_space[0]+$array_space[1]-4,$height_row,$ar_comments[$g],'',0,'L');
			$new_y+=$height_row;
			$pdf->SetXY($new_x,$new_y);
		}

		//DATA SUPERIOR DERECHA
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','B',9);
		$y=8;
		$pdf->SetXY(210,$y);
		$pdf->Cell(15,5,'DATE','',0,'R');
		$pdf->Cell(58,5,$row2['FECHA'],'B',0,'C',true);
		$pdf->Ln();
		$y+=6;
		$pdf->SetXY(210,$y);
		$pdf->Cell(15,5,'SIZE','',0,'R');
		$pdf->Cell(58,5,$hojas[$i]->DESTAL,'B',0,'C',true);
		$pdf->Ln();
		$y+=6;
		$ar_descolrep=get_array_descol($row2['DESCOLREP']);
		$pdf->SetXY(210,$y);
		$pdf->Cell(15,5,'COLOR','',0,'R');
		$pdf->Cell(58,5,$hojas[$i]->DESCOLREP,'B',0,'C',true);
		$pdf->Ln();
		if (isset($ar_descolrep[1])) {
			$y+=6;
			$pdf->SetXY(210,$y);
			$pdf->Cell(15,5,'','',0,'R');
			$pdf->Cell(58,5,$ar_descolrep[1],'B',0,'C',true);
			$pdf->Ln();
		}

		//COMENTARIOS
		$pdf->SetFont('Arial','',9);
		$y=127;
		$h_add=5;
		/*
		$comment1=$row2['COMENTARIOS'];
		$array_comments=transform_to_array($comment1);
		for ($i=0; $i < count($array_comments); $i++) {
			$y+=$h_add;
			$pdf->SetXY(223,$y);
			$pdf->Cell(60,5,$array_comments[$i],'',0,'L');
			$pdf->Ln();
		}*/

		//LOGO LE
		$file_path='../assets/img/logo_le.jpeg';
		$pdf->Image($file_path, 14,6,$logo_width,$logo_height,'JPG');
	}
}

$sql="BEGIN SP_RLE_SELECT_REPMEDPDF(:PO,:PACLIS,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':PO', $_GET['po']);
oci_bind_by_name($stmt, ':PACLIS', $_GET['paclis']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
$row=oci_fetch_assoc($OUTPUT_CUR);
$count=oci_num_rows($OUTPUT_CUR);
$ruta="";
if($count>0){
	$ruta=$row['RUTPDF'];
}else{
	$ruta="";
}

$dir_path="../../pdf-ReportesLE/";
if ($ruta!="") {
	unlink($dir_path.$ruta);
}

$time=date("Ymdhis");
$nombre='MED'.$_GET['po'].'-'.$time.'.pdf';
$sql="BEGIN SP_RLE_INSERT_REPMEDPDF(:PO,:PACLIS,:RUTPDF); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':PO', $_GET['po']);
oci_bind_by_name($stmt, ':PACLIS', $_GET['paclis']);
oci_bind_by_name($stmt, ':RUTPDF', $nombre);
$result=oci_execute($stmt);

$pdf->Output('F',$dir_path.$nombre,true);

oci_close($conn);

echo "1";

?>