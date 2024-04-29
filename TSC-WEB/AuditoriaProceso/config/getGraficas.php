<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['request'])) {
		$sql="select * from Taller where estado='A'";
		$result=mysqli_query($conn,$sql);
		$talleres=array();
		$i=0;
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
			$taller=new stdClass();
			$taller=$row;
			$talleres[$i]=$taller;
			$i++;
		}
		$response->state=true;
		$response->talleres=$talleres;
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->err=$error;
	}
	header('Content-Type: application/json');
	echo json_encode($response);
?>