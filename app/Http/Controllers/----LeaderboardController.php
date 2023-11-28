<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use App\Http\Requests\StoreLeaderboardRequest;
use App\Http\Requests\UpdateLeaderboardRequest;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeaderboardRequest $request)
    {
        // Validate incoming request data, adjust as needed
        $validatedData = $request->validate([
            'session_id' => 'required',
            'user_id' => 'required',
            'username' => 'required',
            'rank' => 'required',
            'score' => 'required',
        ]);

        try {
            $leaderboard = Leaderboard::create($validatedData);

            return response()->json(['message' => 'Leaderboard details stored successfully', 'data' => $leaderboard], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to store leaderboard details', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Leaderboard $leaderboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leaderboard $leaderboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeaderboardRequest $request, Leaderboard $leaderboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leaderboard $leaderboard)
    {
        //
    }
}
