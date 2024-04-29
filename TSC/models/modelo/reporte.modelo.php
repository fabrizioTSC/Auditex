<?php 

	require_once __DIR__.'/../../libs/fpdf/fpdf.php';


	class RptMaestro extends fpdf
	{

		// APUNTES
		// 	FUNCION CELL(ANCHO,ALTO,INFORMACION O TEXTO,BORDE,SALTO DE LINEA,ALINEACION,ACEPTA COLOR DE FON);


		// HEADER PARA TODOS LOS PDF
		public function Header()
		{
			
			
			
			//TIPO DE LETRA, FORMATO, TAMAÑO
			$this->SetFont('Arial','BI','15'); 
			// 
			$this->Cell(80);

			// COLOR DEL DEXTO DE LA CABECERA
			// $this->SetTextColor(96,108,166);

			//ancho,alto,información,borde,alineacion
			// $this->Cell(30,10,utf8_decode('MPIG SERVICIO GENERALES S.R.L'),0,0,'C');
			
		    //	SALTO DE LINEA
			// $this->Ln(12); 

			// LINEA DE BAJO
			// $this->Cell(0,0,'',1,0,'C'); //LINEA DE BAJO

			// SALTO DE LINEA
			$this->Ln(5	); 
			// MARCA DE AGUA
			// $this->RotatedText(65,175,'MPIG',10);
		}

		// FOOTER PARA TODOS LOS PDF
		public function Footer()
		{
			// date_default_timezone_set('America/Lima');
			// //Posicion en Y
		    // $this->SetY(-15);
		    // // Arial italic 8
		    // $this->SetFont('Arial','I',8);
		    // //COLORES
		    // //$this->SetDrawColor(3,64,136);		//BORDE
		    // //$this->SetFillColor(215,239,245);	//FONDO
		    // //$this->SetTextColor(3,64,136);		//TEXTO
		    // //FECHA IZQUIERDA
		    // $this->Cell(0,10,date('d-m-Y h:i:s'),1,0,'L',1);
		    // // Número de página DERECHA
		    // $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');

		}

		// AGREGA TITULO DEL DOCUMENTO
		public function setTitleDocument($titulo,$bold = false,$letra = 18,$saltolinea = 10){
			
			//TIPO DE LETRAS
			$this->SetFont('Arial',$bold ? 'B' : '',$letra);
			// COLOR DEL DEXTO DE LA CABECERA
			// $this->SetTextColor(96,108,166);
			// AGREGAMOS TITULO
			$this->Cell(0,5,utf8_decode($titulo),0,0,'C');
			$this->Ln($saltolinea); 

		}

        // AGREGA TEXTO
		public function setTexto($texto,$bold = false,$letra = 18){
			
			//TIPO DE LETRAS
			$this->SetFont('Arial',$bold ? 'B' : '',$letra);
			// COLOR DEL DEXTO DE LA CABECERA
			// $this->SetTextColor(96,108,166);
			// AGREGAMOS TITULO
			$this->Cell(0,5,utf8_decode($texto),0,0,'L');
			$this->Ln(10); 

		}

		// AGREGA CABECERA DE LAS TABLAS
		public function setCabeceraTabla($tamaño,$texto,$borde,$alineacion,$salto,$fondo,$tamanoletra = 8){
			
			$this->SetFont('Arial','B',$tamanoletra);

			$this->SetFillColor(32, 77, 134);			//FONDO

			if($fondo == "1"){
				$this->SetTextColor(255,255,255);			// COLOR DE TEXTO

			}else{
				$this->SetTextColor(0,0,0);			// COLOR DE TEXTO

			}

			$this->Cell($tamaño,8,utf8_decode(strtoupper($texto) ),$borde,$salto,strtoupper($alineacion),$fondo);

		}

		// AGREGA CABECERA DE LAS TABLAS
		public function setCabeceraTabla_new($tamaño,$texto,$borde,$alineacion,$salto,$fondo,$tamanoletra = 8){
			
			$this->SetFont('Arial','B',$tamanoletra);

			$this->SetFillColor(233, 236, 239);			//FONDO

			// if($fondo == "1"){
			// 	$this->SetTextColor(255,255,255);			// COLOR DE TEXTO

			// }else{
			// 	$this->SetTextColor(0,0,0);			// COLOR DE TEXTO
			// }

			$this->Cell($tamaño,$tamanoletra,utf8_decode(strtoupper($texto) ),$borde,$salto,strtoupper($alineacion),$fondo);

		}

		// TABLAS ESPECIALES
		public function setContenidoTablaEspecial($tamaño,$texto,$bordes,$salto = 0,$tipo = "",$align = "L",$tamanoletra = 8,$r=255,$g=255,$b=255,$fondo = false,$textoblack = true){

			$this->SetFont('Arial',$tipo,$tamanoletra); //NUEVO TIPO DE LETRA
			$this->SetFillColor($r, $g, $b);			//FONDO

			if($textoblack){
				$this->SetTextColor(0,0,0);			// COLOR DE TEXTO
			}else{
				$this->SetTextColor(255,255,255);			// COLOR DE TEXTO
			}

			// $this->SetFillColor(32, 77, 134);			//FONDO



			// $this->Cell($tamaño, 7,utf8_decode($texto),$bordes,$salto,$align,$fondo);
			$this->Cell($tamaño, $tamanoletra,utf8_decode($texto),$bordes,$salto,$align,$fondo);

			// $this->Cell($tamaño, 8, $texto,'R',0,'R');
		}

		// ASIGNAR DATOS DE TABLA
		public function setContenidoTabla($tamaño,$datos,$tamanoletra = 9,$align = false,$estilo = ""){


			$this->SetFont('Arial',$estilo,$tamanoletra); //NUEVO TIPO DE LETRA
			$this->SetFillColor(255,255,255);			//FONDO
			$this->SetTextColor(0,0,0);			// COLOR DE TEXTO
			$this->SetWidths($tamaño);

			if($align){
				$this->SetAligns($align);
				// $this->setst
			}

	
			// foreach ($datos as $fila) {
				$this->Row($datos);		
			// }

		}

		public function setContenidoTabla1($tamaño,$datos){


			$this->SetFont('Arial','',6); //NUEVO TIPO DE LETRA
			$this->SetFillColor(255,255,255);			//FONDO
			$this->SetTextColor(0,0,0);			// COLOR DE TEXTO
			$this->SetWidths($tamaño);

	
			// foreach ($datos as $fila) {
				$this->Row($datos);		
			// }

		}

		// PARA TERMINOS Y CONDICIONES CABECERA
		public function setCabeceraTerminos($texto){


			$this->SetFont('Arial',"B",7); //NUEVO TIPO DE LETRA
			$this->SetTextColor(96,108,166);			// COLOR DE TEXTO
			$this->Cell(7, 8,utf8_decode($texto),0,1,'L');
			// $this->Cell($tamaño, 8, $texto,'R',0,'R');
		}

		// PARA TERMINOS Y CONDICIONES
		public function setCuerpoTerminos($texto){


			$this->SetFont('Arial',"",5); //NUEVO TIPO DE LETRA
			$this->SetTextColor(0,0,0);			// COLOR DE TEXTO
			$this->Cell(5,5,utf8_decode($texto),0,1,'L');
			// $this->Cell($tamaño, 8, $texto,'R',0,'R');
		}


	}

	

?>