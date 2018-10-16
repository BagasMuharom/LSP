<?php

namespace App\Support\Form;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use App\Models\Uji;
use PDF;

class FormAsesmenDiri
{

    private $uji;

    private $word;

    public function __construct(Uji $uji)
    {
        $this->uji = $uji;
        $this->word = new PhpWord();
    }

    public function create()
    {
        // for ($i = 1; $i <= 3;$i++) {
        //     $section = $this->word->addSection();

        //     $section->addText(
        //         '"Learn from yesterday, live for today, hope for tomorrow. '
        //             . 'The important thing is not to stop questioning." '
        //             . '(Albert Einstein)'
        //     );
        // }

        // $writer = IOFactory::createWriter($this->word, 'Word2007');
        // $writer->save(public_path('file.docx'));
        $pdf = PDF::loadView('form.apl_02', [
            'uji' => $this->uji
        ]);
        // $font = $pdf->getDomPDF()->getFontMetrics()->get_font("helvetica", "bold");
        // $pdf->getDomPDF()->getCanvas()->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
        return $pdf->stream();
    }

    public function download()
    {

    }

}