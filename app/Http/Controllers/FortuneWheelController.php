<?php

namespace App\Http\Controllers;

use App\Models\FortuneWheel;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class FortuneWheelController extends Controller
{

    public function index(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();

        $fortuneWheels = FortuneWheel::where('id_lecturer', $lecturer->id)->get();
        return view('Interactive-tools.fortune-wheel-index', ['fortuneWheels' => $fortuneWheels]);
    }
    public function createFortuneWheel()
    {
        $fortuneWheel = new FortuneWheel();
        return view('Interactive-tools.fortune-wheel-edit', compact('fortuneWheel'));
    }

    public function updateFortuneWheel(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();

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
                // $fortuneWheel->update($data);
                $fortuneWheel->update([
                    'title' => $data['title'],
                    'entries' => $data['entries'],
                    'results' => $data['results'],
                    'id_lecturer' => $lecturer->id,
                ]);
                Log::info('updated: ' . json_encode($data));

                return redirect()->route('fortune-wheel-index')->with('success', 'Wheel updated successfully');
            }
        }else{
            // $fortuneWheel = FortuneWheel::create($data);
            $fortuneWheel = new FortuneWheel([
                'title' => $data['title'],
                'entries' => $data['entries'],
                'results' => $data['results'],
                'id_lecturer' => $lecturer->id,
            ]);
            Log::info('stored: ' . json_encode($data));
            $fortuneWheel->save();
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

    public function search(Request $request)
    {
        $search = $request->input('search');

        $fortuneWheels = FortuneWheel::when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->get();

        return view('Interactive-tools.fortune-wheel-index', ['fortuneWheels' => $fortuneWheels]);
    }
}
