<?php

namespace App\Listeners;

use App\Events\ItemEditedEvent;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TrackChanges
{
    /**
     * Track changes of item in changes table
     *
     * @param  ItemEditedEvent  $event
     * @return void
     */
    public function handle(ItemEditedEvent $event)
    {
        $item = $event->item;
        $user = $event->user;
        
        $changes = $item->getDirty();

        foreach ($changes as $field => $newValue) {
            // Create new Change for each field modified
            $item->changes()->create([
                'badge_number' => $user->badge_number,
                'field' => $field,
                'old' => $item->getOriginal()[$field],
                'new' => $newValue
            ]);
        }
    }
}
