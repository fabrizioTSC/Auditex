<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}

    $_SESSION['navbar'] = "Configuración de correos";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuracion de envio de correos</title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

</head>
<body>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>

    <div class="container mt-3">

        <div class="card">

            <div class="card-body"> 

                <div class="row">

                    <div class="col-md-4">
                        <label for="">Descripcion correo</label>
                        <select name="" id="cboheadcorreos" class="custom-select custom-select-sm"></select>
                    </div>

                    <div class="col-md-6"></div>

                    <div class="col-md-1">
                        <label for=""></label>
                        <button class="btn btn-sm btn-block btn-info"> <i class="fas fa-envelope"></i> </button>
                    </div>

                    <div class="col-md-1">
                        <label for=""></label>
                        <button class="btn btn-sm btn-block btn-info" id="btnagregarcorreos"> <i class="fas fa-user-plus"></i> </button>
                    </div>

                </div>

            </div>

        </div>

        <div class="card mt-2">
            <div class="card-body">
                <table class="table table-bordered text-center table-hover table-sm">
                    <thead class="thead-light">
                        <tr>    
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Filtros</th>
                        </tr>
                    </thead>
                    <tbody id="tbodycorreos">

                    </tbody>
                </table>
            </div>
        </div>


    </div>

    

<!-- REQUIRE -->
<?php 
    require_once 'modalfiltros.php';
    require_once 'modaladdcorreos.php';
?>

<div class="loader"></div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>


<!-- SCRIPTS -->
<script>
        let     IDENVIO  = null;
        let     IDCORREO = null;
        let     TIPOCORREO = null;

        const frmcorreos    = document.getElementById("frmcorreos");
        const frmfiltros    = document.getElementById("frmfiltros");
        // LOAD
        window.addEventListener("load",async ()=>{

            $(".select2").select2();    

            // GET CABECERAS CORREOS
            await getHeadCorreos();

            // CORREOS
            await getCorreos();

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });


        // CABECERAS DE LOS CORREOS
        async function getHeadCorreos(){

            let response = await get("sistema","correos","getheadcorreos");
            // console.log(response);
            setComboSimple("cboheadcorreos",response,"PROCESO","IDENVIO");

        }

        // CABECERAS DE LOS CORREOS
        async function getCorreos(){

            let response = await get("sistema","correos","getcorreos");
            setComboSimple("cbocorreos",response,"CORREO","IDCORREO");

        }

        // GET DETALLE DE CORREOS
        async function getDetalleCorreos(idenvio){
            let response = await get("sistema","correos","getdetailcorreos",{idenvio},true);
            $("#tbodycorreos").html(response);
        }

        // GET FILTROS
        async function getFiltros(idenvio,idcorreo,tipo){

            let response = await get("sistema","correos","getfiltroscorreo",{
                idenvio,idcorreo,tipo
            },true);

            $("#tbodyfiltros").html(response);
            InformarMini("Filtros encontrados");
            // console.log(response);
        }

        // ELIMINAMOS DETALLE CORREO
        async function deleteCorreo(id){

            let response = await post("sistema","correos","deletedetailcorreo",[id]);
            // console.log(response);
            if(response.success){
                await getFiltros(IDENVIO,IDCORREO,TIPOCORREO);
                InformarMini("Eliminado correctemente");
            }else{
                Advertir(response.rpt);
            }

        }

        // REGISTRAMOS CORREOS DETALLE
        frmcorreos.addEventListener('submit',(e)=>{
            e.preventDefault();
            setDetailCorreo();
        });

        // REGISTRAMOS FILTROS
        frmfiltros.addEventListener('submit',async (e)=>{
            e.preventDefault();
            MostrarCarga();
            await setFiltroCorreo();
        })

        // 
        async function setFiltroCorreo(){

            let filtro = $("#txtfiltro").val().trim();

            await post("sistema","correos","setdetailcorreo",[   
                        IDENVIO,IDCORREO,TIPOCORREO,filtro
                ]).then(async (response) => {

                    if(response.success){
                        // await getDetalleCorreos(IDENVIO);
                        await getFiltros(IDENVIO,IDCORREO,TIPOCORREO);
                        frmfiltros.reset();
                        // $("#modalfiltros").modal("hide");
                        InformarMini(response.rpt);
                    }else{
                        Advertir(response.rpt);
                    }
                    
                }).catch((error) => {
                    Advertir("Ocurrio un error");
                    console.log(error);
                });

        }

        // REGISTRAR CORREOS
        function setDetailCorreo(){



            let idcorreo    = $("#cbocorreos").val();
            let tipo        = $("#cbotipocorreo").val();
        

            if(IDENVIO != "" && IDENVIO != null){

                MostrarCarga();

                post("sistema","correos","setdetailcorreo",[   
                        IDENVIO,idcorreo,tipo
                ]).then(async (response) => {

                    if(response.success){
                        await getDetalleCorreos(IDENVIO);
                        frmcorreos.reset();
                        $("#modaladdcorreos").modal("hide");
                        InformarMini(response.rpt);
                    }else{
                        Advertir(response.rpt);
                    }

                }).catch((error) => {
                    Advertir("Ocurrio un error");
                    console.log(error);
                });
            }else{
                Advertir("Seleccione asunto de envio");
            }

            

        }

        // CORREOS
        $("#cboheadcorreos").change(async function(){
            IDENVIO = $(this).val();
            MostrarCarga();
            await getDetalleCorreos(IDENVIO);
            InformarMini("Correcto...");
        });

        // FILTROS SEGUN CORREO
        $("#tbodycorreos").on('click','.addfiltro', async function(){

            IDENVIO                 = $(this).data("id");
            IDCORREO                = $(this).data("idcorreo");
            TIPOCORREO              = $(this).data("tipo");


            MostrarCarga();
            await getFiltros(IDENVIO,IDCORREO,TIPOCORREO);

            $("#modalfiltros").modal("show");
        });

        // AGREGAMOS CORREO
        $("#btnagregarcorreos").click(async function(){

            $("#modaladdcorreos").modal("show");

        });

        // ELIMINAMOS FILTRO DE CORREO
        $("#tbodyfiltros").on('click','.deletecorreo',async function(){


            let id = $(this).data("id");
            MostrarCarga();
            await deleteCorreo(id);

        });




</script>

</body>
</html>