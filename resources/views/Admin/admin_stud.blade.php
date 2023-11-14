@extends('Layout/admin_master')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .title_bar{
    display: flex;
    flex-direction: row;
    }
    .add_icon{
        width:30px;
        height:30px;
        align-self: center;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class = title_bar>
<h1>Students</h1>
<a href="{{ route('admin_add_stud') }}">
    <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
</a>
<form action="{{ route('admin_stud_search') }}" method="GET">
    <input type="text" name="search" placeholder="Search by name">
    <button type="submit" class="search-button">Search</button>
</form>
</div>

<!-- In your Blade view (resources/views/admin/students/index.blade.php) -->
<table class="report-table">
    <thead>
        <tr>
            <th class="bordered">No</th>
            <th class="bordered">Student ID</th>
            <th class="bordered">Student Name</th>
            <th class="bordered">Gender</th>
            <th class="bordered">Email</th>
           
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
                <td class="button-container" style="border:none; padding:0; margin:0;">
                    <a href="{{ route('admin_edit_stud', ['student' => $student->id]) }}" class="update-button">Update</a>
                    <button onclick="confirmAndSubmit({{ $student->id }})">Remove</button>
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