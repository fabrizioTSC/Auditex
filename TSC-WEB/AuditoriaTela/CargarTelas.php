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
			<div class="headerTitle">Cargar Telas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>		
		<div class="bodyContent mainBodyContent">
			<div class="lbl" style="padding-top: 0px;margin-bottom: 5px;">Proveedor:</div>		
			<select class="selectclass-min" style="width: 150px;padding: 5px;margin-bottom: 5px;" id="selectcodprv">
			</select>
			<div class="sameline">
				<div class="btnPrimary" onclick="click_input()" style="margin:0px;">Cargar CSV</div>
				<div class="btnPrimary" onclick="click_input2()" style="margin:0px;margin-left: 5px;">Validar CSV</div>
			</div>
			<div style="display: none;" id="show_preview">
				<div class="lineDecoration"></div>
				<div id="maintbl" style="margin-bottom: 10px;overflow-x: scroll;height: calc(100vh - 225px);position: relative;">
					<div id="bodytbl" style="position: relative;">
						<div class="tblHeader" id="data-header" style="position: relative;z-index: 11;">
							<!--
							<div class="itemHeader" style="width: 50%;text-align: center;">Item1</div>
							<div class="itemHeader" style="width: 20%;text-align: center;">Rango</div>
							<div class="itemHeader" style="width: 30%;text-align: center;">Valor</div>-->
						</div>
						<div class="tblBody" id="data-preview" style="position: relative;">
						</div>
					</div>
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 0px;" onclick="send_data()">Confirmar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<input type="file" id="inputFile" style="display: none;">
	<input type="file" id="inputFile2" style="display: none;">
	<script type="text/javascript">
		$(document).ready(function(){
			$("#maintbl").scroll(function(){
				if ($("#maintbl").scrollTop()>50) {
					$("#data-header").css("position","absolute");
					$("#data-header").css("top",$("#maintbl").scrollTop()+"px");
				}else{
					$("#data-header").css("position","relative");
					$("#data-header").css("top","0px");
				}
			});
			$.ajax({
				type:"POST",
				url:"config/getInfoForCharge.php",
				success:function(data){
					console.log(data);
					ar_infoctelas=data.infoprv;
					ar_infocolumns=data.infoestdim;
					ar_estdim=data.estdim;
					var html='';
					for (var i = 0; i < data.infoprv.length; i++) {
						html+='<option value="'+data.infoprv[i].CODDAT+'">'+data.infoprv[i].DESDAT+'</option>';
					}
					$("#selectcodprv").append(html);
					$(".panelCarga").fadeOut(100);
				}
			});
		});
		var pos_start_medida=13;
		var ar_infocolumns=[];
		var ar_infoctelas=[];
		var ar_estdim=[];
		function click_input(){
			$("#inputFile").click();
		}
		function click_input2(){
			$("#inputFile2").click();
		}
		var ar_send=[];
		function counter_delimiter(text){
			var delimiter1=',';
			var cont_delimiter1=0;
			var delimiter2=';';
			var cont_delimiter2=0;
			for (var i = 0; i < text.length; i++) {
				if(text[i]==delimiter1){
					cont_delimiter1++;
				}
				if(text[i]==delimiter2){
					cont_delimiter2++;
				}
			}
			console.log(cont_delimiter1+" - "+cont_delimiter2);
			if (cont_delimiter1>cont_delimiter2) {
				return delimiter1;
			}else{
				return delimiter2;
			}
		}
		function send_data(){
            $(".panelCarga").fadeIn(200);
			$.ajax({
				type:"POST",
				data:{
					array_estdim:JSON.stringify(ar_estdim),
					array:JSON.stringify(ar_send)
				},
				url:"config/saveTelasFromCsv.php",
				success:function(data){
					console.log(data);
					if (data.state) {
						alert(data.tel+" telas guardadas y "+data.dettel+" detalle de telas guardados!");
					}else{
						alert("No se pudo insertar los registros!");
					}
					window.location.reload();
				}
			});
		}
		$("#inputFile").change(function(evt){
			var f = evt.target.files[0]; 
	        if (f){
		        var r = new FileReader();
		        r.onload = function(e){
		            var ar1=e.target.result.split("\n");
		        	var delimiter=counter_delimiter(ar1[0]);
		            var ar_pos=[];
		            for (var i = 0; i < ar_infoctelas.length; i++) {
		            	if(ar_infoctelas[i].CODDAT==$("#selectcodprv").val()){
		            		ar_pos.push(ar_infoctelas[i].CODTEL-1);
		            		ar_pos.push(ar_infoctelas[i].CODPRV-1);
		            		ar_pos.push(ar_infoctelas[i].DESTEL-1);
		            		ar_pos.push(ar_infoctelas[i].COMFIN-1);
		            	}
		            }
		            for (var i = 0; i < ar_infocolumns.length; i++) {
		            	if(ar_infocolumns[i].CODDAT==$("#selectcodprv").val()){
		            		ar_pos.push(ar_infocolumns[i].VALOR-1);
		            		ar_pos.push(ar_infocolumns[i].TOLERANCIA-1);
		            	}
		            }
		            console.log(ar_pos);
		            ar_send=[];
		            for (var i = 0; i < ar1.length; i++) {
		            	/*if (isNaN(parseInt(ar1[i][0])) || parseInt(ar1[i][0])==3) {
		            		console.log(i+1);
		            		console.log(ar1[i]);
		            	}*/
		            	var ar_aux=ar1[i].split(delimiter);
		            	var aux=[];
		            	for (var j = 0; j < ar_pos.length; j++) {
		            		aux.push(process_text(ar_aux[ar_pos[j]]));
		            	}
		            	if(aux[0]!=""){
			            	ar_send.push(aux);
			            }
		            }
		           	var html1='';
		           	var html2='';
		            for (var i = 0; i < ar_send.length; i++) {
		            	for (var j = 0; j < ar_send[i].length; j++) {
		            		if (i==0) {
		            			html1+='<div class="itemHeader" style="width: 150px;text-align: center;font-size:12px;">'+ar_send[i][j]+'</div>';
		            		}else{
		            			if (j==0) {
		            				html2+='<div class="tblLine">';
		            			}
		            			html2+='<div class="itemBody" style="width: 150px;text-align: center;font-size:12px;">'+ar_send[i][j]+'</div>';
		            			if (j==ar_send[i].length-1) {
		            				html2+='</div>';
		            			}
		            		}
		            	}
		            }
            		$("#data-header").empty();
            		$("#data-header").append(html1);
            		$("#data-preview").empty();
            		$("#data-preview").append(html2);
		            $("#bodytbl").css("width",ar_send[0].length*110+"px");
		            $("#show_preview").css("display","block");
		        };
	            r.readAsText(f);
	        }else{
	            alert("No se pudo cargar el archivo!");
	        }
		});
		$("#inputFile2").change(function(evt){
			console.clear();
			var f = evt.target.files[0]; 
	        if (f){
		        var r = new FileReader();
		        r.onload = function(e){
		            var ar1=e.target.result.split("\n");
		        	var delimiter=counter_delimiter(ar1[0]);
		            var ar_pos=[];
		            for (var i = 0; i < ar_infoctelas.length; i++) {
		            	if(ar_infoctelas[i].CODDAT==$("#selectcodprv").val()){
		            		ar_pos.push(ar_infoctelas[i].CODTEL-1);
		            		ar_pos.push(ar_infoctelas[i].CODPRV-1);
		            		ar_pos.push(ar_infoctelas[i].DESTEL-1);
		            		ar_pos.push(ar_infoctelas[i].COMFIN-1);
		            	}
		            }
		            for (var i = 0; i < ar_infocolumns.length; i++) {
		            	if(ar_infocolumns[i].CODDAT==$("#selectcodprv").val()){
		            		ar_pos.push(ar_infocolumns[i].VALOR-1);
		            		ar_pos.push(ar_infocolumns[i].TOLERANCIA-1);
		            	}
		            }
		            console.log(ar_pos);
		            ar_send=[];
		            for (var i = 0; i < ar1.length; i++) {
		            	if (ar1[i][0]!="") {
			            	if (isNaN(parseInt(ar1[i][0])) && i!=0) {
			            		console.log(i);
			            		console.log(ar1[i-1]);
			            		console.log(ar1[i]);
			            	}
		            	}
		            }
		        };
	            r.readAsText(f);
	        }else{
	            alert("No se pudo cargar el archivo!");
	        }
		});
		function process_text(text){
			if (text!=undefined) {
				return text.trimStart().trimEnd();
			}else{
				return "";
			}
		}
	</script>
</body>
</html>