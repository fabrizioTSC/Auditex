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
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/reporteLE.css">
	<style type="text/css">
		td input[type="number"]{
			width: calc(100% - 12px);
		}
		td,th{
			font-size: 12px;
		}
		th:nth-child(5),th:nth-child(5){
			width: 200px;
		}
		#table-color tr th,
		#table-color tr td{
			width: 50%;
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
			<div class="headerTitle">Generar Reporte de Auditoría Calidad</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="div-flex mt5">
				<label>FORM</label>
				<div class="content-input">
					<input type="text" id="form">
				</div>
			</div>
			<div class="div-flex mt5">
				<label>VERSION</label>
				<div class="content-input">
					<input type="text" id="version">
				</div>
			</div>
			<div class="div-flex mt5">
				<label>DATE (M/D/Y)</label>
				<div class="content-input">
					<input type="text" id="fecha" disabled>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>VENDOR NAME / #</label>
				<div class="content-input">
					<input type="text" id="vendor">
				</div>
			</div>
			<div class="div-flex mt5">
				<label>FACTORY NAME / #</label>
				<div class="content-input">
					<input type="text" id="factory">
				</div>
			</div>
			<div class="div-flex mt5">
				<label>AQL LEVEL</label>
				<div class="content-input">
					<input type="text" id="desaql" disabled>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>LOT SIZE</label>
				<div class="content-input">
					<input type="text" id="cantidad" disabled>
				</div>
			</div>
			<div class="mt5">
				<label>WAREHOUSE DESTINATION DVDC (PLEASE SELECT THE OPTION)</label>
				<br>
				<select id="codwardes">
				</select>
			</div>
			<div class="div-flex mt5">
				<label>SAMPLE SIZE</label>
				<div class="content-input">
					<input type="text" id="canaql" disabled>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>A-R LEVEL</label>
				<div class="content-input">
					<input type="text" id="candefmax" disabled>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>STYLE #</label>
				<div class="content-input">
					<input type="text" id="estcli" disabled>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>CATEGORIA</label>
				<div class="content-input">
					<input type="text" id="categoria">
				</div>
			</div>
			<div class="div-flex mt5">
				<label>PO #</label>
				<div class="content-input"><?php if(isset($_GET['po'])){echo $_GET['po'];} ?></div>
			</div>
			<div class="mt5">
				<label>ITEM DESCRIPTION</label>
				<textarea id="despre" rows="2"></textarea>
			</div>
			<div class="mt5">
				<label>COLOR(S) DESCRIPTION</label>
				<textarea id="descol" disabled rows="2"></textarea>
			</div>
			<div class="mt5">
				<label>COLOR(S)</label>
				<div style="width: 100%;overflow-x: scroll;margin-bottom: 5px;">
					<table style="min-width: 300px;width: 100%;">
						<tbody id="table-color">
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>LE# AUDITOR</label>
				<div class="content-input">
					<select onchange="update_nomusu(this)" id="codaud">
						<option value="A">PASS</option>
						<option value="R">FAIL</option>
					</select>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>AUDITOR</label>
				<div class="content-input">
					<input type="text" id="nomaud" disabled>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>NOM-CONF. UNITS</label>
				<div class="content-input">
					<input type="text" id="candef" disabled>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>TOTAL CARTONS</label>
				<div class="content-input">
					<input type="text" id="numcaj" disabled>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>PASS</label>
				<div class="content-input">
					<select id="resultado">
						<option value="A">PASS</option>
						<option value="R">FAIL</option>
					</select>
				</div>
			</div>
			<div class="div-flex div-st2 mt5">
				<label>FINAL AUDIT</label>
				<input type="checkbox" id="finalaudit">
			</div>
			<div class="div-flex div-st2 mt5">
				<label>PRE-FINAL</label>
				<input type="checkbox" id="prefinal">
			</div>
			<div class="div-flex div-st2  mt5">
				<label>IN-LINE</label>
				<input onclick="validate_check(this,'inlinevez')" class="sp-check" type="checkbox" id="inline">
				<select id="inlinevez">
					<option value="1">1ST</option>
					<option value="2">2ND</option>
					<option value="3">3RD</option>
				</select>
			</div>
			<div class="div-flex div-st2  mt5">
				<label>RE-AUDIT</label>
				<input onclick="validate_check(this,'reauditvez')" class="sp-check" type="checkbox" id="reaudit">
				<select id="reauditvez">
					<option value="1">1ST</option>
					<option value="2">2ND</option>
					<option value="3">3RD</option>
				</select>
			</div>
			<div class="div-flex div-st2  mt5">
				<label>CERTIFIED AUDITOR</label>
				<input type="checkbox" id="certifiedaud">
			</div>
			<div class="div-flex div-st2  mt5">
				<label>TRAINEE</label>
				<input type="checkbox" id="trainee">
			</div>
			<div class="div-flex div-st2  mt5">
				<label>PRE-CERTIFED AUDITOR</label>
				<input type="checkbox" id="precertifiedaud">
			</div>
			<div class="div-flex div-st2  mt5">
				<label>CORRELATION AUDIT</label>
				<input type="checkbox" id="correlationaud">
			</div>
			<div class="div-flex div-st2  mt5">
				<label>LE AUDITOR</label>
				<input type="checkbox" id="leauditor">
			</div>
			<div class="mt5">
				<label>CARTON # INSPECTION PULL</label>
				<br>
				<input type="text" id="carinspul">
			</div>
			<div class="mt5">
				<label>CARTON # INSPECTION MOISTURE READING PULL</label>
				<br>
				<input type="text" id="carinsmoisture">
			</div>
			<div class="mt5">
				<label>GENERAL COMMENTS</label>
				<br>
				<textarea id="comentarios"></textarea>
			</div>
			<h4>Lista de defectos</h4>
			<div style="width: 100%;overflow-x: scroll;margin-bottom: 5px;">
				<table style="min-width: 600px;width: 100%;">
					<tbody id="table-body">
						<tr>
							<th>Defect Code</th>
							<th>Defect Description</th>
							<th>Qty</th>
							<th>Qty Report</th>
							<th>Corrective Action</th>
						</tr>
						<tr>
							<td>13</td>
							<td>13</td>
							<td>13</td>
							<td><input type="number" name="" value="2"></td>
							<td><textarea id="" value="Hola"></textarea></td>
						</tr>
					</tbody>
				</table>
			</div>
			<center>
				<button class="btnPrimary" onclick="generar_rep_defectos()">Generar</button>
				<button class="btnPrimary" onclick="pre_rep_defectos()">Previsualizar</button>
			</center>
			<center>
				<button style="margin-top: 5px;" class="btnPrimary" onclick="confirm_report()">Confirmar calidad</button>
			</center>
			<div class="lineDecoration"></div>
			<center>
				<button class="btnPrimary" onclick="window.history.back();">Volver</button>
			</center>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var po="<?php echo $_GET['po']; ?>";
		var paclis="<?php echo $_GET['paclis']; ?>";
		$(document).ready(function(){
			$.ajax({
				type:"POST",
				url:"config/startGenRepDef.php",
				data:{
					po:po,
					paclis:paclis
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						let html='';
						for (var i = 0; i < data.war.length; i++) {
							html+='<option value="'+data.war[i].CODWARDES+'">'+data.war[i].DESWARDES+'</option>';							
						}
						document.getElementById("codwardes").innerHTML=html;
						html='';
						for (var i = 0; i < data.aud.length; i++) {
							html+='<option value="'+data.aud[i].CODAUD+'|'+data.aud[i].NOMAUD+'">'+data.aud[i].CODAUD+' | '+data.aud[i].NOMAUD+'</option>';							
						}
						document.getElementById("codaud").innerHTML=html;

						document.getElementById("estcli").value=data.data.ESTCLI;
						document.getElementById("form").value=data.data.FORM;
						document.getElementById("version").value=data.data.VERSION;
						document.getElementById("fecha").value=data.data.FECHA;
						document.getElementById("vendor").value=data.data.VENDOR;
						document.getElementById("factory").value=data.data.FACTORY;
						document.getElementById("desaql").value=data.data.AQL;
						document.getElementById("cantidad").value=data.data.CANTIDAD;
						document.getElementById("codwardes").value=data.data.CODWARDES;
						document.getElementById("canaql").value=data.data.CANAUD;
						document.getElementById("candefmax").value=data.data.CANDEFMAX+"/"+(parseInt(data.data.CANDEFMAX)+1);
						document.getElementById("despre").value=data.data.DESPRE;
						document.getElementById("descol").value=data.data.DESCOL;
						document.getElementById("nomaud").value=data.data.NOMAUD;
						document.getElementById("codaud").value=data.data.CODAUD+"|"+data.data.NOMAUD;
						document.getElementById("candef").value=data.data.CANDEF;
						document.getElementById("numcaj").value=data.data.NUMCAJ;
						document.getElementById("carinspul").value=data.data.CARINSPULL;
						document.getElementById("carinsmoisture").value=data.data.CARINSMOISTURE;
						document.getElementById("comentarios").value=data.data.COMENTARIOS;

						document.getElementById("categoria").value=data.data.CATEGORIA;
						//document.getElementById("descolrep").value=data.data.DESCOLREP;

						auto_check(document.getElementById("finalaudit"),data.data.FINALAUDIT);
						auto_check(document.getElementById("prefinal"),data.data.PREFINAL);
						auto_check2(document.getElementById("inline"),data.data.INLINE,document.getElementById("inlinevez"),data.data.INLINEVEZ);
						auto_check2(document.getElementById("reaudit"),data.data.REAUDIT,document.getElementById("reauditvez"),data.data.REAUDITVEZ);
						auto_check(document.getElementById("certifiedaud"),data.data.CERTIFIEDAUD);
						auto_check(document.getElementById("trainee"),data.data.TRAINEE);
						auto_check(document.getElementById("precertifiedaud"),data.data.PRECERTIFIEDAUD);
						auto_check(document.getElementById("correlationaud"),data.data.CORRELATIONAUD);
						auto_check(document.getElementById("leauditor"),data.data.LEAUDITOR);
						
						document.getElementById("table-body").innerHTML=data.html;
						document.getElementById("table-color").innerHTML=data.htmlcol;
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		});
		function generar_rep_defectos(){
			//alert("En proceso");
			if (document.getElementById("codaud").value=="") {
				alert("Seleccione un auditor");
				return;
			}
			let ar_aud=document.getElementById("codaud").value.split("|");
			let finalaudit=get_value_check(document.getElementById("finalaudit"));
			let prefinal=get_value_check(document.getElementById("prefinal"));
			let inline=get_value_check(document.getElementById("inline"));
			if (inline=="1" && document.getElementById("inlinevez").value=="") {
				alert("Debe seleccionar la VEZ de IN-LINE");
				return;
			}
			let reaudit=get_value_check(document.getElementById("reaudit"));
			if (reaudit=="1" && document.getElementById("reauditvez").value=="") {
				alert("Debe seleccionar la VEZ de RE-AUDIT");
				return;
			}
			let certifiedaud=get_value_check(document.getElementById("certifiedaud"));
			let trainee=get_value_check(document.getElementById("trainee"));
			let precertifiedaud=get_value_check(document.getElementById("precertifiedaud"));
			let correlationaud=get_value_check(document.getElementById("correlationaud"));
			let leauditor=get_value_check(document.getElementById("leauditor"));
			$(".panelCarga").fadeIn(100);
			var ar_send=[];
			var ar=document.getElementsByClassName("ipt-candefrep");
			for (var i = 0; i < ar.length; i++) {
				let id=ar[i].id.replace("def","");
				let aux=[];
				aux.push(id);
				aux.push(ar[i].value);
				aux.push(document.getElementById("coract"+id).value);
				ar_send.push(aux);
			}
			var ar=document.getElementsByClassName("ipt-descolrep");
			var ar_descol=[];
			for (var i = 0; i < ar.length; i++) {
				var aux=[];
				aux.push(ar[i].id.replace("col-",""));
				aux.push(ar[i].value);
				ar_descol.push(aux);
			}
			$.ajax({
				type:"POST",
				url:"config/saveDatRepDef.php",
				data:{
					po:po,
					paclis:paclis,
					form:document.getElementById("form").value,
					version:document.getElementById("version").value,
					vendor:document.getElementById("vendor").value,
					factory:document.getElementById("factory").value,
					codwardes:document.getElementById("codwardes").value,
					categoria:document.getElementById("categoria").value,
					despre:document.getElementById("despre").value,
					//descolrep:document.getElementById("descolrep").value,
					descolrep:'',
					codaud:ar_aud[0],
					nomaud:ar_aud[1],
					pass:document.getElementById("resultado").value,
					carinspul:document.getElementById("carinspul").value,
					carinsmoisture:document.getElementById("carinsmoisture").value,
					comentarios:document.getElementById("comentarios").value,
					finalaudit:finalaudit,
					prefinal:prefinal,
					inline:inline,
					inlinevez:document.getElementById("inlinevez").value,
					reaudit:reaudit,
					reauditvez:document.getElementById("reauditvez").value,
					certifiedaud:certifiedaud,
					trainee:trainee,
					precertifiedaud:precertifiedaud,
					correlationaud:correlationaud,
					leauditor:leauditor,
					array:ar_send,
					arraycol:ar_descol
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function update_nomusu(dom){
			let id=dom.value.split("|");
			document.getElementById("nomaud").value=id[1];
		}
		function auto_check(dom,value){
			if (value=="1") {
				dom.checked=true;
			}else{
				dom.checked=false;
			}
		}
		function auto_check2(dom,value,dom2,value2){
			if (value=="1") {
				dom.checked=true;
				dom2.disabled=false;
			}else{
				dom.checked=false;
				dom2.disabled=true;
			}
			dom2.value=value2;
		}
		function validate_check(dom,id){
			if (dom.checked) {
				document.getElementById(id).disabled=false;
			}else{
				document.getElementById(id).disabled=true;
			}
		}
		function get_value_check(dom){
			if (dom.checked) {
				return "1";
			}else{
				return "0";
			}
		}
		function pre_rep_defectos(){
			var a=document.createElement("a");
			a.target="_blank";
			a.href="fpdf/pdfReporteDefectos.php?po="+po+"&paclis="+paclis;
			a.click();
		}
		function confirm_report(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/confirmDatRepCalInt.php",
				data:{
					po:po,
					paclis:paclis
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
	</script>
</body>
</html>