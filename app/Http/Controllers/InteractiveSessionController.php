<?php

namespace App\Http\Controllers;

use App\Models\InteractiveSession;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class InteractiveSessionController extends Controller
{
    public function index()
    {
        return view("Interactive-Sessions.index");
    }
    public function createInteractiveSession(Request $request)
    {
        $title = $request->input('title');
        
        $sessionCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $session = InteractiveSession::create([
            'title' => $title,
            'code' => $sessionCode,
            // 'lecture_id' => $request->input('lecture_id'),
            'status' => 'live',
        ]);
        $session->save();
        // return view("Interactive-Sessions.interactiveSession-lecturer", [
        //     "title" => $title,
        //     "sessionCode" => $sessionCode,
        //     "sessionId" => $session->id,
        // ]);

        return redirect()->route('interactive-session-lecturer', [
            'title' => $title,
            'sessionCode' => $sessionCode,
            'sessionId' => $session->id,
        ]);
        
    }

    public function showInteractiveSessionLecturer(Request $request){
                return view("Interactive-Sessions.interactiveSession-lecturer", [
            "title" => $request->input('title'),
            "sessionCode" => $request->input('sessionCode'),
            "sessionId" => $request->input('sessionId'),
        ]);
    }

    public function joinInteractiveSession(Request $request)
    {
        $code = $request->input('code');
        try {
            $session = InteractiveSession::where('code', $code)->firstOrFail();
    
            if ($session->status !== 'ended') {
                return view("Interactive-Sessions.interactiveSession-student", [
                    "title" => $session->title,
                    "sessionCode" => $code
                ]);
            } else {
                return back()->with('error', 'Session has already ended.');
            }
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'Invalid session code.');
        }
    }

    public function endInteractiveSession(Request $request)
    {
        $sessionId = $request->input('sessionId');
        $session = InteractiveSession::find($sessionId);
    
        if ($session) {
            $session->status = 'ended';
            $session->messages = $request->input('messages');
            $session->save();
    
            return response()->json(['message' => 'Interactive session ended successfully']);
        }
    
        return response()->json(['message' => 'Interactive session not found'], 404);
    }
}
