<?php

    require __DIR__.'../../../vendor/autoload.php';

    class TextileWebModel {

        public function LoginTextileWeb($usuario,$clave,$existe = false){

            try{

                $url = "http://localhost:11633";


                $client = new \GuzzleHttp\Client(["base_uri" => $url]);
                $body = [];
                // $body["tipo"] = "LO";
                $body["usuario"] = $usuario;
                $body["clave"] = $clave;
                $body["idempresa"] = 1;

                $response = $client->request("POST","/Dashboard/Login", [
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