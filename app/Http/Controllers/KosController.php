<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $pass = Str::password(16, symbols: false);

        User::create([
            'name' => $request->ownname,
            'email' => $request->ownemail,
            'password' => Hash::make($pass),
            'pass_view' => Crypt::encrypt($pass),
            'role' => 3,
        ]);

        $data = User::where('email', $request->ownemail)->first();

        Kos::create([
            'kos_id' => Str::password(16, symbols: false),
            'image' => $request->image,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'capacity' => $request->capacity,
            'user_id' => $data->id
        ]);

        return array('status' => 'success');
    }
}
