<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScoresUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $quizId;
    public $score;

    public function __construct($score)
    {
        // $quizId moet nog voor de ($score) komen
        // $this->quizId = $quizId;
        $this->score = $score;
    }

    public function broadcastOn()
    {
        return new Channel('quiz-' . $this->quizId);
    }
}
