<?php 
    session_start();
	require_once '../../../models/modelo/reporte.modelo.php';
	require_once '../../../models/modelo/core.modelo.php';



	if(isset($_POST["id"])){

		//INSTANCIAS
		$pdf 	= new RptMaestro();
		$objModelo = new CoreModelo();

        $idpdf = $_POST["id"];

        $datopareto1 = json_decode($_POST["datopareto1"]);
        $datopareto2 = json_decode($_POST["datopareto2"]);
        $datopareto3 = json_decode($_POST["datopareto3"]);
        $datopareto4 = json_decode($_POST["datopareto4"]);
        $datopareto5 = json_decode($_POST["datopareto5"]);
        $datopareto6 = json_decode($_POST["datopareto6"]);


        // DATOS TABLA GENERAL
        $thead       =  json_decode($_POST["thead"]);
        $tbody       =  json_decode($_POST["tbody"]);

        // DATOS TABLA PROVEEDOR
        $theadproveedor         =  json_decode($_POST["theadproveedor"]);
        $tbodyproveedor         =  json_decode($_POST["tbodyproveedor"]);

        // DATOS TABLA CLIENTE
        $theadcliente           =  json_decode($_POST["theadcliente"]);
        $tbodycliente           =  json_decode($_POST["tbodycliente"]);

        // PROVEEDOR CLIENTE (FILTROS)
        $proveedor      =  $_POST["proveedor"];
        $cliente        =  $_POST["cliente"];



        // var_dump($thead);

        $filtros    = $_POST["filtros"];
        $fecha      = $_POST["fecha"];

        $fechames       = "";
        $fechasemana    = "";

        $primermayodefecto1         = $_POST["primermayodefecto1"];
        $segundomayodefecto1        = $_POST["segundomayodefecto1"];
        $primermayodefecto2         = $_POST["primermayodefecto2"];
        $segundomayodefecto2        = $_POST["segundomayodefecto2"];
	
        // CREAMOS FECHA
        $fechaComoEntero = strtotime($fecha);
        $fechasemana = date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);

        //AGREGA PAGINA GRAFICO GENERAL
        $pdf->AddPage();

        // AGREGAMOS TITULO
		$pdf->setTitleDocument("INDICADOR GENERAL DE TESTING",true,15);
		$pdf->setTitleDocument($filtros,false,12);

        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/testing/pdfindicadores/{$idpdf}_general_tmp.png",20,30,170,80);
        
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

                    if($canbody2 == 6 || $canbody2 == 7 || $canbody2 == 8 || $canbody2 == 9 || $canbody2 == 16 || $canbody2 == 17 || $canbody2 == 18 || $canbody2 == 19 ){
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

        // #####################################
        // ### ARMAMOS DATOS TABLA PROVEEDOR ###
        // #####################################

        if($proveedor == ""){

            // AGREGAMOS TITULO  
            $pdf->AddPage();
            $pdf->setTitleDocument("PROVEEDORES",true,15);
            $canthead = 0;
            $cantbody = 0;

            $widthdescripcion   = 35;
            $widthvalores       = 14;

            // THEAD PROVEEDORES
            foreach($theadproveedor as $fila){
                $canthead++;
                $salto =  count($theadproveedor) == $canthead ? "1" : "0";

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

            foreach($tbodyproveedor as $fila){
                $cont++;
                $cantidadprov++;

                if($cantidadprov == 2 || $cantidadprov == 3 || $cantidadprov == 4 || $cantidadprov == 5 || $cantidadprov == 6 || $cantidadprov == 7 || $cantidadprov == 8 || $cantidadprov == 9){
                    $cantbody = 1;
                    $saltonuevo = true;
                    if($cont == count($tbodyproveedor)){
                        $pdf->setContenidoTablaEspecial($widthdescripcion,"","LB","0","","L",6,255,255,255,true);
                    }else{
                        $pdf->setContenidoTablaEspecial($widthdescripcion,"","L","0","","L",6,255,255,255,true);
                    }
                }else{
                    $cantbody = 0;
                    $saltonuevo = false;
                }



                foreach($fila as $filanew){

                    $cantbody++;
                    $arrayfila = $saltonuevo ? count($fila) + 1 :  count($fila) ;
                    $salto =  $arrayfila == $cantbody ? "1" : "0";

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

                        if($cantidadprov == 6 || $cantidadprov == 7 || $cantidadprov == 8 || $cantidadprov == 9 ){
                            $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true,false);
                        }
                        else{
                            $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
                        }

                    }else{
                        $bordes = $salto == "0" ? "TBL" : "TBLR";
                        $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
                    }

                    // if($cantidadprov == 1){

                    //     if($cantbody == 2){
                    //         $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
                    //     }else if($cantbody > 2) {
                    //         $bordes = $salto == "0" ? "TBL" : "TBLR";
                    //         $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
                    //     }
    
                    // }else{
                    //     if($cantbody == 1 || $cantbody == 2){
                    //         $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
                    //     }else{
                    //         $bordes = $salto == "0" ? "TBL" : "TBLR";
                    //         $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
                    //     }
    
                    // }


                    // if($cantbody == 1 && $cantidadprov == 1){
                    //     // $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
                    // }else if ( ($cantbody == 2 || $cantbody == 1) && $cantidadprov != 1){
                    //     $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
                    // }
                    // else{
                    //     $bordes = $salto == "0" ? "TBL" : "TBLR";
                    //     $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
                    // }

                
                }

                if($cantidadprov == 9){
                    $cantidadprov = 0;
                    $cantbody = 0;
                    $saltonuevo = false;
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
                $cont++;
                $cantidadprov++;

                if($cantidadprov == 2 || $cantidadprov == 3 || $cantidadprov == 4 || $cantidadprov == 5 || $cantidadprov == 7 || $cantidadprov == 6 || $cantidadprov == 8 || $cantidadprov == 9){
                    $cantbody = 1;
                    $saltonuevo = true;
                    if($cont == count($tbodycliente)){
                        $pdf->setContenidoTablaEspecial($widthdescripcion,"","LB","0","","L",6,255,255,255,true);
                    }else{
                        $pdf->setContenidoTablaEspecial($widthdescripcion,"","L","0","","L",6,255,255,255,true);
                    }
                }else{
                    $cantbody = 0;
                    $saltonuevo = false;
                }



                foreach($fila as $filanew){

                    $cantbody++;
                    $arrayfila = $saltonuevo ? count($fila) + 1 :  count($fila) ;
                    $salto =  $arrayfila == $cantbody ? "1" : "0";

                    $color = $filanew->{"background"};
                    $r = 255;
                    $g = 255;
                    $b = 255;

                    if($color != ""){
                        $r = $color->{"r"};
                        $g = $color->{"g"};
                        $b = $color->{"b"};
                    }



                    // if($cantbody == 1 || $cantbody == 2){
                    //     $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
                    // }else{
                    //     $bordes = $salto == "0" ? "TBL" : "TBLR";
                    //     $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
                    // }

                    if($cantbody == 1 || $cantbody == 2){

                        if($cantidadprov == 6 || $cantidadprov == 7 || $cantidadprov == 8 || $cantidadprov == 9 ){
                            $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true,false);
                        }
                        else{
                            $pdf->setContenidoTablaEspecial($widthdescripcion,$filanew->{"texto"},"TBL",$salto,"","L",6,$r,$g,$b,true);
                        }
                        
                    }else{
                        $bordes = $salto == "0" ? "TBL" : "TBLR";
                        $pdf->setContenidoTablaEspecial($widthvalores,$filanew->{"texto"},$bordes,$salto,"","L",6,$r,$g,$b,true);
                    }

                    

                }

                if($cantidadprov == 9){
                    $cantidadprov = 0;
                    $cantbody = 0;
                    $saltonuevo = false;
                }

            }

        }            

        //AGREGA PAGINA PARETO 1
        $pdf->AddPage();
		$pdf->setTitleDocument("DIAGRAMA DE PARETO GENERAL - NIVEL N°1",false,15,5);
		$pdf->setTitleDocument($fechasemana,false,12);
        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/testing/pdfindicadores/{$idpdf}_pareto1_tmp.png",20,40,170,80);
        
        // SALTO DE LINEA
        $pdf->Ln(95);    
        $pdf->setCabeceraTabla(70,"Defectos","TBL","L","0",true);
        $pdf->setCabeceraTabla(40,"Frecuencia","TBL","L","0",true);
        $pdf->setCabeceraTabla(40,"%","TBL","L","0",true);
        $pdf->setCabeceraTabla(40,"% Acumulado","TBLR","L","1",true);

        $cont = 0;
        foreach($datopareto1 as $fila ){
            $cont++;
            $array = [
                $cont .". ".$fila->{"descripcion"} ,
                $fila->{"valor"},
                $fila->{"porcentaje"} . "%",
                $fila->{"acumulado"} . "%"
            ];

            $pdf->setContenidoTabla([70,40,40,40],$array);
        }

        //AGREGA PAGINA PARETO 2
        $pdf->AddPage();
        $pdf->setTitleDocument("DIAGRAMA DE PARETO GENERAL - NIVEL N°1",false,15,5);
		$pdf->setTitleDocument($fechames,false,12);
        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/testing/pdfindicadores/{$idpdf}_pareto2_tmp.png",20,40,170,80);

        // SALTO DE LINEA
        $pdf->Ln(95);    
        $pdf->setCabeceraTabla(70,"Defectos","TBL","L","0",true);
        $pdf->setCabeceraTabla(40,"Frecuencia","TBL","L","0",true);
        $pdf->setCabeceraTabla(40,"%","TBL","L","0",true);
        $pdf->setCabeceraTabla(40,"% Acumulado","TBLR","L","1",true);

        $cont = 0;
        foreach($datopareto2 as $fila ){
            $cont++;

            $array = [
                $cont .". ".$fila->{"descripcion"} ,
                $fila->{"valor"},
                $fila->{"porcentaje"} . "%",
                $fila->{"acumulado"} . "%"
            ];

            $pdf->setContenidoTabla([70,40,40,40],$array);
        }

        //AGREGA PAGINA PARETO 3
        $pdf->AddPage();
        $pdf->setTitleDocument("DIAGRAMA DE PARETO GENERAL - NIVEL N°2",false,15,5);
		$pdf->setTitleDocument($fechasemana,false,12,5);
		$pdf->setTitleDocument($primermayodefecto1,false,12,5);
        // $primermayodefecto1
        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/testing/pdfindicadores/{$idpdf}_pareto3_tmp.png",20,40,170,80);

        // SALTO DE LINEA
        $pdf->Ln(95);    
        $pdf->setCabeceraTabla(70,"Defectos","TBL","L","0",true);
        $pdf->setCabeceraTabla(40,"Frecuencia","TBL","L","0",true);
        $pdf->setCabeceraTabla(20,"%","TBL","L","0",true);
        $pdf->setCabeceraTabla(30,"% Acumulado","TBL","L","0",true);
        $pdf->setCabeceraTabla(30,"% Del General","TBLR","L","1",true);

        $cont = 0;
        foreach($datopareto3 as $fila ){
            $cont++;

            $array = [
                $cont .". ".$fila->{"descripcion"} ,
                $fila->{"valor"},
                $fila->{"porcentaje"} . "%",
                $fila->{"acumulado"} . "%",
                $fila->{"delgeneral"} . "%"
            ];

            $pdf->setContenidoTabla([70,40,20,30,30],$array);
        }


        //AGREGA PAGINA PARETO 4
        $pdf->AddPage();
        $pdf->setTitleDocument("DIAGRAMA DE PARETO GENERAL - NIVEL N°2",false,15,5);
		$pdf->setTitleDocument($fechasemana,false,12,5);
		$pdf->setTitleDocument($segundomayodefecto1,false,12,5);

        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/testing/pdfindicadores/{$idpdf}_pareto4_tmp.png",20,40,170,80);

        // SALTO DE LINEA
        $pdf->Ln(95);    
        $pdf->setCabeceraTabla(70,"Defectos","TBL","L","0",true);
        $pdf->setCabeceraTabla(40,"Frecuencia","TBL","L","0",true);
        $pdf->setCabeceraTabla(20,"%","TBL","L","0",true);
        $pdf->setCabeceraTabla(30,"% Acumulado","TBL","L","0",true);
        $pdf->setCabeceraTabla(30,"% Del General","TBLR","L","1",true);

        $cont = 0;
        foreach($datopareto4 as $fila ){
            $cont++;

            $array = [
                $cont .". ".$fila->{"descripcion"} ,
                $fila->{"valor"},
                $fila->{"porcentaje"} . "%",
                $fila->{"acumulado"} . "%",
                $fila->{"delgeneral"} . "%"
            ];

            $pdf->setContenidoTabla([70,40,20,30,30],$array);
        }
		

        //AGREGA PAGINA PARETO 5
        $pdf->AddPage();
        $pdf->SetTextColor(0,0,0);
        $pdf->setTitleDocument("DIAGRAMA DE PARETO GENERAL - NIVEL N°2",false,15,5);
		$pdf->setTitleDocument($fechames,false,12,5);
		$pdf->setTitleDocument($primermayodefecto2,false,12,5);


        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/testing/pdfindicadores/{$idpdf}_pareto5_tmp.png",20,50,170,80);

         // SALTO DE LINEA
         $pdf->Ln(110);    
         $pdf->setCabeceraTabla(70,"Defectos","TBL","L","0",true);
         $pdf->setCabeceraTabla(40,"Frecuencia","TBL","L","0",true);
         $pdf->setCabeceraTabla(20,"%","TBL","L","0",true);
         $pdf->setCabeceraTabla(30,"% Acumulado","TBL","L","0",true);
         $pdf->setCabeceraTabla(30,"% Del General","TBLR","L","1",true);
 
         $cont = 0;
         foreach($datopareto5 as $fila ){
            $cont++;
 
             $array = [
                $cont .". ".$fila->{"descripcion"} ,
                 $fila->{"valor"},
                 $fila->{"porcentaje"} . "%",
                 $fila->{"acumulado"} . "%",
                 $fila->{"delgeneral"} . "%"
             ];
 
             $pdf->setContenidoTabla([70,40,20,30,30],$array);
         }

        //AGREGA PAGINA PARETO 6
        $pdf->AddPage();
        $pdf->setTitleDocument("DIAGRAMA DE PARETO GENERAL - NIVEL N°2",false,15,5);
		$pdf->setTitleDocument($fechames,false,12,5);
		$pdf->setTitleDocument($segundomayodefecto2,false,12);

        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/testing/pdfindicadores/{$idpdf}_pareto6_tmp.png",20,40,170,80);
         
        // SALTO DE LINEA
        $pdf->Ln(95);    
        $pdf->setCabeceraTabla(70,"Defectos","TBL","L","0",true);
        $pdf->setCabeceraTabla(40,"Frecuencia","TBL","L","0",true);
        $pdf->setCabeceraTabla(20,"%","TBL","L","0",true);
        $pdf->setCabeceraTabla(30,"% Acumulado","TBL","L","0",true);
        $pdf->setCabeceraTabla(30,"% Del General","TBLR","L","1",true);

        $cont = 0;
        foreach($datopareto6 as $fila ){
            $cont++;

            $array = [
                $cont .". ".$fila->{"descripcion"} ,
                $fila->{"valor"},
                $fila->{"porcentaje"} . "%",
                $fila->{"acumulado"} . "%",
                $fila->{"delgeneral"} . "%"
            ];

            $pdf->setContenidoTabla([70,40,20,30,30],$array);
        }


        // MOSTRAMOS PDF
		$pdf->OutPut("reporte.pdf",'I');

        // ELIMINAMOS IMAGENES
        unlink("../../tmp/testing/pdfindicadores/{$idpdf}_general_tmp.png");
        unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto1_tmp.png");
        unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto2_tmp.png");
        unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto3_tmp.png");
        unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto4_tmp.png");
        unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto5_tmp.png");
        unlink("../../tmp/testing/pdfindicadores/{$idpdf}_pareto6_tmp.png");

        // unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_tblgeneral_tmp.png");




	}

?>