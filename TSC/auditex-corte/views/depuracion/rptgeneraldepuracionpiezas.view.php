<?php
	date_default_timezone_set('America/Lima');
	session_start();
	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Reporte general depuración de corte";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depuración Corte Reporte General</title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>
    <!-- <link rel="stylesheet" href="../../../libs/css/mdb.min.css"> -->
    <style>
        body{
            font-family: 'Roboto',sans-serif !important;
            font-size: 11px !important;
            padding-top: 60px !important;

        }
        td,th{
            padding: 2px !important;
            /* font-weight: normal !important; */
        }
        .table{
            margin-bottom: 0px !important;
        }


        nav{
            height: 8vh !important;
        }

        .container-fluid{
            margin-top: 2vh !important;
        }



    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>


<div class="container-fluid "> 

    <!-- BUSQUEDA -->
    <div class="card" >
        <div class="card-body">

            <form class="row" id="frmbusqueda">

                <!-- SEDE -->
                <div class="col-md-2">
                    <label for="">Sede</label>
                    <select name="" id="cbosedes" style="width: 100%;" class="custom-select custom-select-sm select2"></select>
                </div>

                 <!-- TIPO SERVICIOS -->
                <div class="col-md-2">
                    <label for="">Tipo servicio</label>
                    <select name="" id="cbotiposervicios" style="width: 100%;" class="custom-select custom-select-sm select2"></select>
                </div>

                <!-- TIPO SERVICIOS -->
                <div class="col-md-2">
                    <label for="">Proveedor</label>
                    <select name="" id="cboproveedores"  style="width: 100%;" class="custom-select custom-select-sm select2"></select>
                </div>

                <!-- TALLER -->
                <div class="col-md-2">
                    <label for="">Taller</label>
                    <select name="" id="cbotalleres" style="width: 100%;" class="custom-select custom-select-sm select2"></select>
                </div>

                <!-- CLIENTE -->
                <div class="col-md-2">
                    <label for="">Cliente</label>
                    <select name="" id="cbocliente"  style="width: 100%;" class="custom-select custom-select-sm select2"></select>
                </div>

                <!-- ARTICULO -->
                <div class="col-md-2">
                    <label for="">Articulo</label>
                    <input type="text" id="txtarticulo" class="form-control form-control-sm">
                    <!-- <select name="" id="txtarticulo" class="custom-select custom-select-sm"></select> -->
                </div>

                <!-- CODIGO DE TELA -->
                <div class="col-md-2">
                    <label for="">Cod. Tela</label>
                    <input type="text" id="txtcodtela" class="form-control form-control-sm">
                    <!-- <select name="" id="txtarticulo" class="custom-select custom-select-sm"></select> -->
                </div>

                <!-- PROGRAMA -->
                <div class="col-md-2">
                    <label for="">Programa</label>
                    <input type="text" id="txtprograma" class="form-control form-control-sm">
                    <!-- <select name="" id="txtprograma" class="custom-select custom-select-sm"></select> -->
                </div>

                <!-- FICHAS -->
                <div class="col-md-2">
                    <label for="">Ficha</label>
                    <input type="text" class="form-control form-control-sm" id="txtficha">
                </div>

                <!-- COLORES -->
                <div class="col-md-2">
                    <label for="">Color</label>
                    <input type="text" id="txtcolor" class="form-control form-control-sm">
                    <!-- <select name="" id="txtcolor" class="custom-select custom-select-sm"></select> -->
                </div>

                <!-- FECHA I -->
                <div class="col-md-2">
                    <label   label for="">Fecha Inicio</label>
                    <input type="date" class="form-control form-control-sm" id="txtfechai">
                </div>

                <!-- FECHA F-->
                <div class="col-md-2">
                    <label for="">Fecha Fin</label>
                    <input type="date" class="form-control form-control-sm" id="txtfechaf">
                </div>

                <!-- BUSQUEDA -->
                <div class="col-md-6 pt-2">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-success " type="button" id="btnexportar">
                        <i class="fas fa-file-excel"></i>
                        Descargar
                    </button>
                </div>

                <div class="col-md-6 pt-2">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-primary float-right" type="submit">
                        <i class="fas fa-search"></i>
                        Buscar
                    </button>
                </div>

                

            </form>
        </div>
    </div>

     <!-- FORM ENVIO -->
    <form action="/tsc/controllers/auditex-corte/rptdepuracion.controller.php" method="POST" id="frmarchivo">
        <input type="hidden" name="operacion" value="setexportardepuracion">
        <!-- <input type="hidden" name="table" id="tablecontainerhtml"> -->
    </form>

    <!-- TABLA -->
    <div class="card mt-3">
        <div class="card-body p-0">

            <table class="table table-sm table-bordered-sistema table-hover text-center" id="tablereporte" style="width: 100%;">
                <thead class="thead-sistema">
                    <tr>
                        <th style="width: 10px !important;vertical-align:middle;">Item</th>
                        <th style="width: 50px !important;vertical-align:middle;">Ficha</th>
                        <th style="width: 50px !important;vertical-align:middle;">Cliente</th>
                        <th style="width: 50px !important;vertical-align:middle;">Pedido</th>
                        <th style="width: 50px !important;vertical-align:middle;">Estilo Cliente</th>
                        <th style="width: 50px !important;vertical-align:middle;">Estilo TSC</th>
                        <th style="width: 50px !important;vertical-align:middle;">Color</th>
                        <th style="width: 50px !important;vertical-align:middle;">Partida</th>
                        <th style="width: 50px !important;vertical-align:middle;">Programa</th>
                        <th style="width: 50px !important;vertical-align:middle;">Cant Ficha</th>
                        <th style="width: 50px !important;vertical-align:middle;">Fecha Inicio</th>
                        <th style="width: 50px !important;vertical-align:middle;">Fecha Fin</th>
                        <th style="width: 50px !important;vertical-align:middle;">Cant Piezas Depuradas</th>
                        <th style="width: 50px !important;vertical-align:middle;">Motivo</th>
                        <th style="width: 50px !important;vertical-align:middle;">Kg. Depurado</th>
                        <th style="width: 50px !important;vertical-align:middle;">Porcentaje</th>
                        <th style="width: 50px !important;vertical-align:middle;">Validado Por:</th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <tbody id="tbodyreporte"></tbody>
            </table>

        </div>
    </div>

</div>



<div class="loader"></div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script>

    const frmbusqueda = document.getElementById("frmbusqueda");
    // FILTROS 
    let SEDES = [];
    let TIPOSERVICIO = [];
    let TALLER = [];

    // LOAD
    $(document).ready(async function(){

        await getSedes();
        await getTipoServicios();
        await getTalleres();
        await getproveedores();
        await getclientes();

        $(".loader").fadeOut("slow");
    });

    // BUSQUEDA
    frmbusqueda.addEventListener('submit',(e)=>{
        e.preventDefault();
        getReporte();
    });

    // REPORTE 
    function getReporte(){

        MostrarCarga("Buscando...");

        let sede = $("#cbosedes").val();
        let tiposervicio = $("#cbotiposervicios").val();
        let proveedor = $("#cboproveedores").val();
        let taller = $("#cbotalleres").val();
        let cliente = $("#cbocliente").val();
        let articulo = $("#txtarticulo").val();
        let programa = $("#txtprograma").val();
        let ficha = $("#txtficha").val();
        let color = $("#txtcolor").val();
        let fechai = $("#txtfechai").val();
        let fechaf  = $("#txtfechaf").val();  
        let codtela = $("#txtcodtela").val();  


        let datos = {
            sede,         tiposervicio,        proveedor,
            taller,       cliente,             articulo,
            programa,     ficha,               color,
            fechai,       fechaf,              codtela
        }

        get("auditex-corte","rptdepuracion","getreportegeneral",datos,true)
            .then(response => {

                
                // console.log(response.length);

                //ArmarDataTable("reporte",response,false,false,false,true,400,false);
                ArmarDataTable("reporte",response,false,false,false,false,400,false);


                if(response.length != 8){
                    InformarMini("Reporte generado");
                }else{
                    AdvertirMini("No hay información");
                }
                // $("#tbodyreporte").html(response);

            })
            .catch(error => {
                console.log(error);
                Advertir("Ocurrio un error");
            });


    }

    // SEDES
    async function getSedes(){
        SEDES = await get("auditex-corte","indicadordepuracion","getsedes");
        setComboSimple("cbosedes",SEDES,"DESSEDE","CODSEDE",true,false,"TODOS");
    } 

    // TIPO SERVICIOS
    async function getTipoServicios(){
        TIPOSERVICIO = await get("auditex-corte","indicadordepuracion","gettiposervicios");
        setComboSimple("cbotiposervicios",TIPOSERVICIO,"DESTIPSERV","CODTIPSERV",true,false,"TODOS");
    } 

    // TALLERES
    async function getTalleres(){
        TALLER = await get("auditex-corte","indicadordepuracion","gettalleres");
        setComboSimple("cbotalleres",TALLER,"DESTLL","CODTLL",true,false,"TODOS");
    } 

    // GET PROVEEDORES
    async function getproveedores(){
        let response = await get("auditex-testing","testing","getproveedorestela",{});
        setComboSimple("cboproveedores",response,"DESCRIPCIONPROVEEDOR","IDPROVEEDOR",true,false,"TODOS");
    }

    // GET PROVEEDORES
    async function getclientes(){
        let response = await get("auditex-testing","testing","getclientes",{});
        setComboSimple("cbocliente",response,"DESCRIPCIONCLIENTE","IDCLIENTE",true,false,"TODOS");
    }

    // FILTRAMOS
    $("#cbosedes").change(function(){
        filtrerTalleres();
    });

    // FILTRAMOS
    $("#cbotiposervicios").change(function(){
        filtrerTalleres();
    });

    // FILTRAMOS TALLERES
    function filtrerTalleres(){
                
        let idsede          = $("#cbosedes").val();
        let idtiposervicio  = $("#cbotiposervicios").val();

        let filtrado = TALLER;

        // FILTRAMOS SEDE
        if(idsede != ""){   
            filtrado = TALLER.filter(obj => obj.CODSEDE == idsede);
        }

        // FILTRAMOS TIPO SERVICIOS
        if(idtiposervicio != ""){   
            filtrado = TALLER.filter(obj => obj.CODTIPOSERV == idtiposervicio);
        }

        setComboSimple("cbotalleres",filtrado,"DESTLL","CODTLL");
    }

    // EXPORTAR
    $("#btnexportar").click(function(){
        $("#frmarchivo").submit();
    });


</script>


</body>
</html>