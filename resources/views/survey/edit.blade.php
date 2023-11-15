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

    <style>

    </style>
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
                <label for="survey_title"></label>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" id="save-survey-form" type="button">Save Form</button>
            </div>
        </div>
    </div>


    <div class="tab-style">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab"
                    href="#tab-1">Edit</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab"
                    href="#tab-2">Response ({{ $surveyResponses->count() }})</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active" role="tabpanel">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 sidebar">
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
                                            <input id="survey_title" class="input-fields" type="text"
                                                title="Survey Title" placeholder="Your Survey Title"
                                                value="{{ $survey->title }}" />
                                            <span id="title_char_counter" class="char_count">0/0</span>
                                            <b>Description</b>
                                            <label for="survey_description"></label>
                                            <textarea id="survey_description" class="input-fields" title="Survey Description" placeholder="(Optional)">{{ $survey->description }}</textarea>
                                            <span id="description_char_counter" class="char_count">0/0</span>

                                            <b>Visibility</b>
                                            <label for="visibility"></label>
                                            <select id="visibility" name="visibility" class="input-fields"
                                                title="Survey Visibility">
                                                <option value="public"
                                                    {{ $survey->visibility === 'public' ? 'selected' : '' }}>
                                                    Public</option>
                                                <option value="private"
                                                    {{ $survey->visibility === 'private' ? 'selected' : '' }}>
                                                    Private</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" role="tab">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-2"
                                            aria-expanded="false" aria-controls="accordion-1 .item-2">
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
                            <div id="form-preview">
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
                        <div class="col-md-3 sidebar">
                            <div style="background: white;">
                                <div class="accordion" role="tablist" id="accordion-1-action-block">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" role="tab">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#accordion-1-action-block .item-1"
                                                aria-expanded="true" aria-controls="accordion-1-action-block .item-1">
                                                Add Block</button>
                                        </h2>
                                        <div class="accordion-collapse collapse item-1 show" role="tabpanel">
                                            <!-- <div class="accordion-collapse collapse item-1 show" role="tabpanel"> -->
                                            <div class="accordion-body">
                                                <p class="fw-bold">Input block</p>
                                                <div id="form-builder">
                                                    <button class="btn btn-secondary"
                                                        onclick="addQuestion(QUESTION_TYPE_INT.TEXT_INPUT)"><i
                                                            class="fas fa-font favicon-with-btn"></i>Text
                                                        Input</button>
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
                                                data-bs-target="#accordion-1-action-block .item-2"
                                                aria-expanded="true" aria-controls="accordion-1-action-block .item-2">
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

                                                {{-- <div>
                                                    <b>Question Properties</b>
                                                    <label for="question_properties"></label>
                                                    <select id="question_properties" name="question_properties"
                                                        class="input-fields text-capitalize" title="Question Properties">
                                                    </select>
                                                </div> --}}

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
                </div>
            </div>
            <div id="tab-2" class="tab-pane" role="tabpanel">
                <!-- Display all survey responses in a scrollable table -->
                <div class="row justify-content-center " >
                    <p>number of response: {{ $surveyResponses->count() }}</p>

                    <div class="survey-response-style table-responsive">
                        <table border="1" class="table table-striped table-bordered table-hover ">
                            <thead class="thead-light">
                                <tr>
                                    <th>Response ID</th>
                                    <th>Survey ID</th>
                                    <th>User ID</th>
                                    <!-- Add columns for each question title -->
                                    @foreach ($surveyResponses->first()->question_responses as $questionResponse)
                                        <th>{{ $questionResponse->survey_question->title }}</th>
                                    @endforeach
                                    <!-- Add other headings as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surveyResponses as $response)
                                    <tr>
                                        <td>{{ $response->id }}</td>
                                        <td>{{ $response->survey_id }}</td>
                                        <td>{{ $response->user_id }}</td>
                                        <!-- Loop through each question response for this response -->
                                        @foreach ($response->question_responses as $questionResponse)
                                            <td>{{ $questionResponse->answers }}</td>
                                        @endforeach
                                        <!-- Add other response details as needed -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
    </script> <!-- Include noUiSlider CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js"></script>

    {{-- <script src="js/survey.js"></script> --}}


    <script>
        const surveyFromDB = @json($survey);
    </script>
    <script src="{{ asset('js/survey_utility.js') }}"></script>
    <script src="{{ asset('js/survey_form.js') }}"></script>
    <script src="{{ asset('js/survey_admin.js') }}"></script>


</body>

</html>
