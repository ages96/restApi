<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;

use App\Mail\FormEmail;

class SubmitEmailSub extends Job
{

    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->data["receiver"])->send(new FormEmail($this->data));
    }
}