<?php

namespace App\Listeners;

use App\PierMigration;
use Illuminate\Support\Facades\Log;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionPaymentSucceeded;

class SubscriptionPaid
{
    /**
     * @param  SubscriptionPaymentSucceeded  $event
     */
    public function handle($event)
    {
        sleep(10);

        // if ($event->status !== 'active') {
        //     // I decided to handle other states manually.
        //     return;
        // }

        $entryId = PierMigration::browse("FancyMapsSubscriptions", [
            "whereSubscription_id" => $event->subscription_id,
            "limit" => 1,
            "pluck" => "_id"
        ]);

        if($entryId != null){
            PierMigration::updateRow("FancyMapsSubscriptions", $entryId, [
                "receipt_number" => $event->order_id,
            ]);
        }
        else{
            Log::info([
                "type" => "PaymentSuccess", 
                "entry" => $event->subscription_id, 
                "receipt_number" => $event->order_id,
            ]);

            PierMigration::insertRow("FancyMapsSubscriptions", [
                "receipt_number" => $event->order_id,
                "status" => "active",
                "end_date" => $event->next_bill_date,
                "email" => $event->email,
                "subscription_id" => $event->subscription_id,
                "plan_id" =>  $event->subscription_plan_id,
                "update_link" => $event->update_url == null ? "update_link" : $event->update_url,
                "cancel_link" => $event->cancel_url == null ? "cancel_link" : $event->cancel_url,
            ]);
        }
    }
}