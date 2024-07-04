<?php

namespace Imrancse94\Grocery\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Imrancse94\Grocery\app\Mail\PreOrderUserConfirmation;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to_email;
    private $mailable;
    /**
     * Create a new job instance.
     */
    public function __construct($to_email,Mailable $mailable)
    {
        $this->to_email = $to_email;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->to_email)->send($this->mailable);
    }
}
