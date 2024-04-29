<?php
	set_time_limit(480);
	header("Pragma: public");
	header("Expires: 0");
	$filename = "Reporte_Indicador_Clasificación_de_Fichas.xls";
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=$filename");
	header("Pragma: no-cache");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	include("../connection.php");
?>
<div style="font-size: 20px;font-weight: bold;">Reporte Indicador Clasificaci&oacute;n de Fichas</div>
<br>
<div style="font-size: 17px;font-weight: bold;"><?php echo $_GET['titulo']; ?></div>
<br>
<?php
	$ar_header=[];
	$ar_clasi1=[];
	$ar_clasi2=[];
	$ar_clasi3=[];
	$ar_clasi4=[];
	$ar_clasi5=[];
	$ar_clasi6=[];
	$ar_clasi7=[];
	$ar_clasi8=[];
	$ar_clasi9=[];
	$ar_sum=[];

	$auxh=0;
	$aux1=0;
	$aux2=0;
	$aux3=0;
	$aux4=0;
	$aux5=0;
	$aux6=0;
	$aux7=0;
	$aux8=0;
	$aux9=0;

	function get_content_array($id){
		global $ar_clasi1;
		global $ar_clasi2;
		global $ar_clasi3;
		global $ar_clasi4;
		global $ar_clasi5;
		global $ar_clasi6;
		global $ar_clasi7;
		global $ar_clasi8;
		global $ar_clasi9;

		switch ($id) {
			case "1":
				return $ar_clasi1;
				break;
			case '2':
				return $ar_clasi2;
				break;
			case '3':
				return $ar_clasi3;
				break;
			case '4':
				return $ar_clasi4;
				break;
			case '5':
				return $ar_clasi5;
				break;
			case '6':
				return $ar_clasi6;
				break;
			case '7':
				return $ar_clasi7;
				break;
			case '8':
				return $ar_clasi8;
				break;
			case '9':
				return $ar_clasi9;
				break;			
			default:
				return [];			
				break;
		}		
	}

	function proceMes($value){
		switch($value){
			case "01": return "Ene.";
				break;
			case "02": return "Feb.";
				break;
			case "03": return "Mar.";
				break;
			case "04": return "Abr.";
				break;
			case "05": return "May.";
				break;
			case "06": return "Jun.";
				break;
			case "07": return "Jul.";
				break;
			case "08": return "Ago.";
				break;
			case "09": return "Set.";
				break;
			case "10": return "Oct.";
				break;
			case "11": return "Nov.";
				break;
			case "12": return "Dic.";
				break;
			default:break;
		}
	}

	function add_to_array($codclarec,$value,$val_sum){
		global $aux1;
		global $aux2;
		global $aux3;
		global $aux4;
		global $aux5;
		global $aux6;
		global $aux7;
		global $aux8;
		global $aux9;
		global $ar_clasi1;
		global $ar_clasi2;
		global $ar_clasi3;
		global $ar_clasi4;
		global $ar_clasi5;
		global $ar_clasi6;
		global $ar_clasi7;
		global $ar_clasi8;
		global $ar_clasi9;

		switch ($codclarec) {
			case "1":
				$ar_clasi1[$aux1]=$value;
				$aux1++;
				break;
			case '2':
				$ar_clasi2[$aux2]=$value;
				$aux2++;
				break;
			case '3':
				$ar_clasi3[$aux3]=$value;
				$aux3++;
				break;
			case '4':
				$ar_clasi4[$aux4]=$value;
				$aux4++;
				break;
			case '5':
				$ar_clasi5[$aux5]=$value;
				$aux5++;
				break;
			case '6':
				$ar_clasi6[$aux6]=$value;
				$aux6++;
				break;
			case '7':
				$ar_clasi7[$aux7]=$value;
				$aux7++;
				break;
			case '8':
				$ar_clasi8[$aux8]=$value;
				$aux8++;
				break;
			case '9':
				$ar_clasi9[$aux9]=$value;
				$aux9++;
				break;			
			default:
				break;
		}
	}
	$ar_header[$auxh]=$_GET['titulo'];	
	$auxh++;

	$clasi=[];
	$k=0;
	$sql="BEGIN SP_AT_SELECT_CLAREC(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		add_to_array($row['CODCLAREC'],$row['DESCLAREC'],0);
		$clasi[$k]=$row['CODCLAREC'];
		$k++;
	}

	$ant_name="";
	$sumaux=0;
	$j=0;
	$sql="BEGIN SP_AT_INDICADOR_CLASIFICHA(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ($ant_name=="") {
			$ant_name=$row['ANHO'];
			$ar_header[$auxh]=$ant_name;
			$auxh++;
			$sumaux+=(int)$row['CANPRE'];
		}else{
			if ($ant_name!=$row['ANHO']) {
				$ant_name=$row['ANHO'];
				$ar_header[$auxh]=$ant_name;
				$auxh++;
				$ar_sum[$j]=$sumaux;
				$j++;
				$sumaux=(int)$row['CANPRE'];	
			}else{
				$sumaux+=(int)$row['CANPRE'];
			}
		}
		add_to_array($row['CODCLAREC'],$row['CANPRE'],$row['CANPRE']);
	}
	$ar_sum[$j]=$sumaux;
	$j++;

	$ant_name="";
	$sumaux=0;
	$sql="BEGIN SP_AT_INDICADOR_CLASIFICHA(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if (!is_null($row['DESCLAREC'])) {
			if ($ant_name=="") {
				$ant_name=$row['ANHO_MES'];
				$ar_header[$auxh]=proceMes(substr($ant_name,4,5));
				$auxh++;
				$sumaux+=$row['CANPRE'];
			}else{
				if ($ant_name!=$row['ANHO_MES']) {
					$ant_name=$row['ANHO_MES'];
					$ar_header[$auxh]=proceMes(substr($ant_name,4,5));
					$auxh++;	
					$ar_sum[$j]=$sumaux;
					$j++;
					$sumaux=$row['CANPRE'];			
				}else{
					$sumaux+=(int)$row['CANPRE'];
				}
			}
			add_to_array($row['CODCLAREC'],$row['CANPRE'],$row['CANPRE']);
		}
	}
	$ar_sum[$j]=$sumaux;
	$j++;

	$ant_name="";
	$sumaux=0;
	$sql="BEGIN SP_AT_INDICADOR_CLASIFICHA(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
	$opcion=2;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ($ant_name=="") {
			$ant_name=$row['NUMERO_SEMANA'];
			$ar_header[$auxh]="S. ".$ant_name;
			$auxh++;
			$sumaux+=$row['CANPRE'];
		}else{
			if ($ant_name!=$row['NUMERO_SEMANA']) {
				$ant_name=$row['NUMERO_SEMANA'];
				$ar_header[$auxh]="S. ".$ant_name;
				$auxh++;	
				$ar_sum[$j]=$sumaux;
				$j++;
				$sumaux=$row['CANPRE'];			
			}else{
				$sumaux+=(int)$row['CANPRE'];
			}
		}
		add_to_array($row['CODCLAREC'],$row['CANPRE'],$row['CANPRE']);
	}
	$ar_sum[$j]=$sumaux;
	$j++;
?>
<table style="border-collapse: collapse;">
	<thead>
<?php
	for ($i=0; $i < count($ar_header); $i++) { 
?>
		<th style="border:1px solid #333;padding: 5px;background: #ccc;"><?php echo $ar_header[$i]; ?></th>
<?php
	}
?>
	</thead>

	<tbody>
<?php
	for ($j=0; $j < count($clasi); $j++) { 
		$array=get_content_array($clasi[$j]);
?>
		<tr>
<?php
		for ($i=0; $i < count($array); $i++) { 
			if ($i==0) {
?>
			<th style="border:1px solid #333;padding: 5px;background: #ccc;"><?php echo $array[$i]; ?></th>
<?php			
			}else{
?>
			<td style="border:1px solid #333;padding: 5px;"><?php echo $array[$i]; ?></td>
<?php
			}
		}
?>	
		</tr>
		<tr>
<?php
		$l=0;
		for ($i=0; $i < count($array); $i++) { 
			if ($i==0) {
?>
			<th style="border:1px solid #333;padding: 5px;background: #ccc;"><?php echo "% ".$array[$i]; ?></th>
<?php			
			}else{
?>
			<td style="border:1px solid #333;padding: 5px;"><?php echo (round(((int)$array[$i])*10000/((int)$ar_sum[$l]))/100)." %"; ?></td>
<?php
				$l++;
			}
		}
?>
		</tr>
<?php
	}
?>
		<tr>
			<th style="border:1px solid #333;padding: 5px;background: #ccc;">TOTAL</th>
<?php
	for ($i=0; $i < count($ar_sum); $i++) { 
?>
			<th style="border:1px solid #333;padding: 5px;background: #ccc;"><?php echo $ar_sum[$i]; ?></th>
<?php
	}
?>
		</tr>
	</tbody>
</table>