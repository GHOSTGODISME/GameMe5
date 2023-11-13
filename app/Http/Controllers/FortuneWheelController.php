<?php

namespace App\Http\Controllers;

use App\Models\FortuneWheel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class FortuneWheelController extends Controller
{
    public function createFortuneWheel()
    {
        $fortuneWheel = new FortuneWheel();
        $fortuneWheel->save();

        return view('Interactive-tools.fortune-wheel', compact('fortuneWheel'));
    }

    // Index method that redirects to createFortuneWheel
    public function index()
    {
        return $this->createFortuneWheel();
    }

    public function updateFortuneWheel(Request $request)
    {
        // Validate the request if needed
        $request->validate([
            'fortuneWheel' => 'required|array', // Add more validation rules if necessary
        ]);

        // Extract the FortuneWheel data from the request
        $fortuneWheelData = $request->input('fortuneWheel');

        // Assuming your FortuneWheel model has an 'id' field for identification
        $fortuneWheelId = $fortuneWheelData['id'];

        // Find the FortuneWheel in the database
        $fortuneWheel = FortuneWheel::findOrFail($fortuneWheelId);

        // Update the FortuneWheel attributes
        $fortuneWheel->title = $fortuneWheelData['title'];

        // Update entries and results unconditionally
        $fortuneWheel->entries = $fortuneWheelData['entries'] ?? [];
        $fortuneWheel->results = $fortuneWheelData['results'] ?? [];
        

        // Save the updated FortuneWheel to the database
        $fortuneWheel->save();

        // return response()->json(['message' => 'Wheel updated successfully']);
         return redirect()->route('fortune-wheel-main')->with('success', 'Wheel updated successfully');

        //return view('Interactive-tools.fortune-wheel-main')->with('success', 'Wheel updated successfully');
    }

    public function editFortuneWheel($id)
    {
        // Fetch the Fortune Wheel with the given ID
        $fortuneWheel = FortuneWheel::findOrFail($id);

        // Return the createFortuneWheel view with the Fortune Wheel data
        return view('Interactive-tools.fortune-wheel', compact('fortuneWheel'));
    }

    public function deleteFortuneWheel($id)
    {
        // Find the fortune wheel by ID
        $fortuneWheel = FortuneWheel::find($id);

        // Check if the fortune wheel exists
        if (!$fortuneWheel) {
            return response()->json(['message' => 'Fortune Wheel not found.'], 404);
        }

        // Delete the fortune wheel
        $fortuneWheel->delete();

        return response()->json(['message' => 'Fortune Wheel deleted successfully.']);
    }


    public function showFortuneWheelMain()
    {
        $fortuneWheels = FortuneWheel::all();
        return view('Interactive-tools.fortune-wheel-main', ['fortuneWheels' => $fortuneWheels]);
    }
}
