<?php


    require_once __DIR__ . '/../../../vendor/autoload.php';
    require_once __DIR__ .'/../../modelo/reporteexcel.modelo.php';


    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


    class AuditoriaFinalModelo extends Spreadsheet
    {

        private $letras;


        // REPORTE DE DEFECTOS (PRENDAS)
        function getReporteGeneral($name_file,$datacabecera,$datacuerpo,$label){

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

                // INSTANCIAMOS
                $objExcelAjustes = new ExcelAjustes();

                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $name_file."_".$date.".xlsx";

                $letrafinal = "";
                
                // PHP EXCEL
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // AJUSTES
                $ajustes = $objExcelAjustes->getValores();


                // FILTROS
                $sheet->setCellValue("A1",$label);
                // NEGRITA
                $sheet->getStyle("A1")->applyFromArray($ajustes["negrita"]);


                $filainicio = 3;


                // #################
                // ### CABECERAS ###
                // #################
                $cont = 0;
                foreach($datacabecera as $fila){

                    $letra = $this->letras[$cont];

                    $sheet->setCellValue($letra.$filainicio,$fila);

                    if($fila == "CANTIDAD" || $fila == "TALLER" || $fila == "AUDITOR"  || $fila == "SEDE" || $fila == "SERVICIO"){
                        $sheet->getColumnDimension($letra)->setWidth(12);
                    }

                    if($cont > 11){
                        $sheet->getColumnDimension($letra)->setWidth(20);
                    }
                    // $sheet->getColumnDimension($letra)->setWidth(9);

                    $cont++;

                    if(count($datacabecera) == $cont){
                        $letrafinal = $letra;
                    }

                }

                // CUERPO
                foreach($datacuerpo as $cuerpo){

                    $filainicio++;
                    $contletra = 0;

                    foreach($cuerpo as $newcuerpo){
                        
                        $letra = $this->letras[$contletra];
                        $sheet->setCellValue("{$letra}{$filainicio}", $newcuerpo );
                        $contletra++;

                    }


                }

                // $sheet->setCellValue('A1','FICHA');
                // $sheet->getColumnDimension("A")->setWidth(9);

                // $sheet->setCellValue('B1','PARTIDA');
                // $sheet->getColumnDimension("B")->setWidth(9);

                // $sheet->setCellValue('C1','PARTE');
                // $sheet->getColumnDimension("C")->setWidth(9);

                // $sheet->setCellValue('D1','NUM. VEZ');
                // $sheet->getColumnDimension("D")->setWidth(11);

                // $sheet->setCellValue('E1','PEDIDO');
                // $sheet->getColumnDimension("E")->setWidth(9);

                // $sheet->setCellValue('F1','COLOR');
                // $sheet->getColumnDimension("F")->setWidth(32);

                // $sheet->setCellValue('G1','CANT. FICHA');
                // $sheet->getColumnDimension("G")->setWidth(12);

                // $sheet->setCellValue('H1','FECHA');
                // $sheet->getColumnDimension("H")->setWidth(11);

                // $sheet->setCellValue('I1','USUARIO');
                // $sheet->getColumnDimension("I")->setWidth(12);

                // $sheet->setCellValue('J1','COD. DEFECTO');
                // $sheet->getColumnDimension("J")->setWidth(14);

                // $sheet->setCellValue('K1','DEFECTO');
                // $sheet->getColumnDimension("K")->setWidth(25);

                // $sheet->setCellValue('L1','CANT. DEFECTO');
                // $sheet->getColumnDimension("L")->setWidth(17);

                // $sheet->setCellValue('M1','OBSERVACIÓN');
                // $sheet->getColumnDimension("M")->setWidth(17);


                // ###############
                // ### ESTILOS ###
                // ###############

                // // TEXTO CENTRADO
                $sheet->getStyle("A3:{$letrafinal}3")->getAlignment()->setWrapText(true); 

                // BACKGROUP
                $objExcelAjustes->setBackground($spreadsheet,"A3:{$letrafinal}3","D9D9D9");
                // $objExcelAjustes->setBackground($spreadsheet,"AV4:AX5","C4D79B");
                
                // NEGRITA
                $sheet->getStyle("A3:{$letrafinal}3")->applyFromArray($ajustes["negrita"]);

             



                // // DATOS DEL CUERPO
                // $inicio = 1;

                // DETALLE
                // foreach($data as $fila){

                //     $inicio++;

                //     $fecha       = date("d/m/Y", strtotime($fila['FECHACREA']));

                //     $sheet->setCellValue("A{$inicio}", $fila["FICHA"]);
                //     $sheet->setCellValue("B{$inicio}", $fila["PARTIDA"]);
                //     $sheet->setCellValue("C{$inicio}", $fila["PARTE"]);
                //     $sheet->setCellValue("D{$inicio}", $fila["NUMVEZ"]);
                //     $sheet->setCellValue("E{$inicio}", $fila["PEDIDO"]);
                //     $sheet->setCellValue("F{$inicio}", $fila["COLOR"]);
                //     $sheet->setCellValue("G{$inicio}", $fila["CANTIDAD"]);
                //     $sheet->setCellValue("H{$inicio}", $fecha);
                //     $sheet->setCellValue("I{$inicio}", $fila["USUARIOCREA"]);
                //     $sheet->setCellValue("J{$inicio}", $fila["CODDEFAUX"]);
                //     $sheet->setCellValue("K{$inicio}", $fila["DESDEF"]);
                //     $sheet->setCellValue("L{$inicio}", $fila["CANTDEFECTOS"]);
                //     $sheet->setCellValue("M{$inicio}", $fila["OBSERVACION"]);
                //     // $sheet->setCellValue("A{$inicio}", $fila["FICHA"]);



                // }

                // FORMAT
                // $sheet->getStyle('H')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);

                $sheet->getStyle("A3:{$letrafinal}{$filainicio}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A3:{$letrafinal}{$filainicio}")->getAlignment()->setVertical('center');

                // BORDES
                $sheet->getStyle("A3:{$letrafinal}{$filainicio}")->applyFromArray($ajustes["bordes"]);


                // TIPO DE FORMATO
                $sheet->getStyle('J')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);

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