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


        // THEAD
        $thead       =  json_decode($_POST["thead"]);
        // TBODY
        $tbody1      =  json_decode($_POST["tbody1"]);
        $tbody2      =  json_decode($_POST["tbody2"]);
        $tbody3      =  json_decode($_POST["tbody3"]);
        $tbody4      =  json_decode($_POST["tbody4"]);
        // TFOOT
        $tfoot1      =  json_decode($_POST["tfoot1"]);
        $tfoot2      =  json_decode($_POST["tfoot2"]);



        // var_dump($thead);

        $filtros    = $_POST["filtros"];
        $fecha      = $_POST["fecha"];

        $fechames       = "";
        $fechasemana    = "";

        $primermayodefecto1      = $_POST["primermayodefecto1"];
        $segundomayodefecto1      = $_POST["segundomayodefecto1"];
        $primermayodefecto2      = $_POST["primermayodefecto2"];
        $segundomayodefecto2      = $_POST["segundomayodefecto2"];


        // FECHA MES
        setlocale(LC_TIME, "spanish");			
        // CREAMOS FECHA
        $fechaComoEntero = strtotime($fecha);
        $mes = strftime("%B", strtotime($fechaComoEntero));
        $fechames = date("Y", $fechaComoEntero) ." - " . ucwords($mes);

        // FECHA SEMANA
        setlocale(LC_TIME, "spanish");			
        // CREAMOS FECHA
        $fechaComoEntero = strtotime($fecha);
        $fechasemana = date("Y", $fechaComoEntero) ." - Semana " . date("W", $fechaComoEntero);




        //AGREGA PAGINA GRAFICO GENERAL
        $pdf->AddPage();

        // AGREGAMOS TITULO
		$pdf->setTitleDocument("INDICADOR GENERAL DE DEPURACIONES",true,15);
		$pdf->setTitleDocument($filtros,false,12);

        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/depuracion/pdfindicadores/{$idpdf}_general_tmp.png",20,30,170,80);

		// $pdf->Image("../../tmp/depuracion/pdfindicadores/{$idpdf}_tblgeneral_tmp.png",20,130,170,40);
        
        // ###################################
        // ### ARMAMOS DATOS TABLA GENERAL ###
        // ###################################

        // THEAD
        $pdf->Ln(90);    
        $canthead = 0;
        $widthdescripcion   = 30;
        $widthvalores       = 13.5;


        foreach($thead as $fila){
            $canthead++;
            $salto =  count($thead) == $canthead ? "1" : "0";

            if($canthead == 1){
                $pdf->setCabeceraTabla($widthdescripcion,$fila,"TBL","L",$salto,true,7);
            }else{
                $pdf->setCabeceraTabla($widthvalores,$fila,"TBL","L",$salto,true,7);
            }


            // if(count($thead) == $canthead){
            // }else{
            //     $pdf->setCabeceraTabla(,$fila,"TBL","L","0",true);
            // }
        }

        $datostbody1        = [];
        $datostbody2        = [];
        $datostbody3        = [];
        $datostbody4        = [];

        $datoswidthtbody   = [];
        $contwidth = 0;
        // TBODY 1
        foreach($tbody1 as $fila ){
            $contwidth++;
            $datostbody1[] =  utf8_decode($fila);

            if($contwidth == 1){
                $datoswidthtbody[] = $widthdescripcion;
            }else{
                $datoswidthtbody[] = $widthvalores;
            }
        }
        // TBODY 2
        foreach($tbody2 as $fila ){
            $datostbody2[] = utf8_decode($fila);
        }
        // TBODY 3
        foreach($tbody3 as $fila ){
            $datostbody3[] = utf8_decode($fila);
        }
        // TBODY 4
        foreach($tbody4 as $fila ){
            $datostbody4[] = utf8_decode($fila);
        }


        //  DATOS TBODY
        $pdf->setContenidoTabla($datoswidthtbody,$datostbody1,7);
        $pdf->setContenidoTabla($datoswidthtbody,$datostbody2,7);
        $pdf->setContenidoTabla($datoswidthtbody,$datostbody3,7);
        $pdf->setContenidoTabla($datoswidthtbody,$datostbody4,7);

        // TFOOT
        $datostfoot1        = [];
        $datostfoot2        = [];

        // TFOOT 1
         foreach($tfoot1 as $fila ){
            $datostfoot1[] =  utf8_decode($fila);
        }
        // TFOOT 2
        foreach($tfoot2 as $fila ){
            $datostfoot2[] = utf8_decode($fila);
        }

        // $pdf->RowColors=array(array(210,245,255),array(255,255,210));
        //  DATOS TFOOT
        $pdf->setContenidoTabla($datoswidthtbody,$datostfoot1,7);
        $pdf->setContenidoTabla($datoswidthtbody,$datostfoot2,7);

        //AGREGA PAGINA PARETO 1
        $pdf->AddPage();
		$pdf->setTitleDocument("DIAGRAMA DE PARETO GENERAL - NIVEL N°1",false,15,5);
		$pdf->setTitleDocument($fechasemana,false,12);
        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGENs
		$pdf->Image("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto1_tmp.png",20,40,170,80);
        
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
		$pdf->Image("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto2_tmp.png",20,40,170,80);

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
		$pdf->Image("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto3_tmp.png",20,40,170,80);

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
		$pdf->Image("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto4_tmp.png",20,40,170,80);

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
		$pdf->Image("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto5_tmp.png",20,50,170,80);

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
		$pdf->Image("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto6_tmp.png",20,40,170,80);
         
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
        unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_general_tmp.png");

        unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto1_tmp.png");
        unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto2_tmp.png");
        unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto3_tmp.png");
        unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto4_tmp.png");
        unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto5_tmp.png");
        unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_pareto6_tmp.png");
        unlink("../../tmp/depuracion/pdfindicadores/{$idpdf}_tblgeneral_tmp.png");




	}

?>