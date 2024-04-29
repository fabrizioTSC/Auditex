<?php
	session_start();
	date_default_timezone_set('America/Lima');

	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Reporte Clasificación de Fichas";
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

        #frmbusqueda > .form-group >label{
            color:#fff !important;
        }
        
        #tbodyfichas > tr {
            cursor: pointer !important;
        }

        #table-reporte{
            table-layout: fixed !important;
            /* width: auto; */
        }

        #thead-reporte{
            font-size: 12px !important;
        }

        #tbody-reporte{
            font-size: 11px !important;
        }


        th:first-child, td:first-child{
            position:sticky;
            left:0px;
            background: #e9ecef  !important;
        }

        /* td:first-child{ */
            /* background-color:grey; */
        /* } */


        /* table {
            font-family: "Fraunces", serif;
            font-size: 125%;
            white-space: nowrap;
            margin: 0;
            border: none;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            border: 1px solid black;
        }
        table td,
        table th {
        border: 1px solid black;
        padding: 0.5rem 1rem;
        } */
        /* #table-reporte thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            background: white;
        } */
        /* table td {
        background: #fff;
        padding: 4px 5px;
        text-align: center;
        } */

        /* #table-reporte tbody th {
            text-align: left;
            position: relative;
        } */
        /* #table-reporte thead th:first-child {
            position: sticky;
            left: 0;
            z-index: 2;
        } */

        /* #table-reporte tbody th {
            position: sticky;
            left: 0;
            z-index: 1;
        } */


        /* #theadtr th { */
            /* border: 1px solid blue; */
            /* width: 200px !important; */
            /* word-wrap: break-word; */
        /* } */

    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container mt-3"> 

    <div class="card" id="container-busqueda" >

        <!-- BUSQUEDA  -->
        <form class="card-body row justify-content-center "  id="frmbusqueda" autocomplete="off">

            <!-- SEDE -->
            <div class="form-group-sm col-md-6">
                <label for="">Sede</label>
                <select name="" id="cbosede" class="custom-select custom-select-sm changescombos select2" style="width: 100%;" >  </select>
            </div>
            
            <!-- TIPO SERVICIO -->
            <div class="form-group-sm col-md-6">
                <label for="">Tipo Servicio</label>
                <select name="" id="cbotiposervicio" class="custom-select custom-select-sm changescombos select2" style="width: 100%;" ></select>
            </div>

            <!-- TALLER -->
            <div class="form-group-sm col-md-6">
                <label for="">Taller</label>
                <select name="" id="cbotaller" class="custom-select custom-select-sm select2" style="width: 100%;" ></select>
            </div>

            <!-- AUDITOR -->
            <div class="form-group-sm col-md-6">
                <label for="">Auditor</label>
                <select name="" id="cboauditor" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
            </div>

            <!-- CLIENTE -->
            <div class="form-group-sm col-md-6">
                <label for="">Cliente</label>
                <select name="" id="cbocliente" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
            </div>

            <!-- PEDIDO -->
            <div class="form-group-sm col-md-6">
                <label for="">Pedido</label>
                <input type="text" id="txtpedido" class="form-control form-control-sm">
            </div>

            <!-- COLOR -->
            <div class="form-group-sm col-md-6">
                <label for="">Color</label>
                <input type="text" id="txtcolor" class="form-control form-control-sm">
            </div>

            <!--  -->
            <div class="form-group-sm col-md-6">
                <!-- <label for=""></label> -->
                <!-- <input type="text" class="form-control form-control-sm"> -->
            </div>

            <!-- FECHA INICIO -->
            <div class="form-group-sm col-md-6">
                <label for="">Fecha Inicio:</label>
                <input type="date" id="txtfechai" class="form-control form-control-sm" value="<?= date("Y-m-d") ?>">
            </div>

            
            <!-- FECHA FIN -->
            <div class="form-group-sm col-md-6">
                <label for="">Fecha fin:</label>
                <input type="date" id="txtfechaf" class="form-control form-control-sm" value="<?= date("Y-m-d") ?>">
            </div>


            <!-- BOTON -->
            <div class="form-group-sm col-md-6">
                <label for="">&nbsp;</label>
                <button class="btn btn-sistema btn-sm btn-block" type="submit">BUSCAR</button>
                <!-- <input type="date" class="form-control form-control-sm"> -->
            </div>


        </form>

    </div>

    <div class="card" id="container-reporte" style="display: none;">

        <label for="" id="lblfiltros" class="font-weight-bold" ></label>
        
        <div class="card-body p-0">


            <div class="row justify-content-end mb-2">

                <!-- <div class="col-md-12">
                </div> -->


                <div class="col-md-2">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-warning btn-sm btn-block" type="button" id="btnvolver" >
                        <i class="fas fa-arrow-left"></i>   
                        VOLVER
                    </button>
                </div>

                <div class="col-md-2">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-success btn-sm btn-block" type="button" id="btnexportar" >
                        <i class="fas fa-file"></i>   
                        EXPORTAR
                    </button>
                </div>
                
            </div>
            
            <div class="table-responsive text-center" style="max-height: 400px;" id="tablecont">

                <table class="table table-bordered table-hover table-sm m-0" >
                <!-- <table class="" id="table-reporte"> -->
                    <thead id="thead-reporte" class="thead-light">
                        
                    </thead>
                    <tbody id="tbody-reporte">

                    </tbody>
                </table>

            </div>


        </div>
    </div>


</div>



<div class="loader"></div>


<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script>


    let frmbusqueda = document.getElementById("frmbusqueda");
    let tableCont = document.querySelector('#tablecont');
    let LABELS          = "";
    let TABLE_HEADER    = [];
    let TABLE_BODY      = [];            


    window.addEventListener('load',async ()=>{

        $(".changescombos").change(function(){
                getTallerMaquina();
        }); 

        // await GetReporte();
        await getSedes();
        await getTipoServicios();
        await getClientes();
        await getAuditores();

        getTallerMaquina();

        $(".loader").fadeOut("slow");
    });

    frmbusqueda.addEventListener('submit',async (e)=>{

        e.preventDefault();
        await GetReporte();

    });

    // GET SEDES
    async function getSedes(){

        let response = await get("auditex-generales","generales","getsedes",{ });
        setComboSimple("cbosede",response,"DESSEDE","CODSEDE",true,false,"TODOS");
        // console.log(response);
    }

    // GET SEDES
    async function getClientes(){

        let response = await get("auditex-generales","generales","getclientes",{ });
        setComboSimple("cbocliente",response,"DESCLI","CODCLI",true,false,"TODOS");
    }
    
    // GET SEDES
    async function getAuditores(){

        let response = await get("auditex-generales","generales","getauditores",{ });
        setComboSimple("cboauditor",response,"CODUSU","CODUSU",true,false,"TODOS");
    }

    // GET SEDES
    async function getTipoServicios(){

        let response = await get("auditex-generales","generales","gettiposervicios",{ });
        setComboSimple("cbotiposervicio",response,"DESTIPSERV","CODTIPSERV",true,false,"TODOS");
    }

     // GET TALLER O MAQUINA
     function getTallerMaquina(){

        let sede          = $("#cbosede").val() == "" ? null : $("#cbosede").val();
        let tiposervicio    = $("#cbotiposervicio").val() == "" ? null : $("#cbotiposervicio").val();

        MostrarCarga();
        get("auditex-generales","generales","gettalleres_new",{ sede,tiposervicio})
        .then(response =>{

            setComboSimple("cbotaller",response,"DESCRIPCION","ID",true,false,"TODOS");
            OcultarCarga();
        })
        .catch(error => {
            Advertir("Error en ajax");
        });
    

    }


    // GET REPORTE
    async function GetReporte(){

        $(".loader").fadeIn();

        let sede            = $("#cbosede").val();
        let tiposervicio    = $("#cbotiposervicio").val();
        let taller          = $("#cbotaller").val();
        let auditor         = $("#cboauditor").val();
        let cliente         = $("#cbocliente").val();
        let pedido          = $("#txtpedido").val();
        let color           = $("#txtcolor").val();
        let fechai          = $("#txtfechai").val();
        let fechaf          = $("#txtfechaf").val();

        

        // $( "#myselect option:selected" ).text()

        let lbl_sede            = $("#cbosede option:selected").text();
        let lbl_tiposervicio    = $("#cbotiposervicio option:selected").text();
        let lbl_taller          = $("#cbotaller option:selected").text();
        let lbl_auditor         = $("#cboauditor option:selected").text();
        let lbl_cliente         = $("#cbocliente option:selected").text();
        let lbl_pedido          = $("#txtpedido").val()     == "" ? "(TODOS)" : $("#txtpedido").val();
        let lbl_color           = $("#txtcolor").val()      == "" ? "(TODOS)" : $("#txtcolor").val();
        let lbl_fechai          = $("#txtfechai").val()     == "" ? "(TODOS)" : $("#txtfechai").val();
        let lbl_fechaf          = $("#txtfechaf").val()     == "" ? "(TODOS)" : $("#txtfechaf").val();

        // FILTROS
        LABELS =  `
            SEDE: ${lbl_sede} / TIPO SERVICIO: ${lbl_tiposervicio} / TALLER: ${lbl_taller} / AUDITOR: ${lbl_auditor} /
            CLIENTE: ${lbl_cliente} / PEDIDO: ${lbl_pedido} / COLOR: ${lbl_color} / 
            FECHA INICIO: ${lbl_fechai} / FECHA FIN: ${lbl_fechaf}
        `;

        $("#lblfiltros").text(LABELS);


        let response = await get("auditex-costura", "reporteauditoria", "getreporte", { 
            sede,tiposervicio,taller,auditor,cliente,pedido,color,fechai,fechaf
        });

        setTable(response);

        $("#container-busqueda").fadeOut(500);
        setTimeout(()=>{
            $("#container-reporte").fadeIn();
            $(".loader").fadeOut("slow");
        },510);


    }

    // VOLVER
    $("#btnvolver").click(function(){

        $("#container-reporte").fadeOut(500);
        setTimeout(()=>{
            $("#container-busqueda").fadeIn();
        },510);


    });

    // ARMAMOS TABLA GENERAL
    function setTable(data,fecha = null) {

        let cont = 0;
        let th = "<tr id='theadtr'>";
        let tr = "";
        let tf = "";
        let titulo = "";
        let valor = "";
        let total = 0;
        let totalprogramado = 0;
        let totalcortado    = 0;
        TABLE_HEADER    = [];
        TABLE_BODY      = [];    

        // RECORREMOS
        for (let key in data) {
            cont++;
            total = 0;
            tr += "<tr>";
            
            // ARMAMOS CABECERA

            let cuerpo = [];

            for (let key2 in data[key]) {

                // VALORES
                titulo = key2.replace(/'/g, "");
                titulo = titulo.replace(/_/g, " ");
                valor = data[key][key2];
                valor = valor == null ? 0 : valor;

                if ( 
                    !isNaN(valor) &&
                    titulo != "FICHA"   && titulo != "PARTE" && titulo != "NUMVEZ" && titulo != "CANTIDAD" && 
                    titulo != "CANPAR"  && titulo != "ESTTSC" && titulo != "ESTCLI" && titulo != "PEDIDO"  && 
                    titulo != "TALLER"  && titulo != "AUDITOR" && titulo != "SEDE" && titulo != "TIPOSERVICIO" 
                ) {
                    let suma = parseFloat(valor);
                    total += suma;
                }

                // VALOR PROGRAMADO
                if (cont == 1) {


                    let bg = titulo.includes("OBS") ? "background: #cecfd1" : "";
                    
                    if(titulo != "PRIMERA OBS"){

                        titulo = titulo.includes("OBS") ? "OBS" : titulo;

                        // AGREGAMOS TITULO
                        TABLE_HEADER.push(titulo);

                        if (
                                titulo != "FICHA"   && titulo != "PARTE" && titulo != "NUMVEZ" && titulo != "CANTIDAD" && 
                                titulo != "CANPAR"  && titulo != "ESTTSC" && titulo != "ESTCLI" && titulo != "PEDIDO"  && 
                                titulo != "TALLER"  && titulo != "AUDITOR" && titulo != "SEDE" && titulo != "TIPOSERVICIO" 
                            ) {
                            
                            th += `<th class="border-table align-vertical" style='min-width:120px; ${bg}' >${titulo}</th>`;

                        }else if(titulo == "TALLER")
                        {
                            th += `<th class="border-table align-vertical" style='min-width:150px;${bg}' >${titulo}</th>`;
                        }else if(titulo == "FICHA" || titulo == "PARTE" || titulo == "NUMVEZ" || titulo == "CANTIDAD" || titulo == "CANPAR" || titulo == "ESTTSC" || titulo == "ESTCLI"  || titulo == "PEDIDO"){
                            th += `<th class="border-table align-vertical" style='min-width:60px;${bg}' >${titulo}</th>`;
                        }
                        else{
                            th += `<th class="border-table align-vertical" style='min-width:90px;${bg}' >${titulo}</th>`;

                        }

                    }   
                   
                }

               

                if (titulo != "PRIMERA OBS") {
                    // AGREGAMOS CUERPO
                    let valornew = valor == "0" ? "" : valor;
                    let val = "";
                    let cls = (titulo == "TIPOSERVICIO"  || titulo.includes("OBS")  ) ? "border-table-right" : "";


                    if(titulo == "FICHA"){
                        val = valornew;
                        tr += `<th class="align-vertical ${cls}">${valornew}</th>`;
                    }
                    else if (titulo == "CANTIDAD"){
                        val = format_miles(valornew);
                        tr += `<td class="align-vertical ${cls}">${ format_miles(valornew) }</td>`;
                    }
                    else {
                        val = valornew;
                        tr += `<td class="align-vertical ${cls}">${valornew}</td>`;
                    }

                    cuerpo.push(val);

                }


            }


            // TOTAL POR FILA
            tr += `<td class="align-vertical">${format_miles(total)}</td>`;

            cuerpo.push(format_miles(total));
            TABLE_BODY.push(cuerpo);


            tr += "</tr>";


        }

        th += "<th style='min-width:100px' class='border-table align-vertical' >TOTAL CLASIF</th>";
        TABLE_HEADER.push("TOTAL CLASIF");


        th += "</tr>";


        $("#thead-reporte").html(th);
        $("#tbody-reporte").html(tr);

        tableCont.addEventListener('scroll',scrollHandle);

    }

    function scrollHandle (e){
        var scrollTop = this.scrollTop;
        // theaddatos
        // this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
        this.querySelector('#thead-reporte').style.transform = 'translateY(' + scrollTop + 'px)';
        // this.querySelector('#theaddatos_2').style.transform = 'translateY(' + scrollTop + 'px)';

    }

    // EXPORTAR
    $("#btnexportar").click(function(){


        var form = document.createElement("form");
        form.method = "POST";
        form.action = "../../../controllers/auditex-costura/auditoriaproceso.controller.php"   ;
        form.target = "_blank";


        // GRAFICO
        // var imagen = document.createElement("input");  
        // imagen.value= document.getElementById("chartgeneral").toDataURL("image/png");
        // imagen.name = "imagen";
        // form.appendChild(imagen);

        // DATA
        let datos = {
            // titulo: TITULOS,
            cabecera: TABLE_HEADER,
            cuerpo: TABLE_BODY,
            labels:LABELS
            // aprobadas_cant: APROBADAS_CANT,
            // rechazadas_cant: RECHAZADAS_CANT,
            // total_cant: TOTAL_CANT,
            // aprobadas_por_cant: APROBADAS_CANT_POR,
            // rechazadas_por_cant: RECHAZADAS_CANT_POR,

            // aprobadas_pren: APROBADAS_PREN,
            // rechazadas_pren: RECHAZADAS_PREN,
            // total_pren: TOTAL_PREN,
            // aprobadas_por_pren: APROBADAS_PREN_POR ,
            // rechazadas_por_pren: RECHAZADAS_PREN_POR ,
            // titulofiltro: LABELS,
            // tipolavado: "PRENDAS"
            // defectolbl: DEFECTOINDICADOR
        }

        // OPERACION
        var data = document.createElement("input");  
        data.value =  "get-reporte-clasificacion-fichas";
        data.name = "operacion";
        form.appendChild(data);


        var data = document.createElement("input");  
        data.value =  JSON.stringify(datos);
        data.name = "data";
        form.appendChild(data);


        // // DATOS PARETOS 1
        // var pareto1 = document.createElement("input");  
        // pareto1.value =  JSON.stringify(
        //     {
        //         img :document.getElementById("chartpareto1").toDataURL("image/png"),
        //         data: datopareto1,
        //         lbl:document.getElementById("lblpareto1").innerText
        //     }
            
        // )
        // pareto1.name = "pareto1";
        // form.appendChild(pareto1);

        // // DATOS PARETOS 2
        // var pareto2 = document.createElement("input");  
        // pareto2.value =  JSON.stringify(
        //     {
        //         img :document.getElementById("chartpareto2").toDataURL("image/png"),
        //         data: datopareto2,
        //         lbl:document.getElementById("lblpareto2").innerText
        //     }
        // )
        // pareto2.name = "pareto2";
        // form.appendChild(pareto2);

        // // DATOS PARETOS 3
        // var pareto3 = document.createElement("input");  
        // pareto3.value =  JSON.stringify(
        //     {
        //         img :document.getElementById("chartpareto3").toDataURL("image/png"),
        //         data: datopareto3,
        //         lbl:document.getElementById("lblpareto3").innerText
        //     }
        // )
        // pareto3.name = "pareto3";
        // form.appendChild(pareto3);

        // // DATOS PARETOS 4
        // var pareto4 = document.createElement("input");  
        // pareto4.value =  JSON.stringify(
        //     {
        //         img :document.getElementById("chartpareto4").toDataURL("image/png"),
        //         data: datopareto4,
        //         lbl:document.getElementById("lblpareto4").innerText
        //     }
        // )
        // pareto4.name = "pareto4";
        // form.appendChild(pareto4);

        // // DATOS PARETOS 5
        // var pareto5 = document.createElement("input");  
        // pareto5.value =  JSON.stringify(
        //     {
        //         img :document.getElementById("chartpareto5").toDataURL("image/png"),
        //         data: datopareto5,
        //         lbl:document.getElementById("lblpareto5").innerText
        //     }
        // )
        // pareto5.name = "pareto5";
        // form.appendChild(pareto5);

        // // DATOS PARETOS 6
        // var pareto6 = document.createElement("input");  
        // pareto6.value =  JSON.stringify(
        //     {
        //         img :document.getElementById("chartpareto6").toDataURL("image/png"),
        //         data: datopareto6,
        //         lbl:document.getElementById("lblpareto6").innerText
        //     }
        // )
        // pareto6.name = "pareto6";
        // form.appendChild(pareto6);


        // AGREGAMOS INPUT AL FORMULARIO
        document.body.appendChild(form);

        // ENVIAMOS FORMULARIO
        form.submit();

        // REMOVEMOS FORMULARIO
        document.body.removeChild(form);



    });




</script>



</body>
</html>