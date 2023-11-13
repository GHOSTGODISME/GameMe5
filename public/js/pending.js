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
        this.title = "";
        this.type = "";
        this.options = null;
        this.correct_ans = [];
        this.answer_explaination = null;
        this.single_ans_flag = true;
        this.points = 0;
        this.duration = 0;
    }
}

// Quiz Details Instance
const quizDetails = new Question();

// DOM Ready Event
$(document).ready(function () {
    // Event listener for quiz type container click
    $("#quizDetailsContainer").click(function () {
        $("#quizModal").modal("show");
    });

    // Event listener for quiz type change
    $('#quiz-type').change(function () {
        handleQuizTypeChange();
    });

    // Event listener for answer option change
    $('#quiz-mc-ans-option').change(function () {
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
    $('.correct-answer-radio, .correct-answer-checkbox').each(function () {
        var checkbox = $(this);
        var input = checkbox.siblings('input[name="input_options"]');

        // Initialize tooltip
        checkbox.tooltip({
            placement: 'right', // Change the placement to 'right'
            trigger: 'hover',
            title: function () {
                return input.val() ? 'Mark this as correct answer' : 'Please enter a value first';
            },
            template: '<div class="tooltip" role="tooltip"><div class="tooltip-inner"></div></div>'
        });

        // Update input state
        updateInputState(input, checkbox);

        // Handle input value change
        input.on('input', function () {
            updateInputState(input, checkbox);
        });
    });
}


// Update tooltips on option value change
$(document).on('input', 'input[name="input_options"]', function () {
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
        removeButton.style.display = optionCount <= MIN_OPTION_COUNT ? "none" : "block"; // Hide if total options are 2 or fewer

        removeButton.onclick = function () {
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

    TF.forEach(function (tf) {
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
    textarea.oninput = function () {
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
    deleteButtons.forEach(function (button) {
        button.style.display = optionCount <= MIN_OPTION_COUNT ? "none" : "block";
    });
}

function updateQuizDetailsOptions() {
    quizDetails.options = [];
    quizDetails.correct_ans = [];

    var options = document.querySelectorAll("#optionsContainer input[name='input_options']");
    var correctAnswerInputsRadio = document.querySelectorAll("#optionsContainer input[name='correct-answer-radio']");
    var correctAnswerInputsCheckbox = document.querySelectorAll("#optionsContainer input[name='correct-answer-checkbox']");

    options.forEach(function (option, index) {
        console.log("option " + option.value + " index " + index);
        if (option.value != '') {
            quizDetails.options.push(option.value);
        }



        if (quizDetails.single_ans_flag) {
            var optionIndex = correctAnswerInputsRadio[index].getAttribute("data-option-index");
            if (correctAnswerInputsRadio[index].type === 'radio' && correctAnswerInputsRadio[index].checked) {
                // quizDetails.correct_ans = [optionIndex];
                quizDetails.correct_ans.push(option.value);
            }
        } else {
            var optionIndexCheckbox = correctAnswerInputsCheckbox[index].getAttribute("data-option-index");
            if (correctAnswerInputsCheckbox[index].type === 'checkbox' && correctAnswerInputsCheckbox[index].checked) {
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

function validateDetails() {
    // Check if the question title is entered
    if (quizDetails.title.trim() === "") {
        alert("Please enter the question title.");
        return;
    }

    // Check based on the question type
    if (quizDetails.type === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.MULTIPLE_CHOICE]) {
        // Check if at least 2 options are entered
        if (quizDetails.options.length < 2) {
            alert("Please enter at least 2 options for multiple-choice questions.");
            return;
        }

        // Check if the correct answer is selected
        if (quizDetails.single_ans_flag) {
            if (quizDetails.correct_ans.length !== 1) {
                alert("Please select the correct answer for the multiple-choice question.");
                return;
            }
        } else {
            // Check if at least one correct answer is selected for multiple-select
            if (quizDetails.correct_ans.length === 0) {
                alert("Please select at least one correct answer for the multiple-choice question.");
                return;
            }
        }
    } else if (quizDetails.type === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TRUE_FALSE]) {
        // Check if the correct answer is selected for true/false
        if (quizDetails.correct_ans.length !== 1) {
            alert("Please select the correct answer for the True/False question.");
            return;
        }
    } else if (quizDetails.type === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TEXT_INPUT]) {
        // Check if the correct answer is entered for text input
        if (quizDetails.correct_ans.length !== 1) {
            alert("Please enter the correct answer for the Text Input question.");
            return;
        }
    }

    return true;
}


$('#save-quiz-question').click(function () {

    quizDetails.title = $("#quiz_title").val();
    quizDetails.type = $("#quiz-type").val();
    quizDetails.duration = $("#quiz-duration").val();
    quizDetails.points = $("#quiz-points").val();

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

    console.log(validateDetails());
    console.log(quizDetails); // Check the captured values in the console
});