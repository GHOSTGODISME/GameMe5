class SurveyResponse{
    constructor(){
        this.id = "";
        this.survey_id = "";
        this.user_id = "";
        this.question_response = [];
    }
}

class SurveyQuestionResponse{
    constructor(){
        this.id = "";
        this.question_id = "";
        this.answer = [];
    }
}

const surveyResponse = new SurveyResponse();
const questionResponse = [];
surveyResponse.survey_id = survey.id;
surveyResponse.question_response = questionResponse;

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    populateSurveyForm();
    initializeSurveySubmitBtn();
});

function populateSurveyForm() {
    // Populate survey details
    document.getElementById('survey_title_preview').value = survey.title;
    document.getElementById('survey_description_preview').value = survey.description;

    updateFormPreview();
}

function updateFormPreview() {
    const formPreview = document.getElementById("questions_container");
    formPreview.innerHTML = ""; // Clear the existing content

    surveyQuestions.sort((a, b) => a.index - b.index);
    // Append the corresponding questions to the form preview
    surveyQuestions.forEach(question => {
        const questionContainer = updateQuestionPreview(question);
        formPreview.appendChild(questionContainer);
    });
}

function updateQuestionPreview(question) {

    const questionContainer = document.createElement("div");
    questionContainer.className = "question-style";
    questionContainer.setAttribute("data-survey-question", question.id);

    questionContainer.innerHTML = `
    <p class="question-title text-break" id="${question.id}-questionTitle">${question.title}</p>
    <p class="form-text text-muted text-break" id="${question.id}-questionDescription" style="display: none;">${question.description}</p>
    `;

    const inputContainer = document.createElement("div");
    inputContainer.className = "input-container";

    recreateQuestionTypeBlock(question, inputContainer);

    // initializeQuestionOnClickStudent(questionContainer);

    // Append the input container to the question container
    questionContainer.appendChild(inputContainer);

    // const questionTitleElement = questionContainer.querySelector(".question-title");
    // const questionInput = questionContainer.querySelector(".question-input");
    // applyQuestionProperty(question, questionTitleElement,questionInput);

    return questionContainer;
}

// function applyQuestionProperty(question, questionTitleElement, questionInput) {
//     console.log(question.properties.toLowerCase());
//     switch (question.properties.toLowerCase()) {
//         case QUESTION_PROPERTIES[0]: // Default
//             console.log(QUESTION_PROPERTIES[0]);
//             questionTitleElement.classList.remove("required");
//             // questionInput.required = false;
//             // questionInput.readOnly = false;

//             break;
//         case QUESTION_PROPERTIES[1]: // Required
//             console.log(QUESTION_PROPERTIES[1]);
//             questionTitleElement.classList.add("required");
//             // questionInput.required = true;
//             // questionInput.readOnly = false;
//             break;
//         case QUESTION_PROPERTIES[2]: // Disabled
//             console.log(QUESTION_PROPERTIES[2]);
//             questionTitleElement.classList.remove("required");
//             // questionInput.required = false;
//             // questionInput.readOnly = true;
//             break;
//         default:
//             break;
//     }
// }

function initializeQuestionOnClickStudent(questionBlock) {
    questionBlock.addEventListener('click', () => {
        // Retrieve the question class from the custom attribute.
        const questionData = questionBlock.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id.toString() === questionData);

        // Retrieve input values based on the question type
        switch (parseInt(question.type)) {
            case QUESTION_TYPE_INT.TEXT_INPUT:
                const textInputValue = document.getElementById(`${question.id}-userInput`).value;
                storeResponse(question.id, textInputValue);
                break;
            case QUESTION_TYPE_INT.MULTIPLE_CHOICE:
                const selectedRadio = document.querySelector(`input[name='${question.id}']:checked`);
                if (selectedRadio) {
                    const selectedRadioValue = selectedRadio.value;
                    storeResponse(question.id, selectedRadioValue);
                } else {
                    console.log("No option selected for multiple-choice question.");
                }               
                break;
            case QUESTION_TYPE_INT.CHECKBOX:
                const selectedCheckboxes = document.querySelectorAll(`input[name='${question.id}[]']:checked`);
                const checkboxValues = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
                storeResponse(question.id, checkboxValues);
                break;
            case QUESTION_TYPE_INT.SCALE:
                const sliderValue = document.getElementById(`${question.id}-scale`).noUiSlider.get();
                storeResponse(question.id, sliderValue);
                break;
            default:
                console.log("None triggered");
        }
    });
}


// Function to store the survey response
function storeResponse(questionID, answer) {
    const existingQuestionResponse = surveyResponse.question_response.find(response => response.question_id === questionID);

    if (existingQuestionResponse) {
        existingQuestionResponse.answer = answer;
    } else {
        const newQuestionResponse = new SurveyQuestionResponse();
        newQuestionResponse.question_id = questionID;
        newQuestionResponse.answer = answer;
        surveyResponse.question_response.push(newQuestionResponse);
    }

    console.log("Survey Response:", surveyResponse);
}

function storeResponseOnSubmit(){
    surveyQuestions.forEach(question => {
        switch (parseInt(question.type)) {
            case QUESTION_TYPE_INT.TEXT_INPUT:
                const textInputValue = document.getElementById(`${question.id}-userInput`).value;
                storeResponse(question.id, textInputValue);
                break;
            case QUESTION_TYPE_INT.MULTIPLE_CHOICE:
                const selectedRadio = document.querySelector(`input[name='${question.id}']:checked`);
                if (selectedRadio) {
                    const selectedRadioValue = selectedRadio.value;
                    storeResponse(question.id ?? question.id, selectedRadioValue);
                } else {
                    console.log("No option selected for multiple-choice question.");
                    storeResponse(question.id ?? question.id, null);
                }
                break;
            case QUESTION_TYPE_INT.CHECKBOX:
                const selectedCheckboxes = document.querySelectorAll(`input[name='${question.id}[]']:checked`);
                if (selectedCheckboxes) {
                    const checkboxValues = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
                    storeResponse(question.id ?? question.id, checkboxValues);
    
                }else{
                    console.log("No option selected for checkbox question.");
                    storeResponse(question.id ?? question.id, null);
                }

                break;
            case QUESTION_TYPE_INT.SCALE:
                const sliderValue = document.getElementById(`${question.id}-scale`).noUiSlider.get();
                storeResponse(question.id, sliderValue);
                break;
            default:
                console.log("None triggered");
        }
    });

    return
}

function validateSurvey() {
    let allQuestionsAnswered = true;

    surveyQuestions.forEach(question => {
        switch (parseInt(question.type)) {
            case QUESTION_TYPE_INT.TEXT_INPUT:
                const textInputValue = document.getElementById(`${question.id}-userInput`).value;
                if (!textInputValue.trim()) {
                    allQuestionsAnswered = false;
                }
                break;
            case QUESTION_TYPE_INT.MULTIPLE_CHOICE:
                const selectedRadio = document.querySelector(`input[name='${question.id}']:checked`);
                if (!selectedRadio) {
                    allQuestionsAnswered = false;
                }
                break;
            case QUESTION_TYPE_INT.CHECKBOX:
                const selectedCheckboxes = document.querySelectorAll(`input[name='${question.id}[]']:checked`);
                if (selectedCheckboxes.length === 0) {
                    allQuestionsAnswered = false;
                }
                break;
            case QUESTION_TYPE_INT.SCALE:
                // Add validation for scale input if needed
                break;
            default:
                console.log("None triggered");
        }
    });

    return allQuestionsAnswered;
}

function initializeSurveySubmitBtn(){
    $('#survey-form').on('submit', function (event) {
        event.preventDefault(); 

        const allQuestionsAnswered = validateSurvey();

        if (allQuestionsAnswered) {
            storeResponseOnSubmit();

            $.ajax({
                url: '/submit-survey-response',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(surveyResponse),
                success: function(response) {
                    console.log('Form saved successfully:', response);
                    history.back();
                },
                error: function(xhr, status, error) {
                    console.error('Error saving form:', error);
                    console.log('Response Text:', xhr.responseText);
                }
                
            });


            console.log(surveyResponse);
        }else{
            alert('Please answer all questions before submitting the survey.');
            scrollToUnansweredQuestion();
        }
    });
}

// Function to scroll to the section of the first unanswered question
function scrollToUnansweredQuestion() {
    surveyQuestions.forEach(question => {
        switch (parseInt(question.type)) {
            case QUESTION_TYPE_INT.TEXT_INPUT:
                const textInputValue = document.getElementById(`${question.id}-userInput`).value;
                if (!textInputValue.trim()) {
                    const questionContainer = document.querySelector(`[data-survey-question='${question.id}']`);
                    if (questionContainer) {
                        questionContainer.scrollIntoView({ behavior: 'smooth' });
                        return;
                    }
                }
                break;
            case QUESTION_TYPE_INT.MULTIPLE_CHOICE:
                const selectedRadio = document.querySelector(`input[name='${question.id}']:checked`);
                if (!selectedRadio) {
                    const questionContainer = document.querySelector(`[data-survey-question='${question.id}']`);
                    if (questionContainer) {
                        questionContainer.scrollIntoView({ behavior: 'smooth' });
                        return;
                    }
                }
                break;
            case QUESTION_TYPE_INT.CHECKBOX:
                const selectedCheckboxes = document.querySelectorAll(`input[name='${question.id}[]']:checked`);
                if (selectedCheckboxes.length === 0) {
                    const questionContainer = document.querySelector(`[data-survey-question='${question.id}']`);
                    if (questionContainer) {
                        questionContainer.scrollIntoView({ behavior: 'smooth' });
                        return;
                    }
                }
                break;
            case QUESTION_TYPE_INT.SCALE:
                // there is default value for scale input, so no need to check on it
                break;
            default:
                console.log("None triggered");
        }
    });
}