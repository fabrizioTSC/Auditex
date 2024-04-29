<?php
set_time_limit(240);

function show_resultado($text){
	if ($text=="A") {
		return "Aprobado";
	}else{
		if ($text=="C") {
			return "Aprobado no conforme";
		}else{
			return "Rechazado";
		}
	}
}
function show_res_tsc($text){
	if ($text=="C") {
		return "ANC";
	}else{
		return $text;
	}
}
function format_parraf($text){
	/*$newtext="";
	for ($i=0; $i <strlen($text) ; $i++) { 
		if ($i%5==0 and $i!=0) {
			$newtext.="\n";
		}else{
			$newtext.=$text[$i];
		}
	}
	return $newtext;*/
	return $text;
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
	function myCell($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=3*$height+3;
		$len=strlen($t);
		$tam_text=25;
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
	function myCell2($w,$h,$x,$t){
		$height=$h/3;
		$len=strlen($t);
		$tam_text=22;
		if ($len>$tam_text) {
			if ($h*10+$this->GetX()*10>self::A4_HEIGHT-self::WIDTH_MARGIN*2-40) {
				$this->AddPage();
			}
			$text=str_split($t,$tam_text);
			if (count($text)==2) {
				$ar_heights=[$height+2,3*$height+3];
			}else{
				if (count($text)>2) {
					$ar_heights=[$height+2,3*$height,4*$height+3];
				}
			}
			$tam=count($text);
			if (count($text)>2) {
				$tam=3;
			}
			for ($i=0; $i < $tam; $i++) { 
			$this->SetX($x);
			$this->Cell($w,$ar_heights[$i],$text[$i],'','','');
			}
			$this->SetX($x);
			$this->Cell($w,$h,'','LTRB',0,'L',0);
		}else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'LTRB',0,'L',0);
		}
	}
}
include("../config/connection.php");

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Auditoría Tela"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Partida: ".$_GET['partida'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Cliente: ".$_GET['cli'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Proveedor: ".$_GET['prov'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Codigo de tela: ".$_GET['codtel'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Articulo: ".$_GET['art'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Color: ".$_GET['col'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Composicion: ".$_GET['com'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Programa: ".$_GET['prog'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"X-Factory: ".$_GET['xfac'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Destino: ".$_GET['des'],0,0,'L');
$pdf->Ln();
/*$pdf->Cell($pdf->get_max_width_to_white(),6,"Responsable: ".$_GET['respon'],0,0,'L');
$pdf->Ln();*/
$pdf->Cell($pdf->get_max_width_to_white(),6,"Peso (Kg.): ".$_GET['pes'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Peso Programado (Kg.): ".$_GET['pesoprg'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Rendimiento por peso: ".$_GET['ren'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Auditor: ".$_GET['auditor'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Supervisor: ".$_GET['supervisor'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Fecha inicio: ".$_GET['feciniaud'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Fecha fin: ".$_GET['fecfinaud'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Ruta tela: ".$_GET['ruttel'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Est. Cliente: ".$_GET['estcliestcon'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"CMC Proveedor: ".$_GET['cmcprv'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"CMC WTS: ".$_GET['cmcwts'],0,0,'L');
$pdf->Ln();
if ($_GET['estcon']!="") {
	$pdf->Cell($pdf->get_max_width_to_white(),6,"Estudio de consumo: ".$_GET['estcon'],0,0,'L');
	$pdf->Ln();
}
if ($_GET['datcol']!="") {
	$pdf->Cell($pdf->get_max_width_to_white(),6,"Dato color: ".$_GET['datcol'],0,0,'L');
	$pdf->Ln();
}
if ($_GET['motivo']!="") {
	$pdf->Cell($pdf->get_max_width_to_white(),6,"Motivo: ".$_GET['motivo'],0,0,'L');
	$pdf->Ln();
}

	$sql="BEGIN SP_AUDTEL_SELECT_RESULTADOS(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :PESO, :PESOAUD, :PESOAPRO, :PESOCAI, :CALIFICACION, :TIPO, :RESULTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
	oci_bind_by_name($stmt, ':PESO', $peso,40);
	oci_bind_by_name($stmt, ':PESOAUD', $pesoaud,40);
	oci_bind_by_name($stmt, ':PESOAPRO', $pesoapro,40);
	oci_bind_by_name($stmt, ':PESOCAI', $pesocai,40);
	oci_bind_by_name($stmt, ':CALIFICACION', $calificacion,40);
	oci_bind_by_name($stmt, ':TIPO', $tipo,40);
	oci_bind_by_name($stmt, ':RESULTADO', $resultado,40);
	$result=oci_execute($stmt);

$pdf->Ln();
$pdf->SetFont('Arial','',9);

$first_col_width=0;
//MISMO TAMAÑO TODO
//$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/(count($headers)-1);
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/2;

$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$pdf->Cell($width_by_cell,6,"Resultado Auditoria",1,0,'L',true);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($width_by_cell,6,show_resultado($resultado),1,0,'L',true);
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$pdf->Cell($width_by_cell,6,"Puntaje partida",1,0,'L',true);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($width_by_cell,6,$calificacion,1,0,'L',true);
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$pdf->Cell($width_by_cell,6,"Calificacion partida",1,0,'L',true);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($width_by_cell,6,$tipo,1,0,'L',true);
$pdf->Ln();

$pdf->Ln();
$first_col_width=0;
//MISMO TAMAÑO TODO
//$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/(count($headers)-1);
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/3;
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$pdf->Cell($width_by_cell,6,"",1,0,'L',true);
$pdf->Cell($width_by_cell,6,"KG.",1,0,'L',true);
$pdf->Cell($width_by_cell,6,"%",1,0,'L',true);
$pdf->Ln();
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($width_by_cell,6,"KG. Partida",1,0,'L',true);
$pdf->Cell($width_by_cell,6,str_replace(",", ".", $peso),1,0,'L',true);
$pdf->Cell($width_by_cell,6,"100%",1,0,'L',true);
$pdf->Ln();
$pdf->Cell($width_by_cell,6,"KG. Auditado",1,0,'L',true);
$pdf->Cell($width_by_cell,6,str_replace(",", ".", $pesoaud),1,0,'L',true);
if ($peso!=0) {
	$pdf->Cell($width_by_cell,6,(round(floatval(str_replace(",", ".", $pesoaud))*10000/floatval(str_replace(",", ".", $peso)))/100)."%",1,0,'L',true);
}else{
	$pdf->Cell($width_by_cell,6,"0%",1,0,'L',true);
}
$pdf->Ln();
$pdf->Cell($width_by_cell,6,"KG. Aprovechable",1,0,'L',true);
$pdf->Cell($width_by_cell,6,str_replace(",", ".", $pesoapro),1,0,'L',true);
if ($peso!=0) {
	$pdf->Cell($width_by_cell,6,(round(floatval(str_replace(",", ".", $pesoapro))*10000/floatval(str_replace(",", ".", $peso)))/100)."%",1,0,'L',true);
}else{
	$pdf->Cell($width_by_cell,6,"0%",1,0,'L',true);
}
$pdf->Ln();
$pdf->Cell($width_by_cell,6,"KG. Caida",1,0,'L',true);
$pdf->Cell($width_by_cell,6,str_replace(",", ".", $pesocai),1,0,'L',true);
if ($peso!=0) {
	$pdf->Cell($width_by_cell,6,(round(floatval(str_replace(",", ".", $pesocai))*10000/floatval(str_replace(",", ".", $peso)))/100)."%",1,0,'L',true);
}else{
	$pdf->Cell($width_by_cell,6,"0%",1,0,'L',true);
}
$pdf->Ln();
$pdf->Ln();

	$sql="BEGIN SP_AUDTEL_VALIDAR_NUMFORM(:PARTIDA,:CODPRV,:NUMVEZ,:NUMFORM,:RES1,:RES2,:RES3); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
	oci_bind_by_name($stmt, ':NUMFORM', $numform,40);
	oci_bind_by_name($stmt, ':RES1', $res1,40);
	oci_bind_by_name($stmt, ':RES2', $res2,40);
	oci_bind_by_name($stmt, ':RES3', $res3,40);
	$result=oci_execute($stmt);


$pdf->SetFont('Arial','B',11);
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. TONO",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Calificacion: ".show_resultado($res1),0,0,'L');
$pdf->Ln();
		if ($_GET['respon1']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Responsable: ".$_GET['respon1'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Encargado: ".$_GET['encar1'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['obs1']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Observacion: ".$_GET['obs1'],0,0,'L');
$pdf->Ln();
		}

$pdf->SetFont('Arial','B',11);
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. APARIENCIA",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Calificacion: ".show_resultado($res2),0,0,'L');
$pdf->Ln();
		if ($_GET['respon2']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Responsable: ".$_GET['respon2'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Encargado: ".$_GET['encar2'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['obs2']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Observacion: ".$_GET['obs2'],0,0,'L');
$pdf->Ln();
		}

$pdf->SetFont('Arial','B',11);
$pdf->Cell($pdf->get_max_width_to_white(),6,"3. ESTABILIDAD DIMENSIONAL",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Calificacion: ".show_resultado($res3),0,0,'L');
$pdf->Ln();
		if ($_GET['respon3']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Responsable: ".$_GET['respon3'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Encargado: ".$_GET['encar3'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['obs3']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Observacion: ".$_GET['obs3'],0,0,'L');
$pdf->Ln();
		}

$pdf->SetFont('Arial','B',11);
$pdf->Cell($pdf->get_max_width_to_white(),6,"4. CONTROL DE DEFECTOS",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Calificacion: ".$_GET['resblo4'],0,0,'L');
$pdf->Ln();
		if ($_GET['respon4']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Responsable: ".$_GET['respon4'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Encargado: ".$_GET['encar4'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['obs4']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Observacion: ".$_GET['obs4'],0,0,'L');
$pdf->Ln();
		}
$pdf->Ln();

	if ($res1!=null) {
$pdf->SetFont('Arial','B',11);
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. TONO",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$first_col_width=60;
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/3;
$width_array=[50,15,65,60];
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$pdf->Cell($width_array[0],6,"CONTROL DE TONO",1,0,'L',true);
$pdf->Cell($width_array[1],6,"TSC",1,0,'L',true);
$pdf->Cell($width_array[2],6,"REC. 1",1,0,'L',true);
$pdf->Cell($width_array[3],6,"REC. 2",1,0,'L',true);
$pdf->Ln();

		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDTONEXC(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($width_array[0],6,$row['DESTON'],1,0,'L',true);
$pdf->Cell($width_array[1],6,show_res_tsc($row['RESTSC']),1,0,'L',true);
$pdf->Cell($width_array[2],6,utf8_encode($row['DESREC1']),1,0,'L',true);
$pdf->Cell($width_array[3],6,utf8_encode($row['DESREC2']),1,0,'L',true);
$pdf->Ln();
		}
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Calificacion: ".show_resultado($res1),0,0,'L');
$pdf->Ln();
		if ($_GET['respon1']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Responsable: ".$_GET['respon1'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Encargado: ".$_GET['encar1'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['aud1']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Auditor: ".$_GET['aud1'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['coo1']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Coordinador: ".$_GET['coo1'],0,0,'L');
$pdf->Ln();
		}
$pdf->Ln();
	}
	if ($res2!=null) {
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. APARIENCIA",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$first_col_width=0;
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/6;
$width_array=[25,50,15,80,20];
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$pdf->Cell($width_array[0],6,"AREA",1,0,'L',true);
$pdf->Cell($width_array[1],6,"C. APARIENCIA",1,0,'L',true);
$pdf->Cell($width_array[2],6,"TSC",1,0,'L',true);
$pdf->Cell($width_array[3],6,"REC.",1,0,'L',true);
$pdf->Cell($width_array[4],6,"CM.",1,0,'L',true);
/*$pdf->Cell($width_array[5],6,"CAIDA",1,0,'L',true);*/
$pdf->Ln();

		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDCAEXC(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Cell($width_array[0],6,$row['DSCAREAD'],1,0,'L',true);
$pdf->Cell($width_array[1],6,$row['DESAPA'],1,0,'L',true);
$pdf->Cell($width_array[2],6,show_res_tsc($row['RESTSC']),1,0,'L',true);
$pdf->Cell($width_array[3],6,utf8_encode($row['DESREC1']),1,0,'L',true);
$pdf->Cell($width_array[4],6,str_replace(",",".",$row['CM']),1,0,'L',true);
/*$pdf->Cell($width_array[5],6,str_replace(",",".",$row['CAIDA']),1,0,'L',true);*/
$pdf->Ln();
		}
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Calificacion: ".show_resultado($res2),0,0,'L');
$pdf->Ln();
		if ($_GET['respon2']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Responsable: ".$_GET['respon2'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Encargado: ".$_GET['encar2'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['aud2']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Auditor: ".$_GET['aud2'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['coo2']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Coordinador: ".$_GET['coo2'],0,0,'L');
$pdf->Ln();
		}
$pdf->Ln();
	}
	if ($res3!=null) {
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell($pdf->get_max_width_to_white(),6,"3. ESTABILIDAD DIMENSIONAL",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$width_col=[50,15,15,15,15,15,65];
$first_col_width=50;
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/6;
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$pdf->Cell($width_col[0],6,"CARACTERISTICA",1,0,'L',true);
$pdf->Cell($width_col[1],6,"TOLERANCIA",1,0,'L',true);
$pdf->Cell($width_col[2],6,"ESTANDAR",1,0,'L',true);
$pdf->Cell($width_col[3],6,"TSC",1,0,'L',true);
$pdf->Cell($width_col[4],6,"TESTING",1,0,'L',true);
$pdf->Cell($width_col[5],6,"CON.",1,0,'L',true);
$pdf->Cell($width_col[6],6,"RECOMENDACION",1,0,'L',true);
/*$pdf->Cell($width_col[7],6,"% CAIDA",1,0,'L',true);*/
$pdf->Ln();

		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDEDEXCV2(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$tolerancia=$row['TOLERANCIA'];
			if ((int)$row['TOLERANCIA']!=0) {
				$tolerancia="+/- ".$row['TOLERANCIA']." ".$row['DIMTOL'];
			}
			$valor=floatval(str_replace(",",".",$row['VALOR']));
			$valor2=floatval(str_replace(",",".",$row['VALORTSC']));
			if ($row['DIMVAL']=="%") {
				$valor=(floatval("0".str_replace(",",".",$row['VALOR'])))." ".$row['DIMVAL'];
				$valor2=floatval(str_replace(",",".",$row['VALORTSC']))." ".$row['DIMVAL'];
			}
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$x=$pdf->GetX();
$pdf->myCell($width_col[0],6,$x,$row['DESESTDIM']);
$pdf->Cell($width_col[1],6,$tolerancia,1,0,'L',true);
$pdf->Cell($width_col[2],6,$valor,1,0,'L',true);
$pdf->Cell($width_col[3],6,$valor2,1,0,'L',true);
$pdf->Cell($width_col[4],6,$row['TESTINGF'],1,0,'L',true);
$pdf->Cell($width_col[5],6,show_res_tsc($row['RESTSC']),1,0,'L',true);
$x=$pdf->GetX();
$pdf->myCell($width_col[6],6,$x,utf8_encode($row['DESREC1']));
/*$pdf->Cell($width_col[7],6,str_replace(",",".",$row['VALORCAIDA']),1,0,'L',true);*/
$pdf->Ln();
		}
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Calificacion: ".show_resultado($res3),0,0,'L');
$pdf->Ln();
		if ($_GET['respon3']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Responsable: ".$_GET['respon3'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Encargado: ".$_GET['encar3'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['aud3']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Auditor: ".$_GET['aud3'],0,0,'L');
$pdf->Ln();
		}
		if ($_GET['coo3']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Coordinador: ".$_GET['coo3'],0,0,'L');
$pdf->Ln();
		}
$pdf->Ln();
	}
$pdf->SetFont('Arial','B',11);
$pdf->Cell($pdf->get_max_width_to_white(),6,"4. CONTROL DE DEFECTOS",0,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell($pdf->get_max_width_to_white(),6,"Rollos: ".$_GET['numrollos']." - Rollos a auditar: ".$_GET['audrollos'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Calificacion: ".$_GET['cali4'],0,0,'L');
$pdf->Ln();

$body=[];
$i=0;
$body[$i]=array("N. ROLLO");
$i++;
$body[$i]=array("ANCHO SIN REPOSO");
$i++;
$body[$i]=array("DENSIDAD SIN REPOSO");
$i++;
$body[$i]=array("PESO POR ROLLO");
$i++;

	$sql="BEGIN SP_AUDTEL_SELECT_DEFROLEXC(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
$body[$i]=array($row['DSCAREAD']." - ".$row['DESDEF']." (".$row['PUNTOS'].")");
$i++;
	}
$body[$i]=array("TOTAL PUNTOS DEFECTOS");
$i++;
$body[$i]=array("METROS");
$i++;
$body[$i]=array("ANCHO TOTAL");
$i++;
$body[$i]=array("ANCHO UTIL CON REPOSO");
$i++;
$body[$i]=array("INCLINACION STD");
$i++;
$body[$i]=array("INCLINACION DER");
$i++;
$body[$i]=array("INCLINACION IZQ");
$i++;
$body[$i]=array("INCLINACION MED");
$i++;
$body[$i]=array("RAPPORT");
$i++;
$body[$i]=array("PUNTOS POR ROLLO");
$i++;
$body[$i]=array("CALIFICACION POR ROLLO");
$i++;

	$sql="BEGIN SP_AUDTEL_SELECT_PARROL(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
$i=0;
$aux=$body[$i];
$aux[count($body[$i])]=$row['NUMROL'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['ANCSINREP'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['DENSINREP'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['PESO'];
$body[$i]=$aux;
$i++;
		$sql="BEGIN SP_AUDTEL_SELECT_PARROLDEF(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:NUMROL,:OUTPUT_CUR); END;";
		$stmt2=oci_parse($conn, $sql);
		oci_bind_by_name($stmt2, ':PARTIDA', $_GET['partida']);
		oci_bind_by_name($stmt2, ':CODTEL', $_GET['codtel']);
		oci_bind_by_name($stmt2, ':CODPRV', $_GET['codprv']);
		oci_bind_by_name($stmt2, ':CODTAD', $_GET['codtad']);
		oci_bind_by_name($stmt2, ':NUMVEZ', $_GET['numvez']);
		oci_bind_by_name($stmt2, ':PARTE', $_GET['parte']);
		oci_bind_by_name($stmt2, ':NUMROL', $row['NUMROL']);
		$OUTPUT_CUR2=oci_new_cursor($conn);
		oci_bind_by_name($stmt2, ':OUTPUT_CUR', $OUTPUT_CUR2,-1,OCI_B_CURSOR);
		$result2=oci_execute($stmt2);
		oci_execute($OUTPUT_CUR2);
		$totpuntos=0;
		while($row2=oci_fetch_assoc($OUTPUT_CUR2)){
$aux=$body[$i];
$aux[count($body[$i])]=$row2['CANTIDAD'];
$body[$i]=$aux;
$i++;
$totpuntos+=intval($row2['PESO'])*intval($row2['CANTIDAD']);
		}
$aux=$body[$i];
$aux[count($body[$i])]=$totpuntos;
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['METLIN'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['ANCTOT'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['ANCUTI'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['INCSTD'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['INCDER'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['INCIZQ'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['INCMED'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['RAPPORT'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['PUNTOS'];
$body[$i]=$aux;
$i++;
$aux=$body[$i];
$aux[count($body[$i])]=$row['CALIFICACION'];
$body[$i]=$aux;
$i++;
	}

$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$first_col_width=40;
if (count($body[0])>1) {
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/(count($body[0])-1);
	for ($i=0; $i < 1; $i++) { 
			$ar_text=str_split($body[$i][0],22);
		for ($j=0; $j < count($body[$i]); $j++) { 
			if ($j==0) {
$pdf->Cell($first_col_width,6,$body[$i][$j],1,0,'L',true);
			}else{
$pdf->Cell($width_by_cell,6,$body[$i][$j],1,0,'L',true);				
			}
		}
$pdf->Ln();
	}
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
	for ($i=1; $i < count($body); $i++) { 
		$ar_text=str_split($body[$i][0],22);
		for ($j=0; $j < count($body[$i]); $j++) { 
			if ($j==0) {
//$pdf->Cell($first_col_width,6,$body[$i][$j],1,0,'L',true);
$x=$pdf->GetX();
$pdf->myCell2($first_col_width,6*(1+count($ar_text))/2,$x,$body[$i][$j]);
			}else{
$pdf->Cell($width_by_cell,6*(1+count($ar_text))/2,$body[$i][$j],1,0,'L',true);
			}
		}
$pdf->Ln();
	}
}
$pdf->Ln();
$pdf->SetFont('Arial','',10);

if ($_GET['respon4']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Responsable: ".$_GET['respon4'],0,0,'L');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"Encargado: ".$_GET['encar4'],0,0,'L');
$pdf->Ln();
}
if ($_GET['aud4']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Auditor: ".$_GET['aud4'],0,0,'L');
$pdf->Ln();
}
if ($_GET['coo4']!="") {
$pdf->Cell($pdf->get_max_width_to_white(),6,"Coordinador: ".$_GET['coo4'],0,0,'L');
$pdf->Ln();
}

$pdf->Output('D','Auditoria tela - '.$_GET['partida'].'.pdf',true);
//$pdf->Output('','',true);

oci_close($conn);
?>