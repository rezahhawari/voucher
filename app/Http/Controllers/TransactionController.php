<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Support\Facades\Crypt;

class TransactionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function payment(Request $request, Transaction $transaction)
    {
        // Http::withHeaders([
        //     'Accept' => 'application/json',
        //     'Content-Type' => 'application/json',
        //     'Authorization' => 'Basic '. base64_encode(env('MIDTRANS_SERVERKEY').':'),
        // ])
        // $period = explode('|', $request->paketwifi);
        $transaction->period_id = $request->paketwifi;
        $transaction->save();
        $midtrans = new CreateSnapTokenService($transaction, $request->total, $request->qty);
        $snapToken = $midtrans->getSnapToken();
        // $transaction->
        $transaction->qty = $request->qty;
        $transaction->snap_token = $snapToken;
        $transaction->save();

        return array('status' => 'success', 'snaptoken' => $snapToken);
    }

    public function storepayment(Request $request)
    {
        $transaction = Transaction::where('transaction_id', $request->order_id)->first();
        $transaction->payment_method = $request->payment_method;
        $transaction->amount = $request->amount;
        $transaction->status = 1;
        $transaction->save();
        return array('status' => 'success', 'message' => 'Pembayaran berhasil diverifikasi', 'order_id' => Crypt::encrypt($transaction->id));
    }


}
