<?php

class Conexion
{

    // CREDENCIALES ORACLE
    // private $host		= "172.16.88.137";
    private $host		= "172.16.87.26";
    private $base  		= "dbsystex";
    private $user 		= "USYSTEX";
    private $pass 		= "oracle";
    private $charset    = "utf8";

    // CREDENCIALES SQL
    private $host_sql		= '172.16.87.9';
    private $base_sql  		= 'bd_genesys';
    private $user_sql 		= 'sa';
    private $pass_sql 		= 'scr20.$ab';
    // private $charset_sql    = 'utf8';

    // CREDENCIALES SQL SIGE
    private $host_sql_sige		= '172.16.87.12';
    private $base_sql_sige      = 'sige_tsc';
    private $user_sql_sige 		= 'sa';
    private $pass_sql_sige 		= 'D8t8$46nt63$';

    // CREDENCIALES SQL SIGE AUDITEX
    // private $host_sql_sige_a		= '172.16.87.12';
    // private $base_sql_sige_a        = 'sige_auditex';
    // private $user_sql_sige_a 		= 'sa';
    // private $pass_sql_sige_a 		= 'D8t8$46nt63$';

    public function Conectar()
    {
        try{
            $con = new PDO("oci:dbname=".$this->host."/".$this->base.";charset=".$this->charset,$this->user,$this->pass);
            return $con;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }


    public function ConectarOci()
    {
        try{
            $con = oci_connect($this->user, $this->pass, $this->host.'/'.$this->base,'AL32UTF8');
            return $con;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function ConectarSQL($basedatos = "bd_genesys")
    {
        try{
            $this->base_sql = $basedatos;
            $con = new PDO("sqlsrv:server=".$this->host_sql.";database=".$this->base_sql,$this->user_sql,$this->pass_sql);
            return $con;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function ConectarSQLSIGE($basedatos = "sige_tsc")
    {
        try{
            $this->base_sql_sige = $basedatos;
            $con = new PDO("sqlsrv:server=".$this->host_sql_sige.";database=".$this->base_sql_sige,$this->user_sql_sige,$this->pass_sql_sige);
            return $con;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }


}


?>