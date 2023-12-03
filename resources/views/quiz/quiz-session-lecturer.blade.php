<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style scoped>
        .joined-participants-text {
            font-size: 24px;
        }

        .joined-participants-container {
            color: white;
            padding: 50px;
            /* border: 4px solid black; */
            border-radius: 10px;
            width: 90%;
            margin: auto;
            margin-top: 40px;
            background-color: #13C1B7;
            /* background-color: #1b4e42; */
        }

        .joined-participants-people-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            overflow: auto;
            max-height: 400px;


            border: 4px solid black;
            background: #226755;
            border-radius: 10px;
        }

        .joined-participants-people {
            border-radius: 10px;
            background: #42c0a2;
            padding: 15px 40px;
            color: #FEFEFE;
            margin: 20px;
            display: inline-block;
        }

        .joined-participants-people:hover {
            box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
            background: #287462;
        }

        .details-container {
            padding: 20px 20px;
            margin: 10px;
            font-size: 20px;
            border-radius: 10px;
            color: white;
            width: 80%;
            margin: auto;
        }


        .details-container div:nth-child(2) {
            color: black;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            background: #84dea8;
            padding: 15px;
            border-radius: 10px;
            margin: auto;
            margin-top: 10px;
            word-break: break-all;
        }

        .btn-container {
            margin-top: 20px;
            text-align: center;
        }

        .btn-container a {
            width: 200px;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            color: white;
            background: #349981;
        }

        .btn-container button:hover {
            background: #98ffc7;
            color: black;
        }


        .header_container {
            width: 100%;
            height: 100px;
            display: flex;
            justify-content: space-between;
            background: linear-gradient(to right, #13C1B7, #87DFA8);
        }
    </style>
</head>

<body>
    @include('Layout/lect_header')
    <div class="row">
        <div class="col-xl-7">
            <div class="joined-participants-container">
                <p class="joined-participants-text">Joined Participants <i class="fa-solid fa-person"></i><i
                        class="fa-solid fa-person-dress"></i>
                    <span id="participantsCount">0</span>
                </p>

                <div class="joined-participants-people-container" id="participantsList">
                </div>

                <div class="d-none" style="text-align: center; margin-top: 50px;" id="waitingMessage">
                    Waiting for participants.......
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="joined-participants-container">
                <div style="background: #226755; padding: 20px; border-radius: 10px;">


                    <div class="details-container" style="padding: 0;">
                        Join the session now!
                    </div>
                    <div style="width: 90%; margin: auto;">
                        <div class="details-container">

                            <div>1. Access the link below</div>
                            <div class="copy-quiz-link" style="cursor: pointer;">
                                <span id="quizLinkText">localhost:8000</span>
                                <span id="quizLinkIcon" class="fas fa-copy"></span>
                            </div>
                        </div>
                        

                        <div class="details-container">
                            <div>2. Enter the code</div>
                            <div class="copy-session-code" style="cursor: pointer;">
                                <span id="sessionCodeText"></span>
                                <span id="sessionCodeIcon" class="fas fa-copy"></span>
                            </div>
                        </div>

                        <div class="details-container">
                            <div>Or scan the code below!!!</div>
                            <div id="qrCode">{{$qrCodeContent}}</div>
                        </div>

                        <div class="details-container">
                            <div>Assign to Class</div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignClassModal">
                                Assign to Class
                            </button>
                        </div>

                    </div>

                    <div class="btn-container">
                        <a href="{{ route('leaderboard-lecturer') }}" class="btn">Start</a>
                        <a onclick="startQuiz()" class="btn">Start</a>

                    </div>
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
                <form id="assignClassForm" action="{{ route('assign_class') }}" method="post">
                    @csrf
                    
                    <div class="form-group">
                        <label for="class">Select Class:</label>
                        <select class="form-control" id="class" name="class_id" required>
                            <!-- Options will be dynamically added using JavaScript -->
                        </select>
                    </div>

                     <!-- Your input field -->
                    <input type="hidden" name="class_session_code" id="class_session_code" value="">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Assign Class</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

    <script></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
        integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous">
    </script>

    <script>
        socket = io("http://localhost:3000");
        const sessionCode = sessionStorage.getItem('sessionCode');
        socket.emit('joinSession', sessionCode.toString());

        document.addEventListener('DOMContentLoaded', function() {
            const sessionCodeElement = document.getElementById('sessionCodeText');
            const sessionCodeIcon = document.getElementById('sessionCodeIcon');
            const quizLinkElement = document.getElementById('quizLinkText');
            const quizLinkIcon = document.getElementById('quizLinkIcon');
            const sessionCode = sessionStorage.getItem('sessionCode');

            if (sessionCodeElement) {
                sessionCodeElement.textContent = sessionCode || 'N/A';
            }

            quizLinkElement.textContent = `localhost:8000/join-quiz?code=${sessionCode}`
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

            document.querySelector('.copy-session-code').addEventListener('click', function() {
                handleCopyClick(sessionCodeElement, sessionCodeIcon);
            });

            document.querySelector('.copy-quiz-link').addEventListener('click', function() {
                handleCopyClick(quizLinkElement, quizLinkIcon);
            });
        });


        function startQuiz() {
            socket.emit("startSession", sessionCode.toString());
            window.location.href = '{{ route('leaderboard-lecturer') }}';
            // $router.push("/quiz/quiz-loading");
        }

        function updateParticipants(participants) {
            let participantsContainer = document.getElementById('participantsList');
            let participantsCount = document.getElementById('participantsCount');
            let waitingMessage = document.getElementById('waitingMessage');

            if (participants.length > 0) {
                participantsCount.textContent = participants.length;
                waitingMessage.classList.add('d-none');

                participantsContainer.innerHTML = '';
                participants.forEach(function(participant) {
                    let span = document.createElement('span');
                    span.className = 'joined-participants-people';
                    span.textContent = participant;
                    participantsContainer.appendChild(span);
                });
            } else {
                participantsContainer.innerHTML = '';
                participantsCount.textContent = '0';
                waitingMessage.classList.remove('d-none');
            }
        }

        let participants = [];

        socket.on("initial participants", (initialParticipants) => {
            participants = initialParticipants.map(participant => participant.username);
            updateParticipants(participants);
        });

        socket.on("participant joined", ({
            username
        }) => {
            participants.push(username);
            updateParticipants(participants);
        });


        window.addEventListener('beforeunload', function(event) {
            socket.close();
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

    document.addEventListener('DOMContentLoaded', function () {
        // Parse the JSON and set the value of the input field
        document.getElementById('class_session_code').value = sessionStorage.getItem('sessionCode');
    });

    </script>

</body>

</html>
