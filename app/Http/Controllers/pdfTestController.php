<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class pdfTestController extends Controller
{
    public function process(Request $request)
    {
        // download sample file.
        Storage::disk('local')->put('test.pdf', file_get_contents('http://www.africau.edu/images/default/sample.pdf'));

        $outputFile = Storage::disk('local')->path('output.pdf');
        // fill data
        $this->fillPDF(Storage::disk('local')->path('test.pdf'), $outputFile);
        //output to browser
        return response()->file($outputFile);
    }

    public function fillPDF($file, $outputFile)
    {
        $im = QrCode::size(50)->format('png')->generate('Make me into a QrCode!');
        $output_file = 'img/qr-code/img-' . time() . '.png';
        Storage::disk('local')->put($output_file, $im);


        $fpdi = new FPDI;
        // merger operations
        $count = $fpdi->setSourceFile($file);
        for ($i=1; $i<=$count; $i++) {
            $template   = $fpdi->importPage($i);
            $size       = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
            $left = 35;
            $top = 10;
            $text = null;
            if ($i==1) {
                $text = "esta es una prueba de radicado";
                $fpdi->Image(Storage::disk('local')->path($output_file),5,5);
            }

            $fpdi->SetFont("helvetica", "", 15);
            $fpdi->SetTextColor(153,0,153);
            $fpdi->Text($left,$top,$text);
            Storage::disk('local')->delete($output_file, $im);
        }
        return $fpdi->Output($outputFile, 'F');
    }
}
