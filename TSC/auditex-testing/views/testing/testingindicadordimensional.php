<?php
	date_default_timezone_set('America/Lima');
	session_start();
	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Indicador de estabilidad dimensional";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicador de estabilidad dimensional</title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>
    <!-- <link rel="stylesheet" href="../../../libs/css/mdb.min.css"> -->
    <style>
        body{
            font-family: 'Roboto',sans-serif !important;
            /* font-size: 11px !important; */
            padding-top: 60px !important;
        }

        hr{
            border:0.8px solid #fff;
        }

        #table-responsive{
            max-height: 300px !important;
        }

        #theaddatos th{
            vertical-align: middle !important;
        }
        #tabledatos{
            font-size: 11px !important;
        }
        

        .container-filtros{
            margin-top: 8vh !important;
            background-image: url('/tsc/public/img/fondo.png')
            
        }

        .mt-20{
            margin-top: 20vh !important;
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
                                        <label for="">Fecha Inicio</label>
                                        <input type="date" name="fechai" class="form-control form-control-sm" value="<?php echo date("Y-m-d");?>"  required>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Fecha Fin</label>
                                        <input type="date" name="fechaf" class="form-control form-control-sm" value="<?php echo date("Y-m-d");?>"  required>
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
        <div class="container container-filtros fixed-top">

            <div class="row">

                <!-- TELAS -->
                <div class="col-md-4">
                    <label for="" class="text-white font-weight-bold">Telas</label>
                    <select name="" id="cbotelas" style="width: 100%;" class="custom-select custom-select-sm filtros select2"></select>
                </div>

                <!-- COLORES -->
                <div class="col-md-3">
                    <label for="" class="text-white font-weight-bold">Colores</label>
                    <select name="" id="cbocolores" style="width: 100%;" class="custom-select custom-select-sm filtros select2"></select>
                </div>

                <!-- PROGRAMA -->
                <div class="col-md-4">
                    <label for="" class="text-white font-weight-bold">Programa</label>
                    <select name="" id="cboprogramas" style="width: 100%;" class="custom-select custom-select-sm filtros select2"></select>
                </div>

                <!-- BUSQUEDA -->
                <div class="col-md-1">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-primary btn-sm btn-block" id="btnbuscar" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <!-- FILTROS -->
                <div class="col-md-12 text-center pt-md-2">

                    <label id="lblfiltros" class="text-white font-weight-bold"></label>

                </div>

                <div class="col-md-12">
                    <hr>
                </div>

            </div>
        
        </div>
        
        <div class="container mt-20">

            <!-- GRAFICOS -->
            <div class="row justify-content-md-center mt-3" style="margin-top: 20vh;" >


                <!-- GRAFICO DE ANCHOS BEFORE -->
                <div class="col-md-12">
                    <label class="text-white font-weight-bold">ANCHO BEFORE</label>
                </div>

                <div class="col-md-8" >
                    <div class="card p-0">
                        <div class="card-body p-0" id="canvasancho-container">
                            <canvas id="canvasancho"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

                <!-- GRAFICO DE ANCHOS AFTER -->
                <div class="col-md-12">
                    <label class="text-white font-weight-bold">ANCHO AFTER</label>
                </div>

                <div class="col-md-8" >
                    <div class="card p-0">
                        <div class="card-body p-0" id="canvasanchoafter-container">
                            <canvas id="canvasanchoafter"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

                <!-- GRAFICO DE DENSIDAD BEFORE -->
                <div class="col-md-12">
                    <label class="text-white font-weight-bold">DENSIDAD BEFORE</label>
                </div>

                <div class="col-md-8" >
                    <div class="card p-0">
                        <div class="card-body p-0" id="canvasdensidad-container">
                            <canvas id="canvasdensidad"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

                <!-- GRAFICO DE DENSIDAD AFTER -->
                <div class="col-md-12">
                    <label class="text-white font-weight-bold">DENSIDAD AFTER</label>
                </div>

                <div class="col-md-8" >
                    <div class="card p-0">
                        <div class="card-body p-0" id="canvasdensidadafter-container">
                            <canvas id="canvasdensidadafter"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

                <!-- %ENC ANCHO 3RA LAV -->
                <div class="col-md-12">
                    <label class="text-white font-weight-bold">%ENC ANCHO 3RA LAV</label>
                </div>

                <div class="col-md-8" >
                    <div class="card p-0">
                        <div class="card-body p-0" id="canvasanchoterceralavada-container">
                            <canvas id="canvasanchoterceralavada"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

                <!-- %ENC LARGO 3RA LAV -->
                <div class="col-md-12">
                    <label class="text-white font-weight-bold">%ENC LARGO 3RA LAV</label>
                </div>

                <div class="col-md-8" >
                    <div class="card p-0">
                        <div class="card-body p-0" id="canvaslargoterceralavada-container">
                            <canvas id="canvaslargoterceralavada"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

                <!-- REVIRADO TERCERA LAVADA -->
                <div class="col-md-12">
                    <label class="text-white font-weight-bold">% REVIRADO 3RA LAV</label>
                </div>

                <div class="col-md-8" >
                    <div class="card p-0">
                        <div class="card-body p-0" id="canvasreviradotercera-container">
                            <canvas id="canvasreviradotercera"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

                <!-- INCLINACIÓN BEFORE -->
                <div class="col-md-12">
                    <label class="text-white font-weight-bold">INCLINACIÓN BEFORE</label>
                </div>

                <div class="col-md-8" >
                    <div class="card p-0">
                        <div class="card-body p-0" id="canvasinclinacionbefore-container">
                            <canvas id="canvasinclinacionbefore"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>

                 <!-- INCLINACIÓN AFTER -->
                 <div class="col-md-12">
                    <label class="text-white font-weight-bold">INCLINACIÓN AFTER</label>
                </div>

                <div class="col-md-8" >
                    <div class="card p-0">
                        <div class="card-body p-0" id="canvasinclinacionafter-container">
                            <canvas id="canvasinclinacionafter"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                </div>


            </div>

            <!-- TABLA -->
            <div class="row justify-content-md-center ">

                <div class="col-md-2 mb-md-1">
                    <button class="btn btn-success btn-block btn-sm" id="btnexportar">
                        <i class="fas fa-file-excel"></i>
                        Exportar
                    </button>
                </div>

                <div class="col-md-2 mb-md-1">
                    <button class="btn btn-danger btn-block btn-sm" id="btnexportarpdf">
                        <i class="fas fa-file-pdf"></i>
                        Exportar PDF
                    </button>
                </div>

                <div class="col-md-12">

                    <div class="card p-0">
                        <div class="card-body p-0">

                            <div class="table-responsive" id="table-responsive">
                                <table class="table table-bordered table-sm table-hover" id="tabledatos">
                                    <thead class="bg-sistema text-white text-center" id="theaddatos">
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Partida</th>
                                            <th rowspan="2">Proveedor</th>
                                            <th rowspan="2">Cliente</th>
                                            <th rowspan="2">Programa</th>
                                            <th rowspan="2">Cod. Tela</th>
                                            <th rowspan="2">Desc. Tela</th>
                                            <th rowspan="2">Color</th>
                                            <!-- ANCHO B/W -->
                                            <th colspan="4" >Ancho B/W</th>
                                            <!-- ANCHO A/W -->
                                            <th colspan="4" >Ancho A/W</th>
                                            <!-- DENSIDAD B/W -->
                                            <th colspan="4" >Densidad B/W</th>
                                            <!-- DENSIDAD A/W -->
                                            <th colspan="4" >Densidad A/W</th>
                                            <!-- FECHA -->
                                            <th rowspan="2" >Fecha</th>
                                            <!-- KG -->
                                            <th rowspan="2" >KG</th>
                                            <!-- Grado -->
                                            <th rowspan="2" nowrap>
                                                <label for="">Gr. por desv. </label>
                                                <br>
                                                <label for="">por m2 de std. </label>
                                            </th>
                                            <!-- % -->
                                            <th rowspan="2" nowrap>
                                                <label for="">% de desv.</label>
                                                <br>
                                                <label for="">por dens. std.</label>
                                            </th>
                                            <!-- KG afectados -->
                                            <th rowspan="2" >KG. afectados +/-</th>
                                            <!-- KG afectados -->
                                            <th rowspan="2" >KG. afectados +</th>
                                            <!-- ENCOGIMIENTOS ANCHO 3RA LAVADA -->
                                            <th colspan="4" >% ENCO. ANCHO 3RA LAVADA</th>
                                            <!-- ENCOGIMIENTOS LARGO 3RA LAVADA -->
                                            <th colspan="4" >% ENCO. LARGO 3RA LAVADA</th>
                                            <!-- REVIRADO -->
                                            <th colspan="4" >REVIRADO</th>
                                            <!-- INCLINACIÓN ACABADA -->
                                            <th colspan="4" >INCLINACIÓN ACABADA</th>
                                            <!-- INCLINACIÓN LAVADA -->
                                            <th colspan="4" >INCLINACIÓN LAVADA</th>


                                        </tr>
                                        <tr>
                                            <th nowrap>
                                                <label>Ancho</label>
                                                <br>
                                                <label>Aud.</label>
                                            </th>
                                            <th nowrap>
                                                <label>Std.</label>  <br>
                                                <label>Ancho.</label>
                                            </th>
                                            <th nowrap>LI</th>
                                            <th nowrap>LS</th>

                                            <th nowrap>
                                                <label>Ancho</label>
                                                <br>
                                                <label>Aud.</label>
                                            </th>
                                            <th nowrap>
                                                <label>Std.</label>  <br>
                                                <label>Ancho.</label>
                                            </th>
                                            <th nowrap>LI</th>
                                            <th nowrap>LS</th>

                                            <th nowrap>
                                                <label>Den.</label> <br>
                                                <label >Aud.</label>

                                            </th>
                                            <th nowrap>Estd.</th>
                                            <th nowrap>LI</th>
                                            <th nowrap>LS</th>
                                            
                                            <th nowrap>
                                                <label>Den.</label> <br>
                                                <label >Aud.</label>
                                            </th>
                                            <th nowrap>Estd.</th>
                                            <th nowrap>LI</th>
                                            <th nowrap>LS</th>

                                            <th nowrap>
                                                <label>% 3ra</label>  <br>
                                                <label>Lav Real</label>
                                            </th>
                                            <th nowrap>
                                                <label>% Std  </label> <br>
                                                <label>3ra Lav</label>
                                            </th>
                                            <th nowrap>LI A3</th>
                                            <th nowrap>LS A3</th>

                                            <th nowrap>
                                                <label>% 3ra</label>  <br>
                                                <label>Lav Real</label>
                                            </th>
                                            <th nowrap>
                                                <label>% Std  </label> <br>
                                                <label>3ra Lav</label>
                                            </th>
                                            <th nowrap>LI L3</th>
                                            <th nowrap>LS L3</th>

                                            <th nowrap>
                                                <label>% 3ra</label>  <br>
                                                <label>Lav Real</label>
                                            </th>
                                            <th nowrap>
                                                <label>% Std  </label> <br>
                                                <label>3ra Lav</label>
                                            </th>
                                            <th nowrap>LI R3</th>
                                            <th nowrap>LS R3</th>

                                            <th nowrap>
                                                <label>Inc Aca </label> <br>
                                                <label>Real</label>
                                            </th>
                                            <th nowrap>
                                                <label>Std Inc</label>  <br>
                                                <label>Aca</>
                                            </th>
                                            <th nowrap>
                                                <label>LI Inc</label> <br>
                                                <label>Aca</label>
                                            </th>
                                            <th nowrap>
                                                <label>LS Inc </label> <br>
                                                <label>Aca</label>
                                            </th>

                                            <th nowrap>
                                                <label>Inc</label>  <br>
                                                <label>Lav</label>
                                            </th>
                                            <th nowrap>
                                                <label>Std Inc</label>  <br>
                                                <label>Lav</label>
                                            </th>
                                            <th nowrap>
                                                <label>LI Inc </label> <br>
                                                <label>Lav</lab>
                                            </th>
                                            <th nowrap>
                                                <label>LS Inc</label> <br>
                                                <label>Lav</label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodydatos">
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    
                </div>

            </div>

        </div>

        

    <?php endif; ?> 


<div class="loader"></div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>



<script>

    let proveedor,cliente,fechai,fechaf;
    let filtros = "";
    let DATOSGRAFICOS   = [];
    let PROVEEDORES     = [];
    let CLIENTES        = [];
    let DATAFILTRADA    = [];


    //  LOAD
    window.addEventListener('load',async ()=>{

        await getclientes();
        await getproveedores();


        // INDICADOR
        await getFiltrosIndicador();

        $(".loader").fadeOut("slow");
    });
    
    // FILTROS PARA INDICADOR
    async function getFiltrosIndicador(){

        proveedor = "<?php echo isset($_POST["proveedor"]) ? $_POST["proveedor"] : "";  ?>";
        cliente = "<?php echo isset($_POST["cliente"]) ? $_POST["cliente"] : "";  ?>";
        fechai = "<?php echo isset($_POST["fechai"]) ? $_POST["fechai"] : "";  ?>";
        fechaf = "<?php echo isset($_POST["fechaf"]) ? $_POST["fechaf"] : "";  ?>";

        let reporte = "<?php echo isset($_POST["reporte"]) ? $_POST["reporte"] : "";  ?>";

        let lblproveedor    = proveedor == "" ? "(TODOS)" : PROVEEDORES.find(obj => obj.IDPROVEEDOR == proveedor).DESCRIPCIONPROVEEDOR;
        let lblcliente      = cliente == "" ? "(TODOS)" : CLIENTES.find(obj => obj.IDCLIENTE == cliente).DESCRIPCIONCLIENTE;
        let lblfechai       = fechai;  
        let lblfechaf       = fechaf;

        filtros = `PROVEEDOR: ${lblproveedor} / CLIENTE: ${lblcliente} / Del ${lblfechai} al ${lblfechaf}`;
        $("#lblfiltros").text(filtros);

        // MOSTRAMOS REPORTE
        if(reporte == "Y"){

            let response = await get("auditex-testing","indicadortesting","getindicadordimensional",{
                proveedor,cliente,fechaf,fechai
            });

            DATOSGRAFICOS = await get("auditex-testing","indicadortesting","getindicadordimensionaldatos",{
                proveedor,cliente,fechaf,fechai
            });

            // COMBOS
            setcombos(response);

            // ARMAMOS GRAFICOS
            setgraficos();

        }

    }

    // GET PROVEEDORES
    async function getproveedores(){
        PROVEEDORES = await get("auditex-testing","testing","getproveedorestela",{});
        setComboSimple("cboproveedor",PROVEEDORES,"DESCRIPCIONPROVEEDOR","IDPROVEEDOR",true);
    }

    // GET PROVEEDORES
    async function getclientes(){
        CLIENTES = await get("auditex-testing","testing","getclientes",{});
        setComboSimple("cbocliente",CLIENTES,"DESCRIPCIONCLIENTE","IDCLIENTE",true);
    }

    // SET COMBOS
    function setcombos(data){

        let telas       = [];
        let colores     = [];
        let programas   = [];

        // ASIGNAMOS
        for(let obj of data){
            telas.push(obj.CODTELA);
            colores.push(obj.COLOR);
            programas.push(obj.PROGRAMA);
        }

        // ELIMINAMOS REPETIDOS
        telas       = telas.filter(distinct)
        colores     = colores.filter(distinct)
        programas   = programas.filter(distinct)


        // COMBOS PARA TELAS
        let objtelas = "<option value=''>TODOS</option>";
        for(let obj of telas){
            objtelas += "<option value='"+obj+"'>"+obj+"</option>";
        }

        // COMBOS PARA COLORES
        let objcolores = "<option value=''>TODOS</option>";
        for(let obj of colores){
            objcolores += "<option value='"+obj+"'>"+obj+"</option>";
        }

        // COMBOS PARA PROGRAMAS
        let objprogramas = "<option value=''>TODOS</option>";
        for(let obj of programas){
            objprogramas += "<option value='"+obj+"'>"+obj+"</option>";
        }        

        // ASIGNAMOS DATAS
        $("#cbotelas").html(objtelas);
        $("#cbocolores").html(objcolores);
        $("#cboprogramas").html(objprogramas);



    }

    // ARMAMOS GRAFICOS
    function setgraficos(telas = null,colores = null,programa = null){

        DATAFILTRADA =  DATOSGRAFICOS;

        // FILTRAMOS POR TELAS
        if(telas != null){
            DATAFILTRADA = DATAFILTRADA.filter(obj => obj.CODTELA == telas);
        }

        // FILTRAMOS POR COLORES
        if(colores != null){
            DATAFILTRADA = DATAFILTRADA.filter(obj => obj.COLOR == colores);
        }

        // FILTRAMOS POR PROGRAMAS
        if(programa != null){
            DATAFILTRADA =  DATAFILTRADA.filter(obj => obj.PROGRAMA == programa);
        }
        
        let labels = []; 

        for(let i = 1; i <= DATAFILTRADA.length;i++){
            labels.push(i);
        }


        // ANCHOS BEFORE
        let valoresanchos = getValores("ANCHOBEFORE_AUDITADO","ANCHOBEFORE_TOLERANCIA","ANCHOBEFORE_ESTANDAR",DATAFILTRADA,"ANCHOBEFORE");
        setCharts("canvasancho",labels,valoresanchos);

        // ANCHOS AFTER
        let valoresanchosafter = getValores("ANCHOAFTER_AUDITADO","ANCHOAFTER_TOLERANCIA","ANCHOAFTER_ESTANDAR",DATAFILTRADA,"ANCHOAFTER");
        setCharts("canvasanchoafter",labels,valoresanchosafter);

        // DENSIDADES BEFORE
        let valoresdensidad = getValores("DENSIDADBEFORE_AUDITADO","DENSIDADBEFORE_TOLERANCIA","DENSIDADBEFORE_ESTANDAR",DATAFILTRADA,"DENSIDADBEFORE");
        setCharts("canvasdensidad",labels,valoresdensidad);

        // DENSIDADES AFTER
        let valoresdensidadafter = getValores("DENSIDADAFTER_AUDITADO","DENSIDADAFTER_TOLERANCIA","DENSIDADAFTER_ESTANDAR",DATAFILTRADA,"DENSIDADAFTER");
        setCharts("canvasdensidadafter",labels,valoresdensidadafter);

        // ANCHO TERCERA LAVADA
        let valoranchoterceralavada = getValores("ANCHOTERCERA_AUDITADO","ANCHOTERCERA_TOLERANCIA","ANCHOTERCERA_ESTANDAR",DATAFILTRADA,"ANCHOTERCERA");
        setCharts("canvasanchoterceralavada",labels,valoranchoterceralavada);

        // LARGO TERCERA LAVADA
        let valorlargoterceralavada = getValores("HILOTERCERA_AUDITADO","HILOTERCERA_TOLERANCIA","HILOTERCERA_ESTANDAR",DATAFILTRADA,"HILOTERCERA");
        setCharts("canvaslargoterceralavada",labels,valorlargoterceralavada);

        // LARGO TERCERA LAVADA
        let valorreviradotercera = getValores("REVIRADOTERCERA_AUDITADO","REVIRADOTERCERA_TOLERANCIA","REVIRADOTERCERA_ESTANDAR",DATAFILTRADA,"REVIRADOTERCERA");
        setCharts("canvasreviradotercera",labels,valorreviradotercera);

        // INCLINACION BEFORE
        let valorinclinacionbefore = getValores("INCLIACABADOS_AUDITADO","INCLIACABADOS_TOLERANCIA","INCLIACABADOS_ESTANDAR",DATAFILTRADA,"INCLIACABADOS");
        setCharts("canvasinclinacionbefore",labels,valorinclinacionbefore);

        // INCLINACION AFTER
        let valorinclinacionafter = getValores("INCLILAVADOS_AUDITADO","INCLILAVADOS_TOLERANCIA","INCLILAVADOS_ESTANDAR",DATAFILTRADA,"INCLILAVADOS");
        setCharts("canvasinclinacionafter",labels,valorinclinacionafter);

        // DATOS DE LA TABLA
        setDatosTable(DATAFILTRADA);

    }

    // OBTIENE VALORES
    function getValores(tsc,tolerancia,estandar,data,nombre = false){

        // let retornar = {};
        let valortsc = [];
        let valorinferior = [];
        let valorsuperior = [];
        let valorestandar = [];
        let indice = 0;

        for(let obj of data){

            // REAL TSC
            let vvalortsc = obj[tsc] ? obj[tsc] : 0;
            vvalortsc = !isNaN(vvalortsc) ? parseFloat(vvalortsc) : 0;
            // console.log(vvalortsc);
            valortsc.push(vvalortsc);
            // ESTANDAR
            let vestandar = parseFloat(obj[estandar]);
            valorestandar.push(vestandar);
            let vtolerancia = parseFloat(obj[tolerancia]);
            // TOLERANCIA INFERIOR
            valorinferior.push(vestandar - vtolerancia);
            // TOLERANCIA SUPERIOR
            valorsuperior.push(vestandar + vtolerancia);

            // AGREGAMOS DATOS TOLERANCIAS
            if(nombre){
                DATAFILTRADA[indice][nombre+"_LIMITEINFERIOR"] = vestandar - vtolerancia;
                DATAFILTRADA[indice][nombre+"_LIMITESUPERIOR"] = vestandar + vtolerancia;
            }


            indice++;
        }

        let mayortsc        = Math.max(...valortsc);
        let mayorestandar   = Math.max(...valorestandar);
        let mayorinferior   = Math.max(...valorinferior);
        let mayorsuperior   = Math.max(...valorsuperior);

        let menortsc        = Math.min(...valortsc);
        let menorrestandar  = Math.min(...valorestandar);
        let menorinferior   = Math.min(...valorinferior);
        let menorsuperior   = Math.min(...valorsuperior);

        let mayor = Math.max(mayortsc,mayorestandar,mayorinferior,mayorsuperior);
        let menor = Math.min(menortsc,menorrestandar,menorinferior,menorsuperior);


        return {
            valortsc,valorinferior,valorsuperior,valorestandar,mayor,menor
        }

    }

    // ASIGNAMOS VALORES CHART
    function setCharts(chart,labels,datavalores){

        document.getElementById(chart+'-container').innerHTML='';
        document.getElementById(chart+'-container').innerHTML="<canvas id='"+chart+"'></canvas>";

        var chartData = {
            labels: labels,
            datasets: [
                {
                    type: 'line',
                    label: 'Auditado TSC',
                    backgroundColor:window.chartColors.blue,
                    data: datavalores.valortsc,
                    lineTension: 0,
                    borderWidth: 2,
                    fill: false,
                    yAxisID: 'y-axis-1',
                    borderColor: window.chartColors.blue
                }, 
                {
                    type: 'line',
                    label: 'Estandar',
                    backgroundColor:window.chartColors.reddark,
                    data: datavalores.valorestandar,
                    lineTension: 0,
                    borderWidth: 2,
                    fill: false,
                    yAxisID: 'y-axis-2',
                    borderColor: window.chartColors.reddark
                }, 
                {
                    type: 'line',
                    label: 'LI',
                    backgroundColor:window.chartColors.black,
                    data: datavalores.valorinferior,
                    lineTension: 0,
                    borderWidth: 2,
                    fill: false,
                    yAxisID: 'y-axis-3',
                    borderColor: window.chartColors.black
                }, 
                {
                    type: 'line',
                    label: 'LS',
                    backgroundColor:window.chartColors.yellow,
                    data: datavalores.valorsuperior,
                    lineTension: 0,
                    borderWidth: 2,
                    fill: false,
                    yAxisID: 'y-axis-4',
                    borderColor: window.chartColors.yellow
                }
            ]
        };

        var ctx = document.getElementById(chart).getContext('2d');
        
        window.myMixedChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: true,
                    callbacks: {
                        title: function (tooltipItem, data) { 
                            let index = tooltipItem[0].index;
                            let partida = DATAFILTRADA[index].PARTIDA;
                            
                            return "Partida: " + partida; 
                        },
                    }
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true
                        }
                    }],				
                    yAxes: [{
                        type: 'linear',
                        display: true,
                        ticks: {
                            suggestedMin: datavalores.menor,
                            suggestedMax: datavalores.mayor
                        },
                        id: 'y-axis-1',
                    },{
                        type: 'linear',
                        display: false,
                        ticks: {
                            suggestedMin: datavalores.menor,
                            suggestedMax: datavalores.mayor
                        },
                        id: 'y-axis-2'
                    },{
                        type: 'linear',
                        display: false,
                        ticks: {
                            suggestedMin: datavalores.menor,
                            suggestedMax: datavalores.mayor
                        },
                        id: 'y-axis-3'
                    },{
                        type: 'linear',
                        display: false,
                        ticks: {
                            suggestedMin: datavalores.menor,
                            suggestedMax: datavalores.mayor
                        },
                        id: 'y-axis-4'
                    }]
                },
                legend:{
                    labels:{
                        usePointStyle: true
                    }
                },
            }
        });
    }   

    // ASIGNAMOS DATOS A TABLA
    function setDatosTable(data){

        let tr ="";
        let cont = 0;
        let indice = 0;

        for(let obj of data){
            cont++;


            let ruta = "";
            let grado               = 0;
            let porcentaje          = 0;
            let porcentajereporte   = 0;
            let kgafectado          = 0;
            let kgafectadomas       = 0;
            let densidareal         = 0;
            let densidadestandar    = 0;
            let kilos               = parseFloat(obj.KILOS);


            ruta = obj.RUTA;
            ruta = ruta.toUpperCase();

            // SI ES LAVADO
            if(ruta.includes("LAVADO")){
                densidareal         = (obj.DENSIDADAFTER_AUDITADO != "" && obj.DENSIDADAFTER_AUDITADO != null) ? parseFloat(obj.DENSIDADAFTER_AUDITADO) : 0;
                densidadestandar    = (obj.DENSIDADAFTER_ESTANDAR != "" && obj.DENSIDADAFTER_ESTANDAR != null) ? parseFloat(obj.DENSIDADAFTER_ESTANDAR) : 0;

            }else{  
                densidareal         = (obj.DENSIDADBEFORE_AUDITADO != "" && obj.DENSIDADBEFORE_AUDITADO != null) ? parseFloat(obj.DENSIDADBEFORE_AUDITADO) : 0;
                densidadestandar    = (obj.DENSIDADBEFORE_ESTANDAR != "" && obj.DENSIDADBEFORE_ESTANDAR != null) ? parseFloat(obj.DENSIDADBEFORE_ESTANDAR) : 0;
            }

            // CALCULAMOS
            grado           = densidareal - densidadestandar;
            porcentaje      = (densidareal - densidadestandar) / densidadestandar;
            kgafectado      = kilos * porcentaje;
            kgafectadomas   = kgafectado < 0 ? 0 : kgafectado;       
            
            // AGREGAMOS DATOS
            DATAFILTRADA[indice]["GRADO"] = grado;
            DATAFILTRADA[indice]["PORCENTAJE"] = porcentaje;
            DATAFILTRADA[indice]["KGAFECTADO"] = kgafectado;
            DATAFILTRADA[indice]["KGAFECTADOMAS"] = kgafectadomas;


            porcentajereporte = (porcentaje * 100).toFixed(2) + "%";

            let reviradotercera = parseFloat(obj.REVIRADOTERCERA_AUDITADO);

            tr += `
                <tr>
                    <td nowrap>${cont}</td>
                    <td nowrap>${obj.PARTIDA}</td>
                    <td nowrap>${obj.PROVEEDOR}</td>
                    <td nowrap>${obj.CLIENTE}</td>
                    <td nowrap>${obj.PROGRAMA}</td>
                    <td nowrap>${obj.CODTELA}</td>
                    <td nowrap>${obj.DESCRIPCIONTELA}</td>
                    <td nowrap>${obj.COLOR}</td>

                    <td nowrap>${obj.ANCHOBEFORE_AUDITADO}</td>
                    <td nowrap>${obj.ANCHOBEFORE_ESTANDAR}</td>
                    <td nowrap>${obj.ANCHOBEFORE_LIMITEINFERIOR}</td>
                    <td nowrap>${obj.ANCHOBEFORE_LIMITESUPERIOR}</td>

                    <td nowrap>${obj.ANCHOAFTER_AUDITADO}</td>
                    <td nowrap>${obj.ANCHOAFTER_ESTANDAR}</td>
                    <td nowrap>${obj.ANCHOAFTER_LIMITEINFERIOR}</td>
                    <td nowrap>${obj.ANCHOAFTER_LIMITESUPERIOR}</td>

                    <td nowrap>${obj.DENSIDADBEFORE_AUDITADO}</td>
                    <td nowrap>${obj.DENSIDADBEFORE_ESTANDAR}</td>
                    <td nowrap>${obj.DENSIDADBEFORE_LIMITEINFERIOR}</td>
                    <td nowrap>${obj.DENSIDADBEFORE_LIMITESUPERIOR}</td>

                    <td nowrap>${obj.DENSIDADAFTER_AUDITADO}</td>
                    <td nowrap>${obj.DENSIDADAFTER_ESTANDAR}</td>
                    <td nowrap>${obj.DENSIDADAFTER_LIMITEINFERIOR}</td>
                    <td nowrap>${obj.DENSIDADAFTER_LIMITESUPERIOR}</td>

                    <td nowrap>${obj.FECHA}</td>
                    <td nowrap>${kilos}</td>

                    <td nowrap>${grado}</td>
                    <td nowrap>${porcentajereporte}</td>
                    <td nowrap>${kgafectado.toFixed(2)}</td>
                    <td nowrap>${kgafectadomas.toFixed(2)}</td>

                    <td nowrap>${obj.ANCHOTERCERA_AUDITADO}%</td>
                    <td nowrap>${obj.ANCHOTERCERA_ESTANDAR}%</td>
                    <td nowrap>${obj.ANCHOTERCERA_LIMITEINFERIOR}%</td>
                    <td nowrap>${obj.ANCHOTERCERA_LIMITESUPERIOR}%</td>

                    <td nowrap>${obj.HILOTERCERA_AUDITADO}%</td>
                    <td nowrap>${obj.HILOTERCERA_ESTANDAR}%</td>
                    <td nowrap>${obj.HILOTERCERA_LIMITEINFERIOR}%</td>
                    <td nowrap>${obj.HILOTERCERA_LIMITESUPERIOR}%</td>

                    <td nowrap>${reviradotercera}%</td>
                    <td nowrap>${obj.REVIRADOTERCERA_ESTANDAR}%</td>
                    <td nowrap>${obj.REVIRADOTERCERA_LIMITEINFERIOR}%</td>
                    <td nowrap>${obj.REVIRADOTERCERA_LIMITESUPERIOR}%</td>

                    <td nowrap>${obj.INCLIACABADOS_AUDITADO}°</td>
                    <td nowrap>${obj.INCLIACABADOS_ESTANDAR}°</td>
                    <td nowrap>${obj.INCLIACABADOS_LIMITEINFERIOR}°</td>
                    <td nowrap>${obj.INCLIACABADOS_LIMITESUPERIOR}°</td>

                    <td nowrap>${obj.INCLILAVADOS_AUDITADO}°</td>
                    <td nowrap>${obj.INCLILAVADOS_ESTANDAR}°</td>
                    <td nowrap>${obj.INCLILAVADOS_LIMITEINFERIOR}°</td>
                    <td nowrap>${obj.INCLILAVADOS_LIMITESUPERIOR}°</td>


                </tr>
            `;

            indice++;
        }

        $("#tbodydatos").html(tr);
    }

    // BUSCAR
    $("#btnbuscar").click(function(){

        let tela        = $("#cbotelas").val()      == "" ? null : $("#cbotelas").val();
        let colores     = $("#cbocolores").val()    == "" ? null : $("#cbocolores").val();
        let programas   = $("#cboprogramas").val()  == "" ? null : $("#cboprogramas").val();

        setgraficos(tela,colores,programas);

    });

    // EXPORTAR DATA EXCEL
    $("#btnexportar").click(function(){

        // CREAMOS FORMULARIO
        var form = document.createElement("form");
        // FILTRO
        var operacioninput   = document.createElement("input");
        var lblfiltroinput   = document.createElement("input");
        var datafiltroinput  = document.createElement("input");

        // CONFIGURAMOS ATRIBUTOS DEL FORMULARIO
        form.method = "POST";
        form.action = "../../../controllers/auditex-testing/indicadortesting.controller.php";
        form.target = "_blank";

        // OPERACION
        operacioninput.value    = "exportarexcel";
        operacioninput.name     = "operacion";
        form.appendChild(operacioninput);

        // LBLFILTROS
        lblfiltroinput.value    = filtros;
        lblfiltroinput.name     = "lblfiltros";
        form.appendChild(lblfiltroinput);

        // DATA FILTRO
        datafiltroinput.value = JSON.stringify(DATAFILTRADA);
        datafiltroinput.name  = "data";
        form.appendChild(datafiltroinput);

        // AGREGAMOS FORMULARIO AL DOCUMENTO
        document.body.appendChild(form);

        // ENVIAMOS FORMULARIO
        form.submit();

        // REMOVEMOS FORMULARIO
        document.body.removeChild(form);


    });

    // EXPORTAR PDF
    $("#btnexportarpdf").click(function(){

        MostrarCarga("Cargando...");

        var form = document.createElement("form");
        form.method = "POST";
        form.action = "../testing-indicadores/pdfindicadordimensional.report.php"   ;
        form.target = "_blank";

        // FILTROS
        var filtroslbl = document.createElement("input");
        filtroslbl.value= filtros;
        filtroslbl.name = "filtroslbl";
        form.appendChild(filtroslbl);

        // CANVAS ANCHO
        var canvasancho = document.createElement("input");
        canvasancho.value= document.getElementById("canvasancho").toDataURL("image/png");
        canvasancho.name = "canvasancho";
        form.appendChild(canvasancho);

        // CANVAS ANCHO AFTER
        var canvasanchoafter = document.createElement("input");
        canvasanchoafter.value= document.getElementById("canvasanchoafter").toDataURL("image/png");
        canvasanchoafter.name = "canvasanchoafter";
        form.appendChild(canvasanchoafter);

        // CANVAS ANCHO
        var canvasdensidad = document.createElement("input");
        canvasdensidad.value= document.getElementById("canvasdensidad").toDataURL("image/png");
        canvasdensidad.name = "canvasdensidad";
        form.appendChild(canvasdensidad);

        // CANVAS ANCHO
        var canvasdensidadafter = document.createElement("input");
        canvasdensidadafter.value= document.getElementById("canvasdensidadafter").toDataURL("image/png");
        canvasdensidadafter.name = "canvasdensidadafter";
        form.appendChild(canvasdensidadafter);

        // CANVAS ANCHO
        var canvasanchoterceralavada = document.createElement("input");
        canvasanchoterceralavada.value= document.getElementById("canvasanchoterceralavada").toDataURL("image/png");
        canvasanchoterceralavada.name = "canvasanchoterceralavada";
        form.appendChild(canvasanchoterceralavada);

        // CANVAS ANCHO
        var canvaslargoterceralavada = document.createElement("input");
        canvaslargoterceralavada.value= document.getElementById("canvaslargoterceralavada").toDataURL("image/png");
        canvaslargoterceralavada.name = "canvaslargoterceralavada";
        form.appendChild(canvaslargoterceralavada);

        // CANVAS ANCHO
        var canvasreviradotercera = document.createElement("input");
        canvasreviradotercera.value= document.getElementById("canvasreviradotercera").toDataURL("image/png");
        canvasreviradotercera.name = "canvasreviradotercera";
        form.appendChild(canvasreviradotercera);

        // CANVAS ANCHO
        var canvasinclinacionbefore     = document.createElement("input");
        canvasinclinacionbefore.value   = document.getElementById("canvasinclinacionbefore").toDataURL("image/png");
        canvasinclinacionbefore.name    = "canvasinclinacionbefore";
        form.appendChild(canvasinclinacionbefore);

        // CANVAS ANCHO
        var canvasinclinacionafter     = document.createElement("input");
        canvasinclinacionafter.value   = document.getElementById("canvasinclinacionafter").toDataURL("image/png");
        canvasinclinacionafter.name    = "canvasinclinacionafter";
        form.appendChild(canvasinclinacionafter);


        // AGREGAMOS INPUT AL FORMULARIO
        document.body.appendChild(form);

        // ENVIAMOS FORMULARIO
        form.submit();

        // REMOVEMOS FORMULARIO
        document.body.removeChild(form);


        Informar("Generado correctamente");


    });

</script>


</body>
</html>