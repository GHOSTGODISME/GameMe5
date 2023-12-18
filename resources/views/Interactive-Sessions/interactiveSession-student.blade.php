<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
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
    @include('Layout/student_header')
    
    <div class="main-body">
        <div class="session-body-header">
            <div>
                <span class="h2">Session - {{ $title }}<span> 
                    <small>(<span id="concurrentUser">0</span>)</small>
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
        const sessionCode = @json($sessionCode);
        sessionStorage.setItem("interactiveSessionCode", sessionCode);
        sessionStorage.setItem("stud_id", @json(session('stud_id')));
        sessionStorage.setItem("stud_name", @json(session('stud_name')));

        const id = `s-${@json(session('stud_id'))}`;
        const username = @json(session('stud_name'));
    </script>

    <script src="{{ asset('js/interactive_session_student.js') }}"></script>


</body>

</html>
