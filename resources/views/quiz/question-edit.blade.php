<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <style>
        .input-fields {
            width: 100%;
            margin: 10px 0 20px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid black;
            min-height: 50px;
        }

        .input-fields:focus {
            background-color: whitesmoke;
        }

        .format-option {
            margin: 20px;
            padding: 10px;
            border-radius: 10px;
            border: solid 1px black;
        }

        .correct-answer-radio,
        .correct-answer-checkbox {
            float: right;
            margin: 5px;
            height: 20px;
            width: 20px;
        }

        .icon {
            margin-right: 5px;
        }

        .student-input {
            width: 20px;
            margin: 5px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #CACACA;
        }
    </style>
</head>

<body>
    <div>
        <label for="quiz-type">Quiz type</label>
        <select id="quiz-type" name="Quiz Type" class="input-fields" title="Quiz Type">
            <option value="multiple" selected>Multiple Choice</option>
            <option value="truefalse">True/False</option>
            <option value="textinput">Text Input</option>
        </select>

        <label for="quiz-mc-ans-option">Answer Option </label>
        <select id="quiz-mc-ans-option" name="Answer Option" class="input-fields" title="Answer Option">
            <option value="single" selected>Single Select</option>
            <option value="multiple">Multiple Select</option>
        </select>

        <label for="quiz-duration">duration</label>
        <select id="quiz-duration" name="Quiz duration" class="input-fields" title="Quiz duration">
            <option value="10">10 seconds</option>
            <option value="15">15 seconds</option>
            <option value="30">30 seconds</option>
        </select>

        <label for="quiz-points">points</label>
        <select id="quiz-points" name="Quiz points" class="input-fields" title="Quiz points">
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="30">30</option>
        </select>


        <button class="btn btn-primary" id="save-quiz-question">Save Question</button>

        <div class="container">
            <div class="row">
                <!-- <div class="col-md-12">quiz title</div> -->
                <div class="col-md-12">
                    <label for="quiz_title"></label>
                    <textarea id="quiz_title" class="input-fields" title="Quiz Title" placeholder="Enter your question here"></textarea>
                </div>

            </div>
            <div class="row justify-content-center" id="optionsContainer">
                <!-- Options will be dynamically added here -->
            </div>

            <div class="row" id="mcq_addbtn_container">
                <div class="col-md-12 d-flex justify-content-center m-3">
                    <button class="btn btn-primary" type="button" onclick="mcqSingleOption()">Add
                        options</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <br>
                    <label for="quiz_answer_explaination">quiz_answer_explaination</label>
                    <textarea id="quiz_answer_explaination" class="input-fields" title="Quiz Explantion"
                        placeholder="(Optional) A better explaination could definitely helps the students to understand more"></textarea>

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
    {{-- <script src="pending.js"></script> --}}
    {{-- <script src="{{ asset('js/pending.js') }}"></script> --}}

    <script>
        // Constants
        const QUESTION_TYPE_INT = {
            MULTIPLE_CHOICE: 0,
            TRUE_FALSE: 1,
            TEXT_INPUT: 2,
        };

        const QUESTION_TYPE_STRING = {
            0: "multiple",
            1: "truefalse",
            2: "textinput",
        };

        const MIN_OPTION_COUNT = 2;
        const DEFAULT_OPTION_COUNT = 4;
        const MAX_OPTION_COUNT = 6;

        // Global Variables
        let optionCount = 0; // Initial option count

        // Quiz Details Class
        class Question {
            constructor() {
                this.id = ""
                this.title = "";
                this.type = "";
                this.options = null;
                this.correct_ans = [];
                this.answer_explaination = null;
                this.single_ans_flag = true;
                this.points = 0;
                this.duration = 0;
                this.quiz_id = "";
            }
        }

        // Quiz Details Instance
        const quizDetails = new Question();

        const quizFromDb = @JSON($quiz);
        quizDetails.quiz_id = quizFromDb.id;
        // console.log(@JSON($quiz));
        console.log(quizFromDb);
        console.log(quizDetails.quiz_id);

        // DOM Ready Event
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Event listener for quiz type container click
            $("#quizDetailsContainer").click(function() {
                $("#quizModal").modal("show");
            });

            // Event listener for quiz type change
            $('#quiz-type').change(function() {
                handleQuizTypeChange();
            });

            // Event listener for answer option change
            $('#quiz-mc-ans-option').change(function() {
                updateAnswerOption();
            });

            // Initialize default options
            initializeOptions();
        });


        // Functions
        function initializeOptions() {
            for (var i = 0; i < DEFAULT_OPTION_COUNT; i++) {
                mcqSingleOption();
            }
            initializeTooltips();

        }


        // Function to update input element state based on the presence of a value
        function updateInputState(input, checkbox) {
            var value = input.val();
            checkbox.prop('disabled', value === '');
        }

        function initializeTooltips() {
            $('.correct-answer-radio, .correct-answer-checkbox').each(function() {
                var checkbox = $(this);
                var input = checkbox.siblings('input[name="input_options"]');

                // Initialize tooltip
                checkbox.tooltip({
                    placement: 'right', // Change the placement to 'right'
                    trigger: 'hover',
                    title: function() {
                        return input.val() ? 'Mark this as correct answer' :
                            'Please enter a value first';
                    },
                    template: '<div class="tooltip" role="tooltip"><div class="tooltip-inner"></div></div>'
                });

                // Update input state
                updateInputState(input, checkbox);

                // Handle input value change
                input.on('input', function() {
                    updateInputState(input, checkbox);
                });
            });
        }


        // Update tooltips on option value change
        $(document).on('input', 'input[name="input_options"]', function() {
            initializeTooltips();
        });

        function handleQuizTypeChange() {
            var selectedQuizType = $('#quiz-type').val();
            var answerOptionContainer = $("#quiz-mc-ans-option");
            var optionContainer = document.getElementById("optionsContainer");

            optionContainer.innerHTML = "";

            if (selectedQuizType === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.MULTIPLE_CHOICE]) {
                document.getElementById("mcq_addbtn_container").style.display = "block";
                answerOptionContainer.show();
                quizDetails.single_ans_flag = true;
                updateAnswerOption();
                optionCount = 0;

                for (var i = 0; i < DEFAULT_OPTION_COUNT; i++) {
                    mcqSingleOption();
                }
            } else if (selectedQuizType === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TRUE_FALSE]) {
                document.getElementById("mcq_addbtn_container").style.display = "none";
                answerOptionContainer.hide();
                quizDetails.single_ans_flag = true;
                updateAnswerOption();
                trueFalse();
            } else if (selectedQuizType === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TEXT_INPUT]) {
                document.getElementById("mcq_addbtn_container").style.display = "none";
                answerOptionContainer.hide();
                quizDetails.single_ans_flag = null;
                textInput();
            } else {
                answerOptionContainer.hide();
                quizDetails.single_ans_flag = null;
            }

            initializeTooltips();
        }


        function mcqSingleOption() {
            if (optionCount < MAX_OPTION_COUNT) {
                var optionContainer = document.getElementById("optionsContainer");

                var optionDiv = document.createElement("div");
                optionDiv.className = "col-10 col-md-3 format-option";

                var input = document.createElement("input");
                input.type = "text";
                input.className = "input-fields";
                input.name = "input_options"
                input.placeholder = "Enter your option here";

                var correctAnswerInputRadio = document.createElement("input");
                correctAnswerInputRadio.type = "radio";
                correctAnswerInputRadio.name = "correct-answer-radio";
                correctAnswerInputRadio.className = "correct-answer-radio";
                correctAnswerInputRadio.setAttribute("data-option-index", optionCount);

                var correctAnswerInputCheckbox = document.createElement("input");
                correctAnswerInputCheckbox.type = "checkbox";
                correctAnswerInputCheckbox.name = "correct-answer-checkbox";
                correctAnswerInputCheckbox.className = "correct-answer-checkbox";
                correctAnswerInputCheckbox.setAttribute("data-option-index", optionCount);

                var removeButton = document.createElement("button");
                removeButton.className = "btn btn-danger m-auto";
                removeButton.type = "button";
                removeButton.innerHTML = `<i class="far fa-trash-alt icon"></i>`;
                removeButton.innerHTML += "Remove";
                removeButton.style.display = optionCount <= MIN_OPTION_COUNT ? "none" :
                "block"; // Hide if total options are 2 or fewer

                removeButton.onclick = function() {
                    optionDiv.remove();
                    optionCount--;

                    // Check total options again and update the display of delete buttons
                    updateDeleteButtonDisplay();
                };

                optionDiv.appendChild(correctAnswerInputRadio);
                optionDiv.appendChild(correctAnswerInputCheckbox);
                optionDiv.appendChild(input);
                optionDiv.appendChild(removeButton);

                optionContainer.appendChild(optionDiv);

                optionCount++;

                // Check total options and update the display of delete buttons
                updateDeleteButtonDisplay();
                updateAnswerOption();
                initializeTooltips();
            }
        }

        function trueFalse() {
            // <div class="col-10 col-md-5 format-option">
            //             <input type="radio" name="correct-answer" class="correct-answer-radio" >
            //             <input type="text" class="input-fields text-center fs-5 border-0" name="input_options" value="True" readonly>    
            //         </div>
            //         <div class="col-10 col-md-5 format-option">
            //             <input type="radio" name="correct-answer" class="correct-answer-radio">
            //             <input type="text" class="input-fields text-center fs-5 border-0" name="input_options" value="False" readonly>    
            //         </div>

            const TF = ["True", "False"];

            TF.forEach(function(tf) {
                var optionDiv = document.createElement("div");
                optionDiv.className = "col-10 col-md-3 format-option";

                var input = document.createElement("input");
                input.type = "text";
                input.className = "input-fields text-center fs-5 border-0";
                input.name = "input_options"
                input.value = tf;
                input.readonly = true;

                var correctAnswerInputRadio = document.createElement("input");
                correctAnswerInputRadio.type = "radio";
                correctAnswerInputRadio.name = "correct-answer-radio";
                correctAnswerInputRadio.className = "correct-answer-radio";
                // correctAnswerInputRadio.setAttribute("data-option-index", tf);
                correctAnswerInputRadio.setAttribute("value", tf);

                optionDiv.appendChild(correctAnswerInputRadio);
                optionDiv.appendChild(input);

                document.getElementById("optionsContainer").appendChild(optionDiv);
            });


            initializeTooltips();
        }

        function textInput() {
            //     <div class="row justify-content-center">
            //     <div class="col-10 col-md-10 format-option">
            //         <label for="text_input_correct_answer">Enter your answer here</label>
            //         <textarea id="text_input_correct_answer" class="input-fields"
            //             title="Text Input Answer"></textarea>
            //     </div>

            //     <div class="col-10 col-md-10 format-option">
            //         <p>Student's view</p>
            //         <div id="students-view" class="row justify-content-center "></div>
            //     </div>
            // </div>

            var optionDiv = document.createElement("div");
            optionDiv.className = "col-10 col-md-10 format-option";

            var label = document.createElement("label");
            label.htmlFor = "text_input_correct_answer";
            label.textContent = "Enter your answer here";

            var textarea = document.createElement("textarea");
            textarea.id = "text_input_correct_answer";
            textarea.className = "input-fields";
            textarea.title = "Text Input Answer";
            textarea.placeholder = "Enter the answer here";
            textarea.oninput = function() {
                updateStudentsView();
            };

            var studentViewContainer = document.createElement("div");
            studentViewContainer.className = "col-10 col-md-10 format-option";
            studentViewContainer.innerHTML += "<p>Student's view</p>";

            var studentViewSample = document.createElement("div");
            studentViewSample.id = "student-view";
            studentViewSample.className = "row justify-content-center";

            studentViewContainer.appendChild(studentViewSample);

            optionDiv.appendChild(label);
            optionDiv.appendChild(textarea);
            optionDiv.appendChild(studentViewContainer);

            document.getElementById("optionsContainer").appendChild(optionDiv);

        }

        function updateStudentsView() {
            var answerTextarea = document.getElementById('text_input_correct_answer');
            var studentsViewDiv = document.getElementById('student-view');

            // Clear the existing content in student's view
            studentsViewDiv.innerHTML = '';

            // Get the current value in the answer textarea
            var answerValue = answerTextarea.value;

            // Loop through each character and create an input block
            for (var i = 0; i < answerValue.length; i++) {
                var inputBlock = document.createElement('input');
                inputBlock.type = 'text';
                inputBlock.className = 'student-input';
                // inputBlock.value = answerValue[i];
                inputBlock.readOnly = true;

                studentsViewDiv.appendChild(inputBlock);
            }
        }


        function updateDeleteButtonDisplay() {
            var deleteButtons = document.querySelectorAll("#optionsContainer .btn-danger");

            // Hide all delete buttons if total options are 2 or fewer, else show them
            deleteButtons.forEach(function(button) {
                button.style.display = optionCount <= MIN_OPTION_COUNT ? "none" : "block";
            });
        }

        function updateQuizDetailsOptions() {
            quizDetails.options = [];
            quizDetails.correct_ans = [];

            var options = document.querySelectorAll("#optionsContainer input[name='input_options']");
            var correctAnswerInputsRadio = document.querySelectorAll(
            "#optionsContainer input[name='correct-answer-radio']");
            var correctAnswerInputsCheckbox = document.querySelectorAll(
                "#optionsContainer input[name='correct-answer-checkbox']");

            options.forEach(function(option, index) {
                console.log("option " + option.value + " index " + index);
                if (option.value != '') {
                    quizDetails.options.push(option.value);
                }



                if (quizDetails.single_ans_flag) {
                    var optionIndex = correctAnswerInputsRadio[index].getAttribute("data-option-index");
                    if (correctAnswerInputsRadio[index].type === 'radio' && correctAnswerInputsRadio[index]
                        .checked) {
                        // quizDetails.correct_ans = [optionIndex];
                        quizDetails.correct_ans.push(option.value);
                    }
                } else {
                    var optionIndexCheckbox = correctAnswerInputsCheckbox[index].getAttribute("data-option-index");
                    if (correctAnswerInputsCheckbox[index].type === 'checkbox' && correctAnswerInputsCheckbox[index]
                        .checked) {
                        // quizDetails.correct_ans.push(optionIndexCheckbox);
                        quizDetails.correct_ans.push(option.value);
                    }
                }
            });
        }

        function updateAnswerOption() {
            var selectedAnswerOption = $("#quiz-mc-ans-option").val();
            quizDetails.single_ans_flag = selectedAnswerOption === "single";

            //reset checked fields
            $("input[name='correct-answer-radio']").prop('checked', false);
            $("input[name='correct-answer-checkbox']").prop('checked', false);


            if (quizDetails.single_ans_flag === true) {
                $(".correct-answer-checkbox").hide();
                $(".correct-answer-radio").show();
            } else if (quizDetails.single_ans_flag === false) {
                $(".correct-answer-radio").hide();
                $(".correct-answer-checkbox").show();
            }
        }

        function variableAssignment(quizDetails) {
            quizDetails.title = $("#quiz_title").val();
            quizDetails.type = $("#quiz-type").val();
            quizDetails.duration = parseInt($("#quiz-duration").val());
            quizDetails.points = parseInt($("#quiz-points").val());
            // Update answer explanation, assign null if empty
            quizDetails.answer_explaination = $("#quiz_answer_explaination").val();
            if (quizDetails.answer_explaination === "") {
                quizDetails.answer_explaination = null;
            }

            if (quizDetails.type === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.MULTIPLE_CHOICE]) {
                var selectedAnswerOption = $("#quiz-mc-ans-option").val();
                quizDetails.single_ans_flag = selectedAnswerOption === "single";
                updateQuizDetailsOptions();

            } else if (quizDetails.type === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TRUE_FALSE]) {
                quizDetails.single_ans_flag = true; // It's always single answer for True/False
                updateQuizDetailsOptions();

            } else if (quizDetails.type === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TEXT_INPUT]) {
                // Handle Text Input type
                quizDetails.single_ans_flag = null; // No single/multiple answer concept for Text Input
                quizDetails.options = null;

                if ($("#text_input_correct_answer").val().trim() != '') {
                    quizDetails.correct_ans = [$("#text_input_correct_answer").val()];
                }
            }
        }

        function validateDetails(quizDetails) {
            // Check if the question title is entered
            if (quizDetails.title.trim() === "") {
                alert("Please enter the question title.");
                return false;
            }

            // Check based on the question type
            if (quizDetails.type === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.MULTIPLE_CHOICE]) {
                // Check if at least 2 options are entered
                if (quizDetails.options.length < 2) {
                    alert("Please enter at least 2 options for multiple-choice questions.");
                    return false;
                }

                // Check for duplicate options
                var uniqueOptions = new Set(quizDetails.options);
                if (uniqueOptions.size !== quizDetails.options.length) {
                    alert("Duplicate options found. Please ensure options are unique.");
                    return false;
                }


                // Check if the correct answer is selected
                if (quizDetails.single_ans_flag) {
                    if (quizDetails.correct_ans.length !== 1) {
                        alert("Please select the correct answer for the multiple-choice question.");
                        return false;
                    }
                } else {
                    // Check if at least one correct answer is selected for multiple-select
                    if (quizDetails.correct_ans.length === 0) {
                        alert("Please select at least one correct answer for the multiple-choice question.");
                        return false;
                    }
                }
            } else if (quizDetails.type === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TRUE_FALSE]) {
                // Check if the correct answer is selected for true/false
                if (quizDetails.correct_ans.length !== 1) {
                    alert("Please select the correct answer for the True/False question.");
                    return false;
                }
            } else if (quizDetails.type === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TEXT_INPUT]) {
                // Check if the correct answer is entered for text input
                if (quizDetails.correct_ans.length !== 1) {
                    alert("Please enter the correct answer for the Text Input question.");
                    return false;
                }
            }

            return true;
        }


        $('#save-quiz-question').click(function() {
            variableAssignment(quizDetails);

            const validQuestion = validateDetails(quizDetails)
            console.log(validQuestion);
            console.log(quizDetails); // Check the captured values in the console

            if (validQuestion) {
                // Make an AJAX request to save the question
                $.ajax({
                    type: 'POST',
                    url: '/save-question',
                    contentType: 'application/json', // Set content type to JSON
                    data: JSON.stringify(quizDetails), // Convert object to JSON string
                    success: function(response) {
                        console.log(response.message);
                        // You can perform additional actions here if needed
                        history.back();
                    },
                    error: function(error) {
                        console.error('Error saving question:', error);
                        // Handle the error as needed
                    }
                });
            }

        });
    </script>
</body>

</html>
