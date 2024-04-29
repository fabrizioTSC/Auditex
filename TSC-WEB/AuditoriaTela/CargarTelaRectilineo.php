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
		.lbl2{
			width: 150px;
			padding-right: 5px;
		}
		.lbl3{
			font-size: 12px;
		}
		.contentInput{
			width: calc(100% - 155px);
		}
		.specialIpt{
			width: 150px;
		}
		@media(max-width: 400px){
			.lbl2{
				width: calc(40% - 5px);
			}
			.contentInput{
				width: calc(60%);
			}
			.specialIpt{
				width: calc(100% - 16px);
			}
		}
		table{
			width: 100%;
			min-width: 550px;
		}
		thead{
			background: #980f0f;
			color: #fff;
		}
		tbody{
			background: #fff;
		}
		table,td{
			border-collapse: collapse;			
		}
		tr td:nth-child(1){
			padding: 5px;
			text-align: center;
			width: 60px;
		}
		thead tr td{
			padding: 5px;
		}
		td input{
			padding: 5px 3px;
			width: calc(100% - 10px);
		}
		tbody tr{
			border-top: 1px #666 solid;
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
	<div class="editarDefectos" id="modal1">
		<div class="contentEditar">
			<div class="titleContent">Añadir talla</div>
			<div class="lineDecoration"></div>
			<div class="bodyEdicion">
				<div class="sameLine">
					<div class="lblNew" style="width: 110px;padding-top: 5px;">Tallas</div>
					<input type="text" id="nombretalla" class="iptClass" style="width: calc(100% - 110px);font-size: 15px;border: 1px solid #999;">
				</div>
				<div class="tblSelection" style="border: 1px solid #999;margin-bottom: 10px;">
					<div class="listaTalleres" id="spacetallas">
						<div class="classTaller"></div>
					</div>
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 5px;" onclick="save_talla()">Confirmar</button>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="hide_modal(1)">Cancerlar</button>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Cargar Tela Rectilineo</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>		
		<div class="bodyContent mainBodyContent">
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">C&oacute;digo Tela:</div>
				<div class="contentInput">
					<input type="text" id="idcodtel" class="classIpt specialIpt">
				</div>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">C&oacute;digo Prov.:</div>
				<div class="contentInput">
					<input type="text" id="idcodprv" class="classIpt specialIpt">
				</div>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">Descripci&oacute;n Tela:</div>
				<div class="contentInput">
					<input type="text" id="iddestel" class="classIpt">
				</div>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">Composici&oacute;n final:</div>
				<div class="contentInput">
					<input type="text" id="idcomfin" class="classIpt">
				</div>
			</div>
			<div onclick="add_talla()" style="color: #1010ad;margin-bottom: 5px;text-decoration: underline;">Agregar talla</div>
			<div style="width: 100%;overflow-x: scroll;">
				<table>
					<thead>
						<tr>
							<td>Talla</td>
							<td>Largo</td>
							<td>Tolerancia</td>
							<td>Ancho</td>
							<td>Tolerancia</td>
							<td>Peso por Unid. (gr)</td>
						</tr>
					</thead>
					<tbody id="tbl-body">
						<!--<tr>
							<td><span class="span-talla" data-talla="014" id="tal-014">XS</span></td>
							<td><input type="text" id="lar-014"></td>
							<td><input type="text" id="tollar-014"></td>
							<td><input type="text" id="anc-014"></td>
							<td><input type="text" id="tolanc-014"></td>
							<td><input type="text" id="pes-014"></td>
						</tr>-->
					</tbody>
				</table>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;margin-bottom: 0px;" onclick="send_data()">Guardar</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var tallas=[];
		$(document).ready(function(){
			$.ajax({
				type:"POST",
				url:"config/getInfoTallas.php",
				success:function(data){
					console.log(data);
					tallas=data.tallas;

					var html='';
					for (var i = 0; i < tallas.length; i++) {
						html+='<div class="taller" onclick="selectTalla(\''+tallas[i].CODTAL+'\',\''+tallas[i].DESTAL+'\')">'+tallas[i].CODTAL+' - '+tallas[i].DESTAL+'</div>';
					}
					$("#spacetallas").empty();
					$("#spacetallas").append(html);

					codtal_var="0";

					$(".panelCarga").fadeOut(100);
				}
			});
			$("#nombretalla").keyup(function(){
				var html='';
				for (var i = 0; i < tallas.length; i++) {
					if ((tallas[i].DESTAL.toUpperCase()).indexOf($("#nombretalla").val().toUpperCase())>=0) {
						html+='<div class="taller" onclick="selectTalla(\''+tallas[i].CODTAL+'\',\''+tallas[i].DESTAL+'\')">'+tallas[i].CODTAL+' - '+tallas[i].DESTAL+'</div>';
					}
				}
				$("#spacetallas").empty();
				$("#spacetallas").append(html);	
			});
		});
		function selectTalla(codtal,destal){
			$("#nombretalla").val(destal);
			codtal_var=codtal;
			$("#nombretalla").keyup();
		}
		var codtal_var="0";
		function save_talla(){
			if (codtal_var=="0") {
				alert("Seleecione un registro de la tabla!");
			}else{
				if (document.getElementById("tal-"+codtal_var)) {
					alert("Talla existente!");
				}else{
					//Agregar fila
					let html=
						'<tr>'+
							'<td><span class="span-talla" data-talla="'+codtal_var+'" id="tal-'+codtal_var+'">'+$("#nombretalla").val()+'</span></td>'+
							'<td><input type="text" id="lar-'+codtal_var+'"></td>'+
							'<td><input type="text" id="tollar-'+codtal_var+'"></td>'+
							'<td><input type="text" id="anc-'+codtal_var+'"></td>'+
							'<td><input type="text" id="tolanc-'+codtal_var+'"></td>'+
							'<td><input type="text" id="pes-'+codtal_var+'"></td>'+
						'</tr>';
					codtal_var="0";
					$("#nombretalla").val("");
					$("#nombretalla").keyup();
					document.getElementById("tbl-body").innerHTML+=html;
					hide_modal(1);
				}
			}
		}
		function validate_content(text){
			if (text==null) {
				return '';
			}else{
				return text;
			}
		}
		function send_data(){
			var ar=document.getElementsByClassName("span-talla");
			if (ar.length==0) {
				alert("Debe agregar tallas!");
				return;
			}
			var validado=true;
			var ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				let id=ar[i].dataset.talla;
				let ar_aux=[];
				ar_aux.push(id);
				ar_aux.push(document.getElementById("lar-"+id).value);
				ar_aux.push(document.getElementById("tollar-"+id).value);
				ar_aux.push(document.getElementById("anc-"+id).value);
				ar_aux.push(document.getElementById("tolanc-"+id).value);
				ar_aux.push(parseInt(parseFloat(document.getElementById("pes-"+id).value)*100000));
				ar_send.push(ar_aux);
			}
			console.log(ar_send);
			if (validado && validar_campos()) {
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:"POST",
					url:"config/saveInfoTelRec.php",
					data:{
						codtel:$("#idcodtel").val(),
						codprv:$("#idcodprv").val(),
						destel:$("#iddestel").val(),
						comfin:$("#idcomfin").val(),
						ren:$("#idren").val(),
						array:ar_send
					},
					success:function(data){
						console.log(data);
						alert(data.detail);
						if (data.state) {
							window.location.reload();
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}else{
				alert("Complete todos los campos!");
			}
		}
		function validar_campos(){
			if ($("#idcodtel").val()!=""
				&& $("#iddestel").val()!=""
				&& $("#idcomfin").val()!="") {
				return true;
			}else{
				return false;
			}
		}
		function add_talla(){
			$("#modal1").fadeIn(100);
		}
		function hide_modal(id){
			$("#modal"+id).fadeOut(100);
		}
	</script>
</body>
</html>