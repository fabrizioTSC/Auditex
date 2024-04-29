<?php
	include('../connection.php');

    $codigoficha =  $_POST['codfic'];

    $path="No hay estilos!";
	$sql="BEGIN spu_encogimientos_j(:CODFIC,:OUTPUT_CUR); END;";
    $stmt=oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':CODFIC', $codigoficha);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
    oci_execute($OUTPUT_CUR);
    $path=
    "<table>".
        "<thead>".
            "<tr>".
                "<th>HILO</th>".
                "<th>TRAVEZ</th>".
                "<th>LARG. MANGA</th>".
                "<th>OPERACIÓN</th>".
            "</tr>".
        "</thead>".
        "<tbody>";
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
        $hilo       = str_replace(",",".",$row["HILO"]);
        $travez     = str_replace(",",".",$row["TRAVEZ"]);
        $largmanga  = str_replace(",",".",$row["LARGMANGA"]);
        $path.=
        "<tr>".
            "<td>".str_replace(",",".",$row['HILO'])."</td>".
            "<td>".str_replace(",",".",$row['TRAVEZ'])."</td>";
        if ($row["CONLARGMANGA"]!=0) {
            $path.=
            "<td>".str_replace(",",".",$row['LARGMANGA'])."</td>";
        }else{
            $path.=
            "<td></td>";            
        }
        if ($row["CANT_MED_AUD"]!=0) {
            $path.=
			"<td><a href='RegistrarMedidasAudFinCor.php?codfic=$codigoficha&hilo=$hilo&travez=$travez&largmanga=$largmanga'>ver aud/tot:" .$row["CANT_MED_AUD"]."/".$row["CANT_MED"]."</a></td>";            "<td>".str_replace(",",".",$row['LARGMANGA'])."</td>";
        }else{
            $path.=
            "<td>aud/tot: " .$row["CANT_MED_AUD"]."/".$row["CANT_MED"]."</td>";            
        }
		//$path.=
        //    "<td><a href='RegistrarMedidasAudFinCor.php?codfic=$codigoficha&hilo=$hilo&travez=$travez&largmanga=$largmanga'>ver " .$row["CANT_MED_AUD"]."/".$row["CANT_MED"]."</a></td>";
        $path.=
        "</tr>";
    }
    $path.=
        "</tbody>".
    "</table>";

    echo $path;

	oci_close($conn);

?>