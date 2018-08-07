<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReminderEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $userToSendEmails = [];
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        //
        $this->userToSendEmails = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        foreach ($this->userToSendEmails as $k => $v) {
            $userData = User::find($k);
            $data['user_name'] = $userData->user_name;
            $data['email'] = $userData->email;
            $data['products'] = $v;

            \Mail::send('admin.emails.order', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['user_name'])->subject('new order');
            });
        }
    }
}
