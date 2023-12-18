
function generateUniqueID() {
    const timestamp = new Date().getTime().toString(16); // Timestamp converted to hexadecimal
    const randomString = Math.random().toString(16).slice(2); // Random string
    return `poll-${timestamp}-${randomString}`;
}

$(document).ready(function () {
    $('#pollModal').on('hidden.bs.modal', function () {
        // Clear the input fields in the modal
        $('#pollTitle').val('');
        $('#optionsContainer').empty(); // Remove all poll options

        // Add a default input for adding options
        const placeholderInput = `                <div id="optionsContainer">
                            <div class="input-group mt-2">
                                <input type="text" class="form-control polls-option"
                                    placeholder="Click to add option" onclick="addOption(this)" readonly>
                            </div>
                        </div>`;
        $('#optionsContainer').append(placeholderInput);
    });
});


socket = io("http://localhost:3000");
let pollIdCounter = generateUniqueID();

socket.emit("createInteractiveSession", {
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

socket.on('pollVoteReceived', (data) => {
    const {
        pollId,
        optionSelected,
        votes
    } = data;
    updatePollResult(pollId, optionSelected, votes);
});

socket.on('is-participants-length', (data) => {
    const concurrentUser = document.getElementById('concurrentUser');
    concurrentUser.innerText = data;
});

socket.on('returnChatMessage', (messages) => {
    const formattedData = messages.map(entry => `${entry.username} ${entry.time}\n${entry.message}`).join(
        '\n\n');
    const blob = new Blob([formattedData], {
        type: 'text/plain'
    });

    const url = URL.createObjectURL(blob);

    const currentDate = new Date().toISOString().split('T')[0];

    const downloadLink = document.createElement('a');
    downloadLink.href = url;
    downloadLink.download = `${sessionTitle}_messsage_${currentDate}.txt`;
    downloadLink.click();
})


document.addEventListener('DOMContentLoaded', function () {
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

    document.getElementById('messageInput').addEventListener('keyup', function (event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });

    document.getElementById('code-copy-container').addEventListener('click', function (event) {
        handleCopyClick(codePlaceholder, codeCopyIcon);
    });

    $('#exportChat').click(function () {
        socket.emit("exportChatMessage", sessionCode);
    });

    $('#endBtn').click(function () {
        if (sessionId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            socket.emit("saveChatMessage", sessionCode);
            socket.on('returnChatMessageSave', message => {
                $.ajax({
                    url: '/end-interactive-session',
                    type: 'POST',
                    data: {
                        messages: message,
                        sessionId: sessionId
                    },
                    success: function (response) {
                        socket.emit("endInteractiveSession", sessionCode);
                        console.log('Session ended successfully');
                        window.location.href = "/lect_homepage";

                    },
                    error: function (xhr, status, error) {
                        console.error('Failed to end session:', error);
                    }
                });
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

        const totalVotes = Object.values(votes).reduce((acc, curr) => acc + curr, 0);
        //const selectedOptionVotes = votes[optionSelected];

        // Update progress bars for all options within the poll
        pollOptions.forEach((optionElement) => {
            const optionTextContainer = optionElement.querySelector('.option-text');
            const optionText = optionTextContainer.textContent.trim().toLowerCase();

            const progressContainer = optionElement.querySelector('.progress');
            const progressBar = progressContainer.querySelector('.progress-bar');

            const optionVotes = votes[optionText];
            const votesPercentage = totalVotes > 0 ? (optionVotes / totalVotes) * 100 : 0;
            progressBar.style.width = `${votesPercentage}%`;
            progressBar.textContent = `${optionVotes}`;
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
    removeButton.onclick = function () {
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
    placeholderInput.onclick = function () {
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
    const lowerCaseOptions = [];
    const optionInputs = document.querySelectorAll('#optionsContainer input:not([readonly])');
    optionInputs.forEach(input => {
        if (input.value.trim() !== '' && input.value !== null) {
            options.push(input.value.trim());
            lowerCaseOptions.push(input.value.trim().toLowerCase());
        }
    });

    // check if there are duplicated option
    const uniqueOptions = Array.from(new Set(lowerCaseOptions));
    if (uniqueOptions.length !== options.length) {
        alert('Duplicate options are not allowed. Please enter unique options for the poll.');
        return;
    }

    if (pollTitle.trim() == "") {
        alert('Please enter a title for the poll.');
        return;
    }

    if (options.length < 2) {
        alert('Please enter at least two options for the poll.');
        return;
    }

    const pollId = `${generateUniqueID()}`;
    createNewPollContainer(pollId, pollTitle, options);

    socket.emit('createPoll', {
        sessionCode,
        pollId,
        pollTitle,
        options
    });

    $('#pollModal').modal('hide');
}