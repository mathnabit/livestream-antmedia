<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'streamId' => 'required|string',
            'name' => 'required|string',
            'rtmpURL' => 'required|string'
        ]);

        try {
            // Create a new meeting
            $meeting = Meeting::create([
                'name' => $request->input('name'),
                'key' => $request->input('streamId'),
                'url' => $request->input('rtmpURL'),
                'status' => $request->input('status'),
                'start_time' => $request->input('startTime'),
                'duration' => $request->input('duration'),
                'total_watchers' => 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create a new meeting: ' . $e,
            ], 500);
        }

        return response()->json($meeting, 201);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'totalWatchers' => 'required|integer',
        ]);

        try {
            // Find the meeting by key and update the total watchers
            $meeting = Meeting::where('key', $id)->firstOrFail();
            $meeting->total_watchers = $request->input('totalWatchers');
            $meeting->save();

            return response()->json([
                'message' => 'Total watchers updated successfully',
                'meeting' => $meeting,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update the meeting: ' . $e,
            ], 404);
        }
        
    }
}
