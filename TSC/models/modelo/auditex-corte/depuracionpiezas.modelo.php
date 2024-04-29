<?php

    require_once __DIR__ .'/../../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    class DepuracionPiezasModelo extends Spreadsheet{


        function getExcel($namefile,$data){

            try{

                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $namefile."_".$date.".xlsx";
    
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();


                // BORDES
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                // COLOR DE FONDO DE LAAS CABECERAS
                // $backgroundStylearray = [
                //     'fill' => [
                //         'type' =>  \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, //PHPExcel_Style_Fill::FILL_SOLID,
                //         'color' => array('argb' => 'FDFFA3')
                //     ]
                // ];
                

                // OCULTAMOS LINEAS
                $sheet->setShowGridlines(false);
                


                // // INFORMACION DE LA PARTIDA
                // $sheet->mergeCells('A1:M1');
                $sheet->setCellValue('A1', 'FICHA');
                $sheet->setCellValue('B1', 'CLIENTE');
                $sheet->setCellValue('C1', 'PEDIDO');
                $sheet->setCellValue('D1', 'ESTILO CLIENTE');
                $sheet->setCellValue('E1', 'ESTILO TSC');
                $sheet->setCellValue('F1', 'COLOR');
                $sheet->setCellValue('G1', 'PARTIDA');
                $sheet->setCellValue('H1', 'PROGRAMA');
                $sheet->setCellValue('I1', 'CANT FICHA');
                $sheet->setCellValue('J1', 'FECHA INICIO');
                $sheet->setCellValue('K1', 'FECHA FIN');
                $sheet->setCellValue('L1', 'CANT PIEZAS DEPURADAS');
                $sheet->setCellValue('M1', 'CANT PIEZAS DEPURADAS');
                $sheet->setCellValue('N1', 'KG DEPURADOS');
                $sheet->setCellValue('O1', 'PORCENTAJE');
                $sheet->setCellValue('P1', 'VALIDADO POR');

                // COLORES DE FONDO BACKGROUND
                $sheet->getStyle("A1:P1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00FF7F');
                // NEGRITA
                $sheet->getStyle("A1:P1")->applyFromArray(
                    [
                        'font' => [
                            'bold' => true,
                        ],
                    ]
                );

                // CABECERAS
                $inicio = 1;
                $cont = 0;

                // DATOS ARRAY
                foreach($data as $fila){

                    $inicio++;
                    // $cont++;


                    $peso           = (float)$fila['PESO'];
                    $fechainicio    = date("d/m/Y", strtotime($fila['FINICIO']));
                    $fechafin       = $fila['FFIN'];
                    $fechafin       = $fechafin != "" ? date("d/m/Y", strtotime($fila['FFIN'])) : ""; 

                    $porcentaje = (float)$fila['PIEZASDEP']  / (float)$fila['CANTFICHA'];
                    // $porcentaje = round($porcentaje,3);
    
                    $sheet->setCellValue("A{$inicio}", $fila["FICHA"]);
                    $sheet->setCellValue("B{$inicio}", $fila["CLIENTE"]);
                    $sheet->setCellValue("C{$inicio}", $fila["PEDIDO_VENDA"]);
                    $sheet->setCellValue("D{$inicio}", $fila["ESTILOCLIENTE"]);
                    $sheet->setCellValue("E{$inicio}", $fila["ESTILOTSC"]);
                    $sheet->setCellValue("F{$inicio}", $fila["COLOR"]);
                    $sheet->setCellValue("G{$inicio}", $fila["PARTIDA"]);
                    $sheet->setCellValue("H{$inicio}", $fila["PROGRAMA"]);
                    $sheet->setCellValue("I{$inicio}", $fila["CANTFICHA"]);
                    $sheet->setCellValue("J{$inicio}", $fechainicio);
                    $sheet->setCellValue("K{$inicio}", $fechafin);
                    $sheet->setCellValue("L{$inicio}", $fila["PIEZASDEP"]);
                    $sheet->setCellValue("M{$inicio}", $peso);
                    $sheet->setCellValue("N{$inicio}", $fila["DEFECTOS"]);
                    $sheet->setCellValue("O{$inicio}", $porcentaje);
                    $sheet->setCellValue("P{$inicio}", $fila["USUARIO"]);


                    // COLUMNA PORCENTAJE
                    $sheet->getStyle("O{$inicio}")
                        ->getNumberFormat()->setFormatCode(
                        // PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE
                        \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00
                        // \PhpOffice\PhpSpreadsheet\Style\Number_Format::FORMAT_PERCENTAGE
                    );
                    
                }

                // BORDERS
                $sheet->getStyle("A1:P{$inicio}")->applyFromArray($styleArray);
                // $sheet->getStyle("A1:N{$inicio}")->getAlignment()->setWrapText(true);
                foreach(range('A','P') as $columnID) { 
                    // $objPHPExcel->getActiveSheet()->getColumnDimension($columnID) ->setAutoSize(true); 
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);

                }

                $writer = new Xlsx($spreadsheet);
                $writer->save($filename);
                $content = file_get_contents($filename);

                header("Content-Disposition: attachment; filename=".$filename);

                unlink($filename);
                exit($content);

            }catch(Exception $e) {
                exit($e->getMessage());
            }

           

        }


    }


?>