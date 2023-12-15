<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- <link rel="stylesheet" href="play-quiz-style.css"> -->

    <style scoped>
        body {
            background: linear-gradient(90deg, #13C1B7 0%, #87DFA8 100%);
        }

        table {
            margin-top: 10px;
            border-collapse: separate;
            border-spacing: 0 5px;
        }

        thead {
            background: #232946;
            color: white;
            font-size: 18px;
        }

        tbody tr {
            background: #01BCFF;
            color: white;
            font-size: 16px;

        }

        tbody tr:hover {
            background: #0179FF;
            color: white;
            font-size: 16px;
        }


        table th:nth-child(1) {
            text-align: center;
        }

        table th:nth-child(3) {
            text-align: center;
        }

        table td:nth-child(3) {
            text-align: center;
        }

        th,
        td {
            padding: 15px;
            word-break: break-all;
        }

        .header-style {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin: 0 50px;
            height: 125px;
        }

        .tab-container {
            width: 80%;
            margin: 50px auto;
            padding: 50px;
            background: whitesmoke;
            border: 3px solid black;
            border-radius: 10px;
        }

        .table-container {
            margin-top: 20px;
        }

        .question-summary-container {
            border: 1px solid black;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 5px;
            background: white;
        }

        .question-summary-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            text-align: center;
            padding: 10px 0;
        }

        .question-summary-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            text-align: center;
        }

        .question-summary-modal-text {
            display: flex;
            justify-content: center;
            align-items: center;
            background: whitesmoke;
            border-radius: 10px;
            /* min-height: 300px; */
            height: calc((100% - 80px) / 2);
            font-size: 24px;
            margin-top: 20px;
            word-break: break-word;
            text-overflow: ellipsis;
        }

        .question-summary-modal-option {
            padding: 20px 16px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-direction: row;
            height: calc((100% - 80px) / 2);
            margin: 15px 0;
            padding: 10px;
        }

        .question-summary-modal-option :first-child {
            margin-left: 0;
        }

        .question-summary-modal-option :last-child {
            margin-right: 0;
        }

        .option-container {
            margin: 10px;
            height: 100%;
            width: 100%;
            text-align: center;
            border-radius: 10px;
            background: whitesmoke;
            display: flex;
            flex-direction: column;
        }

        .option-text {
            width: inherit;
            height: inherit;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            word-break: break-word;
        }

        .option-num-player {}

        .question-summary-modal-text-input {
            padding: 20px 16px;
            margin: 15px 0;
            padding: 10px;
            background: whitesmoke;
            border-radius: 10px;
        }

        .question-summary-modal-text-input .text-input-header {
            font-weight: bold;
        }

        .student-ans-text-container {
            max-height: 200px;
            overflow: auto;
            margin: 10px 20px;
        }

        .student-ans-text-container .student-ans-text-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        #code-copy-container {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            text-align: center;
        }

        .incorrect-option {
            background-color: #FF9191;
        }

        .correct-option {
            background-color: #85FFB6;
        }
    </style>
</head>

<body>
    <!-- header -->
    <div class="header-style">
        <div><img src="{{ asset('img/logo_header.png') }}" /></div>
        <div id="code-copy-container" style="cursor: pointer;">
            <span id="codePlaceholder"></span>
            <span id="codeCopyIcon" class="fas fa-copy"></span>
        </div>
        <div><a id="endBtn" class="btn btn-dark">End Session</a></div>
    </div>

    <div>
        <div class="tab-container">
            <ul class="nav nav-tabs " role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab"
                        href="#tab-1">Leaderboard</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab"
                        href="#tab-2">Questions</a></li>
            </ul>

            <div class="tab-content">
                <div id="tab-1" class="tab-pane active" role="tabpanel">
                    <div class="table-container">
                        <small>Participants count: <span id="participantCount">0</span></small>
                        <table class="" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 25%;">Rank</th>
                                    <th scope="col" style="width: 50%;">Name</th>
                                    <th scope="col" style="width: 25%;">Score</th>
                                    <th scope="col" class="d-none">User ID </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane " role="tabpanel">

                    <div style="padding: 20px;" id="questionsContainer">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="quizSummaryModal"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content " style="padding: 25px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Question 1</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- header -->
                    <div class="question-summary-header">
                        <div>Average Time Taken: <span id="averageTimeTaken-modal"></span></div>
                        <div>Blank Count: <span id="blankCount-modal"></span></div>
                        <div>Accuracy: <span id="accuracyPercentage-modal"></span>%</div>
                    </div>

                    <!-- question title text-->
                    <div class="question-summary-modal-text">
                        <span id="questionTitle-modal">title</span>
                    </div>


                    <div class="question-summary-modal-option">
                        <!-- Question Options -->
                        <!-- Option 1 -->
                        <div class="option-container">
                            <div class="option-text">Option 1</div>
                            <div class="option-num-player">0 players</div>
                        </div>
                        <!-- Repeat for other options -->
                    </div>

                    <div class="question-summary-modal-text-input-container">
                        <!-- Text Input -->
                        <div class="question-summary-modal-text-input">
                            <p class="text-input-header">Correct Answer: </p>
                            <p id="correctAnswer-modal"></p>
                        </div>

                        <div class="question-summary-modal-text-input">
                            <p class="text-input-header">Student Answer: </p>
                            <div class="student-ans-text-container " id="studentAnswer-modal">
                            </div>
                        </div>
                    </div>
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

    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
        integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous">
    </script>

    <script>
        let studentResponses = {};
        let leaderboardData = {};
        const socket = io("http://localhost:3000");
        const sessionCode = sessionStorage.getItem('sessionCode');
        socket.emit('joinSession', sessionCode.toString());


        function createQuestionHTML(question, index) {
            const totalCorrect = 0;
            const totalIncorrect = 0;
            const totalResponses = totalCorrect + totalIncorrect;

            const correctPercentage = (totalCorrect / totalResponses) * 100;
            const incorrectPercentage = (totalIncorrect / totalResponses) * 100;

            let questionHTML = `
                <div id="ques-${question.id}" class="question-summary-container">
                <div class="question-summary-header">
                    <div>Question ${index}.</div>
                    <div>
                    <div>Average Time Taken:</div>
                    <span class="average-time-taken">0</span> s
                    </div>
                    <div>
                        <div class="progress" style="border-radius: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: ${correctPercentage}%" aria-valuenow="${correctPercentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: ${incorrectPercentage}%" aria-valuenow="${incorrectPercentage}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div><span class="total-correct">${totalCorrect}</span> correct, <span class="total-incorrect">${totalIncorrect}</span> incorrect</div>
                    </div>
                </div>
                <hr>
                <div >
                    ${question.title}
                    </div>
                    <hr>
                <div>`;

            if (question.type === 0 || question.type === 1) {
                question.options.forEach((option, index) => {
                    const icon = (question.type === 0) ? 'fa-circle' : 'fa-square';
                    questionHTML += `<p><i class="fas ${icon}" style="color: grey;"></i> ${option}</p>`;
                });
            } else if (question.type === 2) {
                questionHTML += '<p>Text input</p>';
            }

            questionHTML += `
                </div>
                </div>`;

            return questionHTML;
        }

        function updateQuestionStatus(questionId, studentResponses) {
            const questionElement = document.getElementById(`ques-${questionId}`);
            const questionStats = calculateQuestionStats(questionId, studentResponses);
            // console.log("questionStats");
            console.log(questionStats);
            if (questionElement && questionStats) {
                const {
                    totalResponses,
                    totalCorrect,
                    totalIncorrect,
                    correctPercentage,
                    incorrectPercentage,
                    averageTimeTaken,
                    accuracy,
                    selectedOptions
                } = questionStats;

                const avgTimeTakenElement = questionElement.querySelector('.average-time-taken');
                if (avgTimeTakenElement) {
                    avgTimeTakenElement.textContent = `${averageTimeTaken.toFixed(1)}`;
                }

                const totalCorrectElement = questionElement.querySelector('.total-correct');
                const totalIncorrectElement = questionElement.querySelector('.total-incorrect');
                if (totalCorrectElement && totalIncorrectElement) {
                    totalCorrectElement.textContent = totalCorrect;
                    totalIncorrectElement.textContent = totalIncorrect;
                }

                const progressBarCorrect = questionElement.querySelector('.progress-bar.bg-success');
                const progressBarIncorrect = questionElement.querySelector('.progress-bar.bg-danger');
                if (progressBarCorrect && progressBarIncorrect) {
                    progressBarCorrect.style.width = `${correctPercentage}%`;
                    progressBarCorrect.setAttribute('aria-valuenow', `${correctPercentage}`);

                    progressBarIncorrect.style.width = `${incorrectPercentage}%`;
                    progressBarIncorrect.setAttribute('aria-valuenow', `${incorrectPercentage}`);
                }
            } else {
                console.log("element not exist");
                if (!questionStats) {
                    console.log("no question stats");
                }
            }
        }


        function calculateQuestionStats(questionId, studentResponses) {
            const responses = studentResponses;
            let totalResponses = 0;
            let totalCorrect = 0;
            let totalIncorrect = 0;
            let correctPercentage = 0;
            let incorrectPercentage = 0;
            let averageTimeTaken = 0;
            let accuracy = 0;
            let selectedOptions = [];
            let blankCount = 0;

            if (responses && responses.length > 0) {
                totalResponses = responses.length ?? 0;
                totalCorrect = 0;
                totalIncorrect = 0;
                selectedOptions = {};

                responses.forEach(response => {
                    if (response.correctness) {
                        totalCorrect++;
                    } else {
                        totalIncorrect++;
                    }

                    let answeredOptions;

                    try {
                        answeredOptions = JSON.parse(response.answeredOption);
                    } catch (error) {
                        answeredOptions = response.answeredOption;
                    }

                    console.log("answeredOptions");
                    console.log(answeredOptions);
                    if (!answeredOptions || answeredOptions[0] == null) {
                        blankCount++; // Increment blank count for each empty or null response
                    } else if (Array.isArray(answeredOptions)) {
                        answeredOptions.forEach(option => {
                            console.log(answeredOptions);
                            selectedOptions[option] = (selectedOptions[option] || 0) + 1;
                        });
                    }
                });

                totalTimeTaken = studentResponses.reduce((acc, response) => acc + response.timeTaken, 0) ?? 0;
                accuracy = totalResponses > 0 ? (totalCorrect / totalResponses) * 100 : 0;
                correctPercentage = (totalCorrect / totalResponses) * 100 ?? 0;
                incorrectPercentage = (totalIncorrect / totalResponses) * 100 ?? 0;
                averageTimeTaken = totalResponses > 0 ? totalTimeTaken / totalResponses : 0;
            }

            return {
                totalResponses,
                totalCorrect,
                totalIncorrect,
                correctPercentage,
                incorrectPercentage,
                averageTimeTaken,
                accuracy,
                selectedOptions,
                blankCount,
            };
        }

        function populateModalWithData(question, index) {
            const modalTitle = document.querySelector('#exampleModalLabel');
            const avgTimeTaken = document.querySelector('#averageTimeTaken-modal');
            const blank = document.querySelector('#blankCount-modal');
            const accuracy = document.querySelector('#accuracyPercentage-modal');
            const questionTitleText = document.querySelector('#questionTitle-modal');
            const questionOptionContainer = document.querySelector('.question-summary-modal-option');
            const textInputContainer = document.querySelector('.question-summary-modal-text-input-container');

            const questionStats = calculateQuestionStats(question.id, studentResponses[question.id]);

            modalTitle.textContent = `Question ${index}`;
            avgTimeTaken.textContent = `${questionStats.averageTimeTaken ?? 0} seconds`;
            accuracy.textContent = questionStats.accuracy;
            questionTitleText.textContent = question.title;
            blank.textContent = questionStats.blankCount;

            if (question.type === 2) {
                questionOptionContainer.classList.add('d-none');
                textInputContainer.classList.remove('d-none');

                const correctAnswerText = document.querySelector('#correctAnswer-modal');
                const studentAnswerText = document.querySelector('#studentAnswer-modal');
                correctAnswerText.textContent = `${question.correct_ans[0]}`;
                studentAnswerText.innerHTML = '';

                const responses = studentResponses[question.id];
                responses.forEach(studentAnswer => {
                    const studentAnsRow = document.createElement('div');
                    studentAnsRow.classList.add('student-ans-text-row');

                    if (studentAnswer.correctness === 1) {
                        studentAnsRow.classList.add('correct-option');
                    } else {
                        studentAnsRow.classList.add('incorrect-option');
                    }

                    let answeredOption;
                    try {
                        answeredOption = JSON.parse(studentAnswer.answeredOption);
                    } catch (error) {
                        answeredOption = studentAnswer.answeredOption;
                    }
                   console.log(answeredOption);

                    const answerText = answeredOption && answeredOption[0] !== null ?
                        answeredOption[0] : 'No answer provided';

                    console.log(answerText);
                    const textColor = answeredOption && answeredOption[0] !== null ?
                        'black' : 'grey';

                    studentAnsRow.innerHTML = `
                        <span>${studentAnswer.username}</span>
                        <span style="color:${textColor};">${answerText}</span>
                    `;

                    studentAnswerText.appendChild(studentAnsRow);
                });
            } else {
                questionOptionContainer.classList.remove('d-none');
                textInputContainer.classList.add('d-none');
                questionOptionContainer.innerHTML = '';
                // If it's a multiple choice type
                question.options.forEach(option => {
                    const optionContainer = document.createElement('div');
                    optionContainer.classList.add('option-container');

                    const optionText = document.createElement('div');
                    optionText.classList.add('option-text');

                    if (question.correct_ans.includes(option)) {
                        optionText.classList.add('correct-option');
                    } else {
                        optionText.classList.add('incorrect-option');
                    }

                    optionText.textContent = option;

                    const optionNumPlayer = document.createElement('div');
                    optionNumPlayer.classList.add('option-num-player');
                    console.log(questionStats.selectedOptions);
                    const selectedOptionCount = questionStats.selectedOptions[option] || 0;
                    optionNumPlayer.textContent = `${selectedOptionCount} players`;

                    optionContainer.appendChild(optionText);
                    optionContainer.appendChild(optionNumPlayer);
                    questionOptionContainer.appendChild(optionContainer);
                });
            }
        }


        function resetModalFields() {
            $('.question-summary-modal-text').empty();
            $('.question-summary-modal-option').empty();
            $('.question-summary-modal-text-input-container').addClass('d-none');
        }
        // Event listener when the modal is hidden
        $('#myModal').on('hidden.bs.modal', function() {
            // resetModalFields();
        });

        function handleQuestionClick(question, index) {
            $('#myModal').modal('show');
            populateModalWithData(question, index);
        }

        $(document).ready(function() {
            const questionsContainer = $('#questionsContainer');
            const sessionId = sessionStorage.getItem('sessionId');
            $.ajax({
                url: `/sessions/${sessionId}/quiz-questions`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    const quizQuestions = response.quizQuestions;
                    const userResponses = response.userResponses;

                    console.log(quizQuestions);
                    console.log(userResponses);

                    quizQuestions.forEach((question, index) => {
                        if (!studentResponses[question.id]) {
                            studentResponses[question.id] = [];
                        }
                        const questionHTML = createQuestionHTML(question, index + 1);
                        const questionElement = $(questionHTML);
                        questionElement.click(function() {
                            handleQuestionClick(question, index + 1);
                        });
                        questionsContainer.append(questionElement);

                        userResponses.forEach((userResponse) => {
                            if (question.id === userResponse.questionId) {
                                studentResponses[question.id].push(userResponse);
                                updateQuestionStatus(question.id, studentResponses[
                                    question.id]);
                            }
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            const containers = document.querySelectorAll('.question-summary-container');
            containers.forEach(container => {
                container.addEventListener('click', function() {
                    $('#myModal').modal('show'); // Using jQuery to trigger the Bootstrap modal
                });
            });

            const codePlaceholder = document.getElementById('codePlaceholder');
            const codeCopyIcon = document.getElementById('codeCopyIcon');
            const sessionCode = sessionStorage.getItem('sessionCode');

            if (codePlaceholder) {
                codePlaceholder.textContent = sessionCode || 'N/A';
            }

            function handleCopyClick(element, iconElement) {
                const text = element.innerText;

                const dummyElement = document.createElement('textarea');
                dummyElement.value = text;
                document.body.appendChild(dummyElement);
                dummyElement.select();
                document.execCommand('copy');
                document.body.removeChild(dummyElement);

                iconElement.className = 'fas fa-check';

                setTimeout(() => {
                    iconElement.className = 'fas fa-copy';
                    iconElement.style.color = '';
                    element.innerText = text;
                }, 2000);
            }

            document.getElementById('code-copy-container').addEventListener('click', function(event) {
                handleCopyClick(codePlaceholder, codeCopyIcon);
            });

            $('#endBtn').click(function() {
                const sessionId = sessionStorage.getItem('sessionId');

                if (sessionId) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    $.ajax({
                        url: '/end-session/' + sessionId,
                        type: 'PUT',
                        success: function(response) {
                            socket.emit("endSession", sessionCode);
                            console.log('Session ended successfully');
                            window.location.href = '/lect_homepage';
                        },
                        error: function(xhr, status, error) {
                            console.error('Failed to end session:', error);
                        }
                    });
                } else {
                    console.error('Session ID not found');
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const updateLeaderboardRow = (leaderboardData) => {
                const tableBody = document.querySelector('tbody');
                const existingRows = tableBody.querySelectorAll('tr');
                leaderboardData.forEach((entry, index) => {
                    const {
                        id,
                        username,
                        score
                    } = entry;

                    const existingRow = existingRows[index];
                    const scoreValue = score !== undefined ? score : 0;

                    if (existingRow) {
                        // Update existing row content
                        const cells = existingRow.querySelectorAll('td');
                        console.log(cells);
                        if (cells.length >= 3) {
                            cells[0].textContent = username;
                            cells[1].textContent = score;
                            cells[2].textContent = id;
                        } else {
                            console.error('Not enough cells in the row.');
                        }
                    } else {
                        // Create a new row for the entry
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <th scope="row">${index + 1}</th>
                            <td>${username}</td>
                            <td>${score}</td>
                            <td class="d-none">${id}</td>
                        `;
                        tableBody.appendChild(newRow);
                    }
                });

                // Remove extra rows if there are more existing rows than entries
                // if (existingRows.length > leaderboardData.length) {
                //     for (let i = leaderboardData.length; i < existingRows.length; i++) {
                //         tableBody.removeChild(existingRows[i]);
                //     }
                // }
            };

            socket.on('updateResponse', (data) => {
                console.log("testtttttttt");
                console.log(data);
                if (data) {
                    const questionId = data.questionId;

                    if (!studentResponses[questionId]) {
                        studentResponses[questionId] = [];
                    }

                    studentResponses[questionId].push(data);
                    console.log("here");
                    console.log(studentResponses);
                    updateQuestionStatus(questionId, studentResponses[questionId]);
                }
            });

            socket.on('initial leaderboard', function(leaderboardData) {
                console.log('trigger initial');
                console.log(leaderboardData);
                updateLeaderboardRow(leaderboardData);

                const participantCount = leaderboardData.length;
                document.getElementById('participantCount').textContent = participantCount;

            });

            socket.on('update leaderboard', function(leaderboardData) {
                console.log('trigger update');
                console.log(leaderboardData);
                updateLeaderboardRow(leaderboardData);

                const participantCount = leaderboardData.length;
                document.getElementById('participantCount').textContent = participantCount;
            });
        });

        window.addEventListener('beforeunload', function(event) {
            socket.close();
        });
    </script>
</body>

</html>
