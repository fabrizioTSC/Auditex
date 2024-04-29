<?php

    require_once __DIR__ .'/../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    class ExcelAjustes {

        private $retornar;
        private $letras;

        // VALORES
        public function getValores(){


            $this->retornar = [

                // NEGRITA
                "negrita" => [
                    'font' => [
                        'bold' => true,
                    ],
                ],
                // BORDES
                "bordes" => [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]

            ];


            return $this->retornar;
        }

        // COLOR DE FONDO
        public function setBackground($spreadsheet,$rango,$color){

            $spreadsheet
                        ->getActiveSheet()
                        ->getStyle($rango)
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB($color);

        }

        // FUNCTION EXPORTAR GENERAL
        public function Exportar_Simple($name_file,$data,$data_columnas,$filainicio,$celdasextras = [],$formatoscolumnas = []){

            try{

                $this->letras =  [
                    "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z" ,
                     "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ",
                     "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ" ,
                     "CA", "CB", "CC", "CD", "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ" ,
                     "DA", "DB", "DC", "DD", "DE", "DF", "DG", "DH", "DI", "DJ", "DK", "DL", "DM", "DN", "DO", "DP", "DQ", "DR", "DS", "DT", "DU", "DV", "DW", "DX", "DY", "DZ" ,
                     "EA", "EB", "EC", "ED", "EE", "EF", "EG", "EH", "EI", "EJ", "EK", "EL", "EM", "EN", "EO", "EP", "EQ", "ER", "ES", "ET", "EU", "EV", "EW", "EX", "EY", "EZ" ,
                     "FA", "FB", "FC", "FD", "FE", "FF", "FG", "FH", "FI", "FJ", "FK", "FL", "FM", "FN", "FO", "FP", "FQ", "FR", "FS", "FT", "FU", "FV", "FW", "FX", "FY", "FZ" ,
                     "GA", "GB", "GC", "GD", "GE", "GF", "GG", "GH", "GI", "GJ", "GK", "GL", "GM", "GN", "GO", "GP", "GQ", "GR", "GS", "GT", "GU", "GV", "GW", "GX", "GY", "GZ" ,
                ];


                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $name_file."_".$date.".xlsx";

                
                // PHP EXCEL
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // AJUSTES
                $ajustes = $this->getValores();


                // SI QUIERE AGREGAR CELDAS  MANUALES
                if($celdasextras){


                    foreach($celdasextras as $celda){

                        $sheet->setCellValue($celda["UBICACION"],$celda["VALOR"]);

                        // BORDES
                        $sheet->getStyle($celda["UBICACION"])->applyFromArray($ajustes["bordes"]);

                        if($celda["TITULO"]){
                            $this->setBackground($spreadsheet,$celda["UBICACION"],"D9D9D9");
                            $sheet->getStyle($celda["UBICACION"])->applyFromArray($ajustes["negrita"]);
                        }


                    }

                }


                // #################
                // ### CABECERAS ###
                // #################
                $contcolumnas = 0;
                $columnainicio  = "";
                $columnafin     = "";

                foreach($data_columnas as $fila){

                    $columnastring = $this->letras[$contcolumnas].$filainicio;

                    if($contcolumnas == 0){
                        $columnainicio = $columnastring;
                    }

                    if($contcolumnas == count($data_columnas) - 1){
                        $columnafin = $columnastring;
                    }

                    $sheet->setCellValue($columnastring,$fila["TITULO"]);
                    $sheet->getColumnDimension($this->letras[$contcolumnas])->setWidth($fila["WIDTH"]);

                    $contcolumnas++;
                }

                // ###############
                // ### ESTILOS ###
                // ###############

                // TEXTO CENTRADO
                $sheet->getStyle( $columnainicio.':'.$columnafin )->getAlignment()->setWrapText(true); 

                // BACKGROUP
                $this->setBackground($spreadsheet,$columnainicio.':'.$columnafin,"D9D9D9");
                
                // NEGRITA
                $sheet->getStyle($columnainicio.':'.$columnafin)->applyFromArray($ajustes["negrita"]);

                // #############
                // ### DATOS ###
                // #############
                $inicio = $filainicio;

                 foreach($data as $filadata){

                    $inicio++;
                    $contcolumnas = 0;

                    foreach($data_columnas as $fila){

                        $columnastring = $this->letras[$contcolumnas].$inicio;
                        $sheet->setCellValue($columnastring, $filadata[  $fila["CONTENIDO"] ]);

                        $contcolumnas++;
                    }

                }

                // CENTRAR
                $sheet->getStyle($columnainicio.":".$columnastring)->getAlignment()->setHorizontal('center');
                $sheet->getStyle($columnainicio.":".$columnastring)->getAlignment()->setVertical('center');

                // BORDES
                $sheet->getStyle($columnainicio.":".$columnastring)->applyFromArray($ajustes["bordes"]);

                // FORMATOS DE COLUMNAS
                if($formatoscolumnas){

                    foreach($formatoscolumnas as $format){

                        // $sheet->getStyle('P')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);
                        $sheet->getStyle($format["COLUMNA"] )->getNumberFormat()->
                            setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3 );


                    }



                }

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

        // FUNCTION EXPORTAR GENERAL INNOVATE
        public function Exportar_Simple_Innovate($name_file,$data,$data_columnas,$filainicio,$celdasextras = [],
            $formatoscolumnasnumero = [],
            $formatoscolumnasporcentaje = []
        ){

            try{

                $this->letras =  [
                    "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z" ,
                     "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ",
                     "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ" ,
                     "CA", "CB", "CC", "CD", "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ" ,
                     "DA", "DB", "DC", "DD", "DE", "DF", "DG", "DH", "DI", "DJ", "DK", "DL", "DM", "DN", "DO", "DP", "DQ", "DR", "DS", "DT", "DU", "DV", "DW", "DX", "DY", "DZ" ,
                     "EA", "EB", "EC", "ED", "EE", "EF", "EG", "EH", "EI", "EJ", "EK", "EL", "EM", "EN", "EO", "EP", "EQ", "ER", "ES", "ET", "EU", "EV", "EW", "EX", "EY", "EZ" ,
                     "FA", "FB", "FC", "FD", "FE", "FF", "FG", "FH", "FI", "FJ", "FK", "FL", "FM", "FN", "FO", "FP", "FQ", "FR", "FS", "FT", "FU", "FV", "FW", "FX", "FY", "FZ" ,
                     "GA", "GB", "GC", "GD", "GE", "GF", "GG", "GH", "GI", "GJ", "GK", "GL", "GM", "GN", "GO", "GP", "GQ", "GR", "GS", "GT", "GU", "GV", "GW", "GX", "GY", "GZ" ,
                ];


                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $name_file."_".$date.".xlsx";

                // PHP EXCEL
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // AJUSTES
                $ajustes = $this->getValores();


                // SI QUIERE AGREGAR CELDAS  MANUALES
                if($celdasextras){


                    foreach($celdasextras as $celda){

                        // $sheet->setCellValue($celda["UBICACION"],$celda["VALOR"]);
                        $sheet->mergeCells($celda["RANGO"])->setCellValue($celda["UBICACION"],$celda["VALOR"]);

                        // BORDES
                        $sheet->getStyle($celda["RANGO"])->applyFromArray($ajustes["bordes"]);

                        if($celda["TITULO"]){
                            $this->setBackground($spreadsheet,$celda["UBICACION"],"D9D9D9");
                            $sheet->getStyle($celda["RANGO"])->applyFromArray($ajustes["negrita"]);
                            $sheet->getStyle($celda["RANGO"])->getAlignment()->setWrapText(true);

                        }


                    }

                }


                // #################
                // ### CABECERAS ###
                // #################
                $contcolumnas = 0;
                $columnainicio  = "";
                $columnafin     = "";

                foreach($data_columnas as $fila){

                    $columnastring = $this->letras[$contcolumnas].$filainicio;

                    if($contcolumnas == 0){
                        $columnainicio = $columnastring;
                    }

                    if($contcolumnas == count($data_columnas) - 1){
                        $columnafin = $columnastring;
                    }

                    $sheet->setCellValue($columnastring,$fila["TITULO"]);
                    $sheet->getColumnDimension($this->letras[$contcolumnas])->setWidth($fila["WIDTH"]);

                    $contcolumnas++;
                }

                // ###############
                // ### ESTILOS ###
                // ###############

                // TEXTO CENTRADO
                $sheet->getStyle( $columnainicio.':'.$columnafin )->getAlignment()->setWrapText(true); 

                // BACKGROUP
                $this->setBackground($spreadsheet,$columnainicio.':'.$columnafin,"D9D9D9");

                // NEGRITA
                $sheet->getStyle($columnainicio.':'.$columnafin)->applyFromArray($ajustes["negrita"]);

                // #############
                // ### DATOS ###
                // #############
                $inicio = $filainicio;

                 foreach($data as $filadata){

                    $inicio++;
                    $contcolumnas = 0;

                    foreach($data_columnas as $fila){

                        $columnastring = $this->letras[$contcolumnas].$inicio;
                        $sheet->setCellValue($columnastring, $filadata->{$fila["CONTENIDO"]});

                        $contcolumnas++;
                    }

                }

                // CENTRAR
                $sheet->getStyle($columnainicio.":".$columnastring)->getAlignment()->setHorizontal('center');
                $sheet->getStyle($columnainicio.":".$columnastring)->getAlignment()->setVertical('center');

                // BORDES
                $sheet->getStyle($columnainicio.":".$columnastring)->applyFromArray($ajustes["bordes"]);

                // FORMATOS DE COLUMNAS
                if($formatoscolumnasnumero){

                    foreach($formatoscolumnasnumero as $format){

                        // $sheet->getStyle('P')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_0);

                        if($format["TIPO"] == "PORCENTAJE"){
                            $sheet->getStyle($format["COLUMNA"])->getNumberFormat()->
                            setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE);
                        }

                        if($format["TIPO"] == "NUMERO"){
                            $sheet->getStyle($format["COLUMNA"])->getNumberFormat()->
                            setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3 );
                        }

                    }



                }

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


?>