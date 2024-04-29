<?php
	session_start();
	date_default_timezone_set('America/Lima');

	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');

	}

    $_SESSION['navbar'] = "Carga de Packing Acabados";
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

        <!-- <div class="card-header">

        </div> -->

        <div class="card-body">

            
            <form class="row" id="frmsubida" autocomplete="off"> 

                <div class="col-md-4">
                    <label for="">PO</label>
                    <input type="text" class="form-control form-control-sm" id="txtpo" required>
                </div>

                <div class="col-md-6">

                    <label for="">Carga de archivo</label>
                    <input type="file" class="form-control form-control-sm" id="archivo" required>

                </div>
                
                <div class="col-md-2">
                    <label for="">&nbsp;</label>
                    <button class="btn btn-sm btn-block btn-primary" type="submit"   >CARGAR</button>
                </div>
                

            </form>

            
            <div class="table-responsive">

                <table class="table table-bordered table-sm mt-2 text-center" id="tabledatos">
                    <thead class="thead-light">
                        <tr id="theaddatos">
                            <th class='border-table'>PEDIDO</th>
                            <th class='border-table'>NIVEL</th>
                            <th class='border-table'>GRUPO</th>
                            <th class='border-table'>DSC ESTILO</th>
                            <th class='border-table'>COD TALLA</th>
                            <th class='border-table'>TALLA</th>
                            <th class='border-table'>ITEM</th>
                            <th class='border-table'>COLOR</th>
                            <th class='border-table'>CANTIDAD</th>
                            <th class='border-table'>ALTERNATIVA</th>
                            <th class='border-table'>RUTA</th>
                            <th class='border-table'>ESTILO CLI</th>
                            <th class='border-table'>PO</th>

                        </tr>
                    </thead>
                    <tbody id="tbodydatos"> 

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

    const frmsubida = document.getElementById("frmsubida");

    window.addEventListener('load',async ()=>{

        $(".loader").fadeOut("slow");


    });

    frmsubida.addEventListener('submit',async (e)=>{
        e.preventDefault();
        await ConfirmarPacking();
        // SubirAchivo();
    });

    $("#archivo").change(function(){

        SubirAchivo();

    });

    // CONFIRMAMOS ESTADO
    async function ConfirmarPacking(){

        $(".loader").fadeIn();

        let po = $("#txtpo").val().trim();
        let parameters = [po];

        let response = await post("auditex-audfinal", "cargapacking", "confirmarpacking", parameters);

        if(response.success){
            $(".loader").fadeOut("slow");
            Informar(response.rpt,2000,true);
        }

    }


    // SUBIR ARCHIVO
    function SubirAchivo(){

        $(".loader").fadeIn();

        let po = $("#txtpo").val().trim();

        const file = $("#archivo")[0].files[0];
        const formData = new FormData();
        formData.append("operacion","cargapacking");
        formData.append("archivo",file);
        formData.append("po",po);


        if(file){
                // REGISTRAMOS ARCHIVO
            MoverArchivos("auditex-audfinal","cargapacking",formData)
                .then(async (response) => { 

                    // ARMAMOS DATA
                    if(response.estado){
                        ArmarTabla(response.data);
                        $(".loader").fadeOut("slow");
                    }else{
                        ArmarTabla(response.data);
                        $(".loader").fadeOut();
                        Advertir(response.mensaje);
                    }
                    
                }).catch(error => {
                    alert("Ocurrio un error al registrar archivo");
                })
        }else{
            $(".loader").fadeOut();
            Advertir("Adjunte archivo");
        }

    }


    // ARMAMOS TABLA
    function ArmarTabla(data){

        let tr = "";
        for(let item of data){
            tr += `                        
                <tr>
                    <td>${item.PEDIDO}</td>
                    <td>${item.NIVEL}</td>
                    <td>${item.GRUPO}</td>
                    <td>${item.DSC_ESTILO}</td>
                    <td>${item.SUBGRUPO}</td>
                    <td>${item.DSC_TALLA}</td>
                    <td>${item.ITEM}</td>
                    <td>${item.DSC_COLOR}</td>
                    <td>${item.CANTIDAD}</td>
                    <td>${item.ALTERNATIVA}</td>
                    <td>${item.RUTA}</td>
                    <td>${item.ESTILO_CLI}</td>
                    <td>${item.PO_CLI}</td>

                </tr>
            `;

        }

        $("#tbodydatos").html(tr);

    }

</script>



</body>
</html>