<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SurveyResponseEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $imageData;


    public function __construct($imageData)
    {
        $this->imageData = $imageData;
    }

    public function build()
    {
        Log::info("check");
        Log::info($this->imageData);
        $generatedDate = Carbon::now()->format('Y-m-d H:i:s');
        $decodedImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->imageData));
        return $this->view('Email\survey-response-email')
            ->attachData($decodedImageData,  "survey_summary_{$generatedDate}.jpg", [
                'mime' => 'image/jpeg',
            ])
            ->subject('Your Survey Response');
    }
}
