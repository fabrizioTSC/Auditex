<?php
    // ini_set('max_execution_time', '300');
    ini_set('max_execution_time', '0');
    setlocale(LC_NUMERIC, 'en_US.UTF-8');
    require_once __DIR__.'/../../core/model.master.php';
    // require_once

    class CoreModelo extends ModelMaster{
        private $pdo;
        private $oci;
        private $pdosql;
        private $pdosqlsige;

        function __construct($basedatos = "bd_genesys",$basedatossige = "sige_tsc"){
            $this->pdo          = parent::getConexion();
            $this->oci          = parent::getConexionOci();
            $this->pdosql       = parent::getConexionSQL($basedatos);
            $this->pdosqlsige   = parent::getConexionSQLSIGE($basedatossige);
            $this->pdosqltest = $this->getConexionSQLTest();
        }


        // OBTENER
        function get($spu,$parameters){

            // ARRAY CON PARAMENTROS
            $arrayg = $this->getCantParametersOci($parameters);
            // var_dump($arrayg);
            $stringparametros = $arrayg["paramtexto"];
            $arrayparametros = $arrayg["param"];


            $cursor = oci_new_cursor($this->oci); //CREANDO EL CURSOR
            // $sql = "begin {$spu}({$stringparametros},:rc); end;";
            $sql = count($parameters) > 0 ?  "begin {$spu}({$stringparametros},:rc); end;" : "begin {$spu}(:rc); end;";


            $comando = oci_parse($this->oci, $sql);
            //INSERTANDO PARAMETROS
            for($i = 0; $i < count($parameters);$i++){
                oci_bind_by_name($comando,$arrayparametros[$i],$parameters[$i]);
            }
            oci_bind_by_name($comando,':rc',            $cursor,-1,OCI_B_CURSOR);


            oci_execute($comando);  //EJECUTANDO PROCEDIMIENTO
            oci_execute($cursor);   //EJECUTANDO CURSOR
            oci_close($this->oci);// CERRANDO CONEXION

            //RETORNANDO EL VALOR EN UN ARRAY
            return oci_fetch_assoc($cursor);

        }
       
        public function getSQL($spu, $parameters) {
            try {
                // Construir la consulta SQL para ejecutar el procedimiento almacenado
                $placeholders = implode(',', array_fill(0, count($parameters), '?'));
                $sql = "EXEC $spu $placeholders";
       
                // Preparar el comando PDO
                $comando = $this->pdosqltest->prepare($sql);
       
                // Vincular los parámetros al comando utilizando un contador
                $counter = 1;
                foreach ($parameters as $value) {
                    $comando->bindValue($counter, $value !== '' ? $value : null, is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                    $counter++;
                }
       
                // Ejecutar el comando
                $comando->execute();
       
                // Inicializar arreglo para resultados
                $results = [];
       
                // Procesar múltiples conjuntos de resultados si están disponibles
                do {
                    // Verificar si hay columnas en el conjunto de resultados
                    if ($comando->columnCount() > 0) {
                        $result = $comando->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($result)) {
                            // Convertir todos los valores numéricos a float
                            array_walk_recursive($result, function(&$item) {
                                if (is_numeric($item) && !is_null($item)) {
                                    $item = (float)$item;
                                }
                            });
                            $results[] = $result;
                        }
                    }
                } while ($comando->nextRowset()); // Intentar avanzar al siguiente conjunto de resultados
       
                // Verificar si se encontraron resultados
                if (empty($results)) {
                    return false; // Retorna false cuando no hay resultados
                }
       
                // Aplanar el array si solo hay un conjunto de resultados
                $flattenedResults = count($results) == 1 ? reset($results) : $results;
       
                // Devolver un solo objeto si hay un único conjunto de resultados con una sola fila
                 if (count($flattenedResults) == 1 && is_array($flattenedResults[0])) {
                    return $flattenedResults[0];
                } else {
                    return $flattenedResults;
                 }
       
            } catch (PDOException $e) {
                // Manejo del error
                error_log("PDOException in getSQL: " . $e->getMessage());
                return ["error" => $e->getMessage()];
            }
        }


        public function getAllSQL($spu, $parameters) {
            try {
                // Construir la consulta SQL para ejecutar el procedimiento almacenado
                $placeholders = implode(',', array_fill(0, count($parameters), '?'));
                $sql = "EXEC $spu $placeholders";
       
                // Preparar el comando PDO
                $comando = $this->pdosqltest->prepare($sql);
       
                // Vincular los parámetros al comando utilizando un contador
                $counter = 1;
                foreach ($parameters as $value) {
                    $comando->bindValue($counter, $value !== '' ? $value : null, is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                    $counter++;
                }
       
                // Ejecutar el comando
                $comando->execute();
       
                // Inicializar arreglo para resultados
                $results = [];
       
                // Procesar múltiples conjuntos de resultados si están disponibles
                do {
                    // Verificar si hay columnas en el conjunto de resultados
                    if ($comando->columnCount() > 0) {
                        $result = $comando->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($result)) {
                            // Convertir todos los valores numéricos a float
                            array_walk_recursive($result, function(&$item) {
                                if (is_numeric($item) && !is_null($item)) {
                                    $item = (float)$item;
                                }
                            });
                            $results[] = $result;
                        }
                    }
                } while ($comando->nextRowset()); // Intentar avanzar al siguiente conjunto de resultados
       
                // Verificar si se encontraron resultados
                if (empty($results)) {
                    return false; // Retorna false cuando no hay resultados
                }
       
                // Aplanar el array si solo hay un conjunto de resultados
                $flattenedResults = count($results) == 1 ? reset($results) : $results;
                return $flattenedResults;
       
            } catch (PDOException $e) {
                // Manejo del error
                error_log("PDOException in getSQL: " . $e->getMessage());
                return ["error" => $e->getMessage()];
            }
        }


        // OBTENER SQL SIGE
        function getSQLSIGE($spu,$parameters){
            // CANTIDAD DE PARAMETROS
            $cant = $this->getCantParameters($parameters);
            // REEMPLAZAMOS VACIOS POR NULOS
            $array = $this->ReplaceEmpty($parameters);

            $sql = count($parameters) > 0 ?  "exec {$spu} {$cant} " : "exec {$spu} ";

            $comando = $this->pdosqlsige->prepare($sql);
            $comando->execute(
                $array
            );

            return $comando->fetch(PDO::FETCH_OBJ);
        }

        // LISTAR
        function getAll($spu,$parameters){
                // ARRAY CON PARAMENTROS
                $arrayg = $this->getCantParametersOci($parameters);
                // var_dump($arrayg);
                $stringparametros = $arrayg["paramtexto"];
                $arrayparametros = $arrayg["param"];


                $cursor = oci_new_cursor($this->oci); //CREANDO EL CURSOR
                $sql = count($parameters) > 0 ?  "begin {$spu}({$stringparametros},:rc); end;" : "begin {$spu}(:rc); end;";

                $comando = oci_parse($this->oci, $sql);
                //INSERTANDO PARAMETROS
                for($i = 0; $i < count($parameters);$i++){
                    oci_bind_by_name($comando,$arrayparametros[$i],$parameters[$i]);
                }
                oci_bind_by_name($comando,':rc',            $cursor,-1,OCI_B_CURSOR);

                oci_execute($comando);  //EJECUTANDO PROCEDIMIENTO
                oci_execute($cursor);   //EJECUTANDO CURSOR
                oci_close($this->oci);// CERRANDO CONEXION


                //RETORNANDO EL VALOR EN UN ARRAY
                // return oci_fetch_assoc($cursor);
                oci_fetch_all($cursor, $objeto, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                return $objeto;
        }

        function getAllSQL_Indicador($spu, $parametros) {
            // Parámetros de conexión
            $serverName = "172.16.84.221";
            $database = "SIGE_AUDITEX_PRUEBA_2";
            $username = "sa";
            $password = "Developer2024$";
   
            try {
                // Conexión con la base de datos
                $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
                // Construir la cadena de parámetros
                $params = '';
                foreach ($parametros as $key => $value) {
                    $params .= "@" . $key . " = :" . $key . ", ";
                }
                $params = rtrim($params, ', ');
       
                // Preparar la llamada al procedimiento almacenado con todos los parámetros
                $sql = "EXEC " . $spu . " " . $params;
                $stmt = $conn->prepare($sql);
       
                // Vincular los parámetros
                foreach ($parametros as $key => &$value) {
                    $stmt->bindParam(':' . $key, $value);
                }
       
                // Ejecutar el procedimiento almacenado
                $stmt->execute();
       
                // Intentar obtener el primer conjunto de resultados
                do {
                    if ($stmt->columnCount() > 0) {
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (!empty($results)) {
                            return $results;
                        }
                    }
                } while ($stmt->nextRowset());
       
                if (!isset($results) || empty($results)) {
                    return array();
                }
       
            } catch(PDOException $e) {
                return array("error" => "Error de conexión: " . $e->getMessage());
            }
        }


        // REGISTRAR - MODIFICAR - ELIMINAR
        function setAll($spu,$parameters,$mensaje){


            $response = array();


            try{


                // CANTIDAD DE PARAMETROS
                $cant = $this->getCantParameters($parameters);
                // REEMPLAZAMOS VACIOS POR NULOS
                $array = $this->ReplaceEmpty($parameters);


                $comando = $this->pdo->prepare("begin  {$spu} ($cant); end;");
                $comando->execute(
                    $array
                );


                $response["success"]  = true;
                $response["rpt"]  =     $mensaje;
                // return $comando->fetchAll(PDO::FETCH_OBJ);


            }catch(Exception $e){
                $response["success"]  = false;
                $response["rpt"]  = $e->getMessage();
            }


            return $response;

        }

           // REGISTRAR - MODIFICAR - ELIMINAR (SQL)
           function setAllSQL($spu,$parameters,$mensaje){
            $response = array();

            try{
                // CANTIDAD DE PARAMETROS
                $cant = $this->getCantParameters($parameters);
                // REEMPLAZAMOS VACIOS POR NULOS
                $array = $this->ReplaceEmpty($parameters);

                $comando = $this->pdosqltest->prepare("exec  {$spu} {$cant} ");
                $comando->execute(
                    $array
                );
                $response["success"]  = true;
                $response["rpt"]  =     $mensaje;
            }catch(Exception $e){
                $response["success"]  = false;
                $response["rpt"]  = $e->getMessage();
            }

            return $response;
        }

        // REGISTRAR - MODIFICAR - ELIMINAR (SQL SIGE)
        function setAllSQLSIGE($spu,$parameters,$mensaje){

            $response = array();

            try{

                // CANTIDAD DE PARAMETROS
                $cant = $this->getCantParameters($parameters);
                // REEMPLAZAMOS VACIOS POR NULOS
                $array = $this->ReplaceEmpty($parameters);

                $comando = $this->pdosqlsige->prepare("exec  {$spu} {$cant} ");
                $comando->execute(
                    $array
                );
                $response["success"]  = true;
                $response["rpt"]  =     $mensaje;

            }catch(Exception $e){
                $response["success"]  = false;
                $response["rpt"]  = $e->getMessage();
            }

            return $response;
        }




        // SELECT
        function select($sql){
            $comando = $this->pdo->prepare($sql);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_OBJ);

        }


        #region FUNCIONES EXTRAS
                // OBTIENE LA CANTIDAD DE PARAMETROS Y LOS CONVIERTE
                function getCantParameters($array){
                       
                    $response = array();




                    if($array != null){
                        for($i = 0; $i < count($array);$i++){
                            $response[] = "?";
                        }
           
                        return implode(",",$response);
                    }else{
                        return "";
                    }
                   
                }

                // OBTIENE LA CANTIDAD DE PARAMETROS Y LOS CONVIERTE
                function getCantParametersOci($array){
                       
                    $response = array();
                    if($array != null ){
                        for($i = 0; $i < count($array);$i++){
                            $response[] = ":param{$i}";
                        }
           
                        return [
                            "paramtexto" => implode(",",$response),
                            "param" => $response
                        ];
                    }else{
                        return [
                            "paramtexto" => "",
                            "param" => ""
                        ];
                    }
                   
                }


                // REEMPLAZA VACIOS
                function ReplaceEmpty($array){


                    $array2 = $array;
       
                    for($i = 0; $i < count($array);$i++){
                        if($array2[$i] == ""){
                            $array2[$i] = null;
                        }
                    }
       
                    return $array2;
                }

                
            #endregion

    }


?>





