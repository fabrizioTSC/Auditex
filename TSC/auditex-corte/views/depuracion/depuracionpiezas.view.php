<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Depuración de corte";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depuración Corte</title>

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>
    <link rel="stylesheet" href="../../../libs/css/mdb.min.css">
    <style>
        td,th{
            padding: 0px !important;
        }
        body{
            padding-top:60px !important;
        }
    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container-fluid mt-3"> 

    <!-- CABECERA -->
    <div class="card">

        <div class="card-body pt-0 pb-0">
            
            <form class="row" id="frmficha" >

                <div class="col-md-2">
                    <div class="md-form input-group">

                        <div class="input-group-prepend">
                            <button class="bg-primary"> 
                                <i style="color:white" class="fas fa-search"></i>
                            </button>
                        </div>
                        <input type="number" id="txtficha" class="form-control form-control-sm" placeholder="Ficha">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="md-form">
                        <input type="text" id="txtcliente" class="form-control form-control-sm">
                        <label for="txtcliente">Cliente</label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="md-form">
                        <input type="text" id="txtpedido" class="form-control form-control-sm">
                        <label for="txtpedido">Pedido</label>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <!-- <div class="md-form">
                        <input type="text" id="txtpartida" class="form-control form-control-sm">
                        <label for="txtpartida">Partida</label>
                    </div> -->
                    <div class="md-form input-group">

                        <div class="input-group-prepend">
                            <a class="btn btn-sm bg-warning" id="refpartida" target="_blank" href=""> 
                                <i style="color:white" class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                        <input type="text" id="txtpartida" class="form-control form-control-sm" placeholder="Partida">
                    </div>

                </div>

                <div class="col-md-2">
                    <div class="md-form">
                        <input type="text" id="txtcantidadficha" class="form-control form-control-sm">
                        <label for="txtcantidadficha">Cantidad Ficha</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="md-form">
                        <input type="text" id="txtproveedor" class="form-control form-control-sm">
                        <label for="txtproveedor">Proveedor</label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="md-form">
                        <input type="text" id="txtcolor" class="form-control form-control-sm">
                        <label for="txtcolor">Color</label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="md-form">
                        <input type="text" id="txtprograma" class="form-control form-control-sm">
                        <label for="txtprograma">Programa</label>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="md-form">
                        <input type="text" id="txtusuario" class="form-control form-control-sm">
                        <label for="txtusuario">Usuario</label>
                    </div>
                </div>
               
                <div class="col-md-1">
                    <div class="md-form">
                        <input type="text" id="txtfechainicio" class="form-control form-control-sm">
                        <label for="txtfechainicio">F. Inicio</label>
                    </div>
                </div>
                
                <div class="col-md-1">
                    <div class="md-form">
                        <input type="text" id="txtfechafin" class="form-control form-control-sm">
                        <label for="txtfechafin">F. Fin</label>
                    </div>
                </div>

                <button type="submit" class="d-none" >enviar</button>

            </form>

        </div>
    </div>

    <!-- DETALLE -->
    <div class="card mt-3">  
        <div class="table-responsive pt-0 pb-0"> 

            <table class="table table-sm table-bordered text-center" >
                <thead class="thead-light">
                    <tr>    
                        <th style="vertical-align: middle;" rowspan="2" nowrap>N°</th>
                        <th style="vertical-align: middle;" rowspan="2" nowrap>Paquete</th>
                        <th style="vertical-align: middle;" rowspan="2" nowrap>Talla</th>
                        <th style="vertical-align: middle;" rowspan="2" nowrap>Cantidad Paquete</th>
                        <th style="vertical-align: middle;" rowspan="2" nowrap>Defecto Cantidad</th>
                        <th style="vertical-align: middle;" rowspan="2" nowrap>Cantidad Depuración</th>
                        <th style="vertical-align: middle;" colspan="2" nowrap>Tono</th>
                        <th style="vertical-align: middle;" rowspan="2" nowrap>Usuario</th>
                        <th style="vertical-align: middle;" rowspan="2" nowrap>Observaciones</th>
                    </tr>
                    <tr>    
                        <th>C</th>
                        <th>D</th>
                    </tr>
                </thead>
                <tbody id="tbodyficha">
                </tbody>
            </table>

        </div> 
    </div>

    <!-- MOTIVOS -->
    <div class="card mt-3 p-0">
        <div class="card-body p-0" id="card-motivos">MOTIVO:</div>
    </div>
    
    <!-- OBSERVACIONES -->
    <div class="card mt-3 p-0">
        <div class="card-body p-0" id="card-observaciones"> 
            <input type="text" class="form-control form-control-sm inhabilitar" id="txtobservaciones" placeholder="Observaciones">
        </div>
    </div>

    <div class="row  mt-3 justify-content-md-end">   
        <!-- TABLE RESUMEN -->
        <div class="col-md-6">
            <div class="card" id="card-resumen">
                <!-- <div class="card-body">  -->
                    <table  class="table table-sm table-bordered text-center">
                        <thead class="thead-light"> 
                            <tr>    
                                <th colspan="2">RESUMEN:</th>
                            </tr>
                            <tr>    
                                <th>Talla</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyresumen"> 

                        </tbody>
                    
                    </table>
                <!-- </div> -->
            </div>
        </div>

        <div class="col-md-4"></div>

        <!-- PESO -->
        <div class="col-md-2">  
            <div class="form-group">    
                <label for="txtpeso" class="text-white">Peso:</label>
                <input type="number" class="form-control form-control-sm inhabilitar" id="txtpeso">
            </div>
        </div>

        <?php
            // 63 => AUDITOR
            // 84 => SUPERVISOR
            // 7  => COORDINADOR

        ?>


        <!-- BOTON GUARDAR -->
        <?php if($_SESSION["codcargo"] == "7" || $_SESSION["codcargo"] == "146" || $_SESSION["codcargo"] == "63" || $_SESSION["codcargo"] == "184"  ): ?>
            
                <div class="col-md-2">
                    <button class="btn btn-sm btn-block btn-danger inhabilitar" id="btnguardar" disabled="disabled">Guardar</button>
                </div>
            
        <?php endif; ?>
        
        <!-- <?php echo "<h1>{$_SESSION['codcargo']}</h1>"; ?> -->

        <!-- BOTON ENVIAR CORREO -->
        <?php if($_SESSION["codcargo"] == "7" || $_SESSION["codcargo"] == "146" || $_SESSION["codcargo"] == "184"  ): ?> 
            
            <div class="col-md-2">
                <button class="btn btn-sm btn-block btn-primary inhabilitar" id="btnenviarcorreo" disabled="disabled">Enviar Correo</button>
            </div>

        <?php endif; ?>
        


    </div>

</div>



<div class="loader"></div>

<!-- MODALS -->
<?php require_once 'modaldefectos.view.php'; ?>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>
<script src="../../../libs/js/mdb.min.js"></script>

<script src="../../js/depuracion/funciones.js"></script>
<script src="../../js/depuracion/eventos.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> -->
<script>

    // GLOBALES
    const frmficha      = document.getElementById("frmficha");
    const frmdefectos   = document.getElementById("frmdefectos");

    let IDDEPURACION = null;
    let PARTIDA = null;
    let OBSERVACION = null;
    let PESO = null;
    let FICHA = null;
    let IDPAQUETE = null;
    let USUARIO = "<?= $_SESSION["user"] ?>";

    // 
    $(document).ready(function(){
        $(".loader").fadeOut("slow");
    });

    // FICHA
    frmficha.addEventListener('submit',(e)=>{
        e.preventDefault();
        getFicha();

    });

    // ENVIAR CORREO
    $("#btnenviarcorreo").click(async function(){

        if(IDDEPURACION != null && IDDEPURACION != ""){

            let rpt =  await Preguntar("Confirme para enviar correo");

            // 
            if(rpt.value){
                MostrarCarga("Enviando...");

                window.open(`http://textilweb.tsc.com.pe:8094/EnvioCorreo/EnvioCorreoDepuracion/?ficha=${FICHA}&usuario=${USUARIO}`,'_blank');

                InformarMini("Correcto");


                // try {
                //     const response = await axios.get(`http://textilweb.tsc.com.pe:8094/EnvioCorreo/EnvioCorreoDepuracion/?ficha=${FICHA}&usuario=${USUARIO}`);
                //     setTimeout(()=>{
                //         location.reload();
                //     },1600);
                //     InformarMini(response.mensaje,1500);
                //     // console.log(response);
                // } catch (error) {
                //     setTimeout(()=>{
                //         location.reload();
                //     },1600);
                //     InformarMini(response.mensaje,1500);
                //     // console.error(error);
                // }

                // post("auditex-corte","depuracion","setcorreo",[
                //     FICHA
                // ])   
                // .then(response => {

                //     if(response.success){
                //         setTimeout(()=>{
                //             location.reload();
                //         },1600);
                //         InformarMini(response.mensaje,1500);
                //     }else{
                //         Advertir(response.mensaje);
                //     }

                //     // console.log(response);
                //     // InformarMini("Correcto");
                // })  
                // .catch(error => {
                //     Advertir("Ocurrio un error al enviar correo");
                // });

            }


        }else{
            AdvertirMini("No existe registro o no se cerró");
        }

    });




</script>


</body>
</html>