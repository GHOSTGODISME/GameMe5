<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Participants Join</title>
</head>
<body>
    <ul id="participants"></ul>
    <form id="usernameForm" action="">
        <input id="usernameInput" autocomplete="off" placeholder="Enter your username">
        <button>Join</button>
    </form>

    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
        integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous">
    </script>

    <script>
        const socket = io('http://localhost:3000');

        const usernameForm = document.getElementById('usernameForm');
        const usernameInput = document.getElementById('usernameInput');
        const participantsList = document.getElementById('participants');

        // Function to render participants
        function renderParticipants(participants) {
            participants.forEach(username => {
                const item = document.createElement('li');
                item.textContent = `${username} joined`;
                participantsList.appendChild(item);
            });
        }

        usernameForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (usernameInput.value) {
                // Emit a 'join' event to the server with the entered username
                socket.emit('join', usernameInput.value);
                usernameInput.value = '';
            }
        });

        // Listen for 'initial participants' event from the server
        socket.on('initial participants', (participants) => {
            renderParticipants(participants);
        });

        // Listen for 'participant joined' events from the server
        socket.on('participant joined', (username) => {
            const item = document.createElement('li');
            item.textContent = `${username} joined`;
            participantsList.appendChild(item);
        });
    </script>
</body>
</html>
