<?php

namespace Modules\Auth\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Auth\Entities\User;

class UserRegistered
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public User $user, public array $userData)
    {
        //
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
