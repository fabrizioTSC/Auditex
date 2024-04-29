<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Porcentaje_de_Defectos_por_Talleres_y_Rango_de_fechas.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$fecini=strtotime($_GET['fecini']);
$fecini=date("Ymd", $fecini);
$fecfin=strtotime($_GET['fecfin']);
$fecfin=date("Ymd", $fecfin);

include("../connection.php");
$sql="select CONCAT('COD-',REPLACE(ae.codtll,'0','O')) as CODTLL, t.destll,  sum(ad.candef) candef, t.cantot, round(100*(sum(ad.candef)/t.cantot) ,2) Por
					from auditoriadetalledefecto ad, fichaauditoria fa, auditoriaenvio ae, defecto d, taller t,
					(select sum(ad.candef) cantot
					from auditoriadetalledefecto ad, fichaauditoria fa
					where ad.codfic = fa.codfic and ad.codtad = fa.codtad and ad.numvez = fa.numvez and ad.parte = fa.parte
					and to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."'
					and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
					) t
				where ad.codfic = fa.codfic and ad.codtad = fa.codtad and ad.numvez = fa.numvez and ad.parte = fa.parte
				and fa.codenv = ae.codenv
				and ad.coddef = d.coddef
				and ae.codtll = t.codtll
				and to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."'
				and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
				group by t.cantot, ae.codtll, t.destll
				order by candef desc";
$stmt=oci_parse($conn, $sql);
$result=oci_execute($stmt);

?>
<div style="font-size: 20px;font-weight: bold;">Porcentaje de Defectos por Talleres y Rango de fechas</div>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $_GET['fecini']; ?> al <?php echo $_GET['fecfin']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Cod. Taller</th>
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">Cantidad Defecto</th>
			<th style="border:1px solid #333;">Cantidad Total</th>
			<th style="border:1px solid #333;">Porcentaje</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo str_replace('O','0',$row['CODTLL']);?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESTLL'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTOT'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['POR'];?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>