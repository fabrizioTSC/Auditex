<?php   
    session_start();
    if(isset($_SESSION['user'])){
        header("location: main1.php");
    }

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TSC Web - Login</title>
    <!-- PARA CELULARES -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="Libs/fontawesome-free/css/all.min.css">
    <!-- SISTEMA -->
    <link href="Admin/css/sistema.css" rel="stylesheet" />
    <!-- DASHBOARD ESTILOS -->
    <link rel="stylesheet" href="Libs/Dashboard/css/adminlte.min.css">
    <!-- ICONO -->
    <link rel="shortcut icon" type="image/x-icon" href="public/favicon.ico" />

</head>
<body class="login-block">
    <div class="login-caja">

        <!-- /.login-logo -->
        <div class="card ">
            <div class="card-body login-card-body rounded p-0">

                <div class="row">

                    <!-- PRIMERA COLUMNA -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 p-4">

                        <div class="form-group">
                            <h3 class="text-center font-weight-bold">Iniciar Sesión</h3>
                        </div>
                        <!-- IMAGEN -->
                        <div class="text-center mb-3">
                            <img src="Public/tecsito.png" class="rounded-circle w-50">
                        </div>
                        <!-- DNI -->
                        <div class="input-group mt-3">
                            <input type="text" class="form-control mayus credenciales" placeholder="DNI (opcional)" id="iddni" value="" autofocus>
                            <div class="input-group-append input-group-text" onclick="show_by_dni()" style="background: #2d6d8c;color:#fff;">
                                <span class="fas fa-search"></span>
                            </div>
                        </div>
                        <label id="idnamecontent" style="margin: 1rem 0 0 0;display: none;">Hola <span id="idname"></span></label>
                        <!-- USUARIO -->
                        <div class="input-group mt-3" >
                            <input type="text" class="form-control mayus credenciales" placeholder="Usuario" id="txtUsuario" value="" autofocus>
                            <div class="input-group-append input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <!-- CLAVE -->
                        <div class="input-group mt-3">
                            <input type="password" class="form-control mayus credenciales" placeholder="Contraseña" id="txtPassword" value="">
                            <div class="input-group-append input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="btnLogin">&nbsp;</label>
                            <button  class="btn btn-block btn-danger" id="btnLogin">
                                Login
                            </button>
                        </div>
                       
                    </div>

                    <!-- SEGUNDA COLUMNA -->
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 ">

                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                            </ol>
                            <div class="carousel-inner " >
                                <div class="carousel-item active">
                                    <img src="public/img1.jpg" class="d-block w-100 " >
                                </div>
                                <div class="carousel-item">
                                    <img src="public/img2.jpg" class="d-block w-100 " >
                                </div>
                                <div class="carousel-item">
                                    <img src="public/img3.jpg" class="d-block w-100 " >
                                </div>
                                <div class="carousel-item">
                                    <img src="public/img4.jpg" class="d-block w-100 " >
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- JQUERY -->
    <script src="Libs/Jquery/jquery-3.4.1.min.js"></script>
    <!-- BOOTSTRAP 4 -->
    <script src="Libs/Bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- SWEET ALERT 2 -->
    <script src="Libs/sweetalert2/sweetalert2.all.min.js"></script>

    <script>

        $("#btnLogin").click(function(){
            Login();
        });

        $(".credenciales").keypress(function(e){
            if(e.keyCode == 13) Login();
        });

        function show_by_dni(){
            if ($("#iddni").val()=="") {
                Swal.fire("Complete los datos","Textile Web","warning");
            }else{
                
                $.ajax({
                    url:'getUsuDNI.php',
                    type:'POST',
                    data:{
                        dni:$("#iddni").val()
                    },
                    success:function(data){
                        //console.log(data);
                        if(data.state){
                            $("#idname").text(data.datos.NOMUSU);
                            $("#idnamecontent").css("display","block");
                            $("#txtUsuario").val(data.datos.ALIUSU);
                        }else{
                            $("#idnamecontent").css("display","none");
                            $("#txtUsuario").val("");
                            $("#txtPassword").val("");  
                            Swal.fire(data.detail,"Textile Web","warning");
                        }
                    }
                });
            }
        }


        function Login(){

            let datos = {
                'username'  :   $("#txtUsuario").val().trim().toUpperCase(),
                'password'  :   $("#txtPassword").val().trim().toUpperCase(),
                'operacion' : 'login'
            }

            if(datos.username != "" && datos.password != ""){

                // CARGA
                Swal.fire({
                    title: "Validando credenciales",
                    html: 'Esto puede tardar unos minutos',
                    //timer: 2000,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })  

                $.ajax({
                    // url:'../tsc-web/auditex/config/login.php',
                    url:'../tsc/controllers/innovate/login.controller.php',
                    type:'POST',
                    data:datos,
                    success:function(e){
                        let js = JSON.parse(e);
                        // console.log(js);

                        if(js.token){
                            saveToken(js);
                        }else{
                            if(js.success){
                                Swal.fire(js.msjusuario,"Textile Web","success");
                                setTimeout(()=>{
                                    location.href = "main1.php";
                                },1000); 
                            }else{
                                Swal.fire(js.msjusuario,"Textile Web","warning");
                            }
                        }

                        // if(js.token || js.msjusuario){
                        //     if(js.msjusuario != "Usuario no existe"){
                        //         saveToken(js.token);
                        //     }else{
                                
                        //         Swal.fire("Correcto","Textile Web","success");
                        //         setTimeout(()=>{
                        //             location.href = "main1.php";
                        //         },1000); 
                                
                        //     }
                        // }else{
                        //     Swal.fire("Las credenciales son incorrectas","Textile Web","warning");
                        // }
                    }
                });

            }else{
                Swal.fire("Complete los datos","Textile Web","warning");
            }
        }

        function saveToken(js){

            $.ajax({
                    url:'../tsc/controllers/innovate/login.controller.php',
                    type:'POST',
                    data:{operacion:"savetoken",token:js.token},
                    success:function(e){
                        Swal.fire(js.msjusuario,"Textile Web","success");
                        setTimeout(()=>{
                            location.href = "main1.php";
                        },1000);
                    }
                    
            });

            

        }
    
    </script>


</body>
</html>

