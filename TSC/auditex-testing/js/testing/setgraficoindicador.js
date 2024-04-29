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
                    label: '% Kg Aprobados',
                    data: datos.kgaprobados,
                    order: 1,
                    backgroundColor: BACKCOLORGRAFICO,
                },
                {
                    label: '% Kg Apro. no con',
                    data: datos.kgaprobadosnoconforme,
                    type: 'line',
                    fill: false,
                    yAxisID: 'B',
                    lineTension: 0,  
                    // backgroundColor: 'yellow',
                    borderColor: '#ffcd56',
                    borderWidth: 3,
                },
                {
                    label: '% Kg Rechazados',
                    data: datos.kgrechazados,
                    type: 'line',
                    fill: false,
                    yAxisID: 'C',
                    lineTension: 0,  
                    // backgroundColor: 'purple',
                    borderColor: '#9d141d',
                    borderWidth: 3,
                },
                // {
                //     label: '% Kg Otros',
                //     data: datos.kgotros,
                //     type: 'line',
                //     fill: false,
                //     yAxisID: 'D',
                //     lineTension: 0,  
                //     // backgroundColor: 'green',
                //     borderColor: 'green',
                //     borderWidth: 2,
                    
                // },
            ],
            labels: datos.valorlabels
        },
        options: {
            maintainAspectRatio: false,
            //responsive: true,
            // layout: {
            //     padding: {
            //         left: 0,
            //         right: 0,
            //         top: 0,
            //         bottom: 20
            //     }
            // },
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
                            stepSize: 1,
                            display:true

                        },
                        gridLines: {
                            display: true,
						    drawBorder: true,
						    color: ['none',CONFIINDICADORTESTING[1].COLORFONDO,CONFIINDICADORTESTING[2].COLORFONDO]
                        },
                        afterBuildTicks: function(humdaysChart) {
                            humdaysChart.ticks = [];
                            humdaysChart.ticks.push(0);
                            humdaysChart.ticks.push( parseFloat(CONFIINDICADORTESTING[0].VALORFIN) );
                            humdaysChart.ticks.push( parseFloat(CONFIINDICADORTESTING[1].VALORFIN) );
                            humdaysChart.ticks.push(100);
                        }
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
                    {
                        id: 'C',
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
                    {
                        id: 'D',
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


                                
                                if(dataset.yAxisID == "B"){     // KILOS APROBADOS NO CONFORMES
                                    ctx.fillText(valor, model.x , model.y - 5);                                    
                                }else if(dataset.yAxisID == "C"){ // RECHAZADOS

                                    console.log("X",model.x,"Y",model.y);
                                    
                                    // ctx.fillText(valor, model.x, 369);

                                    ctx.fillText(valor, model.x, 509);
                                    // ctx.fillText(valor, model.x , model.y - 5);



                                }else if(dataset.yAxisID == "D"){ // OTROS
                                    ctx.fillText(valor, model.x , model.y - 5);
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

//ARMA GRAFICO INDICADOR
// function setGrafico(chartname, contenedorchart,datos, titulochart = false, mostrarleyenda = false) {



//     //QUITAMOS CANVAS
//     $(`#${chartname}`).remove();
//     $(`#${contenedorchart}`).append(`<canvas id='${chartname}'></canvas>`);

//     var ctx = document.getElementById(chartname).getContext('2d');
       
//     // TITULO
//     let title = {};
//     if(titulochart){
//         title.display = true;
//         title.text = titulochart;
//     }
    

//     // Utils.srand(2);


//     // CREAMOS CHART
//     var mixedChart = new Chart(ctx, {
//         type: 'bar',
//   data: {
//     labels: datos.valorlabels,
//     datasets: [{
//       backgroundColor: "red",
//       data: datos.kgaprobados,
//       datalabels: {
//         align: 'end',
//         anchor: 'start'
//       }
//     }, {
//       backgroundColor: "blue",
//       data:datos.kgaprobadosnoconforme,
//       datalabels: {
//         align: 'center',
//         anchor: 'center'
//       }
//     }, {
//       backgroundColor: "green",
//       data: datos.kgrechazados,
//       datalabels: {
//         anchor: 'end',
//         align: 'start',
//       }
//     }]
//   },
//   options: {
//     plugins: {
//       datalabels: {
//         color: 'white',
//         display: function(context) {
//           return context.dataset.data[context.dataIndex] > 15;
//         },
//         font: {
//           weight: 'bold'
//         },
//         formatter: Math.round
//       }
//     },

//     // Core options
//     aspectRatio: 5 / 3,
//     layout: {
//       padding: {
//         top: 24,
//         right: 16,
//         bottom: 0,
//         left: 8
//       }
//     },
//     elements: {
//       line: {
//         fill: false
//       },
//       point: {
//         hoverRadius: 7,
//         radius: 5
//       }
//     },
//     scales: {
//       xAxes: [{
//         stacked: true
//       }],
//       yAxes: [{
//         stacked: true
//       }]
//     }
//   }
//     });

// }