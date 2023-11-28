<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AnnQna;
use App\Models\AnnText;
use App\Models\Student;
use App\Models\AnnPolls;
use App\Models\Lecturer;
use App\Models\AnnQnaAns;
use App\Models\Classroom;
use App\Models\Announcement;
use App\Models\Classstudent;
use Illuminate\Http\Request;
use App\Models\Classlecturer;
use App\Models\AnnPollsResult;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class ClassroomController extends Controller{

    function classroom_stud_home(){

        // $email = $request->session()->get('email');
        $email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $stud = Student::where('iduser', $user->id)->first();
        $student = Student::with('classrooms')->find($stud->id);

        return view('Classroom/classroom_stud_home', compact('student'));
    }

    function classroom_lect_home(Request $request){

        //$email = $request->session()->get('email');
        $email = 'wongtian628@gmail.com';
        $user = User::where('email', $email)->first();
        $lect = Lecturer::where('iduser', $user->id)->first();
    
        
        // Get the search query from the request
        $searchQuery = $request->input('search');

        $classrooms = Classroom::where('name', 'LIKE', '%' . $searchQuery . '%')->get();
    
        // Get the classes associated with the lecturer
        $lecturerClasses = Classlecturer::where('idlecturer', $lect->id)->pluck('idclass')->toArray();

        // Filter the classrooms to include only those that the lecturer has
        $filteredClassrooms = $classrooms->whereIn('id', $lecturerClasses);
    
        return view('Classroom/classroom_lect_home', compact('filteredClassrooms'));
    }


    function join_class(Request $request){
        // Validate the form data
        $request->validate([
            'class_code' => 'required|exists:classroom,joincode',
        ]);

        // Get the classroom based on the provided class code
        $classroom = Classroom::where('joincode', $request->class_code)->first();

        // $email = $request->session()->get('email');
        $email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $stud = Student::where('iduser', $user->id)->first();
      
        Classstudent::create([
            'idclass' => $classroom->id,
            'idstudent' => $stud->id, // Assuming you have a relationship set up
        ]);

        // Redirect or provide a success response
        return redirect()->route('classroom_stud_home')->with('success', 'Successfully joined the classroom!');

    }

    function classroom_quit(Request $request){
        // Validate the form data
        $request->validate([
            'class_id' => 'required|exists:class_student,idclass',
        ]);
             // $email = $request->session()->get('email');
             $email = 'aa@gmail.com';
             $user = User::where('email', $email)->first();
             $stud = Student::where('iduser', $user->id)->first();
             $classStudent = ClassStudent::where([
            'idclass' => $request->class_id,
            'idstudent' =>$stud->id, // Assuming you have a relationship set up
        ])->first();
            $classStudent->delete();
            return response()->json(['success' => true]);
    }

    function classroom_remove(Request $request){
       // Validate the request, e.g., check if the lecturer has permission to delete this classroom
    $request->validate([
        'class_id' => 'required',
    ]);

    // Get the classroom ID from the request
    $classroomId = $request->input('class_id');

    // Use Eloquent to find the classroom with its associated announcements
    $classroom = Classroom::with('announcements')->find($classroomId);

    // Check if the classroom exists
    if (!$classroom) {
        // Handle the case where the classroom does not exist
        return response()->json(['message' => 'Classroom not found'], 404);
    }

    // Detach lecturers and students from the classroom
    $classroom->lecturers()->detach();
    $classroom->students()->detach();
    $announcements = Announcement::where('idclass', $classroom->id)->get();

    // Delete announcements and related content
    foreach ($announcements as $announcement) {
        // Additional logic may be needed to delete related content based on the announcement type
        switch ($announcement->type) {
            case 'AnnText':
                // Delete related record in ann_text table
                $announcement->annText->delete();
                break;
    
            case 'AnnQuiz':
                // Delete related record in ann_quiz table
                $announcement->annQuiz->delete();
                // You may need additional logic for other related tables for AnnQuiz
                break;
    
            case 'AnnQna':
                // Delete related records in ann_qna_ans table
                $announcement->annQna->annQnaAns()->delete();
                $announcement->annQna->delete();
       
                // You may need additional logic for other related tables for AnnQna
                break;
    
            case 'AnnPolls':
                // Delete related records in ann_polls_result table
                $announcement->annPollsResult->annQnaAns()->delete();
                $announcement->annPolls->delete();
                // You may need additional logic for other related tables for AnnPolls
                break;
    
            case 'AnnFeedback':
                // Delete related record in ann_feedback table
                $announcement->annFeedback->delete();
                // You may need additional logic for other related tables for AnnFeedback
                break;
    
            // Add more cases for other announcement types as needed
    
            default:
                // Handle any other announcement types
                break;
        }
    
        // Delete the announcement
        $announcement->delete();
    }
    

    // Delete the classroom
    $classroom->delete();

    // Respond with a success message
    return response()->json(['success' => true]);
    }



    public function class_stud_stream(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_stud_stream', compact('classroom', 'announcements'));
    }
    
    
    public function class_lect_stream(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_lect_stream', compact('classroom', 'announcements'));
    }

    public function class_stud_quiz(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->where('type', 'AnnQuiz')
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_stud_quiz', compact('classroom','announcements'));
    }

    public function class_lect_quiz(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->where('type', 'AnnQuiz')
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_lect_quiz', compact('classroom','announcements'));
    }


    public function class_stud_qna(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->where('type', 'AnnQna')
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_stud_qna', compact('classroom','announcements'));
    }

    public function class_lect_qna(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->where('type', 'AnnQna')
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_lect_qna', compact('classroom','announcements'));
    }

    public function class_stud_polls(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->where('type', 'AnnPolls')
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_stud_polls', compact('classroom','announcements'));
    }

    public function class_lect_polls(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->where('type', 'AnnPolls')
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_lect_polls', compact('classroom','announcements'));
    }

    public function class_stud_feedback(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->where('type', 'AnnFeedback')
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_stud_feedback', compact('classroom','announcements'));
    }

    public function class_lect_feedback(Classroom $classroom)
    {
        $announcements = Announcement::where('idclass', $classroom->id)
        ->where('type', 'AnnFeedback')
        ->with('content')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Classroom/classroom_lect_feedback', compact('classroom','announcements'));
    }

    public function class_stud_people(Classroom $classroom)
    {
        $classroom = Classroom::with('students.user', 'lecturers.user')->find($classroom->id);

        // Retrieve students and lecturers with associated user information
        $students = $classroom->students;
        $lecturers = $classroom->lecturers;
        return view('Classroom/classroom_stud_people', compact('classroom', 'students', 'lecturers'));
    }


    
    public function class_lect_people(Classroom $classroom)
    {
        $classroom = Classroom::with('students.user', 'lecturers.user')->find($classroom->id);

        // Retrieve students and lecturers with associated user information
        $students = $classroom->students;
        $lecturers = $classroom->lecturers;
        return view('Classroom/classroom_lect_people', compact('classroom', 'students', 'lecturers'));
    }

 
    public function class_specify_qna(AnnQna $qna){
        $qna = AnnQna::where('id', $qna->id)->first();
        $announcement = Announcement::where('id',$qna->ann_id)->first();
        $classroom = Classroom::where('id',$announcement->idclass)->first();
        return view('Classroom/classroom_specify_qna', compact('classroom','qna','announcement'));
    }

    public function class_reply_qna(Request $request, AnnQna $qna){
        $timestamp = now();
        $request->validate([
            'reply_content' => 'required|string',
        ]);

        // Create a new reply and associate it with the Q&A
        // $email = $request->session()->get('email');
        $email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $contentWithLineBreaks = str_replace("\r\n", "\n", $request->input('reply_content'));
        $reply = new AnnQnaAns([
            'content' => $contentWithLineBreaks,
            'userid' => $user->id, // Assuming you have authentication
            'created_at'=> $timestamp,
        ]);

        $qna->replies()->save($reply);

        return redirect()->back()->with('success', 'Reply added successfully.');
    }

    public function class_specify_polls(AnnPolls $polls){
        $polls = AnnPolls::where('id', $polls->id)->first();
        $announcement = Announcement::where('id',$polls->ann_id)->first();
        $classroom = Classroom::where('id',$announcement->idclass)->first();
        $email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $userId =$user->id;

        $option1Count = AnnPollsResult::where('polls_id', $polls->id)
        ->where('option', 1)
        ->count();

        $option2Count = AnnPollsResult::where('polls_id',  $polls->id)
            ->where('option', 2)
            ->count();

        $userHasVoted = AnnPollsResult::where('user_id',$userId)
        ->where('polls_id', $polls->id)
        ->exists();
        return view('Classroom/classroom_specify_polls', compact('classroom','polls','announcement','option1Count','option2Count','userHasVoted'));
    }

    public function class_reply_polls(Request $request){
        $pollsId = $request->input('polls_id');
        $selectedOption = $request->input('poll_option');
        // $email = $request->session()->get('email');
        $email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $userId =$user->id;

        // Store the poll result in the database
        // Assuming you have a PollResult model

        AnnPollsResult::create([
            'polls_id' => $pollsId,
            'option' => $selectedOption,
            'user_id' => $userId,
        ]);

        // Redirect back or to a thank you page
        return redirect()->back()->with('success', 'Poll option submitted successfully!');
    }

    public function lect_add_class(){
        return view('Classroom/classroom_lect_add_class');
    }

    public function lect_add_classroom(Request $request){
            
        $request->validate([
            'name' => 'required|string',
            'course_code' => 'required|string',
            'group' => 'required|integer',
        ]);

        // Generate a random 6-digit join code
        $joinCode = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

        // Get the current user ID
            // $email = $request->session()->get('email');
        $email = 'wongtian628@gmail.com';
        $user = User::where('email', $email)->first();
        $authorId = $user->id;

        // Create a new classroom record
        $classroom = new Classroom([
            'name' => $request->input('name'),
            'coursecode' => $request->input('course_code'),
            'group' => $request->input('group'),
            'joincode' => $joinCode,
            'author' => $authorId,
        ]);

        // Save the classroom record
        $classroom->save();

        Classlecturer::create([
            'idclass' => $classroom->id,
            'idlecturer' => $user->lecturer->id,
        ]);
    

        // Redirect to a success page or return a response as needed

      
        return redirect()->route('classroom_lect_home')->with('success_message', 'Classroom created successfully');
    }

    public function class_add_announcement(Request $request){
        // Validate the form data
    $validatedData = $request->validate([
        'announcementType' => 'required|in:text,qna,polls',
        'content' => 'required_if:announcementType,text',
        'qna_question' => 'required_if:announcementType,qna',
        'polls_question' => 'required_if:announcementType,polls',
        'option1' => 'required_if:announcementType,polls',
        'option2' => 'required_if:announcementType,polls',
        // Add other validation rules as needed
    ]);

     // $email = $request->session()->get('email');
     $email = 'aa@gmail.com';
     $user = User::where('email', $email)->first();
    
     $type = "";

     switch ($request->announcementType) {
         case 'qna':
             $type = "AnnQna";
             break;
         case 'text':
             $type = "AnnText";
             break;
         case 'polls':
             $type = "AnnPolls";
             break;
         // Add other cases as needed for different announcement types
         default:
             // Handle the default case if necessary
             break;
     }

    // Create an announcement record
    $announcement = Announcement::create([
        'idclass' => $request->classId,
        'type' => $type,
        'created_at' => now(),
        'user_id' => $user->id, // Assuming user is authenticated
    ]);

    // Save data to specific child tables based on the announcement type
    switch ($request->announcementType) {
        case 'text':
            AnnText::create([
                'annid' => $announcement->id,
                'content' => $request->content,
            ]);
            break;

        case 'qna':
            AnnQna::create([
                'ann_id' => $announcement->id,
                'question' => $request->qna_question,
                // Add other fields for Q&A as needed
            ]);
            break;

        case 'polls':
            AnnPolls::create([
                'ann_id' => $announcement->id,
                'question' => $request->polls_question,
                'option1' => $request->option1,
                'option2' => $request->option2,
                // Add other fields for Polls as needed
            ]);
            break;

        // Add other cases for additional announcement types

        default:
            // Handle other cases or throw an error
            break;
    }

    // Redirect or respond as needed
    return redirect()->route('class_lect_stream', ['classroom' => $request->classId]);
    }
    

    public function class_lect_specify_qna(AnnQna $qna){
        $qna = AnnQna::where('id', $qna->id)->first();
        $announcement = Announcement::where('id',$qna->ann_id)->first();
        $classroom = Classroom::where('id',$announcement->idclass)->first();
        return view('Classroom/classroom_lect_specify_qna', compact('classroom','qna','announcement'));
    }
   
    public function class_lect_specify_polls(AnnPolls $polls){
        $polls = AnnPolls::where('id', $polls->id)->first();
        $announcement = Announcement::where('id',$polls->ann_id)->first();
        $classroom = Classroom::where('id',$announcement->idclass)->first();
        $email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $userId =$user->id;

        $option1Count = AnnPollsResult::where('polls_id', $polls->id)
        ->where('option', 1)
        ->count();

        $option2Count = AnnPollsResult::where('polls_id',  $polls->id)
            ->where('option', 2)
            ->count();

        $userHasVoted = AnnPollsResult::where('user_id',$userId)
        ->where('polls_id', $polls->id)
        ->exists();
        return view('Classroom/classroom_lect_specify_polls', compact('classroom','polls','announcement','option1Count','option2Count','userHasVoted'));

    }

}