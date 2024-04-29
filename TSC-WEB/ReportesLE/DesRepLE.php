<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="1";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");

	require "../../TSC/models/modelo/core.modelo.php";
    $objModelo = new CoreModelo("bd_genesys","sige_auditex");
	$nropacking = 0;

?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
	<link rel="stylesheet" type="text/css" href="css/opciones.css">
	<link rel="stylesheet" type="text/css" href="../../dashboard/Admin/css/estilo_menu.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		input[type="number"]{
			width: calc(100% - 12px); 
		}
		.itemBodyLink{
			text-decoration: underline;
			color: #1d1dd4;
			cursor: pointer;
		}
		.tblBody div{
			border-top: 1px solid #666;
		}
		.item1,.item2{
			width: calc(25% - 10px);
		}
		.item3{
			width: calc(100%/3);
		}
		h3,h4{
			margin: 5px 0;
		}
		.itemMainContent{
			height: auto;
			display: flex;
		}
		.bodySpecialButton{
			height: auto;
		}
		.mainBodyContent{
			margin-bottom: 70px;
		}
		@media(max-width: 650px){
			.item1{
				width: calc(100% - 240px);
			}
			.item2{
				width: 70px;
			}
		}
		h4{
			margin-top: 0;
		}
		.part-disabled{
			cursor: none;
			pointer-events: none;
			color: #bbb;
			background: #eee;
		}
		.content-logos{
			margin: 20px 50px;
			display: flex;
			justify-content: space-between;
			align-content: center;
		}
		.n2-container {
		    width: 100%;
		}
		.n2-container .n2-menu {
			justify-content: center;
		}
		.n2-container .n2-menu .n2-item {
		    width: 200px;
		}
		.n2-container .n2-menu .n2-item .img-item-2 {
		    width: 25%;
		}
		.n2-container .n2-menu .n2-item .img-item-2 img{
		    width: 100%;
		}
		@media(max-width: 700px){
			.content-logos{
				margin: 15px 20px;
			}
		}
	</style>
</head>
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="content-logos">
			<img src="assets/img/le-logo-20210520.png" style="max-width: 350px;margin-right: 10px;width: 40%;">
			<img src="assets/img/tsc-logo-20210520.png" style="max-width: 400px;width: 50%;">
		</div>
		<div class="headerContent" style="position: relative;">
			<div class="headerTitle">CERTIFIED AUDITOR DATASHEET</div>
		</div>
		<div class="bodyContent">

			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 80px;margin-top: 10px;">Enter PO:</div>
				<div class="spaceIpt" style="width: calc(120px);font-size: 15px">
					<input type="text" id="po" class="classIpt" style="width: calc(100% - 17px);" value="<?= isset($_GET['po']) ?  $_GET['po'] : ""; ?>">
				</div>
				<button class="btnPrimary" onclick="buscar_pedido()" style="margin-left: 5px;width: auto;"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>

			<?php
				// include('config/connection.php');
				$count=0;

				if (isset($_GET['po'])) {

					$po = $_GET['po'];

					// BUSCAMOS QUE EXISTA EN SIGE
					$responsesige = [];
					$responsesige = $objModelo->getSQLSIGE("AuditoriaFinal.uspSetAudiFinal",[75,null,null,$po]);

					if($responsesige){
						// var_dump($responsesige);
						$nropacking = $responsesige->{"NroPacking"};
						$count = "1";


					}else{

						$responsesige2 = $objModelo->get("AUDITEX.SP_RLE_SELECT_POPL",[$po]);
						if($responsesige2){
							$nropacking = $responsesige2["NROPACKING"];
							$count = "1";
						}

					}





					// $sql="BEGIN SP_RLE_SELECT_POPL(:PO,:OUTPUT_CUR); END;";

					// $stmt=oci_parse($conn, $sql);
					// oci_bind_by_name($stmt, ':PO', $_GET['po']);
					// $OUTPUT_CUR=oci_new_cursor($conn);
					// oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					// $result=oci_execute($stmt);
					// oci_execute($OUTPUT_CUR);
					// $row=oci_fetch_assoc($OUTPUT_CUR);
					// $count=oci_num_rows($OUTPUT_CUR);

				}
			?>

			<?php if (isset($_GET['po'])): ?>

				<?php if ($count!="1"): ?>
					<div style="margin-top: 5px;color: #fdf504;"><label>Reports not found for this PO</label></div>
				<?php else: ?>
						<div style="display:none;margin-top: 5px;color: #fdf504;" id="msg"><label>Reports not found for this PO</label></div>
						<div class="n2-container">
							<div class="n2-menu" id="cont-n2" style="margin: 80px 0;">

								<div class="n2-item" data-codn2="1" onclick="defectos()" id="contenido-bloque-1" style="display: none;">
									<div class="img-item-2">
										<img src="../../dashboard/Admin/img/icon-n2.png" alt="" srcset="">
									</div>
									<div class="desc-item-2">QUALITY</div>
								</div>

								<div class="n2-item" data-codn2="2" onclick="medidas()" id="contenido-bloque-2" style="display: none;">
									<div class="img-item-2">
										<img src="../../dashboard/Admin/img/icon-n2.png" alt="" srcset="">
									</div>
									<div class="desc-item-2">MEASURE</div>
								</div>

								<div class="n2-item" data-codn2="3" onclick="fotos('2')" id="contenido-bloque-4" style="display: none;">
									<div class="img-item-2">
										<img src="../../dashboard/Admin/img/icon-n2.png" alt="" srcset="">
									</div>
									<div class="desc-item-2">IMAGES OF WET</div>
								</div>

								<div class="n2-item" data-codn2="29" onclick="fotos('1')" id="contenido-bloque-3" style="display: none;">
									<div class="img-item-2">
										<img src="../../dashboard/Admin/img/icon-n2.png" alt="" srcset="">
									</div>
									<div class="desc-item-2">IMAGES OF DEFECTS</div>
								</div>

								<div class="n2-item" data-codn2="4" onclick="detmet()" id="contenido-bloque-5" style="display: none;">
									<div class="img-item-2">
										<img src="../../dashboard/Admin/img/icon-n2.png" alt="" srcset="">
									</div>
									<div class="desc-item-2">METAL CERTIFICATE</div>
								</div>

							</div>
						</div>
				<?php endif; ?>

			<?php endif; ?>




			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="window.history.back();">Return</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="text/javascript">

		var paclis_v	=	'';
		var rutpdf		=	'';
		let sistema 	= 	'sistextil';


		<?php if ($count =="1"): ?>
			$(document).ready(function(){
				paclis_v = "<?= $nropacking ?>";
				val_defectos();
			});
		<?php endif; ?>


		var partidas_ar;
		function buscar_pedido(){
			if($("#po").val()==""){
				alert("Escriba la PO");
				return;
			}
			window.location.href="DesRepLE.php?po="+$("#po").val();
		}
		function show_detail(paclis){
			//window.location.href="IniciarAudFin.php?pedido="+pedido+"&dsccol="+dsccol;
			document.getElementById("div-estcli").style.display="block";
			document.getElementById("paclis").innerHTML=paclis;
			paclis_v=paclis;
						document.getElementById("contenido-bloque-1").style.display="none";
						document.getElementById("contenido-bloque-2").style.display="none";
						document.getElementById("contenido-bloque-3").style.display="none";
						document.getElementById("contenido-bloque-4").style.display="none";
		}
		
		function defectos(){
			var a=document.createElement("a");
			a.target="_blank";

			if(sistema == "sige"){
				a.href = `http://textilweb.tsc.com.pe:8094/ReportesPDF/ImpresionReporteLandsEndAuditoriaFinal?po=${$("#po").val()}&num_packing=${paclis_v}`;

			}else{
				a.href="fpdf/pdfReporteDefectos.php?po="+$("#po").val()+"&paclis="+paclis_v;
			}
			a.click();



		}

		async function medidas(){

			var a=document.createElement("a");
			a.target="_blank";
			if(sistema == "sige"){

				$.ajax({
					type:"GET",
					url:"/tsc/controllers/landsend/landsend.controller.php",
					data:{
						operacion:'getestilosclientepopacking',
						po:$("#po").val(),
						paclis:paclis_v
					},
					success: async function(data){
						// console.log(data);
						await getEstiloMedida(data);

					}
				});
			
				// a.href = `http://textilweb.tsc.com.pe:8094/ReportesPDF/ImpresionReporteLandsEndAuditoriaFinalMedidas?po=${$("#po").val()}&num_packing=${paclis_v}`;
				

			}else{
				a.href="../pdf-ReportesLE/"+rutpdf;
				a.click();
				
			}
			
		}

		function fotos(id){
			var a=document.createElement("a");
			a.target="_blank";

			if(sistema == "sige"){
				let filtro = id == "2" ? "Humedad" : "Calidad Interna";
				a.href = `http://textilweb.tsc.com.pe:8094/ReportesPDF/ImpresionReporteLandsEndAuditoriaFinalHumedadCalidad?po=${$("#po").val()}&num_packing=${paclis_v}&filtro=${filtro}`;
			}else{
				a.href="fpdf/pdfReporteFotos.php?po="+$("#po").val()+"&paclis="+paclis_v+"&tipo="+id;
			}

			a.click();
		}

		var id_detmet='';
		function detmet(){
			var a=document.createElement("a");
			a.target="_blank";

			if(sistema == "sige"){
				a.href = `http://textilweb.tsc.com.pe:8094/ReportesPDF/ImpresionReporteLandsEndRegistroMetales?po=${$("#po").val()}`;
			}else{
				// a.href="fpdf/pdfReporteFotos.php?po="+$("#po").val()+"&paclis="+paclis_v+"&tipo="+id;
				a.href="http://textilweb.tsc.com.pe:81/TSC/landsend/views/registrometales/imprimirpdf.php?id="+id_detmet;
			}

			// a.href="http://textilweb.tsc.com.pe:81/TSC/landsend/views/registrometales/imprimirpdf.php?id="+id_detmet;
			a.click();
		}

		async function getEstiloMedida(data){

			let datanew = {};
			for(let item of data){
				datanew[item.EstiloCli] = item.EstiloCli;
				// datanew.push(item.EstiloCli);
			}

			await Swal.fire({
				title: 'Select Style',
				input: 'select',
				inputOptions: datanew,
				inputPlaceholder: 'Select a Style',
				showCancelButton: true,
				inputValidator: (value) => {
					// a.href = `http://textilweb.tsc.com.pe:8094/ReportesPDF/ImpresionReporteLandsEndAuditoriaFinalMedidas?po=${$("#po").val()}&num_packing=${paclis_v}`;
					window.open(`http://textilweb.tsc.com.pe:8094/ReportesPDF/ImpresionReporteLandsEndAuditoriaFinalMedidas?po=${$("#po").val()}&num_packing=${paclis_v}&estilocli=${value}`,'_blank');
						// console.log(value,value);
					// return new Promise((resolve) => {
					// if (value === 'oranges') {
					// 	resolve()
					// } else {
					// 	resolve('You need to select style')
					// }
					// })
				}
				})

				// if (fruit) {
				// Swal.fire(`You selected: ${fruit}`)
				// }

		}

		// ##############
		// ### AJAXXX ###
		// ##############

		// DEFECTOS
		function val_defectos(){
			$(".panelCarga").fadeIn(100);

			$.ajax({
				type:"GET",
				url:"/tsc/controllers/landsend/landsend.controller.php",
				data:{
					operacion:'getdatosreportelandsend-cantidad',
					po:$("#po").val(),
					paclis:paclis_v
				},
				success:function(data){
					console.log(data);
					sistema = data.sistema;
					if (!data.state) {
						alert(data.detail);
					}else{
						if (data.estado=="C") {
							document.getElementById("contenido-bloque-1").style.display="flex";
							val_medidas();
						}else{
							document.getElementById("msg").style.display="block";
							$(".panelCarga").fadeOut(100);
							document.getElementById("contenido-bloque-1").style.display="none";
							document.getElementById("contenido-bloque-2").style.display="none";
							document.getElementById("contenido-bloque-3").style.display="none";
							document.getElementById("contenido-bloque-4").style.display="none";
							document.getElementById("contenido-bloque-5").style.display="none";
						}
					}
				}
			});
		}

		// MEDIDAS
		function val_medidas(){
			$.ajax({
				type:"GET",
				url:"/tsc/controllers/landsend/landsend.controller.php",
				data:{
					operacion:'getdatosreportelandsend-medidas',
					po:$("#po").val(),
					paclis:paclis_v,
					sistema
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						if (data.RUTPDF!="") {
							rutpdf=data.RUTPDF;
							document.getElementById("contenido-bloque-2").style.display="flex";
							val_fotos();
						}else{
							document.getElementById("msg").style.display="block";
							$(".panelCarga").fadeOut(100);
							document.getElementById("contenido-bloque-1").style.display="none";
							document.getElementById("contenido-bloque-2").style.display="none";
							document.getElementById("contenido-bloque-3").style.display="none";
							document.getElementById("contenido-bloque-4").style.display="none";
							document.getElementById("contenido-bloque-5").style.display="none";
						}
					}
				}
			});
		}

		// CALIDAD Y HUMEDAD
		function val_fotos(){
			$.ajax({
				type:"GET",
				url:"/tsc/controllers/landsend/landsend.controller.php",
				data:{
					operacion:'getdatosreportelandsend-defectos-humedad',
					po:$("#po").val(),
					paclis:paclis_v,
					sistema
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						if (data.estado=="C") {
							if (data.estadohum=="C") {
								document.getElementById("contenido-bloque-3").style.display="flex";
								document.getElementById("contenido-bloque-4").style.display="flex";
								val_det_met();
							}else{
								document.getElementById("msg").style.display="block";
								$(".panelCarga").fadeOut(100);
								document.getElementById("contenido-bloque-1").style.display="none";
								document.getElementById("contenido-bloque-2").style.display="none";
								document.getElementById("contenido-bloque-3").style.display="none";
								document.getElementById("contenido-bloque-4").style.display="none";
								document.getElementById("contenido-bloque-5").style.display="none";
							}
						}else{
							document.getElementById("msg").style.display="block";
							$(".panelCarga").fadeOut(100);
							document.getElementById("contenido-bloque-1").style.display="none";
							document.getElementById("contenido-bloque-2").style.display="none";
							document.getElementById("contenido-bloque-3").style.display="none";
							document.getElementById("contenido-bloque-4").style.display="none";
							document.getElementById("contenido-bloque-5").style.display="none";
						}
					}
				}
			});
		}

		// CERTIFICADO DE METALES
		function val_det_met(){
			$.ajax({
				type:"GET",
				url:"/tsc/controllers/landsend/landsend.controller.php",
				data:{
					operacion:'getdatosreportelandsend-metal',
					po:$("#po").val(),
					paclis:paclis_v,
					sistema
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						if (data.ID!="") {
							id_detmet=data.ID;
							document.getElementById("contenido-bloque-5").style.display="flex";
						}else{
							document.getElementById("msg").style.display="block";

							document.getElementById("contenido-bloque-1").style.display="none";
							document.getElementById("contenido-bloque-2").style.display="none";
							document.getElementById("contenido-bloque-3").style.display="none";
							document.getElementById("contenido-bloque-4").style.display="none";
							document.getElementById("contenido-bloque-5").style.display="none";
						}
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}

		// // DEFECTOS
		// function val_defectos(){
		// 	$(".panelCarga").fadeIn(100);

		// 	$.ajax({
		// 		type:"POST",
		// 		url:"config/valEstRepCalInt.php",
		// 		data:{
		// 			po:$("#po").val(),
		// 			paclis:paclis_v
		// 		},
		// 		success:function(data){
		// 			// console.log(data);
		// 			if (!data.state) {
		// 				alert(data.detail);
		// 			}else{
		// 				if (data.estado=="C") {
		// 					document.getElementById("contenido-bloque-1").style.display="flex";
		// 					val_medidas();
		// 				}else{
		// 					document.getElementById("msg").style.display="block";
		// 					$(".panelCarga").fadeOut(100);
		// 					document.getElementById("contenido-bloque-1").style.display="none";
		// 					document.getElementById("contenido-bloque-2").style.display="none";
		// 					document.getElementById("contenido-bloque-3").style.display="none";
		// 					document.getElementById("contenido-bloque-4").style.display="none";
		// 					document.getElementById("contenido-bloque-5").style.display="none";
		// 				}
		// 			}
		// 		}
		// 	});
		// }

		// // MEDIDAS
		// function val_medidas(){
		// 	$.ajax({
		// 		type:"POST",
		// 		url:"config/startGenRepMed.php",
		// 		data:{
		// 			po:$("#po").val(),
		// 			paclis:paclis_v
		// 		},
		// 		success:function(data){
		// 			console.log(data);
		// 			if (!data.state) {
		// 				alert(data.detail);
		// 			}else{
		// 				if (data.RUTPDF!="") {
		// 					rutpdf=data.RUTPDF;
		// 					document.getElementById("contenido-bloque-2").style.display="flex";
		// 					val_fotos();
		// 				}else{
		// 					document.getElementById("msg").style.display="block";
		// 					$(".panelCarga").fadeOut(100);
		// 					document.getElementById("contenido-bloque-1").style.display="none";
		// 					document.getElementById("contenido-bloque-2").style.display="none";
		// 					document.getElementById("contenido-bloque-3").style.display="none";
		// 					document.getElementById("contenido-bloque-4").style.display="none";
		// 					document.getElementById("contenido-bloque-5").style.display="none";
		// 				}
		// 			}
		// 		}
		// 	});
		// }

		// // CALIDAD Y HUMEDAD
		// function val_fotos(){
		// 	$.ajax({
		// 		type:"POST",
		// 		url:"config/valEstRepDef.php",
		// 		data:{
		// 			po:$("#po").val(),
		// 			paclis:paclis_v
		// 		},
		// 		success:function(data){
		// 			console.log(data);
		// 			if (!data.state) {
		// 				alert(data.detail);
		// 			}else{
		// 				if (data.estado=="C") {
		// 					if (data.estadohum=="C") {
		// 						document.getElementById("contenido-bloque-3").style.display="flex";
		// 						document.getElementById("contenido-bloque-4").style.display="flex";
		// 						val_det_met();
		// 					}else{
		// 						document.getElementById("msg").style.display="block";
		// 						$(".panelCarga").fadeOut(100);
		// 						document.getElementById("contenido-bloque-1").style.display="none";
		// 						document.getElementById("contenido-bloque-2").style.display="none";
		// 						document.getElementById("contenido-bloque-3").style.display="none";
		// 						document.getElementById("contenido-bloque-4").style.display="none";
		// 						document.getElementById("contenido-bloque-5").style.display="none";
		// 					}
		// 				}else{
		// 					document.getElementById("msg").style.display="block";
		// 					$(".panelCarga").fadeOut(100);
		// 					document.getElementById("contenido-bloque-1").style.display="none";
		// 					document.getElementById("contenido-bloque-2").style.display="none";
		// 					document.getElementById("contenido-bloque-3").style.display="none";
		// 					document.getElementById("contenido-bloque-4").style.display="none";
		// 					document.getElementById("contenido-bloque-5").style.display="none";
		// 				}
		// 			}
		// 		}
		// 	});
		// }

		// // CERTIFICADO DE METALES
		// function val_det_met(){
		// 	$.ajax({
		// 		type:"POST",
		// 		url:"config/valEstDetMet.php",
		// 		data:{
		// 			po:$("#po").val(),
		// 			paclis:paclis_v
		// 		},
		// 		success:function(data){
		// 			console.log(data);
		// 			if (!data.state) {
		// 				alert(data.detail);
		// 			}else{
		// 				if (data.ID!="") {
		// 					id_detmet=data.ID;
		// 					document.getElementById("contenido-bloque-5").style.display="flex";
		// 				}else{
		// 					document.getElementById("msg").style.display="block";

		// 					document.getElementById("contenido-bloque-1").style.display="none";
		// 					document.getElementById("contenido-bloque-2").style.display="none";
		// 					document.getElementById("contenido-bloque-3").style.display="none";
		// 					document.getElementById("contenido-bloque-4").style.display="none";
		// 					document.getElementById("contenido-bloque-5").style.display="none";
		// 				}
		// 			}
		// 			$(".panelCarga").fadeOut(100);
		// 		}
		// 	});
		// }


	</script>
</body>
</html>