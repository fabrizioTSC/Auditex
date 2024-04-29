$(document).ready(function(){
	var arrayInputs=document.getElementsByClassName("divBtnsAddMinus");
	for (var i = 0; i < arrayInputs.length; i++) {
		if(arrayInputs[i].innerHTML!="0"){
			addValueSpecial(arrayInputs[i].dataset.ope,arrayInputs[i].dataset.def,arrayInputs[i].innerHTML);
		}
	}
});

function addValueSpecial(ope,def,val){
	var canope=parseInt($("#ope"+ope).text())+parseInt(val);
	$("#ope"+ope).html(canope);
	var candef=parseInt($("#def"+def).text())+parseInt(val);
	$("#def"+def).html(candef);
	var cantotal=parseInt($("#idTotalAll").text())+parseInt(val);
	$("#idTotalAll").html(cantotal);
}