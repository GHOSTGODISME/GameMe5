<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/quiz-style.css') }}">
</head>

<body>
    <div class="container">
        <div class="row header">
            <div class="col-md-4 text-start favicon-with-text">
                <i class="fas fa-chevron-left"></i>
                <span>Back</span>

                <div class="col-md-4 text-end" id="quizDetailsContainer">
                    <span id="quizDetailsTrigger" style="cursor: pointer;">
                        <!-- Added this span for styling and cursor -->
                        <span id="quizDetailsTitle" style="cursor: pointer;">Quiz Title</span>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#quizModal">Edit</button>
                    </span>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <h2 class="text-center text-black-50 title-style-header" id="quiz_title_header">Quiz Title</h2>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" type="button">Save Quiz</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-md-3 col-lg-2 col-xl-2" style="min-height: 200px;background-color: red;">
                    Quiz structure
                    <!-- this is the place for the user to rearrange the structure
                    like survey -->
                </div>
                <div class="col-md-9 col-lg-10 col-xl-10" style="background-color: whitesmoke;">
                    <p><b>place to display the created question</b></p>

                    {{-- <button class="btn btn-primary">Create new question</button> --}}
                    <a href="{{ route('create-question', ['id' => $quiz->id]) }}" class="btn btn-primary">Create new question</a>

                    @if (isset($questions) && !is_null($questions) && count($questions) > 0)
                        @foreach ($questions as $question)
                            <div class="question-container">
                                <div class="question-container-header">
                                    <div class="question-counter">
                                        <span>Question {{ $loop->iteration }}</span>
                                    </div>
                                    <div class="button-container">
                                        <button class="btn btn-primary">Edit</button>
                                        <button class="btn btn-primary">Duplicate</button>
                                        <button class="btn btn-danger">Remove</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="question-title-container ">
                                    <p>{{ $question->title }}</p>
                                </div>

                                @if (!empty($question->options))
                                    <div class="answer-choice-container container-space">
                                        <div class="horizontal-line-with-text">
                                            <span> Answer choice </span>
                                        </div>
                                        <div id="answer-choice-details">
                                            @foreach ($question->options as $option)
                                                <p>{{ $option }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif


                                <div class="correct-answer-container container-space">
                                    <div class="horizontal-line-with-text">
                                        <span> Answer </span>
                                    </div>
                                    <div id="correct-answer">
                                        @foreach ($question->correct_ans as $correctAnswer)
                                            <p>{{ $correctAnswer }}</p>
                                        @endforeach
                                    </div>
                                </div>

                                @if (!empty($question->answer_explanation))
                                    <div class="answer-explanation-container container-space">
                                        <div class="horizontal-line-with-text">
                                            <span> Answer Explanation </span>
                                        </div>
                                        <p>{{ $question->answer_explanation }}</p>
                                    </div>
                                @endif


                                <div class="question-container-footer">
                                    <label for="quiz-duration">duration</label>
                                    <select id="quiz-duration" name="Quiz duration" title="Quiz duration">
                                        <option value="10" {{ $question->duration === '10' ? 'selected' : '' }}>10
                                            seconds</option>
                                        <option value="15" {{ $question->duration === '15' ? 'selected' : '' }}>15
                                            seconds</option>
                                        <option value="30" {{ $question->duration === '30' ? 'selected' : '' }}>30
                                            seconds</option>
                                    </select>

                                    <label for="quiz-points">points</label>
                                    <select id="quiz-points" name="Quiz points" title="Quiz points">
                                        <option value="10" {{ $question->points === '10' ? 'selected' : '' }}>10
                                        </option>
                                        <option value="15" {{ $question->points === '15' ? 'selected' : '' }}>15
                                        </option>
                                        <option value="30"{{ $question->points === '30' ? 'selected' : '' }}>30
                                        </option>
                                    </select>
                                </div>
                            </div>
                            </select>

                            <hr> <!-- Add a horizontal line to separate questions -->
                        @endforeach
                    @else
                        <p>No records found.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <!-- model for popup-screen -->
    <div class="modal fade" id="quizModal" tabindex="-1" aria-labelledby="quizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quizModalLabel">Quiz Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3">
                    <div>
                        <p class="m-0"><b class="required">Title</b></p>
                        <label for="quiz_title_modal"></label>
                        <input id="quiz_title_modal" class="input-fields" type="text" title="Quiz Title" value="{{ $quiz->title }}"/>
                        <span id="title_char_counter_modal" class="char_count">0/0</span>
                    </div>
                    <div>
                        <p class="m-0"><b>Description</b></p>
                        <label for="quiz_description_modal"></label>
                        <textarea id="quiz_description_modal" class="input-fields" title="Quiz Description" placeholder="(Optional)">{{ $quiz->description }}</textarea>
                        <span id="description_char_counter_modal" class="char_count">0/0</span>
                    </div>
                    <div>
                        <p class="m-0"><b>Visibility</b></p>
                        <label for="visibility_modal"></label>
                        <select id="visibility_modal" name="visibility_modal" class="input-fields"
                            title="Quiz Visibility">
                            <option value="public" {{ $quiz->visibility === 'public' ? 'selected' : '' }}>Public</option>
                            <option value="private" {{ $quiz->visibility === 'public' ? 'selected' : '' }}>Private</option>
                        </select>
                    </div>
                    <!-- Add any additional fields you need in the modal -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveQuizDetails()">Save</button>
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

    <script>
        console.log(@json($quiz));
        console.log(@json($questions));

        // Added this script to handle the click event for the quiz details container
        class Quiz {
            constructor(title, description, visibility) {
                this.id = "";
                this.title = title;
                this.description = description;
                this.visibility = visibility;
            }
        }

        $(document).ready(function() {
            $("#quizDetailsContainer").click(function() {
                $("#quizModal").modal("show");
            });
        });

        function saveQuizDetails() {
            var quizTitle = $("#quiz_title_modal").val();
            var quizDescription = $("#quiz_description_modal").val();
            var visibility = $("#visibility_modal").val();
            const quiz = new Quiz(quizTitle, quizDescription, visibility);

            // Add your logic to save quiz details, including the new content (visibility) here

            // Close the modal after saving
            $("#quizModal").modal("hide");

            // Update the displayed title (if needed)
            $("#quizDetailsTitle").text(quizTitle);
        }


        function saveQuiz() {
            // Retrieve survey details (title, description, etc.)
            var quizTitle = $("#quiz_title_modal").val();
            var quizDescription = $("#quiz_description_modal").val();
            var visibility = $("#visibility_modal").val();
            const quiz = new Quiz(quizTitle, quizDescription, visibility);

            const validQuiz = validateDetails(quiz);

            console.log(quiz);
            // Make an AJAX POST request to the backend to save the form data
            if (validQuiz) {
                $.ajax({
                    url: '/save-quiz',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(survey),
                    success: function(response) {
                        console.log('Quiz saved successfully:', response);
                        history.back();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving form:', error);
                        console.log('Response Text:', xhr.responseText);
                    }

                });
            }
        }

        function validateDetails(quiz) {
            if (!quiz.title.trim()) {
                alert("Please enter a title for your quiz");
                return false;
            }
            if (quiz.visibility === null) {
                alert("Please select the visibility of your quiz");
                return false;
            }
            return true;
        }
    </script>

</body>

</html>
