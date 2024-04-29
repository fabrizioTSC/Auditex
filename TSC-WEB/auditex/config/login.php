<?php
	set_time_limit(240);
	include('connection.php');
	if (isset($_POST['username'])) {
		$sql="BEGIN SP_AT_SELECT_USUARIOLOGIN(:ALIUSU,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':ALIUSU', $_POST['username']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		if (oci_num_rows($stmt)>0) {
			if ($_POST['password']==$row['PASSWORDUSU']) {
				session_start();

				//VARIABLES DE SESION
				$_SESSION['user']		=	$_POST['username'];
				$_SESSION['perfil']		=	$row['CODROL'];
				$_SESSION['codusu']		=	$row['CODUSU'];

				$accesos=array();
				$i=0;
				$sql="BEGIN SP_AT_SELECT_USUACC(:CODUSU,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':CODUSU', $row['CODUSU']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				while($row=oci_fetch_assoc($OUTPUT_CUR)){
					$obj=new stdClass();
					$obj->CODTAD=$row['CODTAD'];
					$obj->DESTAD=$row['DESTAD'];
					$obj->RUTAPL=$row['RUTAPL'];
					$obj->CODROL=$row['CODROL'];
					$obj->DESROL=$row['DESROL'];
					$accesos[$i]=$obj;
					$i++;
				}
				$_SESSION['accesos']=json_encode($accesos);

				echo json_encode(array("success"=> true));

				//header('Location: ../main.php');
			}else{
				$_SESSION['error']=1;
				//header('Location: ../index.php');
				echo json_encode(array("success"=> false));

			}
		}else{
			$_SESSION['error']=0;
			//header('Location: ../index.php');
			echo json_encode(array("success"=> false));

		}
	}else{
		echo "Debe ser un metodo post.";
	}
?>