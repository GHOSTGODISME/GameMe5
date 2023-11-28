<?php

namespace App\Models;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Dompdf\Dompdf;
use Carbon\Carbon;

class QuizSummaryEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $pdf;

    public function __construct(DomPDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function build()
    {
        $generatedDate = Carbon::now()->format('Y-m-d H:i:s');

        return $this->view('Email\quiz-summary-email')
                    ->subject('Your Quiz Summary')
            ->attachData($this->pdf->output(), "quiz_summary_{$generatedDate}.pdf");
    }
}
