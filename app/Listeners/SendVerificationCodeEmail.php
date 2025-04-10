<?php

namespace App\Listeners;

use App\Events\SendVerificationCode;
use App\Mail\SendCodeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendVerificationCode $event): void
    {
        Mail::to($event->user['email'])->send(new SendCodeMail($event->code));
    }

}
