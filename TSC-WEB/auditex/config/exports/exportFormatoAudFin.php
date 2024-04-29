<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Formato_Auditoria_Final_Costura.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	include("../connection.php");
	$titulo="";
	if ($_GET['option']=="1") {
		if ($_GET['codsede']=="0") {
			$titulo.="(TODOS) / ";
		}else{
			$sql="BEGIN SP_AT_SELECT_SEDE(:CODSED,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			$row=oci_fetch_assoc($OUTPUT_CUR);
			$titulo.=utf8_encode($row['DESSEDE'])." / ";
		}
		if ($_GET['codtipser']=="0") {
			$titulo.="(TODOS) / ";
		}else{
			$sql="BEGIN SP_AT_SELECT_TIPSER(:CODTIPSER,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			$row=oci_fetch_assoc($OUTPUT_CUR);
			$titulo.=utf8_encode($row['DESTIPSERV'])." / ";
		}
		if ($_GET['codtll']=="0") {
			$titulo.="(TODOS)";
		}else{
			$sql="BEGIN SP_AT_SELECT_TALLER(:CODTLL,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			$row=oci_fetch_assoc($OUTPUT_CUR);
			$titulo.=utf8_encode($row['DESTLL']);
		}
	}else{
		if ($_GET['option']=="2") {
			$titulo="Pedido: ".$_GET['pedido'];
		}else{
			$titulo="Ficha: ".$_GET['codfic'];
		}
	}

	$sql="BEGIN SP_INSP_SELECT_DATE(:ANT,:FECHA); END;";
	$stmt=oci_parse($conn, $sql);
	$ant=0;
	oci_bind_by_name($stmt, ':ANT', $ant);
	$fecha="";
	oci_bind_by_name($stmt, ':FECHA', $fecha, 40);
	$result=oci_execute($stmt);

	$fecini=explode("-", $_GET['fecini']);
	$fecfin=explode("-", $_GET['fecfin']);

	if ($_GET['option']=="1") {
		$titulo.=" - Del ".$fecini[2]."/".$fecini[1]."/".$fecini[0]." al ".$fecfin[2]."/".$fecfin[1]."/".$fecfin[0];
	}else{
		if ($_GET['check']=="1") {
			$titulo.=" - Del ".$fecini[2]."/".$fecini[1]."/".$fecini[0]." al ".$fecfin[2]."/".$fecfin[1]."/".$fecfin[0];
		}
	}

	$fecini=$fecini[0].$fecini[1].$fecini[2];
	$fecfin=$fecfin[0].$fecfin[1].$fecfin[2];

	if ($_GET['option']=="1") {
		$sql="BEGIN SP_AT_REPORTE_DETAUDFIN(:CODTLL,:CODSED,:CODTIPSER,:FECINI,:FECFIN,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
		oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
		oci_bind_by_name($stmt, ':FECINI', $fecini);
		oci_bind_by_name($stmt, ':FECFIN', $fecfin);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
	}else{
		if ($_GET['option']=="2") {
			$sql="BEGIN SP_AT_REPORTE_DETAUDFIN2(:PEDIDO,:FECINI,:FECFIN,:CHECK,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PEDIDO', $_GET['pedido']);
			oci_bind_by_name($stmt, ':FECINI', $fecini);
			oci_bind_by_name($stmt, ':FECFIN', $fecfin);
			oci_bind_by_name($stmt, ':CHECK', $_GET['check']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
		}else{
			$sql="BEGIN SP_AT_REPORTE_DETAUDFIN3(:CODFIC,:FECINI,:FECFIN,:CHECK,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
			oci_bind_by_name($stmt, ':FECINI', $fecini);
			oci_bind_by_name($stmt, ':FECFIN', $fecfin);
			oci_bind_by_name($stmt, ':CHECK', $_GET['check']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
		}
	}
?>
<div><strong><?php echo $titulo; ?></strong></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border-top:1px solid #333;border-left:1px solid #333;"></th>
			<th style="border:1px solid #333;">FORMATO</th>
			<th style="border-top:1px solid #333;border-right:1px solid #333;">Fecha de Vigencia</th>
		</tr>
		<tr>
			<th style="border-left:1px solid #333;">C&oacute;digo</th>
			<th style="border-left:1px solid #333;border-right: 1px solid #333;"></th>
			<th style="border-right:1px solid #333;"><?php echo $fecha; ?></th>
		</tr>
		<tr>
			<th style="border-left:1px solid #333;">Edici&oacute;n N.-1</th>
			<th style="border-left:1px solid #333;border-right: 1px solid #333;">AUDITOR&Iacute;A FINAL DE COSTURA</th>
			<th style="border-right: 1px solid #333;">P&aacute;gina 1 de 1</th>
		</tr>
		<tr>
			<th style="border-bottom:1px solid #333;border-left:1px solid #333;"></th>
			<th style="border-bottom:1px solid #333;border-left:1px solid #333;border-right: 1px solid #333;"></th>
			<th style="border-bottom:1px solid #333;border-right: 1px solid #333;"></th>
		</tr>
	</thead>
</table>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Item</th>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Auditor</th>
			<th style="border:1px solid #333;">Linea/Servicio</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Estilo</th>
			<th style="border:1px solid #333;">Pedido</th>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Parte</th>
			<th style="border:1px solid #333;">Cantidad de veces auditada</th>
			<th style="border:1px solid #333;">Lote</th>
			<th style="border:1px solid #333;">Muestra</th>
			<th style="border:1px solid #333;">C&oacute;digo defecto</th>
			<th style="border:1px solid #333;">Descripci&oacute;n</th>
			<th style="border:1px solid #333;">Cantidad defecto</th>
			<th style="border:1px solid #333;">A/R</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$cont=1;
			$ant="";
			$ant_fp="";
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				$cod=$row['FECHA'].$row['FICHA'].$row['PARTE'].$row['VEZ'];
				$fp=$row['FICHA'].$row['PARTE'];
				if ($ant!=$cod) {
					if($ant_fp!=$fp and $cont!=1){
		?>
		<tr>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
		</tr>
		<?php
						$ant_fp=$fp;
					}
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $cont; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECHA'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['AUDITOR'];?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['TALLER']);?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['CLIENTE']);?></td>
			<td style="border:1px solid #333;"><?php echo $row['ESTILO'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['PEDIDO'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['FICHA'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['DSCCOL'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['PARTE'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['VEZ'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['LOTE'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['MUESTRA'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODDEF'];?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DEFECTO']);?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['RESULTADO'];?></td>
		</tr>
		<?php
					$cont++;
					$ant=$cod;
				}else{
		?>
		<tr>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"><?php echo $row['CODDEF'];?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DEFECTO']);?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF'];?></td>
			<td style="border:1px solid #333;"></td>
		</tr>
		<?php
				}
			}
			oci_close($conn);
		?>
	</tbody>
</table>