<?php

    require_once __DIR__ .'/../../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    // use PhpOffice\PhpSpreadsheet\IOFactory;

    class CargaPackingModelo extends Spreadsheet{

        private $letras;

        function __construct(){
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
			// $this->oci = parent::getConexionOci();
        }

        function ReadExcel($file){

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $sheet = $spreadsheet->getSheet(1); 
            $highestRow = $sheet->getHighestRow(); 
            // $highestColumn = $sheet->getHighestColumn();

            // OBTENEMOS TALLAS
            $tallas = [];

            $iniciorowtallas = 7;
            $iniciocoltallas = 5;
            $valortalla = "";

            while(strtoupper($valortalla) != "BOX" ){

                $valortalla = $sheet->getCell("{$this->letras[$iniciocoltallas]}{$iniciorowtallas}")->getValue();
                if($valortalla != null && strtoupper($valortalla) != "BOX"){
                    $tallas[] = [
                        "talla"     => $valortalla,
                        "columna"   => $iniciocoltallas
                    ];
                }
                $iniciocoltallas++;
            }

            // OBTENEMOS DATOS
            $rowinicio = 9;
            $pedido = "start";
            $datosgeneral = [];

            while($pedido != ""){

                $pedido         = $sheet->getCell("C{$rowinicio}")->getValue();
                $estilo         = $sheet->getCell("D{$rowinicio}")->getValue();
                $color    = $sheet->getCell("E{$rowinicio}")->getValue();

                if($pedido != ""){
                    foreach($tallas as $tal ){

                        $valtalla = $sheet->getCell("{$this->letras[$tal['columna']]}{$rowinicio}")->getValue();
                        $valtalla = $valtalla == "" ? 0 : $valtalla;
    
                        $datosgeneral[] = 
                        [
                            "pedido" => trim($pedido),
                            "estilo" => trim($estilo),
                            "color" => trim($color),
                            "talla" => trim($tal["talla"]),
                            "cantidad" => $valtalla
    
                        ];
    
                    }
                }

               


                $rowinicio++;

            }

            $datagroup = $this->GroupData($datosgeneral);
            $datagroup = $this->GroupData($datagroup);

            return [
                "tallas" => $tallas,
                // "datosgeneral" => $datosgeneral,
                "datagroup" => $datagroup
            ];


          


        }


        public function GroupData($data) {


            $groups = array();
            $key = 0;

            foreach ($data as $item) {

                if(count($groups) == 0){

                    $groups[] = array(
                        'talla' => $item['talla'],
                        'pedido' => $item['pedido'],
                        'estilo' => $item['estilo'],
                        'color' => $item['color'],
                        'cantidad' => $item['cantidad'],
                    );

                }else{

                    // BUSCAMOS INDICE
                    $indice = false;

                    foreach ($groups as $key => $objeto) {

                        if ($objeto["talla"] == $item["talla"] && $objeto["color"] == $item["color"]) {
                            $indice = $key;
                        }

                    }

                    if ($indice === false) {

                        $groups[] = array(
                            'talla' => $item['talla'],
                            'pedido' => $item['pedido'],
                            'estilo' => $item['estilo'],
                            'color' => $item['color'],
                            'cantidad' => $item['cantidad'],
                        );


                     

                    } else {

                        $groups[$indice]['cantidad'] = $groups[$indice]['cantidad'] + $item['cantidad'];

                        // var_dump($indice);
                        // echo "| " .$item["talla"];

                        // echo "<br>";

                        
                    }


                }

             
            }
            return $groups;
        }
       


    }


?>