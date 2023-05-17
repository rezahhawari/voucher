<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        if ($request->ownname != null) {
            if ($request->ownemail != null) {
                $email = $request->ownemail;
            } else {
                $str = str_replace(' ', '', $request->ownname);
                $email = Str::lower($str) . '@mykost.id';
            }
            // $pass = Str::password(16, symbols: false);
            $pass = '12345678';
            User::create([
                'name' => $request->ownname,
                'email' => $email,
                'password' => Hash::make($pass),
                'pass_view' => Crypt::encrypt($pass),
                'role' => 3,
            ]);
            $data = User::where('email', $email)->first();
            $user_id = $data->id;
        } else {
            $user_id = null;
        }


        Venue::create([
            'venue_id' => Str::password(16, symbols: false),
            'venuecat_id' => $request->cat,
            'image' => $request->image,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'capacity' => $request->capacity,
            'description' => $request->desc,
            'start_date' => $request->sdate,
            'end_date' => $request->edate,
            'user_id' => $user_id,

        ]);

        return array('status' => 'success');
    }

    public function changestatus(Request $request)
    {
        if ($request->status == 'active') {
            Venue::where('id', $request->id)->update([
                'status' => 1,
            ]);
        }

        if ($request->status == 'unactive') {
            Venue::where('id', $request->id)->update([
                'status' => 0,
            ]);
        }

        return array('status' => 'success');
    }
}
