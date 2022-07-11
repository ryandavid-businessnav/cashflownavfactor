<?php
// app/Http/Controllers/SubscriptionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request) {
        $platform = request('platform');
        $receipt = null;
        $purchase_token = request('purchaseToken');
        $order_id = request('orderId');

        $user = $request->user();
        $this->verifySubscription($user, $platform, $purchase_token, $order_id, $receipt);
        return 'ok';
    }

    // next: add verifySubscription()
    private function verifySubscription($user, $platform, $purchase_token, $order_id, $receipt = null) {

        $gplay_data = [
            'gplay_order_token' => $purchase_token,
            'gplay_order_id' => $order_id,
        ];

        $user->update($gplay_data);

    }
}