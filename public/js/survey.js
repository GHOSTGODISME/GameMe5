const QUESTION_TYPE_INT = {
    TEXT_INPUT: 0,
    MULTIPLE_CHOICE: 1,
    CHECKBOX: 2,
    DROPDOWN: 3,
    SCALE: 4
};

const QUESTION_TYPE_STRING = {
    0: "text input",
    1: "multiple choice",
    2: "checkbox",
    3: "dropdown",
    4: "scale"
}

const QUESTION_PROPERTIES = {
    0: "default",
    1: "required",
    2: "disabled"
}

class SurveyQuestion {
    constructor(id, type, title, description) {
        this.index = 0; // Index in the form structure

        this.id = id; // Unique question ID
        this.type = type; // Question type (e.g., text input, multiple-choice, etc.)
        this.title = title; // Question title
        this.description = description; // Question description

        this.options = []; // Question options (for multiple-choice, checkbox, etc.)

        this.placeholder = "";
        this.prefilledValue = "";

        this.scale_min_label = "";
        this.scale_max_label = "";
        this.scale_min_value = "1"; // default min
        this.scale_max_value = "5"; //default max

        this.properties = "default";
    }

    getFirstOption() {
        console.log(this.options[0]);
        return this.options[0];
    }

    getLastOption() {
        console.log(this.options[this.options.length]);
        return this.options[this.options.length];
    }

    // Add a method to update the options for the question
    addOption(option) {
        this.options.push(option);
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

    deleteOption(option) {
        const index = this.options.indexOf(option);
        if (index > -1)
            this.options.splice(index, 1);
    }

    deleteOptionWithIndex(index) {
        this.options.splice(index, 1);
    }

    // Create a static factory method to clone an existing question
    // static cloneQuestion(newID) {
    //     questionCount++;
    //     //const questionID = `${idPrefix}-${lectureID}-${surveyID}-${questionCount}-${type}`;

    //     const clonedQuestion = new SurveyQuestion(newID, this.type, this.title, this.description);

    //     // Copy other attributes as needed
    //     clonedQuestion.options = this.options.slice(); // Copy the options array

    //     // Copy other attributes
    //     clonedQuestion.placeholder = this.placeholder;
    //     clonedQuestion.prefilledValue = this.prefilledValue;

    //     clonedQuestion.scale_min_label = this.scale_min_label;
    //     clonedQuestion.scale_max_label = this.scale_max_label;
    //     clonedQuestion.scale_min_value = this.scale_min_value;
    //     clonedQuestion.scale_max_value = this.scale_max_value;

    //     return clonedQuestion;
    // }

    static cloneQuestion(existingQuestion) {
        questionCount++;
        const newID = `${idPrefix}-${lectureID}-${surveyID}-${questionCount}-${existingQuestion.type}`;

        const clonedQuestion = new SurveyQuestion(newID, existingQuestion.type, existingQuestion.title, existingQuestion.description);

        // Copy other attributes as needed
        // clonedQuestion.options = existingQuestion.options.slice(); // Copy the options array
        clonedQuestion.options = existingQuestion.options; // Copy the options array

        // Copy other attributes
        clonedQuestion.placeholder = existingQuestion.placeholder;
        clonedQuestion.prefilledValue = existingQuestion.prefilledValue;

        clonedQuestion.scale_min_label = existingQuestion.scale_min_label;
        clonedQuestion.scale_max_label = existingQuestion.scale_max_label;
        clonedQuestion.scale_min_value = existingQuestion.scale_min_value;
        clonedQuestion.scale_max_value = existingQuestion.scale_max_value;

        clonedQuestion.properties = existingQuestion.properties;
        return clonedQuestion;
    }
}

const surveyQuestionContainer = document.getElementById("questions_container");
// const surveyQuestionOptionContainer = document.getElementById("options_container");

const formStructureContainer = document.getElementById("form_structure");
const lectureID = 0;
const surveyID = 0;

let questionCount = 0;

let title = document.getElementById("survey_title").value;
let description = document.getElementById('survey_description').value;

const idPrefix = "s"
let surveyQuestions = []

const scaleOptions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; // Example options


// ${lectureID}-${surveyID}-${questionCount}-${QUESTION_TYPE_INT[0]}

const sortable = new Sortable(formStructureContainer, {
    //handle: '.handle',

    animation: 150,
    onEnd: function (evt) {
        const structureElements = formStructureContainer.querySelectorAll('.structure');
        const newSurveyQuestions = [];

        structureElements.forEach((structure, newIndex) => {
            const questionID = structure.getAttribute('data-question-id');
            const question = surveyQuestions.find(q => q.id === questionID);

            if (question) {
                question.index = newIndex;
                newSurveyQuestions.push(question);
            }
        });

        // Update the surveyQuestions array with the reordered questions
        surveyQuestions = newSurveyQuestions;

        console.log("updated " + surveyQuestions);
        console.log(surveyQuestions);
        // Update the form preview when an item is dragged and dropped
        updateFormPreview();
    }
});

function addQuestion(type) {
    questionCount++;
    const index = questionCount;

    const questionID = `${idPrefix}-${lectureID}-${surveyID}-${questionCount}-${type}`;
    const questionTitle = `${questionCount} Please enter the question`;
    const description = "";

    const question = new SurveyQuestion(questionID, type, questionTitle, description);

    const questionContainer = document.createElement("div");
    questionContainer.className = "question-style";
    // questionContainer.setAttribute("data-survey-question", JSON.stringify(question));
    questionContainer.setAttribute("data-survey-question", question.id);

    questionContainer.innerHTML = `
    <p class="question-title text-break" id="${question.id}-questionTitle">${question.title}</p>
    <p class="form-text text-muted text-break" id="${question.id}-questionDescription" style="display: none;">${question.description}</p>
    `;
    // Create a div with the class "input-container" for grouping input elements
    const inputContainer = document.createElement("div");
    inputContainer.className = "input-container";

    // input type="text" id="${question.id}-userInput" class="question-input" placeholder="${question.placeholder}" value="${question.prefilledValue}" />
    switch (type) {
        case QUESTION_TYPE_INT.TEXT_INPUT:
            inputContainer.innerHTML = `
            <textarea id="${question.id}-userInput" class="question-input " placeholder="${question.placeholder}">${question.prefilledValue}</textarea>
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

    //question.index = surveyQuestions.length;
    initializeQuestionOnClick(questionContainer);
    // Add a click event listener to open the question for editing
    // questionContainer.addEventListener('click', () => {
    //     // Retrieve the question class from the custom attribute.
    //     const questionData = questionContainer.getAttribute("data-survey-question");
    //     const question = surveyQuestions.find(q => q.id === questionData);

    //     console.log("current question id: " + questionData);
    //     // Remove the 'selected-question' class from previously selected questions
    //     const previouslySelectedQuestion = document.querySelector(".selected-question");
    //     if (previouslySelectedQuestion) {
    //         previouslySelectedQuestion.classList.remove("selected-question");
    //     }

    //     // Add the 'selected-question' class to the current question
    //     questionContainer.classList.add("selected-question");

    //     // Populate the component_info section with the selected question's information
    //     const questionTitleInput = document.getElementById("question_title");
    //     const questionDescriptionInput = document.getElementById("question_description");

    //     questionTitleInput.value = question.title;
    //     questionDescriptionInput.value = question.description;

    //     // const minLabel = document.getElementById(`${question.id}-scale-min-label`);
    //     // const maxLabel = document.getElementById(`${question.id}-scale-max-label`);

    //     // minLabel.textContent = question.options[0];
    //     // maxLabel.textContent = question.options[question.options.length - 1];    

    //     questionEditOption(question);
    // });

    surveyQuestions.push(question);
    console.log(surveyQuestions);


    // Append the input container to the question container
    questionContainer.appendChild(inputContainer);

    surveyQuestionContainer.appendChild(questionContainer);

    const structure = createStructureElement(question.id, QUESTION_TYPE_STRING[question.type], question.title);
    formStructureContainer.appendChild(structure);

    // const minLabel = document.getElementById(`${question.id}-scale-min-label`);
    // const maxLabel = document.getElementById(`${question.id}-scale-max-label`);

    // minLabel.textContent = question.options[0];
    // maxLabel.textContent = question.options[question.options.length - 1];
}

function initializeQuestionOnClick(questionBlock) {
    questionBlock.addEventListener('click', () => {
        // Retrieve the question class from the custom attribute.
        const questionData = questionBlock.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id === questionData);

        console.log("current question id: " + questionData);
        // Remove the 'selected-question' class from previously selected questions
        const previouslySelectedQuestion = document.querySelector(".selected-question");
        if (previouslySelectedQuestion) {
            previouslySelectedQuestion.classList.remove("selected-question");
        }

        // Add the 'selected-question' class to the current question
        questionBlock.classList.add("selected-question");

        // Populate the component_info section with the selected question's information
        const questionTitleInput = document.getElementById("question_title");
        const questionDescriptionInput = document.getElementById("question_description");

        questionTitleInput.value = question.title;
        questionDescriptionInput.value = question.description;

        // const minLabel = document.getElementById(`${question.id}-scale-min-label`);
        // const maxLabel = document.getElementById(`${question.id}-scale-max-label`);

        // minLabel.textContent = question.options[0];
        // maxLabel.textContent = question.options[question.options.length - 1];    

        questionEditOption(question);

        const editBlockSection = document.getElementById("edit_block_section");
        editBlockSection.style.display='block';
    });
}

// Create a function to generate the scale input HTML
function createScaleInput(question) {
    const scaleContainer = document.createElement("div");
    scaleContainer.className = "slider-container";

    scaleContainer.innerHTML =
        // `<span id="${question.id}-scale-min-label" class="slider-label">${question.scale_min_label}</span>
        `<span id="scale-min-label" class="slider-label">${question.scale_min_value}</span>
    `;

    // Create a range input for the scale
    const scaleInput = document.createElement("div");
    scaleInput.id = `${question.id}-scale`;
    scaleInput.className = "range-slider noUi-active slider-hide";
    scaleContainer.appendChild(scaleInput);
    console.log("scaleInput.id " + scaleInput.id);

    createSlider(question);

    scaleContainer.innerHTML +=
        `<span id="scale-max-label" class="slider-label">${question.scale_max_value}</span>
    `;

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

function initializeScaleSlider(questionID, min, max) {
    const sliderContainer = document.createElement("div");
    sliderContainer.className = "slider-container";

    // Generate unique IDs for the slider and labels
    const sliderID = `${questionID}-scale`;
    const minLabelID = `${questionID}-scale-min-label`;
    const maxLabelID = `${questionID}-scale-max-label`;

    // Check if the slider is already initialized
    if (document.getElementById(sliderID)) {
        console.log(`Slider ${sliderID} is already initialized.`);
        return;
    }

    sliderContainer.innerHTML = `
        <span id="${minLabelID}" class="slider-label">${min}</span>
        <div id="${sliderID}" class="range-slider noUi-active slider-hide"></div>
        <span id="${maxLabelID}" class="slider-label">${max}</span>
    `;

    // Add the slider container to the DOM
    const inputContainer = document.querySelector(`#${questionID} .input-container`);
    if (inputContainer) {
        inputContainer.appendChild(sliderContainer);
    }

    // Initialize the slider
    const slider = document.getElementById(sliderID);
    console.log("slider " + slider);
    if (slider) {
        noUiSlider.create(slider, {
            start: 0,
            tooltips: true,
            connect: true,
            step: 1,
            range: {
                'min': parseInt(min, 10),
                'max': parseInt(max, 10)
            },
            format: wNumb({ decimals: 0 })
        });

        // Add an event listener to the slider
        slider.noUiSlider.on('update', function (values, handle) {
            console.log("noUiSlider " + values[handle]);
        });

        console.log("INITIALIZED");
    }
    console.log("hey");
}




//==================================================================================
//==========update form when changing structure================================
//==================================================================================
function recreateSameQuestion(question) {
    const questionContainer = document.createElement("div");
    questionContainer.className = "question-style";
    questionContainer.setAttribute("data-survey-question", question.id);

    questionContainer.innerHTML = `
    <p class="question-title text-break" id="${question.id}-questionTitle">${question.title}</p>`;



    if (question.description !== "") {
        questionContainer.innerHTML += `<p class="form-text text-muted text-break" id="${question.id}-questionDescription">${question.description}</p>`;
    } else {
        questionContainer.innerHTML += `<p class="form-text text-muted text-break" id="${question.id}-questionDescription" style="display: none;">${question.description}</p>`;
    }

    // Create a div with the class "input-container" for grouping input elements
    const inputContainer = document.createElement("div");
    inputContainer.className = "input-container";

    switch (question.type) {
        case QUESTION_TYPE_INT.TEXT_INPUT:
            inputContainer.innerHTML = `
            <textarea id="${question.id}-userInput" class="question-input " placeholder="${question.placeholder}">${question.prefilledValue}</textarea>
            <label for="${question.id}-userInput" class="visually-hidden"></label>
            `;
            break;
        case QUESTION_TYPE_INT.MULTIPLE_CHOICE:
            question.options.forEach((option, index) => {
                inputContainer.innerHTML +=
                    `<label class="input_option">
                <input type="radio" id="${question.id}-option${index + 1}" name="${question.id}" value="${option}">
                ${option}
            </label>`;
            });

            break;
        case QUESTION_TYPE_INT.CHECKBOX:
            question.options.forEach((option, index) => {
                inputContainer.innerHTML +=
                    `<label class="input_option">
                <input type="checkbox" id="${question.id}-option${index + 1}" name="${question.id}" value="${option}">
                ${option}
            </label>`;
            });
            break;
        case QUESTION_TYPE_INT.SCALE:
            const scaleInput = createScaleInput(question);

            inputContainer.append(scaleInput);
            break;
    }

    initializeQuestionOnClick(questionContainer);

    questionContainer.appendChild(inputContainer);
    surveyQuestionContainer.appendChild(questionContainer);

    const structure = createStructureElement(question.id, QUESTION_TYPE_STRING[question.type], question.title);
    formStructureContainer.appendChild(structure);

    return questionContainer;
}



function updateQuestionPreview(question) {

    const questionContainer = document.createElement("div");
    questionContainer.className = "question-style";
    questionContainer.setAttribute("data-survey-question", question.id);

    questionContainer.innerHTML = `
    <p class="question-title" id="${question.id}-questionTitle">${question.title}</p>
    `;

    // if (question.description) {
    //     questionContainer.innerHTML += `
    //         <p class="text-black-50 text-break" id="${question.id}-questionDescription">${question.description}</p>
    //     `;
    // } else {
    //     questionContainer.innerHTML += `
    // <p class="text-black-50 text-break" id="${question.id}-questionDescription" style="display:none;">${question.description}</p>
    // `;
    // }

    questionContainer.innerHTML = `
    <p class="question-title text-break" id="${question.id}-questionTitle">${question.title}</p>
    <p class="form-text text-muted text-break" id="${question.id}-questionDescription" style="display: none;">${question.description}</p>
    `;

    const inputContainer = document.createElement("div");
    inputContainer.className = "input-container";


    switch (question.type) {
        case QUESTION_TYPE_INT.TEXT_INPUT:
            inputContainer.innerHTML = `
            <textarea id="${question.id}-userInput" class="question-input " placeholder="${question.placeholder}">${question.prefilledValue}</textarea>
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
    }

    // Add a click event listener to open the question for editing
    questionContainer.addEventListener('click', () => {
        // Retrieve the question class from the custom attribute.
        const questionData = questionContainer.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id === questionData);

        // Remove the 'selected-question' class from previously selected questions
        const previouslySelectedQuestion = document.querySelector(".selected-question");
        if (previouslySelectedQuestion) {
            previouslySelectedQuestion.classList.remove("selected-question");
        }

        // Add the 'selected-question' class to the current question
        questionContainer.classList.add("selected-question");

        // Populate the component_info section with the selected question's information
        const questionTitleInput = document.getElementById("question_title");
        const questionDescriptionInput = document.getElementById("question_description");

        questionTitleInput.value = question.title;
        questionDescriptionInput.value = question.description;

        // const minLabel = document.getElementById(`${question.id}-scale-min-label`);
        // const maxLabel = document.getElementById(`${question.id}-scale-max-label`);

        // minLabel.textContent = question.options[0];
        // maxLabel.textContent = question.options[question.options.length - 1];    

        questionEditOption(question);
    });
    //questionContainer.setAttribute("data-survey-question", JSON.stringify(question));
    //questionContainer.setAttribute("data-question-id", question.id);

    // Append the input container to the question container
    questionContainer.appendChild(inputContainer);

    return questionContainer;
}

function createStructureElement(questionID, QUESTION_TYPE_INT, questionString) {
    const structure = document.createElement("div");
    structure.className = "structure";
    structure.setAttribute("data-question-id", questionID);
    structure.setAttribute("data-question-type", QUESTION_TYPE_INT);
    structure.innerHTML = `
    <!-- <i class="fas fa-bars handle m-3"> -->
    <p class="structure-title" id="${questionID}-questionTitle">${questionString}</p>
    <p class="structure-type">${QUESTION_TYPE_INT}</p>
    `;
    return structure;
}

function updateFormPreview() {
    const formPreview = document.getElementById("questions_container");
    formPreview.innerHTML = ""; // Clear the existing content

    // Append the corresponding questions to the form preview
    surveyQuestions.forEach(question => {
        const questionContainer = updateQuestionPreview(question);
        formPreview.appendChild(questionContainer);
    });
}

function updateFormStructure() {
    // Clear the existing form structure
    const formStructureContainer = document.getElementById("form_structure");
    formStructureContainer.innerHTML = "";

    // Iterate through surveyQuestions and recreate the structure
    surveyQuestions.forEach(question => {
        const structure = createStructureElement(question.id, QUESTION_TYPE_STRING[question.type], question.title);
        formStructureContainer.appendChild(structure);
        console.log("triggered");
    });
}



//==================================================================================
//==========initialization and updating survey title and description================================
//==================================================================================

$(document).ready(function () {
    // Get a reference to the "Survey Title" input field and the character limit
    const titleInput = document.getElementById('survey_title');
    const descriptionInput = document.getElementById('survey_description');

    let titleCharLimit = 80;
    let descriptionCharLimit = 4500;

    titleInput.required = true;
    titleInput.value = "Your Survey Title";

    titleInput.addEventListener('input', function () {
        const inputValue = titleInput.value;
        if (inputValue.length > titleCharLimit) {
            titleInput.value = inputValue.substring(0, titleCharLimit);
        }
        updateTitle(titleInput, titleCharLimit);
    });

    descriptionInput.addEventListener('input', function () {
        const inputValue = descriptionInput.value;
        if (inputValue.length > descriptionCharLimit) {
            descriptionInput.value = inputValue.substring(0, descriptionCharLimit);
        }
        updateDescription(descriptionInput, descriptionCharLimit);
    });

    // Initialize title and character counter
    updateTitle(titleInput, titleCharLimit);
    updateDescription(descriptionInput, descriptionCharLimit);


    const inputOptionField = document.getElementById("input_option_container");
    const textFields = document.getElementById("text_edit_container");
    const scaleField = document.getElementById("scale-container");
    const editBlockSection = document.getElementById("edit_block_section");

    inputOptionField.style.display = "none";
    textFields.style.display = "none";
    scaleField.style.display = "none";

    editBlockSection.style.display = "none";
});

function updateTitle(input, maxCharLimit) {
    let titleHeader = document.getElementById('survey_title_header');
    let titlePreview = document.getElementById('survey_title_preview');
    let titleCharCounter = document.getElementById('title_char_counter');

    let inputValue = input.value;

    if (inputValue.length > maxCharLimit - 1) {
        input.value = inputValue.substring(0, maxCharLimit - 1);
    }
    titleHeader.textContent = inputValue.substring(0, maxCharLimit - 1) || 'Your Survey Title';
    titlePreview.textContent = inputValue.substring(0, maxCharLimit - 1) || 'Your Survey Title';
    titleCharCounter.textContent = `${inputValue.length}/${maxCharLimit - inputValue.length}`;
}

function updateDescription(input, maxCharLimit) {
    let descriptionPreview = document.getElementById('survey_description_preview');
    let descriptionCharCounter = document.getElementById('description_char_counter');

    let inputValue = input.value;
    if (inputValue.length > maxCharLimit - 1) {
        input.value = inputValue.substring(0, maxCharLimit - 1);
    }

    descriptionPreview.textContent = inputValue.substring(0, maxCharLimit - 1) || '';
    descriptionCharCounter.textContent = `${inputValue.length}/${maxCharLimit - inputValue.length}`;
}

//==================================================================================
//====================Updating the title and description for each question component===========
//==================================================================================
// Add an input event listener to the question properties
const questionPropertiesDDL = document.getElementById("question_properties");
function populateQuestionProperties() {
    for (const key in QUESTION_PROPERTIES) {
        const optionElement = document.createElement("option");
        optionElement.value = QUESTION_PROPERTIES[key];
        optionElement.textContent = QUESTION_PROPERTIES[key];
        optionElement.style.textTransform = "capitalize";
        questionPropertiesDDL.appendChild(optionElement);
    }
}
populateQuestionProperties();

questionPropertiesDDL.addEventListener("input", function () {
    let questionProperties = questionPropertiesDDL.value;

    console.log("questionProperties " + questionProperties);
    // // Retrieve the selected question container from the DOM
    const selectedQuestionContainer = document.querySelector(".selected-question");

    // Access the question object using the data-survey-question attribute
    const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
    const question = surveyQuestions.find(q => q.id === questionData);

    question.properties = questionProperties;

    const questionInput = selectedQuestionContainer.querySelector(".question-input");
    const questionTitleElement = selectedQuestionContainer.querySelector(".question-title");

    switch (question.properties.toLowerCase()) {
        case QUESTION_PROPERTIES[0]:
            questionTitleElement.classList.remove("required");

            switch (question.type) {
                case QUESTION_TYPE_INT.TEXT_INPUT:
                    questionInput.required = false;
                    questionInput.readOnly = false;
            }
            break;
        case QUESTION_PROPERTIES[1]:
            questionTitleElement.classList.add("required");
            console.log("questionTitleElement.classList " + questionTitleElement.classList);

            switch (question.type) {
                case QUESTION_TYPE_INT.TEXT_INPUT:
                    questionInput.required = true;
                    questionInput.readOnly = false;
                    console.log("triggered");
            }

            break;

        case QUESTION_PROPERTIES[2]:
            questionTitleElement.classList.remove("required");

            switch (question.type) {
                case QUESTION_TYPE_INT.TEXT_INPUT:
                    questionInput.required = false;
                    questionInput.readOnly = true;
            }
            break;
    }
    console.log("questionTitleElement.classList " + questionTitleElement.classList);

});


// Add an input event listener to the question title textarea
const questionTitleInput = document.getElementById("question_title");
questionTitleInput.addEventListener("input", function () {
    let questionTitle = questionTitleInput.value.trim();

    // Retrieve the selected question container from the DOM
    const selectedQuestionContainer = document.querySelector(".selected-question");

    // Access the question object using the data-survey-question attribute
    const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
    const question = surveyQuestions.find(q => q.id === questionData);

    // Update the question title in the selected question container
    const questionTitleElement = selectedQuestionContainer.querySelector(".question-title");
    if (questionTitleElement) {
        questionTitleElement.textContent = questionTitle;
    }

    question.title = questionTitle;
});

// Add an input event listener to the question description textarea
const questionDescriptionInput = document.getElementById("question_description");
questionDescriptionInput.addEventListener("input", function () {
    let questionDescription = questionDescriptionInput.value.trim();

    // Retrieve the selected question container from the DOM
    const selectedQuestionContainer = document.querySelector(".selected-question");

    // Access the question object using the data-survey-question attribute
    const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
    const question = surveyQuestions.find(q => q.id === questionData);

    // Update the question description in the selected question container
    const questionDescriptionElement = selectedQuestionContainer.querySelector(".form-text");

    if (questionDescriptionElement) {
        if (questionDescription !== "") {
            questionDescriptionElement.style.display = 'block';
            questionDescriptionElement.textContent = questionDescription;
        } else {
            questionDescriptionElement.style.display = 'none';
        }
    }

    // Update the question's description property
    question.description = questionDescription;
});


//==================================================================================
//====================manipulating each input fields attributes===========
//==================================================================================
// Add an input event listener to the question placeholder textarea
const questionPlaceholderInput = document.getElementById("question_placeholder");
questionPlaceholderInput.addEventListener("input", function () {
    const questionPlaceholder = questionPlaceholderInput.value;

    // Retrieve the selected question container from the DOM
    const selectedQuestionContainer = document.querySelector(".selected-question");

    // Access the question object using the data-survey-question attribute
    const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
    const question = surveyQuestions.find(q => q.id === questionData);

    console.log("questionData " + questionData);
    console.log("question " + question);
    // Update the input field's placeholder
    const questionInput = selectedQuestionContainer.querySelector(".question-input");
    if (questionInput) {
        questionInput.placeholder = questionPlaceholder;
    }

    // Update the question's placeholder property
    question.placeholder = questionPlaceholder;
});

// Add an input event listener to the question pre-filed value textarea
const questionPrefiledValueInput = document.getElementById("question_prefiled_value");
questionPrefiledValueInput.addEventListener("input", function () {
    const questionPrefiledValue = questionPrefiledValueInput.value;

    // Retrieve the selected question container from the DOM
    const selectedQuestionContainer = document.querySelector(".selected-question");

    // Access the question object using the data-survey-question attribute
    const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
    //const question = surveyQuestions.find(q => q.id === JSON.parse(questionData).id);
    const question = surveyQuestions.find(q => q.id === questionData);

    // Update the input field's value
    const questionInput = selectedQuestionContainer.querySelector(".question-input");
    if (questionInput) {
        questionInput.value = questionPrefiledValue;
    }

    // Update the question's pre-filed value property
    question.prefilledValue = questionPrefiledValue;
});

function questionEditOption(question) {
    const selectedType = question.type;

    // Get references to the input fields
    const inputOptionField = document.getElementById("input_option_container");
    const textFields = document.getElementById("text_edit_container");
    const scaleField = document.getElementById("scale-container");

    // Determine which input fields should be visible based on the selected question type
    if (selectedType === QUESTION_TYPE_INT.MULTIPLE_CHOICE || selectedType === QUESTION_TYPE_INT.CHECKBOX) {
        // Show Input Option and hide the others
        inputOptionField.style.display = "block";
        textFields.style.display = "none";
        scaleField.style.display = "none";

        let questionInputOptionInput = document.getElementById("input_option_contentholder");
        console.log("question.options " + question.options);
        questionInputOptionInput.value = '';
        for (let i = 0; i < question.options.length; i++) {
            questionInputOptionInput.value += question.options[i];
            questionInputOptionInput.value += "\n";
        }

    } else if (selectedType === QUESTION_TYPE_INT.TEXT_INPUT) {
        // Show Pre-filled Value and Placeholder, hide Input Option
        inputOptionField.style.display = "none";
        textFields.style.display = "block";
        scaleField.style.display = "none";

        const questionPlaceholderInput = document.getElementById("question_placeholder");
        const questionPrefilledInput = document.getElementById("question_prefiled_value");

        questionPlaceholderInput.value = question.placeholder;
        questionPrefilledInput.value = question.prefilledValue;


    } else if (selectedType === QUESTION_TYPE_INT.SCALE) {
        inputOptionField.style.display = "none";
        textFields.style.display = "none";
        scaleField.style.display = "block";

        const scaleMinLabelInput = document.getElementById("min_label_containholder");
        const scaleMaxLabelInput = document.getElementById("max_label_containholder");

        const minLabel = document.getElementById(`scale-min-label`);
        const maxLabel = document.getElementById(`scale-max-label`);

        const scaleMinNum = document.getElementById("min_num");
        const scaleMaxNum = document.getElementById("max_num");

        // scaleMinLabelInput.value = question.scale_min_label;
        // scaleMaxLabelInput.value = question.scale_max_label;

        // scaleMinLabelInput.value = question.options[0];
        // scaleMaxLabelInput.value = question.options[question.options.length - 1];

        console.log("= question.scale_min_value " + question.scale_min_value);
        console.log("= question.scale_miax_value " + question.scale_max_value);
        minLabel.textContent = question.scale_min_value;
        maxLabel.textContent = question.scale_max_value;

        scaleMinNum.value = question.scale_min_value;
        scaleMaxNum.value = question.scale_max_value;

    }
    else {
        // For other question types, hide all input fields
        inputOptionField.style.display = "none";
        textFields.style.display = "block";
        scaleField.style.display = "none";
    }
}

// const inputOptionsContainer = document.getElementById("input_options");

// function createInputOptionDiv() {
//     const inputOptionDiv = document.createElement("div");
//     inputOptionDiv.className = "input-option";

//     const inputOptionField = document.createElement("input");
//     inputOptionField.type = "text";
//     inputOptionField.placeholder = "Click to add input option";
//     inputOptionField.addEventListener("click", () => {
//         addInputOption(inputOptionDiv);
//     });

//     inputOptionDiv.appendChild(inputOptionField);

//     return inputOptionDiv;
// }

// function addInputOption(inputOptionDiv) {
//     if (!inputOptionDiv.classList.contains("added")) {
//         inputOptionDiv.classList.add("added");
//         const removeOptionButton = document.createElement("button");
//         removeOptionButton.innerText = "x";
//         removeOptionButton.className = "remove-option";
//         removeOptionButton.addEventListener("click", () => {
//             removeInputOption(inputOptionDiv);
//         });
//         inputOptionDiv.appendChild(removeOptionButton);
//         inputOptionsContainer.appendChild(inputOptionDiv);
//         inputOptionsContainer.appendChild(createInputOptionDiv()); // Add a new input option after this one
//     }
//         // Check if there's more than one option and hide the "x" button
//         if (inputOptionsContainer.childElementCount > 1) {
//             inputOptionDiv.lastElementChild.style.display = "inline"; // Show "x" button
//         }
// }



// function removeInputOption(inputOptionDiv) {
//     inputOptionsContainer.removeChild(inputOptionDiv);
// }

// // Initialize with one input option
// inputOptionsContainer.appendChild(createInputOptionDiv());




// // Assume 'questionInputOption' contains the input options entered in the textarea
const questionInputOptionInput = document.getElementById("input_option_contentholder");
questionInputOptionInput.addEventListener("input", function () {
    //const inputOptions = questionInputOptionInput.value.split('\n').filter(option => option.trim() !== '');
    const inputOptions = parseInputOptions(questionInputOptionInput.value);

    console.log("hello " + inputOptions);
    // Retrieve the selected question container from the DOM
    const selectedQuestionContainer = document.querySelector(".selected-question");

    // Access the question object using the data-survey-question attribute
    const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
    //const question = surveyQuestions.find(q => q.id === JSON.parse(questionData).id);
    const question = surveyQuestions.find(q => q.id === questionData);
    console.log("1");
    console.log(question);

    var inputContainer = selectedQuestionContainer.querySelector(".input-container");

    inputContainer.innerHTML = ``;

    // console.log("inputOptions " + inputOptions);
    question.updateOptions(inputOptions);
    const index = surveyQuestions.findIndex(q => q.id === question.id);
    if (index !== -1) {
        surveyQuestions[index] = question;
    }
    // update the value that been stored in each block
    //selectedQuestionContainer.setAttribute("data-survey-question", JSON.stringify(question));


    switch (question.type) {
        case QUESTION_TYPE_INT.MULTIPLE_CHOICE:
            inputOptions.forEach((option, index) => {
                inputContainer.innerHTML += `
            <label class="input_option">
                    <input type="radio" id="${question.id}-option${index + 1}" name="${question.id}" value="${option}">
                    ${option}
                </label>
                `;
            });

            console.log(question);
            break;
        case QUESTION_TYPE_INT.CHECKBOX:
            inputOptions.forEach((option, index) => {
                inputContainer.innerHTML += `
                <label class="input_option">
                <input type="checkbox" id="${question.id}-option${index + 1}" name="${question.id}" value="${option}">
                    ${option}
                </label>
                `;
            });
            console.log(question);

            break;
        // Add handling for other question types
    }
});

// Function to parse input options considering double-quoted text as a single input
function parseInputOptions(input) {
    const optionsSet = new Set();
    const lines = input.split('\n');

    for (const line of lines) {
        const trimmedOption = line.trim();
        if (trimmedOption !== '') {
            optionsSet.add(trimmedOption);
        }
    }

    // If there are no options, add a default value
    if (optionsSet.size === 0) {
        optionsSet.add("Default Option");
    }

    return Array.from(optionsSet);
}



// const minLabelInputContainer = document.getElementById("min_label_containholder");
// minLabelInputContainer.addEventListener("input", function () {
//     const minLabelInput = minLabelInputContainer.value;

//     // Retrieve the selected question container from the DOM
//     const selectedQuestionContainer = document.querySelector(".selected-question");

//     // Access the question object using the data-survey-question attribute
//     const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
//         const question = surveyQuestions.find(q => q.id === JSON.parse(questionData).id);

//     // Update the input field's placeholder
//     const questionInput = selectedQuestionContainer.querySelector(`#${question.id}-scale-min-label`);
//     if (questionInput) {
//         questionInput.textContent = minLabelInput;
//     }

//     // Update the question's placeholder property
//     question.textContent = minLabelInput;
// });
const minLabelInputContainer = document.getElementById("min_label_containholder");
const maxLabelInputContainer = document.getElementById("max_label_containholder");

function updateLabelInput(labelInputContainer, labelType) {
    labelInputContainer.addEventListener("input", function () {
        const labelInput = labelInputContainer.value;

        // Retrieve the selected question container from the DOM
        const selectedQuestionContainer = document.querySelector(".selected-question");

        // Access the question object using the data-survey-question attribute
        const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id === questionData);

        // Update the input field's placeholder
        const questionInput = selectedQuestionContainer.querySelector(`#${question.id}-scale-${labelType}-label`);
        if (questionInput) {
            questionInput.textContent = labelInput;
            console.log(labelInput);
            console.log(questionInput.textContent);
        }

        // Update the question's placeholder property
        question[`scale_${labelType}_label`] = labelInput;
    });
}

updateLabelInput(minLabelInputContainer, "min");
updateLabelInput(maxLabelInputContainer, "max");


// Get the select elements
const minSelect = document.getElementById("min_num");
const maxSelect = document.getElementById("max_num");

// Function to add options to a select element
function populateSelect(select, options) {
    for (var i = 1; i <= options.length; i++) {
        const optionElement = document.createElement("option");
        optionElement.value = i;
        optionElement.textContent = i;
        select.appendChild(optionElement);
    }
}

// // // Function to add options to a select element
// // function updateSelect(select, constraint, minMax) {
// //     for (let option of scaleOptions) {
// //         const optionElement = document.createElement("option");
// //         optionElement.value = option;
// //         optionElement.textContent = option;

// //         // Disable the option based on the constraint (either "min" or "max")
// //         if ((constraint === "min" && option >= minMax)||
// //         (constraint === "max" && option <= minMax)) {
// //             optionElement.disabled = true;
// //         }
// //         select.appendChild(optionElement);
// //     }
// // }


// // Populate the select elements with the scale options
populateSelect(minSelect, scaleOptions);
populateSelect(maxSelect, scaleOptions);


// // Add event listeners to handle changes
// minSelect.addEventListener("change", function () {
//     // Retrieve and store the selected minimum value
//     const selectedMin = minSelect.value;
//     // You can store this value in your data structure or do something else with it
//     console.log("Selected Min: " + selectedMin);
// });

// maxSelect.addEventListener("change", function () {
//     // Retrieve and store the selected maximum value
//     const selectedMax = maxSelect.value;
//     // You can store this value in your data structure or do something else with it
//     console.log("Selected Max: " + selectedMax);
// });

function updateScaleInput(scaleInputContainer) {
    scaleInputContainer.addEventListener("input", function () {
        //const scaleInput = scaleInputContainer.value;

        // Retrieve the selected question container from the DOM
        const selectedQuestionContainer = document.querySelector(".selected-question");

        // Access the question object using the data-survey-question attribute
        const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id === questionData);

        console.log(question);

        question.scale_min_value = minSelect.value;
        question.scale_max_value = maxSelect.value;

        // Update the existing noUiSlider with new values
        const slider = document.getElementById(`${question.id}-scale`);
        slider.noUiSlider.updateOptions({
            range: {
                'min': parseInt(question.scale_min_value, 10),
                'max': parseInt(question.scale_max_value, 10)
            }
        });

        const minLabel = selectedQuestionContainer.querySelector(`#scale-min-label`);
        const maxLabel = selectedQuestionContainer.querySelector(`#scale-max-label`);

        //update label
        minLabel.textContent = question.scale_min_value;
        maxLabel.textContent = question.scale_max_value;
    });
}


updateScaleInput(minSelect);
updateScaleInput(maxSelect);


//==================================================================================
//==========remove and duplicate================================
//==================================================================================


// // Get the element for the current question block
// const questionBlock = document.querySelector('.survey-form');

// // Get the parent element that contains all question blocks
// const questionBlocksContainer = questionBlock.parentElement;

// // Remove block button click event
// const removeBlockButton = questionBlock.querySelector('button:nth-child(1)');
// removeBlockButton.addEventListener('click', function () {
//     // Check if this is the selected question block
//     if (questionBlock.classList.contains('selected-question')) {
//         // Remove the selected question block
//         questionBlocksContainer.removeChild(questionBlock);
//     }
// });



const deleteQuestionButton = document.getElementById("remove_block");
deleteQuestionButton.addEventListener('click', function () {
    // Retrieve the selected question container from the DOM
    const selectedQuestionContainer = document.querySelector(".selected-question");

    if (selectedQuestionContainer) {
        // Access the question object using the data-survey-question attribute
        const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id === questionData);

        // Remove the selected question block from the DOM
        selectedQuestionContainer.parentElement.removeChild(selectedQuestionContainer);

        // Also remove the corresponding structure element from the form structure
        //formStructureContainer.removeChild(structure);

        // Remove the question object from the surveyQuestions array
        const questionIndex = surveyQuestions.indexOf(question);
        if (questionIndex !== -1) {
            surveyQuestions.splice(questionIndex, 1);
        }

        updateFormStructure();
    }
});

const duplicateQuestionButton = document.getElementById("duplicate_block");
duplicateQuestionButton.addEventListener('click', function () {
    // Retrieve the selected question container from the DOM
    const selectedQuestionContainer = document.querySelector(".selected-question");

    if (selectedQuestionContainer) {
        // Access the question object using the data-survey-question attribute
        const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id === questionData);

        //clone the question
        const clonedQuestion = SurveyQuestion.cloneQuestion(question);

        // Rearrange surveyQuestions array based on the new question's position
        const originalIndex = surveyQuestions.findIndex(q => q.id === question.id);
        surveyQuestions.splice(originalIndex + 1, 0, clonedQuestion);

        //console.log(surveyQuestions);

        // Clone the selected question container
        // const duplicatedQuestionContainer = selectedQuestionContainer.cloneNode(true);
        const duplicatedQuestionContainer = recreateSameQuestion(clonedQuestion);

        // Remove the 'selected-question' class from the original and add it to the duplicated question
        selectedQuestionContainer.classList.remove("selected-question");
        duplicatedQuestionContainer.classList.add("selected-question");

        // Insert the duplicated question container after the selected question
        selectedQuestionContainer.insertAdjacentElement('afterend', duplicatedQuestionContainer);

        updateFormStructure();
    }
});