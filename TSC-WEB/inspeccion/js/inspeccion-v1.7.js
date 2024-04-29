function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	while(string.indexOf('\'')>0){
		string=string.replace('\'','');
	}
	return string;
}

$(document).ready(function(){
	var winWid=(window.innerWidth-240)/2;
	$(".contentMsgInstant").css("left",winWid+"px");
	$.ajax({
		type:"POST",
		url:"config/searchFicha.php",
		data:{
			codfic:codfic,
			codtll:codtll
		},
		success:function(data){
			console.log(data);
			if(data.state==true){
				$("#idLinea").text(data.TALLER);
				$("#idColor").text(data.ficha.color);
				$("#idEstilo").text(data.ficha.estilo);
				$("#idTurno").text(turno);
				$("#idCliente").text(data.ficha.cliente);
				$("#idCodFic").text(codfic);
			}else{
				alert(data.detail);
			}
			$("#idresultFicha").css("display","block");
			$("#PlaceToSearch").css("display","none");
			$(".panelCarga").fadeOut(200);

			var heigthTblHeader=document.getElementsByClassName("bigitemTable")[0].offsetHeight;
			if (heigthTblHeader==66) {
				$("#tblToAnimate").css("max-height","calc(100vh - 131px)");
			}
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
	var iniV=0;
	var iniH=0;
	$("#tblToAnimate").scroll(function(){
		var heiTbl=parseInt(document.getElementsByClassName("contentTblInspec")[0].offsetHeight);
		var heiBtns=parseInt(document.getElementById("spaceToBtn").offsetHeight);

		if (heiTbl<heiBtns) {
			var scrollV=parseInt($("#tblToAnimate").scrollTop());		
			if (iniV!=scrollV) {
				if (scrollV!=0) {
					$("#headerDefectos").css("position","absolute");
					$("#headerDefectos").css("top",scrollV+"px");
					$(".spaceToHide").css("display","none");
					$(".spaceToHideF").css("display","none");
				}else{
					$("#headerDefectos").css("position","relative");
					$("#headerDefectos").css("top","0px");
					$(".spaceToHideF").css("display","flex");
					$(".spaceToHide").css("display","flex");
				}
			}
		}
		
		var widTbl=parseInt(document.getElementsByClassName("placeDefectos")[0].offsetWidth)+
			parseInt(document.getElementsByClassName("placeTotales")[0].offsetWidth);
		var widWindow=parseInt(window.innerWidth);

		if (widTbl>widWindow) {
			var scrollH=parseInt($("#tblToAnimate").scrollLeft());
			if (scrollH!=0) {
				$("#freeOperations").css("position","absolute");
				$("#freeOperations").css("left",scrollH+"px");
			}else{
				$("#freeOperations").css("position","relative");
				$("#freeOperations").css("left","0px");
			}
		}
		
		iniV=scrollV;
		iniH=scrollH;
	});
	chargeOpeDef();
	$("#idDefectoSearch").keyup(function(){
		$(".resultDefectos").empty();
		var html="";
		var busqueda=document.getElementById("idDefectoSearch").value;
		for (var i = 0; i < listaDefectos.length; i++) {
			if ((listaDefectos[i].DESDEF.toUpperCase()).indexOf(busqueda.toUpperCase())>=0
				|| (listaDefectos[i].CODDEFAUX.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {
				html+=
				'<div class="linedetail" onclick="selectDefecto('+listaDefectos[i].CODDEF+',\''+formatText(listaDefectos[i].DESDEF)+'\')">'+
					listaDefectos[i].CODDEFAUX+' - '+listaDefectos[i].DESDEF+
				'</div>';
			}
		}
		$(".resultDefectos").append(html);
		coddef_var="";
	});
	$("#idOperacionSearch").keyup(function(){
		$(".resultOperaciones").empty();
		var html="";
		var busqueda=document.getElementById("idOperacionSearch").value;
		for (var i = 0; i < listaOperaciones.length; i++) {
			if ((listaOperaciones[i].DESOPE.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {
				html+=
				'<div class="linedetail" onclick="selectOperacion('+listaOperaciones[i].CODOPE+',\''+formatText(listaOperaciones[i].DESOPE)+'\')">'+
					listaOperaciones[i].DESOPE+
				'</div>';
			}
		}
		$(".resultOperaciones").append(html);
		codope_var="";
	});
	createSaver();
});

var listaDefectos;
var listaOperaciones;
function chargeOpeDef(){
	$.ajax({
		type:"POST",
		url:"config/getDefOpeIns.php",
		success:function(data){
			console.log(data);
			var html="";
			listaDefectos=data.defectos;
			for (var i = 0; i < data.defectos.length; i++) {
				html+=
				'<div class="linedetail" onclick="selectDefecto('+data.defectos[i].CODDEF+',\''+formatText(data.defectos[i].DESDEF)+'\')">'+
					data.defectos[i].CODDEFAUX+' - '+data.defectos[i].DESDEF+
				'</div>';
			}
			$(".resultDefectos").empty();
			$(".resultDefectos").append(html);

			html="";
			listaOperaciones=data.operaciones;
			for (var i = 0; i < data.operaciones.length; i++) {
				html+=
				'<div class="linedetail" onclick="selectOperacion('+data.operaciones[i].CODOPE+',\''+formatText(data.operaciones[i].DESOPE)+'\')">'+
					data.operaciones[i].DESOPE+
				'</div>';
			}
			$(".resultOperaciones").empty();
			$(".resultOperaciones").append(html);
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
}

var codope_var;
var desope_var;
function selectOperacion(codope,desope){
	codope_var=codope;
	desope_var=desope;
	$("#idOperacionSearch").val(desope);
}

function selectOperacionAdd(){
	if (codope_var=="") {
		alert("Seleccione una operación de la lista");
	}else{
		if ($("#ope"+codope_var)[0]) {
			alert("La operación esta en la tabla!");
		}else{
			$(".panelCarga").fadeIn(200);

			var style="padding: 2px 5px 8px 5px;font-size:10px;";
			if (desope_var.length<16) {
				style="";
			}
			var html=
				'<div class="sameline classOperacion" data-codope="'+codope_var+'">'+
					'<div class="itemsFinalTbl" style="width: 60px;">'+codope_var+'</div>'+
					'<div class="itemsFinalTbl alignLeft maxHeight" style="width: 120px;'+style+'">'+desope_var+'</div>'+
				'</div>';
			$("#spaceToAddOpe").append(html);

			var contentSpaces=document.getElementById("spaceToBtn").getElementsByClassName("spaceFlex");
			for (var i = 0; i < contentSpaces.length; i++) {
				var verticalGrown =contentSpaces[i].getElementsByClassName("verticalGrown");
				for (var j = 0; j < verticalGrown.length; j++) {
					var idDef=verticalGrown[j].children[1].id.replace("def","");
					var div=document.createElement("div");
    				div.setAttribute('class', "itemsFinalTbl maxHeight counterBtn");
    				div.style.width="88px";
					html=
						'<div class="divBtnsAddMinus" data-def="'+codope_var+'"'+
							'data-ope="'+codope_var+'"'+
							// 'onclick="addValue('+codope_var+','+idDef+')"'+
							`onclick="addValue('${codope_var}',${idDef})"`  +

							'id="OPE'+codope_var+'DEF'+idDef+'">0</div>'+
						'<div class="buttonminus" onclick="desValue('+codope_var+','+idDef+')"><i class="fa fa-minus" aria-hidden="true"></i></div>';
					div.innerHTML=html;
					verticalGrown[j].children[0].appendChild(div);
				}
			}
			html='<div class="itemsFinalTbl itemFinalTotal" id="ope'+codope_var+'">0</div>';
			$(".spaceToAddBtns3").append(html)
			showMsg("Operación agregada!");

			$(".panelCarga").fadeOut(200);
			closeModal("modalOperaciones");
		}
	}
}

var coddef_var;
var desdef_var;
function selectDefecto(coddef,desdef){
	coddef_var=coddef;
	desdef_var=desdef;
	$("#idDefectoSearch").val(desdef);
}

function selectDefectoAdd(){
	if (coddef_var=="") {
		alert("Seleccione un defecto de la lista");
	}else{
		if ($("#def"+coddef_var)[0]) {
			alert("El defecto esta en la tabla!");
		}else{
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:"POST",
				url:"config/getInfoDefecto.php",
				data:{
					coddef:coddef_var
				},
				success:function(data){
					console.log(data);
					var arrayOperaciones=document.getElementsByClassName("classOperacion");
					if ($(".class"+data.defecto.CODFAM)[0]) {					
						var style="padding: 2px 5px 8px 5px;font-size:10px;";
						if (data.defecto.DESDEF.length<16) {
							style="";
						}
						var html=
							'<div class="verticalGrown">'+
								'<div class="itemsFinalTbl" style="width: 88px;">'+data.defecto.CODDEFAUX+'</div>'+
								'<div class="itemsFinalTbl maxHeight" style="width: 88px;'+style+'">'+data.defecto.DESDEF+'</div>'+
							'</div>';
						$(".contentFam"+data.defecto.CODFAM).append(html);

						var btns='';
						for (var i = 0; i < arrayOperaciones.length; i++) {
							btns+=
								'<div class="itemsFinalTbl maxHeight counterBtn" style="width: 88px;">'+
									'<div class="divBtnsAddMinus" data-def="'+data.defecto.CODDEF+'"'+
										'data-ope="'+arrayOperaciones[i].dataset.codope+'"'+
										// 'onclick="addValue("'+arrayOperaciones[i].dataset.codope+'",'+data.defecto.CODDEF+')"'+
										`onclick="addValue('${arrayOperaciones[i].dataset.codope}',${data.defecto.CODDEF})"`  +

										'id="OPE'+arrayOperaciones[i].dataset.codope+'DEF'+data.defecto.CODDEF+'">0</div>'+
									'<div class="buttonminus" onclick="desValue('+arrayOperaciones[i].dataset.codope+','+data.defecto.CODDEF+')"><i class="fa fa-minus" aria-hidden="true"></i></div>'+
								'</div>';
						}

						var html=
							'<div class="verticalGrown">'+
								'<div class="spaceToAddBtnPart2">'+
									btns+
								'</div>'+
								'<div class="itemsFinalTbl" style="width: 88px;" id="def'+data.defecto.CODDEF+'">0</div>'+
							'</div>';
						$(".classBtn"+data.defecto.CODFAM).append(html);
					}else{					
						var style="padding: 2px 5px 8px 5px;font-size:10px;";
						if (data.defecto.DESDEF.length<16) {
							style="";
						}
						var html=
							'<div class="class'+data.defecto.CODFAM+'">'+
								'<div class="itemsFinalTbl" style="height: 29px;">'+data.defecto.DSCFAMILIA+'</div>'+
								'<div class="sameline contentFam'+data.defecto.CODFAM+'">'+
									'<div class="verticalGrown">'+
										'<div class="itemsFinalTbl" style="width: 88px;">'+data.defecto.CODDEFAUX+'</div>'+
										'<div class="itemsFinalTbl maxHeight" style="width: 88px;'+style+'">'+data.defecto.DESDEF+'</div>'+
									'</div>'+
								'</div>'+
							'</div>';
						$("#headerDefectos").append(html);

						var btns='';
						for (var i = 0; i < arrayOperaciones.length; i++) {
							btns+=
								'<div class="itemsFinalTbl maxHeight counterBtn" style="width: 88px;">'+
									'<div class="divBtnsAddMinus" data-def="'+data.defecto.CODDEF+'"'+
										'data-ope="'+arrayOperaciones[i].dataset.codope+'"'+
										// 'onclick="addValue("'+arrayOperaciones[i].dataset.codope+'",'+data.defecto.CODDEF+')"'+
										`onclick="addValue('${arrayOperaciones[i].dataset.codope}',${data.defecto.CODDEF})"`  +

										'id="OPE'+arrayOperaciones[i].dataset.codope+'DEF'+data.defecto.CODDEF+'">0</div>'+
									'<div class="buttonminus" onclick="desValue('+arrayOperaciones[i].dataset.codope+','+data.defecto.CODDEF+')"><i class="fa fa-minus" aria-hidden="true"></i></div>'+
								'</div>';
						}

						var html=
							'<div class="spaceFlex classBtn'+data.defecto.CODFAM+'">'+
								'<div class="verticalGrown">'+
									'<div class="spaceToAddBtnPart2">'+
										btns+
									'</div>'+
									'<div class="itemsFinalTbl" style="width: 88px;" id="def'+data.defecto.CODDEF+'">0</div>'+
								'</div>'+
							'</div>';
						$("#spaceToBtn").append(html);
					}
					$(".panelCarga").fadeOut(200);
					showMsg("Defecto agregado en "+data.defecto.DSCFAMILIA+"!");
					closeModal("modalDefectos");
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
		}
	}
}

function hideDetalle(){
	if ($("#detailInspeccion").css("display")=="block") {
		$("#detailInspeccion").fadeOut(200);
		$("#btnHideDetalle").text("Mostrar detalle");
		$("#tblToAnimate").css("max-height","calc(100vh - 103px)");
	}else{
		$("#detailInspeccion").fadeIn(200);
		$("#btnHideDetalle").text("Ocultar detalle");
		var heigthTblHeader=document.getElementsByClassName("bigitemTable")[0].offsetHeight;
		if (heigthTblHeader==66) {
			$("#tblToAnimate").css("max-height","calc(100vh - 131px)");
		}else{
			$("#tblToAnimate").css("max-height","calc(100vh - 145px)");			
		}
	}
}

function addValue(codope,coddef){
	// console.log(codope,'codope',coddef,'coddef');
	var id="OPE"+codope+"DEF"+coddef;
	// console.log(id,'ID');
	var valueNum=parseInt($("#"+id).text());
	valueNum++;
	$("#"+id).empty();
	$("#"+id).append(valueNum);
	var defCont=parseInt($("#def"+coddef).text())+1;
	$("#def"+coddef).html(defCont);
	var opeCont=parseInt($("#ope"+codope).text())+1;
	$("#ope"+codope).html(opeCont);
	var total=parseInt($("#idTotalAll").text())+1;
	$("#idTotalAll").html(total);
}

var waitTap;
var tapCounter=0;
function desValue(codope,coddef){
	event.stopPropagation();
	tapCounter++;
	waitTap=setTimeout(function(){
		tapCounter=0;
	},1000);
	if (tapCounter==2) {
		clearInterval(waitTap);
		var id="OPE"+codope+"DEF"+coddef;
		var valueNum=parseInt($("#"+id).text());
		if (valueNum!=0) {
			valueNum--;
			$("#"+id).empty();
			$("#"+id).append(valueNum);
			var defCont=parseInt($("#def"+coddef).text());
			$("#def"+coddef).html(defCont-1);
			var opeCont=parseInt($("#ope"+codope).text());
			$("#ope"+codope).html(opeCont-1);
			var total=parseInt($("#idTotalAll").text());
			$("#idTotalAll").html(total-1);
			showMsg("Defecto quitado!");
		}
		tapCounter=0;
	}
}

function addTotalValue(id_val){
	var valueNum=parseInt($("#"+id_val).text());
	valueNum++;
	$("#"+id_val).empty();
	$("#"+id_val).append(valueNum);	
}

function desTotalValue(id_val){
	event.stopPropagation();
	tapCounter++;
	waitTap=setTimeout(function(){
		tapCounter=0;
	},1000);
	var valueNum=parseInt($("#"+id_val).text());
	if (tapCounter==2) {
		clearInterval(waitTap);
		if (valueNum!=0) {
			valueNum--;
			$("#"+id_val).empty();
			$("#"+id_val).append(valueNum);
		}
		tapCounter=0;
		showMsg("Prenda quitada!");
	}
}

function showMsg(msg){
	$(".contentMsgInstant").text(msg);
	$(".contentMsgInstant").fadeIn(100);
	setTimeout(function(){
		$(".contentMsgInstant").fadeOut(100);
	},2000);
}

function filterDefecto(){
	$(".modalDefectos").fadeIn(200);
}

function filterOperacion(){
	$(".modalOperaciones").fadeIn(200);	
}

function closeModal(class_name){
	$("."+class_name).fadeOut(200);	
	if (class_name=='modalDefectos') {
		$("#idDefectoSearch").val("");
		$("#idDefectoSearch").keyup();
	}else{
		if (class_name=='modalOperaciones') {
			$("#idOperacionSearch").val("");
			$("#idOperacionSearch").keyup();
		}
	}
}

var autosave;
function createSaver(){
	autosave=setInterval(function(){
		saveInspeccion();
	},30*1000);	
}

var arrayToSend=[];
function saveInspeccion(){
	clearInterval(autosave);
	var arrayDO=document.getElementsByClassName("divBtnsAddMinus");
	arrayToSend=[];
	var contTotalDef=0;
	for (var i = 0; i < arrayDO.length; i++) {
		var aux=[];
		if(arrayDO[i].innerHTML!="0"){
			aux.push(arrayDO[i].dataset.ope);
			aux.push(arrayDO[i].dataset.def);
			aux.push(arrayDO[i].innerHTML);
			contTotalDef=contTotalDef+parseInt(arrayDO[i].innerHTML);
			arrayToSend.push(aux);
		}
	}
	var manualTotal=parseInt($("#idNumPreDefNumNew").text());
	if (contTotalDef<manualTotal) {
		alert("Los defectos/operaciones son menores a los defectos totales!");
		createSaver();
	}else{
		if ((manualTotal==""||manualTotal==0)&&contTotalDef>0) {
			alert("Debe indicar la cantidad de prendas con defecto!");
			createSaver();
			return "No";
		}else{
			if (arrayToSend.length==0) {
				var val=confirm("Desea guardar sin defectos?");
				if (val==true) {
					confirmSaveInpeccion();
				}else{
					createSaver();
				}
			}else{
				confirmSaveInpeccion();
			}
		}
	}
}


function confirmSaveInpeccion(){
	if ($("#idcanpre").val()=="" || $("#idcanpre").val()=="0") {
		alert("Complete la cantidad de prendas!");
		$("#idcanpre").focus();
		createSaver();
	}else{
		if(codinscos_var=="0"){
			$(".panelCarga").fadeIn(200);
			$.ajax({
				url:"config/save_inspeccion.php",
				type:"POST",
				data:{
					codusu:codusu_var,
					codfic:codfic,
					turinscos:"1",
					canpre:$("#idcanpre").val(),
					canpredef:$("#idNumPreDefNumNew").text(),
					codtll:codtll,
					array:arrayToSend,
					codstl:$("#idEstilo").text()
				},
				success:function(data){
					console.log(data);
					if (data.exist==true) {
						var conf=confirm("Ya existe la inspección de la ficha para hoy y en el turno seleccionado. ¿Desea ir a la inspección para continuarla?");
						if (conf) {
							window.location.href="EditarInspeccionFicha.php?codinscos="+data.codinscos;
						}else{
							window.location.href="IniciarInspeccion.php";
						}
					}else{
						if (data.state==true) {
							$("#lblcantidadreturn").text("Cantidad: "+ data.cantidadreturn);
							showMsg(data.detail);
							codinscos_var=data.codinscos;
						}else{
							showMsg(data.detail);
						}
						createSaver();						
						$(".panelCarga").fadeOut(200);
					}
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
		}else{
			$(".panelCarga").fadeIn(200);
			$.ajax({
				url:"config/save_inspeccion.php",
				type:"POST",
				data:{
					codusu:codusu_var,
					codfic:codfic,
					turinscos:"1",
					canpre:$("#idcanpre").val(),
					canpredef:$("#idNumPreDefNumNew").text(),
					codtll:codtll,
					array:arrayToSend,
					codstl:$("#idEstilo").text(),
					codinscos:codinscos_var
				},
				success:function(data){
					console.log(data);
					showMsg(data.detail);
					/*
					if (data.state==true) {
						showMsg(data.detail);
						//location.href="main.php";
					}else{
						showMsg(data.detail);
					}*/
					createSaver();
					
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
		}
	}
}

function endInspeccion(){
	var confirm_var=confirm("Desea guardar los cambios?");
	var validate="";
	if (confirm_var==true) {
		validate=saveInspeccion();
	}
	if (validate!="No") {
		location.href="main.php";
	}
}