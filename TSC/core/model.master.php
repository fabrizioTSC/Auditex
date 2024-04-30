<?php

    require_once  __DIR__.'/../config/conexion.php';

    class ModelMaster
    {

        public function getConexion()
        {
            try
            {
                $objConexion = new Conexion();
                $pdo = $objConexion->Conectar();
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                return $pdo;
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }


        }


        public function getConexionOci()
        {
            try
            {
                $objConexion = new Conexion();
                $oci = $objConexion->ConectarOci();
                return $oci;
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }

        }

        public function getConexionSQL($basedatos = "bd_genesys")
        {
            try
            {
                $objConexion = new Conexion();
                $oci = $objConexion->ConectarSQL($basedatos);
                return $oci;
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }

        }

        public function getConexionSQLSIGE($basedatos = "sige_tsc")
        {
            try
            {
                $objConexion = new Conexion();
                $oci = $objConexion->ConectarSQLSIGE($basedatos);
                return $oci;
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }


        }


        public function getConexionSQLTest()
        {
            try
            {
                $objConexion = new Conexion();
                $pdo = $objConexion->ConectarSQLTest(); // Asegúrate de que ConectarSQLTest está definido en Conexion.php
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            }
            catch(Exception $e)
            {
                die($e->getMessage());
            }
        }


    }


?>