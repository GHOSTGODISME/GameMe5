<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameMe5</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body{
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .quiz-body {
            background: #252525;
        }

        #summary-container {
            background: white;
            width: 500px;
            margin: auto;
            padding-top: 50px;
            padding-bottom: 20px;
        }

        #summary-general-container {
            width: 80%;
            margin: auto;
            text-align: center;
        }

        .summary-container-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 30px;
            margin-bottom: 30px;
            font-size: 18px;
            color: white;
            background: #0195FF;
            border-radius:8px;
        }

        .summary-color-block {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            flex-wrap: wrap;
        }

        .summary-container-block {
            background: yellowgreen;
            color: white;
            width: 100px;
            padding: 10px;
            margin: 10px;
            word-break: break-all;
        }

        .summary-container-block p:first-child {
            text-align: left;
            font-size: 18px;
            font-weight: 300;
            margin: 0;
        }

        .summary-container-block p:nth-child(2) {
            text-align: center;
            font-size: 32px;
            font-weight: bolder;
            margin: 0;
            display: inline-block;
        }

        .summary-container-block span {
            font-size: 20px;
        }

        #review-question-container {
            width: 90%;
            background: white;
            margin: auto;
            margin-top: 30px;
        }


        .review-question-title {
            font-size: 24px;
        }

        .review-question-container-single {
            margin: 15px;
        }

        .container-style {
            padding: 10px 20px;
            word-break: break-all;
        }

        .review-answer {
            margin-left: 30px;
        }

        .correct-ans {
            color: #35A32B;
        }

        .correct-ans-title-bg {
            border-radius: 10px 10px 0 0;
            background: #85FFB6;
        }

        .correct-ans-options-bg {
            border-radius: 0 0 10px 10px;
            background: #DCFFE4;
        }

        .incorrect-ans {
            color: #B90000;
        }

        .incorrect-ans-title-bg {
            border-radius: 10px 10px 0 0;
            background: #FF9191;
        }

        .incorrect-ans-options-bg {
            border-radius: 0 0 10px 10px;
            background: #FFC7C7;
        }

        .horizontal-line-with-text {
            margin: auto;
            width: 70%;
            height: 8px;
            border-bottom: 1px solid black;
            text-align: center;
            margin-bottom: 50px;
            margin-top: 30px;
        }

        .horizontal-line-with-text span {
            font-size: 14px;
            background-color: white;
            padding: 0 15px;
        }

        .radio-text {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        /* Styling for the custom circular icons */
        .icon-style {
            margin-right: 10px;
            margin-top: 3px;
            font-size: 18px;
            vertical-align: middle;
        }

        .default {
            color: rgb(132, 132, 132);
            /* Style for unchecked */
        }

        .correct {
            color: green;
            /* Style for correct answer */
        }

        .incorrect {
            color: red;
            /* Style for incorrect answer */
        }

        .submit-button-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .button-style {
            font-size: 16px;
            padding: 10px 40px;
            display: flex;
            background: #123956;
        }

        @media (max-width: 767px){
        .quiz-body{
        width:100%;
        }
        #summary-container{
            margin:auto;
            max-width:80vw;
        }
        #summary-general-container{
            margin:auto;
        }

        .summary-container-row {
            padding: 8px 30px;
            margin-bottom: 15px;
            font-size: 12px;
            border-radius:8px;
        }

        .summary-container-block {
            background: yellowgreen;
            color: white;
            width: 60px;
            padding: 10px;
            word-break: break-all;
        }

        .summary-container-block p:first-child {
            text-align: left;
            font-size: 10px;
            font-weight: 300;
            margin: 0;
        }

        .summary-container-block p:nth-child(2) {
            text-align: center;
            font-size: 14px;
            font-weight: bolder;
            margin: 0;
            display: inline-block;
        }

        .summary-container-block span {
            font-size: 14px;
        }

        .review-question-title {
            font-size: 16px;
        }

        p{
            font-size:12px;
        }

        .btn{
            font-size: 12px;
        }

        .container-style{
            font-size:12px;
        }

        .horizontal-line-with-text span{
            font-size:10px;   
        }

        .horizontal-line-with-text {
            width:100%;
        }

    }
    </style>

</head>

@section('quizTitle',$quizTitle)

<body>
    @include('Layout/quiz_summary_header')
    <div class="quiz-body">
        <div id="summary-container">
            <div id="summary-general-container">
                <h2>Summary</h2>
                <p id="quiz-username">Username</p>

                <div class="summary-container-row">
                    <span>Rank</span>
                    <span id="quiz-rank">0/0</span>
                </div>
                <div class="summary-container-row">
                    <span>Score</span>
                    <span id="quiz-score">0</span>
                </div>
                <div class="summary-container-row">
                    <span>Accuracy</span>
                    <span id="quiz-accuracy">0%</span>
                </div>

                <div class="summary-color-block">
                    <div class="summary-container-block" style="background: #76C893;">
                        <p class="">Correct</p>
                        <p id="quiz-correct">0</p>
                    </div>
                    <div class="summary-container-block" style="background: #D05252;">
                        <p class="">Incorrect</p>
                        <p id="quiz-incorrect">0</p>
                    </div>

                    <div class="summary-container-block" style="background: #168AAD;">
                        <p class="">Avg Time</p>
                        <p id="quiz-avg-time">0</p>
                        <span>s</span>
                    </div>
                </div>

                <div>
                    <hr>
                    <p>This summary has already been sent to your email. Please wait for a moment.</p>
                    <a href="{{ route('generate-pdf', ['userId' => $userId, 'sessionId' => $sessionId, 'quizId' => $quizId]) }}"
                        class="btn btn-primary">
                        Haven't received? Download it now</a>
                    <br>
                    <hr>
                </div>

                <div>
                    <a href="{{ url('/stud_homepage') }}" class="btn btn-primary">Back to Homepage</a>
                    <hr>
                </div>

            </div>

            <div id="review-question-container">

                <p class="review-question-title">Review Questions</p>

                <div id="quiz-container"></div>


                <div class="horizontal-line-with-text">
                    <span> You have reach to the end of the summary </span>
                </div>

            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script>
        function clearLocalStorageWithPrefix(prefix) {
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                if (key.startsWith(prefix)) {
                    localStorage.removeItem(key);
                }
            }
        }
        clearLocalStorageWithPrefix('quiz:');

        let questionsData = [];
        let userResponseDetails = [];
        let userResponses = {};
        let correctness = {};

        async function fetchQuizDetails(userId, sessionId, quizId) {
            try {
                const response = await fetch(`/user/${userId}/session/${sessionId}/quiz/${quizId}/details`);
                if (!response.ok) {
                    throw new Error('Failed to fetch quiz details');
                }

                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error fetching quiz details:', error.message);
                return null;
            }
        }

        async function getQuizSummaryDetails() {
            // Fetch the quiz details
            const userId = @json($userId);
            const sessionId = @json($sessionId);
            const quizId = @json($quizId);
            const quizDetails = await fetchQuizDetails(userId, sessionId, quizId);

            if (quizDetails) {
                const {
                    quiz,
                    quizResponse,
                    totalParticipants,
                    rank
                } = quizDetails;


                userResponseDetails = quizResponse.quiz_response_details;
                const {
                    accuracy,
                    correct_answer_count,
                    incorrect_answer_count,
                    total_points,
                    average_time
                } = quizResponse;

                document.getElementById('quiz-username').textContent = quizResponse.username;
                document.getElementById('quiz-rank').textContent = `${rank}/${totalParticipants}`;
                document.getElementById('quiz-score').textContent = total_points;
                document.getElementById('quiz-accuracy').textContent = `${accuracy}%`;
                document.getElementById('quiz-correct').textContent =
                    `${correct_answer_count}/${correct_answer_count + incorrect_answer_count}`;
                document.getElementById('quiz-incorrect').textContent =
                    `${incorrect_answer_count}/${correct_answer_count + incorrect_answer_count}`;
                document.getElementById('quiz-avg-time').textContent = `${average_time}`;


                questionsData = quiz.quiz_questions;
                userResponseDetails.forEach(detail => {
                    const {
                        question_id,
                        user_response,
                        correctness: isCorrect
                    } = detail;
                    userResponses[question_id] = user_response;
                    correctness[question_id] = isCorrect;
                });

                generateQuizSummaryDetails();
            } else {
                console.error('Failed to fetch quiz details');
            }


        }

        function generateInputHTML(singleAnswerFlag, option, isChecked, isCorrect) {
            const inputType = singleAnswerFlag === 1 ? "circle" : "square";
            const iconType = singleAnswerFlag === 0 && isChecked ? "check-square" : inputType;
            const checkedClass = isChecked ? "checked" : "default";
            const correctnessClass = isCorrect ? "correct" : "incorrect-ans";
            let answerText = '';

            if (isChecked) {
                answerText = isCorrect ? `<span class="review-answer correct-ans"> Your Answer</span>` :
                    `<span class="review-answer incorrect-ans"> Your Answer</span>`;
            } else if (!isChecked && isCorrect) {
                answerText = `<span class="review-answer correct-ans"> Correct Answer</span>`;
            }

            return `
                <p class="radio-text">
                  <i class="fas fa-circle icon-style ${checkedClass} ${correctnessClass} "></i> ${option}
                  ${answerText}
                </p>
              `;
        }

        function generateQuizSummaryDetails() {
            const quizContainer = $("#quiz-container");
            questionsData.forEach((question, index) => {
                const {
                    id,
                    title,
                    options,
                    correct_ans,
                    single_ans_flag,
                    type
                } = question;


                let userAnswers = userResponses[id] || null; // User's selected answers (array)
                if (userAnswers != null) {
                    userAnswers = JSON.parse(userAnswers);
                }


                const isCorrect = correctness[id];

                const titleBgClass = isCorrect ? "correct-ans-title-bg" : "incorrect-ans-title-bg";
                const optionsBgClass = isCorrect ? "correct-ans-options-bg" : "incorrect-ans-options-bg";

                const questionIndex = index + 1; // Question index (starting from 1)

                let questionHTML = '';
                if (type === 0 || type === 1) {
                    // For radio or checkbox type questions
                    questionHTML = `
        <div class="review-question-container-single">
          <div class="container-style ${titleBgClass}">
            ${questionIndex}. ${title}
          </div>
          <div class="container-style ${optionsBgClass}">
            ${options.map((option) => {
              const optionLowerCase = option.toLowerCase();
              const isChecked = userAnswers?.map(ans => ans?.toLowerCase()).includes(optionLowerCase);
              const isOptionCorrect = correct_ans.map(ans => ans.toLowerCase()).includes(optionLowerCase);
              return generateInputHTML(single_ans_flag, option, isChecked, isOptionCorrect, type);
            }).join("")}
          </div>
        </div>
      `;
                } else if (type === 2) {
                    // For text input type questions
                    let answerDetails = '';
                    if (userAnswers.length > 0 && userAnswers[0] !== undefined && userAnswers[0] !== null &&
                        userAnswers[0].trim() !== '') {
                        const answerIsCorrect = userAnswers[0].toLowerCase() === correct_ans[0].toLowerCase();
                        const answerClass = answerIsCorrect ? "correct-ans" : "incorrect-ans";

                        answerDetails = `
          <p>${userAnswers[0]} <span class="review-answer ${answerClass}"> Your Answer</span></p>
        `;
                    } else {
                        // If user did not enter any input
                        answerDetails = `
          <p>No answer provided</p>
        `;
                    }

                    const correctAnswerSection = !isCorrect ?
                        `
          <hr>
          <span class="correct-ans">Correct Answer: </span>
          <p>${correct_ans[0]}</p>
        ` :
                        '';

                    questionHTML = `
        <div class="review-question-container-single">
          <div class="container-style ${titleBgClass}">
            ${questionIndex}. ${title}
          </div>
          <div class="container-style ${optionsBgClass}">
            ${answerDetails}
            ${correctAnswerSection}
          </div>
        </div>
      `;
                }

                quizContainer.append(questionHTML);
            });
        }

        getQuizSummaryDetails();
    </script>


</body>

</html>
