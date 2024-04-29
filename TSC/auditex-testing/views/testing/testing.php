<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: /dashboard');
	}

    $_SESSION['navbar'] = "Testing";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditex Testing</title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

    <link rel="stylesheet" href="../../css/testing/testing.css">

    <style>
       body{
            padding-top: 60px !important;
       }

    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container-fluid pt-3"> 

    <div class="card p-0" id="card1">

        <form class="card-body p-0" id="frmbusqueda" autocomplete="off">

            <ul class="nav nav-tabs busquedas">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#panel1">Rango de Fechas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#panel2">Año - Semana</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#panel3">Generales</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content mb-3 busquedas">

                <div id="panel1" class="container-fluid pt-1 tab-pane active">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Desde</label>
                            <input type="date" class="form-control form-control-sm" id="txtfechai">
                        </div>

                        <div class="col-md-6">
                            <label for="">Hasta</label>
                            <input type="date" class="form-control form-control-sm" id="txtfechaf">
                        </div>
                    </div>
                </div>

                <div id="panel2" class="container-fluid pt-1 tab-pane fade">

                    <div class="row">

                        <div class="col-md-6">
                            <label for="">Año</label>
                            <input type="number" class="form-control form-control-sm" id="txtanio" value="<?php echo date("Y"); ?>" max="<?php echo date("Y"); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="">Semana</label>
                            <input type="number" class="form-control form-control-sm" id="txtsemana" max="52" min="1" value="<?php echo date("W"); ?>">
                        </div>

                    </div>    

                </div>

                <div id="panel3" class="container-fluid pt-1 tab-pane fade"><br>

                    <div class="row">

                        <div class="col-md-3">
                            <label for="">Proveedor</label>
                            <select name="" id="cboproveedor" class="custom-select custom-select-sm select2" multiple="multiple" data-placeholder="Seleccione Proveedor" data-dropdown-css-class="select2-danger" style="width: 100%;"></select>
                        </div>

                        <div class="col-md-3">
                            <label for="">Cliente</label>
                            <select name="" id="cbocliente" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="">Artículo de tela</label>
                            <select name="" id="cboarticulo" class="custom-select custom-select-sm select2articulotela"  multiple="multiple" data-placeholder="Seleccione Articulo" data-dropdown-css-class="select2-danger" style="width: 100%;"></select>
                        </div>

                        <div class="col-md-3">
                            <label for="">Programa</label>
                            <select name="" id="cboprograma" class="custom-select custom-select-sm select2programa"  multiple="multiple" data-placeholder="Seleccione Programa" data-dropdown-css-class="select2-danger" style="width: 100%;"></select>
                        </div>
                        

                        <div class="col-md-2">
                            <label for="">Color</label>
                            <select name="" id="cbocolor" class="custom-select custom-select-sm select2"  multiple="multiple" data-placeholder="Seleccione Color" data-dropdown-css-class="select2-danger" style="width: 100%;" ></select>
                        </div>

                        <div class="col-md-2">
                            <label for="">Estatus</label>
                            <select name="" id="cboestatus" class="custom-select custom-select-sm">
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="">Partida</label>
                            <input type="text" class="form-control form-control-sm" id="txtpartida">
                            <!-- <input type="text" class="form-control form-control-sm" id="txtpartida" value="C305335"> -->

                        </div>

                        <div class="col-md-2">
                            <label for="">Codigo Tela</label>
                            <input type="text" class="form-control form-control-sm" id="txtcodtela">
                        </div>

                        <div class="col-md-2">
                            <label for="">Desde</label>
                            <input type="date" class="form-control form-control-sm" id="txtfechain">
                        </div>

                        <div class="col-md-2">
                            <label for="">Hasta</label>
                            <input type="date" class="form-control form-control-sm" id="txtfechafn">
                        </div>


                    </div>

                </div>

            </div>


            <button class="btn btn-sm  btn-primary float-right ml-2" type="submit">Buscar</button>

            <!-- <button class="btn btn-sm  btn-danger float-right" id="btnguardar" type="button">Guardar</button> -->

            <button class="btn btn-sm  btn-warning float-right " id="btnmostrar" type="button">
                <i class="fas fa-eye-slash"></i>
            </button>

            <button class="btn btn-sm btn-success float-right mr-2" id="btnocultarcolumnas"  type="button">
                        <i class="fas fa-arrow-left"></i>
            </button>


        </form>

    </div>

    <!-- TABLA  -->
    <div class="card mt-3" id="card2">

        <div class="container-general float-left w-100">


            <div class="header float-left w-750 width" id="header1" >

                <div class="bg-header1 text-center w-750 width font-weight-bold" style="padding:0px">
                    INFORMACIÓN DE LA PARTIDA
                </div>

                    <div class="th-tela bg-header1 " style="width: 30px;"> <label class="font-weight-bold">N°</label>
                    </div><div class="th-tela bg-header1 " style="width: 40px;"> <label class="font-weight-bold">Status</label>
                    </div><div class="th-tela bg-header1 columnakilos " style="width: 40px;"> <label class="font-weight-bold">Kilos</label>
                    </div><div class="th-tela bg-header1" style="width: 60px;"> <label class="font-weight-bold">Programa</label>
                    </div><div class="th-tela bg-header1" style="width: 75px;"> <label class="font-weight-bold">Cod Tela</label> 
                    </div><div class="th-tela bg-header1" style="width: 50px;"> <label class="font-weight-bold">Partida</label> 
                    </div><div class="th-tela bg-header1" style="width: 50px;"> <label class="font-weight-bold">Resultado</label> 
                    </div><div class="th-tela bg-header1" style="width: 40px;"> <label class="font-weight-bold">Fecha</label> 
                    </div><div class="th-tela bg-header1" style="width: 65px;"> <label class="font-weight-bold">Proveedor</label> 
                    </div><div class="th-tela bg-header1" style="width: 100px;"> <label class="font-weight-bold">Tipo de Tela</label> 
                    </div><div class="th-tela bg-header1" style="width: 50px;"> <label class="font-weight-bold">Color</label> 
                    </div><div class="th-tela bg-header1" style="width: 50px;"> <label class="font-weight-bold">Cod Color</label> 
                    </div><div class="th-tela bg-header1" style="width: 50px;"> <label class="font-weight-bold">Lavado</label> 
                    </div><div class="th-tela bg-header1" style="width: 50px;"> <label class="font-weight-bold">Ruta ERP</label> 

                    </div>
            </div>

            <div class="header float-left calc-750 calc" id="header2">

                <div class="bg-header2 font-weight-bold text-center" style="width: 400px;padding:0px;display: inline-block;">
                    ENCOGIMIENTO ESTÁNDAR PRIMERA
                </div><!--
                --><div class="bg-header3 text-white font-weight-bold text-center" style="width: 400px;padding:0px;display: inline-block;">
                    ENCOGIMIENTO TSC - TEXTIL PRIMERA
                </div><!--
                --><div class="bg-header4 font-weight-bold text-white text-center" style="width: 384px;padding:0px;display: inline-block;">
                DATOS REALES TSC - 1RA LAVADA
                </div><!--
                --><div class="bg-header1 font-weight-bold text-center" style="width: 401px;padding:0px;display: inline-block;">
                    ENCOGIMIENTO ESTÁNDAR TERCERA
                </div><!--
                --><div class="bg-header3 font-weight-bold text-white text-center" style="width: 400px;padding:0px;display: inline-block;">
                ENCOGIMIENTO TSC - TEXTIL TERCERA
                </div><!--
                --><div class="bg-tolerancias font-weight-bold text-white text-center" style="width: 400px;padding:0px;display: inline-block;">
                    TOLERANCIAS
                </div><!--
                --><div class="bg-header4 font-weight-bold text-white text-center" style="width: 425px;padding:0px;display: inline-block;">
                    DATOS REALES TSC - 3RA / 5TA LAVADA
                </div><!--
                --><div class="bg-header1 font-weight-bold  text-center" style="width: 160px;padding:0px;display: inline-block;">
                    <!-- Tolerancias B/W + - 5% --> TOL-DENSIDAD
                </div><!--
                --><div class="bg-header4 text-white text-center" style="width: 185px;padding:0px;display: inline-block;">
                    Encog. De Paños Lavados
                </div><!--
                --><div class="bg-header3 font-weight-bold text-white text-center" style="width: 265px;padding:0px;display: inline-block;">
                    Residual Paño
                </div><!--
                --><div class="bg-header4 font-weight-bold text-white text-center" style="width: 384px;padding:0px;display: inline-block;">
                1RA LAVADA (SECADO TAMBOR)
                </div><!--
                --><div class="bg-header2 font-weight-bold text-center" style="width: 425px;padding:0px;display: inline-block;">
                <!-- 3RA LAVADA (SECADO TAMBOR) -->
                5TA LAVADA (SECADO TAMBOR)
                </div><!--
                --><div class="bg-tolerancias  font-weight-bold text-white text-center" style="width: 220px;padding:0px;display: inline-block;">
                    Datos Extra
                </div>

                <br>

                <!-- ENCOGIMIENTO PRIMERA -->
                <div class="bg-header2 th">
                    <label class="verticalText ">Hilo</label>
                    <!-- Hilo -->
                </div><div class="bg-header2 th">
                    <label class="verticalText ">Trama</label>
                    <!-- Trama -->
                </div><div class="bg-header2 th"><label class="verticalText ">Densidad B/W</label>
                </div><div class="bg-header2 th"><label class="verticalText ">Densidad (A/W)</label>
                </div><div class="bg-header2 th"><label class="verticalText ">Ancho (B/W)</label>
                </div><div class="bg-header2 th"><label class="verticalText ">Ancho (A/W)</label>
                </div><div class="bg-header2 th"><label class="verticalText ">Incli Acabados (B/W)</label>
                </div><div class="bg-header2 th"><label class="verticalText ">Incli Acabados (A/W)</label>
                </div><div class="bg-header2 th"><label class="verticalText ">Solides</label>
                </div><div class="bg-header2 th"><label class="verticalText ">Revirado</label></div><!--
                ENCOGIMIENTO PRIMERA TSC--><div class="bg-header3 th"><label class="verticalText text-white">Hilo</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Trama</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Densidad B/W</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Densidad (A/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Ancho (B/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Ancho (A/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Incli Acabados (B/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Incli Acabados (A/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Solides</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Revirado</label></div><!--
                REALES TSC PRIMERA --><div class="bg-header4 th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Hilo</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Trama</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Densidad B/W</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">º de Inclinacion</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Ancho Total (B/W)</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Ancho Util (B/W)</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Revirado 1</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Revirado 2</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Revirado 3</label></div><!--
                ENCOGIMIENTO TERCERA --><div class="bg-header1 th"><label class="verticalText ">Hilo</label>
                </div><div class="bg-header1 th"><label class="verticalText ">Trama</label>
                </div><div class="bg-header1 th"><label class="verticalText ">Densidad B/W</label>
                </div><div class="bg-header1 th"><label class="verticalText ">Densidad (A/W)</label>
                </div><div class="bg-header1 th"><label class="verticalText ">Ancho (B/W)</label>
                </div><div class="bg-header1 th"><label class="verticalText ">Ancho (A/W)</label>
                </div><div class="bg-header1 th"><label class="verticalText ">Incli Acabados (B/W)</label>
                </div><div class="bg-header1 th"><label class="verticalText ">Incli Acabados (A/W)</label>
                </div><div class="bg-header1 th"><label class="verticalText ">Solides</label>
                </div><div class="bg-header1 th"><label class="verticalText ">Revirado</label></div><!--
                ENCOGIMIENTO TERCERA TSC--><div class="bg-header3 th"><label class="verticalText text-white">Hilo</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Trama</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Densidad B/W</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Densidad (A/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Ancho (B/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Ancho (A/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Incli Acabados (B/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Incli Acabados (A/W)</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Solides</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Revirado</label></div><!--
                TOLERANCIA ENCOGIMIENTO TERCERA --><div class="bg-tolerancias th"><label class="verticalText text-white">Hilo</label>
                </div><div class="bg-tolerancias th"><label class="verticalText text-white">Trama</label>
                </div><div class="bg-tolerancias th"><label class="verticalText text-white">Densidad B/W</label>
                </div><div class="bg-tolerancias th"><label class="verticalText text-white">Densidad (A/W)</label>
                </div><div class="bg-tolerancias th"><label class="verticalText text-white">Ancho (B/W)</label>
                </div><div class="bg-tolerancias th"><label class="verticalText text-white">Ancho (A/W)</label>
                </div><div class="bg-tolerancias th"><label class="verticalText text-white">Incli Acabados (B/W)</label>
                </div><div class="bg-tolerancias th"><label class="verticalText text-white">Incli Acabados (A/W)</label>
                </div><div class="bg-tolerancias th"><label class="verticalText text-white">Solides</label>
                </div><div class="bg-tolerancias th"><label class="verticalText text-white">Revirado</label></div><!--
                REALES TSC TERCERA --><div class="bg-header4  th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Hilo</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Trama</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Densidad A/W</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">º de Inclinacion</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Ancho Total (A/W)</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Ancho Util (A/W)</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Revirado 1</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Revirado 2</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Revirado 3</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Solidez</label></div><!--
                TOLERANCIAS BEFORE --><div class="bg-header1 th"><label class="">B/W +5%</label>
                </div><div class="bg-header1 th"><label class="verticalText ">B/W -5%</label></div><!--                
                TOLERANCIAS AFTER --><div class="bg-header1 th"><label class="">A/W +5%</label>
                </div><div class="bg-header1 th"><label class="verticalText ">A/W -5%</label></div><!--
                Encog. De Paños Lavados --><div class="bg-header4  th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                </div><div class="bg-header4  th"><label class="text-white">Hilo</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">Trama</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">° INCLINACIÓN B/W</label>
                </div><div class="bg-header4  th"><label class="verticalText text-white">° INCLINACIÓN A/W</label></div><!-- 
                RESIDUALES PAÑO --><div class="bg-header3 th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Hilo</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Trama</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">º de Inclinacion</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Revirado 1</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Revirado 2</label>
                </div><div class="bg-header3 th"><label class="verticalText text-white">Revirado 3</label></div><!--
                REALES TSC PRIMERA --><div class="bg-header4 th" style='width: 25px;padding-left:0px'><label class="text-white">OP</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Hilo</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Trama</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Densidad B/W</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">º de Inclinacion</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Ancho Total (B/W)</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Ancho Util (B/W)</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Revirado 1</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Revirado 2</label>
                </div><div class="bg-header4 th"><label class="verticalText text-white">Revirado 3</label></div><!--
                REALES TSC TERCERA --><div class="bg-header2  th" style='width: 25px;padding-left:0px'><label class="">OP</label>
                </div><div class="bg-header2  th"><label class="verticalText ">Hilo</label>
                </div><div class="bg-header2  th"><label class="verticalText ">Trama</label>
                </div><div class="bg-header2  th"><label class="verticalText ">Densidad A/W</label>
                </div><div class="bg-header2  th"><label class="verticalText ">º de Inclinacion</label>
                </div><div class="bg-header2  th"><label class="verticalText ">Ancho Total (A/W)</label>
                </div><div class="bg-header2  th"><label class="verticalText ">Ancho Util (A/W)</label>
                </div><div class="bg-header2  th"><label class="verticalText ">Revirado 1</label>
                </div><div class="bg-header2  th"><label class="verticalText ">Revirado 2</label>
                </div><div class="bg-header2  th"><label class="verticalText ">Revirado 3</label>
                </div><div class="bg-header2  th"><label class="verticalText ">Solidez</label></div><!--
                FECHA DE LIBERACIÓN --><div class="bg-tolerancias th"><label class="text-white">F. LIBERACIÓN</label>
                </div><!-- LIBERADO POR --><div class="bg-tolerancias th"><label class="text-white">LIBERADO POR</label>
                </div><!-- OBSERVACIONES TSC --><div class="bg-tolerancias th" style="width:100px !important"><label class="text-white">OBSERVACIONES</label>
                </div><!-- CONCESION --><div class="bg-tolerancias th" ><label class="text-white">CONCESIÓN</label>
                </div>

            </div>


            <!-- BODY DATOS TELA -->
            <div id="container-datos-tela" class="float-left w-750 width">
            
            </div>

            <!-- CONTENEDOR DE DATOS DE GENERALES -->
            <div id="container-datos-generales" class="float-left calc-750 calc">
            
            </div>

        </div>
        
    </div>

</div>


<!-- MODALS -->
<?php  
    // MODAL LAVADAS
    require_once 'modallavada.php'; 
    // MODAL ENCOGIMIENTOS
    require_once 'modalencogimiento.php'; 
    // MODAL AGRUPADOR
    require_once 'modalpartidasagrupadas.php';
    // MODAL MOTIVOS DE RECHAZO
    require_once 'modalmotivos.php';
?> 


<div class="loader"></div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>


<script src="../../js/testing/functions.js"></script>
<script src="../../js/testing/events.js"></script>
<!-- <script src="../../../libs/admin/registrometales/registro.js"></script> -->



<script >
    let mostrar = true;
    const frmbusqueda       = document.getElementById("frmbusqueda");
    // const frmmodal          = document.getElementById("frmmodal");
    const frmencogimiento   = document.getElementById("frmencogimiento");
    const frmagrupador      = document.getElementById("frmagrupador");
    let IDLAVADA    = null;
    let TIPOLAVADA  = null;
    let FILA        = null;
    let BOLSAS              = [];
    let DETALLEBOLSAS       = [];
    let IDTESTING   = null;
    let PARTIDA     = null;
    let KILOS       = null;
    let LOTE        = null;
    let ESTADOSTESTING = [];
    let FILASOMBREADA = null;
    let OCULTARCOLUMNAS = true;
    let MOTIVOSDEVOLUCION = [];
    let ESTADONUEVO = null;
    let IDBOLSA  = null;
    let USUARIO = "<?php echo $_SESSION['user'];?>";
    let frmbolsas         = document.getElementsByClassName("frmbolsas");
    let CALCULAPORCENTAJE = 25.5;
    let IDCLIENTE = null;
    let IDPROVEEDOR = null;
    // let CODIGOCLIENTEDEVANLAY   = "";
    let CODIGOCLIENTEDEVANLAY   = "001000088000000";
    let TAMBOR = 0;


    // LOAD
    window.addEventListener("load",async ()=>{

        // SELECT 2
        $(".select2").select2();

        // SELECT 2 PROGRAMA
        $(".select2programa").select2({
            placeholder : "Seleccione cliente",
            language: {
                noResults: function() {
                    return 'SELECCIONE UN CLIENTE PRIMERO';
                },
            },
        });

        // SELECT 2 ARTICULO TELA
        $(".select2articulotela").select2({
            placeholder : "Seleccione cliente",
            language: {
                noResults: function() {
                    return 'SELECCIONE UN CLIENTE PRIMERO';
                },
            },
        });


        // PROVEEDORES DE TELA
        await getproveedores();

        // CLIENTES
        await getclientes();

        // COLORES
        await getcolores();

        // ESTADOS TESTING
        await getEstadoTesting();

        // MOTIVOS DE  DEVOLUCION
        await getMotivosDevolucion();
        

        // OCULTAMOS CARGA
        $(".loader").fadeOut("slow");
    });

    // MOSTRAR OCULTAR
    $("#btnmostrar").click(function(){
        mostrar = !mostrar;

        if(mostrar){
            $(".busquedas").removeClass("d-none");
            $(this).html("<i class='fas fa-eye-slash'></i>");
        }else{
            $(".busquedas").addClass("d-none");
            $(this).html("<i class='fas fa-eye'></i>");
        }

    });

    // EVENTO DE BUSQUEDA
    frmbusqueda.addEventListener('submit',(e)=>{

        e.preventDefault();
        getTesting();

    });


    // REGISTRAMOS BOLSAS
    for(let item of frmbolsas){

        item.addEventListener('submit',async (e)=>{
            e.preventDefault();
            await saveBolsasIndividual(item);
        });

    }


    // DATOS SEGUN CLIENTE
    $("#cbocliente").change(async function(){

        // let cli9 = $("#cbocliente").find(':selected').data('cgc_cliente9');
        // let cli4 = $("#cbocliente").find(':selected').data('cgc_cliente4');
        // let cli2 = $("#cbocliente").find(':selected').data('cgc_cliente2');

        // await getprogramacliente(cli9,cli4,cli2);
        let id = $(this).val();
        await getarticulostela(id);
        await getprogramacliente(id);

    });


    // SCROOL TOP
    $("#container-datos-generales").scroll(function(){
        $("#container-datos-tela").scrollTop( $("#container-datos-generales").scrollTop() );
        $("#header2").scrollLeft( $("#container-datos-generales").scrollLeft())
    })

    $("#container-datos-tela").scroll(function(){
        $("#header1").scrollLeft( $("#container-datos-tela").scrollLeft())
    });

    // MOSTRAMOS MODAL LAVADO
    $("#container-datos-generales").on('click','.openlavado',async function(){

        $("#idbolsa1").val("");
        $("#idbolsa2").val("");
        $("#idbolsa3").val("");


        let response = await getSelectValue([
            {   id:"D",
                title:"Mostrar detalle"
            },
            {   id:"S",
                title:"Modificar"
            },
        ],"id","title","Seleccione operación");


        // OBTENEMOS DATOS
        PARTIDA     =  $(this).data("partida");
        KILOS       =  $(this).data("kilos");
        LOTE        =  $(this).data("lote");
        IDLAVADA    =  $(this).data("idlavada");
        TIPOLAVADA  =  $(this).data("lavada");
        FILA        =  $(this).data("fila");
        IDTESTING   =  $(this).data("idtesting");
        IDCLIENTE   =  $(this).data("idcliente");
        IDPROVEEDOR =  $(this).data("idproveedor");
        TAMBOR      =  $(this).data("tambor");


        // HACEMOS CALCULO SI ES CLIENTE DEVANLAY
        if(IDCLIENTE == CODIGOCLIENTEDEVANLAY){
            // CALCULAPORCENTAJE = 46;
            CALCULAPORCENTAJE = 25.5;

        }else{
            CALCULAPORCENTAJE = 25.5;
        }



        // MODIFICAR DETALLE
        if(response == "D"){

            MostrarCarga("Cargando...");


            // LIMPIAMOS FORMULARIO
            $(".frmbolsas")[0].reset();
            $(".frmbolsas")[1].reset();
            $(".frmbolsas")[2].reset();


            // frmmodal.reset();   
            $(".totalhilo").text("");
            $(".totaltrama").text("");
            $("#promediohilo").text("");
            $("#promediotrama").text("");
            $("#reviradobolsa1").text("");
            $("#reviradobolsa2").text("");
            $("#reviradobolsa3").text("");


            // // PRIMERO O TERCERA LAVADA
            $("#tdlabellavada").text(`MUESTRA ${TIPOLAVADA}RA LAVADA`);
            $("#modallavadolabel").text("Datos Reales Lavadas: " + PARTIDA);


            // LIMPIAMOS ARRAY DE BOLSAS
            BOLSAS          = [];
            DETALLEBOLSAS   = [];

            // BOLSAS
            let bolsa1 = await getbolsa(IDLAVADA,1);
            let bolsa2 = await getbolsa(IDLAVADA,2);
            let bolsa3 = await getbolsa(IDLAVADA,3);


            if(DETALLEBOLSAS.length == 9 && BOLSAS.length == 3){
                // MOSTRAMOS DATOS CALCULADOS
                getPromedio("totalhilo","promediohilo");
                getPromedio("totaltrama","promediotrama");

                $(`#lblpartidalavado`).text(`PARTIDA ${PARTIDA}`);

                // InformarMini("Cargado");
                OcultarCarga();

                $("#modallavado").modal({
                    backdrop: 'static', 
                    keyboard: false,
                    show:true
                });

            }else{
                Advertir("No se generaron las 3 bolsas vuelva a intentarlo");
            }

        }

        // MODIFICAR CABECERA
        if(response == "S"){  
            // console.log("Estas guardando");
            MostrarCarga("Cargando...");
            
            // REGISTRAMOS TESTING
            await setTesting();

            let hilo        = parseFloatSistema(replacevalor($(`.hilo${TIPOLAVADA}${FILA}`).val().trim(),"%"));
            let trama       = parseFloatSistema(replacevalor($(`.trama${TIPOLAVADA}${FILA}`).val().trim(),"%"));
            let densidad    = parseFloatSistema($(`.densidad${TIPOLAVADA}${FILA}`).val().trim());
            let inclinacion = parseFloatSistema(replacevalor($(`.inclinacion${TIPOLAVADA}${FILA}`).val().trim(),"°"));
            let anchototal  = parseFloatSistema($(`.ancho${TIPOLAVADA}${FILA}`).val().trim());
            let anchoutil   = parseFloatSistema($(`.anchoutil${TIPOLAVADA}${FILA}`).val().trim());
            let revirado1   = parseFloatSistema(replacevalor($(`.revirado1${TIPOLAVADA}${FILA}`).val().trim(),"%"));
            let revirado2   = parseFloatSistema(replacevalor($(`.revirado2${TIPOLAVADA}${FILA}`).val().trim(),"%"));
            let revirado3   = parseFloatSistema(replacevalor($(`.revirado3${TIPOLAVADA}${FILA}`).val().trim(),"%"));
            let solidez     = null;

            if(TIPOLAVADA == 3){
                solidez = parseFloatSistema($(`.solidez${TIPOLAVADA}${FILA}`).val().trim());
            }


            let responseupdatelavado = await get("auditex-testing","testing","setupdatelavadamanual",{
                idreallavada:IDLAVADA,  idtesting:IDTESTING,    tipolavada:TIPOLAVADA,
                hilo,                   trama,                  densidad,       inclinacion,        anchototal,
                revirado1,              revirado2,              revirado3,      solidez,            anchoutil,
                tambor:     TAMBOR 
            });

            IDLAVADA = responseupdatelavado.ID;

            InformarMini("Modificado correctamente");

        }

        
    });

    // MOSTRAMOS MODAL ENCOGIMIENTO
    $("#container-datos-generales").on('click','.openencogimiento',async function(){

        frmencogimiento.reset();

        PARTIDA     =  $(this).data("partida");
        LOTE        =  $(this).data("lote");
        IDLAVADA    =  $(this).data("idlavada");
        // TIPOLAVADA  =  $(this).data("lavada");
        FILA        =  $(this).data("fila");
        IDTESTING   =  $(this).data("idtesting");
        KILOS       = $(this).data("kilos");
        IDPROVEEDOR =  $(this).data("idproveedor");



        let rpt = await getSelectValue([
            {   id:"D",
                title:"Mostrar detalle"
            },
            {   id:"S",
                title:"Modificar"
            },
        ],"id","title","Seleccione operación");

        // DETALLE
        if(rpt == "D"){

            MostrarCarga("Cargando...");

            // TRAEMOS REGISTROS BEFORE
            let datosbefore = await get("auditex-testing","testing","getencogimientos",{
                idtesting:IDTESTING,tipo:'B'
            });

            // ASIGNAMOS DATOS
            if(datosbefore){
                $("#hiloencogimientobefore").val( parseFloatSistema( datosbefore.HILO ) );
                $("#tramaencogimientobefore").val( parseFloatSistema( datosbefore.TRAMA ) );
            }

            
            // TRAEMOS REGISTROS
            let datosafter = await get("auditex-testing","testing","getencogimientos",{
                idtesting:IDTESTING,tipo:'A'
            });

            // ASIGNAMOS DATOS AFTER
            if(datosbefore){
                $("#hiloencogimientoafter").val( parseFloatSistema( datosafter.HILO ) );
                $("#tramaencogimientoafter").val( parseFloatSistema( datosafter.TRAMA ) );
            }

            setEncogimientos("trama");
            setEncogimientos("hilo");

            // VALORES REGISTRADOS EN CABECERA
            let responsecabecera = await  get("auditex-testing","testing","getencogimientoreal",{
                idtesting:IDTESTING
            });


            // SET VALORES
            $(`#hilorealencogimiento`).val( responsecabecera.HILOENCOGIMIENTO );
            $(`#tramarealencogimiento`).val(responsecabecera.TRAMAENCOGIMIENTO);

            $(`#inclinacionbefore`).val(responsecabecera.INCLINACIONBEFORE);
            $(`#inclinacionafter`).val( responsecabecera.INCLINACIONAFTER);

            // InformarMini("Cargado");
            OcultarCarga();

            $("#modalencogimiento").modal(
                {
                backdrop: 'static', 
                keyboard: false,
                show:true
                }
            );


        }

        // SAVE
        if(rpt == "S"){

            MostrarCarga("Cargando...");

            // ACTUALIZAMOS ENCOGIMIENTOS
            let responseupdate = await get("auditex-testing","testing","updateencogimientos",{
                idtesting:IDTESTING,
                hilo:   parseFloatSistema( replacevalor($(`.hiloencogimiento${FILA}`).val().trim(),"%") ),
                trama:  parseFloatSistema( replacevalor($(`.tramaencogimiento${FILA}`).val().trim(),"%") ),
                inclib: parseFloatSistema($(`.inclibefore${FILA}`).val().trim() ),
                inclia: parseFloatSistema($(`.incliafter${FILA}`).val().trim() )
            });

            //console.log(responseupdate);

            InformarMini("Actualizado correctamente");

        }

        
    });

    // MOSTRAMOS MODAL RESIDUAL
    $("#container-datos-generales").on('click','.openresidual',async function(){


        $("#idbolsa1").val("");
        $("#idbolsa2").val("");
        $("#idbolsa3").val("");

        let response = await getSelectValue([
            {   id:"D",
                title:"Mostrar detalle"
            },
            {   id:"S",
                title:"Modificar"
            },
        ],"id","title","Seleccione operación");


        // OBTENEMOS DATOS
        PARTIDA     =  $(this).data("partida");
        KILOS       =  $(this).data("kilos");
        LOTE        =  $(this).data("lote");
        IDLAVADA    =  $(this).data("idresidual");
        TIPOLAVADA  =  "R";
        FILA        =  $(this).data("fila");
        IDTESTING   =  $(this).data("idtesting");
        IDCLIENTE   =  $(this).data("idcliente");
        IDPROVEEDOR =  $(this).data("idproveedor");

        // console.log(IDCLIENTE,"IDCLIENTE");


        // HACEMOS CALCULO SI ES CLIENTE DEVANLAY
        if(IDCLIENTE == CODIGOCLIENTEDEVANLAY){
            // CALCULAPORCENTAJE = 46;
            CALCULAPORCENTAJE = 25.5;

        }else{
            CALCULAPORCENTAJE = 25.5;
        }

        // MODIFICAR DETALLE
        if(response == "D"){

            MostrarCarga("Cargando...");


            // LIMPIAMOS FORMULARIO
            $(".frmbolsas")[0].reset();
            $(".frmbolsas")[1].reset();
            $(".frmbolsas")[2].reset();
            // frmmodal.reset();   
            $(".totalhilo").text("");
            $(".totaltrama").text("");
            $("#promediohilo").text("");
            $("#promediotrama").text("");
            $("#reviradobolsa1").text("");
            $("#reviradobolsa2").text("");
            $("#reviradobolsa3").text("");


            // RESIDUAL
            $("#tdlabellavada").text(`RESIDUAL`);
            $("#modallavadolabel").text("Residual Paños: " + PARTIDA);

            // LIMPIAMOS ARRAY DE BOLSAS
            BOLSAS          = [];
            DETALLEBOLSAS   = [];

            // BOLSAS
            let bolsa1 = await getbolsa(null,1,IDLAVADA);
            let bolsa2 = await getbolsa(null,2,IDLAVADA);
            let bolsa3 = await getbolsa(null,3,IDLAVADA);


            if(DETALLEBOLSAS.length == 9 && BOLSAS.length == 3){

                // MOSTRAMOS DATOS CALCULADOS
                getPromedio("totalhilo","promediohilo");
                getPromedio("totaltrama","promediotrama");

                $(`#lblpartidalavado`).text(`PARTIDA ${PARTIDA}`);

                // InformarMini("Cargado");
                OcultarCarga();

                $("#modallavado").modal({
                    backdrop: 'static', 
                    keyboard: false,
                    show:true
                });

            }else{
                Advertir("No se generaron las 3 bolsas vuelva a intentarlo");
            }

        }

        // MODIFICAR CABECERA
        if(response == "S"){  
            // console.log("Estas guardando");
            MostrarCarga("Cargando...");
            
            // REGISTRAMOS TESTING
            await setTesting();

            let hilo        = parseFloatSistema(replacevalor($(`.hilo${FILA}`).val().trim(),"%"));
            let trama       = parseFloatSistema(replacevalor($(`.trama${FILA}`).val().trim(),"%"));
            let inclinacion = parseFloatSistema(replacevalor($(`.inclinacion${FILA}`).val().trim(),"°"));
            let revirado1   = parseFloatSistema(replacevalor($(`.revirado1${FILA}`).val().trim(),"%"));
            let revirado2   = parseFloatSistema(replacevalor($(`.revirado2${FILA}`).val().trim(),"%"));
            let revirado3   = parseFloatSistema(replacevalor($(`.revirado3${FILA}`).val().trim(),"%"));
            // let solidez     = null;

           

            let responseupdatelavado = await get("auditex-testing","testing","setupdateresidualpanomanual",{
                idresidualpano:IDLAVADA,    idtesting:IDTESTING,
                hilo,       trama,          inclinacion,
                revirado1,  revirado2,      revirado3
            });

            IDLAVADA = responseupdatelavado.ID;

            InformarMini("Modificado correctamente");

        }


    });

    // OPEN LAVADO TAMBOR
    $("#container-datos-generales").on('click','.openlavadotambor',async function(){

        $("#idbolsa1").val("");
        $("#idbolsa2").val("");
        $("#idbolsa3").val("");


        let response = await getSelectValue([
        {   id:"D",
            title:"Mostrar detalle"
        },
        {   id:"S",
            title:"Modificar"
        },
        ],"id","title","Seleccione operación");


        // OBTENEMOS DATOS
        PARTIDA     =  $(this).data("partida");
        KILOS       =  $(this).data("kilos");
        LOTE        =  $(this).data("lote");
        IDLAVADA    =  $(this).data("idlavadatambor");
        TIPOLAVADA  =  $(this).data("lavada");
        FILA        =  $(this).data("fila");
        IDTESTING   =  $(this).data("idtesting");
        IDCLIENTE   =  $(this).data("idcliente");
        IDPROVEEDOR =  $(this).data("idproveedor");
        TAMBOR      =  $(this).data("tambor");


        // HACEMOS CALCULO SI ES CLIENTE DEVANLAY
        if(IDCLIENTE == CODIGOCLIENTEDEVANLAY){
            // CALCULAPORCENTAJE = 46;
            // CALCULAPORCENTAJE = 46;
            CALCULAPORCENTAJE = 25.5;
        }else{
            CALCULAPORCENTAJE = 25.5;
        }



        // MODIFICAR DETALLE
        if(response == "D"){

            MostrarCarga("Cargando...");


            // LIMPIAMOS FORMULARIO
            $(".frmbolsas")[0].reset();
            $(".frmbolsas")[1].reset();
            $(".frmbolsas")[2].reset();


            // frmmodal.reset();   
            $(".totalhilo").text("");
            $(".totaltrama").text("");
            $("#promediohilo").text("");
            $("#promediotrama").text("");
            $("#reviradobolsa1").text("");
            $("#reviradobolsa2").text("");
            $("#reviradobolsa3").text("");


            // // PRIMERO O TERCERA LAVADA
            $("#tdlabellavada").text(`MUESTRA ${TIPOLAVADA}RA LAVADA TAMBOR`);
            $("#modallavadolabel").text("Datos Reales Lavadas: " + PARTIDA);


            // LIMPIAMOS ARRAY DE BOLSAS
            BOLSAS          = [];
            DETALLEBOLSAS   = [];

            // BOLSAS
            let bolsa1 = await getbolsa(null,1,null,IDLAVADA);
            let bolsa2 = await getbolsa(null,2,null,IDLAVADA);
            let bolsa3 = await getbolsa(null,3,null,IDLAVADA);


            if(DETALLEBOLSAS.length == 9 && BOLSAS.length == 3){
                // MOSTRAMOS DATOS CALCULADOS
                getPromedio("totalhilo","promediohilo");
                getPromedio("totaltrama","promediotrama");

                $(`#lblpartidalavado`).text(`PARTIDA ${PARTIDA}`);

                // InformarMini("Cargado");
                OcultarCarga();

                $("#modallavado").modal({
                    backdrop: 'static', 
                    keyboard: false,
                    show:true
                });

            }else{
                Advertir("No se generaron las 3 bolsas vuelva a intentarlo");
            }

        }

        // MODIFICAR CABECERA
        if(response == "S"){  
            // console.log("Estas guardando");
            MostrarCarga("Cargando...");

            // REGISTRAMOS TESTING
            await setTesting();

            let hilo        = parseFloatSistema(replacevalor($(`.hilo${TIPOLAVADA}${FILA}tambor`).val().trim(),"%"));
            let trama       = parseFloatSistema(replacevalor($(`.trama${TIPOLAVADA}${FILA}tambor`).val().trim(),"%"));
            let densidad    = parseFloatSistema($(`.densidad${TIPOLAVADA}${FILA}tambor`).val().trim());
            let inclinacion = parseFloatSistema(replacevalor($(`.inclinacion${TIPOLAVADA}${FILA}tambor`).val().trim(),"°"));
            let anchototal  = parseFloatSistema($(`.ancho${TIPOLAVADA}${FILA}tambor`).val().trim());
            let anchoutil   = parseFloatSistema($(`.anchoutil${TIPOLAVADA}${FILA}tambor`).val().trim());
            let revirado1   = parseFloatSistema(replacevalor($(`.revirado1${TIPOLAVADA}${FILA}tambor`).val().trim(),"%"));
            let revirado2   = parseFloatSistema(replacevalor($(`.revirado2${TIPOLAVADA}${FILA}tambor`).val().trim(),"%"));
            let revirado3   = parseFloatSistema(replacevalor($(`.revirado3${TIPOLAVADA}${FILA}tambor`).val().trim(),"%"));
            let solidez     = null;

            if(TIPOLAVADA == 3){
                solidez = parseFloatSistema($(`.solidez${TIPOLAVADA}${FILA}tambor`).val().trim());
            }


            let responseupdatelavado = await get("auditex-testing","testing","setupdatelavadamanual",{
                idreallavada:IDLAVADA,  idtesting:IDTESTING,    tipolavada:TIPOLAVADA,
                hilo,                   trama,                  densidad,       inclinacion,        anchototal,
                revirado1,              revirado2,              revirado3,      solidez,            anchoutil,
                tambor:     TAMBOR
            });

            IDLAVADA = responseupdatelavado.ID;

            InformarMini("Modificado correctamente");

        }


    });

    function PintarDireccionales(scrool = false){
        $(".input-hover").removeClass("bg-sombreado");
        // $(".td-tela").removeClass("bg-sombreado");

        $(`.sombreado${FILASOMBREADA}`).addClass("bg-sombreado");

        // if(scrool){
        //     $("#container-datos-generales").scrollTop(scrool);
        //     $("#container-datos-tela").scrollTop(scrool);
        // }
    }


    // DIRECCIONALES
    $(document).keyup( function(e){
        // console.log(e.which);

            // if(FILASOMBREADA != null){

            //     // $("#container-datos-tela").scrollTop( $("#container-datos-generales").scrollTop() );
            //     let scrool      = $("#container-datos-generales").scrollTop();
            //     // let scroolleft  = $("#container-datos-generales").scrollLeft();

            //     // console.log(scrool,"valor");


            //     // ARRIBA
            //     if(e.which == 38){
            //         FILASOMBREADA--;
            //         scrool -= 30;
            //     }

            //     // ABAJO
            //     if(e.which == 40){
            //         FILASOMBREADA++;
            //         scrool += 30;

            //     }


            //     // console.log(scrool);
            //     PintarDireccionales(scrool);

            // }

    });

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    
    $("#btnocultarcolumnas").click(function(){

        OCULTARCOLUMNAS = !OCULTARCOLUMNAS;

        $("#btnocultarcolumnas").html(
            OCULTARCOLUMNAS ? `<i class="fas fa-arrow-left"></i>` : `<i class="fas fa-arrow-right"></i>`
        );

        // MOSTRAMOS
        if(OCULTARCOLUMNAS){

            $(".calc").removeClass("calc-655");
            $(".calc").addClass("calc-750");

            $(".width").removeClass("w-655");
            $(".width").addClass("w-750");
           

            $(".columnakilos").removeClass("d-none");


        }else{ // OCULTAMOS

            $(".calc").removeClass("calc-750");
            $(".calc").addClass("calc-655");

            $(".width").removeClass("w-750");
            $(".width").addClass("w-655");

            $(".columnakilos").addClass("d-none");

        }

    });



</script>    

</body>
</html>