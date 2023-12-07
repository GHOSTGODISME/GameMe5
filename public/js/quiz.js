// Constants
const QUESTION_TYPE_INT = {
    MULTIPLE_CHOICE: 0,
    TRUE_FALSE: 1,
    TEXT_INPUT: 2,
};

const QUESTION_TYPE_STRING = {
    0: "Multiple Choice",
    1: "True/False",
    2: "Text Input",
};

const MIN_OPTION_COUNT = 2;
const DEFAULT_OPTION_COUNT = 4;
const MAX_OPTION_COUNT = 6;

// Global Variables
let optionCount = 0; // Initial option count

// Quiz Details Class
class Quiz {
    constructor() {
        this.id = "";
        this.title = "Quiz Title";
        this.description = "";
        this.visibility = "public";
        this.quiz_questions = [];
    }
}

class Question {
    constructor() {
        this.id = ""
        this.uniqueID = generateUniqueID();
        this.title = "";
        this.type = "";
        this.options = [];
        this.correct_ans = [];
        this.answer_explaination = [];
        this.single_ans_flag = true;
        this.points = 0;
        this.duration = 0;
        this.quiz_id = "";

        this.index = 0;
    }
}

// Function to map fetched quiz data to Quiz instance
function mapQuizDataToInstance(fetchedQuizData) {
    let quizInstance = new Quiz();

    // Map fetched quiz data to the Quiz instance
    quizInstance.id = fetchedQuizData.id || "";
    quizInstance.title = fetchedQuizData.title || "Quiz Title";
    quizInstance.description = fetchedQuizData.description || "";
    quizInstance.visibility = fetchedQuizData.visibility || "public";

    // Map quiz questions
    if (fetchedQuizData.quiz_questions && Array.isArray(fetchedQuizData.quiz_questions)) {
        console.log("quiz_questions");
        quizInstance.quiz_questions = fetchedQuizData.quiz_questions.map(questionData => {
            // Create Question instance for each question data
            let question = new Question();

            question.id = questionData.id || "";
            question.uniqueID = questionData.uniqueID ?? generateUniqueID();
            question.title = questionData.title || "";
            question.type = questionData.type || 0;
            question.options = questionData.options || [];
            question.correct_ans = questionData.correct_ans || [];
            question.answer_explaination = questionData.answer_explaination || [];
            question.single_ans_flag = questionData.single_ans_flag !== undefined ? questionData.single_ans_flag : true;
            question.points = questionData.points !== undefined ? questionData.points : 0;
            question.duration = questionData.duration !== undefined ? questionData.duration : 0;
            question.quiz_id = questionData.quiz_id || "";

            question.index = questionData.index !== undefined ? parseInt(questionData.index) : 0;
            console.log("question");
            return question;
        });
    }

    return quizInstance;
}

function deepCopy(obj) {
    if (typeof obj !== 'object' || obj === null) {
        return obj; // Return the value if obj is not an object
    }

    let copiedObj = Array.isArray(obj) ? [] : {};

    for (let key in obj) {
        if (Object.prototype.hasOwnProperty.call(obj, key)) {
            copiedObj[key] = deepCopy(obj[key]);
        }
    }

    return copiedObj;
}


const quiz = mapQuizDataToInstance(quizFromDB);
let ori_quiz = deepCopy(quiz);

let savedQuiz = mapQuizDataToInstance(quizFromDB);

console.log("quizzz");
console.log(quiz);

// let quiz_questions = quizRecord.quiz_questions;
// console.log("quiz_questions");
// console.log(quiz_questions);

// Quiz Details Instance
const quizDetails = new Question();
// let allQuiz = [];
let allQuiz = quiz.quiz_questions;
// const quiz = new Quiz();
// let quiz;
// if(quizRecord.id != null){
//     quiz = quizRecord;
// }else{
//     quiz = new Quiz();
// }
// quiz.quiz_questions = allQuiz;

// console.log("quiz");
// console.log(quiz);

// console.log("test " +quizFromDb );
// console.log(quizFromDb );

// const quizFromDb = @JSON($quiz);
// quizDetails.quiz_id = quizFromDb.id;
// // console.log(@JSON($quiz));
// console.log(quizFromDb);
// console.log(quizDetails.quiz_id);

// DOM Ready Event
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    updateQuizDetailsShow(quiz);
    initializeEventListeners();
    initializeOptions();

    populateQuiz(allQuiz, mode);
});

function generateUniqueID() {
    const timestamp = new Date().getTime().toString(16); // Timestamp converted to hexadecimal
    const randomString = Math.random().toString(16).slice(2); // Random string
    return `temp-${timestamp}-${randomString}`;
}

function initializeEventListeners() {
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


    // Function to reset the modal content when it's closed
    $('#questionModal').on('hidden.bs.modal', function () {
        // Clear input fields and reset modal state here
        $('#quiz-type').val('Multiple Choice').change(); // Reset dropdown to default value
        $('#optionsContainer').empty(); // Clear options
        $('#quiz_title').val(''); // Clear quiz title input
        $("#quiz-duration").val('10').change();
        $("#quiz-points").val('10').change();
        $('#quiz_answer_explaination').val(''); // Clear answer explaination input

        // Initialize default options
        initializeOptions();
    });

    $('#saveQuizDetailsBtn').click(function () {
        saveQuizDetails(quiz);

        // Add your logic to save quiz details, including the new content (visibility) here
        const validDetails = validateQuizDetails(quiz);

        if (validDetails) {
            $("#quizModal").modal("hide");
            updateQuizDetailsShow(quiz);
        }

    });



    $('#saveQuestionBtn').click(function () {
        const uniqueID = $('#quiz_unique_id').val();
        console.log(uniqueID);
        const quiz = variableAssignment(uniqueID);
        console.log(quiz);
        validQuestion = validateDetails(quiz);

        console.log(quiz);
        // Close the modal after saving
        if (validQuestion) {
            const existingIndex = allQuiz.findIndex(q => q.uniqueID === uniqueID);

            if (existingIndex !== -1) {
                // Update existing record in allQuiz array
                allQuiz[existingIndex] = quiz;
                console.log("Record updated:", allQuiz[existingIndex]);
            } else {
                console.log("Record not found. Adding as a new record.");
                // Add new record to allQuiz array
                console.log("quiz.duration " + quiz.duration);
                console.log("quiz.points " + quiz.points);
                allQuiz.push(quiz);
                console.log("Record added:", quiz);
            }

            console.log(allQuiz);
            // Update UI or perform necessary actions
            populateQuiz(allQuiz, mode);
            $('#questionModal').modal('hide');
        }

        //reset value
        $('#quiz_unique_id').val("");
    });

    initializeEditDeleteButtonListeners();
    initializePointsDurationDDLListeners();

}
// Functions
function initializeOptions() {
    optionCount = 0; // Initial option count
    for (var i = 0; i < DEFAULT_OPTION_COUNT; i++) {
        addOption();
    }
    updateAnswerOption();
    initializeTooltips();
}

function updateQuizDetailsShow(quiz) {
    $(".quiz-title-display").text(quiz.title);
    $(".quiz-visibility-display").text(quiz.visibility);

    $(".quiz-visibility-display").css("text-transform", "capitalize");

    $(".quiz-description-display").text(quiz.description ?? "(None)");
    if (!quiz.description.trim()) {
        $(".quiz-description-display").text("(None)");
    } else {
        $(".quiz-description-display").text(quiz.description);
    }
}

// Function to update input element state based on the presence of a value
function updateInputState(input, checkbox) {
    var value = input.val();
    checkbox.prop('disabled', value === '');
}

function initializeTooltips() {
    console.log("triggered");
    $('.correct-answer-radio, .correct-answer-checkbox').each(function () {
        var checkbox = $(this);
        var input = checkbox.siblings('input[name="input_options"]');

        // Initialize tooltip
        checkbox.tooltip({
            placement: 'right', // Change the placement to 'right'
            trigger: 'hover',
            title: function () {
                return input.val() ? 'Mark this as correct answer' :
                    'Please enter a value first';
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

function handleQuizTypeChange() {
    var selectedQuizType = $('#quiz-type').val();
    var answerOptionContainer = $("#quiz-mc-ans-option-container");
    var answerOptionSelect = $("#quiz-mc-ans-option");
    var optionContainer = document.getElementById("optionsContainer");

    optionContainer.innerHTML = "";

    if (selectedQuizType === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.MULTIPLE_CHOICE]) {
        document.getElementById("mcq_addbtn_container").style.display = "block";
        answerOptionContainer.show();
        answerOptionSelect.prop('disabled', false); // Disable the dropdown
        answerOptionSelect.val("single"); // Set default to Single Select
        updateAnswerOption();

        optionCount = 0;
        for (var i = 0; i < DEFAULT_OPTION_COUNT; i++) {
            addOption();
        }
        initializeTooltips();

    } else if (selectedQuizType === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TRUE_FALSE]) {
        document.getElementById("mcq_addbtn_container").style.display = "none";
        answerOptionContainer.show();
        answerOptionSelect.val("single"); // Set default to Single Select
        answerOptionSelect.prop('disabled', true); // Disable the dropdown
        updateAnswerOption();
        trueFalse();
    } else if (selectedQuizType === QUESTION_TYPE_STRING[QUESTION_TYPE_INT.TEXT_INPUT]) {
        document.getElementById("mcq_addbtn_container").style.display = "none";
        answerOptionContainer.hide();
        textInput();
    } else {
        answerOptionContainer.hide();
    }


}


function addOption() {
    if (optionCount < MAX_OPTION_COUNT) {
        var optionContainer = document.getElementById("optionsContainer");

        var optionDiv = document.createElement("div");
        optionDiv.className = "col-10 col-lg-5 col-xl-5 format-option";

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
        optionDiv.className = "col-10 col-lg-5 col-xl-5 format-option";

        var input = document.createElement("input");
        input.type = "text";
        input.className = "input-fields text-center fs-5 border-0";
        input.name = "input_options"
        input.value = tf;
        input.disabled = true;

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

function updateQuizDetailsOptions(quizDetails) {
    console.log(quizDetails);
    quizDetails.options = [];
    quizDetails.correct_ans = [];

    var options = document.querySelectorAll("#optionsContainer input[name='input_options']");
    var correctAnswerInputsRadio = document.querySelectorAll(
        "#optionsContainer input[name='correct-answer-radio']");
    var correctAnswerInputsCheckbox = document.querySelectorAll(
        "#optionsContainer input[name='correct-answer-checkbox']");

    options.forEach(function (option, index) {
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
    const answerOption = selectedAnswerOption === "single";

    //reset checked fields
    // $("input[name='correct-answer-radio']").prop('checked', false);
    // $("input[name='correct-answer-checkbox']").prop('checked', false);


    if (answerOption === true) {
        $(".correct-answer-checkbox").hide();
        $(".correct-answer-radio").show();
    } else if (answerOption === false) {
        $(".correct-answer-radio").hide();
        $(".correct-answer-checkbox").show();
    }
}

function variableAssignment(uniqueID) {
    let quiz = allQuiz.find(q => q.uniqueID === uniqueID);
    if (!quiz) {
        quiz = new Question();
        quiz.index = allQuiz.length + 1;
    }

    quiz.title = $("#quiz_title").val();
    quiz.type = mapStringToInteger($("#quiz-type").val());
    quiz.duration = parseInt($("#quiz-duration").val());
    quiz.points = parseInt($("#quiz-points").val());

    console.log("quiz.durationquiz.duration " + quiz.duration);
    console.log("quiz.pointsquiz.points " + quiz.points);
    // Update answer explaination, assign null if empty
    quiz.answer_explaination = $("#quiz_answer_explaination").val();
    if (quiz.answer_explaination === "") {
        quiz.answer_explaination = null;
    }

    if (quiz.type === QUESTION_TYPE_INT.MULTIPLE_CHOICE) {
        var selectedAnswerOption = $("#quiz-mc-ans-option").val();
        quiz.single_ans_flag = selectedAnswerOption === "single";
        updateQuizDetailsOptions(quiz);

    } else if (quiz.type === QUESTION_TYPE_INT.TRUE_FALSE) {
        quiz.single_ans_flag = true; // It's always single answer for True/False
        updateQuizDetailsOptions(quiz);

    } else if (quiz.type === QUESTION_TYPE_INT.TEXT_INPUT) {
        // Handle Text Input type
        quiz.single_ans_flag = null; // No single/multiple answer concept for Text Input
        quiz.options = null;

        if ($("#text_input_correct_answer").val().trim() != '') {
            quiz.correct_ans = [$("#text_input_correct_answer").val()];
        }
    }

    return quiz;
}

function mapStringToInteger(stringType) {
    const typeMappings = {
        "Multiple Choice": QUESTION_TYPE_INT.MULTIPLE_CHOICE,
        "True/False": QUESTION_TYPE_INT.TRUE_FALSE,
        "Text Input": QUESTION_TYPE_INT.TEXT_INPUT,
    };
    return typeMappings[stringType] || QUESTION_TYPE_INT.MULTIPLE_CHOICE; // Default to Multiple Choice
}

function validateDetails(quizDetails) {
    // Check if the question title is entered
    if (quizDetails.title.trim() === "") {
        alert("Please enter the question title.");
        return false;
    }

    // Check based on the question type
    if (quizDetails.type === QUESTION_TYPE_INT.MULTIPLE_CHOICE) {
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
            // Check if all selected correct answers are within the options
            for (const ans of quizDetails.correct_ans) {
                if (!quizDetails.options.includes(ans)) {
                    alert("One or more selected correct answers are not among the available options.");
                    return false;
                }
            }
        }
    } else if (quizDetails.type === QUESTION_TYPE_INT.TRUE_FALSE) {
        // Check if the correct answer is selected for true/false
        if (quizDetails.correct_ans.length !== 1) {
            alert("Please select the correct answer for the True/False question.");
            return false;
        }

        if (!quizDetails.options.includes(quizDetails.correct_ans[0])) {
            alert("The selected correct answer is not among the available options.");
            return false;
        }
    } else if (quizDetails.type === QUESTION_TYPE_INT.TEXT_INPUT) {
        // Check if the correct answer is entered for text input
        if (quizDetails.correct_ans.length !== 1) {
            alert("Please enter the correct answer for the Text Input question.");
            return false;
        }
    }

    return true;
}


function initializeEditDeleteButtonListeners() {
    document.querySelectorAll('.edit-btn').forEach(button => {
        console.log("initialized edit");
        button.addEventListener('click', function () {
            const uniqueID = this.getAttribute('data-question-id');
            loadQuestionDataIntoModal(uniqueID);
        });
    });

    document.querySelectorAll('.remove-btn').forEach(button => {
        console.log("initialized remove");
        button.addEventListener('click', function () {
            const uniqueID = this.getAttribute('data-question-id');
            deleteQuestion(uniqueID);
        });
    });

    document.querySelectorAll('.duplicate-btn').forEach(button => {
        console.log("initialized duplicate");
        button.addEventListener('click', function () {
            const uniqueID = this.getAttribute('data-question-id');
            duplicateQuestion(uniqueID);
        });
    });


}

function initializePointsDurationDDLListeners() {
    document.querySelectorAll('.points_ddl').forEach(button => {
        console.log("initialized points");
        button.addEventListener('click', function () {
            const uniqueID = this.getAttribute('data-question-id');
            const questionToUpdate = allQuiz.find(q => q.uniqueID === uniqueID);
            const selectedPoints = $(this).val();
            console.log(selectedPoints);

            if (questionToUpdate) {
                questionToUpdate.points = parseInt(selectedPoints);
                console.log(`Question ${uniqueID} duration updated to ${selectedPoints}`);

                const index = allQuiz.findIndex(q => q.uniqueID === questionToUpdate.uniqueID);
                if (index !== -1) {
                    allQuiz[index] = questionToUpdate;
                }
            }
        });
    });

    document.querySelectorAll('.duration_ddl').forEach(button => {
        console.log("initialized dl");
        button.addEventListener('click', function () {
            const uniqueID = this.getAttribute('data-question-id');
            const questionToUpdate = allQuiz.find(q => q.uniqueID === uniqueID);
            const selectedDuration = $(this).val();
            console.log(selectedDuration);

            if (questionToUpdate) {
                questionToUpdate.duration = parseInt(selectedDuration);
                console.log(`Question ${uniqueID} duration updated to ${selectedDuration}`);

                const index = allQuiz.findIndex(q => q.uniqueID === questionToUpdate.uniqueID);
                if (index !== -1) {
                    allQuiz[index] = questionToUpdate;
                }
            }
        });
    });
}

function loadQuestionDataIntoModal(uniqueID) {
    // Find the question in the allQuiz array
    const question = allQuiz.find(q => q.uniqueID === uniqueID);
    console.log(question);
    // <input type="hidden" id="quiz_unique_id" name="quiz_unique_id" value="">

    $('#quiz_unique_id').val(uniqueID);
    if (question) {
        // Set the values of the modal fields with the data of the question
        $('#quiz_title').val(question.title);
        $('#quiz-type').val(QUESTION_TYPE_STRING[question.type]).change();
        $('#quiz-duration').val(question.duration.toString()).change();
        $('#quiz-points').val(question.points.toString()).change();
        $('#quiz_answer_explaination').val(question.answer_explaination || '');

        // Handle loading options based on the type of question
        if (question.type === QUESTION_TYPE_INT.MULTIPLE_CHOICE) {
            $('#optionsContainer').empty();
            optionCount = 0;
            question.options.forEach(option => {
                console.log(option);
                addOption();
                let optionInput = $('#optionsContainer .format-option:last-child input[name="input_options"]');
                optionInput.val(option);

                if (question.correct_ans.includes(option)) {
                    let correctInput = question.single_ans_flag ? 'input[type="radio"]' : 'input[type="checkbox"]';
                    optionInput.siblings(correctInput).prop('checked', true);
                }
            });

            $("#quiz-mc-ans-option").val(question.single_ans_flag ? "single" : "multiple").change();
        } else if (question.type === QUESTION_TYPE_INT.TRUE_FALSE) {
            $('#optionsContainer').empty();
            trueFalse();
            $("input[name='correct-answer-radio'][value='" + question.correct_ans[0] + "']").prop('checked', true);
        } else if (question.type === QUESTION_TYPE_INT.TEXT_INPUT) {
            $('#text_input_correct_answer').val(question.correct_ans[0] || '');
            updateStudentsView();
        }

        // Open the modal
        $('#questionModal').modal('show');
    }
}

function populateQuiz(questions, mode) {
    const quizQuestionsContainer = document.getElementById("all_quiz_questions_container");
    // Clear existing content
    quizQuestionsContainer.innerHTML = '';


    questions.sort((a, b) => a.index - b.index);
    // Iterate over each question and append its HTML
    questions.forEach((question, index) => {
        const questionHTML = generateQuestionHTML(question, index, mode);
        quizQuestionsContainer.insertAdjacentHTML('beforeend', questionHTML);
        question.index = index;

    });

    // Reinitialize edit button listeners after populating the quiz
    initializeEditDeleteButtonListeners();
    initializePointsDurationDDLListeners();

    document.getElementById("num_of_question").textContent = questions.length;

    if (questions.length === 0 || questions === null) {
        quizQuestionsContainer.innerHTML = `
        <p class="text-center p-5 text-black-50">No Question Available</p>
        `;
    }
}

function generateQuestionHTML(question, index, mode) {
    // Construct HTML for the question
    let questionHTML = `
<div class="question-container" data-question-id="${question.uniqueID}">
    <div class="question-container-header">
        <div class="question-counter">
            <span>Question ${index + 1}</span>
            <span> - ${QUESTION_TYPE_STRING[question.type]} Question</span>
        </div>`

    if (mode !== 'view' && mode !== "viewWithRestriction") {
        questionHTML += `        <div class="button-container">
            <button class="btn btn-primary edit-btn" data-question-id="${question.uniqueID}">Edit</button>
            <button class="btn btn-info duplicate-btn" data-question-id="${question.uniqueID}">Duplicate</button>
            <button class="btn btn-danger remove-btn" data-question-id="${question.uniqueID}">Remove</button>
        </div>`;
    }

    questionHTML +=
        `  </div>
            <hr>
            <div class="question-title-container">
                <p>${question.title}</p>
            </div>
        `;

    if (question.options && question.options.length > 0) {
        questionHTML += `
        <div class="answer-choice-container container-space">
            <div class="horizontal-line-with-text">
                <span> Answer choice </span>
            </div>
            <div id="answer-choice-details">
    `;

        question.options.forEach((option, index) => {
            let inputElement = '';
            let isCorrect = question.correct_ans && question.correct_ans.includes(option);

            if (question.single_ans_flag) {
                inputElement = `<input type="radio" name="answer-option-${question.id}" ${isCorrect ? 'checked' : ''} >`;
            } else {
                inputElement = `<input type="checkbox" ${isCorrect ? 'checked' : ''} ">`;
            }
            // Display correct answers in green color, incorrect in red color
            // const colorStyle = isCorrect ? 'color: green;' : 'color: red;';
            // htmlContent += `<label style="${colorStyle} pointer-events: none;">${inputElement} ${option}</label><br>`;
            questionHTML += `<label style="pointer-events: none;">${inputElement} ${option}</label><br>`;
        });


        questionHTML += `
            </div>
        </div>
    `;
    } else {

        // Checking and appending correct answer(s) if available
        if (question.correct_ans && question.correct_ans.length > 0) {
            questionHTML += `
            <div class="correct-answer-container container-space">
                <div class="horizontal-line-with-text">
                    <span> Answer </span>
                </div>
                <div id="correct-answer">
        `;

            question.correct_ans.forEach((answer, index) => {
                questionHTML += `<p>${answer}</p>`;
            });

            questionHTML += `
                </div>
            </div>
        `;
        }
    }
    // Checking and appending answer explaination if available
    if (question.answer_explaination) {
        questionHTML += `
    <div class="answer-explaination-container container-space">
        <div class="horizontal-line-with-text">
            <span> Answer explaination </span>
        </div>
        <p>${question.answer_explaination}</p>
    </div>
`;
    }

    // Footer Section - Duration and Points selection
    questionHTML += `
    <div class="question-container-footer">
        <div>
            <label for="quiz-duration-show">Duration</label>
        <select id="quiz-duration-show" name="Quiz duration" class="form-select duration_ddl " style="width:150px;" title="Quiz duration" data-question-id="${question.uniqueID}" ${mode === "view" || "viewWithRestriction" ? "disabled" : ""}>
            <option value="10" ${question.duration === 10 ? 'selected' : ''}>10 seconds</option>
            <option value="15" ${question.duration === 15 ? 'selected' : ''}>15 seconds</option>
            <option value="30" ${question.duration === 30 ? 'selected' : ''}>30 seconds</option>
        </select>
        </div>

        <div>
            <label for="quiz-points-show">Points</label>
        <select id="quiz-points-show"  name="Quiz points" class="form-select points_ddl"  style="width:150px;" title="Quiz points" data-question-id="${question.uniqueID}" ${mode === "view" || "viewWithRestriction" ? "disabled" : ""}>
            <option value="10" ${question.points === 10 ? 'selected' : ''}>10</option>
            <option value="15" ${question.points === 15 ? 'selected' : ''}>15</option>
            <option value="30" ${question.points === 30 ? 'selected' : ''}>30</option>
        </select>
        </div>
    </div>
</div>
</div>`;

    questionHTML += '</div>'; // Close the question-container div


    console.log("question.duration " + question.duration);
    console.log("question.points " + question.points);
    console.log("1 " + `${question.duration === 10 ? 'selected' : ''}`);
    console.log("2 " + `${question.duration === 15 ? 'selected' : ''}`);
    console.log("3 " + `${question.duration === 30 ? 'selected' : ''}`);
    return questionHTML;
}


// Function to delete a question from allQuiz array based on uniqueID
function deleteQuestion(uniqueID) {
    const indexToDelete = allQuiz.findIndex(q => q.uniqueID === uniqueID);
    if (indexToDelete !== -1) {
        const confirmation = window.confirm('Are you sure you want to delete this question?');
        if (confirmation) {
            allQuiz.splice(indexToDelete, 1);

            // Update the indices after deletion
            allQuiz.forEach((question, index) => {
                question.index = index + 1; // Update indices based on the new positions
            });
            populateQuiz(allQuiz, mode); // Assuming populateQuiz function updates the UI
        }
    } else {
        console.log('Question not found.');
    }
}

function duplicateQuestion(uniqueID) {
    const indexToDuplicate = allQuiz.findIndex(q => q.uniqueID === uniqueID);
    if (indexToDuplicate !== -1) {
        const originalQuestion = allQuiz[indexToDuplicate];
        const duplicatedQuestion = JSON.parse(JSON.stringify(originalQuestion));

        // Optionally, modify properties if needed (e.g., change uniqueID, reset some values)
        duplicatedQuestion.uniqueID = generateUniqueID(); // Change uniqueID for the duplicated question
        duplicatedQuestion.id = ""; // Clear ID or set to another value if required

        // Insert the duplicated question right after the original one
        allQuiz.splice(indexToDuplicate + 1, 0, duplicatedQuestion);

        console.log(originalQuestion);
        console.log(duplicatedQuestion);
        // Update the UI or perform any other necessary actions
        populateQuiz(allQuiz, mode); // Assuming populateQuiz function updates the UI
        console.log(allQuiz);
        console.log(quiz);
    } else {
        console.log('Question not found.');
    }
}

const questionsContainer = document.getElementById("all_quiz_questions_container");
const sortable = new Sortable(questionsContainer, {
    //handle: '.handle',
    animation: 150,
    onEnd: function (evt) {
        const questionElement = questionsContainer.querySelectorAll('.question-container');
        const updatedAllQuiz = [];

        questionElement.forEach((question, newIndex) => {
            const uniqueID = question.getAttribute('data-question-id');

            const foundQuestion = allQuiz.find(q => q.uniqueID === uniqueID);
            if (foundQuestion) {
                foundQuestion.index = newIndex;
                updatedAllQuiz.push(foundQuestion);
            }

        });
        allQuiz = updatedAllQuiz;
        console.log(allQuiz);
        populateQuiz(allQuiz, mode);
    }

});


//==================================================================================
//==========save quiz================================
//==================================================================================

function saveQuizDetails(quiz) {
    var quizTitle = $("#quiz_title_modal").val().trim();
    var quizDescription = $("#quiz_description_modal").val().trim();
    var visibility = $("#visibility_modal").val();
    quiz.title = quizTitle;
    quiz.description = quizDescription.trim() ?? null;
    quiz.visibility = visibility;
}

function validateQuizDetails(quiz) {
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

function saveQuiz() {
    saveQuizDetails(quiz);

    const validQuiz = validateQuizDetails(quiz);

    console.log(quiz);
    // Make an AJAX POST request to the backend to save the form data
    if (validQuiz) {
        savedQuiz = mapQuizDataToInstance(quiz);
        console.log(quiz);
        console.log(quiz.quiz_questions);
        console.log(savedQuiz);
        console.log(savedQuiz.quiz_questions);

        $.ajax({
            url: '/save-quiz',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(quiz),
            success: function (response) {
                ori_quiz = quiz;
                console.log('Quiz saved successfully:', response);
                window.location.href = "/quiz-index-own-quiz";
                // history.back();
            },
            error: function (xhr, status, error) {
                console.error('Error saving form:', error);
                console.log('Response Text:', xhr.responseText);
            }
        });
    }
}

// // Event listener for the "Save Form" button click
// document.getElementById('save-quiz-btn').addEventListener('click', function() {
//     saveQuiz(); 
// });


function compareObject(obj1, obj2) {
    // Check if both inputs are objects
    if (typeof obj1 !== 'object' || typeof obj2 !== 'object') {
        console.log("false 1");
        return false;
    }

    // Get the keys of the objects
    const keys1 = Object.keys(obj1);
    const keys2 = Object.keys(obj2);

    if (keys1.length !== keys2.length) {
        console.log("false 2");
        return false;
    }

    for (const key of keys1) {
        const val1 = obj1[key];
        const val2 = obj2[key];

        if (typeof val1 === 'object' && typeof val2 === 'object') {
            const objectsEqual = compareObject(val1, val2);
            if (!objectsEqual) {
                console.log(val1);
                console.log(val2);
                console.log("false 3");
                return false;
            }
        } else if (val1 !== val2) {
            console.log(val1);
            console.log(val2);
            console.log("false 4");
            return false;
        }
    }
    return true;
}
// Event listener for beforeunload
window.addEventListener('beforeunload', function (e) {
    if (!compareObject(ori_quiz, quiz)) {
        console.log(ori_quiz);
        console.log(quiz);
        e.preventDefault();
        e.returnValue = '';
        return 'Are you sure you want to leave? Your changes may not be saved.';
    }
});