<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .header_container {
            width: 100%;
            height: 100px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            background: linear-gradient(to right, #13C1B7, #87DFA8);
        }

        .reply-container {
            margin: 40px 0;
            background: whitesmoke;
            border-radius: 10px;
        }

        .optionsContainer input {
            padding: 20px;
        }

        .polls-option,
        .polls-options {
            margin: 10px 0;
        }

        .polls-container-style {
            border: 1px solid black;
            padding: 12px;
            margin: 10px;
            border-radius: 10px;
        }

        .session-body-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            margin: 30px auto;
        }

        .session-content-container {
            margin-top: 20px;
            border-radius: 10px;
            border: 1px black solid;
            height: 400px;
            max-height: 400px;
            overflow: auto;
        }

        .session-single-message {
            padding: 10px;
            border-bottom: 1px solid black;
        }

        .session-content-container .session-single-message:last-child {
            border-bottom: none;
        }

        .session-polls-container {
            height: 600px;
            max-height: 600px;
            overflow: auto;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="header_container">
        <img src="{{ asset('img/logo_header.png') }}" alt="Logo Header">
        <img src="{{ asset('img/hamburger.png') }}" alt="favicon">
    </div>

    <div class="main-body">
        <div class="session-body-header">
            <div>
                <span class="h2">Session - {{ $title }}<span> <small>(<span
                                id="concurrentUser">0</span>)</small>
            </div>
            <div><a id="leaveBtn" class="btn btn-dark">Leave Session</a></div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="session-content-container">
                    </div>
                    <div>
                        <div class="reply-container">

                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type your reply here"
                                    id="messageInput">
                                <span class="input-group-btn">
                                    <button class="btn btn-dark" type="button" onclick="sendMessage()">Enter</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 session-polls-container">
                    <h3>Polls</h3>
                    <div class="big-polls-container">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
        integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous">
    </script>

    <script>
        //         console.log(@{$title});
        // console.log(@{$sessionCode});

        console.log(@json($title));
        socket = io("http://localhost:3000");
        const sessionCode = @json($sessionCode);
        sessionStorage.setItem("interactiveSessionCode", sessionCode);
        sessionStorage.setItem("stud_id", @json(session("stud_id")));
        sessionStorage.setItem("stud_name", @json(session("stud_name")));

        const id = @json(session("stud_id"));
        const username = @json(session("stud_name"));

        console.log(sessionCode);
        socket.emit("joinInteractiveSession", {
            sessionCode,
            id,
            username
        });

        socket.on('chatMessageReceived', (data) => {
            const {
                id,
                username,
                message,
                time
            } = data;
            console.log(data);
            displayMessage(id, username, message, time);
        });

        socket.on('newPollCreated', (data) => {
            const {
                pollId,
                pollTitle,
                options
            } = data;
            console.log("newPollCreated received");
            generatePollContainer(pollId, pollTitle, options);
        });

        socket.on('is-participants-length', (data) => {
            const concurrentUser = document.getElementById('concurrentUser');
            concurrentUser.innerText = data;
        });

        socket.on('interactiveSessionEnded', () => {
            if (!alert("This session has ended.")) {
                window.location.href = '/';
            }

        });

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (message !== '') {
                socket.emit('sendChatMessage', {
                    sessionCode,
                    id,
                    username,
                    message
                });
                messageInput.value = '';
            }
        }

        function displayMessage(userId, username, message, time) {
            console.log("userid " + userId);
            console.log("id " + id);
            const sessionContent = document.querySelector('.session-content-container');
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('session-single-message');

            const messageInfo = document.createElement('div');
            messageInfo.innerHTML = `<b>${username}${userId === id ? ' (You)' : ''}</b> <span>${time}</span>`;
            const messageText = document.createElement('div');
            messageText.textContent = message;

            messageDiv.appendChild(messageInfo);
            messageDiv.appendChild(messageText);
            sessionContent.appendChild(messageDiv);
        }

        function submitVote(pollId) {
            const form = document.getElementById(`pollForm-${pollId}`);
            const radioInputs = form.querySelectorAll(`input[name="pollOption-${pollId}"]:checked`);

            if (radioInputs.length > 0) {
                const optionSelected = radioInputs[0].value; // Get the selected option value
                radioInputs.forEach(input => {
                    input.disabled = true;
                });

                // Hide the vote button after submitting
                const voteButton = form.querySelector('a.btn-primary');
                if (voteButton) {
                    voteButton.style.display = 'none';
                }

                socket.emit('voteForPoll', {
                    sessionCode,
                    pollId,
                    optionSelected,
                    userId: id
                });
            }
        }


        function generatePollContainer(pollId, question, options) {
            const container = document.createElement('div');
            container.innerHTML = `
        <div class="student-poll-view polls-container-style" data-poll-id="${pollId}">
            <h5>${question}</h5>
            <hr>
            <form id="pollForm-${pollId}">
                ${options.map((option, index) => `
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pollOption-${pollId}" id="option${index + 1}-${pollId}" value="${option.toLowerCase().replace(/\s/g, '')}">
                                        <label class="form-check-label" for="option${index + 1}-${pollId}">
                                            ${option}
                                        </label>
                                    </div>`).join('')}
                <div style="text-align: end; margin-top: 10px;">
                    <a class="btn btn-primary" onclick="submitVote('${pollId}')">Vote</a>
                </div>
            </form>
        </div>
    `;

            document.querySelector('.big-polls-container')
                .appendChild(container);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('leaveBtn').addEventListener('click', function() {
                // socket.emit('disconnect');
                socket.emit('leaveInteractiveSession', {
                    sessionCode,
                    id
                });
                window.location.href = "/stud_homepage";
            });

            document.getElementById('messageInput').addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });

        });
    </script>



</body>

</html>
