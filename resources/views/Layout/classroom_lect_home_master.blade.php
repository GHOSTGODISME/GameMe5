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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
        align-items: center;
    }

    .title_container a{
       margin:0;
       padding:0;
    }


    .class_title{
        color: var(--Button, #2A2A2A);
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-bottom: 0;
      
    }

    .class_subtitle{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-decoration:underline;
        margin-right:75%;
        align-self: flex-end;
    }


    .add_icon{
        width:30px;
        height:30px;
        align-self: center;
    }

    .sub_cont{
    display: flex;
    flex-direction: row;   
    align-items: center;
    
    }

    .add_link{
        padding: 0;
        margin:0;
    }

    .search-form {
        position: relative;
        margin-top:15px;
        margin-right:10px;
    }

    /* Style for the search icon */
    .search_icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px; /* Adjust the width as needed */
        height: 20px; /* Adjust the height as needed */
    }

    /* Style for the input */
    .search-input {
        padding: 10px 40px; /* Adjust padding to accommodate the icon */
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-right: 10px;
        font-size: 14px;
    }

    /* Style for the button */
    .search-button {
        padding: 10px 15px;
        background-color: #000;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .noResultMsg{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    
</style>

<body>
@include('Layout/lect_header')

<div class="content">
    <h1 class="class_title">Classroom</h1>
        <div class="title_container">
            <h3 class="class_subtitle">Classes</h3>
            <form action="{{ route('lect_search_class') }}" method="GET" class="search-form">
                <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
                <input type="text" name="search" class="search-input" placeholder="Search">
            </form>
            <a href="{{ route('lect_add_class') }}">
                <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
            </a>
        </div>
        <!-- Page Content -->
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
    
    {{-- Check if the search results are empty --}}
    @if($filteredClassrooms->isEmpty())
        <p class="noResultMsg">No results found.</p>
    @else
        {{-- Display your search results --}}
        @yield('content')
    @endif
    </div>       
</body>
</html>