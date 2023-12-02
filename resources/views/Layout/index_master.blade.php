<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <title>@yield('title', 'GameMe5')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    

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

    .title_bar {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
        /* align-items: center; */
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
        
        <!-- Page Content -->
        @yield('content')
    </div>
</body>

</html>
<script>
</script>
