<?php

    class DepuracionCorte{

        private $filtercopiado;
        private $filterdestinatario;

        // ARMA CUERPO DE CORREO
        function getCuerpoCorreo($datoscorreo,$resumendepuracion,$resumendefectos){
            
            $peso = (float)$datoscorreo['PESO'];
            $defectos = strtolower($datoscorreo['DEFECTOS']);
            return  "
                    <div style='font-size:12px !important'>
                        <label>Buen Día</label>
                        <p> Se comunica la caída de la ficha {$datoscorreo['FICHA']} pedido {$datoscorreo['PEDIDO_VENDA']}, cliente {$datoscorreo['CLIENTE']}  color  {$datoscorreo['COLOR']} cantidad de la ficha {$datoscorreo['CANTFICHA']}</p>
                        <strong>PARTIDA:</strong>   {$datoscorreo['PARTIDA']}
                        <br>
                        <br>
                        <strong>MOTIVO:</strong>    {$defectos}
                        <br>
                        <br>
                        {$resumendepuracion}
                        <br>
                        <br>
                        {$resumendefectos}
                        <br>
                        <label style='margin-right: 30px;' >Validado por: {$datoscorreo['NOMUSU']}</label>
                        <label >Peso: $peso kg</label>
                        <label style='margin-right: 15px;' >Observación: {$datoscorreo['OBSERVACION']}</label>
                    </div>
            ";

        }

        // ARMA TABLA PARA RESUMEN DE DEPURACIÓM
        function getResumenDefectos($datos){

            // $tabla = "";
            $tbody = "";
            // $tfoot = "";

            foreach($datos as $fila){

                $tbody .= "<tr>";
                $tbody .= "<td style='border: 1px solid black;'>{$fila['COD']}</td>";
                $tbody .= "<td style='border: 1px solid black;'>{$fila['DEF']}</td>";
                $tbody .= "<td style='border: 1px solid black;'>{$fila['SUMA']}</td>";
                $tbody .= "</tr>";


            }


            $tabla = "<table style='border-collapse: collapse;border: 1px solid black;text-align:center'>
                        <thead>
                            <tr>  
                                <th style='border: 1px solid black;'>CÓDIGO</th>
                                <th style='border: 1px solid black;'>DESCRIPCIÓN DE DEFECTO</th>
                                <th style='border: 1px solid black;'>CANTIDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            $tbody
                        </tbody>
                    </table>
            ";

            return $tabla;

        }

        // ARMA TABLA PARA RESUMEN DE DEPURACIÓM
        function getResumenDepuracion($datos1,$maxpaq,$datos3){

            // $tabla = "";
            $tbody = "";
            $tfoot = "";

            $total = 0;
            foreach($datos1 as $fila){
                $tbody .= "<tr>";
                $tbody .= "     <td  style='border: 1px solid black;'>{$fila['DESCR_TAMANHO']}</td>";
                $tbody .= "     <td  style='border: 1px solid black;'>{$fila['SUMADEFECTOS']}</td>";

                // 
                $td = "";

                foreach($datos3 as $fila2){

                        for($i = 1; $i <= $maxpaq;$i++){

                            if(($fila2["DESCR_TAMANHO"] == $fila["DESCR_TAMANHO"]) && $fila2["PAQ"] == $i ){
                                $td .= "
                                    <td style='border: 1px solid black;'>{$fila2['CORRELATIVO']}</td>
                                    <td style='border: 1px solid black;'>{$fila2['SUMADEFECTOS']}</td>
                                ";
                            }


                        }
                    
                }
                $tbody .= $td;
                $tbody .= "</tr>";

                $total +=  $fila['SUMADEFECTOS'];
            }

            $tfoot .=   "   <tr>";
            $tfoot .=   "       <th style='border: 1px solid black;'>TOTAL:</th>";
            $tfoot .=   "       <th style='border: 1px solid black;'>{$total}</th>";
            $tfoot .=   "   </tr>";

            // <tr> <th colspan='2' style='border: 1px solid black;'>RESUMEN:</th> </tr>

            // CANTIDAD AGRUPADOS
            $thagrupado = "";
            $thagrupado2 = "";

            for($i = 1; $i <= $maxpaq;$i++){

                $thagrupado .= "<th style='border: 1px solid black;' colspan='2'> {$i} </th>";
                $thagrupado2 .= "
                    <th style='border: 1px solid black;padding:3px'>Paq</th>
                    <th style='border: 1px solid black;padding:3px'>Cant</th>
                ";
            }


            $tabla = "<table style='border-collapse: collapse;border: 1px solid black;text-align:center'>
                        <thead>
                           
                            <tr>  
                                <th style='border: 1px solid black;' rowspan='2'>TALLA</th>
                                <th style='border: 1px solid black;' rowspan='2'>CANTIDAD</th>
                                {$thagrupado}
                            </tr>
                            <tr>{$thagrupado2}</tr>
                        </thead>
                        <tbody>
                            $tbody
                        </tbody>
                        <tfoot>
                            $tfoot
                        </tfoot>
                    </table>
            ";

            return $tabla;

        }

        // OBTIENE USUARIO REMITENTE, DESTINATARIOS Y USUARIO COPIA
        function getUsersCorreo($data,$filterdestinatario = false,$filtercopiado = false){

            $this->filterdestinatario = $filterdestinatario;
            $this->filtercopiado      = $filtercopiado;


            // REMITENTE
            $remitente = array_filter($data,function($obj){
                return $obj["TIPO"] == "E";
            });

            // DESTINATARIO
            $destinatario = array_filter($data,function($obj){

                if($this->filterdestinatario){
                    return $obj["TIPO"] == "R" && $obj["FILTRO"]  == $this->filterdestinatario;
                
                }else{
                    return $obj["TIPO"] == "R";
                }
            });

            // COPIADOS
            $copiado = array_filter($data,function($obj){

                if($this->filtercopiado){
                    return $obj["TIPO"] == "C" && $obj["FILTRO"]  == $this->filtercopiado;
                
                }else{
                    return $obj["TIPO"] == "C";
                }

            });

            return [
                "remitente" => $remitente,
                "destinatario" => $destinatario,
                "copiado" => $copiado
            ];

        }



    }

?>