<?php

namespace App\Service;

use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;

class PdfService
{
    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    public function showPdfFile($html)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        $output = $this->dompdf->output();

        return new Response(
            $output,
            200,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function generatePdfFile($html)
    {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        $output = $this->dompdf->output();

        return $output;
    }
}
