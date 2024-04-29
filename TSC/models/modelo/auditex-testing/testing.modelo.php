<?php

    require_once __DIR__ .'/../../../vendor/autoload.php';
    require_once __DIR__ .'/../../modelo/reporteexcel.modelo.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



    class TestingModelo extends Spreadsheet{


        function getExcel($namefile,$data,$filtros){

        
            try{
                // INSTANCIAMOS
                $objExcelAjustes = new ExcelAjustes();

                // CREAMOS NOMBRES
                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $namefile."_".$date.".xls";
                
                // INSTANCIAMOS PHP EXCEL
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // AJUSTES
                $ajustes = $objExcelAjustes->getValores();

                // FILTROS
                $sheet->setCellValue("A1",$filtros);
                $sheet->getStyle("A1")->applyFromArray($ajustes["negrita"]);



                #region CABECERA 1

                    // INFORMACION DE LA PARTIDA
                    $sheet->mergeCells('A3:M3');
                    $sheet->setCellValue('A3', 'INFORMACIÓN DE LA PARTIDA');

                    // ENCOGIMIENTO ESTANDAR PRIMERA
                    $sheet->mergeCells('N3:W3');
                    $sheet->setCellValue('N3', 'ENCOGIMIENTO ESTANDAR PRIMERA');

                    // ENCOGIMIENTO TSC - TEXTIL PRIMERA
                    $sheet->mergeCells('X3:AG3');
                    $sheet->setCellValue('X3', 'ENCOGIMIENTO TSC - TEXTIL PRIMERA');

                    // DATOS REALES TSC - 1RA LAVADA
                    $sheet->mergeCells('AH3:AP3');
                    $sheet->setCellValue('AH3', 'DATOS REALES TSC - 1RA LAVADA');

                    // ENCOGIMIENTO ESTANDAR TERCERA
                    $sheet->mergeCells('AQ3:AZ3');
                    $sheet->setCellValue('AQ3', 'ENCOGIMIENTO ESTANDAR TERCERA');

                    // ENCOGIMIENTO TSC - TEXTIL TERCERA
                    $sheet->mergeCells('BA3:BJ3');
                    $sheet->setCellValue('BA3', 'ENCOGIMIENTO TSC - TEXTIL TERCERA');

                    // TOLERANCIAS
                    $sheet->mergeCells('BK3:BT3');
                    $sheet->setCellValue('BK3', 'TOLERANCIAS');
                    
                    // DATOS REALES TSC - 3RA LAVADA
                    $sheet->mergeCells('BU3:CD3');
                    $sheet->setCellValue('BU3', 'DATOS REALES TSC - 3RA LAVADA');

                    // TOL-DENSIDAD 
                    $sheet->mergeCells('CE3:CH3');
                    $sheet->setCellValue('CE3', 'TOL-DENSIDAD');

                    //  ENCOG. DE PAÑOS LAVADOS
                    $sheet->mergeCells('CI3:CL3');
                    $sheet->setCellValue('CI3', 'ENCOG. DE PAÑOS LAVADOS');

                    //  RESIDUAL PAÑO
                    $sheet->mergeCells('CM3:CR3');
                    $sheet->setCellValue('CM3', 'RESIDUAL PAÑO');

                    // 1RA SECADA TAMBOR
                    $sheet->mergeCells('CS3:DA3');
                    $sheet->setCellValue('CS3', '1RA LAVADA (SECADA TAMBOR)');

                    // 3RA SECADA TAMBOR
                    $sheet->mergeCells('DB3:DK3');
                    $sheet->setCellValue('DB3', '3RA LAVADA (SECADA TAMBOR)');

                    // DATOS EXTRA
                    $sheet->mergeCells('DL3:DN3');
                    $sheet->setCellValue('DL3', 'DATOS EXTRA');


                #endregion

                #region CABECERA 2

                    $sheet->setCellValue('A4', 'N°');
                    $sheet->getColumnDimension("A")->setWidth(3);

                    $sheet->setCellValue('B4', 'Status');
                    $sheet->getColumnDimension("B")->setWidth(6);

                    $sheet->setCellValue('C4', 'Kilos');
                    $sheet->getColumnDimension("C")->setWidth(7);

                    $sheet->setCellValue('D4', 'Programa');
                    $sheet->getColumnDimension("D")->setWidth(12);

                    $sheet->setCellValue('E4', 'Cod. Tela');
                    $sheet->getColumnDimension("E")->setWidth(11);

                    $sheet->setCellValue('F4', 'Partida');
                    $sheet->getColumnDimension("F")->setWidth(8);

                    $sheet->setCellValue('G4', 'Fecha');
                    $sheet->getColumnDimension("G")->setWidth(9);

                    $sheet->setCellValue('H4', 'Proveedor');
                    $sheet->getColumnDimension("H")->setWidth(12);

                    $sheet->setCellValue('I4', 'Tipo de tela');
                    $sheet->getColumnDimension("I")->setWidth(22);

                    $sheet->setCellValue('J4', 'Color');
                    $sheet->getColumnDimension("J")->setWidth(10);

                    $sheet->setCellValue('K4', 'Cod Color');
                    $sheet->getColumnDimension("K")->setWidth(10);
                    
                    $sheet->setCellValue('L4', 'Lavado');
                    $sheet->getColumnDimension("L")->setWidth(8);

                    $sheet->setCellValue('M4', 'Ruta ERP');
                    $sheet->getColumnDimension("M")->setWidth(15);

                    // ENCOGIMIENTO ESTANDAR PRIMERA
                    $sheet->setCellValue('N4', 'H');
                    $sheet->getColumnDimension("N")->setWidth(4);

                    $sheet->setCellValue('O4', 'T');
                    $sheet->getColumnDimension("O")->setWidth(4);

                    $sheet->setCellValue('P4', 'Den. B/W');
                    $sheet->getColumnDimension("P")->setWidth(5);

                    $sheet->setCellValue('Q4', 'Den. A/W');
                    $sheet->getColumnDimension("Q")->setWidth(5);

                    $sheet->setCellValue('R4', 'Ancho B/W');
                    $sheet->getColumnDimension("R")->setWidth(6);

                    $sheet->setCellValue('S4', 'Ancho A/W');
                    $sheet->getColumnDimension("S")->setWidth(6);

                    $sheet->setCellValue('T4', 'Incli Acab. B/W');
                    $sheet->getColumnDimension("T")->setWidth(6);

                    $sheet->setCellValue('U4', 'Incli Acab. A/W');
                    $sheet->getColumnDimension("U")->setWidth(6);

                    $sheet->setCellValue('V4', 'Solid');
                    $sheet->getColumnDimension("V")->setWidth(5);

                    $sheet->setCellValue('W4', 'Rev.');
                    $sheet->getColumnDimension("W")->setWidth(5);

                    // TEXTO CENTRADO
                    $sheet->getStyle('N4:W4')->getAlignment()->setWrapText(true); 


                    // ENCOGIMIENTO TSC - TEXTIL PRIMERA
                    $sheet->setCellValue('X4', 'H');
                    $sheet->getColumnDimension("X")->setWidth(6);

                    $sheet->setCellValue('Y4', 'T');
                    $sheet->getColumnDimension("Y")->setWidth(6);

                    $sheet->setCellValue('Z4', 'Den. B/W');
                    $sheet->getColumnDimension("Z")->setWidth(5);

                    $sheet->setCellValue('AA4', 'Den. A/W');
                    $sheet->getColumnDimension("AA")->setWidth(5);

                    $sheet->setCellValue('AB4', 'Ancho B/W');
                    $sheet->getColumnDimension("Z")->setWidth(6);

                    $sheet->setCellValue('AC4', 'Ancho A/W');
                    $sheet->getColumnDimension("AC")->setWidth(6);

                    $sheet->setCellValue('AD4', 'Incli Acab. B/W');
                    $sheet->getColumnDimension("AD")->setWidth(5);

                    $sheet->setCellValue('AE4', 'Incli Acab. A/W');
                    $sheet->getColumnDimension("AE")->setWidth(5);

                    $sheet->setCellValue('AF4', 'Solid');
                    $sheet->getColumnDimension("AF")->setWidth(5);

                    $sheet->setCellValue('AG4', 'Rev.');
                    $sheet->getColumnDimension("AG")->setWidth(5);

                    // TEXTO CENTRADO
                    $sheet->getStyle('X4:AG4')->getAlignment()->setWrapText(true); 
            
                    // REALES PRIMERA
                    $sheet->setCellValue('AH4', 'H');
                    $sheet->getColumnDimension("AH")->setWidth(5);

                    $sheet->setCellValue('AI4', 'T');
                    $sheet->getColumnDimension("AI")->setWidth(5);

                    $sheet->setCellValue('AJ4', 'Den. B/W');
                    $sheet->getColumnDimension("AJ")->setWidth(5);

                    $sheet->setCellValue('AK4', 'Incli Acab. B/W');
                    $sheet->getColumnDimension("AK")->setWidth(6);

                    $sheet->setCellValue('AL4', 'Ancho Total');
                    $sheet->getColumnDimension("AL")->setWidth(5);

                    $sheet->setCellValue('AM4', 'Ancho Util');
                    $sheet->getColumnDimension("AM")->setWidth(5);

                    $sheet->setCellValue('AN4', 'Rev. 1');
                    $sheet->getColumnDimension("AN")->setWidth(6);

                    $sheet->setCellValue('AO4', 'Rev. 2');
                    $sheet->getColumnDimension("AO")->setWidth(6);

                    $sheet->setCellValue('AP4', 'Revi. 3');
                    $sheet->getColumnDimension("AP")->setWidth(6);

                    // TEXTO CENTRADO
                    $sheet->getStyle('AH4:AP4')->getAlignment()->setWrapText(true); 

                    // ENCOGIMIENTO ESTANDAR TERCERA
                    $sheet->setCellValue('AQ4', 'H');
                    $sheet->getColumnDimension("AQ")->setWidth(5);

                    $sheet->setCellValue('AR4', 'T');
                    $sheet->getColumnDimension("AR")->setWidth(5);

                    $sheet->setCellValue('AS4', 'Den. B/W');
                    $sheet->getColumnDimension("AS")->setWidth(5);

                    $sheet->setCellValue('AT4', 'Den. A/W');
                    $sheet->getColumnDimension("AT")->setWidth(5);

                    $sheet->setCellValue('AU4', 'Ancho B/W');
                    $sheet->getColumnDimension("AU")->setWidth(5);

                    $sheet->setCellValue('AV4', 'Ancho A/W');
                    $sheet->getColumnDimension("AV")->setWidth(5);

                    $sheet->setCellValue('AW4', 'Incli Acab. B/W');
                    $sheet->getColumnDimension("AW")->setWidth(5);

                    $sheet->setCellValue('AX4', 'Incli Acab. A/W');
                    $sheet->getColumnDimension("AX")->setWidth(5);

                    $sheet->setCellValue('AY4', 'Solid.');
                    $sheet->getColumnDimension("AY")->setWidth(5);

                    $sheet->setCellValue('AZ4', 'Rev');
                    $sheet->getColumnDimension("AZ")->setWidth(5);

                    // TEXTO CENTRADO
                    $sheet->getStyle('AQ4:AZ4')->getAlignment()->setWrapText(true); 

                    // ENCOGIMIENTO TSC - TEXTIL TERCERA

                    $sheet->setCellValue('BA4', 'H');
                    $sheet->getColumnDimension("BA")->setWidth(6);

                    $sheet->setCellValue('BB4', 'T');
                    $sheet->getColumnDimension("BB")->setWidth(6);

                    $sheet->setCellValue('BC4', 'Den. B/W');
                    $sheet->getColumnDimension("BC")->setWidth(5);

                    $sheet->setCellValue('BD4', 'Den. A/W');
                    $sheet->getColumnDimension("BD")->setWidth(5);

                    $sheet->setCellValue('BE4', 'Ancho B/W');
                    $sheet->getColumnDimension("BE")->setWidth(5);

                    $sheet->setCellValue('BF4', 'Ancho A/W');
                    $sheet->getColumnDimension("BF")->setWidth(5);

                    $sheet->setCellValue('BG4', 'Incli Acab. B/W');
                    $sheet->getColumnDimension("BG")->setWidth(5);

                    $sheet->setCellValue('BH4', 'Incli Acab. A/W');
                    $sheet->getColumnDimension("BH")->setWidth(5);

                    $sheet->setCellValue('BI4', 'Solid');
                    $sheet->getColumnDimension("BI")->setWidth(5);

                    $sheet->setCellValue('BJ4', 'Rev.');
                    $sheet->getColumnDimension("BJ")->setWidth(6);

                    // TEXTO CENTRADO
                    $sheet->getStyle('BA4:BJ4')->getAlignment()->setWrapText(true); 


                    // TOLERANCIAS
                    $sheet->setCellValue('BK4', 'H');
                    $sheet->getColumnDimension("Bk")->setWidth(6);

                    $sheet->setCellValue('BL4', 'T');
                    $sheet->getColumnDimension("BL")->setWidth(6);

                    $sheet->setCellValue('BM4', 'Den. B/W');
                    $sheet->getColumnDimension("BM")->setWidth(6);

                    $sheet->setCellValue('BN4', 'Den. A/W');
                    $sheet->getColumnDimension("BN")->setWidth(6);

                    $sheet->setCellValue('BO4', 'Ancho B/W');
                    $sheet->getColumnDimension("BO")->setWidth(6);

                    $sheet->setCellValue('BP4', 'Ancho A/W');
                    $sheet->getColumnDimension("BP")->setWidth(6);

                    $sheet->setCellValue('BQ4', 'Incli Acab. B/W');
                    $sheet->getColumnDimension("BQ")->setWidth(6);

                    $sheet->setCellValue('BR4', 'Incli Acab. A/W');
                    $sheet->getColumnDimension("BR")->setWidth(6);

                    $sheet->setCellValue('BS4', 'Solid');
                    $sheet->getColumnDimension("BS")->setWidth(6);

                    $sheet->setCellValue('BT4', 'Rev.');
                    $sheet->getColumnDimension("BT")->setWidth(6);


                    $sheet->getStyle('BK4:BT4')->getAlignment()->setWrapText(true); 

                    // DATOS REALES TSC - 3RA LAVADA

                    $sheet->setCellValue('BU4', 'H');
                    $sheet->getColumnDimension("BU")->setWidth(6);

                    $sheet->setCellValue('BV4', 'T');
                    $sheet->getColumnDimension("BV")->setWidth(6);

                    $sheet->setCellValue('BW4', 'Den. B/W');
                    $sheet->getColumnDimension("BW")->setWidth(6);

                    $sheet->setCellValue('BX4', 'Incli Acab. B/W');
                    $sheet->getColumnDimension("BX")->setWidth(6);

                    $sheet->setCellValue('BY4', 'Ancho Total');
                    $sheet->getColumnDimension("BY")->setWidth(6);

                    $sheet->setCellValue('BZ4', 'Ancho Util');
                    $sheet->getColumnDimension("BZ")->setWidth(6);

                    $sheet->setCellValue('CA4', 'Rev. 1');
                    $sheet->getColumnDimension("CA")->setWidth(6);

                    $sheet->setCellValue('CB4', 'Rev. 2');
                    $sheet->getColumnDimension("CB")->setWidth(6);

                    $sheet->setCellValue('CC4', 'Rev.3');
                    $sheet->getColumnDimension("CC")->setWidth(6);

                    $sheet->setCellValue('CD4', 'Solid.');
                    $sheet->getColumnDimension("CD")->setWidth(6);

                    $sheet->getStyle('BU4:CD4')->getAlignment()->setWrapText(true); 


                    // TOLERANCIAS DENSIDAD
                    $sheet->setCellValue('CE4', 'B/W +5%');
                    $sheet->getColumnDimension("CE")->setWidth(5);

                    $sheet->setCellValue('CF4', 'B/W -5%');
                    $sheet->getColumnDimension("CF")->setWidth(5);

                    $sheet->setCellValue('CG4', 'A/W +5%');
                    $sheet->getColumnDimension("CG")->setWidth(5);

                    $sheet->setCellValue('CH4', 'A/W -5%');
                    $sheet->getColumnDimension("CH")->setWidth(5);


                    $sheet->getStyle('CE4:CH4')->getAlignment()->setWrapText(true); 


                    // ENCOGIMIENTOS DE PAÑOS LAVADOS
                    $sheet->setCellValue('CI4', 'H');
                    $sheet->getColumnDimension("CI")->setWidth(5.5);

                    $sheet->setCellValue('CJ4', 'T');
                    $sheet->getColumnDimension("CJ")->setWidth(5.5);

                    $sheet->setCellValue('CK4', 'Incli. B/W');
                    $sheet->getColumnDimension("CK")->setWidth(5.5);

                    $sheet->setCellValue('CL4', 'Incli. A/W');
                    $sheet->getColumnDimension("CL")->setWidth(5.5);

                    $sheet->getStyle('CI4:CL4')->getAlignment()->setWrapText(true); 


                    // RESIDUAL PAÑO
                    $sheet->setCellValue('CM4', 'H');
                    $sheet->getColumnDimension("CM")->setWidth(6);

                    $sheet->setCellValue('CN4', 'T');
                    $sheet->getColumnDimension("CN")->setWidth(6);

                    $sheet->setCellValue('CO4', 'Incli.');
                    $sheet->getColumnDimension("CO")->setWidth(5);

                    $sheet->setCellValue('CP4', 'Rev. 1');
                    $sheet->getColumnDimension("CP")->setWidth(6);

                    $sheet->setCellValue('CQ4', 'Rev. 2');
                    $sheet->getColumnDimension("CQ")->setWidth(6);

                    $sheet->setCellValue('CR4', 'Rev. 3');
                    $sheet->getColumnDimension("CR")->setWidth(6);

                    $sheet->getStyle('CM4:CR4')->getAlignment()->setWrapText(true);


                    // PRIMERA TAMBOR
                    $sheet->setCellValue('CS4', 'H');
                    $sheet->getColumnDimension("CS")->setWidth(5);

                    $sheet->setCellValue('CT4', 'T');
                    $sheet->getColumnDimension("CT")->setWidth(5);

                    $sheet->setCellValue('CU4', 'Den. B/W');
                    $sheet->getColumnDimension("CU")->setWidth(5);

                    $sheet->setCellValue('CV4', 'Incli Acab. B/W');
                    $sheet->getColumnDimension("CV")->setWidth(6);

                    $sheet->setCellValue('CW4', 'Ancho Total');
                    $sheet->getColumnDimension("CW")->setWidth(5);

                    $sheet->setCellValue('CX4', 'Ancho Util');
                    $sheet->getColumnDimension("CX")->setWidth(5);

                    $sheet->setCellValue('CY4', 'Rev. 1');
                    $sheet->getColumnDimension("CY")->setWidth(6);

                    $sheet->setCellValue('CZ4', 'Rev. 2');
                    $sheet->getColumnDimension("CZ")->setWidth(6);

                    $sheet->setCellValue('DA4', 'Revi. 3');
                    $sheet->getColumnDimension("DA")->setWidth(6);

                    // TEXTO CENTRADO
                    $sheet->getStyle('CS4:DA4')->getAlignment()->setWrapText(true); 


                    // TERCERA TAMBOR

                    $sheet->setCellValue('DB4', 'H');
                    $sheet->getColumnDimension("DB")->setWidth(6);

                    $sheet->setCellValue('DC4', 'T');
                    $sheet->getColumnDimension("DC")->setWidth(6);

                    $sheet->setCellValue('DD4', 'Den. B/W');
                    $sheet->getColumnDimension("DD")->setWidth(6);

                    $sheet->setCellValue('DE4', 'Incli Acab. B/W');
                    $sheet->getColumnDimension("DD")->setWidth(6);

                    $sheet->setCellValue('DF4', 'Ancho Total');
                    $sheet->getColumnDimension("DF")->setWidth(6);

                    $sheet->setCellValue('DG4', 'Ancho Util');
                    $sheet->getColumnDimension("DG")->setWidth(6);

                    $sheet->setCellValue('DH4', 'Rev. 1');
                    $sheet->getColumnDimension("DH")->setWidth(6);

                    $sheet->setCellValue('DI4', 'Rev. 2');
                    $sheet->getColumnDimension("DI")->setWidth(6);

                    $sheet->setCellValue('DJ4', 'Rev.3');
                    $sheet->getColumnDimension("DJ")->setWidth(6);

                    $sheet->setCellValue('DK4', 'Solid.');
                    $sheet->getColumnDimension("DK")->setWidth(6);

                    $sheet->getStyle('DB4:DK4')->getAlignment()->setWrapText(true); 



                    // DATOS EXTRA
                    $sheet->setCellValue('DL4', 'Fecha Liberación');
                    $sheet->getColumnDimension("DL")->setWidth(10);

                    $sheet->setCellValue('DM4', 'Liberado por');
                    $sheet->getColumnDimension("DM")->setWidth(27);

                    $sheet->setCellValue('DN4', 'Observaciones');
                    $sheet->getColumnDimension("DN")->setWidth(73);

                    $sheet->getStyle('DL4:DN4')->getAlignment()->setWrapText(true); 

                #endregion

                #region ESTILOS DE LA CABECERA

                     // ALTO DE LA FILA
                    $sheet->getRowDimension(3)->setRowHeight(25);
                    $sheet->getRowDimension(4)->setRowHeight(44);

                    // COLORE DE FONDO   
                    $objExcelAjustes->setBackground($spreadsheet,"A3:M3","95B3D7");
                    $objExcelAjustes->setBackground($spreadsheet,"A4:M4","D3E2F5");

                    $objExcelAjustes->setBackground($spreadsheet,"N3:W3","FF9393");
                    $objExcelAjustes->setBackground($spreadsheet,"N4:W4","FFC5C5");

                    $objExcelAjustes->setBackground($spreadsheet,"X3:AG3","FFDA65");
                    $objExcelAjustes->setBackground($spreadsheet,"X4:AG4","FFE285");

                    $objExcelAjustes->setBackground($spreadsheet,"AH3:AP3","A7D971");
                    $objExcelAjustes->setBackground($spreadsheet,"AH4:AP4","C7E7A3");

                    $objExcelAjustes->setBackground($spreadsheet,"AQ3:AZ3","FF9393");
                    $objExcelAjustes->setBackground($spreadsheet,"AQ4:AZ4","FFC5C5");

                    $objExcelAjustes->setBackground($spreadsheet,"BA3:BJ3","FFDA65");
                    $objExcelAjustes->setBackground($spreadsheet,"BA4:BJ4","FFE285");

                    $objExcelAjustes->setBackground($spreadsheet,"BK3:BT3","95B3D7");
                    $objExcelAjustes->setBackground($spreadsheet,"BK4:BT4","D3E2F5");

                    $objExcelAjustes->setBackground($spreadsheet,"BU3:CD3","A7D971");
                    $objExcelAjustes->setBackground($spreadsheet,"BU4:CD4","C7E7A3");

                    $objExcelAjustes->setBackground($spreadsheet,"CE3:CH3","FF9393");
                    $objExcelAjustes->setBackground($spreadsheet,"CE4:CH4","FFC5C5");

                    $objExcelAjustes->setBackground($spreadsheet,"CI3:CL3","A7D971");
                    $objExcelAjustes->setBackground($spreadsheet,"CI4:CL4","C7E7A3");

                    $objExcelAjustes->setBackground($spreadsheet,"CM3:CR3","FFE285");
                    $objExcelAjustes->setBackground($spreadsheet,"CM4:CR4","FFE9A3");


                    $objExcelAjustes->setBackground($spreadsheet,"CS3:DA3","A7D971");
                    $objExcelAjustes->setBackground($spreadsheet,"CS4:DA4","C7E7A3");

                    $objExcelAjustes->setBackground($spreadsheet,"DB3:DK3","FFE285");
                    $objExcelAjustes->setBackground($spreadsheet,"DB4:DK4","FFE9A3");


                    $objExcelAjustes->setBackground($spreadsheet,"DL3:DN3","95B3D7");
                    $objExcelAjustes->setBackground($spreadsheet,"DL4:DN4","D3E2F5");

                #endregion
                

                $inicio = 4;
                $cont = 0;

                // DATOS ARRAY
                foreach($data as $fila){

                    $inicio++;
                    $cont++;

                    $simboloestado      = $fila["SIMBOLOESTADO"] == "" ? $fila["ESTADOSISTEMA"] : $fila["SIMBOLOESTADO"];

                    // DATOS GENERALES
                    $sheet->setCellValue("A{$inicio}", $cont);
                    $sheet->setCellValue("B{$inicio}", $simboloestado);
                    $sheet->setCellValue("C{$inicio}", $fila["KILOS"]);
                    $sheet->setCellValue("D{$inicio}", $fila["PROGRAMA"]);
                    $sheet->setCellValue("E{$inicio}", $fila["CODTELA"]);
                    $sheet->setCellValue("F{$inicio}", $fila["PARTIDA"]);

                    $fecha  = date("d/m/Y", strtotime($fila['FECHA']));

                    $sheet->setCellValue("G{$inicio}", $fecha);
                    $sheet->setCellValue("H{$inicio}", $fila["PROVEEDOR"]);
                    $sheet->setCellValue("I{$inicio}", $fila["DESCRIPCIONTELALARGA"]);
                    $sheet->setCellValue("J{$inicio}", $fila["COLOR"]);
                    $sheet->setCellValue("K{$inicio}", $fila["CODCOLOR"]);
                    $sheet->setCellValue("L{$inicio}", $fila["RUTA"]);
                    $sheet->setCellValue("M{$inicio}", $fila["RUTAERP"]);
                    
                    // EMNGOGIMIENTOS ESTANDAR PRIMERA

                    // HILO
                    $hiloprimera = str_replace("%","",$fila["HILOPRIMERA"]);
                    $hiloprimera = (float)$hiloprimera / 100;
                    $sheet->setCellValue("N{$inicio}", $hiloprimera);

                    // TRAMA
                    $tramaprimera = str_replace("%","",$fila["TRAMAPRIMERA"]);
                    $tramaprimera = (float)$tramaprimera / 100;
                    $sheet->setCellValue("O{$inicio}", $tramaprimera);

                    $sheet->setCellValue("P{$inicio}", trim($fila["DENSIDADBEFORE"]));
                    $sheet->setCellValue("Q{$inicio}", trim($fila["DENSIDADAFTER"]));
                    $sheet->setCellValue("R{$inicio}", trim($fila["ANCHOREPOSOBEFORE"]));
                    $sheet->setCellValue("S{$inicio}", trim($fila["ANCHOREPOSOAFTER"]));
                    $sheet->setCellValue("T{$inicio}", $fila["INCLIACABADOS"]);
                    $sheet->setCellValue("U{$inicio}", $fila["INCLILAVADO"]);
                    $sheet->setCellValue("V{$inicio}", $fila["SOLIDES"]);

                    // REVIRADO
                    $reviradoprimera = str_replace("%","",$fila["REVIRADOPRIMERA"]);
                    $reviradoprimera = (float)$reviradoprimera / 100;
                    $sheet->setCellValue("W{$inicio}", $reviradoprimera);

                    // ENCOGIMIENTO TSC - TEXTIL PRIMERA

                    // HILO PRIMERA TSC
                    $hiloprimeratsc = str_replace("%","",$fila["HILOPRIMERATSC"]);
                    $hiloprimeratsc = (float)$hiloprimeratsc / 100;
                    $sheet->setCellValue("X{$inicio}", $hiloprimeratsc);

                    // TRAMA PRIMERA TSC
                    $tramaprimeratsc = str_replace("%","",$fila["TRAMAPRIMERATSC"]);
                    $tramaprimeratsc = (float)$tramaprimeratsc / 100;
                    $sheet->setCellValue("Y{$inicio}", $tramaprimeratsc);


                    $sheet->setCellValue("Z{$inicio}", trim($fila["DENSIDADBEFORETSC"]));
                    $sheet->setCellValue("AA{$inicio}", trim($fila["DENSIDADAFTERTSC"]));
                    $sheet->setCellValue("AB{$inicio}", trim($fila["ANCHOREPOSOBEFORETSC"]));
                    $sheet->setCellValue("AC{$inicio}", trim($fila["ANCHOREPOSOAFTERTSC"]));
                    $sheet->setCellValue("AD{$inicio}", $fila["INCLIACABADOSTSC"]);
                    $sheet->setCellValue("AE{$inicio}", $fila["INCLILAVADOTSC"]);
                    $sheet->setCellValue("AF{$inicio}", $fila["SOLIDESTSC"]);

                    
                    // REVIRADO PRIMERA TSC
                    $reviradoprimeratsc = str_replace("%","",$fila["REVIRADOPRIMERATSC"]);
                    $reviradoprimeratsc = (float)$reviradoprimeratsc / 100;
                    $sheet->setCellValue("AG{$inicio}", $reviradoprimeratsc);
                    
                    // DATOS REALES TSC - 1RA LAVADA
                    $hilo   =  (float)$fila['HILOPRIMERAL'];
                    $trama  =  (float)$fila['TRAMAPRIMERAL'];
                    $revirado1primeralavada = (float)$fila['REVIRADO1PRIMERAL'];
                    $revirado2primeralavada = (float)$fila['REVIRADO2PRIMERAL'];
                    $revirado3primeralavada = (float)$fila['REVIRADO3PRIMERAL'];


                    $inclinacionprimeral = (float)$fila["INCLINACIONPRIMERAL"];

                    $sheet->setCellValue("AH{$inicio}", $hilo / 100);
                    $sheet->setCellValue("AI{$inicio}", $trama / 100);
                    $sheet->setCellValue("AJ{$inicio}", $fila["DENSIDADPRIMERAL"]);
                    $sheet->setCellValue("AK{$inicio}", $inclinacionprimeral . "°");
                    $sheet->setCellValue("AL{$inicio}", $fila["ANCHOTOTALPRIMERAL"]);
                    $sheet->setCellValue("AM{$inicio}", $fila["ANCHOUTILPRIMERAL"]);
                    $sheet->setCellValue("AN{$inicio}", $revirado1primeralavada / 100);
                    $sheet->setCellValue("AO{$inicio}", $revirado2primeralavada / 100);
                    $sheet->setCellValue("AP{$inicio}", $revirado3primeralavada / 100);
                    

                    // ENCOGIMIENTO ESTANDAR TERCERA

                    // HILO TERCERA
                    $hilotercera = str_replace("%","",$fila["HILOTERCERA"]);
                    $hilotercera = (float)$hilotercera / 100;
                    $sheet->setCellValue("AQ{$inicio}", $hilotercera);

                    // $sheet->setCellValue("AQ{$inicio}", $fila["HILOTERCERA"]);

                    // TRAMA TERCERA
                    $tramatercera = str_replace("%","",$fila["TRAMATERCERA"]);
                    $tramatercera = (float)$tramatercera / 100;
                    $sheet->setCellValue("AR{$inicio}", $tramatercera);

                    // $sheet->setCellValue("AR{$inicio}", $fila["TRAMATERCERA"]);

                    $sheet->setCellValue("AS{$inicio}", trim($fila["DENSIDADBEFORE"]));
                    $sheet->setCellValue("AT{$inicio}", trim($fila["DENSIDADAFTER"]));
                    $sheet->setCellValue("AU{$inicio}", trim($fila["ANCHOREPOSOBEFORE"]));
                    $sheet->setCellValue("AV{$inicio}", trim($fila["ANCHOREPOSOAFTER"]));
                    $sheet->setCellValue("AW{$inicio}", trim($fila["INCLIACABADOS"]));
                    $sheet->setCellValue("AX{$inicio}", trim($fila["INCLILAVADO"]));
                    $sheet->setCellValue("AY{$inicio}", $fila["SOLIDES"]);

                    // REVIRADO TERCERA
                    $reviradotercera = str_replace("%","",$fila["REVIRADOTERCERA"]);
                    $reviradotercera = (float)$reviradotercera / 100;
                    $sheet->setCellValue("AZ{$inicio}", $reviradotercera);

                    // ENCOGIMIENTO TSC - TEXTIL TERCERA
                    $hiloterceratsc = str_replace("%","",$fila["HILOTERCERATSC"]);
                    $hiloterceratsc = (float)$hiloterceratsc / 100;
                    $sheet->setCellValue("BA{$inicio}", $hiloterceratsc);

                    // $sheet->setCellValue("BA{$inicio}", $fila["HILOTERCERATSC"]);

                    $tramaterceratsc = str_replace("%","",$fila["TRAMATERCERATSC"]);
                    $tramaterceratsc = (float)$tramaterceratsc / 100;
                    $sheet->setCellValue("BB{$inicio}", $tramaterceratsc);
                    // $sheet->setCellValue("BB{$inicio}", $fila["TRAMATERCERATSC"]);

                    $sheet->setCellValue("BC{$inicio}", trim($fila["DENSIDADBEFORETSC"]));
                    $sheet->setCellValue("BD{$inicio}", trim($fila["DENSIDADAFTERTSC"]));
                    $sheet->setCellValue("BE{$inicio}", trim($fila["ANCHOREPOSOBEFORETSC"]));
                    $sheet->setCellValue("BF{$inicio}", trim($fila["ANCHOREPOSOAFTERTSC"]));
                    $sheet->setCellValue("BG{$inicio}", trim($fila["INCLIACABADOSTSC"]));
                    $sheet->setCellValue("BH{$inicio}", trim($fila["INCLILAVADOTSC"]));
                    $sheet->setCellValue("BI{$inicio}", $fila["SOLIDESTSC"]);

                    $reviradoterceratsc = str_replace("%","",$fila["REVIRADOTERCERATSC"]);
                    $reviradoterceratsc = (float)$reviradoterceratsc / 100;
                    $sheet->setCellValue("BJ{$inicio}", $reviradoterceratsc);
                    // $sheet->setCellValue("BJ{$inicio}", $fila["REVIRADOTERCERATSC"]);
    

                    // TOLERANCIAS TERCERA
                    $sheet->setCellValue("BK{$inicio}", trim($fila["HILOTERCERATOL"]));
                    $sheet->setCellValue("BL{$inicio}", trim($fila["TRAMATERCERATOL"]));
                    $sheet->setCellValue("BM{$inicio}", trim($fila["DENSIDADBEFORETOL"]));
                    $sheet->setCellValue("BN{$inicio}", trim($fila["DENSIDADAFTERTOL"]));
                    $sheet->setCellValue("BO{$inicio}", trim($fila["ANCHOREPOSOBEFORETOL"]));
                    $sheet->setCellValue("BP{$inicio}", trim($fila["ANCHOREPOSOAFTERTOL"]));
                    $sheet->setCellValue("BQ{$inicio}", trim($fila["INCLIACABADOSTOL"]));
                    $sheet->setCellValue("BR{$inicio}", trim($fila["INCLILAVADOTOL"]));
                    $sheet->setCellValue("BS{$inicio}", trim($fila["SOLIDES"]));
                    $sheet->setCellValue("BT{$inicio}", trim($fila["REVIRADOTERCERATOL"]));
                    

                    // DATOS REALES TSC - 3RA LAVADA

                    $hilo       =  (float)$fila['HILOTERCERAL'];
                    $trama      =  (float)$fila['TRAMATERCERAL'];
                    $solidez    =  (float)$fila['SOLIDEZTERCERAL'];

                    $revirado1terceralavada    =  (float)$fila['REVIRADO1TERCERAL'];
                    $revirado2terceralavada    =  (float)$fila['REVIRADO2TERCERAL'];
                    $revirado3terceralavada    =  (float)$fila['REVIRADO3TERCERAL'];


                    $sheet->setCellValue("BU{$inicio}", $hilo / 100);
                    $sheet->setCellValue("BV{$inicio}", $trama / 100);
                    $sheet->setCellValue("BW{$inicio}", trim($fila["DENSIDADTERCERAL"]));

                    $inclinacionterceral = (float)$fila["INCLINACIONTERCERAL"];

                    $sheet->setCellValue("BX{$inicio}", $inclinacionterceral . "°");
                    $sheet->setCellValue("BY{$inicio}", trim($fila["ANCHOTOTALTERCERAL"]));
                    $sheet->setCellValue("BZ{$inicio}", trim($fila["ANCHOUTILTERCERAL"]));
                    $sheet->setCellValue("CA{$inicio}", $revirado1terceralavada / 100);
                    $sheet->setCellValue("CB{$inicio}", $revirado2terceralavada / 100);
                    $sheet->setCellValue("CC{$inicio}", $revirado3terceralavada / 100);
                    $sheet->setCellValue("CD{$inicio}", $solidez / 100);
                    

                    // TOLERANCIAS DENSIDAD
                    $sheet->setCellValue("CE{$inicio}", trim($fila["TOLERANCIABEFOREMAS"]));
                    $sheet->setCellValue("CF{$inicio}", trim($fila["TOLERANCIABEFOREMENOS"]));
                    $sheet->setCellValue("CG{$inicio}", trim($fila["TOLERANCIAAFTERMAS"]));
                    $sheet->setCellValue("CH{$inicio}", trim($fila["TOLERANCIAAFTERMENOS"]));
    
                    // ENCOGIMIENTOS DE PAÑOS LAVADOS

                    $hiloencogimiento           =  (float)$fila['HILOENCOGIMIENTO'];
                    $tramaencogimiento          =  (float)$fila['TRAMAENCOGIMIENTO'];

                    // INCLINACION BEFORE
                    $inclinacionbefore      = $fila["INCLINACIONBEFORE"] == "" ? "" : $fila["INCLINACIONBEFORE"]."°";
                    $inclinacionafter       = $fila["INCLINACIONAFTER"] == "" ? "" : $fila["INCLINACIONAFTER"]."°";



                    $sheet->setCellValue("CI{$inicio}", $hiloencogimiento / 100);
                    $sheet->setCellValue("CJ{$inicio}", $tramaencogimiento / 100);
                    $sheet->setCellValue("CK{$inicio}", $inclinacionbefore);
                    $sheet->setCellValue("CL{$inicio}", $inclinacionafter);


                    // RESIDUAL PAÑO
                    $hiloresidual       = (float)$fila['HILORESIDUAL'];
                    $tramaresidual      = (float)$fila['TRAMARESIDUAL'];
                    $revirado1residual  = (float)$fila['REVIRADO1RESIDUAL'];
                    $revirado2residual  = (float)$fila['REVIRADO2RESIDUAL'];
                    $revirado3residual  = (float)$fila['REVIRADO3RESIDUAL'];

                    $inclinacionresidual = $fila["INCLINACIONRESIDUAL"] == "" ? "0" : (float)$fila["INCLINACIONRESIDUAL"];

                    $sheet->setCellValue("CM{$inicio}",  $hiloresidual / 100);
                    $sheet->setCellValue("CN{$inicio}",  $tramaresidual / 100);
                    $sheet->setCellValue("CO{$inicio}",  $inclinacionresidual . "°");
                    $sheet->setCellValue("CP{$inicio}",  $revirado1residual / 100);
                    $sheet->setCellValue("CQ{$inicio}",  $revirado2residual / 100);
                    $sheet->setCellValue("CR{$inicio}",  $revirado3residual / 100);

                    // PRIMERA TAMBOR
                    $hiloprimeralavadatam    = (float)$fila['HILOPRIMERALTAM'];
                    $tramaprimeralavadatam   = (float)$fila['TRAMAPRIMERALTAM'];
                    $revirado1primeratam =  (float)$fila['REVIRADO1PRIMERALTAM'];
                    $revirado2primeratam =  (float)$fila['REVIRADO2PRIMERALTAM'];
                    $revirado3primeratam =  (float)$fila['REVIRADO3PRIMERALTAM'];


                    $inclinacionprimeral = (float)$fila["INCLINACIONPRIMERALTAM"];

                    $sheet->setCellValue("CS{$inicio}", $hiloprimeralavadatam / 100);
                    $sheet->setCellValue("CT{$inicio}", $tramaprimeralavadatam / 100);
                    $sheet->setCellValue("CU{$inicio}", $fila["DENSIDADPRIMERALTAM"]);
                    $sheet->setCellValue("CV{$inicio}", $inclinacionprimeral . "°");
                    $sheet->setCellValue("CW{$inicio}", $fila["ANCHOTOTALPRIMERALTAM"]);
                    $sheet->setCellValue("CX{$inicio}", $fila["ANCHOUTILPRIMERALTAM"]);
                    $sheet->setCellValue("CY{$inicio}", $revirado1primeratam / 100);
                    $sheet->setCellValue("CZ{$inicio}", $revirado2primeratam / 100);
                    $sheet->setCellValue("DA{$inicio}", $revirado3primeratam / 100);


                    // TERCERA TAMBOR

                    $hiloterceralavadatam       =  (float)$fila['HILOTERCERALTAM'];
                    $tramaterceralavadatam      =  (float)$fila['TRAMATERCERALTAM'];
                    $solidezterceratam          =  (float)$fila['SOLIDEZTERCERALTAM'];

                    $revirado1terceratam        =  (float)$fila['REVIRADO1TERCERALTAM'];
                    $revirado2terceratam        =  (float)$fila['REVIRADO2TERCERALTAM'];
                    $revirado3terceratam        =  (float)$fila['REVIRADO3TERCERALTAM'];


                    $sheet->setCellValue("DB{$inicio}", $hiloterceralavadatam / 100);
                    $sheet->setCellValue("DC{$inicio}", $tramaterceralavadatam / 100);
                    $sheet->setCellValue("DD{$inicio}", trim($fila["DENSIDADTERCERALTAM"]));

                    $inclinacionterceraltamb = (float)$fila["INCLINACIONTERCERALTAM"];

                    $sheet->setCellValue("DE{$inicio}", $inclinacionterceraltamb . "°");
                    $sheet->setCellValue("DF{$inicio}", trim($fila["ANCHOTOTALTERCERALTAM"]));
                    $sheet->setCellValue("DG{$inicio}", trim($fila["ANCHOUTILTERCERALTAM"]));
                    $sheet->setCellValue("DH{$inicio}", $revirado1terceratam / 100);
                    $sheet->setCellValue("DI{$inicio}", $revirado2terceratam / 100);
                    $sheet->setCellValue("DJ{$inicio}", $revirado3terceratam / 100);
                    $sheet->setCellValue("DK{$inicio}", $solidezterceratam / 100);



                    // DATOS EXTRA
                    // FECHA LIBERACION
                    $fechaliberacion  = $fila["FECHALIBERACION"] != "" ? date("d/m/Y", strtotime($fila['FECHALIBERACION'])) : "";

                    $sheet->setCellValue("DL{$inicio}",  $fechaliberacion);
                    $sheet->setCellValue("DM{$inicio}",  $fila["NOMBREUSUARIO"]);
                    $sheet->setCellValue("DN{$inicio}",  $fila["OBSERVACIONES"]);

                }

                // FONT SIZE
                $sheet->getStyle("A3:DN3")->getFont()->setSize(11);
                $sheet->getStyle("A4:DN{$inicio}")->getFont()->setSize(10);

                // CENTRAR
                $sheet->getStyle('A3:DN3')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A3:DN3')->getAlignment()->setVertical('center');

                $sheet->getStyle('A4:DN4')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A4:DN4')->getAlignment()->setVertical('center');

                // NEGRITA
                $sheet->getStyle("A3:DN4")->applyFromArray($ajustes["negrita"]);

                #region FORMATO DE CELDAS

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('N')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('O')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('W')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('X')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('Y')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AG')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AH')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AI')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AN')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AO')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AP')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AQ')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AR')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AZ')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('BA')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('BB')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('BJ')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('BU')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('BV')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CA')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CB')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CC')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO DE FECHA COLUMNA G
                    $sheet->getStyle('G')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);

                    // FORMATO DE FECHA COLUMNA DL
                    $sheet->getStyle('DL')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);


                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CI')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CJ')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CM')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CN')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CP')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CQ')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CR')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);


                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CS')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CT')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CY')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('CZ')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('DA')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    //---------------------------------------------
                    // FORMATO PORCENTAJES
                    $sheet->getStyle('DB')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('DC')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('DH')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('DI')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('DJ')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);



                #endregion



                // BORDERS
                $sheet->getStyle("A3:DN{$inicio}")->applyFromArray($ajustes["bordes"]);

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header("Content-Disposition: attachment;filename=$filename");
                header('Cache-Control: max-age=0');

                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
                $writer->save('php://output');



            }catch(Exception $e) {
                exit($e->getMessage());
            }

           

        }


    }


?>