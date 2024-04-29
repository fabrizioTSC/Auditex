<?php
	session_start();
	if (!isset($_SESSION['user-ins'])) {
		header('Location: index.php');
	}
	include("config/_contentMenu.php");
	include("config/connection.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX - INSPECCION</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/demo-v5.css">
</head>
<body>
	<?php contentMenu();?>
	<div class="contentMsgInstant"></div>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="modalDefectos" style="display: none;">
		<div class="btnClose" onclick="closeModal('modalDefectos')"><i class="fa fa-times" aria-hidden="true"></i></div>
		<div class="lblInTable" style="width: 100%;">Defecto a agregar:</div>
		<input type="text" id="idDefectoSearch" class="classIpt" style="padding: 5px;font-size: 12px;border-radius: 0px;">
		<div class="resultDefectos">		
		</div>
		<button class="btnPrimary btnFloat" style="margin-top: 5px;width: 100%;" onclick="selectDefectoAdd()">Agregar</button>
	</div>	
	<div class="modalOperaciones" style="display: none;">
		<div class="btnClose" onclick="closeModal('modalOperaciones')"><i class="fa fa-times" aria-hidden="true"></i></div>
		<div class="lblInTable" style="width: 100%;">Operaci&oacute;n a agregar:</div>
		<input type="text" id="idOperacionSearch" class="classIpt" style="padding: 5px;font-size: 12px;border-radius: 0px;">
		<div class="resultOperaciones">		
		</div>
		<button class="btnPrimary btnFloat" style="margin-top: 5px;width: 100%;" onclick="selectOperacionAdd()">Agregar</button>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Inspecci&oacute;n de fichas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="mainHeaderPage">
			<div class="bigitemTable">
				<div id="detailInspeccion">
					<div class="sameline">
						<div class="lblInTable">Fic.:</div>
						<span id="idCodFic"></span>
						&nbsp;&nbsp;-&nbsp;&nbsp;
						<div class="lblInTable">Lin.:</div>
						<span id="idLinea"></span>
						<!--
						&nbsp;&nbsp;-&nbsp;&nbsp;
						<div class="lblInTable">Tur.:</div>
						<span id="idTurno"></span>
						-->
					</div>
					<div class="sameline">
						<div class="lblInTable">Est.:</div>
						<span id="idEstilo"></span>
						&nbsp;&nbsp;-&nbsp;&nbsp;
						<div class="lblInTable">Cli.:</div>
						<span id="idCliente"></span>	
						&nbsp;&nbsp;-&nbsp;&nbsp;		
						<div class="lblInTable">Col.:</div>
						<span id="idColor"></span>
					</div>
				</div>
				<button class="linkclass" onclick="hideDetalle()" id="btnHideDetalle">Ocultar detalle</button>
				<button class="btnPrimary btnFloat" style="margin-top: 0px;width: 100px;" onclick="saveInspeccion()">Guardar</button>
				<button class="btnPrimary btnFloat" style="margin-top: 0px;width: 30px;" onclick="filterDefecto()"><i class="fa fa-plus" aria-hidden="true"></i></button>
				<button class="btnPrimary btnFloat" style="margin-top: 0px;width: 100px;" onclick="endInspeccion()">Terminar</button>
			</div>
			<div class="contentTblInspec" id="tblToAnimate">
				<div class="placeOperations" id="freeOperations">
					<div class="itemsFinalTbl spaceToHide" style="width: 192px;display: flex;">
						<div style="width: calc(50% - 5px);padding-right: 5px;">
							<div class="textInSelect lbllittle">Pre. Tot.: </div>
							<input type="number" id="idcanpre" class="iptclass2" style="width: calc(100% - 12px);height: 35px;font-size: 20px;text-align: center;">
						</div>
						<div style="width: calc(50% - 5px);padding-left: 5px;">
							<div class="textInSelect lbllittle">Pre. Def.: </div>
							<div class="classToInpt" style="width: calc(100% - 12px);height: 35px;font-size: 20px;" onclick="addTotalValue('idNumPreDefNumNew')">
								<div class="tittletext" id="idNumPreDefNumNew" style="padding-top: 7px;">0</div>
								<div class="buttonminusS2" onclick="desTotalValue('idNumPreDefNumNew')"><i class="fa fa-minus" aria-hidden="true"></i></div>
							</div>
						</div>
					</div>
					<div class="sameline spaceToHideF">
						<div class="itemsFinalTbl" style="width: 60px;">C&Oacute;DIGO</div>
						<div class="itemsFinalTbl alignLeft" style="width: 120px;position: relative;">
							OPERACI&Oacute;N
							<div class="buttonminusS2" style="top: 3px;right: 3px;" onclick="filterOperacion()"><i class="fa fa-plus" aria-hidden="true"></i></div>
						</div>
					</div>
					<div id="spaceToAddOpe">
					<?php 
						$sql="SELECT * FROM ESTILOOPERACION stlope
						INNER JOIN OPERACION ope
						ON stlope.CODOPE=ope.CODOPE
						WHERE esttsc='".$_GET['esttsc']."'";
						$stmt=oci_parse($conn, $sql);
						$result=oci_execute($stmt);
						$operaciones=[];
						$i=0;
						while ($row=oci_fetch_array($stmt)) {
							$operaciones[$i]=$row;
							$i++;
							$style='padding: 2px 5px 8px 5px;font-size:10px;';
							if(strlen (utf8_encode($row['DESOPE']))<16){
								$style="";
							}
					?>
						<div class="sameline classOperacion" data-codope="<?php echo $row['CODOPE']; ?>">
							<div class="itemsFinalTbl" style="width: 60px;"><?php echo $row['CODOPE']; ?></div>
							<div class="itemsFinalTbl alignLeft maxHeight" style="width: 120px;<?php echo $style; ?>"><?php echo utf8_encode($row['DESOPE']); ?></div>
						</div>
					<?php
						}
					?>
					</div>
					<div class="itemsFinalTbl" style="width: 192px;">TOTAL</div>			
				</div>
				<div class="placeDefectos">
					<div class="spaceFlex" id="headerDefectos">
					<?php 
						$sql="SELECT * FROM defecto defe inner join familiadefecto fd on defe.CODFAM=fd.CODFAMILIA 
						WHERE defe.ESTADO='A' and ordenins!=0
						order by fd.orden,defe.CODFAM,defe.ordenins";
						$stmt=oci_parse($conn, $sql);
						$result=oci_execute($stmt);
						$antclass="";
						$defectos=[];
						$i=0;
						while ($row=oci_fetch_array($stmt)) {
							$defectos[$i]=$row;
							$i++;
							$style='padding: 2px 5px 8px 5px;font-size:10px;';
							if(strlen (utf8_encode($row['DESDEF']))<14){
								$style="";
							}
							if ($antclass=="") {
								$antclass=$row['CODFAM'];
					?>
						<div class="<?php echo 'class'.$row['CODFAM']; ?>">
							<div class="itemsFinalTbl" style="height: 29px;"><?php echo utf8_encode($row['DSCFAMILIA']); ?></div>
							<div class="sameline contentFam<?php echo $row['CODFAM']; ?>">
					<?php
							}else{
								if ($antclass!=$row['CODFAM']) {
									$antclass=$row['CODFAM'];
					?>
							</div>
						</div>
						<div class="<?php echo 'class'.$row['CODFAM']; ?>">
							<div class="itemsFinalTbl" style="height: 29px;"><?php echo utf8_encode($row['DSCFAMILIA']); ?></div>
							<div class="sameline contentFam<?php echo $row['CODFAM']; ?>">
					<?php
								}
							}
					?>					
							<div class="verticalGrown">
								<div class="itemsFinalTbl" style="width: 88px;"><?php echo $row['CODDEFAUX']; ?></div>
								<div class="itemsFinalTbl maxHeight" style="width: 88px;<?php echo $style; ?>"><?php echo utf8_encode($row['DESDEF']); ?></div>			
							</div>
					<?php
						}
					?>
							</div>
						</div>
					</div>
					<div class="spaceFlex" id="spaceToBtn">
						<?php 
							$antclass="";
							for ($i=0; $i < count($defectos) ; $i++) { 
								if ($antclass=="") {
									$antclass=$defectos[$i]['CODFAM'];
						?>
						<div class="spaceFlex classBtn<?php echo $defectos[$i]['CODFAM']; ?>">	
						<?php
								}else{
									if ($antclass!=$defectos[$i]['CODFAM']) {
										$antclass=$defectos[$i]['CODFAM'];
						?>
						</div>
						<div class="spaceFlex classBtn<?php echo $defectos[$i]['CODFAM']; ?>">	
						<?php
									}
								}
						?>
							<div class="verticalGrown">
								<div class="spaceToAddBtnPart2">
							<?php
								for ($j=0; $j < count($operaciones) ; $j++) { 
							?>	
									<div class="itemsFinalTbl maxHeight counterBtn" style="width: 88px;">
										<div class="divBtnsAddMinus" data-def="<?php echo $defectos[$i]['CODDEF']; ?>"
											data-ope="<?php echo $operaciones[$j]['CODOPE']; ?>"
											onclick="addValue(<?php echo $operaciones[$j]['CODOPE']; ?>,<?php echo $defectos[$i]['CODDEF']; ?>)"
											id="<?php echo 'OPE'.$operaciones[$j]['CODOPE'].'DEF'.$defectos[$i]['CODDEF']; ?>">0</div>
										<div class="buttonminus" onclick="desValue(<?php echo $operaciones[$j]['CODOPE']; ?>,<?php echo $defectos[$i]['CODDEF']; ?>)"><i class="fa fa-minus" aria-hidden="true"></i></div>
									</div>
							<?php
								}
							?>
								</div>
								<div class="itemsFinalTbl" style="width: 88px;" id="def<?php echo $defectos[$i]['CODDEF']; ?>">0</div>
							</div>
						<?php
							}
						?>
						</div>
					</div>
				</div>
				<div class="placeTotales">
					<div class="itemsFinalTbl spaceToHide itemFinalTotal" style="height: 81px;">TOTAL</div>
					<div class="spaceToAddBtns3">
					<?php
						for ($j=0; $j < count($operaciones) ; $j++) { 
					?>	
						<div class="itemsFinalTbl itemFinalTotal" id="ope<?php echo $operaciones[$j]['CODOPE']; ?>">0</div>
					<?php
						}
					?>
					</div>
					<div class="itemsFinalTbl itemFinalTotal" id="idTotalAll">0</div>	
				</div>
			</div>
		</div>
	</div>
	<div class="selectionOpeModal" style="display: none;">
		<div class="bodyModal">
			<div class="btnClose" onclick="closeModal('selectionOpeModal')"><i class="fa fa-times" aria-hidden="true"></i></div>
			<div class="lblInTable" style="font-weight: bold; font-size: 15px; width: 100%; margin-bottom: 5px;">Seleccione una operaci&oacute;n:</div>
			<select id="seleccionope" class="selectclass" style="width: calc(100% - 2px);margin-bottom: 5px; border: 1px solid #666;">
				<?php
				for ($i=0;$i<count($operaciones);$i++) {
				?>
				<option value="<?php echo $operaciones[$i]['CODOPE']; ?>"><?php echo utf8_encode($operaciones[$i]['DESOPE']); ?></option>
				<?php
				}
				?>
			</select>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="confirmAddOpe()">A&ntilde;adir</button>			
		</div>
	</div>
	<script type="text/javascript">
		var codusu_var="<?php echo $_SESSION['user-ins'];?>";
		var codfic=<?php echo $_GET['codfic']; ?>;
		var turno=1;
		var codtll="<?php echo $_GET['codtll']; ?>";
		<?php
		$codinscos_aux="0";
		if (isset($_GET['codinscos'])) {
			$codinscos_aux=$_GET['codinscos'];
		}
		?>
		var codinscos_var="<?php echo $codinscos_aux; ?>";
	</script>
	<script type="text/javascript" src="js/inspeccion-v1.7.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>