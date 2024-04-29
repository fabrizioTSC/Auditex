<?php
	include('connection.php');
	$response=new stdClass();

		$parametrosreportes=[];
		$i=0;
		
		$stmt = oci_parse($conn,'BEGIN SP_INSP_SEL_PARAMETROSREPORTES(:CODTAD, :OUTPUT_CUR); END;');                     
		$codtad = 102;
		oci_bind_by_name($stmt,':CODTAD',$codtad);   
		// Declare your cursor         
		$OUTPUT_CUR = oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);    
		// Execute statement               
		$result=oci_execute($stmt); 
		// Execute the cursor
		oci_execute($OUTPUT_CUR);
		while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
		
//		$sql="SELECT *		FROM parametrosreportes pr inner join tipoauditoria ta on pr.CODTAD=ta.CODTAD where pr.codtad in (101,102) order by CODRAN";
//		$stmt=oci_parse($conn, $sql);
//		$result=oci_execute($stmt);
//		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$obj=new stdClass();
			$obj->CODTAD=$row['CODTAD'];
			$obj->DESTAD=utf8_encode($row['DESTAD']);
			$obj->DESCRI=utf8_encode($row['DESCRI']);
			$obj->CODRAN=$row['CODRAN'];
			$obj->VALOR=$row['VALOR'];
			$parametrosreportes[$i]=$obj;
			$i++;
		}
		$response->state=true;
		$response->parametrosreportes=$parametrosreportes;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>