<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GameMe5</title>

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
        }

        #code-copy-container {
            margin: 0;
            padding: 0;
            margin-top: 20px;
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
    @include('Layout/lect_header_nav')
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
