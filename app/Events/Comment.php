<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Comment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $news_id;
    public $comment;
    public function __construct($news_id, $comment)
    {
        $this->news_id = $news_id;
        $this->comment = $comment;
    }


    public function broadcastOn(): array
    {
        return [
            'news.' . $this->news_id
        ];
    }
    public function broadcastAs()
    {
        return 'comment';
    }
}
