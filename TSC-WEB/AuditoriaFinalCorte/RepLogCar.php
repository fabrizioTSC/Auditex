<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="3";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte Log de Carga de Medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>			
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">
    <?php 
        include("config/connection.php");
        $titulo = "";
        if($_GET['esttsc'] != "0"){
            $titulo .= htmlspecialchars($_GET['esttsc'])." / ";
        } else {
            $titulo .= "(TODOS) / ";
        }

        if($_GET['codusu'] != "0"){
            $sql = "EXEC [AUDITEX].[SP_AT_SELECT_AUDITOR] @p_codusu = ?";
            $params = array((int)$_GET['codusu']);
            $stmt = sqlsrv_query($conn, $sql, $params);
            if($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            $titulo .= $row ? utf8_encode($row['ALIUSU']) . " / " : "(Desconocido) / ";
        } else {
            $titulo .= "(TODOS) / ";
        }

        $ar_fecini = explode("-", $_GET['fecini']);
        $ar_fecfin = explode("-", $_GET['fecfin']);
        $titulo .= $ar_fecini[2]."-".$ar_fecini[1]."-".$ar_fecini[0]." al ".$ar_fecfin[2]."-".$ar_fecfin[1]."-".$ar_fecfin[0];
        echo "<div class='lblNew' id='spacetitulo'>$titulo</div>";

        $fecini = $ar_fecini[0] . $ar_fecini[1] . $ar_fecini[2];
        $fecfin = $ar_fecfin[0] . $ar_fecfin[1] . $ar_fecfin[2];
        $sql = "EXEC [AUDITEX].[SP_AFC_REPORTE_LOG_CARGA_MED] @p_esttsc = ?, @p_codusu = ?, @p_confecha = ?, @p_fecini = ?, @p_fecfin = ?";
        $params = array($_GET['esttsc'], $_GET['codusu'], $_GET['fec'], $fecini, $fecfin);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    ?>
    <div class="mayorContent">
	<div class="rowLine" style="display: block;width: 1220px;">
        <div class="tblPrendasDefecto">
            <div class="tblHeader">
                <div class="itemHeader2" style="width: 100px;">Est. TSC</div>
                <div class="itemHeader2" style="width: 100px;">Hilo</div>
                <div class="itemHeader2" style="width: 100px;">Travez</div>
                <div class="itemHeader2" style="width: 100px;">Largmanga</div>
                <div class="itemHeader2" style="width: 100px;">Cod. Usu.</div>
                <div class="itemHeader2" style="width: 150px;">Fecha</div>
                <div class="itemHeader2" style="width: 90px;">Cargado</div>
                <div class="itemHeader2" style="width: 300px;">Nom. Archivo</div>
                <div class="itemHeader2" style="width: 90px;">Link CSV</div>
            </div>
            <div class="tblBody">
                <?php
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                ?>
                        <div class="tblLine">
                            <div class="itemBody2" style="width: 100px;"><?php echo htmlspecialchars($row['ESTTSC']); ?></div>
							<div class="itemBody2" style="width: 100px;"><?php echo intval($row['HILO']); ?></div>
                            <div class="itemBody2" style="width: 100px;"><?php echo intval($row['TRAVEZ']); ?></div>
                            <div class="itemBody2" style="width: 100px;"><?php echo intval($row['LARGMANGA']); ?></div>
                            <div class="itemBody2" style="width: 100px;"><?php echo htmlspecialchars($row['CODUSU']); ?></div>
                            <div class="itemBody2" style="width: 150px;"><?php 
								$dateString = $row['FECHA'];
								// Asumiendo que $dateString está en el formato 'd/m/Y H:i:s'
								$dateParts = explode(' ', $dateString); // Separar fecha de hora
								if(count($dateParts) == 2) {
									$dateComponents = explode('/', $dateParts[0]);
									if(count($dateComponents) == 3) {
										$formattedDateString = $dateComponents[2] . '-' . $dateComponents[1] . '-' . $dateComponents[0] . ' ' . $dateParts[1];
										$fecha = date_create($formattedDateString);
										if ($fecha !== false) { // Verificamos que la fecha sea válida
											echo htmlspecialchars(date_format($fecha, 'd/m/Y h:i:s A')); // Formateamos la fecha
										} else {
											echo 'Fecha inválida'; // Mensaje de error para una fecha no válida
										}
									} else {
										echo 'Sin fecha'; // Mensaje o acción para cuando la estructura no es la esperada
									}
								} else {
									echo 'Sin fecha'; // Mensaje o acción para cuando no hay partes de fecha y hora
								}
       						 ?></div>
                            <div class="itemBody2" style="width: 90px;"><?php echo htmlspecialchars($row['CARGADO']); ?></div>
                            <div class="itemBody2" style="width: 300px;"><?php echo htmlspecialchars(utf8_encode($row['NOMARCHIVO'])); ?></div>
                            <div class="itemBody2" style="width: 90px;"><?php 
                              
                                echo '<a target="_blank" href="../carga-csv-afc/'.htmlspecialchars($row['ESTTSC'])
                                .'-'.intval(floatval($row['HILO'])*100)
                                .'-'.intval(floatval($row['TRAVEZ'])*100)
                                .'-'.intval(floatval($row['LARGMANGA'])*100)
                                .'-'.htmlspecialchars($row['FECHAF']).'.csv">Ver</a>'; 
                            ?></div>

                        </div>
                <?php
                    }
                    // Si no hay filas en el conjunto de resultados, muestra un mensaje.
                    if(sqlsrv_has_rows($stmt) === false) {
                        echo "<div style='color: red; font-size: 18px; padding: 5px; font-size: 14px;'>No hay resultados!</div>";
                    }
                ?>
				</div>
            </div> <!-- tblBody -->
        </div> <!-- tblPrendasDefecto -->
		
    </div> <!-- mayorContent -->
    <div class="lineDecoration"></div>
</div> <!-- bodyContent -->

		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="window.history.back()">Volver</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/ReporteGeneral-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>