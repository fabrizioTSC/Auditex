// INDICADORES MANTENIMIENTOS
async function getMantIndicadores(id){

    try{
        let response = await get("auditex-corte","indicadordepuracion","getmantindicador",{id});
        return response;
    }catch(error){
        Advertir("Ocurrio un error al obtener valores");
    }

}

// RETORNA COLOR DE FONDO Y COLOR DE LETRA
function getColorBackandFontIndicadores(dato,valor){
    // console.log(dato);
    let retornar = {};
    
    for(let obj of dato){

        // valor = parseFloat(valor);
        valor = Math.ceil(valor);

        let valorincio  = parseFloat(obj.VALORINICIO);
        let valorfin    = parseFloat(obj.VALORFIN);
        // console.log(valorincio,valor,valorfin);
        if(valorincio <= valor && valor <= valorfin){

            retornar.backcolor = obj.COLORFONDO;
            retornar.fontcolor = obj.COLORLETRA;
            break;
        }

    }

    // console.log(dato,valor,retornar);

    return retornar;

}

// FORMAT INDICADORES TEXTIL
function formatDataIndicadoresTextilBloques(array,descripcion,valor,id,frecuencia){

    let descripciones   = [];
    let valores         = [];
    let porcentajes     = [];
    let acumulados      = [];
    let frecuencias     = [];
    let ides            = [];
    let colores         = [];

    let color1 = "#ff963c";
    let color2 = "#f0c8a0";
    let cont = 0;

    for(let obj of array){

        cont++;

        ides.push(obj[id]);
        descripciones.push(obj[descripcion]);
        valores.push( parseFloat(obj[valor]) );
        frecuencias.push( parseFloat(obj[frecuencia]));
        // AGREGAMOS COLORES
        colores.push(cont <= 2 ? color1 : color2);
        

    }

    // OBTENEMOS LA SUMA DE CANTIDAD DE VALORES
    // let total = valores.reduce((a, b) => a + b, 0);
    let total = frecuencias.reduce((a, b) => a + b, 0);


    let acumulado = 0;
    // OBTENEMOS PORCENTAJE
    // for(let obj of valores){
    for(let obj of frecuencias){


        // GENERAMOS PORCENTAJE
        let porcentaje = ((obj / total) * 100).toFixed(2);
        // FORMATEAMOS
        porcentaje = parseFloat(porcentaje);
        // AGREGAMOS
        porcentajes.push(porcentaje);
        // ASIGNAMOS ACUMULADO
        acumulado += porcentaje;
        // GUARDAMOS ACUMULADO
        acumulados.push(acumulado.toFixed(2));
    }

    return {
        descripciones,
        valores,
        porcentajes,
        acumulados,
        total,
        mayor1: ides.length > 0 ? ides[0] : 0,
        mayor2: ides.length > 1 ? ides[1] : 0,
        mayor1des: ides.length > 0 ? descripciones[0] : "",
        mayor2des: ides.length > 1 ? descripciones[1] : "",
        colores,
        frecuencias
    }

}

function setGraficoBarraIndicadoresTextilBloques(chartname, data, titulochart = false, mostrarleyenda = false){

    Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 20;
    };

    //QUITAMOS CANVAS
    $(`#${chartname}`).remove();
    $(`#${chartname}container`).append(`<canvas id='${chartname}'></canvas>`);

    let canvas  = document.getElementById(chartname);
    var ctx     = canvas.getContext('2d');

    // TITULO
    let title = {};
    if(titulochart){
        title.display = true;
        title.text = titulochart;
    }

    // // MAXIMO
    let MAX = Math.max(...data.porcentajes);
    MAX = MAX + 5;

    let datavalores         = [...data.porcentajes];//data.valores;
    let datadescripciones   = [...data.descripciones];//data.descripciones;


    // CREAMOS CHART
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: [
                {
                    label: 'Frecuencia',
                    data: datavalores,
                    order: 1,
                    backgroundColor: '#36a2eb',
                    // borderColor: '#ffc600',
                },
            ],
            labels: datadescripciones
        },
        options: {
            maintainAspectRatio: false,
            //responsive: true,
            legend: {
                display:  mostrarleyenda,
                position: 'top',
            },
            title,
            scales: {
                yAxes: [
                    {
                        id: 'A',
                        type: 'linear',
                        position: 'left',
                        ticks: {
                            min: 0,
                            max: 100,
                            // stepSize: STEP,
                            display:true

                        },
                    },
                ]
            },
            tooltips: {
                enabled: false,
            },
            plugins: {
                // display:false
                datalabels : {
                 display:false
                }
            },
            animation: {
                duration: 1500,
                onComplete : function () {
                    var ctx = this.chart.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                    ctx.fillStyle = "black";
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    
    
                    this.data.datasets.forEach(function (dataset) {
    
                        for (var i = 0; i < dataset.data.length; i++) {
    
                            for (var key in dataset._meta) {
    
                                // console.log("Dataset",dataset);
    
                                var model = dataset._meta[key].data[i]._model;
                                var valor = 0;
                                valor = dataset.data[i] + "%";
                                ctx.fillText(valor, model.x , model.y - 5);                                    
    
                            }
                        }
    
    
                    });
                }
            }
        }
    });

    // CREAMOS TABLA
    let tr = "";
    let arrayretornar = [];
    let cont = 0;

    // RECORREMOS
    for(let i = 0; i < data.acumulados.length;i++){

        // let objtabla = {};
        cont++;
        // objtabla.descripcion    = data.descripciones[i];
        // objtabla.valor          = data.valores[i];
        // objtabla.porcentaje     = data.porcentajes[i];
        // objtabla.acumulado      = data.acumulados[i];


        tr += `
            <tr>
                <td style='text-align:left !important'>${cont}. ${data.descripciones[i]}</td>
                <td>${format_miles(data.valores[i])}</td>
                <td>${data.porcentajes[i]}%</td>
                <td>${data.acumulados[i]}%</td>
                <td>${format_miles(data.frecuencias[i])}</td>
            </tr>
        `;

    }

    // ASIGNAMOS
    $(`#${chartname}tbody`).html(tr);

    return {
        chart,canvas
    };
}

// FORMAT DATA
function formatDataIndicadores(array,descripcion,valor,id){

    let descripciones   = [];
    let valores         = [];
    let porcentajes     = [];
    let acumulados      = [];
    let ides            = [];
    let colores         = [];

    let color1 = "#ff963c";
    let color2 = "#f0c8a0";
    let cont = 0;

    for(let obj of array){

        cont++;

        ides.push(obj[id]);
        descripciones.push(obj[descripcion]);
        valores.push( parseFloat(obj[valor]) );

        // AGREGAMOS COLORES
        colores.push(cont <= 2 ? color1 : color2);
        

    }

    // OBTENEMOS LA SUMA DE CANTIDAD DE VALORES
    let total = valores.reduce((a, b) => a + b, 0);

    let acumulado = 0;
    // OBTENEMOS PORCENTAJE
    for(let obj of valores){

        // GENERAMOS PORCENTAJE
        let porcentaje = ((obj / total) * 100).toFixed(2);
        // FORMATEAMOS
        porcentaje = parseFloat(porcentaje);
        // AGREGAMOS
        porcentajes.push(porcentaje);
        // ASIGNAMOS ACUMULADO
        acumulado += porcentaje;
        // GUARDAMOS ACUMULADO
        acumulados.push(acumulado.toFixed(2));
    }

    return {
        descripciones,
        valores,
        porcentajes,
        acumulados,
        total,
        // mayor1: ides.length > 0 ? ides[0] : null,
        // mayor2: ides.length > 1 ? ides[1] : null,
        // mayor1des: ides.length > 0 ? descripciones[0] : null,
        // mayor2des: ides.length > 1 ? descripciones[1] : null,
        mayor1: ides.length > 0 ? ides[0] : 0,
        mayor2: ides.length > 1 ? ides[1] : 0,
        mayor1des: ides.length > 0 ? descripciones[0] : "",
        mayor2des: ides.length > 1 ? descripciones[1] : "",
        colores
    }

}

// SET PARETOS
function setGraficoParetosGeneral(chartname, data, titulochart = false, mostrarleyenda = false,nivel2total = false){

    Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 20;
    };

    //QUITAMOS CANVAS
    $(`#${chartname}`).remove();
    $(`#${chartname}container`).append(`<canvas id='${chartname}'></canvas>`);

    var ctx = document.getElementById(chartname).getContext('2d');

    // TITULO
    let title = {};
    if(titulochart){
        title.display = true;
        title.text = titulochart;
    }

    // MAXIMO
    let MAX = data.total;
    let PORCENTAJE = Math.round(MAX * 0.10);
    MAX = MAX + PORCENTAJE;

    let STEP = 100;//MAX >= 1000 ? 200 : 100;
    let nuevomax = MAX % STEP;
    nuevomax = STEP - nuevomax;
    nuevomax = nuevomax == STEP ? 0 : nuevomax;
    MAX += nuevomax;

    // CALCULAMOS PORCENTAJE DEL GENERAL SI ES NIVEL 2
    if(nivel2total){
        let delgeneral = [];
        for(let obj of data.valores){
            let valor = (obj / nivel2total) * 100;
            valor = valor.toFixed(2);
            delgeneral.push(valor);
        }

        data.delgeneral = delgeneral;
    }

    let datavalores         = [...data.valores];//data.valores;
    let datacolores         = [...data.colores];//data.colores;
    let dataacumulados      = [...data.acumulados];//data.acumulados;
    let datadescripciones   = [...data.descripciones];//data.descripciones;

    datavalores.length = datavalores.length > 10 ? 10 : datavalores.length;
    datacolores.length = datacolores.length > 10 ? 10 : datacolores.length;
    dataacumulados.length = dataacumulados.length > 10 ? 10 : dataacumulados.length;
    datadescripciones.length = datadescripciones.length > 10 ? 10 : datadescripciones.length;
    // datavalores.length = 10;



    // CREAMOS CHART
    var mixedChart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: [
                {
                    label: 'Frecuencia',
                    data: datavalores,
                    order: 1,
                    backgroundColor: datacolores,
                    // borderColor: '#ffc600',
                },
                {
                    label: 'Acumulado',
                    data: dataacumulados,
                    type: 'line',
                    fill: false,
                    backgroundColor: '#ff6384',
                    borderColor: '#ff6384',
                    yAxisID: 'B',
                    lineTension: 0,   
                }],
            labels: datadescripciones
        },
        options: {
            maintainAspectRatio: false,
            //responsive: true,
            legend: {
                display:  mostrarleyenda,
                position: 'top',
            },
            title,
            scales: {
                yAxes: [
                    {
                        id: 'A',
                        type: 'linear',
                        position: 'left',
                        ticks: {
                            min: 0,
                            max: MAX,
                            // stepSize: STEP,
                            display:true

                        },
                        gridLines: {
                            display: false
                        }
                    },
                    {
                        id: 'B',
                        type: 'linear',
                        position: 'right',
                        ticks: {
                            min: 0,
                            max: 100,
                            stepSize: 10,
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
                                if (dataset.type == "line") {
                                    valor = dataset.data[i] + "%";
                                } else {
                                    // valor = dataset.data[i] + "%";
                                    valor = data.porcentajes[i] + "%";
                                }

                                ctx.fillText(valor, model.x, model.y - 5);
                            }
                        }


                    });
                }
            }
        }
    });

    // CREAMOS TABLA
    let tr = "";


    let arrayretornar = [];
    let cont = 0;
    // RECORREMOS
    for(let i = 0; i < data.acumulados.length;i++){

        let objtabla = {};
        cont++;
        objtabla.descripcion    = data.descripciones[i];
        objtabla.valor          = data.valores[i];
        objtabla.porcentaje     = data.porcentajes[i];
        objtabla.acumulado      = data.acumulados[i];


        tr += `
            <tr>
                <td style='text-align:left !important'>${cont}. ${data.descripciones[i]}</td>
                <td>${data.valores[i]}</td>
                <td>${data.porcentajes[i]}%</td>
                <td>${data.acumulados[i]}%</td>
        `;

        if(nivel2total){
            tr += `<td>${data.delgeneral[i]}%</td>`;
            objtabla.delgeneral      = data.delgeneral[i];
        }

        tr += "</tr>";

        arrayretornar.push(objtabla);

    }

    // ASIGNAMOS
    $(`#${chartname}tbody`).html(tr);
    return arrayretornar;

}

// SET PARETOS
function setGraficoBarraGeneral(chartname, data, titulochart = false, mostrarleyenda = false){

    Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 20;
    };

    //QUITAMOS CANVAS
    $(`#${chartname}`).remove();
    $(`#${chartname}container`).append(`<canvas id='${chartname}'></canvas>`);

    let canvas  = document.getElementById(chartname);
    var ctx     = canvas.getContext('2d');

    // TITULO
    let title = {};
    if(titulochart){
        title.display = true;
        title.text = titulochart;
    }

    // // MAXIMO
    let MAX = Math.max(...data.valores);
    MAX = MAX + 5;

    let datavalores         = [...data.valores];//data.valores;
    let datadescripciones   = [...data.descripciones];//data.descripciones;


    // CREAMOS CHART
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: [
                {
                    label: 'Frecuencia',
                    data: datavalores,
                    order: 1,
                    backgroundColor: '#36a2eb',
                    // borderColor: '#ffc600',
                },
            ],
            labels: datadescripciones
        },
        options: {
            maintainAspectRatio: false,
            //responsive: true,
            legend: {
                display:  mostrarleyenda,
                position: 'top',
            },
            title,
            scales: {
                yAxes: [
                    {
                        id: 'A',
                        type: 'linear',
                        position: 'left',
                        ticks: {
                            min: 0,
                            max: MAX,
                            // stepSize: STEP,
                            display:true

                        },
                    },
                ]
            },
            tooltips: {
                enabled: false,
            },
            plugins: {
                // display:false
                datalabels : {
                 display:false
                }
            },
            animation: {
                duration: 1500,
                onComplete : function () {
                    var ctx = this.chart.ctx;
                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                    ctx.fillStyle = "black";
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    
    
                    this.data.datasets.forEach(function (dataset) {
    
                        for (var i = 0; i < dataset.data.length; i++) {
    
                            for (var key in dataset._meta) {
    
                                // console.log("Dataset",dataset);
    
                                var model = dataset._meta[key].data[i]._model;
                                var valor = 0;
                                valor = dataset.data[i]; //+ "%";
                                ctx.fillText(valor, model.x , model.y - 5);                                    
    
                            }
                        }
    
    
                    });
                }
            }
        }
    });

    return {
        chart,canvas
    };
}

// COPIA LO QUE ESTA EN EL ELEMENTO
function copyToClipboard(elemento) {
    var $temp = $("<input>")
    $("body").append($temp);

    // let valor = $(elemento).text() == "" ? $(elemento).val() : $(elemento).text();
    let valor = $(elemento).data("valor");


    // console.log(valor);
    $temp.val(valor).select();
    
    document.execCommand("copy");
    $temp.remove();
}