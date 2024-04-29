<?php
	session_start();
	// date_default_timezone_set('America/Lima');

    // require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    // require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';

	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    // $objModelo = new CoreModelo();
    $_SESSION['navbar'] = "Indicador por Auditor";


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['navbar'] ?>  </title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>
    <!-- <link rel="stylesheet" href="../../../libs/css/mdb.min.css"> -->
    <style>
        /* td,th{
            padding: 0px !important;
        } */
        body{
            padding-top:60px !important;
        }

        .font-size-11{
            font-size: 11.5px !important;
        }

        .hr{
            border: 1px solid #fff;
        }
        label{
            margin-bottom: 0px !important;
        }
        label,h1,h2,h3,h4,h5,h6{
            color:#fff !important;
        }
        .swal2-popup > label,h1,h2,h3,h4,h5,h6{ 
            color: #595959 !important;
        }

        .table-indicador{
            background-color: #fff;
        }


        .table-indicador > thead{
            table-layout: fixed;

        }

        .table-indicador > thead{
            font-size: 14px !important;
        }

        .table-indicador > tbody{
            font-size: 13px !important;
            font-weight: bold !important;
            /* vertical-align: middle !important; */
        }


        .table-indicador  th{
            /* font-size: 13px !important;
            font-weight: bold !important; */
            vertical-align: middle !important;
        }

        .table-indicador > td,th{
            padding: 0px !important;
        }

    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container mt-3">


    <!-- CONTAINER BUSQUEDA -->
    <div class="container" id="containerbusqueda">

        <form action="" class="row justify-content-center" id="frmbusqueda">

            <div class="form-group col-12 col-md-8">
                <label for="">Sede</label>
                <select name="cbosede" id="cbosede" class="custom-select select2 filtrossedetiposer" style="width: 100%;"></select>
            </div>

            <div class="form-group col-12 col-md-8">
                <label for="">Tipo de Servicio</label>
                <select name="cbotiposervicio" id="cbotiposervicio" class="custom-select select2 filtrossedetiposer" style="width: 100%;"></select>
            </div>

            <div class="form-group col-12 col-md-8">
                <label for="">Taller</label>
                <select name="cbotaller" id="cbotaller" class="custom-select select2" style="width: 100%;" ></select>
            </div>


            <div class="form-group col-12 col-md-8">
                <label for="">Auditor</label>
                <select name="cboauditor" id="cboauditor" class="custom-select select2" style="width: 100%;" ></select>
                <!-- <input type="text" class="form-control form-control-sm" name="fecha" id="fecha" > -->
            </div>

            <div class="form-group col-12 col-md-8">

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input tipofiltro" type="radio" name="tipofiltro" id="radioaniomes"   data-filtro="aniomes" data-tipofiltro="1" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Año / Mes
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <input type="month" class="form-control form-control-sm filtrosinput aniomes" id="txtaniomes">
                    </div>
                </div>

            </div>

            <div class="form-group col-12 col-md-8">
                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input tipofiltro" type="radio" name="tipofiltro" id="radioaniosemana" data-filtro="aniosemana" data-tipofiltro="2" >
                            <label class="form-check-label" for="exampleRadios1">
                                Año / Semana
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <input type="week" class="form-control form-control-sm filtrosinput aniosemana" id="txtaniosemana" disabled>
                    </div>
                </div>
            </div>

            <div class="form-group col-12 col-md-8">

                <div class="row">

                    <!-- CHECK -->
                    <div class="col">

                        <div class="form-check">
                            <input class="form-check-input tipofiltro" type="radio" name="tipofiltro" id="radiofechas" data-filtro="rangofechas" data-tipofiltro="3">
                            <label class="form-check-label" for="exampleRadios1">
                                Rango Fechas
                            </label>
                        </div>

                    </div>
                    <!-- FECHA INICIO -->
                    <div class="col">
                        <input type="date" class="form-control form-control-sm filtrosinput rangofechas" id="txtfechai" disabled>
                    </div>

                    <!-- FECHA FIN -->
                    <div class="col">
                        <input type="date" class="form-control form-control-sm filtrosinput rangofechas rangofechas" id="txtfechaf" disabled>
                    </div>

                </div>


            </div>

            <!-- <div class="form-group col-md-10 col-10">

            </div> -->

            <div class="form-group col-12 col-md-6">
                <label for="">&nbsp;</label>
                <input type="hidden" name="showreport" value="true">
                <button class="btn btn-sm btn-block btn-secondary" type="submit">MOSTRAR INDICADORES</button>
            </div>

        </form>

    </div>


    <!-- CONTAINER INDICADOR -->
    <div class="contaier" id="containerindicador" style="display:none" >

        <div class="row justify-content-center">

            <div class="col-md-2">
                <button class="btn btn-sm btn-block btn-warning" id="btnvolver">
                    <i class="fas fa-arrow-left"></i>
                    Volver
                </button>
            </div>

            <div class="col-md-2">
                <button class="btn btn-sm btn-block btn-danger" id="btnexportarpdf">Descargar PDF</button>
            </div>

        </div>

        <div class="row justify-content-center">

            <div class="col-10 text-center">
                <label for="" class="font-weight-bold">INDICADORES POR AUDITOR - COSTURA FINAL</label>
                <br>
                <label id="lblfiltros">
                </label>
            </div>

            <!--  CHART GENERAL -->
            <div class="col-10 bg-white" style="min-height: 500px;" id="contenedorchartgeneral">

                <canvas id="chartgeneral"></canvas>

            </div>


            <!-- TABLA -->
            <div class="col-10 mt-2 bg-white p-0">

                <table class="table table-bordered table-sm m-0" id="tableindicadorgeneral">
                    <thead class="thead-light text-center" style="font-size:12px" >
                        <tr>
                            <th>AUDITOR</th>
                            <th>FICHAS AUDITADAS</th>
                            <th>FICHAS APROBADAS</th>
                            <th>FICHAS RECHAZADAS</th>
                            <th>TOTAL PRENDAS</th>
                            <th>PRENDAS APROBADAS</th>
                            <th>PRENDAS RECHAZADAS</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyindicadorgeneral"  style="font-size:11px">

                    </tbody>
                </table>

            </div>

            <!-- DIAGRAMA DE PARETO NIVEL 1 (SEMANA) -->
            <div class="col-md-8 text-white mt-2 text-center " style="font-size: 13px !important;">
                <hr>
                <label class="w-100 font-weight-bold" style="font-size: 15px !important;">DIAGRAMA DE PARETO GENERAL - DEFECTOS</label>
            </div>

            <!-- GRAFICO PARETO 2 -->
            <div class="card col-md-8 p-0" >
                <div class="card-body p-0">
                    <div class="form-group" id="chartpareto1container" style="height: 400px;">
                        <canvas id="chartpareto1" ></canvas>
                    </div>
                </div>
            </div>

            <!-- TABLA PARETO 2 -->
            <div class="card col-md-6 mt-1  p-0" >
                <div class="table-responsive">

                    <table class="table table-sm  text-center table-bordered-sistema m-0 table-indicador" id="chartpareto2table">
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


        </div>

    </div>

</div>



<div class="loader"></div>


<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script>

    const frmbusqueda = document.getElementById("frmbusqueda");
    let TIPOFILTRO = 1;
    let btnvolver = document.getElementById("btnvolver");
    let SEDELBL         = null;
    let TIPOSERVICIOLBL = null;
    let TALLERLBL       = null;
    let AUDITORLBL      = null;
    let TIPOFILTROLBL   = null;
    let MESLBL          = null;
    let SEMANALBL       = null;
    let ANIOLBL         = null;
    let FECHAILBL       = null;
    let FECHAFLBL       = null;
    let DATAGENERAL     = null;
    let DATAPARETO      = null;
    let TITULOINDICADOR = null;
    let FECHAS          = null;

    window.addEventListener('load',async ()=>{

        // SEDES
        await getSedes();

        await getTipoServicios();

        await getAuditores();

        $(".loader").fadeOut("slow");
    });

    frmbusqueda.addEventListener('submit',(e)=>{
        e.preventDefault();
        GetDataIndicador();
    });

    // GET SEDES
    async function getSedes(){
        let response = await get("auditex-generales","generales","getsedes",{ });
        setComboSimple("cbosede",response,"DESSEDE","CODSEDE",true,false,"TODOS");
    }

    // GET TIPO DE SERVICIOS
    async function getTipoServicios(){
        let response = await get("auditex-generales","generales","gettiposervicios",{ });
        setComboSimple("cbotiposervicio",response,"DESTIPSERV","CODTIPSERV",true,false,"TODOS");
    }

    // GET TIPO DE SERVICIOS
    async function getAuditores(){
        let response = await get("auditex-generales","generales","getauditorescosturafinal",{ });
        setComboSimple("cboauditor",response,"CODUSU","CODUSU",true,false,"TODOS");
    }

    // BUSCAMOS
    function GetDataIndicador(){

        let anio            = "";
        let mes             = "";
        let semana          = "";

        let sede            = $("#cbosede").val() == "" ? null : $("#cbosede").val();
        let tiposervicio    = $("#cbotiposervicio").val() == "" ? null : $("#cbotiposervicio").val();
        let codtaller       = $("#cbotaller").val() == "" ? null : $("#cbotaller").val();
        let auditor         = $("#cboauditor").val() == "" ? null : $("#cboauditor").val();
        let tipofiltro      = TIPOFILTRO;

        SEDELBL             = sede          == null ? "(TODOS)" : $( "#cbosede option:selected" ).text();
        TIPOSERVICIOLBL     = tiposervicio  == null ? "(TODOS)" : $( "#cbotiposervicio option:selected" ).text();
        TALLERLBL           = codtaller     == null ? "(TODOS)" : $( "#cbotaller option:selected" ).text();
        AUDITORLBL          = auditor       == null ? "(TODOS)" : $( "#cboauditor option:selected" ).text();
        let fechai          = $("#txtfechai").val() == "" ? null : $("#txtfechai").val();
        let fechaf          = $("#txtfechaf").val() == "" ? null : $("#txtfechaf").val();

        if(TIPOFILTRO == 1){
            let input = $("#txtaniomes").val();
            anio    = input.split("-")[0];
            mes     = input.split("-")[1];


            FECHAS = ` Año: ${anio} - Mes: ${mes}`;
        }

        if(TIPOFILTRO == 2){
            let input = $("#txtaniosemana").val();
            anio        = input.split("-W")[0];
            semana      = input.split("-W")[1];

            FECHAS = ` Año: ${anio} - Semana: ${semana}`;

        }

        if(TIPOFILTRO == 3){
            FECHAS = `${fechai} - ${fechaf}`;
        }


        TITULOINDICADOR = `
            SEDE: ${SEDELBL} / TIPO SERVICIO: ${TIPOSERVICIOLBL} / TALLER: ${TALLERLBL} / AUDITOR: ${AUDITORLBL}
            / FECHAS : ${FECHAS}
        `;

        $("#lblfiltros").text(TITULOINDICADOR);

        MostrarCarga();
        get("auditex-costura","auditoriafinal","getindicadorauditor",{
                sede,       tiposervicio,   codtaller,  auditor,
                tipofiltro, anio,           mes,        semana,
                fechai,     fechaf
        })
        .then(response =>{

            let tr = ``;
            let usuarios            = [];
            let prendasaprobadas    = [];
            let prendasrechazadas   = [];
            let fichasaprobadas     = [];
            let fichasrechazadas    = [];
            let datageneral         = {};

            let data                        = response.response_auditor;
            let data_pareto_sin_formato     = response.response_defecto;
            DATAGENERAL                     = data;
            let data_pareto                 = formatDataIndicadores(data_pareto_sin_formato,"CODUSU","CANTDEF","CODUSU");
            let datopareto1                 = setGraficoParetosGeneral("chartpareto1",data_pareto,false,true);
            DATAPARETO                      = datopareto1;
            // console.log("datapareto",datopareto1)
            // console.log

            let indice = 0;
            for(let item of data){

                usuarios.push(item.CODUSU);
                prendasaprobadas.push(item.PRENDASAPRO);
                prendasrechazadas.push(item.PRENDASAREC);
                fichasaprobadas.push(item.FICHASAPRO);
                fichasrechazadas.push(item.FICHASAREC);


                tr += `
                    <tr>
                        <td>${item.CODUSU}</td>
                        <td>${format_miles(item.FICHASAUD)}</td>
                        <td>${format_miles(item.FICHASAPRO)}</td>
                        <td>${format_miles(item.FICHASAREC)}</td>
                        <td>${format_miles(item.PRENDASTOT)}</td>
                        <td>${format_miles(item.PRENDASAPRO)}</td>
                        <td>${format_miles(item.PRENDASAREC)}</td>
                    </tr>
                `;
                DATAGENERAL[indice].PRENDASTOT  = format_miles(item.PRENDASTOT);
                DATAGENERAL[indice].PRENDASAPRO = format_miles(item.PRENDASAPRO);
                DATAGENERAL[indice].PRENDASAREC = format_miles(item.PRENDASAREC);


                indice++;

            }

            $("#tbodyindicadorgeneral").html(tr);

            datageneral.labels = usuarios;
            datageneral.prendasaprobadas    = prendasaprobadas;
            datageneral.prendasrechazadas   = prendasrechazadas;
            datageneral.fichasaprobadas     = fichasaprobadas;
            datageneral.fichasrechazadas    = fichasrechazadas;

            MostrarOcultarReporte(true);
            SetChartGeneral(datageneral,'chartgeneral','contenedorchartgeneral');
            OcultarCarga();
        })
        .catch(error => {
            console.log('error',error);
            Advertir("Error en ajax");
        });

    }

    btnvolver.addEventListener('click',()=> {
        MostrarOcultarReporte(false);
    });

    // TALLERES
    function getTalleres(){

        let sede            = $("#cbosede").val() == "" ? null : $("#cbosede").val();
        let tiposervicio    = $("#cbotiposervicio").val() == "" ? null : $("#cbotiposervicio").val();

        // if(tiposervicio != null){
        MostrarCarga();
        get("auditex-generales","generales","gettalleres_new",{ sede,tiposervicio})
        .then(response =>{

            setComboSimple("cbotaller",response,"DESCRIPCION","ID");
            OcultarCarga();
        })
        .catch(error => {
            Advertir("Error en ajax");
        });

    }

    // SET CHART GENERAL
    function SetChartGeneral(datos,chartname,contenedorchart,titulochart,mostrarleyenda = 'mostrarleyenda'){

        //QUITAMOS CANVAS
        $(`#${chartname}`).remove();
        $(`#${contenedorchart}`).append(`<canvas id='${chartname}'></canvas>`);

        var ctx = document.getElementById(chartname).getContext('2d');

        // TITULO
        let title = {};
        if(titulochart){
            title.display = true;
            title.text = titulochart;
        }

        let maxfichas = Math.max(...datos.fichasaprobadas);
        maxfichas +=10;

        // CREAMOS CHART
        var mixedChart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: [
                    {
                        label: 'Prendas Aprobadas',
                        data: datos.prendasaprobadas,
                        order: 1,
                        backgroundColor: '#4bc0c0',
                    },
                    {
                        label: 'Prendas Rechazadas',
                        data: datos.prendasrechazadas,
                        order: 1,
                        backgroundColor: '#ff6384',
                    },
                    {
                        label: 'Fichas Aprobadas',
                        data: datos.fichasaprobadas,
                        type: 'line',
                        fill: false,
                        yAxisID: 'B',
                        lineTension: 0,
                        // borderColor: '#333631',
                        borderWidth: 3,
                        backgroundColor: '#9ad0f5',
                        borderColor: '#9ad0f5',
                    },
                    {
                        label: 'Fichas Rechazadas',
                        data: datos.fichasrechazadas,
                        type: 'line',
                        fill: false,
                        yAxisID: 'B',
                        lineTension: 0,
                        // borderColor: '#333631',
                        borderWidth: 3,
                        backgroundColor: '#ffb1c1',
                        borderColor: '#ffb1c1',
                    },
                ],
                labels: datos.labels
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display:  mostrarleyenda,
                    position: 'top',
                },
                title,
                scales: {
                    yAxes: [
                        {
                            // id: 'B',
                            // type: 'linear',
                            // position: 'left',
                            // ticks: {
                            //     min: 0,
                            //     max: 120,
                            //     stepSize: 1,
                            //     display:true

                            // },
                            // gridLines: {
                            //     display: true,
                            //     drawBorder: true,
                            //     color: ['none',CONFIINDICADOR[1].COLORFONDO,CONFIINDICADOR[2].COLORFONDO]
                            // },
                            // afterBuildTicks: function(humdaysChart) {
                            //     humdaysChart.ticks = [];
                            //     humdaysChart.ticks.push(0);
                            //     humdaysChart.ticks.push( parseFloat(CONFIINDICADOR[0].VALORFIN) );
                            //     humdaysChart.ticks.push( parseFloat(CONFIINDICADOR[1].VALORFIN) );
                            //     humdaysChart.ticks.push(100);
                            // }
                        },
                        {
                            id: 'B',
                            type: 'linear',
                            position: 'right',
                            ticks: {
                                min: 0,
                                max: maxfichas,
                                display:true
                            },
                            gridLines: {
                                display: false
                            }
                        },
                    ]
                },
                tooltips: {
                    enabled: false,
                },
                legend:{
                    labels:{
                        usePointStyle: true
                    }
                },
                plugins: {
                    datalabels: {
                        color: 'black',
                        font:{
                            weight:'bold'
                        }
                    }
                },
                animation: {
                duration: 1500,
                onComplete : function () {
                    var ctx = this.chart.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                    ctx.fillStyle = "black";
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset) {

                        for (var i = 0; i < dataset.data.length; i++) {
                            for (var key in dataset._meta) {
                                var model = dataset._meta[key].data[i]._model;
                                var valor = 0;
                                valor = format_miles(dataset.data[i]);
                                // if (dataset.type == "line") {
                                    // valor = dataset.data[i] + "%";
                                // } else {
                                    // valor = dataset.data[i] + "%";
                                    // valor = data.porcentajes[i] + "%";
                                // }

                                ctx.fillText(valor, model.x, model.y - 5);
                            }
                        }


                    });
                }
            }
            }
        });


    }

    $(".filtrossedetiposer").change(function(){
        getTalleres();
    });


    $(".tipofiltro").change(function(){

        let filtro      = $(this).data("filtro");
        let tipofiltro  = $(this).data("tipofiltro");

        TIPOFILTRO = tipofiltro;

        $(".filtrosinput").prop("disabled",true);
        $(".filtrosinput").val("");
        $("."+filtro).prop("disabled",false);

    });

    function MostrarOcultarReporte(mostrar = true){

        // containerindicador
        // containerbusqueda

        if(mostrar){

            $("#containerbusqueda").fadeOut(1000);
            setTimeout(()=>{
                $("#containerindicador").fadeIn();
            },1100);

        }else{

            $("#containerindicador").fadeOut(1000);
            setTimeout(()=>{
                $("#containerbusqueda").fadeIn();
            },1100);

        }

    }

    $("#btnexportarpdf").click(function(){

        var form = document.createElement("form");
        form.method = "POST";
        form.action = "pdfindicadorauditor.report.php"   ;
        form.target = "_blank";


        // GRAFICO
        var imagen = document.createElement("input");
        imagen.value= document.getElementById("chartgeneral").toDataURL("image/png");
        imagen.name = "imagen";
        form.appendChild(imagen);

        var imagenpareto = document.createElement("input");
        imagenpareto.value= document.getElementById("chartpareto1").toDataURL("image/png");
        imagenpareto.name = "imagenpareto";
        form.appendChild(imagenpareto);

        var tituloindicador = document.createElement("input");
        tituloindicador.value= TITULOINDICADOR;
        tituloindicador.name = "tituloindicador";
        form.appendChild(tituloindicador);


        // date general
        var datageneral = document.createElement("input");
        datageneral.value= JSON.stringify(DATAGENERAL);
        datageneral.name = "datageneral";
        form.appendChild(datageneral);

        var datapareto = document.createElement("input");
        datapareto.value= JSON.stringify(DATAPARETO);
        datapareto.name = "datapareto";
        form.appendChild(datapareto);
        // TITULOINDICADOR


        // AGREGAMOS INPUT AL FORMULARIO
        document.body.appendChild(form);

        // ENVIAMOS FORMULARIO
        form.submit();

        // REMOVEMOS FORMULARIO
        document.body.removeChild(form);


    });



</script>



</body>
</html>