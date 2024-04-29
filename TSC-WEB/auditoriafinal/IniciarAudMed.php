<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: ../../dashboard/index.php');
	}
	$appcod="13";
	//include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
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
		<div class="headerContent">
			<div class="headerTitle">Iniciar auditoría de medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-top: 10px;">
			<div style="display: flex;justify-content: center;">
				<div class="rowLine" style="display: flex;width: 150px;">
					<label style="padding: 7px 5px 0 0;">Ficha</label>
					<input type="number" id="codfic" style="width: 100px;">
				</div>
			</div>
			<center>
				<button class="btnPrimary" onclick="val_ficha_med()">Iniciar</button>
				<button class="btnPrimary" onclick="window.history.back();" style="margin-top: 5px;">Volver</button>
			</center>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">		
		function val_ficha_med(){
			if ($("#codfic").val()=="") {
				alert("Complete la ficha");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/valEstTscAudMed.php",
				data:{
					codfic:$("#codfic").val()
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						window.location.href="AuditoriaMedidas.php?codfic="+$("#codfic").val();
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