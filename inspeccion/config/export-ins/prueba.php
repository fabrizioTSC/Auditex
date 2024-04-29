<?php 

header("Pragma: public");
header("Expires: 0");
$filename = "Prueba.pdf";
header('Content-Type: application/pdf');
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
/*
require("../../fpdf/fpdf.php");
$pdf=new PDF_HTML();
 
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
 
$pdf->AddPage();
$pdf->Image('logo.png',18,13,33);
$pdf->SetFont('Arial','B',14);
$pdf->WriteHTML('How to Convert HTML to PDF with fpdf example');
 
$pdf->SetFont('Arial','B',7); 
$htmlTable=
'';
$pdf->WriteHTML2("<br>$htmlTable");
$pdf->SetFont('Arial','B',6);
$pdf->Output(); */
?>
<script src="../../charts-dist/Chart.min.js"></script>
<canvas id="chart-area"></canvas>
<script type="text/javascript">
	window.chartColors = {
		red: 'rgb(255, 99, 132)',
		orange: 'rgb(255, 159, 64)',
		yellow: 'rgb(255, 205, 86)',
		green: 'rgb(80, 200, 2)',
		blue: 'rgb(54, 162, 235)',
		purple: 'rgb(153, 102, 255)',
		grey: 'rgb(201, 203, 207)'
	};
	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: [10,20],
				backgroundColor: [
					window.chartColors.red,
					window.chartColors.green
				],
				label: 'Total prendas'
			}],
			labels: [
				'Tot. pren. defectuosas - '+10+'%',
				'Tot. pren. sin defecto - '+20+'%'
			]
		},
		options: {
			responsive: true,
			legend: {
				position: 'top',
			},
			title: {
				display: true,
				text: 'PORCENTAJE DE PRENDAS DEFECTUOSAS'
			},
			animation: {
				animateScale: true,
				animateRotate: true
			}
		}
	};
	var ctx = document.getElementById('chart-area').getContext('2d');
	window.myPie = new Chart(ctx, config);
</script>