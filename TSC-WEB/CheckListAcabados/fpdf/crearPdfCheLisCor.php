<?php
set_time_limit(240);
function process_res($text){
	if ($text=="1") {
		return "SI";
	}else{
		return "NO";
	}
}
function process_resultado($text){
	if ($text=="A") {
		return "Aprobado";
	}else{
		if ($text=="P") {
			return "Pendiente";
		}else{
			if ($text=="" || $text==null) {
				return "-";
			}else{
				return "Rechazado";
			}	
		}	
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

$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,"CHECK LIST CORTE",0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',10);

$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Ficha: ".$_GET['codfic']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Taller: ".$_GET['tal']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Pedido: ".$_GET['pedido']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Estilo TSC: ".$_GET['esttsc']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Estilo Cliente: ".$_GET['estcli']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Cliente: ".$_GET['cli']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Partida: ".$_GET['partida']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Cod. Tela: ".$_GET['codtel']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Color: ".$_GET['color']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Cant. Pedido: ".$_GET['canpre']),0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Ruta prenda: ".$_GET['ruttel']),0,0,'L');
$pdf->Ln();

$sql="BEGIN SP_CLC_SELECT_RESULTADOS(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
$resdoc="";
$resten="";
$restiz="";
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$resdoc=process_resultado($row['RESDOC']);
	$resten=process_resultado($row['RESTEN']);
	$restiz=process_resultado($row['RESTIZ']);
}

$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Resultados",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. Validacion de documentacion: ".$resdoc,0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. Validacion del tizado/moldes: ".$restiz,0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"3. Validacion del tendido: ".$resten,0,0,'L');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. Validacion de documentacion",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$pdf->Cell(120,6,"Descripcion",1,0,'L',true);
$pdf->Cell(35,6,"Resultado",1,0,'L',true);
//$pdf->Cell(35,6,"Reposo",1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(255);
$pdf->SetTextColor(0);

$sql="BEGIN SP_CLC_SELECT_CHEDOCGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$pdf->Cell(120,6,utf8_encode($row['DESDOC']),1,0,'L',true);
	$pdf->Cell(35,6,process_res($row['RESDOC']),1,0,'L',true);
	//$pdf->Cell(35,6,str_replace(",",".",$row['REPOSO']),1,0,'L',true);
	$pdf->Ln();
}
$pdf->Ln();

if ($_GET['obs1']!="") {
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell($pdf->get_max_width_to_white(),6,"Observacion",0,0,'L');
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell($pdf->get_max_width_to_white(),6,$_GET['obs1'],0,0,'L');
	$pdf->Ln();
	$pdf->Ln();
}

///////

$pdf->SetFont('Arial','B',9);
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. Validacion del tizado/moldes",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$pdf->Cell(120,6,"Descripcion",1,0,'L',true);
$pdf->Cell(35,6,"Veces",1,0,'L',true);
$pdf->Cell(35,6,"Resultado",1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(255);
$pdf->SetTextColor(0);

$sql="BEGIN SP_CLC_SELECT_CHETIZGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$pdf->Cell(120,6,utf8_encode($row['DESTIZ']),1,0,'L',true);
	$pdf->Cell(35,6,str_replace(",",".",$row['VECES']),1,0,'L',true);
	$pdf->Cell(35,6,process_res($row['RESTIZ']),1,0,'L',true);
	$pdf->Ln();
}
$pdf->Ln();

if ($_GET['obs2']!="") {
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell($pdf->get_max_width_to_white(),6,"Observacion",0,0,'L');
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell($pdf->get_max_width_to_white(),6,$_GET['obs2'],0,0,'L');
	$pdf->Ln();
	$pdf->Ln();
}

///////

$pdf->SetFont('Arial','B',9);
$pdf->Cell($pdf->get_max_width_to_white(),6,"3. Validacion del tendido",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$pdf->Cell(140,6,"Descripcion",1,0,'L',true);
$pdf->Cell(50,6,"Resultado",1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(255);
$pdf->SetTextColor(0);

$sql="BEGIN SP_CLC_SELECT_CHETENGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$pdf->Cell(140,6,utf8_encode($row['DESTEN']),1,0,'L',true);
	$pdf->Cell(50,6,process_res($row['RESTEN']),1,0,'L',true);
	$pdf->Ln();
}
$pdf->Ln();

if ($_GET['obs3']!="") {
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell($pdf->get_max_width_to_white(),6,"Observacion",0,0,'L');
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell($pdf->get_max_width_to_white(),6,$_GET['obs3'],0,0,'L');
	$pdf->Ln();
	$pdf->Ln();
}

$pdf->Output('D','Check list corte - '.str_replace("/","-",$_GET['codfic']).'.pdf',true);
//$pdf->Output('','',true);

oci_close($conn);
?>