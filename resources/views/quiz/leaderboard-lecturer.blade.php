<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- <link rel="stylesheet" href="play-quiz-style.css"> -->

    <style scoped>
        body {
            background: linear-gradient(90deg, #13C1B7 0%, #87DFA8 100%);
        }

        
table{
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

th,td{
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
    </style>
</head>

<body>
    <!-- header -->
    <div class="header-style">
        <div>logo</div>
        <div>quiz code</div>
        <div><a class="btn btn-dark">end btn</a></div>
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
                        <small>Participants count: 80</small>
                        <table class="" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 20%;">Rank</th>
                                    <th scope="col" style="width: 35%;">Name</th>
                                    <th scope="col" style="width: 25%;">Progress</th>
                                    <th scope="col" style="width: 20%;">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Chloe Lee</td>
                                    <td>3/5</td>
                                    <td>1500</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>kel</td>
                                    <td>3/5</td>
                                    <td>1100</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Chloe Lee</td>
                                    <td>3/5</td>
                                    <td>1500</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>kel</td>
                                    <td>3/5</td>
                                    <td>1100</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane " role="tabpanel">

                    <div style="padding: 20px;">
                        <div class="question-summary-container">
                            <!-- header -->
                            <div class="question-summary-header">
                                <div>Question 1</div>
                                <div>
                                    <div>
                                        Average Time Taken:
                                    </div>
                                    <span>
                                        0 secs
                                    </span>
                                </div>
                                <!-- range -->
                                <div>
                                    <div class="progress" style="border-radius: 10px;">
                                        <div class="progress-bar" role="progressbar" style="width: 50%"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>
                                        0 correct, 0 incorrect
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- body -->
                            <div>
                                1. quiz title
                                <hr>
                                <p><i class="fas fa-circle" style="color: grey;"></i> opiton 1</p>
                                <p><i class="fas fa-circle" style="color: grey;"></i> opiton 1</p>
                                <p><i class="fas fa-square" style="color: grey;"></i> opiton 1</p>
                                <p><i class="fas fa-square" style="color: grey;"></i> opiton 1</p>
                            </div>

                        </div>

                        <div class="question-summary-container">
                            <!-- header -->
                            <div class="question-summary-header">
                                <div>Question 1</div>
                                <div>
                                    <div>
                                        Average Time Taken:
                                    </div>
                                    <span>
                                        0 secs
                                    </span>
                                </div>
                                <!-- range -->
                                <div>
                                    <div class="progress" style="border-radius: 10px;">
                                        <div class="progress-bar" role="progressbar" style="width: 50%"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>
                                        0 correct, 0 incorrect
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- body -->
                            <div>
                                1. quiz title
                                <hr>
                                <p>Text input</p>
                            </div>

                        </div>
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
                        <div>Average Time Taken: 5secs</div>
                        <div>Accuracy: 50%</div>
                    </div>

                    <!-- question title text-->
                    <div class="question-summary-modal-text">
                        title
                    </div>

                    <!-- question option -->

                    <div class="question-summary-modal-option">
                        <div class="option-container">
                            <div class="option-text">option 1</div>
                            <div class="option-num-player">0 players</div>
                        </div>
                        <div class="option-container">
                            <div class="option-text">option 1</div>
                            <div class="option-num-player">0 players</div>
                        </div>
                        <div class="option-container">
                            <div class="option-text">option 1</div>
                            <div class="option-num-player">0 players</div>
                        </div>
                        <div class="option-container">
                            <div class="option-text">option 1</div>
                            <div class="option-num-player">0 players</div>
                        </div>
                    </div>

                    <div class="question-summary-modal-text-iput-container d-none">
                        <div class="question-summary-modal-text-input">
                            <p class="text-input-header">Correct Answer: </p>
                            <p>random answer</p>
                        </div>
            
                        <div class="question-summary-modal-text-input">
                            <p class="text-input-header">Student Answer: </p>
                            <div class="student-ans-text-container">
                                <div class="student-ans-text-row">
                                    <span>username</span>
                                    <span>point</span>
                                </div>
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

    <script>
        // JavaScript to handle the click event for each container
        document.addEventListener('DOMContentLoaded', function () {
            const containers = document.querySelectorAll('.question-summary-container');

            containers.forEach(container => {
                container.addEventListener('click', function () {
                    // Show the modal when a container is clicked
                    $('#myModal').modal('show'); // Using jQuery to trigger the Bootstrap modal
                });
            });
        });
    </script>

</body>

</html>