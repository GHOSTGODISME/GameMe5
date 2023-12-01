<?php

namespace App\Jobs;

use App\Models\SurveyResponseEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSurveyResponseEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $email;
    protected $imageData;
     /**
     * Create a new job instance.
     * @param string $email
     * @param mixed $imageData
     */
    public function __construct($email, $imageData)
    {
        $this->email = $email;
        $this->imageData = $imageData;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new SurveyResponseEmail($this->imageData));
    }
}
