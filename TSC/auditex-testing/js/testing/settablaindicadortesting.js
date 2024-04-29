// ARMA TABLA DE INDICADOR
function setTablaIndicador(data,tabla){

    // KILOS
    TOTALKG = [];
    TOTALKGAPRO = [];
    TOTALKGAPRONOCON = [];
    TOTALKGRECH = [];
    TOTALKGOTROS = [];

    // UNIDADES
    TOTALAUD = [];
    TOTALAUDAPRO = [];
    TOTALAUDAPRONOCON = [];
    TOTALAUDRECH = [];
    TOTALAUDOTROS = [];

    // PORCENTAJE
    TOTALKGPORCENTAJE           = [];
    TOTALKGAPROPORCENTAJE       = [];
    TOTALKGAPRONOCONPORCENTAJE  = [];
    TOTALKGRECHPORCENTAJE       = [];
    TOTALKGOTROSPORCENTAJE      = [];


    let cont = 0;
    let th = "<tr>";
    let tr = "";
    let tf = "";
    let titulo = "";
    let valor = "";
    let colorfondo        = "#dddddd";
    let colorfondo2       = "#204d86";


    for (let key in data) {
        cont++;
        tr += "<tr>";
        // ARMAMOS CABECERA
        for (let key2 in data[key]) {

            // VALORES
            titulo = key2.replace(/'/g, "");
            valor = data[key][key2];
            valor = valor == null ? 0 : valor;


            // TOTAL DE KILOS
            if (cont == 1) {

                if(titulo != "IDTIPO"){
                    if(titulo == "TIPO"){
                        th += `<th nowrap style='text-align:left !important'>DETALLE GENERAL</th>`;
                        
                    }else{
                        th += `<th nowrap>${titulo}</th>`;
                    }
                }

                // AGREGAMOS TITULOS
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    LABELS.push(titulo);
                }

                // AGREGAMOS TOTAL DE KILOS
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALKG.push(valor);
                }
            }

            // TOTAL DE KILOS APROBADOS
            if (cont == 2) {

                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALKGAPRO.push(valor);
                }
            }

            // TOTAL DE KILOS APROBADOS NO CONFORMES
            if (cont == 3) {

                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALKGAPRONOCON.push(valor);
                }
            }

            // TOTAL DE KG RECHAZADOS
            if (cont == 4) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALKGRECH.push(valor);
                }
            }

            // TOTAL DE KG OTROS
            if (cont == 5) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALKGOTROS.push(valor);
                }

            }

            // TOTAL PARTIDAS
            if (cont == 6) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALPARTIDAS.push(valor);
                }

            }
            
            // TOTAL AUDITADOS
            if (cont == 7) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALAUD.push(valor);
                }

            }

            // TOTAL AUDITADOS APROBADOS
            if (cont == 8) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALAUDAPRO.push(valor);
                }

            }

            // TOTAL AUDITADOS APROBADOS NO CONFORME
            if (cont == 9) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALAUDAPRONOCON.push(valor);
                }

            }

            // TOTAL AUDITADOS RECHAZADOS
            if (cont == 10) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALAUDRECH.push(valor);
                }

            }

            // TOTAL AUDITADOS OTROS
            if (cont == 11) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO") {
                    TOTALAUDOTROS.push(valor);
                }

            }

            if(titulo != "IDTIPO"){
                // let valorcoma = "";
                if(!isNaN(valor)){
                    let valorcoma = parseFloat(valor);
                    valorcoma = valorcoma.toLocaleString("en-US");
                    tr += `<td nowrap>${ valorcoma }</td>`;
                }else{
                    tr += `<td nowrap class='thead-sistema-2' data-color='${colorfondo}' style='text-align:left !important'>${ valor }</td>`;

                }
                
            }
        }

        tr += "</tr>";


        // PORCENTAJES KILOS
        if(cont == 5){

            // % KG APROBADOS
            tr += "<tr>";
                tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important'>% KG. APROBADOS</th>";
                for(let i = 0 ; i < TOTALKG.length; i++){
                    let porcentaje = TOTALKGAPRO[i] / TOTALKG[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);

                    // ASIGNAMOS COLORES A LA TABLA
                    let color = getColorBackandFontIndicadores(CONFIINDICADORTESTING,porcentaje);
                    // ASIGNAMOS COLORES AL GRAFICO
                    BACKCOLORGRAFICO.push(color.backcolor);

                    // AGREGAMOS
                    TOTALKGAPROPORCENTAJE.push(porcentaje);

                    // tr += "<td>"+porcentaje+"%</td>";
                    tr += `<td data-color='${color.backcolor}' style='background:${color.backcolor};color:${color.fontcolor}' >${porcentaje}%</td>`;
                }
            tr += "</tr>";

            // % KG APROBADOS NO CONFORME
            tr += "<tr>";
                tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important'>% KG. APRO. NO CON.</th>";
                for(let i = 0 ; i < TOTALKG.length; i++){
                    let porcentaje = TOTALKGAPRONOCON[i] / TOTALKG[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);

                    // AGREGAMOS
                    TOTALKGAPRONOCONPORCENTAJE.push(porcentaje);

                    tr += "<td>"+porcentaje+"%</td>";
                }
            tr += "</tr>";

            // % KG RECHAZADOS
            tr += "<tr>";
                tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important'>% KG. RECHAZADOS</th>";
                for(let i = 0 ; i < TOTALKG.length; i++){
                    let porcentaje = TOTALKGRECH[i] / TOTALKG[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);

                    // AGREGAMOS
                    TOTALKGRECHPORCENTAJE.push(porcentaje);

                    tr += "<td>"+porcentaje+"%</td>";
                }
            tr += "</tr>";

            // % KG OTROS
            tr += "<tr>";
                tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important;border-bottom: 2px solid black'>% KG. OTROS (En Evaluación)</th>";
                for(let i = 0 ; i < TOTALKG.length; i++){
                    let porcentaje = TOTALKGOTROS[i] / TOTALKG[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);

                    // AGREGAMOS
                    TOTALKGOTROSPORCENTAJE.push(porcentaje);

                    tr += "<td style='border-bottom: 2px solid black'>"+porcentaje+"%</td>";
                }
            tr += "</tr>";

        }

        // PORCENTAJES AUDITADOS
        if(cont == 11){

            // % AUDITADOS APROBADOS
            tr += "<tr>";
                tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important'>% AUD. APROBADOS</th>";
                for(let i = 0 ; i < TOTALPARTIDAS.length; i++){
                    let porcentaje = TOTALAUDAPRO[i] / TOTALPARTIDAS[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);

                    let color = getColorBackandFontIndicadores(CONFIINDICADORTESTING,porcentaje);
                    tr += `<td data-color='${color.backcolor}' style='background:${color.backcolor};color:${color.fontcolor}' >${porcentaje}%</td>`;
                    // tr += "<td>"+porcentaje+"%</td>";
                    
                }
            tr += "</tr>";

            // % AUDITADOS APROBADOS NO CONFORME
            tr += "<tr>";
                tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important'>% AUD. APRO. NO CON.</th>";
                for(let i = 0 ; i < TOTALPARTIDAS.length; i++){
                    let porcentaje = TOTALAUDAPRONOCON[i] / TOTALPARTIDAS[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);
                    tr += "<td>"+porcentaje+"%</td>";
                }
            tr += "</tr>";

            // % AUDITADOS RECHAZADOS
            tr += "<tr>";
                tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important'>% AUD. RECHAZADOS</th>";
                for(let i = 0 ; i < TOTALPARTIDAS.length; i++){
                    let porcentaje = TOTALAUDRECH[i] / TOTALPARTIDAS[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);
                    tr += "<td>"+porcentaje+"%</td>";
                }
            tr += "</tr>";

            // % AUDITADOS OTROS
            tr += "<tr>";
                tr += "<th nowrap class='thead-sistema' data-color='"+colorfondo2+"' style='text-align:left !important'>% AUD. OTROS (En Evaluación)</th>";
                for(let i = 0 ; i < TOTALPARTIDAS.length; i++){
                    let porcentaje = TOTALAUDOTROS[i] / TOTALPARTIDAS[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);
                    tr += "<td>"+porcentaje+"%</td>";
                }
            tr += "</tr>";

        }


    }

    th += "</tr>";

    // ASIGNAMOS VALORES
    $(`#thead${tabla}`).html(th);
    $(`#tbody${tabla}`).html(tr);
    // $(`#tfoot${tabla}`).html(tf);

    // ARMAMOS GRAFICO
    setGrafico("chartgeneral","chartgeneralcontainer",{
        valorlabels:LABELS,
        kgaprobados:TOTALKGAPROPORCENTAJE,
        kgaprobadosnoconforme:TOTALKGAPRONOCONPORCENTAJE,
        kgrechazados:TOTALKGRECHPORCENTAJE,
        kgotros:TOTALKGOTROSPORCENTAJE

    },false,true);

}