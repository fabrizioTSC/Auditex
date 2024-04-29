<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location: main3.php");
    }
    $CodN3 = $_GET['cn3'];
    
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
        <ol class="breadcrumb bc-tsc" id="n4-breadcrumb"> 
        </ol>
    </div> 


    <div class="n4-container">
        <div class="n4-menu" id="cont-n4">
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
            let html4 = '';

            var vCodN3 = '<?php echo $CodN3; ?>';
            var codusu = '<?php echo $_SESSION["codusu"]; ?>';

            let content4 = document.getElementById("cont-n4");
            
            if (typeof accesos == 'undefined' || accesos == null) {
                alert('Acceso a Nivel 4 no encontrado');
            }
            else {
                if(permisos.length > 0){
                    for(var i = 0; i < permisos.length; i++)
                    {   
                        if (permisos[i].CODN3 == vCodN3) {

                            if(!datos.includes(permisos[i].CODN4) ) {

                                html4 += 
                                '<div class="n4-item" data-puerto="' + permisos[i].PUERTO + '" data-controlador="'+permisos[i].CONTROLADOR+'" data-vista="' + permisos[i].VISTA + '" data-form="' + permisos[i].FORMLOGIN + '" data-codn4="' + permisos[i].CODN4 + '" data-au="' + permisos[i].AU4 + '"  data-fw4="' + permisos[i].FW4 + '" data-pw4="' + permisos[i].PW4 + '">'
                                + '<div class="img-item-4">'
                                
                                + '<img src="./Admin/img/' + permisos[i].IMAGEN4 + '" alt="" srcset="">'

                                + '</div>'
                                + '<div class="desc-item-4">' + permisos[i].TW4 + '</div>'  
                                + '</div>';
                            }
                            datos[i] = permisos[i].CODN4;
                        }
                    }
                    content4.innerHTML = html4;
                }
            }
        }

        $(document).on("click", ".n4-container #cont-n4 .n4-item", function(){

            let au          = $(this).attr("data-au");
            let dataform    = $(this).attr("data-form");


            // AGREGADO
            if(dataform == "1"){

                let puerto = $(this).data("puerto");
                let controlador = $(this).data("controlador");
                let vista = $(this).data("vista");

                LoginIntegrado(puerto,controlador,vista);

            }else{

                if (au == 1) {

                    let vfw = $(this).attr("data-fw4");
                    let vpw = $(this).attr("data-pw4");
                    let id4 = $(this).attr("data-codn4");

                    if(id4 == 73 || id4 == 74 || id4 == 75 || id4 == 76 || id4 == 77 || id4 == 78 || id4 == 79 ){
                        location.href = vpw + vfw + "/?token=<?php echo isset($_SESSION["tokeninnovate"]) ? $_SESSION["tokeninnovate"] : ""; ?>";

                    }else{
                        location.href = vpw + vfw;
                    }


                }
                else {  

                    var vcodn3 = $(this).attr("data-codn4");
                    location.href = "main5.php?cn4=" + vcodn3;

                }
            }

        });


        function loadBreadCrumb (){
            
            let datos3 = [];
            let datos2 = [];
            let datos1 = [];
            
            let accesos = localStorage.getItem('accessform');
            let data = JSON.parse(accesos);
            
            let html4 = '';
            var vCodN3 = '<?php echo $CodN3; ?>';
            let cont4bc = document.getElementById("n4-breadcrumb");

            if(data.length > 0){
                for(var i = 0; i < data.length; i++)
                {
                    if (data[i].CODN3 == vCodN3) {
                        if(!datos3.includes(data[i].CODN3)) {  
                            if(!datos2.includes(data[i].CODN2)) {  
                                if(!datos1.includes(data[i].CODN1)) {  
                                    html4 = '<li><a href="http://textilweb.tsc.com.pe:81/dashboard/main1.php">' + data[i].TW1 + '</a></li>' +
                                            '<li><a href="http://textilweb.tsc.com.pe:81/dashboard/main2.php?tw1=' + data[i].TW1 + '&cn1=' + data[i].CODN1 + '">' + data[i].TW2 + '</a></li>' +
                                            '<li><a href="http://textilweb.tsc.com.pe:81/dashboard/main3.php?cn2=' + data[i].CODN2 + '">' + data[i].TW3 + '</a></li>';
                                }
                                datos1[i] = data[i].CODN1;    
                            }
                            datos2[i] = data[i].CODN2;    
                        }
                        datos3[i] = data[i].CODN3; 
                    }
                }
                cont4bc.innerHTML = html4;
            }
        }


        // LOGIN
        function LoginIntegrado(puerto,controladorvalor,vistavalor){

                // alert(puerto+""+controladorvalor+""+vistavalor);

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