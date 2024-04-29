window.chartColors = {
	red: 'rgb(255, 99, 132)',
	reddark: 'rgb(255, 50, 60)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(80, 200, 2)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
	black: 'rgb(50, 50, 50)',
	mostaza: 'rgb(195, 170, 5)',
	reddarkdark: 'rgb(140, 10, 20)'
};

function validate_total(valor){
	if (valor>100) {
		return 100;
	}else{
		return valor;
	}
}

var sumtotpesgen=0;
var sumtotcangen=0;
var param_codran1=0;
var param_codran2=0;
var sumpesblo=0;
var sumcanblo=0;
var sumpeston=0;
var sumcanton=0;
var sumpestoncol=0;
var sumcantoncol=0;
var sumpestontel=0;
var sumcantontel=0;
var sumpesapa=0;
var sumcanapa=0;
var sumpesapadef=0;
var sumcanapadef=0;
var sumpesapacol=0;
var sumcanapacol=0;
var sumpesapatel=0;
var sumcanapatel=0;
var sumpesed=0;
var sumcaned=0;
var sumpesedcol=0;
var sumcanedcol=0;
var sumpesedtel=0;
var sumcanedtel=0;
$(document).ready(function(){
	$(".classseltoncol").change(function(){
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codcli:codcli,
				codprv:codprv,
				codusu:codusurep,
				codusueje:codusueje,
				fecini:fecini,
				fecfin:fecfin,
				resultado:resultado,
				codarea:codarea,
				codton:$("#selectTonCol").val(),
				codapa:codapa,
				codestdim:codestdim,
				rango:rango,
				coddef:coddef
			},
			url:"config/updateTonCol.php",
			success:function(data){
				console.log(data);
				var labels=[];
				var porkgnoapr=[];
				var kgnoapr=[];
				var html='';
				var sumpor1=0;
				var sumpor2=0;
				for (var i = 0; i < data.detalletonocolor.length; i++) {
					var por1=Math.round(data.detalletonocolor[i].PESTOT*10000/sumtotpesgen)/100;
					sumpor1+=por1;
					var por2=Math.round(data.detalletonocolor[i].PESTOT*10000/data.sumpestonocolor)/100;
					sumpor2+=por2;
					html+=
					'<div class="tblLine">'+
						'<div class="itemBody2" style="width: 28%;">'+data.detalletonocolor[i].CODCOL+'</div>'+
						'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletonocolor[i].PESTOT)+'</div>'+
						'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
						'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
						'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletonocolor[i].CANTOT)+'</div>'+
					'</div>';
					labels.push(data.detalletonocolor[i].CODCOL);
					porkgnoapr.push(por2);
					kgnoapr.push(data.detalletonocolor[i].PESTOT);
				}
				html+=
				'<div class="tblLine linestyleend">'+
					'<div class="itemBody2" style="width: 28%;">Total</div>'+
					//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpestonocolor*100)/100)+'</div>'+
					//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcantonocolor*100)/100)+'</div>'+
				'</div>';
				html+=
				'<div style="width:100%;height:20px;background:#ddd;">'+
				'</div>'+
				'<div class="tblLine linestyleend">'+
					'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
					'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
					'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
					'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
				'</div>';

				$("#idTblBody2-1").empty();
				$("#idTblBody2-1").append(html);

				//processGraph(labels,kgnoapr,porkgnoapr,'2-1');
				sumpestoncol=data.sumpestonocolor;
				sumcantoncol=data.sumcantonocolor;
				$(".panelCarga").fadeOut(100);
			}
		});
	});
	$(".classseltontel").change(function(){
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codcli:codcli,
				codprv:codprv,
				codusu:codusurep,
				codusueje:codusueje,
				fecini:fecini,
				fecfin:fecfin,
				resultado:resultado,
				codarea:codarea,
				codton:$("#selectTonTel").val(),
				codapa:codapa,
				codestdim:codestdim,
				rango:rango,
				coddef:coddef
			},
			url:"config/updateTonTel.php",
			success:function(data){
				console.log(data);
				var labels=[];
				var porkgnoapr=[];
				var kgnoapr=[];
				var html='';
				var sumpor1=0;
				var sumpor2=0;
				for (var i = 0; i < data.detalletonotela.length; i++) {
					var por1=Math.round(data.detalletonotela[i].PESTOT*10000/sumtotpesgen)/100;
					sumpor1+=por1;
					var por2=Math.round(data.detalletonotela[i].PESTOT*10000/data.sumpestonotela)/100;
					sumpor2+=por2;
					html+=
					'<div class="tblLine">'+
						'<div class="itemBody2" style="width: 28%;">'+data.detalletonotela[i].DESTEL+'</div>'+
						'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletonotela[i].PESTOT)+'</div>'+
						'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
						'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
						'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletonotela[i].CANTOT)+'</div>'+
					'</div>';
					labels.push(data.detalletonotela[i].DESTEL);
					porkgnoapr.push(por2);
					kgnoapr.push(data.detalletonotela[i].PESTOT);
				}
				html+=
				'<div class="tblLine linestyleend">'+
					'<div class="itemBody2" style="width: 28%;">Total</div>'+
					//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpestonotela*100)/100)+'</div>'+
					//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcantonotela*100)/100)+'</div>'+
				'</div>';
				html+=
				'<div style="width:100%;height:20px;background:#ddd;">'+
				'</div>'+
				'<div class="tblLine linestyleend">'+
					'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
					'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
					'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
					'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
				'</div>';

				$("#idTblBody2-2").empty();
				$("#idTblBody2-2").append(html);

				//processGraph(labels,kgnoapr,porkgnoapr,'2-1');
				sumpestontel=data.sumpestonotela;
				sumcantontel=data.sumcantonotela;
				$(".panelCarga").fadeOut(100);
			}
		});
	});
	$(".classApaCodareDef").change(function(){
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codcli:codcli,
				codprv:codprv,
				codusu:codusurep,
				codusueje:codusueje,
				fecini:fecini,
				fecfin:fecfin,
				resultado:resultado,
				codarea:$("#selectApaCodAreaDef").val(),
				codton:codton,
				codapa:codapa,
				codestdim:codestdim,
				rango:rango,
				coddef:coddef
			},
			url:"config/updateApaCodAreaDef.php",
			success:function(data){
				console.log(data);
			//APA - DEF
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleapadef.length; i++) {
				var por1=Math.round(data.detalleapadef[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleapadef[i].PESTOT*10000/data.sumpesapadef)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleapadef[i].DSCAREAD+'</div>'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleapadef[i].DESAPA+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapadef[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapadef[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleapadef[i].DESAPA);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleapadef[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				'<div class="itemBody2" style="width: 28%;"></div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesapadef*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanapadef*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody4").empty();
			$("#idTblBody4").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'4');
			sumpesapadef=data.sumpesapadef;
			sumcanapadef=data.sumcanapadef;

			//APA - COLOR
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleapacol.length; i++) {
				var por1=Math.round(data.detalleapacol[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleapacol[i].PESTOT*10000/data.sumpesapadef)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleapacol[i].CODCOL+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapacol[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapacol[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleapacol[i].CODCOL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleapacol[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesapacol*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanapacol*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody4-1").empty();
			$("#idTblBody4-1").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'4');
			sumpesapacol=data.sumpesapacol;
			sumcanapacol=data.sumcanapacol;

			var html='';
			for (var i = 0; i < data.codapas.length; i++) {
				html+=
				'<option value="'+data.codapas[i].CODAPA+'">'+data.codapas[i].DESAPA+'</option>';
			}
			$("#selectApaCodApaCol").empty();
			$("#selectApaCodApaCol").append(html);
			$("#selectApaCodApaTel").empty();
			$("#selectApaCodApaTel").append(html);

			//APA - TELA
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleapatel.length; i++) {
				var por1=Math.round(data.detalleapatel[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleapatel[i].PESTOT*10000/data.sumpesapatel)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleapatel[i].DESTEL+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapatel[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapatel[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleapatel[i].CODCOL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleapatel[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesapatel*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanapatel*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody4-2").empty();
			$("#idTblBody4-2").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'4');
			sumpesapatel=data.sumpesapatel;
			sumcanapatel=data.sumcanapatel;
				$(".panelCarga").fadeOut(100);
			}
		});
	});
	$(".classApaCodApaCol").change(function(){
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codcli:codcli,
				codprv:codprv,
				codusu:codusurep,
				codusueje:codusueje,
				fecini:fecini,
				fecfin:fecfin,
				resultado:resultado,
				codarea:codarea,
				codton:$("#selectTonTel").val(),
				codapa:$("#selectApaCodApaCol").val(),
				codestdim:codestdim,
				rango:rango,
				coddef:coddef
			},
			url:"config/updateApaCol.php",
			success:function(data){
				console.log(data);
				//APA - COLOR
				var labels=[];
				var porkgnoapr=[];
				var kgnoapr=[];
				var html='';
				var sumpor1=0;
				var sumpor2=0;
				for (var i = 0; i < data.detalleapacol.length; i++) {
					var por1=Math.round(data.detalleapacol[i].PESTOT*10000/sumtotpesgen)/100;
					sumpor1+=por1;
					var por2=Math.round(data.detalleapacol[i].PESTOT*10000/data.sumpesapacol)/100;
					sumpor2+=por2;
					html+=
					'<div class="tblLine">'+
						'<div class="itemBody2" style="width: 28%;">'+data.detalleapacol[i].CODCOL+'</div>'+
						'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapacol[i].PESTOT)+'</div>'+
						'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
						'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
						'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapacol[i].CANTOT)+'</div>'+
					'</div>';
					labels.push(data.detalleapacol[i].CODCOL);
					porkgnoapr.push(por2);
					kgnoapr.push(data.detalleapacol[i].PESTOT);
				}
				html+=
				'<div class="tblLine linestyleend">'+
					'<div class="itemBody2" style="width: 28%;">Total</div>'+
					//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesapacol*100)/100)+'</div>'+
					//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanapacol*100)/100)+'</div>'+
				'</div>';
				html+=
				'<div style="width:100%;height:20px;background:#ddd;">'+
				'</div>'+
				'<div class="tblLine linestyleend">'+
					'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
					'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
					'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
					'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
				'</div>';

				$("#idTblBody4-1").empty();
				$("#idTblBody4-1").append(html);

				//processGraph(labels,kgnoapr,porkgnoapr,'4');
				sumpesapacol=data.sumpesapacol;
				sumcanapacol=data.sumcanapacol;
				$(".panelCarga").fadeOut(100);
			}
		});
	});
	$(".classApaCodApaTel").change(function(){
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codcli:codcli,
				codprv:codprv,
				codusu:codusurep,
				codusueje:codusueje,
				fecini:fecini,
				fecfin:fecfin,
				resultado:resultado,
				codarea:codarea,
				codton:$("#selectTonTel").val(),
				codapa:$("#selectApaCodApaTel").val(),
				codestdim:codestdim,
				rango:rango,
				coddef:coddef
			},
			url:"config/updateApaTel.php",
			success:function(data){
				console.log(data);
				//APA - TELA
				var labels=[];
				var porkgnoapr=[];
				var kgnoapr=[];
				var html='';
				var sumpor1=0;
				var sumpor2=0;
				for (var i = 0; i < data.detalleapatel.length; i++) {
					var por1=Math.round(data.detalleapatel[i].PESTOT*10000/sumtotpesgen)/100;
					sumpor1+=por1;
					var por2=Math.round(data.detalleapatel[i].PESTOT*10000/data.sumpesapatel)/100;
					sumpor2+=por2;
					html+=
					'<div class="tblLine">'+
						'<div class="itemBody2" style="width: 28%;">'+data.detalleapatel[i].DESTEL+'</div>'+
						'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapatel[i].PESTOT)+'</div>'+
						'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
						'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
						'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapatel[i].CANTOT)+'</div>'+
					'</div>';
					labels.push(data.detalleapatel[i].CODCOL);
					porkgnoapr.push(por2);
					kgnoapr.push(data.detalleapatel[i].PESTOT);
				}
				html+=
				'<div class="tblLine linestyleend">'+
					'<div class="itemBody2" style="width: 28%;">Total</div>'+
					//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesapatel*100)/100)+'</div>'+
					//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanapatel*100)/100)+'</div>'+
				'</div>';
				html+=
				'<div style="width:100%;height:20px;background:#ddd;">'+
				'</div>'+
				'<div class="tblLine linestyleend">'+
					'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
					'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
					'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
					'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
				'</div>';

				$("#idTblBody4-2").empty();
				$("#idTblBody4-2").append(html);

				//processGraph(labels,kgnoapr,porkgnoapr,'4');
				sumpesapatel=data.sumpesapatel;
				sumcanapatel=data.sumcanapatel;
				$(".panelCarga").fadeOut(100);
			}
		});
	});
	$.ajax({
		type:"POST",
		data:{
			codcli:codcli,
			codprv:codprv,
			codusu:codusurep,
			codusueje:codusueje,
			fecini:fecini,
			fecfin:fecfin,
			resultado:resultado,
			codarea:codarea,
			codton:codton,
			codapa:codapa,
			codestdim:codestdim,
			rango:rango,
			coddef:coddef
		},
		url:"config/getInfoRepBlo.php",
		success:function(data){
			var tit1='RECHAZADOS';
			var tit2='RECH.';
			if (resultado=="C") {
				tit1='APRO. NO CONF.';
				tit2='ANC';
			}
			$(".idtit1").text(tit1);
			$(".tit2").text(tit2);
			console.log(data);
			var labels=[];
			var rechazado=[];
			var aprnocon=[];
			var aprobado=[];
			var colors=[];
			var html='';
			//param_codran2=parseInt(data.param[0].VALOR);
			//param_codran1=parseInt(data.param[1].VALOR);
			$("#titulodetalle").append(data.titulo);

			sumtotpesgen=data.detalletotal[0].PESTOT;
			sumtotcangen=data.detalletotal[0].CANTOT;

			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalle1.length; i++) {
				var por1=Math.round(data.detalle1[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalle1[i].PESTOT*10000/data.sumpesblo)/100;
				sumpor2+=por2;
				if (sumpor2>100) {
					sumpor2=100;
				}
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalle1[i].BLOQUE+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalle1[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalle1[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalle1[i].BLOQUE);
				porkgnoapr.push(por2);
				//kgnoapr.push(data.detalle1[i].PESTOT);
				kgnoapr.push(sumpor2);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesblo*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanblo*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody").empty();
			$("#idTblBody").append(html);

			processGraph(labels,kgnoapr,porkgnoapr,'');
			sumpesblo=data.sumpesblo;
			sumcanblo=data.sumcanblo;

			//tono
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalletono.length; i++) {
				var por1=Math.round(data.detalletono[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalletono[i].PESTOT*10000/data.sumpestono)/100;
				sumpor2+=por2;
				if (sumpor2>100) {
					sumpor2=100;
				}
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalletono[i].DESTON+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletono[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletono[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalletono[i].DESTON);
				porkgnoapr.push(por2);
				//kgnoapr.push(data.detalletono[i].PESTOT);
				kgnoapr.push(sumpor2);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
			//	'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpestono*100)/100)+'</div>'+
			//	'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcantono*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody2").empty();
			$("#idTblBody2").append(html);

			processGraph(labels,kgnoapr,porkgnoapr,'2');
			sumpeston=data.sumpestono;
			sumcanton=data.sumcantono;

			//tono - color
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalletonocolor.length; i++) {
				var por1=Math.round(data.detalletonocolor[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalletonocolor[i].PESTOT*10000/data.sumpestonocolor)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalletonocolor[i].CODCOL+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletonocolor[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletonocolor[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalletonocolor[i].CODCOL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalletonocolor[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpestonocolor*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcantonocolor*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody2-1").empty();
			$("#idTblBody2-1").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'2-1');
			sumpestoncol=data.sumpestonocolor;
			sumcantoncol=data.sumcantonocolor;

			var html='';
			for (var i = 0; i < data.tonos.length; i++) {
				html+=
				'<option value="'+data.tonos[i].CODTON+'">'+data.tonos[i].DESTON+'</option>';
			}
			$("#selectTonCol").empty();
			$("#selectTonCol").append(html);

			//tono - tela
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalletonotela.length; i++) {
				var por1=Math.round(data.detalletonotela[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalletonotela[i].PESTOT*10000/data.sumpestonotela)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalletonotela[i].DESTEL+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletonotela[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalletonotela[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalletonotela[i].DESTEL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalletonotela[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpestonotela*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcantonotela*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody2-2").empty();
			$("#idTblBody2-2").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'2-1');
			sumpestontel=data.sumpestonotela;
			sumcantontel=data.sumcantonotela;

			var html='';
			for (var i = 0; i < data.tonos.length; i++) {
				html+=
				'<option value="'+data.tonos[i].CODTON+'">'+data.tonos[i].DESTON+'</option>';
			}
			$("#selectTonTel").empty();
			$("#selectTonTel").append(html);

			//APARIENCIA
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleapa.length; i++) {
				var por1=Math.round(data.detalleapa[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleapa[i].PESTOT*10000/data.sumpesapa)/100;
				sumpor2+=por2;
				if (sumpor2>100) {
					sumpor2=100;
				}
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleapa[i].DSCAREAD+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapa[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapa[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleapa[i].DSCAREAD);
				porkgnoapr.push(por2);
				//kgnoapr.push(data.detalleapa[i].PESTOT);
				kgnoapr.push(sumpor2);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesapa*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanapa*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody3").empty();
			$("#idTblBody3").append(html);

			processGraph(labels,kgnoapr,porkgnoapr,'3');
			sumpesapa=data.sumpesapa;
			sumcanapa=data.sumcanapa;

			//APA - DEF
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleapadef.length; i++) {
				var por1=Math.round(data.detalleapadef[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleapadef[i].PESTOT*10000/data.sumpesapadef)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleapadef[i].DSCAREAD+'</div>'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleapadef[i].DESAPA+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapadef[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapadef[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleapadef[i].DESAPA);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleapadef[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				'<div class="itemBody2" style="width: 28%;"></div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesapadef*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanapadef*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody4").empty();
			$("#idTblBody4").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'4');
			sumpesapadef=data.sumpesapadef;
			sumcanapadef=data.sumcanapadef;

			var html='';
			for (var i = 0; i < data.codareas.length; i++) {
				html+=
				'<option value="'+data.codareas[i].CODAREAD+'">'+data.codareas[i].DSCAREAD+'</option>';
			}
			$("#selectApaCodAreaDef").empty();
			$("#selectApaCodAreaDef").append(html);

			//APA - COLOR
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleapacol.length; i++) {
				var por1=Math.round(data.detalleapacol[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleapacol[i].PESTOT*10000/data.sumpesapacol)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleapacol[i].CODCOL+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapacol[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapacol[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleapacol[i].CODCOL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleapacol[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesapacol*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanapacol*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody4-1").empty();
			$("#idTblBody4-1").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'4');
			sumpesapacol=data.sumpesapacol;
			sumcanapacol=data.sumcanapacol;

			var html='';
			for (var i = 0; i < data.codapas.length; i++) {
				html+=
				'<option value="'+data.codapas[i].CODAPA+'">'+data.codapas[i].DESAPA+'</option>';
			}
			$("#selectApaCodApaCol").empty();
			$("#selectApaCodApaCol").append(html);
			$("#selectApaCodApaTel").empty();
			$("#selectApaCodApaTel").append(html);

			//APA - TELA
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleapatel.length; i++) {
				var por1=Math.round(data.detalleapatel[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleapatel[i].PESTOT*10000/data.sumpesapatel)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleapatel[i].DESTEL+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapatel[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleapatel[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleapatel[i].CODCOL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleapatel[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesapatel*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanapatel*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody4-2").empty();
			$("#idTblBody4-2").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'4');
			sumpesapatel=data.sumpesapatel;
			sumcanapatel=data.sumcanapatel;

			//EST. DIM.
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleed.length; i++) {
				var por1=Math.round(data.detalleed[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleed[i].PESTOT*10000/data.sumpesed)/100;
				sumpor2+=por2;
				if (sumpor2>100) {
					sumpor2=100;
				}
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleed[i].DESESTDIM+'</div>'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleed[i].RANGO+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleed[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleed[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleed[i].DESESTDIM);
				porkgnoapr.push(por2);
				//kgnoapr.push(data.detalleed[i].PESTOT);
				kgnoapr.push(sumpor2);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				'<div class="itemBody2" style="width: 28%;"></div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesed*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcaned*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody5").empty();
			$("#idTblBody5").append(html);

			processGraph(labels,kgnoapr,porkgnoapr,'5');
			sumpesed=data.sumpesed;
			sumcaned=data.sumcaned;

			//EST. DIM. COLOR
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleedcol.length; i++) {
				var por1=Math.round(data.detalleedcol[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleedcol[i].PESTOT*10000/data.sumpesedcol)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleedcol[i].CODCOL+'</div>'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleedcol[i].RANGO+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleedcol[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleedcol[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleedcol[i].CODCOL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleedcol[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				'<div class="itemBody2" style="width: 28%;"></div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesedcol*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanedcol*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody5-1").empty();
			$("#idTblBody5-1").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'5-1');
			sumpesedcol=data.sumpesedcol;
			sumcanedcol=data.sumcanedcol;

			//EST. DIM. TELA
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleedtel.length; i++) {
				var por1=Math.round(data.detalleedtel[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleedtel[i].PESTOT*10000/data.sumpesedtel)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleedtel[i].DESTEL+'</div>'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleedtel[i].RANGO+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleedtel[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleedtel[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleedtel[i].DESTEL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleedtel[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				'<div class="itemBody2" style="width: 28%;"></div>'+
				//'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesedtel*100)/100)+'</div>'+
				//'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanedtel*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody5-2").empty();
			$("#idTblBody5-2").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'5-1');
			sumpesedtel=data.sumpesedtel;
			sumcanedtel=data.sumcanedtel;



			var newaredtdim=[];
			for (var i = 0; i < data.estdims.length; i++) {
				var aux=[];
				if (i==0) {
					aux.push(data.estdims[i].CODESTDIM);
					aux.push(data.estdims[i].DESESTDIM);
					newaredtdim.push(aux);
				}else{
					var j=0;
					var validar=true;
					while(j<newaredtdim.length && validar){
						if (data.estdims[i].CODESTDIM==newaredtdim[j][0]) {
							validar=false;
						}
						j++;
					}
					if (validar) {
						aux.push(data.estdims[i].CODESTDIM);
						aux.push(data.estdims[i].DESESTDIM);
						newaredtdim.push(aux);
					}
				}
			}
			var html='';
			for (var i = 0; i < newaredtdim.length; i++) {
				html+=
				'<option value="'+newaredtdim[i][0]+'">'+newaredtdim[i][1]+'</option>';
			}
			$("#selectEstDimCol").empty();
			$("#selectEstDimCol").append(html);
			$("#selectEstDimTel").empty();
			$("#selectEstDimTel").append(html);

			var newrango=[];
			for (var i = 0; i < data.rangos.length; i++) {
				var aux=[];
				if (i==0) {
					aux.push(data.rangos[i].RANGO);
					newrango.push(aux);
				}else{
					var j=0;
					var validar=true;
					while(j<newrango.length && validar){
						if (data.rangos[i].RANGO==newrango[j][0]) {
							validar=false;
						}
						j++;
					}
					if (validar) {
						aux.push(data.rangos[i].RANGO);
						newrango.push(aux);
					}
				}
			}
			var html='';
			for (var i = 0; i < newrango.length; i++) {
				html+=
				'<option value="'+newrango[i][0]+'">'+newrango[i]+'</option>';
			}
			$("#selectEstDimRanCol").empty();
			$("#selectEstDimRanCol").append(html);
			$("#selectEstDimRanTel").empty();
			$("#selectEstDimRanTel").append(html);

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
});

function processGraph(ar_lab,ar_apr_noc,ar_apr,id){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Kg. No Apr.',
			borderColor: window.chartColors.yellow,
			borderWidth: 2,
			fill: false,
			data: ar_apr_noc,
			lineTension: 0,
			yAxisID: 'y-axis-2'
		}, {
			type: 'bar',
			label: '% Kg. No Apr.',
			backgroundColor:window.chartColors.reddark,
			data: ar_apr,
			yAxisID: 'y-axis-1',
			datalabels: {
				align: 'top',
				anchor: 'start'
			}
		}]
	};
	var wWin=window.innerWidth;
	var dBorder=true;
	var stepTicks=5;
	if (wWin<600) {
		dBorder=false;
		stepTicks=20;
	}
	var ctx = document.getElementById('chart-area'+id).getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],				
				yAxes: [{
					display: true,
					scaleLabel: {
						display: false
					},
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100
					},
					id: 'y-axis-1',
				},{
					type: 'linear',
					display: false,
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100
					}
				}]
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						if (context.dataset.type!="line") {
							return Math.round(value)+"%";
						}else{
							return Math.round(value)+"%";
						}
					},
					font:{
						weight:600
					}
				}
			}
		}
	});
}

function update_edcol(){	
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codcli:codcli,
			codprv:codprv,
			codusu:codusurep,
			codusueje:codusueje,
			fecini:fecini,
			fecfin:fecfin,
			resultado:resultado,
			codarea:codarea,
			codton:codton,
			codapa:codapa,
			codestdim:$("#selectEstDimCol").val(),
			rango:$("#selectEstDimRanCol").val(),
			coddef:coddef
		},
		url:"config/updateEstDimCol.php",
		success:function(data){
			console.log(data);
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleedcol.length; i++) {
				var por1=Math.round(data.detalleedcol[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleedcol[i].PESTOT*10000/data.sumpesedcol)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleedcol[i].CODCOL+'</div>'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleedcol[i].RANGO+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleedcol[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleedcol[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleedcol[i].CODCOL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleedcol[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				'<div class="itemBody2" style="width: 28%;"></div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesedcol*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanedcol*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody5-1").empty();
			$("#idTblBody5-1").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'5-1');
			sumpesedcol=data.sumpesedcol;
			sumcanedcol=data.sumcanedcol;
			$(".panelCarga").fadeOut(100);
		}
	});
}

function update_edtel(){	
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codcli:codcli,
			codprv:codprv,
			codusu:codusurep,
			codusueje:codusueje,
			fecini:fecini,
			fecfin:fecfin,
			resultado:resultado,
			codarea:codarea,
			codton:codton,
			codapa:codapa,
			codestdim:$("#selectEstDimTel").val(),
			rango:$("#selectEstDimRanTel").val(),
			coddef:coddef
		},
		url:"config/updateEstDimTel.php",
		success:function(data){
			console.log(data);
			var labels=[];
			var porkgnoapr=[];
			var kgnoapr=[];
			var html='';
			var sumpor1=0;
			var sumpor2=0;
			for (var i = 0; i < data.detalleedtel.length; i++) {
				var por1=Math.round(data.detalleedtel[i].PESTOT*10000/sumtotpesgen)/100;
				sumpor1+=por1;
				var por2=Math.round(data.detalleedtel[i].PESTOT*10000/data.sumpesedtel)/100;
				sumpor2+=por2;
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleedtel[i].DESTEL+'</div>'+
					'<div class="itemBody2" style="width: 28%;">'+data.detalleedtel[i].RANGO+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleedtel[i].PESTOT)+'</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por1+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+por2+'%</div>'+
					'<div class="itemBody2" style="width: 18%;">'+formatNumber(data.detalleedtel[i].CANTOT)+'</div>'+
				'</div>';
				labels.push(data.detalleedtel[i].DESTEL);
				porkgnoapr.push(por2);
				kgnoapr.push(data.detalleedtel[i].PESTOT);
			}
			html+=
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 28%;">Total</div>'+
				'<div class="itemBody2" style="width: 28%;"></div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumpesedtel*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(sumpor1*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+Math.round(validate_total(sumpor2)*100)/100+'%</div>'+
				'<div class="itemBody2" style="width: 18%;">'+formatNumber(Math.round(data.sumcanedtel*100)/100)+'</div>'+
			'</div>';
			html+=
			'<div style="width:100%;height:20px;background:#ddd;">'+
			'</div>'+
			'<div class="tblLine linestyleend">'+
				'<div class="itemBody2" style="width: 25%;">Kg. Auditados</div>'+
				'<div class="itemBody2" style="width: 25%;">'+formatNumber(Math.round(sumtotpesgen*100)/100)+'</div>'+
				'<div class="itemBody2" style="width: 25%;"># auditor&iacute;as</div>'+
				'<div class="itemBody2" style="width: 25%;">'+Math.round(Math.round(sumtotcangen)*100)/100+'</div>'+
			'</div>';

			$("#idTblBody5-2").empty();
			$("#idTblBody5-2").append(html);

			//processGraph(labels,kgnoapr,porkgnoapr,'5-1');
			sumpesedtel=data.sumpesedtel;
			sumcanedtel=data.sumcanedtel;
			$(".panelCarga").fadeOut(100);
		}
	});
}

function downloadPDF(){
	$.ajax({
	  	type: "POST",
	  	url: "config/saveTmpImgRepBlo.php",
	  	data: { 
	    	img1: document.getElementById("chart-area").toDataURL("image/png"),
	    	img2: document.getElementById("chart-area2").toDataURL("image/png"),
	    	img3: document.getElementById("chart-area3").toDataURL("image/png"),
	    	img4: document.getElementById("chart-area5").toDataURL("image/png"),
			codprv:codprv,
			fecini:fecini,
			fecfin:fecfin,
			codusu:codusurep,
			codusueje:codusueje
	  	},
	  	success:function(data){
	  		var title=$("#titulodetalle").text();
	  		var a=document.createElement("a");
	  		a.target="_blank";
	  		a.href="fpdf/pdfRepBlo.php?n="+data+
	  		"&t="+title+"&tit1="+document.getElementsByClassName("idtit1")[0].innerText+
	  		"&tit2="+document.getElementsByClassName("tit2")[0].innerText+
	  		"&codprv="+codprv+"&codcli="+codcli+"&resultado="+resultado+
	  		"&fecini="+fecini+"&fecfin="+fecfin+"&codusu="+codusurep+"&codusueje="+codusueje+
			"&codtoncol="+$("#selectTonCol").val()+
			"&codtontel="+$("#selectTonTel").val()+
			"&lbltoncol="+$("#selectTonCol")[0].options[$("#selectTonCol")[0].selectedIndex].label+
			"&lbltontel="+$("#selectTonTel")[0].options[$("#selectTonTel")[0].selectedIndex].label+
			"&codarea="+$("#selectApaCodAreaDef").val()+
			"&lblarea="+$("#selectApaCodAreaDef")[0].options[$("#selectApaCodAreaDef")[0].selectedIndex].label+
			"&codareacol="+$("#selectApaCodApaCol").val()+
			"&codareatel="+$("#selectApaCodApaTel").val()+
			"&lblareacol="+$("#selectApaCodApaCol")[0].options[$("#selectApaCodApaCol")[0].selectedIndex].label+
			"&lblareatel="+$("#selectApaCodApaTel")[0].options[$("#selectApaCodApaTel")[0].selectedIndex].label+
			"&codestdimcol="+$("#selectEstDimCol").val()+
			"&rangocol="+format_signo($("#selectEstDimRanCol").val())+
			"&lblestdimcol="+$("#selectEstDimCol")[0].options[$("#selectEstDimCol")[0].selectedIndex].label+
			"&codestdimtel="+$("#selectEstDimTel").val()+
			"&rangotel="+format_signo($("#selectEstDimRanTel").val())+
			"&lblestdimtel="+$("#selectEstDimTel")[0].options[$("#selectEstDimTel")[0].selectedIndex].label+
			"&coddef=0"+
			"&sumtotpesgen="+sumtotpesgen+
			"&sumtotcangen="+sumtotcangen+
			"&sumpesblo="+sumpesblo+
			"&sumcanblo="+sumcanblo+
			"&sumpeston="+sumpeston+
			"&sumcanton="+sumcanton+
			"&sumpestoncol="+sumpestoncol+
			"&sumcantoncol="+sumcantoncol+
			"&sumpestontel="+sumpestontel+
			"&sumcantontel="+sumcantontel+
			"&sumpesapa="+sumpesapa+
			"&sumcanapa="+sumcanapa+
			"&sumpesapadef="+sumpesapadef+
			"&sumcanapadef="+sumcanapadef+
			"&sumpesapacol="+sumpesapacol+
			"&sumcanapacol="+sumcanapacol+
			"&sumpesapatel="+sumpesapatel+
			"&sumcanapatel="+sumcanapatel+
			"&sumpesed="+sumpesed+
			"&sumcaned="+sumcaned+
			"&sumpesedcol="+sumpesedcol+
			"&sumcanedcol="+sumcanedcol+
			"&sumpesedtel="+sumpesedtel+
			"&sumcanedtel="+sumcanedtel;
			a.click();
	  	}
	}).done(function(o) {
	  	console.log('Images Saved!'); 
	});
}

function format_signo(valor){
	if (valor=="+") {
		return "1";
	}else{
		return "0";
	}
}