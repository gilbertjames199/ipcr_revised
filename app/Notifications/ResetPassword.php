<?php

namespace App\Notifications;

use App\Models\UserEmployeeCredential;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $token;
    public $user;
    public $my_one;

    public function __construct($token, $user, $my_one)
    {
        //
        $this->token = $token;
        $this->user = $user;
        $this->my_one = $my_one;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // $serverIp = Request::server('SERVER_ADDR');
        $hostname = gethostname();
        $serverIp = gethostbyname($hostname);

        $port = Request::server('SERVER_PORT');
        $baseUrl = "http://{$serverIp}";
        if ($port != 80 && $port != 443) {
            $baseUrl = $baseUrl . ":{$port}";
        }
        // $baseUrl = $baseUrl . "?otp=" . $this->my_one;
        // $url = url(config('app.url') . route('password.reset', $this->token, false));

        $url = url($baseUrl . route('password.reset', $this->token, false));

        $user = UserEmployeeCredential::where('otp', $this->my_one)->first();
        $email_clause = "?email=" . $user->email;
        $url = $url . $email_clause;
        if ($user) {
            if ($user->email) {
                $this->upsertPasswordReset($user->email, $this->token);
            }
        }
        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->view('vendor.notifications.email', ['url' => $url, 'user' => $this->user, 'my_one' => $this->my_one]);
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
    }

    function upsertPasswordReset($email, $token)
    {
        $currentDateTime = Carbon::now();
        $hashedToken = bcrypt($token);
        // Check if email exists in the password_resets table
        $emailExists = DB::table('password_resets')
            ->where('email', $email)
            ->exists();
        if ($this->verifyResetToken($email, $token) == true) {
        }
        if ($emailExists) {
            // Update the existing record
            DB::table('password_resets')
                ->where('email', $email)
                ->update([
                    'token' => $hashedToken,
                    'created_at' => $currentDateTime,
                ]);
        } else {
            // Insert a new record
            DB::table('password_resets')
                ->insert([
                    'email' => $email,
                    'token' => $hashedToken,
                    'created_at' => $currentDateTime,
                ]);
        }
    }

    function verifyResetToken($email, $plainToken)
    {
        $record = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if ($record && Hash::check($plainToken, $record->token)) {
            // Token is valid, proceed with password reset
            return true;
        }

        return false;
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
