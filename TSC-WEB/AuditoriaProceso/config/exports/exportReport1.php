<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_ratio_de_numero_de_veces_de_auditoria.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$fecini=strtotime($_GET['fecini']);
$fecini=date("Ymd", $fecini);
$fecfin=strtotime($_GET['fecfin']);
$fecfin=date("Ymd", $fecfin);

include("../connection.php");
$sql="select sum(a.canaud) canaud, sum(a.canteo) canteo, round(100*sum(a.canteo)/sum(a.canaud),2) efi
	from (
	select ae.codtll, fa.canaud, case fa.resultado when 'A' then fa.canaud else 0 end canteo from 
	fichaauditoria fa, auditoriaenvio ae
		where fa.codenv = ae.codenv and (fa.codfic, fa.codtad, fa.parte) in
		    (	select codfic, codtad, parte from fichaauditoria fa
        	where fa.codenv = ae.codenv
        	and fa.estado = 'T'
        	and fa.resultado = 'A'
        	and to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."'
        	and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
        )
    ) a
order by efi desc";
$stmt=oci_parse($conn, $sql);
$result=oci_execute($stmt);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte ratio de numero de veces de auditoria</div>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $_GET['fecini']; ?> al <?php echo $_GET['fecfin']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Cantidad Auditar</th>
			<th style="border:1px solid #333;">Cantidad Teorica</th>
			<th style="border:1px solid #333;">Eficiencia</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['CANAUD'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTEO'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['EFI'];?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>