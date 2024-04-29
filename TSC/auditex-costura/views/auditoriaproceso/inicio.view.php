<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		// header('Location: index.php');
		header('Location: /dashboard');
	}

    require_once '../../../models/modelo/core.modelo.php';
    $objModelo = new CoreModelo();

    //CARGAMOS FICHAS DEL SIGE
    // $responsecargasige = $objModelo->setAllSQL("uspCargaAuditoriaEnvioToAuditex",[],"Correcto");
    // var_dump($responsecargasige);

    $_SESSION['navbar'] = "Iniciar Auditoria Proceso";
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

    </style>

</head>
<body>

<?php require_once '../../../plantillas/navbar.view.php'; ?>

<div class="container mt-3">

    <form action="" class="row" id="frmbusqueda">

        <div class="col-12 form-group">
            <label class="font-weight-bold">Taller:</label>
            <select name="" id="cbotaller" class="custom-select select2" style="width: 100%;" ></select>
        </div>

        <div class="col-12 form-group">
            <label class="font-weight-bold">Fichas a Auditar:</label>
        </div>

        <div class="col-12 form-group">

            <table class="table table-bordered table-sm table-hover" id="tablefichas">
                <thead class="thead-light text-center">
                    <tr>
                        <th class="border-table">Ficha</th>
                        <th class="border-table">Cantidad</th>
                    </tr>
                </thead>
                <tbody id="tbodyfichas" class='bg-white'>

                </tbody>
            </table>

        </div>

    </form>



</div>



<div class="loader"></div>


<!-- SCRIPTS -->
<?php require_once '../../../plantillas/script.view.php'; ?>

<script>


    let CODIGOTALLER = null;

    window.addEventListener('load',async ()=>{

        // OBTENEMOS USUARIOS
        await getTalleres();

        // PARA SELECCIONAR FICHA
        $("#cbotaller").change(async function(){

            $(".loader").fadeIn("show");
            let valor = $("#cbotaller").val();
            await getFichas(valor);
            $(".loader").fadeOut("slow");

        });

        $(".loader").fadeOut("slow");
    });

    // GET TALLERES
    async function getTalleres(){

        let response = await get("auditex-costura", "auditoriaproceso", "getTalleres", { });
        let tr = "<option value=''>[SELECCIONE]</option>";
        for(let item of response){
            tr +=  `
                <option value='${item.CODTLL}'> ${item.DESTLL} (${item.DESCOM}) </option>
            `;
        }

        $("#cbotaller").html(tr);

    }

    // GET FICHAS
    async function getFichas(codtll){

        CODIGOTALLER = codtll;

        let response = await get("auditex-costura", "auditoriaproceso", "getfichasauditar", { codtll });
        let tr = "";

        console.log(response)

        for(let item of response.responselista){
            tr +=  `
                <tr onclick="validateInicio(${item.CODFIC})">

                    <td class="text-center">${item.CODFIC}</td>
                    <td class="text-center">${item.CANPRE}</td>

                </tr>
            `;
        }

        ArmarDataTable_New("fichas",tr,false,false,false,false,true,false);

        // $("#cbotaller").html(tr);


    }

    // VALIDA INICIO
    function validateInicio(codfic){


        $(".loader").fadeIn("show");


        let parameters = [codfic,CODIGOTALLER, "<?= $_SESSION["user"]; ?>"];

        post("auditex-costura", "auditoriaproceso", "validateinicio", parameters)
        .then(response => {
            // console.log(response)

            if(response.success){

				location.href="registro.view.php?ficha="+codfic+"&turno=1&codtll="+CODIGOTALLER;


            }else{

                $(".loader").fadeOut("slow");
                Advertir("No se pudo iniciar");


            }

        })
        .catch(error => {
            console.log(error)
            $(".loader").fadeOut("slow");
            Advertir("Ocurrio un error :C")
        });


    }


</script>



</body>
</html>