<?php

    require __DIR__.'../../../vendor/autoload.php';

    class InnovateModel {

        public function LoginInnovate($usuario,$clave,$existe = false){

            try{

                $url = "http://textilweb.tsc.com.pe:8098";


                $client = new \GuzzleHttp\Client(["base_uri" => $url]);
                $body = [];
                $body["tipo"] = "LO";
                $body["usuario"] = $usuario;
                $body["pass"] = $clave;
                $body["sistema"] = "auditex";

                $response = $client->request("POST","/Security/Login", [
                    "body" => json_encode($body),
                    "headers" => [
                        'Content-Type' => 'application/json', 
                        'Accept' => 'application/json',
                    ]
                    
                ]);

                echo $response->getBody();

            }catch(Exception $e){
                echo json_encode(
                    array(
                        "msjusuario" => "Correcto",
                        "success"=> true,
                        "error" => $e->getMessage(),
                        "existe" => $existe
                    )
                );
            }

            

            
        }
        
     


    }

?>