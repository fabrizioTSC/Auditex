
// ARMAR DATABLA NEW
function ArmarDataTable(tabla, dato, ordenar = false, minimo = true, exportar = false, scroolx = false,scrooly = false,search = true) {

    // REFRESCAMOS
    var tbl = $(`#table${tabla}`).DataTable();
    tbl.destroy();



    // LLENAMOS DATOS
    $(`#tbody${tabla}`).html(dato);


    var objeto = {};
    objeto.language = { 'url': "/tsc/libs/js/datatables/spanish.json" };
    // BUSCAR
    objeto.searching = search;

    // ORDENAR
    objeto.ordering = ordenar;

    // SCROOL HORIZONTAL
    objeto.scrollX = scroolx;

    // SCROOL VERTICAL
    if(scrooly){
        objeto.scrollY = scrooly;
        // objeto.scrollCollapse = true;
        objeto.paging = false;

    }

    if (minimo) {
        objeto.lengthMenu = [[5, 10, 20, -1], [5, 10, 20, 'Todos']];
    }

    if (exportar) {
        objeto.dom = 'Bfrtip';
        objeto.buttons = ['excel', 'pdf', 'print'];
    }

    $(`#table${tabla}`).DataTable(objeto);


}