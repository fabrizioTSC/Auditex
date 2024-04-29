<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}

    $_SESSION['navbar'] = "Registro de metales";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Metales</title>

    <!-- <link rel="stylesheet" href="../../../libs/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../libs/css/sistema.min.css">
    <link rel="stylesheet" href="../../../libs/css/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../../libs/js/datatables-bs4/css/dataTables.bootstrap4.css"> -->

    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

    <style>
        /* label{
            color:white;
        } */
        body{
            color:white;
            padding-top: 60px !important;
        }
    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container text-center pt-2">
    <h4>CERTIFICATION</h4>
    <h5>LANDS' END METAL DETECTION</h5>
</div>

<div class="container">

    <div class="row">

        <!-- REGISTRO -->
        <div class="col-md-6">
      
            <form id="frmregistro">

                    <!-- PRIMEROS DATOS -->
                    <fieldset class="fieldset mt-3 ">

                        <div class="row form-group pl-3">  
                            <div class="col-md-12 ">
                                <label>Detection Completed:</label>
                                <hr style="color: white;">
                            </div>
                        
                        </div>

                        <!--  -->
                        <div class="row form-group justify-content-md-center pr-2 pl-2">
                            <div class="col-md-2 ">
                                <label for="">Shipment PO#s:</label>
                            </div>
                            <div class="col-md-8 ">
                                <input type="text" id="txtpo" required class="form-control form-control-sm">
                            </div>
                        </div>
                        
                        <!--  -->
                        <div class="row form-group justify-content-md-center pr-2 pl-2">
                            <div class="col-md-2">
                                <label for="">Shipment BOL#:</label>
                            </div>
                            <div class="col-md-8 justify-content-md-center">
                                <input type="text" id="txtbol" class="form-control form-control-sm">
                            </div>
                        </div>

                        <!--  -->
                        <div class="row form-group justify-content-md-center pr-2 pl-2">
                            <div class="col-md-2">
                                <label for="">Date:</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" id="txtfecha" class="form-control form-control-sm" value="<?php echo date("Y-m-d");?>">
                            </div>
                        </div>

                        <!--  -->
                        <div class="row form-group justify-content-md-center pr-2 pl-2">
                            <div class="col-md-2">
                                <label for="">Usuario :</label>
                            </div>
                            <div class="col-md-8">
                                <select name="" id="cbousuario" required class="custom-select custom-select-sm"></select>
                            </div>
                        </div>
                    </fieldset>

                    <!-- SELECCIONE METODO -->
                    <fieldset class="fieldset mt-3">

                        <legend>Seleccione Metodo</legend>

                        <div class="row form-group justify-content-md-center pr-2 pl-2">

                            <div class="col-md-3">
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="rdbmetodo"  checked>
                                    <label class="form-check-label" for="rdbmetodo">
                                        Hand-Held 
                                        Notes-Comments:
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <textarea name="" id="txtnota" class="form-control form-control-sm" rows="2">NONE</textarea>
                            </div>
                        </div>


                    </fieldset>

                    <!-- VALIDADO POR -->
                    <fieldset class="fieldset mt-3 ">

                        <legend>Validado por:</legend>

                        <div class="row form-group justify-content-md-center pr-2 pl-2">

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked id="chkacabados">
                                    <label class="form-check-label" for="chkacabados">
                                        AREA ACABADOS
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked id="chkcalidad">
                                    <label class="form-check-label" for="chkcalidad">
                                        AREA CALIDAD
                                    </label>
                                </div>
                            </div>

                        </div>


                    </fieldset>

                    <div class="row justify-content-md-center pt-3 pb-5" >
                        <div class="col-md-4">
                            <button class="btn btn-danger btn-sm btn-block" id="btnregistrar" type="submit" >Registrar</button>
                        </div>
                    </div>

            </form>

        </div>

        <!-- DATOS REGISTRADOS -->
        <div class="col-md-6">

            <div class="card mt-3">  
                <div class="card-body">
                    
                    <table class="table table-sm table-bordered" id="tabledatos">
                        <thead class="thead-light">
                            <tr>
                                <th>PO</th>
                                <th>FECHA</th>
                                <th>NOMBRES</th>
                                <th>METODO</th>
                                <th>NOTAS</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="tbodydatos">

                        </tbody>
                    </table>
                </div>
            </div>


        </div>

    </div>


</div>


<div class="loader"></div>

<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script src="../../../libs/admin/registrometales/registro.js"></script>

<script >
    let IDREGISTRO = null;
    const frmregistro  = document.getElementById("frmregistro");

    window.addEventListener("load",async ()=>{
        await getUsuarios();
        await getRegistros();

        // OCULTAMOS CARGA
        $(".loader").fadeOut("slow");
    });

</script>


    
</body>
</html>