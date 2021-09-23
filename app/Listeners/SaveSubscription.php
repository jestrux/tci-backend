<?php

namespace App\Listeners;

use App\PierMigration;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionCreated;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionUpdated;

class SaveSubscription
{
    /**
     * @param  SubscriptionCreated|SubscriptionUpdated  $event
     */
    public function handle($event)
    {
        // if ($event->status !== 'active') {
        //     // I decided to handle other states manually.
        //     return;
        // }

        // prevent mulitple entry on same subscription

        // sleep(8);

        $entryId = PierMigration::browse("FancyMapsSubscriptions", [
            "whereSubscription_id" => $event->subscription_id,
            "limit" => 1,
            "pluck" => "_id"
        ]);
        
        if($entryId != null){
            $details = [
                "cancel_link" => $event->cancel_url,
                "update_link" => $event->update_url
            ];

            if($event->status != null)
                $details["status"] = $event->status;

            PierMigration::updateRow("FancyMapsSubscriptions", $entryId, $details);

            return;
        }
        else{
            Log::info([
                "type" => "SubscriptionCreated", 
                "entry" => $event->subscription_id, 
                "cancel_link" => $event->cancel_url, 
                "update_link" => $event->update_url
            ]);
        }

        PierMigration::insertRow("FancyMapsSubscriptions", [
            "end_date" => $event->next_bill_date,
            "email" => $event->email,
            "subscription_id" => $event->subscription_id,
            // "receipt_number" => $event->order_id,
            // "receipt_number" => "fancymapsunpaidreceipt",
            "cancel_link" => $event->cancel_url,
            "update_link" => $event->update_url,
            "plan_id" =>  $event->subscription_plan_id,
            "status" => $event->status == null ? "active" : $event->status,
            // "transaction" => collect($event)->toJson()
        ]);
    }
}