<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Porcentaje_de_defectos_por_defectos_y_rango_de_fechas.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$fecini=strtotime($_GET['fecini']);
$fecini=date("Ymd", $fecini);
$fecfin=strtotime($_GET['fecfin']);
$fecfin=date("Ymd", $fecfin);

include("../connection.php");
$sql="select ad.coddef, d.desdef, sum(ad.candef) candef, t.cantot, round(100*(sum(ad.candef)/t.cantot) ,2) Por
					from auditoriadetalledefecto ad, fichaauditoria fa, defecto d,
					(select sum(ad.candef) cantot
					from auditoriadetalledefecto ad, fichaauditoria fa
					where ad.codfic = fa.codfic and ad.codtad = fa.codtad and ad.numvez = fa.numvez and ad.parte = fa.parte
					and to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."'
					and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
					) t
				where ad.codfic = fa.codfic and ad.codtad = fa.codtad and ad.numvez = fa.numvez and ad.parte = fa.parte
				and ad.coddef = d.coddef
				and to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."'
				and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
				group by ad.coddef, d.desdef, t.cantot
				order by candef desc";
$stmt=oci_parse($conn, $sql);
$result=oci_execute($stmt);

?>
<div style="font-size: 20px;font-weight: bold;">Porcentaje de Defectos por Defectos y Rango de fechas</div>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $_GET['fecini']; ?> al <?php echo $_GET['fecfin']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Cod. Defecto</th>
			<th style="border:1px solid #333;">Defecto</th>
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
			<td style="border:1px solid #333;"><?php echo $row['CODDEF'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESDEF'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTOT'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['POR'];?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>