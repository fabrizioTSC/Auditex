<?php

    require_once '../../models/modelo/generales/exportarexcel.modelo.php';
    require_once '../../models/modelo/reporteexcel.modelo.php';

    // $objExportarM = new ExcelGeneralModelo();
    $objReporteExcelM = new ExcelAjustes();

    // if(isset($_POST["operacion"])){

    //     if($_POST["operacion"] == "reportepcp"){

    //     }

    // }

    if(isset($_POST["operacion"])){

        if($_POST["operacion"] == "reportepcp"){

            $data = $_POST["data"];
            $data = json_decode($data);


            $objReporteExcelM->Exportar_Simple_Innovate("Reporte_Capacidades",$data,[
                [
                    "TITULO"=>"Servicio","WIDTH"=>30,"CONTENIDO"=>"srv_nombre"
                ],
                [
                    "TITULO"=>"Línea","WIDTH"=>10,"CONTENIDO"=>"lin_descripcion"
                ],
                [
                    "TITULO"=>"Mes","WIDTH"=>20,"CONTENIDO"=>"nombre_mes"
                ],
                [
                    "TITULO"=>"Semana","WIDTH"=>10,"CONTENIDO"=>"semana"
                ],
                [
                    "TITULO"=>"Estado","WIDTH"=>14,"CONTENIDO"=>"estado"
                ],
                [
                    "TITULO"=>"Días Diferencia","WIDTH"=>10,"CONTENIDO"=>"diasdif"
                ],
                [
                    "TITULO"=>"Jornada Laboral","WIDTH"=>10,"CONTENIDO"=>"jornada"
                ],
                [
                    "TITULO"=>"Operarios","WIDTH"=>10,"CONTENIDO"=>"maquinistas"
                ],
                [
                    "TITULO"=>"Eficiencia","WIDTH"=>10,"CONTENIDO"=>"eficiencia_porcentaje"
                ],
                [
                    "TITULO"=>"Minutos Disponibles","WIDTH"=>12,"CONTENIDO"=>"minutosaproducir"
                ],
                [
                    "TITULO"=>"Minutos a Producir","WIDTH"=>12,"CONTENIDO"=>"minutosproducidos"
                ],
                [
                    "TITULO"=>"Tipo Prendas","WIDTH"=>14,"CONTENIDO"=>"tipoprenda"
                ]
                ],5,[
                    [
                        "UBICACION"=>"A2","VALOR"=>"REPORTE PCP (OFERTA CAPACIDADES)",
                        "TITULO"=>true,"RANGO"=>"A2:D2"
                    ]
                ],[
                    ["TIPO"=>"NUMERO","COLUMNA"=>"F"],
                    ["TIPO"=>"NUMERO","COLUMNA"=>"G"],
                    ["TIPO"=>"NUMERO","COLUMNA"=>"J"],
                    ["TIPO"=>"NUMERO","COLUMNA"=>"K"],
                    ["TIPO"=>"PORCENTAJE","COLUMNA"=>"I"]
                    // "F","G","J","K"
                ]);

        }

    }

?>