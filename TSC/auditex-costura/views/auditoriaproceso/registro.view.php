<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Registro Auditoria Proceso";
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
            margin-bottom: 0px !important;
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

    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container-fluid mt-3"> 

    
    <div class="row">

      <label class="col-label col-md-2 font-weight-bold">Ficha:</label>
      <label class="col-label col-md-10" id="lblficha"> <?= $_GET["ficha"]; ?>  </label>

      <label class="col-label col-md-2 font-weight-bold">Linea/Servicio:</label>
      <label class="col-label col-md-10" id="lbllineaservicio">  </label>

      <label class="col-label col-md-2 font-weight-bold">Cliente:</label>
      <label class="col-label col-md-10" id="lblcliente">   </label>

      <label class="col-label col-md-2 font-weight-bold">Color:</label>
      <label class="col-label col-md-10" id="lblcolor">   </label>

      <label class="col-label col-md-2 font-weight-bold">Partida:</label>
      <label class="col-label col-md-10" > 
          <a id="lblpartida" href="" target="_blank"></a>
      </label>

      <label class="col-label col-md-2 font-weight-bold">Aud. Final Corte:</label>
      <label class="col-label col-md-10" >   
        <a id="lblaudfinal" href="" target="_blank"></a>
      </label>
      
      <div class="col">
          <hr>
      </div>

    </div>
    
    <div class="row justify-content-md-center">

        <!-- OPERACIONES -->
        <div class="col-md-12">

            <label for="" class="font-weight-bold">Operaciones Agregadas:</label>

            <button class="btn btn-sm btn-primary float-right" type="button" id="btnagregaroperaciones">
                <i class="fas fa-plus"></i>
                Agregar Operación
            </button>

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-sm mt-4">
                    <thead class="thead-light text-center">
                        <tr>
                            <th class="border-table">Fecha</th>
                            <th class="border-table">Operador</th>
                            <th class="border-table">Operación</th>
                            <th class="border-table">Vez</th>
                            <th class="border-table">Cant Prendas</th>
                            <th class="border-table">Cant Defectos</th>
                            <th class="border-table">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyoperaciones" class="bg-white">

                    </tbody>
                </table>

            </div>

        </div>

        <!-- DEFECTOS -->
        <div class="col-md-12 mt-4">

            <label for="" class="font-weight-bold" id="lbldefectoperacion">Defectos Agregados de Operación:</label>

            <button class="btn btn-sm btn-primary float-right d-none" type="button" id="btnagregardefectos">
                <i class="fas fa-plus"></i>
                Agregar Defectos
            </button>

            <div class="table-responsive">

                
                <table class="table table-bordered table-hover table-sm mt-2">
                    <thead class="thead-light text-center">
                        <tr>
                            <th class="border-table">Defecto</th>
                            <th class="border-table">Cantidad</th>
                            <th class="border-table">Observación</th>
                            <th class="border-table">Eliminar</th>
                            <!-- <th class="border-table">Cant Prendas</th> -->
                            <!-- <th class="border-table">Estado</th> -->
                        </tr>
                    </thead>
                    <tbody id="tbodydefectos" class="bg-white">

                    </tbody>
                </table>

            </div>


        </div>

    </div>

    <div class="row justify-content-md-center">
        <!-- TERMINA AUD OPERACION -->
        <div class="col-md-3">
            <button id="btnterminaroperacion" type="button" class="d-none btn btn-secondary btn-sm btn-block">TERMINAR AUDITORIA DE OPERACIÓN</button>
        </div>
    </div>

    <div class="row justify-content-md-center mt-3">
         <!-- TERMINA AUDITORIA -->
         <div class="col-md-3">
            <button id="btnterminarauditoria" type="button" class="btn btn-danger btn-sm btn-block">TERMINAR AUDITORIA</button>
        </div>
    </div>

           

</div>


<!-- MODAL OPERACIONES -->
<div class="modal fade" id="modaloperaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Agregar Operaciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form action=""  id="frmoperaciones" autocomplete="off">

                <div class="form-group">
                    <label for="" style="color:#000">Operador</label>
                    <select name="" id="cbooperador" class="custom-select select2" sytle="widt:100%" required></select>
                </div>

                <div class="form-group">
                    <label for="" style="color:#000">Operación</label>
                    <select name="" id="cbooperacion" class="custom-select select2" sytle="widt:100%" required></select>
                </div>

                <div class="form-group">
                    <label for="" style="color:#000">Cantidad Prendas</label>
                    <input type="number" class="form-control form-control-sm" id="txtcantidadoperacion" required >
                </div>

                <div class="form-group">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-primary" type="submit">
                        <i class="fas fa-plus"></i>
                        Agregar Operación
                    </button>
                </div>


        </form>
        


      </div>

    </div>
  </div>
</div>

<!-- MODAL DEFECTOS -->
<div class="modal fade" id="modaldefectos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Agregar Defectos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form action=""  id="frmdefectos" autocomplete="off">

                <div class="form-group">
                    <label for="" style="color:#000">Defecto</label>
                    <select name="" id="cbodefecto" class="custom-select select2" sytle="widt:100%" required></select>
                </div>

                <div class="form-group">
                    <label for="" style="color:#000">Cantidad</label>
                    <input type="number" class="form-control form-control-sm" id="txtcantidaddefectos" required>
                </div>

                <div class="form-group">
                    <label for="" style="color:#000">Observación</label>
                    <input type="text" class="form-control form-control-sm" id="txtobservaciondefectos" >
                </div>

                <div class="form-group">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-primary" type="submit">
                        <i class="fas fa-plus"></i>
                        Agregar Defecto
                    </button>
                </div>


        </form>
        


      </div>

    </div>
  </div>
</div>


<div class="loader"></div>


<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script>

    let     codtipser_tll = "";
    let     SECUENCIA = null;
    let     CODOPERACION = null;
    let     CODPER      = null;
    let     NUMVEZ = null;
    let     DESOPE = null;
    let     SECUENCIAOPERACION = null;
    const   frmoperaciones  = document.getElementById("frmoperaciones");
    const   frmdefectos     = document.getElementById("frmdefectos");

    window.addEventListener('load',async ()=>{

        // INICIA AUDITORIA
        await IniciarAuditoria();

        // DATOS DE LA UDITORIA
        await getDatosAuditoriProceso();

        // GET  DATOS PARA AGREGAR
        await getDatosAgregar();

        // TERMINAR AUDITORIA
        $("#btnterminarauditoria").click(async function (){

            let rpt = await Preguntar("Confirme para terminar Auditoria");
            // console.log(rpt);
            if(rpt.value){  


                try{
                    // DATOS QUE VAMOS A DEVOLVER
                    let response;
                    // PARAMETROS 
                    let datos = {};

                    //  EJECUTAMOS
                    response = await $.ajax({
                        url :`/TSC-WEB/auditoriaproceso/config/endFichaAudPro.php`,
                        type:'post',
                        data:{
                            codfic: "<?= $_GET["ficha"] ?>",
                            secuen:SECUENCIA
                        }
                    })

                    if(response.state){
                        Informar("Terminado correctamente");
                        location.reload();
                    }

                    // console.log("terminado",response);


                }catch(error){
                    console.log(error);
                    Advertir("Ajax error: " + JSON.stringify(error));
                }


            }

        });

        // TERMINAR AUDITORIA DE OPERACION
        $("#btnterminaroperacion").click(async function(){

            let rpt = await Preguntar("Confirme para terminar auditoria de Operación");
            
            if(rpt.value){

                $(".loader").fadeIn("show");


                let response = await post("auditex-costura", "auditoriaproceso", "terminaroperacion", [
                    "<?= $_GET["ficha"] ?>",SECUENCIA,CODOPERACION,NUMVEZ,"<?= $_SESSION["user"]; ?>"
                ]);

                // console.log("Operacion end",response);
                if(response.success){
                    await getOperacionesAgregadas(SECUENCIA);
                    $("#btnagregardefectos").addClass("d-none");
                    $("#tbodydefectos").html("");
                    $("#lbldefectoperacion").text(`Defectos Agregados de Operación:`);
                    $("#btnterminaroperacion").addClass("d-none");



                    $(".loader").fadeOut("slow");

                }else{

                    Advertir("Ocurrio un error");
                    $(".loader").fadeOut("slow");

                }



            }

        });

        $(".loader").fadeOut("slow");
    });


    // INICIAR AUDITORIA
    async function IniciarAuditoria(){
        try{
            // DATOS QUE VAMOS A DEVOLVER
            let response;
            // PARAMETROS 
            let datos = {};

            // datos.operacion = operacion;
            // datos.parameters = parameters;
            
            //  EJECUTAMOS
            response = await $.ajax({
                url :`/TSC-WEB/auditoriaproceso/config/getFichaAudiPro.php`,
                type:'post',
                data:{
                    codfic: "<?= $_GET["ficha"] ?>",
                    codtll: "<?= $_GET["codtll"] ?>",
                    codusu: "<?= $_SESSION["codusu"] ?>",
                    turno:1,
                    secuen:0

                }
            })


            // ASIGNAMOS DATOS
            $("#lbllineaservicio").text(response.taller.DESTLL);
            $("#lblcliente").text(response.taller.DESCLI);
            $("#lblcolor").text(response.taller.DESCOL);


            // PARTIDA
            let rutapartida =  '/tsc-web/auditoriatela/VerAuditoriaTela.php?partida='+
            response.partida.PARTIDA+'&codtel='+response.partida.CODTEL+
				'&codprv='+response.partida.CODPRV+
				'&numvez='+	response.partida.NUMVEZ+
				'&parte='+response.partida.PARTE+
				'&codtad='+response.partida.CODTAD;

            $("#lblpartida").attr("href",rutapartida);
            $("#lblpartida").text(response.partida.PARTIDA);


            // AUD FINAL CORTE
            let rutafinal =  "/tsc-web/AuditoriaFinalCorte/ConsultarEditarAuditoria.php?codfic=<?= $_GET["ficha"] ?>";

            $("#lblaudfinal").attr("href",rutafinal);
            $("#lblaudfinal").text(response.partida.DESTLL);

            codtipser_tll = response.taller.CODTIPOSERV;
            SECUENCIA = response.secuen;
            // OPERACIONESA AGREGADAS
            await getOperacionesAgregadas(response.secuen);

        }catch(error){
            console.log(error);
            Advertir("Ajax error: " + JSON.stringify(error));
        }
    }


    // GET OPERACIONES AGREGADAS
    async function getOperacionesAgregadas(secuencia){

        let response = await get("auditex-costura", "auditoriaproceso", "getoperacionesagregadas", {
            ficha :"<?= $_GET["ficha"] ?>",
            secuencia
         });

        //  console.log(response);

        let tr = "";
        for(let item of response){

            let estado      = item.ESTADO != null ? item.ESTADO : "";
            let usuariofin  = item.USUARIOFIN != null ? item.USUARIOFIN : "";

            tr +=  `
                <tr onclick="getDefectosAgregados(${secuencia},${item.CODOPE},${item.CODPER},${item.NUMVEZ},'${item.DESOPE}','${usuariofin}','${item.SECUENCIAOOPERACION}')">

                    <td class="text-center">${item.FECHAINICIOCHAR}</td>
                    <td class="text-center">${item.NOMPER}</td>
                    <td class="text-center">${item.DESOPE}</td>
                    <td class="text-center">${item.NUMVEZ}</td>
                    <td class="text-center">${item.CANTPRENDA}</td>
                    <td class="text-center">${item.CANDEF}</td>
                    <td class="text-center">${estado}</td>

                </tr>
            `;
        }

        $("#tbodyoperaciones").html(tr)

    }


    // GET DATOS PARA AGREGAR
    async function getDatosAgregar(){

        try{
            // DATOS QUE VAMOS A DEVOLVER
            // let response;
            // // PARAMETROS
            // let datos = {};

            //  EJECUTAMOS
            // response = await $.ajax({
            //     url :`/TSC-WEB/auditoriaproceso/config/getDataAudPro.php`,
            //     type:'post',
            //     data:{
            //     }
            // })

            let response = await get("auditex-costura", "auditoriaproceso", "getDataAudPro");

            let listaOperadores = [];

            if(codtipser_tll=="2"||codtipser_tll=="1"){
				listaOperadores.push(
                    {
                        CODPER: 0,
                        NOMPER: "OPERARIO GENERICO (0)"
                    }
                );
			}else{
				for (var i = 0; i < response.operadores.length; i++) {
					if (response.operadores[i].CODPER!="0") {
						listaOperadores.push(response.operadores[i]);
					}
				}
			}

            // OPERADORES
            setComboSimple("cbooperador",listaOperadores,"NOMPER","CODPER");

            // OPERACIONES
            setComboSimple("cbooperacion",response.operaciones,"DESOPE","CODOPE");

            // DEFECTOS
            setComboSimple("cbodefecto",response.defectos,"DESDEF","CODDEF");


        }catch(error){
            console.log(error);
            Advertir("Ajax error: " + JSON.stringify(error));
        }


    }

    // GET DATOS AUDITORIA PROCESO
    async function getDatosAuditoriProceso(){

        let response = await get("auditex-costura", "auditoriaproceso", "getauditoriproceso", {
            ficha :"<?= $_GET["ficha"] ?>",
            secuencia:SECUENCIA,
            taller:"<?= $_GET["codtll"] ?>"
        });
        
        if(response){

            if(response.FECFIN != null){

                $("#btnagregaroperaciones").addClass("d-none");
                $("#btnterminarauditoria").addClass("d-none");

            }

        }

        // console.log("DATOS AUDI",response);

    }

    // GET OPERACIONES AGREGADAS
    async function getDefectosAgregados(secuencia,ope,codper,numvez,desope,usuariofin,secuenciaoperacion = 0){

        $(".loader").fadeIn("show");

        if(usuariofin != null && usuariofin != ""){
            $("#btnterminaroperacion").addClass("d-none");
            $("#btnagregardefectos").addClass("d-none");

        }

        if(usuariofin == null || usuariofin == ""){
            $("#btnterminaroperacion").removeClass("d-none");
            $("#btnagregardefectos").removeClass("d-none");
        }


        $("#lbldefectoperacion").text(`Defectos Agregados de Operación: ${desope}`);

        DESOPE              = desope;
        CODOPERACION        = ope;
        CODPER              = codper;
        NUMVEZ              = numvez;
        SECUENCIAOPERACION  = secuenciaoperacion;

        let response = await get("auditex-costura", "auditoriaproceso", "getdefectosagregados", {
            ficha :"<?= $_GET["ficha"] ?>",
            secuencia,
            ope,
            numvez,
            secuenciaoperacion
        });

        //  console.log(response);

        let tr = "";
        for(let item of response){
            let observacion = item.OBSERVACION != null ? item.OBSERVACION : "";

            let bnteliminar = "";

            if(item.CERRADO == "0"){
                bnteliminar = `

                    <button class='btn btn-sm btn-danger' type='button' onclick="EliminarDefecto(${item.CODFIC},${item.SECUEN},${item.CODOPE},${item.CODDEF},${item.NUMVEZ})" >Eliminar</button>
                
                `;
            }

            tr +=  `
                <tr >
                    <td class="text-center">${item.DESDEF}</td>
                    <td class="text-center">${item.CANDEF}</td>
                    <td class="text-center">${observacion}</td>
                    <td class="text-center">
                        ${bnteliminar}
                    </td>
                </tr>
            `;
        }

        $("#tbodydefectos").html(tr);
        $(".loader").fadeOut("slow");


    }

    // ABRIL MODAL PARA AGREGAR OPERACION
    $("#btnagregaroperaciones").click(function(){
        frmoperaciones.reset();
        $("#cbooperacion").val("").trigger("change");
        $("#cbooperador").val("").trigger("change");

        $("#modaloperaciones").modal("show");
    });

    $("#btnagregardefectos").click(function(){
        if(CODOPERACION != null){

            $("#cbodefecto").val("").trigger("change");
            $("#modaldefectos").modal("show");
            
        }else{
            Advertir("Seleccione una operación primero")
        }
    });


    // AGREGAR OPERACION
    frmoperaciones.addEventListener('submit',async (e)=>{
        e.preventDefault();

        let cantpren  = $("#txtcantidadoperacion").val().trim();

        // let response = await Verificaoperacion($("#cbooperacion").val());

        // if(response.CANT == 0){

            if(cantpren >= 10 ){
            await saveOperacion(cantpren);

            }else{
                // Advertir("La cantidad de prenda debe ser mayor a 0")
                let rpt = await Preguntar("La cantidad de prendas debe ser a 10, confirme para guardar");
                if (rpt.value){
                    await saveOperacion(cantpren);
                }
            }

        // }else{
            // Advertir("Operación duplicada");
        // }

        



    });

    async function saveOperacion(cantpren){

        try{
                $(".loader").fadeIn("show");

                // DATOS QUE VAMOS A DEVOLVER
                let response;
                // PARAMETROS 
                let datos = {};

                //  EJECUTAMOS
                response = await $.ajax({
                    url :`/TSC-WEB/auditoriaproceso/config/saveOpeAudPro.php`,
                    type:'post',
                    data:{
                        codfic :  "<?= $_GET["ficha"] ?>",
                        secuen: SECUENCIA,
                        codper: $("#cbooperador").val(),
                        codope: $("#cbooperacion").val(),
                        cantpren,
                        // secuenciaoperacion:SECUENCIAOPERACION
                    }
                });

                if(response.state){

                    await getOperacionesAgregadas(SECUENCIA);
                    $("#modaloperaciones").modal("hide");
                    frmoperaciones.reset();
                    $("#cbooperacion").val("").trigger("change");
                    $("#cbooperador").val("").trigger("change");
                    $(".loader").fadeOut("slow");

                }else{
                    $(".loader").fadeOut("slow");
                    Advertir(response.error.detail);
                }



            }catch(error){
                $(".loader").fadeOut("slow");
                console.log(error);
                Advertir("Ajax error: " + JSON.stringify(error));
            }

    }

    async function Verificaoperacion(idoperacion){

        return await get("auditex-costura", "auditoriaproceso", "verificaoperacionregistrada", {
            ficha :"<?= $_GET["ficha"] ?>",
            secuencia:SECUENCIA,
            idoperacion
            // numvez
        });

    }

    async function VerificaDefecto(idoperacion,iddefecto){

        return await get("auditex-costura", "auditoriaproceso", "verificadefectoregistrada", {
            ficha :"<?= $_GET["ficha"] ?>",
            secuencia:SECUENCIA,
            idoperacion,iddefecto,
            numvez:NUMVEZ
            // numvez
        });

    }

    function EliminarDefecto(ficha,secuencia,codoperacion,coddef,numvez){


        Preguntar("Confirme para Eliminar Defecto")
            .then(rpt => {

                if(rpt.value){

                    $(".loader").fadeIn("show");

                    get("auditex-costura", "auditoriaproceso", "eliminardefecto", {
                        ficha,secuencia,codoperacion,coddef,numvez
                    }).then(async response =>{

                        if(response.success){
                            await getDefectosAgregados(SECUENCIA,CODOPERACION,CODPER,NUMVEZ,DESOPE,null,SECUENCIAOPERACION);
                        }else{
                            Advertir("Error al eliminar defecto");
                        }

                        $(".loader").fadeOut("slow");

                    }).catch(error => {
                        $(".loader").fadeOut("slow");
                        Advertir("Error al eliminar defecto");
                    })



                }

            }).catch(error => {

            });

    }


    // AGREGAR DEFECTOS
    frmdefectos.addEventListener('submit',async (e)=>{

        e.preventDefault();

        let candef  = $("#txtcantidaddefectos").val().trim();

        if(candef > 0 ){

            let verifica = await VerificaDefecto(CODOPERACION,$("#cbodefecto").val());

            if(verifica.CANT == 0){

                try{
                    $(".loader").fadeIn("show");

                    // DATOS QUE VAMOS A DEVOLVER
                    let response;
                    // PARAMETROS 
                    let datos = {};

                    //  EJECUTAMOS
                    response = await $.ajax({
                        url :`/TSC-WEB/auditoriaproceso/config/saveDefAudPro.php`,
                        type:'post',
                        data:{
                            codfic:  "<?= $_GET["ficha"] ?>",
                            secuen: SECUENCIA,
                            codope: CODOPERACION,
                            codper: CODPER,
                            numvez: NUMVEZ,
                            usuario: "<?= $_SESSION["user"]; ?>",
                            coddef: $("#cbodefecto").val(),
                            observacion:  $("#txtobservaciondefectos").val().trim(),
                            candef,
                        }
                    });

                    // console.log(response);

                    if(response.state){

                        await getOperacionesAgregadas(SECUENCIA);
                        await getDefectosAgregados(SECUENCIA,CODOPERACION,CODPER,NUMVEZ,DESOPE,null,SECUENCIAOPERACION);
                        $("#modaldefectos").modal("hide");
                            frmdefectos.reset();
                            $("#cbodefecto").val("").trigger("change");
                            $(".loader").fadeOut("slow");


                            if(parseFloat(response.maxdefectos) > 4){
                                Advertir("Auditoria rechazada")
                            }                        

                    }else{
                        $(".loader").fadeOut("slow");
                        Advertir("Ocurrio un error");
                    }



                }catch(error){
                    console.log(error);
                    $(".loader").fadeOut("slow");
                    Advertir("Ajax error: " + JSON.stringify(error));
                }


            }else{
                Advertir("Defecto duplicado");
            }

            

        }else{
            Advertir("La cantidad de prenda debe ser mayor a 0")
        }

    });

</script>



</body>
</html>