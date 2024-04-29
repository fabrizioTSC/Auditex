<?php
set_time_limit(240);
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
	}
	function get_max_width_to_white() {
		return self::MAX_WIDTH_TO_WHITE;
	}
}
include("../config/connection.php");

$file_path_dir='../assets/tmp-RepDesMed/';
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("REPORTE DE DESVIACIÓN DE MEDIDAS"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Estilo TSC: ".$_GET['esttsc'],0,0);
$pdf->Ln();
if ($_GET['codfic']=="0") {
	$pdf->Cell($pdf->get_max_width_to_white(),6,"Ficha: TODOS",0,0);
}else{
	$pdf->Cell($pdf->get_max_width_to_white(),6,"Ficha: ".$_GET['esttsc'],0,0);
}
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Fecha desde ".$_GET['fecini']." hasta ".$_GET['fecfin'],0,0);
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Estilo Cliente: ".$_GET['estcli'],0,0);
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Cliente: ".$_GET['cliente'],0,0);
$pdf->Ln();


$ar_fecini=explode("-",$_GET['fecini']);
$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
$ar_fecfin=explode("-",$_GET['fecfin']);
$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];

$data=[];
$sql="BEGIN SP_AT_REPORTE_DESV_MEDIDAS(:ESTTSC,:CODFIC,:FECINI,:FECFIN,:TIPO,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':ESTTSC', $_GET['esttsc']);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
$tipo=2;
oci_bind_by_name($stmt, ':TIPO', $tipo);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$obj=new stdClass();
	$obj->CODMED=$row['CODMED'];
	$obj->DESMED=utf8_encode($row['DESMED']);
	$obj->CODDES=$row['CODDES'];
	$obj->SECUENCIA=$row['SECUENCIA'];
	$obj->VALPUL=$row['VALPUL'];
	$obj->VALCM=$row['VALCM'];
	$obj->TOLVAL=$row['TOLVAL'];
	$obj->CODTAL=$row['CODTAL'];
	$obj->DESTAL=utf8_encode($row['DESTAL']);
	$obj->ORDEN=$row['ORDEN'];
	$obj->TOTAL=$row['TOTAL'];
	array_push($data,$obj);
}

$general=[];
$header=['Desv.'];
$ch=0;
$fila=[];
$sum_fila=0;
$sum_med=0;
$sum_med_ver=0;
$val_tal=[];
$ant_codmed="";
$ant_valpul="";
for ($i=0; $i < count($data); $i++) {
	if ($ant_valpul!=$data[$i]->VALPUL) {
		if ($ant_valpul!="") {
			$aux=[];
			array_push($aux,$val_tal);
			array_push($aux,$sum_fila);
			array_push($fila,$aux);
		}
		$val_tal=[];
		$sum_fila=0;
		array_push($val_tal,$data[$i]->VALPUL);
		$ch++;
	}
	if ($data[$i]->VALPUL=="0") {
		array_push($val_tal,$data[$i]->TOTAL."|0");
	}else{
		array_push($val_tal,$data[$i]->TOTAL."|".$data[$i]->TOLVAL);
	}
	if ($ch<2) {
		array_push($header,$data[$i]->DESTAL);
	}
	$sum_fila+=$data[$i]->TOTAL;
	$ant_valpul=$data[$i]->VALPUL;

	if ($ant_codmed!=$data[$i]->CODMED) {
		if ($ant_codmed!="") {
			$aux=[];
			array_push($aux,$data[$i]->DESMED);
			array_push($aux,$fila);
			array_push($header,"TOTAL");
			array_push($header,"%");
			array_push($aux,$header);
			array_push($aux,$sum_med);
			array_push($aux,$sum_med_ver);
			array_push($general,$aux);
			$fila=[];
			$sum_med=0;
			$sum_med_ver=0;
			$ch=1;
			$header=['Desv.',$data[$i]->DESTAL];
		}
	}
	$sum_med+=$data[$i]->TOTAL;
	if ($data[$i]->TOLVAL=="0" || $data[$i]->VALPUL=="0") {
		$sum_med_ver+=$data[$i]->TOTAL;
	}
	$ant_codmed=$data[$i]->CODMED;
}
$aux=[];
array_push($aux,$val_tal);
array_push($aux,$sum_fila);
array_push($fila,$aux);
$aux=[];
array_push($aux,$data[count($data)-1]->DESMED);//0
array_push($aux,$fila);//1
array_push($header,"TOTAL");
array_push($header,"%");
array_push($aux,$header);//2
array_push($aux,$sum_med);//3
array_push($aux,$sum_med_ver);//4
array_push($general,$aux);

$pdf->Ln();
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0);
for ($i=0; $i < count($general); $i++) {
	if ($i!=0) {
		$pdf->AddPage();
		$pdf->Ln(12);	
	}
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell($pdf->get_max_width_to_white(),6,$general[$i][0],0,0,'L');
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	if ($general[$i][3]!=0) {
		$pdf->Cell($pdf->get_max_width_to_white(),4,(round(($general[$i][3]-$general[$i][4])*10000/$general[$i][3])/100)."% fuera de tolerancia",0,0,'C');
		$pdf->Ln();
		$pdf->Cell($pdf->get_max_width_to_white(),4,(round($general[$i][4]*10000/$general[$i][3])/100)."% dentro de tolerancia",0,0,'C');
		$pdf->Ln();
	}else{
		$pdf->Cell($pdf->get_max_width_to_white(),4,"0% fuera de tolerancia",0,0,'C');
		$pdf->Ln();
		$pdf->Cell($pdf->get_max_width_to_white(),4,"100% dentro de tolerancia",0,0,'C');
		$pdf->Ln();
	}
	$aux=$general[$i][2];
	$pdf->SetFillColor(152,15,15);
	$pdf->SetTextColor(255);
	$pdf->SetFont('Arial','B',9);
	for ($j=0; $j < count($aux); $j++) {
		$pdf->Cell($pdf->get_max_width_to_white()/count($aux),6,$aux[$j],1,0,'L',true);
	}
	$pdf->Ln();
	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial','',9);
	$aux=$general[$i][1];
	for ($j=0; $j < count($aux); $j++) {
		$fila=$aux[$j][0];
		for ($x=0; $x < count($fila); $x++) {
			$ar=explode("|",$fila[$x]);
			if (count($ar)>1) {
				if ($ar[1]=="2") {
					$pdf->SetFillColor(255,255,255);
				}else{
					$pdf->SetFillColor(229,255,201);
				}
				$pdf->Cell($pdf->get_max_width_to_white()/(count($fila)+2),6,$ar[0],1,0,'C',true);
			}else{
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell($pdf->get_max_width_to_white()/(count($fila)+2),6,$ar[0],1,0,'C',true);
			}
		}
		$pdf->SetFillColor(200,200,200);
		$pdf->Cell($pdf->get_max_width_to_white()/(count($fila)+2),6,$aux[$j][1],1,0,'C',true);
		if ($general[$i][3]!=0) {
			$pdf->Cell($pdf->get_max_width_to_white()/(count($fila)+2),6,(round($aux[$j][1]*10000/$general[$i][3])/100)."%",1,0,'C',true);
		}else{
			$pdf->Cell($pdf->get_max_width_to_white()/(count($fila)+2),6,"0%",1,0,'C',true);
		}
		$pdf->Ln();
	}
	$pdf->Ln();

	$file_path=$file_path_dir.$_GET['esttsc']."-".$_GET['codfic']."-".($i+1).'-tmp.png';
	$array=$pdf->resizeToFit($file_path);
	$pdf->Image($file_path,$array[2],180,$array[0] ,$array[1],'PNG');
	$pdf->Ln($array[1]);
}

$pdf->Output('D','Reporte de Desviación de medidas - Estilo TSC '.$_GET['esttsc'].' - Ficha '.$_GET['codfic'].'.pdf',true);
//$pdf->Output('','',true);

oci_close($conn);

//// DELETE FILES
for ($i=0; $i < $_GET['numimg']; $i++) {
    unlink($file_path_dir.$_GET['esttsc']."-".$_GET['codfic']."-".($i+1)."-tmp.png");
}

?>