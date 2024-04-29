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
    $_SESSION['navbar'] = "Carga Indicador Manual";

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


        /* th:first-child, td:first-child{
            position:sticky;
            left:0px;
            background: #e9ecef  !important;
        } */

       
    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container-fluid mt-3"> 

    <div class="card">

        <?php
            // $po     = isset($_GET["txtpo"]) ? $_GET["txtpo"] : null;
            $pedido = isset($_GET["txtpedido"]) ? $_GET["txtpedido"] : null;

            $data = [];

            if($pedido != null ){

                $data = $objModelo->getAll("PQ_PACKINGACABADOS_TMP.SPU_GETAUDFINAL",[$pedido]);

            }



        ?>
        
        
        <div class="card-body">

            
            <form class="row" id="frmsubida" autocomplete="off"> 

           

                <div class="col-md-10">
                    <label for="">PEDIDO</label>
                    <input type="text" class="form-control form-control-sm" id="txtpedido" name="txtpedido" value="<?= $pedido  ?>"  >
                </div>
                
                <div class="col-md-2">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-primary" type="submit"   >Buscar</button>
                </div>
                

            </form>

            
            <div class="table-responsive">

                <table class="table table-bordered table-sm mt-2 text-center tablainput " id="tabledatos">
                    <thead class="thead-light">
                        <tr id="theaddatos">

                            <th class='border-table'>PEDIDO</th>
                            <th class='border-table'>COLOR</th>
                            <th class='border-table'>PARTE</th>
                            <th class='border-table'>VEZ</th>
                            <th class='border-table'>CANTIDAD PRENDAS</th>
                            <th class='border-table'>FECHA REGISTRO</th>
                            <th class='border-table'>ESTADO</th>
                            <th class='border-table'>RESULTADO</th>

                            <th class='border-table'></th>

                        </tr>
                    </thead>
                    <tbody id="tbodydatos"> 

                        <?php if(count($data) > 0 ): ?>
                            <?php $indice = 0;  ?>
                            <?php foreach($data as $fila):  ?>

                                <?php
                                    $fecha = $fila["FECFINAUD"] != null ?  $fila["FECFINAUD"] : "";
                                    $indice++;
                                ?>

                                <tr>

                                    <td> <?=  $fila["PEDIDO"]?> </td>
                                    <td> <?=  $fila["DESCOL"] ?> </td>

                                    <td> <?=  $fila["PARTE"] ?> </td>
                                    <td> <?=  $fila["NUMVEZ"] ?> </td>


                                    <td>
                                        <input type="text" class="inputtabla cantidad<?= $indice ?>" value="<?=  $fila["CANTIDAD"] ?>">                                        
                                    </td>

                                    <td>
                                        <input type="date" class="inputtabla fecha<?= $indice ?>" value="<?=  $fecha; ?>">
                                    </td>
                                    <td> <?=  $fila["ESTADO"] ?> </td>
                                    <td> <?=  $fila["RESULTADO"] ?> </td>

                                    <td>
                                        <a class="btn btn-sm btn-primary btnguardar" 
                                            data-pedido="<?= $fila["PEDIDO"]?>" 
                                            data-color="<?= $fila["DESCOL"]?>" 
                                            data-parte="<?= $fila["PARTE"]?>" 
                                            data-vez="<?= $fila["NUMVEZ"]?>" 
                                            data-indice="<?= $indice ?>" 

                                            >
                                            <i class="fas fa-save"></i>
                                        </a>
                                    </td>

                                </tr>

                            <?php endforeach;  ?>


                        <?php  endif; ?>

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

    // const frmsubida = document.getElementById("frmsubida");

    window.addEventListener('load',async ()=>{

        $(".loader").fadeOut("slow");


    });

    // frmsubida.addEventListener('submit',async (e)=>{
    //     e.preventDefault();
    //     await ConfirmarPacking();
    //     // SubirAchivo();
    // });

    $(".btnguardar").click(async function(){

        $(".loader").fadeIn();


        let pedido  = $(this).data("pedido");
        let color   = $(this).data("color");
        let parte   = $(this).data("parte");
        let vez     = $(this).data("vez");
        let indice  = $(this).data("indice");


        let cantidad    = $(`.cantidad${indice}`).val();
        let fecha       = $(`.fecha${indice}`).val();

        // console.log(pedido,color);
        

        let parameters = [
            pedido,color,parte,vez,fecha,cantidad
        ];

        console.log("parameters",parameters);
        
        response = await post("auditex-audfinal", "indicadormanual", "setindicador", parameters);
        if(response.success){
            Informar("Realizado correctamente",1500);
            $(".loader").fadeOut("slow");   
        }else{
            $(".loader").fadeOut("slow");   
            Advertir("Ocurrio un problema");
        }
        

    });


</script>



</body>
</html>