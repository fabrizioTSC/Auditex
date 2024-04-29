<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';


    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo = new CoreModelo();
    $fichainicio = isset($_GET["ficha"]) ? $_GET["ficha"] : "";
    $_SESSION['navbar'] = "Ingreso de Etapas";

    $IDFICHA    = isset($_GET["idficha"]) ? $_GET["idficha"] : null;
    $IDFICHA    = $IDFICHA == "" ? null : $IDFICHA;

    // VARIABLES
    $dataficha  = null;
    $dataetapas = [];

    // DATOS PARA REGISTRO
    if($IDFICHA != null){


        $dataficha  = $objModelo->get("AUDITEX.PQ_LAVANDERIA.SPU_GETLAVADOPANIOCORTE",[1,$IDFICHA]);
        $dataetapas = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_GETLAVADOPANIOCORTE",[2,$IDFICHA]);


    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['navbar'] ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

    <style>

        body{
            padding-top: 50px !important;
        }

        .font-size-11{
            font-size: 11.5px !important;
        }

        .hr{
            border: 1px solid #fff;
        }

        label,h1,h2,h3,h4,h5,h6{
            color:#fff;
        }

        .container-data-general{
            font-size: 12px !important;
            font-weight: bold !important;
        }


    </style>

    <!-- <link rel="stylesheet" href="../../css/encogimientocorte/molde.css"> -->

</head>

<body>
    <div class="loader"></div>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>

    <!--  -->
    <div class="container-fluid mt-3">


        <!-- BUSQUEDA -->
        <?php if($IDFICHA == null): ?>

            <div class="container">

                    <form  id="frmbusqueda" autocomplete="off" method="GET" class="row justify-content-md-center">

                        <label for="" class="col-md-2 col-2 col-label font-weight-bold">Ficha:</label>

                        <div class="col-md-8 col-6">
                            <input id="txtficha" type="number" class="form-control form-control-sm" name="ficha" value="<?= $fichainicio; ?>"  autofocus required>
                        </div>

                        <div class="col-md-2 col-4">
                            <button class="btn btn-sm btn-block btn-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                    </form>

            </div>

        <?php endif; ?>

      
        <!-- PARA REGISTROS (LUEGO DE BUSQUEDA) -->
        <?php if($IDFICHA != null): ?>


            <!-- DATOS DE LA FICHA -->
            <div class="row container-data-general">

                <div class="col-6">

                    <div class="row">

                        <!-- FICHA -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">FICHA :</label>
                        </div>
                        <div class="col-md-8">
                            <label for=""><?= $dataficha["CODFIC"];?></label> 
                        </div>

                        <!-- PEDIDO -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">PEDIDO:</label>
                        </div>
                        <div class="col-md-8">
                            <label for=""><?= $dataficha["PEDIDO"];?></label> 
                        </div>

                        <!-- ESTILO CLIENTE -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">ESTILO CLIENTE:</label>
                        </div>
                        <div class="col-md-8">
                            <label for=""><?= $dataficha["ESTCLI"];?></label> 
                        </div>

                        <!-- ESTILO TSC -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">ESTILO TSC:</label>
                        </div>
                        <div class="col-md-8">
                            <label for=""><?= $dataficha["ESTTSC"];?></label> 
                        </div>

                        <!-- PARTIDA -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">PARTIDA:</label>
                        </div>
                        <?php 
                            $rutapartida   = "/TSC-WEB/auditoriatela/VerAuditoriaTela.php?partida={$dataficha['PARTIDA']}&codtel={$dataficha['CODTEL']}&codprv={$dataficha['CODPRV']}&numvez={$dataficha['NUMVEZ']}&parte=1&codtad=1";
                        ?>
                        <div class="col-md-8">
                            <a href="<?= $rutapartida;?>" target="_blank">
                                <?= $dataficha["PARTIDA"];?>

                            </a>   
                        </div>
                        
                        <!-- VOLVER -->
                        <div class="col-md-4">
                            <!-- <label class="font-weight-bold">:</label> -->
                            <a href="ingresopanos.view.php">Volver</a>
                        </div>
                        

                    </div>


                </div>

                <div class="col-6">

                    <div class="row">

                        <!-- TIPO DE TELA -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">TIPO DE TELA:</label>
                        </div>
                        <div class="col-md-8">
                            <label for=""><?= $dataficha["DESTEL"];?></label>
                        </div>

                        <!-- COLOR -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">COLOR:</label>
                        </div>
                        <div class="col-md-8">
                            <label for=""><?= $dataficha["COLOR"];?></label>
                        </div>

                        <!-- CLIENTE -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">CLIENTE:</label>
                        </div>
                        <div class="col-md-8">
                            <label for=""><?= $dataficha["DESCLI"];?></label>
                        </div>

                        <!-- CANT. TOT. FICHA -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">CANT. TOT. FICHA:</label>
                        </div>
                        <div class="col-md-8">
                            <label for=""><?= $dataficha["CANTOTALFICHA"];?></label>
                        </div>

                        <!--  AUDITOR   -->
                        <div class="col-md-4">
                            <label class="font-weight-bold">USUARIO:</label>
                        </div>
                        <div class="col-md-8">
                            <label for=""><?= $dataficha["USUARIOCREA"];?></label> 
                        </div>

                    </div>

                </div>

            </div>

            <!-- SEPARADOS -->
            <hr class="hr">
            <!-- END SEPARADOR  -->

            <?php if($dataficha["ESTADO"] == "1"): ?>

                <form id="frmregistroetapas"  class="row" autocomplete="off">

                        <label class="col-1 col-label font-weight-bold">Etapa:</label>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm mayus" id="txtetapanew" required autofocus>
                        </div>

                        <label class="col-1 col-label font-weight-bold">N° Paños:</label>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm mayus" id="txtnumeropanos" required>
                        </div>

                        <div class="col-2">
                            <button class="btn btn-sm btn-sistema btn-block" type="submit" >Agregar</button>
                        </div>
                </form>
                <!-- SEPARADOS -->
                    <hr class="hr">
                <!-- END SEPARADOR  -->

            <?php endif; ?>


            

            <!-- ETAPAS REGISTRADAS -->
            <div class="row justify-content-md-center">

                <?php foreach($dataetapas as $etapa): ?>

                        <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                            <div class="card">
                                <div class="card-body p-0">
                                    

                                    <form  class="frmetapas row justify-content-center" autocomplete="off">

                                        <div class="col-12">

                                            <table class="table table-bordered table-sm tablainput">

                                                <thead class="thead-sistema-new text-center">
                                                    <tr>
                                                        <th colspan="4" class="p-0">Etapa <?= $etapa["ETAPA"]; ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" class="p-0">Medida Real Corte</th>
                                                        <th colspan="2" class="p-0">Media Real Fisico</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Largo</th>
                                                        <th>Ancho</th>
                                                        <th>Largo</th>
                                                        <th>Ancho</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr >
                                                        <td height="30">
                                                            <input type="text" class="inputtabla text-center" value="<?= $etapa["LARGO_MEDIDAREAL_CORTE"]; ?>" id="txtlargoantes_<?= $etapa["ETAPA"]; ?>">
                                                        </td>
                                                        <td height="30">
                                                            <input type="text" class="inputtabla text-center" value="<?= $etapa["ANCHO_MEDIDAREAL_CORTE"]; ?>" id="txtlargodespues_<?= $etapa["ETAPA"]; ?>" >
                                                        </td>
                                                        <td height="30">
                                                            <input type="text" class="inputtabla text-center" value="<?= $etapa["ANCHO_MEDIDAREAL_FISICO"]; ?>" id="txtanchoantes_<?= $etapa["ETAPA"]; ?>">
                                                        </td>
                                                        <td height="30">
                                                            <input type="text" class="inputtabla text-center" value="<?= $etapa["LARGO_MEDIDAREAL_FISICO"]; ?>" id="txtanchodespues_<?= $etapa["ETAPA"]; ?>" >
                                                        </td>
                                                    </tr>
                                                </tbody>

                                            </table>

                                        </div>

                                        <label class="col-label col-8 text-dark">Cant. Paños: </label>
                                        <div class="col-4">
                                            <input type="text" class="form-control form-control-sm" value="<?= $etapa["NUM_PANOS"] ?>" id="txtnumpanos<?= $etapa["ETAPA"]; ?>">
                                        </div>
                                        <label class="col-label col-7 text-dark">Tonos: </label>
                                        <div class="col-5">
                                            <!-- TONOS -->
                                            <?php  if($dataficha["ESTADO"] == "1"):?>

                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control form-control-sm mayus"  id="txttonos<?= $etapa["ETAPA"]; ?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text cursor-pointer agregartonos" data-id="<?= $etapa["IDETAPA"]; ?>" data-etapa="<?= $etapa["ETAPA"]; ?>" >
                                                            <i class="fas fa-plus"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                            <?php endif; ?>

                                        </div>
                                        <!-- TONOS REGISTRADOS -->
                                        <div class="col-12">

                                            <?php 
                                                $tonos = $objModelo->getAll("AUDITEX.PQ_LAVANDERIA.SPU_SETETAPASTONOS_PANOS",[3,null,$etapa["IDETAPA"],null]);
                                            ?>  

                                            <div class="row containers_tono" id="containertonos_<?= $etapa["ETAPA"]; ?>">

                                                <?php foreach($tonos as $tono): ?>

                                                    <div class="col-3 mb-1">
                                                        <a 
                                                            class="btn btn-sistema btn-block btn-sm cursor-pointer tonosquitar" 
                                                            title="Quitar Tono" 
                                                            data-id="<?= $tono["IDTONO"] ?>" 
                                                            data-idetapa="<?= $etapa["IDETAPA"] ?>" 
                                                            data-etapa="<?= $etapa["ETAPA"] ?>" 

                                                            >
                                                            <?= $tono["TONO"] ?>
                                                        </a>
                                                    </div>


                                                <?php endforeach; ?>

                                            </div>

                                            

                                        </div>

                                        <label class="col-label col-12 text-dark">Observaciones: </label>
                                        <div class="col-12">
                                            <textarea class="form-control form-control-sm" rows="1" ><?= $etapa["OBSERVACION"]; ?></textarea>
                                        </div>

                                        <input type="hidden" name="" value="<?= $etapa["IDETAPA"]; ?>">

                                        <?php if($dataficha["ESTADO"] == "1"): ?>

                                            <div class="col-3">
                                                <label for=""></label>
                                                <button data-id="<?= $etapa["IDETAPA"] ?>" class="btn btn-sm btn-danger btn-block eliminareetapas"  type="button">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <div class="col-3">
                                                <label for=""></label>
                                                <button class="btn btn-sm btn-success btn-block" type="submit">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>

                                        <?php endif; ?>


                                    </form>
                                </div>                                
                            </div>

                        </div>



                <?php endforeach; ?>


            </div>

            <?php if($dataficha["ESTADO"] == "1"): ?>

                <div class="row justify-content-center">
                    <div class="col-3">
                        <button class="btn btn-sm btn-block btn-sistema" type="button" id="btnenviarlavanderia">Enviar a Lavanderia</button>
                    </div>                                                
                </div>

            <?php endif; ?>


        <?php endif; ?>


    </div>


        


    <!-- SCRIPTS -->
    <?php require_once '../../../plantillas/script.view.php'; ?>

    <script>

        // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
        window.addEventListener("load", async () => {

            // OCULTAMOS CARGA
            $(".loader").fadeOut("slow");
        });

    </script>

    <!-- SI ES BUSQUEDA -->
    <?php if($IDFICHA == null): ?>

        <script>

            const frmbusqueda = document.getElementById("frmbusqueda");

            async function VerificaPano(ficha){
                return await get("auditex-corte","lavanderiapanos",'verificapano',{
                    ficha
                });
            }

            frmbusqueda.addEventListener('submit',async (e)=>{
                e.preventDefault();

                MostrarCarga();
                let ficha = document.getElementById("txtficha").value.trim();

                let response = await VerificaPano(ficha);

                if(response.VERIFICA > 0){
                    CreateFicha(ficha);
                }else{

                    let rpt = await Preguntar("La ficha no lleva lavado de paño,confirme para iniciar");
                    if(rpt.value){
                        CreateFicha(ficha);
                    }

                }

                
            });

            function CreateFicha(ficha){

                post("auditex-corte","lavanderiapanos","set-ficha",[
                        1,
                        ficha,
                        "<?php echo $_SESSION["user"];?>"
                ])    
                    .then(response =>{


                        if(response){

                            window.location = `ingresopanos.view.php?&idficha=${response.ID}`;


                            // if(response.LLEVALAVADO == 1){
                            //     window.location = `ingresopanos.view.php?&idficha=${response.ID}`;
                            // }

                            // if(response.LLEVALAVADO == 0){
                            //     // window.location = `ingresopanos.view.php?&idficha=${response.ID}`;

                            //     Advertir("La ficha no lleva lavado en paños");
                            // }


                        }else{

                            Advertir("Ocurrio un error al generar ficha");

                        }


                    })
                    .catch(error =>{
                        Advertir("Ocurrio un error :c");
                    });

            }

        </script>

    <?php endif; ?>

    <!-- SI ES REGISTRO -->
    <?php if($IDFICHA != null && $dataficha["ESTADO"] == "1"): ?>

        <script>

            // VARIABLES
            const frmregistroetapas = document.getElementById("frmregistroetapas");
            const frmetapas         = document.getElementsByClassName("frmetapas");


            // REGISTRAR ETAPAS
            frmregistroetapas.addEventListener('submit',(e)=>{
                e.preventDefault();

                MostrarCarga();

                let     etapa               = document.getElementById("txtetapanew").value.trim();
                let     txtnumeropanos      = document.getElementById("txtnumeropanos").value.trim();

                post("auditex-corte","lavanderiapanos","set-etapas",[
                    1,null,<?= $IDFICHA; ?>,etapa,null,null,null,null,txtnumeropanos,null,"<?php echo $_SESSION["user"];?>"
                ])    
                    .then(response =>{

                        // console.log("RESPONSE",response);

                        if(response.success){
                            OcultarCarga();
                            window.location = `ingresopanos.view.php?&idficha=<?= $IDFICHA;?>`;

                        }else{
                            Advertir("Ocurrio un error al generar ficha");
                        }


                    })
                    .catch(error =>{

                        console.log("ERROR",error);
                        Advertir("Ocurrio un error :c");
                    });


            });

            // MODIFICAR ETAPAS AGREGAMOS EVENTOS
            for(let forms of frmetapas){
                forms.addEventListener('submit',(e)=>{
                    e.preventDefault();
                    modify_etapas(forms);
                });
            }

            // ELIMINAR ETAPAS
            $(".eliminareetapas").click(function(){

                MostrarCarga();

                let id = $(this).data("id");

                post("auditex-corte","lavanderiapanos","set-etapas",[
                    2,id,null,null,null,null,null,null,null,null,"<?php echo $_SESSION["user"];?>"
                ])    
                    .then(response =>{

                        if(response.success){
                            OcultarCarga();
                            window.location = `ingresopanos.view.php?&idficha=<?= $IDFICHA;?>`;

                        }else{
                            Advertir("Ocurrio un error al eliminar etapa");
                        }

                    })
                    .catch(error =>{

                        console.log("ERROR",error);
                        Advertir("Ocurrio un error :c");
                    });

            })


            // MODIFICAR ETAPAS
            function modify_etapas (form){

                // console.log(form);
                MostrarCarga();

                // let txtlargoantes       = form[0].value.trim();
                // let txtlargodespues     = form[1].value.trim();
                // let txtanchoantes       = form[2].value.trim();
                // let txtanchodespues     = form[3].value.trim();


                let txt_real_corte_largo        = form[0].value.trim();
                let txt_real_corte_ancho        = form[1].value.trim();
                let txt_real_fisico_largo       = form[2].value.trim();
                let txt_real_fisico_ancho       = form[3].value.trim();

                let txtcantpanos        = form[4].value.trim();
                let txtobservaciones    = form[6].value.trim();
                let idetapa             = form[7].value.trim();

                // console.log(
                //     txtlargoantes,txtlargodespues,txtanchoantes,txtanchodespues,txtcantpanos,txtobservaciones,idetapa
                // );

                post("auditex-corte","lavanderiapanos","set-etapas",[
                    // 1,idetapa,<?= $IDFICHA; ?>,null,txtlargoantes,txtlargodespues,txtanchoantes,txtanchodespues,txtcantpanos,txtobservaciones,"<?php echo $_SESSION["user"];?>"
                    1,idetapa,<?= $IDFICHA; ?>,null,txt_real_corte_largo,txt_real_corte_ancho,txt_real_fisico_largo,txt_real_fisico_ancho,txtcantpanos,txtobservaciones,"<?php echo $_SESSION["user"];?>"

                ])    
                    .then(response =>{

                        console.log("RESPONSE",response);
                        OcultarCarga();


                    })
                    .catch(error =>{

                        console.log("ERROR",error);
                        Advertir("Ocurrio un error :c");
                    });


            }

            $(".agregartonos").click(function(){

                MostrarCarga();

                let idetapa = $(this).data("id");   
                let etapa   = $(this).data("etapa");
                let tono    = $("#txttonos"+etapa).val().trim()


                post("auditex-corte","lavanderiapanos","set-tonos",[
                    1,null,idetapa,tono                
                ])    
                    .then(response =>{

                        // OcultarCarga();
                        // console.log(response);

                        if(response){
                            reloadTonos(etapa,idetapa);

                        }else{
                            Advertir("Ocurrio un error al eliminar etapa");
                        }

                    })
                    .catch(error =>{

                        console.log("ERROR",error);
                        Advertir("Ocurrio un error :c");
                    });


            });


            // VOLVER A CARGAR LOS TONOS
            function reloadTonos(etapa,idetapa){ 


                post("auditex-corte","lavanderiapanos","set-tonos",[
                    3,null,idetapa,null                
                ],true)    
                    .then(response =>{

                        $("#containertonos_"+etapa).html(response);
                        $("#txttonos"+etapa).val("");
                        OcultarCarga();

                    })
                    .catch(error =>{

                        console.log("ERROR",error);
                        Advertir("Ocurrio un error :c");
                    });



            }

            // QUITAR TONO
            $(".containers_tono").on('click','.tonosquitar',function(){

                MostrarCarga();

                let idtono = $(this).data("id");
                let idetapa = $(this).data("idetapa");   
                let etapa   = $(this).data("etapa");

                post("auditex-corte","lavanderiapanos","set-tonos",[
                    2,idtono,null,null                
                ],true)    
                    .then(response =>{

                        reloadTonos(etapa,idetapa);

                    })
                    .catch(error =>{

                        console.log("ERROR",error);
                        Advertir("Ocurrio un error :c");
                    });

            });


            // ENVIAR A LAVANDERIA
            $("#btnenviarlavanderia").click(function(){

                MostrarCarga();
                post("auditex-corte","lavanderiapanos","set-ficha",[
                        2,
                        "<?= $dataficha["CODFIC"]; ?>",
                        "<?= $_SESSION["user"];?>"
                ])    
                    .then(response =>{

                        if(response.SUCCESS == "OK"){
                            window.location = `ingresopanos.view.php`;

                        }else{
                            Advertir("Ocurrio un error al enviar ficha");
                        }

                        // console.log(response);

                    })
                    .catch(error =>{
                        Advertir("Ocurrio un error :c");
                    });


            });


        </script>

    <?php endif; ?>


</body>

</html>