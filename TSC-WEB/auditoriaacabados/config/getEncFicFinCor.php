<?php
	include('connection.php');
    $response=new stdClass();

    $fichas=[];
    $i=0;
    $path="No hay estilo!";
	$sql="BEGIN spu_encogimientos_j(:CODFIC,:OUTPUT_CUR); END;";
    $stmt=oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
    oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
        $obj=new stdClass();
        $obj->hilo       = str_replace(",",".",$row["HILO"]);
        $obj->travez     = str_replace(",",".",$row["TRAVEZ"]);
        $obj->largmanga  = str_replace(",",".",$row["LARGMANGA"]);
        $fichas[$i]=$obj;
        $i++;
    }
    $response->fichas=$fichas;
    if ($i==0) {
        $response->state=false;
        $response->detail="No hay encogimientos para la ficha";
    }else{
        $response->state=true;
    }

    oci_close($conn);
    header('Content-Type: application/json');
    echo json_encode($response);
?>