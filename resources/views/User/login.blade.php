@extends('Layout/userauth_master')

@section('title', 'Sign In')

@section('content')

    <style>
        .forget_pass {
            color: #000;
            font-family: 'Roboto';
            font-size: 12px;
            font-style: normal;
            font-weight: 300;
            line-height: normal;
            text-decoration-line: underline;
        }

        .forget_pass_container {
            width: 300px;
            display: flex;
            justify-content: right;
            margin-top: 10px;
        }


        #txt_login_email,
        #txt_login_password {
            padding: 15px;
            border: 1px solid #BFBFBF;
            border-radius: 10px;
            box-sizing: border-box;
            background: #FAFAFA;
            width: 300px;
            height: 34px;
            flex-shrink: 0;
        }

        #txt_login_email {
            margin-bottom: 30px;
        }

        #txt_login_email:focus,
        #txt_login_password:focus {
            outline: none;
            border-color: #007bff;
            /* Change the border color on focus */
        }

        #txt_login_email::placeholder,
        #txt_login_password::placeholder {
            color: #BABABA;
            font-family: 'Roboto';
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }

    .error_message p{
        margin-left:15px;
        font-family: 'Roboto';
        font-size: 12px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        color: #D8000C;
    }
    
    .button_general{
        margin-top:60px;
    }
    .welcome_txt2{
        display:none;
    }
 

    .login-method-btn {
        padding: 10px 20px;
        margin-left: 0px; /* Counteract the left padding of the parent */
        margin-right: 50px; /* Adjust as needed */
        cursor: pointer;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        background-color: #6d6d6d;
        font-size: 12px;
        color: #ffffff;

    }

    .login-method-btn.active {
        background: #FAFAFA;
        color: #000000;
        border:1px solid black;
    }

    #manual-login-form {
        display: block; /* Initially show the manual login form */
    }
    #qrcode-con{
        display: none; /* Initially hide the auto QR code display area */
    }

    .qr{
        min-width:300px;
    }

    @media only screen and (max-width: 768px) {
    /* Add specific styles for screens with a maximum width of 600px */
       .welcome_txt1{
          display: none;
        }
        .welcome_txt2{
         display: block;
        }

        #txt_login_email,
        #txt_login_password {
            width: 100%;
        }

        .input_label {
            font-size: 14px;
            margin-bottom: 15px; /* Adjust margin for smaller screens */
        }

        .forget_pass_container {
            width: 100%; /* Make the forget password container full width */
            text-align: center; /* Center the forget password link */
            margin-top: 10px;
        }

        .error_message {
            height: auto; /* Allow error message height to adjust based on content */
        }

        .error_message p {
            font-size: 12px;
        }

        .button_general {
            margin-top: 30px;
            width: 100%; /* Make the button full width */
        }

        .help_txt {
            width: 100%; /* Make the help text full width */
        }
    }
    


<<<<<<< HEAD
</style>
<div class="login-method-selection">
    <div class="login-method-btn active" onclick="showLoginMethod('manual')">Manual Login</div>
    <div class="login-method-btn" onclick="showLoginMethod('qrcode')">QR Code Login</div>
</div>

<h1 class=welcome_txt1>Welcome<br>Back!</h1>
<h1 class=welcome_txt2>Welcome back!</h1>
<div id="manual-login-form">
<form  action="{{route('login_post')}}" method="POST">
    @csrf
    <div class="input_label">
        <label for="login_email">Email:</label>
    </div>
=======
    </style>
    <h1 class=header>Welcome<br>Back!</h1>

    <form action="{{ route('login_post') }}" method="POST">
        @csrf
        <div class="input_label">
            <label for="login_email">Email:</label>
        </div>
>>>>>>> main-merge-with-ks
        <input type="email" id="txt_login_email" name="email" placeholder="xxxxx@student.tarc.edu.my" required>

        <div class="input_label">
            <label for="login_password">Password:</label>
        </div>
        <input type="password" id="txt_login_password" name="password" placeholder="Enter your password" required><br>

<<<<<<< HEAD
    <div class="forget_pass_container"><a class="forget_pass" href="{{route('forgetpassword_1')}}">Forget you password?</a><br></div>
    <div class="error_container">
        @error('email')
           <div class="error_message">
               <img src="{{ asset('img/error_icon.png') }}">
             
              <p> {{ $message }}</p>
           </div>
          @enderror
       </div>
    <button type="submit" class="button_general">Log In</button><br>
    <span class = help_txt >Don't have an account?  <a class="hypertext" href="{{route('signup_1')}}">{{ __('Sign Up')}}</a><span>
</form>
</div>

<!-- QR code display area -->

<div class="qr" id="qrcode-con"></div>

<script>
    // Function to toggle display of manual login form and QR code based on selected login method
    function showLoginMethod(method) {
        var manualLoginForm = document.getElementById("manual-login-form");
        var qrCodeImg = document.getElementById("qrcode-con");

        if (method === "qrcode") {
            manualLoginForm.style.display = "none";
            qrCodeImg.style.display = " block";
            document.querySelector('.login-method-btn.active').classList.remove('active');
            document.querySelector('.login-method-btn:nth-child(2)').classList.add('active');
        } else {
            manualLoginForm.style.display = "block";
            qrCodeImg.style.display = "none";
            document.querySelector('.login-method-btn.active').classList.remove('active');
            document.querySelector('.login-method-btn:nth-child(1)').classList.add('active');
        }
    }

    function generateQRCode() {
        var qrCodeElement = document.getElementById("qrcode-con");
        var data = "https://www.facebook.com/";
        // Create a QR code instance
        var qr = new QRCode(qrCodeElement, {
            text: data,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }

    window.onload = function () {
        generateQRCode();
        showLoginMethod('manual'); // Show manual login initially
    };
</script>
=======
>>>>>>> main-merge-with-ks

        <div class="forget_pass_container"><a class="forget_pass" href="{{ route('forgetpassword_1') }}">Forget you
                password?</a><br></div>
        <div class="error_container">
            @error('email')
                <div class="error_message">
                    <img src="{{ asset('img/error_icon.png') }}">

                    <p> {{ $message }}</p>
                </div>
            @enderror
        </div>

        <button type="submit" class="button_general">Log In</button><br>
        <!-- <span class=help_txt>Don't have an account? <a class="hypertext"
                    href="{{ route('signup_1') }}">{{ __('Sign Up') }}</a><span> -->
        <h3>Or You can Login With SSI !</h3>
        <div id="qrcode"></div>

    </form>

    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
    <script>
        function fetchConnectionAndGenerateQR() {

            const url = "http://10.123.10.106:4001/connections/create-invitation"

            const headers = {
                "Content-Type": "application/json",
                "Access-Control-Allow-Origin": "*",
            }

            fetch(url, {
                    method: "POST",
                    headers: headers,
                    mode: "cors",
                    body: JSON.stringify({}),
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`)
                    }
                    return response.json()
                })
                .then((responseData) => {
                    console.log("POST request successful!")
                    console.log("Response data:", responseData.invitation_url)
                    const invitation_url = responseData.invitation_url
                    const qrcode = new QRCode(document.getElementById('qrcode'), {
                        text: `${invitation_url}`,
                        width: 300,
                        height: 300,
                        colorDark: '#000',
                        colorLight: '#fff',
                        correctLevel: QRCode.CorrectLevel.H
                    });
                })
                .catch((error) => {
                    console.error("Error:", error)
                })
        }

        fetchConnectionAndGenerateQR()

        let webSocket = new WebSocket("ws://10.123.10.106:4001/ws");

        webSocket.onopen = function(event) {
            console.log(`[message] Data received from server: ${event.data}`)
            const actualData = JSON.parse(event.data)
            //console.log(actualData)

            if (actualData.topic === "present_proof_v2_0") {
                if (actualData.payload.state === "presentation-received") {
                    //console.log(actualData.payload)
                    // console.log(
                    //   actualData.payload.by_format.pres.indy.requested_proof
                    //     .revealed_attr_groups["attrProp1"].values
                    // )

                    const compressedData =
                        actualData.payload.by_format.pres.indy.requested_proof
                        .revealed_attr_groups["attrProp1"].values

                    let connection_id = actualData.payload.connection_id
                    let dob = compressedData["dob"].raw
                    let student_id = compressedData["student_id"].raw
                    let gender = compressedData["gender"].raw
                    let email = compressedData["email"].raw
                    let student_name = compressedData["student_name"].raw

                    console.log(dob)
                    console.log(connection_id)
                    //Send Post Request to API
                    const payload = {
                        email: email,
                        dob: dob,
                        student_id: student_id,
                        gender: gender,
                        student_name: student_name,
                        connection_id: connection_id,
                    }
                    console.log(`Credential Received`)
                    console.log(payload)

                    sendToBackend(payload)
                }
            } else if (actualData.topic === "connections") {
                if (actualData.payload.state === "active") {
                    const connection_id = actualData.payload.connection_id
                    console.log("SENDING VERIFICATION")
                    sendPresentation(connection_id)
                }
            }

        };

        function sendPresentation(connection_id) {
            console.log("Fetching now")

            const url = "http://10.123.10.106:4001/present-proof-2.0/send-request"

            const headers = {
                "Content-Type": "application/json",
                "Access-Control-Allow-Origin": "*",
            }

            const payloadBody = {
                comment: "Request for SSI Login",
                connection_id: `${connection_id}`,
                presentation_request: {
                    indy: {
                        name: "Verifying your Student Card",
                        version: "1.0",
                        requested_attributes: {
                            attrProp1: {
                                names: ["email", "gender", "student_id", "student_name", "dob"],
                                restrictions: [{
                                    cred_def_id: "NypRCRGykSwKUuRBQx2b9o:3:CL:96:student_card",
                                }, ],
                            },
                        },
                        requested_predicates: {},
                    },
                },
                trace: false,
            }

            fetch(url, {
                    method: "POST",
                    headers: headers,
                    mode: "cors",
                    body: JSON.stringify(payloadBody),
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`)
                    }
                    return response.json()
                })
                .then((responseData) => {
                    console.log("POST request successful!")
                    console.log("Response data:", responseData)
                })
                .catch((error) => {
                    console.error("Error:", error)
                })
        }

        function sendToBackend(payloadBody) {
            console.log("Sending to Backend Now")

            const url = "http://localhost:8000/login_ssi"
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const headers = {
                "Content-Type": "application/json",
                "Access-Control-Allow-Origin": "*",
                'X-CSRF-TOKEN': csrfToken,
            }

            fetch(url, {
                    method: "POST",
                    headers: headers,
                    mode: "cors",
                    body: JSON.stringify(payloadBody),
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`)
                    }
                    return response.json()
                })
                .then((responseData) => {
                    console.log("POST request successful!")
                    console.log("Response data:", responseData)

                    window.location.href = 'http://localhost:8000/stud_homepage'

                })
                .catch((error) => {
                    console.error("Error:", error)
                })

            
        }

        webSocket.onmessage = function(event) {
            //console.log(event.data);
            const actualData = JSON.parse(event.data)
            if (actualData.topic === "present_proof_v2_0") {
                if (actualData.payload.state === "presentation-received") {
                    //console.log(actualData.payload)
                    console.log(
                        actualData.payload.by_format.pres.indy.requested_proof
                        .revealed_attr_groups["attrProp1"].values
                    )

                    const compressedData =
                        actualData.payload.by_format.pres.indy.requested_proof
                        .revealed_attr_groups["attrProp1"].values

                    let connection_id = actualData.payload.connection_id
                    let dob = compressedData["dob"].raw
                    let student_id = compressedData["student_id"].raw
                    let gender = compressedData["gender"].raw
                    let email = compressedData["email"].raw
                    let student_name = compressedData["student_name"].raw

                    console.log(dob)
                    console.log(connection_id)
                    //Send Post Request to API
                    const payload = {
                        email: email,
                        dob: dob,
                        student_id: student_id,
                        gender: gender,
                        name: student_name,
                        connection_id: connection_id,
                    }

                    sendToBackend(payload)
                }
                //console.log(JSON.stringify(actualData))
            }
        };
    </script>

@endsection
