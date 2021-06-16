<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Anounces;

class newAdd
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $anounce;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Anounces $anounces)
    {
        $this->anounce = $anounces;
    }

    
}
