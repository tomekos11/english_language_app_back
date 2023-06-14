<?php

namespace Modules\Auth\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Auth\Entities\User;

class UserLoggedIn
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public User $user)
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
