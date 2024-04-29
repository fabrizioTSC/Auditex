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
	<title>AUDITEX - INSPECCION</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		textarea{
			margin-top: 5px;
			padding: 5px;
			width: calc(100% - 10px);
			height: 200px;
			font-family: sans-serif;
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
		<div class="headerContent">
			<div class="headerTitle">Agregar Partida</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 5px;">
			<div id="space1">
				<div class="lbl" style="padding: 0px;">Pegue el texto</div>
				<textarea id="idquery"></textarea>
				<button class="btnPrimary" onclick="send_query()">Ejecutar</button>
				<div class="lbl" id="content-result" style="padding: 0px;margin-top: 10px;display: none;color: #bb1717;"><span id="query-result"></span></div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
	</script>
	<script type="text/javascript">
		function send_query(){
			if ($("#idquery").val()!="") {
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:"POST",
					url:"config/insertQuery.php",
					data:{
						query:$("#idquery").val()
					},
					success:function(data){
						console.log(data);
						if (!data.state) {
							alert(data.detail);
						}else{
							$("#query-result").text(data.detail);
							$("#content-result").css("display","block");
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}else{
				alert("Debe pegar un query!");
			}
		}
	</script>
</body>
</html>