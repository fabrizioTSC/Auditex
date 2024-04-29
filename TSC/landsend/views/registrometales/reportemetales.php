<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}

    $_SESSION['navbar'] = "Reporte de metales";
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
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">

                    <table class="table table-sm table-bordered" id="tableregistros">
                        <thead class="thead-light">
                            <tr>    
                                <th nowrap>ACA</th>
                                <th nowrap>CAL</th>
                                <th nowrap>ID</th>
                                <th nowrap>PO</th>
                                <th nowrap>BOL</th>
                                <th nowrap>FECHA</th>
                                <th nowrap>DNI</th>
                                <th nowrap>NOMBRES</th>
                                <th nowrap>SIGNATURE</th>
                                <th nowrap>METODO</th>
                                <th nowrap>NOTAS</th>
                                <th nowrap>FECHA REGISTRO</th>
                                <th nowrap></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyregistros">
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

<script >
    //let IDREGISTRO = null;
    //const frmregistro  = document.getElementById("frmregistro");

    window.addEventListener("load",async ()=>{
        //await getUsuarios();
        await getRegistros();

        // OCULTAMOS CARGA
        $(".loader").fadeOut("slow");
    });


    async function getRegistros(){

        let response = await get("landsend","registrometales","getregistros");
        console.log(response);
        let tr = "";
        
        response.forEach((obj)=>{

            let acabados = obj.VALIDADOACABADOS == "1" ? "<input type='checkbox' checked disabled>" : "<input type='checkbox' disabled>";
            let calidad  = obj.VALIDADOCALIDAD  == "1" ? "<input type='checkbox' checked disabled>" : "<input type='checkbox' disabled>";

 
            tr += `
                <tr>
                    <td nowrap class='text-center'> ${acabados} </td>
                    <td nowrap class='text-center'> ${calidad} </td>
                    <td nowrap> ${obj.IDREGISTRO} </td>
                    <td nowrap> ${obj.PO == null ? '' : obj.PO  } </td>
                    <td nowrap> ${obj.BOL == null ? '' : obj.BOL} </td>
                    <td nowrap> ${obj.FECHA} </td>
                    <td nowrap> ${obj.DNI} </td>
                    <td nowrap> ${obj.NOMBRES} </td>
                    <td nowrap> </td>
                    <td nowrap> ${obj.METODO} </td>
                    <td nowrap> ${obj.NOTAS} </td>
                    <td nowrap> ${obj.F_REGISTRO} </td>



                    <td nowrap> 

                        <a href='imprimirpdf.php?id=${obj.IDREGISTRO}' target='_blank' title='Imprimir' class='mr-1'> 
                            <i class='fas fa-print'></i>
                        </a>

                    </td>
                </tr>
            `;
        });


        ArmarDataTable("registros",tr,false,true,false,true);

    }

</script>


    
</body>
</html>