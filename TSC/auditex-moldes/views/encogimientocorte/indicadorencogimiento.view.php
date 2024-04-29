<?php
	date_default_timezone_set('America/Lima');
	session_start();
	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Indicador general Moldaje";

    function getNameMonth($fecha){

        $mes =  date("m", strtotime($fecha));
        $mes = (float)$mes;
        $name = "";

        switch ($mes) {
            case 1: $name = "Enero"; break;
            case 2: $name = "Febrero"; break;
            case 3: $name = "Marzo"; break;
            case 4: $name = "Abril"; break;
            case 5: $name = "Mayo"; break;
            case 6: $name = "Junio"; break;
            case 7: $name = "Julio"; break;
            case 8: $name = "Agosto"; break;
            case 9: $name = "Septiembre"; break;
            case 10: $name = "Octubre"; break;
            case 11: $name = "Noviembre"; break;
            case 12: $name = "Diciembre"; break;
        }

        return $name;


    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indicador general moldaje</title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>
    <!-- <link rel="stylesheet" href="../../../libs/css/mdb.min.css"> -->
    <style>
        body{
            font-family: 'Roboto',sans-serif !important;
            font-size: 11px !important;
            padding-top: 60px !important;
        }
        
        /* td,th{
            padding: 1px !important;
        } */


        #tabletblgeneral{
            table-layout: fixed;
        }

        #tableclientes{
            table-layout: fixed;
        }


        .filafija .descripcion {
            width: 60px !important;
            overflow: auto !important;
            vertical-align: middle !important;
        }

        .filafija .columnas {
            width: 30px !important;
            overflow: auto !important;
            vertical-align: middle !important;
        }


        .tabletblgeneral td,th{
            padding: 4px !important;
            /* font-weight: normal !important; */
        }


        .table{
            margin-bottom: 0px !important;
        }
        hr{
            border:0.8px solid #fff;
        }
        label{
            margin-bottom: 0px !important;
        }
    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>


    <?php if(!isset($_POST["reporte"]) ): ?> 
        <!-- FILTROS -->
        <div class="container-fluid mt-3 pl-md-5 pr-md-5"> 

                <div class="row justify-content-md-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <form action="" method="POST" autocomplete="off">

                                    <!-- <div class="form-group">
                                        <label for="">Proveedor</label>
                                        <select name="proveedor" id="cboproveedor" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                                    </div> -->

        
                                    <div class="form-group">
                                        <label for="">Cliente</label>
                                        <select name="cliente" id="cbocliente" class="custom-select custom-select-sm select2" style="width: 100%;"></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Programa</label>
                                        <select name="programa[]" id="cboprograma" class="custom-select custom-select-sm select2" style="width: 100%;" multiple ></select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Estilo Cliente</label>
                                        <input type="text" name="estilocliente" class="form-control form-control-sm" >
                                    </div>

                                    <div class="form-group">
                                        <label for="">Estilo TSC</label>
                                        <input type="text" name="estilotsc" class="form-control form-control-sm" >
                                    </div>

                                    <div class="form-group">
                                        <label for="">Fecha Corte</label>
                                        <input type="date" name="fecha" class="form-control form-control-sm" value="<?php echo date("Y-m-d");?>"  required>
                                    </div>

                                    

                                    <div class="form-group">
                                        <input type="hidden" name="reporte" value="Y">
                                        <button class="btn btn-block btn-primary btn-sm" type="submit">Buscar</button>
                                    </div>
                                </form>
                            


                            </div>
                        </div>
                    </div>
                </div>
                
        </div>
    <?php else: ?> 
        <!-- INDICADOR -->
        <div class="container-fluid mt-3 pl-md-5 pr-md-5 text-center">

            <div class="row justify-content-md-center">

                    <!-- EXPORTAR PDF -->
                    <form class="col-md-8" id="frmvolver" method="POST">
                        <input type="hidden" name="notreporte" value="N">
                        <button class="btn btn-sm btn-warning" type="submit" id="btnvolver"> <i class="fas fa-arrow-left"></i> Volver  </button>
                        <button class="btn btn-sm btn-danger" type="button" id="btnexportarpdf">Exportar <i class="fas fa-file-pdf"></i> </button>
                    </form>

                    <!-- DESCRIPCIONES -->
                    <div class="col-md-8 text-white pt-1" style="font-size: 13px !important;">
                        <label>INDICADOR GENERAL DE MOLDES</label>
                        <br>


                        <!-- CLIENTE -->
                        <label >CLIENTE:</label> 
                        <label id="lblcliente"></label>
                        <label >/</label> 

                        <!-- ESTILO CLIENTE-->
                        <label >ESTILO CLIENTE:</label> 
                        <label id="lblestilocliente"></label>
                        <label >/</label> 

                        <!-- ESTILO TSC -->
                        <label >ESTILO TSC:</label> 
                        <label id="lblestilotsc"></label>
                        <label >/</label> 

                        <!-- PROGRAMA -->
                        <label >PROGRAMA:</label> 
                        <label id="lblprograma"></label>
                        <label >/</label> 

                        <!-- FECHA -->
                        <label >FECHA:</label> 
                        <label id="lblfecha"></label>

                    </div>

                    <!-- GRAFICO GENERAL -->
                    <div class="card col-md-8" >
                        <div class="card-body pt-0">
                            <div class="form-group" id="chartgeneralcontainer" style="height: 400px;">
                                <canvas id="chartgeneral" ></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA -->
                    <div class="card col-md-12 p-0 mt-3">

                        <div class="table-responsive">
                            <!-- <div class="form-group"> -->
                                <table class="table table-sm  text-center table-bordered-sistema" id="tabletblgeneral">
                                    <thead id="theadtblgeneral" class="thead-sistema"></thead>
                                    <tbody id="tbodytblgeneral"></tbody>
                                    <tfoot id="tfoottblgeneral"></tfoot>
                                </table>
                            <!-- </div> -->
                        </div>
                        
                    </div>

                    <!-- CLIENTES -->
                    <div class="col-md-8 text-white mt-2" style="font-size: 13px !important;">
                        <!-- <hr> -->
                       
                        <div class="row justify-content-md-center">
                            <div class="col-md-3">
                                <button class="btn btn-sm btn-success btn-block" data-toggle="collapse" data-target="#collapseclientes" aria-expanded="false" aria-controls="collapseclientes">
                                    CLIENTES
                                </button>
                            </div>
                        </div>
                        
                    </div>

                    <!-- TABLA CLIENTES -->
                    <div class="card col-md-12 mt-1  p-0" >
                        <div class="collapse" id="collapseclientes">

                            <div class="table-responsive">
                                
                                <table class="table table-sm  text-center table-bordered-sistema" id="tableclientes">
                                    <thead class="thead-sistema" id="theadclientes"></thead>
                                    <tbody id="tbodyclientes"></tbody>
                                </table>
                                
                            </div>

                        </div>
                    </div>

                   
                         

            </div>

        </div>



    <?php endif; ?> 


<div class="loader"></div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>


<script src="../../js/encogimientocorte/settablaindicadormoldaje.js"></script>
<script src="../../js/encogimientocorte/setgraficoindicador.js"></script>
<script src="../../js/encogimientocorte/settablaclimoldes.js"></script>
<!-- <script src="../../js/testing/functionsindicadortesting.js"></script> -->


<script>
    // DATOS GENERALES
    let LABELS = [];
    let CONFIINDICADORTESTING = [];
    let BACKCOLORGRAFICO = [];
    let CLIENTES        = [];


    // KILOS GENERAL
    // let TOTALKG = [];
    // let TOTALKGAPRO = [];
    // let TOTALKGAPRONOCON = [];
    // let TOTALKGRECH = [];
    // let TOTALKGOTROS = [];

    // TOTALES UNIDADES
    let TOTALLIBERADASPORCENTAJE = [];
    let TOTALPENDIENTESPORCENTAJE = [];

    // TOTALES CANTIDAD
    let TOTALLIBERADASPORCENTAJE_CANT   = [];
    let TOTALPENDIENTESPORCENTAJE_CANT  = [];


    // UNIDADES
    let TOTALFICHAS = [];
    let TOTALLIBERADAS = [];
    let TOTALPENDIENTES = [];

    // CANTIDAD
    let TOTALFICHAS_CANT = [];
    let TOTALLIBERADAS_CANT = [];
    let TOTALPENDIENTES_CANT = [];

    // KILOS PROVEEDORES
    // let TOTALPROVEDORESKG = [];
    // let TOTALPROVEDORESKGAPRO = [];
    // let TOTALPROVEDORESKGAPRONOCON = [];
    // let TOTALPROVEDORESKGRECH = [];
    // let TOTALPROVEDORESKGOTROS = [];

    
    // DATA GENERAL
    let DATAGENERAL             = [];
    let DATAGENERAL_CANT        = [];



    // FILTROS 
    let SEDES = [];
    let TIPOSERVICIO = [];
    let TALLER = [];
    let PROVEEDOR = [];
    let CLIENTE = [];
    let TIPOTELA = [];

    let fecha = "",cliente = "",estilocliente="",estilotsc ="",programa="";
    let filtros = "";
    let primermayodefecto1 = "";
    let segundomayodefecto1 = "";
    let primermayodefecto2 = "";
    let segundomayodefecto2 = "";
    let MOSTRARFILAS = false;



    //  LOAD
    window.addEventListener('load',async ()=>{
        
        // INDICADOR PRENDAS POR DEPURAR
        CONFIINDICADORTESTING = await getMantIndicadores(4);
 

        // await getproveedores();
        await getclientes();
        // await gettipotela();


        // INDICADOR
        await getIndicador();

        $(".loader").fadeOut("slow");
    });
    
    // FUNCION
    async function getIndicador(){


        fecha           = "<?php echo isset($_POST["fecha"]) ? $_POST["fecha"] : "";  ?>";
        cliente         = "<?php echo isset($_POST["cliente"]) ? $_POST["cliente"] : "";  ?>";
        estilocliente   = "<?php echo isset($_POST["estilocliente"]) ? $_POST["estilocliente"] : "";  ?>";
        estilotsc       = "<?php echo isset($_POST["estilotsc"]) ? $_POST["estilotsc"] : "";  ?>";
        programa        = "<?php echo isset($_POST["programa"]) ? join("','",$_POST["programa"]) : "";  ?>";



        let reporte = "<?php echo isset($_POST["reporte"]) ? $_POST["reporte"] : "";  ?>";

        // PARA MOSTRAR FILTROS
        let lblfecha        = fecha;
        // let lblproveedor    = proveedor == "" ? "(TODOS)" : PROVEEDOR.find(obj => obj.IDPROVEEDOR == proveedor).DESCRIPCIONPROVEEDOR;
        let lblcliente              = cliente == "" ? "(TODOS)" : CLIENTES.find(obj => obj.IDCLIENTE == cliente).DESCRIPCIONCLIENTE;
        let lblestilocliente        = estilocliente == "" ? "(TODOS)" : estilocliente;
        let lblestilotsc            = estilotsc == "" ? "(TODOS)" : estilotsc;
        let lblprograma             = programa == "" ? "(TODOS)" : programa;


        // TRAEMOS DATOS
        if(reporte == "Y"){

            // ASIGNAMOS DATOS
            // $("#lblproveedor").text(lblproveedor);
            $("#lblcliente").text(lblcliente);
            $("#lblestilocliente").text(lblestilocliente);
            $("#lblestilotsc").text(lblestilotsc);
            $("#lblprograma").text(lblprograma);
            $("#lblfecha").text(lblfecha);


            // PARAMETROS
            let parametros = [
                // fecha,null,null,null,null,null
                fecha,cliente,estilocliente,estilotsc,programa,null
            ];

            // '2021-09-16',NULL,NULL,NULL,NULL,NULL

            filtros = lblcliente + " / " + lblestilocliente + " / " + lblestilotsc + " / " + lblprograma + " / "  + lblfecha;

            // INDICADOR GENERAL
            await getIndicadorGeneral(parametros);

            // INDICADOR PROVEEDORES
            

            // INDICADOR CLIENTES
            // if(cliente == null || cliente == ""){
            //     await getIndicadorClientes(parametros);
            // }

    
        }

    }

     // GET GENERALES
    async function getIndicadorGeneral(parametros){
        try{
            // GENERAL UNIDAD
            let response  = await post("auditex-moldes","indicadormoldes","getindicadorgeneral",parametros);

            // GENERAL CANTIDAD FICHA
            let response_cant  = await post("auditex-moldes","indicadormoldes","getindicadorgeneral-cantfichas",parametros);

            console.log("indicador",response,response_cant);

            setTablaIndicador(response,"tblgeneral",response_cant);

            // return response;    
        }catch(error){
            console.log(error);
            Advertir("Ocurrio un error al generar indicador");
        }
    } 

    // EXPORTAR PDF
    $("#btnexportarpdf").click(function(){

        MostrarCarga("Cargando...");


        // let parameters = [
        //     document.getElementById("chartgeneral").toDataURL("image/png")
        // ];


        var form = document.createElement("form");

        // // CONFIGURAMOS ATRIBUTOS DEL FORMULARIO
        form.method = "POST";
        form.action = "pdf/pdfindicadormoldaje_new.report.php";   
        form.target = "_blank";

        var imagen = document.createElement("input");  
        imagen.value= document.getElementById("chartgeneral").toDataURL("image/png");
        imagen.name = "imagen";
        form.appendChild(imagen);

        // AGREGAMOS INPUT AL FORMULARIO
        document.body.appendChild(form);

        // ENVIAMOS FORMULARIO
        form.submit();

        // REMOVEMOS FORMULARIO
        document.body.removeChild(form);

        InformarMini("Correcto");


            
    });


    // MOSTRAR Y OCULTAR FILAS
    $("#tbodytblgeneral").on('click','#btnmostrarfilas',function(){

        MOSTRARFILAS = !MOSTRARFILAS;

        if(MOSTRARFILAS){
            $(this).text("Ocultar");
            $(".filasocultas").removeClass("d-none");
        }else{
            $(this).text("Mostrar");
            $(".filasocultas").addClass("d-none");
        }


    });

    // DATOS DE TELA
    function getDatosTabla(idthead,idtbody,idtfoot) {

        // HEAD
        let thead = document.getElementById(idthead);
        let trthead = thead.children[0];
        let THEADDATOS = [];
        let TBODY = [];

        if(trthead.children.length > 0){

            for (let i = 0; i < trthead.children.length; i++) {
                THEADDATOS.push(trthead.children[i].innerText);
            }

        }



        // TBODYS
        let tbody   = document.getElementById(idtbody);

        if(tbody.children.length > 0){

            for(let i = 0; i < tbody.children.length; i++){

                let tr              = tbody.children[i];
                let trarray = [];
                for(let j = 0; j < tr.children.length; j++){

                    let td      =  tr.children[j];

                    let texto           = td.innerText;
                    // let background      = td.style.background;
                    let background      = td.dataset.color;
                    background = background ? hexToRgb(background) : "";

                    trarray.push(
                        {
                            texto,
                            background
                        }
                    );
                }

                TBODY.push(trarray);        
            }

        }




        // DEVOLVEMOS DATOS
        return {
            thead: THEADDATOS,
            tbody: TBODY
        }

    }

    // GET PROVEEDORES
    async function getclientes(){
        // CLIENTES = await get("auditex-testing","testing","getclientes",{});
        // setComboSimple("cbocliente",CLIENTES,"DESCRIPCIONCLIENTE","IDCLIENTE",true);

        CLIENTES = await get("auditex-moldes","encogimientoscorte","getclientes",{});
        setComboSimple("cbocliente",CLIENTES,"DESCRIPCIONCLIENTE","IDCLIENTE",true);

    }


    // PROGRAMA SEGUN CLIENTE
    async function getprogramacliente(idcliente){

        let response = await get("auditex-testing","testing","getprogramacliente",{
            idcliente
        });
        // console.log(response);
        setComboSimple("cboprograma",response,"PROGRAMA","PROGRAMA");

    }

    // PROGRAMA SSEGUN CLIENTE
    $("#cbocliente").change(function(){
        let id = $("#cbocliente").val();
        getprogramacliente(id).then(response => {

        }).catch(error => {
            Advertir("Ocurrio un error al obtener programa");
            console.log(error);
        })
    });

    // GET CLIENTES
    async function getIndicadorClientes(parametros){
        try{

            // UNIDADES
            let response  = await post("auditex-moldes","indicadormoldes","getindicadorclientes",parametros);

            // CANTIDAD FICHA
            let response_cantidad  = await post("auditex-moldes","indicadormoldes","getindicadorclientes-cantfichas",parametros);

            
            setTablaIndicadorCliente(response,"clientes",response_cantidad);


        }catch(error){
            console.log(error);
            Advertir("Ocurrio un error al generar indicador");
        }
    } 


</script>


</body>
</html>