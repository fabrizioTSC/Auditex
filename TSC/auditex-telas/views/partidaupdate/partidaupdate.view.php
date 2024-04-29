<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

$_SESSION['navbar'] = "Actualización de Fecha - Partida";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Fecha - Partida</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

    <link rel="stylesheet" href="/tsc/libs/js/datatables-fixed/fixedColumns.bootstrap4.css">

    <style> 

        .color2 {
            background-color: #781C08 !important;
            color: #FFF !important;
        } 
        body{
            padding-top: 50px !important;
        } 
        #tabledatos tbody th {
            white-space: nowrap;
            font-size: 11px;
            padding: 4px !important;
        }  

        #frmbusqueda{
            font-size: 12px;  
        }
 
         .tbl-data tr th {
            text-align: center;
            font-size: 11px;
        }
 
        .center-vert {
            line-height: 4;
        }
 
        .celda {
            height: auto;
            width: 50px;
        }
  
        .bus{
            font-size: 11px;
        }

        .tbodydatos{
            font-size: 11px !important;
        }  

        .font10{
            font-size: 11px !important;
        }
 
    </style>

</head>

<body>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>
    <!-- Bloque Búsqueda -->
    <div class="container-fluid mt-3">

        <div class="card p-1">

            <form class="card-body p-1" id="frmbusqueda">

                <!-- FILTRO DE BÚSQUEDA -->
                <div  class="row justify-content-md mt-1">
                    <!-- Label -->
                    <div class="col-md-2">  
                        <label for="">Partida:</label>
                        <input type="text" class="form-control form-control-sm bus" id="txtpartida"> 
                    </div>  
                    
                    <!-- Botón Buscar -->
                    <div class="col-md-2">  
                        <button class="btn btn-sm btn-primary " type="submit">
                            <i class="fas fa-search"></i> 
                                Buscar
                        </button>    
                    </div>  

                    <div class="col-md-2">  
                        <label for="">Fecha:</label>
                        <input type="date" class="form-control form-control-sm bus" id="txtfecha">
                    </div>  

                    <div class="col-md-2">  
                      <!-- Botón Buscar --> 
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" id="btnactualiza">
                            <i class="fas fa-save"></i>
                            Actualizar
                        </button>
                    </div>  

                </div>

            </form>
            
        </div>
     
    </div>

    <!-- Bloque Detalle -->
      <div class="card p-1 mt-1">
                <div class="card-body p-0">

                    <table class="table table-bordered table-sm table-hover nowrap" id="tabledatos" style="width: 100% !important;">

                        <thead class="thead-light tbl-data">
                            <!-- Nombre de la cabecera de mi tabla --> 
                            <tr>
                                <th class="color2">Aplica</th>
                                <th class="color2">Partida</th>
                                <th class="color2">Vez</th>
                                <th class="color2">Parte</th>
                                <th class="color2">Cód. Tela</th>
                                <th class="color2">Situación</th>
                                <th class="color2">Color</th>
                                <th class="color2">Proveedor</th> 
                                <th class="color2">Ruta</th>
                                <th class="color2">Artículo</th>
                                <th class="color2">Composición</th>
                                <th class="color2">Rendimiento</th>
                                <th class="color2">Peso</th>
                                <th class="color2">Programa</th>
                                <th class="color2">X Factory</th> 
                            </tr>

                        </thead>
                        <tbody id="tbodydatos">
                            
                        </tbody>
                    </table>

                </div>
            </div>
 
<div class="loader"></div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<!-- DATATABLE -->
<script src="/tsc/libs/js/datatables-fixed/dataTables.fixedColumns.min.js"></script>


<!-- SCRIPTS -->
<script>

    let frmbusqueda = document.getElementById("frmbusqueda");

    // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
    window.addEventListener("load", async () => {


        $("#tabledatos").DataTable(
            {
                scrollY:        "100px",
                scrollX:        true,
                scrollCollapse: true,
                paging:         false,
                searching:      false,
                ordering:       false,
                fixedColumns:   {
                    leftColumns: 3,
                }
            } 
        );

        // OCULTAMOS CARGA
        $(".loader").fadeOut("slow");
    });

    // ACTUALIZAR
    $("#btnactualiza").click(async function(){

        let check = $(".checkprueba");

        let valoresmodidicar  = []; 
 
        for(let item of check){
            let fecha = $("#txtfecha").val();
            let valor = $(item).prop("checked");

            var resFecha = fecha.split("-");
            var reversedFecha = resFecha.reverse();
            var Fechaf = reversedFecha.join('-');
            var frFecha = Fechaf.replaceAll("-", "/"); 
 
            if(valor){ 
                let partida =  $(item).data("partida");
                let vez     =  $(item).data("vez");
                let parte   =  $(item).data("parte");
                 valoresmodidicar.push({
                    partida,vez,parte
                }); 
            }    
        }

        if(valoresmodidicar.length == 0){
            Advertir("No ha seleccionado una partida.");
        }else{

            if(frFecha.length == 0){
                Advertir("No ha seleccionado una fecha."); 
            }else{
                // PROCESO DE ACTUALIZAR
                for(let item of valoresmodidicar){
                     // ejecuta
                    await ActualizaPartida(item.partida,item.vez,item.parte,frFecha)
                }
                await BuscaPartida();
            }
        }  
    })

    // FUNCION QUE SE EJECUTA CUANDO ENVIAMOS EL FORMULARIO
    frmbusqueda.addEventListener('submit', async (e) => {
        e.preventDefault();
        await BuscaPartida();
    })

    // FUNCION GENERAL QUE BUSCA LOS DATOS GENERALES
    async function BuscaPartida() {

        MostrarCarga("Cargando...");
 
        let partida = $("#txtpartida").val();

        let response = await get("auditex-tela", "partidaupdate", "getreporte", {
            partida
        }, true);
 
        let tabla = $("#tabledatos").DataTable();
        tabla.destroy();

        $("#tbodydatos").html(response);
 
        InformarMini("Reporte generado");

    } 
  
    async function ActualizaPartida(partida, vez, parte,fecha) {
     // EJECUTAMOS SOLICITUD
        let response = await get("auditex-tela", "partidaupdate", "set-actualizarfechatela", {
            partida,
            vez,
            parte,
            fecha
        }, true);
 
        Informar("Actualizado correctamente");
    }

</script>


</body>

</html>