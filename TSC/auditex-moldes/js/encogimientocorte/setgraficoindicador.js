// //ARMA GRAFICO INDICADOR
function setGrafico(chartname, contenedorchart,datos, titulochart = false, mostrarleyenda = false) {


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
    


    // CREAMOS CHART
    var mixedChart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: [
                {
                    label: '% Liberadas',
                    data: datos.liberadas,
                    order: 1,
                    backgroundColor: "#28a745",
                },
                {
                    label: '% Pendientes',
                    data: datos.pendientes,
                    type: 'line',
                    fill: false,
                    yAxisID: 'B',
                    lineTension: 0,  
                    borderColor: '#dc3545',
                    borderWidth: 3,
                },

            ],
            labels: datos.valorlabels
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
                        id: 'A',
                        type: 'linear',
                        position: 'left',
                        ticks: {
                            min: 0,
                            max: 120,
                            stepSize: 20,
                            display:true

                        },
                    },
                    {
                        id: 'B',
                        type: 'linear',
                        position: 'right',
                        ticks: {
                            min: 0,
                            max: 120,
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

}
