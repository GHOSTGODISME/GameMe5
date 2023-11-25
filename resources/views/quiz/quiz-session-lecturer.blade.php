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
                    <span>(8)</span>
                </p>

                <div class="joined-participants-people-container">
                    <span class="joined-participants-people">Ghostgod</span>
                    <span class="joined-participants-people">husky</span>
                    <span class="joined-participants-people">Ghostgod</span>
                    <span class="joined-participants-people">husky</span>
                </div>

                <div class="d-none" style="text-align: center; margin-top: 50px;">
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
                            <div>
                                <span>joinquiz.link</span>
                                <i class="fa fa-copy"></i>
                            </div>
                        </div>

                        <div class="details-container">
                            <div>2. Enter the code</div>
                            <div>
                                <span id="sessionCode">{{ $sessionCode }}</span>
                                <i class="fa fa-copy copy-session-code" data-clipboard-target="#sessionCode"></i>
                            </div>                            
                        </div>
                    </div>


                    <div class="btn-container">
                        <a href="{{ route('leaderboard-lecturer') }}" class="btn">Start</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
</script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new ClipboardJS('.copy-session-code');

        // Display a message when the text is copied
        document.querySelector('.copy-session-code').addEventListener('click', function() {
            var sessionCodeElement = document.getElementById('sessionCode');
            var sessionCode = sessionCodeElement.innerText;

            var dummyElement = document.createElement('textarea');
            dummyElement.value = sessionCode;
            document.body.appendChild(dummyElement);
            dummyElement.select();
            document.execCommand('copy');
            document.body.removeChild(dummyElement);

            alert('Code copied to clipboard!');
        });
    });
</script>

</body>

</html>