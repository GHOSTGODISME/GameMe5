<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>GameMe5</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <style scoped>
        body {
            background: linear-gradient(to right, #00C6FF, #0082FF, #0072FF);
            margin: 0;
            padding: 0;
        }

        .content-body {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            gap: 80px;
            margin-top: 100px;
        }

        img {
            height: 80;
        }

        .input-style {
            width: 350px;
            text-align: center;
            padding: 10px;
            font-size: 22px;
        }

        .btn-style {
            width: 200px;
            height: 50px;
        }




        #txt_int_code {
            padding: 25px 15px 20px 15px;
            border: 1px solid #BFBFBF;
            border-radius: 10px;
            box-sizing: border-box;
            background: #FAFAFA;
            width: 500px;
            height: 40px;
            flex-shrink: 0;
            margin-top: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
            /* Replace 'Your Font' with the desired font name */
            font-size: 25px;
            /* Adjust the font size as needed */
            font-weight: bold;
            /* Adjust the font weight as needed */
            text-align: center;
            /* Center the text horizontally */
        }

        #txt_int_code:focus {
            outline: none;
            border-color: #007bff;
            /* Change the border color on focus */
        }

        #txt_int_code::placeholder {
            color: #A3A3A3;
            font-family: 'Roboto';
            font-size: 25px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            text-align: center;
        }

        .stud_big_cont {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .button_general {
            width: 300px;
            height: 45px;
            flex-shrink: 0;
            border-radius: 8px;
            background: var(--Button, #2A2A2A);
            color: #FEFEFE;
            font-family: 'Roboto';
            font-size: 24px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }
    </style>

</head>


<body>
    @include('Layout/student_header')
    {{-- for header template --}}
    <div class="content-body">
        <div class="stud_big_cont">
            <img src="img/logo_stud.png" alt="logo">

            <form method="GET" action="{{ route('join-interactive-session') }}"
                style="display: flex; flex-direction: column; justify-content: flex-end; align-items: center; gap: 50px;">
                @csrf
                <input type="text" name="code" id="txt_int_code" class="form-control input-style"
                    placeholder="Code">
                <button type="submit" class="button_general">Join Session</button>
            </form>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @if ($errors->has('code'))
        <script>
            // Use SweetAlert2 to display a modal
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ $errors->first('code') }}',
                customClass: {
                    title: 'custom-title-class',
                    content: 'custom-content-class',
                },
            });
        </script>
    @endif


</body>

</html>
