<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   
    <link rel="stylesheet" href="{{ asset('css/quiz-style.css') }}">
    <style scoped>
        .header-container {
            height: 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(to right, #13C1B7, #87DFA8);
            color: white;
            padding: 30px;
            flex-wrap: wrap;
        }

        .header-quiz-title {
            font-weight: bold;
            font-size: 32px;
        }

        .edit-quiz-page-body {
            width: 80%;
        }

        body {
            background: whitesmoke;
        }

        .quiz-details-container:first-child {
            padding: 30px;
            margin: 30px 0 0;
            background: white;
            border-radius: 10px;
        }

        .quiz-details-questions-container {
            padding: 30px;
            margin: 5px;
            margin-top: 30px;
            background: white;
            border-radius: 10px;
        }

        .quiz-details-button {
            background: white;
            margin-top: 15px;
            padding: 30px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            align-items: center;
            gap: 10px;
        }

        .quiz-details-button button {
            width: 200px;
            padding: 10px 0;
        }

        .live-session-setting-style {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        .live-session-section-style {
            background: white;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            font-size: 18px;
            border: 1px solid grey;
        }

        .live-session-section-style div:first-child {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <img src="img/logo_header.png" alt="Logo">

        <div class="">
            <!-- <h2 >Quiz Title</h2> -->
            <div class="" id="quizDetailsContainer">
                <span id="quizDetailsTrigger" style="cursor: pointer;">
                    <!-- Added this span for styling and cursor -->
                    <span id="quizDetailsTitle" style="cursor: pointer;display: inline;text-align: center;"
                        class="title-style-header h2 quiz-title-display" id="quiz_title_header">Quiz Title</span>
                    <a><i class="fa-regular fa-pen-to-square" style="font-size: 22px; margin-left: 10px;"></i></a>
                </span>
            </div>
        </div>

        @if ($mode == 'edit' || $mode == 'create')
            <button class="btn btn-dark header-save-btn" id="save-quiz-btn" type="button">Save Quiz</button>
        @else
            <a href="{{ route('edit-quiz', ['id' => $quiz->id]) }}" class="btn btn-dark header-edit-btn">
                Edit</a>
            {{-- <button class="btn btn-dark header-edit-btn" id="edit-quiz-btn" type="button">Edit</button> --}}
        @endif

    </div>

    <div class="container edit-quiz-page-body">
        <div class="row">
            <div class="row">
                <div class="col-md-5 col-lg-5 col-xl-4">
                    <div class="quiz-details-container">
                        <p class="h4" style="margin-bottom: 20px;">Quiz structure</p>
                        <div>
                            <p><b>Title: </b><span class="quiz-title-display "></span></p>
                            <p class="quiz-description-container"><b>Description: </b><span
                                    class="quiz-description-display"></span></p>
                            <p><b>Visibility: </b><span class="quiz-visibility-display"></span></p>

                            @if (isset($quiz->id))
                                <small class="text-black-50"><span class="num-of-plays">0</span> plays</small>
                            @endif
                        </div>
                        @if ($mode == 'view')
                            <div class="quiz-details-button">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#liveSessionModal">Start
                                    Live Session </button>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignClassModal">
                                        Assign to Class
                                    </button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-7 col-lg-7 col-xl-8">
                    <div class="quiz-details-questions-container">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <p class="m-0"><b>Questions (<span id="num_of_question">0</span>)</b></p>

                            @if ($mode == 'edit')
                                <button type="button" class="btn btn-primary" id="openQuestionModal"
                                    data-bs-toggle="modal" data-bs-target="#questionModal">
                                    <i class="fa-solid fa-plus" style="margin-right: 10px;"></i>Add Question
                                </button>
                            @endif
                        </div>


                        <div id="all_quiz_questions_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <!-- model for quiz details edition-screen -->
    <div class="modal fade" id="quizModal" tabindex="-1" aria-labelledby="quizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content" style="padding: 25px;">
                <!-- Modal header -->

                <div class="modal-header">
                    <h5 class="modal-title" id="quizModalLabel">Quiz Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body m-3">
                    <div>
                        <p class="m-0"><b class="required">Title</b></p>
                        <label for="quiz_title_modal"></label>
                        <input id="quiz_title_modal" class="input-fields form-control" type="text" title="Quiz Title"
                            value="{{ $quiz->title }}" @if ($mode === 'view') disabled @endif />
                        <!-- <span id="title_char_counter_modal" class="char_count">0/0</span> -->
                    </div>
                    <div>
                        <p class="m-0"><b>Description</b></p>
                        <label for="quiz_description_modal"></label>
                        <textarea id="quiz_description_modal" class="input-fields form-control" title="Quiz Description"
                            placeholder="(Optional)" style="height:max-content;"@if ($mode === 'view') disabled @endif>{{ $quiz->description }}</textarea>
                        {{-- <span id="description_char_counter_modal" class="char_count">0/0</span> --}}
                    </div>
                    <div>
                        <p class="m-0"><b>Visibility</b></p>
                        <label for="visibility_modal"></label>
                        <select id="visibility_modal" name="visibility_modal" class="input-fields form-control"
                            title="Quiz Visibility" @if ($mode === 'view') disabled @endif>
                            <option value="public" {{ $quiz->visibility === 'public' ? 'selected' : '' }}>Public
                            </option>
                            <option value="private" {{ $quiz->visibility === 'private' ? 'selected' : '' }}>Private
                            </option>
                        </select>
                    </div>
                    <!-- Add any additional fields you need in the modal -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveQuizDetailsBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal for quiz question creation and edition -->
    <div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel"
        aria-hidden="true">
        <!-- Modal content -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="padding: 25px;">
                <!-- Modal header -->
                <div class="modal-header">
                    <h5 class="modal-title">Modify Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" id="quiz_unique_id" name="quiz_unique_id" value="">

                    <!-- <div class="question-container"> -->
                    <div class="row d-flex">
                        <div class="col-10 col-md-7 col-lg-5 question-container-header">
                            <label for="quiz-type" style="font-size: 18px;">Quiz type</label>
                            <select id="quiz-type" name="Quiz Type" class=" form-select ddl-style"
                                title="Quiz Type">
                                <option value="Multiple Choice" selected>Multiple Choice</option>
                                <option value="True/False">True/False</option>
                                <option value="Text Input">Text Input</option>
                            </select>
                        </div>
                        <div class="col-10 col-md-7 col-lg-5 question-container-header"
                            id="quiz-mc-ans-option-container">
                            <label for="quiz-mc-ans-option" style="font-size: 18px;">Answer Option </label>
                            <select id="quiz-mc-ans-option" name="Answer Option" class="form-select ddl-style"
                                title="Answer Option">
                                <option value="single" selected>Single Select</option>
                                <option value="multiple">Multiple Select</option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <!-- <button class="btn btn-primary" id="save-quiz-question">Save Question</button> -->

                    <div class="container">
                        <div class="row">
                            <!-- <div class="col-md-12">quiz title</div> -->
                            <div class="col-md-12">
                                <label for="quiz_title"></label>
                                <textarea id="quiz_title" class="input-fields form-control" title="Quiz Title"
                                    placeholder="Enter your question here"></textarea>
                            </div>

                        </div>
                        <div class="row justify-content-center" id="optionsContainer">
                            <!-- Options will be dynamically added here -->
                        </div>

                        <div class="row" id="mcq_addbtn_container">
                            <div class="col-md-12 d-flex justify-content-center m-3">
                                <button class="btn btn-primary" type="button" onclick="addOption()">Add
                                    options</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <label for="quiz_answer_explaination">Answer Explaination</label>
                                <textarea id="quiz_answer_explaination" class="input-fields form-control" title="Quiz Explantion"
                                    placeholder="(Optional) A better explaination could definitely helps the students to understand more"></textarea>

                            </div>
                        </div>

                        <hr>

                        <div class="row d-flex">
                            <div class="col-10 col-md-7 col-lg-5 question-container-header">
                                <label for="quiz-duration" style="font-size: 18px;">Duration</label>
                                <select id="quiz-duration" name="Quiz duration" class="form-select ddl-style"
                                    title="Quiz duration">
                                    <option value="10">10 seconds</option>
                                    <option value="15">15 seconds</option>
                                    <option value="30">30 seconds</option>
                                </select>
                            </div>
                            <div class="col-10 col-md-7 col-lg-5 question-container-header"
                                id="quiz-mc-ans-option-container">
                                <label for="quiz-points" style="font-size: 18px;">Points</label>
                                <select id="quiz-points" name="Quiz points" class="form-select ddl-style"
                                    title="Quiz points">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveQuestionBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- live session Modal -->
    <div class="modal fade" id="liveSessionModal" tabindex="-1" aria-labelledby="liveSessionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="padding: 25px;">

                <div class="modal-header">
                    <h5 class="modal-title">Initiate Live Session for</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="live-session-section-style">
                        <div>Details</div>
                        <hr>
                        <p><b>Title: </b><span id="session-title">{{ $quiz->title }}</span></p>
                        <p><small><b>Number of Questions: </b><span id="question-count">10</span></small>
                        </p>
                    </div>

                    <div class="live-session-section-style">
                        <div>Question and Answer</div>
                        <hr>
                        <div class="live-session-setting-style">
                            <label class="form-check-label" for="shuffleSwitch">Shuffle Options</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="shuffleSwitch">
                            </div>
                        </div>
                    </div>

                    <div class="live-session-section-style">
                        <div>Gamification</div>
                        <hr>
                        <div class="live-session-setting-style">
                            <label class="form-check-label" for="leaderboardSwitch">Show Leaderboard</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="leaderboardSwitch" checked>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="continueBtn">Continue</button>
                </div>
            </div>
        </div>
    </div>

    


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <link rel="stylesheet"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
        <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
        integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous">
</script>

    <script>
        class QuizSessionSetting {
            constructor() {
                this.shuffleOptions = false;
                this.showLeaderboard = true;
            }
        }

        const quizFromDB = @json($quiz);
        const quizQuestionFromDB = @json($questions);
        const mode = @json($mode);
        console.log(quizFromDB);
        console.log(quizQuestionFromDB);

        $(document).ready(function() {
            $('#continueBtn').click(function() {
                // Get settings from the checkboxes
                const quizSessionSetting = new QuizSessionSetting();
                quizSessionSetting.shuffleOptions = $('#shuffleSwitch').is(':checked')? 1 : 0;
                quizSessionSetting.showLeaderboard = $('#leaderboardSwitch').is(':checked')? 1 : 0;
                console.log(quizSessionSetting);
                const quizId = quizFromDB.id;
                // AJAX request to store the new quiz session
                $.ajax({
                    url: '/create-quiz-session', // Replace with your backend route
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        quizSessionSetting,
                        quizId
                    }),
                    success: function(response) {
                        // Handle success, e.g., display a success message or redirect
                        console.log('Quiz session created successfully!');
                        // Assuming you have the URL stored in a variable called 'redirectUrl'
                        console.log(response.sessionCode);
                        if (response.sessionCode) {
                            sessionStorage.setItem("sessionId", response.sessionId);
                            sessionStorage.setItem("sessionCode", response.sessionCode);
                            // Redirect to the specified URL with the sessionCode as a query parameter
                            
                            socket = io("http://localhost:3000");
                            socket.emit("createSession", response.sessionCode.toString());

                            socket.on('session created',()=>{
                                window.location.href =
                                "{{ route('quiz-session-lecturer', ['sessionId' => ':sessionId']) }}"
                                .replace(':sessionId', response.sessionId);
                                socket.close();
                            })

                        } else {
                            // Handle the case when sessionCode is missing or invalid
                            console.error('Session code is missing or invalid.');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            });
        });
    </script>

    <script src="{{ asset('js/quiz.js') }}"></script>

    {{-- <script>
        console.log(@json($quiz));
        console.log(@json($questions));
    </script> --}}

</body>

</html>
