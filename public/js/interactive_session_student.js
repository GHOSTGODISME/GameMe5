
socket = io("http://localhost:3000");

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
    displayMessage(id, username, message, time);
});

socket.on('newPollCreated', (data) => {
    const {
        pollId,
        pollTitle,
        options
    } = data;
    generatePollContainer(pollId, pollTitle, options);
});

socket.on('is-participants-length', (data) => {
    const concurrentUser = document.getElementById('concurrentUser');
    concurrentUser.innerText = data;
});

socket.on('interactiveSessionEnded', () => {
    if (!alert("This session has ended.")) {
        window.location.href = '/stud_homepage';
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
        const allInputs = form.querySelectorAll(`input[name="pollOption-${pollId}"]`);

        allInputs.forEach(input => {
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

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('leaveBtn').addEventListener('click', function () {
        socket.emit('leaveInteractiveSession', {
            sessionCode,
            id
        });
        window.location.href = "/stud_homepage";
    });

    document.getElementById('messageInput').addEventListener('keyup', function (event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });

});


window.addEventListener('popstate', function () {
    // Reload the page
    location.reload();
});