<?php


    require_once __DIR__ . '/../../../vendor/autoload.php';
    require_once __DIR__ .'/../../modelo/reporteexcel.modelo.php';


    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


    class LavanderiaModelo extends Spreadsheet
    {

        // REPORTE DE DEFECTOS (PRENDAS)
        function getReporteDefectos_Prendas($name_file,$data){

            try{

                // INSTANCIAMOS
                $objExcelAjustes = new ExcelAjustes();

                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $name_file."_".$date.".xlsx";

                
                // PHP EXCEL
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // AJUSTES
                $ajustes = $objExcelAjustes->getValores();

                // #################
                // ### CABECERAS ###
                // #################

                $sheet->setCellValue('A1','FICHA');
                $sheet->getColumnDimension("A")->setWidth(9);

                $sheet->setCellValue('B1','PARTIDA');
                $sheet->getColumnDimension("B")->setWidth(9);

                $sheet->setCellValue('C1','PARTE');
                $sheet->getColumnDimension("C")->setWidth(9);

                $sheet->setCellValue('D1','NUM. VEZ');
                $sheet->getColumnDimension("D")->setWidth(11);

                $sheet->setCellValue('E1','PEDIDO');
                $sheet->getColumnDimension("E")->setWidth(9);

                $sheet->setCellValue('F1','COLOR');
                $sheet->getColumnDimension("F")->setWidth(32);

                $sheet->setCellValue('G1','CANT. FICHA');
                $sheet->getColumnDimension("G")->setWidth(12);

                $sheet->setCellValue('H1','FECHA');
                $sheet->getColumnDimension("H")->setWidth(11);

                $sheet->setCellValue('I1','USUARIO');
                $sheet->getColumnDimension("I")->setWidth(12);

                $sheet->setCellValue('J1','COD. DEFECTO');
                $sheet->getColumnDimension("J")->setWidth(14);

                $sheet->setCellValue('K1','DEFECTO');
                $sheet->getColumnDimension("K")->setWidth(25);

                $sheet->setCellValue('L1','CANT. DEFECTO');
                $sheet->getColumnDimension("L")->setWidth(17);

                $sheet->setCellValue('M1','OBSERVACIÓN');
                $sheet->getColumnDimension("M")->setWidth(17);


                // ###############
                // ### ESTILOS ###
                // ###############

                // TEXTO CENTRADO
                $sheet->getStyle('A1:M1')->getAlignment()->setWrapText(true); 

                // BACKGROUP
                $objExcelAjustes->setBackground($spreadsheet,"A1:M1","D9D9D9");
                // $objExcelAjustes->setBackground($spreadsheet,"AV4:AX5","C4D79B");
                
                // NEGRITA
                $sheet->getStyle("A1:M1")->applyFromArray($ajustes["negrita"]);


                // DATOS DEL CUERPO
                $inicio = 1;

                // DETALLE
                foreach($data as $fila){

                    $inicio++;

                    $fecha       = date("d/m/Y", strtotime($fila['FECHACREA']));

                    $sheet->setCellValue("A{$inicio}", $fila["FICHA"]);
                    $sheet->setCellValue("B{$inicio}", $fila["PARTIDA"]);
                    $sheet->setCellValue("C{$inicio}", $fila["PARTE"]);
                    $sheet->setCellValue("D{$inicio}", $fila["NUMVEZ"]);
                    $sheet->setCellValue("E{$inicio}", $fila["PEDIDO"]);
                    $sheet->setCellValue("F{$inicio}", $fila["COLOR"]);
                    $sheet->setCellValue("G{$inicio}", $fila["CANTIDAD"]);
                    $sheet->setCellValue("H{$inicio}", $fecha);
                    $sheet->setCellValue("I{$inicio}", $fila["USUARIOCREA"]);
                    $sheet->setCellValue("J{$inicio}", $fila["CODDEFAUX"]);
                    $sheet->setCellValue("K{$inicio}", $fila["DESDEF"]);
                    $sheet->setCellValue("L{$inicio}", $fila["CANTDEFECTOS"]);
                    $sheet->setCellValue("M{$inicio}", $fila["OBSERVACION"]);
                    // $sheet->setCellValue("A{$inicio}", $fila["FICHA"]);



                }

                // FORMAT
                $sheet->getStyle('H')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);

                $sheet->getStyle("A1:M{$inicio}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A1:M{$inicio}")->getAlignment()->setVertical('center');

                // BORDES
                $sheet->getStyle("A1:M{$inicio}")->applyFromArray($ajustes["bordes"]);


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

        // REPORTE DE AUDITOR (PRENDAS)
        function getReporteAuditor_Prendas($name_file,$data){

            try{

                // INSTANCIAMOS
                $objExcelAjustes = new ExcelAjustes();

                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $name_file."_".$date.".xlsx";

                
                // PHP EXCEL
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // AJUSTES
                $ajustes = $objExcelAjustes->getValores();

                // #################
                // ### CABECERAS ###
                // #################

                $sheet->setCellValue('A1','USUARIO');
                $sheet->getColumnDimension("A")->setWidth(12);

                $sheet->setCellValue('B1','FECHA');
                $sheet->getColumnDimension("B")->setWidth(10);

                $sheet->setCellValue('C1','AUDITORIA');
                $sheet->getColumnDimension("C")->setWidth(11);

                $sheet->setCellValue('D1','CANTIDAD APROBADA');
                $sheet->getColumnDimension("D")->setWidth(13);

                $sheet->setCellValue('E1','CANTIDAD RECHAZADA');
                $sheet->getColumnDimension("E")->setWidth(13);

                $sheet->setCellValue('F1','CANTIDAD PRENDAS');
                $sheet->getColumnDimension("F")->setWidth(13);

                $sheet->setCellValue('G1','CANTIDAD AUDITADAS');
                $sheet->getColumnDimension("G")->setWidth(13);

                $sheet->setCellValue('H1','CANTIDAD DEFECTOS');
                $sheet->getColumnDimension("H")->setWidth(13);



                // ###############
                // ### ESTILOS ###
                // ###############

                // TEXTO CENTRADO
                $sheet->getStyle('A1:H1')->getAlignment()->setWrapText(true); 

                // BACKGROUP
                $objExcelAjustes->setBackground($spreadsheet,"A1:H1","D9D9D9");
                // $objExcelAjustes->setBackground($spreadsheet,"AV4:AX5","C4D79B");
                
                // NEGRITA
                $sheet->getStyle("A1:H1")->applyFromArray($ajustes["negrita"]);


                // DATOS DEL CUERPO
                $inicio = 1;

                // DETALLE
                foreach($data as $fila){

                    $inicio++;

                    $fecha       = date("d/m/Y", strtotime($fila['FECHA']));

                    $sheet->setCellValue("A{$inicio}", $fila["USUARIOCIERRE"]);
                    $sheet->setCellValue("B{$inicio}", $fecha);
                    $sheet->setCellValue("C{$inicio}", $fila["AUDITORIAS"]);
                    $sheet->setCellValue("D{$inicio}", $fila["APROBADOS"]);
                    $sheet->setCellValue("E{$inicio}", $fila["RECHAZADOS"]);
                    $sheet->setCellValue("F{$inicio}", $fila["PRENDAS"]);
                    $sheet->setCellValue("G{$inicio}", $fila["AUDITADAS"]);
                    $sheet->setCellValue("H{$inicio}", $fila["CANTDEFECTOS"]);

                }

                // FORMAT
                $sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);

                $sheet->getStyle("A1:H{$inicio}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A1:H{$inicio}")->getAlignment()->setVertical('center');

                // BORDES
                $sheet->getStyle("A1:H{$inicio}")->applyFromArray($ajustes["bordes"]);


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

        function getReporteGeneralPrendas($name_file,$data){

            try{

                // INSTANCIAMOS
                $objExcelAjustes = new ExcelAjustes();

                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $name_file."_".$date.".xlsx";

                
                // PHP EXCEL
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // AJUSTES
                $ajustes = $objExcelAjustes->getValores();

                // #################
                // ### CABECERAS ###
                // #################

                $sheet->setCellValue('A1','FICHA');
                $sheet->getColumnDimension("A")->setWidth(12);

                $sheet->setCellValue('B1','CLIENTE');
                $sheet->getColumnDimension("B")->setWidth(10);

                $sheet->setCellValue('C1','PEDIDO');
                $sheet->getColumnDimension("C")->setWidth(10);

                $sheet->setCellValue('D1','EST. CLIENTE');
                $sheet->getColumnDimension("D")->setWidth(13);

                $sheet->setCellValue('E1','EST. TSC');
                $sheet->getColumnDimension("E")->setWidth(13);

                $sheet->setCellValue('F1','PARTIDA');
                $sheet->getColumnDimension("F")->setWidth(13);

                $sheet->setCellValue('G1','COLOR');
                $sheet->getColumnDimension("G")->setWidth(14);

                $sheet->setCellValue('H1','PARTE');
                $sheet->getColumnDimension("H")->setWidth(8);

                $sheet->setCellValue('I1','VEZ');
                $sheet->getColumnDimension("I")->setWidth(8);

                $sheet->setCellValue('J1','USUARIO');
                $sheet->getColumnDimension("J")->setWidth(11);

                $sheet->setCellValue('K1','FECHA');
                $sheet->getColumnDimension("K")->setWidth(11);

                $sheet->setCellValue('L1','CANT FICHA');
                $sheet->getColumnDimension("L")->setWidth(9);

                $sheet->setCellValue('M1','CANT PARTE');
                $sheet->getColumnDimension("M")->setWidth(12);

                $sheet->setCellValue('N1','CANT MUESTRA');
                $sheet->getColumnDimension("N")->setWidth(13);

                $sheet->setCellValue('O1','RESULTADO');
                $sheet->getColumnDimension("O")->setWidth(13);

                $sheet->setCellValue('P1','DEFECTOS');
                $sheet->getColumnDimension("P")->setWidth(28);

                $sheet->setCellValue('Q1','CANT. DEFECTOS');
                $sheet->getColumnDimension("Q")->setWidth(12);

                $sheet->setCellValue('R1','CANT MAX DEFECTOS');
                $sheet->getColumnDimension("R")->setWidth(12);

                $sheet->setCellValue('S1','COD DEFECTOS');
                $sheet->getColumnDimension("S")->setWidth(12);

                $sheet->setCellValue('T1','TIPO SETVICIO');
                $sheet->getColumnDimension("T")->setWidth(13);

                $sheet->setCellValue('U1','MAQUINA/TALLER');
                $sheet->getColumnDimension("U")->setWidth(25);

                $sheet->setCellValue('V1','TALLER DE COSTURA');
                $sheet->getColumnDimension("V")->setWidth(30);


                // ###############
                // ### ESTILOS ###
                // ###############

                // TEXTO CENTRADO
                $sheet->getStyle('A1:V1')->getAlignment()->setWrapText(true); 

                // BACKGROUP
                $objExcelAjustes->setBackground($spreadsheet,"A1:V1","D9D9D9");
                // $objExcelAjustes->setBackground($spreadsheet,"AV4:AX5","C4D79B");
                
                // NEGRITA
                $sheet->getStyle("A1:V1")->applyFromArray($ajustes["negrita"]);


                // DATOS DEL CUERPO
                $inicio = 1;

                // DETALLE
                foreach($data as $fila){

                    $inicio++;

                    $fechacierre       = date("d/m/Y", strtotime($fila['FECHACIERRE']));

                    $sheet->setCellValue("A{$inicio}", $fila["CODFIC"]);
                    $sheet->setCellValue("B{$inicio}", $fila["DESCLI"]);
                    $sheet->setCellValue("C{$inicio}", $fila["PEDIDO"]);
                    $sheet->setCellValue("D{$inicio}", $fila["ESTCLI"]);
                    $sheet->setCellValue("E{$inicio}", $fila["ESTTSC"]);
                    $sheet->setCellValue("F{$inicio}", $fila["PARTIDA"]);
                    $sheet->setCellValue("G{$inicio}", $fila["COLOR"]);
                    $sheet->setCellValue("H{$inicio}", $fila["PARTE"]);
                    $sheet->setCellValue("I{$inicio}", $fila["NUMVEZ"]);
                    $sheet->setCellValue("J{$inicio}", $fila["USUARIOCIERRE"]);
                    $sheet->setCellValue("K{$inicio}", $fechacierre);
                    $sheet->setCellValue("L{$inicio}", $fila["CANTOTALFICHA"]);
                    $sheet->setCellValue("M{$inicio}", $fila["CANTIDADPARTIDA"]);
                    $sheet->setCellValue("N{$inicio}", $fila["SAMPLESIZE"]);
                    $sheet->setCellValue("O{$inicio}", $fila["RESULTADOFINAL"]);
                    $sheet->setCellValue("P{$inicio}", $fila["DES_DEFECTOS"]);
                    $sheet->setCellValue("Q{$inicio}", $fila["CAN_DEFECTOS"]);
                    $sheet->setCellValue("R{$inicio}", $fila["RECHAZADO"]);
                    $sheet->setCellValue("S{$inicio}", $fila["COD_DEFECTOS"]);
                    $sheet->setCellValue("T{$inicio}", $fila["TIPO"]);
                    $sheet->setCellValue("U{$inicio}", $fila["MAQUINATALLER"]);
                    $sheet->setCellValue("V{$inicio}", $fila["TALLERCOSTURA"]);



                }

                // FORMAT
                $sheet->getStyle('K')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD);

                $sheet->getStyle("A1:V{$inicio}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A1:V{$inicio}")->getAlignment()->setVertical('center');

                // BORDES
                $sheet->getStyle("A1:V{$inicio}")->applyFromArray($ajustes["bordes"]);


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

        // REPORTE INDICADOR (PRENDAS)
        function getReporteIndicador_Prendas($name_file,$data){

            try{

                // INSTANCIAMOS
                $objExcelAjustes = new ExcelAjustes();

                $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
                $date = str_replace(".", "", $date);
                $filename = $name_file."_".$date.".xlsx";

                
                // PHP EXCEL
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // AJUSTES
                $ajustes = $objExcelAjustes->getValores();

                // #################
                // ### CABECERAS ###
                // #################

                $sheet->setCellValue('A1','DEFECTO');
                $sheet->getColumnDimension("A")->setWidth(20);

                $sheet->setCellValue('B1','MUESTRA');
                $sheet->getColumnDimension("B")->setWidth(10);

                $sheet->setCellValue('C1','TOTAL');
                $sheet->getColumnDimension("C")->setWidth(10);

                $sheet->setCellValue('D1','%');
                $sheet->getColumnDimension("D")->setWidth(10);


                // ###############
                // ### ESTILOS ###
                // ###############

                // TEXTO CENTRADO
                $sheet->getStyle('A1:D1')->getAlignment()->setWrapText(true); 

                // BACKGROUP
                $objExcelAjustes->setBackground($spreadsheet,"A1:D1","D9D9D9");
                // $objExcelAjustes->setBackground($spreadsheet,"AV4:AX5","C4D79B");
                
                // NEGRITA
                $sheet->getStyle("A1:D1")->applyFromArray($ajustes["negrita"]);


                // DATOS DEL CUERPO
                $inicio = 1;

                // DETALLE
                foreach($data as $fila){

                    $inicio++;

                    // $fecha       = date("d/m/Y", strtotime($fila['FECHA']));

                    $sheet->setCellValue("A{$inicio}", $fila->{"defecto"});
                    $sheet->setCellValue("B{$inicio}", $fila->{"muestratotal"});
                    $sheet->setCellValue("C{$inicio}", $fila->{"cantidad"});

                    $sheet->setCellValue("D{$inicio}", $fila->{"cantidad"} / $fila->{"muestratotal"} );
                    // $sheet->setCellValue("E{$inicio}", $fila["RECHAZADOS"]);
                    // $sheet->setCellValue("F{$inicio}", $fila["PRENDAS"]);
                    // $sheet->setCellValue("G{$inicio}", $fila["AUDITADAS"]);
                    // $sheet->setCellValue("H{$inicio}", $fila["CANTDEFECTOS"]);

                }

                // FORMAT
                $sheet->getStyle('D')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);

                $sheet->getStyle("A1:D{$inicio}")->getAlignment()->setHorizontal('center');
                $sheet->getStyle("A1:D{$inicio}")->getAlignment()->setVertical('center');

                // BORDES
                $sheet->getStyle("A1:D{$inicio}")->applyFromArray($ajustes["bordes"]);


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