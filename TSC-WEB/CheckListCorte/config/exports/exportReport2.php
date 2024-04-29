<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_ratio_de_numero_de_veces_de_auditoria_por_taller.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$array_fecini=explode("/",$_GET['fecini']);
$fecini=$array_fecini[2].$array_fecini[1].$array_fecini[0];
$array_fecfin=explode("/",$_GET['fecfin']);
$fecfin=$array_fecfin[2].$array_fecfin[1].$array_fecfin[0];

include("../connection.php");
$sql="select CONCAT('COD-',REPLACE(a.codtll,'0','O')) as CODTLL, t.destll as DESTLL, sum(a.canaud) canaud, sum(a.canteo) canteo, 
round(100*sum(a.canteo)/sum(a.canaud),2) efi 
	from (
		select ae.codtll, fa.canaud, case fa.resultado when 'A' then fa.canaud else 0 end canteo from  fichaauditoria fa, auditoriaenvio ae
		where fa.codenv = ae.codenv and (fa.codfic, fa.codtad, fa.parte) in
		(select codfic, codtad, parte from fichaauditoria fa where fa.codenv = ae.codenv
		and fa.estado = 'T' and fa.resultado = 'A'
		and to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."'
		and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
	)
) a, taller t
where a.codtll = t.codtll
group by a.codtll, t.destll
order by efi desc, t.destll";
$stmt=oci_parse($conn, $sql);
$result=oci_execute($stmt);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte ratio de n&uacute;mero de veces de auditor&iacute;a por taller</div>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $_GET['fecini']; ?> al <?php echo $_GET['fecfin']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Cod. Taller</th>
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">Cantidad auditoria</th>
			<th style="border:1px solid #333;">Cantidad teorica</th>
			<th style="border:1px solid #333;">Eficiencia</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo str_replace('O','0',$row['CODTLL']);?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESTLL'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANAUD'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTEO'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['EFI'];?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>