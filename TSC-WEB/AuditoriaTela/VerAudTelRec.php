<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="1";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/AuditoriaTela.css">
	<style type="text/css">
		@media(max-width: 500px){
			#idTabApa{
				overflow-x: scroll;
			}
			#idTabApaHed,#form2{
				min-width: 500px;
			}
		}
		@media(max-width: 730px){
			#headertbl3,#form3{
				min-width: 770px;
			}
		}
		table,td{
			border-collapse: collapse;
		}
		table{
			width: 100%;
			min-width: 700px;
			font-size: 13px;
		}
		thead td{
			background: #980f0f;
			color: #fff;
		}
		tbody td,thead td{
			border: 1px #333 solid;
			padding: 5px;
		}
		td{
			background: #fff;
		}
		td input{
			width: calc(100% - 10px);
			text-align: center;
			padding: 3px;
		}
		input[type="number"], input[type="text"]{
			width: calc(100% - 2px);
			border-radius: 0;
		}
		.cell-input{
			padding: 0px;
		}
		tr td:nth-child(1),
		tr td:nth-child(2),
		tr td:nth-child(3),
		tr td:nth-child(4),
		tr td:nth-child(5),
		tr td:nth-child(6){
			width: 50px;
			text-align: center;
			font-size: 12px;
		}
		tbody tr td:nth-child(1),
		tbody tr td:nth-child(2),
		tbody tr td:nth-child(3),
		tbody tr td:nth-child(4),
		tbody tr td:nth-child(5),
		tbody tr td:nth-child(6){
			background: #ddd;
		}
	</style>
</head>
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent" id="mainToScroll">
		<div class="headerContent">
			<div class="headerTitle">Consultar Auditoria de Tela Rectilineo</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div id="idDetalle" style="display: block;">
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Partida: <span id="idPartida"><?php echo $_GET['partida']; ?></span></div>
					<div class="lbl" style="width: 50%;">Cliente: <span id="idCliente"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Proveedor: <span id="idProveedor"></span></div>
					<div class="lbl" style="width: 50%;">Cod. Tela: <span id="idCodtela"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Cod. Color: <span id="idCodCol"></span></div>
					<div class="lbl" style="width: 50%;">Color: <span id="idColor"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Art&iacute;culo: <span id="idArticulo"></span></div>
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Composici&oacute;n: <span id="idComposicion"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Programa: <span id="idPrograma"></span></div>
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">X-Factory: <span id="idXFactory"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Cant. programada: <span id="idCanPro"></span></div>
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;display: flex;">Peso (Kg):&nbsp;
						<div style="display: flex;">
							<input type="number" id="idPesVal" style="width: calc(80px);padding: 2px;">
							<!--
							<button class="btnPrimary" style="width: 30px;padding: 0px;" onclick="save_peso()"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>-->
						</div>
					</div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Peso programado: <span id="idPesoPrg"></span></div>
					<div class="lbl" style="width: 50%;">Auditor: <span id="idAuditor"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Fec. Inicio: <span id="idfecini"></span></div>
					<div class="lbl" style="width: 50%;">Fec. Fin: <span id="idfecfin"></span></div>
				</div>
			</div>
			<div class="btn-addrollo" onclick="animar_detalle()"><span id="btnContent">Ocultar detalle</span></div>
			<div class="lineDecoration"></div>
			<div class="forms-content" style="width: 100%; overflow-x: scroll;">
				<table>
					<thead>						
						<tr>
							<td>Talla</td>
							<td>Unid. Pro.</td>
							<td>Largo</td>
							<td>Tol.</td>
							<td>Alto</td>
							<td>Tol.</td>
							<td>Largo Obte.</td>
							<td>Alto Obte.</td>
							<td>Unid. real</td>
							<td>Unid. 2das</td>
							<td>% 2das</td>
							<td>Observaciones</td>
						</tr>
					</thead>
					<tbody id="tbl-body">
						<!--
						<tr>
							<td class="clase-talla" data-codtal="014">XS</td>
							<td>XS</td>
							<td>XS</td>
							<td>XS</td>
							<td>XS</td>
							<td>XS</td>
							<td class="cell-input">
								<input class="ipt-tal" id="largo-014" data-codtal="014" type="text" value="0">
							</td>
							<td class="cell-input">
								<input class="ipt-tal" id="alto-014" data-codtal="015" type="text" value="0">
							</td>
							<td class="cell-input">
								<input class="ipt-tal" id="unirea-014" data-codtal="016" type="text" value="0">
							</td>
							<td class="cell-input">
								<input class="ipt-tal" id="uniseg-014"  data-codtal="017" type="text" value="0">
							</td>
							<td><center><span id="por-014">0</span>%</center></td>
							<td class="cell-input">
								<input class="ipt-tal" id="largo-014" data-codtal="018" type="text" value="0">
							</td>
						</tr>-->
					</tbody>
				</table>
			</div>
			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="redirect('IniciarAuditoriaTela.php')">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" id="add-script">
	</script>
	<script type="text/javascript">
		var perfil_usu="<?php echo $_SESSION['perfil']; ?>";
		var codusu="<?php echo $_SESSION['user']; ?>";
		var partida="<?php echo $_GET['partida']; ?>";
		var codprv="<?php echo $_GET['codprv']; ?>";
		var codtel="<?php echo $_GET['codtel']; ?>";
		var codtad="<?php echo $_GET['codtad']; ?>";
		var parte="<?php echo $_GET['parte']; ?>";
		var numvez="<?php echo $_GET['numvez']; ?>";
		$(document).ready(function(){			
			$.ajax({
				type:'POST',
				url:'config/startAudTelRec.php',
				data:{
					partida:partida,
					codprv:codprv,
					codtel:codtel,
					codtad:codtad,
					parte:parte,
					numvez:numvez
				},
				success:function(data){
					console.log(data);

					$("#idCliente").text(data.partida.DESCLI);
					$("#idProveedor").text(data.partida.DESPRV);
					$("#idCodtela").text(codtel);
					$("#idArticulo").text(data.partida.DESTEL);
					$("#idCodCol").text(data.partida.CODCOL);
					$("#idColor").text(data.partida.DESCOL);
					$("#idComposicion").text(data.partida.COMPOS);
					$("#idPrograma").text(data.partida.PROGRAMA);
					$("#idXFactory").text(data.partida.XFACTORY);
					$("#idPesVal").val(data.partida.PESO);
					$("#idCanPro").text(data.partida.CANPRG);
					$("#idPesoPrg").text(data.partida.PESOPRG);
					$("#idAuditor").text(data.partida.CODUSU);
					$("#idfecini").text(data.partida.FECINIAUD);
					$("#idfecfin").text(data.partida.FECFINAUD);

					let html='';
					for (var i = 0; i < data.detalle.length; i++) {
					html+=
						'<tr>'+
							'<td class="clase-talla" data-codtal="'+data.detalle[i].CODTAL+'">'+data.detalle[i].DESTAL+'</td>'+
							'<td>'+data.detalle[i].CANPRGTAL+'</td>'+
							'<td>'+data.detalle[i].LARGO+'</td>'+
							'<td>'+data.detalle[i].TOLLARGO+'</td>'+
							'<td>'+data.detalle[i].ALTO+'</td>'+
							'<td>'+data.detalle[i].TOLALTO+'</td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" id="largo-'+data.detalle[i].CODTAL+'" data-codtal="'+data.detalle[i].CODTAL+'" type="text" value="0">'+
							'</td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" id="alto-'+data.detalle[i].CODTAL+'" data-codtal="'+data.detalle[i].CODTAL+'" type="text" value="0">'+
							'</td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" onblur="calc_percent(this);" id="unirea-'+data.detalle[i].CODTAL+'" data-codtal="'+data.detalle[i].CODTAL+'" type="text" value="0">'+
							'</td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" onblur="calc_percent(this);" id="uniseg-'+data.detalle[i].CODTAL+'"  data-codtal="'+data.detalle[i].CODTAL+'" type="text" value="0">'+
							'</td>'+
							'<td><center><span id="por-'+data.detalle[i].CODTAL+'">0</span>%</center></td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" id="obs-'+data.detalle[i].CODTAL+'" data-codtal="'+data.detalle[i].CODTAL+'" type="text">'+
							'</td>'+
						'</tr>';
					}
					$("#tbl-body").append(html);

					for (var i = 0; i < data.guardado.length; i++) {
						document.getElementById("largo-"+data.guardado[i].CODTAL).value=data.guardado[i].LARGO;
						document.getElementById("alto-"+data.guardado[i].CODTAL).value=data.guardado[i].ALTO;
						document.getElementById("unirea-"+data.guardado[i].CODTAL).value=data.guardado[i].CANAUD;
						document.getElementById("uniseg-"+data.guardado[i].CODTAL).value=data.guardado[i].CANSEG;
						document.getElementById("obs-"+data.guardado[i].CODTAL).value=data.guardado[i].OBS;
						let den=parseInt(data.guardado[i].CANAUD);
						if (den!=0) {
							let num=parseInt(data.guardado[i].CANSEG);
							$("#por-"+data.guardado[i].CODTAL).text(Math.round(num*10000/den)/100);
						}
					}
					$(".panelCarga").fadeOut(100);
				},
			    error: function (jqXHR, exception) {
			        var msg = '';
			        if (jqXHR.status === 0) {
			            msg = 'Sin conexión.\nVerifique su conexión a internet!';
			        } else if (jqXHR.status == 404) {
			            msg = 'No se encuentra el archivo necesario para guardar la inspección!';
			        } else if (jqXHR.status == 500) {
			            msg = 'Servidor no disponible (Web de TSC). Intente más tarde';
			        } else if (exception === 'parsererror') {
			            msg = 'La respuesta tiene errores. Por favor, contactar al equipo de desarrollo!';
			        } else if (exception === 'timeout') {
			            msg = 'Tiempo de respuesta muy largo (Web de TSC)!';
			        } else if (exception === 'abort') {
			            msg = 'Se cancelo la consulta!';
			        } else {
			            msg = 'Error desconocido.\n' + jqXHR.responseText+'.\nInforme al equipo de desarrollo!';
			        }
			        alert(msg);
			        $(".panelCarga").fadeOut(100);
			    }
			});
		});
		function calc_percent(dom){
			let codtal=dom.dataset.codtal;
			let den=parseInt($("#unirea-"+codtal).val());
			if (den!=0) {
				let num=parseInt($("#uniseg-"+codtal).val());
				$("#por-"+codtal).text(Math.round(num*10000/den)/100);
			}
		}

		function save_auditoria(){
			let ar=document.getElementsByClassName("clase-talla");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				let codtal=ar[i].dataset.codtal;
				let aux=[];
				aux.push(codtal);
				aux.push(document.getElementById("largo-"+codtal).value);
				aux.push(document.getElementById("alto-"+codtal).value);
				aux.push(document.getElementById("unirea-"+codtal).value);
				aux.push(document.getElementById("uniseg-"+codtal).value);
				aux.push(document.getElementById("obs-"+codtal).value);
				ar_send.push(aux);
			}
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/saveAudTelRec.php',
				data:{
					partida:partida,
					codprv:codprv,
					codtel:codtel,
					codtad:codtad,
					numvez:numvez,
					parte:parte,
					codusu:codusu,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function end_auditoria(){
			let ar=document.getElementsByClassName("clase-talla");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				let codtal=ar[i].dataset.codtal;
				let aux=[];
				aux.push(codtal);
				aux.push(document.getElementById("largo-"+codtal).value);
				aux.push(document.getElementById("alto-"+codtal).value);
				aux.push(document.getElementById("unirea-"+codtal).value);
				aux.push(document.getElementById("uniseg-"+codtal).value);
				aux.push(document.getElementById("obs-"+codtal).value);
				ar_send.push(aux);
			}
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/finishAudTelRec.php',
				data:{
					partida:partida,
					codprv:codprv,
					codtel:codtel,
					codtad:codtad,
					numvez:numvez,
					parte:parte,
					codusu:codusu,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function save_peso(){
			if ($("#idPesVal").val()!="") {
				let peso=parseInt(parseFloat($("#idPesVal").val())*100);
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/updatePesoPAR.php',
					data:{
						partida:partida,
						codprv:codprv,
						codtel:codtel,
						codtad:codtad,
						numvez:numvez,
						parte:parte,
						peso:peso
					},
					success:function(data){
						console.log(data);
						if (!data.state) {
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(200);
					}
				});
			}else{
				alert("Ingrese un valor de peso!");
			}
		}
		function animar_detalle(){
			var display=$("#idDetalle").css("display");
			if (display=="block") {
				$("#idDetalle").fadeOut(100);
				$("#btnContent").text("Mostrar detalle");
				$("#idTabApa").css("max-height","calc(100vh - 233px)");
			}else{
				$("#idDetalle").fadeIn(100);
				$("#btnContent").text("Ocultar detalle");
				$("#idTabApa").css("max-height","calc(100vh - 506px)");
			}
		}
	</script>
</body>
</html>