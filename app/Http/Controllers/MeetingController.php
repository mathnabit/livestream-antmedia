<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function store(Request $request)
    {
        $meeting = Meeting::create([
            'stream_key' => $request->input('streamId'),
            'name' => $request->input('name'),
            'stream_url' => $request->input('rtmpURL'),
            'total_views' => 0,
            'current_views' => 0,
        ]);

        return response()->json($meeting, 201);
    }
}
