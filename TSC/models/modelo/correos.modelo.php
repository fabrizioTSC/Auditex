<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require __DIR__."../../../vendor/autoload.php";

    
    class CorreosModelo extends PHPMailer{

        function __CONSTRUCT(){

            // $this->SMTPDebug = SMTP::DEBUG_SERVER;  -- SE HABILITA PARA DEBUG
            $this->IsSMTP();                            // SMTP
            $this->SMTPAuth = true;                     // SMTP AUNT
            
            
            $this->Host     = "smtp-mail.outlook.com";               //SERVIDOR      -       OUTLOOK
            // $this->Host  = "smtp.gmail.com";                      //SERVIDOR      -       GMAIL
            
            $this->Port     = 587;                                          //PUERTO    
            // $this->Username = "julio302318@outlook.es";                     //CORREO
            // $this->Password = "jheison302318";                              //CONTRASEÑA

            $this->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;             // SEGURIDAD
            // $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;             // SEGURIDAD

            $this->CharSet = 'UTF-8';
            // $this->SetFrom('julio302318@outlook.es', 'Depuración Corte');       //QUIEN LO ENVIA - ALIAS
            // $this->AddAddress("julio302318@gmail.com");                         //CORREO PARA DESTINARIO
            //$this->addCC("");    

        }

        function EnviarCorreo($correoremitente,$clavermitente,$asunto,$mensaje,$destinatarios,$copiados = null,$alias = null,$html = true){
            $devolver = [];
            try{

                $this->Username = $correoremitente;                     //CORREO
                $this->Password = $clavermitente;                       //CONTRASEÑA    
                if($alias != null){
                    $this->SetFrom($correoremitente, $alias);           //QUIEN LO ENVIA - ALIAS
                }

                $this->isHTML($html);                                   // FORMATO HTML
                $this->Subject = $asunto;                  // ASUNTO
                $this->Body    = $mensaje;                              // MENSAJE
                // $this->AltBody = 'This is the body in plain text for non-HTML mail clients';
                

                // DESTINATARIOS
                if($destinatarios != null){
                    foreach($destinatarios as $destinatario){
                        $this->AddAddress($destinatario["CORREO"]);                                   
                    }
                }

                // COPIADOS
                if($copiados != null){
                    foreach($copiados as $copiado){
                        $this->addCC($copiado["CORREO"]);                                   
                    }
                }

                // ENVIAMOS
                $this->Send();

                $devolver = [
                    "success" => true,
                    "mensaje" => "Correo enviado correctamente"
                ];
                // echo "correcto";
            }catch(Exception $e){
                $devolver = [
                    "success" => false,
                    "mensaje" => $this->ErrorInfo
                ];
            }

            return $devolver;
        }



    }


?>