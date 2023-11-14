<?php

namespace App\Models;
use Illuminate\Mail\Mailable;


class VerificationCodeMail extends Mailable
{
    public $verificationCode;

    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        return $this->view('Email\verification_code')
                    ->subject('Verification Code');
    }
}