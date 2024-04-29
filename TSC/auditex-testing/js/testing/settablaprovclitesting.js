// ARMA TABLA DE INDICADOR
function setTablaIndicadorProveedor(data,tabla){



    let cont = 0;
    let cont2 = 0;

    let th = "<tr>";
    let tr = "";
    let tf = "";
    let titulo = "";
    let valor = "";
    let nombreproveedor = "";
    let nombre = "";
    let rowspan = false;
    let colorfondo      = "#dddddd";
    let theadsistema    = "#204d86";


    TOTALPROVEDORESKG = [];
    TOTALPROVEDORESKGAPRO = [];
    TOTALPROVEDORESKGAPRONOCON = [];
    TOTALPROVEDORESKGRECH = [];
    TOTALPROVEDORESKGOTROS = [];

    for (let key in data) {
        cont++;
        cont2++;
        tr += "<tr>";
        // ARMAMOS CABECERA
        for (let key2 in data[key]) {

            // VALORES
            titulo = key2.replace(/'/g, "");
            valor = data[key][key2];
            valor = valor == null ? 0 : valor;

            // console.log(titulo);
            // TOTAL DE KILOS
            if (cont == 1) {

                if(titulo != "IDTIPO"){

                    if(titulo == "TIPO"){
                        th += `<th data-prueba='' style='text-align:left !important'>DETALLE GENERAL</th>`;
                        
                    }else if(titulo == "PROVEEDOR" || titulo ==  "CLIENTE"){
                        th += `<th data-prueba=''  style='text-align:left !important;width:60px !important;'>${titulo}</th>`;
                    }else{
                        th += `<th data-prueba=''>${titulo}</th>`;
                    }

                }
            }


            if(cont2 == 1){
                
                // AGREGAMOS TOTAL DE KILOS
                if (titulo != "IDTIPO" && titulo != "TIPO" && titulo != "PROVEEDOR" && titulo != "CLIENTE") {
                    TOTALPROVEDORESKG.push(valor);
                }

            }

            // TOTAL DE KILOS APROBADOS
            if (cont2 == 2) {

                if (titulo != "IDTIPO" && titulo != "TIPO" && titulo != "PROVEEDOR" && titulo != "CLIENTE") {
                    TOTALPROVEDORESKGAPRO.push(valor);
                }
            }

            // TOTAL DE KILOS APROBADOS NO CONFORMES
            if (cont2 == 3) {

                if (titulo != "IDTIPO" && titulo != "TIPO" && titulo != "PROVEEDOR" && titulo != "CLIENTE") {
                    TOTALPROVEDORESKGAPRONOCON.push(valor);
                }
            }

            // TOTAL DE KG RECHAZADOS
            if (cont2 == 4) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO" && titulo != "PROVEEDOR" && titulo != "CLIENTE") {
                    TOTALPROVEDORESKGRECH.push(valor);
                }
            }

            // TOTAL DE KG OTROS
            if (cont2 == 5) {
                
                if (titulo != "IDTIPO" && titulo != "TIPO" && titulo != "PROVEEDOR" && titulo != "CLIENTE") {
                    TOTALPROVEDORESKGOTROS.push(valor);
                }

            }

            

            if(titulo != "IDTIPO"){
                // let valorcoma = "";
                if(!isNaN(valor)){
                    let valorcoma = parseFloat(valor);
                    valorcoma = valorcoma.toLocaleString("en-US");
                    tr += `<td data-prueba='' data-color='${colorfondo}' style='background:${colorfondo}'>${ valorcoma }</td>`;
                }else{
                    
                    let tipo = key2;

                    

                    if( tipo == "CLIENTE" || tipo == "PROVEEDOR" ){

                        if(nombre != valor){
                            rowspan = true;
                        }
    
                        nombre = valor;


                        if(rowspan){
                            tr += `<td data-prueba=''  data-color='${colorfondo}' style='text-align:left !important; vertical-align:middle;background:${colorfondo} ' rowspan='9' >${ valor }</td>`;
                            rowspan = false;
                        }
                        

                    }else{
                        tr += `<td data-prueba=''  data-color='${colorfondo}' style='text-align:left !important;background:${colorfondo}'>${ valor }</td>`;
                    }

                }

                if(titulo == "PROVEEDOR" || titulo == "CLIENTE"){
                    nombreproveedor = valor;
                }
                
            }
        }

        tr += "</tr>";


        // PORCENTAJES KILOS
        if(cont2  == 5){

            cont2 = 0;
            // % KG APROBADOS
            tr += "<tr>";
                // tr += "<th data-prueba='' class='thead-sistema' style='text-align:left !important;vertical-align:middle;' rowspan='4'>"+nombreproveedor+"</th>";
                tr += "<th data-prueba='' data-color='"+theadsistema+"' class='thead-sistema' style='text-align:left !important'>% KG. APROBADOS</th>";
                for(let i = 0 ; i < TOTALPROVEDORESKG.length; i++){
                    let porcentaje = TOTALPROVEDORESKGAPRO[i] / TOTALPROVEDORESKG[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);

                    let color = getColorBackandFontIndicadores(CONFIINDICADORTESTING,porcentaje);
                    tr += `<td data-color='${color.backcolor}' style='background:${color.backcolor};color:${color.fontcolor}' >${porcentaje}%</td>`;

                    

                }
            tr += "</tr>";

            // % KG APROBADOS NO CONFORME
            tr += "<tr>";
                tr += "<th data-prueba='' data-color='"+theadsistema+"' class='thead-sistema' style='text-align:left !important'>% KG. APRO. NO CON.</th>";
                for(let i = 0 ; i < TOTALPROVEDORESKG.length; i++){
                    let porcentaje = TOTALPROVEDORESKGAPRONOCON[i] / TOTALPROVEDORESKG[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);

                    // let color = getColorBackandFontIndicadores(CONFIINDICADORTESTING,porcentaje);
                    // tr += `<td style='background:${color.backcolor};color:${color.fontcolor}' >${porcentaje}%</td>`;

                    tr += "<td data-color='"+colorfondo+"' style='background:"+colorfondo+"'>"+porcentaje+"%</td>";

                }
            tr += "</tr>";

            // % KG RECHAZADOS
            tr += "<tr>";
                tr += "<th data-prueba='' data-color='"+theadsistema+"' class='thead-sistema' style='text-align:left !important'>% KG. RECHAZADOS</th>";
                for(let i = 0 ; i < TOTALPROVEDORESKG.length; i++){
                    let porcentaje = TOTALPROVEDORESKGRECH[i] / TOTALPROVEDORESKG[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);

                    tr += "<td data-color='"+colorfondo+"' style='background:"+colorfondo+"'>"+porcentaje+"%</td>";
                }
            tr += "</tr>";

            // % KG OTROS
            tr += "<tr>";
                tr += "<th data-prueba='' data-color='"+theadsistema+"' class='thead-sistema' style='text-align:left !important'>% KG. OTROS (En Evaluación)</th>";
                for(let i = 0 ; i < TOTALPROVEDORESKG.length; i++){
                    let porcentaje = TOTALPROVEDORESKGOTROS[i] / TOTALPROVEDORESKG[i];
                    porcentaje = isNaN(porcentaje) ? 0 : porcentaje;
                    porcentaje = porcentaje * 100;
                    porcentaje = porcentaje.toFixed(2);

                    tr += "<td data-color='"+colorfondo+"' style='background:"+colorfondo+"'>"+porcentaje+"%</td>";
                }
            tr += "</tr>";

            // CAMBIO DE COLOR
            colorfondo = colorfondo == "#dddddd" ? "#ffffff" : "#dddddd" ;

            // REINICIAMOS
            TOTALPROVEDORESKG = [];
            TOTALPROVEDORESKGAPRO = [];
            TOTALPROVEDORESKGAPRONOCON = [];
            TOTALPROVEDORESKGRECH = [];
            TOTALPROVEDORESKGOTROS = [];

        }

       


    }

    th += "</tr>";

    // ASIGNAMOS VALORES
    $(`#thead${tabla}`).html(th);
    $(`#tbody${tabla}`).html(tr);
    

}