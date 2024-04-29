<?php 
    session_start();
	require_once '../../../models/modelo/reporte.modelo.php';
	require_once '../../../models/modelo/core.modelo.php';



	if(isset($_POST["id"])){

		//INSTANCIAS
		$pdf 	= new RptMaestro();
		$objModelo = new CoreModelo();

        $idpdf = $_POST["id"];



        // DATOS TABLA GENERAL
        $thead       =  json_decode($_POST["thead"]);
        $tbody       =  json_decode($_POST["tbody"]);

        // DATOS TABLA PROVEEDOR
        // $theadproveedor         =  json_decode($_POST["theadproveedor"]);
        // $tbodyproveedor         =  json_decode($_POST["tbodyproveedor"]);

        // DATOS TABLA CLIENTE
        $theadcliente           =  json_decode($_POST["theadcliente"]);
        $tbodycliente           =  json_decode($_POST["tbodycliente"]);

        // PROVEEDOR CLIENTE (FILTROS)
        // $proveedor      =  $_POST["proveedor"];
        $cliente        =  $_POST["cliente"];



        // var_dump($thead);

        $filtros    = $_POST["filtros"];
        $fecha      = $_POST["fecha"];

        $fechames       = "";
        $fechasemana    = "";

        // $primermayodefecto1         = $_POST["primermayodefecto1"];
        // $segundomayodefecto1        = $_POST["segundomayodefecto1"];
        // $primermayodefecto2         = $_POST["primermayodefecto2"];
        // $segundomayodefecto2        = $_POST["segundomayodefecto2"];
	
        // CREAMOS FECHA
        $fechaComoEntero = strtotime($fecha);
        $fechasemana = date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);

        //AGREGA PAGINA GRAFICO GENERAL
        $pdf->AddPage();

        // AGREGAMOS TITULO
		$pdf->setTitleDocument("INDICADOR GENERAL DE MOLDAJE",true,15);
		$pdf->setTitleDocument($filtros,false,12);

        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/encogimientocorte/pdfindicadores/{$idpdf}_general_tmp.png",20,30,170,80);
        
        // ###################################
        // ### ARMAMOS DATOS TABLA GENERAL ###
        // ###################################

        // THEAD
        $pdf->Ln(90);    
        $canthead = 0;
        $cantbody = 0;
        $canbody2 = 0;

        $widthdescripcion   = 40;
        $widthvalores       = 18;


        // THEAD
        foreach($thead as $fila){
            $canthead++;
            $salto =  count($thead) == $canthead ? "1" : "0";

            if($canthead == 1){
                $pdf->setCabeceraTabla($widthdescripcion,$fila,"TBL","L",$salto,true,7);
            }else{
                $bordes = $salto == "0" ? "TBL" : "TBLR";
                $pdf->setCabeceraTabla($widthvalores,$fila,$bordes,"L",$salto,true,7);
            }

        }

        // TBODY
        foreach($tbody as $fila){
            $canbody2++;
            $cantbody = 0;
            foreach($fila as $filanew){

                $cantbody++;
                $salto =  count($fila) == $cantbody ? "1" : "0";

                $color = $filanew->{"background"};
                $r = 255;
                $g = 255;
                $b = 255;

                if($color != ""){
                    $r = $color->{"r"};
                    $g = $color->{"g"};
                    $b = $color->{"b"};
                }


                if($cantbody == 1){

                    if($r == "32" && $g == "77" && $b == "134"){
                        $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true,false);
                    }else{
                        $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
                    }


                }else{
                    $bordes = $salto == "0" ? "TBL" : "TBLR";
                    $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
                }
            }

        }

          
        // ####################################
        // ### ARMAMOS DATOS TABLA CLIENTES ###
        // ####################################

        if($cliente == ""){

            // AGREGAMOS TITULO  
            $pdf->AddPage();
            $pdf->setTitleDocument("CLIENTES",true,15);
            $canthead = 0;
            $cantbody = 0;

            $widthdescripcion   = 35;
            $widthvalores       = 14;

            // THEAD PROVEEDORES
            foreach($theadcliente as $fila){
                $canthead++;
                $salto =  count($theadcliente) == $canthead ? "1" : "0";

                if($canthead == 1 || $canthead == 2){
                    $pdf->setCabeceraTabla($widthdescripcion,$fila,"TBL","L",$salto,true,7);
                }else{
                    $bordes = $salto == "0" ? "TBL" : "TBLR";
                    $pdf->setCabeceraTabla($widthvalores,$fila,$bordes,"L",$salto,true,7);
                }

            }

            // TBODY
            $cantidadprov = 0;
            $saltonuevo = false;
            $cont = 0;

            foreach($tbodycliente as $fila){
                $canbody2++;
                $cantbody = 0;
                foreach($fila as $filanew){
    
                    $cantbody++;
                    $salto =  count($fila) == $cantbody ? "1" : "0";
    
                    $color = $filanew->{"background"};
                    $r = 255;
                    $g = 255;
                    $b = 255;
    
                    if($color != ""){
                        $r = $color->{"r"};
                        $g = $color->{"g"};
                        $b = $color->{"b"};
                    }
    
    
                    if($cantbody == 1 || $cantbody == 2){

                        if($r == "32" && $g == "77" && $b == "134"){
                            $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true,false);
                        }else{
                            $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
                        }

                        // $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
    
    
                    }else{
                        $bordes = $salto == "0" ? "TBL" : "TBLR";
                        $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
                    }
                }
    
            }

            // foreach($tbodycliente as $fila){
            //     $cont++;
            //     $cantidadprov++;

            //     if($cantidadprov == 2 || $cantidadprov == 3 || $cantidadprov == 4 || $cantidadprov == 5 || $cantidadprov == 7 || $cantidadprov == 6 || $cantidadprov == 8 || $cantidadprov == 9){
            //         $cantbody = 1;
            //         $saltonuevo = true;
            //         if($cont == count($tbodycliente)){
            //             $pdf->setContenidoTablaEspecial($widthdescripcion,"","LB","0","","L",6,255,255,255,true);
            //         }else{
            //             $pdf->setContenidoTablaEspecial($widthdescripcion,"","L","0","","L",6,255,255,255,true);
            //         }
            //     }else{
            //         $cantbody = 0;
            //         $saltonuevo = false;
            //     }



            //     foreach($fila as $filanew){

            //         $cantbody++;
            //         $arrayfila = $saltonuevo ? count($fila) + 1 :  count($fila) ;
            //         $salto =  $arrayfila == $cantbody ? "1" : "0";

            //         $color = $filanew->{"background"};
            //         $r = 255;
            //         $g = 255;
            //         $b = 255;

            //         if($color != ""){
            //             $r = $color->{"r"};
            //             $g = $color->{"g"};
            //             $b = $color->{"b"};
            //         }


            //         if($cantbody == 1 || $cantbody == 2){

            //             if($cantidadprov == 6 || $cantidadprov == 7 || $cantidadprov == 8 || $cantidadprov == 9 ){
            //                 $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true,false);
            //             }
            //             else{
            //                 $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
            //             }
                        
            //         }else{
            //             $bordes = $salto == "0" ? "TBL" : "TBLR";
            //             $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
            //         }

                    

            //     }

            //     if($cantidadprov == 9){
            //         $cantidadprov = 0;
            //         $cantbody = 0;
            //         $saltonuevo = false;
            //     }

            // }

        } 

        // if($cliente == ""){

        //     // AGREGAMOS TITULO  
        //     $pdf->AddPage();
        //     $pdf->setTitleDocument("CLIENTES",true,15);
        //     $canthead = 0;
        //     $cantbody = 0;

        //     $widthdescripcion   = 35;
        //     $widthvalores       = 14;

        //     // THEAD PROVEEDORES
        //     foreach($theadcliente as $fila){
        //         $canthead++;
        //         $salto =  count($theadcliente) == $canthead ? "1" : "0";

        //         if($canthead == 1 || $canthead == 2){
        //             $pdf->setCabeceraTabla($widthdescripcion,$fila,"TBL","L",$salto,true,7);
        //         }else{
        //             $bordes = $salto == "0" ? "TBL" : "TBLR";
        //             $pdf->setCabeceraTabla($widthvalores,$fila,$bordes,"L",$salto,true,7);
        //         }

        //     }

        //     // TBODY
        //     $cantidadprov = 0;
        //     $saltonuevo = false;
        //     $cont = 0;

        //     foreach($tbodycliente as $fila){
        //         $cont++;
        //         $cantidadprov++;

        //         if($cantidadprov == 2 || $cantidadprov == 3 || $cantidadprov == 4 || $cantidadprov == 5 || $cantidadprov == 7 || $cantidadprov == 6 || $cantidadprov == 8 || $cantidadprov == 9){
        //             $cantbody = 1;
        //             $saltonuevo = true;
        //             if($cont == count($tbodycliente)){
        //                 $pdf->setContenidoTablaEspecial($widthdescripcion,"","LB","0","","L",6,255,255,255,true);
        //             }else{
        //                 $pdf->setContenidoTablaEspecial($widthdescripcion,"","L","0","","L",6,255,255,255,true);
        //             }
        //         }else{
        //             $cantbody = 0;
        //             $saltonuevo = false;
        //         }



        //         foreach($fila as $filanew){

        //             $cantbody++;
        //             $arrayfila = $saltonuevo ? count($fila) + 1 :  count($fila) ;
        //             $salto =  $arrayfila == $cantbody ? "1" : "0";

        //             $color = $filanew->{"background"};
        //             $r = 255;
        //             $g = 255;
        //             $b = 255;

        //             if($color != ""){
        //                 $r = $color->{"r"};
        //                 $g = $color->{"g"};
        //                 $b = $color->{"b"};
        //             }


        //             if($cantbody == 1 || $cantbody == 2){

        //                 if($cantidadprov == 6 || $cantidadprov == 7 || $cantidadprov == 8 || $cantidadprov == 9 ){
        //                     $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true,false);
        //                 }
        //                 else{
        //                     $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
        //                 }
                        
        //             }else{
        //                 $bordes = $salto == "0" ? "TBL" : "TBLR";
        //                 $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
        //             }

                    

        //         }

        //         if($cantidadprov == 9){
        //             $cantidadprov = 0;
        //             $cantbody = 0;
        //             $saltonuevo = false;
        //         }

        //     }

        // }            

       
        // MOSTRAMOS PDF
		$pdf->OutPut("reporte.pdf",'I');

        // ELIMINAMOS IMAGENES
        unlink("../../tmp/encogimientocorte/pdfindicadores/{$idpdf}_general_tmp.png");
        // unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto1_tmp.png");
        // unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto2_tmp.png");
        // unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto3_tmp.png");
        // unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto4_tmp.png");
        // unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto5_tmp.png");
        // unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto6_tmp.png");

        // unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_tblgeneral_tmp.png");




	}

?>