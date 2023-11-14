<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>fyp</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/survey_style.css') }}">


</head>

<body>
    <div class="container ">
        <div class="row header">
            <div class="col-md-4 text-start favicon-with-text">
                <i class="fas fa-chevron-left"></i>
                <span>Back</span>
            </div>

            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <h2 class="text-center text-black-50 title-style-header" id="survey_title_header">Title</h2>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" type="button">view
                    response&nbsp;</button>
                    <button class="btn btn-primary" id="save-survey-form" type="button">Save Form</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="accordion" role="tablist" id="accordion-1">
                    <div class="accordion-item">
                        <h2 class="accordion-header" role="tab">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#accordion-1 .item-1" aria-expanded="true"
                                aria-controls="accordion-1 .item-1">
                                Information</button>
                        </h2>
                        <div class="accordion-collapse collapse show item-1" role="tabpanel">
                            <div class="accordion-body">
                                <b class="required">Survey Title</b>
                                <label for="survey_title"></label>
                                <input id="survey_title" class="input-fields" type="text" title="Survey Title" value="{{ $survey->title }}" />
                                <span id="title_char_counter" class="char_count">0/0</span>
                                <b>Description</b>
                                <label for="survey_description"></label>
                                <textarea id="survey_description" class="input-fields" title="Survey Description" placeholder="(Optional)">{{ $survey->description }}</textarea>
                                <span id="description_char_counter" class="char_count">0/0</span>

                                <b>Visibility</b>
                                <label for="visibility"></label>
                                <select id="visibility" name="visibility" class="input-fields"
                                    title="Survey Visibility">
                                    <option value="public" {{ $survey->visibility === 'public' ? 'selected' : '' }}>Public</option>
                                    <option value="private" {{ $survey->visibility === 'private' ? 'selected' : '' }}>Private</option>
                                                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" role="tab">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#accordion-1 .item-2" aria-expanded="false"
                                aria-controls="accordion-1 .item-2">
                                Form Structure</button>
                        </h2>
                        <div class="accordion-collapse collapse item-2" role="tabpanel">
                            <div class="accordion-body">
                                <p> <small class="form-text text-muted">
                                        This section shows the form structure.
                                        You may drag and drop the structure to change the arrangement.
                                    </small></p>
                                <div id="form_structure" class="sortable"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- <div>
                    <h1>Survey Title</h1>
                    <p>Survey Description</p> -->

                <!-- <div class="question-style">
                        <!== this question type allow the user to enter text input ==>
                        <!== should allow the admin to decide to receive short answer or long answer ==>
                        <p class="question-title">text input question</p>
                        <p class="fw-light">description test</p>
                        <input type="text" id="ti" class="question-input" placeholder="text input" value="" />
                        <label for="text-input" class="visually-hidden"></label>
                    </div>

                    <!== <div class="question-style">
                        <!== this question type allow the user to create multiple option ==>
                        <!== only single selection is allowed ==>
                        <p class="question-title">multiple choice question</p>
                        <p class="fw-light">description test</p>
                        <label><input type="radio" id="mc-question-option1" name="mc-question" value="Option 1">
                            Please enter the option(s)</label>
                    </div>
                    

                    <div class="question-style">
                        <!== this question type allow the user to create multiple option  ==>
                        <!== allow multiple selection ==>
                        <p class="question-title">checkbox question</p>
                        <p class="fw-light">description test</p>
                        <label>
                            <input type="checkbox" id="cb-question-option1" name="cb-question[]" value="Option 1">
                            Please enter the option(s)</label>
                    </div> -->


                <!-- <div class="question-style">
                        <!== this question type allow the user to select the scale  ==>
                        <!== will ask for range, min 0 max 10 ==>
                        <!== and representation of min max, like not interested, very interested ==>
                        <p class="question-title">scale question</p>
                        <p class="fw-light">description test</p>
                        1 to 5 <br>
                        1: not interested <br>
                        5: very interested <br>
                        <input type="range" id="scale-question" name="scale-question-${questionCount}" min="1" max="5">
                    </div>

                </div> -->

                <div id="form-preview">
                    <h6>Preview | View Response (tbc)</h6>
                    <form id="survey-form">
                        <h2 id="survey_title_preview" class="text-break"></h2>
                        <p id="survey_description_preview" class="text-break">Survey Description</p>
                        <div>
                            <div id="questions_container"></div>
                        </div>
                        <input type="submit" class="btn btn-primary m-auto d-block" value="Submit">
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <div style="background: white;">
                    <div class="accordion" role="tablist" id="accordion-1-action-block">
                        <div class="accordion-item">
                            <h2 class="accordion-header" role="tab">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-1-action-block .item-1" aria-expanded="true"
                                    aria-controls="accordion-1-action-block .item-1">
                                    Add Block</button>
                            </h2>
                            <div class="accordion-collapse collapse item-1 show" role="tabpanel">
                                <!-- <div class="accordion-collapse collapse item-1 show" role="tabpanel"> -->
                                <div class="accordion-body">
                                    <p class="fw-bold">Input block</p>
                                    <div id="form-builder">
                                        <button class="btn btn-secondary"
                                            onclick="addQuestion(QUESTION_TYPE_INT.TEXT_INPUT)"><i
                                                class="fas fa-font favicon-with-btn"></i>Text Input</button>
                                        <button class="btn btn-secondary"
                                            onclick="addQuestion(QUESTION_TYPE_INT.MULTIPLE_CHOICE)"><i
                                                class="fas fa-list-ul favicon-with-btn"></i>Multiple
                                            Choice</button>
                                        <button class="btn btn-secondary "
                                            onclick="addQuestion(QUESTION_TYPE_INT.CHECKBOX)"><i
                                                class="far fa-check-square favicon-with-btn"></i>Checkbox</button>
                                        <!-- <button class="btn btn-secondary d-none"
                                            onclick="addQuestion(QUESTION_TYPE_INT.DROPDOWN)">Dropdown
                                            List</button> -->
                                        <button class="btn btn-secondary"
                                            onclick="addQuestion(QUESTION_TYPE_INT.SCALE)"><i
                                                class="fas fa-exchange-alt favicon-with-btn"></i>Scale</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" id="edit_block_section">
                            <h2 class="accordion-header" role="tab">
                                <!-- <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-1-action-block .item-2" aria-expanded="false"
                                    aria-controls="accordion-1-action-block .item-2"> -->
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-1-action-block .item-2" aria-expanded="true"
                                    aria-controls="accordion-1-action-block .item-2">
                                    Edit Block Info</button>
                            </h2>
                            <div class="accordion-collapse collapse item-2 show" role="tabpanel">
                                <div class="accordion-body">

                                    <p class="fw-bold">Remove & Duplicate Block</p>
                                    <div class="remove_duplicate_row">
                                        <button id="remove_block" class="btn btn-secondary"><i
                                                class="far fa-trash-alt favicon-with-btn"></i>Remove</button>
                                        <button id="duplicate_block" class="btn btn-secondary"><i
                                                class="far fa-copy favicon-with-btn"></i>Duplicate</button>
                                    </div>

                                    <hr>
                                    <div>
                                        <b>Question Properties</b>
                                        <label for="question_properties"></label>
                                        <select id="question_properties" name="question_properties"
                                            class="input-fields text-capitalize" title="Question Properties">
                                        </select>
                                    </div>

                                    <div id="compoenent_edit">

                                        <div id="question_title_container">
                                            <b>Question Title</b>
                                            <textarea id="question_title" class="input-fields" title="Question Title" placeholder="Question Title"></textarea>
                                        </div>

                                        <div id="question_description_container">
                                            <b>Description</b>
                                            <textarea id="question_description" class="input-fields" title="Description" placeholder="Description"></textarea>
                                        </div>

                                        <hr>

                                        <div id="text_edit_container">
                                            <div id="placeholder_container">
                                                <b>Placeholder</b>
                                                <textarea id="question_placeholder" class="input-fields" title="Placeholder" placeholder="Placeholder"></textarea>
                                            </div>

                                            <div id="pre_filed_container">
                                                <b>Pre-filed value</b>
                                                <textarea id="question_prefiled_value" class="input-fields" title="Pre-filed value" placeholder="Pre-filed value"></textarea>
                                            </div>
                                        </div>

                                        <!-- reserve for other possible usage -->
                                        <div id="input_option_container">
                                            <b>Input Option</b>
                                            <!-- <textarea id="question_input_option" class="input-fields" title="Input Option" placeholder="Input Option"></textarea> -->

                                            <!-- <label for="input_option_contentholder"></label> -->
                                            <textarea id="input_option_contentholder" class="input-fields" title="Input Option" placeholder="Input Option"></textarea>
                                        </div>

                                        <!-- <div id="input_option_container">
                                            <b>Input Options</b>
                                            <div id="input_options">
                                                <!== Input options will be added dynamically here ==>
                                            </div>
                                            <!== <button id="add_input_option">Add Option</button> ==>
                                        </div> -->

                                        <div id="scale-container">
                                            <b>Scale Edit</b>
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label><span>Min: </span>
                                                            <select id="min_num"
                                                                class="scale-input-fields"></select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><span>Max: </span>
                                                            <select id="max_num"
                                                                class="scale-input-fields"></select>

                                                    </div>
                                                </div>
                                                <div>
                                                    <span>Min Label: </span>
                                                    <input type="text" id="min_label_containholder"
                                                        class="input-fields" title="Min Label"
                                                        placeholder="(Optional)" value="">
                                                </div>
                                                <div>
                                                    <span>Max Label: </span>
                                                    <input type="text" id="max_label_containholder"
                                                        class="input-fields" title="Max Label"
                                                        placeholder="(Optional)" value="">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card"></div>
        <div class="card"></div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <link rel="stylesheet"
            href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script> <!-- Include noUiSlider CSS and JavaScript -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js"></script>

        {{-- <script src="js/survey.js"></script> --}}


        <script>

            const surveyFromDB = @json($survey);
            //console.log(survey123);

            </script>
        <script  src="{{ asset('js/survey.js') }}"></script>


</body>

</html>
