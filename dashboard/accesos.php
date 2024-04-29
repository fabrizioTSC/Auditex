<?php

	$conn = oci_connect("AUDITEX", "oracle", "(DESCRIPTION =    (ADDRESS_LIST =      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.87.26)(PORT = 1521))    )    (CONNECT_DATA =      (SERVER = DEDICATED)      (SERVICE_NAME = dbsystex)    )  )",'AL32UTF8'); 
	$response=new stdClass();

    $permisos = array();
    

	$i=0;
    $sql = "BEGIN TSCSP_GET_ACCESO (:P_CODUSU,:O_CURSOR); END;";

	$stmt=oci_parse($conn, $sql);
    
    oci_bind_by_name($stmt, ':P_CODUSU', $_POST['codusu']);
    
    $O_CURSOR=oci_new_cursor($conn);
    
	oci_bind_by_name($stmt, ':O_CURSOR', $O_CURSOR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
    oci_execute($O_CURSOR);

	while($row=oci_fetch_assoc($O_CURSOR)){

        $obj=new stdClass();

        $obj->CODN1 =$row['CODN1']; 
        $obj->TW1 = $row['TW1'];
        $obj->STW1 = $row['STW1'];
        $obj->IMAGEN1 = $row['IMAGEN1'];
        $obj->CODN2 = $row['CODN2']; 
        $obj->TW2 = $row['TW2'];
        $obj->IMAGEN2 = $row['IMAGEN2'];
        $obj->CODN3 = $row['CODN3']; 
        $obj->TW3 = $row['TW3'];
        $obj->IMAGEN3 = $row['IMAGEN3'];
        $obj->CODN4 = $row['CODN4']; 
        $obj->TW4 = $row['TW4'];
        $obj->IMAGEN4 = $row['IMAGEN4'];
        $obj->AU4 = $row['AU4']; 
        $obj->FW4 = $row['FW4'];
        $obj->PW4 = $row['PW4'];
        $obj->CODN5 = $row['CODN5'];
        $obj->TW5 = $row['TW5'];
        $obj->FW5 = $row['FW5']; 
        $obj->PW5 = $row['PW5'];
        $obj->IMAGEN5 = $row['IMAGEN5'];

        // AGREGADO
        $obj->FORMLOGIN = $row['FORMLOGIN4'];
        $obj->PUERTO = trim($row['PUERTO4']);
        $obj->CONTROLADOR = trim($row['CONTROLADOR4']);
        $obj->VISTA = trim($row['VISTA4']);

        $obj->FORMLOGIN5 = $row['FORMLOGIN5'];
        $obj->PUERTO5 = trim($row['PUERTO5']);
        $obj->CONTROLADOR5 = trim($row['CONTROLADOR5']);
        $obj->VISTA5 = trim($row['VISTA5']);
        
        $permisos[$i]=$obj;
        $i++;
    }

    oci_close($conn);
    header('Content-Type: application/json; charset=utf-8');
    
	echo json_encode($permisos);
?>