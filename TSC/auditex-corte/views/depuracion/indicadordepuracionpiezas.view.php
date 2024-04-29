<?php
	date_default_timezone_set('America/Lima');
	session_start();
	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Indicador general depuraciones";

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
    <title>Indicador general depuraciones</title>

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

                                <form action="" method="POST">


                                    <div class="form-group">
                                        <label for="">Sede</label>
                                        <select name="sede" id="cbosedes" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tipo Servicio</label>
                                        <select name="tiposervicio" id="cbotiposervicios" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Taller</label>
                                        <select name="taller" id="cbotalleres" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Proveedor</label>
                                        <select name="proveedor" id="cboproveedor" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="">Cliente</label>
                                        <select name="cliente" id="cbocliente" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Codigo de Tela</label>
                                        <input type="text" name="codtela" class="form-control form-control-sm" >
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
                        <button class="btn btn-sm btn-warning" type="submit" id="btnvolver">Volver <i class="fas fa-arrow-left"></i> </button>
                        <button class="btn btn-sm btn-danger" type="button" id="btnexportarpdf">Exportar <i class="fas fa-file-pdf"></i> </button>
                    </form>

                    <!-- DESCRIPCIONES -->
                    <div class="col-md-8 text-white pt-1" style="font-size: 13px !important;">
                        <label>INDICADOR GENERAL DE DEPURACIONES</label>
                        <br>

                        <!-- SEDE -->
                        <label >SEDE:</label> 
                        <label id=" ">SEDE:</label>
                        <label >/</label> 

                        <!-- TIPO SERVICIO -->
                        <label >TIPO SERVICIO:</label> 
                        <label id="lbltiposervicio"></label>
                        <label >/</label> 

                        <!-- TALLER -->
                        <label >TALLER:</label> 
                        <label id="lbltaller"></label>
                        <label >/</label> 

                        <!-- PROVEEDOR -->
                        <label >PROVEEDOR:</label> 
                        <label id="lblproveedor"></label>
                        <label >/</label> 

                        <!-- CLIENTE -->
                        <label >CLIENTE:</label> 
                        <label id="lblcliente"></label>
                        <label >/</label> 

                        <!-- COD TELA -->
                        <label >COD TELA:</label> 
                        <label id="lblcodtela"></label>
                        <label >/</label> 

                        <!-- FECHA -->
                        <label >FECHA:</label> 
                        <label id="lblfecha"></label>

                    </div>

                    <!-- GRAFICO GENERAL -->
                    <div class="card col-md-12" >
                        <div class="card-body pt-0">
                            <div class="form-group" id="chartgeneralcontainer" style="height: 400px;">
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

                    <!-- DIAGRAMA DE PARETO NIVEL 1 -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <hr>
                        <label class="w-100">DIAGRAMA DE PARETO GENERAL - NIVEL N°1</label>
                        <label class="w-100" id="lblpareto1">
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
                                            <th>DEFECTOS</th>
                                            <th>FRECUENCIA</th>
                                            <th>%</th>
                                            <th>% ACUMULADO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chartpareto1tbody"></tbody>
                            </table>
                            
                        </div>
                    </div>

                    <!-- DIAGRAMA DE PARETO NIVEL 1 -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <hr>
                        <label class="w-100">DIAGRAMA DE PARETO GENERAL - NIVEL N°1</label>
                        <label class="w-100" id="lblpareto2">
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
                                            <th>DEFECTOS</th>
                                            <th>FRECUENCIA</th>
                                            <th>%</th>
                                            <th>% ACUMULADO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="chartpareto2tbody"></tbody>
                            </table>
                            
                        </div>
                    </div>

                    <!-- DIAGRAMA DE PARETO NIVEL 2 - PRIMER MAYOR DEFECTO - SEMANAL-->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <hr>
                        <label class="w-100">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                        <label for=""  class="w-100">
                            <?php
                                if(isset($_POST["reporte"])){
                                    // CREAMOS FECHA
                                    // $fecha = $_POST["fecha"];
                                    // $fechaComoEntero = strtotime($fecha);
                                    // echo date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);
                                    $fecha = $_POST["fecha"];
                                    echo date("Y", $fechaComoEntero) ." - " . getNameMonth($fecha);
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
                                            <th>DEFECTOS</th>
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
                        <label class="w-100">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                        <label class="w-100" >
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
                                            <th>DEFECTOS</th>
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
                        <label class="w-100">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                        <label class="w-100" >
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
                                            <th>DEFECTOS</th>
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
                        <label class="w-100">DIAGRAMA DE PARETO GENERAL - NIVEL N°2</label>
                        <label class="w-100">
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
                                            <th>DEFECTOS</th>
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
<script src="../../js/depuracion/settablaindicador.js"></script>
<script src="../../js/depuracion/setgraficoindicador.js"></script>
<script src="../../js/depuracion/exportpdfindicadordepuracion.js"></script>


<script>
    // DATOS GENERALES
    let LABELS = [];
    let FICHASTOTALES = [];
    let PRENDASDEPURADAS = [];
    let PRENDASSEGUNDAS = [];
    let PRENDASDESPACHADAS = [];
    let PRENDASPORDEPURARPOR = [];
    let PRENDASDEPURADASPOR = [];
    let CONFIINDICADORPORDEPURAR = [];
    let CONFIINDICADORDEPURADAS = [];
    let BACKCOLORGRAFICO = [];

    // FILTROS 
    let SEDES = [];
    let TIPOSERVICIO = [];
    let TALLER = [];
    let PROVEEDOR = [];
    let CLIENTE = [];

    let fecha = "";
    let filtros = "";
    let primermayodefecto1 = "";
    let segundomayodefecto1 = "";
    let primermayodefecto2 = "";
    let segundomayodefecto2 = "";



    //  DOC PDF
    // let DOCPDF = new jsPDF('p', 'mm', [297, 210]); //210mm wide and 297mm high

    
    // DATOS POR PARETO
    let datopareto1  = null;
    let datopareto2  = null;
    let datopareto3  = null;
    let datopareto4  = null;
    let datopareto5  = null;
    let datopareto6  = null;


    //  LOAD
    window.addEventListener('load',async ()=>{

        

        // INDICADOR PRENDAS POR DEPURAR
        CONFIINDICADORPORDEPURAR = await getMantIndicadores(1);
        // INDICADOR PRENDAS DEPURADAS
        CONFIINDICADORDEPURADAS  = await getMantIndicadores(2);

        await getSedes();
        await getTipoServicios();
        await getTalleres();
        await getproveedores();
        await getclientes();


        // INDICADOR
        await getIndicador();

        $(".loader").fadeOut("slow");
    });
    
    // FUNCION
    async function getIndicador(){

        fecha = "<?php echo isset($_POST["fecha"]) ? $_POST["fecha"] : "";  ?>";
        let tiposervicio = "<?php echo isset($_POST["tiposervicio"]) ? $_POST["tiposervicio"] : "";  ?>";
        let taller = "<?php echo isset($_POST["taller"]) ? $_POST["taller"] : "";  ?>";
        let sede = "<?php echo isset($_POST["sede"]) ? $_POST["sede"] : "";  ?>";
        let proveedor = "<?php echo isset($_POST["proveedor"]) ? $_POST["proveedor"] : "";  ?>";
        let cliente = "<?php echo isset($_POST["cliente"]) ? $_POST["cliente"] : "";  ?>";
        let codtela = "<?php echo isset($_POST["codtela"]) ? $_POST["codtela"] : "";  ?>";


        let reporte = "<?php echo isset($_POST["reporte"]) ? $_POST["reporte"] : "";  ?>";

        // PARA MOSTRAR FILTROS
        let lblfecha = fecha;
        let lbltiposervicio = tiposervicio == "" ? "(TODOS)" : TIPOSERVICIO.find(obj => obj.CODTIPSERV == tiposervicio).DESTIPSERV;
        let lbltaller = taller == "" ? "(TODOS)" : TALLER.find(obj => obj.CODTLL == taller).DESTLL;
        let lblsede = sede == "" ? "(TODOS)" : SEDES.find(obj => obj.CODSEDE == sede).DESSEDE;
        let lblproveedor = proveedor == "" ? "(TODOS)" : PROVEEDOR.find(obj => obj.IDPROVEEDOR == proveedor).DESCRIPCIONPROVEEDOR;
        let lblcliente = cliente == "" ? "(TODOS)" : CLIENTE.find(obj => obj.IDCLIENTE == cliente).DESCRIPCIONCLIENTE;
        let lblcodtela = codtela == "" ? "(TODOS)" : codtela;



        // TRAEMOS DATOS
        if(reporte == "Y"){

            // ASIGNAMOS DATOS
            $("#lblfecha").text(lblfecha);
            $("#lbltiposervicio").text(lbltiposervicio);
            $("#lbltaller").text(lbltaller);
            $("#lblsede").text(lblsede);
            $("#lblproveedor").text(lblproveedor);
            $("#lblcliente").text(lblcliente);
            $("#lblcodtela").text(lblcodtela);



            filtros = lblsede + " / " + lbltiposervicio + " / " + lbltaller + " / " + lblproveedor + " / " + lblcliente + " / "  + lblcodtela + " / " + lblfecha;


            try{
                // DATOS PARA EL INDICADOR GENERAL
                let response = await post("auditex-corte","indicadordepuracion","getindicadorgeneral",[
                    sede,tiposervicio,taller,fecha,proveedor,cliente,codtela
                ]);

                setTablaIndicador(response,"tblgeneral");
                
                // DATOS PARA EL PARETO 1 - NIVEL 1
                let datapareto1     = await getParetos(1,sede,tiposervicio,taller,fecha,proveedor,cliente,codtela);
                let responsepareto1 = formatDataIndicadores(datapareto1,"DSCFAMILIA","CANTIDAD","CODFAMILIA");
                datopareto1 = setGraficoParetosGeneral("chartpareto1",responsepareto1,false,true);

                // DATOS PARA EL PARETO 2 - NIVEL 1
                let datapareto2     = await getParetos(2,sede,tiposervicio,taller,fecha,proveedor,cliente,codtela);
                let responsepareto2 = formatDataIndicadores(datapareto2,"DSCFAMILIA","CANTIDAD","CODFAMILIA");
                datopareto2 = setGraficoParetosGeneral("chartpareto2",responsepareto2,false,true);



                // DATOS PARA EL PARETO 3 - NIVEL 2 - SEMANAL 
                let datapareto3     = await getParetos(3,sede,tiposervicio,taller,fecha,proveedor,cliente,codtela,responsepareto1.mayor1);
                let responsepareto3 = formatDataIndicadores(datapareto3,"DESDEF","CANTIDAD","CODDEF");
                datopareto3 = setGraficoParetosGeneral("chartpareto3",responsepareto3,false,true,responsepareto1.total);
                primermayodefecto1 = responsepareto1.mayor1des + " (1er Mayor Defecto)";
                $("#lblpareto3").text(primermayodefecto1);

                // DATOS PARA EL PARETO 4 - NIVEL 2 - SEMANAL
                let datapareto4     = await getParetos(3,sede,tiposervicio,taller,fecha,proveedor,cliente,codtela,responsepareto1.mayor2);
                let responsepareto4 = formatDataIndicadores(datapareto4,"DESDEF","CANTIDAD","CODDEF");
                datopareto4 = setGraficoParetosGeneral("chartpareto4",responsepareto4,false,true,responsepareto1.total);
                segundomayodefecto1 = responsepareto1.mayor2des + " (2do Mayor Defecto)";
                $("#lblpareto4").text(segundomayodefecto1);



                // DATOS PARA EL PARETO 5 - NIVEL 2 - MENSUAL
                let datapareto5     = await getParetos(4,sede,tiposervicio,taller,fecha,proveedor,cliente,codtela,responsepareto2.mayor1);
                let responsepareto5 = formatDataIndicadores(datapareto5,"DESDEF","CANTIDAD","CODDEF");
                datopareto5 = setGraficoParetosGeneral("chartpareto5",responsepareto5,false,true,responsepareto2.total);
                primermayodefecto2 = responsepareto2.mayor1des + " (1er Mayor Defecto)";
                $("#lblpareto5").text(primermayodefecto2);


                // DATOS PARA EL PARETO 6 - NIVEL 2 - MENSUAL
                let datapareto6     = await getParetos(4,sede,tiposervicio,taller,fecha,proveedor,cliente,codtela,responsepareto2.mayor2);
                let responsepareto6 = formatDataIndicadores(datapareto6,"DESDEF","CANTIDAD","CODDEF");
                datopareto6 = setGraficoParetosGeneral("chartpareto6",responsepareto6,false,true,responsepareto2.total);
                segundomayodefecto2 = responsepareto2.mayor2des + " (2do Mayor Defecto)";
                $("#lblpareto6").text(segundomayodefecto2);


            }catch(error){
                console.log(error);
                Advertir("Ocurrio un error al generar indicador");
            }
    
        }

    }

    // SEDES
    async function getSedes(){
        SEDES = await get("auditex-corte","indicadordepuracion","getsedes");
        setComboSimple("cbosedes",SEDES,"DESSEDE","CODSEDE",true,false,"TODOS");
    } 

    // TIPO SERVICIOS
    async function getTipoServicios(){
        TIPOSERVICIO = await get("auditex-corte","indicadordepuracion","gettiposervicios");
        setComboSimple("cbotiposervicios",TIPOSERVICIO,"DESTIPSERV","CODTIPSERV",true,false,"TODOS");
    } 

    // TALLERES
    async function getTalleres(){
        TALLER = await get("auditex-corte","indicadordepuracion","gettalleres");
        setComboSimple("cbotalleres",TALLER,"DESTLL","CODTLL",true,false,"TODOS");
    } 

    // FILTRAMOS
    $("#cbosedes").change(function(){
        filtrerTalleres();
    });

    // FILTRAMOS
    $("#cbotiposervicios").change(function(){
        filtrerTalleres();
    });

    // FILTRAMOS TALLERES
    function filtrerTalleres(){
                
        let idsede          = $("#cbosedes").val();
        let idtiposervicio  = $("#cbotiposervicios").val();

        let filtrado = TALLER;

        // FILTRAMOS SEDE
        if(idsede != ""){   
            filtrado = TALLER.filter(obj => obj.CODSEDE == idsede);
        }

        // FILTRAMOS TIPO SERVICIOS
        if(idtiposervicio != ""){   
            filtrado = TALLER.filter(obj => obj.CODTIPOSERV == idtiposervicio);
        }

        setComboSimple("cbotalleres",filtrado,"DESTLL","CODTLL");
    }

    // TRAE DATOS PARETOS
    async function getParetos(opcion,sede,tiposervicio,taller,fecha,proveedor,cliente,codtela,parametro = null){

        try{

            return await  get("auditex-corte","indicadordepuracion","getparametros",{
                opcion,sede,tiposervicio,taller,fecha,proveedor,cliente,codtela,parametro 
            });


        }catch(error){
            Advertir("Ocurrio un error al obtener datos del pareto " + opcion);
            console.log(error);
        }

    }

    // EXPORTAR PDF
    $("#btnexportarpdf").click(function(){

        MostrarCarga("Cargando...");


        html2canvas(document.getElementById("tabletblgeneral"), {
            onrendered: function(canvas) {

                // CREAMOS IMAGEN
                var imgtabla = canvas.toDataURL('image/png');

                let parameters = [
                    document.getElementById("chartgeneral").toDataURL("image/png"),
                    document.getElementById("chartpareto1").toDataURL("image/png"),
                    document.getElementById("chartpareto2").toDataURL("image/png"),
                    document.getElementById("chartpareto3").toDataURL("image/png"),
                    document.getElementById("chartpareto4").toDataURL("image/png"),
                    document.getElementById("chartpareto5").toDataURL("image/png"),
                    document.getElementById("chartpareto6").toDataURL("image/png"),
                    imgtabla
                ];

            post("auditex-corte","indicadordepuracion","saveimagenes",parameters).then(response => {

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

                    // DATOS TABLA GENERAL INDICAOR
                    var thead       = document.createElement("input");  
                    var tbody1      = document.createElement("input");  
                    var tbody2      = document.createElement("input");  
                    var tbody3      = document.createElement("input");  
                    var tbody4      = document.createElement("input");  
                    var tfoot1      = document.createElement("input");  
                    var tfoot2      = document.createElement("input");  






                    // CONFIGURAMOS ATRIBUTOS DEL FORMULARIO
                    form.method = "POST";
                    form.action = "pdfindicadordepuracion.report.php";   
                    form.target = "_blank";


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

                    // DATOS DE LA TABLA GENERAL
                    // <thead id="theadtblgeneral" class="thead-sistema"></thead>
                    // <tbody id="tbodytblgeneral"></tbody>
                    // <tfoot id="tfoottblgeneral"></tfoot>

                    let datos = getDatosTabla("theadtblgeneral","tbodytblgeneral","tfoottblgeneral");
                    // console.log(datos);

                    // THEAD
                    thead.value = JSON.stringify(datos.thead);
                    thead.name  = "thead";
                    form.appendChild(thead);

                    // TBODY 1
                    tbody1.value = JSON.stringify(datos.tbody1);
                    tbody1.name  = "tbody1";
                    form.appendChild(tbody1);

                    // TBODY 2
                    tbody2.value = JSON.stringify(datos.tbody2);
                    tbody2.name  = "tbody2";
                    form.appendChild(tbody2);

                    // TBODY 3
                    tbody3.value = JSON.stringify(datos.tbody3);
                    tbody3.name  = "tbody3";
                    form.appendChild(tbody3);

                    // TBODY 4
                    tbody4.value = JSON.stringify(datos.tbody4);
                    tbody4.name  = "tbody4";
                    form.appendChild(tbody4);

                    // TFOOT 1
                    tfoot1.value = JSON.stringify(datos.tfoot1);
                    tfoot1.name  = "tfoot1";
                    form.appendChild(tfoot1);

                    // TFOOT 2
                    tfoot2.value = JSON.stringify(datos.tfoot2);
                    tfoot2.name  = "tfoot2";
                    form.appendChild(tfoot2);


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

            }
        });

        


        
    });
    

    // DATOS DE TELA
    function getDatosTabla(idthead,idtbody,idtfoot) {

        // HEAD
        let thead = document.getElementById(idthead);
        let trthead = thead.children[0];
        let THEADDATOS = [];

        for (let i = 0; i < trthead.children.length; i++) {
            THEADDATOS.push(trthead.children[i].innerText);
        }

        // TBODY 1
        let tbody   = document.getElementById(idtbody);
        let trbody1 = tbody.children[0];
        let TBODY1 = [];

        for (let i = 0; i < trbody1.children.length; i++) {
            TBODY1.push(trbody1.children[i].innerText);
        }

        // TBODY 2
        //let tbody = document.getElementById(idtbody);
        let trbody2 = tbody.children[1];
        let TBODY2 = [];

        for (let i = 0; i < trbody2.children.length; i++) {
            TBODY2.push(trbody2.children[i].innerText);
        }

        // TBODY 3
        //let tbody = document.getElementById(idtbody);
        let trbody3 = tbody.children[2];
        let TBODY3 = [];

        for (let i = 0; i < trbody3.children.length; i++) {
            TBODY3.push(trbody3.children[i].innerText);
        }

        // TBODY 4
        //let tbody = document.getElementById(idtbody);
        let trbody4 = tbody.children[3];
        let TBODY4 = [];

        for (let i = 0; i < trbody4.children.length; i++) {
            TBODY4.push(trbody4.children[i].innerText);
        }

        // TFOOT 1
        let tfoot = document.getElementById(idtfoot);
        let trtfoot = tfoot.children[0];
        let TFOOT = [];

        for (let i = 0; i < trtfoot.children.length; i++) {
            TFOOT.push(trtfoot.children[i].innerText);
        }

        // TFOOT 2  
        // let tfoot2 = document.getElementById(idtfoot);
        let trtfoot2 = tfoot.children[1];
        let TFOOT2 = [];

        for (let i = 0; i < trtfoot2.children.length; i++) {
            TFOOT2.push(trtfoot2.children[i].innerText);
        }


        // DEVOLVEMOS DATOS
        return {
            thead: THEADDATOS,
            tbody1: TBODY1,
            tbody2: TBODY2,
            tbody3: TBODY3,
            tbody4: TBODY4,
            tfoot1: TFOOT,
            tfoot2: TFOOT2
        }



    }

     // GET PROVEEDORES
    async function getproveedores(){
        PROVEEDOR = await get("auditex-testing","testing","getproveedorestela",{});
        setComboSimple("cboproveedor",PROVEEDOR,"DESCRIPCIONPROVEEDOR","IDPROVEEDOR",true,false,"TODOS");
    }

    // GET PROVEEDORES
    async function getclientes(){
        CLIENTE = await get("auditex-testing","testing","getclientes",{});
        setComboSimple("cbocliente",CLIENTE,"DESCRIPCIONCLIENTE","IDCLIENTE",true,false,"TODOS");
    }

</script>


</body>
</html>