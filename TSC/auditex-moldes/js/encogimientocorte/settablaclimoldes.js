// ARMA TABLA DE INDICADOR
function setTablaIndicadorCliente(data,tabla,datacantidad){

    DATAPRUEBA = data;


    let cont = 0;
    let cont2 = 0;

    let th = "<tr class='filafija'>";
    let th2 = "<tr class='filafija'>";

    let tr = "";
    let trporcentaje = "";
    let tf = "";
    let titulo = "";
    let valor = "";
    let valorcantidad = "";

    let nombreproveedor = "";
    let nombre = "";
    let rowspan = false;
    let colorfondo      = "#dddddd";
    let colorfondo2     = "#204d86";
    let theadsistema    = "#204d86";

    let TOTALFICHASCLI      = [];
    let TOTALLIBERADASCLI   = [];
    let TOTALPENDIENTESCLI  = [];
    let DATAGENERALFICHAS   = [];
    let concatporcentaje    = false;
    let trgeneral = "";
    let contclienteacumulado = 0;
    let cantfilascliente = 0;
    

    // RECORREMOS FILAS
    for (let key in data) {

        cont++;
        cont2++;
        contclienteacumulado++;

        tr = "<tr>";


        let array = {
            descripcion :"",
            data:[]
        };


        // ARMAMOS CABECERA
        for (let key2 in data[key]) {

            // VALORES UNIDADES
            titulo = key2.replace(/'/g, "");
            valor = data[key][key2];
            valor = valor == null ? 0 : valor;


            // VALORES CANTIDAD
            valorcantidad = datacantidad[key][key2];
            valorcantidad = valorcantidad == null ? 0 : valorcantidad;

            // AGREGAMOS
            if (titulo != "IDTIPO" && titulo != "TIPO" && titulo != "CLIENTE" && titulo != "PROVEEDOR") {
                array.data.push(        
                    {
                        valor,valorcantidad
                    }
                );
            }

            // ARMAMOS CABECERAS
            if (cont == 1) {

                if(titulo != "IDTIPO"){

                    if(titulo == "TIPO"){
                        th += `<th data-prueba='' rowspan='2' class='descripcion' style='text-align:left !important'>DETALLE GENERAL</th>`;
                        
                    }else if(titulo == "PROVEEDOR" || titulo ==  "CLIENTE"){
                        th += `<th data-prueba='' rowspan='2'  class='descripcion' style='text-align:left !important;'>${titulo}</th>`;
                    }else{
                        th += `<th colspan="2" data-prueba='' class='columnas'>${titulo}</th>`;

                        th2 += `<th >FICHA</th>`;
                        th2 += `<th >PRENDA</th>`;
                        

                    }

                }
            }

            // TOTAL FICHAS
            if (cont2 == 1) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO" && titulo != "PROVEEDOR" && titulo != "CLIENTE") {
                    TOTALFICHASCLI.push(valor);
                }

            }

            // TOTAL LIBERADAS
            if (cont2 == 2) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO" && titulo != "PROVEEDOR" && titulo != "CLIENTE") {
                    TOTALLIBERADASCLI.push(valor);
                }

            }

            // TOTAL PENDIENTES
            if (cont2 == 3) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO" && titulo != "PROVEEDOR" && titulo != "CLIENTE") {
                    TOTALPENDIENTESCLI.push(valor);
                }

            }
            

            // DATOS EN LAS FILAS
            if(titulo != "IDTIPO"){

                // let valorcoma = "";

                if(!isNaN(valor)){

                    // UNIDAD
                    let valorcoma = parseFloat(valor);
                    valorcoma = valorcoma.toLocaleString("en-US");
                    tr += `<td data-prueba='' data-color='${colorfondo}' style='background:${colorfondo}'>${ valorcoma }</td>`;

                    // CANTIDAD
                    let valorcomacantidad = parseFloat(valorcantidad);
                    valorcomacantidad = valorcomacantidad.toLocaleString("en-US");
                    tr += `<td data-prueba='' data-color='${colorfondo}' style='background:${colorfondo}'>${ valorcomacantidad }</td>`;


                }else{
                    array.descripcion = valor;
                    
                    let tipo = key2;


                    // ROWSPAN
                    if(titulo == "PROVEEDOR" || titulo == "CLIENTE"){

                        // console.log(contclienteacumulado,cantfilascliente,valor);

                        if(contclienteacumulado == 1){
                            cantfilascliente = data.filter(obj => obj.CLIENTE == valor).length;
                            // cantfilascliente =  (cantfilascliente * 2) - 1;
                            tr += `<td class="align-vertical text-center" rowspan='${(cantfilascliente * 2) - 1}' data-prueba=''  data-color='${colorfondo}' style='background:${colorfondo}'>${ valor }</td>`;
                        }

                        // SI ES UN NUEVO CIENTE
                        if(contclienteacumulado == cantfilascliente){
                            contclienteacumulado = 0;
                        }

                        

                    }else{
                        tr += `<td data-prueba=''  data-color='${colorfondo}' style='text-align:left !important;background:${colorfondo}'>${ valor }</td>`
                    }



                    
                }



                //////////////////////////
                if(titulo == "PROVEEDOR" || titulo == "CLIENTE"){

                    // SI YA CAMBIO DE CLIENTE
                    if( (nombreproveedor != valor && nombreproveedor != "")){


                        // #####################
                        // #### PORCENTAJES ####
                        // #####################

                        // RECORREMOS PORCENTAJES
                        trporcentaje = "";
                        let contdatageneral = 0;
                        cont2 = 0;

                        // console.log("DATAGENERALFICHAS",DATAGENERALFICHAS);

                        for(let j = 0; j < DATAGENERALFICHAS.length; j++){
                            
                            let item = DATAGENERALFICHAS[j];

                            if(contdatageneral >= 1){


                                // % AUDITADOS PENDIENTES
                                trporcentaje += `<tr > `;

                                trporcentaje +=  `<th class='thead-sistema' data-color='${colorfondo2}' style='text-align:left !important'>%  ${item.descripcion} </th> `;

                                for(let i = 0 ; i < DATAGENERALFICHAS[0].data.length; i++){
                                    

                                    // UNIDAD
                                    let porcentaje = DATAGENERALFICHAS[j].data[i].valor / DATAGENERALFICHAS[0].data[i].valor;
                                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                                    porcentaje = porcentaje * 100;
                                    porcentaje = porcentaje.toFixed(2);


                                    trporcentaje += "<td>"+porcentaje+"%</td>";

                                    // CANTIDADA
                                    let porcentajecantidad = DATAGENERALFICHAS[j].data[i].valorcantidad / DATAGENERALFICHAS[0].data[i].valorcantidad;
                                    porcentajecantidad = isNaN(porcentajecantidad) ? 0 : porcentajecantidad;
                                    porcentajecantidad = porcentajecantidad * 100;
                                    porcentajecantidad = porcentajecantidad.toFixed(2);


                                    trporcentaje += "<td>"+porcentajecantidad+"%</td>";
                                }

                                trporcentaje += "</tr>";

                            } 

                            contdatageneral++;

                        }

                        // LIMPIAMOS
                        DATAGENERALFICHAS   = [];
                        TOTALFICHASCLI      = [];
                        TOTALLIBERADASCLI   = [];
                        TOTALPENDIENTESCLI  = [];

                    
                        concatporcentaje = true;

                    }

                    nombreproveedor = valor;
                }
                
            }

            
        }

        // AGREGAMOS DATA
        DATAGENERALFICHAS.push(array);

        tr += "</tr>";

        // SI YA CAMBIO DE CLIENTE
        if(cont == data.length){


            // #####################
            // #### PORCENTAJES ####
            // #####################

            // RECORREMOS PORCENTAJES
            trporcentaje = "";
            let contdatageneral = 0;
            cont2 = 0;

            // console.log("DATAGENERALFICHAS",DATAGENERALFICHAS);

            for(let j = 0; j < DATAGENERALFICHAS.length; j++){
                
                let item = DATAGENERALFICHAS[j];

                if(contdatageneral >= 1){


                    // % AUDITADOS PENDIENTES
                    trporcentaje += `<tr > `;
                    // trporcentaje +=  `<th class='thead-sistema' data-color='${colorfondo2}' style='text-align:left !important'>%  ${nombreproveedor} </th> `;
                    trporcentaje +=  `<th class='thead-sistema' data-color='${colorfondo2}' style='text-align:left !important'>%  ${item.descripcion} </th> `;

                    for(let i = 0 ; i < DATAGENERALFICHAS[0].data.length; i++){
                        
                        // UNIDAD
                        let porcentaje = DATAGENERALFICHAS[j].data[i].valor / DATAGENERALFICHAS[0].data[i].valor;
                        porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                        porcentaje = porcentaje * 100;
                        porcentaje = porcentaje.toFixed(2);


                        trporcentaje += "<td>"+porcentaje+"%</td>";

                        // CANTIDADA
                        let porcentajecantidad = DATAGENERALFICHAS[j].data[i].valorcantidad / DATAGENERALFICHAS[0].data[i].valorcantidad;
                        porcentajecantidad = isNaN(porcentajecantidad) ? 0 : porcentajecantidad;
                        porcentajecantidad = porcentajecantidad * 100;
                        porcentajecantidad = porcentajecantidad.toFixed(2);


                        trporcentaje += "<td>"+porcentajecantidad+"%</td>";
                    }

                    trporcentaje += "</tr>";

                } 

                contdatageneral++;

            }

            concatporcentaje = true;

        }


        // ASIGNAMOS PORCENTAJE
        if (concatporcentaje) {

            if(cont == data.length){
                trgeneral += tr;
                trgeneral += trporcentaje;
            }else{
                trgeneral += trporcentaje;
                trgeneral += tr;
            }

            

            trporcentaje = "";
            concatporcentaje = false;

        }else{
            trgeneral += tr;
        }


        
    }

    th  += "</tr>";
    th2 += "</tr>";

    th += th2;

    // ASIGNAMOS VALORES
    $(`#thead${tabla}`).html(th);
    $(`#tbody${tabla}`).html(trgeneral);
    

}