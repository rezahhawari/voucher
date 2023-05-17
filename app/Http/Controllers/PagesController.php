<?php

namespace App\Http\Controllers;

use App\Mail\VoucherMail;
use App\Models\Period;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Venue;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function home()
    {
        return view('pages.index',[
            'venue' => Venue::all(),
        ]);
    }

    public function customerdetail(Transaction $transaction)
    {
        return view('pages.customerdetail', [
            'transaction' => $transaction,
            'venue' => Venue::where('id', $transaction->venue_id)->first(),
            'duration' => Period::where('venue_id', $transaction->venue_id)->get(),
        ]);
    }

    public function storeemail(Request $request)
    {
        // $venue = Venue::where('id', $request->venue)->first();
        $cekemail = User::where('email', $request->email)->first();
        // dd($cekemail);
        if ($cekemail == null) {

            User::create([
                'email' => $request->email,
            ]);
            $user = User::where('email', $request->email)->first();
            $data = json_decode(Transaction::where('customer_id', $user->id)->where('venue_id', $request->venue)->where('status', 0)->first());
            // dd($data);
            if ($data == null) {
                $inv = json_decode(Transaction::max('transaction_id'));
                if ($inv == null) {
                    $thisinvoice = 1;

                } else {
                    $thisinvoice = $inv + 1;
                }



                Transaction::create([
                    'transaction_id' => $thisinvoice,
                    'customer_id' => $user->id,
                    'venue_id' => $request->venue,
                ]);
                $transaction = Transaction::where('transaction_id', $thisinvoice)->first();

            } else {
                if ($data->status == '0') {
                    $max = Transaction::max('transaction_id');
                    $thisinvoice = $max;
                    $transaction = $data;
                }else{
                    $max = Transaction::max('transaction_id');
                    $thisinvoice = $max + 1;

                    Transaction::create([
                        'transaction_id' => $thisinvoice,
                        'customer_id' => $user->id,
                        'venue_id' => $request->venue,
                    ]);
                    $transaction = Transaction::where('transaction_id', $thisinvoice)->first();
                }
            }

        } else {
            $user = User::where('email', $request->email)->first();
            $data = json_decode(Transaction::where('customer_id', $user->id)->where('venue_id', $request->venue)->where('status', 0)->first());
            // dd($data);
            if ($data == null) {
                $inv = json_decode(Transaction::max('transaction_id'));
                if ($inv == null) {
                    $thisinvoice = 1;

                } else {
                    $thisinvoice = $inv + 1;
                }

                Transaction::create([
                    'transaction_id' => $thisinvoice,
                    'customer_id' => $user->id,
                    'venue_id' => $request->venue,
                ]);
                $transaction = Transaction::where('transaction_id', $thisinvoice)->first();
            } else {
                if ($data->status == '0') {
                    $max = Transaction::max('transaction_id');
                    $thisinvoice = $max;
                    $transaction = $data;
                }else{
                    $max = Transaction::max('transaction_id');
                    $thisinvoice = $max + 1;

                    Transaction::create([
                        'transaction_id' => $thisinvoice,
                        'customer_id' => $user->id,
                        'venue_id' => $request->venue,
                    ]);
                    $transaction = Transaction::where('transaction_id', $thisinvoice)->first();
                }
            }
        }

        // dd($transaction);


        return array('status' => 'success', 'id' => $transaction->id, 'message' => 'Verifikasi berhasil');
    }

    public function getvoucher()
    {
        $transaction = Transaction::where('id', Crypt::decrypt(request('order')))->with('customer', 'period')->first();
        $voucher = Voucher::where('period_id', $transaction->period_id)->where('status', 1)->with('period')->take($transaction->qty)->get();
        $vcr = [];
        foreach ($voucher as $v) {
            // $v->update([
            //     'status' => 0,
            // ]);
            $vcr[] = $v->code;
        }
        // dd(count($vcr));
        $details = [
            'name' => $transaction->customer->name,
            'invoice' => '#'.$transaction->transaction_id,
            'tgl' => date('d-m-Y'),
            'product' => $transaction->period->period . ' (Speed :' . $transaction->period->speed . 'Mbps)',
            'qty' => $transaction->qty,
            'price' => $transaction->period->period_price,
            'total' => $transaction->total,
            'code' => $vcr,
        ];

        Mail::to($transaction->customer->email)->send(new VoucherMail($details));

        return view('pages.voucher', compact('voucher'));
    }

    public function sentemail()
    {
        $details = [
            'title' => 'Mail from websitepercobaan.com',
            'body' => 'This is for testing email using smtp'
        ];

        Mail::to('rezahawari19@gmail.com')->send(new VoucherMail($details));
    }



}
