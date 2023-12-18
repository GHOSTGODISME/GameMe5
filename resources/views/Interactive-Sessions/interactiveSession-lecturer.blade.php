<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

    <style>
        .header_container {
            width: 100%;
            height: 100px;
            display: flex;
            justify-content: space-between;
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

        #code-copy-container {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            text-align: center;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-content: center;
        }

        .logo {
            width: 180px;
            height: 50px;
            flex-shrink: 0;
            margin-top: 25px;
            margin-left: 50px;
        }

        .hamburger {
            width: 25px;
            height: 25px;
            flex-shrink: 0;
            margin-top: 40px;
            margin-right: 30px;
            cursor: pointer;
            /* Add cursor style to indicate it's clickable */
        }

        #code-copy-container {
            margin: 0;
            padding: 0;
            margin-top: 20px;
        }

        /* Navigation panel styles */
        .navigation-panel {

            position: fixed;
            top: 0;
            right: -300px;
            /* Initially off-screen */
            width: 300px;
            height: 100%;
            background: #3CCBC3;
            transition: right 0.3s ease;
            z-index: 1000;
            /* Set a higher z-index value */

        }

        .nav-link {
            padding: 15px 15px 0 15px;
            color: #ffffff;
            text-decoration: none;
            display: block;
            font-family: 'Roboto';
            font-size: 30px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;

        }


        .nav-link:hover {
            padding: 15px 15px 0 15px;
            color: #ffffff;
            text-decoration: none;
            display: block;
            font-family: 'Roboto';
            font-size: 30px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;

        }

        .close-icon {
            position: absolute;
            top: 25px;
            right: 20px;
            width: 35px;
            height: 35px;
            cursor: pointer;

        }

        .nav_row {
            display: flex;
            flex-direction: row;
            padding-left: 20px;
            padding-right: 10px;
            align-items: flex-end;
            margin-top: 40px;
        }


        .menu_icons {
            width: 60px;
            height: 60px;
        }
    </style>
</head>

<body>
    <div class="header_container">
        <a href="{{ url('/lect_homepage') }}"><img class="logo" src="{{ asset('img/logo_header.png') }}"
                alt="Logo"></a>
        <div id="code-copy-container" style="cursor: pointer;">
            <span id="codePlaceholder">{{ $sessionCode }}</span>
            <span id="codeCopyIcon" class="fas fa-copy"></span>
        </div>
        <img class="hamburger" src ="{{ asset('img/hamburger.png') }}" alt="favicon" onclick="toggleNavigation()">
    </div>
    <div class="navigation-panel">
        <div class="nav_row">
            <img src="{{ asset('img/close_icon.png') }}" alt="Close" class="close-icon"
                onclick="toggleNavigation()"><br>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/profile_icon.png') }}" alt="profile_icon">
            <a href="{{ route('lect_profile') }}" class="nav-link">Profile</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/quiz_icon.png') }}" alt="quiz_icon">
            <a href="{{ route('own-quiz') }}" class="nav-link">Quiz</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/classroom_icon.png') }}" alt="classroom_icon">
            <a href="{{ route('classroom_lect_home') }}" class="nav-link">Classroom</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/feedback_icon.png') }}" alt="feedback_icon">
            <a href="{{ route('survey-index') }}" class="nav-link">Survey</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/session_icon.png') }}" alt="session_icon">
            <a href="{{ route('interactive-session-index') }}" class="nav-link">Session</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/tools_icon.png') }}" alt="tools_icon">
            <a href="{{ route('fortune-wheel-index') }}" class="nav-link">Tools</a>
        </div>
        <div class="nav_row">
            <img class="menu_icons" src="{{ asset('img/report_icon.png') }}" alt="report_icon">
            <a href="{{ route('report_home') }}" class="nav-link">Report</a>
        </div>
        <!-- Add more navigation links as needed -->
    </div>
    <div class="main-body">
        <div class="session-body-header">
            <div>
                <span class="h2">Session - {{ $title }}<span> <small>(<span
                                id="concurrentUser">0</span>)</small>
            </div>
            <div>
                <a id="exportChat" class="btn btn-dark">Export Chat</a>
                <a id="endBtn" class="btn btn-dark">End Session</a>
            </div>
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
                    <div class="flex-container">
                        <h3>Polls</h3>
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pollModal"><i
                                class="fa fa-solid fa-plus"></i> New Poll</a>
                    </div>
                    <div class="big-polls-container"></div>

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
    <link rel="stylesheet"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"
        integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous">
    </script>

    <script>
        function toggleNavigation() {
            var navigationPanel = document.querySelector('.navigation-panel');
            navigationPanel.style.right = navigationPanel.style.right === '0px' ? '-300px' : '0px';
        }

        const sessionCode = @json($sessionCode);
        sessionStorage.setItem("interactiveSessionCode", sessionCode);
        sessionStorage.setItem("lect_id", @json(session('lect_id')));
        sessionStorage.setItem("lect_name", @json(session('lect_name')));

        const sessionId = @json($sessionId);
        const id = `l-${@json(session('lect_id'))}`;
        const username = @json(session('lect_name'));
        const sessionTitle = @json($title);
    </script>

    <script src="{{ asset('js/interactive_session_educator.js') }}"></script>

</body>

</html>
