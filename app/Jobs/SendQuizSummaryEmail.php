<?php

namespace App\Jobs;

use App\Models\QuizSummaryEmail;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendQuizSummaryEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $pdfContent;
    /**
     * Create a new job instance.
     * @param string $email
     * @param mixed $pdfContent
     */
    public function __construct($email, $pdfContent)
    {
        $this->email = $email;
        $this->pdfContent = $pdfContent;
    }

    public function handle()
    {
            $pdf = $this->generatePDF($this->pdfContent);
            Mail::to($this->email)->send(new QuizSummaryEmail($pdf));
    }

    public function generatePDF($response)
    {
        $data = json_decode($response->getContent());

        $generatedDate = Carbon::now()->format('Y-m-d H:i:s');

        // Create an instance of the Dompdf class
        $dompdf = new Dompdf();

        // (Optional) Setup the options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('enable_javascript', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        // Load HTML content (replace this with your HTML)
        $html = view('Pdf.quiz-summary-pdf-template', compact('data', 'generatedDate'))->render();
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (generates the PDF)
        $dompdf->render();

        // Output PDF
        return $dompdf;
    }

    public function failed($exception)
    {
        // Rerun the job
        $this->release(5); // Retry the job after 10 seconds
    }

}
