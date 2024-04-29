<?php 
	set_time_limit(240);
	include('../connection.php');
	header("Pragma: public");
	header("Expires: 0");
	$filename = "Reporte_eficiencia_lineas.xls";
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=$filename");
	header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    
?>

<div style="font-size: 20px;font-weight: bold;">Reporte de registros inspecci&oacute;n</div>

<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $_GET['inicio']; ?> al <?php echo $_GET['fin']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Linea</th>
			<th style="border:1px solid #333;">Taller/Linea</th>
			<th style="border:1px solid #333;">Turno</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo servicio</th>
			<th style="border:1px solid #333;">Codigo Inspeccion</th>
			<th style="border:1px solid #333;">Operaci&oacute;n</th>
			<th style="border:1px solid #333;">Defecto</th>
			<th style="border:1px solid #333;">Candet</th>
			<th style="border:1px solid #333;">Usuario</th>
			<th style="border:1px solid #333;">Apellidos y nombres</th>
			<th style="border:1px solid #333;">Fecha</th>
		</tr>
	</thead>
	<tbody>
    <?php
							include('../../config/connection.php');

							//CREANDO CURSOR
							$OUTPUT_CUR=oci_new_cursor($conn);
							//EJECUTANDO CONSULTA
							$sql="BEGIN SP_LISTAR_REGISTROS_INSPECCION(:I_LINEAS,:I_FECHAI,:I_FECHAF,:OUTPUT_CUR); END;";		
							$stmt=oci_parse($conn,$sql);

							$linea = $_GET['lineas'];
							$linea2 = "'".$_GET['inicio']."'";
							$linea3 =  "'".$_GET['fin']."'";


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
								
								echo "<tr> ";
								echo "<td style='border:1px solid #333;'>{$fila['FICHA']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['DESCOM']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['TURINSCOS']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['SEDE']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['DESTIPSERV']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['CODINSCOS']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['DESOPE']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['DESDEF']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['CANDET']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['CODUSU']}</td>";
								echo "<td style='border:1px solid #333;'>{$fila['NOMUSU']}</td>";
								echo "<td style='border:1px solid #333;'>{$fecha}</td>";
								echo "</tr>";

							}
							
					?>
	</tbody>
</table>