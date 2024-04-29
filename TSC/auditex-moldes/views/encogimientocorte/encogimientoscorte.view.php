<?php

    require_once __DIR__.'../../../../models/modelo/core.modelo.php';
    ini_set('memory_limit', '-1');


    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }

    $objModelo = new CoreModelo();

    $_SESSION['navbar'] = "Registro de Encogimiento - Fichas de Corte";
    $datostablasegunda = "";



    // OBTENEMOS DATOS
    if(isset($_POST["operacion"])){

        // CARGAMOS FICHAS DEL SIGE
        $responsecargasige = $objModelo->setAllSQL("uspCargaGiroFichaSigeToAuditex",[],"Correcto");


        $fecini         = $_POST["frFechaI"]        != "" ? $_POST["frFechaI"] : "";
        $fecfin         = $_POST["frFechaF"]        != "" ? $_POST["frFechaF"] : "";
        $cliente        = $_POST["cliente"]         != "" ? $_POST["cliente"] : "";
        $partida        = $_POST["partida"]         != "" ? $_POST["partida"] : "";
        $ficha          = $_POST["ficha"]           != "" ? $_POST["ficha"] : "";
        $estcli         = $_POST["estcli"]          != "" ? $_POST["estcli"] : "";
        $articulo       = $_POST["articulo"]        != "" ? $_POST["articulo"] : "";
        $programa       = $_POST["programa"]        != "" ? $_POST["programa"] : "";

        $estatus        = isset($_POST["estatus"])          ? join("','",$_POST["estatus"]) : "";
        $esttsc         = $_POST["esttsc"]          != "" ? $_POST["esttsc"] : "";
        $color          = $_POST["color"]           != "" ? $_POST["color"] : "";
        $encogimiento   = $_POST["encogimiento"]    != "" ? $_POST["encogimiento"] : "";

        $fecinilib      = $_POST["frFechaILiberacion"]        != "" ? $_POST["frFechaILiberacion"] : "";
        $fecfinlib      = $_POST["frFechaFLiberacion"]        != "" ? $_POST["frFechaFLiberacion"] : "";

        $usuliberacion  = $_POST["usuliberacion"]              != "" ? $_POST["usuliberacion"] : "";

        $responsefichas = $objModelo->getAll("USYSTEX.SPGET_RPT_MOLDESCORTE_001_NEW", [
            $fecini,    $fecfin,    $cliente, $partida, $ficha, $estcli, $articulo, $programa, $estatus, $esttsc, $color, $encogimiento,
            $fecinilib, $fecfinlib,$usuliberacion
        ]);

        $contfichas = 0;
        $contadorfichas_new = 0;

        $_SESSION["molde_reporte"] = $responsefichas;

    }


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encogimientos corte</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <!-- STYLE -->
    <?php require_once '../../../plantillas/style.view.php'; ?>

    <!-- <link rel="stylesheet" href="../../../libs/bootstraptable/css/bootstrap-table.min.css">
    <link rel="stylesheet" href="../../../libs/bootstraptable/css/bootstrap-table-fixed-columns.min.css" > -->
    <!-- <link href="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/sticky-header/bootstrap-table-sticky-header.css" rel="stylesheet"> -->



    <style>
        body{
            padding-top: 50px !important;
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"  rel="stylesheet"  />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/encogimientocorte/molde.css">

</head>

<body>
    <div class="loader"></div>

    <?php require_once '../../../plantillas/navbar.view.php'; ?>

    <div class="container-fluid mt-3">

        <!-- BUSQUEDA -->
        <div class="card p-0">

            <form class="card-body p-0" id="frmbusqueda" autocomplete="off" method="POST">

                <!-- FILTRO DE BÚSQUEDA -->
                <div class="row">

                    <input type="hidden" class="form-control form-control-sm bus"  name="operacion" value="operacion"> 

                    <?php

                            $p_fechai           = isset($_POST["frFechaI"]) ? $_POST["frFechaI"] : "";
                            $p_fechaf           = isset($_POST["frFechaF"]) ? $_POST["frFechaF"] : "";
                            $p_partida          = isset($_POST["partida"]) ? $_POST["partida"] : "";
                            $p_ficha            = isset($_POST["ficha"]) ? $_POST["ficha"] : "";
                            $p_estilocliente    = isset($_POST["estcli"]) ? $_POST["estcli"] : "";
                            $p_articulo         = isset($_POST["articulo"]) ? $_POST["articulo"] : "";
                            $p_programa         = isset($_POST["programa"]) ? $_POST["programa"] : "";
                            $p_estilotsc        = isset($_POST["esttsc"]) ? $_POST["esttsc"] : "";
                            $p_color            = isset($_POST["color"]) ? $_POST["color"] : "";

                            $p_estado           = isset($_POST["estatus"]) ? json_encode($_POST["estatus"]) : "";

                            $p_fechailib        = isset($_POST["frFechaILiberacion"]) ? $_POST["frFechaILiberacion"] : "";
                            $p_fechaflib        = isset($_POST["frFechaFLiberacion"]) ? $_POST["frFechaFLiberacion"] : "";

                            $p_usuliberacion    =  isset($_POST["usuliberacion"])      ? $_POST["usuliberacion"] : "";
                            $p_cliente          =  isset($_POST["cliente"])      ? $_POST["cliente"] : "";



                    ?>


                    <div class="col-md-2">
                        <label for="" class="font-weight-bold">Fecha Inicio (PCP)</label>
                        <input type="date" class="form-control form-control-sm <?php echo $p_fechai != "" ? "is-valid" : ""; ?> " id="txtfechai" name="frFechaI" value="<?php echo $p_fechai; ?>"> 
                    </div>

                    <div class="col-md-2">
                        <label for="" class="font-weight-bold">Fecha Fin (PCP)</label>
                        <input type="date" class="form-control form-control-sm <?php echo $p_fechaf != "" ? "is-valid" : ""; ?> " id="txtfechaf" name="frFechaF" value="<?php echo $p_fechaf; ?>">
                    </div>

                    <!-- <input type="hidden" class="form-control form-control-sm bus" id="txtcliente" name="cliente" > -->

                    <div class="col-md-2">
                        <label for="">Programa</label>
                        <input type="text" class="form-control form-control-sm <?php echo $p_programa != "" ? "is-valid" : "";  ?> " id="txtprograma" value="<?php echo $p_programa; ?>" name="programa">
                    </div>

                    <div class="col-md-2">
                        <label for="">Estatus</label>
                        <select style="width: 100%;" multiple  name="estatus[]" id="cboestatusbusqueda" class="select2 custom-select custom-select-sm <?php echo $p_estado != "" ? "is-valid" : "";  ?>"></select>
                    </div>


                    <div class="col-md-2">
                        <label for="">Fecha Inicio (Lib)</label>
                        <input type="date" class="form-control form-control-sm <?php echo $p_fechailib != "" ? "is-valid" : ""; ?> " id="txtfechailib" name="frFechaILiberacion" value="<?php echo $p_fechailib; ?>"> 
                    </div>

                    <div class="col-md-2">
                        <label for="">Fecha Fin (Lib)</label>
                        <input type="date" class="form-control form-control-sm <?php echo $p_fechaflib != "" ? "is-valid" : ""; ?> " id="txtfechaflib" name="frFechaFLiberacion" value="<?php echo $p_fechaflib; ?>">
                    </div>

                    <div class="col-md-1">
                        <label for="">Partida</label>
                        <input type="text" class="form-control form-control-sm <?php echo $p_partida != "" ? "is-valid" : ""; ?> " id="txtpartida" value="<?php echo $p_partida; ?>" name="partida">
                    </div>

                    <div class="col-md-1">
                        <label for="">Ficha</label>
                        <input type="number" class="form-control form-control-sm <?php echo $p_ficha != "" ? "is-valid" : ""; ?> " id="txtficha" value="<?php echo $p_ficha;  ?>" name="ficha">
                    </div>

                    <div class="col-md-1">
                        <label for="">Estilo Cli.</label>
                        <input type="text" class="form-control form-control-sm <?php echo $p_estilocliente != "" ? "is-valid" : ""; ?> " id="txtestilocliente" value="<?php echo $p_estilocliente; ?>" name="estcli">
                    </div>
                    

                    <div class="col-md-1">
                        <label for="">Estilo TSC</label>
                        <input type="text" class="form-control form-control-sm <?php echo $p_estilotsc != "" ? "is-valid" : "";  ?> " id="txtestilotsc" name="esttsc" value="<?php echo $p_estilotsc; ?>" >
                    </div>

                    
                    <div class="col-md-1">
                        <label for="">Artículo</label>
                        <input type="text" class="form-control form-control-sm <?php echo $p_articulo != "" ? "is-valid" : ""; ?> " id="txtarticulo" value="<?php echo $p_articulo;  ?>" name="articulo">
                    </div>

                    <div class="col-md-1">
                        <label for="">Color</label>
                        <input type="text" class="form-control form-control-sm <?php echo $p_color != "" ? "is-valid" : ""; ?> " id="txtcolor" name="color" value="<?php echo $p_color; ?>">
                    </div>

                    <input type="hidden" class="form-control form-control-sm bus" id="txtencogimiento" name="encogimiento">

                    <!-- USUARIO LIBERADOS -->
                    <div class="col-md-2">
                        <label for="">Usu. Lib</label>
                        <select name="usuliberacion" id="cbousuliberacion" class="custom-select custom-select-sm <?php echo $p_usuliberacion != "" ? "is-valid" : "";  ?>"></select>
                    </div>

                    <!-- CLIENTES -->
                    <div class="col-md-2">
                        <label for="">Clientes</label>
                        <select name="cliente" id="cboclientes" class="custom-select custom-select-sm <?php echo $p_cliente != "" ? "is-valid" : "";  ?>"></select>
                    </div>

                    
                    <div class="col-md-1">
                        <label for="">&nbsp;</label>
                        <button type="button" class="btn btn-success btn-sm btn-block" id="btnexportar">
                            <i class="fas fa-file-excel"></i>
                                Export.
                        </button>
                    </div>

                    <div class="col-md-1">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-sm btn-primary btn-block" type="submit">
                            <i class="fas fa-search"></i> 
                                Buscar
                        </button> 
                    </div>

                </div>
                    
            </form>

        </div>

        <!-- CARD -->
        <div class="card mt-3 p-0" id="card2">

            <div class="card-body p-0" id="cardbodygeneral">


                <!-- COLUMNA 1 DE CARD -->
                <div class="col-card-1 col-card">

                    <table class="table table-bordered table-sm tabledatos" id="tabledatos" >

                        <thead id="theaddatos" class="thead-light thead theaddatos">

                            <tr >
                                <th rowspan="2" class="w-bajo-sm border-table" >
                                    N°
                                </th>
                                <th rowspan="2" class="w-mediano-sm-cant border-table" data-field="col_2">Ficha</th>
                                <th rowspan="2" class="w-bajo border-table" data-field="col_3">
                                    <!-- <label >Est.</label> <br>
                                    <label >Mol.</label>  -->
                                    Est. Mol.
                                </th>
                                <th rowspan="2" class="w-bajo-sm border-table" data-field="col_4">P.E.</th>
                                <th rowspan="2" class="w-bajo border-table" data-field="col_5">
                                    Est. Test.
                                </th>
                                <th rowspan="2" class="w-mediano-xs border-table" data-field="col_6">
                                    Fecha Lib Testing
                                    <!-- <label >Fecha</label> <br> -->
                                    <!-- <label >Emisión</label>  -->
                                </th>
                                <th rowspan="2" class="w-bajo border-table" data-field="col_5">
                                    CONCESION
                                </th>
                                <th rowspan="2" class="w-mediano-xs border-table" data-field="col_6">
                                    Fecha Emisión
                                    <!-- <label >Fecha</label> <br> -->
                                    <!-- <label >Emisión</label>  -->
                                </th>
                                <th rowspan="2" class="w-mediano-xs border-table" data-field="col_7">
                                    Fecha Lib
                                    <!-- <label>Fecha</label> <br>
                                    <label>Lib.</label> -->
                                </th>
                                <th rowspan="2" class="w-mediano-sm border-table" data-field="col_8">Cliente</th>
                                <th rowspan="2" class="w-mediano-sm-sm border-table" data-field="col_9">Programa</th>
                                <th rowspan="2" class="w-mediano-sm border-table" data-field="col_10">Pedido</th>
                                <th rowspan="2" class="w-mediano-sm-sm2 border-table" data-field="col_11">
                                    Estilo Cliente
                                    <!-- <label>Estilo </label> <br> -->
                                    <!-- <label>Cliente</label> -->
                                </th>
                                <th rowspan="2" class="w-mediano-sm border-table" data-field="col_12">
                                    Estilo TSC
                                    <!-- <label>Estilo</label> <br> -->
                                    <!-- <label>TSC</label> -->
                                </th>
                                <th rowspan="2" class="w-mediano-sm border-table" data-field="col_13">Artículo</th>
                                <th rowspan="2" class="w-mediano-sm border-table" data-field="col_14">Color</th>
                                <th rowspan="2" class="w-mediano-xs-partida border-table" data-field="col_15">Partida</th>
                                <th rowspan="2" class="w-mediano-sm-cant border-table" data-field="col_16">
                                    Cant. Prog.
                                    <!-- <label>Cant. </label><br> -->
                                    <!-- <label>Prog.</label> -->
                                </th>

                                <th  class="w-mediano-sm border-table" data-field="col_17">
                                    Ruta Prenda
                                </th>
                            </tr>

                            <!-- <tr> -->
                            <tr class="text-center">
                                <th  class="border-table">
                                    &nbsp;
                                </th>
                            </tr>
                            <!-- </tr> -->

                        </thead>

                        <tbody id="tbodydatos" class="text-center tbodydatos">

                            

                            <?php if(isset($responsefichas)):?>                                            

                                <?php foreach($responsefichas as $fila): ?>

                                    <?php 
                                        // CALCULAMOS VARIABLES
                                        $contfichas++; 
                                        $contadorfichas_new++; 

                                        // CLIENTE
                                        $fantasiacliente = $fila['FANTASIA_CLIENTE'] == "" ? "CLI" : $fila['FANTASIA_CLIENTE'];
                                        $fantasiacliente = strlen($fantasiacliente) > 6 ?  substr($fantasiacliente,0,6) : $fantasiacliente;  

                                        $fechaemision       = date("d/m/Y", strtotime($fila['FECHAEMISION']));
                                        $fechahoraemision   = $fila['FECHAEMISIONSTRING'];

                                        // $fechaliberaciontesting       = date("d/m/Y", strtotime($fila['FECHALIBERACION_TESTING']));
                                        $fechaliberaciontesting       = $fila['FECHALIBERACION_TESTING'];

                                        // $fechahoraliberaciontesting   = $fila['FECHALIBERACION_TESTING_STRING'];


                                        $fechaliberacion    = $fila['FECHA_LIBERACION'] != "" ? date("d/m/Y", strtotime($fila['FECHA_LIBERACION'])) : "";
                                        $articulo           = strlen($fila['ARTICULO']) > 6 ?  substr($fila['ARTICULO'],0,6) : $fila['ARTICULO'];
                                        // $estilocliente           = strlen($fila['ESTILOCLIENTE']) > 6 ?  substr($fila['ESTILOCLIENTE'],0,6) : $fila['ESTILOCLIENTE'];            

                                        $estilocliente           = $fila['ESTILOCLIENTE'];            


                                        $color                  = strlen($fila['COLOR']) > 6 ? substr($fila['COLOR'],0,6) : $fila['COLOR'];
                                        $rutapartida            = "/TSC-WEB/auditoriatela/VerAuditoriaTela.php?partida={$fila['PARTIDA']}&codtel={$fila['CODTELA']}&codprv={$fila['CODPRV']}&numvez={$fila['NUMVEZ']}&parte=1&codtad=1";
                                        $rutaprenda             = strlen($fila['RUTA_PRENDA']) > 6 ?  substr($fila['RUTA_PRENDA'],0,6) : $fila['RUTA_PRENDA'];          

                                        // FICHA CANCELADA
                                        $fichacancelada         = $fila["COD_CANCE_TELA"] == "0" ? false : true;
                                        $fichadisabled          = $fichacancelada ? "disabled='disabled'" : "";
                                        $clasefichadisabled     = $fichacancelada ? "fichadisabled" : "";

                                        // CHECK DE PRUEBA DE ENCOGIMIENTO
                                        $pruebaencogimiento = $fila['PRUEBA_ENCOGIMIENTO'] == "" ? false : true;
                                        $checkedpruebaenco = $pruebaencogimiento ? "<input type='checkbox' {$fichadisabled} data-estilotsc='{$fila['ESTILOTSC']}'  data-partida='{$fila['PARTIDA']}' data-fila='{$contfichas}' data-lote='{$fila['LOTE_PRODUTO']}' data-ficha='{$fila['FICHA']}' class='checkpruebaencogimiento' checked />" : "<input type='checkbox' {$fichadisabled} data-fila='{$contfichas}'  data-estilotsc='{$fila['ESTILOTSC']}'  data-partida='{$fila['PARTIDA']}' data-lote='{$fila['LOTE_PRODUTO']}' data-ficha='{$fila['FICHA']}' class='checkpruebaencogimiento'/>" ;


                                        // #################################
                                        // ### DATOS DE LA SEGUNDA TABLA ###
                                        // #################################

                                        // REALES TERCERA
                                        $revirado1tercera = $fila['REVIRADO1TERCERAL'] != "" ? (float)$fila['REVIRADO1TERCERAL']."%" : "-";
                                        $revirado2tercera = $fila['REVIRADO2TERCERAL'] != "" ? (float)$fila['REVIRADO2TERCERAL']."%" : "-";
                                        $revirado3tercera = $fila['REVIRADO3TERCERAL'] != "" ? (float)$fila['REVIRADO3TERCERAL']."%" : "-";

                                        // MOLDE USAR
                                        $molde_usar_hilo    = $fila['MOLDE_USAR_HILO'] != null ? (float)$fila['MOLDE_USAR_HILO'] : "";
                                        $molde_usar_trama   = $fila['MOLDE_USAR_TRAMA'] != null ? (float)$fila['MOLDE_USAR_TRAMA'] : "";
                                        $molde_usar_manga   = $fila['MOLDE_USAR_MANGA'] != null ? (float)$fila['MOLDE_USAR_MANGA'] : ""; 

                                        // MOLDA PAÑO
                                        $molde_pano_hilo    = $fila['MOLDE_PANO_HILO'];
                                        $molde_pano_trama   = $fila['MOLDE_PANO_TRAMA'];

                                        $displaypruebaencogimiento = !$pruebaencogimiento ? "d-none" : "";

                                        $hiloprueba     = $fila['RESULTADO_PRUEBA_HILO_USADO'];
                                        $tramaprueba    = $fila['RESULTADO_PRUEBA_TRAMA_USADO'];
                                        $mangaprueba    = $fila['RESULTADO_PRUEBA_MANGA_USADO'];

                                        $resultado_prueba_observacion = $fila['RESULTADO_PRUEBA_OBSERVACION'] == "" ? "Agregar" : substr($fila['RESULTADO_PRUEBA_OBSERVACION'],0,7);
                                        $observacion_liberacion = $fila['OBSERVACION_LIBERACION'] == "" ? "Agregar" : "Mostrar";
                                        $pruebaencogimiento = $fila['PRUEBA_ENCOGIMIENTO'] == "" ? false : true;

                                        // FICHA CANCELADA
                                        $fichacancelada         = $fila["COD_CANCE_TELA"] == "0" ? false : true;
                                        $fichadisabled          = $fichacancelada ? "disabled='disabled'" : "";
                                        $clasefichadisabled     = $fichacancelada ? "fichadisabled" : "";

                                        // 
                                        $hiloprimeral           = $fila['HILOPRIMERAL'] != '' ? (float)$fila['HILOPRIMERAL'].'%' : '-';
                                        $tramaprimeral          = $fila['TRAMAPRIMERAL'] != '' ? (float)$fila['TRAMAPRIMERAL'].'%' : '-';
                                        $densidadprimeral       = $fila['DENSIDADPRIMERAL'] != '' ? (float)$fila['DENSIDADPRIMERAL'] : '-';
                                        $revirado1primeral      = $fila['REVIRADO1PRIMERAL'] != '' ? (float)$fila['REVIRADO1PRIMERAL'].'%' : '-';
                                        $revirado2primeral      = $fila['REVIRADO2PRIMERAL'] != '' ? (float)$fila['REVIRADO2PRIMERAL'].'%' : '-';
                                        $revirado3primeral      = $fila['REVIRADO3PRIMERAL'] != '' ? (float)$fila['REVIRADO3PRIMERAL'].'%' : '-';
                                        $inclinacionprimeral    = $fila['INCLINACIONPRIMERAL'] != '' ? (float)$fila['INCLINACIONPRIMERAL'].'°' : '-';

                                        $hiloencogimiento       = $fila['HILOENCOGIMIENTO'] == '' ? '-'  : $fila['HILOENCOGIMIENTO'];
                                        $tramaencogimiento      = $fila['TRAMAENCOGIMIENTO'] == '' ? '-'  : $fila['TRAMAENCOGIMIENTO'];
                                        $inclinacionbefore      = $fila['INCLINACIONBEFORE'] == '' ? '-'  : $fila['INCLINACIONBEFORE'];
                                        $inclinacionafter       = $fila['INCLINACIONAFTER'] == '' ? '-'  : $fila['INCLINACIONAFTER'];




                                        $datostablasegunda .= "

                                        <tr class='rows selectrow{$contadorfichas_new}'>

                                        <td height='25' class='{$clasefichadisabled}'>{$fila['HILOTERCERATSC']}</td>
                                        <td height='25' class='{$clasefichadisabled}'>{$fila['TRAMATERCERATSC'] }</td>
                                        <td height='25' class='{$clasefichadisabled}'>{$fila['DENSIDADBEFORETSC'] }</td>
                                        <td height='25' class='{$clasefichadisabled}'>{$fila['ANCHOREPOSOBEFORETSC'] }</td>
                                        <td height='25' class='{$clasefichadisabled}'>{$fila['INCLIACABADOSTSC'] }</td>
                                        <td height='25' class='border-table-right {$clasefichadisabled}'>{$fila['REVIRADOTERCERATSC']}</td>

                                        <!-- ENCOGIMIENTOS ESTANDAR -->
                                        <td height='25' class='{$clasefichadisabled}'>{$fila['HILOTERCERA']}</td>
                                        <td height='25' class='{$clasefichadisabled}'>{$fila['TRAMATERCERA']}</td>
                                        <td height='25' class='{$clasefichadisabled}'>{$fila['DENSIDADBEFORE']}</td>
                                        <td height='25' class='{$clasefichadisabled}'>{$fila['ANCHOREPOSOBEFORE']}</td>
                                        <td height='25' class='border-table-right {$clasefichadisabled}'>{$fila['REVIRADOTERCERA']}</td>

                                        <!-- REALES PRIMERA -->
                                        <td height='25' class='{$clasefichadisabled}'>
                                            {$hiloprimeral} 
                                        </td>
                                        <td height='25' class='{$clasefichadisabled}'>
                                            {$tramaprimeral} 
                                        </td>
                                        <td height='25' class='{$clasefichadisabled}'>
                                            {$densidadprimeral} 
                                        </td>
                                        <td height='25' class='{$clasefichadisabled}'>
                                            {$revirado1primeral} 
                                        </td>
                                        <td height='25' class='{$clasefichadisabled}'>
                                            {$revirado2primeral} 
                                        </td>
                                        <td height='25' class='{$clasefichadisabled}'>
                                            {$revirado3primeral} 
                                        </td>
                                        <td height='25' class='border-table-right {$clasefichadisabled}'>
                                            {$inclinacionprimeral} 
                                        </td>

                                        <!-- REALES TERCERA -->
                                        <td height='25' class='{$clasefichadisabled}' >{$fila['HILOTERCERAL']}%</td>
                                        <td height='25' class='{$clasefichadisabled}' >{$fila['TRAMATERCERAL']}%</td>
                                        <td height='25' class='{$clasefichadisabled}' >{$fila['DENSIDADTERCERAL']}</td>
                                        <td height='25' class='{$clasefichadisabled}' >{$revirado1tercera}</td>
                                        <td height='25' class='{$clasefichadisabled}' >{$revirado2tercera}</td>
                                        <td height='25' class='{$clasefichadisabled}' >{$revirado3tercera}</td>
                                        <td height='25' class='border-table-right {$clasefichadisabled}'>{$fila['INCLINACIONTERCERAL']}°</td>

                                        <!-- OBSERVACION DE TESTING -->
                                        <td height='25' class='border-table-right cursor-pointer {$clasefichadisabled}' data-toggle='tooltip' data-placement='right' title='{$fila['OBSERVACIONES']}' >
                                            Mostrar
                                        </td>
                                        
                                        <!-- ENCOGIMIENTOS DE PAÑO -->
                                        <td height='25' class='{$clasefichadisabled}' >
                                            {$hiloencogimiento}
                                        </td>
                                        <td height='25' class='{$clasefichadisabled}' >
                                            {$tramaencogimiento}
                                        </td>
                                        <td height='25' class='{$clasefichadisabled}' >
                                            {$inclinacionbefore}
                                        </td>
                                        <td height='25' class='border-table-right {$clasefichadisabled}'>
                                            {$inclinacionafter}
                                        </td>";


                                        // <!-- MOLDE USAR -->
                                        if($molde_usar_hilo != '' || $molde_usar_trama != '' || $molde_usar_manga != '' )
                                        {

                                            $datostablasegunda .= "
                                                <td height='25' class='{$clasefichadisabled}'>
                                                                
                                                    <button type='button' class='btn btn-sm btn-success btn-block selectmoldeusar hilousar{$contadorfichas_new} font-sistema p-0' title='Asignar molde a usar'
                                                        data-estilotsc='{$fila['ESTILOTSC']}'
                                                        data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                        data-ficha='{$fila['FICHA']}'
                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        data-fila='{$contadorfichas_new}'
                                                        {$fichadisabled }
                                                        >
                                                        {$molde_usar_hilo}%
                                                    </button>
                                                </td>
                                                <td height='25' class='tramausar{$contadorfichas_new} {$clasefichadisabled}'> {$molde_usar_trama}% </td>
                                                <td height='25' class='mangausar{$contadorfichas_new} border-table-right {$clasefichadisabled}'> {$molde_usar_manga}%</td>
                                            ";

                                        }else{
                                            $datostablasegunda .="
                                            <td height='25' class='{$clasefichadisabled}'>
                                                <button type='button' class='btn btn-sm btn-primary btn-block selectmoldeusar hilousar{$contadorfichas_new} font-sistema p-0' title='Asignar molde a usar'
                                                    data-estilotsc='{$fila['ESTILOTSC']}'
                                                    data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                    data-ficha='{$fila['FICHA']}'
                                                    data-lote='{$fila['LOTE_PRODUTO']}'
                                                    data-fila='{$contadorfichas_new}'
                                                    {$fichadisabled }
                                                    >
                                                    <i class='fas fa-plus'></i>                            
                                                </button>
                                            </td>
                                            <td height='25' class='tramausar{$contadorfichas_new} {$clasefichadisabled}'></td>
                                            <td height='25' class='border-table-right mangausar{$contadorfichas_new} {$clasefichadisabled}'></td>
                                            ";
                                        }

                                            

                                        // <!-- MOLDE PAÑO -->
                                        if($molde_pano_hilo != '' || $molde_pano_trama != ''){

                                            $datostablasegunda .="

                                            <td height='25' class='{$clasefichadisabled}'>
                                                        
                                                        <button type='button' class='btn btn-sm btn-success btn-block selectmoldepanousar hilopanousar{$contadorfichas_new} font-sistema p-0' title='Asignar molde paño a usar'
                                                            data-estilotsc='{$fila['ESTILOTSC']}'
                                                            data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                            data-ficha='{$fila['FICHA']}'
                                                            data-fila='{$contadorfichas_new}'
                                                            data-hilo='{$molde_pano_hilo}'
                                                            data-trama='{$molde_pano_trama}'
                                                            data-lote='{$fila['LOTE_PRODUTO']}'

                                                            {$fichadisabled }
                                                            >
                                                            {$molde_pano_hilo}%
                                                        </button>
                                            </td>
                                            <td height='25' class='tramapanousar{$contadorfichas_new} {$clasefichadisabled}'> {$molde_pano_trama}% </td>
                                            ";
                                        }else{

                                            $datostablasegunda .="
                                                <td height='25' class='{$clasefichadisabled}'>
                                                    <button type='button' class='btn btn-sm btn-primary btn-block selectmoldepanousar hilopanousar{$contadorfichas_new} font-sistema p-0' title='Asignar molde paño a usar'
                                                        data-estilotsc='{$fila['ESTILOTSC']}'
                                                        data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                        data-ficha='{$fila['FICHA']}'
                                                        data-fila='{$contadorfichas_new}'
                                                        data-hilo='{$molde_pano_hilo}'
                                                        data-trama='{$molde_pano_trama}'
                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        {$fichadisabled }
                                                        >
                                                        <i class='fas fa-plus'></i>                            
                                                    </button>
                                                </td>
                                                <td height='25' class='tramapanousar{$contadorfichas_new} {$clasefichadisabled}'></td>
                                            ";

                                        }
                                            


                                        // <!-- VERSION DEL MOLDE -->
                                        if($fila['MOLDE_VERSION'] == '')
                                        {
                                            $datostablasegunda .="
                                                <td height='25' class='{$clasefichadisabled}'>
                                                    <button type='button' class='btn btn-sm btn-primary btn-block selectversionmolde versionmolde{$contadorfichas_new} font-sistema p-0' title='Asignar version de molde'
                                                        data-estilotsc='{$fila['ESTILOTSC']}'
                                                        data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                        data-ficha='{$fila['FICHA']}'
                                                        data-fila='{$contadorfichas_new}'
                                                        data-moldeversion='{$fila['MOLDE_VERSION']}'
                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        {$fichadisabled }
                                                        >
                                                        <i class='fas fa-plus'></i>                            
                                                    </button>
                                                </td>
                                            ";
                                        }else{

                                            $datostablasegunda .="

                                                <td height='25' class='{$clasefichadisabled}'>
                                                    <button type='button' class='btn btn-sm btn-success btn-block selectversionmolde versionmolde{$contadorfichas_new} font-sistema p-0' title='Asignar version de molde'
                                                        data-estilotsc='{$fila['ESTILOTSC']}'
                                                        data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                        data-ficha='{$fila['FICHA']}'
                                                        data-fila='{$contadorfichas_new}'
                                                        data-moldeversion='{$fila['MOLDE_VERSION']}'
                                                        data-lote='{$fila['LOTE_PRODUTO']}'

                                                        {$fichadisabled }
                                                        >
                                                        {$fila['MOLDE_VERSION']}                        
                                                    </button>
                                                </td>

                                            ";

                                        }


                                        // PRIMERA LAVADA MOLDE AGREGADO

                                        
                                        $hilo_molde_primera_lavada          = $fila['PRIMERA_LAVADA_MOLDE_HILO'];
                                        $trama_molde_primera_lavada         = $fila['PRIMERA_LAVADA_MOLDE_TRAMA'];
                                        $densidad_molde_primera_lavada      = $fila['PRIMERA_LAVADA_MOLDE_DENSIDAD'];
                                        $inclinacionbw_molde_primera_lavada = $fila['PRIMERA_LAVADA_MOLDE_INCLI_BW'];
                                        $inclinacionaw_molde_primera_lavada = $fila['PRIMERA_LAVADA_MOLDE_INCLI_AW'];
                                        $revirado_molde_primera_lavada      = $fila['PRIMERA_LAVADA_MOLDE_REVIRADO'];

                                        if($fila['PRIMERA_LAVADA_MOLDE_HILO'] != ''){

                                            $datostablasegunda .= "

                                                <td height='25' class='{$clasefichadisabled}'>

                                                    <button type='button' class='btn btn-sm btn-success btn-block selectmoldeprimeralavada primeralavadahilo{$contadorfichas_new} font-sistema p-0' title='Asignar Primera Lavada Moldes'
                                                        data-estilotsc='{$fila['ESTILOTSC']}'
                                                        data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                        data-ficha='{$fila['FICHA']}'
                                                        data-fila='{$contadorfichas_new}'

                                                        data-hilo='{$hilo_molde_primera_lavada}'
                                                        data-trama='{$trama_molde_primera_lavada}'
                                                        data-densidad='{$densidad_molde_primera_lavada}'
                                                        data-inclinacionbw='{$inclinacionbw_molde_primera_lavada}'
                                                        data-inclinacionaw='{$inclinacionaw_molde_primera_lavada}'
                                                        data-revirado='{$revirado_molde_primera_lavada}'


                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        {$fichadisabled }
                                                        >
                                                        {$hilo_molde_primera_lavada}
                                                    </button>
                                                </td>


                                                
                                                <td height='25' class='{$clasefichadisabled}  primeralavadatrama{$contadorfichas_new}'  >{$fila['PRIMERA_LAVADA_MOLDE_TRAMA'] }</td>
                                                <td height='25' class='{$clasefichadisabled}  primeralavadadensidad{$contadorfichas_new}'  >{$fila['PRIMERA_LAVADA_MOLDE_DENSIDAD'] }</td>
                                                <td height='25' class='{$clasefichadisabled}  primeralavadainclib{$contadorfichas_new}'  >{$fila['PRIMERA_LAVADA_MOLDE_INCLI_BW'] }</td>
                                                <td height='25' class='{$clasefichadisabled}  primeralavadainclia{$contadorfichas_new}'  >{$fila['PRIMERA_LAVADA_MOLDE_INCLI_AW'] }</td>
                                                <td height='25' class='border-table-right {$clasefichadisabled} primeralavadarevirado{$contadorfichas_new}'  >{$fila['PRIMERA_LAVADA_MOLDE_REVIRADO']}</td>
                                            ";
                                        }else{





                                            $datostablasegunda .= "

                                                <td height='25' class='{$clasefichadisabled}'>

                                                    <button type='button' class='btn btn-sm btn-primary btn-block selectmoldeprimeralavada primeralavadahilo{$contadorfichas_new} font-sistema p-0' title='Asignar Primera Lavada Moldes'
                                                        data-estilotsc='{$fila['ESTILOTSC']}'
                                                        data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                        data-ficha='{$fila['FICHA']}'
                                                        data-fila='{$contadorfichas_new}'

                                                        data-hilo='{$hilo_molde_primera_lavada}'
                                                        data-trama='{$trama_molde_primera_lavada}'
                                                        data-densidad='{$densidad_molde_primera_lavada}'
                                                        data-inclinacionbw='{$inclinacionbw_molde_primera_lavada}'
                                                        data-inclinacionaw='{$inclinacionaw_molde_primera_lavada}'
                                                        data-revirado='{$revirado_molde_primera_lavada}'


                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        {$fichadisabled }
                                                        >
                                                        <i class='fas fa-plus'></i>
                                                    </button>

                                                </td>
                                                <td height='25'  class='{$clasefichadisabled} primeralavadatrama{$contadorfichas_new}'></td>
                                                <td height='25'  class='{$clasefichadisabled} primeralavadadensidad{$contadorfichas_new}'></td>
                                                <td height='25'  class='{$clasefichadisabled} primeralavadainclib{$contadorfichas_new}'></td>
                                                <td height='25'  class='{$clasefichadisabled} primeralavadainclia{$contadorfichas_new}'></td>
                                                <td height='25'  class='border-table-right {$clasefichadisabled} primeralavadarevirado{$contadorfichas_new}'></td>

                                            ";

                                        }




                                        // PRIMERA LAVADA MOLDE AGREGADO END

                                        // <!-- PRUEBAS DE ENCOGIMIENTO -->
                                        if($pruebaencogimiento){

                                            // <!-- DATOS DE PRUEBA ENCOGIMIENTO  -->
                                            if($mangaprueba != '' || $hiloprueba != '' || $tramaprueba != ''){

                                                $datostablasegunda .="

                                                    <td height='25' class='{$clasefichadisabled}'>

                                                        <button type='button' class='pruebaencogimiento{$contadorfichas_new} btn btn-sm btn-success btn-block font-sistema p-0 selectpruebaencogimiento selectpruebaencogimiento{$contadorfichas_new} ' title='Asignar prueba de encogimiento'
                                                                        data-estilotsc='{$fila['ESTILOTSC']}'

                                                            data-hilousado='{$hiloprueba}'
                                                            data-tramausado='{$tramaprueba}'
                                                            data-mangausado='{$mangaprueba}'

                                                            data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                            data-ficha='{$fila['FICHA']}'
                                                            data-fila='{$contadorfichas_new}'
                                                            data-lote='{$fila['LOTE_PRODUTO']}'
                                                            >
                                                            { '{$hiloprueba}% / {$tramaprueba}% / {$mangaprueba}%'}             
                                                        </button>

                                                    </td>

                                                ";

                                            }else{

                                                $datostablasegunda .="
                                                    <td height='25' class='{$clasefichadisabled}'>

                                                        <button type='button' class='pruebaencogimiento{$contadorfichas_new} btn btn-sm btn-primary btn-block font-sistema p-0 selectpruebaencogimiento selectpruebaencogimiento{$contadorfichas_new} ' title='Asignar prueba de encogimiento'
                                                                data-estilotsc='{$fila['ESTILOTSC']}'

                                                            data-hilousado='{$hiloprueba}'
                                                            data-tramausado='{$tramaprueba}'
                                                            data-mangausado='{$mangaprueba}'
                                                            data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                            data-ficha='{$fila['FICHA']}'
                                                            data-lote='{$fila['LOTE_PRODUTO']}'
                                                            data-fila='{$contadorfichas_new}'
                                                            >
                                                            <i class='fas fa-plus'></i>                            
                                                        </button>
                                                        
                                                    </td>
                                                ";

                                            }

                                                

                                            // <!-- OBSERVACION -->
                                            $datostablasegunda .=" 

                                                <td height='25' class='{$clasefichadisabled}'>
                                                
                                                    <button type='button' 
                                                        data-ficha='{$fila['FICHA']}' 
                                                        data-fila='{$contadorfichas_new}' 
                                                        data-estilotsc='{$fila['ESTILOTSC']}'
                                                        class='btn btn-primary btn-sm font-sistema btn-block buttons-table pruebaencogimiento{$contadorfichas_new} addobservacionencogimiento addobservacionencogimiento{$contadorfichas_new}'  
                                                        data-observacion='{$fila['RESULTADO_PRUEBA_OBSERVACION']}'
                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                    >
                                                        Mostrar
                                                    </button>
                                                </td>

                                                <!-- RESULTADOS -->
                                                <td height='25' class='border-table-right {$clasefichadisabled}'>

                                                    <button type='button' 
                                                        data-ficha='{$fila['FICHA']}' 
                                                        data-partida='{$fila['PARTIDA']}' 
                                                        data-estilotsc='{$fila['ESTILOTSC']}' 
                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        class='btn btn-primary btn-sm font-sistema btn-block buttons-table resultadopruebaencogimiento  pruebaencogimiento{$contadorfichas_new}'>
                                                        <i class='fas fa-eye'></i>
                                                    </button>

                                                </td>
                                            ";

                                        }else{

                                            $datostablasegunda .= "  
                                            <!-- DATOS -->
                                                <td height='25' class='{$clasefichadisabled}'>

                                                    <button type='button' class='pruebaencogimiento{$contadorfichas_new} btn btn-sm btn-primary btn-block font-sistema p-0 selectpruebaencogimiento selectpruebaencogimiento{$contadorfichas_new} d-none' title='Asignar prueba de encogimiento'
                                                            data-estilotsc='{$fila['ESTILOTSC']}'

                                                        data-hilousado='{$hiloprueba}'
                                                        data-tramausado='{$tramaprueba}'
                                                        data-mangausado='{$mangaprueba}'
                                                        data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                        data-ficha='{$fila['FICHA']}'
                                                        data-fila='{$contadorfichas_new}'
                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        >
                                                        <i class='fas fa-plus'></i>                            
                                                    </button>

                                                </td>  

                                                <!-- OBSERVACION -->
                                                <td     
                                                    height='25' class='{$clasefichadisabled} {$clasefichadisabled}'>

                                                    <button type='button' 
                                                        data-ficha='{$fila['FICHA']}' 
                                                        data-fila='{$contadorfichas_new}' 
                                                        data-estilotsc='{$fila['ESTILOTSC']}'
                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        class='d-none btn btn-primary btn-sm font-sistema btn-block buttons-table pruebaencogimiento{$contadorfichas_new} addobservacionencogimiento addobservacionencogimiento{$contadorfichas_new}'  
                                                        data-observacion='{$fila['RESULTADO_PRUEBA_OBSERVACION']}'
                                                    >
                                                        Agregar
                                                    </button>

                                                </td>  

                                                <!-- RESULTADOS -->
                                                <td class='border-table-right {$clasefichadisabled}'>
                                                    <button type='button' 
                                                        data-ficha='{$fila['FICHA']}' 
                                                        data-partida='{$fila['PARTIDA']}' 
                                                        data-estilotsc='{$fila['ESTILOTSC']}' 
                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        class='pruebaencogimiento{$contadorfichas_new} btn btn-primary btn-sm font-sistema btn-block buttons-table resultadopruebaencogimiento  d-none '>
                                                        <i class='fas fa-eye'></i>
                                                    </button>
                                                </td>  
                                            ";


                                        }

                                            


                                        $mostrar = $observacion_liberacion == 'Mostrar' ? 'btn-warning' : 'btn-primary';
                                        $datostablasegunda .= "  
                                        <!-- OBSERVACION LIBERACION -->
                                            <td height='25' class='{$clasefichadisabled}'  >   
                                                
                                                <button type='button' 
                                                        class='btn btn-sm {$mostrar} btn-block  observacionliberacion observacionliberacion{$contadorfichas_new} {$clasefichadisabled} font-sistema p-0' title='Asignar observación de liberación'
                                                        data-estilotsc='{$fila['ESTILOTSC']}'
                                                        data-estilocliente='{$fila['ESTILOCLIENTE']}'
                                                        data-ficha='{$fila['FICHA']}'
                                                        data-observacion='{$fila['OBSERVACION_LIBERACION']}'
                                                        data-fila='{$contadorfichas_new}'
                                                        data-lote='{$fila['LOTE_PRODUTO']}'
                                                        {$fichadisabled }
                                                >
                                                        {$observacion_liberacion}
                                                </button>

                                            </td>

                                            <!-- USUARIO LIBERACION -->
                                            <td height='25' class='border-table-right cursor-pointer usuarioliberado{$contadorfichas_new} {$clasefichadisabled}' data-toggle='tooltip' data-placement='left' title='{$fila['NOMBREUSUARIO'] }'>
                                                {$fila['USUARIO_LIBERACION'] }
                                            </td>

                                            
                                        

                                        </tr>
                                           
                                        ";



                                    ?>
                                    <tr class="rows selectrow<?= $contfichas; ?>">
                                    
                                        <td height="25" class="cursor-pointer selectrow <?= $fichacancelada ? "bg-danger" : "" ?> <?= $clasefichadisabled; ?>" <?= $fichadisabled; ?> data-fila="<?= $contfichas; ?>" >
                                            <?= $contfichas; ?>
                                        </td>

                                        <!-- FICHA -->
                                        <?php if($fichacancelada): ?>

                                            <td 
                                                height="25" 
                                                <?= $fichadisabled; ?> 
                                                    class="<?= $clasefichadisabled; ?> cursor-pointer"
                                                    data-mdb-toggle='popover'
                                                    title='Eliminación de Ficha'
                                                    data-mdb-content='
                                                        Fecha Anulación:    <?= $fila["DATA_CANCE_TELA"]; ?> /
                                                        Motivo Anulación:   <?= $fila["DESCRIPCIONCANCELAMIENTO"]; ?> /
                                                        Usuario Anulación:   <?= $fila["USUARIO_CANCELAMENTO"]; ?> 
                                                    '
                                                >
                                                <?= $fila["FICHA"]; ?>
                                            </td>

                                        <?php else: ?>

                                            <td 
                                                height="25" 
                                                <?= $fichadisabled; ?> 
                                                    class="<?= $clasefichadisabled; ?> cursor-pointer"
                                                >
                                                <?= $fila["FICHA"]; ?>
                                            </td>
                                        

                                        <?php endif; ?>

                                        

                                        <!-- ESTADO DE MOLDAJE -->
                                        <td height="25"   class='<?= $clasefichadisabled; ?> '  style="padding: 0px !important;">

                                            <button 
                                                type='button' 
                                                data-ficha='<?= $fila["FICHA"]; ?> ' 
                                                data-idestado='<?=$fila['IDESTADOMOLDE'];?>'
                                                data-estilotsc='<?= $fila['ESTILOTSC'] ?>'
                                                data-fila='<?= $contfichas; ?>'
                                                data-lote='<?=$fila['LOTE_PRODUTO']; ?>'
                                                class='buttons-table btn btn-sm btn-block estmoldaje estmoldaje<?= $contfichas; ?> <?= $fila['COLORESTADOMOLDAJE'] ?>'
                                                <?= $fichadisabled; ?>
                                                >
                                                    <?= $fila['SIMBOLOMOLDAJE'] == "" ? "<i class='fas fa-plus'></i>" : $fila['SIMBOLOMOLDAJE']; ?>
                                            </button>

                                        </td>

                                        <!-- CHECK DE PRUEBA DE ENCOGIMIENTO -->
                                        <td height="25" class="<?= $clasefichadisabled; ?>" >
                                            <?= $checkedpruebaenco; ?>
                                        </td>

                                        <!-- ESTADO DE TESTING -->
                                        <td height="25" data-toggle='tooltip' data-placement='right' title='<?= $fila['DESCRIPCIONESTADO']?>' class='<?=$fila['COLORESTADO'];?> cursor-pointer <?= $clasefichadisabled; ?>'>
                                            <?= $fila['SIMBOLOESTADO']; ?>
                                        </td>

                                        <!-- FECHA LIBERACION TESTING -->
                                        <td height="25" class='<?= $clasefichadisabled; ?> cursor-pointer fechaliberaciontesting' data-toggle='tooltip' data-placement='right' title='<?= $fechaliberaciontesting?>'>
                                            <?= $fechaliberaciontesting; ?>   
                                        </td>

                                        <!-- CONCESIÓN -->
                                        <td height="25" data-toggle='tooltip' data-placement='right'  cursor-pointer <?= $clasefichadisabled; ?>'>
                                            <?= $fila['CONCESION'] == '1' ? 'SI' : 'NO'; ?>
                                        </td>

                                        <!-- FECHA EMISION -->
                                        <td height="25" class='<?= $clasefichadisabled; ?> cursor-pointer fechaliberaciontesting' data-toggle='tooltip' data-placement='right' title='<?= $fechahoraemision?>'>
                                            <?= $fechaemision; ?>   
                                        </td>

                                        <!-- FECHA DE LIBERACION -->
                                        <td height="25" class='fechaliberaciontd fechaliberaciontd<?= $contfichas; ?> <?= $clasefichadisabled; ?>'>
                                            <?php if($fechaliberacion != ""):?>

                                                <button type='button' data-ficha='<?= $fila["FICHA"]; ?>' data-lote='<?= $fila["LOTE_PRODUTO"]; ?>' class='btn btn-sm btn-info buttons-table fechaliberacion'>
                                                    <?= $fechaliberacion; ?> 
                                                </button>
                                                
                                            <?php endif;?>
                                        </td>

                                        <!-- CLIENTE -->
                                        <td height="25" data-toggle='tooltip' data-placement='right' title='<?= $fila['CLIENTE']?>' class='cursor-pointer <?= $clasefichadisabled; ?>'>
                                            <?= $fantasiacliente; ?>
                                        </td>

                                        <!-- PROGRAMA -->
                                        <td height="25" class="<?= $clasefichadisabled; ?>">
                                            <?= $fila['PROGRAMA']; ?>   
                                        </td>
                                        <!-- PEDIDO VENTA -->
                                        <td height="25" class="<?= $clasefichadisabled; ?>">
                                            <?= $fila['PEDIDO_VENDA']; ?>   
                                        </td>
                                        <!-- ESTILO CLIENTE -->
                                        <td height="25" data-toggle='tooltip' data-placement='right' title='<?= $fila['ESTILOCLIENTE']; ?>  ' class='cursor-pointer <?= $clasefichadisabled; ?>'>
                                            <?= $estilocliente; ?>   
                                        </td>
                                        <!-- ESTILO TSC -->
                                        <td height="25" class="<?= $clasefichadisabled; ?>">
                                            <?= $fila['ESTILOTSC']; ?>   
                                        </td>
                                        <!-- ARTICULO -->
                                        <td height="25" data-toggle='tooltip' data-placement='right' title='<?= $fila['ARTICULO']; ?>  ' class='cursor-pointer <?= $clasefichadisabled; ?>'>
                                            <?= $articulo; ?>   
                                        </td>

                                        <!-- COLOR -->
                                        <td height="25" data-toggle='tooltip' data-placement='right' title='<?= $fila['COLOR']; ?>  ' class='cursor-pointer <?= $clasefichadisabled; ?>'>
                                            <?= $color; ?>   
                                        </td>
                                        <!-- PARTIDA -->
                                        <td height="25" class="<?= $clasefichadisabled; ?>">
                                            <a target='_blank' href='<?= $rutapartida; ?>'>    
                                                <?= $fila['PARTIDA']; ?>
                                            </a>
                                        </td>
                                        <!-- CANTIDAD PROGRAMAD -->
                                        <td height="25" class="<?= $clasefichadisabled; ?>">
                                            <?= $fila['QTDE_PROGRAMADA']; ?>   
                                        </td>

                                        <!-- RUTA DE LA PRENDA -->
                                        <td height="25" class='cursor-pointer <?= $clasefichadisabled; ?>' data-toggle='tooltip' data-placement='left' title='<?= $fila['RUTA_PRENDA'];?>'>
                                            <?= $rutaprenda; ?>   
                                        </td>
                                        

                                    </tr>

                                <?php endforeach; ?>
                            
                            <?php endif;?>


                        </tbody>

                    </table>

                </div>

                <!-- COLUMNA 2 DE CARD -->
                <div class="col-card-2 col-card ">

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm tabledatos" id="tabledatos_2" >

                            <thead id="theaddatos_2" class="thead-light thead theaddatos">

                              
                                <tr >

                                    <th colspan="6" class="w-largo-sm border-table thead-light-dark font-weight-bold" >
                                        <!-- <label>Encogimientos TSC</label> <br>
                                        <label>Textil 3ra Lavada</label> -->
                                        Encogimientos TSC Textil 3ra Lavada
                                    </th>
                                    <th colspan="5" class="w-largo-sm-sm border-table thead-light-dark">
                                        <!-- <label>Encogimientos Estandar </label> <br>
                                        <label>3ra Lavada</label>  -->
                                        Encogimientos Estandar 3ra Lavada

                                    </th>
                                    <th colspan="7" class="w-largo-md border-table thead-light-dark">
                                        Encogimientos reales TSC 1ra Lavada
                                        <!-- <label>Encogimientos reales TSC </label> <br>
                                        <label>1ra Lavada</label> -->
                                    </th>
                                    <th colspan="7" class="w-largo-md border-table thead-light-success">
                                        Encogimientos reales TSC  3ra Lavada
                                        <!-- <label>Encogimientos reales TSC  </label> <br> -->
                                        <!-- <label>3ra Lavada</label> -->
                                    </th>
                                    <th rowspan="2" class="w-mediano border-table" data-field="col_43">
                                        Comentario Testing
                                        <!-- <label>Comentario </label> <br> -->
                                        <!-- <label>Testing</label> -->
                                    </th>
                                    <th colspan="4" class="w-mediano-lg border-table thead-light-dark">
                                        Encogimiento de Paño
                                        <!-- <label>Encogimiento </label> <br> -->
                                        <!-- <label>de Paño</label> -->
                                    </th>
                                    <th colspan="3" class="w-mediano-md border-table thead-light-success">Molde Usar</th>

                                    <th colspan="2" class="w-mediano-md border-table thead-light-success">Molde de Paño Lavado</th>
                                    <th rowspan="2" class="w-mediano-md-sm border-table" data-field="col_57">
                                        Versión Molde
                                    </th>

                                    <!-- AGREGADO -->
                                    <th colspan="6" class="w-largo-sm border-table thead-light-dark font-weight-bold">Primera Lavada Moldes</th>
                                    <!-- END AGREGADO  -->

                                    <th colspan="3" class="w-largo-sm border-table thead-light-dark">Prueba de Encogimiento</th>
                                    <!-- <th colspan="3" class="w-mediano-md border-table thead-light-dark" >Factor de Corrección</th> -->
                                    <th rowspan="2" class="w-mediano-md-sm border-table" data-field="col_57">
                                        Observación de Liberación
                                    </th>
                                    <th rowspan="2" class="w-mediano-md border-table" data-field="col_58">Liberado</th>

                                </tr>

                                <tr >

                                    <th class="border-table w-mediano-sm" >
                                        Hilo
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_19">
                                        Tra.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_20">
                                        Den.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_21">
                                        Anc.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_22">
                                        ° Inc.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_23">
                                        Rev.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_24">
                                        Hilo
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_25">
                                        Tra.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_26">
                                        Den. B/W
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_27">
                                        Anc.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_28">
                                        Rev.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_29">
                                        Hilo
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_30">
                                        Tra.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_31">
                                        Den.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_32">
                                        R. 1
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_33">
                                        R. 2
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_34">
                                        R. 3
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_35">
                                        ° Inc.
                                    </th>

                                    <th class="border-table w-mediano-sm" data-field="col_36">
                                        Hilo
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_37">
                                        Tra.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_38">
                                        Den.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_39">
                                        R. 1
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_40">
                                        R. 2
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_41">
                                        R. 3
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_42">
                                        ° Inc.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_44">
                                        Hilo
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_45">
                                        Tra.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_46">
                                        °Incli. B/W
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_47">
                                        °Incli. A/W
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_48">
                                        Hilo
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_49">
                                        Tra.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_50">
                                        Man.
                                    </th>

                                    <!-- MOLDE PAÑO -->
                                    <th class="border-table w-mediano-sm" data-field="col_48">
                                        Hilo
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_49">
                                        Tra.
                                    </th>

                                    <!-- AGREGADO -->
                                    <th class="border-table w-mediano-sm" >
                                        Hilo
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_19">
                                        Tra.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_20">
                                        Den.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_21">
                                        ° Inc Bw.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_22">
                                        ° Inc Aw.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_23">
                                        Rev.
                                    </th>
                                    <!-- END AGREGADO -->


                                    

                                    <th class="border-table w-mediano-sm-lg" data-field="col_51">
                                        Molde Usado H / T / M
                                    </th>
                                    <th class="border-table w-mediano" data-field="col_52">
                                        Observación
                                    </th>
                                    <th class="border-table w-mediano-sm-lg" data-field="col_53">
                                        Resultados de prueba
                                    </th>
                                    <!-- <th class="border-table w-mediano-sm" data-field="col_54">
                                        Hilo
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_55">
                                        Tra.
                                    </th>
                                    <th class="border-table w-mediano-sm" data-field="col_56">
                                        Man.
                                    </th> -->

                                </tr>
                            </thead>

                            <tbody class="tbodydatos text-center" id="tbodydatos2">

                                <?php if(isset($responsefichas)):?>                                            

                                    <?= $datostablasegunda; ?>

                                            
                                <?php endif;?>
                            
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        
        <!-- FORM ENVIO -->
        <form action="/tsc/controllers/auditex-moldes/encogimientoscorte.controller.php" method="GET" id="frmreporteexportar" target="_blank">
            <input type="hidden" name="operacion" value="setexportarmoldes">

            <!-- VALORES DE REPORTE -->
            <input type="hidden" name="frFechaI" value="<?=  $fecini; ?>">
            <input type="hidden" name="frFechaF" value="<?=  $fecfin; ?>">
            <input type="hidden" name="cliente" value="<?=  $cliente; ?>">
            <input type="hidden" name="partida" value="<?=  $partida; ?>">
            <input type="hidden" name="ficha" value="<?=  $ficha; ?>">
            <input type="hidden" name="estcli" value="<?=  $estcli; ?>">
            <input type="hidden" name="articulo" value="<?=  $articulo; ?>">
            <input type="hidden" name="programa" value="<?=  $programa; ?>">
            <input type="hidden" name="estatus" value="<?=  $estatus; ?>">
            <input type="hidden" name="esttsc" value="<?=  $esttsc; ?>">
            <input type="hidden" name="color" value="<?=  $color; ?>">
            <input type="hidden" name="encogimiento" value="<?=  $encogimiento; ?>">
            <input type="hidden" name="frFechaILiberacion" value="<?=  $fecinilib; ?>">
            <input type="hidden" name="frFechaFLiberacion" value="<?=  $fecfinlib; ?>">
            <input type="hidden" name="usuliberacion" value="<?=  $usuliberacion; ?>">

        </form>

        <!-- </div> -->

        <!-- MODAL PARA REGISTRO DE RESULTADOS DE PRUEBA DE ENCOGIMIENTO -->
        <?php require_once 'modalresultadoprueba.php'; ?>

        <!-- Ventanita para agregar ver los moldes disponibles -->
        <?php require_once 'modalpruebaencogimiento.php'; ?>

        <!-- MODAL OBSERVACIONES  -->
        <?php require_once 'modalobservacionencogimiento.php'; ?>

        <!-- Ventanita para agregar encogimientos -->
        <?php require_once 'modalmoldeusar.php'; ?>

        <!-- Ventanita para agregar observacion -->
        <?php require_once 'modalobservacion.php'; ?>

        <!-- Ventanita para agregar observacion de liberacion -->
        <?php require_once 'modalobservacionliberacion.php'; ?>


        <!-- Ventanita para agregar imagenes -->
        <?php require_once 'modalestadomoldaje.php'; ?>

        
        <!-- MODAL PARA HISTORIAL DE ESTADOS -->
        <?php require_once 'modalhistorialestados.php'; ?>

        <!-- MODAL PARA MOLDE DE PAÑOS -->
        <?php require_once 'modalmoldepanousar.php'; ?>

        <!-- MODAL PARA VERSION DEL MOLDE -->
        <?php require_once 'modalversionmolde.php'; ?>



         <!-- modalresultadoprueba -->
        <!-- SCRIPTS -->
        <?php require_once '../../../plantillas/script.view.php'; ?>

        <!-- HEAD FIXED -->
        <!-- <script src="../../../libs/fixed-header-table/js/jquery.fixedheadertable.min.js"></script> -->

        <!-- DATATABLE -->
        <!-- <script src="/tsc/libs/js/datatables-fixed/dataTables.fixedColumns.min.js"></script> -->

        <script src="../../js/encogimientocorte/moldaje.js"></script>
        <script src="../../js/encogimientocorte/moldaje_imagenes.js"></script>



        <!-- <script src="../../../libs/bootstraptable/js/bootstrap-table.min.js"></script> -->
        <!-- <script src="../../../libs/bootstraptable/js/bootstrap-table-fixed-columns.min.js"></script> -->
        <!-- <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js"></script> -->

        <!-- MDB -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>


        <!-- SCRIPTS -->
        <script>
            // CREAMOS VARIABLES
            let FICHA       = null;
            let ESTILOTSC   = null;
            let PARTIDA     = null;
            let FILA        = null;
            let LOTEFICHA   = null;
            let USUARIO     = "<?php echo $_SESSION["user"];?>";
            let frmbusqueda                     = document.getElementById("frmbusqueda");
            let frmpruebaencogimiento           = document.getElementById("frmpruebaencogimiento");
            let frmobservacionencogimiento      = document.getElementById("frmobservacionencogimiento");
            let frmobservacionliberacion        = document.getElementById("frmobservacionliberacion");
            let frmresultadopruebaencogimiento  = document.getElementById("frmresultadopruebaencogimiento");
            let frmestadosmoldaje               = document.getElementById("frmestadosmoldaje");
            let frmreporteexportar              = document.getElementById("frmreporteexportar");
            let frmmoldepanousar                = document.getElementById("frmmoldepanousar");
            let frmversionmolde                 = document.getElementById("frmversionmolde");
            let frmmoldeprimeralavada           = document.getElementById("frmmoldeprimeralavada");


            var tableCont = document.querySelector('#cardbodygeneral');
            let DATAPRUEBA = null;


            // FUNCION QUE SE EJECUTA CUANDO EL DOCUMENTO CARGA POR COMPLETO
            window.addEventListener("load", async () => {

                // ESTADOS DE MOLDAJE
                await getestadosmoldaje(<?= $p_estado; ?>);

                // USUARIO DE LIBERACION
                await getusuarioliberacion("<?= $p_usuliberacion; ?>");

                // GET CLIENTES
                await getclientes("<?= $p_cliente; ?>");

                tableCont.addEventListener('scroll',scrollHandle);

                // POPOVER
                $('[data-toggle="popover"]').popover()

                // TOOL TIP
                $('[data-toggle="tooltip"]').tooltip()

                // OCULTAMOS CARGA
                $(".loader").fadeOut("slow");



            });

            function scrollHandle (e){
                var scrollTop = this.scrollTop;
                theaddatos
                // this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
                this.querySelector('#theaddatos').style.transform = 'translateY(' + scrollTop + 'px)';
                this.querySelector('#theaddatos_2').style.transform = 'translateY(' + scrollTop + 'px)';

            }

            
            // CUANDO DAMOS CLICK EN GUARDAR ENCOGIMIENTO DISPONIBLE
            $("#btnguardarmoldeusar").click(async function() {

                MostrarCarga("Cargando");

                // GUARDAMOS RADIOS
                let radios      = $(".checkmoldeusar");
                let checkfichas = $(".checkfichastbodyfichasasociadas");


                let radioseleccionado = null;

                for (let radio of radios) {

                    if ($(radio).prop("checked")) {
                        radioseleccionado = radio;
                        break;
                    }

                }

                if (radioseleccionado != null) {

                    
                    let hilo = $(radioseleccionado).data("hilo");
                    let trama = $(radioseleccionado).data("trama");
                    let manga = $(radioseleccionado).data("manga");

                    
                    // DATA DE LAS FICHAS SELECCIONADAS
                    for(let item of checkfichas){

                        if ($(item).prop("checked")) {
                            // radioseleccionado = radio;
                            let ficha       = $(item).data("ficha");
                            let estilotsc   = $(item).data("estilotsc");
                            let fila        = $(item).data("fila");
                            let loteficha        = $(item).data("lote");



                            // console.log(ficha,estilotsc);

                            // ENVIAMOS DATOS A LA FUNCION
                            await GuardarEncogimiento(hilo, trama, manga,ficha,estilotsc,loteficha);

                            // ASIGNAMOS DATOS
                            $(".hilousar"+fila).removeClass("btn-primary");
                            $(".hilousar"+fila).addClass("btn-success");
                            $(".hilousar"+fila).text(hilo+"%");
                            $(".tramausar"+fila).text(trama+"%");
                            $(".mangausar"+fila).text(manga+"%");

                        }

                    }

                    

                    
                    // OCULTAMOS MOLDE DISPONIBLE
                    $("#modalmoldeusar").modal('hide');
                    OcultarCarga();

                    // await BuscarEnCorte();

                } else {
                    Advertir("Seleccione una opcion");
                }

            });

            // ABRE MODAL PARA SELECCIONAR ENCOGIMIENTOS A LA FICHA
            $(".tbodydatos").on('click', '.selectmoldeusar', async function() {

                MostrarCarga();

                // OBTENEMOS DATOS DE LA FICHA
                let estilotsc       = $(this).data("estilotsc");
                let estilocliente   = $(this).data("estilocliente");
                FICHA               = $(this).data("ficha");
                ESTILOTSC           = $(this).data("estilotsc");
                FILA                = $(this).data("fila");
                LOTEFICHA           = $(this).data("lote");

                // ASIGANMOS DATOS DE LA FICHA AL MODAL
                $("#lblestilotsc_moldeusar").text("ESTILO TSC: " + estilotsc);
                $("#lblestilocliente_moldeusar").text("ESTILO CLIENTE: " + estilocliente);

                // BUSCAMOS ENCOGIMIENTOS DISPONIBLES
                await BuscarEstiloDisponible(estilotsc);
                await getFichasReporte();
                // console.log(fichas);

                // ABRIMOS MODAL CON LOS DATOS CARGADOS
                $("#modalmoldeusar").modal("show");

                OcultarCarga();

            });

            // Permite visualizar una ventanita
            $(".tbodydatos").on('click', '.selectpruebaencogimiento', function() {

                FILA    = $(this).data("fila");
                FICHA   = $(this).data("ficha");
                ESTILOTSC   = $(this).data("estilotsc");
                LOTEFICHA           = $(this).data("lote");

                let hilousado = $(this).data("hilousado");
                let tramausado = $(this).data("tramausado");
                let mangausado = $(this).data("mangausado");

                // hilousado = hilousado.replace("%", "");
                // tramausado = tramausado.replace("%", "");
                // mangausado = mangausado.replace("%", "");

                $("#txthilo_pruebaencogimiento").val(hilousado);
                $("#txttrama_pruebaencogimiento").val(tramausado);
                $("#txtmanga_pruebaencogimiento").val(mangausado);

                $("#modalpruebaencogimiento").modal("show");
            });

            // MUESTRA SI LLEVA PRUEBA DE ENCOGIMIENTO
            $(".tbodydatos").on('change', '.checkpruebaencogimiento', async function() {

                MostrarCarga("Cargando...");

                let ficha   = $(this).data("ficha");
                let partida = $(this).data("partida");
                FILA        = $(this).data("fila");
                let check   = $(this).prop("checked");
                let estilotsc   = ESTILOTSC;
                let usuario     = USUARIO;
                LOTEFICHA           = $(this).data("lote");
                check = check ? 1 : 0;

                let response = await get("auditex-moldes", "encogimientoscorte", "set-actualizarpruebaencogimiento", {
                    ficha,
                    check,
                    estilotsc,
                    usuario,
                    partida,
                    loteficha:LOTEFICHA
                });

                if(check){
                    $(".pruebaencogimiento"+FILA).removeClass("d-none");
                }else{
                    $(".pruebaencogimiento"+FILA).addClass("d-none");
                }

                OcultarCarga();

            });
 
            // ABRE MODAL CON LAS OBSERVACIONES
            $(".tbodydatos").on('click', '.addobservacionencogimiento', function() {
                FICHA   = $(this).data("ficha");
                FILA    = $(this).data("fila");
                ESTILOTSC   = $(this).data("estilotsc");
                
                let observacion = $(this).data("observacion");

                $("#txtobservacionencogimiento").val(observacion);

                $("#modalobservacionencogimiento").modal("show");
            });

            // ABRE MODAL CON LOS ESTADOS DE MOLDAJE
            $(".tbodydatos").on('click', '.estmoldaje', function() {
                FICHA       = $(this).data("ficha");
                FILA        = $(this).data("fila");
                ESTILOTSC   = $(this).data("estilotsc");
                LOTEFICHA           = $(this).data("lote");
                let idestado = $(this).data("idestado");
                // let observacion = $(this).data("observacion");

                $("#cboestadosmoldaje").val(idestado);
                // $("#txtobservacionencogimiento").val(observacion);

                $("#modalestadomoldaje").modal("show");
            });

            // Permite visualizar ventanita de observación liberación
            $(".tbodydatos").on('click', '.observacionliberacion', function() {

                MostrarCarga();

                FICHA   = $(this).data("ficha");
                FILA    = $(this).data("fila");
                ESTILOTSC   = $(this).data("estilotsc");
                let observacion = $(this).data("observacion");
                LOTEFICHA           = $(this).data("lote");

                getFichasReporte("tbodyfichasasociadasobservacion").then(response => {

                    $("#txtobservacionliberacion").val(observacion);
                    $("#modalobservacionliberacion").modal("show");

                    OcultarCarga();

                }).catch(error =>{
                    Advertir("Ocurrio un error");
                });


            });
            
            // Permite visualizar una ventanita
            $(".tbodydatos").on('click', '.resultadopruebaencogimiento', async function() {

                MostrarCarga();

                FICHA   = $(this).data("ficha");
                PARTIDA = $(this).data("partida");
                ESTILOTSC   = $(this).data("estilotsc");
                LOTEFICHA           = $(this).data("lote");

                await getDatosPruebaEncogimiento();                    
                $("#modalresultadoprueba").modal("show");

                OcultarCarga();


            });

            // VISUALIZA EL HISTORIAL DE ESTADOS
            $(".tbodydatos").on('click', '.fechaliberacion', function() {

                let ficha = $(this).data("ficha");

                get("auditex-moldes", "encogimientoscorte", "get-historialestados", {
                    ficha
                },true).then(response => {

                    $("#tbodyhistorialestados").html(response); 
                    $("#modalhistorialestados").modal("show");  

                }).catch(error => {

                })

            });          
            

            // EXPORTAR EXCEL
            $("#btnexportar").click(function(){

                frmreporteexportar.submit();

            });


            // ABRE MODAL PARA SELECCIONAR ENCOGIMIENTOS A LA FICHA
            $(".tbodydatos").on('click', '.selectmoldepanousar', async function() {

                MostrarCarga();

                // OBTENEMOS DATOS DE LA FICHA
                let estilotsc       = $(this).data("estilotsc");
                let estilocliente   = $(this).data("estilocliente");

                let hilo            = $(this).data("hilo");
                let trama           = $(this).data("trama");

                FICHA               = $(this).data("ficha");
                ESTILOTSC           = $(this).data("estilotsc");
                FILA                = $(this).data("fila");
                LOTEFICHA           = $(this).data("lote");
                

                getFichasReporte("tbodyfichasasociadas_moldepano").then(response => {


                    $("#txthilomoldepanousar").val(hilo);
                    $("#txttramamoldepanousar").val(trama);

                    // ABRIMOS MODAL CON LOS DATOS CARGADOS
                    $("#modalmoldepanousar").modal("show");
                    OcultarCarga();

                }).catch(error =>{
                    Advertir("Ocurrio un error");
                });

            });


            // ABRE MODAL PARA SELECCIONAR PRIMERA LAVADA DE MOLDES 
            $(".tbodydatos").on('click', '.selectmoldeprimeralavada', async function() {

                MostrarCarga();

                // OBTENEMOS DATOS DE LA FICHA
                let estilotsc       = $(this).data("estilotsc");
                let estilocliente   = $(this).data("estilocliente");


                let hilo                = $(this).data("hilo");
                let trama               = $(this).data("trama");
                let densidad            = $(this).data("densidad");
                let inclinacionbw       = $(this).data("inclinacionbw");
                let inclinacionaw       = $(this).data("inclinacionaw");
                let revirado            = $(this).data("revirado");


                FICHA               = $(this).data("ficha");
                ESTILOTSC           = $(this).data("estilotsc");
                FILA                = $(this).data("fila");
                LOTEFICHA           = $(this).data("lote");


                getFichasReporte("tbodyfichasasociadas_moldeprimeralavada").then(response => {


                    $("#txthilomoldeprimeralavada").val(hilo);
                    $("#txttramamoldeprimeralavada").val(trama);
                    $("#txtdensidadmoldeprimeralavada").val(densidad);
                    $("#txtinclinacionbwmoldeprimeralavada").val(inclinacionbw);
                    $("#txtinclinacionawmoldeprimeralavada").val(inclinacionaw);
                    $("#txtreviradomoldeprimeralavada").val(revirado);
                    

                    // ABRIMOS MODAL CON LOS DATOS CARGADOS
                    $("#modalmoldeprimeralavada").modal("show");
                    OcultarCarga();

                }).catch(error =>{
                    Advertir("Ocurrio un error");
                });

            });


            // ABRE MODAL PARA VERSION DE MOLDE
            $(".tbodydatos").on('click', '.selectversionmolde', async function() {

                MostrarCarga();

                // OBTENEMOS DATOS DE LA FICHA
                let estilotsc       = $(this).data("estilotsc");
                let estilocliente   = $(this).data("estilocliente");

                let moldeversion            = $(this).data("moldeversion");
                // let trama           = $(this).data("trama");

                FICHA               = $(this).data("ficha");
                ESTILOTSC           = $(this).data("estilotsc");
                FILA                = $(this).data("fila");
                LOTEFICHA           = $(this).data("lote");

                getFichasReporte("tbodyfichasasociadas_versionmolde").then(response => {

                    $("#txtversionmolde").val(moldeversion);


                    // ABRIMOS MODAL CON LOS DATOS CARGADOS
                    $("#modalversionmolde").modal("show");

                    OcultarCarga();

                }).catch(error =>{
                    Advertir("Ocurrio un error");
                });


               

            });

        </script>

</body>

</html>