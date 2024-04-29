<?php 
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

	$sql="select * from clasificacionrecuperacion where estado='A' order by codclarec";	
	$stmt=oci_parse($conn, $sql);
	$result=oci_execute($stmt);
	$ar_header[$auxh]=$_GET['titulo'];
	$auxh++;
	$clasi=[];
	$k=0;

	while ($row=oci_fetch_array($stmt)) {
		add_to_array($row['CODCLAREC'],$row['DESCLAREC'],0);
		$clasi[$k]=$row['CODCLAREC'];
		$k++;
	}

	$whereTll="";
	$whereSede="";
	$whereTipSer="";
	if ($_GET['codtll']!=0) {
		$whereTll=" and ae.codtll='".$_GET['codtll']."'";
	}
	if ($_GET['codsede']!=0) {
		$whereSede=" and ae.codsede=".$_GET['codsede'];
	}
	if ($_GET['codtipser']!=0) {
		$whereTipSer=" and ae.codtiposerv=".$_GET['codtipser'];
	}
	$sql="select to_char(fr.fecreg,'YYYY') anho
		     , cr.desclarec, cr.codclarec, sum(frd.canpre) CANPRE
		  from (select distinct a.codenv, a.codfic, t.codtll, t.codsede, t.codtiposerv
		          from auditoriaenvio a, taller t where a.codtll = t.codtll) ae
		      , fichaauditoria fa, fichaauditoriarecuperacion fr, fichaauditoriarecuperaciondet frd, clasificacionrecuperacion cr
		 where fa.codfic = fr.codfic and fa.parte = fr.parte and fa.numvez = fr.numvez and fa.codtad = fr.codtad
		   and fr.codfic = frd.codfic and fr.parte = frd.parte and fr.numvez = frd.numvez and fr.codtad = frd.codtad
		   and frd.codclarec = cr.codclarec
		   and to_char(fr.fecreg,'YYYY')>= (to_char(add_months(sysdate,-24),'YYYY'))
		   and ae.codenv = fa.codenv
		   ".$whereTll."
		   ".$whereSede."
		   ".$whereTipSer."
		 group by to_char(fr.fecreg,'YYYY'), cr.desclarec, cr.codclarec
		 order by 1, 3
		";	
	$stmt=oci_parse($conn, $sql);
	$result=oci_execute($stmt);
	$ant_name="";
	$sumaux=0;
	$j=0;
	while ($row=oci_fetch_array($stmt)) {
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

	$sql="select to_char(fr.fecreg,'YYYYMM') anho_mes
		     , cr.desclarec, cr.codclarec, sum(frd.canpre) canpre
		  from (select distinct a.codenv, a.codfic, t.codtll, t.codsede, t.codtiposerv
		          from auditoriaenvio a, taller t where a.codtll = t.codtll) ae
		      , fichaauditoria fa, fichaauditoriarecuperacion fr, fichaauditoriarecuperaciondet frd, clasificacionrecuperacion cr
		 where fa.codfic = fr.codfic and fa.parte = fr.parte and fa.numvez = fr.numvez and fa.codtad = fr.codtad
		   and fr.codfic = frd.codfic and fr.parte = frd.parte and fr.numvez = frd.numvez and fr.codtad = frd.codtad
		   and frd.codclarec = cr.codclarec
		   and to_char(fr.fecreg,'YYYYMM')>= (to_char(add_months(sysdate,-3),'YYYYMM'))
		   and ae.codenv = fa.codenv
		   ".$whereTll."
		   ".$whereSede."
		   ".$whereTipSer."
		 group by to_char(fr.fecreg,'YYYYMM'), cr.desclarec, cr.codclarec
		 order by 1, 3";
	$stmt=oci_parse($conn, $sql);
	$result=oci_execute($stmt);
	$ant_name="";
	$sumaux=0;
	while ($row=oci_fetch_array($stmt)) {
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
	$ar_sum[$j]=$sumaux;
	$j++;

	$sql="select to_char(fr.fecreg,'YYYY') anho, ff.numero_semana
		      , cr.desclarec, cr.codclarec, sum(frd.canpre) CANPRE
		  from fecha_semana ff
		      , (select distinct a.codenv, a.codfic, t.codtll, t.codsede, t.codtiposerv
		          from auditoriaenvio a, taller t where a.codtll = t.codtll) ae
		      , fichaauditoria fa, fichaauditoriarecuperacion fr, fichaauditoriarecuperaciondet frd, clasificacionrecuperacion cr
		 where fa.codfic = fr.codfic and fa.parte = fr.parte and fa.numvez = fr.numvez and fa.codtad = fr.codtad
		   and fr.codfic = frd.codfic and fr.parte = frd.parte and fr.numvez = frd.numvez and fr.codtad = frd.codtad
		   and frd.codclarec = cr.codclarec
		   and ae.codenv = fa.codenv
		   and trunc(fr.fecreg) = trunc(ff.fecha_calendario)
		   and trunc(fr.fecreg) >= (select trunc(fecha_calendario + 1 - dia_semana) from fecha_semana where trunc(fecha_calendario) = trunc(sysdate-21))
		   ".$whereTll."
		   ".$whereSede."
		   ".$whereTipSer."
		 group by to_char(fr.fecreg,'YYYY'), ff.numero_semana, cr.desclarec, cr.codclarec
		 order by to_char(fr.fecreg,'YYYY'), ff.numero_semana, cr.codclarec
		";
	$stmt=oci_parse($conn, $sql);
	$result=oci_execute($stmt);
	$ant_name="";
	$sumaux=0;
	while ($row=oci_fetch_array($stmt)) {
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

/*
	echo json_encode($ar_header)."<br>";
	echo json_encode($ar_clasi1)."<br>";
	echo json_encode($ar_clasi2)."<br>";
	echo json_encode($ar_clasi3)."<br>";
	echo json_encode($ar_clasi4)."<br>";
	echo json_encode($ar_clasi5)."<br>";
	echo json_encode($ar_clasi6)."<br>";
	echo json_encode($ar_sum)."<br>";
	*/

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