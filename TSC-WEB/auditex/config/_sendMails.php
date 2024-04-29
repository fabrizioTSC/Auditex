<?php
	set_time_limit(120000);
	include('connection.php');
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require_once("phpmailer/Exception.php");
	require_once("phpmailer/PHPMailer.php");
	require_once("phpmailer/SMTP.php");

	$sql="BEGIN SP_AT_SELECT_FECFINSEM(:FECHA); END;";
	$stmt=oci_parse($conn, $sql);
	$fecha="";
	oci_bind_by_name($stmt, ':FECHA', $fecha,40);
	$result=oci_execute($stmt);

	$url_base='http://textilweb.tsc.com.pe:81/TSC-WEB/';
	//$url_base='http://localhost:8081/TSC-WEB/';
	$ant_user="";
	$ant_email="";
	$i=0;
	$html='';

	echo "Ruta de mails: '".$url_base."'.<br>";

	$sql="BEGIN SP_AT_SELECT_INDREPDETALL(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		if ($ant_user!=$row['CODUSU'] ) {
			if ($i!=0) {
				if(!is_null($ant_email)){
					$mail = new PHPMailer(true);
					try {
					    $mail->SMTPDebug = 0;
					    $mail->isSMTP();
					    $mail->SMTPSecure = 'starttls';
					    $mail->Port       = 587;
					    $mail->SMTPAuth   = true;
					    $mail->Host       = 'smtp.office365.com';
					    $mail->Username   = 'information@tsc.com.pe';
					    $mail->Password   = 'K4mbi0.19';

					    $mail->setFrom('information@tsc.com.pe', 'AUDITEX MASTER');
					    $mail->addAddress($ant_email);
					    $mail->isHTML(true);
					    $mail->Subject = 'INDICADORES DE RESULTADOS - AUDITEX - TSC';
					    $mail->Body    = '<div style="margin: 10px;font-family: sans-serif;">
							<div style="font-size: 15px;font-weight: bold;text-align: center;margin-bottom: 10px;">INDICADORES DE RESULTADOS</div>
							'.$html.'
						</div>';

					    $mail->send();
					    echo "Correo enviado a ".$ant_email.".<br>";
					    echo "------------------<br>";
					} catch (Exception $e) {
					    echo "No se envio a ".$ant_email.". Error: {$mail->ErrorInfo}.<br>";
					    echo "------------------<br>";
					}
				}else{
					echo "Usuario sin mail: ".$ant_user.".<br>";
					echo "------------------<br>";
				}
				$html='';
			}
		}
		if(!is_null($row['EMAILUSU'])){
			if($row['CODTAD']=='1'){
			$html.=
				'<div style="font-size: 14px;margin-bottom: 5px;margin-top: 10px;">'.utf8_encode($row['DESTAD']).' - '.$row['DESTIPIND'].':</div>
				<a target="_blank" 
				href="'.$url_base.$row['RUTREP'].'?codprv=0&codusu=0&codusueje=0&bloque=0&fecha='.$fecha.'">'.
				$url_base.$row['RUTREP'].'?codprv=0&codusu=0&codusueje=0&bloque=0&fecha='.$fecha.'</a>';			
			}else{
			$html.=
				'<div style="font-size: 14px;margin-bottom: 5px;margin-top: 10px;">'.utf8_encode($row['DESTAD']).' - '.$row['DESTIPIND'].':</div>
				<a target="_blank" 
				href="'.$url_base.$row['RUTREP'].'?codsede='.$row['CODSEDE'].'&codtipser='.$row['CODTIPOSERV'].'&codtll='.$row['CODTLL'].'&fecha='.$fecha.'">'.
				$url_base.$row['RUTREP'].'?codsede='.$row['CODSEDE'].'&codtipser='.$row['CODTIPOSERV'].'&codtll='.$row['CODTLL'].'&fecha='.$fecha.'</a>';
		}
		}
		$ant_user=$row['CODUSU'];
		$ant_email=$row['EMAILUSU'];
		$i++;
	}
	if(!is_null($ant_email)){
		$mail = new PHPMailer(true);
		try {
		    $mail->SMTPDebug = 0;
		    $mail->isSMTP();
			$mail->SMTPSecure = 'starttls';
		    $mail->Port       = 587;
		    $mail->SMTPAuth   = true;
		    $mail->Host       = 'smtp.office365.com';
		    $mail->Username   = 'information@tsc.com.pe';
		    $mail->Password   = 'K4mbi0.19';

		    $mail->setFrom('information@tsc.com.pe', 'AUDITEX MASTER');
		    $mail->addAddress($ant_email);
		    $mail->isHTML(true);
		    $mail->Subject = 'INDICADORES DE RESULTADOS - AUDITEX - TSC';
		    $mail->Body    = '<div style="margin: 10px;font-family: sans-serif;">
				<div style="font-size: 15px;font-weight: bold;text-align: center;margin-bottom: 10px;">INDICADORES DE RESULTADOS</div>
				'.$html.'
			</div>';

		    $mail->send();
		    echo "Correo enviado a ".$ant_email.".<br>";
		    echo "------------------<br>";
		} catch (Exception $e) {
		    echo "No se envio a ".$ant_email.". Error: {$mail->ErrorInfo}.<br>";
		    echo "------------------<br>";
		}
	}else{
		echo "Usuario sin mail: ".$ant_user.".<br>";
		echo "------------------<br>";
	}
?>