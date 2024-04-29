<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Fichas Pedido";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['navbar'] ?>  </title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>
    <!-- <link rel="stylesheet" href="../../../libs/css/mdb.min.css"> -->
    <style>
        /* td,th{
            padding: 0px !important;
        } */
        body{
            padding-top:60px !important;
        }

        /* .table-reporte{
            table-layout: fixed;
        } */
         
        .fila .w-bajo{
            min-width: 60px !important;
            max-width: 60px !important;
            overflow: auto;
        }

        .fila .w-color{
            min-width: 100px !important;
            max-width: 100px !important;
            overflow: auto;
        }

        .fila .w-medio{
            min-width: 150px !important;
            max-width: 150px !important;
            overflow: auto;
        }

        #table-head-container{
            overflow: hidden;
        }

        #table-body-container{
            max-height: 300px !important;
            overflow: auto;
        }
        #tbodyreporte{
            font-size: 11px !important;
        }
        #theadreporte{
            font-size: 11px !important;
        }

        .bg-diferencia{
            background: #ffb0b0 !important;
        }

    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container-fluid mt-3"> 

    <form action="" id="frmbusqueda" class="row">
        
        <label for="" class="col-label col-md-1 text-white font-weight-bold text-left" >Desde:</label>
        <div class="col-md-2">
            <input type="number" class="form-control form-control-sm" required id="txtpedidoi" value="">
        </div>

        <label for="" class="col-label col-md-1 text-white font-weight-bold text-right">Hasta:</label>
        <div class="col-md-2">
            <input type="number" class="form-control form-control-sm" required id="txtpedidof" value="">
        </div>

        <div class="col-md-1">
            <button class="btn btn-sm btn-block btn-secondary" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div class="col-md-2">
            <button class="btn btn-sm btn-block btn-success d-none"   id="btnexportar">Exportar</button>
        </div>

    </form>

    <div class="row mt-2">

        <!-- <div class="col-12">
            <hr>
        </div> -->

        <label class="col-label col-md-12  text-white " id="lblestilocliente">
            <strong>ESTILO CLIENTE:</strong>
        </label>
        <label class="col-label col-md-12  text-white " id="lbltotalpedido">
            <strong>TOTAL DEL PEDIDO:</strong>
        </label>
        <label class="col-label col-md-12  text-white" id="lbltotalauditado">
            <strong>TOTAL DEL AUDITADO:</strong>
        </label>
        <label class="col-label col-md-12  text-white " id="lbldiferencia">
            <strong>DIFERENCIA:</strong>
        </label>
    </div>

    <div  class="row mt-2">

        <!-- HEADER -->
        <div class="col-12" id="table-head-container">

            <table class="table table-bordered table-sm w-100 table-reporte m-0" >
                <thead class="thead-light text-center" id="theadreporte">
                    <tr class="fila">
                        <th class="border-table w-bajo  align-vertical">PO</th>
                        <th class="border-table w-bajo  align-vertical">Ficha</th>
                        <th class="border-table w-bajo  align-vertical">Pedido</th>
                        <th class="border-table w-color align-vertical">Color</th>
                        <th class="border-table w-medio align-vertical">Cliente</th>
                        <th class="border-table w-bajo  align-vertical">Cant Ficha</th>
                        <th class="border-table w-medio align-vertical">Usuarios</th>
                        <th class="border-table w-color  align-vertical">Cant Auditada</th>
                        <th class="border-table w-color  align-vertical">Cant Auditada Tot </th>
                        <th class="border-table w-medio align-vertical">Línea / Taller</th>
                        <th class="border-table w-medio align-vertical">Fecha Fin Aud.</th>
                        <th class="border-table w-bajo  align-vertical">Est. TSC</th>
                        <th class="border-table w-bajo  align-vertical">Est. CLI</th>
                        <th class="border-table w-medio align-vertical">Tipo Prenda</th>
                        <th class="border-table w-bajo  align-vertical">Partida</th>
                        <th class="border-table w-medio  align-vertical">Programa</th>
                        <th class="border-table w-medio align-vertical">Tipo Tela</th>
                    </tr>
                </thead>
            </table>

        </div>
        <!-- CUERPO -->
        <div class="col-12 " id="table-body-container">

            <table class="table table-bordered table-sm w-100 table-reporte text-center" >
                <tbody class="bg-white" id="tbodyreporte">
                    
                </tbody>
            </table>

        </div>
       

    </div>


</div>



<div class="loader"></div>


<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>


<script>

    const frmbusqueda   = document.getElementById("frmbusqueda");
    const tbodyreporte  = document.getElementById("tbodyreporte");
    let table_body     = document.querySelector("#table-body-container")
    let table_head     = document.querySelector("#table-head-container")
    const btnexportar  = document.getElementById("btnexportar");
    let TOTALPEDIDO, TOTALAUDITADO,ESTILOS ;


    // 
    $(document).ready(function(){


        // EVENTO DE BUSQUEDA
        frmbusqueda.addEventListener('submit',(e)=>{

            e.preventDefault();
            MostrarCarga();
            let pedidoi = document.getElementById("txtpedidoi").value;
            let pedidof = document.getElementById("txtpedidof").value;


            get("auditex-costura", "fichaspedido", "getreporte", {
                pedidoi,pedidof
            }).then(response =>{

                let tr ="";
                let totalpedido     = 0;
                let totalauditada   = 0;
                let estiloscliente  = [];


                if(response){

                    for(let item of response){

                       
                        let totalauditadofila   = 0;
                        totalpedido += parseFloat(item.CANPRE);

                        if(item.CANTAUDITADA != null && item.CANTAUDITADA != ""){

                            let auditadas = item.CANTAUDITADA;
                            auditadas = auditadas.split(",");

                            for(let i of auditadas){
                                totalauditada           += parseFloat(i);
                                totalauditadofila       += parseFloat(i);
                            }

                        }
                        let totalpedidofila     = parseFloat(item.CANPRE);
                        let clasediferencia     = "";

                        if(totalpedidofila != totalauditadofila){
                            clasediferencia = "bg-diferencia"
                        }

                        // AGREGAMOS ESTILO CLIENTE
                        estiloscliente.push(item.ESTCLI);
                        
                        let po = item.PO == null ? "-" : item.PO ;

                        tr += `
                            <tr class="fila ${clasediferencia}">
                                <td class="w-bajo">${po}</td>
                                <td class="w-bajo">${item.FICHA}</td>
                                <td class="w-bajo">${item.PEDIDO}</td>
                                <td class="w-color">${item.COLOR}</td>
                                <td class="w-medio">${item.DESCLI}</td>
                                <td class="w-bajo">${format_miles(item.CANPRE)}</td>
                                <td class="w-medio">${item.USUARIOS}</td>
                                <td class="w-color">${item.CANTAUDITADA}</td>

                                <td class="w-color">${format_miles(totalauditadofila) }</td>

                                <td class="w-medio">${item.LINEATALLER}</td>
                                <td class="w-medio">${item.FECHAFINAUD}</td>
                                <td class="w-bajo">${item.ESTTSC}</td>
                                <td class="w-bajo">${item.ESTCLI}</td>
                                <td class="w-medio">${item.DESPRE}</td>
                                <td class="w-bajo">${item.PARTIDA}</td>
                                <td class="w-medio">${item.PROGRAMA}</td>
                                <td class="w-medio">${item.TIPOTELA}</td>


                            </tr>
                        `;

                    }

                    $("#tbodyreporte").html(tr);

                    // ASIGNAMOS
                    $("#lbltotalpedido").html(
                        `<strong>TOTAL DEL PEDIDO:</strong> ${totalpedido}`
                    );

                    $("#lbltotalauditado").html(
                        `<strong>TOTAL DEL AUDITADO:</strong> ${totalauditada}`
                    );

                    $("#lbldiferencia").html(
                        `<strong>DIFERENCIA:</strong> ${totalpedido - totalauditada}`
                    );

                    let estilo = estiloscliente.filter((value,index,self)=>{
                        return self.indexOf(value) === index;
                    });

                    TOTALPEDIDO = totalpedido;
                    TOTALAUDITADO = totalauditada;
                    ESTILOS = estilo;

                    $("#lblestilocliente").html(
                        `<strong>ESTILO CLIENTE:</strong> ${estilo}`
                    );

                    $("#btnexportar").removeClass("d-none");


                    OcultarCarga();



                }else{
                    Advertir("Ocurrio un error en el reporte");
                }
                // console.log(response);

            })
            .catch(error => {
                $("#btnexportar").addClass("d-none");
                console.log(error);
                Advertir("Ocurrio un error en el código :c");
            })

        });

        // EVENTO SCROLL
        table_body.addEventListener('scroll',()=>{
            let scrollLeft = table_body.scrollLeft;
            table_head.scrollLeft = scrollLeft;
        } );

        // EXPORTAR
        btnexportar.addEventListener('click',()=>{

            let ruta = "../../../controllers/auditex-costura/fichaspedido.controller.php?operacion=set-exportar";

            let pedidoi = document.getElementById("txtpedidoi").value;
            let pedidof = document.getElementById("txtpedidof").value;


            window.open(`${ruta}&estilos=${ESTILOS}&totalpedido=${TOTALPEDIDO}&totalauditado=${TOTALAUDITADO}&pedidoi=${pedidoi}&pedidof=${pedidof}`)

            // TOTALPEDIDO = totalpedido;
                    // TOTALAUDITADO = totalauditada;
                    // ESTILOS = estilo;

        });


        $(".loader").fadeOut("slow");
    });






</script>


</body>
</html>