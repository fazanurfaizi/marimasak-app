<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User\User;

class PasswordResetRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    private $token;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(user $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url('/admin/password/find/'.$this->token);
        return $this->view('emails.password_reset_request')
            ->subject('Password Reset Request')
            ->with([
                'name' => $this->user->name,
                'url' => url($url)
            ]);
    }
}
