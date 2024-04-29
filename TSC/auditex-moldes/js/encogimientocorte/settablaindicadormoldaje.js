// ARMA TABLA DE INDICADOR
function setTablaIndicador(data,tabla,datacantidad){


    // TOTALES - UNIDAD
    TOTALLIBERADASPORCENTAJE = [];
    TOTALPENDIENTESPORCENTAJE = [];

    // TOTALES - CANTIDAD
    TOTALLIBERADASPORCENTAJE_CANT   = [];
    TOTALPENDIENTESPORCENTAJE_CANT  = [];


    // UNIDADES
    TOTALFICHAS = [];
    TOTALLIBERADAS = [];
    TOTALPENDIENTES = [];

    // CANTIDADES
    TOTALFICHAS_CANT = [];
    TOTALLIBERADAS_CANT = [];
    TOTALPENDIENTES_CANT = [];


    DATAGENERAL             = [];
    DATAGENERAL_CANT        = [];


    let cont = 0;

    let th = "<tr class='filafija'>";

    let th2 = "<tr class='filafija'>";

    let tr = "";
    let tf = "";
    let titulo = "";
    let valor = "";
    let valorcantidad = "";
    let colorfondo        = "#dddddd";
    let colorfondo2       = "#204d86";


    for (let key in data) {
        cont++;

        if(cont >= 4){
            tr += "<tr class='filasocultas d-none'>";
        }else{
            tr += "<tr>";
        }


        let array = {
            descripcion :"",
            data:[]
        };

        // RECORREMOS LISTA
        for (let key2 in data[key]) {

            // VALORES
            titulo = key2.replace(/'/g, "");

            // VALOR UNIDAD
            valor = data[key][key2];
            valor = valor == null ? 0 : valor;

            // VALOR CANTIDAD
            valorcantidad = datacantidad[key][key2];
            valorcantidad = valorcantidad == null ? 0 : valorcantidad;

            // AGREGAMOS
            if (titulo != "IDTIPO" && titulo != "TIPO") {
                
                array.data.push(
                {
                    valor,
                    valorcantidad
                });
            }


            // ARMAMOS CABECERA
            if (cont == 1) {

                if(titulo != "IDTIPO"){
                    if(titulo == "TIPO"){
                        th += `<th nowrap rowspan='2' class='descripcion' style='text-align:left !important'>DETALLE GENERAL</th>`;
                        
                    }else{
                        th += `<th nowrap class='columnas' colspan='2' >${titulo}</th>`;

                        th2 += `
                            <th   >FICHA</th>
                            <th   >PRENDA</th>
                        `;

                    }
                }

                // AGREGAMOS TITULOS
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    LABELS.push(titulo);
                }

                // AGREGAMOS TOTAL DE FICHAS
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALFICHAS.push(valor);
                }
            
            }

            
            // TOTAL LIBERADAS
            if (cont == 2) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALLIBERADAS.push(valor);
                }

            }

            // TOTAL PENDIENTES
            if (cont == 3) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALPENDIENTES.push(valor);
                }

            }

            if(titulo != "IDTIPO"){

                if(!isNaN(valor)){

                    // UNIDAD
                    let valorcoma = parseFloat(valor);
                    valorcoma = valorcoma.toLocaleString("en-US");
                    tr += `<td nowrap>${ valorcoma }</td>`;

                    // CANTIDAD
                    let valorcomacantidad = parseFloat(valorcantidad);
                    valorcomacantidad = valorcomacantidad.toLocaleString("en-US");

                    tr += `<td nowrap>${ valorcomacantidad }</td>`;
                }else{

                    array.descripcion = valor;

                    let theadcolor = cont >= 4 ? "thead-sistema-3" : "thead-sistema-2";
                    let bold = cont <= 3 ? "font-weight-bold" : "";


                    if(valor == "TOTAL. PENDIENTES"){
                        tr += `
                        <td nowrap class='${theadcolor} ${bold}' data-color='${colorfondo}' style='text-align:left !important'>
                            ${ valor } <button class='btn btn-sm btn-primary p-0 float-right' type='button' id="btnmostrarfilas"> Mostrar </button>
                        </td>`;
                    }else{
                        tr += `<td nowrap class='${theadcolor} ${bold}' data-color='${colorfondo}' style='text-align:left !important'>${ valor }</td>`;
                    }

                    // tr += `<td nowrap class='thead-sistema-2' data-color='${colorfondo}' style='text-align:left !important'>${ valor }</td>`;

                }

                
            }
        }


        // AGREGAMOS DATA
        DATAGENERAL.push(array);

        tr += "</tr>";


    }

    th += "</tr>";
    th2 += "</tr>";

    th += th2;


    // #####################
    // #### PORCENTAJES ####
    // #####################

    // RECORREMOS PORCENTAJES
    let contdatageneral = 0;
    for(let j = 0; j < DATAGENERAL.length; j++){
        
        let item = DATAGENERAL[j];

        if(contdatageneral >= 1){

            let ocultar = contdatageneral >= 3 ? "filasocultas d-none" : "";

            // % AUDITADOS PENDIENTES
            tr += `<tr class='${ocultar}' > `;
            tr +=  `<th nowrap class='thead-sistema' data-color='${colorfondo2}' style='text-align:left !important'>%  ${item.descripcion} </th> `;

            for(let i = 0 ; i < DATAGENERAL[0].data.length; i++){
                
                // PORCENTAJE UNIDADES
                let porcentaje = DATAGENERAL[j].data[i].valor / DATAGENERAL[0].data[i].valor;
                porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                porcentaje = porcentaje * 100;
                porcentaje = porcentaje.toFixed(2);

                // PORCENTAJES CANTIDADES
                let porcentajecantidad = DATAGENERAL[j].data[i].valorcantidad / DATAGENERAL[0].data[i].valorcantidad;
                porcentajecantidad = isNaN(porcentajecantidad) ? 0 : porcentajecantidad;
                porcentajecantidad = porcentajecantidad * 100;
                porcentajecantidad = porcentajecantidad.toFixed(2);


                // LIBERADAS
                if(contdatageneral == 1){
                    TOTALLIBERADASPORCENTAJE.push(porcentaje);
                }

                // PENDIENTES
                if(contdatageneral == 2){
                    TOTALPENDIENTESPORCENTAJE.push(porcentaje);
                }


                tr += "<td>"+porcentaje+"%</td>";
                tr += "<td>"+porcentajecantidad+"%</td>";

            }

            tr += "</tr>";

        } 

        contdatageneral++;

    }


    
    // % AUDITADOS LIBERADAS
    // tr += "<tr>";
    //     tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important'>% LIBERADAS</th>";
    //     for(let i = 0 ; i < TOTALFICHAS.length; i++){
    //         let porcentaje = TOTALLIBERADAS[i] / TOTALFICHAS[i];
    //         porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
    //         porcentaje = porcentaje * 100;
    //         porcentaje = porcentaje.toFixed(2);

    //         let color = getColorBackandFontIndicadores(CONFIINDICADORTESTING,porcentaje);


    //         // ASIGNAMOS COLORES AL GRAFICO
    //         BACKCOLORGRAFICO.push("#28a745");

            

    //         // AGREGAMOS
    //         TOTALLIBERADASPORCENTAJE.push(porcentaje);

    //         tr += `<td data-color='${color.backcolor}' style='background:${color.backcolor};color:${color.fontcolor}' >${porcentaje}%</td>`;
            
    //     }
    // tr += "</tr>";

    // // % AUDITADOS PENDIENTES
    // tr += "<tr>";
    //     tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important'>% PENDIENTES</th>";
    //     for(let i = 0 ; i < TOTALFICHAS.length; i++){
    //         let porcentaje = TOTALPENDIENTES[i] / TOTALFICHAS[i];
    //         porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
    //         porcentaje = porcentaje * 100;
    //         porcentaje = porcentaje.toFixed(2);

    //         TOTALPENDIENTESPORCENTAJE.push(porcentaje);


    //         tr += "<td>"+porcentaje+"%</td>";
    //     }
    // tr += "</tr>";

    // ASIGNAMOS VALORES
    $(`#thead${tabla}`).html(th);
    $(`#tbody${tabla}`).html(tr);
    // $(`#tfoot${tabla}`).html(tf);

    // ARMAMOS GRAFICO
    setGrafico("chartgeneral","chartgeneralcontainer",{
        valorlabels:LABELS,
        liberadas:TOTALLIBERADASPORCENTAJE,
        pendientes:TOTALPENDIENTESPORCENTAJE,
        // kgrechazados:TOTALKGRECHPORCENTAJE,
        // kgotros:TOTALKGOTROSPORCENTAJE

    },false,true);

}