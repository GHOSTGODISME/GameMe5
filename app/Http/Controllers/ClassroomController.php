<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AnnQna;
use App\Models\AnnQuiz;
use App\Models\AnnText;
use App\Models\Student;
use App\Models\AnnPolls;
use App\Models\Lecturer;
use App\Models\AnnQnaAns;
use App\Models\Classroom;
use App\Models\AnnFeedback;
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

    function classroom_stud_home(Request $request){

        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $stud = Student::where('iduser', $user->id)->first();
        $student = Student::with('classrooms')->find($stud->id);

        return view('Classroom/classroom_stud_home', compact('student'));
    }

    function classroom_lect_home(Request $request){

        $email = $request->session()->get('email');
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

        $email = $request->session()->get('email');
        //$email = 'aa@gmail.com';
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
             $email = $request->session()->get('email');
             ///$email = 'aa@gmail.com';
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
        $currentUserEmail = session('email'); 
        //$currentUserEmail = 'aa@gmail.com';
        $currentUser = User::where('email', $currentUserEmail)->first();
        return view('Classroom/classroom_stud_stream', compact('classroom', 'announcements', 'currentUser'));
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

        $currentUserEmail = session('email'); 
        //$currentUserEmail = 'aa@gmail.com';
        $currentUser = User::where('email', $currentUserEmail)->first();
        return view('Classroom/classroom_stud_quiz', compact('classroom','announcements','currentUser'));
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
        $currentUserEmail = session('email'); 
        ///$currentUserEmail = 'aa@gmail.com';
        $currentUser = User::where('email', $currentUserEmail)->first();
        return view('Classroom/classroom_stud_qna', compact('classroom','announcements','currentUser'));
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

        $currentUserEmail = session('email'); 
        //$currentUserEmail = 'aa@gmail.com';
        $currentUser = User::where('email', $currentUserEmail)->first();

        return view('Classroom/classroom_stud_polls', compact('classroom','announcements','currentUser'));
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
        $currentUserEmail = session('email'); 
        //$currentUserEmail = 'aa@gmail.com';
        $currentUser = User::where('email', $currentUserEmail)->first();
        return view('Classroom/classroom_stud_feedback', compact('classroom','announcements','currentUser'));
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

        $currentUserEmail = session('email'); 
        //$currentUserEmail = 'aa@gmail.com';
        $currentUser = User::where('email', $currentUserEmail)->first();

        return view('Classroom/classroom_specify_qna', compact('classroom','qna','announcement','currentUser'));
    }

    public function class_reply_qna(Request $request, AnnQna $qna){
        $timestamp = now();
        $request->validate([
            'reply_content' => 'required|string',
        ]);

        // Create a new reply and associate it with the Q&A
        $email = $request->session()->get('email');
        //$email = 'aa@gmail.com';
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

    public function class_specify_polls(AnnPolls $polls, Request $request){
        $polls = AnnPolls::where('id', $polls->id)->first();
        $announcement = Announcement::where('id',$polls->ann_id)->first();
        $classroom = Classroom::where('id',$announcement->idclass)->first();
        $email = $request->session()->get('email');
        //$email = 'aa@gmail.com';
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

        $currentUserEmail = session('email'); 
        //$currentUserEmail = 'aa@gmail.com';
        $currentUser = User::where('email', $currentUserEmail)->first();


        return view('Classroom/classroom_specify_polls', compact('classroom','polls','announcement','option1Count','option2Count','userHasVoted', 'currentUser'));
    }

    public function class_reply_polls(Request $request){
        $pollsId = $request->input('polls_id');
        $selectedOption = $request->input('poll_option');
        $email = $request->session()->get('email');
        //$email = 'aa@gmail.com';
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
        $email = $request->session()->get('email');
        //$email = 'wongtian628@gmail.com';
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

      
        return redirect()->route('lect_add_class')->with(['success_message' => 'Classroom created successfully', 'joinCode' => $joinCode, 'classroomId' =>$classroom->id]);
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

     $email = $request->session()->get('email');
     //$email = 'aa@gmail.com';
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


    public function class_stud_add_announcement(Request $request){
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

     $email = $request->session()->get('email');
     //$email = 'aa@gmail.com';
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
    return redirect()->route('class_stud_stream', ['classroom' => $request->classId]);
    }


    

    public function class_lect_specify_qna(AnnQna $qna){
        $qna = AnnQna::where('id', $qna->id)->first();
        $announcement = Announcement::where('id',$qna->ann_id)->first();
        $classroom = Classroom::where('id',$announcement->idclass)->first();
        return view('Classroom/classroom_lect_specify_qna', compact('classroom','qna','announcement'));
    }
   
    public function class_lect_specify_polls(AnnPolls $polls, Request $request){
        $polls = AnnPolls::where('id', $polls->id)->first();
        $announcement = Announcement::where('id',$polls->ann_id)->first();
        $classroom = Classroom::where('id',$announcement->idclass)->first();
        $email = $request->session()->get('email');
        //$email = 'aa@gmail.com';
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

    public function get_announcement_details(Request $request)
    {
        $announcementId = $request->input('announcementId');
        $announcement = Announcement::with('annText', 'annQna', 'annPolls')->findOrFail($announcementId);
    
        $details = [
            'annText' => $announcement->annText,
            'annQna' => $announcement->annQna,
            'annPolls' => $announcement->annPolls,
            // Add other details as needed
        ];
    
        // Return the specific details as JSON
        return response()->json(['announcement' => $announcement, 'details' => $details]);
    }

public function class_update_announcement(Request $request)
{

 // Validate the request data
        $request->validate([
            'announcementId' => 'required|exists:announcement,id',
            'updateAnnouncementType' => 'required|in:Text Announcement,Q&A Announcement,Polls Announcement',
            'content' => 'required_if:updateAnnouncementType,Text Announcement',
            'qna_question' => 'required_if:updateAnnouncementType,,Q&A Announcement',
            'polls_question' => 'required_if:updateAnnouncementType,Polls Announcement',
            'option1' => 'required_if:updateAnnouncementType,Polls Announcement',
            'option2' => 'required_if:updateAnnouncementType,Polls Announcement',
            // Add other validation rules as needed
        ]);

        $announcementId = $request->input('announcementId');

        // Fetch the announcement by ID
        $announcement = Announcement::findOrFail($announcementId);

        // Update announcement fields based on the request
        $announcement->update([
            // Update other fields as needed
        ]);

        $type = $request->updateAnnouncementType;


        // Update data in specific child tables based on the announcement type
        switch ($type) {
            case "Text Announcement":
                AnnText::where('annid', $announcement->id)->update([
                    'content' => $request->content,
                ]);
                break;

            case 'Q&A Announcement':
                $announcement->annQna->update([
                    'question' => $request->qna_question,
                    // Update other fields for Q&A as needed
                ]);
                break;

            case 'Polls Announcement':
                $announcement->annPolls->update([
                    'question' => $request->polls_question,
                    'option1' => $request->option1,
                    'option2' => $request->option2,
                    // Update other fields for Polls as needed
                ]);
                break;

            // Update other cases for additional announcement types

            default:
                // Handle other cases or throw an error
                break;
        }

        // Return a response, e.g., a success message or JSON response
        return back();

}



    public function class_delete_announcement(Request $request) {
        // Get announcement ID from the request
    $announcementId = $request->input('announcementId');
    $announcement = Announcement::find($announcementId);

    if (!$announcement) {
        return response()->json(['error' => 'Announcement not found'], 404);
    }

     $email = $request->session()->get('email');
     //$email = 'aa@gmail.com';
     $user = User::where('email', $email)->first();
    
    // Type check and delete associated content based on the announcement type
    switch ($announcement->type) {
        case 'AnnText':
            $announcement->annText()->delete();
            break;
        case 'AnnQuiz':
            $announcement->annQuiz()->delete();
            break;
        case 'AnnQna':
            AnnQnaAns::where('quesid', $announcement->annQna->id)->delete();
            $announcement->annQna()->delete();
            break;
        case 'AnnPolls':
            AnnPollsResult::where('polls_id', $announcement->annPolls->id)->delete();
            $announcement->annPolls()->delete();
            break;
        case 'AnnFeedback':
            $announcement->annFeedback()->delete();
            break;
        // Add more cases as needed for other announcement types
        default:
            // Handle the default case or throw an error
            break;
    }

    // Finally, delete the announcement itself
    $announcement->delete();
        // Return a response, e.g., a success message or JSON response
        return response()->json(['success' => 'Announcement deleted successfully']);
    }


    function lect_update_class($classroomId){
        $classroom = Classroom::find($classroomId);
        // You can add more error handling here if the classroom is not found.

        return view('Classroom/classroom_lect_edit_class', ['classroom' => $classroom]);
    }


    function lect_update_classroom(Request $request, $id){

        $request->validate([
            'name' => 'required|string|max:255',
            'course_code' => 'required|string|max:255',
            'group' => 'required|string|max:255',
            // Add more validation rules if needed
        ]);

        $classroom = Classroom::find($id);

        if (!$classroom) {
            // Handle the case where the classroom is not found
            return redirect()->back()->with('error_message', 'Classroom not found.');
        }

        // Update the classroom properties
        $classroom->name = $request->input('name');
        $classroom->coursecode = $request->input('course_code');
        $classroom->group = $request->input('group');

        // Save the updated classroom
        $classroom->save();

        // Redirect with success message
        return redirect()->route('classroom_lect_home')->with('success_message', 'Classroom updated successfully.');
    
    }

    public function lect_remove_student($id)
    {
        $student = Classstudent::where('idstudent', $id)->first();
        $classroom = $student -> idclass;
        if (!$student) {
            // Handle the case where the student is not found
            return redirect()->back()->with('error_message', 'Student not found.');
        }

        // Remove the student
        $student->delete();

        // Redirect with success message
        return redirect()->route('class_lect_people', ['classroom' => $classroom])->with('success_message', 'Student removed successfully.');
    }
    
    function assign_class(Request $request){
        $request->validate([
            'class_id' => 'required|exists:classroom,id',
            'class_session_code' => 'required',
        ]);
        $email = $request->session()->get('email');
        //$email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $userId =$user->id;
        // Create a new Announcement
        $announcement = new Announcement();
        $announcement->idclass = $request->input('class_id');
        $announcement->type = 'AnnQuiz'; // Set the type to 'quiz'
        $announcement->user_id = $userId;
        $announcement->save();
    
        // Create a new AnnQuiz
        $annQuiz = new AnnQuiz();
        $annQuiz->ann_id = $announcement->id;
        $annQuiz->session_code = $request->input('class_session_code');

        // Add other fields as needed
        $annQuiz->save();
        return redirect()->back()->with('success', 'Assignment successful!');
    }


    function assign_class_survey(Request $request){
        $request->validate([
            'class_id' => 'required|exists:classroom,id',
            'survey_id' => 'required',
        ]);

        $email = $request->session()->get('email');
        //$email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $userId =$user->id;
        // Create a new Announcement
        $announcement = new Announcement();
        $announcement->idclass = $request->input('class_id');
        $announcement->type = 'AnnFeedback'; // Set the type to 'quiz'
        $announcement->user_id = $userId;
        $announcement->save();
    
        // Create a new AnnQuiz
        $annSurvey= new AnnFeedback();
        $annSurvey->ann_id = $announcement->id;
        $annSurvey->survey_id = $request->input('survey_id');

        // Add other fields as needed
        $annSurvey->save();
        return redirect()->back()->with('success', 'Assignment successful!');
    }



}