<?php

namespace App\Listeners;

use App\PierMigration;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionCancelled;

class SubscriptionTerminated
{
    /**
     * @param  SubscriptionCancelled  $event
     */
    public function handle($event)
    {
        $entry = PierMigration::browse("FancyMapsSubscriptions", [
            "whereSubscription_id" => $event->subscription_id,
            "limit" => 1
        ]);

        if($entry != null && $entry->_id != null){
            PierMigration::updateRow("FancyMapsSubscriptions", $entry->_id, [
                "status" => $event->status == null || $event->status == "deleted" ? "cancelled" : $event->status
            ]);
        }
    }
}