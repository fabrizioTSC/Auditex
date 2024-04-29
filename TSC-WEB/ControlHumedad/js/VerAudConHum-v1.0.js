var codtad;
let canaudter=0;
function cargarDatos(codfic,codusu){
	document.getElementById("idcodfic").innerHTML=codfic;
	codficha=codfic;
	$.ajax({
		type:"POST",
		data:{
			codfic:codfic,
			numvez:numvez,
			parte:parte,
			codusu:codusu
		},
		url:"config/getDetalleFichaACHCon.php",
		success:function(data){
			console.log(data);
			if (data.state) {
				codtad=data.detficaud.codtad;
				numvez=data.detficaud.numvez;
				parte=data.detficaud.parte;
				document.getElementById("idfecha").innerHTML=data.detficaud.feciniaud;
				let percent=parseInt(data.ficha.CANAUDTER)/parseInt(data.ficha.CANTIDAD);
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

function decrease_deftal(obj,coddef,codtal,ubidef){
}

function add_clasi_total(dom){
}

function add_total(){
	let ar=document.getElementsByClassName("ipt-tal");
	let suma=0;
	for (var i = 0; i < ar.length; i++) {
		suma+=parseInt(ar[i].value);
	}
	$("#tot-tal").text(suma);
}

function guardar_tallas(){
	let ar=document.getElementsByClassName("ipt-tal");
	let ar_send=[];
	let cont=0;
	for (var i = 0; i < ar.length; i++) {
		if (parseInt(ar[i].dataset.maxvalue)<parseInt(ar[i].value)) {
			cont++;
		}
		let aux=[];
		aux.push(ar[i].dataset.codtal);
		aux.push(ar[i].value);
		aux.push($("#candef-"+ar[i].dataset.codtal).text());
		ar_send.push(aux);
	}
	if (cont!=0) {
		alert("Los valores a auditar no deben ser mayores a la cantidad de la talla!");
	}else{
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codfic:document.getElementById("idcodfic").innerHTML,
				numvez:numvez,
				parte:parte,
				codtad:codtad,
				array:ar_send
			},
			url:"config/saveTallasAPNC.php",
			success:function(data){
				console.log(data);
				if (!data.state) {
					alert(data.detail);
				}
				$(".panelCarga").fadeOut(100);
			}
		});
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
function addDefecto(desdef,coddefaux,coddef){
	coddef_var=coddef;
	coddefaux_var=coddefaux;
	desdef_var=desdef;
	$("#iddefecto").val(desdef);
}

function agregar_talla(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codfic:document.getElementById("idcodfic").innerHTML,
			numvez:numvez,
			parte:parte,
			codtad:codtad,
			coddef:coddef_var,
			codtal:$("#selecttallas").val(),
			ubicacion:$("#idubicacion").val()
		},
		url:"config/saveFichaDetalleAPNC.php",
		success:function(data){
			console.log(data);
			if (!data.state) {
				alert(data.detail);
			}else{
				let html='';
				html+=
				'<tr>'+
					'<td class="classsave" data-coddef="'+coddef_var+
					' data-codtal="'+$("#selecttallas").val()+' data-ubidef="'+$("#idubicacion").val()+'">'+document.getElementById("selecttallas").getElementsByTagName("option")[document.getElementById("selecttallas").selectedIndex].innerHTML+'</td>'+
					'<td><div class="div-inline">'+
						'<span class="addval canini2" id="canini2-'+
						coddef_var+'-'+$("#selecttallas").val()+'-'+
						$("#idubicacion").val()+'" data-obj="canini2">0</span>'+
						'<button onclick="decrease_deftal(\'canini2\',\''+coddef_var+'\',\''+
						$("#selecttallas").val()+'\',\''+$("#idubicacion").val()+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
					'</div></td>'+
					'<td><div class="div-inline">'+
						'<span class="addval canini3" id="canini3-'+
						coddef_var+'-'+$("#selecttallas").val()+'-'+
						$("#idubicacion").val()+'" data-obj="canini3">0</span>'+
						'<button onclick="decrease_deftal(\'canini3\',\''+coddef_var+'\',\''+
						$("#selecttallas").val()+'\',\''+$("#idubicacion").val()+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
					'</div></td>'+
					'<td><div class="div-inline">'+
						'<span class="addval canini4" id="canini4-'+
						coddef_var+'-'+$("#selecttallas").val()+'-'+
						$("#idubicacion").val()+'" data-obj="canini4">0</span>'+
						'<button onclick="decrease_deftal(\'canini4\',\''+coddef_var+'\',\''+
						$("#selecttallas").val()+'\',\''+$("#idubicacion").val()+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
					'</div></td>'+
					'<td><div class="div-inline">'+
						'<span class="addval canfin1" id="canfin1-'+
						coddef_var+'-'+$("#selecttallas").val()+'-'+
						$("#idubicacion").val()+'" data-obj="canfin1">0</span>'+
						'<button onclick="decrease_deftal(\'canfin1\',\''+coddef_var+'\',\''+
						$("#selecttallas").val()+'\',\''+$("#idubicacion").val()+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
					'</div></td>'+
					'<td><div class="div-inline">'+
						'<span class="addval canfin2" id="canfin2-'+
						coddef_var+'-'+$("#selecttallas").val()+'-'+
						$("#idubicacion").val()+'" data-obj="canfin2">0</span>'+
						'<button onclick="decrease_deftal(\'canfin2\',\''+coddef_var+'\',\''+
						$("#selecttallas").val()+'\',\''+$("#idubicacion").val()+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
					'</div></td>'+
					'<td><div class="div-inline">'+
						'<span class="addval canfin3" id="canfin3-'+
						coddef_var+'-'+$("#selecttallas").val()+'-'+
						$("#idubicacion").val()+'" data-obj="canfin3">0</span>'+
						'<button onclick="decrease_deftal(\'canfin3\',\''+coddef_var+'\',\''+
						$("#selecttallas").val()+'\',\''+$("#idubicacion").val()+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
					'</div></td>'+
					'<td><div class="div-inline">'+
						'<span class="addval canfin4" id="canfin4-'+
						coddef_var+'-'+$("#selecttallas").val()+'-'+
						$("#idubicacion").val()+'" data-obj="canfin4">0</span>'+
						'<button onclick="decrease_deftal(\'canfin4\',\''+coddef_var+'\',\''+
						$("#selecttallas").val()+'\',\''+$("#idubicacion").val()+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
					'</div></td>'+
					'<td>'+coddefaux_var+'</td>'+
					'<td>'+desdef_var+'</td>'+
					'<td>'+$("#idubicacion").val()+'</td>'+
					'<td class="cell-input"><input class="classobs" id="obs-'+
					coddef_var+'-'+$("#selecttallas").val()+'-'+
					$("#idubicacion").val()+'" value=""/></td>'+
				'</tr>';
				let ar=document.getElementById("tbldeftal").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
				let html2='';
				for (var i = 0; i < ar.length; i++) {
					if (i==ar.length-1) {
						html2+=html;
					}
					html2+='<tr>'+ar[i].innerHTML+'</tr>';
				}
				$("#tbldeftal").empty();
				$("#tbldeftal").append(html2);
				html=
					'<script>'+
						'$(".addval").click(function(){'+
							'add_clasi_total(this);'+
						'});';
				$("#addscripts").empty();
				$("#addscripts").append(html);
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}

function terminar_auditora(){
	let ar=document.getElementsByClassName("classobs");
	let ar_send=[];
	for (var i = 0; i < ar.length; i++) {
		let ar_id=ar[i].id.split("-");
		let aux=[];
		aux.push(ar_id[1]);//def
		aux.push(ar_id[2]);//tal
		aux.push(ar_id[3]);//ubi
		aux.push(ar[i].value);//obs
		ar_send.push(aux);
	}
	console.log(ar_send);
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codfic:document.getElementById("idcodfic").innerHTML,
			numvez:numvez,
			parte:parte,
			codtad:codtad,
			array:ar_send
		},
		url:"config/endFichaAPNC.php",
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