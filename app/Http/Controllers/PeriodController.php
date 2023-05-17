<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PeriodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        Period::create([
            'period_id' => Str::password(16, symbols: false),
            'period_price' => $request->price,
            'period' => $request->duration,
            'speed' => $request->speed,
            'device' => $request->device,
            'venue_id' => $request->venue,
            'user_id' => Auth::user()->id,
        ]);

        return array('status' => 'success');
    }

    public function destroy(Request $request)
    {
        Period::where('id', $request->id)->delete();

        return array('status' => 'success');
    }
}
