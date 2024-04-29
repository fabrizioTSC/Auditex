<?php 

	require_once '../../../models/modelo/reporte.modelo.php';
	require_once '../../../models/modelo/core.modelo.php';



	if(isset($_GET["id"])){

		//INSTANCIAS
		$pdf 	= new RptMaestro();
		$objModelo = new CoreModelo();
        $id = $_GET["id"];

        $response = $objModelo->get("AUDITEX.SPU_REGISTRO_METALES_GET",[$id]);
        
        // var_dump($response);

		//AGREGA PAGINA
		$pdf->AddPage("D");
		// AGREGAMOS TITULO
		$pdf->setTitleDocument("CERTIFICATION",true,20);
		$pdf->setTitleDocument("LANDS' END METAL DETECTION",false,15);


        // ESPACIOS
        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(160,"INSTRUCTIONS: Requirement for apparel, textile, textile products And footwear shipments. Complete form And","",1,"","L",10);
        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(160,"attach it to shipping documents And invoices. The freight forwarder will require this document prior to shipment.","",1,"","L",10);

        // SALTO DE LINEA
        // $pdf->Ln(3);    

        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(160,"Detection completed:","",1,"","L",10);
	
        // SALTO DE LINEA
        // $pdf->Ln(5);    
	

        // PO
        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(40,"Shipment PO#'s:","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(170,$response["PO"],"B",1,"B","C",13); // 15
        
		// SALTO DE LINEA
		$pdf->Ln(2); 

        // BOL
        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(40,"Shipment BOL#'s:","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(170,$response["BOL"],"B",1,"","C",10);

        // SALTO DE LINEA
		$pdf->Ln(2); 

        // DATE
        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(40,"Date:","",0,"","L",10);

        $date = date_create($response["FECHA"]);
        $date = date_format($date, 'd/m/Y');

        $pdf->setContenidoTablaEspecial(170,$date,"B",1,"","C",10);

        // SALTO DE LINEA
		$pdf->Ln(2); 
        
        // BY
        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(40,"By:","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(170,$response["NOMBRES"],"B",1,"","C",10);

        // SALTO DE LINEA
		$pdf->Ln(5); 

        // SIGNATURE
        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(40,"Signature:","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(170,"","B",1,"","C",10);


		// SALTO DE LINEA
		// $pdf->Ln(12); 

        // SIGNATURE
        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(40,"Detection method used (circle):","",1,"","L",10);

        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(40,"Pass Through System  - Hand-held  - None or Partial   (Item Contains Metal):","",1,"","L",10);

        // SALTO DE LINEA
		// $pdf->Ln(5); 

        // NOTAS
        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(40,"Notes/Comments:","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(170,$response["NOTAS"],"B",1,"","C",10);

        $pdf->setContenidoTablaEspecial(30,"","",0,"","L",10);
        $pdf->setContenidoTablaEspecial(210,"","B",1,"","C",10);

        // $pdf->setContenidoTablaEspecial(210,"","",1,"","C",10);


        // SALTO DE LINEA
		// $pdf->Ln(20); 

        if($response["VALIDADOCALIDAD"]){
            
            $pdf->setContenidoTablaEspecial(155,"","",0,"","L",10);
            $pdf->setContenidoTablaEspecial(30,"Ing Jessica Soriano Llerena","",1,"","C",10);

            $pdf->setContenidoTablaEspecial(155,"","",0,"","L",10);
            $pdf->setContenidoTablaEspecial(30,"Jefatura de Calidad","",1,"B","C",10);

        }
        


        // IMAGENES

        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGEN
		$pdf->Image('../../../public/img/circle.png',70,138,35,14);

        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGEN
        if($response["VALIDADOACABADOS"]){
            $pdf->Image('../../../public/img/firmammartinez.png',80,170,50);
        }


        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGEN
        if($response["VALIDADOCALIDAD"]){
		    $pdf->Image('../../../public/img/firmajsoriano.png',160,175,50);
        }
        //MARGEN IZQUIERDO - MARGEN SUPERIOR - TAMAÑO IMAGEN
		$pdf->Image('../../../public/img/signature.jpeg',150,120,25);
	
		$pdf->OutPut("reporte.pdf",'I');


	}

?>