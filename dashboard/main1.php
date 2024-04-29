<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location: index.php");
    }
    
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
    <link rel="stylesheet" href="./Libs/Bootstrap/css/bootstrap.min.css">

</head>
<body>

    <?php contentMainHeader();?>
    
    <?php 
        // echo $_SESSION["tokeninnovate"];
    ?>

    <div class="n1-container">
        <div class="n1-menu" id="cont-n1">
        </div>
    </div>

    <script src="Libs/Jquery/jquery-3.4.1.min.js"></script>
    <script src="./Libs/Bootstrap/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
    
        loadMain ();

        function loadMain()
        {            
            let accesos = localStorage.getItem('accessform');
            var datos = [];
            let content = document.getElementById("cont-n1");
            let html='';

            if (typeof accesos == 'undefined' || accesos == null) {

                var codusu = '<?php echo $_SESSION["codusu"]; ?>';
               
                $.ajax({
                    url:'accesos.php',
                    type:'POST',
                    data: {
                        opcion : 6,
                        nivel : 1,
                        codusu : codusu
                    },
                    success:function(data){
                        
                        if(data.length > 0) {
                            
                            localStorage.setItem("accessform",JSON.stringify(data));
                            

                            for (var i = 0; i < data.length; i++) {
                                if (!datos.includes(data[i].CODN1)) {
                                    if (data[i].CODN1 != null) {
                                        html += 
                                        '<div class="n1-item n1-item-1" data-codn1="' + data[i].CODN1 + '" data-tw="' + data[i].TW1 + '">'+
                                            '<img src="Admin/img/' + data[i].IMAGEN1 + '" alt="'+ data[i].TW1 +'">'+
                                            '<div class="cont-card">'+
                                            '<p class="card-titulo">'+
                                            '<b>' + data[i].TW1 + '</b></p>'+
                                            '<p class="card-detalle">' + data[i].STW1 + '</p>'+
                                            '</div>'+
                                        '</div>';
                                    }
                                }
                                datos[i] = data[i].CODN1;
                            }

                            content.innerHTML=html;
                        }
                    }
                });
            }
            else {

                let permisos = JSON.parse(accesos);
            
                if(permisos.length > 0){
                    for (var i = 0; i < permisos.length; i++) {

                        if (!datos.includes(permisos[i].CODN1)) {
                            if (permisos[i].CODN1 != null) {
                                html += 
                                '<div class="n1-item n1-item-1" data-codn1="' + permisos[i].CODN1 + '" data-tw="' + permisos[i].TW1 + '">'+
                                    '<img src="Admin/img/' + permisos[i].IMAGEN1 + '" alt="'+ permisos[i].TW1 +'">'+
                                    '<div class="cont-card">'+
                                    '<p class="card-titulo">'+
                                    '<b>' + permisos[i].TW1 + '</b></p>'+
                                    '<p class="card-detalle">' + permisos[i].STW1 + '</p>'+
                                    '</div>'+
                                '</div>';
                            }
                        }
                        datos[i] = permisos[i].CODN1;
                    }
                    content.innerHTML=html;
                }
            }   
        }

        $(document).on("click", ".n1-container #cont-n1 .n1-item", function(){
            var vcodn1 = $(this).attr("data-codn1");
            var vtw1 = $(this).attr("data-tw");
            
            // // Definir si es Gestion de Liquidacion.
            // if (vcodn1 == 3)
            // {
            //     //window.open('http://textilweb.tsc.com.pe:8094/','_blank');

            //     // location.href = "http://textilweb.tsc.com.pe:8094/";

            //     //CREAMOS FORMULARIO
            //     var form = document.createElement("form");

            //     var usuario         = document.createElement("input");  
            //     var clave           = document.createElement("input");  
            //     var idempresa       = document.createElement("input");  
            //     var controlador     = document.createElement("input");  
            //     var vista           = document.createElement("input");  

            //     // CONFIGURAMOS ATRIBUTOS DEL FORMULARIO
            //     form.method = "POST";
            //     form.action = "http://localhost:11633/Dashboard/LoginExterno";   
            //     // form.target = "_blank";

            //     // PARAMETRO USUARIO
            //     usuario.value= "JAMORETTIA";
            //     usuario.name = "usuario";
            //     form.appendChild(usuario);

            //     // PARAMETRO CLAVE
            //     clave.value= "JAMORETTIA";
            //     clave.name = "clave";
            //     form.appendChild(clave);

            //     // PARAMETRO EMPRESA
            //     idempresa.value= "1";
            //     idempresa.name = "idempresa";
            //     form.appendChild(idempresa);
                
            //     // PARAMETRO CONTROLADOR
            //     controlador.value= "Corte";
            //     controlador.name = "controlador";
            //     form.appendChild(controlador);

            //     // PARAMETRO ACTION
            //     vista.value= "LiquidacionCorte";
            //     vista.name = "vista";
            //     form.appendChild(vista);

            //     // AGREGAMOS INPUT AL FORMULARIO
            //     document.body.appendChild(form);

            //     // ENVIAMOS FORMULARIO
            //     form.submit();

            //     // REMOVEMOS FORMULARIO
            //     document.body.removeChild(form);



            // }
            // else {
            //     location.href = "main2.php?tw1=" + vtw1 + "&cn1=" + vcodn1;
            // }
                location.href = "main2.php?tw1=" + vtw1 + "&cn1=" + vcodn1;
        });



    </script>

</body>

</html>