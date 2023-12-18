socket = io("http://localhost:3000");
const routes = JSON.parse(document.querySelector('meta[name="app-routes"]').getAttribute('content'));
const sessionCode = sessionStorage.getItem('sessionCode');
socket.emit('joinSession', sessionCode.toString());

document.addEventListener('DOMContentLoaded', function () {
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

    document.querySelector('.copy-session-code').addEventListener('click', function () {
        handleCopyClick(sessionCodeElement, sessionCodeIcon);
    });

    document.querySelector('.copy-quiz-link').addEventListener('click', function () {
        handleCopyClick(quizLinkElement, quizLinkIcon);
    });
});


function startQuiz() {
    socket.emit("startSession", sessionCode.toString());
    // window.location.href = '{{ route('leaderboard - lecturer') }}';
    window.location.href = routes.leaderboardLecturerRoute;
}

function updateParticipants(participants) {
    let participantsContainer = document.getElementById('participantsList');
    let participantsCount = document.getElementById('participantsCount');
    let waitingMessage = document.getElementById('waitingMessage');

    if (participants.length > 0) {
        participantsCount.textContent = participants.length;
        waitingMessage.classList.add('d-none');

        participantsContainer.innerHTML = '';
        participants.forEach(function (participant) {
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


window.addEventListener('beforeunload', function (event) {
    socket.close();
});


document.addEventListener('DOMContentLoaded', function () {

    // Fetch lecturerClasses using AJAX
    fetch(routes.getLecturerClassesRoute)
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
    document.getElementById('session_id').value = sessionStorage.getItem('sessionId');
});