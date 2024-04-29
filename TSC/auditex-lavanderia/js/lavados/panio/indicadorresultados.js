// GET DATOS INDICADOR
async function getDatosIndicador(fecha,sede,tiposervicio,taller){


    let responseanios = await get("auditex-lavanderia","lavadopanio","get-indicador-resultados",{ 
        opcion:1,fecha,sede,tiposervicio,taller
    });

    let responsemeses = await get("auditex-lavanderia","lavadopanio","get-indicador-resultados",{ 
        opcion:2,fecha,sede,tiposervicio,taller
    });

    let responsesemanas = await get("auditex-lavanderia","lavadopanio","get-indicador-resultados",{ 
        opcion:3,fecha,sede,tiposervicio,taller
    });

    let dataconcat  = [].concat(responseanios,responsemeses,responsesemanas);

    // ###############
    // ### PARETOS ###
    // ###############

        // ### NIVEL 1

        // NIVEL 1 - SEMANA
        let datapareto1     = await getParetos(1,null,fecha,sede,tiposervicio,taller);
        let responsepareto1 = formatDataIndicadores(datapareto1,"DSCFAMILIA","CANTIDAD","CODFAMILIA");
        datopareto1 = setGraficoParetosGeneral("chartpareto1",responsepareto1,false,true);

        // NIVEL 2 - MES
        let datapareto2     = await getParetos(2,null,fecha,sede,tiposervicio,taller);
        let responsepareto2 = formatDataIndicadores(datapareto2,"DSCFAMILIA","CANTIDAD","CODFAMILIA");
        datopareto2 = setGraficoParetosGeneral("chartpareto2",responsepareto2,false,true);

        // #### NIVEL 2 

        // NIVEL 2 - PRIMER MAYOR DEFECTO - SEMANA
        let datapareto3     = await getParetos(3,responsepareto1.mayor1,fecha,sede,tiposervicio,taller); 
        let responsepareto3 = formatDataIndicadores(datapareto3,"DESDEF","CANTIDAD","CODDEF");
        datopareto3 = setGraficoParetosGeneral("chartpareto3",responsepareto3,false,true,responsepareto1.total);

        // console.log(datopareto3,"datapareto");


        primermayodefecto1 = responsepareto1.mayor1des + " (1er Mayor Defecto)";
        $("#lblpareto3").text(primermayodefecto1);

        // NIVEL 2 - SEGUNDO MAYOR DEFECTO - SEMANA
        let datapareto4     = await getParetos(3,responsepareto1.mayor2,fecha,sede,tiposervicio,taller); 
        let responsepareto4 = formatDataIndicadores(datapareto4,"DESDEF","CANTIDAD","CODDEF");
        datopareto4 = setGraficoParetosGeneral("chartpareto4",responsepareto4,false,true,responsepareto1.total);
        segundomayodefecto1 = responsepareto1.mayor2des + " (2do Mayor Defecto)";
        $("#lblpareto4").text(segundomayodefecto1);


        // NIVEL 2 - PRIMER MAYOR DEFECTO - MES
        let datapareto5     = await getParetos(4,responsepareto2.mayor1,fecha,sede,tiposervicio,taller); 
        let responsepareto5 = formatDataIndicadores(datapareto5,"DESDEF","CANTIDAD","CODDEF");
        datopareto5 = setGraficoParetosGeneral("chartpareto5",responsepareto5,false,true,responsepareto2.total);
        primermayodefecto2 = responsepareto2.mayor1des + " (1er Mayor Defecto)";
        $("#lblpareto5").text(primermayodefecto2);


        // NIVEL 2 - SEGUNDO MAYOR DEFECTO - MES
        let datapareto6     = await getParetos(4,responsepareto2.mayor2,fecha,sede,tiposervicio,taller); 
        let responsepareto6 = formatDataIndicadores(datapareto6,"DESDEF","CANTIDAD","CODDEF");
        datopareto6 = setGraficoParetosGeneral("chartpareto6",responsepareto6,false,true,responsepareto2.total);
        segundomayodefecto2 = responsepareto2.mayor2des + " (2do Mayor Defecto)";
        $("#lblpareto6").text(segundomayodefecto2);

        
        setTableIndicador(dataconcat);


}   

// ARMAR TABLA
function setTableIndicador(data){

    // ##############################
    // ### VARIABLES PARA GRAFICO ###
    // ##############################
    TITULOS = [];

    APROBADAS_CANT = [];
    RECHAZADAS_CANT = [];
    TOTAL_CANT = [];
    APROBADAS_CANT_POR = [];
    APROBADAS_CANT_POR2 = [];
    RECHAZADAS_CANT_POR = [];

    APROBADAS_PREN = [];
    RECHAZADAS_PREN = [];
    TOTAL_PREN = [];
    APROBADAS_PREN_POR = [];
    RECHAZADAS_PREN_POR = [];
    BACKCOLORGRAFICO = [];

    // CABECERA
    let tr = "<tr>";
    tr += "<th style='min-width:100px'>DETALLE GENERAL</th>";
    for(let item of data){
        TITULOS.push(item.COLUMNA);
        tr += `<th style='min-width:80px' class="text-center">${item.COLUMNA}</th>`;
    }
    tr += "</tr>";

    $("#theadindicador").html(tr);




    // ###############
    // ### DETALLE ###
    // ###############

    // CANTIDAD
    let traprobadas = "";
    let trrechazadas = "";
    let trauditadas = "";


    let trporcentajeaprobadas = "";
    let trporcentajerechazadas = "";

    // PRENDAS
    let traprobadas_cant = "";
    let trrechazadas_cant = "";
    let trauditadas_cant = "";

    let trporcentajeapro_cant = "";
    let trporcentajerecha_cant = "";



    // CANTIDAD
    traprobadas += "<tr> <th class='border-table thead-sistema-3 '># AUD. APROB. 1RA</th>";
    trrechazadas += "<tr> <th class='border-table thead-sistema-3'># AUD. RECH.</th>";
    trauditadas += "<tr> <th class='border-table thead-sistema-3'># AUDITORIAS</th>";

    trporcentajeaprobadas += "<tr> <th class='border-table thead-sistema'>% APRO. 1RA</th>";
    trporcentajerechazadas += "<tr> <th class='border-table thead-sistema'>% RECH.</th>";

    // PRENDAS
    traprobadas_cant += "<tr> <th class='border-table thead-sistema-3'>PREND. APROB. 1RA</th>";
    trrechazadas_cant += "<tr> <th class='border-table thead-sistema-3'>PREND. RECH.</th>";
    trauditadas_cant += "<tr> <th class='border-table thead-sistema-3'>TOTAL PRENDAS</th>";

    trporcentajeapro_cant += "<tr> <th class='border-table thead-sistema'>% APRO. 1RA</th>";
    trporcentajerecha_cant += "<tr> <th class='border-table thead-sistema'>% RECH.</th>";




    for(let item of data){
    

        // CANTIDAD
        traprobadas += `<td class="text-center border-table bg-white">${format_miles(item.APROBADO)}</td>`;
        trrechazadas += `<td class="text-center border-table bg-white">${format_miles(item.RECHAZADO)}</th>`;
        trauditadas += `<td class="text-center border-table bg-white">${format_miles(item.TOTAL)}</td>`;

        // PORCENTAJE APROBADAS
        let porcentaje_a = parseFloat(item.APROBADO) / parseFloat(item.TOTAL);
        porcentaje_a = porcentaje_a * 100;
        let color = getColorBackandFontIndicadores(CONFIINDICADOR,porcentaje_a.toFixed(2));
        // console.log(color);


        trporcentajeaprobadas += `<td class="text-center border-table" style='background:${color.backcolor};color:${color.fontcolor}'>${porcentaje_a.toFixed(2)}%</td>`;
        BACKCOLORGRAFICO.push(color.backcolor);

        // PORCENTAJE RECHAZADAS
        let porcentaje_r = parseFloat(item.RECHAZADO) / parseFloat(item.TOTAL);
        porcentaje_r = porcentaje_r * 100;

        trporcentajerechazadas += `<td class="text-center border-table bg-white">${porcentaje_r.toFixed(2)}%</td>`;


        // PRENDAS
        traprobadas_cant += `<td class="text-center border-table bg-white">${format_miles(item.CANTAPROBADA)}</td>`;
        trrechazadas_cant += `<td class="text-center border-table bg-white">${format_miles(item.CANTRECHAZADO)}</th>`;
        trauditadas_cant += `<td class="text-center border-table bg-white">${format_miles(item.CANTTOTAL)}</td>`;

        // PORCENTAJE APROBADAS
        let porcentaje_p = parseFloat(item.CANTAPROBADA) / parseFloat(item.CANTTOTAL);
        porcentaje_p = porcentaje_p * 100;

        trporcentajeapro_cant += `<td class="text-center border-table bg-white">${porcentaje_p.toFixed(2)}%</td>`;


        // PORCENTAJE RECHAZADAS
        let porcentaje_pr = parseFloat(item.CANTRECHAZADO) / parseFloat(item.CANTTOTAL);
        porcentaje_pr = porcentaje_pr * 100;

        trporcentajerecha_cant += `<td class="text-center border-table bg-white">${porcentaje_pr.toFixed(2)}%</td>`;


        // AGREGAMOS EN ARRAYS
        APROBADAS_CANT.push(format_miles(item.APROBADO));
        RECHAZADAS_CANT.push(format_miles(item.RECHAZADO));
        TOTAL_CANT.push(format_miles(item.TOTAL));
        APROBADAS_CANT_POR.push(
            {
                valor:porcentaje_a.toFixed(2),backcolor:color.backcolor,fontcolor:color.fontcolor
            }
        );


        APROBADAS_CANT_POR2.push(porcentaje_a.toFixed(2));
        RECHAZADAS_CANT_POR.push(porcentaje_r.toFixed(2));


        APROBADAS_PREN.push(format_miles(item.CANTAPROBADA));
        RECHAZADAS_PREN.push(format_miles(item.CANTRECHAZADO));
        TOTAL_PREN.push(format_miles(item.CANTTOTAL));
        APROBADAS_PREN_POR.push(porcentaje_p.toFixed(2));
        RECHAZADAS_PREN_POR.push(porcentaje_pr.toFixed(2));


    }

    // CANTIDAD
    traprobadas += "</tr>";
    trrechazadas += "</tr>";
    trauditadas += "</tr>";

    trporcentajeaprobadas += "</tr>";
    trporcentajerechazadas += "</tr>";

        // PRENDAS
    traprobadas_cant += "</tr>";
    trrechazadas_cant += "</tr>";
    trauditadas_cant += "</tr>";

    trporcentajeapro_cant += "</tr>";
    trporcentajerecha_cant += "</tr>";

    // trporcentaje += "</tr>";


    setGrafico("chartgeneral",
        {
            aprobadas:APROBADAS_CANT_POR2,
            rechazadas:RECHAZADAS_CANT_POR ,
            labels:TITULOS
        }
    );


    $("#tbodyindicador").html(traprobadas+trrechazadas+trauditadas+trporcentajeaprobadas+trporcentajerechazadas+traprobadas_cant+trrechazadas_cant+trauditadas_cant+trporcentajeapro_cant+trporcentajerecha_cant);

}

// //ARMA GRAFICO INDICADOR
function setGrafico(chartname,datos, titulochart = false, mostrarleyenda = false) {


    //QUITAMOS CANVAS
    // $(`#${chartname}`).remove();
    // $(`#${contenedorchart}`).append(`<canvas id='${chartname}'></canvas>`);

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
                    label: 'Aud. aprobadas 1ra',
                    data: datos.aprobadas,
                    order: 1,
                    backgroundColor: BACKCOLORGRAFICO,
                },
                {
                    label: 'Aud. Rechazadas',
                    data: datos.rechazadas,
                    type: 'line',
                    fill: false,
                    yAxisID: 'B',
                    lineTension: 0,  
                    // backgroundColor: 'yellow',
                    // borderColor: '#ccccc',
                    borderColor: '#333631',

                    borderWidth: 3,
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
                        id: 'A',
                        type: 'linear',
                        position: 'left',
                        ticks: {
                            min: 0,
                            max: 120,
                            stepSize: 1,
                            display:true

                        },
                        gridLines: {
                            display: true,
                            drawBorder: true,
                            color: ['none',CONFIINDICADOR[1].COLORFONDO,CONFIINDICADOR[2].COLORFONDO]
                        },
                        afterBuildTicks: function(humdaysChart) {
                            humdaysChart.ticks = [];
                            humdaysChart.ticks.push(0);
                            humdaysChart.ticks.push( parseFloat(CONFIINDICADOR[0].VALORFIN) );
                            humdaysChart.ticks.push( parseFloat(CONFIINDICADOR[1].VALORFIN) );
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


                                
                                // if(dataset.yAxisID == "B"){     // KILOS APROBADOS NO CONFORMES
                                    ctx.fillText(valor, model.x , model.y - 5);                                    
                                // }
                                // else if(dataset.yAxisID == "C"){ // RECHAZADOS

                                //     console.log("X",model.x,"Y",model.y);
                                    
                                //     // ctx.fillText(valor, model.x, 369);

                                //     ctx.fillText(valor, model.x, 359);


                                // }else if(dataset.yAxisID == "D"){ // OTROS
                                //     ctx.fillText(valor, model.x , model.y - 5);
                                // }else{
                                //     ctx.fillText(valor, model.x, model.y - 5);                                    
                                // }


                            }
                        }


                    });
                }
            }
        }
    });

}


// TRAE DATOS PARETOS
async function getParetos(opcion,idfamdefecto,fecha,sede,tiposervicio,taller){

    try{

        return await  get("auditex-lavanderia","lavadopanio","get-indicador-resultados-defectos",{
            opcion,idfamdefecto,fecha,sede,tiposervicio,taller
        });


    }catch(error){
        Advertir("Ocurrio un error al obtener datos del pareto " + opcion);
        console.log(error);
    }

}