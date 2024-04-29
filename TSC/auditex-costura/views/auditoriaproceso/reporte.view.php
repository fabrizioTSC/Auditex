<?php
	session_start();
	date_default_timezone_set('America/Lima');

	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Reporte General de Auditoria Proceso";
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

        label{
            color:#fff; 
            /* margin-bottom: 0px !important; */
        }

        hr{
            border-color:#fff;
        }

        #frmbusqueda > .form-group >label{
            color:#fff !important;
        }
        
        #tbodyoperaciones > tr {
            cursor: pointer !important;
        }

        thead{
            font-size: 13px;
        }

        tbody{
            font-size: 12px;
        }

        #tblreporte{
            table-layout: fixed;
        }

        .thead-fila .w-bajo{
            width: 60px;
        }

        .thead-fila .w-bajo2{
            width: 100px;
        }

        .thead-fila .w-medio{
            /* min-width: 150px; */
            /* max-width: 150px; */
            width: 150px;
            /* overflow: auto; */
        }

        .thead-fila .w-alto{
            /* min-width: 200px; */
            /* max-width: 200px; */
            width: 200px;
            /* overflow: auto; */
        }

 




    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>


<div class="container mt-3" id="container-busqueda"> 

    <form class="row justify-content-center" id="frmbusqueda">

        <div class="col-md-6">
            <label for="">Sede</label>
            <select name="" id="cbosede" class="custom-select select2" style="width: 100%;"></select>
        </div>

        <div class="col-md-6">
            <label for="">Tipo Servicio</label>
            <select name="" id="cbotiposervicio" class="custom-select select2" style="width: 100%;"></select>
        </div>

        <div class="col-md-6">
            <label for="">Taller</label>
            <select name="" id="cbotaller" class="custom-select select2" style="width: 100%;"></select>
        </div>

        <div class="col-md-6">
            <label for="">Auditor</label>
            <select name="" id="cboauditor" class="custom-select select2" style="width: 100%;"></select>
        </div>

        <div class="col-md-6">
            <label for="">Cliente</label>
            <select name="" id="cbocliente" class="custom-select select2" style="width: 100%;"></select>
        </div>


        <div class="col-md-6">
            <label for="">PO</label>
            <input type="text" class="form-control form-control-sm" id="txtpo">
        </div>

        <div class="col-md-6">
            <label for="">Pedido</label>
            <input type="text" class="form-control form-control-sm" id="txtpedido">
        </div>

        <div class="col-md-6">
            <label for="">Color</label>
            <input type="text" class="form-control form-control-sm" id="txtcolor">
        </div>


        <div class="col-md-6">
            <label for="">Fecha I</label>
            <input type="date" class="form-control form-control-sm" id="txtfechai" value="<?=  date("Y-m-d") ?>">
        </div>

        <div class="col-md-6">
            <label for="">Fecha F</label>
            <input type="date" class="form-control form-control-sm" id="txtfechaf" value="<?=  date("Y-m-d") ?>">
        </div>

        <div class="col-md-4">
            <label for="">&nbsp;</label>
            <button class="btn btn-sm btn-block btn-secondary" type="submit">Buscar</button>
        </div>

    </form>

</div>

<!-- REPORTE -->
<div class="container-fluid mt-3 d-none" id="container-reporte">

    <div class="row mb-3">
        <div class="col-md-12 text-white" id="lblfiltros">
            <!-- <label for="" id="lblfiltros"></label> -->
        </div>
        <div class="col-md-2 ">
            <!-- <label for="">&nbsp;</label> -->
            <button class="btn btn-sm btn-block btn-success" type="button" id="btnexportar">Exportar</button>
        </div>
    </div>

    <div class="table-responsive" style="max-height: 400px;" id="tblresponsivecontent">

        <table class="table table-sm table-bordered table-hover" id="tblreporte">
            <thead class="thead-sistema-new text-center" id="tblresponsivethead">
                <tr class="thead-fila">
                    <th class="border-table w-bajo  align-vertical" >ITEM</th>
                    <th class="border-table w-bajo  align-vertical" >FICHA</th>
                    <th class="border-table w-bajo2 align-vertical" >PO</th>
                    <th class="border-table w-bajo  align-vertical" >PEDIDO</th>
                    <th class="border-table w-bajo  align-vertical" >ESTILO TSC</th>
                    <th class="border-table w-bajo2 align-vertical" >ESTILO CLIENTE</th>
                    <th class="border-table w-medio align-vertical" >OPERACION</th>
                    <th class="border-table w-bajo  align-vertical" >NUMVEZ</th>
                    <th class="border-table w-medio align-vertical" >ESTADO</th>
                    <th class="border-table w-bajo2 align-vertical" >FECHA FIN</th>
                    <th class="border-table w-bajo2 align-vertical" >USUARIO FIN</th>
                    <th class="border-table w-alto align-vertical" >TALLER</th>
                    <th class="border-table w-alto align-vertical" >CLIENTE</th>
                    <th class="border-table w-alto align-vertical" >DEFECTOS</th>
                    <th class="border-table w-alto align-vertical" >CANT DEFECTOS</th>
                    <th class="border-table w-bajo2 align-vertical" >PARTIDA</th>
                    <th class="border-table w-alto align-vertical" >COLOR</th>
                    <th class="border-table w-alto align-vertical" >TIPOTELA</th>
                </tr>
            </thead>
            <tbody id="tbodyreporte" class="bg-white">

            </tbody>
        </table>

    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-2">
            <button class="btn btn-sm btn-block btn-secondary mt-2" type="button" id="btnvolver">
                <i class="fas fa-arrow-left"></i>
                Volver
            </button>
        </div>
    </div>

   

</div>




<div class="loader"></div>


<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script>

    const frmbusqueda = document.getElementById("frmbusqueda");
    let FILTROS = "";
    let TALLERES = "";


    window.addEventListener('load',async ()=>{

        let tableCont = document.querySelector('#tblresponsivecontent');

        function scrollHandle (e){
            var scrollTop = this.scrollTop;
            this.querySelector('#tblresponsivethead').style.transform = 'translateY(' + scrollTop + 'px)';
        }

        tableCont.addEventListener('scroll',scrollHandle);

        await getSedes();
        await getTipoServicios();
        await getTalleres();
        await getClientes();
        await getAuditores();

        frmbusqueda.addEventListener('submit',(e)=>{
            e.preventDefault();
            getReporte();
        }); 

        $("#btnvolver").click(function(){

            $(".loader").fadeIn("show");   


            $("#container-reporte").addClass("d-none");
            $("#container-busqueda").removeClass("d-none");

            $(".loader").fadeOut("slow");   


        });

        // EXPORTAR
        $("#btnexportar").click(function(){

            window.open(`
                ../../../controllers/auditex-costura/auditoriaproceso.controller.php?operacion=set-exportar&filtros=${FILTROS}
            `,"_blank");

        });


        $(".loader").fadeOut("slow");
    });


    // GET SEDES
    async function getSedes(){
        let response = await get("auditex-generales","generales","getsedes",{ });
        setComboSimple("cbosede",response,"DESSEDE","CODSEDE",true,false,"TODOS");
    }

    // GET SEDES
    async function getTipoServicios(){
        let response = await get("auditex-generales","generales","gettiposervicios",{ });
        console.log("tipo servicios",response);
        setComboSimple("cbotiposervicio",response,"DESTIPSERV","CODTIPSERV",true,false,"TODOS");
    }

    $("#cbotiposervicio").change(function(){

        let valor = $("#cbotiposervicio").val();
        if(valor != ""){
            let filtros = TALLERES.filter(obj => obj.CODTIPOSERV  == valor);
            setComboSimple("cbotaller",filtros,"DESTLL","CODTLL",true,false,"TODOS");
        }else{
            let filtros = TALLERES.filter(obj => obj.CODTIPOSERV  == valor);
            setComboSimple("cbotaller",TALLERES,"DESTLL","CODTLL",true,false,"TODOS");
        }
        

    });

    // GET TALLERES
    async function getTalleres(){
        let response = await get("auditex-generales","generales","gettalleres",{ });
        // console.log("tipo servicios",response);
        TALLERES = response;
        setComboSimple("cbotaller",response,"DESTLL","CODTLL",true,false,"TODOS");
    }

    // GET CLIENTES
    async function getClientes(){
        let response = await get("auditex-costura","auditoriaproceso","getclientes",{ });
        setComboSimple("cbocliente",response,"DESCLI","CODCLI",true,false,"TODOS");
    }

    // GET AUDITORES
    async function getAuditores(){
        let response = await get("auditex-costura","auditoriaproceso","getauditores",{ });
        setComboSimple("cboauditor",response,"USUARIOFIN","USUARIOFIN",true,false,"TODOS");
    }



    // FUNCION PARA BUSCAR REPORTE
    function getReporte(){

        $(".loader").fadeIn("show");
        
        let filtros = 
        {
            sede:$("#cbosede").val(),       tiposervicio:$("#cbotiposervicio").val(),  taller:$("#cbotaller").val(),
            auditor:$("#cboauditor").val(),    cliente:$("#cbocliente").val(),            po:$("#txtpo").val(),
            pedido:$("#txtpedido").val(),     color:$("#txtcolor").val(),              fechai:$("#txtfechai").val(),
            fechaf:$("#txtfechaf").val()
        };

        FILTROS = 
        `
                Sede:  ${ filtros.sede != "" ? $("#cbosede option:selected" ).text() : "TODOS" } / Tipo Servicio: ${ filtros.tiposervicio != "" ? $("#cbotiposervicio option:selected" ).text() : "TODOS" } /
                Taller: ${ filtros.taller != "" ? $("#cbotaller option:selected" ).text() : "TODOS" } / Auditor: ${ filtros.auditor != "" ? filtros.auditor : "TODOS" } /
                Cliente:  ${ filtros.cliente != "" ? $("#cbocliente option:selected" ).text() : "TODOS" } / PO:  ${ filtros.po != "" ? filtros.po : "TODOS" } /
                Pedido:  ${ filtros.pedido != "" ? filtros.pedido : "TODOS" } / Color:  ${ filtros.color != "" ? filtros.color : "TODOS" } /
                Fecha Inicio:  ${ filtros.fechai != "" ? filtros.fechai : "TODOS" } / Fecha Fin: ${ filtros.fechaf != "" ? filtros.fechaf : "TODOS" }
        `;

        $("#lblfiltros").html(
            `
                <strong> Sede: </strong> ${ filtros.sede != "" ? $("#cbosede option:selected" ).text() : "TODOS" } / <strong>Tipo Servicio:</strong> ${ filtros.tiposervicio != "" ? $("#cbotiposervicio option:selected" ).text() : "TODOS" } /
                <strong> Taller:</strong> ${ filtros.taller != "" ? $("#cbotaller option:selected" ).text() : "TODOS" } / <strong>Auditor:</strong> ${ filtros.auditor != "" ? filtros.auditor : "TODOS" } 
                <br>
                <strong> Cliente: </strong> ${ filtros.cliente != "" ? $("#cbocliente option:selected" ).text() : "TODOS" } / <strong>PO: </strong> ${ filtros.po != "" ? filtros.po : "TODOS" } /
                <strong> Pedido: </strong> ${ filtros.pedido != "" ? filtros.pedido : "TODOS" } / <strong>Color: </strong> ${ filtros.color != "" ? filtros.color : "TODOS" } 
                <br>
                <strong> Fecha Inicio: </strong> ${ filtros.fechai != "" ? filtros.fechai : "TODOS" } / <strong>Fecha Fin:  </strong>${ filtros.fechaf != "" ? filtros.fechaf : "TODOS" }
            `
        );

        get("auditex-costura","auditoriaproceso","getreporte",filtros ,true)
            .then(response => {
            // console.log(response);
            $("#tbodyreporte").html(response);

            $("#container-busqueda").addClass("d-none");
            $("#container-reporte").removeClass("d-none");

            $(".loader").fadeOut("slow");

        }).catch(error => {
            console.log("Error");
            Advertir("Ocurrio un error");
            $(".loader").fadeOut("slow");
        });

    }


</script>



</body>
</html>