// ARMA TABLA DE INDICADOR
function setTablaIndicador(data,tabla){

    let cont = 0;
    let th = "<tr>";
    let tr = "";
    let tf = "";
    let titulo = "";
    let valor = "";

    for (let key in data) {
        cont++;
        tr += "<tr>";
        // ARMAMOS CABECERA
        for (let key2 in data[key]) {

            // VALORES
            titulo = key2.replace(/'/g, "");
            valor = data[key][key2];
            valor = valor == null ? 0 : valor;


            // FICHAS TOTALES
            if (cont == 1) {

                if(titulo != "IDTIPO"){
                    if(titulo == "TIPO"){
                        // th += `<th nowrap style='text-align:left !important'>${titulo}</th>`;
                        th += `<th nowrap style='text-align:left !important'>DETALLE GENERAL</th>`;
                        
                    }else{
                        th += `<th nowrap>${titulo}</th>`;
                    }
                }

                // AGREGAMOS TITULOS
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    LABELS.push(titulo);
                }

                // AGREGAMOS VALORES PROGRAMADO
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    FICHASTOTALES.push(valor);
                }
            }

            // FICHAS DEPURADAS
            if (cont == 2) {
                // AGREGAMOS VALORES PROGRAMADO
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    PRENDASDEPURADAS.push(valor);
                }
            }

            // PRENDAS SEGUNDAS
            if (cont == 3) {
                // AGREGAMOS VALORES PROGRAMADO
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    PRENDASSEGUNDAS.push(valor);
                }
            }

            // PRENDAS DESPACHADAS
            if (cont == 4) {
                // AGREGAMOS VALORES PROGRAMADO
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    PRENDASDESPACHADAS.push(valor);
                }
            }

            if(titulo != "IDTIPO"){
                // let valorcoma = "";
                if(!isNaN(valor)){
                    let valorcoma = parseFloat(valor);
                    valorcoma = valorcoma.toLocaleString("en-US");
                    tr += `<td nowrap>${ valorcoma }</td>`;
                }else{
                    tr += `<td nowrap class='thead-sistema-2' style='text-align:left !important'>${ valor }</td>`;

                }
                
            }
        }

        tr += "</tr>";


    }

    // % DE PRRENDAS POR DEPURADAR
    th += "</tr>";
    tf = "<tr><th nowrap class='thead-sistema'  style='text-align:left !important'>% Prendas por Depurar </th>";
    // OBTENEMOS VALOR DE PORCENTAJE
    for (let i = 0; i < PRENDASDEPURADAS.length; i++) {
        let valor = PRENDASDESPACHADAS[i] > 0 ? Math.round(((PRENDASDEPURADAS[i] / PRENDASDESPACHADAS[i]) * 100)) : 0;
        // ASIGNAMOS COLORES A LA TABLA
        let color = getColorBackandFontIndicadores(CONFIINDICADORPORDEPURAR,valor);
        // ASIGNAMOS COLORES AL GRAFICO
        BACKCOLORGRAFICO.push(color.backcolor);
        tf += `<th style='background:${color.backcolor};color:${color.fontcolor}' >${ valor }%</th>`;
        PRENDASPORDEPURARPOR.push(valor);
    }
    tf +="</tr>";

     // % DE PRRENDAS POR DEPURADAR
     tf += "<tr><th nowrap class='thead-sistema'  style='text-align:left !important'>% Prendas Depuradas </th>";
     // OBTENEMOS VALOR DE PORCENTAJE
     for (let i = 0; i < PRENDASSEGUNDAS.length; i++) {

        let valor = PRENDASDESPACHADAS[i] > 0 ? ((PRENDASSEGUNDAS[i] / PRENDASDESPACHADAS[i]) * 100) : 0;
        valor = valor.toFixed(2);

        let color = getColorBackandFontIndicadores(CONFIINDICADORDEPURADAS,valor);
        tf += `<th style='background:${color.backcolor};color:${color.fontcolor}' >${valor}%</th>`;
        PRENDASDEPURADASPOR.push(valor);

     }
     tf +="</tr>";

    // ASIGNAMOS VALORES
    $(`#thead${tabla}`).html(th);
    $(`#tbody${tabla}`).html(tr);
    $(`#tfoot${tabla}`).html(tf);

    // ARMAMOS GRAFICO
    setGrafico("chartgeneral","chartgeneralcontainer",PRENDASPORDEPURARPOR,PRENDASDEPURADASPOR,LABELS,false,true);

}