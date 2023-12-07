const QUESTION_TYPE_INT = {
    TEXT_INPUT: 0,
    MULTIPLE_CHOICE: 1,
    CHECKBOX: 2,
    SCALE: 3,    
};

const QUESTION_TYPE_STRING = {
    0: "text input",
    1: "multiple choice",
    2: "checkbox",
    3: "scale",
}

// const QUESTION_PROPERTIES = {
//     0: "default",
//     1: "required",
//     2: "disabled"
// }

class Survey{
    constructor(){
        this.id = "";
        this.title = "";
        this.description = "";
        this.status = "";
        this.questions = [];
    }
}

class SurveyQuestion {
    constructor(id, type, title, description) {
        this.id = id ?? generateUniqueID(); 
        this.type = type; // Question type (e.g., text input, multiple-choice, etc.)
        this.title = title; // Question title
        this.description = description ?? ""; // Question description

        this.options = []; // Question options (for multiple-choice, checkbox, etc.)

        this.placeholder = "";
        this.prefilledValue = "";

        this.scale_min_label = "";
        this.scale_max_label = "";
        this.scale_min_value = ""; 
        this.scale_max_value = ""; 

        this.index = 0;
    }
    
    updateOptions(options) {
        // Clear existing options
        this.options = [];

        console.log("trigger update");

        // Add new options
        for (let option of options) {
            this.options.push(option);
        }
    }

    static cloneQuestion(existingQuestion) {
        questionCount++;
        const newID = `${idPrefix}-${lectureID}-${surveyID}-${questionCount}-${existingQuestion.type}`;

        const clonedQuestion = new SurveyQuestion(newID, existingQuestion.type, existingQuestion.title, existingQuestion.description);

        clonedQuestion.options = existingQuestion.options;

        clonedQuestion.placeholder = existingQuestion.placeholder;
        clonedQuestion.prefilledValue = existingQuestion.prefilledValue;

        clonedQuestion.scale_min_label = existingQuestion.scale_min_label;
        clonedQuestion.scale_max_label = existingQuestion.scale_max_label;
        clonedQuestion.scale_min_value = existingQuestion.scale_min_value;
        clonedQuestion.scale_max_value = existingQuestion.scale_max_value;

        return clonedQuestion;
    }
}


const lectureID = 0;
const surveyID = 0;
let questionCount = 0;

const idPrefix = "s"
const scaleOptions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; // Example options

const survey = mapSurveyDataToInstance(surveyFromDB);
let ori_survey = survey;

let surveyQuestions = survey.questions;

// console.log();
console.log(survey);
console.log(surveyQuestions);

// Function to generate a unique ID for unsaved questions
function generateUniqueID() {
    const timestamp = new Date().getTime().toString(16); // Timestamp converted to hexadecimal
    const randomString = Math.random().toString(16).slice(2); // Random string
    return `temp-${timestamp}-${randomString}`;
}

// Function to map fetched survey data to Survey instance
function mapSurveyDataToInstance(fetchedSurveyData) {
    let survey = new Survey();

    // Map fetched survey data to the Survey instance
    survey.id = fetchedSurveyData.id;
    survey.title = fetchedSurveyData.title;
    survey.description = fetchedSurveyData.description;
    survey.status = fetchedSurveyData.status;

    // Map questions
    if (fetchedSurveyData.survey_questions && Array.isArray(fetchedSurveyData.survey_questions)) {
        survey.questions = fetchedSurveyData.survey_questions.map(questionData => {
            questionCount++;
            // Create SurveyQuestion instance for each question data
            let surveyQuestion = new SurveyQuestion(
                questionData.id,
                questionData.type,
                questionData.title,
                questionData.description
            );

            // Map other question properties
            surveyQuestion.options = questionData.options || [];
            surveyQuestion.placeholder = questionData.placeholder || "";
            surveyQuestion.prefilledValue = questionData.prefilledValue || "";
            surveyQuestion.scale_min_label = questionData.scale_min_label || "";
            surveyQuestion.scale_max_label = questionData.scale_max_label || "";
            surveyQuestion.scale_min_value = questionData.scale_min_value || "";
            surveyQuestion.scale_max_value = questionData.scale_max_value || "";
            // surveyQuestion.properties = questionData.properties || "default";
            surveyQuestion.index = questionData.index || 0;

            return surveyQuestion;
        });
    }

    return survey;
}



function createScaleInput(question) {
    const scaleContainer = document.createElement("div");
    scaleContainer.className = "slider-container";
    question.scale_min_value = "1";
    question.scale_max_value = "5";

    const minLabel = question.scale_min_label ? question.scale_min_label : question.scale_min_value;
    const maxLabel = question.scale_max_label ? question.scale_max_label : question.scale_max_value;

    scaleContainer.innerHTML = `
        <span class="slider-label" id="scale-min-label">${minLabel}</span>
        <div id="${question.id}-scale" class="range-slider noUi-active slider-hide"></div>
        <span class="slider-label" id="scale-max-label">${maxLabel}</span>
    `;

    createSlider(question);

    return scaleContainer;
}

function createSlider(question) {
    $(document).ready(function () {
        var slider = document.getElementById(`${question.id}-scale`);

        noUiSlider.create(slider, {
            start: 0,
            tooltips: true,
            connect: true,
            step: 1,
            range: {
                'min': parseInt(question.scale_min_value, 10),
                'max': parseInt(question.scale_max_value, 10)
            },
            format: wNumb({ decimals: 0 })
        });

        // Add an event listener to the slider
        slider.noUiSlider.on('update', function (values, handle) {
            console.log("noUiSlider " + values[handle]);
        });
    });
}

function createQuestionTypeBlock(type, question, inputContainer){
    switch (type) {
        case QUESTION_TYPE_INT.TEXT_INPUT:
            inputContainer.innerHTML = `
            <textarea id="${question.id}-userInput" class="question-input form form-control" placeholder="${question.placeholder}">${question.prefilledValue}</textarea>
            <label for="${question.id}-userInput" class="visually-hidden"></label>
            `;
            break;
        case QUESTION_TYPE_INT.MULTIPLE_CHOICE:
            question.options.push("Option 1");// initialize
            inputContainer.innerHTML = `
            <label class="input_option">
                <input type="radio" id="${question.id}-option1" name="mc-question" value="${question.options[0]}">
                ${question.options[0]}
            </label>
            `;

            break;
        case QUESTION_TYPE_INT.CHECKBOX:
            question.options.push("Option 1");// initialize
            inputContainer.innerHTML = `
            <label class="input_option">
                <input type="checkbox" id="${question.id}-option1" name="cb-question[]" value="${question.options[0]}">
                ${question.options[0]}
            </label>
            `;
            break;
        case QUESTION_TYPE_INT.SCALE:
            // inputContainer.innerHTML = `
            // <input type="range" id="${question.id}-scale" name="scale-question-${questionCount}" min="1" max="5">
            // `;
            //const scaleInputBlock = createRadioScale(question);
            const scaleInput = createScaleInput(question);
            inputContainer.append(scaleInput);
            break;
    }
}

function recreateQuestionTypeBlock(question, inputContainer){
    switch (parseInt(question.type)) {
        case QUESTION_TYPE_INT.TEXT_INPUT:
            inputContainer.innerHTML = `
            <textarea id="${question.id}-userInput" class="question-input form form-control" placeholder="${question.placeholder}">${question.prefilledValue}</textarea>
            <label for="${question.id}-userInput" class="visually-hidden"></label>
            `;
            break;
        case QUESTION_TYPE_INT.MULTIPLE_CHOICE:
            // inputContainer.innerHTML = `
            // <label class="input_option">
            //     <input type="radio" id="${question.id}-option1" name="mc-question" value="Option 1">
            //     Please enter the option(s)
            // </label>
            // `;

            question.options.forEach((option, index) => {
                inputContainer.innerHTML += `
            <label class="input_option">
                    <input type="radio" id="${question.id}-option${index + 1}" name="${question.id}" value="${option}">
                    ${option}
                </label>
                `;
            });
            break;
        case QUESTION_TYPE_INT.CHECKBOX:
            // inputContainer.innerHTML = `
            // // <label class="input_option">
            // //     <input type="checkbox" id="${question.id}-option1" name="cb-question[]" value="Option 1">
            // //     Please enter the option(s)
            // // </label>
            // // `;
            question.options.forEach((option, index) => {
                inputContainer.innerHTML += `
                <label class="input_option">
                <input type="checkbox" id="${question.id}-option${index + 1}" name="${question.id}[]" value="${option}">
                    ${option}
                </label>
                `;
            });
            break;
        case QUESTION_TYPE_INT.SCALE:
            const scaleInput = createScaleInput(question);
            inputContainer.append(scaleInput);
            break;
            default:
                console.log("none triggered");
    }
}