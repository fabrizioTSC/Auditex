<?php
	date_default_timezone_set('America/Lima');
	session_start();
	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Indicador general testing";

    function getNameMonth($fecha){

        $mes =  date("m", strtotime($fecha));
        $mes = (float)$mes;
        $name = "";

        switch ($mes) {
            case 1: $name = "Enero"; break;
            case 2: $name = "Febrero"; break;
            case 3: $name = "Marzo"; break;
            case 4: $name = "Abril"; break;
            case 5: $name = "Mayo"; break;
            case 6: $name = "Junio"; break;
            case 7: $name = "Julio"; break;
            case 8: $name = "Agosto"; break;
            case 9: $name = "Septiembre"; break;
            case 10: $name = "Octubre"; break;
            case 11: $name = "Noviembre"; break;
            case 12: $name = "Diciembre"; break;
        }

        return $name;


    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicador general testing</title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>
    <!-- <link rel="stylesheet" href="../../../libs/css/mdb.min.css"> -->
    <style>
        body{
            font-family: 'Roboto',sans-serif !important;
            font-size: 11px !important;
            padding-top: 60px !important;
        }
        
        /* td,th{
            padding: 1px !important;
        } */

        .tabletblgeneral td,th{
            padding: 4px !important;
            /* font-weight: normal !important; */
        }

        /* .tabletblgeneral td,th{
            padding: 2px !important;
        } */

        .table{
            margin-bottom: 0px !important;
        }
        hr{
            border:0.8px solid #fff;
        }
        label{
            margin-bottom: 0px !important;
        }
    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>


    <?php if(!isset($_POST["reporte"]) ): ?> 
        <!-- FILTROS -->
        <div class="container mt-3 pl-md-5 pr-md-5"> 

                <div class="row justify-content-md-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <form action="" method="POST" autocomplete="off">

                                    <div class="form-group">
                                        <label for="">Proveedor</label>
                                        <select name="proveedor" id="cboproveedor" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="">Cliente</label>
                                        <select name="cliente" id="cbocliente" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Programa</label>
                                        <select name="programa[]" id="cboprograma" class="custom-select custom-select-sm select2" style="width: 100%;" multiple ></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Codigo de Tela</label>
                                        <input type="text" name="codtela" class="form-control form-control-sm" >
                                    </div>

                                    <div class="form-group">
                                        <label for="">Tipos de Tela</label>
                                        <select name="tipotela[]" id="cbotipotela" class="custom-select custom-select-sm select2" style="width: 100%;" multiple></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Fecha Corte</label>
                                        <input type="date" name="fecha" class="form-control form-control-sm" value="<?php echo date("Y-m-d");?>"  required>
                                    </div>

                                    

                                    <div class="form-group">
                                        <input type="hidden" name="reporte" value="Y">
                                        <button class="btn btn-block btn-primary btn-sm" type="submit">Buscar</button>
                                    </div>
                                </form>
                            


                            </div>
                        </div>
                    </div>
                </div>
                
        </div>
    <?php else: ?> 
        <!-- INDICADOR -->
        <div class="container mt-3 pl-md-5 pr-md-5 text-center">

            <div class="row justify-content-md-center">

                    <!-- EXPORTAR PDF -->
                    <form class="col-md-8" id="frmvolver" method="POST">
                        <input type="hidden" name="notreporte" value="N">
                        <button class="btn btn-sm btn-warning" type="submit" id="btnvolver"> <i class="fas fa-arrow-left"></i> Volver  </button>
                        <button class="btn btn-sm btn-danger" type="button" id="btnexportarpdf">Exportar <i class="fas fa-file-pdf"></i> </button>
                    </form>

                    <!-- DESCRIPCIONES -->
                    <div class="col-md-8 text-white pt-1" style="font-size: 13px !important;">
                        <label>INDICADOR GENERAL DE TESTING</label>
                        <br>

                        <!-- PROVEEDOR -->
                        <label >PROVEEDOR:</label> 
                        <label id="lblproveedor"></label>
                        <label >/</label> 

                        <!-- CLIENTE -->
                        <label >CLIENTE:</label> 
                        <label id="lblcliente"></label>
                        <label >/</label> 

                        <!-- PROGRAMA -->
                        <label >PROGRAMA:</label> 
                        <label id="lblprograma"></label>
                        <label >/</label> 

                        <!-- CODIGO DE TELA -->
                        <label >CODIGO DE TELA:</label> 
                        <label id="lblcodtela"></label>
                        <label >/</label> 

                        <!-- TIPOS DE TELA -->
                        <label >TIPOS DE TELA:</label> 
                        <label id="lbltipotela"></label>
                        <label >/</label> 

                        <!-- FECHA -->
                        <label >FECHA:</label> 
                        <label id="lblfecha"></label>

                    </div>

                    <!-- GRAFICO GENERAL -->
                    <div class="card col-md-10" >
                        <div class="card-body pt-0">
                            <div class="form-group" id="chartgeneralcontainer" style="height: 550px;">
                                <canvas id="chartgeneral" ></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA -->
                    <div class="card col-md-12 p-0 mt-3">

                        <div class="table-responsive">
                            <!-- <div class="form-group"> -->
                                <table class="table table-sm  text-center table-bordered-sistema" id="tabletblgeneral">
                                    <thead id="theadtblgeneral" class="thead-sistema"></thead>
                                    <tbody id="tbodytblgeneral"></tbody>
                                    <tfoot id="tfoottblgeneral"></tfoot>
                                </table>
                            <!-- </div> -->
                        </div>
                        
                    </div>

                    <!-- PROVEEDORES -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <!-- <hr> -->
                        <!-- <label class="w-100">PROVEEDORES</label> -->
                        <div class="row justify-content-md-center">
                            <div class="col-md-3">
                                <button class="btn btn-sm btn-success btn-block" data-toggle="collapse" data-target="#collapseproveedores" aria-expanded="false" aria-controls="collapseproveedores">
                                    PROVEEDORES
                                </button>
                            </div>
                        </div>
                        

                    </div>

                    <!-- TABLA PROVEEDORES -->
                    <div class="card col-md-12 mt-1  p-0" >
                        <div class="collapse" id="collapseproveedores">

                            <div class="table-responsive">
                                
                                <table class="table table-sm  text-center table-bordered-sistema" id="tableproveedores">
                                    <thead class="thead-sistema" id="theadproveedores"></thead>
                                    <tbody id="tbodyproveedores"></tbody>
                                </table>
                                
                            </div>

                        </div>
                    </div>

                    <!-- CLIENTES -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <!-- <hr> -->
                       
                        <div class="row justify-content-md-center">
                            <div class="col-md-3">
                                <button class="btn btn-sm btn-success btn-block" data-toggle="collapse" data-target="#collapseclientes" aria-expanded="false" aria-controls="collapseclientes">
                                    CLIENTES
                                </button>
                            </div>
                        </div>
                        
                    </div>

                    <!-- TABLA CLIENTES -->
                    <div class="card col-md-12 mt-1  p-0" >
                        <div class="collapse" id="collapseclientes">

                            <div class="table-responsive">
                                
                                <table class="table table-sm  text-center table-bordered-sistema" id="tableclientes">
                                    <thead class="thead-sistema" id="theadclientes"></thead>
                                    <tbody id="tbodyclientes"></tbody>
                                </table>
                                
                            </div>

                        </div>
                    </div>

                    <!-- ################### -->
                    <!-- ##### PARETOS ##### -->
                    <!-- ################### -->

                    <!-- DIAGRAMA DE PARETO NIVEL 1 (SEMANA) -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <hr>
                        <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°1</label>
                        <label class="w-100 font-weight-bold" id="lblpareto1">
                            <?php
                                if(isset($_POST["reporte"])){
                                    // CREAMOS FECHA
                                    $fecha = $_POST["fecha"];
                                    $fechaComoEntero = strtotime($fecha);
                                    echo date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);
                                }
                            ?>
                        </label>
                    </div>

                    <!-- GRAFICO PARETO 1 -->
                    <div class="card col-md-8 p-0" >
                        <div class="card-body p-0">
                            <div class="form-group" id="chartpareto1container" style="height: 400px;">
                                <canvas id="chartpareto1" ></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA PARETO 1 -->
                    <div class="card col-md-6 mt-1  p-0" >
                        <div class="table-responsive">
                            
                            <table class="table table-sm  text-center table-bordered-sistema" id="chartpareto1table">
                                    <thead class="thead-sistema">
                                        <tr>    
                                            <th>MOTIVOS</th>
                                            <th>FRECUENCIA</th>
                                            <th>%</th>
                                            <th>% ACUMULADO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chartpareto1tbody"></tbody>
                            </table>
                            
                        </div>
                    </div>
                    

                    <!-- DIAGRAMA DE PARETO NIVEL 1 (MES) -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <hr>
                        <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°1</label>
                        <label class="w-100 font-weight-bold" id="lblpareto2">
                            <?php
                                if(isset($_POST["reporte"])){
                                    // setlocale(LC_TIME, "spanish");			
                                    // CREAMOS FECHA
                                    $fecha = $_POST["fecha"];
                                    echo date("Y", $fechaComoEntero) ." - " . getNameMonth($fecha);
                                }
                            ?>
                        </label>
                    </div>

                    <!-- GRAFICO PARETO 2 -->
                    <div class="card col-md-8 p-0" >
                        <div class="card-body p-0">
                            <div class="form-group" id="chartpareto2container" style="height: 400px;">
                                <canvas id="chartpareto2" ></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA PARETO 2 -->
                    <div class="card col-md-6 mt-1  p-0" >
                        <div class="table-responsive">
                            
                            <table class="table table-sm  text-center table-bordered-sistema" id="chartpareto2table">
                                    <thead class="thead-sistema">
                                        <tr>    
                                            <th>MOTIVOS</th>
                                            <th>FRECUENCIA</th>
                                            <th>%</th>
                                            <th>% ACUMULADO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chartpareto2tbody"></tbody>
                            </table>
                            
                        </div>
                    </div>

                    <!-- ###############  -->
                    <!-- ### NIVEL 2 ### -->
                    <!-- ###############  -->

                    <!-- DIAGRAMA DE PARETO NIVEL 2 - PRIMER MAYOR DEFECTO - SEMANAL-->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <hr>
                        <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                        <label for=""  class="w-100 font-weight-bold">
                            <?php
                                if(isset($_POST["reporte"])){
                                    // CREAMOS FECHA
                                    $fecha = $_POST["fecha"];
                                    $fechaComoEntero = strtotime($fecha);
                                    echo date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);
                                    // $fecha = $_POST["fecha"];
                                    // echo date("Y", $fechaComoEntero) ." - " . getNameMonth($fecha);
                                }
                            ?>
                        </label>
                        <label class="w-100 font-weight-bold" id="lblpareto3"></label>
                    </div>


                    <!-- GRAFICO PARETO 2 -  PRIMER MAYOR DEFECTO - SEMANAL -->
                    <div class="card col-md-8 p-0" >
                        <div class="card-body p-0">
                            <div class="form-group" id="chartpareto3container" style="height: 400px;">
                                <canvas id="chartpareto3" ></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA PARETO 2 -  PRIMER MAYOR DEFECTO - SEMANAL -->
                    <div class="card col-md-6 mt-1  p-0" >
                        <div class="table-responsive">
                            
                            <table class="table table-sm  text-center table-bordered-sistema" id="chartpareto3table">
                                    <thead class="thead-sistema">
                                        <tr>    
                                            <th>MOTIVOS</th>
                                            <th>FRECUENCIA</th>
                                            <th>%</th>
                                            <th>% ACUMULADO</th>
                                            <th>% DEL GENERAL</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chartpareto3tbody"></tbody>
                            </table>
                            
                        </div>
                    </div>


                    <!-- DIAGRAMA DE PARETO NIVEL 2 - SEGUNDO MAYOR DEFECTO - SEMANAL -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <hr>
                        <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                        <label class="w-100 font-weight-bold" >
                            <?php
                                if(isset($_POST["reporte"])){
                                    // CREAMOS FECHA
                                    $fecha = $_POST["fecha"];
                                    $fechaComoEntero = strtotime($fecha);
                                    echo date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);
                                }
                            ?>
                        </label>
                        <label class="w-100 font-weight-bold" id="lblpareto4"></label>
                    </div>

                    <!-- GRAFICO PARETO 2 -  SEGUNDO MAYOR DEFECTO - SEMANAL -->
                    <div class="card col-md-8 p-0" >
                        <div class="card-body p-0">
                            <div class="form-group" id="chartpareto4container" style="height: 400px;">
                                <canvas id="chartpareto4" ></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA PARETO 2 -  SEGUNDO MAYOR DEFECTO - SEMANAL -->
                    <div class="card col-md-6 mt-1  p-0" >
                        <div class="table-responsive">
                            
                            <table class="table table-sm  text-center table-bordered-sistema" id="chartpareto4table">
                                    <thead class="thead-sistema">
                                        <tr>    
                                            <th>MOTIVOS</th>
                                            <th>FRECUENCIA</th>
                                            <th>%</th>
                                            <th>% ACUMULADO</th>
                                            <th>% DEL GENERAL</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chartpareto4tbody"></tbody>
                            </table>
                            
                        </div>
                    </div>


                    
                    <!-- DIAGRAMA DE PARETO NIVEL 2 - PRIMER MAYOR DEFECTO - MENSUAL -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <hr>
                        <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                        <label class="w-100 font-weight-bold" >
                            <?php
                                if(isset($_POST["reporte"])){
                                    // setlocale(LC_TIME, "spanish");			
                                    // CREAMOS FECHA
                                    $fecha = $_POST["fecha"];
                                    // $fechaComoEntero = strtotime($fecha);
                                    // $mes = strftime("%B", strtotime($fechaComoEntero));
                                    
                                    echo date("Y", $fechaComoEntero) ." - " .getNameMonth($fecha);
                                }
                            ?>
                        </label>
                        <label class="w-100 font-weight-bold" id="lblpareto5"></label>

                    </div>

                    <!-- GRAFICO PARETO 2 -  PRIMER MAYOR DEFECTO - MENSUAL -->
                    <div class="card col-md-8 p-0" >
                        <div class="card-body p-0">
                            <div class="form-group" id="chartpareto5container" style="height: 400px;">
                                <canvas id="chartpareto5" ></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA PARETO 2 -  PRIMER MAYOR DEFECTO - MENSUAL -->
                    <div class="card col-md-6 mt-1  p-0" >
                        <div class="table-responsive">
                            
                            <table class="table table-sm  text-center table-bordered-sistema" id="chartpareto5table">
                                    <thead class="thead-sistema">
                                        <tr>    
                                            <th>MOTIVOS</th>
                                            <th>FRECUENCIA</th>
                                            <th>%</th>
                                            <th>% ACUMULADO</th>
                                            <th>% DEL GENERAL</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chartpareto5tbody"></tbody>
                            </table>
                            
                        </div>
                    </div>

                    
                    <!-- DIAGRAMA DE PARETO NIVEL 2 - SEGUNDO MAYOR DEFECTO - MENSUAL -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <hr>
                        <label class="w-100 font-weight-bold">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                        <label class="w-100 font-weight-bold">
                            <?php
                                if(isset($_POST["reporte"])){
                                    // setlocale(LC_TIME, "spanish");			
                                    // CREAMOS FECHA
                                    // $fecha = $_POST["fecha"];
                                    // $fechaComoEntero = strtotime($fecha);
                                    // $mes = strftime("%B", strtotime($fechaComoEntero));
                                    // echo date("Y", $fechaComoEntero) ." - " . ucwords($mes);
                                    $fecha = $_POST["fecha"];
                                    echo date("Y", $fechaComoEntero) ." - " . getNameMonth($fecha);
                                }
                            ?>
                        </label>
                        <br>
                        <label class="w-100 font-weight-bold" id="lblpareto6"></label>
                    </div>

                    <!-- GRAFICO PARETO 2 -  SEGUNDO MAYOR DEFECTO - MENSUAL -->
                    <div class="card col-md-8 p-0" >
                        <div class="card-body p-0">
                            <div class="form-group" id="chartpareto6container" style="height: 400px;">
                                <canvas id="chartpareto6" ></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA PARETO 2 -  SEGUNDO MAYOR DEFECTO - MENSUAL -->
                    <div class="card col-md-6 mt-1  p-0" >
                        <div class="table-responsive">
                            
                            <table class="table table-sm  text-center table-bordered-sistema" id="chartpareto6table">
                                    <thead class="thead-sistema">
                                        <tr>    
                                            <th>MOTIVOS</th>
                                            <th>FRECUENCIA</th>
                                            <th>%</th>
                                            <th>% ACUMULADO</th>
                                            <th>% DEL GENERAL</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chartpareto6tbody"></tbody>
                            </table>
                            
                        </div>
                    </div>                                

            </div>

        </div>



    <?php endif; ?> 


<div class="loader"></div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>
<script src="../../js/testing/settablaindicadortesting.js"></script>
<script src="../../js/testing/setgraficoindicador.js"></script>
<script src="../../js/testing/settablaprovclitesting.js"></script>
<script src="../../js/testing/functionsindicadortesting.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script> -->


<script>
    // DATOS GENERALES
    let LABELS = [];
    let CONFIINDICADORTESTING = [];
    let BACKCOLORGRAFICO = [];


    // KILOS GENERAL
    let TOTALKG = [];
    let TOTALKGAPRO = [];
    let TOTALKGAPRONOCON = [];
    let TOTALKGRECH = [];
    let TOTALKGOTROS = [];

    // UNIDADES
    let TOTALPARTIDAS= [];
    let TOTALAUD = [];
    let TOTALAUDAPRO = [];
    let TOTALAUDAPRONOCON = [];
    let TOTALAUDRECH = [];
    let TOTALAUDOTROS = [];

    // PORCENTAJE GENERAL
    let TOTALKGPORCENTAJE           = [];
    let TOTALKGAPROPORCENTAJE       = [];
    let TOTALKGAPRONOCONPORCENTAJE  = [];
    let TOTALKGRECHPORCENTAJE       = [];
    let TOTALKGOTROSPORCENTAJE      = [];

    // KILOS PROVEEDORES
    let TOTALPROVEDORESKG = [];
    let TOTALPROVEDORESKGAPRO = [];
    let TOTALPROVEDORESKGAPRONOCON = [];
    let TOTALPROVEDORESKGRECH = [];
    let TOTALPROVEDORESKGOTROS = [];

    

    // FILTROS 
    let SEDES = [];
    let TIPOSERVICIO = [];
    let TALLER = [];
    let PROVEEDOR = [];
    let CLIENTE = [];
    let TIPOTELA = [];

    let fecha = "",cliente = "",proveedor="",programa ="",codtela="",tipotela="";
    let filtros = "";
    let primermayodefecto1 = "";
    let segundomayodefecto1 = "";
    let primermayodefecto2 = "";
    let segundomayodefecto2 = "";
    

    //  LOAD
    window.addEventListener('load',async ()=>{

        // INDICADOR PRENDAS POR DEPURAR
        CONFIINDICADORTESTING = await getMantIndicadores(3);
 

        await getproveedores();
        await getclientes();
        await gettipotela();


        // INDICADOR
        await getIndicador();

        $(".loader").fadeOut("slow");
    });
    
    // FUNCION
    async function getIndicador(){

        proveedor = "<?php echo isset($_POST["proveedor"]) ? $_POST["proveedor"] : "";  ?>";
        cliente = "<?php echo isset($_POST["cliente"]) ? $_POST["cliente"] : "";  ?>";
        programa = "<?php echo isset($_POST["programa"]) ? join("','",$_POST["programa"]) : "";  ?>";
        codtela = "<?php echo isset($_POST["codtela"]) ? $_POST["codtela"] : "";  ?>";
        tipotela = "<?php echo isset($_POST["tipotela"]) ? join("','",$_POST["tipotela"]) : "";  ?>";
        fecha = "<?php echo isset($_POST["fecha"]) ? $_POST["fecha"] : "";  ?>";


        let reporte = "<?php echo isset($_POST["reporte"]) ? $_POST["reporte"] : "";  ?>";

        // PARA MOSTRAR FILTROS
        let lblfecha        = fecha;
        let lblproveedor    = proveedor == "" ? "(TODOS)" : PROVEEDOR.find(obj => obj.IDPROVEEDOR == proveedor).DESCRIPCIONPROVEEDOR;
        let lblcliente      = cliente == "" ? "(TODOS)" : CLIENTE.find(obj => obj.IDCLIENTE == cliente).DESCRIPCIONCLIENTE;
        let lblcodtela      = codtela == "" ? "(TODOS)" : codtela;
        let lblprograma     = programa == "" ? "(TODOS)" : programa;
        let lbltipotela     = tipotela == "" ? "(TODOS)" : tipotela;


        // TRAEMOS DATOS
        if(reporte == "Y"){

            // ASIGNAMOS DATOS
            $("#lblproveedor").text(lblproveedor);
            $("#lblcliente").text(lblcliente);
            $("#lblcodtela").text(lblcodtela);
            $("#lblprograma").text(lblprograma);
            $("#lbltipotela").text(lbltipotela);
            $("#lblfecha").text(lblfecha);


            // PARAMETROS
            let parametros = [
                proveedor,cliente,programa,
                codtela,tipotela,fecha
            ];

            filtros = lblproveedor + " / " + lblcliente + " / " + lblcodtela + " / " + lblprograma + " / " + lbltipotela + " / "  + lblfecha;

            // INDICADOR GENERAL
            await getIndicadorGeneral(parametros);

            // INDICADOR PROVEEDORES
            if(proveedor == null || proveedor == ""){
                await getIndicadorProveedores(parametros);
            }

            // INDICADOR CLIENTES
            if(cliente == null || cliente == ""){
                await getIndicadorClientes(parametros);
            }

            // DATOS PARA EL PARETO 1 - NIVEL 1
            let datapareto1     = await getParetos(1,null,proveedor,cliente,programa,codtela,tipotela,fecha);
            let responsepareto1 = formatDataIndicadores(datapareto1,"DESCRIPCION","CANTIDAD","ID");
            datopareto1 = setGraficoParetosGeneral("chartpareto1",responsepareto1,false,true);

            // DATOS PARA EL PARETO 2 - NIVEL 1
            let datapareto2     = await getParetos(2,null,proveedor,cliente,programa,codtela,tipotela,fecha);
            let responsepareto2 = formatDataIndicadores(datapareto2,"DESCRIPCION","CANTIDAD","ID");
            datopareto2= setGraficoParetosGeneral("chartpareto2",responsepareto2,false,true);
            
            // DATOS PARA EL PARETO 3 - NIVEL 2 - SEMANAL 
            let datapareto3     = await getParetos(3,responsepareto1.mayor1,proveedor,cliente,programa,codtela,tipotela,fecha);
            let responsepareto3 = formatDataIndicadores(datapareto3,"DESCRIPCION","CANTIDAD","ID");
            datopareto3 = setGraficoParetosGeneral("chartpareto3",responsepareto3,false,true,responsepareto1.total);
            primermayodefecto1 = responsepareto1.mayor1des + " (1er Mayor Defecto)";
            $("#lblpareto3").text(primermayodefecto1);

            // DATOS PARA EL PARETO 4 - NIVEL 2 - SEMANAL
            let datapareto4     = await getParetos(3,responsepareto1.mayor2,proveedor,cliente,programa,codtela,tipotela,fecha);
            let responsepareto4 = formatDataIndicadores(datapareto4,"DESCRIPCION","CANTIDAD","ID");
            datopareto4 = setGraficoParetosGeneral("chartpareto4",responsepareto4,false,true,responsepareto1.total);
            segundomayodefecto1 = responsepareto1.mayor2des + " (2do Mayor Defecto)";
            $("#lblpareto4").text(segundomayodefecto1);



            // DATOS PARA EL PARETO 5 - NIVEL 2 - MENSUAL
            let datapareto5     = await getParetos(4,responsepareto2.mayor1,proveedor,cliente,programa,codtela,tipotela,fecha);
            let responsepareto5 = formatDataIndicadores(datapareto5,"DESCRIPCION","CANTIDAD","ID");
            datopareto5 = setGraficoParetosGeneral("chartpareto5",responsepareto5,false,true,responsepareto2.total);
            primermayodefecto2 = responsepareto2.mayor1des + " (1er Mayor Defecto)";
            $("#lblpareto5").text(primermayodefecto2);


            // DATOS PARA EL PARETO 6 - NIVEL 2 - MENSUAL
            let datapareto6     = await getParetos(4,responsepareto2.mayor2,proveedor,cliente,programa,codtela,tipotela,fecha);
            let responsepareto6 = formatDataIndicadores(datapareto6,"DESCRIPCION","CANTIDAD","ID");
            datopareto6 = setGraficoParetosGeneral("chartpareto6",responsepareto6,false,true,responsepareto2.total);
            segundomayodefecto2 = responsepareto2.mayor2des + " (2do Mayor Defecto)";
            $("#lblpareto6").text(segundomayodefecto2);
    
        }

    }

    // TRAE DATOS PARETOS
    async function getParetos(opcion,parametro,proveedor,cliente,programa,codtela,tipotela,fecha){

        try{

            return await  get("auditex-testing","indicadortesting","getparetos",{
                opcion,parametro,proveedor,cliente,programa,codtela,tipotela,fecha
            });


        }catch(error){
            Advertir("Ocurrio un error al obtener datos del pareto " + opcion);
            console.log(error);
        }

    }


    // EXPORTAR PDF
    $("#btnexportarpdf").click(function(){

        MostrarCarga("Cargando...");


        let parameters = [
            document.getElementById("chartgeneral").toDataURL("image/png"),
            document.getElementById("chartpareto1").toDataURL("image/png"),
            document.getElementById("chartpareto2").toDataURL("image/png"),
            document.getElementById("chartpareto3").toDataURL("image/png"),
            document.getElementById("chartpareto4").toDataURL("image/png"),
            document.getElementById("chartpareto5").toDataURL("image/png"),
            document.getElementById("chartpareto6").toDataURL("image/png"),
        ];

        post("auditex-testing","indicadortesting","saveimagenes",parameters).then(response => {

            if(response.success){

                var form = document.createElement("form");
                var idpdf = document.createElement("input");  
                var pareto1 = document.createElement("input");  
                var pareto2 = document.createElement("input");  
                var pareto3 = document.createElement("input");  
                var pareto4 = document.createElement("input");  
                var pareto5 = document.createElement("input");  
                var pareto6         = document.createElement("input");  
                var fechainput      = document.createElement("input");  
                var filtrosinput    = document.createElement("input");  
                var primermayordefecto1input        = document.createElement("input");  
                var segundomayordefecto1input       = document.createElement("input");  
                var primermayordefecto2input        = document.createElement("input");  
                var segundomayordefecto2input       = document.createElement("input");  
                var proveedorinput          = document.createElement("input");  
                var clienteinput            = document.createElement("input");  


                // DATOS TABLA GENERAL INDICAOR
                var thead       = document.createElement("input");  
                var tbody      = document.createElement("input");  

                // DATOS TABLA PROVEEDORES INDICADOR
                var theadproveedor      = document.createElement("input");  
                var tbodyproveedor      = document.createElement("input");  
                
                // DATOS TABLA CLIENTES INDICADOR
                var theadcliente      = document.createElement("input");  
                var tbodycliente      = document.createElement("input");  

                // CONFIGURAMOS ATRIBUTOS DEL FORMULARIO
                form.method = "POST";
                form.action = "pdfindicadortesting.report.php";   
                form.target = "_blank";

                // PARAMETROS PARA MOSTRAR PROVEEDOR O CLIENTE
                proveedorinput.value    = proveedor;
                proveedorinput.name     = "proveedor";
                form.appendChild(proveedorinput);

                clienteinput.value    = cliente;
                clienteinput.name     = "cliente";
                form.appendChild(clienteinput);



                // PARAMETRO ID
                idpdf.value= response.mensaje;
                idpdf.name = "id";
                form.appendChild(idpdf);

                // PARETO 1
                pareto1.value = JSON.stringify(datopareto1);
                pareto1.name  = "datopareto1";
                form.appendChild(pareto1);

                // PARETO 2
                pareto2.value = JSON.stringify(datopareto2);
                pareto2.name  = "datopareto2";
                form.appendChild(pareto2);

                // PARETO 3
                pareto3.value = JSON.stringify(datopareto3);
                pareto3.name  = "datopareto3";
                form.appendChild(pareto3);

                // PARETO 4
                pareto4.value = JSON.stringify(datopareto4);
                pareto4.name  = "datopareto4";
                form.appendChild(pareto4);

                // PARETO 5
                pareto5.value = JSON.stringify(datopareto5);
                pareto5.name  = "datopareto5";
                form.appendChild(pareto5);

                // PARETO 6
                pareto6.value = JSON.stringify(datopareto6);
                pareto6.name  = "datopareto6";
                form.appendChild(pareto6);

                // FECHA
                fechainput.value = fecha;
                fechainput.name  = "fecha";
                form.appendChild(fechainput);

                // FILTROS
                filtrosinput.value = filtros;
                filtrosinput.name  = "filtros";
                form.appendChild(filtrosinput);

                // TEXTO DEFECTOS
                primermayordefecto1input.value = primermayodefecto1;
                primermayordefecto1input.name  = "primermayodefecto1";
                form.appendChild(primermayordefecto1input);

                segundomayordefecto1input.value = segundomayodefecto1;
                segundomayordefecto1input.name  = "segundomayodefecto1";
                form.appendChild(segundomayordefecto1input);

                primermayordefecto2input.value = primermayodefecto2;
                primermayordefecto2input.name  = "primermayodefecto2";
                form.appendChild(primermayordefecto2input);

                segundomayordefecto2input.value = segundomayodefecto2;
                segundomayordefecto2input.name  = "segundomayodefecto2";
                form.appendChild(segundomayordefecto2input);

                // #################################
                // ### DATOS DE LA TABLA GENERAL ###
                // #################################

                let datos = getDatosTabla("theadtblgeneral","tbodytblgeneral","tfoottblgeneral");

                // THEAD
                thead.value = JSON.stringify(datos.thead);
                thead.name  = "thead";
                form.appendChild(thead);

                // TBODY 
                tbody.value = JSON.stringify(datos.tbody);
                tbody.name  = "tbody";
                form.appendChild(tbody);

                // ###################################
                // ### DATOS DE LA TABLA PROVEEDOR ###
                // ###################################

                if(proveedor == ""){

                    let datosproveedor = getDatosTabla("theadproveedores","tbodyproveedores","tbodyproveedores");
                
                    // THEAD
                    theadproveedor.value = JSON.stringify(datosproveedor.thead);
                    theadproveedor.name  = "theadproveedor";
                    form.appendChild(theadproveedor);

                    // TBODY 
                    tbodyproveedor.value = JSON.stringify(datosproveedor.tbody);
                    tbodyproveedor.name  = "tbodyproveedor";
                    form.appendChild(tbodyproveedor);

                    
                }else{

                    // let datosproveedor = getDatosTabla("theadproveedores","tbodyproveedores","tbodyproveedores");
                
                    // THEAD
                    theadproveedor.value = JSON.stringify([]);
                    theadproveedor.name  = "theadproveedor";
                    form.appendChild(theadproveedor);

                    // TBODY 
                    tbodyproveedor.value = JSON.stringify([]);
                    tbodyproveedor.name  = "tbodyproveedor";
                    form.appendChild(tbodyproveedor);

                }

                // #################################
                // ### DATOS DE LA TABLA CLIENTE ###
                // #################################

                if(cliente == ""){

                    let datoscliente    = getDatosTabla("theadclientes","tbodyclientes","tbodyproveedores");
                
                    // THEAD
                    theadcliente.value = JSON.stringify(datoscliente.thead);
                    theadcliente.name  = "theadcliente";
                    form.appendChild(theadcliente);

                    // TBODY 
                    tbodycliente.value = JSON.stringify(datoscliente.tbody);
                    tbodycliente.name  = "tbodycliente";
                    form.appendChild(tbodycliente);

                }else{

                    // THEAD
                    theadcliente.value = JSON.stringify([]);
                    theadcliente.name  = "theadcliente";
                    form.appendChild(theadcliente);

                    // TBODY 
                    tbodycliente.value = JSON.stringify([]);
                    tbodycliente.name  = "tbodycliente";
                    form.appendChild(tbodycliente);

                }

                



                // // TBODY 2
                // tbody2.value = JSON.stringify(datos.tbody2);
                // tbody2.name  = "tbody2";
                // form.appendChild(tbody2);

                // // TBODY 3
                // tbody3.value = JSON.stringify(datos.tbody3);
                // tbody3.name  = "tbody3";
                // form.appendChild(tbody3);

                // // TBODY 4
                // tbody4.value = JSON.stringify(datos.tbody4);
                // tbody4.name  = "tbody4";
                // form.appendChild(tbody4);

                // // TFOOT 1
                // tfoot1.value = JSON.stringify(datos.tfoot1);
                // tfoot1.name  = "tfoot1";
                // form.appendChild(tfoot1);

                // // TFOOT 2
                // tfoot2.value = JSON.stringify(datos.tfoot2);
                // tfoot2.name  = "tfoot2";
                // form.appendChild(tfoot2);


                // AGREGAMOS INPUT AL FORMULARIO
                document.body.appendChild(form);

                // ENVIAMOS FORMULARIO
                form.submit();

                // REMOVEMOS FORMULARIO
                document.body.removeChild(form);

                InformarMini("Correcto");
                // window.open("pdfindicadordepuracion.report.php?id="+response.mensaje,"_blank");
            }else{
                Advertir("Ocurrio un error al generar el reporte")
            }

        }).catch(error => {
            console.log(error);
            Advertir("Ocurrio un error al generar el reporte");
        });

            
    });


</script>


</body>
</html>