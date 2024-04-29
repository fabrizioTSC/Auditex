<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location: main2.php");
    }
    $CodN2 = $_GET['cn2'];
    
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
        <ol class="breadcrumb bc-tsc" id="n3-breadcrumb"> 
        </ol>
    </div> 


    <div class="n3-container">
        <div class="n3-menu" id="cont-n3">
        </div>
    </div>

    <script src="Libs/Jquery/jquery-3.4.1.min.js"></script>
    <script src="./Libs/Bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript">
            
        loadMain();
        loadBreadCrumb();

        function loadMain (){

            let accesos = localStorage.getItem('accessform');
            let permisos = JSON.parse(accesos);

            var datos = [];
            let html3 = '';
                        
            var vCodN2 = '<?php echo $CodN2; ?>';

            let content3 = document.getElementById("cont-n3");

            if (typeof accesos == 'undefined' || accesos == null) {
                alert('Acceso a Nivel 3 no encontrado');
            }
            else {

                if(permisos.length > 0){
                    for(var i = 0; i < permisos.length; i++)
                    {
                        if (permisos[i].CODN2 == vCodN2) {   
                            if(!datos.includes(permisos[i].CODN3) ) {
                                html3 += 
                                
                                '<div class="n3-item" data-codn3="' + permisos[i].CODN3 + '">'
                                + '<div class="img-item-3">'
                                + '<img src="Admin/img/' + permisos[i].IMAGEN3 + '" alt="" srcset="">'
                                + '</div>'
                                + '<div class="desc-item-3">' + permisos[i].TW3 + '</div>'  
                                + '</div>';
                            }
                            datos[i] = permisos[i].CODN3;
                        }
                    }
                    content3.innerHTML = html3;
                }
            }

        }


        $(document).on("click", ".n3-container #cont-n3 .n3-item", function(){
            var vcodn3 = $(this).attr("data-codn3");
            location.href = "main4.php?cn3=" + vcodn3;
        });


        function loadBreadCrumb () {

            let datos2 = [];
            let datos1 = [];

            let html3 = '';

            let accesos = localStorage.getItem('accessform');
            let data = JSON.parse(accesos);
                        
            var vCodN2 = '<?php echo $CodN2; ?>';
            let cont3bc = document.getElementById("n3-breadcrumb");

            if(data.length > 0) {
                for(var i = 0; i < data.length; i++)
                {
                    if (data[i].CODN2 == vCodN2) {
                        if(!datos2.includes(data[i].CODN2)) {  
                            if(!datos1.includes(data[i].CODN1)) {  
                                html3 = '<li><a href="http://textilweb.tsc.com.pe:81/dashboard/main1.php">' + data[i].TW1 + '</a></li>' +
                                        '<li><a href="http://textilweb.tsc.com.pe:81/dashboard/main2.php?tw1=' + data[i].TW1 + '&cn1=' + data[i].CODN1 + '">' + data[i].TW2 + '</a></li>';
                            }
                            datos1[i] = data[i].CODN1;    
                        }
                        datos2[i] = data[i].CODN2;    
                    }
                }
                cont3bc.innerHTML = html3;
            }

        }
        

      
    </script>
    
    

</body>

</html>