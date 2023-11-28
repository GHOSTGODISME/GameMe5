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
    html,body{
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .content{
    margin-left:90px;
    margin-top:30px; 
    margin-right:90px; 
    }

    .nav_container{
        display: flex;
        flex-direction: row;

    }

    .admin_title{
        color: var(--Button, #2A2A2A);
        font-family: 'Roboto';
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .admin_subtitle1{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .admin_subtitle2{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-left:50px;
    }

    .admin_subtitle3{
        color: #000;
        font-family: 'Inter';
        font-size: 30px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }



    .bordered{
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

.admin_table th{
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

.button-container {
    position: relative;
    display: flex;
    align-items: center;
  }

  .menu-icon {
    cursor: pointer;
    font-size: 18px; /* Adjust the font size as needed */
    display: flex;
    align-items: start;
    margin:0;
    padding: 0;
    
  }

  .action-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #D9D9D9;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    display: none;
    width:100px;

  }

  .action-menu a {
    display: block;
    padding: 8px;
    text-decoration: none;
    color: #000;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 200;
    line-height: normal;
  }

  .action-menu a:hover {
    background-color: #f2f2f2;
  }

  .admin_subtitle1 a, .admin_subtitle2 a{
    text-decoration: none;
  }

  .admin_subtitle1 a:hover, .admin_subtitle2 a:hover{
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
  }

  .admin_subtitle1 a:visited, .admin_subtitle2 a:visited  {
        color: #5C5C5C;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
}

.label_admin_stud{
    color: #000;
    font-family: 'Roboto';
    font-size: 16px;
    font-style: normal;
    font-weight: 300;
    line-height: normal;
}

.admin_row{
    display:flex;
    flex-direction:row;
    width:50%;
    justify-content: space-between;
}

.studE_info{
    width:300px;
}

.admin_input{
    width:300px;
    border: 1px solid #000;
    border-radius: 8px;
    background: #FFF;
    height:30px;
    font-size: 14px;
    padding-left:10px;
   
}

    .comp-button-container {
        display: flex;
        width:350px;
        justify-content: space-between;
        margin-top:30px;
      
    }

    .confirm-button, .cancel-button {
        cursor: pointer;
        border: none;
    }

    .confirm-button {
        width: 150px;
        height: 35px;
        margin-top:40px;
        flex-shrink: 0;
        border-radius: 8px;
        background: var(--Button, #2A2A2A);
        color: #FEFEFE;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;  
      
    }

    .cancel-button {
        background-color: #dc3545;
        width: 150px;
        height: 35px;
        margin-top: 40px;
        flex-shrink: 0;
        border-radius: 8px;
        color: #FEFEFE;
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;  
        text-decoration: none; /* Fix the typo here */
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .success_message {
        color: #28a745;
        margin-top: 10px;
    }

    .styled-select {
    position: relative;
    display: inline-block;
    width: 300px; /* Adjust the width as needed */
    height:30px;
}

.styled-select select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 100%;
    padding-left:10px;
    border: 1px solid #000;
    border-radius: 8px;
    background-color: #fff;
    cursor: pointer;
    font-size: 14px;
    color: #333;
}

.styled-select::after {
    content: '\25BC'; /* Unicode character for down arrow */
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    font-size: 16px;
    color: #555;
    pointer-events: none;
}

.styled-date-input {
    position: relative;
    width: 300px; /* Adjust the width as needed */
    height:30px;
}

.styled-date-input input {
    width: 100%;
    padding: 10px;
    border: 1px solid #000;
    border-radius: 8px;
    background-color: #fff;
    font-size: 14px;
    color: #333;
}

.styled-date-input::before {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    font-size: 18px;
    color: #555;
    pointer-events: none;
}


</style>
<body>
@include('Layout/lect_header')
<div class="content">
<h1 class= "admin_title"> Admin Dashboard </h1>
<div class = "nav_container">
    <h3 class="admin_subtitle1 {{ in_array(request()->route()->getName(), ['admin_stud', 'admin_add_stud','admin_edit_stud']) ? 'stud-page' : '' }}">
        <a href="{{ route('admin_stud') }}">Students</a>
    </h3>
    <h3 class="admin_subtitle2 {{ in_array(request()->route()->getName(), ['admin_staff', 'admin_add_staffs','admin_edit_staff'])  ? 'staff-page' : '' }}">
        <a href="{{ route('admin_staff') }}">Staff</a>
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