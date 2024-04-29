<?php 
function add_cero($valor){
	$valor="".$valor;
	if (strlen($valor)>1) {
		if ($valor[0]=="," || $valor[0]==".") {
			return "0".$valor;
		}
		if (($valor[1]=="," && $valor[0]=="-")||($valor[1]=="." && $valor[0]=="-")) {
			return str_replace("-","-0",$valor);
		}
	}
	return $valor;
}
header("Pragma: public");
header("Expires: 0");
$filename = "Auditoria_Tela_".$_GET['partida'].".xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
function show_resultado($text){
	if ($text=="A") {
		return "Aprobado";
	}else{
		if ($text=="C") {
			return "Aprobado no conforme";
		}else{
			return "Rechazado";
		}
	}
}
?>
<div style="font-size: 20px;font-weight: bold;">Auditor&iacute;a Tela</div>
<br>
<div style="font-weight: bold;">Partida: <?php echo $_GET['partida']; ?></div>
<div style="font-weight: bold;">Cliente: <?php echo $_GET['cli']; ?></div>
<div style="font-weight: bold;">Proveedor: <?php echo $_GET['prov']; ?></div>
<div style="font-weight: bold;">C&oacute;digo de tela: <?php echo $_GET['codtel']; ?></div>
<div style="font-weight: bold;">Art&iacute;culo: <?php echo $_GET['art']; ?></div>
<div style="font-weight: bold;">Color: <?php echo $_GET['col']; ?></div>
<div style="font-weight: bold;">Composici&oacute;n: <?php echo $_GET['com']; ?></div>
<div style="font-weight: bold;">Programa: <?php echo $_GET['prog']; ?></div>
<div style="font-weight: bold;">X-Factory: <?php echo $_GET['xfac']; ?></div>
<div style="font-weight: bold;">Destino: <?php echo $_GET['des']; ?></div>
<div style="font-weight: bold;">Peso (Kg.): <?php echo $_GET['pes']; ?></div>
<div style="font-weight: bold;">Peso Programado (Kg.): <?php echo $_GET['pesoprg']; ?></div>
<div style="font-weight: bold;">Rendimiento por peso: <?php echo $_GET['ren']; ?></div>
<div style="font-weight: bold;">Auditor: <?php echo $_GET['auditor']; ?></div>
<div style="font-weight: bold;">Supervisor: <?php echo $_GET['supervisor']; ?></div>
<div style="font-weight: bold;">Fecha inicio: <?php echo $_GET['feciniaud']; ?></div>
<div style="font-weight: bold;">Fecha fin: <?php echo $_GET['fecfinaud']; ?></div>
<div style="font-weight: bold;">Ruta tela: <?php echo $_GET['ruttel']; ?></div>
<div style="font-weight: bold;">Est. Cliente: <?php echo $_GET['estcliestcon']; ?></div>
<div style="font-weight: bold;">CMC Proveedor: <?php echo $_GET['cmcprv']; ?></div>
<div style="font-weight: bold;">CMC WTS: <?php echo $_GET['cmcwts']; ?></div>
<?php 
	if ($_GET['estcon']!="") {
		echo '<div style="font-weight: bold;">Estudio de consumo: '.$_GET['estcon'].'</div>';
	}
?>
<?php 
	if ($_GET['datcol']!="") {
		echo '<div style="font-weight: bold;">Dato color: '.$_GET['datcol'].'</div>';
	}
?>
<?php 
	if ($_GET['motivo']!="") {
		echo '<div style="font-weight: bold;">Motivo: '.$_GET['motivo'].'</div>';
	}
?>
<br>
<?php
	include('../connection.php');	

	$sql="BEGIN SP_AUDTEL_SELECT_RESULTADOS(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :PESO, :PESOAUD, :PESOAPRO, :PESOCAI, :CALIFICACION, :TIPO, :RESULTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
	oci_bind_by_name($stmt, ':PESO', $peso,40);
	oci_bind_by_name($stmt, ':PESOAUD', $pesoaud,40);
	oci_bind_by_name($stmt, ':PESOAPRO', $pesoapro,40);
	oci_bind_by_name($stmt, ':PESOCAI', $pesocai,40);
	oci_bind_by_name($stmt, ':CALIFICACION', $calificacion,40);
	oci_bind_by_name($stmt, ':TIPO', $tipo,40);
	oci_bind_by_name($stmt, ':RESULTADO', $resultado,40);
	$result=oci_execute($stmt);
?>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Resultado Auditor&iacute;a</th>						
			<th style="border:1px solid #333;"><?php echo show_resultado($resultado); ?></th>
		</tr>
		<tr>
			<th style="border:1px solid #333;">Puntaje partida</th>						
			<th style="border:1px solid #333;"><?php echo $calificacion; ?></th>
		</tr>
		<tr>
			<th style="border:1px solid #333;">Calificaci&oacute;n partida</th>							
			<th style="border:1px solid #333;"><?php echo $tipo; ?></th>
		</tr>
	</thead>
</table>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;"></th>						
			<th style="border:1px solid #333;">KG.</th>
			<th style="border:1px solid #333;">%</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="border:1px solid #333;">KG. Partida</td>
			<td style="border:1px solid #333;"><?php echo str_replace(",", ".", $peso); ?></td>
			<td style="border:1px solid #333;">100%</td>
		</tr>
		<tr>
			<td style="border:1px solid #333;">KG. Auditado</td>
			<td style="border:1px solid #333;"><?php echo str_replace(",", ".", $pesoaud); ?></td>
			<?php
			if ($peso!=0) {
			?>
			<td style="border:1px solid #333;"><?php echo (round(floatval(str_replace(",", ".", $pesoaud))*10000/floatval(str_replace(",", ".", $peso)))/100)."%"; ?></td>
			<?php
			}else{
			?>
			<td style="border:1px solid #333;"><?php echo "0%"; ?></td>
			<?php
			}
			?>
		</tr>
		<tr>
			<td style="border:1px solid #333;">KG. Aprovechable</td>
			<td style="border:1px solid #333;"><?php echo str_replace(",", ".", $pesoapro); ?></td>
			<?php
			if ($peso!=0) {
			?>
			<td style="border:1px solid #333;"><?php echo (round(floatval(str_replace(",", ".", $pesoapro))*10000/floatval(str_replace(",", ".", $peso)))/100)."%"; ?></td>
			<?php
			}else{
			?>
			<td style="border:1px solid #333;"><?php echo "0%"; ?></td>
			<?php
			}
			?>
		</tr>
		<tr>
			<td style="border:1px solid #333;">KG. Caida</td>
			<td style="border:1px solid #333;"><?php echo str_replace(",", ".", $pesocai); ?></td>
			<?php
			if ($peso!=0) {
			?>
			<td style="border:1px solid #333;"><?php echo (round(floatval(str_replace(",", ".", $pesocai))*10000/floatval(str_replace(",", ".", $peso)))/100)."%"; ?></td>
			<?php
			}else{
			?>
			<td style="border:1px solid #333;"><?php echo "0%"; ?></td>
			<?php
			}
			?>
		</tr>
	</tbody>
</table>
<?php
	$sql="BEGIN SP_AUDTEL_VALIDAR_NUMFORM(:PARTIDA,:CODPRV,:NUMVEZ,:NUMFORM,:RES1,:RES2,:RES3); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
	oci_bind_by_name($stmt, ':NUMFORM', $numform,40);
	oci_bind_by_name($stmt, ':RES1', $res1,40);
	oci_bind_by_name($stmt, ':RES2', $res2,40);
	oci_bind_by_name($stmt, ':RES3', $res3,40);
	$result=oci_execute($stmt);
?>
<br>
<div style="font-weight: bold;">1. TONO</div>
<div style="font-weight: bold;">Calificaci&oacute;n: <?php echo show_resultado($res1); ?></div>
<?php
if ($_GET['respon1']!="") {
?>
<div style="font-weight: bold;">Responsable: <?php echo $_GET['respon1']; ?></div>
<div style="font-weight: bold;">Encargado: <?php echo $_GET['encar1']; ?></div>
<?php
}
if ($_GET['obs1']!="") {
?>
<div style="font-weight: bold;">Observaci&oacute;n: <?php echo $_GET['obs1']; ?></div>
<?php
}
?>
<br>
<div style="font-weight: bold;">2. APARIENCIA</div>
<div style="font-weight: bold;">Calificaci&oacute;n: <?php echo show_resultado($res2); ?></div>
<?php
if ($_GET['respon2']!="") {
?>
<div style="font-weight: bold;">Responsable: <?php echo $_GET['respon2']; ?></div>
<div style="font-weight: bold;">Encargado: <?php echo $_GET['encar2']; ?></div>
<?php
}
if ($_GET['obs2']!="") {
?>
<div style="font-weight: bold;">Observaci&oacute;n: <?php echo $_GET['obs2']; ?></div>
<?php
}
?>
<br>
<div style="font-weight: bold;">3. ESTABILIDAD DIMENSIONAL</div>
<div style="font-weight: bold;">Calificaci&oacute;n: <?php echo show_resultado($res3); ?></div>
<?php
if ($_GET['respon3']!="") {
?>
<div style="font-weight: bold;">Responsable: <?php echo $_GET['respon3']; ?></div>
<div style="font-weight: bold;">Encargado: <?php echo $_GET['encar3']; ?></div>
<?php
}
if ($_GET['obs3']!="") {
?>
<div style="font-weight: bold;">Observaci&oacute;n: <?php echo $_GET['obs3']; ?></div>
<?php
}
?>
<br>
<div style="font-weight: bold;">4. CONTROL DE DEFECTOS</div>
<div style="font-weight: bold;">Calificaci&oacute;n: <?php echo $_GET['resblo4']; ?></div>
<?php
if ($_GET['respon4']!="") {
?>
<div style="font-weight: bold;">Responsable: <?php echo $_GET['respon4']; ?></div>
<div style="font-weight: bold;">Encargado: <?php echo $_GET['encar4']; ?></div>
<?php
}
if ($_GET['obs4']!="") {
?>
<div style="font-weight: bold;">Observaci&oacute;n: <?php echo $_GET['obs4']; ?></div>
<?php
}
?>
<br>
<?php
	if ($res1!=null) {
		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDTONEXC(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
?>
<div style="font-weight: bold;">1. TONO</div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">CONTROL DE TONO</th>
			<th style="border:1px solid #333;">TSC</th>
			<th style="border:1px solid #333;">RECOMENDACI&Oacute;N 1</th>
			<th style="border:1px solid #333;">RECOMENDACI&Oacute;N 2</th>
		</tr>
	</thead>
	<tbody>
<?php
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['DESTON']; ?></td>
			<td style="border:1px solid #333;"><?php echo show_resultado($row['RESTSC']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESREC1']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESREC2']); ?></td>
		</tr>
<?php
		}
?>
	</tbody>
</table>
<div style="font-weight: bold;">Calificaci&oacute;n: <?php echo show_resultado($res1); ?></div>
<?php
		if ($_GET['respon1']!="") {
?>
<div style="font-weight: bold;">Responsable: <?php echo $_GET['respon1']; ?></div>
<div style="font-weight: bold;">Encargado: <?php echo $_GET['encar1']; ?></div>
<?php
		}
	}
	if ($res2!=null) {
		$detalle2=array();
		$i=0;
		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDCAEXC(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
?>
<br>
<div style="font-weight: bold;">2. APARIENCIA</div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">&Aacute;REA</th>						
			<th style="border:1px solid #333;">C. APARIENCIA</th>
			<th style="border:1px solid #333;">TSC</th>
			<th style="border:1px solid #333;">RECOMENDACI&Oacute;N</th>
			<th style="border:1px solid #333;">CM.</th>
			<!--
			<th style="border:1px solid #333;">% CAIDA</th>-->
		</tr>
	</thead>
	<tbody>
<?php
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['DSCAREAD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESAPA']; ?></td>
			<td style="border:1px solid #333;"><?php echo show_resultado($row['RESTSC']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESREC1']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['CM']); ?></td>
			<!--
			<td style="border:1px solid #333;"><?php //echo str_replace(",",".",$row['CAIDA']); ?></td>-->
		</tr>
<?php
		}
?>
	</tbody>
</table>
<div style="font-weight: bold;">Calificaci&oacute;n: <?php echo show_resultado($res2); ?></div>
<?php
		if ($_GET['respon2']!="") {
?>
<div style="font-weight: bold;">Responsable: <?php echo $_GET['respon2']; ?></div>
<div style="font-weight: bold;">Encargado: <?php echo $_GET['encar2']; ?></div>
<?php
		}
		if ($_GET['aud2']!="") {
?>
<div style="font-weight: bold;">Auditor: <?php echo $_GET['aud2']; ?></div>
<?php
		}
		if ($_GET['coo2']!="") {
?>
<div style="font-weight: bold;">Coordinador: <?php echo $_GET['coo2']; ?></div>
<?php
		}
	}
	if ($res3!=null) {
		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDEDEXCV2(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
?>
<br>
<div style="font-weight: bold;">3. ESTABILIDAD DIMENSIONAL</div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">CARACTERISTICA</th>						
			<th style="border:1px solid #333;">TOLERANCIA</th>
			<th style="border:1px solid #333;">ESTANDAR</th>v
			<th style="border:1px solid #333;">TSC</th>
			<th style="border:1px solid #333;">TESTING</th>
			<th style="border:1px solid #333;">CONCLUSI&Oacute;N</th>
			<th style="border:1px solid #333;">RECOMENDACI&Oacute;N</th>
			<!---
			<th style="border:1px solid #333;">% CAIDA</th>-->
		</tr>
	</thead>
	<tbody>
<?php
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$tolerancia=$row['TOLERANCIA'];
			if ((int)$row['TOLERANCIA']!=0) {
				$tolerancia="+/- ".$row['TOLERANCIA']." ".$row['DIMTOL'];
			}
			$valor=floatval(str_replace(",",".",$row['VALOR']));
			$valor2=floatval(str_replace(",",".",$row['VALORTSC']));
			if ($row['DIMVAL']=="%") {
				$valor=(floatval("0".str_replace(",",".",$row['VALOR'])))." ".$row['DIMVAL'];
				$valor2=floatval(str_replace(",",".",add_cero($row['VALORTSC'])))." ".$row['DIMVAL'];
			}
?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['DESESTDIM']; ?></td>
			<td style="border:1px solid #333;"><?php echo $tolerancia; ?></td>
			<td style="border:1px solid #333;"><?php echo $valor; ?></td>
			<td style="border:1px solid #333;"><?php echo $valor2; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['TESTINGF']; ?></td>
			<td style="border:1px solid #333;"><?php echo show_resultado($row['RESTSC']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESREC1']); ?></td>
			<!--
			<td style="border:1px solid #333;"><?php //echo str_replace(",", ".", $row['CAIDA']); ?></td>-->
		</tr>
<?php					
		}
?>
	</tbody>
</table>
<div style="font-weight: bold;">Calificaci&oacute;n: <?php echo show_resultado($res3); ?></div>
<?php
		if ($_GET['respon3']!="") {
?>
<div style="font-weight: bold;">Responsable: <?php echo $_GET['respon3']; ?></div>
<div style="font-weight: bold;">Encargado: <?php echo $_GET['encar3']; ?></div>
<?php
		}
		if ($_GET['aud3']!="") {
?>
<div style="font-weight: bold;">Auditor: <?php echo $_GET['aud3']; ?></div>
<?php
		}
		if ($_GET['coo3']!="") {
?>
<div style="font-weight: bold;">Coordinador: <?php echo $_GET['coo3']; ?></div>
<?php
		}
	}
?>
<br>
<div style="font-weight: bold;">4. CONTROL DE DEFECTOS</div>
<div style="font-weight: normal;">Rollos: <?php echo $_GET['numrollos']; ?> - Rollos a auditar: <?php echo $_GET['audrollos']; ?></div>
<div style="font-weight: normal;">Calificaci&oacute;n: <?php echo $_GET['cali4']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">N. ROLLO</th>						
			<th style="border:1px solid #333;">ANCHO SIN REPOSO</th>
			<th style="border:1px solid #333;">DENSIDAD SIN REPOSO</th>
			<th style="border:1px solid #333;">PESO POR ROLLO</th>
<?php			
	$sql="BEGIN SP_AUDTEL_SELECT_DEFROLEXC(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
?>
			<th style="border:1px solid #333;"><?php echo $row['DSCAREAD']." - ".$row['DESDEF']." (".$row['PUNTOS'].")"; ?></th>
<?php
	}
?>
			<th style="border:1px solid #333;">TOTAL PUNTOS</th>
			<th style="border:1px solid #333;">METROS</th>
			<th style="border:1px solid #333;">ANCHO TOTAL</th>
			<th style="border:1px solid #333;">ANCHO UTIL CON REPOSO</th>
			<th style="border:1px solid #333;">INCLINACI&Oacute;N STD</th>
			<th style="border:1px solid #333;">INCLINACI&Oacute;N DER</th>
			<th style="border:1px solid #333;">INCLINACI&Oacute;N IZQ</th>
			<th style="border:1px solid #333;">INCLINACI&Oacute;N MED</th>
			<th style="border:1px solid #333;">RAPPORT</th>
			<th style="border:1px solid #333;">PUNTOS POR ROLLO</th>
			<th style="border:1px solid #333;">CALIFICACI&Oacute;N POR ROLLO</th>
		</tr>
	</thead>
	<tbody>
<?php
	$sql="BEGIN SP_AUDTEL_SELECT_PARROL(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['NUMROL']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ANCSINREP']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DENSINREP']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PESO']; ?></td>
<?php
		$sql="BEGIN SP_AUDTEL_SELECT_PARROLDEF(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:NUMROL,:OUTPUT_CUR); END;";
		$stmt2=oci_parse($conn, $sql);
		oci_bind_by_name($stmt2, ':PARTIDA', $_GET['partida']);
		oci_bind_by_name($stmt2, ':CODTEL', $_GET['codtel']);
		oci_bind_by_name($stmt2, ':CODPRV', $_GET['codprv']);
		oci_bind_by_name($stmt2, ':CODTAD', $_GET['codtad']);
		oci_bind_by_name($stmt2, ':NUMVEZ', $_GET['numvez']);
		oci_bind_by_name($stmt2, ':PARTE', $_GET['parte']);
		oci_bind_by_name($stmt2, ':NUMROL', $row['NUMROL']);
		$OUTPUT_CUR2=oci_new_cursor($conn);
		oci_bind_by_name($stmt2, ':OUTPUT_CUR', $OUTPUT_CUR2,-1,OCI_B_CURSOR);
		$result2=oci_execute($stmt2);
		oci_execute($OUTPUT_CUR2);
		$totpuntos=0;
		while($row2=oci_fetch_assoc($OUTPUT_CUR2)){
?>
			<td style="border:1px solid #333;"><?php echo $row2['CANTIDAD']; ?></td>
<?php
			$totpuntos+=intval($row2['PESO'])*intval($row2['CANTIDAD']);
		}
?>
			<td style="border:1px solid #333;"><?php echo $totpuntos; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['METLIN']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ANCTOT']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ANCUTI']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['INCSTD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['INCDER']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['INCIZQ']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['INCMED']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RAPPORT']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PUNTOS']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CALIFICACION']; ?></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
<br>
<?php
if ($_GET['respon4']!="") {
?>
<div style="font-weight: bold;">Responsable: <?php echo $_GET['respon4']; ?></div>
<div style="font-weight: bold;">Encargado: <?php echo $_GET['encar4']; ?></div>
<?php
}
?>