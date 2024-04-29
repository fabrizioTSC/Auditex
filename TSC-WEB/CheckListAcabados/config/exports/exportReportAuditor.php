<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_numero_de_auditorías_por_Auditor.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$array_fecini=explode("/",$_GET['fecini']);
$fecini=$array_fecini[2].$array_fecini[1].$array_fecini[0];
$array_fecfin=explode("/",$_GET['fecfin']);
$fecfin=$array_fecfin[2].$array_fecfin[1].$array_fecfin[0];

include("../connection.php");
$sql="select nvl(fa.codusu,'-') CODUSU, count(*) AUDITORIA, nvl(a.cantidad,'0') aprobado, nvl(r.cantidad,'0') rechazado, sum(fa.canpar) Prendas, sum(fa.canaud) Auditado, sum(fa.candef) Defectos
  	from fichaauditoria fa 
   	left join
    (select fa.codusu, count(*) cantidad
    from fichaauditoria fa
    where to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."' 
    and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
    and fa.estado = 'T' and fa.resultado = 'A'
    group by fa.codusu) a on fa.codusu = a.codusu or (fa.codusu is null and a.codusu is null)
 	left join
    (select fa.codusu, count(*) cantidad
    from fichaauditoria fa
    where to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."' 
    and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
    and fa.estado = 'T' and fa.resultado = 'R'
    group by fa.codusu) r on fa.codusu = r.codusu or (fa.codusu is null and r.codusu is null)       
 	where to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."' 
	and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
	and fa.estado = 'T'
 	group by fa.codusu, a.cantidad, r.cantidad";
$stmt=oci_parse($conn, $sql);
$result=oci_execute($stmt);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte de n&uacute;mero de auditor&iacute;as por Auditor</div>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $_GET['fecini']; ?> al <?php echo $_GET['fecfin']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Usuario</th>						
			<th style="border:1px solid #333;">Auditoria</th>
			<th style="border:1px solid #333;">Cant. Apro.</th>
			<th style="border:1px solid #333;">Cant. Rech.</th>
			<th style="border:1px solid #333;">Cant. Prendas</th>
			<th style="border:1px solid #333;">Cant. Auditada</th>
			<th style="border:1px solid #333;">Cant. Defectos</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['CODUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['AUDITORIA']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['APROBADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RECHAZADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PRENDAS']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['AUDITADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DEFECTOS']; ?></td>	
		</tr>
		<?php
			}
		?>
	</tbody>
</table>