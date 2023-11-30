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

    <link rel="stylesheet" href="{{ asset('css/survey_style.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <style scoped>
        body {
            background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);
        }

        #print-layout {
            width: 80%;
            margin: auto;
            margin-bottom: 80px;
            margin-top: 40px;
        }

        #form-preview {
            /* width: 80%;
            padding: 50px 80px;
            margin: 50px auto;
            border-radius: 10px; */
            min-width: 400px;
        }

        .not-receive-response-text {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            margin: 30px;
        }
    </style>
</head>

<body>

    <button type="button" id="printBtn" onclick="convertImage()">Print</button>

    <div id="print-layout">
        <div class="row justify-content-center">
            <div class="col-10">
                <div id="form-preview">
                    <form id="survey-form">
                        <h2 id="survey_title_preview" class="text-break">{{ $survey['title'] }}</h2>
                        <p id="survey_description_preview" class="text-break">{{ $survey['description'] }}</p>
                        <div>
                            <div id="questions_container"></div>
                        </div>

                        <input type="submit" id="submit_survey_form" class="btn btn-primary m-auto d-block"
                            value="Submit">
                    </form>
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
    </script> <!-- Include noUiSlider CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

    {{-- <script src="js/survey.js"></script> --}}


    <script>
        const surveyFromDB = @json($survey);

        console.log(surveyFromDB);
        //console.log(survey123);

        $(document).ready(function() {
            const surveyFromDB = @json($survey);
            if (surveyFromDB.visibility === 'public') {
                $('#survey-form').show();
            } else {
                $('#survey-form').hide();
                $('#form-preview').append(
                    '<p class="not-receive-response-text">This survey is not receiving responses. </p> <p style="text-align:center;">Please consult with your lecturer for further action.</p>'
                );
            }
        });
    </script>
    <script src="{{ asset('js/survey_utility.js') }}"></script>
    <script src="{{ asset('js/survey_form.js') }}"></script>
    {{-- <script  src="{{ asset('js/survey_admin.js') }}"></script> --}}

    <script>

    </script>

</body>

</html>
