<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserRegister extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this->text, $this->user, $this->email);
        return $this->from(env('MAIL_USERNAME'), config('mail.from.name', 'Azimut Web Technologies'))
            ->to('jaronu42@gmail.com')
            //->to()
            ->subject('[Nuevo registro en la web.] ')
            ->view('mail.user_register')
            ->with([
                'user'  => $this->user,
            ]);
        
    }
}
