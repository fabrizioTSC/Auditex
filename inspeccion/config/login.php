<?php
	session_start();
	include('connection.php');
	if (isset($_POST['username'])) {
		$sql="select codusu, codrol, trim(passwordusu) passwordusu  from USUARIO where aliusu='".$_POST['username']."'";
		$result = oci_parse($conn, $sql);
		$result2 = oci_execute($result);
		$row=oci_fetch_array($result,OCI_ASSOC);
		if (oci_num_rows($result)>0) {
			$obj = oci_fetch_object($result);
			if ($_POST['password']==$row['PASSWORDUSU']){
				$_SESSION['user-ins']=$_POST['username'];
				$_SESSION['perfil-ins']=$row['CODROL'];
				$_SESSION['codusu-ins']=$row['CODUSU'];
				header('Location: ../main.php');	
			}else{
				$_SESSION['error']=1;
				header('Location: ../index.php');
			}
		}else{
			if (!$conn) { 
				$_SESSION['error']=2;
			}else{
				$_SESSION['error']=3;
			}
			header('Location: ../index.php');
		}
	}else{
		echo "Debe ser un metodo post.";
	}
?>