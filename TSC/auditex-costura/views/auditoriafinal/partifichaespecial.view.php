<?php
	session_start();
	date_default_timezone_set('America/Lima');

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    require_once __DIR__.'../../../../models/modelo/sistema.modelo.php';

	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $objModelo = new CoreModelo();
    $_SESSION['navbar'] = "Partir Ficha Auditoria Final - Costura";


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

        #frmbusqueda  label{
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


        /* th:first-child, td:first-child{
            position:sticky;
            left:0px;
            background: #e9ecef  !important;
        } */

    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container mt-3">

    <div class="row justify-content-center">

        <form action="" class="row col-12" id="frmbusqueda" autocomplete="off">

            <div class="col-md-2 col-sm-2">
                <label for="">Ficha:</label>
            </div>

            <div class="col-md-8 col-sm-8">
                <input type="number" class="form-control form-control-sm" id="txtficha" required autofocus >
            </div>

            <div class="col-md-2 col-sm-2">
                <button class="btn btn-sm btn-block btn-secondary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>

        </form>

        <div class="mt-3 col-12 container-particiones d-none" >
            <table class="table table-bordered table-sm text-center">
                <thead class="bg-sistema text-white">
                    <tr>
                        <th>FICHA</th>
                        <th>TIPO AUDITORIA</th>
                        <th>PARTE</th>
                        <th>VEZ</th>
                        <th>PRENDAS</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody id="tbodyfichas" class="bg-white">

                </tbody>
            </table>
        </div>

        <div class="col-12 container-particiones d-none">
            <hr style="background:#fff">
        </div>

        <!-- INFO FICHA -->
        <div class="col-12 text-white container-info d-none">

            <div class="row">

                <div class="col-12">
                    <label for="" id="lbltaller"> </label>
                </div>

                <div class="col-12">
                    <label for="" id="lblficha">  </label>
                </div>

                <div class="col-12">
                    <label for="" id="lblcantidaddeprendas"> </label>
                </div>

                <div class="col-10">
                    <label for="" id="">
                        <b>CANTIDAD DE PRENDAS DE FICHA PARCIAL:</b>
                    </label>
                </div>

                <div class="col-2">
                    <input type="text" id="txtcantidadparcial" class="form-control form-control-sm" readonly="true">
                </div>

            </div>


        </div>

        <div class="col-12 container-info d-none">
            <hr style="background:#fff">
        </div>

        <!-- PARTICIONAR -->
        <div class="col-md-4 mt-3 container-particionar d-none">
            <table class="table table-bordered table-sm text-center tablainput ">
                <thead class="bg-sistema text-white">
                    <tr>
                        <th>Talla</th>
                        <th>C. Parcial</th>
                        <th>C. Disponible</th>
                    </tr>
                </thead>
                <tbody id="tbodytallas" class="bg-white">

                </tbody>
            </table>
        </div>

        <div class="col-md-8 mt-3 container-particionar d-none">

            <form class="row mb-2" id="frmregistrooperaciones">

                <div class="col-10">
                    <select style="width:100%" id="cbooperaciones" class="custom-select custom-select-sm select2"></select>
                    <!-- <select style="width:100%" id="cbooperaciones" class="custom-select custom-select-sm "></select> -->
                </div>
                <!-- <div class="col-2">
                    <input type="number" class="form-control form-control-sm" id="txtcantidadoperacion" min="0" required>
                </div> -->
                <div class="col-2">
                    <button class="btn btn-block btn-sm btn-secondary butonsregistros" type="submit">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

            </form>

            <table class="table table-bordered table-sm text-center tablainput">
                <thead class="bg-sistema text-white">
                    <tr>
                        <th>OPERACION</th>
                        <th>CANTIDAD</th>
                        <th>OP</th>
                    </tr>
                </thead>
                <tbody id="tbodyoperaciones" class="bg-white">

                </tbody>
            </table>
        </div>

        <div class="col-md-3 container-particionar d-none">
            <button class="btn btn-sm btn-block btn-secondary butonsregistros" type="button" id="btnpartirficha">
                PARTIR FICHA
            </button>
        </div>


    </div>

</div>

<div class="loader"></div>


<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script>

    const   frmbusqueda             = document.getElementById("frmbusqueda");
    const   frmregistrooperaciones  = document.getElementById("frmregistrooperaciones");
    const   btnpartirficha          = document.getElementById("btnpartirficha");
    let     DATAFICHAS              = [];
    let     FICHA                   = null;
    let     PARTE                   = null;
    let     NUMVEZ                  = null;
    let     HABILREGISTRO           = false;
    let     CODAQL                  = 0;
    let     fsfpcantidad            = 0;
    let     CODTAD                  = null;
    let     CODTLL                  = null;

    btnpartirficha.addEventListener('click',async ()=> {
        if(HABILREGISTRO){
            await partirFicha();
        }
    });


    // LOAD PAGE
    window.addEventListener('load',async ()=>{
        $(".loader").fadeOut("slow");
    });

    // BUSQUEDA
    frmbusqueda.addEventListener("submit",(e)=> {
        e.preventDefault();

        // OCULTAMOS
        $(".container-particiones").addClass("d-none");
        $(".container-info").addClass("d-none");
        $(".container-particionar").addClass("d-none");


        BuscarFichas();
    });

    // REGISTRO DE OPERACIONES
    frmregistrooperaciones.addEventListener("submit",async (e)=> {
        e.preventDefault();
        if(HABILREGISTRO){
            // await SaveOperaciones();

            let codoperacion    = $("#cbooperaciones").val();
            // let operacion       = $("#cbooperaciones option:selected").text();
            let operacion       = $("#cbooperaciones").find(':selected').data('ope');
            let disponible      = $("#cbooperaciones").find(':selected').data('disponible');
            let cantidad        = $("#txtcantidadparcial").val() == '' ? 0 : $("#txtcantidadparcial").val();

            disponible  = parseFloat(disponible);
            cantidad    = parseFloat(cantidad);

            if(cantidad > 0){

                if(operacion != null && operacion != ''){
                    await SaveDeleteOperaciones(FICHA,operacion,codoperacion,PARTE,NUMVEZ,cantidad,1);
                }else{
                    Advertir("Seleccione una operación");
                }

                // if(disponible >= cantidad ){
                // }else{
                    // Advertir("La cantidad ingresada, supera a la cantidad disponible");
                // }

            }else{
                Advertir("La cantidad parcial debe ser mayor a cero");
            }

        }
    });

    // BUSCAR FICHAS
    function BuscarFichas(){

        MostrarCarga("Cargando...");
        let ficha = $("#txtficha").val().trim();
        FICHA = ficha;

        get("auditex-costura","auditoriafinal","getficha",{ficha})
        .then(response => {

            if(response.responseficha){
                let tr = "";
                DATAFICHAS = response.responseficha;

                // RESPONSE FICHAS
                for(let item of response.responseficha){

                    let estado      = item.ESTADO == "T" ? "TERMINADO" : "PENDIENTE";
                    let bgblock     = item.ESTADO == "T" ? "bg-secondary" : "";
                    let dataselect  = item.ESTADO == "P" ? "1" : "0";

                    tr += `
                        <tr class="${bgblock} seleccionar"
                            data-select="${dataselect}"
                            data-parte="${item.PARTE}"
                            data-vez="${item.NUMVEZ}"
                            data-canpar="${item.CANPAR}"
                            data-codaql="${item.CODAQL}"
                            data-codtad="${item.CODTAD}"
                            data-codtll="${item.CODTLL}"
                            >

                            <td> ${item.CODFIC} </td>
                            <td> ESPECIAL </td>
                            <td> ${item.PARTE} </td>
                            <td> ${item.NUMVEZ} </td>
                            <td> ${item.CANPAR} </td>
                            <td>
                                ${estado}
                            </td>
                        </tr>
                    `;
                }


                $("#tbodyfichas").html(tr);
                OcultarCarga();
                $(".container-particiones").removeClass("d-none");
                // container-particiones
            }else{
                $(".container-particiones").addClass("d-none");
            }

        })
        .catch(error => {
            console.log(error,"error");
            Advertir("Ocurrio un error");
        });

    }

    // REGISTRO DE OPERACIONES
    async function SaveDeleteOperaciones(ficha,operacion,codoperacion,parte,vez,cantidad = 0,opcion = 1){

        MostrarCarga("Cargando...");

        post("auditex-costura", "auditoriafinal", "saveoperacion", [
            opcion,ficha, vez,parte,codoperacion,operacion,cantidad
        ])
        .then(async (response) => {
            if(response.responseset.success){

               // RESPONSE OPERACIONES
               setComboSimple("cbooperaciones",response.responseoperaciones,"OPERACION","COD_OPERACION",true, {OPE:"OPE",DISPONIBLE:"DISPONIBLE"});
               GetOperaciones(response.responseoperacionesagregadas);

               $("#cbooperaciones").val("").trigger("change");
               frmregistrooperaciones.reset();
               OcultarCarga();
            }
        })
        .catch( (error) => {
            Advertir("Error");
        });

    }

    // GET TALLAS Y OPERACIONES
    async function GetTallas(parte,vez){

        let ficha = $("#txtficha").val().trim();

        let dataficha = DATAFICHAS.find(obj => obj.PARTE == parte && obj.NUMVEZ == vez);

        // ASIGNAMOS VALOR
        $("#lbltaller").html(`<b>TALLER/LINEA:</b> ${dataficha.DESTLL}`);
        $("#lblficha").html(`<b>FICHA:</b> ${dataficha.CODFIC}`);
        $("#lblcantidaddeprendas").html(`<b>CANTIDAD DE PRENDAS:</b> ${dataficha.CANPAR} de ${dataficha.CANPRE}`);

        let response = await get("auditex-costura","auditoriafinal","gettallafichas_operaciones",{
            ficha,opcion:2,parte,vez
        });

        let tr = "";

        for(let item of response.responsetallas){

            let cantidadreal = item.CANTIDAD == null ? 0 : item.CANTIDAD;
            let cantidaddisponible = item.CANPRE - item.CANTCONSU;

            tr += `
                <tr>
                    <td>${item.DESTAL}</td>
                    <td>
                        <input type='number'
                            data-idtalla='${item.CODTAL}'
                            data-max='${cantidaddisponible}'
                            max='${cantidaddisponible}'
                            value='${cantidadreal}'
                            class='txtcant inputtabla ' />
                    </td>
                    <td>
                        ${cantidaddisponible}
                    </td>
                </tr>
            `;
        }

        $("#tbodytallas").html(tr);

        // RESPONSE OPERACIONES
        setComboSimple("cbooperaciones",response.responseoperaciones,"OPERACION","COD_OPERACION",true, {OPE:"OPE",DISPONIBLE:"DISPONIBLE"});
    }

    // GET OPERACIONES
    function GetOperaciones(response){

        let tr = "";

        for(let item of response){

            tr += `
                <tr>
                        <td>${item.OPERACION}</td>
                        <td>${item.CANTIDAD}</td>
                        <td>
                            <a class="btn btn-danger btn-sm eliminarope "
                                href='#'
                                data-operacion="${item.CODOPERACION}"
                                data-ficha="${item.CODFIC}"
                                data-numvez="${item.NUMVEZ}"
                                data-parte="${item.PARTE}"
                            >
                                <i class='fas fa-trash'></i>
                            </a>
                        </td>
                </tr>
            `;
        }

        $("#tbodyoperaciones").html(tr);

    }

    function calcTot(){
        let cant = $(".txtcant");
        let tot = 0;
        for(let item of cant){
            let valor = $(item).val();

            valor = valor.trim() == "" ? 0 : valor.trim();
            tot += parseFloat( valor );
        }

        $("#txtcantidadparcial").val(tot);
    }

    function validacionTallas(){

        let cant = $(".txtcant");

        let totaltallas = 0;
        let totalparte 	= $("#txtcantidadparcial").val().trim() != "" ? parseFloat( $("#txtcantidadparcial").val().trim()) : 0;
        let error = false;


        for(let item of cant){

            let cant = $(item).val();
            let max = $(item).data("max");
            totaltallas += parseFloat(cant);

            if(cant > max){
                error = true;
            }

        }

        if(!error){
            if(totaltallas > totalparte){
                // alert("La cantidad no puede ser mayor a la cantidad parte");
                return {success:false,mensaje:"La cantidad no puede ser mayor a la cantidad parte"}
            }else{
                return {success:true,mensaje:"correcto"}
                // return true;
            }
        }else{
            // return false;
            return {success:false,mensaje:"La cantidad de una de las tallas es mayor a la cantidad mÃ¡xima"}

        }

    }

    // PARTIR TALLAS
    async function saveTallas(ficha,vez,parte,idtalla,cant){

        let response = await $.ajax({
            type:"POST",
            data:{
                ficha,vez,parte,idtalla,cant,operacion:'settallafichas'
            },
            url:"/tsc/controllers/auditex-costura/auditoriafinal.controller.php",
        });

        return response;
    }

    // PARTIR FICHAS
    async function partirFicha(){


        var cantidadIngresada = $("#txtcantidadparcial").val().trim();

        if(cantidadIngresada != ""){



            if (cantidadIngresada > fsfpcantidad) {
                Advertir("La cantidad no debe exceder a la total de la ficha!");
            }else{

                let validacion  = validacionTallas();

                $(".panelCarga").fadeIn(300);

                if(validacion.success){

                    let tallas = $(".txtcant");
                    // let idPartirconTalla = $("#idPartirconTalla").prop("checked");
                    let tallaspartir = [];

                    // if(idPartirconTalla){

                        // PARTIMOS TALLAS
                    for(let item of tallas){

                        let cant = $(item).val();
                        let idtalla = $(item).data("idtalla");
                        tallaspartir.push(
                            {
                                talla:idtalla,
                                cantidad:cant
                            }
                        );
                    }

                    // PARTIMOS GENERAL
                    await parttifichanew(tallaspartir);
                    // let partirgeneral = await parttifichanew(tallaspartir);
                    // $(".panelCarga").fadeOut(300);

                }else{
                    // alert(validacion.mensaje);
                    Advertir(validacion.mensaje);
                    // alert("La cantidad no puede ser mayor a la cantidad parte");
                }

            }


        }else{
            Advertir("Ingrese cantidad");
        }

    }

    // PARTIR GENERAL
    async function parttifichanew(tallaspartir){

        MostrarCarga("Cargando...");

        post("auditex-costura", "auditoriafinal", "settallafichas_generales", [
            FICHA,NUMVEZ,PARTE,CODTAD,CODAQL,$("#txtcantidadparcial").val().trim(),CODTLL,null,"<?= $_SESSION["user"];?>",tallaspartir
        ])
        .then( (response) => {

            // console.log("response partir",response);
            if (response.success) {
                Informar("Ficha partida!",1500,true);
                // Informar("Ficha partida!");

            }else{
                Advertir("No se pudo partir la ficha!");
            }
        })
        .catch( (error) => {
            Advertir("Error");
        });

    }

    // SELECCIONAR FICHA
    $("#tbodyfichas").on('click','.seleccionar',async function(){

        let select      = $(this).data("select");
        let parte       = $(this).data("parte");
        let vez         = $(this).data("vez");
        let codaql      = $(this).data("codaql");
        let codtad      = $(this).data("codtad");
        let codtll      = $(this).data("codtll");
        fsfpcantidad    = $(this).data("canpar");

        PARTE   = parte;
        NUMVEZ  = vez;
        CODAQL  = codaql;
        CODTAD  = codtad;
        CODTLL  = codtll;

        MostrarCarga();
        await GetTallas(parte,vez);
        let responseoperaciones = await get("auditex-costura","auditoriafinal","getoperacionesagregadas",{
            ficha: FICHA,parte:PARTE,vez:NUMVEZ
        });

        GetOperaciones(responseoperaciones);

        // PARA PODER PARTIR
        if(select == 1){

            HABILREGISTRO = true;
            $(".butonsregistros").removeClass("d-none");
            $(".eliminarope").removeClass("d-none");
            OcultarCarga();
        }else{

            HABILREGISTRO = false;
            $(".butonsregistros").addClass("d-none");
            $(".eliminarope").addClass("d-none");
            Advertir("Ficha terminada, no se puede partir");
        }

        $(".container-info").removeClass("d-none");
        $(".container-particionar").removeClass("d-none");

    });

    // SELECCIONAR OPERACION
    $("#tbodyoperaciones").on('click','.eliminarope',async function(){

        let operacion   = $(this).data("operacion");
        let ficha       = $(this).data("ficha");
        let parte       = $(this).data("parte");
        let numvez      = $(this).data("numvez");

        let rpt = await Preguntar("Confirme para eliminar operación");

        if(rpt.value){
            await SaveDeleteOperaciones(ficha,'',operacion,parte,numvez,0,2);
        }

    });

    $("#tbodytallas").on('keyup','.txtcant',function(){
        calcTot();
    });


</script>



</body>
</html>