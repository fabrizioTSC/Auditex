<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location: main1.php");
    }
    $CodN1 = $_GET['cn1'];
    $TW1 = $_GET['tw1'];

    include("_mainheader.php");
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Admin/css/estilo_menu.css">
    <link rel="stylesheet" href="Libs/Fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="./Libs/Bootstrap/css/bootstrap.min.css">
</head>
<body>

    <?php contentMainHeader();?>
    
    <div class="container-fluid cf-tsc">
        <ol class="breadcrumb bc-tsc">
            <li><a href="http://textilweb.tsc.com.pe:81/dashboard/main1.php"><?php echo $TW1; ?></a></li>
        </ol>
    </div> 

    <div class="n2-container">
        <div class="n2-menu" id="cont-n2">
        </div>
    </div>

    <script src="Libs/Jquery/jquery-3.4.1.min.js"></script>
    <script src="./Libs/Bootstrap/js/bootstrap.min.js"></script>

    
    
    <script type="text/javascript">

        loadMain();

        function loadMain (){
            let accesos = localStorage.getItem('accessform');
            let permisos = JSON.parse(accesos);

            var datos = [];
            let html2 = '';
                        
            var vCodN1 = '<?php echo $CodN1; ?>';

            let content2 = document.getElementById("cont-n2");

            if (typeof accesos == 'undefined' || accesos == null) {
                alert('Acceso a Nivel 2 no encontrado');
            }
            else {

                if(permisos.length > 0){
                    for(var i = 0; i < permisos.length; i++)
                    {
                        if (permisos[i].CODN1 == vCodN1) {
                            if(!datos.includes(permisos[i].CODN2) ) {
                                html2 += 
                                '<div class="n2-item" data-codn2="' + permisos[i].CODN2 + '">'
                                + '<div class="img-item-2">'
                                
                                + '<img src="./Admin/img/' + permisos[i].IMAGEN2 + '" alt="" srcset="">'

                                + '</div>'
                                + '<div class="desc-item-2">' + permisos[i].TW2 + '</div>'  
                                + '</div>';
                            }
                            datos[i] = permisos[i].CODN2;
                        }
                    }
                    content2.innerHTML = html2;
                }
            }
        }

        $(document).on("click", ".n2-container #cont-n2 .n2-item", function(){
            var vcodn2 = $(this).attr("data-codn2");
            location.href = "main3.php?cn2=" + vcodn2;
        });

        
    </script>
    
    

</body>

</html>