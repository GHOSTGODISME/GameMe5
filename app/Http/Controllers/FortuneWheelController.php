<?php

namespace App\Http\Controllers;

use App\Models\FortuneWheel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class FortuneWheelController extends Controller
{

    public function index()
    {
        $fortuneWheels = FortuneWheel::all();
        return view('Interactive-tools.fortune-wheel-index', ['fortuneWheels' => $fortuneWheels]);
    }
    public function createFortuneWheel()
    {
        $fortuneWheel = new FortuneWheel();
        //$fortuneWheel->save();
        return view('Interactive-tools.fortune-wheel-edit', compact('fortuneWheel'));
    }

    public function updateFortuneWheel(Request $request)
    {
        $data = $request->validate([
            'id' =>'nullable|integer',
            'title' => 'required|string',
            'entries' => 'nullable|array',
            'results' => 'nullable|array',
        ]);

        Log::info('data: ' . json_encode($data));

        if (isset($data['id'])) {
            $fortuneWheel = FortuneWheel::find($data['id']);
            Log::info('have id: ' . $fortuneWheel);

            if ($fortuneWheel) {
                $fortuneWheel->update($data);
                Log::info('updated: ' . json_encode($data));

                return redirect()->route('fortune-wheel-index')->with('success', 'Wheel updated successfully');
            }
        }else{
            $fortuneWheel = FortuneWheel::create($data);
            Log::info('stored: ' . json_encode($data));

        }
        // Save the updated FortuneWheel to the database
        return redirect()->route('fortune-wheel-index')->with('success', 'Wheel updated successfully');
    }

    public function editFortuneWheel($id)
    {
        // Fetch the Fortune Wheel with the given ID
        $fortuneWheel = FortuneWheel::findOrFail($id);

        // Return the createFortuneWheel view with the Fortune Wheel data
        return view('Interactive-tools.fortune-wheel-edit', compact('fortuneWheel'));
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
        return view('Interactive-tools.fortune-wheel-edit-index', ['fortuneWheels' => $fortuneWheels]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $fortuneWheels = FortuneWheel::when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->get();

        return view('Interactive-tools.fortune-wheel-index', ['fortuneWheels' => $fortuneWheels]);
    }
}
