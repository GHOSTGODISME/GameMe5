// to make this file works, 
// 1. include the survey_utility.js
// 2. make sure receive the survey object from server first


const surveyQuestionContainer = document.getElementById("questions_container");

/// for changing the form arrangement
const formStructureContainer = document.getElementById("form_structure");
// const lectureID = 0;
// const surveyID = 0;

// let questionCount = 0;

// const idPrefix = "s"
// const scaleOptions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; // Example options

// const survey = mapSurveyDataToInstance(surveyFromDB);
// let surveyQuestions = survey.questions;

console.log(surveyQuestions);
// ${lectureID}-${surveyID}-${questionCount}-${QUESTION_TYPE_INT[0]}

const sortable = new Sortable(formStructureContainer, {
    //handle: '.handle',

    animation: 150,
    onEnd: function (evt) {
        const structureElements = formStructureContainer.querySelectorAll('.structure');
        const newSurveyQuestions = [];

        structureElements.forEach((structure, newIndex) => {
            const questionID = structure.getAttribute('data-question-id');
            const foundQuestion = surveyQuestions.find(q => q.id.toString() === questionID);

            if (foundQuestion) {
                foundQuestion.index = newIndex;
                newSurveyQuestions.push(foundQuestion);
            }
        });

        // Update the surveyQuestions array with the reordered questions
        surveyQuestions = newSurveyQuestions;

        // console.log("updated " + surveyQuestions);
        console.log(surveyQuestions);
        // Update the form preview when an item is dragged and dropped
        updateFormPreview();
    }
});

function addQuestion(type) {
    questionCount++;

    const questionID = `${idPrefix}-${lectureID}-${surveyID}-${questionCount}-${type}`;
    const questionTitle = `${questionCount}. Please enter the question`;
    const description = "";

    const question = new SurveyQuestion(questionID, type, questionTitle, description);

    question.index = surveyQuestions.length +1;

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

    createQuestionTypeBlock(type, question,inputContainer);

    initializeQuestionOnClick_admin(questionContainer);

    // Append the input container to the question container
    questionContainer.appendChild(inputContainer);

    surveyQuestionContainer.appendChild(questionContainer);

    surveyQuestions.push(question);
    const structure = createStructureElement(question.id, QUESTION_TYPE_STRING[question.type], question.title);
    formStructureContainer.appendChild(structure);
    
}

function initializeQuestionOnClick_admin(questionBlock) {
    questionBlock.addEventListener('click', () => {
        // Retrieve the question class from the custom attribute.
        const questionData = questionBlock.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id.toString() === questionData);

        console.log("current question id: " + questionData);
        console.log(surveyQuestions);
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

        console.log(question.index);

        // const questionPropertiesDDL = document.getElementById("question_properties");
        // questionPropertiesDDL.value = question.properties;
        
        // const questionTitleElement = questionBlock.querySelector(".question-title");
        // applyQuestionProperty(question,questionTitleElement );
    
    });
}


//==================================================================================
//==========update form when changing structure================================
//==================================================================================
function recreateSameQuestion(question) {
    console.log(question);
    const questionContainer = document.createElement("div");
    questionContainer.className = "question-style";
    questionContainer.setAttribute("data-survey-question", question.id);

    questionContainer.innerHTML = `
    <p class="question-title text-break" id="${question.id}-questionTitle">${question.title}</p>`;



    if (question.description !== "" || question.description === null) {
        questionContainer.innerHTML += `<p class="form-text text-muted text-break" id="${question.id}-questionDescription">${question.description}</p>`;
    } else {
        questionContainer.innerHTML += `<p class="form-text text-muted text-break" id="${question.id}-questionDescription" style="display: none;">${question.description}</p>`;
    }

    // Create a div with the class "input-container" for grouping input elements
    const inputContainer = document.createElement("div");
    inputContainer.className = "input-container";

        switch (parseInt(question.type)) {
        case QUESTION_TYPE_INT.TEXT_INPUT:
            inputContainer.innerHTML = `
            <textarea id="${question.id}-userInput" class="question-input form-control" placeholder="${question.placeholder}">${question.prefilledValue}</textarea>
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

    initializeQuestionOnClick_admin(questionContainer);

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
    <p class="question-title text-break" id="${question.id}-questionTitle">${question.title}</p>
    <p class="form-text text-muted text-break" id="${question.id}-questionDescription" style="display: none;">${question.description}</p>
    `;

    const inputContainer = document.createElement("div");
    inputContainer.className = "input-container";

    recreateQuestionTypeBlock(question, inputContainer);

    initializeQuestionOnClick_admin(questionContainer);

    // Append the input container to the question container
    questionContainer.appendChild(inputContainer);

    // const questionTitleElement = questionContainer.querySelector(".question-title");
    // applyQuestionProperty(question,questionTitleElement );

    return questionContainer;
}

function createStructureElement(id, questionType, questionString) {
    const structure = document.createElement("div");
    structure.className = "structure";
    structure.setAttribute("data-question-id", id);
    structure.setAttribute("data-question-type", questionType);
    structure.innerHTML = `
    <!-- <i class="fas fa-bars handle m-3"> -->
    <p class="structure-title" id="${id}-questionTitle">${questionString}</p>
    <p class="structure-type">${questionType}</p>
    `;
    return structure;
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

function populateSurveyForm() {
    // Populate survey details
    document.getElementById('survey_title_preview').value = survey.title;
    document.getElementById('survey_description_preview').value = survey.description;

    updateFormPreview();
}


//==================================================================================
//==========initialization and updating survey title and description================================
//==================================================================================

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    initializeSurveyFields();

    //populateSurveyForm();

    updateFormStructure();

    initializeInputListeners();
    initializeFieldsVisibility();

    initializeSurveySubmitBtn_admin();

});

function initializeSurveyFields(){
    document.getElementById('survey_title').value = survey.title;
    document.getElementById('survey_description').value = survey.description;
    document.getElementById('visibility').value = survey.visibility;

    $('.survey-title-input').val(survey.title);
    $('.survey-title-text').text(survey.title);
    $('.survey-description-input').val(survey.description);
    $('.survey-description-text').text(survey.description);
    $('.survey_visibility_input').val(survey.visibility ?? "public");

}

function initializeInputListeners() {
    const titleInput = $(".survey-title-input");
    const descriptionInput = $(".survey-description-input");

    const titleCharLimit = 80;
    const descriptionCharLimit = 4500;

    titleInput.required = true;
    
    titleInput.on('input', function () {
        const inputValue = $(this).val(); // Using jQuery's val() to get the input value
        if (inputValue.length > titleCharLimit) {
            $(this).val(inputValue.substring(0, titleCharLimit)); // Setting value using jQuery's val()
        }
        updateTitle($(this), titleCharLimit); // Pass $(this) to jQuery function for updateTitle
        survey.title = $(this).val(); // Update survey title using jQuery's val()
    });

    descriptionInput.on('input', function () {
        const inputValue = $(this).val(); // Using jQuery's val() to get the input value
        if (inputValue.length > titleCharLimit) {
            $(this).val(inputValue.substring(0, titleCharLimit)); // Setting value using jQuery's val()
        }
        updateDescription($(this), titleCharLimit); // Pass $(this) to jQuery function for updateTitle
    });

        // Initialize title and character counter
        updateTitle(titleInput, titleCharLimit);
        updateDescription(descriptionInput, descriptionCharLimit);
}

function initializeFieldsVisibility(){
    const inputOptionFields = document.getElementById("input_option_container");
    const textFields = document.getElementById("text_edit_container");
    const scaleFields = document.getElementById("scale-container");
    const editBlockSections = document.getElementById("edit_block_section");

    inputOptionFields.style.display = "none";
    textFields.style.display = "none";
    scaleFields.style.display = "none";
    editBlockSections.style.display = "none";
}

function updateTitle(input, maxCharLimit) {
    let inputValue = input.val(); // Use jQuery's val() method to get the value

    if (inputValue.length > maxCharLimit - 1) {
        inputValue = inputValue.substring(0, maxCharLimit - 1);
    input.val(inputValue); // Set the updated value using jQuery's val()
    }

    const title = inputValue || 'Your Survey Title';
    const cc = `${inputValue.length}/${maxCharLimit - inputValue.length}`;

    $('.title_cc').text(cc);

    $('.survey-title-input').val(title);
    $('.survey-title-text').text(title);
}

function updateDescription(input, maxCharLimit) {
    let inputValue = input.val(); // Use jQuery's val() method to get the value
    if (inputValue.length > maxCharLimit - 1) {
        inputValue = inputValue.substring(0, maxCharLimit - 1);
    input.val(inputValue); // Set the updated value using jQuery's val()
    }

    const description = inputValue || '';
    const cc = `${inputValue.length}/${maxCharLimit - inputValue.length}`;

    $('.description_cc').text(cc);

    $('.survey-description-input').val(description);
    $('.survey-description-text').text(description);
}

//==================================================================================
//====================Updating the title and description for each question component===========
//==================================================================================
// to be done in future
// const questionPropertiesDDL = document.getElementById("question_properties");
// function populateQuestionProperties() {
//     for (const key in QUESTION_PROPERTIES) {
//         const optionElement = document.createElement("option");
//         optionElement.value = QUESTION_PROPERTIES[key];
//         optionElement.textContent = QUESTION_PROPERTIES[key];
//         optionElement.style.textTransform = "capitalize";
//         questionPropertiesDDL.appendChild(optionElement);
//     }
// }
// populateQuestionProperties();

// questionPropertiesDDL.addEventListener("input", function () {
//     let questionProperties = questionPropertiesDDL.value;

//     console.log("questionProperties " + questionProperties);
//     // // Retrieve the selected question container from the DOM
//     const selectedQuestionContainer = document.querySelector(".selected-question");

//     // Access the question object using the data-survey-question attribute
//     const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
//     const question = surveyQuestions.find(q => q.id.toString() === questionData);

//     question.properties = questionProperties;
//     console.log("question.properties "+ question.properties);

//     const questionInput = selectedQuestionContainer.querySelector(".question-input");
//     const questionTitleElement = selectedQuestionContainer.querySelector(".question-title");

//     switch (question.properties.toLowerCase()) {
//         case QUESTION_PROPERTIES[0]:
//             questionTitleElement.classList.remove("required");

//                 switch (parseInt(question.type)) {
//                 case QUESTION_TYPE_INT.TEXT_INPUT:
//                     questionInput.required = false;
//                     questionInput.readOnly = false;
//             }
//             break;
//         case QUESTION_PROPERTIES[1]:
//             questionTitleElement.classList.add("required");
//             console.log("questionTitleElement.classList " + questionTitleElement.classList);

//                 switch (parseInt(question.type)) {
//                 case QUESTION_TYPE_INT.TEXT_INPUT:
//                     questionInput.required = true;
//                     questionInput.readOnly = false;
//                     console.log("triggered");
//             }

//             break;

//         case QUESTION_PROPERTIES[2]:
//             questionTitleElement.classList.remove("required");

//                 switch (parseInt(question.type)) {
//                 case QUESTION_TYPE_INT.TEXT_INPUT:
//                     questionInput.required = false;
//                     questionInput.readOnly = true;
//             }
//             break;
//     }
//     console.log("questionTitleElement.classList " + questionTitleElement.classList);

// });


// Add an input event listener to the question title textarea
const questionTitleInput = document.getElementById("question_title");
questionTitleInput.addEventListener("input", function () {
    let questionTitle = questionTitleInput.value.trim();

    // Retrieve the selected question container from the DOM
    const selectedQuestionContainer = document.querySelector(".selected-question");

    // Access the question object using the data-survey-question attribute
    const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
    const question = surveyQuestions.find(q => q.id.toString() === questionData);

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
    const question = surveyQuestions.find(q => q.id.toString() === questionData);

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
    const question = surveyQuestions.find(q => q.id.toString() === questionData);

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
    //const question = surveyQuestions.find(q => q.id.toString() === JSON.parse(questionData).id);
    const question = surveyQuestions.find(q => q.id.toString() === questionData);

    // Update the input field's value
    const questionInput = selectedQuestionContainer.querySelector(".question-input");
    if (questionInput) {
        questionInput.value = questionPrefiledValue;
    }

    // Update the question's pre-filed value property
    question.prefilledValue = questionPrefiledValue;
});

function questionEditOption(question) {
    const selectedType = parseInt(question.type);

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

        scaleMinLabelInput.value = question.scale_min_label;
        scaleMaxLabelInput.value = question.scale_max_label;


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
        textFields.style.display = "none";
        scaleField.style.display = "none";
    }
}


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
    //const question = surveyQuestions.find(q => q.id.toString() === JSON.parse(questionData).id);
    const question = surveyQuestions.find(q => q.id.toString() === questionData);
    console.log("1");
    console.log(question);

    var inputContainer = selectedQuestionContainer.querySelector(".input-container");

    inputContainer.innerHTML = ``;

    // console.log("inputOptions " + inputOptions);
    question.updateOptions(inputOptions);
    const index = surveyQuestions.findIndex(q => q.id.toString() === question.id);
    if (index !== -1) {
        surveyQuestions[index] = question;
    }
    // update the value that been stored in each block
    //selectedQuestionContainer.setAttribute("data-survey-question", JSON.stringify(question));


        switch (parseInt(question.type)) {
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





const minLabelInputContainer = document.getElementById("min_label_containholder");
const maxLabelInputContainer = document.getElementById("max_label_containholder");

function updateLabelInput(labelInputContainer, labelType, labelID) {
    labelInputContainer.addEventListener("input", function () {
        const labelInput = labelInputContainer.value.trim();

        // Retrieve the selected question container from the DOM
        const selectedQuestionContainer = document.querySelector(".selected-question");

        // Access the question object using the data-survey-question attribute
        const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id.toString() === questionData);

        const questionInput = selectedQuestionContainer.querySelector(`${labelID}`);
        if (questionInput && labelType === "min") {
            questionInput.textContent = labelInput || question.scale_min_value;
        }else if (questionInput && labelType === "max") {
            questionInput.textContent = labelInput || question.scale_max_value;
        }

        question[`scale_${labelType}_label`] = labelInput;
    });
}

updateLabelInput(minLabelInputContainer, "min", "#scale-min-label");
updateLabelInput(maxLabelInputContainer, "max", "#scale-max-label");


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

// // Populate the select elements with the scale options
populateSelect(minSelect, scaleOptions);
populateSelect(maxSelect, scaleOptions);


function updateScaleInput(scaleInputContainer) {
    scaleInputContainer.addEventListener("input", function () {


        // Retrieve the selected question container from the DOM
        const selectedQuestionContainer = document.querySelector(".selected-question");

        // Access the question object using the data-survey-question attribute
        const questionData = selectedQuestionContainer.getAttribute("data-survey-question");
        const question = surveyQuestions.find(q => q.id.toString() === questionData);

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
        const question = surveyQuestions.find(q => q.id.toString() === questionData);

        // Remove the selected question block from the DOM
        selectedQuestionContainer.parentElement.removeChild(selectedQuestionContainer);

        // Also remove the corresponding structure element from the form structure
        //formStructureContainer.removeChild(structure);

        // Remove the question object from the surveyQuestions array
        const questionIndex = surveyQuestions.indexOf(question);
        if (questionIndex !== -1) {
            surveyQuestions.splice(questionIndex, 1);

                        // Update the indices after deletion
                        surveyQuestions.forEach((question, index) => {
                            question.index = index + 1; // Update indices based on the new positions
                        });
        }
        console.log(surveyQuestions);

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
        const question = surveyQuestions.find(q => q.id.toString() === questionData);

        //clone the question
        const clonedQuestion = SurveyQuestion.cloneQuestion(question);

        // Rearrange surveyQuestions array based on the new question's position
        const originalIndex = surveyQuestions.findIndex(q => q.id.toString() === question.id);
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

//==================================================================================
//==========save form================================
//==================================================================================


// Function to handle saving the survey form data
function saveSurveyForm() {
    // Retrieve survey details (title, description, etc.)
    survey.title = document.getElementById('survey_title').value;
    survey.description = document.getElementById('survey_description').value;
    survey.visibility = document.getElementById("visibility").value;
    
    survey.questions = surveyQuestions;

    const validSurvey = validateDetails(survey);

    console.log(survey);
    // Make an AJAX POST request to the backend to save the form data
    if(validSurvey){
        $.ajax({
            url: '/save-survey',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(survey),
            success: function(response) {
                // console.log('Form saved successfully:', response);
                // history.back();
            },
            error: function(xhr, status, error) {
                console.error('Error saving form:', error);
                console.log('Response Text:', xhr.responseText);
            }
            
        });
    }
}

function validateDetails(survey){
    if(!survey.title.trim()){
        alert("Please enter a title for your survey");
        return false;
    }
    if(survey.visibility === null){
        alert("Please select the visibility of your survey");
        return false;      
    }

    if (survey.questions.length === 0) {
        alert('Please add at least one question.');
        return false; // Stop execution if no questions are added
    }
    return true;
}
// Event listener for the "Save Form" button click
document.getElementById('save-survey-form').addEventListener('click', function() {
    saveSurveyForm(); // Call the function to save the survey form data
});

function initializeSurveySubmitBtn_admin(){
    $('#survey-form').onclick = null;
    $('#survey-form').on('submit', function (event) {
        event.preventDefault(); 

       validateSurvey();
    });
}