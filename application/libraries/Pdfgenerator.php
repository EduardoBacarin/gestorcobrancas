<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once("./vendor/dompdf/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator {

    public function generate($html, $filename='file', $stream = true, $download = 0, $paper = 'A4', $orientation = "portrait") {
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        //$papel = array(0,0,355.00,866.20);
        //$papel = array(0,0,280.630,695.276);
        $papel = array(0,0,290.630,980);

        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf", array("Attachment" => $download));
        } else {
            return $dompdf->output();
        }
    }
}