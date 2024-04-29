<?php
    // ini_set('max_execution_time', '300');
    ini_set('max_execution_time', '0');
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
            oci_bind_by_name($comando,':rc', 			$cursor,-1,OCI_B_CURSOR);

            oci_execute($comando);	//EJECUTANDO PROCEDIMIENTO
            oci_execute($cursor);	//EJECUTANDO CURSOR
            oci_close($this->oci);// CERRANDO CONEXION

            //RETORNANDO EL VALOR EN UN ARRAY
            return oci_fetch_assoc($cursor);

        }

        // OBTENER SQL
        function getSQL($spu,$parameters){

            // CANTIDAD DE PARAMETROS
            $cant = $this->getCantParameters($parameters);
            // REEMPLAZAMOS VACIOS POR NULOS
            $array = $this->ReplaceEmpty($parameters);

      		$sql = count($parameters) > 0 ?  "exec {$spu} {$cant} " : "exec {$spu} ";

            $comando = $this->pdosql->prepare($sql);
            $comando->execute(
                $array
            );

            return $comando->fetch(PDO::FETCH_OBJ);
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
				oci_bind_by_name($comando,':rc', 			$cursor,-1,OCI_B_CURSOR);

				oci_execute($comando);	//EJECUTANDO PROCEDIMIENTO
				oci_execute($cursor);	//EJECUTANDO CURSOR
				oci_close($this->oci);// CERRANDO CONEXION

				//RETORNANDO EL VALOR EN UN ARRAY
				// return oci_fetch_assoc($cursor);
                oci_fetch_all($cursor, $objeto, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                return $objeto;

        }

        // LISTAR SQL
        function getAllSQL($spu,$parameters){

            // CANTIDAD DE PARAMETROS
            $cant = $this->getCantParameters($parameters);
            // REEMPLAZAMOS VACIOS POR NULOS
            $array = $this->ReplaceEmpty($parameters);

      		$sql = count($parameters) > 0 ?  "exec {$spu} {$cant} " : "exec {$spu} ";

            $comando = $this->pdosql->prepare($sql);
            $comando->execute(
                $array
            );

            return $comando->fetchAll(PDO::FETCH_OBJ);
        }

        // LISTAR SQL SIGE
        function getAllSQLSIGE($spu,$parameters){

            // CANTIDAD DE PARAMETROS
            $cant = $this->getCantParameters($parameters);
            // REEMPLAZAMOS VACIOS POR NULOS
            $array = $this->ReplaceEmpty($parameters);

      		$sql = count($parameters) > 0 ?  "exec {$spu} {$cant} " : "exec {$spu} ";

            $comando = $this->pdosqlsige->prepare($sql);
            $comando->execute(
                $array
            );

            return $comando->fetchAll(PDO::FETCH_OBJ);
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

                $comando = $this->pdosql->prepare("exec  {$spu} {$cant} ");
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