<?php
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
		if (oci_num_rows($OUTPUT_CUR)>0) {
			if ($_POST['password']==$row['PASSWORDUSU']) {
				session_start();
				$_SESSION['user-afc']=$_POST['username'];
				$_SESSION['perfil-afc']=$row['CODROL'];
				$_SESSION['codusu-afc']=$row['CODUSU'];
				header('Location: ../main.php');
			}else{
				$_SESSION['error']=1;
				header('Location: ../index.php');
			}
		}else{
			$_SESSION['error']=0;
			header('Location: ../index.php');
		}
	}else{
		echo "Debe ser un metodo post.";
	}
?>