<?php
    session_start();


    // UNIDADES
    $data                       =   $_SESSION["indicadorgeneral_moldes"];
    $datacliente                =   $_SESSION["indicadorclientes_moldes"];

    // CANTIDADES
    $data_cantidad              =   $_SESSION["indicadorgeneral_moldes_cantidad"];
    $datacliente_cantidad       =   $_SESSION["indicadorclientes_moldes_cantidad"];

    $clientes                   = array();

    $columnas                   =   array_keys($data[0]);
    $contadorgeneraldata        = 0;
    $contadorgeneraldatapor     = 0;
    $contfilasgeneral           = 0;
    $contfilascliente           = 0;

    $contclientefiltrado        = 0;
    $contclientefiltradopor     = 0;
    $contclientefiltradogeneral  = 0;
    $contclientefiltradogeneralpor  = 0;


    // UNIDADES
    $totalfichasgeneral         = array();    
    $totalfichasclientes        = array();

    // CANTIDADES
    $totalfichasgeneral_cant    = array();    
    $totalfichasclientes_cant   = array();

    $startcliente               = true;


    // AGREGAMOS CLIENTES
    foreach($datacliente as $cli){
        $clientes[] = $cli["CLIENTE"];
    }

    // UNIQUE
    $clientes = array_unique($clientes);

    class filtercliente {
            private $cliente;

            function __construct($cliente) {
                    $this->cliente = $cliente;
            }

            function getCliente($item) {
                    return $item["CLIENTE"] == $this->cliente;
            }
    }

    class filterclientecant {
        private $cliente;

        function __construct($cliente) {
                $this->cliente = $cliente;
        }

        function getCliente($item) {
                return $item["CLIENTE"] == $this->cliente;
        }
    }

    // $img        = file_get_contents("img.jpg");
    // $imgbase64  = base64_encode($img);

    $imagenindicador = $_POST["imagen"];

?>


<head>

    <style>

        /* body{
            font-family: Arial ;
        } */

        .text-center{
            text-align: center !important;
        }

        .font-weight-bold{
            font-weight: bold !important;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px !important;
        }

        table thead {
            background: #204d86;
            color:#fff;
        }

        table{
            width: 100% !important;
            /* table-layout: fixed; */
        }

        .bg-1{
            background: #cccccc;
        }

        .bg-2{
            background: #e3e1e1;
        }

        .bg-3{
            background: #204d86;
            color:#fff;
        }

        .page_break { 
                /* page-break-before: always;  */
            page-break-before: always;
            break-after: always;
            page-break-inside: avoid;
        }

        /* .filafija .descripcion {
            width: 60px !important;
            overflow: auto !important;
            vertical-align: middle !important;
        } */
/* 
        .filafija .columnas {
            width: 10px !important;
            overflow: auto !important;
            vertical-align: middle !important;
        } */

        
        /* .text-center{
            text-align: center !important;
        } */


        .image{
            width: 100%;
            height: 100%;
            float: left;
            /* height: 300px !important; */
        }

        .float-left{
            float: left !important;
        }

    </style>

</head>


<!-- GENERAL -->
<div >

    <div>

        <h3 class="text-center font-weight-bold">
            INDICADOR GENERAL DE MOLDAJE 
        </h3>

    </div>

    <div style="height:300px">
        <!-- <img class="image" src="data:image;base64,<?= $imgbase64; ?>" alt=""> -->
        <img class="image" src="<?= $imagenindicador; ?>" alt="">

    </div>


    <div>
         <!-- TABLA GENERAL -->
        <table class="table">

            <!-- ARMAMOS CABECERA -->
            <thead>
                <tr class="filafija">
                    <th class="descripcion" rowspan="2">DETALLE GENERAL</th>

                    <?php foreach($columnas as $col): ?>
                        <?php if($col != "IDTIPO" && $col != "TIPO" ): ?> 
                            <th colspan="2" class="columnas"><?= str_replace("'","",$col) ; ?></th>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </tr>

                <tr class="filafija">
                    <?php foreach($columnas as $col): ?>
                        <?php if($col != "IDTIPO" && $col != "TIPO" ): ?> 
                            <th >UN</th>
                            <th >CANT</th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </thead>

            <!-- ARMAMOS CUERPO -->
            <tbody>

                <!-- DATA GENERAL -->
                <?php foreach($data as $filas): ?>

                    <!-- AUMENTAMOS DATA GENERAL -->
                    <?php  
                        $contadorgeneraldata++; 
                    ?>


                    <tr>

                        <!-- TIPOS -->
                        <th class="bg-1" style="text-align: left !important;">
                            <?= $filas["TIPO"] ; ?>
                        </th>

                        <!-- COLUMNAS -->
                        <?php foreach($columnas as $col): ?>

                            <!-- AGREGAMOS TD -->
                            <?php if($col != "IDTIPO" && $col != "TIPO" ): ?> 

                                <!-- AGREGAMOS TOTALES -->
                                <?php 
                                    if($contadorgeneraldata == 1){
                                        $totalfichasgeneral[]           = $filas[$col];
                                        $totalfichasgeneral_cant[]      = $data_cantidad[$contadorgeneraldata-1][$col];
                                    }
                                ?>

                                <!-- ARMAMOS -->
                                <td class="text-center"><?= $filas[$col] != "" ? number_format($filas[$col]) : "" ; ?></td>
                                <td class="text-center"><?= $data_cantidad[$contadorgeneraldata-1][$col]  != "" ? number_format($data_cantidad[$contadorgeneraldata-1][$col]) : ""; ?></td>


                            <?php endif; ?>

                        <?php endforeach; ?>


                    </tr>


                <?php endforeach; ?>

                <!-- PORCENTAJES -->
                <?php foreach($data as $filas): ?>


                    <!-- AUMENTAMOS DATA GENERAL -->
                    <?php  
                        $contadorgeneraldatapor++; 
                        $contfilasgeneral = 0;
                    ?>

                    <?php if($contadorgeneraldatapor > 1): ?>

                        <tr>

                            <!-- TIPOS -->
                            <th class="bg-3" style="text-align: left !important;">
                                <?= "% " . $filas["TIPO"] ; ?>
                            </th>

                            <!-- COLUMNAS -->
                            <?php foreach($columnas as $col): ?>

                                <!-- AGREGAMOS TD -->
                                <?php if($col != "IDTIPO" && $col != "TIPO" ): ?> 

                                    <!-- ARMAMOS UNIDADES -->
                                    <td class="text-center">
                                        <?= 
                                            $totalfichasgeneral[$contfilasgeneral] != "" 
                                                ?  
                                            round(($filas[$col] / $totalfichasgeneral[$contfilasgeneral]) * 100 ,2). "%"
                                                : 
                                            ""; 
                                        ?>
                                    </td>

                                    <!-- ARMAMOS CANTIDAD -->
                                    <td class="text-center">
                                        <?= 
                                            $totalfichasgeneral_cant[$contfilasgeneral] != "" 
                                                ?  
                                            round(($data_cantidad[$contadorgeneraldatapor-1][$col] / $totalfichasgeneral_cant[$contfilasgeneral]) * 100 ,2). "%"
                                                : 
                                            ""; 
                                        ?>
                                    </td>

                                    <?php
                                        $contfilasgeneral++;
                                    ?>

                                <?php endif; ?>

                            <?php endforeach; ?>


                        </tr>

                    <?php endif; ?>


                <?php endforeach; ?>
                            

            </tbody>

        </table>
    </div>

   



</div>


<!-- CLIENTES -->
<div class="page_break">

    <h3 class="text-center font-weight-bold">
        CLIENTES
    </h3>         

    <table>

        <thead>
            <tr>
                <th rowspan="2">CLIENTE</th>
                <th rowspan="2">DETALLE GENERAL</th>
                <?php foreach($columnas as $col): ?>
                    <?php if($col != "IDTIPO" && $col != "TIPO" ): ?> 
                        <th class="columnas" colspan="2">
                            <?= str_replace("'","",$col) ; ?>
                        </th>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>

            <tr>
                
                <?php foreach($columnas as $col): ?>
                    <?php if($col != "IDTIPO" && $col != "TIPO" ): ?> 
                        <th > UN</th>
                        <th > CANT</th>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </thead>

        <tbody> 
                        
            <?php foreach($clientes as $cliente): ?> 
                

                <?php
                    $startcliente = true;
                    $contclientefiltrado = 0;

                    $clientefiltrado = array_filter($datacliente,array( new filtercliente($cliente),"getCliente"));     
                    $clientefiltrado_cant = array_filter($datacliente_cantidad,array( new filterclientecant($cliente),"getCliente"));     


                    $totalfichasclientes        = array();    
                    $totalfichasclientes_cant   = array();
                ?>


                <?php foreach($clientefiltrado as $filtrado): ?> 

                    <?php
                        $contclientefiltradogeneral++;
                        $contclientefiltrado++;
                    ?>

                    <!-- ######################## -->
                    <!-- ### DATA CANT FICHAS ### -->
                    <!-- ######################## -->
                    <tr>
                        <!-- CLIENTE ROWSPAN -->
                        <?php  if($startcliente): ?>
                            <td class="text-center" rowspan="<?= count($clientefiltrado) * 2 - 1; ?>">
                                <?= $cliente; ?>
                            </td>
                        <?php  endif; ?>

                        <!-- DESCRIPCION DE ESTADOS -->
                        <td><?= $filtrado["TIPO"]; ?></td>

                        <!-- DATA COLUMNAS -->
                        <?php foreach($columnas as $col): ?>
                            <?php if($col != "IDTIPO" && $col != "TIPO" ): ?> 


                                 <!-- AGREGAMOS TOTALES -->
                                <?php 
                                    if($contclientefiltrado == 1){
                                        $totalfichasclientes[]      = $filtrado[$col];
                                        $totalfichasclientes_cant[] = $clientefiltrado_cant[$contclientefiltradogeneral-1][$col];
                                    }
                                ?>

                                <!-- UNIDADES -->
                                <td class="columnas text-center">
                                    <?= $filtrado[$col] != "" ? number_format($filtrado[$col]) : "" ; ?>
                                </td>

                                <!-- CANTIDADES -->
                                <td class="columnas text-center">
                                    <!-- <?= $filtrado[$col]; ?> -->

                                    <?= $clientefiltrado_cant[$contclientefiltradogeneral-1][$col] != "" ? number_format($clientefiltrado_cant[$contclientefiltradogeneral-1][$col]) : "" ; ?>
                                    <!-- <?= var_dump($clientefiltrado_cant); ?> -->

                                </td>

                            <?php endif; ?>
                        <?php endforeach; ?>


                    </tr>

                    <?php $startcliente = false;?>

                    <!-- ####################### -->
                    <!-- ### DATA PORCENTAJE ### -->
                    <!-- ####################### -->
                    <?php  if($contclientefiltrado == count($clientefiltrado)): ?>

                        <?php   
                            $contclientefiltradopor = 0;
                        ?>
                        <?php foreach($clientefiltrado as $filtradoporcentaje): ?> 

                            
                            <?php 
                                // SUMAMOS
                                $contfilascliente = 0;
                                $contclientefiltradopor++; 
                                $contclientefiltradogeneralpor++;

                            ?> 

                            <?php if($contclientefiltradopor > 1): ?>
                                <tr>
                                    <!-- DESCRIPCION DE ESTADOS -->
                                    <td class="bg-3"><?= $filtradoporcentaje["TIPO"]; ?></td>

                                    <!-- DATA COLUMNAS -->
                                    <?php foreach($columnas as $col): ?>


                                        <?php if($col != "IDTIPO" && $col != "TIPO" ): ?> 

                                            <!-- UNIDADES -->
                                            <td class="columnas text-center">
                                                <?= 

                                                    // $filtradoporcentaje[$col]; 
                                                    $totalfichasclientes[$contfilascliente] != "" 
                                                        ?  
                                                    round(($filtradoporcentaje[$col] / $totalfichasclientes[$contfilascliente]) * 100 ,2). "%"
                                                        : 
                                                    ""; 

                                                ?>
                                            </td>

                                            <!-- CANTIDAD -->
                                            <td class="columnas text-center">
                                                <?= 

                                                    // $filtradoporcentaje[$col]; 
                                                    $totalfichasclientes_cant[$contfilascliente] != "" 
                                                        ?  
                                                    round(
                                                        ( 
                                                            $clientefiltrado_cant[$contclientefiltradogeneralpor-1][$col] 
                                                            / 
                                                            $totalfichasclientes_cant[$contfilascliente]
                                                        ) * 100 
                                                        ,
                                                        2). "%"
                                                        : 
                                                    ""; 

                                                ?>
                                            </td>

                                            <?php $contfilascliente++; ?>


                                        <?php endif; ?>


                                    <?php endforeach; ?>

                                </tr>
                                            
                            <?php endif;?>


                        <?php endforeach; ?>


                    <?php  endif; ?>


                <?php endforeach; ?> 





                


            <?php endforeach; ?> 


        </tbody>

    </table>
    
    

</div>



<?php

// var_dump($totalfichasgeneral);
// var_dump($data);
// var_dump($datacliente);
// var_dump($clientes);


?>
