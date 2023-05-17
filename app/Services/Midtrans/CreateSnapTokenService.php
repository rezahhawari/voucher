<?php

namespace App\Services\Midtrans;

use App\Models\Transaction;
use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    // protected $order;
    protected $transaction;
    protected $price;
    protected $qty;

    public function __construct($transaction, $price, $qty)
    {
        parent::__construct();
        // $this->invoice = $inv;
        // $this->price = $pr
        $this->transaction = $transaction;
        $this->price = $price;
        $this->qty = $qty;
    }

    public function getSnapToken()
    {
        $data = Transaction::where('id', $this->transaction->id)->with('customer', 'venue', 'period')->first();
        $params = [
            'transaction_details' => [
                'order_id' => $this->transaction->transaction_id,
                'gross_amount' => $this->price,
            ],
            'item_details' => [
                [
                    'id' => $this->transaction->period_id,
                    'price' => $data->period->period_price,
                    'quantity' => $this->qty,
                    'name' => $data->period->period . ' (Speed :' . $data->period->speed . 'Mbps)',
                ],
            ],
            'customer_details' => [
                'first_name' => $data->customer->name,
                'email' => $data->customer->email,
                'phone' => $data->customer->phone_number,
            ],
            'callbacks' => [
                'finish' => 'http://127.0.0.1:8000/getvoucher',
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
