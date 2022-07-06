<?php

namespace App\Events;

use App\Models\ServiceProvider;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeletedProviderProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $provider_id;
    public $employer_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($provider_id)
    {
        $this->provider_id = $provider_id;
        $this->employer_id = ServiceProvider::find($provider_id)->employer_id;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
