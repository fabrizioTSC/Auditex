<?php
	include('connection.php');
	if (isset($_POST['username'])) {
		$sql="select * from USUARIO where aliusu='".$_POST['username']."'";
		$stmt = oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		//$result=mysqli_query($conn,$sql);
		$row=oci_fetch_array($stmt,OCI_ASSOC);
		if (oci_num_rows($stmt)>0) {
			if ($_POST['password']==$row['PASSWORDUSU']) {
				session_start();
				$_SESSION['user']=$_POST['username'];
				$_SESSION['perfil']=$row['CODROL'];
				$_SESSION['codusu']=$row['CODUSU'];
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