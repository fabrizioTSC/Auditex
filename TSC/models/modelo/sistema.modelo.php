<?php

    class SistemaModelo{


        public function SaveImg($imgp,$nombre,$ruta){
            
            // $img = $parameters[0];
            $img = str_replace('data:image/png;base64,', '', $imgp);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            // $tmp_name_main= $_SESSION["user"].'_general_tmp';
            // $tmp_name_main = $nombre;

            // $fileName = $ruta.$tmp_name_main.'.png';
            $fileName = $ruta.$nombre;
            file_put_contents($fileName, $fileData);

        }


        // DISTINCT ARRAY
        function unique_multidim_array($array, $key) {
            $temp_array = array();
            $i = 0;
            $key_array = array();
           
            foreach($array as $val) {
                if (!in_array($val[$key], $key_array)) {
                    $key_array[$i] = $val[$key];
                    $temp_array[$i] = $val;
                }
                $i++;
            }
            return $temp_array;
        } 

        // OBTENEMOS NOMBRE DEL MES DE LA FECHA
        function getNameMonth($fecha){

            $mes =  date("m", strtotime($fecha));
            $mes = (float)$mes;
            $name = "";

            switch ($mes) {
                case 1: $name = "Enero"; break;
                case 2: $name = "Febrero"; break;
                case 3: $name = "Marzo"; break;
                case 4: $name = "Abril"; break;
                case 5: $name = "Mayo"; break;
                case 6: $name = "Junio"; break;
                case 7: $name = "Julio"; break;
                case 8: $name = "Agosto"; break;
                case 9: $name = "Septiembre"; break;
                case 10: $name = "Octubre"; break;
                case 11: $name = "Noviembre"; break;
                case 12: $name = "Diciembre"; break;
            }

            return $name;

        }


        function getNameMonthShort($fecha){

            $mes =  date("m", strtotime($fecha));
            $mes = (float)$mes;
            $name = "";

            switch ($mes) {
                case 1: $name = "Ene"; break;
                case 2: $name = "Feb"; break;
                case 3: $name = "Mar"; break;
                case 4: $name = "Abr"; break;
                case 5: $name = "May"; break;
                case 6: $name = "Jun"; break;
                case 7: $name = "Jul"; break;
                case 8: $name = "Ago"; break;
                case 9: $name = "Sep"; break;
                case 10: $name = "Oct"; break;
                case 11: $name = "Nov"; break;
                case 12: $name = "Dic"; break;
            }

            return $name;

        }

    }

    // FILTRO
    class SistemaModeloFilter {

        private $filtro;
        private $busqueda;


        function __construct($filtro,$busqueda) {
                $this->filtro = $filtro;
                $this->busqueda = $busqueda;

        }

        function getFiltro($item) {
                return $item[$this->busqueda] == $this->filtro;
        }
    }

    // FILTRO PARA MEDIDAS
    class MedidasFilter {

        private $codigomedida;
        private $idtalla;
        private $valor;

        // private $busqueda;


        function __construct($codigomedida,$idtalla,$valor) {
                $this->codigomedida = $codigomedida;
                $this->idtalla      = $idtalla;
                $this->valor        = $valor;
        }

        function getFiltro($item) {
            return $item["CODIGO_MEDIDA"] == $this->codigomedida && $item["IDTALLA"] == $this->idtalla && $item["VALOR"] == $this->valor;
        }
    }

    // FILTRO PARA MEDIDAS
    class MedidasFilterValor {

        private $codigomedida;
        private $idtalla;
        private $prenda;

        // private $busqueda;


        function __construct($codigomedida,$idtalla,$prenda) {
                $this->codigomedida = $codigomedida;
                $this->idtalla      = $idtalla;
                $this->prenda        = $prenda;
        }

        function getFiltroValor($item) {
            return $item["CODIGO_MEDIDA"] == $this->codigomedida && $item["IDTALLA"] == $this->idtalla && $item["NUMEROPRENDA"] == $this->prenda;
        }
    }


    // FILTRO MEDIDAS REPORTE
    class MedidasReporteFilterValor {

        private $codigomedida;
        private $idtalla;
        private $desviacion;

        // private $busqueda;


        function __construct($codigomedida,$idtalla,$desviacion) {
                $this->codigomedida = $codigomedida;
                $this->idtalla      = $idtalla;
                $this->desviacion   = $desviacion;
        }

        function getFiltroValor($item) {
            return $item["CODIGO_MEDIDA"] == $this->codigomedida && $item["IDTALLA"] == $this->idtalla && $item["VALOR"] == $this->desviacion;
        }
    }

     // FILTRO MEDIDAS REPORTE
     class MedidasFinalesReporteFilterValor {

        private $codigomedida;
        private $idtalla;
        private $numeroprenda;

        // private $busqueda;


        function __construct($codigomedida,$idtalla,$numeroprenda) {
                $this->codigomedida = $codigomedida;
                $this->idtalla      = $idtalla;
                $this->numeroprenda   = $numeroprenda;
        }

        function getFiltroValor($item) {
            return $item["CODMED"] == $this->codigomedida && $item["DESTAL"] == $this->idtalla && $item["NUMPRE"] == $this->numeroprenda;
        }
    }


?>