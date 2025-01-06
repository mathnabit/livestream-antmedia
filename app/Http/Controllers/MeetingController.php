<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    // Get All Meetings
    public function index()
    {
        // Fetch all meetings 
        $meetings = Meeting::all();

        // Format the data
        $formattedMeetings = $meetings->map(function ($meeting) {
            return [
                'id' => $meeting->id,
                'name' => $meeting->name,
                'key' => $meeting->key,
                'url' => $meeting->url,
                'status' => $meeting->status,
                'start_time' => $meeting->status == 'created' ? 'Not Started Yet' : $this->formatStartTime($meeting->start_time),
                'duration' => $this->formatDuration($meeting->duration), 
                'total_watchers' => $meeting->total_watchers, 
            ];
        });

        // Return the formatted data as JSON
        return response()->json($formattedMeetings);
    }
    // Format duration (in seconds) to HH:MM:SS.
    private function formatDuration($durationInMilliseconds)
    {
        // Convert milliseconds to seconds
        $durationInSeconds = $durationInMilliseconds / 1000;
        $hours = str_pad(floor($durationInSeconds / 3600), 2, '0', STR_PAD_LEFT);
        $minutes = str_pad(floor(($durationInSeconds % 3600) / 60), 2, '0', STR_PAD_LEFT);
        $seconds = str_pad($durationInSeconds % 60, 2, '0', STR_PAD_LEFT);

        return "$hours:$minutes:$seconds";
    }

    // Format start_time in seconds to a human-readable date.
    private function formatStartTime($startTime)
    {
        return Carbon::createFromTimestampMs($startTime)->toDateTimeString();
    }

    // Store a new meeting
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

    // Update a meeting
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'totalWatchers' => 'required|integer',
        ]);

        try {
            // Find the meeting by key and update the total watchers
            $meeting = Meeting::where('key', $id)->firstOrFail();
            $meeting->status = $request->input('status');
            $meeting->start_time = $request->input('startTime');
            $meeting->duration = $request->input('duration');
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
