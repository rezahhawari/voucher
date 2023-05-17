<?php

namespace App\Http\Controllers;

use App\Imports\VoucherImport;
use App\Models\Period;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function findduration(Request $request)
    {
        $data = Period::where('venue_id',  $request->id)->get();
        return $data;
    }

    public function store(Request $request)
    {
        Voucher::create([
            'code' => $request->code,
            'period_id' => $request->period,
            'venue_id' => $request->venue,
            'status' => 1,
            'user_id' => $request->user,
        ]);

        return array('status' => 'success');
    }

    public function destroy(Request $request)
    {
        Voucher::destroy($request->id);
        return array('status' => 'success');
    }

    public function importexcel(Request $request)
    {
        Excel::import(new VoucherImport, public_path('excel/'. $request->filename));

        return array('status' => 'success');
        // return back()->with('success', 'Voucher imported successfully');
    }
}
