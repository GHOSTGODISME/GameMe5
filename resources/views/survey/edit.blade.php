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
        .header-container {
            height: 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(90deg, #13C1B7 0%, #87DFA8 100%);
            color: white;
            padding: 30px;
            flex-wrap: wrap;
        }

        .header-quiz-title {
            font-weight: bold;
            font-size: 32px;
        }
    </style>
</head>

<body style="background: whitesmoke;">
    <div class="header-container">
        <a href="{{ url('/lect_homepage') }}"><img class="logo" src="{{ asset('img/logo_header.png') }}" alt="Logo"></a>
        <!-- <div class="favicon-with-text">
            <i class="fas fa-chevron-left"></i>
            <span>Back</span>
        </div> -->

        <div class="">
            <!-- <h2 >Quiz Title</h2> -->
            <div class="surveyDetailsContainer" id="">
                <span id="surveyDetailsTrigger" style="cursor: pointer;">
                    <!-- Added this span for styling and cursor -->
                    <span id="quizDetailsTitle" style="cursor: pointer;"
                        class="title-style-header h2 quiz-title-display survey-title-text"
                        id="survey_title_header">Title</span>
                    <a><i class="fa-regular fa-pen-to-square" style="font-size: 22px; margin-left: 10px;"></i></a>
                </span>
            </div>
        </div>

        <button class="btn btn-dark header-save-btn" id="save-survey-form" type="button">Save Survey</button>
    </div>


    <div class="tab-style" style="padding-top: 40px;">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab"
                    href="#tab-1">Edit</a></li>

            @if (isset($survey->id))
                <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab"
                        href="#tab-2">Response ({{ $surveyResponses->count() }})</a></li>
            @endif
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
                                            <input id="survey_title"
                                                class="input-fields form-control survey-title-input" type="text"
                                                title="Survey Title" placeholder="Your Survey Title"
                                                value="{{ $survey->title }}" />
                                            {{-- <span id="title_char_counter" class="char_count title_cc">0/0</span> --}}
                                            <b>Description</b>
                                            <label for="survey_description"></label>
                                            <textarea id="survey_description" class="input-fields form-control survey-description-input" title="Survey Description"
                                                placeholder="(Optional)">{{ $survey->description }}</textarea>
                                            {{-- <span id="description_char_counter"
                                                class="char_count description_cc">0/0</span> --}}

                                            <b>Visibility</b>
                                            <label for="visibility"></label>
                                            <select id="visibility" name="visibility"
                                                class="input-fields form-control survey_visibility_input"
                                                title="Survey Visibility">
                                                <option value="public"
                                                    {{ $survey->visibility === 'public' ? 'selected' : '' }}>
                                                    Public (Receive response)</option>
                                                <option value="private"
                                                    {{ $survey->visibility === 'private' ? 'selected' : '' }}>
                                                    Private (Not receive response)</option>
                                            </select>

                                            @if (isset($survey->id))
                                                <b style="display: block;">Survey Link</b>
                                                <span id="copyLink" style="cursor: pointer;">
                                                    {{-- <p style="display: inline;">randome link </p> --}}
                                                    <a href="{{ route('get-survey-response', ['id' => $survey->id]) }}"
                                                        id="surveyLink" target="_blank"
                                                        style="word-wrap: break-word">{{ route('get-survey-response', ['id' => $survey->id]) }}</a>


                                                    <i class="fa fa-copy"></i>
                                                </span>
                                                
                                             
                                                    <b style="display: block;margin-top:10px;">Assign Class</b>
                                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignClassModal" style="margin-top:5px;">
                                                        Assign to Class
                                                    </button>
                                              

                                            @endif
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
                                    <h2 id="survey_title_preview" class="text-break survey-title-text">
                                        {{ $survey->title }}</h2>
                                    <p id="survey_description_preview" class="text-break survey-description-text">
                                        {{ $survey->description }}</p>
                                    <div>
                                        <div id="questions_container"></div>
                                    </div>
                                    <input type="button" class="btn btn-primary m-auto d-block" value="Submit"
                                        onclick=validateDetails(survey)>
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
                                                        onclick="addQuestion(QUESTION_TYPES.TEXT_INPUT.value)"><i
                                                            class="fas fa-font favicon-with-btn"></i>Text
                                                        Input</button>
                                                    <button class="btn btn-secondary"
                                                        onclick="addQuestion(QUESTION_TYPES.MULTIPLE_CHOICE.value)"><i
                                                            class="fas fa-list-ul favicon-with-btn"></i>Multiple
                                                        Choice</button>
                                                    <button class="btn btn-secondary "
                                                        onclick="addQuestion(QUESTION_TYPES.CHECKBOX.value)"><i
                                                            class="far fa-check-square favicon-with-btn"></i>Checkbox</button>
                                                    <!-- <button class="btn btn-secondary d-none"
                                                        onclick="addQuestion(QUESTION_TYPE_INT.DROPDOWN)">Dropdown
                                                        List</button> -->
                                                    <button class="btn btn-secondary"
                                                        onclick="addQuestion(QUESTION_TYPES.SCALE.value)"><i
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

                                                <!-- {{-- <div>
                                                    <b>Question Properties</b>
                                                    <label for="question_properties"></label>
                                                    <select id="question_properties" name="question_properties"
                                                        class="input-fields text-capitalize" title="Question Properties">
                                                    </select>
                                                </div> --}} -->

                                                <div id="compoenent_edit">

                                                    <div id="question_title_container">
                                                        <b>Question Title</b>
                                                        <textarea id="question_title" class="input-fields form-control" title="Question Title" placeholder="Question Title"></textarea>
                                                    </div>

                                                    <div id="question_description_container">
                                                        <b>Description</b>
                                                        <textarea id="question_description" class="input-fields form-control" title="Description" placeholder="Description"></textarea>
                                                    </div>

                                                    <hr>

                                                    <div id="text_edit_container">
                                                        <div id="placeholder_container">
                                                            <b>Placeholder</b>
                                                            <textarea id="question_placeholder" class="input-fields form-control" title="Placeholder" placeholder="Placeholder"></textarea>
                                                        </div>

                                                        <div id="pre_filed_container">
                                                            <b>Pre-filed value</b>
                                                            <textarea id="question_prefiled_value" class="input-fields form-control" title="Pre-filed value"
                                                                placeholder="Pre-filed value"></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- reserve for other possible usage -->
                                                    <div id="input_option_container">
                                                        <b>Input Option</b>
                                                        <!-- <textarea id="question_input_option" class="input-fields form-control" title="Input Option"
                                                            placeholder="Input Option"></textarea> -->

                                                        <!-- <label for="input_option_contentholder"></label> -->
                                                        <textarea id="input_option_contentholder" class="input-fields form-control" title="Input Option"
                                                            placeholder="Input Option"></textarea>
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
                                                                            class="scale-input-fields form-control"></select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label><span>Max: </span>
                                                                        <select id="max_num"
                                                                            class="scale-input-fields form-control"></select>

                                                                </div>
                                                            </div>
                                                            <div>
                                                                <span>Min Label: </span>
                                                                <input type="text" id="min_label_containholder"
                                                                    class="input-fields form-control"
                                                                    title="Min Label" placeholder="(Optional)"
                                                                    value="">
                                                            </div>
                                                            <div>
                                                                <span>Max Label: </span>
                                                                <input type="text" id="max_label_containholder"
                                                                    class="input-fields form-control"
                                                                    title="Max Label" placeholder="(Optional)"
                                                                    value="">
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

            @if (isset($survey->id))
                <div id="tab-2" class="tab-pane" role="tabpanel">
                    <!-- Display all survey responses in a scrollable table -->

                    @if (count($surveyResponses) > 0)
                        <div class="row justify-content-center ">
                            <p>Number of response: {{ $surveyResponses->count() }}</p>

                            <div class="survey-response-style table-responsive">
                                <table style="border:1" class="table table-striped table-bordered table-hover ">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Responded Time</th>
                                            @foreach ($uniqueQuestions as $question)
                                                <th>{{ $question->title }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($surveyResponses as $response)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $response->user->name }}</td>
                                                <td>{{ $response->user->email }}</td>
                                                <td>{{ $response->created_at }}</td>
                                                <!-- Loop through each question response for this response -->
                                                @foreach ($response->surveyResponseQuestions as $questionResponse)
                                                    <td>
                                                        @if (is_array($questionResponse->answers))
                                                            {{ implode(', ', $questionResponse->answers) }}
                                                        @else
                                                            {{ $questionResponse->answers }}
                                                        @endif
                                                    </td>
                                                @endforeach

                                                <!-- Add other response details as needed -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div style="margin: 50px 0; display: flex; justify-content: flex-end;">
                            <a href="{{ url('/export-survey-response/' . $survey->id) }}" class="btn btn-dark">Export to Excel</a>

                        </div>

                    @else
                        <p>No records found.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>



    <!-- survey details modal -->
    <div class="modal fade" id="surveyModal" tabindex="-1" aria-labelledby="surveyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content" style="padding: 25px;">
                <!-- Modal header -->

                <div class="modal-header">
                    <h5 class="modal-title" id="surveyModalLabel">Survey Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body m-3">
                    <div>
                        <b class="required">Title</b>
                        <label for="survey_title"></label>
                        <input id="survey_title_modal" class="input-fields form-control survey-title-input"
                            type="text" title="Survey Title" placeholder="Your Survey Title"
                            value="{{ $survey->title }}" />
                        {{-- <span id="title_char_counter" class="char_count title_cc">0/0</span> --}}
                    </div>
                    <div>
                        <b>Description</b>
                        <label for="survey_description"></label>
                        <textarea id="survey_description_modal" class="input-fields form-control survey-description-input"
                            title="Survey Description" placeholder="(Optional)">{{ $survey->description }}</textarea>
                        {{-- <span id="description_char_counter" class="char_count description_cc">0/0</span> --}}
                    </div>
                    <div>
                        <b>Visibility</b>
                        <label for="visibility"></label>
                        <select id="visibility_modal" name="visibility"
                            class="input-fields form-control survey_visibility_input" title="Survey Visibility">
                            <option value="public" {{ $survey->visibility === 'public' ? 'selected' : '' }}>
                                Public (Receive response)</option>
                            <option value="private" {{ $survey->visibility === 'private' ? 'selected' : '' }}>
                                Private (Not receive response)</option>
                        </select>
                    </div>
                    @if (isset($survey->id))
                        <p class="m-0"><b>Survey Link</b></p>
                        <span id="copyLink" style="cursor: pointer;">
                            {{-- <p style="display: inline;">randome link </p> --}}
                            <a href="{{ route('get-survey-response', ['id' => $survey->id]) }}" id="surveyLink"
                                target="_blank"
                                style="word-wrap: break-word">{{ route('get-survey-response', ['id' => $survey->id]) }}</a>
                            <i class="fa fa-copy"></i>
                        </span>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveSurveyDetailsBtn">Save</button>
                </div>
            </div>
        </div>
    </div>



      <!-- assign class Modal -->
<div class="modal fade" id="assignClassModal" tabindex="-1" role="dialog" aria-labelledby="assignClassModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignClassModalLabel">Assign to Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignClassForm" action="{{ route('assign_class_survey') }}" method="post">
                    @csrf
                    
                    <div class="form-group">
                        <label for="class">Select Class:</label>
                        <select class="form-control" id="class" name="class_id" required>
                            <!-- Options will be dynamically added using JavaScript -->
                        </select>
                    </div>

                     <!-- Your input field -->
                    <input type="hidden" name="survey_id" id="survey_id" value={{$survey->id}}>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Assign Class</button>
                    </div>
                </form>
                
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
        console.log(surveyFromDB);
    </script>
    <script src="{{ asset('js/survey_utility.js') }}"></script>
    <script src="{{ asset('js/survey_form.js') }}"></script>
    <script src="{{ asset('js/survey_admin.js') }}"></script>

    <script>
        $(".surveyDetailsContainer").click(function() {
            $("#surveyModal").modal("show");
        });

        $('#saveSurveyDetailsBtn').click(function() {
            saveSurveyDetails(survey);

            // Add your logic to save quiz details, including the new content (visibility) here
            const validDetails = validateSurveyDetails(survey);

            if (validDetails) {
                $("#surveyModal").modal("hide");

                $('.survey-title-input').val(survey.title);
                $('.survey-title-text').text(survey.title);
                $('.survey-description-input').val(survey.description);
                $('.survey-description-text').text(survey.description);
                $('.survey_visibility_input').val(survey.visibility ?? "public");
            }

        });

        function saveSurveyDetails(survey) {
            var surveyTitle = $('#survey_title_modal').val().trim();
            var surveyDescription = $('#survey_description_modal').val().trim();
            var visibility = $("#visibility_modal").val();

            survey.title = surveyTitle;
            survey.description = surveyDescription;
            survey.visibility = visibility;
            console.log("visibility " + visibility);
        }

        function validateSurveyDetails(survey) {
            if (!survey.title.trim()) {
                alert("Please enter a title for your survey");
                return false;
            }
            if (survey.visibility === null) {
                alert("Please select the visibility of your survey");
                return false;
            }
            return true;
        }

        // jQuery to handle click event on the span
        $('#copyLink').click(function() {
            // Get the text within the <p> tag
            // var linkText = $(this).find('p').text().trim();
            var linkText = $('#surveyLink').text();
            // Create a temporary input element to copy the text
            var tempInput = $('<input>');
            $('body').append(tempInput);

            // Set the input value to the link text and select it
            tempInput.val(linkText).select();

            // Copy the selected text to clipboard
            document.execCommand('copy');

            // Remove the temporary input
            tempInput.remove();

            // Add some visual feedback or a message to indicate the text has been copied
            // For example, change the text or style of the span to show it's copied
            // $(this).find('p').text('Link copied!');
            // Additionally, you can change the icon or add a tooltip to indicate the copy action
            $(this).find('i').removeClass('fa-copy').addClass('fa-check'); // Example: Changing icon to checkmark
            // Reset the text and icon after a short delay (optional)
            setTimeout(function() {
                // $('#copyLink').find('p').text('random link');
                $('#copyLink').find('i').removeClass('fa-check').addClass('fa-copy');
            }, 2000); // Change back to original text after 2 seconds (adjust as needed)
        });

        document.addEventListener('DOMContentLoaded', function () {

// Fetch lecturerClasses using AJAX
fetch('{{ route('get_lecturer_classes') }}')
    .then(response => response.json())
    .then(data => {
        // Populate options in the class selection dropdown
        const classSelect = document.getElementById('class');
       
        if (classSelect) {
            data.lecturerClasses.forEach(classDetail => {
                const option = document.createElement('option');
                option.value = classDetail.class.id;
                option.textContent = classDetail.class.name;
                classSelect.appendChild(option);
            });
            
        }
    })

    .catch(error => console.error('Error fetching lecturerClasses:', error));
});

    </script>
</body>

</html>
