<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            align-content: center;
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

        .session-polls-container {
            height: 600px;
            max-height: 600px;
            overflow: auto;
            padding: 10px;
        }

        #code-copy-container {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header_container">
        <img src="{{ asset('img/logo_header.png') }}" alt="Logo Header">
        <div id="code-copy-container" style="cursor: pointer;">
            <span id="codePlaceholder">{{ $sessionCode }}</span>
            <span id="codeCopyIcon" class="fas fa-copy"></span>
        </div>


        <img src="{{ asset('img/hamburger.png') }}" alt="favicon">
    </div>

    <div class="main-body">
        <div class="session-body-header">
            <div>
                <span class="h2">Session - {{ $title }}<span> <small>(<span
                                id="concurrentUser">0</span>)</small>
            </div>
            <div><a id="endBtn" class="btn btn-dark">End Session</a></div>
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
                                    <button class="btn btn-default" type="button"
                                        onclick="sendMessage()">Enter</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 session-polls-container">
                    <div style="text-align: end;">
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pollModal"><i
                                class="fa fa-solid fa-plus"></i> New Poll</a>
                    </div>

                    <div class="big-polls-container">
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- polls modal --}}
    <div class="modal fade" id="pollModal" tabindex="-1" aria-labelledby="pollModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pollModalLabel">Create a New Poll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pollTitle" class="form-label">Poll Title:</label>
                        <input type="text" class="form-control" id="pollTitle"
                            placeholder="Enter poll title or question here">
                    </div>
                    <div class="mb-3">
                        <label for="pollOptions" class="form-label">Poll Options:</label>
                        <div id="optionsContainer">
                            <div class="input-group mt-2">
                                <input type="text" class="form-control polls-option"
                                    placeholder="Click to add option" onclick="addOption(this)" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="savePoll()">Save Poll</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">

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
        console.log(@json($sessionCode));
        socket = io("http://localhost:3000");
        const sessionCode = @json($sessionCode);
        sessionStorage.setItem("interactiveSessionCode", sessionCode);
        let pollIdCounter = 1;
        const sessionId = @json($sessionId);
        const id = "testid";
        const username = "testname";

        console.log(sessionCode);
        socket.emit("createInteractiveSession", sessionCode);

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

        socket.on('pollVoteReceived', (data) => {
            const {
                pollId,
                optionSelected,
                votes
            } = data;
            console.log(data);
            updatePollResult(pollId, optionSelected, votes);
        });

        socket.on('is-participants-length', (data) => {
            const concurrentUser = document.getElementById('concurrentUser');
            concurrentUser.innerText = data;
        });


        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            const codeCopyIcon = document.getElementById('codeCopyIcon');
            const codePlaceholder = document.getElementById('codePlaceholder');

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
                if (sessionId) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    $.ajax({
                        url: '/end-interactive-session/' + sessionId,
                        type: 'PUT',
                        success: function(response) {
                            socket.emit("endInteractiveSession", sessionCode);
                            console.log('Session ended successfully');
                            window.location.href = '/';
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

        function updatePollResult(pollId, optionSelected, votes) {
            const pollContainer = document.querySelector(`[data-poll-id="${pollId}"]`);
            if (pollContainer) {
                const pollOptions = pollContainer.querySelectorAll('.polls-options');

                pollOptions.forEach((optionElement) => {
                    const optionTextContainer = optionElement.querySelector('.option-text');
                    const optionText = optionTextContainer.textContent.trim();

                    if (optionText === optionSelected) {
                        const progressContainer = optionElement.querySelector('.progress');
                        const progressBar = progressContainer.querySelector('.progress-bar');

                        // Update the progress bar with the updated votes
                        const totalVotes = Object.values(votes).reduce((acc, curr) => acc + curr, 0);
                        const selectedOptionVotes = votes[optionSelected];

                        const votesPercentage = totalVotes > 0 ? (selectedOptionVotes / totalVotes) * 100 : 0;

                        progressBar.style.width = `${votesPercentage}%`;
                        progressBar.textContent = `${selectedOptionVotes}`;
                    }
                });
            }
        }


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

        function submitVote(element) {
            const form = document.getElementById('pollForm');
            const radioInputs = form.querySelectorAll('input[name="pollOption"]');
            radioInputs.forEach(input => {
                input.disabled = true;
            });
            element.style.display = 'none';
        }

        function addOption(element) {
            const optionsContainer = document.getElementById('optionsContainer');
            const newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.classList.add('form-control');
            newInput.placeholder = `Option ${optionsContainer.childElementCount}`;

            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mt-2');
            newInputGroup.appendChild(newInput);

            const removeButton = document.createElement('button');
            removeButton.classList.add('btn', 'btn-danger');
            removeButton.textContent = 'Remove';
            removeButton.onclick = function() {
                removeOption(this);
            };

            newInputGroup.appendChild(removeButton);

            element.parentElement.replaceWith(newInputGroup);

            const newInputGroup2 = document.createElement('div');
            newInputGroup2.classList.add('input-group', 'mt-2');

            const placeholderInput = document.createElement('input');
            placeholderInput.type = 'text';
            placeholderInput.classList.add('form-control');
            placeholderInput.placeholder = 'Click to add option';
            placeholderInput.readOnly = true;
            placeholderInput.onclick = function() {
                addOption(this);
            };
            newInputGroup2.appendChild(placeholderInput);
            optionsContainer.appendChild(newInputGroup2);

            newInput.focus();
        }

        function removeOption(button) {
            const optionsContainer = document.getElementById('optionsContainer');
            const inputGroupToRemove = button.parentElement;
            const nextInputGroup = inputGroupToRemove.nextElementSibling;

            optionsContainer.removeChild(inputGroupToRemove);
            if (nextInputGroup) {
                nextInputGroup.firstChild.focus();
            }
        }

        function createNewPollContainer(pollId, pollTitle, pollOptions) {
            const bigPollsContainer = document.querySelector('.big-polls-container');

            const newPollsContainer = document.createElement('div');
            newPollsContainer.dataset.pollId = pollId;
            newPollsContainer.classList = 'polls-container polls-container-style';
            const pollsTitle = document.createElement('div');
            pollsTitle.classList = 'polls-title h5';
            pollsTitle.textContent = `Poll: ${pollTitle}`;

            const hrElement = document.createElement('hr');

            newPollsContainer.appendChild(pollsTitle);
            newPollsContainer.appendChild(hrElement);

            pollOptions.forEach(option => {
                const pollsOption = document.createElement('div');
                pollsOption.classList.add('polls-options');

                const progressContainer = document.createElement('div');
                progressContainer.classList.add('progress');

                const progressBar = document.createElement('div');
                progressBar.classList.add('progress-bar');
                progressBar.setAttribute('role', 'progressbar');
                progressBar.setAttribute('aria-valuemin', '0');
                progressBar.setAttribute('aria-valuemax', '100');

                progressBar.style.width = `0%`;
                progressBar.textContent = `0`;

                progressContainer.appendChild(progressBar);

                const optionTextContainer = document.createElement('span');
                optionTextContainer.classList.add('option-text');
                optionTextContainer.textContent = option;

                pollsOption.appendChild(optionTextContainer);
                pollsOption.appendChild(progressContainer);

                newPollsContainer.appendChild(pollsOption);
            });

            bigPollsContainer.appendChild(newPollsContainer);
        }


        function savePoll() {
            const pollTitle = document.getElementById('pollTitle').value;
            const options = [];
            const optionInputs = document.querySelectorAll('#optionsContainer input:not([readonly])');
            optionInputs.forEach(input => {
                if (input.value.trim() !== '' && input.value !== null) {
                    options.push(input.value);
                }
            });

            if (options.length < 2) {
                alert('Please enter at least two options for the poll.');
                return;
            }

            const pollId = `poll_${pollIdCounter++}`;
            createNewPollContainer(pollId, pollTitle, options);

            socket.emit('createPoll', {
                sessionCode,
                pollId,
                pollTitle,
                options
            });
            console.log('Poll Title:', pollTitle);
            console.log('Poll Options:', options);

            // Add the new poll container only when the user confirms to save
            // if (confirm('Do you want to save this poll?')) {
            // Close the modal after saving the poll
            $('#pollModal').modal('hide');
            // }
        }
    </script>



</body>

</html>
