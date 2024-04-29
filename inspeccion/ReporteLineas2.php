<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte de Eficiencia de Lineas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine">
				<button class="btnPrimary" style="margin-top: 0px;" onclick="exportar_excel()">Descargar</button>
				<button class="btnPrimary" style="margin-top: 0px;" onclick="redirect('main.php')">Volver</button>
			</div>	
			<div class="lineDecoration"></div>	
			<div style="margin-bottom: 10px;overflow: scroll;max-height: calc(100vh - 123px);">
				<div class="tblHeader" style="width: 1300px;">
					<div class="itemHeader" style="width: 50px;text-align: center;">Ficha</div>
					<div class="itemHeader" style="width: 150px;text-align: center;">Taller / Línea </div>
					<div class="itemHeader" style="width: 50px;text-align: center;">Turno</div>
					<div class="itemHeader" style="width: 70px;text-align: center;">Sede</div>
					<div class="itemHeader" style="width: 70px;text-align: center;">Tipo Servicio</div>
					<div class="itemHeader" style="width: 100px;text-align: center;">C.Inspección</div>
					<div class="itemHeader" style="width: 150px;text-align: center;">Operación</div>
					<div class="itemHeader" style="width: 150px;text-align: center;">Defecto</div>
					<div class="itemHeader" style="width: 50px;text-align: center;">Candet</div>
					<div class="itemHeader" style="width: 80px;text-align: center;">Usuario</div>
					<div class="itemHeader" style="width: 150px;text-align: center;">Apellido y nombre</div>
					<div class="itemHeader" style="width: 70px;text-align: center;">Fecha</div>
				</div>
				<div class="tblBody" id="data-lineas" style="width: 1300px;">

					<?php
							include('config/connection.php');

							//CREANDO CURSOR
							$OUTPUT_CUR=oci_new_cursor($conn);
							//EJECUTANDO CONSULTA
							$sql="BEGIN SP_LISTAR_REGISTROS_INSPECCION(:I_LINEAS,:I_FECHAI,:I_FECHAF,:OUTPUT_CUR); END;";		
							$stmt=oci_parse($conn,$sql);

							$linea = $_GET['lineas'];
							$linea2 = "'".$_GET['finicio']."'";
							$linea3 =  "'".$_GET['ffin']."'";


							oci_bind_by_name($stmt,":I_LINEAS", $linea);
							oci_bind_by_name($stmt,":I_FECHAI", $linea2);
							oci_bind_by_name($stmt,":I_FECHAF", $linea3);
							oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR,-1,OCI_B_CURSOR);

							oci_execute($stmt);
							oci_execute($OUTPUT_CUR);

							oci_close($conn);// CERRANDO CONEXION

							//RETORNANDO EL VALOR EN UN ARRAY
							oci_fetch_all($OUTPUT_CUR, $resultado, null, null, OCI_FETCHSTATEMENT_BY_ROW);

							//IMPRIMIENDO TABLA
							foreach($resultado as $fila){		
								$fcreada = date_create($fila['FECINSCOS']);			
								$fecha = date_format($fcreada,"d/m/Y");
								
								echo "<div class='tblLine' style='width: 1280px;'> ";
								echo "<div class='itemBody' style='width: 50px;text-align: center;'>{$fila['FICHA']}</div>";
								echo "<div class='itemBody' style='width: 150px;text-align: center;'>{$fila['DESCOM']}</div>";
								echo "<div class='itemBody' style='width: 50px;text-align: center;'>{$fila['TURINSCOS']}</div>";
								echo "<div class='itemBody' style='width: 70px;text-align: center;'>{$fila['SEDE']}</div>";
								echo "<div class='itemBody' style='width: 70px;text-align: center;'>{$fila['DESTIPSERV']}</div>";
								echo "<div class='itemBody' style='width: 100px;text-align: center;'>{$fila['CODINSCOS']}</div>";
								echo "<div class='itemBody' style='width: 150px;text-align: center;'>{$fila['DESOPE']}</div>";
								echo "<div class='itemBody' style='width: 150px;text-align: center;'>{$fila['DESDEF']}</div>";
								echo "<div class='itemBody' style='width: 50px;text-align: center;'>{$fila['CANDET']}</div>";
								echo "<div class='itemBody' style='width: 80px;text-align: center;'>{$fila['CODUSU']}</div>";
								echo "<div class='itemBody' style='width: 150px;text-align: center;'>{$fila['NOMUSU']}</div>";
								echo "<div class='itemBody' style='width: 70px;text-align: center;'>{$fecha}</div>";


								echo "</div>";

							}
							//var_dump($resultado);

						//OCULTANDO LA CARGA
						echo "
						<script>
							$('.panelCarga').fadeOut(200);
						</script>
						";
					?>

					
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>

	<script>

		function exportar_excel(){
			let lineas = '<?php echo $_GET['lineas'] ?>'  ;
			let inicio = '<?php echo $_GET['finicio'] ?>' ;
			let fin = '<?php echo $_GET['ffin'] ?>' ;

			console.log(lineas,inicio,fin);

			location.href = "config/export-ins/exportRepEfiLin2.php?lineas="+lineas+"&inicio="+inicio+"&fin="+fin;

		}

	</script>

</body>
</html>