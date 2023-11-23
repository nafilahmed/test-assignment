<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ContactMail;
use Mail;

class SendEmailQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sendMail;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sendMail,$data)
    {
        $this->sendMail = $sendMail;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new ContactMail($this->data);
        Mail::to($this->sendMail)->send($email);
    }
}
