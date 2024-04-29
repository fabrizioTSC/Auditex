<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location: main4.php");
    }
    $CodN4 = $_GET['cn4'];

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
        <ol class="breadcrumb bc-tsc" id="n5-breadcrumb"> 
        </ol>
    </div> 

    <div class="n5-container">
        <div class="n5-menu" id="cont-n5">
        </div>
    </div>

    <script src="Libs/Jquery/jquery-3.4.1.min.js"></script>
    <script src="./Libs/Bootstrap/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">

        loadMain();
        loadBreadCrumb();

        function loadMain_old (){

            let accesos = localStorage.getItem('accessform');
            let permisos = JSON.parse(accesos);

            var datos = [];
            let html5 = '';

            var vCodN4 = '<?php echo $CodN4; ?>';
            var codusu = '<?php echo $_SESSION["codusu"]; ?>';

            let content5 = document.getElementById("cont-n5");
            
            if (typeof accesos == 'undefined' || accesos == null) {
                alert('Acceso a Nivel 5 no encontrado');
            }
            else {
                if(permisos.length > 0){
                    for(var i = 0; i < permisos.length; i++)
                    {
                        if (permisos[i].CODN4 == vCodN4) {
                        
                            if(!datos.includes(permisos[i].CODN5)) {
                                html5 += 
                                '<div class="n5-item" data-url="' + permisos[i].PW5 + '' +  permisos[i].FW5 + '">'
                                + '<div class="img-item-5">'
                                + '<img src="./Admin/img/' + permisos[i].IMAGEN5 + '" alt="" srcset="">'
                                + '</div>'
                                + '<div class="desc-item-5">' + permisos[i].TW5 + '</div>'
                                + '</div>';
                            }
                            datos[i] = permisos[i].CODN5;
                        }
                    }
                    content5.innerHTML = html5;
                }
            }
        }



        function loadMain (){

            let accesos = localStorage.getItem('accessform');
            let permisos = JSON.parse(accesos);

            var datos = [];
            let html5 = '';

            var vCodN4 = '<?php echo $CodN4; ?>';
            var codusu = '<?php echo $_SESSION["codusu"]; ?>';

            let content5 = document.getElementById("cont-n5");

            if (typeof accesos == 'undefined' || accesos == null) {
                alert('Acceso a Nivel 5 no encontrado');
            }
            else {
                if(permisos.length > 0){
                    for(var i = 0; i < permisos.length; i++)
                    {
                        if (permisos[i].CODN4 == vCodN4) {
                        
                            if(!datos.includes(permisos[i].CODN5)) {
                                //'<div class="n5-item" data-url="' + permisos[i].PW5 + '' +  permisos[i].FW5 + '">'

                                html5 += 
                                '<div class="n5-item" data-puerto="' + permisos[i].PUERTO5 + '" data-controlador="'+permisos[i].CONTROLADOR5 +'" data-vista="' + permisos[i].VISTA5 + '" data-form="' + permisos[i].FORMLOGIN5 + '" data-codn5="' + permisos[i].CODN5 + '" data-fw5="' + permisos[i].FW5 + '" data-pw5="' + permisos[i].PW5 + '">'
                                + '<div class="img-item-5">'
                                + '<img src="./Admin/img/' + permisos[i].IMAGEN5 + '" alt="" srcset="">'
                                + '</div>'
                                + '<div class="desc-item-5">' + permisos[i].TW5 + '</div>'
                                + '</div>';
                            }
                            datos[i] = permisos[i].CODN5;
                        }
                    }
                    content5.innerHTML = html5;
                }
            }
        }


      
        $(document).on("click", ".n5-container #cont-n5 .n5-item_OLD", function(){
            var url_form = $(this).attr("data-url");
            location.href = url_form;
        });


        $(document).on("click", ".n5-container #cont-n5 .n5-item", function(){
            let dataform = $(this).attr("data-form");

            // AGREGADO
            if(dataform == "1"){

                let puerto = $(this).data("puerto");
                let controlador = $(this).data("controlador");
                let vista = $(this).data("vista");

                LoginIntegrado(puerto,controlador,vista);

                // AGREGADO PARA LOGIN DE AUDITEX V2
            }else if(dataform == "2"){

                let puerto = $(this).data("puerto");
                let usuario = '<?=  $_SESSION['user'];?>';

                location.href = `${puerto}?usuario=${usuario}`;

            }else{

                let vfw = $(this).attr("data-fw5");
                let vpw = $(this).attr("data-pw5");
                let id4 = $(this).attr("data-codn5");

                location.href = vpw + vfw;
            }
        });


        function loadBreadCrumb (){

            let datos4 = [];
            let datos3 = [];
            let datos2 = [];
            let datos1 = [];
            
            let accesos = localStorage.getItem('accessform');
            let data = JSON.parse(accesos);
            
            let html5 = '';

            var vCodN4 = '<?php echo $CodN4; ?>';
            let cont5bc = document.getElementById("n5-breadcrumb");

            if(data.length > 0){
                for(var i = 0; i < data.length; i++)
                {
                    if ((data[i].CODN4 == vCodN4))  {
                        if(!datos4.includes(data[i].CODN4)) {  
                            if(!datos3.includes(data[i].CODN3)) {  
                                if(!datos2.includes(data[i].CODN2)) {  
                                    if(!datos1.includes(data[i].CODN1)) {  
                                    
                                        html5 = '<li><a href="http://textilweb.tsc.com.pe:81/dashboard/main1.php">' + data[i].TW1 + '</a></li>' +
                                                '<li><a href="http://textilweb.tsc.com.pe:81/dashboard/main2.php?tw1=' + data[i].TW1 + '&cn1=' + data[i].CODN1 + '">' + data[i].TW2 + '</a></li>' +
                                                '<li><a href="http://textilweb.tsc.com.pe:81/dashboard/main3.php?cn2=' + data[i].CODN2 + '">' + data[i].TW3 + '</a></li>' +
                                                '<li><a href="http://textilweb.tsc.com.pe:81/dashboard/main4.php?cn3=' + data[i].CODN3 + '">' + data[i].TW4 + '</a></li>';
                                    }
                                    datos1[i] = data[i].CODN1;    
                                }
                                datos2[i] = data[i].CODN2;    
                            }
                            datos3[i] = data[i].CODN3;
                        }
                        datos4[i] = data[i].CODN4; 
                    }
                }
                cont5bc.innerHTML = html5;
            }


        

        }

        function LoginIntegrado(puerto,controladorvalor,vistavalor){

            //CREAMOS FORMULARIO
            var form = document.createElement("form");

            var usuario         = document.createElement("input");  
            var clave           = document.createElement("input");  
            var idempresa       = document.createElement("input");  
            var controlador     = document.createElement("input");  
            var vista           = document.createElement("input");  

            // CONFIGURAMOS ATRIBUTOS DEL FORMULARIO
            form.method = "POST";
            form.action = puerto+"/Dashboard/LoginExterno";   
            // form.target = "_blank";

            // PARAMETRO USUARIO
            usuario.value= "<?php echo  $_SESSION['user'];?>";
            usuario.name = "usuario";
            form.appendChild(usuario);

            // PARAMETRO CLAVE
            // clave.value= "<?php echo  $_SESSION['passuser'];?>";
            clave.value= "<?php echo  isset($_SESSION['passuser']) ? $_SESSION['passuser'] : "";?>";

            clave.name = "clave";
            form.appendChild(clave);

            // PARAMETRO EMPRESA
            idempresa.value= "1";
            idempresa.name = "idempresa";
            form.appendChild(idempresa);

            // PARAMETRO CONTROLADOR
            controlador.value= controladorvalor;
            controlador.name = "controlador";
            form.appendChild(controlador);

            // PARAMETRO ACTION
            vista.value= vistavalor;//"LiquidacionCorte";
            vista.name = "vista";
            form.appendChild(vista);

            // AGREGAMOS INPUT AL FORMULARIO
            document.body.appendChild(form);

            // ENVIAMOS FORMULARIO
            form.submit();

            // REMOVEMOS FORMULARIO
            document.body.removeChild(form);
        }


    </script>
    
    

</body>

</html>