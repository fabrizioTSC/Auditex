//ARMA GRAFICO INDICADOR
function setGrafico(chartname, contenedorchart, prendaspordepurar, prendasdepuradas, valorlabels, titulochart = false, mostrarleyenda = false) {

    // console.log(CONFIINDICADORPORDEPURAR,"RAAA");

    //QUITAMOS CANVAS
    $(`#${chartname}`).remove();
    $(`#${contenedorchart}`).append(`<canvas id='${chartname}'></canvas>`);

    var ctx = document.getElementById(chartname).getContext('2d');
    
    // MAX PRENDAS POR DEPURAR
    let MAX = Math.max(...prendaspordepurar);
    let MAX1 = MAX;
    let PORCENTAJE = Math.round(MAX * 0.10);
    MAX = MAX + PORCENTAJE;

    let STEP = 10;//MAX >= 1000 ? 200 : 100;
    let nuevomax = MAX % STEP;
    nuevomax = STEP - nuevomax;
    nuevomax = nuevomax == STEP ? 0 : nuevomax;
    MAX += nuevomax;

    // MAX PRENDAS DEPURADAS
    let MAXDEPURADAS = Math.max(...prendasdepuradas);
    let PORCENTAJEDE = Math.round(MAXDEPURADAS * 0.30);
    MAXDEPURADAS = MAXDEPURADAS + PORCENTAJEDE;

    let STEPDE = 0.5;
    let nuevomaxn = MAXDEPURADAS % STEPDE;
    nuevomaxn = STEPDE - nuevomaxn;
    nuevomaxn = nuevomaxn == STEPDE ? 0 : nuevomaxn;
    MAXDEPURADAS += nuevomaxn;
   
    // TITULO
    let title = {};
    if(titulochart){
        title.display = true;
        title.text = titulochart;
    }
    


    // CREAMOS CHART
    var mixedChart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: [
                {
                    label: 'Prendas por depurar',
                    data: prendaspordepurar,
                    order: 1,
                    backgroundColor: BACKCOLORGRAFICO,
                    // borderColor: '#ffc600',
                },
                {
                    label: 'Prendas depuradas',
                    data: prendasdepuradas,
                    type: 'line',
                    fill: false,
                    backgroundColor: 'black',
                    borderColor: 'black',
                    yAxisID: 'B',
                    lineTension: 0,   
                    borderWidth: 2,
                }],
            labels: valorlabels
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
                            max: MAX1,
                            stepSize: 1,
                            display:true

                        },
                        gridLines: {
                            // display: false
                            display: true,
						    drawBorder: true,
						    color: ['none',CONFIINDICADORPORDEPURAR[1].COLORFONDO,CONFIINDICADORPORDEPURAR[2].COLORFONDO]
                        },
                        afterBuildTicks: function(humdaysChart) {
                            humdaysChart.ticks = [];
                            humdaysChart.ticks.push(0);
                            humdaysChart.ticks.push( parseFloat(CONFIINDICADORPORDEPURAR[0].VALORFIN) );
                            humdaysChart.ticks.push( parseFloat(CONFIINDICADORPORDEPURAR[1].VALORFIN) );
                            // humdaysChart.ticks.push(100);
                        }
                    },
                    {
                        id: 'B',
                        type: 'linear',
                        position: 'right',
                        ticks: {
                            min: 0,
                            max: 0.30,
                            // stepSize: 0.5,
                            display:false
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
                                valor = dataset.data[i] + "%";

                                // if (dataset.type == "line") {
                                //     valor = dataset.data[i] + "%";
                                // } else {
                                //     valor = dataset.data[i] + "%";
                                // }

                                if(dataset.type == "line"){
                                    ctx.fillText(valor, model.x + 30, model.y);
                                }else{
                                    ctx.fillText(valor, model.x, model.y - 5);
                                }
                            }
                        }


                    });
                }
            }
        }
    });




}