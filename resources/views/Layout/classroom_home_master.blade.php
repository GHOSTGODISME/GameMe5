<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>@yield('title', 'GameMe5')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
       html,body{
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .content{
        margin-left:90px;
        margin-top:30px; 
        margin-right:90px; 
        padding-bottom:50px;
    }

    .title_container{
        display:flex;
        flex-direction:row;
        width:100%;
        justify-content: space-between;
    }

    
    .class_title{
        color: var(--Button, #2A2A2A);
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .class_subtitle{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-decoration:underline;
    }

    .join-form {
    display: flex;
    flex-direction: row;
    height:35px;
    width:300px;
    }

.join-form input {
    width: 100%;
    padding: 5px;
    padding-left:10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-right: none;
    border-radius: 8px 0 0 8px;
    font-size: 16px;
}

.join-form button {
    background-color: #4caf50;
    color: #fff;
    padding:5px;
    border: none;
    border-radius: 0px 8px 8px 0;
    cursor: pointer;
    font-size: 16px;
    width:100px;

   
}

.join-form button:hover {
    background-color: #45a049;
}
</style>

<body>
@include('Layout/student_header')

<div class="content">
<h1 class="class_title">Classroom</h1>
    <div class="title_container">
        <h3 class="class_subtitle">Classes</h3>
        <form class="join-form" action="{{ route('join_class') }}" method="POST">
            @csrf
            <input type="text" id="class_code" name="class_code" placeholder="Enter Class Code">
            <button type="submit">Join</button>
        </form>
    </div>
    @error('class_code') {{-- Note the correct usage --}}
    <script>
         showErrorPopup("{{ __('Invalid Class Code!') }}");
        function showErrorPopup(errorMessage) {
    Swal.fire({
        title: 'Error!',
        text: errorMessage,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}
    </script>
@enderror

@if(session('success'))
    <script>
        showSuccessPopup("{{ session('success') }}");
        function showSuccessPopup(successMessage) {
            Swal.fire({
                title: 'Success!',
                text: successMessage,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    </script>
@endif

    <!-- Page Content -->
    @yield('content')
</div>    


<script>   
 
</script>
</body>

</html>