<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Generate Snap Token
     */
    public function pay(Order $order)
    {
        // samakan dengan Midtrans
        $order->midtrans_order_id = $order->order_number;
        $order->save();

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $order->total_bayar,
            ],
            'item_details' => $order->items->map(function ($item) {
                return [
                    'id' => $item->menu_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'name' => $item->menu_name,
                ];
            })->toArray(),
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payment', compact('order', 'snapToken'));
    }

    /**
     * Midtrans Webhook
     */
    public function notification(Request $request)
    {
        $payload = $request->all();

        \Log::info('Midtrans Callback', $payload);

        $order = Order::where('order_number', $payload['order_id'])->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->payment_method = $payload['payment_type'] ?? null;
        $order->midtrans_transaction_id = $payload['transaction_id'] ?? null;
        $order->payment_response = json_encode($payload);

        switch ($payload['transaction_status']) {
            case 'settlement':
                $order->status = 'paid';
                $order->paid_at = Carbon::now();
                break;

            case 'pending':
                $order->status = 'pending';
                break;

            case 'expire':
            case 'cancel':
            case 'deny':
                $order->status = 'cancelled';
                break;
        }

        $order->save();

        return response()->json(['message' => 'OK']);
    }
}
