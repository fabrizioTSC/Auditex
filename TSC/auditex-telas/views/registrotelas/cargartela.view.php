<?php
session_start();
require_once __DIR__.'../../../../models/modelo/core.modelo.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

$_SESSION['navbar'] = "Cargar Tela";
$objModelo = new CoreModelo();


$codtela            = isset($_GET["txtcodigotela"]) ? $_GET["txtcodigotela"] : "";
$idproveedor        = isset($_GET["idproveedor"]) ? $_GET["idproveedor"] : "";
$dataproveedores    = [];
$datatela           = null;
$dataestabilidad    = [];
$dataproveedoresselect    = [];


if($codtela != ""){
    $dataproveedores            = $objModelo->getAll("AUDITEX.SPU_GETPROVEEDORES_EST_DI",[1,$codtela]);
    $datatela                   = $objModelo->get("AUDITEX.SP_AUDTEL_SELECT_TELA",[$codtela]);
    $dataestabilidad            = $objModelo->getAll("AUDITEX.SP_AUDTEL_SELECT_ESTDIM_V2",[$codtela,$idproveedor]);
    $dataproveedoresselect      = $objModelo->getAll("AUDITEX.SPU_GETPROVEEDORESTELA_TEL",[$codtela]);

}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $_SESSION['navbar'] ?>  </title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

    <link rel="stylesheet" href="/tsc/libs/js/datatables-fixed/fixedColumns.bootstrap4.css">

    <style> 

        .color2 {
            background-color: #781C08 !important;
            color: #FFF !important;
        } 
        body{
            padding-top: 50px !important;
        } 
        #tabledatos tbody th {
            white-space: nowrap;
            font-size: 11px;
            padding: 4px !important;
        }  

        #frmbusqueda{
            font-size: 12px;  
        }
 
         .tbl-data tr th {
            text-align: center;
            font-size: 11px;
        }
 
        .center-vert {
            line-height: 4;
        }
 
        .celda {
            height: auto;
            width: 50px;
        }
  
        .bus{
            font-size: 11px;
        }

        .tbodydatos{
            font-size: 11px !important;
        }  

        .font10{
            font-size: 11px !important;
        }
 
    </style>

</head>

<body>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>


    <div class="container-fluid mt-3">


        <!-- BLOQUE DE BUSQUEDA -->
        <form class="row" action="" id="frmbusquedacodigo" method="GET">
            <div class="col-md-2 col-form-label">
                <label for="" class="text-white" >Código Tela:</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control form-control-sm" autofocus id="txtcodigotela" name="txtcodigotela" value="<?= $codtela; ?>"  required>
            </div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-block btn-secondary">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>

            <?php if($codtela != ""): ?>


                <div class="col-md-2">
                    <a class="btn btn-sm btn-block btn-danger" href="cargartela.view.php">
                        Cancelar
                    </a>
                </div>

                <!-- AGREGAR PROVEEDOR -->
                <div class="col-md-2">
                    <button class="btn btn-sm btn-block btn-primary" type="button" id="btnagregarproveedor" >
                        <i class="fas fa-plus"></i>
                        Agregar Proveedor
                    </button>
                </div>

            <?php endif; ?>


        </form>

        <!-- PROVEEDORES -->
        <?php if($codtela != ""): ?>

            <table class="table table-sm table-bordered bg-white text-center">
                <thead class="thead-light">
                    <tr>
                        <th class="border-table">Cod Proveedor</th>
                        <th class="border-table">Proveedor</th>
                        <th class="border-table">OP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dataproveedores as $fila  ): ?>

                        <tr class=" <?= $fila["IDPROVEEDOR"] == $idproveedor ? 'color2': ''?> ">

                            <td class="border-table">
                                <?= $fila["IDPROVEEDOR"]; ?>
                            </td>
                            <td class="border-table">
                                <?= $fila["PROVEEDOR"]; ?>
                            </td>
                            <td class="border-table">
                                <a class="btn btn-sm btn-primary" href="?txtcodigotela=<?= $fila["CODIGOTELA"]; ?>&idproveedor=<?= $fila["IDPROVEEDOR"]; ?>">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>

                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- DATA TELA -->
            <?php if($idproveedor != null): ?>

                <!-- INFORMACION TELA -->
                <div class="row">

                    <div class="col-md-12">
                        <hr class="bg-white">
                    </div>

                    <div class="col-md-2 col-form-label">
                        <label for="" class="text-white" >Código Prov.:</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="txtcodtelprv" class="form-control form-control-sm" value="<?= $datatela["CODTELPRV"]; ?>"   required>
                    </div>
                    <div class="col-md-8 col-form-label">
                        <!-- <label for="" class="text-white" >Código Prov.:</label> -->
                    </div>

                    <div class="col-md-2 col-form-label">
                        <label for="" class="text-white" >Descripción Tela:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" id="txtdescripciontela" class="form-control form-control-sm" value="<?= $datatela["DESTEL"]; ?>"  required>
                    </div>

                    <div class="col-md-2 col-form-label">
                        <label for="" class="text-white" >Composición final:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" id="txtcomposicionfinal" class="form-control form-control-sm"  value="<?= $datatela["COMPOS"]; ?>" required>
                    </div>

                    <div class="col-md-2 col-form-label">
                        <label for="" class="text-white" >Rendimiento por peso:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" id="txtrendimientopeso" class="form-control form-control-sm" value="<?= $datatela["RENDIMIENTO"]; ?>"  required>
                    </div>

                    <div class="col-md-2 col-form-label">
                        <label for="" class="text-white" >Ruta:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" id="txtruta" class="form-control form-control-sm"  value="<?= $datatela["RUTA"]; ?>"  required>
                    </div>

                </div>

                <!-- INFORMACION ESTABILIDAD -->
                <div class="row">

                    <div class="col-md-3 col-form-label">
                        <label for="" class="text-white" ></label>
                    </div>

                    <div class="col-md-3 col-form-label text-center">
                        <label for="" class="text-white" >Valor</label>
                    </div>

                    <div class="col-md-3 col-form-label text-center">
                        <label for="" class="text-white" >Tolerancia(+)</label>
                    </div>
                    <div class="col-md-3 col-form-label text-center">
                        <label for="" class="text-white" >Tolerancia(-)</label>
                    </div>

                    <?php foreach($dataestabilidad as $fila  ): ?>

                        <div class="col-md-3 col-form-label">
                            <label for="" class="text-white" ><?= $fila["DESESTDIM"]; ?></label>
                        </div>

                        <div class="col-md-3 col-form-label text-center">
                            <input type="text" class="form-control form-control-sm valores      valores<?= $fila["CODESTDIM"]; ?>"     data-codestim="<?= $fila["CODESTDIM"]; ?>"  value="<?= $fila["VALOR"]; ?>"  required>
                        </div>

                        <div class="col-md-3 col-form-label text-center">
                            <input type="text" class="form-control form-control-sm tolerancias  tolerancias<?= $fila["CODESTDIM"]; ?>" data-codestim="<?= $fila["CODESTDIM"]; ?>"  value="<?= $fila["TOLERANCIA"]; ?>"  required>
                        </div>

                        <div class="col-md-3 col-form-label text-center">
                            <input type="text" class="form-control form-control-sm tolerancias  tolerancias_negativa<?= $fila["CODESTDIM"]; ?>" data-codestim="<?= $fila["CODESTDIM"]; ?>"  value="<?= $fila["TOLERANCIA_NEGATIVA"]; ?>"  required>
                        </div>


                    <?php endforeach; ?>


                </div>


                <!-- GUARDAR -->
                <div class="row justify-content-center mb-3">

                    <div class="col-md-3">
                        <button type="button" class="btn btn-secondary btn-sm btn-block" id="btnguardar">
                            Guardar
                        </button>
                    </div>

                </div>

            <?php endif; ?>


        <?php endif; ?>

    </div>



<div class="loader"></div>

<!-- Modal -->
<div class="modal fade" id="modalAgregarProveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro de Proveedores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form class="row"  id="frmregistroproveedores" action="">

                <div class="col-md-12">
                    <label for="">Código de Tela</label>
                    <input type="text" disabled  value="<?= $codtela; ?>" class="form-control form-control-sm">
                </div>

                <div class="col-md-12">
                    <label for="">Proveedor</label>
                    <select name="" id="cboproveedorregistro" class="custom-select custom-select-sm select2" style="width: 100%" >
                        <option value="">SELECCIONE</option>
                        <?php foreach($dataproveedoresselect as $fila  ): ?>
                            <option value="<?= $fila["IDPROVEEDOR"]; ?>"><?= $fila["DESCRIPCIONPROVEEDOR"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-primary" type="submit">
                        Registrar Proveedor
                    </button>
                </div>

            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<!-- DATATABLE -->
<script src="/tsc/libs/js/datatables-fixed/dataTables.fixedColumns.min.js"></script>


<!-- SCRIPTS -->
<script>

    let     frmbusqueda             = document.getElementById("frmbusqueda");
    const   frmregistroproveedores  = document.getElementById("frmregistroproveedores");
    // let btnguardar              = document.getElementById("btnguardar");
    // let btnagregarproveedor     = document.getElementById("btnagregarproveedor");

    // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
    window.addEventListener("load", async () => {

        // OCULTAMOS CARGA
        $(".loader").fadeOut("slow");
    });

    // btnguardar
    // btnguardar.addEventListener('click',()=> {
    //     GuardarDatos();
    // });

    $("#btnguardar").click(function (){
        GuardarDatos();
    });

    $("#btnagregarproveedor").click(function (){
        $("#modalAgregarProveedor").modal("show");
    });

    frmregistroproveedores.addEventListener('submit',(e)=>{
        e.preventDefault();
        let codproveedor = $("#cboproveedorregistro").val();

        if(codproveedor != ''){
            post("auditex-tela", "cargatela", "guardartela",["<?= $codtela; ?>",codproveedor])
            .then((response) => {
                if(response.success){
                    Informar("Registrado correctamente",1500,true);
                }
                // console.log('RESPONSE',response);
            });
        }else{
            Advertir("Seleccione Proveedor primero");
        }



    });

    async function GuardarDatos(){

        MostrarCarga("Cargando...");

        let datacabecera = {
            codtela:                "<?= $codtela; ?>",
            idproveedor:            "<?= $idproveedor; ?>",
            codigoprv:              $("#txtcodtelprv").val(),
            descripciontela:        $("#txtdescripciontela").val(),
            composicionfinal:       $("#txtcomposicionfinal").val(),
            rendimientopeso:        $("#txtrendimientopeso").val(),
            ruta:                   $("#txtruta").val()
        };

        let estabilidades = [];
        let valores = $(".valores");
        for(let val of valores){
            let codestim                = $(val).data("codestim");
            let valor                   = $(val).val();
            let tolerancia              = $(".tolerancias"+codestim).val();
            let tolerancia_negativa     = $(".tolerancias_negativa"+codestim).val();

            estabilidades.push(
                {
                    codestim,
                    valor,
                    tolerancia,
                    tolerancia_negativa
                }
            );
        }

        let response = await post("auditex-tela", "registrotelas", "setcargatela",[datacabecera,estabilidades]);

        if(response.success){
            Informar("Actualizado correctamente",2000);
        }else{
            Advertir("Ocurrio un error en el registro");
        }

        // console.log('RESPONSE',response);

        // console.log(datacabecera,estabilidades);
    }

</script>


</body>

</html>