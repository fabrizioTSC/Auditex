<?php
	/*$local=false;
	if ($local==true) {
		//$conn=mysqli_connect('localhost','root','','tsc');
		$conn=mysqli_connect('localhost','root','','auditex');
	}else{
		//$conn=mysqli_connect('localhost','root','','auditex');
		//mysqli_set_charset( $conn, 'utf8' ); 	
		//$conn = oci_connect("AUDITEX", "auditex", "localhost/xe"); 
		//$conn = oci_connect("AUDITEX", "oracle", "DBSYSTEX"); 
		$conn = oci_connect("AUDITEX", "oracle", "(DESCRIPTION =    (ADDRESS_LIST =      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.87.26)(PORT = 1521))    )    (CONNECT_DATA =      (SERVER = DEDICATED)      (SERVICE_NAME = dbsystex)    )  )","AL32UTF8"); 
		
	} */
	$conn = sqlsrv_connect("172.16.84.221", array("Database" => "SIGE_AUDITEX_PRUEBA_2", "Uid" => "sa", "PWD" => "Developer2024$"));
	if (!$conn) {
		die(print_r(sqlsrv_errors(), true));
	}
?>