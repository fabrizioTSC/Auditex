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
    $_SESSION['navbar'] = "Eliminar Auditoria Final - Costura";


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

    
    <?php
        $ficha      = false;
        $dataficha  = [];

        if(isset($_GET["ficha"])){

            $ficha = $_GET["ficha"];
            $dataficha = $objModelo->getAll("AUDITEX.PQ_MODAUDITEX.SPU_GETFICHASAUDITORIA",[2,$ficha]);
            // var_dump($dataficha);
        }
    ?>

    <form action="" class="row" id="frmbusqueda" method="GET" >


        <div class="col-md-4">
            <label for="">Ficha</label>
            <input type="number" class="form-control form-control-sm" name="ficha" value="<?= $ficha ? $ficha : '' ?>"  required>
        </div>

        <!-- <input type="hidden" name=""> -->

        <div class="col-md-2">
            <label for="">&nbsp;</label>
            <button class="btn btn-sm btn-primary btn-block" type="submit" >BUSCAR</button>
        </div>

    </form>

    <?php  if($ficha): ?>

        <table class="table table-bordered table-hover table-sm mt-2 text-center">
            <thead class="thead-light">
                <tr>
                    <th>FICHA</th>
                    <th>PARTE</th>
                    <th>VEZ</th>
                    <th>CANTIDAD</th>
                    <th>PARCIAL</th>
                    <th>FECHA AUDITORIA</th>
                    <th>USUARIO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php foreach($dataficha as $data): ?>

                    <?php 

                        $disabled = $data["PARTE"] == $data["PARTEMAX"] ? "" : "disabled";

                    ?>

                    <tr>
                        <td><?= $data["CODFIC"]; ?></td>
                        <td><?= $data["PARTE"]; ?></td>
                        <td><?= $data["NUMVEZ"]; ?></td>
                        <td><?= $data["CANTIDAD"]; ?></td>
                        <td><?= $data["CANPAR"]; ?></td>
                        <td><?= $data["FECFINAUD"]; ?></td>
                        <td><?= $data["CODUSU"]; ?></td>
                        <td>
                            <!-- <button class="btn btn-danger btn-sm" type="button">
                                <i class="fas fa-trash"></i>
                            </button> -->
                            <button 
                                    class="btn btn-danger btn-sm eliminaraud" 
                                    type="button" 
                                    <?= $disabled;  ?> 
                                    data-idficha="0"
                                    data-ficha="<?= $data["CODFIC"]; ?>"
                                    data-parte="<?= $data["PARTE"]; ?>"
                                    data-vez="<?= $data["NUMVEZ"]; ?>"
                                >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>


</div>



<div class="loader"></div>


<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script>

    window.addEventListener('load',async ()=>{


        $(".loader").fadeOut("slow");
    });

    $(".eliminaraud").click(async function(){

        let rpt = await Preguntar("Confirme para eliminar auditoria");

        if(rpt.value){

            let idficha = $(this).data("idficha");
            let ficha   = $(this).data("ficha");
            let parte   = $(this).data("parte");
            let vez     = $(this).data("vez");


            post("auditex-generales","generales","setdeleteauditorias",[
                2,idficha,ficha,parte,vez,"<?= $_SESSION["user"]  ?>"
            ])
                .then(response => {

                    if(response.success){
                        Informar(response.mensaje,1500,true);
                    }else{
                        Advertir(response.mensaje);
                    }

                })
                .catch(error => {   
                    Advertir("Ocurrio un error");
                });

        }

    });


</script>



</body>
</html>