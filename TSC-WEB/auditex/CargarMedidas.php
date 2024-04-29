<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="10";
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
			<div class="headerTitle">Cargar Medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>		
		<div class="bodyContent mainBodyContent">	
			<button class="btnPrimary" onclick="click_input()" style="margin:0px;">Cargar CSV</button>
			<div style="display: none;" id="show_preview">
				<div class="lineDecoration"></div>
				<div class="lbl">Estilo: <span id="idesttsc"></span></div>	
				<!--
				<div class="lbl">Hilo: <span id="hilo"></span></div>	
				<div class="lbl">Travez: <span id="travez"></span></div>
				<div class="lbl" id="content-largmanga">Larg. de manga: <span id="largmanga"></span></div>-->
				<div id="maintbl" style="margin-bottom: 10px;overflow-x: scroll;height: calc(100vh - 272px);position: relative;margin-top: 10px;">
					<div id="bodytbl" style="position: relative;">
						<div class="tblHeader" id="data-header" style="position: relative;z-index: 11;">
						</div>
						<div class="tblBody" id="data-preview" style="position: relative;">
						</div>
					</div>
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 0px;" onclick="send_data()">Confirmar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/index-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<input type="file" id="inputFile" style="display: none;">
	<script type="text/javascript">
		var tam_max=80;
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
				data:{
				},
				url:"config/getInfoChargeMedidas.php",
				success:function(data){
					tam_max=data.tamdesmed;
            		$(".panelCarga").fadeOut(200);
				}
			});
		});
		var pos_start_medida=13;
		function click_input(){
			$("#inputFile").click();
		}
		var ar_send=[];
		var esttsc="";
		var hilo;
		var travez;
		var largmanga;

		var medida;
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
			if (cont_delimiter1>cont_delimiter2) {
				return delimiter1;
			}else{
				return delimiter2;
			}
		}
		var pos_send=0;
		var ar_esttsc;
		function send_data(){
            $(".panelCarga").fadeIn(200);
            ar_esttsc=esttsc.split(";");
            info_to_save(ar_esttsc[pos_send]);
		}
		var val_round=100;
		function info_to_save(esttsc){
			$.ajax({
				type:"POST",
				data:{
					esttsc:esttsc/*,
					hilo : hilo*val_round,
					travez : travez*val_round,
					largmanga : largmanga*val_round*/
				},
				url:"config/validarEstTscCargado.php",
				success:function(data){
					console.log(data);
					var validador2=data.state;
					var c;
					if (!validador2) {
						c=confirm(`Ya existen medidas para el ESTILO => ${esttsc} . Desea borrar y cargar las medidas nuevamente?`);
						if (c) {
							validador2=true;
						}else{
							if (pos_send==ar_esttsc.length-1) {
            					$(".panelCarga").fadeOut(200);
							}else{
								pos_send++;
								info_to_save(ar_esttsc[pos_send]);
							}
						}
					}
					if(validador2){
						$.ajax({
							type:"POST",
							data:{
								esttsc:esttsc,
								medida:medida,
								array:JSON.stringify(ar_send),
								filename:"asd"//,
								//hilo : hilo*val_round,
								//travez : travez*val_round,
								//largmanga : largmanga*val_round
							},
							url:"config/saveMedidasFromCsv.php",
							success:function(data){
								console.log(data);
								if (data.state) {
									alert("Se cargaron "+data.insert1+" medidas a ESTILOTSCMEDIDA y "+data.insert2+" registros de detalle a ESTILOTSCMEDIDADETALLE del estilo "+esttsc+"!");
								}else{
									alert(data.detail);
								}
								if (pos_send==ar_esttsc.length-1) {
									window.location.reload();
								}else{
									pos_send++;
									info_to_save(ar_esttsc[pos_send]);
								}
							}
						});
					}
				}
			});
		}
		$("#inputFile").change(function(evt){
			var f = evt.target.files[0]; 
	        if (f){
		        var r = new FileReader();
		        r.onload = function(e){
		        	var delimiter=counter_delimiter(e.target.result);
		            var ar1=e.target.result.split("\n");
		            for (var i = 0; i < ar1.length; i++) {
		            	var ar_aux=ar1[i].split(delimiter);
		            	if(ar_aux[0].indexOf("COD.")>=0){
		            		pos_start_medida=i;
		            	}
		            }
		            //console.log(pos_start_medida);
		            var search_enter=false;
		            var num_veces_anular=2;
		            //BUSCAR SI EXISTE UN SALTO ERRONEO DE LINEA
		            var pos_enter=e.target.result.indexOf("TOL\n(-)");
		            if (pos_enter>=0) {
						search_enter=true;
		            }
		            //INICIO - ENCONTRAR SALTO DE LINEA EN TOLERANCIA
		            var cont_enter=0;
		            var new_text="";
		            var val_no_enter=false;
		            var cont_no_enter=0;
		            for (var i = 0; i < e.target.result.length; i++) {
		            	if(e.target.result[i]=="\n"){
		            		cont_enter++;
		            		if(pos_start_medida<cont_enter && val_no_enter==false && search_enter==true){
			            		new_text+=" ";
			            		cont_no_enter++;
			            		if (cont_no_enter==num_veces_anular) {
			            			val_no_enter=true;
			            		}
			            	}else{
		            			new_text+=e.target.result[i];
			            	}
		            	}else{
		            		new_text+=e.target.result[i];
		            	}
		            }
		            //FIN - ENCONTRAR SALTO DE LINEA EN TOLERANCIA
		            var ar_pos=[];
		            var ar1=new_text.split("\n");
		            var ar2=ar1[pos_start_medida].split(delimiter);
		            for (var i = 0; i < ar2.length; i++) {
		            	//console.log(ar2[i].trimStart().trimEnd());
		            	if(ar2[i].trimStart().trimEnd()!=""){
		            		ar_pos.push(i);
		            	}
		            }
		            var validador=false;
		            var i=0;
		            medida="PU";
		            var pos_est=10000;
		            largmanga=0;
		            var val_tam_text=false;
		            while(validador==false && i<pos_start_medida){
		            	var ar_aux=ar1[i].split(delimiter);

	            		var val_med_2=false;
	            		var k=0;
		            	while (k < ar_aux.length && val_med_2==false) {
		            		if((ar_aux[k].toUpperCase()).indexOf("MEDIDA :")>=0){
		            			var l=k+1;
		            			var val_med_3=false;
		            			while(val_med_3==false && l<ar_aux.length){
		            				if (ar_aux[l]!="") {
		            					val_med_3=true;
		            					val_med_2=true;
		            					//validador=true;
		            					medida=ar_aux[l].substr(0,2);
		            				}
		            				l++;
		            			}
		            		}

			            	if((ar_aux[k].toUpperCase()).indexOf("ESTILO PROPIO")>=0){
			            		var validador2=false;
			            		var j=k+1;
			            		while ( validador2==false && j< ar_aux.length) {
			            			if(ar_aux[j]!=""){
			            				if(j<pos_est){
			            					pos_est=j;
			            				}
										validador2=true;
			            			}
			            			j++;
			            		}
			            	}

			            	/*
							//HILO
							if((ar_aux[k].toUpperCase()).indexOf("HILO")>=0){
			            		var validador2=false;
			            		var j=k+1;
			            		while ( validador2==false && j< ar_aux.length) {
			            			if(ar_aux[j]!=""){
										hilo = ar_aux[j].replace("%","");
										document.getElementById("hilo").innerText =hilo;
										validador2=true;
			            			}
			            			j++;
			            		}
			            	}

							//TRAVEZ
							if((ar_aux[k].toUpperCase()).indexOf("TRAVEZ")>=0){
			            		var validador2=false;
			            		var j=k+1;
			            		while ( validador2==false && j< ar_aux.length) {
			            			if(ar_aux[j]!=""){
										travez = ar_aux[j].replace("%","");
										document.getElementById("travez").innerText = travez;
										validador2=true;
			            			}
			            			j++;
			            		}
			            	}

							//LARG.DE MANGA
							if((ar_aux[k].toUpperCase()).indexOf("LARG.DE MANGA")>=0){
			            		var validador2=false;
			            		var j=k+1;
			            		while ( validador2==false && j< ar_aux.length) {
			            			if(ar_aux[j]!=""){
										largmanga = ar_aux[j].replace("%","");
										validador2=true;
			            			}
			            			j++;
			            		}
			            	}*/

		            		k++;
		            	}
		            	i++;
		            }
		            /*
		            if (largmanga==0) {
		            	//alert("No se encontro la etiqueta 'LARG.DE MANGA'. Se usará largmanga=0!");
		            	alert("No lleva LARGO DE MANGA!");
		            	$("#content-largmanga").remove();
		            }else{
						document.getElementById("largmanga").innerText =largmanga;
					}*/

		            var i=0;
		            while(validador==false && i<pos_start_medida){
		            	var ar_aux=ar1[i].split(delimiter);
	            		var k=0;
		            	while (k < ar_aux.length) {
			            	if((ar_aux[k].toUpperCase()).indexOf("ESTILO PROPIO")>=0){
			            		var validador2=false;
			            		var j=pos_est;
			            		while ( ar_aux[j]!="" && j< ar_aux.length) {
		            				if(esttsc==""){
										esttsc=ar_aux[j];
									}else{
										esttsc+=";"+ar_aux[j];
									}
			            			j++;
			            		}
			            	}
		            		k++;
		            	}
		            	i++;
		            }
		            medida=medida.toUpperCase();
		            console.log(esttsc);
		            console.log(medida);
		            if (esttsc=="") {
		            	alert("No se encontro el ESTILO TSC. Revisar el archivo CSV!");
		            }else{		
			            ar_send=[];
			            for (var i = pos_start_medida; i < ar1.length; i++) {
			            	var ar_aux=ar1[i].split(delimiter);
			            	var aux=[];
			            	for (var j = 0; j < ar_pos.length; j++) {
			            		//aux.push(convert_values(process_text(ar_aux[ar_pos[j]])));
			            		aux.push(process_text(ar_aux[ar_pos[j]]));
			            	}

			            	if(aux[0]!=""){
				            	ar_send.push(aux);
				            	//Validar tamaño de textos
			            		//console.log(ar_aux[1]+" - "+ar_aux[1].length);
			            		if(ar_aux[1].length>tam_max){
									val_tam_text=true;
			            		}
				            }
			            }
			            console.log(ar_send);            	
			            if (val_tam_text) {
			            	alert("Las descripciones no deben tener mas de "+tam_max+" caracteres!");
			            }else{
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
				            	//ar_send[i]
				            }
		            		$("#data-header").empty();
		            		$("#data-header").append(html1);
		            		$("#data-preview").empty();
		            		$("#data-preview").append(html2);
				            //NOMBRE DEL ARCHIVO
				            var ar_est=esttsc.split(";");
				            var new_ar="";
				            for (var i = 0; i < ar_est.length; i++) {
				            	console.log(ar_est[i]);
				            	var auxest="";
				            	for (var j = 0; j < ar_est[i].length; j++) {
				            		if (parseInt(ar_est[i][j]) || ar_est[i][j]=="0") {
				            			auxest+=ar_est[i][j];
				            		}
				            	}
				            	if(auxest!=""){
					            	auxest=auxest.trimStart().trimEnd().padStart(5,"0");
					            	if (new_ar!="") {
					            		new_ar+=";"+auxest;
					            	}else{
					            		new_ar+=auxest;
					            	}
					            }
				            }
				            //esttsc=esttsc.trimStart().trimEnd().padStart(5,"0");
				            esttsc=new_ar;
				            $("#idesttsc").text(esttsc);
				            $("#bodytbl").css("width",ar_send[0].length*110+"px");
				            $("#show_preview").css("display","block");
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
		function convert_values(value){
			var ar=value.split(".");
			if(parseInt(ar[0]) || (ar[0]=="0" && parseInt(ar[1]))){
				var ent=ar[0];
				var dec=parseFloat("0."+ar[1]);
				var frac="";
				if (Number.isInteger(dec*2)) {
					frac=parseInt(dec*2)+"/2";
				}else{
					if (Number.isInteger(dec*4)) {
						frac=parseInt(dec*4)+"/4";
					}else{
						if (Number.isInteger(dec*8)) {
							frac=parseInt(dec*8)+"/8";
						}else{
							frac=parseInt(dec*16+1)+"/16";
						}
					}
				}
				if (ent=="0") {
					return frac;
				}else{
					return ent + " "+ frac;
				}
			}else{
				return value;
			}
		}
	</script>
</body>
</html>