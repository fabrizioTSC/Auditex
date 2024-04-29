var codtad;
var numvez;
var parte;
let canaudter=0;
var sum_totdefped_v=0;
function cargarDatos(codfic,codusu){
	document.getElementById("idcodfic").innerHTML=codfic;
	codficha=codfic;
	$.ajax({
		type:"POST",
		data:{
			codfic:codfic,
			codusu:codusu/*,
			fichaauto:fichaauto*/
		},
		url:"config/getDetalleFichaAPNC.php",
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
				let percent=parseInt(data.ficha.CANAUDTER)/parseInt(data.ficha.CANTIDAD);
				//canaudter=parseInt(data.ficha.CANAUDTER);
				canaudter=parseInt(data.ficha.CANTIDAD);
				//document.getElementById("idcantidad").innerHTML=data.ficha.CANAUDTER+" de "+data.ficha.CANTIDAD;
				document.getElementById("idcantidad").innerHTML=data.ficha.CANTIDAD;
				//document.getElementById("idaudfincos").innerHTML='<a href="../auditex/ConsultarEditarAuditoria.php?codfic='+codfic+'">Aud. Final de Costura</a>';
				document.getElementById("idcanmue").value=data.detficaud.CANMUE;
				document.getElementById("idcanrecup").value=data.detficaud.CANRECUP;

				document.getElementById("idpedcol").innerHTML=val_u(data.partida.pedido)+' - '+val_u(data.partida.color);
				document.getElementById("idpedido").innerHTML=val_u(data.partida.pedido);
				document.getElementById("idesttsc").innerHTML=val_u(data.partida.esttsc);
				document.getElementById("idestcli").innerHTML=val_u(data.partida.estcli);
				//document.getElementById("idnomtal").innerHTML=val_u(data.partida.tallercos);
				document.getElementById("idnomtal").innerHTML='<a href="../auditex/ConsultarEditarAuditoria.php?codfic='+codfic+'">'+val_u(data.partida.tallercos)+'</a>';
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
					if (data.partida.pedido!=null) {
						if(data.porpedcol[0].can2!=""){
							document.getElementById("valadd-2").innerHTML="("+data.porpedcol[0].can2+"/"+data.porpedcol[0].canter+")";
							document.getElementById("valadd-3").innerHTML="("+data.porpedcol[0].can3+"/"+data.porpedcol[0].canter+")";
							document.getElementById("valadd-4").innerHTML="("+data.porpedcol[0].can4+"/"+data.porpedcol[0].canter+")";
							document.getElementById("pedcol-2").innerHTML=Math.round(parseFloat(data.porpedcol[0].por2)*10000)/100;
							document.getElementById("pedcol-3").innerHTML=Math.round(parseFloat(data.porpedcol[0].por3)*10000)/100;
							document.getElementById("pedcol-4").innerHTML=Math.round(parseFloat(data.porpedcol[0].por4)*10000)/100;
							document.getElementById("pedcol-tot").innerHTML=Math.round((
								parseFloat(data.porpedcol[0].por2)+
								parseFloat(data.porpedcol[0].por3)+
								parseFloat(data.porpedcol[0].por4)
							)*10000)/100;
						}
					}
				}
				var html1=
				'<table>'+
					'<tr>'+
						'<th>Talla</th>';
				var html2=
					'<tr>'+
						'<td>Cant. Ficha</td>';
				var html3=
					'<tr>'+
						'<td>Cant. Clas. Fic.</td>';
				var html4=
					'<tr>'+
						'<td>Cant. Acum. Fic</td>';
				var html5=
					'<tr>'+
						'<td>Cant. Ped.</td>';
				var html6=
					'<tr>'+
						'<td>Cant. Clas. Ped.</td>';
				let sum_value=0;
				let sum_totaud=0;
				let sum_totdef=0;
				let sum_totped=0;
				let sum_totdefped=0;				
				for (var i = 0; i < data.dettal.length; i++) {
					/*sum_totaud+=parseInt(data.dettal[i].CANAUD);
					sum_totdef+=parseInt(data.dettal[i].CANDEF);*/
					sum_totaud+=parseInt(data.dettal[i].CANDEF);
					sum_totdef+=parseInt(data.dettaltot[i].CANDEF);
					sum_totped+=parseInt(data.dettal[i].CANPED);
					sum_totdefped+=parseInt(data.dettal[i].CANDEFPED);
					let value=parseInt(percent*data.dettal[i].CANPRE);
					if (i!=data.dettal.length-1) {
						sum_value+=value;
					}else{
						//value=data.ficha.CANAUDTER-sum_value;
						value=data.ficha.CANTIDAD-sum_value;
					}
					html1+='<th>'+data.dettal[i].DESTAL+'</th>';
					html2+='<td><center>'+value+'</center></td>';
					/*html3+='<td class="cell-input"><input class="ipt-tal" data-maxvalue="'+value+'" data-codtal="'+
					data.dettal[i].CODTAL+'" type="text" value="'+data.dettal[i].CANAUD+'"/></td>';*/
					html3+='<td><center><span id="canclasi-'+data.dettal[i].CODTAL+'">'+data.dettal[i].CANDEF+'</span></center></td>';
					html4+='<td><center><span class="savedef" data-codtal="'+data.dettal[i].CODTAL+'" id="candef-'+data.dettal[i].CODTAL+'">'+data.dettaltot[i].CANDEF+'</span></center></td>';
					html5+='<td><center><span id="canped-'+data.dettal[i].CODTAL+'">'+data.dettal[i].CANPED+'</span></center></td>';
					html6+='<td><center><span id="candefped-'+data.dettal[i].CODTAL+'">'+data.dettal[i].CANDEFPED+'</span></center></td>';
				}
				html1+=
						'<th>Total</th>'+
					'<tr>';
				html2+=
						//'<td><center>'+data.ficha.CANAUDTER+'</center></td>'+
						'<td><center>'+data.ficha.CANTIDAD+'</center></td>'+
					'<tr>';
				html3+=
						'<td><center><span id="tot-tal">'+sum_totaud+'</span></center></td>'+
					'<tr>';
				html4+=
						'<td><center><span id="tot-def">'+sum_totdef+'</span></center></td>'+
					'<tr>';
				html5+=
						'<td><center><span id="tot-ped">'+sum_totped+'</span></center></td>'+
					'<tr>';
				html6+=
						'<td><center><span id="tot-defped">'+sum_totdefped+'</span></center></td>'+
					'<tr>';

				sum_totdefped_v=sum_totaud;

				html1+=html2+html3+html4+html5+html6+
				'</table>'+
				'<script>'+
					'$(".ipt-tal").blur(function(){'+
						'add_total();'+
					'});';
				$("#tbltalla").append(html1);

				listaDefectos=data.defectos;
				var html="";
				for (var i = 0; i < listaDefectos.length; i++) {
					html+='<div class="defecto" '+
					'onclick="addDefecto(\''+listaDefectos[i].desdef+'\',\''+listaDefectos[i].coddefaux+'\','+listaDefectos[i].coddef+')">'
					+listaDefectos[i].desdef+' ('+listaDefectos[i].coddefaux+')</div>';
				}
				$("#tbldefectos").append(html);

				html="";
				for (var i = 0; i < data.tallas.length; i++) {
					html+='<option value="'+data.tallas[i].CODTAL+'">'+data.tallas[i].DESTAL+'</option>';
				}
				$("#selecttallas").append(html);

				html='';
				for (var i = 0; i < data.ubidef.length; i++) {
					html+=
					'<option value="'+data.ubidef[i].CODUBIDEF+'">'+data.ubidef[i].CODUBIDEF+' - '+data.ubidef[i].DESUBIDEF+'</option>';
				}
				$("#idubicacion").append(html);

				document.getElementById("idcantot-det").innerHTML=sum_totdefped_v;
				document.getElementById("idprepri-det").innerHTML=parseInt(data.detficaud.CANMUE)-sum_totdefped_v;

				html='';
				let canini2=0;
				let canini3=0;
				let canini4=0;
				let canfin1=0;
				let canfin2=0;
				let canfin3=0;
				let canfin4=0;
				let sumcanfin1=0;
				let sumcanfin2=0;
				let sumcanfin3=0;
				let sumcanfin4=0;
				for (var i = 0; i < data.detfictal.length; i++) {
					canini2+=parseInt(data.detfictal[i].CANINI2);
					canini3+=parseInt(data.detfictal[i].CANINI3);
					canini4+=parseInt(data.detfictal[i].CANINI4);
					canfin1+=parseInt(data.detfictal[i].CANFIN1);
					canfin2+=parseInt(data.detfictal[i].CANFIN2);
					canfin3+=parseInt(data.detfictal[i].CANFIN3);
					canfin4+=parseInt(data.detfictal[i].CANFIN4);
					sumcanfin1+=parseInt(data.detfictal[i].CANFIN1);
					sumcanfin2+=parseInt(data.detfictal[i].CANFIN2);
					sumcanfin3+=parseInt(data.detfictal[i].CANFIN3);
					sumcanfin4+=parseInt(data.detfictal[i].CANFIN4);
					html+=
					'<tr>'+
						'<td class="classsave" data-coddef="'+data.detfictal[i].CODDEF+
						' data-codtal="'+data.detfictal[i].CODTAL+' data-ubidef="'+data.detfictal[i].UBIDEF+'">'+data.detfictal[i].DESTAL+'</td>'+
						/*'<td><div class="div-inline">'+
							'<span class="addval canini2" id="canini2-'+
							data.detfictal[i].CODDEF+'-'+data.detfictal[i].CODTAL+'-'+
							data.detfictal[i].UBIDEF+'" data-obj="canini2">'+data.detfictal[i].CANINI2+'</span>'+
							'<button onclick="decrease_deftal(\'canini2\',\''+data.detfictal[i].CODDEF+'\',\''+
							data.detfictal[i].CODTAL+'\',\''+data.detfictal[i].UBIDEF+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
						'</div></td>'+
						'<td><div class="div-inline">'+
							'<span class="addval canini3" id="canini3-'+
							data.detfictal[i].CODDEF+'-'+data.detfictal[i].CODTAL+'-'+
							data.detfictal[i].UBIDEF+'" data-obj="canini3">'+data.detfictal[i].CANINI3+'</span>'+
							'<button onclick="decrease_deftal(\'canini3\',\''+data.detfictal[i].CODDEF+'\',\''+
							data.detfictal[i].CODTAL+'\',\''+data.detfictal[i].UBIDEF+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
						'</div></td>'+
						'<td><div class="div-inline">'+
							'<span class="addval canini4" id="canini4-'+
							data.detfictal[i].CODDEF+'-'+data.detfictal[i].CODTAL+'-'+
							data.detfictal[i].UBIDEF+'" data-obj="canini4">'+data.detfictal[i].CANINI4+'</span>'+
							'<button onclick="decrease_deftal(\'canini4\',\''+data.detfictal[i].CODDEF+'\',\''+
							data.detfictal[i].CODTAL+'\',\''+data.detfictal[i].UBIDEF+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
						'</div></td>'+
						'<td><div class="div-inline">'+
							'<span class="addval canfin1" id="canfin1-'+
							data.detfictal[i].CODDEF+'-'+data.detfictal[i].CODTAL+'-'+
							data.detfictal[i].CODUBIDEF+'" data-obj="canfin1">'+data.detfictal[i].CANFIN1+'</span>'+
							'<button onclick="decrease_deftal(\'canfin1\',\''+data.detfictal[i].CODDEF+'\',\''+
							data.detfictal[i].CODTAL+'\',\''+data.detfictal[i].CODUBIDEF+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
						'</div></td>'+*/
						'<td><div class="div-inline">'+
							'<span class="addval canfin2" id="canfin2-'+
							data.detfictal[i].CODDEF+'-'+data.detfictal[i].CODTAL+'-'+
							data.detfictal[i].CODUBIDEF+'" data-obj="canfin2">'+data.detfictal[i].CANFIN2+'</span>'+
							'<button onclick="decrease_deftal(\'canfin2\',\''+data.detfictal[i].CODDEF+'\',\''+
							data.detfictal[i].CODTAL+'\',\''+data.detfictal[i].CODUBIDEF+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
						'</div></td>'+
						'<td><div class="div-inline">'+
							'<span class="addval canfin3" id="canfin3-'+
							data.detfictal[i].CODDEF+'-'+data.detfictal[i].CODTAL+'-'+
							data.detfictal[i].CODUBIDEF+'" data-obj="canfin3">'+data.detfictal[i].CANFIN3+'</span>'+
							'<button onclick="decrease_deftal(\'canfin3\',\''+data.detfictal[i].CODDEF+'\',\''+
							data.detfictal[i].CODTAL+'\',\''+data.detfictal[i].CODUBIDEF+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
						'</div></td>'+
						'<td><div class="div-inline">'+
							'<span class="addval canfin4" id="canfin4-'+
							data.detfictal[i].CODDEF+'-'+data.detfictal[i].CODTAL+'-'+
							data.detfictal[i].CODUBIDEF+'" data-obj="canfin4">'+data.detfictal[i].CANFIN4+'</span>'+
							'<button onclick="decrease_deftal(\'canfin4\',\''+data.detfictal[i].CODDEF+'\',\''+
							data.detfictal[i].CODTAL+'\',\''+data.detfictal[i].CODUBIDEF+'\')"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
						'</div></td>'+
						'<td>'+data.detfictal[i].CODDEFAUX+'</td>'+
						'<td>'+data.detfictal[i].DESDEF+'</td>'+
						'<td>'+data.detfictal[i].UBIDEF+'</td>'+
						'<td class="cell-input"><input class="classobs" id="obs-'+
						data.detfictal[i].CODDEF+'-'+data.detfictal[i].CODTAL+'-'+
						data.detfictal[i].CODUBIDEF+'" value="'+data.detfictal[i].OBS+'"/></td>'+
					'</tr>';
				}
				html+=
					'<tr>'+
						'<td class="last-td">TOTAL</td>'+
						/*'<td class="last-td"><center><span id="idcanini2">'+canini2+'</span></center></td>'+
						'<td class="last-td"><center><span id="idcanini3">'+canini3+'</span></center></td>'+
						'<td class="last-td"><center><span id="idcanini4">'+canini4+'</span></center></td>'+
						'<td class="last-td"><center><span id="idcanfin1">'+canfin1+'</span></center></td>'+*/
						'<td class="last-td"><center><span id="idcanfin2">'+canfin2+'</span></center></td>'+
						'<td class="last-td"><center><span id="idcanfin3">'+canfin3+'</span></center></td>'+
						'<td class="last-td"><center><span id="idcanfin4">'+canfin4+'</span></center></td>'+
						'<td class="td-void"></td>'+
						'<td class="td-void"></td>'+
						'<td class="td-void"></td>'+
						'<td class="td-void"></td>'+
					'</tr>';
				$("#tbldeftal").append(html);

				$("#clasi-1").text(Math.round(sumcanfin1*10000/canaudter)/100);
				$("#clasi-2").text(Math.round(sumcanfin2*10000/canaudter)/100);
				$("#clasi-3").text(Math.round(sumcanfin3*10000/canaudter)/100);
				$("#clasi-4").text(Math.round(sumcanfin4*10000/canaudter)/100);
				$("#clasi-tot").text(Math.round((sumcanfin1+sumcanfin2+sumcanfin3+sumcanfin4)*10000/canaudter)/100);
				html=
					'<script>'+
						'$(".addval").click(function(){'+
							'add_clasi_total(this);'+
						'});';
				$("#addscripts").append(html);
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}

function grabar_datos_adic(){
	if ($("#idcanmue").val()!="" && $("#idcanrecup").val()!="") {
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codfic:document.getElementById("idcodfic").innerHTML,
				numvez:numvez,
				parte:parte,
				codtad:codtad,
				canmue:$("#idcanmue").val(),
				canrecup:$("#idcanrecup").val()
			},
			url:"config/saveDetAdiAPNC.php",
			success:function(data){
				console.log(data);
				if (data.state) {
					document.getElementById("idcantot-det").innerHTML=sum_totdefped_v;
					document.getElementById("idprepri-det").innerHTML=parseInt($("#idcanmue").val())-sum_totdefped_v;
				}else{
					alert(data.detail)
				}
				$(".panelCarga").fadeOut(100);
			}
		});
	}else{
		alert("Complete los valores para grabar");
	}
}

function decrease_deftal(obj,coddef,codtal,ubidef){
	let dom=document.getElementById(obj+"-"+coddef+"-"+codtal+"-"+ubidef);
	let valor=parseInt(dom.innerHTML)-1;
	if (valor>=0) {
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codfic:document.getElementById("idcodfic").innerHTML,
				numvez:numvez,
				parte:parte,
				codtad:codtad,
				obj:obj,
				coddef:coddef,
				codtal:codtal,
				ubidef:ubidef,
				cantidad:valor,
				adddec:-1,
				pedido:document.getElementById("idpedido").innerHTML,
				color:document.getElementById("idcolor").innerHTML
			},
			url:"config/saveTalDefFicAPNC.php",
			success:function(data){
				console.log(data);
				if (!data.state) {
					alert(data.detail);
				}else{
					dom.innerHTML=valor;
					$("#id"+obj).text(parseInt($("#id"+obj).text())-1);
					if (obj.indexOf("canfin")>=0) {
						$("#canclasi-"+codtal).text(parseInt($("#candef-"+codtal).text())-1);
						$("#candef-"+codtal).text(parseInt($("#candef-"+codtal).text())-1);
						$("#tot-def").text(parseInt($("#tot-def").text())-1);

						let num=parseInt($("#id"+obj).text());
						let den=canaudter;

						$("#clasi-"+obj.replace("canfin","")).text(Math.round(num*10000/den)/100);
						let ar=document.getElementsByClassName("sum-cla");
						let suma=0;
						for (var i = 0; i < ar.length; i++) {
							suma+=parseFloat(ar[i].innerHTML);
						}
						suma=Math.round(suma*100)/100;
						$("#clasi-tot").text(suma);

						sum_totdefped_v=parseInt(document.getElementById("idcanfin2").innerHTML)+
							parseInt(document.getElementById("idcanfin4").innerHTML)+
							parseInt(document.getElementById("idcanfin3").innerHTML);
						document.getElementById("idcantot-det").innerHTML=sum_totdefped_v;
						document.getElementById("idprepri-det").innerHTML=parseInt($("#idcanmue").val())-sum_totdefped_v;
						$("#tot-tal").text(sum_totdefped_v);
					}					

					if(document.getElementById("idpedido").innerHTML!=""){
						if(data.porpedcol[0].can2!=""){
							document.getElementById("valadd-2").innerHTML="("+data.porpedcol[0].can2+"/"+data.porpedcol[0].canter+")";
							document.getElementById("valadd-3").innerHTML="("+data.porpedcol[0].can3+"/"+data.porpedcol[0].canter+")";
							document.getElementById("valadd-4").innerHTML="("+data.porpedcol[0].can4+"/"+data.porpedcol[0].canter+")";
							document.getElementById("pedcol-2").innerHTML=Math.round(parseFloat(data.porpedcol[0].por2)*10000)/100;
							document.getElementById("pedcol-3").innerHTML=Math.round(parseFloat(data.porpedcol[0].por3)*10000)/100;
							document.getElementById("pedcol-4").innerHTML=Math.round(parseFloat(data.porpedcol[0].por4)*10000)/100;
							document.getElementById("pedcol-tot").innerHTML=Math.round((
								parseFloat(data.porpedcol[0].por2)+
								parseFloat(data.porpedcol[0].por3)+
								parseFloat(data.porpedcol[0].por4)
							)*10000)/100;
						}
					}
				}
				$(".panelCarga").fadeOut(100);
			}
		});
	}
}

function add_clasi_total(dom){
	let ar_data=dom.id.split("-");
	let valor=parseInt(dom.innerHTML)+1;
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codfic:document.getElementById("idcodfic").innerHTML,
			numvez:numvez,
			parte:parte,
			codtad:codtad,
			obj:ar_data[0],
			coddef:ar_data[1],
			codtal:ar_data[2],
			ubidef:ar_data[3],
			cantidad:valor,
			adddec:1,
			pedido:document.getElementById("idpedido").innerHTML,
			color:document.getElementById("idcolor").innerHTML
		},
		url:"config/saveTalDefFicAPNC.php",
		success:function(data){
			console.log(data);
			if (!data.state) {
				alert(data.detail);
			}else{
				dom.innerHTML=valor;
				$("#id"+dom.dataset.obj).text(parseInt($("#id"+dom.dataset.obj).text())+1);
				if (ar_data[0].indexOf("canfin")>=0) {
					$("#canclasi-"+ar_data[2]).text(parseInt($("#canclasi-"+ar_data[2]).text())+1);
					$("#candef-"+ar_data[2]).text(parseInt($("#candef-"+ar_data[2]).text())+1);
					$("#tot-def").text(parseInt($("#tot-def").text())+1);

					let num=parseInt($("#id"+ar_data[0]).text());
					let den=canaudter;

					$("#clasi-"+ar_data[0].replace("canfin","")).text(Math.round(num*10000/den)/100);
					let ar=document.getElementsByClassName("sum-cla");
					let suma=0;
					for (var i = 0; i < ar.length; i++) {
						suma+=parseFloat(ar[i].innerHTML);
					}
					suma=Math.round(suma*100)/100;
					$("#clasi-tot").text(suma);

					sum_totdefped_v=parseInt(document.getElementById("idcanfin2").innerHTML)+
						parseInt(document.getElementById("idcanfin4").innerHTML)+
						parseInt(document.getElementById("idcanfin3").innerHTML);
					document.getElementById("idcantot-det").innerHTML=sum_totdefped_v;
					document.getElementById("idprepri-det").innerHTML=parseInt($("#idcanmue").val())-sum_totdefped_v;
					$("#tot-tal").text(sum_totdefped_v);
				}							

				if(document.getElementById("idpedido").innerHTML!=""){
					if(data.porpedcol[0].can2!=""){
						document.getElementById("valadd-2").innerHTML="("+data.porpedcol[0].can2+"/"+data.porpedcol[0].canter+")";
						document.getElementById("valadd-3").innerHTML="("+data.porpedcol[0].can3+"/"+data.porpedcol[0].canter+")";
						document.getElementById("valadd-4").innerHTML="("+data.porpedcol[0].can4+"/"+data.porpedcol[0].canter+")";
						document.getElementById("pedcol-2").innerHTML=Math.round(parseFloat(data.porpedcol[0].por2)*10000)/100;
						document.getElementById("pedcol-3").innerHTML=Math.round(parseFloat(data.porpedcol[0].por3)*10000)/100;
						document.getElementById("pedcol-4").innerHTML=Math.round(parseFloat(data.porpedcol[0].por4)*10000)/100;
						document.getElementById("pedcol-tot").innerHTML=Math.round((
							parseFloat(data.porpedcol[0].por2)+
							parseFloat(data.porpedcol[0].por3)+
							parseFloat(data.porpedcol[0].por4)
						)*10000)/100;
					}
				}
			}
			$(".panelCarga").fadeOut(100);
		}
	});
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
	if (coddef_var=="") {
		alert("Debe escoger un defecto");
		return;
	}
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
			ubicacion:$("#idubicacion").val(),
			obs:$("#idobs").val()
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
					/*'<td><div class="div-inline">'+
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
					'</div></td>'+*/
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
					'<td>'+data.codubidef+'</td>'+
					'<td class="cell-input"><input class="classobs" id="obs-'+
					coddef_var+'-'+$("#selecttallas").val()+'-'+
					$("#idubicacion").val()+'" value="'+$("#idobs").val()+'"/></td>'+
				'</tr>';
				let ar=document.getElementById("tbldeftal").getElementsByTagName("tr");
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
				$("#idobs").val("")
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