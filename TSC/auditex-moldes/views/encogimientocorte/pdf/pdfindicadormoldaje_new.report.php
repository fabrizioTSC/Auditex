<?php

    require __DIR__.'../../../../../vendor/autoload.php';


    // reference the Dompdf namespace
    use Dompdf\Dompdf;
    use Dompdf\Options;

    $dompdf = new Dompdf();
    // $options = new Options();

    // $options->set('defaultFont', 'Arial');
    // $dompdf = new Dompdf($options);

    $options = $dompdf->getOptions();
    $options->setDefaultFont('Arial');
    $dompdf->setOptions($options);
    
    ob_start();
    include "plantilla.report.php";
    $html = ob_get_clean();

    //$html .= "<link type='text/css' rel='stylesheet' href='/tsc/libs/css/bootstrap.min.css'>";

    $dompdf->loadHtml($html);
    $dompdf->render();
    // DAMOS SALIDA
    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=documento.pdf");
    echo $dompdf->output();


    // instantiate and use the dompdf class
    // $dompdf->loadHtml('hello world');

    // // (Optional) Setup the paper size and orientation
    // $dompdf->setPaper('A4', 'landscape');

    // // Render the HTML as PDF
    // $dompdf->render();

    // Output the generated PDF to Browser
    // $dompdf->stream("FicheroEjemplo.pdf");


   



?>