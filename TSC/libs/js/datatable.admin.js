function ArmarDataTable(tabla,dato,ordenar = false,minimo = true,exportar = false,scrool = false,searching = true){


    // console.log("GAAAAAAAAAAAAAAAAAAAAAAAAAAA",ordenar ,minimo,exportar ,scrool ,searching );

    // // REFRESCAMOS
    // var tbl =  $(`#table${tabla}`).DataTable();
    // tbl.destroy();

    // // LLENAMOS DATOS
    // $(`#tbody${tabla}`).html(dato);


    // var objeto = {};
    // objeto.language = { 'url': "/tsc/libs/js/datatables/spanish.json" };
    // objeto.ordering = ordenar;

    // objeto.searching = searching;

    // objeto.scrollX = scrool;

    // if(minimo){
    //     objeto.lengthMenu = [[5, 10, 20, -1], [5, 10, 20, 'Todos']];
    // }else{
    //     objeto.bLengthChange = false; 
    // }

    // // if(exportar){
    // //     objeto.dom = 'Bfrtip';
    // //     // objeto.buttons = ['excel', 'pdf','print'];
    // //     objeto.buttons = [
    // //         {extend:'excel',className :'btn btn-success'}
    // //     ];

    // // }

    // $(`#table${tabla}`).DataTable(objeto);

    
}


function ArmarDataTable_New(tabla,dato,ordenar = false,minimo = true,exportar = false,scrool = false,searching = true,responsive = false){


    // console.log("GAAAAAAAAAAAAAAAAAAAAAAAAAAA",ordenar ,minimo,exportar ,scrool ,searching );

    // REFRESCAMOS
    var tbl =  $(`#table${tabla}`).DataTable();
    tbl.destroy();

    // LLENAMOS DATOS
    $(`#tbody${tabla}`).html(dato);


    var objeto = {};
    objeto.language = { 'url': "/tsc/libs/js/datatables/spanish.json" };
    objeto.ordering = ordenar;

    objeto.searching = searching;

    objeto.scrollX = scrool;
    objeto.responsive = responsive;

    if(minimo){
        objeto.lengthMenu = [[5, 10, 20, -1], [5, 10, 20, 'Todos']];
    }
    else{
        objeto.paging = false; 
        objeto.info = false; 

    }

    if(exportar){
        objeto.dom = 'Bfrtip';
        // objeto.buttons = ['excel', 'pdf','print'];
        objeto.buttons = [
            {extend:'excel',className :'btn btn-success'}
        ];

    }

    $(`#table${tabla}`).DataTable(objeto);

    
}