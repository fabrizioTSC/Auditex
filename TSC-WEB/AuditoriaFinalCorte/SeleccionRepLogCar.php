<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="3";
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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
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
			<div class="headerTitle">Filtro de Reporte Log de Carga de Medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameLine">
				<div class="lblNew" style="width: 80px;padding-top: 5px;">Est. TSC</div>
				<input type="text" id="nombreEsttsc" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceEsttsc">
					<div class="taller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 20px;"></div>
			<div class="sameLine">
				<div class="lblNew" style="width: 120px;padding-top: 5px;">Usuario</div>
				<input type="text" id="nombreUsuario" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceUsuario">
					<div class="taller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 20px;"></div>
			<div class="sameLine">
				<div class="lblNew" style="width: 200px;padding-top: 5px;">Rango de fechas</div>
				<input type="checkbox" id="idactfecha">
			</div>
			<div id="fechas" style="display: none;">
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Desde</div>
					<input type="date" id="idfecini" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
				</div>
				<div class="sameLine" style="margin-top: 5px;">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Hasta</div>
					<input type="date" id="idfecfin" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
				</div>
			</div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="mostrar()">Mostrar Reporte</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript">
		var esttsc=[];
		var usuario=[];
		$(document).ready(function(){
			document.getElementById("idactfecha").checked=false;
			$.ajax({
				type:"POST",
				data:{
				},
				url:"config/getFiltroRepLogCar.php",
				success:function(data){
					console.log(data);

					esttsc=data.esttsc;
					var html='';
					for (var i = 0; i < esttsc.length; i++) {
						/* html+='<div class="taller" onclick="selectEsttsc(\''+esttsc[i].ESTTSC+'\',\''+formatText(esttsc[i].DESESTTSC)+'\')">'+esttsc[i].DESESTTSC+'</div>'; */
						html += '<div class="taller" onclick="selectEsttsc(\'' + esttsc[i].ESTTSC + '\',\'' + (esttsc[i].DESESTTSC ? formatText(esttsc[i].DESESTTSC) : '') + '\')">' + esttsc[i].DESESTTSC + '</div>';

					}
					$("#spaceEsttsc").empty();
					$("#spaceEsttsc").append(html);

					usuario=data.usuario;
					var html='';
					for (var i = 0; i < usuario.length; i++) {
						/* html+='<div class="taller" onclick="selectUsuario(\''+usuario[i].CODUSU+'\',\''+formatText(usuario[i].DESUSU)+'\')">'+usuario[i].DESUSU+'</div>'; */
						html += '<div class="taller" onclick="selectUsuario(\'' + usuario[i].CODUSU + '\',\'' + (usuario[i].DESUSU ? formatText(usuario[i].DESUSU) : '') + '\')">' + (usuario[i].DESUSU ? usuario[i].DESUSU : 'Sin nombre') + '</div>';

					}
					$("#spaceUsuario").empty();
					$("#spaceUsuario").append(html);

					$("#nombreEsttsc").val("(TODOS)");
					$("#nombreUsuario").val("(TODOS)");
					esttsc_var="0";
					codusu_var="0";

					$(".panelCarga").fadeOut(200);			
				}
			});
			$("#nombreEsttsc").keyup(function(){
				var html='';
				for (var i = 0; i < esttsc.length; i++) {
					if ((esttsc[i].DESESTTSC.toUpperCase()).indexOf($("#nombreEsttsc").val().toUpperCase())>=0) {
						html+='<div class="taller" onclick="selectEsttsc(\''+esttsc[i].ESTTSC+'\',\''+esttsc[i].DESESTTSC+'\')">'+esttsc[i].DESESTTSC+'</div>';
					}
				}
				$("#spaceEsttsc").empty();
				$("#spaceEsttsc").append(html);		
			});
			$("#nombreUsuario").keyup(function(){
				var html='';
				for (var i = 0; i < usuario.length; i++) {
					if ((usuario[i].DESUSU.toUpperCase()).indexOf($("#nombreUsuario").val().toUpperCase())>=0) {
						html+='<div class="taller" onclick="selectUsuario(\''+usuario[i].CODUSU+'\',\''+usuario[i].DESUSU+'\')">'+usuario[i].DESUSU+'</div>';
					}
				}
				$("#spaceUsuario").empty();
				$("#spaceUsuario").append(html);	
			});
			$("#idactfecha").click(function(){
				if (document.getElementById("idactfecha").checked) {
					$("#fechas").css("display","block");
				}else{
					$("#fechas").css("display","none");
				}
			});
			var fecha=new Date();
			var dia=fecha.getDate();
			dia=""+dia;
			if (dia.length==1) {
				dia="0"+dia;
			}
			var mes=fecha.getMonth()+1;
			mes=""+mes;
			if (mes.length==1) {
				mes="0"+mes;
			}
			var anio=fecha.getFullYear();
			var hoy=anio+"-"+mes+"-"+dia;
			document.getElementById("idfecini").value=hoy;
			document.getElementById("idfecfin").value=hoy;
		});

		var esttsc_var="";
		function selectEsttsc(esttsc,desesttsc){
			esttsc_var=esttsc;
			$("#nombreEsttsc").val(desesttsc);
		}

		var codusu_var="";
		function selectUsuario(codusu,desusu){
			codusu_var=codusu;
			$("#nombreUsuario").val(desusu);
		}

		function mostrar(){
			let actfec=0;
			if (document.getElementById("idactfecha").checked) {
				actfec=1;
			}
			window.location.href="RepLogCar.php?esttsc="+esttsc_var+"&codusu="+codusu_var
			+"&fec="+actfec
			+"&fecini="+document.getElementById("idfecini").value
			+"&fecfin="+document.getElementById("idfecfin").value;
		}
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>