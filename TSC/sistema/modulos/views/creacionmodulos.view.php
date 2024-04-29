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
    $_SESSION['navbar'] = "Creación de Modulos";


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

        /* label{
            color: #fff;
        } */

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

    <form class="row" id="frmregistro">

        <div class="form-group col-10">
            <label for="" class="text-white">Nivel 1</label>
            <select class="form-control form-control-sm select2" id="cbonivel1" style="width: 100%;" ></select>
        </div>

        <div class="form-group col-2">
            <label for="">&nbsp;</label>
            <button type="button" class="btn btn-sm btn-block btn-primary btnagregarmod" data-opcion="1" id="btnagregarmod1">
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <div class="form-group col-10">
            <label for="" class="text-white" >Nivel 2</label>
            <select class="form-control form-control-sm select2" id="cbonivel2" style="width: 100%;"></select>
        </div>

        <div class="form-group col-2">
            <label for="">&nbsp;</label>
            <button type="button" class="btn btn-sm btn-block btn-primary btnagregarmod" data-opcion="2" id="btnagregarmod2">
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <div class="form-group col-10">
            <label for="" class="text-white" >Nivel 3</label>
            <select class="form-control form-control-sm select2" id="cbonivel3" style="width: 100%;"></select>
        </div>

        <div class="form-group col-2">
            <label for="">&nbsp;</label>
            <button type="button" class="btn btn-sm btn-block btn-primary btnagregarmod" data-opcion="3" id="btnagregarmod3">
                <i class="fas fa-plus"></i>
            </button>
        </div>


        <div class="form-group col-10">
            <label for="" class="text-white" >Nivel 4</label>
            <select class="form-control form-control-sm select2" id="cbonivel4" style="width: 100%;"></select>
        </div>

        <div class="form-group col-2">
            <label for="">&nbsp;</label>
            <button type="button" class="btn btn-sm btn-block btn-primary btnagregarmod" data-opcion="4" id="btnagregarmod4">
                <i class="fas fa-plus"></i>
            </button>
        </div>


        <div class="form-group col-10">
            <label for="" class="text-white" >Nivel 5</label>
            <select class="form-control form-control-sm select2" id="cbonivel5" style="width: 100%;"></select>
        </div>

        <div class="form-group col-2">
            <label for="">&nbsp;</label>
            <button type="button" class="btn btn-sm btn-block btn-primary btnagregarmod"  data-opcion="5" id="btnagregarmod5">
                <i class="fas fa-plus"></i>
            </button>
        </div>


    </form>


</div>

<div class="loader"></div>

<!--  REGISTRO DE NIVEL 1 -->
<div class="modal fade" id="modalnivel1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">REGISTRO DE MODULO NIVEL 1</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <form id="frmmodulo"  action="" class="row" autocomplete="off">

                <div class="col-12">
                    <label for="">NIVEL</label>
                    <input id="txtnive" class="form-control form-control-sm" required></input>
                </div>

                <div class="col-12">
                    <label for="">TITULO</label>
                    <input id="txttitulo" class="form-control form-control-sm" required></input>
                </div>

                <div class="col-12">
                    <label for="">SUBTITULO</label>
                    <input id="txtsubtitulo" class="form-control form-control-sm"></input>
                </div>

                <div class="col-12">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-primary" type="submit">REGISTRAR</button>
                </div>

            </form>
      </div>
    </div>
  </div>
</div>


<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script>

    const frmmodulo = document.getElementById("frmmodulo");
    let IDNIVEL = null;
    let OPCION  = 1;
    // let NIVEL1 = null;
    // let NIVEL2 = null;
    // let NIVEL3 = null;
    // let NIVEL4 = null;
    // let NIVEL5 = null;

    window.addEventListener('load',async ()=>{

        await GetModulos(1,'','cbonivel1');
        $(".loader").fadeOut("slow");
    });



    $("#cbonivel1").change(async function(){

        let filtro = $("#cbonivel1").val();
        IDNIVEL = filtro;
        await GetModulos(2,filtro,'cbonivel2');
    });

    $("#cbonivel2").change(async function(){

        let filtro = $("#cbonivel2").val();
        IDNIVEL = filtro;
        await GetModulos(3,filtro,'cbonivel3');
    });

    $("#cbonivel3").change(async function(){

        let filtro = $("#cbonivel3").val();
        IDNIVEL = filtro;
        await GetModulos(4,filtro,'cbonivel4');
    });

    $("#cbonivel4").change(async function(){
        let filtro = $("#cbonivel4").val();
        IDNIVEL = filtro;
        await GetModulos(5,filtro,'cbonivel5');
    });


    // AGREGAR MODULOS
    $(".btnagregarmod").click(function(){

        OPCION = $(this).data("opcion");
        $("#frmmodulo").modal("show");

    });


    // GET DATOS
    async function GetModulos(opcion,filtro,elemento){

        let response = await get("sistema","modulos","getmodulos",{opcion,filtro});
        setComboSimple(elemento,response,"DESCRIPCION","ID");
    }

    //
    frmmodulo.addEventListener('submit',async (e)=>{

        e.preventDefault();

        MostrarCarga("Cargando...");
        let response = await post("sistema","modulos","setmodulospri",[
            1,
            $("#txtnivel").val().trim(),
            $("#txttitulo").val().trim(),
            $("#txtsubtitulo").val().trim(),
            IDNIVEL
        ]);

        if(response.success){

            Informar(response.rpt);
            frmmodulo.reset();
            $("#modalnivel1").modal("hide");
            await GetModulos(1,'','cbonivel1');
            $("#cbonivel1").trigger("change");


        }else{
            Advertir("Ocurrio un problema en el registro");
        }

        // console.log("RESPONSE",response);

    });


</script>



</body>
</html>