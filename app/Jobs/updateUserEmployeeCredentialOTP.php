<?php

namespace App\Jobs;

use App\Models\UserEmployeeCredential;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class updateUserEmployeeCredentialOTP implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $username;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $user_emp = UserEmployeeCredential::where('username', $this->username)->first();
        if ($user_emp) {
            $user_emp->otp = '';
            $user_emp->save();
        }
    }
}
