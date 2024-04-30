<?php
	include('connection.php'); // Asegúrate de que este archivo de conexión esté configurado para SQL Server.
	session_start();
	$response = new stdClass();

	if ($_FILES['file']) {
        $tmp_name = $_FILES["file"]["tmp_name"];
        $name = basename($_FILES["file"]["name"]);

        // Preparamos el SQL para ejecutar el procedimiento almacenado.
		$sql = "EXEC [AUDITEX].[SP_AFC_INSERT_LOGCARCSV] 
                    @P_ESTTSC = ?, 
                    @P_HILO = ?, 
                    @P_TRAVEZ = ?, 
                    @P_LARGMANGA = ?, 
                    @P_CODUSU = ?, 
                    @P_CARGADO = ?, 
                    @P_NOMARCHIVO = ?, 
                    @P_FECHA = ?"; // SQL Server utiliza "?" para los parámetros en las sentencias preparadas.
                    
		$stmt = sqlsrv_prepare($conn, $sql, array(
            &$_POST['esttsc'],
            &$_POST['hilo'],
            &$_POST['travez'],
            &$_POST['largmanga'],
            &$_SESSION['user'],
            &$_POST['cargado'],
            &$name,
            &$fecha // Asegúrate de que esta variable tenga el valor deseado antes de usarla.
        ));

        // Verifica si la sentencia se preparó correctamente
        if (!$stmt) {
            echo "Error en la preparación de la sentencia: ".print_r(sqlsrv_errors(), true);
            exit;
        }

		$result = sqlsrv_execute($stmt);

        // Verifica si la ejecución fue exitosa
        if ($result === false) {
            echo "Error al ejecutar la consulta: ".print_r(sqlsrv_errors(), true);
            exit;
        }

		if (!file_exists('../../carga-csv-afc')) {
		    mkdir('../../carga-csv-afc', 0777, true);
		}
		if (move_uploaded_file($tmp_name, "../../carga-csv-afc/".
			$_POST['esttsc']."-".
			$_POST['hilo']."-".
			$_POST['travez']."-".
			$_POST['largmanga']."-".$fecha.".csv")) {
			$response->state = true;
		} else {
			$response->state = false;
			$response->detail = "Archivo CSV no se guardó";
		}
	} else {
		$response->state = false;
		$response->detail = "No existe el CSV";
	}

	header('Content-Type: application/json');
	echo json_encode($response);
?>
