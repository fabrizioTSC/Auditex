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
		table{
			margin: auto;
			max-width: 700px;
			width: 100%;
		}
		th,td{
			padding: 5px;
		}
		th:nth-child(2),td:nth-child(2){
			text-align: center;
		}
		th:nth-child(2),td:nth-child(2),
		th:nth-child(3),td:nth-child(3){
			width: 100px!important;
		}
		td p{
			border:1px solid #333;
			border-radius: 5px;
			padding: 5px;
			width: calc(100% - 12px);
			margin: 0;
		}
		td input{
			width: calc(100% - 12px)!important;
			padding: 5px!important;
		}
		tr{
			background: #fff;
		}
		tr:nth-child(1){
			color: #fff;
			background: #922B21;
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
			<div class="headerTitle">Registro ancho de Tela - Testing</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div id="idDetalle" style="display: block;">
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Partida: <span><?php echo $_GET['p']; ?></span></div>
					<div class="lbl" style="width: 50%;">Cliente: <span id="idCliente"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Proveedor: <span id="idProveedor"></span></div>
					<div class="lbl" style="width: 50%;">Cod. Tela: <span><?php echo $_GET['codtel']; ?></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Cod. Color: <span id="idCodCol"></span></div>
					<div class="lbl" style="width: 50%;">Color: <span id="idColor"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Art&iacute;culo: <span id="idArticulo"></span></div>
					<div class="lbl" style="width: 50%;">Programa: <span id="idPrograma"></span></div>
				</div>
				<!--
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Composici&oacute;n: <span id="idComposicion"></span></div>
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">X-Factory: <span id="idXFactory"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Destino: <span id="idDestino"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Rend. por peso: <span id="idRendimiento"></span></div>
					<div class="lbl" style="width: 50%;">Peso programado: <span id="idPesoPrg"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Auditor: <span id="idAuditor"></span></div>
					<div class="lbl" style="width: 50%;">Coordinador: <span id="idSupervisor"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Fec. Inicio: <span id="idfecini"></span></div>
					<div class="lbl" style="width: 50%;">Fec. Fin: <span id="idfecfin"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Ruta Tela: <span id="idruttel"></span></div>
				</div>-->
			</div>
			<div class="btn-addrollo" onclick="animar_detalle()"><span id="btnContent">Ocultar detalle</span></div>
			<div class="lineDecoration"></div>
			<div class="forms-content">
				<div class="table-form" style="margin: 5px 0px;">
					<table id="table-body">
						<tr>
							<th></th>
							<th>TSC</th>
							<th>TESTING</th>
						</tr>
					</table>
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="save()" id="btn-1">Guardar</button>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="window.history.back();">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var perfil_usu="<?php echo $_SESSION['perfil']; ?>";
		var codusu_v="<?php echo $_SESSION['user']; ?>";
		var partida="<?php echo $_GET['p'] ?>";
		var codtel="<?php echo $_GET['codtel'] ?>";
		var codprv="<?php echo $_GET['codprv'] ?>";
		var codtad="<?php echo $_GET['codtad'] ?>";
		var parte="<?php echo $_GET['parte'] ?>";
		var numvez="<?php echo $_GET['numvez'] ?>";
		$(document).ready(function(){
			$.ajax({
				type:'POST',
				url:'config/startRegistroTesting.php',
				data:{
					partida:partida,
					codtel:codtel,
					codprv:codprv,
					codtad:codtad,
					parte:parte,
					numvez:numvez
				},
				success:function(data){
					console.log(data);
					$("#idCliente").text(data.partida.DESCLI);
					$("#idProveedor").text(data.partida.DESPRV);
					$("#idArticulo").text(data.partida.DESTEL);
					$("#idCodCol").text(data.partida.CODCOL);
					$("#idColor").text(data.partida.DSCCOL);
					$("#idPrograma").text(data.partida.PROGRAMA);
					let html='';
					for (var i = 0; i < data.estdim.length; i++) {
						html+=
						'<tr>'+
							'<td><b>'+data.estdim[i].DESESTDIM+'</b></td>'+
							'<td><p>'+data.estdim[i].VALORTSC+'</p></td>'+
							'<td><input type="number" class="class-save" id="val-'+data.estdim[i].CODESTDIM+'" value="'+data.estdim[i].TESTING+'"></td>'+
						'</tr>';						
					}
					$("#table-body").append(html);

					/*
					$("#idComposicion").text(data.partida.COMPOS);
					$("#idXFactory").text(data.partida.XFACTORY);
					$("#idDestino").text(data.partida.DESTINO);
					$("#idPesVal").val(data.partida.PESO);
					$("#idPesoPrg").text(data.partida.PESOPRG);
					$("#idRendimiento").text(data.partida.RENDIMIENTO+" (metros: "+data.partida.RENMET+")");
					$("#idAuditor").text(data.partida.CODUSU);
					$("#idSupervisor").text(data.partida.CODUSUEJE);
					$("#idfecini").text(data.partida.FECINIAUD);
					$("#idfecfin").text(data.partida.FECFINAUD);
					$("#idruttel").text(data.partida.RUTA);*/
					$(".panelCarga").fadeOut(200);
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
			        $(".panelCarga").fadeOut(200);
			    }
			});
		});
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
		function save(){
			let ar=document.getElementsByClassName("class-save");
			let validate=false;
			let ar_aux=[];
			for (var i = 0; i < ar.length; i++) {
				let aux=[];
				aux.push((ar[i].id).replace("val-",""));
				aux.push(ar[i].value);
				ar_aux.push(aux);
				if(ar[i].value=="" || ar[i].value=="0"){
					validate=true;
				}
			}
			if (validate) {
				var c=confirm("Hay valores de testing vacios. Desea contiuar?");
				if (!c) {
					return;
				}
			}
			//console.log("Envio");
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveRegistroTesting.php',
				data:{
					partida:partida,
					codtel:codtel,
					codprv:codprv,
					parte:parte,
					numvez:numvez,
					array:ar_aux
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
	</script>
</body>
</html>