<?php
	include('connection.php');
	$response=new stdClass();

	$nuevo=$_POST['nuevo'];
	$fecha=date('YmdHis');
	$nombre="MED".$_POST['po']."-".$fecha.".pdf";
	$tmp=$_FILES['file']['tmp_name'];

	if (move_uploaded_file($tmp, "../../pdf-ReportesLE/".$nombre)) {
		if ($nuevo=="1") {
			if(!unlink("../../pdf-ReportesLE/".$_POST['rutpdfant'])){
				$response->state=false;
				$response->detail="No se pudo eliminar PDF anterior";
			}else{
				$sql="BEGIN SP_RLE_INSERT_REPMEDPDF(:PO,:PACLIS,:RUTPDF); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':PO', $_POST['po']);
				oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
				oci_bind_by_name($stmt, ':RUTPDF', $nombre);
				$result=oci_execute($stmt);
				$response->state=true;
			}
		}else{
			$sql="BEGIN SP_RLE_INSERT_REPMEDPDF(:PO,:PACLIS,:RUTPDF); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PO', $_POST['po']);
			oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
			oci_bind_by_name($stmt, ':RUTPDF', $nombre);
			$result=oci_execute($stmt);
			$response->state=true;
		}
	}else{
		$response->state=false;
		$response->detail="No se pudo cargar nuevo PDF";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
