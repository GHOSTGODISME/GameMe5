<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>@yield('title', 'GameMe5')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">



</head>
<style>
    html,
    body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .content {
        margin-left: 90px;
        margin-top: 30px;
        margin-right: 90px;
    }

    .nav_container {
        display: flex;
        flex-direction: row;

    }

    .admin_title {
        color: var(--Button, #2A2A2A);
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .admin_subtitle1 {
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .admin_subtitle2 {
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-left: 50px;
    }

    .admin_subtitle3 {
        color: #000;
        font-family: 'Inter';
        font-size: 30px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .bordered {
        color: var(--Thirdly, #656565);
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .admin_table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .admin_table th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .admin_table td {
        border-bottom: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .admin_table th {
        background-color: #f2f2f2;
    }

    .admin_table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .admin_subtitle1 a,
    .admin_subtitle2 a {
        text-decoration: none;
    }

    .admin_subtitle1 a:hover,
    .admin_subtitle2 a:hover {
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .admin_subtitle1 a:visited,
    .admin_subtitle2 a:visited {
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .title_bar {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
    }

    .add_icon {
        width: 30px;
        height: 30px;
        align-self: center;
    }

    .sub_cont {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .add_link {
        padding: 0;
        margin: 0;
    }

    .search-form {
        display: flex;
        align-items: center;
        position: relative;
    }

    /* Style for the search icon */
    .search_icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        /* Adjust the width as needed */
        height: 20px;
        /* Adjust the height as needed */
    }

    /* Style for the input */
    .search-input {
        padding: 10px 40px;
        /* Adjust padding to accommodate the icon */
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
</style>

<body>
    @include('Layout/lect_header')
    <div class="content">
        <h1 class= "admin_title"> Available Quizzes </h1>
        <div class = "nav_container">
            <h3
                class="admin_subtitle1">
                <a href="{{ route('own-quiz') }}">Owned Quiz</a>
            </h3>
            <h3
                class="admin_subtitle2">
                <a href="{{ route('all-quiz') }}">Quiz Bank</a>
            </h3>

        </div>
        <!-- Page Content -->
        @yield('content')
    </div>
</body>

</html>
<script>
    function toggleMenu(icon) {
        const menu = icon.nextElementSibling;
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }
</script>
