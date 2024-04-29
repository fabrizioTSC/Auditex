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
	<style type="text/css">
		input[type="number"]{
			width: calc(100% - 12px); 
		}
		.itemBodyLink{
			text-decoration: underline;
			color: #1d1dd4;
			cursor: pointer;
		}
		.content-estudio{
		}
		.content-estudio input{
			margin: 0 5px;
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
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Proyecci&oacute;n de Caida por Estudio de Consumo</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 120px;">Buscar partida:</div>
				<div class="spaceIpt" style="width: calc(120px);font-size: 15px">
					<input type="text" id="idpartida" class="classIpt">
				</div>
			</div>
			<div style="color: #bf3b3b;margin-top: 5px;display: none;" id="msg-nopartidas">No existe partida!</div>
			<div class="mainContent" style="margin-top: 5px; display: block;" id="tablepartidas">
				<div class="tblContent" style="overflow-x: scroll;">
					<div class="tblHeader" style="width: auto;">
						<div class="itemHeader" style="width:100px;">PARTIDA</div>
						<div class="itemHeader" style="width:150px;">COD. TEL.</div>
						<div class="itemHeader" style="width:150px;">DES. PROVEEDOR</div>
						<div class="itemHeader" style="width:100px;">NUM. VEZ</div>
						<div class="itemHeader" style="width:100px;">FEC. SOL.</div>
						<div class="itemHeader" style="width:100px;">USU. SOL.</div>
					</div>
					<div class="tblBody" style="width: 760px;" id="table-body">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div id="result-estcon" style="display: none;">
				<div class="content-estudio">
					<div class="rowLine" style="display: flex;margin-bottom: 5px;">
						<label style="width: 120px;font-weight: bold;">Partida:</label>
						<span id="idParSel">asd</span>
					</div>
					<div class="rowLine" style="display: flex;margin-bottom: 5px;">
						<label style="width: 120px;font-weight: bold;">Cod. Tela:</label>
						<span id="idCodTelSel">asd</span>
					</div>
					<div class="rowLine" style="display: flex;margin-bottom: 5px;">
						<label style="width: 120px;font-weight: bold;">Proveedor:</label>
						<span id="idPrvSel">asd</span>
					</div>
					<div class="rowLine" style="display: flex;margin-bottom: 5px;">
						<label style="width: 120px;font-weight: bold;">Motivo:</label>
						<span id="idMotSel">asd</span>
					</div>
					<div class="rowLine" style="display: flex;margin-bottom: 5px;">
						<label style="width: 120px;font-weight: bold;">Est. Cliente:</label>
						<span id="idEstCliSel">asd</span>
					</div>
					<div style="display: flex;margin-bottom: 5px;">
						<label style="font-weight: bold;margin-top: 11px;width: 120px;">Proy. Ca&iacute;da:</label>
						<input type="number" id="idEstCon" style="width: 100px;padding: 7px;">
					</div>
					<div style="display: flex;margin-bottom: 5px;">
						<label style="font-weight: bold;margin-top: 11px;width: 120px;">Datacolor:</label>
						<input type="text" id="idDatCol" style="width: 100px;padding: 7px;">
					</div>
					<center>
						<button class="btnPrimary" style="width: auto;" onclick="guardar_estudio()">Guardar estudio</button>
					</center>
				</div>
				<center>
					<button class="btnPrimary" style="margin-top: 10px;" onclick="show_partida()">Ver partida</button>
				</center>
				<div class="lineDecoration"></div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="redirect('main.php')">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var partidas_ar;
		$(document).ready(function(){			
			$.ajax({
				type:'POST',
				url:'config/getPartidasPorEstCon.php',
				success:function(data){
					console.log(data);
					partidas_ar=data.partidas;
					var html='';
					if (data.state) {
						for (var i = 0; i < partidas_ar.length; i++) {
							html+=
								'<div style="display: flex;" onclick="show_detail(\''+partidas_ar[i].PARTIDA+'\',\''+partidas_ar[i].CODTEL+'\','+
								'\''+partidas_ar[i].CODPRV+'\',\''+partidas_ar[i].NUMVEZ+'\',\''+partidas_ar[i].PARTE+'\',\''+partidas_ar[i].CODTAD+'\',\''+partidas_ar[i].DESPRV+'\')">'+
									'<div class="itemBody itemBodyLink" style="width:100px;">'+partidas_ar[i].PARTIDA+'</div>'+
									'<div class="itemBody" style="width:150px;">'+partidas_ar[i].CODTEL+'</div>'+
									'<div class="itemBody" style="width:150px;">'+partidas_ar[i].DESPRV+'</div>'+
									'<div class="itemBody" style="width:100px;">'+partidas_ar[i].NUMVEZ+'</div>'+
									'<div class="itemBody" style="width:100px;">'+partidas_ar[i].FECSOL+'</div>'+
									'<div class="itemBody" style="width:100px;">'+partidas_ar[i].CODUSUSOL+'</div>'+
								'</div>';
						}
						$("#table-body").empty();
						$("#table-body").append(html);
						$("#tablepartidas").css("display","block");
						$("#msg-nopartidas").css("display","none");
					}else{
						$("#tablepartidas").css("display","none");
						$("#msg-nopartidas").css("display","block");
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		});
		$("#idpartida").keyup(function(){
			document.getElementById("result-estcon").style.display="none";
			var html='';
			for (var i = 0; i < partidas_ar.length; i++) {
				if ((partidas_ar[i].PARTIDA).toUpperCase().indexOf($("#idpartida").val().toUpperCase())>=0) {
					html+=
						'<div style="display: flex;" onclick="show_detail(\''+partidas_ar[i].PARTIDA+'\',\''+partidas_ar[i].CODTEL+'\','+
						'\''+partidas_ar[i].CODPRV+'\',\''+partidas_ar[i].NUMVEZ+'\',\''+partidas_ar[i].PARTE+'\',\''+partidas_ar[i].CODTAD+'\',\''+partidas_ar[i].DESPRV+'\')">'+
							'<div class="itemBody itemBodyLink" style="width:100px;">'+partidas_ar[i].PARTIDA+'</div>'+
							'<div class="itemBody" style="width:150px;">'+partidas_ar[i].CODTEL+'</div>'+
							'<div class="itemBody" style="width:150px;">'+partidas_ar[i].DESPRV+'</div>'+
							'<div class="itemBody" style="width:100px;">'+partidas_ar[i].NUMVEZ+'</div>'+
							'<div class="itemBody" style="width:100px;">'+partidas_ar[i].FECSOL+'</div>'+
							'<div class="itemBody" style="width:100px;">'+partidas_ar[i].CODUSUSOL+'</div>'+
						'</div>';
				}
			}
			$("#table-body").empty();
			$("#table-body").append(html);
		});
		function show_detail(partida,codtel,codprv,numvez,parte,codtad,desprv){
			partida_v=partida.toUpperCase();
			codtel_v=codtel;
			codprv_v=codprv;
			numvez_v=numvez;
			parte_v=parte;
			codtad_v=codtad;
			document.getElementById("result-estcon").style.display="block";
			document.getElementById("idParSel").innerHTML=partida;
			document.getElementById("idCodTelSel").innerHTML=codtel;
			document.getElementById("idPrvSel").innerHTML=desprv;
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getDataEstCon.php',
				data:{
					partida:partida_v,
					codtel:codtel_v,
					codprv:codprv_v,
					numvez:numvez_v,
					parte:parte_v,
					codtad:codtad_v
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						document.getElementById("idMotSel").innerHTML=data.MOTIVO;
						document.getElementById("idEstCliSel").innerHTML=data.ESTCLI;
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		var partida_v=null;
		var codtel_v=null;
		var codprv_v=null;
		var numvez_v=null;
		var parte_v=null;
		var codtad_v=null;
		function show_partida(){
			window.location.href="VerAuditoriaTela.php?partida="+partida_v+"&codtel="+codtel_v+"&codprv="+codprv_v+
			"&numvez="+numvez_v+"&parte="+parte_v+"&codtad="+codtad_v;			
		}
		function guardar_estudio(){
			if (document.getElementById("idEstCon").value=="" ||
				document.getElementById("idDatCol").value=="") {
				alert("Debe ingresar un valor de estudio de consumo y dato color");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/updateEstCon.php',
				data:{
					partida:partida_v,
					codtel:codtel_v,
					codprv:codprv_v,
					numvez:numvez_v,
					parte:parte_v,
					codtad:codtad_v,
					estcon:Math.round(parseFloat(document.getElementById("idEstCon").value)*100),
					datcol:document.getElementById("idDatCol").value
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						window.location.reload();
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
	</script>
</body>
</html>