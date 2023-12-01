@extends('Layout/lect_master')

@section('title', 'Report Dashboard')

@section('content')
<style>
    .title_bar{
    display: flex;
    flex-direction: row;
    width:100%;
    justify-content: space-between;
    }
    .add_icon{
        width:30px;
        height:30px;
        align-self: center;
    }

    .sub_cont{
    display: flex;
    flex-direction: row;   
    justify-content: space-between;
    align-items: center;
    width:200px; 
    }

    .add_link{
        padding: 0;
        margin:0;
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

 
    .bordered{
        color: var(--Thirdly, #656565);
        font-family: 'Roboto';
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: normal; 
    }

.report_table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.report_table th{
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.report_table td {
    border-bottom: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.report_table th {
    background-color: #f2f2f2;
}

.report_table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class = title_bar>
    <div class="sub_cont">
        <h1 class="admin_subtitle3">Report</h1>
    </div>
    <form action="{{ route('admin_stud_search') }}" method="GET" class="search-form">
        <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
        <input type="text" name="search" class="search-input" placeholder="Search">
        <button type="submit" class="search-button">Search</button>
    </form>
</div>



<table class="report_table">
    <thead>
        <tr>
            <th class="bordered">No</th>
            <th class="bordered">Course ID</th>
            <th class="bordered">Quiz Name</th>
            <th class="bordered">Type</th>
            <th class="bordered">Creation Date</th>
            <th class="bordered">Created By</th>
        </tr>
    </thead>
    <tbody>
        {{-- need change to report 
            @foreach ($students as $student)
            <tr>
                <td class="bordered">{{ $loop->index + 1 }}</td>
                <td class="bordered">{{ $student->id }}</td>
                <td class="bordered">{{ $student->name }}</td>
                <td class="bordered">{{ $student->gender}}</td>
                <td class="bordered">{{ $student->email }}</td>
                <td class="button-container">
                <div class="menu-icon" onclick="toggleMenu(this)">
                        <img src="img/threedot_icon.png" alt="three_dot"> <!-- Unicode character for three dots -->
                </div>
                <div class="action-menu">
                    <a href="{{ route('admin_edit_stud', ['student' => $student->id]) }}" class="update-button">Update</a>
                    <a href="#" onclick="confirmAndSubmit({{ $student->id }})">Remove</a>
                </div>
                </td>
            </tr>
        @endforeach --}}
        <!-- Add more rows as needed -->
    </tbody>
</table> 


<script>
</script>






@endsection