<?php 

	require_once '../../../models/modelo/reporte.modelo.php';
	require_once '../../../models/modelo/core.modelo.php';



	if(isset($_GET["ficha"])){

		//INSTANCIAS
		$pdf 	= new RptMaestro();
		$objModelo = new CoreModelo();
        $ficha  = $_GET["ficha"];
        $partida = $_GET["partida"];

        
        $datosficha             = $objModelo->get("USYSTEX.SPGET_RPT_MOLDESCORTE_002_NEW",[4,$ficha,$partida]);
        $datospartida           = $objModelo->getAll("USYSTEX.SPGET_RPT_MOLDESCORTE_002_NEW",[3,$ficha,$partida]);
        $imagenesadjuntas       = $objModelo->getAll("AUDITEX.PQ_MOLDES.SPU_GETIMGPRUEBAENCOGIMIENTO",[$ficha]);
 
		//AGREGA PAGINA
		$pdf->AddPage();

        // TITULO
		$pdf->setTitleDocument("RESULTADOS DE PRUEBA DE ENCOGIMIENTO",true,14); 

		// $pdf->setTitleDocument("Estilo TSC - Cliente: {$datosficha['ESTILOTSC']} / {$datosficha['ESTILOCLIENTE']}",true,10); 

        $pdf->setContenidoTablaEspecial(150,"Estilo TSC - Cliente: {$datosficha['ESTILOTSC']} / {$datosficha['ESTILOCLIENTE']}","");
        $fechaliberacion = $datosficha['FECHA_LIBERACION'] != "" ?  date("d/m/Y", strtotime($datosficha['FECHA_LIBERACION'])) : "no liberado";

        $pdf->setContenidoTablaEspecial(40,"Fecha Liberación: {$fechaliberacion}","",1);

        // FECHA_LIBERACION




        // DATOS DDP
        $pdf->setCabeceraTabla_new(190,"Datos DDP","RLTB","C",1,true);
        // ARTICULO - RUTA PRENDA
        $pdf->setContenidoTabla(
            [20,80,20,70],
            [
                utf8_decode("ARTÍCULO:"),
                $datosficha["ARTICULO"],
                utf8_decode("RUTA:"),
                $datosficha["RUTA_PRENDA"]
            ],
            9,
            false,
            "B"
        );

        // CLIENTE - ESTILO DE PRUEBA (TSC - CLIENTE)
        $pdf->setContenidoTabla(
            [20,70,65,35],
            [
                utf8_decode("CLIENTE:"),
                $datosficha["CLIENTE"],
                utf8_decode("ESTILO DE PRUEBA (TSC / CLIENTE):"),
                $datosficha['ESTILOTSC'] ." / ". $datosficha['ESTILOCLIENTE']
            ]
        );

        $pdf->setCabeceraTabla_new(20,"PARTIDA","RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(20,"COLOR","RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(50,"DATOS ESTÁNDAR","RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(50,utf8_decode("Datos Datos TSC - Textil"),"RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(50,utf8_decode("Datos de Testing - 3ra Lavada"),"RLTB","C",1,true);

        $pdf->setCabeceraTabla_new(40,"","RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(25,"HILO","RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(25,"TRAMA","RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(25,"HILO","RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(25,"TRAMA","RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(25,"HILO","RLTB","C",0,true);
        $pdf->setCabeceraTabla_new(25,"TRAMA","RLTB","C",1,true);


        // DATOS DE LA PARTIDA
        foreach($datospartida as $fila){


            $hilotercera    = $fila["HILOTERCERA"] != "" ? $fila["HILOTERCERA"] : "-";
            $tramatercera   = $fila["TRAMATERCERA"] != "" ? $fila["TRAMATERCERA"] : "-";

            $hiloterceratsc    = $fila["HILOTERCERATSC"] != "" ? $fila["HILOTERCERATSC"] : "-";
            $tramaterceratsc   = $fila["TRAMATERCERATSC"] != "" ? $fila["TRAMATERCERATSC"] : "-";

            $hiloterceral    = $fila["HILOTERCERAL"] != "" ? (float)$fila["HILOTERCERAL"]."%" : "-";
            $tramaterceral   = $fila["TRAMATERCERAL"] != "" ? (float)$fila["TRAMATERCERAL"]."%" : "-";


            $pdf->setContenidoTabla(
                [20,20,25,25,25,25,25,25],
                [
                    $fila["PARTIDA"],$fila["COLOR"],
                    $hilotercera,$tramatercera,
                    $hiloterceratsc,$tramaterceratsc,
                    $hiloterceral,$tramaterceral
                ],
                9,
                [
                    "C","C",
                    "C","C",
                    "C","C",
                    "C","C"
                ]
            );
        }

        // IMAGENES 
        foreach($imagenesadjuntas as $image){

            $x = null;
            $y = null;

		    // $pdf->Image("../../../public/gestion-produccion/tmpencogimientos/".$image["RUTAIMG"],$x,$y,60,60);

        }

        // SALTO DE LINEA
        $pdf->Ln(5);

        // IMAGEN 1
        if(count($imagenesadjuntas) >= 1){

            $pdf->setContenidoTablaEspecial(90,"","RLTB",0,"","",70);
            $pdf->Image("../../../public/auditex-moldes/tmpencogimientos/".$imagenesadjuntas[0]["RUTAIMG"],13,85,85,65);

            // ESPACIO EN BLANCO
            $pdf->setContenidoTablaEspecial(10,"","",0,"","",70);

        }

        // IMAGEN 2
        if(count($imagenesadjuntas) >= 2){

            $pdf->setContenidoTablaEspecial(90,"","RLTB",1,"","",70);
            $pdf->Image("../../../public/auditex-moldes/tmpencogimientos/".$imagenesadjuntas[1]["RUTAIMG"],113,85,85,65);

            // ESPACIO EN BLANCO
            // $pdf->setContenidoTablaEspecial(10,"","",0,"","",70);
        }
        
        // IMAGEN 3
        if(count($imagenesadjuntas) >= 3){

            // SALTO DE LINEA
            $pdf->Ln(5);
            // IMAGEN
            $pdf->setContenidoTablaEspecial(90,"","RLTB",0,"","",70);
            $pdf->Image("../../../public/auditex-moldes/tmpencogimientos/".$imagenesadjuntas[2]["RUTAIMG"],13,160,85,65);

            // ESPACIO EN BLANCO
            $pdf->setContenidoTablaEspecial(10,"","",0,"","",70);
        }

        // IMAGEN 4
        if(count($imagenesadjuntas) >= 4){

            // IMAGEN
            $pdf->setContenidoTablaEspecial(90,"","RLTB",1,"","",70);
            $pdf->Image("../../../public/auditex-moldes/tmpencogimientos/".$imagenesadjuntas[3]["RUTAIMG"],113,160,85,65);
        }
        





        // DATOS DE APROBACION
        $pdf->Ln(2);


        $hilousado  = $datosficha['RESULTADO_PRUEBA_HILO_USADO']    != "" ? (float)$datosficha['RESULTADO_PRUEBA_HILO_USADO']."%" : "";
        $tramausado = $datosficha['RESULTADO_PRUEBA_TRAMA_USADO']   != "" ? (float)$datosficha['RESULTADO_PRUEBA_TRAMA_USADO']."%" : "";
        $mangausado = $datosficha['RESULTADO_PRUEBA_MANGA_USADO']   != "" ? (float)$datosficha['RESULTADO_PRUEBA_MANGA_USADO']."%" : "";


        $pdf->setContenidoTabla(
            [85,55,50],
            [
                utf8_decode("Como pueden apreciar en la imagén se utilizó un Molde"),
                utf8_decode("HILO: {$hilousado}, TRAMA: {$tramausado}, MANGA: {$mangausado}"),
                utf8_decode("en la cual se detalla lo siguiente:")
            ]
        );

        // DATOS DE APROBACION
        $pdf->setContenidoTabla(
            [70,120],
            [
                utf8_decode("En el Hilo(Largo de cuerpo) con tendencia:"),
                utf8_decode($datosficha['HILOTENDENCIA'])
            ]
        );
        $pdf->setContenidoTabla(
            [70,120],
            [
                utf8_decode("En el Trama(Ancho de cuerpo) con tendencia:"),
                utf8_decode($datosficha['TRAMATENDENCIA'])
            ]
        );
        $pdf->setContenidoTabla(
            [190],
            [
                utf8_decode("Por ello y en coordinación con María Muñante se sugiere lo siguiente:")
            ]
        );
        $pdf->setCabeceraTabla_new(190,"MOLDE A UTILIZAR SEGÚN EVALUACIÓN:","RLTB","C",1,true);

        $hiloevaluacion     = $datosficha['HILOEVALUACION']     != ""  ? (float)$datosficha['HILOEVALUACION']."%" : "-";
        $tramaevaluacion    = $datosficha['TRAMAEVALUACION']    != ""  ? (float)$datosficha['TRAMAEVALUACION']."%" : "-";
        $mangaevaluacion    = $datosficha['MANGAEVALUACION']    != ""  ? (float)$datosficha['MANGAEVALUACION']."%" : "-";

        $pdf->setContenidoTabla(
            [31.5,31.5,32.5,31.5,31.5,31.5],
            [
                "HILO:", $hiloevaluacion,
                "TRAMA:", $tramaevaluacion,
                "MANGA:", $mangaevaluacion
            ],
            9,
            [
                "C","C",
                "C","C",
                "C","C"
            ]
        );



        
      
		
        // IMAGEN EN OTRA HOJA
		$pdf->AddPage("D");
		$pdf->setTitleDocument("HOJA DE MEDIDAS DE PUNTOS",true,14); 
		$pdf->Image("../../../public/auditex-moldes/tmpencogimientos/".$datosficha["IMGPRINCIPAL"],null,null,275,160);
	
		$pdf->OutPut("reporte.pdf",'I');


	}

?>