<?php

namespace App\Listeners;

use App\Events\NewAdd;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SendNewAddNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewAdd  $event
     * @return void
     */
    public function handle(NewAdd $event)
    {
        $data = [

            'id' => $event->anounce->id,// id del nuevo anuncio
            'email' => Auth::user()->email,// email de quien lo crea, en este caso el usuario que está registrado
        ];
 
        Mail::send('mail.newAdd', $data, function($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Anuncio nuevo publicado');
            $message->from('pedidos@azimutweb.es');
        });
    }
}
