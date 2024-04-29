function showMenu(){
	$(".menuContent").css("display","block");
}
$(document).ready(function(){
	var heightDevice=window.screen.height;
	$(".menuContent").css("height",heightDevice+"px");
	$(".menuContent").click(function(){
		$(".menuContent").css("display","none");
	});
	$(".spaceMenu").click(function(e){
		e.stopPropagation();
	});
});

function redirect(path){
	window.location.href=path;
}

function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	while(string.indexOf('\'')>0){
		string=string.replace('\'','');
	}
	return string;
}

window.chartColors = {
	red: 'rgb(255, 99, 132)',
	reddark: 'rgb(255, 0, 10)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(80, 200, 2)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
	black: 'rgb(50, 50, 50)'
};

window.colorsBox={green:'#53f500',yellow:'#ffff0a',red:'#ff0000'};

function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}

function proceMes(value){
	switch(value){
		case "01": return "Ene.";
			break;
		case "02": return "Feb.";
			break;
		case "03": return "Mar.";
			break;
		case "04": return "Abr.";
			break;
		case "05": return "May.";
			break;
		case "06": return "Jun.";
			break;
		case "07": return "Jul.";
			break;
		case "08": return "Ago.";
			break;
		case "09": return "Set.";
			break;
		case "10": return "Oct.";
			break;
		case "11": return "Nov.";
			break;
		case "12": return "Dic.";
			break;
		default:break;
	}
}

function proceMesLarge(value){
	switch(value){
		case "01": return "Enero";
			break;
		case "02": return "Febrero";
			break;
		case "03": return "Marzo";
			break;
		case "04": return "Abril";
			break;
		case "05": return "Mayo";
			break;
		case "06": return "Junio";
			break;
		case "07": return "Julio";
			break;
		case "08": return "Agosto";
			break;
		case "09": return "Setiembre";
			break;
		case "10": return "Octubre";
			break;
		case "11": return "Noviembre";
			break;
		case "12": return "Diciembre";
			break;
		default:break;
	}
}