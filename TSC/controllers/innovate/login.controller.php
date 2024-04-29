<?php
	
	require_once '../../models/modelo/core.modelo.php';
	require_once '../../models/modelo/innovate.modelo.php';
	require_once '../../models/modelo/textileweb.modelo.php';


    session_start();
    $objModelo = new CoreModelo();
    $objInnovate = new InnovateModel();
	// $objTextileWeb = new TextileWebModel();



	if (isset($_POST['operacion'])) {

		// LOGIN
		if($_POST["operacion"] == "login"){

			$responseusu = $objModelo->get("AUDITEX.SP_AT_SELECT_USUARIOLOGIN",[
				$_POST["username"]
			]);
				
			// echo json_encode($responseusu);

			if($responseusu){
	
				if($_POST["password"] == $responseusu["PASSWORDUSU"]){
	
					//VARIABLES DE SESION
					$_SESSION['user']			=	$_POST['username'];
					$_SESSION['passuser']		=	$_POST['password'];

					$_SESSION['perfil']			=	$responseusu["CODROL"];

					// $_SESSION['perfil']			=	"5";


					$_SESSION['codusu']			=	$responseusu["CODUSU"];
					$_SESSION['codcargo']		=	$responseusu["CODIGO_CARGO"];
	
					$accesos=array();
	
					$responseacc = $objModelo->getAll("AUDITEX.SP_AT_SELECT_USUACC",[
						$responseusu["CODUSU"]
					]);
	
					// SESSION INNOVATE
					// $responseinnovate =  $objInnovate->LoginInnovate($_POST['username'],$_POST["password"]);
					// $responseinnovate =  $objInnovate->LoginInnovate($_POST['username'],$_POST["password"]);
	
					$i = 0;
					foreach($responseacc as $fila){
	
						$obj=new stdClass();
						$obj->CODTAD= $fila['CODTAD'];
						$obj->DESTAD= $fila['DESTAD'];
						$obj->RUTAPL= $fila['RUTAPL'];
						$obj->CODROL= $fila['CODROL'];
						$obj->DESROL= $fila['DESROL'];
						$accesos[$i]=$obj;
						$i++;
					}
	
					$_SESSION['accesos']=json_encode($accesos);
	
					// echo json_encode(array("success"=> true));

					// NOS LOGUEAMOS PARA INNOVATE
					$objInnovate->LoginInnovate($_POST['username'],$_POST["password"],true);

					// NOS LOGUEMOS PARA TEXTIL WEB
					// $objTextileWeb->LoginTextileWeb($_POST['username'],$_POST["password"],true);
	
				}else{
					$_SESSION['error']=1;
					echo json_encode(array("success"=> false,"msjusuario" => "Clave incorrecta"));
				}
	
			}else{
				$_SESSION['error']=0;
				echo json_encode(array("success"=> false,"msjusuario" => "Usuario no existe o esta inhabilitado"));
			}

		}

		// GUARDAR TOKEN
		if($_POST["operacion"] == "savetoken"){

			$_SESSION["tokeninnovate"] = $_POST["token"];
		}

	}

	
	

?>