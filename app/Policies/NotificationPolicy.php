<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the notification.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Notifications\DatabaseNotification $databaseNotification
     *
     * @return void
     */
    public function update(User $user, DatabaseNotification $databaseNotification)
    {
        return $user->id === $databaseNotification->notifiable_id; // only the owner of the notification can update it
    }
}
