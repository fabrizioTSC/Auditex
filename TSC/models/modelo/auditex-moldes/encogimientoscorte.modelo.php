<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ .'/../../modelo/reporteexcel.modelo.php';

// require_once '../reporteexcel.modelo.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class EncogimientosCorteModelo extends Spreadsheet
{


    function getExcelMoldes($namefile, $data)
    { 

        try{

            // INSTANCIAMOS
            $objExcelAjustes = new ExcelAjustes();

            $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
            $date = str_replace(".", "", $date);
            $filename = $namefile."_".$date.".xlsx";

            // PHP EXCEL
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // AJUSTES
            $ajustes = $objExcelAjustes->getValores();
 

            // CABECERAS
            $sheet->mergeCells('A4:A5')->setCellValue('A4','FICHA');
            $sheet->mergeCells('B4:B5')->setCellValue('B4','ESTADO MOLDAJE');
            $sheet->mergeCells('C4:C5')->setCellValue('C4','ESTADO TESTING');

            $sheet->mergeCells('D4:D5')->setCellValue('D4','FECHA EMISIÓN');
            $sheet->getColumnDimension("D")->setWidth(12);

            $sheet->mergeCells('E4:E5')->setCellValue('E4','FECHA LIBERACIÓN');
            $sheet->getColumnDimension("E")->setWidth(12);

            $sheet->mergeCells('F4:F5')->setCellValue('F4','CLIENTE');
            $sheet->getColumnDimension("F")->setWidth(39);

            $sheet->mergeCells('G4:G5')->setCellValue('G4','PROGRAMA');
            $sheet->getColumnDimension("G")->setWidth(12);

            $sheet->mergeCells('H4:H5')->setCellValue('H4','PEDIDO');
            
            $sheet->mergeCells('I4:I5')->setCellValue('I4','ESTILO CLIENTE');
            $sheet->getColumnDimension("I")->setWidth(11);


            $sheet->mergeCells('J4:J5')->setCellValue('J4','ESTILO TSC');
            $sheet->getColumnDimension("J")->setWidth(11);


            $sheet->mergeCells('K4:K5')->setCellValue('K4','ARTÍCULO');
            $sheet->getColumnDimension("K")->setWidth(29);


            $sheet->mergeCells('L4:L5')->setCellValue('L4','COLOR');
            $sheet->getColumnDimension("L")->setWidth(15);

            
            $sheet->mergeCells('M4:M5')->setCellValue('M4','PARTIDA');

            $sheet->mergeCells('N4:N5')->setCellValue('N4','CANTIDAD PROGRAMADA');
            $sheet->getColumnDimension("N")->setWidth(14);

            $sheet->mergeCells('O4:O5')->setCellValue('O4','RUTA PRENDA');
            $sheet->getColumnDimension("O")->setWidth(29);


            // ENCOGIMIENTOS TSC TEXTIL 3RA LAVADA
            $sheet->mergeCells('P4:U4')->setCellValue('P4','ENCOGIMIENTOS TSC TEXTIL 3RA LAVADA');
            $sheet->setCellValue('P5','HILO');
            $sheet->setCellValue('Q5','TRAMA');
            $sheet->setCellValue('R5','DENSIDAD');
            $sheet->getColumnDimension("R")->setWidth(10);


            $sheet->setCellValue('S5','ANCHO');
            $sheet->setCellValue('T5','°INCLINACIÓN');
            $sheet->setCellValue('U5','REVIRADO');
            $sheet->getColumnDimension("U")->setWidth(10);


            // ENCOGIMIENTOS ESTANDAR 3RA LAVADA
            $sheet->mergeCells('V4:Z4')->setCellValue('V4','ENCOGIMIENTOS ESTANDAR 3RA LAVADA');
            $sheet->setCellValue('V5','HILO');
            $sheet->setCellValue('W5','TRAMA');
            $sheet->setCellValue('X5','DENSIDAD');
            $sheet->getColumnDimension("X")->setWidth(10);

            $sheet->setCellValue('Y5','ANCHO');
            // $sheet->setCellValue('Y5','°INCLINACION');
            $sheet->setCellValue('Z5','REVIRADO');
            $sheet->getColumnDimension("Z")->setWidth(10);


            // ENCOGIMIENTOS REALES TSC 1RA LAVADA
            $sheet->mergeCells('AA4:AG4')->setCellValue('AA4','ENCOGIMIENTOS REALES TSC 1RA LAVADA');
            $sheet->setCellValue('AA5','HILO');
            $sheet->setCellValue('AB5','TRAMA');
            $sheet->setCellValue('AC5','DENSIDAD');
            $sheet->getColumnDimension("AC")->setWidth(10);

            $sheet->setCellValue('AD5','R1');
            $sheet->setCellValue('AE5','R2');
            $sheet->setCellValue('AF5','R3');
            $sheet->setCellValue('AG5','°INC');

            // ENCOGIMIENTOS REALES TSC 3RA LAVADA
            $sheet->mergeCells('AH4:AN4')->setCellValue('AH4','ENCOGIMIENTOS REALES TSC 3RA LAVADA');
            $sheet->setCellValue('AH5','HILO');
            $sheet->setCellValue('AI5','TRAMA');
            $sheet->setCellValue('AJ5','DENSIDAD');
            $sheet->getColumnDimension("AJ")->setWidth(10);


            $sheet->setCellValue('AK5','R1');
            $sheet->setCellValue('AL5','R2');
            $sheet->setCellValue('AM5','R3');
            $sheet->setCellValue('AN5','°INC');

            // COMENTARIO DE TESTING
            $sheet->mergeCells('AO4:AQ5')->setCellValue('AO4','COMENTARIO TESTING');

            // ENCOGIMIENTO DE PAÑO
            $sheet->mergeCells('AR4:AU4')->setCellValue('AR4','ENCOGIMIENTO DE PAÑO');
            $sheet->setCellValue('AR5','HILO');
            $sheet->setCellValue('AS5','TRAMA');
            $sheet->setCellValue('AT5','°INCLI B/W');
            $sheet->setCellValue('AU5','°INCLI A/W');

            // MOLDE USAR
            $sheet->mergeCells('AV4:AX4')->setCellValue('AV4','MOLDE USAR');
            $sheet->setCellValue('AV5','HILO');
            $sheet->setCellValue('AW5','TRAMA');
            $sheet->setCellValue('AX5','MANGA');

            // PRUEBA DE ENCOGIMIENTO
            $sheet->mergeCells('AY4:BD4')->setCellValue('AY4','PRUEBA DE ENCOGIMIENTO');
            $sheet->mergeCells('AY5:BA5')->setCellValue('AY5','MOLDE USADO H/T/M');
            $sheet->mergeCells('BB5:BD5')->setCellValue('BB5','OBSERVACION');

            // OBSERVACION DE LIBERACION
            $sheet->mergeCells('BE4:BG5')->setCellValue('BE4','OBSERVACIÓN DE LIBERACIÓN');

            // USUARIO LIBERADO
            $sheet->mergeCells('BH4:BI5')->setCellValue('BH4','PRUEBA DE USUARIO LIBERADO');

            // CONCESION
            $sheet->mergeCells('BJ4:BK5')->setCellValue('BJ4','CONCESION');

            // AGREGADO
            $sheet->mergeCells('BL4:BU5')->setCellValue('BL4','ENCOGIMIENTO ESTÁNDAR PRIMERA');
            $sheet->setCellValue('BL5','Hilo');
            $sheet->setCellValue('BM5','Tra.');
            $sheet->setCellValue('BN5','Den (BW).');
            $sheet->setCellValue('BO5','Den (AW).');
            $sheet->setCellValue('BP5','Anch (BW).');
            $sheet->setCellValue('BQ5','Anch (AW).');
            $sheet->setCellValue('BR5','° Inc (BW).');
            $sheet->setCellValue('BS5','° Inc (AW).');
            $sheet->setCellValue('BT5','Sol.');
            $sheet->setCellValue('BU5','Rev.');
            $sheet->mergeCells('BV4:BV5')->setCellValue('BV4','Fecha Liberación Testing');


            // PRIMERA LAVADA
            $sheet->mergeCells('BW4:CB4')->setCellValue('BW4','PRIMERA LAVADA MOLDES');
            $sheet->setCellValue('BW5','HILO');
            $sheet->setCellValue('BX5','TRAMA');
            $sheet->setCellValue('BY5','DENSIDAD');
            $sheet->setCellValue('BZ5','°INCLINACIÓN BW');
            $sheet->setCellValue('CA5','°INCLINACIÓN AW');
            $sheet->setCellValue('CB5','REVIRADO');



            // ###############
            // ### ESTILOS ###
            // ###############

            // TEXTO CENTRADO
            $sheet->getStyle('A4:CB5')->getAlignment()->setWrapText(true); 

            // BACKGROUP
            $objExcelAjustes->setBackground($spreadsheet,"A4:CB5","D9D9D9");
            $objExcelAjustes->setBackground($spreadsheet,"AV4:AX5","C4D79B");
            
            // NEGRITA
            $sheet->getStyle("A4:CB5")->applyFromArray($ajustes["negrita"]);




            // DATOS DEL CUERPO
            $inicio = 5;
            $cont = 0;

            // DATOS ARRAY
            foreach($data as $fila){

                $inicio++;
                $cont++;

                // FICHA
                $sheet->setCellValue("A{$inicio}", $fila["FICHA"]);

                // ESTADO MOLDAJE

                // SI ESTA ANULADO
                if($fila["COD_CANCE_TELA"] != "0"){
                    $sheet->setCellValue("B{$inicio}", "ANULADA POR PCP");
                }else{
                    $sheet->setCellValue("B{$inicio}", $fila["SIMBOLOMOLDAJE"]);
                }




                // ESTADO TESTING
                $sheet->setCellValue("C{$inicio}", $fila["DESCRIPCIONESTADO"]);

                // FECHA EMISION
                $fechaemision       = date("d/m/Y", strtotime($fila['FECHAEMISION']));
                $sheet->setCellValue("D{$inicio}", $fechaemision);

                // FECHA LIBERACION
                $fechaliberacion     = $fila['FECHA_LIBERACION']  != "" ? date("d/m/Y", strtotime($fila['FECHA_LIBERACION'])) : "";
                $sheet->setCellValue("E{$inicio}", $fechaliberacion);

                // CLIENTE
                $sheet->setCellValue("F{$inicio}", $fila['CLIENTE']);
                
                // PROGRAMA
                $sheet->setCellValue("G{$inicio}", $fila['PROGRAMA']);

                // PEDIDO
                $sheet->setCellValue("H{$inicio}", $fila['PEDIDO_VENDA']);

                // ESTILO CLIENTE
                $sheet->setCellValue("I{$inicio}", $fila['ESTILOCLIENTE']);

                // ESTILO TSC
                $sheet->setCellValue("J{$inicio}", $fila['ESTILOTSC']);

                // ARTICULO
                $sheet->setCellValue("K{$inicio}", $fila['ARTICULO']);

                // COLOR
                $sheet->setCellValue("L{$inicio}", $fila['COLOR']);

                // PARTIDA
                $sheet->setCellValue("M{$inicio}", $fila['PARTIDA']);

                // CANTIDAD PROGRAMADA
                $sheet->setCellValue("N{$inicio}", $fila['QTDE_PROGRAMADA']);

                // RUTA DE PRENDA
                $sheet->setCellValue("O{$inicio}", $fila['RUTA_PRENDA']);

                // ENCOGIMIENTOS 1RA LAVADA
                $revirado1primera = $fila['REVIRADO1PRIMERAL'] != "" ? (float)$fila['REVIRADO1PRIMERAL'] / 100 : "-";
                $revirado2primera = $fila['REVIRADO2PRIMERAL'] != "" ? (float)$fila['REVIRADO2PRIMERAL'] / 100 : "-";
                $revirado3primera = $fila['REVIRADO3PRIMERAL'] != "" ? (float)$fila['REVIRADO3PRIMERAL'] / 100 : "-";


                // ENCOGIMIENTOS TSC 3RA REAL
                $revirado1tercera = $fila['REVIRADO1TERCERAL'] != "" ? (float)$fila['REVIRADO1TERCERAL'] / 100 : "-";
                $revirado2tercera = $fila['REVIRADO2TERCERAL'] != "" ? (float)$fila['REVIRADO2TERCERAL'] / 100 : "-";
                $revirado3tercera = $fila['REVIRADO3TERCERAL'] != "" ? (float)$fila['REVIRADO3TERCERAL'] / 100 : "-";

                // MOLDE USAR
                $molde_usar_hilo    = $fila['MOLDE_USAR_HILO'];
                $molde_usar_trama   = $fila['MOLDE_USAR_TRAMA'];
                $molde_usar_manga   = $fila['MOLDE_USAR_MANGA']; 


                $hiloprueba     = $fila['RESULTADO_PRUEBA_HILO_USADO'];
                $tramaprueba    = $fila['RESULTADO_PRUEBA_TRAMA_USADO'];
                $mangaprueba    = $fila['RESULTADO_PRUEBA_MANGA_USADO'];

                $resultado_prueba_observacion = $fila['RESULTADO_PRUEBA_OBSERVACION'] == "" ? "Agregar" : substr($fila['RESULTADO_PRUEBA_OBSERVACION'],0,7);
                // $observacion_liberacion = $fila['OBSERVACION_LIBERACION'] == "" ? "Agregar" : substr($fila['OBSERVACION_LIBERACION'],0,12);
                $observacion_liberacion = $fila['OBSERVACION_LIBERACION'] == "" ? "Agregar" : "Mostrar";
                $pruebaencogimiento = $fila['PRUEBA_ENCOGIMIENTO'] == "" ? false : true;

                // ###########################################
                // ### ENCOGIMIENTOS TSC TEXTIL 3RA LAVADA ###
                // ###########################################



                $sheet->setCellValue("P{$inicio}", 
                    $fila['HILOTERCERATSC'] != "" ? (float)$fila['HILOTERCERATSC'] / 100 : ""
                );
                $sheet->setCellValue("Q{$inicio}", 
                    // $fila['TRAMATERCERATSC']
                    $fila['TRAMATERCERATSC'] != "" ? (float)$fila['TRAMATERCERATSC'] / 100 : ""
                );
                $sheet->setCellValue("R{$inicio}", (float)$fila['DENSIDADBEFORETSC']);
                $sheet->setCellValue("S{$inicio}", (float)$fila['ANCHOREPOSOBEFORETSC']);
                $sheet->setCellValue("T{$inicio}", $fila['INCLIACABADOSTSC']);
                $sheet->setCellValue("U{$inicio}", 
                    // $fila['REVIRADOTERCERATSC'],
                    $fila['REVIRADOTERCERATSC'] != "" ? (float)$fila['REVIRADOTERCERATSC'] / 100 : ""
                );

                // ###########################################
                // ### ENCOGIMIENTOS ESTANDAR 3RA LAVADA ###
                // ###########################################

                $sheet->setCellValue("V{$inicio}", 
                    // $fila['HILOTERCERA']
                    $fila['HILOTERCERA'] != "" ? (float)$fila['HILOTERCERA'] / 100 : ""
                );
                $sheet->setCellValue("W{$inicio}", 
                    // $fila['TRAMATERCERA']
                    $fila['TRAMATERCERA'] != "" ? (float)$fila['TRAMATERCERA'] / 100 : ""
                );
                $sheet->setCellValue("S{$inicio}", $fila['DENSIDADBEFORE']);
                $sheet->setCellValue("Y{$inicio}", (float)$fila['ANCHOREPOSOBEFORE']);

                $sheet->setCellValue("Z{$inicio}", 
                    // $fila['REVIRADOTERCERA']
                    $fila['REVIRADOTERCERA'] != "" ? (float)$fila['REVIRADOTERCERA'] / 100 : ""
                );

                // ###########################################
                // ### ENCOGIMIENTOS REALES PRIMERA ###
                // ###########################################
                $sheet->setCellValue("AA{$inicio}", 
                    ($fila['HILOPRIMERAL'] != "" && $fila['HILOPRIMERAL'] != "0") ? (float)$fila['HILOPRIMERAL'] / 100 : ""
                );
                $sheet->setCellValue("AB{$inicio}", 
                    // $fila['TRAMAPRIMERAL']
                    ($fila['TRAMAPRIMERAL'] != "" && $fila['TRAMAPRIMERAL'] != "0") ? (float)$fila['TRAMAPRIMERAL'] / 100 : ""
                );
                $sheet->setCellValue("AC{$inicio}", $fila['DENSIDADPRIMERAL']);
                $sheet->setCellValue("AD{$inicio}", $revirado1primera);
                $sheet->setCellValue("AE{$inicio}", $revirado2primera);
                $sheet->setCellValue("AF{$inicio}", $revirado3primera);
                $sheet->setCellValue("AG{$inicio}", 
                    // $fila['INCLINACIONPRIMERAL']
                    ($fila['INCLINACIONPRIMERAL'] != "" && $fila['INCLINACIONPRIMERAL'] != "0") ? (float)$fila['INCLINACIONPRIMERAL']."°" : ""

                );


                // ###########################################
                // ### ENCOGIMIENTOS REALES TERCERA ###
                // ###########################################
                $sheet->setCellValue("AH{$inicio}", 
                    // $fila['HILOTERCERAL']
                    ($fila['HILOTERCERAL'] != "" && $fila['HILOTERCERAL'] != "0") ? (float)$fila['HILOTERCERAL'] / 100 : ""

                );
                $sheet->setCellValue("AI{$inicio}", 
                    // $fila['TRAMATERCERAL']
                    ($fila['TRAMATERCERAL'] != "" && $fila['TRAMATERCERAL'] != "0") ? (float)$fila['TRAMATERCERAL'] / 100 : ""
                );
                $sheet->setCellValue("AJ{$inicio}", $fila['DENSIDADTERCERAL']);
                $sheet->setCellValue("AK{$inicio}", $revirado1tercera);
                $sheet->setCellValue("AL{$inicio}", $revirado2tercera);
                $sheet->setCellValue("AM{$inicio}", $revirado3tercera);
                $sheet->setCellValue("AN{$inicio}", 
                    // $fila['INCLINACIONTERCERAL']
                    ($fila['INCLINACIONTERCERAL'] != "" && $fila['INCLINACIONTERCERAL'] != "0") ? (float)$fila['INCLINACIONTERCERAL']."°" : ""

                );

                // #############################
                // ### COMENTARIO DE TESTING ###
                // #############################
                $sheet->mergeCells("AO{$inicio}:AQ{$inicio}")->setCellValue("AO{$inicio}", $fila['OBSERVACIONES']);

                // #############################
                // ### ENCOGIMIENTO DE PAÑO ###
                // #############################
                $sheet->setCellValue("AR{$inicio}", 
                    $fila['HILOENCOGIMIENTO'] == "" ? "-" :  $fila['HILOENCOGIMIENTO']
                );
                $sheet->setCellValue("AS{$inicio}", 
                    // $fila['TRAMAENCOGIMIENTO']
                    $fila['TRAMAENCOGIMIENTO'] == "" ? "-" :  $fila['TRAMAENCOGIMIENTO']
                );
                $sheet->setCellValue("AT{$inicio}", 
                    // $fila['INCLINACIONBEFORE']
                    $fila['INCLINACIONBEFORE'] == "" ? "-" :  $fila['INCLINACIONBEFORE']
                );
                $sheet->setCellValue("AU{$inicio}", 
                    // $fila['INCLINACIONAFTER']
                    $fila['INCLINACIONAFTER'] == "" ? "-" :  $fila['INCLINACIONAFTER']
                );


                // ##################
                // ### MOLDE USAR ###
                // ##################
                $sheet->setCellValue("AV{$inicio}", 
                    // $fila['MOLDE_USAR_HILO']
                    ($fila['MOLDE_USAR_HILO'] != "" && $fila['MOLDE_USAR_HILO'] != "0") ? (float)$fila['MOLDE_USAR_HILO'] / 100 : ""
                );
                $sheet->setCellValue("AW{$inicio}", 
                    // $fila['MOLDE_USAR_TRAMA']
                    ($fila['MOLDE_USAR_TRAMA'] != "" && $fila['MOLDE_USAR_TRAMA'] != "0") ? (float)$fila['MOLDE_USAR_TRAMA'] / 100 : ""
                );
                $sheet->setCellValue("AX{$inicio}", 
                    // $fila['MOLDE_USAR_MANGA']
                    ($fila['MOLDE_USAR_MANGA'] != "" && $fila['MOLDE_USAR_MANGA'] != "0") ? (float)$fila['MOLDE_USAR_MANGA'] / 100 : ""

                );

                // ##############################
                // ### PRUEBA DE ENCOGIMIENTO ###
                // ##############################

                $hiloprueba     = $fila['RESULTADO_PRUEBA_HILO_USADO'];
                $tramaprueba    = $fila['RESULTADO_PRUEBA_TRAMA_USADO'];
                $mangaprueba    = $fila['RESULTADO_PRUEBA_MANGA_USADO'];

                $stringprueba = $hiloprueba != "" ? $hiloprueba . "% / " . $tramaprueba . "% / " . $mangaprueba."%" : "";
                $sheet->mergeCells("AY{$inicio}:BA{$inicio}")->setCellValue("AY{$inicio}", $stringprueba);
                $sheet->mergeCells("BB{$inicio}:BD{$inicio}")->setCellValue("BB{$inicio}", $fila['RESULTADO_PRUEBA_OBSERVACION']);


                // #################################
                // ### OBSERVACION DE LIBERACION ###
                // #################################
                $sheet->mergeCells("BE{$inicio}:BG{$inicio}")->setCellValue("BE{$inicio}", $fila['OBSERVACION_LIBERACION']);

                // #############################
                // ### USUARIO DE LIBERACION ###
                // #############################
                $sheet->mergeCells("BH{$inicio}:BI{$inicio}")->setCellValue("BH{$inicio}", $fila['USUARIO_LIBERACION']);

                // CONCESION
                $concesion = $fila['CONCESION'] == "1" ? "SI" : "NO";
                // $sheet->mergeCells("BJ{$inicio}:BK{$inicio}")->setCellValue("BJ{$inicio}", $fila['CONCESION']);
                $sheet->mergeCells("BJ{$inicio}:BK{$inicio}")->setCellValue("BJ{$inicio}", $concesion);

    
                // AGREGADO
                $sheet->setCellValue("BL{$inicio}", $fila["HILOPRIMERA"]);
                $sheet->setCellValue("BM{$inicio}", $fila["TRAMAPRIMERA"]);
                $sheet->setCellValue("BN{$inicio}", $fila["DENSIDADBEFORE"]);
                $sheet->setCellValue("BO{$inicio}", $fila["DENSIDADAFTER"]);
                $sheet->setCellValue("BP{$inicio}", $fila["ANCHOREPOSOBEFORE"]);
                $sheet->setCellValue("BQ{$inicio}", $fila["ANCHOREPOSOAFTER"]);
                $sheet->setCellValue("BR{$inicio}", $fila["INCLIACABADOS"]);
                $sheet->setCellValue("BS{$inicio}", $fila["INCLILAVADO"]);
                $sheet->setCellValue("BT{$inicio}", $fila["SOLIDES"]);
                $sheet->setCellValue("BU{$inicio}", $fila["REVIRADOPRIMERA"]);

                $fechaliberaciontesting     = $fila['FECHALIBERACION_TESTING']  != "" ? date("d/m/Y", strtotime($fila['FECHALIBERACION_TESTING'])) : "";
                $sheet->setCellValue("BV{$inicio}", $fechaliberaciontesting);

                $sheet->setCellValue("BW{$inicio}", $fila["PRIMERA_LAVADA_MOLDE_HILO"]);
                $sheet->setCellValue("BX{$inicio}", $fila["PRIMERA_LAVADA_MOLDE_TRAMA"]);
                $sheet->setCellValue("BY{$inicio}", $fila["PRIMERA_LAVADA_MOLDE_DENSIDAD"]);
                $sheet->setCellValue("BZ{$inicio}", $fila["PRIMERA_LAVADA_MOLDE_INCLI_BW"]);
                $sheet->setCellValue("CA{$inicio}", $fila["PRIMERA_LAVADA_MOLDE_INCLI_AW"]);
                $sheet->setCellValue("CB{$inicio}", $fila["PRIMERA_LAVADA_MOLDE_REVIRADO"]);


            }


            #REGION TIPO DE DATOS

                // TIPO DE DATOS DE LA COLUMNA
                $sheet->getStyle('P')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('Q')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('U')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('V')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('W')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('Z')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AA')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AB')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AH')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AI')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                $sheet->getStyle('AV')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AW')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AX')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);


                $sheet->getStyle('AD')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AE')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AF')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                $sheet->getStyle('AK')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AL')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                $sheet->getStyle('AM')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);


                $sheet->getStyle('D')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);
                $sheet->getStyle('E')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);





                // CENTRAR
                // $sheet->getStyle('A4:BI5')->getAlignment()->setHorizontal('center');
                // $sheet->getStyle('A4:BI5')->getAlignment()->setVertical('center');

                $sheet->getStyle("A4:CB{$inicio}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A4:CB{$inicio}")->getAlignment()->setVertical('center');

                // BORDES
                $sheet->getStyle("A4:CB{$inicio}")->applyFromArray($ajustes["bordes"]);

            #ENDREGION

 
            $writer = new Xlsx($spreadsheet);
            
            ob_end_clean();       
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=$filename");
            header('Cache-Control: max-age=0');
            $writer->save('php://output');

            die;

        }catch(Exception $e) {
            exit($e->getMessage());
        }



    }
}
