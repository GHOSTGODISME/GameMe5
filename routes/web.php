<?php


use App\Http\Controllers\FortuneWheelController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InteractiveSessionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizSessionController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ClassroomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Homepage*/
Route::get('/', function () {
    return view('User/login');
});

/*User Authentication*/
/*Login*/
Route::get('login',[UserAuthController::class, 'login'])->name('login');
Route::post('login',[UserAuthController::class, 'login_post'])->name('login_post');

/*Sign Up*/
Route::get('signup_1',[UserAuthController::class, 'signup'])->name('signup');
Route::get('signup_2_view',[UserAuthController::class, 'signup_2_view'])->name('signup_2_view');
Route::get('signup_3_view',[UserAuthController::class, 'signup_3_view'])->name('signup_3_view');
Route::get('signup_lecturer_view',[UserAuthController::class, 'signup_lecturer_view'])->name('signup_lecturer_view');

Route::post('signup_1',[UserAuthController::class, 'signup_1'])->name('signup_1');
Route::post('signup_2',[UserAuthController::class, 'signup_2'])->name('signup_2');
Route::post('signup_lecturer', [UserAuthController::class, 'signup_lecturer'])->name('signup_lecturer');
Route::post('signup_3',[UserAuthController::class, 'signup_post'])->name('signup_post');
Route::get('successful_signup',[UserAuthController::class, 'successful_signup'])->name('successful_signup');
Route::get('successful_signup_view',[UserAuthController::class, 'successful_signup_view'])->name('successful_signup_view');


/*Forgot Password*/
Route::get('forgetpassword_1', [UserAuthController::class, 'forgetpassword_1'])->name('forgetpassword_1');
Route::get('forgetpassword_2', [UserAuthController::class, 'forgetpassword_2'])->name('forgetpassword_2');
Route::get('forgetpassword_3', [UserAuthController::class, 'forgetpassword_3'])->name('forgetpassword_3');
Route::post('forgetpassword_1', [UserAuthController::class, 'forgetpassword_1_post'])->name('forgetpassword_1_post');
Route::post('forgetpassword_2', [UserAuthController::class, 'forgetpassword_2_post'])->name('forgetpassword_2_post');
Route::post('forgetpassword_3', [UserAuthController::class, 'forgetpassword_3_post'])->name('forgetpassword_3_post');

/*Logout*/
Route::post('logout',[UserAuthController::class, 'logout'])->name('logout');

/*User*/
/*Student*/
//Homepage
Route::get('stud_homepage',[StudentController::class, 'stud_homepage'])->name('stud_homepage');
//Profile
Route::get('stud_profile',[StudentController::class, 'getStudInfo'])->name('stud_profile');
Route::post('update_profile', [StudentController::class, 'update_profile'])->name('update_profile');
Route::post('upload_profile_picture', [StudentController::class, 'upload_profile_picture'])->name('upload_profile_picture');
Route::post('check_password', [StudentController::class, 'check_password'])->name('check_password');
Route::post('update_password', [StudentController::class, 'update_password'])->name('update_password');

/*Lecturer*/
//Homepage
Route::get('lect_homepage',[LecturerController::class, 'lect_homepage'])->name('lect_homepage');
Route::get('lecturer_search_class', [LecturerController::class, 'lect_homepage'])->name('lecturer_search_class');
Route::get('lecturer_search_quiz', [LecturerController::class, 'lect_homepage'])->name('lecturer_search_quiz');
//Profile
Route::get('lect_profile',[LecturerController::class, 'getLectInfo'])->name('lect_profile');
Route::post('update_lecturer_position',[LecturerController::class, 'update_lecturer_position'])->name('update_lecturer_position');
/*Admin*/
//Homepage
Route::get('admin_stud',[AdminController::class, 'admin_stud'])->name('admin_stud');
Route::get('admin_stud_search', [AdminController::class, 'admin_stud'])->name('admin_stud_search');

Route::get('admin_staff',[AdminController::class, 'admin_staff'])->name('admin_staff');
Route::get('admin_staff_search', [AdminController::class, 'admin_staff'])->name('admin_staff_search');

Route::get('admin_add_student',[AdminController::class, 'admin_add_stud'])->name('admin_add_stud');
Route::post('admin_add_student',[AdminController::class, 'admin_add_student'])->name('admin_add_student');


Route::get('admin/edit-student/{student}', [AdminController::class,'admin_edit_stud'])->name('admin_edit_stud');
Route::post('admin/update-student/{student}', [AdminController::class,'admin_update_student'])->name('admin_update_student');

Route::get('admin_add_staffs',[AdminController::class, 'admin_add_staffs'])->name('admin_add_staffs');
Route::post('admin_add_staff',[AdminController::class, 'admin_add_staff'])->name('admin_add_staff');

Route::get('admin_edit_staff/{staff}',[AdminController::class, 'admin_edit_staff'])->name('admin_edit_staff');
Route::post('admin_update_staff/{staff}',[AdminController::class, 'admin_update_staff'])->name('admin_update_staff');

Route::post('admin_destroy_student',[AdminController::class, 'admin_destroy_student'])->name('admin_destroy_student');
Route::post('admin_destroy_staff',[AdminController::class, 'admin_destroy_staff'])->name('admin_destroy_staff');

/**Game Session */
Route::post('game_session',[UserAuthController::class, 'login'])->name('game_session');

/*Classroom*/
Route::get('classroom_stud_home',[ClassroomController::class, 'classroom_stud_home'])->name('classroom_stud_home');
Route::get('classroom_lect_home',[ClassroomController::class, 'classroom_lect_home'])->name('classroom_lect_home');
Route::post('join_class',[ClassroomController::class, 'join_class'])->name('join_class');
Route::post('classroom_quit',[ClassroomController::class, 'classroom_quit'])->name('classroom_quit');
Route::post('classroom_remove',[ClassroomController::class, 'classroom_remove'])->name('classroom_remove');
Route::get('lect_remove_student/{id}',[ClassroomController::class, 'lect_remove_student'])->name('lect_remove_student');
//Specify Class - Student
Route::get('class_stud_stream/{classroom}', [ClassroomController::class, 'class_stud_stream'])->name('class_stud_stream');
Route::get('class_stud_quiz/{classroom}', [ClassroomController::class, 'class_stud_quiz'])->name('class_stud_quiz');
Route::post('class_redirect_quiz', [ClassroomController::class, 'class_redirect_quiz'])->name('class_redirect_quiz');


Route::get('class_stud_qna/{classroom}', [ClassroomController::class, 'class_stud_qna'])->name('class_stud_qna');
Route::get('class_stud_polls/{classroom}', [ClassroomController::class, 'class_stud_polls'])->name('class_stud_polls');
Route::get('class_stud_feedback/{classroom}', [ClassroomController::class, 'class_stud_feedback'])->name('class_stud_feedback');
Route::get('class_stud_people/{classroom}', [ClassroomController::class, 'class_stud_people'])->name('class_stud_people');

Route::get('class_specify_qna/{qna}', [ClassroomController::class, 'class_specify_qna'])->name('class_specify_qna');
Route::post('class_reply_qna/{qna}', [ClassroomController::class, 'class_reply_qna'])->name('class_reply_qna');

Route::get('class_specify_polls/{polls}', [ClassroomController::class, 'class_specify_polls'])->name('class_specify_polls');
Route::post('class_reply_polls', [ClassroomController::class, 'class_reply_polls'])->name('class_reply_polls');

Route::get('class_lect_specify_qna/{qna}', [ClassroomController::class, 'class_lect_specify_qna'])->name('class_lect_specify_qna');
Route::post('class_reply_qna/{qna}', [ClassroomController::class, 'class_reply_qna'])->name('class_reply_qna');

Route::get('class_lect_specify_polls/{polls}', [ClassroomController::class, 'class_lect_specify_polls'])->name('class_lect_specify_polls');
Route::post('class_reply_polls', [ClassroomController::class, 'class_reply_polls'])->name('class_reply_polls');




//Specify Class - Lecturer
Route::get('class_lect_stream/{classroom}', [ClassroomController::class, 'class_lect_stream'])->name('class_lect_stream');
Route::get('class_lect_quiz/{classroom}', [ClassroomController::class, 'class_lect_quiz'])->name('class_lect_quiz');
Route::get('class_lect_qna/{classroom}', [ClassroomController::class, 'class_lect_qna'])->name('class_lect_qna');
Route::get('class_lect_polls/{classroom}', [ClassroomController::class, 'class_lect_polls'])->name('class_lect_polls');
Route::get('class_lect_feedback/{classroom}', [ClassroomController::class, 'class_lect_feedback'])->name('class_lect_feedback');
Route::get('class_lect_people/{classroom}', [ClassroomController::class, 'class_lect_people'])->name('class_lect_people');

Route::get('lect_add_class', [ClassroomController::class, 'lect_add_class'])->name('lect_add_class');
Route::post('lect_add_classroom', [ClassroomController::class, 'lect_add_classroom'])->name('lect_add_classroom');

Route::get('lect_update_class/{classroom}', [ClassroomController::class, 'lect_update_class'])->name('lect_update_class');

Route::post('lect_update_classroom/{classroom}', [ClassroomController::class, 'lect_update_classroom'])->name('lect_update_classroom');


Route::get('lect_search_class', [ClassroomController::class, 'classroom_lect_home'])->name('lect_search_class');

Route::post('class_add_announcement', [ClassroomController::class, 'class_add_announcement'])->name('class_add_announcement');
Route::post('class_stud_add_announcement', [ClassroomController::class, 'class_stud_add_announcement'])->name('class_stud_add_announcement');


Route::get('/get_announcement_details',  [ClassroomController::class, 'get_announcement_details'])->name('get_announcement_details');
Route::post('/class_stud_update_announcement', [ClassroomController::class,'class_stud_update_announcement'])->name('class_stud_update_announcement');
Route::post('class_update_announcement', [ClassroomController::class,'class_update_announcement'])->name('class_update_announcement');
Route::post('class_delete_announcement', [ClassroomController::class, 'class_delete_announcement'])->name('class_delete_announcement');
Route::post('class_stud_delete_announcement', [ClassroomController::class, 'class_stud_delete_announcement'])->name('class_stud_delete_announcement');

Route::post('assign_class', [ClassroomController::class,'assign_class'])->name('assign_class');
Route::post('assign_class_survey', [ClassroomController::class,'assign_class_survey'])->name('assign_class_survey');
Route::get('/get-lecturer-classes', [QuizSessionController::class, 'getLecturerClasses'])->name('get_lecturer_classes');
//Report
Route::get('report_home',  [ReportController::class, 'report_home'])->name('report_home');
Route::get('report_specify/{reportId}',  [ReportController::class, 'report_specify'])->name('report_specify');
Route::get('report_search', [ReportController::class, 'report_home'])->name('report_search');

/////// kel

// fortune wheel related
Route::get('/fortune-wheel-main', [FortuneWheelController::class, 'index'])->name('fortune-wheel-index');
Route::get('/create-fortune-wheel', [FortuneWheelController::class, 'createFortuneWheel'])->name('create-fortune-wheel');
Route::get('/edit-fortune-wheel/{id}', [FortuneWheelController::class, 'editFortuneWheel'])->name('edit-fortune-wheel');
Route::delete('/delete-fortune-wheel/{id}', [FortuneWheelController::class, 'deleteFortuneWheel'])->name('delete-fortune-wheel');
Route::post('/save-fortune-wheel', [FortuneWheelController::class, 'updateFortuneWheel']);
Route::get('/search-fortune-wheels', [FortuneWheelController::class, 'search'])->name('search-fortune-wheel');


//survey related
Route::get('/survey-index', [SurveyController::class, 'index'])->name('survey-index');
Route::get('/search-survey', [SurveyController::class, 'search'])->name('search-survey');
Route::get('/create-survey', [SurveyController::class, 'create'])->name('create-survey');
Route::get('/edit-survey/{id}', [SurveyController::class, 'edit'])->name('edit-survey');
Route::delete('/delete-survey/{id}', [SurveyController::class, 'delete'])->name('delete-survey');
Route::post('/save-survey', [SurveyController::class, 'store']);
Route::get('get-survey/{id}', [SurveyController::class, 'getSurvey']);
Route::get('/student-view-survey/{id}', [SurveyController::class, 'studentResponse'])->name('student-view-survey');
Route::get('/get-survey-response/{id}', [SurveyController::class, 'studentResponse'])->name('get-survey-response');
Route::post('/submit-survey-response', [SurveyController::class, 'storeResponse']);
Route::get('/show-response/{id}', [SurveyController::class, 'showResponses'])->name('show-response-survey');
Route::get('/export-survey',[SurveyController::class, 'exportToPdf'])->name('export-survey');
Route::get('/export-survey-response/{id}', [SurveyController::class, 'exportSurveyResponses']);

// quiz question related
Route::get('/create-quiz', [QuizController::class, 'create'])->name('create-quiz');
Route::get('/edit-quiz/{id}', [QuizController::class, 'edit'])->name('edit-quiz');
Route::get('/view-quiz/{id}', [QuizController::class, 'view'])->name('view-quiz');
Route::delete('/delete-quiz/{id}', [QuizController::class, 'delete'])->name('delete-quiz');
Route::post('/save-quiz', [QuizController::class, 'store']);

Route::get('/quiz-index-own-quiz', [QuizController::class, 'index_own_quiz'])->name('own-quiz');
Route::get('/quiz-index-own-quiz-search', [QuizController::class, 'index_own_quiz'])->name('own-quiz-search');
Route::get('/quiz-index-all-quiz', [QuizController::class, 'index_all_quiz'])->name('all-quiz');
Route::get('/quiz-index-all-quiz-search', [QuizController::class, 'index_all_quiz'])->name('all-quiz-search');


Route::get('/join-quiz', [QuizSessionController::class, 'joinQuiz'])->name('join-quiz');
Route::get('/quiz/details/{code}', [QuizSessionController::class, 'getQuizDetails']);
Route::get('/quiz/questions/{code}', [QuizSessionController::class, 'getQuizQuestions']);
Route::get('/quiz/settings/{sessionId}', [QuizSessionController::class, 'getQuizSessionSettings']);
Route::post('/create-quiz-session', [QuizSessionController::class,'createQuizSession']);
Route::get('/quiz-session-lecturer/{sessionId}', [QuizSessionController::class, 'startSession'])->name('quiz-session-lecturer');
Route::get('/leaderboard-lecturer', [QuizSessionController::class, 'getLeaderboard'])->name('leaderboard-lecturer');
Route::put('/end-session/{sessionId}', [QuizSessionController::class, 'endSession'])->name('endSession');
Route::get('/quiz-summary/{userId}/{sessionId}/{quizId}', [QuizSessionController::class, 'showQuizSummary']);
Route::get('/user/{userId}/session/{sessionId}/quiz/{quizId}/details', [QuizSessionController::class, 'fetchData']);
Route::get('/send-email/{userId}/{sessionId}/{quizId}', [QuizSessionController::class, 'sendEmail']);
Route::get('/generate-pdf/{userId}/{sessionId}/{quizId}', [QuizSessionController::class, 'generatePDF'])->name("generate-pdf");
Route::get('sessions/{sessionId}/quiz-questions', [QuizSessionController::class, 'getQuizQuestionsBySessionId']);
Route::get('sessions/qr-code/{sessionCode}', [QuizSessionController::class, 'generateQR']);


// interactive session related
Route::get('/stud_index', [InteractiveSessionController::class,'stud_index'])->name("stud_index");
Route::post('/stud-join-interactive-session', [InteractiveSessionController::class,'stud_join_interactive_session'])->name("stud-join-interactive-session");
Route::get('/interactive-session-index', [InteractiveSessionController::class,'index'])->name("interactive-session-index");
Route::post('/create-interactive-session', [InteractiveSessionController::class,'createInteractiveSession'])->name("create-interactive-session");
Route::get('/join-interactive-session', [InteractiveSessionController::class, 'joinInteractiveSession'])->name('join-interactive-session');
Route::post('/end-interactive-session', [InteractiveSessionController::class, 'endInteractiveSession']);
Route::get('/interactive-session-lecturer', [InteractiveSessionController::class, 'showInteractiveSessionLecturer'])->name('interactive-session-lecturer');

// Serve Vue app's entry point
Route::get('/quiz/{any}', function () {
    return view('quiz.spa');
})->where('any', '.*');
Route::get('/quiz/', function () {
    return view('quiz.spa');
});