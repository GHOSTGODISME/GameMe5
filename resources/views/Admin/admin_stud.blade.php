@extends('Layout/admin_master')

@section('title', 'Admin Dashboard')

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

    .stud-page a {
    text-decoration: underline;
    /* Add any other styles for the current page link */
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class = title_bar>
    <div class="sub_cont">
        <h1 class="admin_subtitle3">Students</h1>
        <a href="{{ route('admin_add_stud') }}">
            <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
        </a>
    </div>
    <form action="{{ route('admin_stud_search') }}" method="GET" class="search-form">
        <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
        <input type="text" name="search" class="search-input" placeholder="Search">
        <button type="submit" class="search-button">Search</button>
    </form>
</div>

<!-- In your Blade view (resources/views/admin/students/index.blade.php) -->
<table class="admin_table">
    <thead>
        <tr>
            <th class="bordered">No</th>
            <th class="bordered">Student ID</th>
            <th class="bordered">Student Name</th>
            <th class="bordered">Gender</th>
            <th class="bordered">Email</th>
            <th class="bordered">Action</th>
        </tr>
    </thead>
    <tbody>
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
        @endforeach
        <!-- Add more rows as needed -->
    </tbody>
</table>


<script>
    function confirmAndSubmit(studentId) {
    if (confirm("Are you sure you want to remove this student?")) {
        $.ajax({
            url: "{{ route('admin_destroy_student') }}",
            method: 'POST',
            data: {
                studentId: studentId,
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                if (response.success) {
                    alert('Profile removed successfully!');
                    location.reload(); // This will reload the current page
                } else {
                    alert('Error removing profile: ' + response.message);
                }
            },
            error: function () {
                alert('Error removing profile');
            }
        });
    }
}
</script>






@endsection