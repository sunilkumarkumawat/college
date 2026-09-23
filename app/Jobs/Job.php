<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MyMail;

class Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $email = new Mail();
        // Mail::to($this->details['email'])->send($email);
        $details = $this->details;
             MyMail::send('email_print.test', $details, function($message) use ($details) {
                    $message->from(getenv('MAIL_FROM_ADDRESS'));
                    $message->to($this->details['email']);
                    $message->subject('Test Mail');
               });       
    }
}