<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        return Carbon::createFromTimestampMs($startTime)->toDateTimeString('minute');
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
        // $request->validate([
        //     'totalWatchers' => 'required|integer',
        // ]);
        $apiUrl = "https://ams.pm.tts.live:5443/DevTest3/rest/v2/broadcasts/{$id}";
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.e30.AsK6EJG3nbHVjR-iHvmKMfRP7Ug7RyaZQ6MaDoqy6Go';

        try {
            // Find the meeting by key
            $meeting = Meeting::where('key', $id)->firstOrFail();

            // Update the total watchers
            if ($request->has('totalWatchers')) {
                // Update the meeting in the database
                $meeting->status = $request->input('status');
                $meeting->start_time = $request->input('startTime');
                $meeting->duration = $request->input('duration');
                $meeting->total_watchers = $request->input('totalWatchers');
                $meeting->save();
            }

            // Update stream name
            if ($request->has('meetName')) {
                $meetName = $request->input('meetName');

                // Update the stream name in the antmedia server
                $responseUpdate = Http::withHeaders([
                    'Authorization' => $token,
                    'Content-Type' => 'application/json',
                ])
                ->put($apiUrl, [
                    'name' => $meetName,
                ]);

                if ($responseUpdate->successful()) {
                    // Get the updated meeting from the antmedia server
                    $responseGet = Http::withHeaders([
                        'Authorization' => $token,
                        'Content-Type' => 'application/json',
                    ])->get($apiUrl);

                    if ($responseGet->successful()) {
                        // Fetch the updated meeting data
                        $updatedMeetApi = $responseGet->json();
                        // Update the meeting in the database
                        $meeting->update([
                            'name' => $updatedMeetApi['name'], 
                            'key' => $updatedMeetApi['streamId'], 
                            'url' => $updatedMeetApi['rtmpURL'], 
                            'status' => $updatedMeetApi['status'], 
                            'start_time' => $updatedMeetApi['startTime'], 
                            'duration' => $updatedMeetApi['duration'], 
                        ]);
                        $meeting->save();
                    }
                }
            }
            
            return response()->json([
                'message' => 'Meeting updated successfully',
                'meeting' => $meeting,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update the meeting: ' . $e,
            ], 404);
        }   
    }
    // Delete a meeting
    public function delete($id)
    {
        
        try {
           // Find the meeting by id
           $meeting = Meeting::findOrFail($id);

           // Define the API URL and the token
            $apiUrl = "https://ams.pm.tts.live:5443/DevTest3/rest/v2/broadcasts/{$meeting->key}";
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.e30.AsK6EJG3nbHVjR-iHvmKMfRP7Ug7RyaZQ6MaDoqy6Go';

            // Delete the meeting from the antmedia server
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
            ])->delete($apiUrl);

            if ($response->successful()) {
                // Delete the meeting from the database
                $meeting->delete();
            }

            return response()->json([
                'message' => 'Meeting deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Delete failed: ' . $e,
            ], 404);
        }
    }

}
