<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kos;
use App\Models\Period;
use App\Models\Transaction;
use App\Models\Venue;
use App\Models\Venuecat;
use App\Models\Voucher;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function GuzzleHttp\Promise\all;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->role == 1){
            $todaytrans = Transaction::whereDate('created_at', date('Y-m-d'))->with('venue', 'customer')->get();
            // dd($todaytrans);
            $todaytranscount = count($todaytrans);

            $totaltrans = Transaction::all();
            $totaltranscount = count($totaltrans);
            // $estimateincome = 0;
            $estimateincometoday= 0;
            // foreach ($totaltrans as $t) {
            //     $estimateincome += $t->amount;
            // }
            foreach ($todaytrans as $d) {
                $estimateincometoday += $d->amount;
            }
        }

        if (Auth::user()->role == 3) {
            $todaytrans = Transaction::whereDate('created_at', date('Y-m-d'))->with('venue', 'customer')->get();
            // dd($todaytrans);
            $todaytranscount = count($todaytrans);

            $totaltrans = Transaction::all();
            $totaltranscount = count($totaltrans);
            // $estimateincome = 0;
            $estimateincometoday= 0;
            // foreach ($totaltrans as $t) {
            //     $estimateincome += $t->amount;
            //     $estimateincome *= 0.2;
            // }
            foreach ($todaytrans as $d) {
                if ($d->venue->user_id == Auth::user()->id) {
                    $estimateincometoday += $d->amount;
                    $estimateincometoday *= 0.2;
                }
            }
        }

        return view('admin.index', [
            'today' => $todaytrans,
            'counttoday' => $todaytranscount,
            'totaltrans' => $totaltranscount,
            'estimateincometoday' => $estimateincometoday
        ]);
    }

    public function event()
    {
        return view('admin.event' , ['event' => Event::all()]);
    }

    public function uptempimage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('img'), $imageName);

        return $imageName;
    }

    public function uptempexcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        // menangkap file excel
		$file = $request->file('file');

		// membuat nama file unik
		$nama_file = time().'.'.$file->extension();

		// upload ke folder file_siswa di dalam folder public
		$file->move('excel',$nama_file);

        // dd($request);

        return $nama_file;
    }

    public function kos()
    {
        // dd(Str::password(16, numbers: false, symbols: false));
        return view('admin.kos', ['kos' => Kos::all()]);
    }

    public function venue()
    {
        return view('admin.venue', [
            'venue' => Venue::all(),
            'cat' => Venuecat::all(),
        ]);
    }

    public function duration()
    {
        return view('admin.period', [
            'duration' => Period::with('venue')->get(),
            'venue' => Venue::where('status', 1)->get()
        ]);
    }

    public function voucher()
    {
        return view('admin.voucher', [
            'voucher' => Voucher::with('venue', 'period')->get(),
            'venue' => Venue::all(),
        ]);
    }

    public function transaction()
    {

        return view('admin.transaction', [
            'transaction' => Transaction::with('venue', 'user')->get(),
        ]);
    }
}
