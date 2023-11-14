<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .char_count {
            display: block;
            text-align: end;
            margin-top: -20px;
        }

        .input-fields {
            width: 100%;
            margin: 10px 0 20px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid black;
            min-height: 50px;
        }
    </style>

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
                <button class="btn btn-primary" type="button">Save</button>
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
                <div class="col-md-9 col-lg-10 col-xl-10" style="background-color: whitesm;">
                    <p><b>place to display the created question</b></p>

                    {{-- <button class="btn btn-primary">Create new question</button> --}}
                    <a href="{{ route('questions.create') }}" class="btn btn-primary">Create new question</a>

                    @if(count($questions) > 0)
                    @foreach($questions as $question)
                    <div class="stored-question">
                        <p>Question {{ $loop->iteration }}</p>
                        <button>Edit</button>
                        <button>Paste</button>
                        <button>Remove</button>
            
                        <p>Question title</p>
                        <p>{{ $question->title }}</p>
            
                        <p>Answer choice</p>
                        @foreach($question->options ?? [] as $option)
                            <p>{{ $option }}</p>
                        @endforeach
            
                        <p>Answer</p>
                        @foreach($question->correct_ans as $correctAnswer)
                        <p>{{ $correctAnswer }}</p>
                         @endforeach            
                        

                        @if ($question->answer_explanation)
                            <p>Answer Explanation</p>
                            <p>{{ $question->answer_explanation }}</p>
                        @endif
            
                        <p>Time</p>
                        <p>{{ $question->duration }}</p>
            
                        <p>Point</p>
                        <p>{{ $question->points }}</p>
                    </div>
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
                        <p class="m-0"><b class="required">Quiz Title</b></p>
                        <label for="quiz_title_modal"></label>
                        <input id="quiz_title_modal" class="input-fields" type="text" title="Quiz Title" />
                        <span id="title_char_counter_modal" class="char_count">0/0</span>
                    </div>
                    <div>
                        <p class="m-0"><b>Description</b></p>
                        <label for="quiz_description_modal"></label>
                        <textarea id="quiz_description_modal" class="input-fields" title="Quiz Description"></textarea>
                        <span id="description_char_counter_modal" class="char_count">0/0</span>
                    </div>
                    <div>
                        <p class="m-0"><b>Visibility</b></p>
                        <label for="visibility_modal"></label>
                        <select id="visibility_modal" name="visibility_modal" class="input-fields"
                            title="Quiz Visibility">
                            <option value="public">Public</option>
                            <option value="private">Private</option>
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
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>

    <script>
        // Added this script to handle the click event for the quiz details container
        $(document).ready(function () {
            $("#quizDetailsContainer").click(function () {
                $("#quizModal").modal("show");
            });
        });

        function saveQuizDetails() {
            var quizTitle = $("#quiz_title_modal").val();
            var quizDescription = $("#quiz_description_modal").val();
            var visibility = $("#visibility_modal").val();

            // Add your logic to save quiz details, including the new content (visibility) here

            // Close the modal after saving
            $("#quizModal").modal("hide");

            // Update the displayed title (if needed)
            $("#quizDetailsTitle").text(quizTitle);
        }
    </script>

    <!--for multiple choice question -->
    <script>
        var optionCount = 2; // Initial option count
        const defaultOptionCount = 4;
        const maxOptionCount = 6;
        let currentCount = 0;

        // <div class="col-md-3">
        //     <input type="text" class="input-fields" placeholder="Option 1" />
        //     <button class="btn btn-danger" type="button" style="display: none;">Remove</button>
        // </div>

        for (var i = 0; i < defaultOptionCount; i++) {
                addOption();
        }

        function addOption() {
            if (currentCount < maxOptionCount) {
            var optionDiv = document.createElement("div");
            optionDiv.className = "col-md-3";

            var input = document.createElement("input");
            input.type = "text";
            input.className = "input-fields";
            input.placeholder = "Option " + (currentCount + 1);

            var removeButton = document.createElement("button");
            removeButton.className = "btn btn-danger";
            removeButton.type = "button";
            removeButton.innerHTML = "Remove";
            removeButton.onclick = function () {
                optionDiv.remove();
                optionCount--;
            };

            optionDiv.appendChild(input);
            optionDiv.appendChild(removeButton);

            document.getElementById("optionsContainer").appendChild(optionDiv);
            currentCount++;
        }
    }


    </script>

</body>

</html>