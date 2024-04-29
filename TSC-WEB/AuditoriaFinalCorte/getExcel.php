<!DOCTYPE html>
<html>
<head>
	<title>Get EXCEL</title>
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<input type="file" id="inputFile">
	<script type="text/javascript">
		$("#inputFile").change(function(evt){
			var f = evt.target.files[0]; 
	        if (f){
		        var r = new FileReader();
		        r.onload = function(e){
		            var ar1=e.target.result.split("\n");
		            var ar_pos=[];
		            var ar2=ar1[0].split(",");
		            for (var i = 0; i < ar2.length; i++) {
		            	if(ar2[i]!=""){
		            		ar_pos.push(i);
		            	}
		            }
		            var ar_send=[];
		            for (var i = 0; i < ar1.length; i++) {
		            	var ar_aux=ar1[i].split(",");
		            	var aux=[];
		            	for (var j = 0; j < ar_pos.length; j++) {
		            		aux.push(ar_aux[ar_pos[j]]);
		            	}
		            	if(aux[0]!=""){
			            	ar_send.push(aux);
			            }
		            }
		            console.log(ar_send);
		            //NOMBRE DEL ARCHIVO
		            console.log(f.name.substr(0,f.name.indexOf(".")));
		        };
	            r.readAsText(f);
	        }else{
	            console.log("failed");
	        }
		});
	</script>
</body>
</html>