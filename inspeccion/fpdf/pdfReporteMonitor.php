<?php
require('fpdf181/fpdf.php');
class PDF extends FPDF {
	const DPI = 96;
	const MM_IN_INCH = 25.4;
	const A4_HEIGHT = 297;
	const A4_WIDTH = 210;
	const WIDTH_MARGIN = 5;
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

function getColor($color){
	$r=20;
	$g=20;
	$b=20;
	switch ($color) {
		case 'green':
			$r=20;
			$g=160;
			$b=20;
			break;
		case 'red':
			$r=200;
			$g=50;
			$b=10;
			break;
		default:
			break;
	}
	return array($r,$g,$b);
}

include("../config/connection.php");
$sql="select SYSDATE from dual";	
$stmt=oci_parse($conn, $sql);
$result=oci_execute($stmt);
$rowFecha=oci_fetch_array($stmt);

$file_path_dir='../assets/tmp/';

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("RESUMEN GENERAL DE REGISTRO DE INSPECCIÓN"),0,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',13);

if (isset($_GET['turno'])) {
	$pdf->Cell($pdf->get_max_width_to_white()/2,6,"Turno: ".utf8_decode($_GET['turno']),0,0,'L');
	$pdf->Cell($pdf->get_max_width_to_white()/2,6,"Fecha: ".$rowFecha[0],0,0,'L');

	$sql="BEGIN SP_INSP_SELECT_INFREPTUR(:TURNO,:CANPRE,:CANPREDEF,:TOTDEF); END;";		
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,":TURNO", $_GET['turno']);
	oci_bind_by_name($stmt,":CANPRE", $canpre,40);
	oci_bind_by_name($stmt,":CANPREDEF", $canpredef,40);
	oci_bind_by_name($stmt,":TOTDEF", $totdef,40);
	$result=oci_execute($stmt);
}else{
	$sql="BEGIN SP_INSP_SELECT_INFREP(:CODTLL,:CANPRE,:CANPREDEF,:TOTDEF,:CODFIC,:PEDIDO,:DESCLI); END;";		
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,":CODTLL", $_GET['ct']);
	oci_bind_by_name($stmt,":CANPRE", $canpre,40);
	oci_bind_by_name($stmt,":CANPREDEF", $canpredef,40);
	oci_bind_by_name($stmt,":TOTDEF", $totdef,40);
	oci_bind_by_name($stmt,":CODFIC", $codfic,40);
	oci_bind_by_name($stmt,":PEDIDO", $pedido,40);
	oci_bind_by_name($stmt,":DESCLI", $descli,40);
	$result=oci_execute($stmt);

	$pdf->Cell($pdf->get_max_width_to_white()/2,6,"Linea: ".utf8_decode($_GET['nt']),0,0,'L');
	$pdf->Cell($pdf->get_max_width_to_white()/2,6,"Fecha: ".$rowFecha[0],0,0,'L');
	$pdf->Ln();
	$pdf->Cell($pdf->get_max_width_to_white()/2,6,"Ficha: ".utf8_decode($_GET['cf']),0,0,'L');
	$pdf->Cell($pdf->get_max_width_to_white()/2,6,"Pedido: ".$_GET['p'],0,0,'L');
	$pdf->Ln();
	$pdf->Cell($pdf->get_max_width_to_white(),6,"Cliente: ".$_GET['dc'],0,0,'L');
	$pdf->Ln();
}

/*
$sql="select sum(CANPRE) as CANPRE,SUM(CANPREDEF) as CANPREDEF from INSCOS WHERE to_char(FECINSCOS,'YYYYMMDD')=to_char(SYSDATE,'YYYYMMDD') and CODTLL=".$_GET['ct'];
$stmt=oci_parse($conn,$sql);
$result=oci_execute($stmt);
$row=oci_fetch_array($stmt,OCI_ASSOC);*/

$pdf->Ln();
$hei_x_line=4;
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(210);
$pdf->Cell(40,$hei_x_line,"",0,0);
$pdf->Cell(30,$hei_x_line,"Total prendas",0,0,'C',true);
$pdf->Cell(10,$hei_x_line,"",0,0);
$pdf->Cell(30,$hei_x_line,"Total prendas",0,0,'C',true);
$pdf->Cell(10,$hei_x_line,"",0,0);
$pdf->Cell(30,$hei_x_line,"Total prendas",0,0,'C',true);
$pdf->Ln();
$pdf->Cell(40,$hei_x_line,"",0,0);
$pdf->Cell(30,$hei_x_line,"inspeccionadas",0,0,'C',true);
$pdf->Cell(10,$hei_x_line,"",0,0);
$pdf->Cell(30,$hei_x_line,"sin defcto",0,0,'C',true);
$pdf->Cell(10,$hei_x_line,"",0,0);
$pdf->Cell(30,$hei_x_line,"defectuosas",0,0,'C',true);
$pdf->Ln();

$pdf->SetFont('Arial','',11);
$pdf->Cell(40,$hei_x_line,"",0,0);
$c=getColor("green");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(20,$hei_x_line,$canpre,0,0,'C',true);
$c=getColor("red");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(10,$hei_x_line,"100%",0,0,'C',true);
$pdf->Cell(10,$hei_x_line,"",0,0);
$c=getColor("green");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(20,$hei_x_line,$canpre-$canpredef,0,0,'C',true);
$c=getColor("red");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
if ($canpre!=0) {
	$pdf->Cell(10,$hei_x_line,round(($canpre-$canpredef)*100/$canpre)."%",0,0,'C',true);
}else{
	$pdf->Cell(10,$hei_x_line,"0%",0,0,'C',true);
}
$pdf->Cell(10,$hei_x_line,"",0,0);
$c=getColor("green");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(20,$hei_x_line,$canpredef,0,0,'C',true);
$c=getColor("red");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
if ($canpre!=0) {
	$pdf->Cell(10,$hei_x_line,round($canpredef*100/$canpre)."%",0,0,'C',true);
}else{
	$pdf->Cell(10,$hei_x_line,"0%",0,0,'C',true);
}
$pdf->Ln();

$file_path=$file_path_dir.$_GET['n'].'-1.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],60,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

if (isset($_GET['turno'])) {
	$sql="BEGIN SP_INSP_SELECT_INFREPDET1TURN(:TURNO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':TURNO', $_GET['turno']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
}else{
	$sql="BEGIN SP_INSP_SELECT_INFREPDET1(:CODTLL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
}

$sum1=0;
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$sum1+=(int) $row['CANTIDAD'];
}

if (isset($_GET['turno'])) {
	$sql="BEGIN SP_INSP_SELECT_INFREPDET2TUR(:TURNO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':TURNO', $_GET['turno']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
}else{	
	$sql="BEGIN SP_INSP_SELECT_INFREPDET2(:CODTLL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
}

$sum2=0;
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$sum2+=(int) $row['CANTIDAD'];
}

$pdf->Ln(5);
$pdf->Cell(190,1,"",0,0,'L',true);

$pdf->Ln(5);
$c=getColor("black");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->SetFont('Arial','',9);
$pdf->Cell(80,$hei_x_line,"",0,0);
$pdf->Cell(30,$hei_x_line,"Total defectos",0,0,'C',true);
$pdf->Ln();
$pdf->SetFont('Arial','',11);
$pdf->Cell(80,$hei_x_line,"",0,0);
$c=getColor("green");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(20,$hei_x_line,$sum1+$sum2,0,0,'C',true);
$c=getColor("red");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(10,$hei_x_line,"100%",0,0,'C',true);

//////// DETALLE DEFECTO1
$pdf->Ln();
$c=getColor("black");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,$hei_x_line,"Def. Const. - Limp.",0,0,'C',true);
$pdf->Ln();
$pdf->Cell(30,$hei_x_line,"Manchas",0,0,'C',true);
$pdf->Ln();
$pdf->SetFont('Arial','',11);
$c=getColor("green");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(20,$hei_x_line,$sum1,0,0,'C',true);
$c=getColor("red");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(10,$hei_x_line,(round($sum1*100/($sum1+$sum2)))."%",0,0,'C',true);
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'-2.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],180,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln();

//////// DETALLE DEFECTO2
$pdf->AddPage();
$c=getColor("black");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,$hei_x_line,"Def. Tela - Otros",0,0,'C',true);
$pdf->Ln();
$pdf->SetFont('Arial','',11);
$c=getColor("green");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(20,$hei_x_line,$sum2,0,0,'C',true);
$c=getColor("red");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->Cell(10,$hei_x_line,(round($sum2*100/($sum1+$sum2)))."%",0,0,'C',true);
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'-3.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],17,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln();

///// PAGINA 3
$pdf->AddPage();
$c=getColor("black");
$pdf->SetTextColor($c[0],$c[1],$c[2]);
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Diagrama de Pareto por Operación - Costura"),0,0,'L');
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'-4.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],20,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln(5);
$pdf->Cell(190,1,"",0,0,'L',true);
$pdf->Ln(5);
$file_path=$file_path_dir.$_GET['n'].'-5.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],110,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln();

///// PAGINA 4
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Diagrama de Pareto por Defectos"),0,0,'L');
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'-6.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],20,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln(5);
$pdf->Cell(190,1,"",0,0,'L',true);
$pdf->Ln(5);
$file_path=$file_path_dir.$_GET['n'].'-7.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],110,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln();

///// PAGINA 5
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Defectos causados - Hombre VS. Máquina"),0,0,'L');
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'-8.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],20,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln(5);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Detalle defectos por máquina"),0,0,'L');
$pdf->Ln(5);
$file_path=$file_path_dir.$_GET['n'].'-9.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],130,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);
$pdf->Ln();

///// PAGINA 5
$pdf->AddPage();
$file_path=$file_path_dir.$_GET['n'].'-10.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],10,$array[0] ,$array[1],'PNG');

if (isset($_GET['turno'])) {
	$pdf->Output('D','Reporte inspeccion - Turno '.$_GET['turno'].'.pdf',true);
}else{
	$pdf->Output('D','Reporte inspeccion - '.$_GET['nt'].'.pdf',true);
}
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