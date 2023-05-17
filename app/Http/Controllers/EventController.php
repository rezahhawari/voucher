<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        Event::create([
            'name' => $request->name,
            'description' => $request->desc,
            'start_date' => $request->sdate,
            'end_date' => $request->edate,
            'image' => $request->img,
            'status' => 1,
            'user_id' => $request->user,
        ]);

        return array('status' => 'success');
    }

    public function destroy(Request $request)
    {
        Event::destroy($request->id);

        return array('status' => 'success');
    }
}
