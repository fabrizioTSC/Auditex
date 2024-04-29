var codtad;
var numvez;
var parte;
let canaudter=0;
function cargarDatos(codfic,codusu){
	document.getElementById("idcodfic").innerHTML=codfic;
	codficha=codfic;
	$.ajax({
		type:"POST",
		data:{
			codfic:codfic,
			codusu:codusu
		},
		url:"config/getDetalleFichaACH.php",
		success:function(data){
			console.log(data);
			if (data.close) {
				alert("La ficha ya fue terminada!");
				window.history.back();
			}
			if (data.state) {
				codtad=data.detficaud.codtad;
				numvez=data.detficaud.numvez;
				parte=data.detficaud.parte;
				document.getElementById("idfecha").innerHTML=data.detficaud.feciniaud;
				//let percent=parseInt(data.ficha.CANAUDTER)/parseInt(data.ficha.CANTIDAD);
				//canaudter=parseInt(data.ficha.CANAUDTER);
				canaudter=parseInt(data.ficha.CANTIDAD);
				//document.getElementById("idcantidad").innerHTML=data.ficha.CANAUDTER+" de "+data.ficha.CANTIDAD;
				document.getElementById("idcantidad").innerHTML=data.ficha.CANTIDAD;
				document.getElementById("idaudfincos").innerHTML='<a href="../auditex/ConsultarEditarAuditoria.php?codfic='+codfic+'">Aud. Final de Costura</a>';

				//document.getElementById("idpedcol").innerHTML=val_u(data.partida.pedido)+' - '+val_u(data.partida.color);
				document.getElementById("idpedido").innerHTML=val_u(data.partida.pedido);
				document.getElementById("idesttsc").innerHTML=val_u(data.partida.esttsc);
				document.getElementById("idestcli").innerHTML=val_u(data.partida.estcli);
				document.getElementById("idnomtal").innerHTML=val_u(data.partida.tallercos);
				document.getElementById("idarticulo").innerHTML=val_u(data.partida.articulo);
				if (data.partida.tallercor!=null) {
					document.getElementById("idnomtalcor").innerHTML=
					'<a href="../AuditoriaFinalCorte/ConsultarEditarAuditoria.php?codfic='+
					codfic+'">'+data.partida.tallercor+'</a>';
				}
				if (data.partida.partida!=null) {
					document.getElementById("idpartida").innerHTML=
					'<a href="../Auditoriatela/VerAuditoriaTela.php?partida='+data.partida.partida+
					'&codtel='+data.partida.codtel+'&codprv='+data.partida.codprv+
					'&numvez='+data.partida.numvez+'&parte='+data.partida.parte+
					'&codtad='+data.partida.codtad+'">'+data.partida.partida+'</a>';
				}		
				
				if (data.partida.color!=null) {
					document.getElementById("idcolor").innerHTML=data.partida.color;
				}

				let html='';
				for (var i = 0; i < data.detalle_humedad.length; i++) {
					html+=
					'<tr>'+
						'<td><input type="number" value="'+data.detalle_humedad[i].IDREG+'" disabled></td>'+
						'<td><input class="class-humedad" data-idreg="'+data.detalle_humedad[i].IDREG+'" type="number" value="'+data.detalle_humedad[i].HUMEDAD+'" min-value="0"></td>'+
					'</tr>';
				}
				document.getElementById("table-humedad").innerHTML=html;
				document.getElementById("idTemAmb").value=data.TEMAMB;
				document.getElementById("idHumAmb").value=data.HUMAMB;
				document.getElementById("idHumMax").value=data.HUMMAX;
				document.getElementById("idResultado").innerHTML=processResultado(data.RESULTADO);
				document.getElementById("idPromedio").value=data.HUMPRO;
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}

function processResultado(text){
	if (text=="A") {
		return "Aprobado";
	}else{
		if (text=="R") {
			return "Rechazado";
		}else{
			return "";
		}
	}
}

$(document).ready(function(){
	$("#iddefecto").keyup(function(){
		coddef_var="";
		desdef_var="";
		$("#tbldefectos").empty();
		var html="";
		var busqueda=document.getElementById("iddefecto").value;
		for (var i = 0; i < listaDefectos.length; i++) {
			if ((listaDefectos[i].desdef.toUpperCase()+
				listaDefectos[i].coddef.toUpperCase()+
				listaDefectos[i].coddefaux.toUpperCase()
				).indexOf(busqueda.toUpperCase())>=0) {
				html+='<div class="defecto" '+
				'onclick="addDefecto(\''+listaDefectos[i].desdef+'\',\''+listaDefectos[i].coddefaux+'\','+listaDefectos[i].coddef+')">'
				+listaDefectos[i].desdef+' ('+listaDefectos[i].coddefaux+')</div>';
			}
		}
		$("#tbldefectos").append(html);
	});
});

let desdef_var="";
let coddefaux_var="";
let coddef_var="";

function guardar_humedad(){
	let ar=document.getElementsByClassName("class-humedad");
	let ar_send=[];
	for (var i = 0; i < ar.length; i++) {
		let aux=[];
		aux.push(ar[i].dataset.idreg);
		aux.push(Math.round(parseFloat(ar[i].value)*100));
		ar_send.push(aux);
	}
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codfic:codficha,
			codtad:codtad,
			numvez:numvez,
			parte:parte,
			array:ar_send
		},
		url:"config/saveDetHumACH.php",
		success:function(data){
			if(!data.state){
				alert(data.detail);
			}else{				
				document.getElementById("idResultado").innerHTML=processResultado(data.RESULTADO);
				document.getElementById("idPromedio").value=data.HUMPRO;
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}

function terminar_auditora(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codfic:codficha,
			codtad:codtad,
			numvez:numvez,
			parte:parte
		},
		url:"config/endFichaACH.php",
		success:function(data){
			console.log(data);
			if (!data.state) {
				alert(data.detail);
			}else{
				window.location.href="main.php";
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}

function val_u(text){
	if (text==undefined || text==null) {
		return "-";
	}else{
		return text;
	}
}

function guardar_datos_cabecera(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codfic:codficha,
			codtad:codtad,
			numvez:numvez,
			parte:parte,
			temamb:Math.round(parseFloat(document.getElementById("idTemAmb").value)*100),
			humamb:Math.round(parseFloat(document.getElementById("idHumAmb").value)*100)
		},
		url:"config/saveDetTemHumACH.php",
		success:function(data){
			if(!data.state){
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}