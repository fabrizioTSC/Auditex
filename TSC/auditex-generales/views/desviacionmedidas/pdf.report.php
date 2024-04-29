<?php

    require __DIR__.'../../../../vendor/autoload.php';


    // reference the Dompdf namespace
    use Dompdf\Dompdf;
    use Dompdf\Options;

    $dompdf = new Dompdf();
    // $options = new Options();

    // $options->set('defaultFont', 'Arial');
    // $dompdf = new Dompdf($options);

    $options = $dompdf->getOptions();
    $options->setDefaultFont('Arial');
    // $options->isJavascriptEnabled();
    $options->setIsJavascriptEnabled(true);

    $dompdf->setOptions($options);
    
    ob_start();
    include "plantilla.report.php";
    $html = ob_get_clean();

    //$html .= "<link type='text/css' rel='stylesheet' href='/tsc/libs/css/bootstrap.min.css'>";

    $dompdf->loadHtml($html);
    $dompdf->render();
    // DAMOS SALIDA
    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=Reporte_desviacion.pdf");
    echo $dompdf->output();





?>