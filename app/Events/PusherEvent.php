<?php

namespace App\Events;

//利用したいデータベースを参照
use App\Models\Chats;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherEvent implements ShouldBroadcast
{
    use SerializesModels;

    //利用する変数追加
    public $chatsModel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chats $chatsModel)
    {
        $this->chatsModel = $chatsModel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channelName');
    }
}
