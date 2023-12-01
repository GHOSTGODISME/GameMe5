<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<device-width>, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <style scoped>
        body {
            display: grid;
            place-items: center;
            background: linear-gradient(90deg, #13C1B7 0%, #87DFA8 100%);
        }

        .content-body {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            gap: 80px;
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
    </style>
</head>

<body>
    {{-- for header template --}}

    <div class="content-body">
        <div><img src ="img/logo_header.png" alt="Logo"></div>
        <form method="GET" action="{{ route('create-interactive-session') }}"
            style="display: flex; flex-direction: column; justify-content: flex-end; align-items: center; gap: 50px;">
            @csrf
            <input type="text" name="title" class="form-control input-style" placeholder="Title">
            <button type="submit" class="btn btn-dark btn-style">Create Session</button>
        </form>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>


</body>

</html>
