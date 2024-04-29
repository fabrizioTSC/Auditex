<?php

    require_once __DIR__ .'/../../../vendor/autoload.php';
    require_once __DIR__ .'/../../modelo/reporteexcel.modelo.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


    class TestingIndicadorModelo extends Spreadsheet{


        function getExcel($namefile,$filtros,$data){

            try{

                // INSTANCIAMOS
                $objExcelAjustes = new ExcelAjustes();
                // AJUSTES
                $ajustes = $objExcelAjustes->getValores();

                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $namefile."_".$date.".xls";
    
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // // BORDES
                // $styleArray = [
                //     'borders' => [
                //         'allBorders' => [
                //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //             'color' => ['argb' => '000000'],
                //         ],
                //     ],
                // ];

                // // NEGRITA
                // $negrita = [
                //     'font' => [
                //         'bold' => true,
                //     ],
                // ];

                // OCULTAMOS LINEAS DE CUADRICULA
                // $sheet->setPrintGridlines(true);
                // TITULO DEL REPORTE
                $sheet->setCellValue('A1', 'Reporte de Estabilidad Dimensional');
                // FONT SIZE
                $sheet->getStyle("A1")->getFont()->setSize(15);

                // CENTRAR
                $sheet->getStyle('B5:H5')->getAlignment()->setHorizontal('center');

                // FILTROS APLICADOS
                $sheet->setCellValue('A3', $filtros);
                
                // CABECERAS
                $sheet->mergeCells('A5:A6');
                $sheet->setCellValue('A5', 'N°');

                $sheet->mergeCells('B5:B6');
                $sheet->setCellValue('B5', 'Partida');

                $sheet->mergeCells('C5:C6');
                $sheet->setCellValue('C5', 'Proveedor');

                $sheet->mergeCells('D5:D6');
                $sheet->setCellValue('D5', 'Cliente');

                $sheet->mergeCells('E5:E6');
                $sheet->setCellValue('E5', 'Programa');

                $sheet->mergeCells('F5:F6');
                $sheet->setCellValue('F5', 'Cod. Tela');

                $sheet->mergeCells('G5:G6');
                $sheet->setCellValue('G5', 'Desc. Tela');

                $sheet->mergeCells('H5:H6');
                $sheet->setCellValue('H5', 'Color');

                // ANCHO B/W
                $sheet->mergeCells('I5:L5')->setCellValue("I5","Ancho B/W");

                // ANCHO A/W
                $sheet->mergeCells('M5:P5')->setCellValue("M5","Ancho A/W");

                // DENSIDAD B/W
                $sheet->mergeCells('Q5:T5')->setCellValue("Q5","Densidad B/W");

                // DENSIDAD A/W
                $sheet->mergeCells('U5:X5')->setCellValue("U5","Densidad A/W");

                // FECHA
                $sheet->mergeCells('Y5:Y6')->setCellValue("Y5","Fecha");

                // KG
                $sheet->mergeCells('Z5:Z6')->setCellValue("Z5","KG");

                // GRADOS
                $sheet->mergeCells('AA5:AA6')->setCellValue("AA5","Gr. por desv. por m2 de std.");

                // %
                $sheet->mergeCells('AB5:AB6')->setCellValue("AB5","% de desv. por dens. std.");

                // KG AFECTADO
                $sheet->mergeCells('AC5:AC6')->setCellValue("AC5","KG. afectados +/-");

                // KG AFECTADO +
                $sheet->mergeCells('AD5:AD6')->setCellValue("AD5","KG. afectados +");

                // % ENCO. ANCHO 3RA LAVADA
                $sheet->mergeCells('AE5:AH5')->setCellValue("AE5","% ENCO. ANCHO 3RA LAVADA");

                // % ENCO. LARGO 3RA LAVADA
                $sheet->mergeCells('AI5:AL5')->setCellValue("AI5","% ENCO. LARGO 3RA LAVADA");

                // REVIRADO
                $sheet->mergeCells('AM5:AP5')->setCellValue("AM5","REVIRADO");

                // INCLINACIÓN ACABADA
                $sheet->mergeCells('AQ5:AT5')->setCellValue("AQ5","INCLINACIÓN ACABADA");

                // INCLINACIÓN LAVADA
                $sheet->mergeCells('AU5:AX5')->setCellValue("AU5","INCLINACIÓN LAVADA");

                // CABECERAS
                $sheet->setCellValue('I6', 'Ancho Aud.');
                $sheet->setCellValue('J6', 'Std. Ancho');
                $sheet->setCellValue('K6', 'LI');
                $sheet->setCellValue('L6', 'LI');

                $sheet->setCellValue('M6', 'Ancho Aud.');
                $sheet->setCellValue('N6', 'Std. Ancho');
                $sheet->setCellValue('O6', 'LI');
                $sheet->setCellValue('P6', 'LI');

                $sheet->setCellValue('Q6', 'Den Aud.');
                $sheet->setCellValue('R6', 'Estd.');
                $sheet->setCellValue('S6', 'LI');
                $sheet->setCellValue('T6', 'LI');

                $sheet->setCellValue('U6', 'Den Aud.');
                $sheet->setCellValue('V6', 'Estd.');
                $sheet->setCellValue('W6', 'LI');
                $sheet->setCellValue('X6', 'LI');

                $sheet->setCellValue('AE6', '% 3ra Lav Real');
                $sheet->setCellValue('AF6', '% Std  3ra Lav');
                $sheet->setCellValue('AG6', 'LI A3');
                $sheet->setCellValue('AH6', 'LS A3');

                $sheet->setCellValue('AI6', '% 3ra Lav Real');
                $sheet->setCellValue('AJ6', '% Std  3ra Lav');
                $sheet->setCellValue('AK6', 'LI A3');
                $sheet->setCellValue('AL6', 'LS A3');

                $sheet->setCellValue('AM6', '% 3ra Lav Real');
                $sheet->setCellValue('AN6', '% Std  3ra Lav');
                $sheet->setCellValue('AO6', 'LI A3');
                $sheet->setCellValue('AP6', 'LS A3');

                $sheet->setCellValue('AQ6', 'Inc Aca Real');
                $sheet->setCellValue('AR6', 'Std Inc Aca');
                $sheet->setCellValue('AS6', 'LI Inc Aca');
                $sheet->setCellValue('AT6', 'LS Inc Aca');

                $sheet->setCellValue('AU6', 'Inc Lav');
                $sheet->setCellValue('AV6', 'Std Inc Lav');
                $sheet->setCellValue('AW6', 'LI Inc Lav');
                $sheet->setCellValue('AX6', 'LS Inc Lav');
                

                // LETRA EN NEGRITA
                $sheet->getStyle("A5:AX6")->applyFromArray($ajustes["negrita"]);
                $sheet->getStyle("A1")->applyFromArray($ajustes["negrita"]);
                $sheet->getStyle("A3")->applyFromArray($ajustes["negrita"]);

                

                $inicio = 6;
                $cont = 0;

                // DATOS ARRAY
                foreach($data as $fila){
                    $cont++;
                    $inicio++;

                    $sheet->setCellValue("A{$inicio}", $cont);
                    $sheet->setCellValue("B{$inicio}", $fila->{"PARTIDA"});
                    $sheet->setCellValue("C{$inicio}", $fila->{"PROVEEDOR"});
                    $sheet->setCellValue("D{$inicio}", $fila->{"CLIENTE"});
                    $sheet->setCellValue("E{$inicio}", $fila->{"PROGRAMA"});
                    $sheet->setCellValue("F{$inicio}", $fila->{"CODTELA"});
                    $sheet->setCellValue("G{$inicio}", $fila->{"DESCRIPCIONTELA"});
                    $sheet->setCellValue("H{$inicio}", $fila->{"COLOR"});

                    $sheet->setCellValue("I{$inicio}", $fila->{"ANCHOBEFORE_AUDITADO"});
                    $sheet->setCellValue("J{$inicio}", trim($fila->{"ANCHOBEFORE_ESTANDAR"}));
                    $sheet->setCellValue("K{$inicio}", $fila->{"ANCHOBEFORE_LIMITEINFERIOR"});
                    $sheet->setCellValue("L{$inicio}", $fila->{"ANCHOBEFORE_LIMITESUPERIOR"});

                    $sheet->setCellValue("M{$inicio}", $fila->{"ANCHOAFTER_AUDITADO"});
                    $sheet->setCellValue("N{$inicio}", trim($fila->{"ANCHOAFTER_ESTANDAR"}));
                    $sheet->setCellValue("O{$inicio}", $fila->{"ANCHOAFTER_LIMITEINFERIOR"});
                    $sheet->setCellValue("P{$inicio}", $fila->{"ANCHOAFTER_LIMITESUPERIOR"});

                    $sheet->setCellValue("Q{$inicio}", $fila->{"DENSIDADBEFORE_AUDITADO"});
                    $sheet->setCellValue("R{$inicio}", trim($fila->{"DENSIDADBEFORE_ESTANDAR"}));
                    $sheet->setCellValue("S{$inicio}", $fila->{"DENSIDADBEFORE_LIMITEINFERIOR"});
                    $sheet->setCellValue("T{$inicio}", $fila->{"DENSIDADBEFORE_LIMITESUPERIOR"});

                    $sheet->setCellValue("U{$inicio}", $fila->{"DENSIDADAFTER_AUDITADO"});
                    $sheet->setCellValue("V{$inicio}", trim($fila->{"DENSIDADAFTER_ESTANDAR"}));
                    $sheet->setCellValue("W{$inicio}", $fila->{"DENSIDADAFTER_LIMITEINFERIOR"});
                    $sheet->setCellValue("X{$inicio}", $fila->{"DENSIDADAFTER_LIMITESUPERIOR"});

                    // FECHA
                    $fecha  = date("d/m/Y", strtotime($fila->{"FECHA"}));
                    $sheet->setCellValue("Y{$inicio}", $fecha);


                    $sheet->setCellValue("Z{$inicio}", $fila->{"KILOS"});

                    $sheet->setCellValue("AA{$inicio}", $fila->{"GRADO"});
                    $sheet->setCellValue("AB{$inicio}", $fila->{"PORCENTAJE"});
                    $sheet->setCellValue("AC{$inicio}", $fila->{"KGAFECTADO"});
                    $sheet->setCellValue("AD{$inicio}", $fila->{"KGAFECTADOMAS"});




                    $sheet->setCellValue("AE{$inicio}", ($fila->{"ANCHOTERCERA_AUDITADO"} == "" ?  0 : (float)$fila->{"ANCHOTERCERA_AUDITADO"} ) / 100 );
                    $sheet->setCellValue("AF{$inicio}", ($fila->{"ANCHOTERCERA_ESTANDAR"} == "" ?  0 : (float)$fila->{"ANCHOTERCERA_ESTANDAR"} ) / 100 );
                    $sheet->setCellValue("AG{$inicio}", ($fila->{"ANCHOTERCERA_LIMITEINFERIOR"} == "" ?  0 : (float)$fila->{"ANCHOTERCERA_LIMITEINFERIOR"} ) / 100 );
                    $sheet->setCellValue("AH{$inicio}", ($fila->{"ANCHOTERCERA_LIMITESUPERIOR"} == "" ?  0 : (float)$fila->{"ANCHOTERCERA_LIMITESUPERIOR"} ) / 100 );

                    $sheet->setCellValue("AI{$inicio}", ($fila->{"HILOTERCERA_AUDITADO"} == "" ?  0 : (float)$fila->{"HILOTERCERA_AUDITADO"} ) / 100 );
                    $sheet->setCellValue("AJ{$inicio}", ($fila->{"HILOTERCERA_ESTANDAR"} == "" ?  0 : (float)$fila->{"HILOTERCERA_ESTANDAR"} ) / 100 );
                    $sheet->setCellValue("AK{$inicio}", ($fila->{"HILOTERCERA_LIMITEINFERIOR"} == "" ?  0 : (float)$fila->{"HILOTERCERA_LIMITEINFERIOR"} ) / 100 );
                    $sheet->setCellValue("AL{$inicio}", ($fila->{"HILOTERCERA_LIMITESUPERIOR"} == "" ?  0 : (float)$fila->{"HILOTERCERA_LIMITESUPERIOR"} ) / 100 );

                    $sheet->setCellValue("AM{$inicio}", ($fila->{"REVIRADOTERCERA_AUDITADO"} == "" ?  0 : (float)$fila->{"REVIRADOTERCERA_AUDITADO"} ) / 100 );
                    $sheet->setCellValue("AN{$inicio}", ($fila->{"REVIRADOTERCERA_ESTANDAR"} == "" ?  0 : (float)$fila->{"REVIRADOTERCERA_ESTANDAR"} ) / 100);
                    $sheet->setCellValue("AO{$inicio}", ($fila->{"REVIRADOTERCERA_LIMITEINFERIOR"} == "" ?  0 : (float)$fila->{"REVIRADOTERCERA_LIMITEINFERIOR"} ) / 100 );
                    $sheet->setCellValue("AP{$inicio}", ($fila->{"REVIRADOTERCERA_LIMITESUPERIOR"} == "" ?  0 : (float)$fila->{"REVIRADOTERCERA_LIMITESUPERIOR"} ) / 100 );

                    $sheet->setCellValue("AQ{$inicio}", $fila->{"INCLIACABADOS_AUDITADO"} == "" ?  $fila->{"INCLIACABADOS_AUDITADO"} : $fila->{"INCLIACABADOS_AUDITADO"} ."°");
                    $sheet->setCellValue("AR{$inicio}", $fila->{"INCLIACABADOS_ESTANDAR"} == "" ?  $fila->{"INCLIACABADOS_ESTANDAR"} : $fila->{"INCLIACABADOS_ESTANDAR"} ."°");
                    $sheet->setCellValue("AS{$inicio}", $fila->{"INCLIACABADOS_LIMITEINFERIOR"} == "" ?  $fila->{"INCLIACABADOS_LIMITEINFERIOR"} : $fila->{"INCLIACABADOS_LIMITEINFERIOR"} ."°");
                    $sheet->setCellValue("AT{$inicio}", $fila->{"INCLIACABADOS_LIMITESUPERIOR"} == "" ?  $fila->{"INCLIACABADOS_LIMITESUPERIOR"} : $fila->{"INCLIACABADOS_LIMITESUPERIOR"} ."°");

                    $sheet->setCellValue("AU{$inicio}", $fila->{"INCLILAVADOS_AUDITADO"} == "" ?  $fila->{"INCLILAVADOS_AUDITADO"} : $fila->{"INCLILAVADOS_AUDITADO"} ."°");
                    $sheet->setCellValue("AV{$inicio}", $fila->{"INCLILAVADOS_ESTANDAR"} == "" ?  $fila->{"INCLILAVADOS_ESTANDAR"} : $fila->{"INCLILAVADOS_ESTANDAR"} ."°");
                    $sheet->setCellValue("AW{$inicio}", $fila->{"INCLILAVADOS_LIMITEINFERIOR"} == "" ?  $fila->{"INCLILAVADOS_LIMITEINFERIOR"} : $fila->{"INCLILAVADOS_LIMITEINFERIOR"} ."°");
                    $sheet->setCellValue("AX{$inicio}", $fila->{"INCLILAVADOS_LIMITESUPERIOR"} == "" ?  $fila->{"INCLILAVADOS_LIMITESUPERIOR"} : $fila->{"INCLILAVADOS_LIMITESUPERIOR"} ."°");

                }

        

                // ANCHO DE COLUMNA AUTOMATICO
                foreach(range('B','H') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                #region  CONFIGURACION DE PAGINA

                    // CENTRAR
                    $sheet->getStyle('A5:AX6')->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('A5:AX6')->getAlignment()->setVertical('center');
                    // BORDERS
                    $sheet->getStyle("A5:AX{$inicio}")->applyFromArray($ajustes["bordes"]);

                    // COLOR DE FONDO
                    $objExcelAjustes->setBackground($spreadsheet,"A5:AX6","C6E0B4");

                    // ALTO DE COLUMNA
                    $sheet->getRowDimension(6)->setRowHeight(45);
                    $sheet->getStyle('A5:AX6')->getAlignment()->setWrapText(true); 

                    // FORMATO PORCENTAJES
                    $sheet->getStyle('AB')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );

                    // FORMATO NUMEROS
                    $sheet->getStyle('AC')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);

                    // FORMATO NUMEROS
                    $sheet->getStyle('AD')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);


                    // FORMATO NUMEROS
                    $sheet->getStyle('AE')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AF')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AG')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AH')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AI')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AJ')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AK')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AL')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AM')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AN')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AO')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );
                    $sheet->getStyle('AP')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0 );





                #endregion
                

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