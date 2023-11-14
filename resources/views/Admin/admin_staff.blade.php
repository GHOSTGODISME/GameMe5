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
<h1>Staff</h1>
<a href="{{ route('admin_add_staffs') }}">
    <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
</a>
<form action="{{ route('admin_staff_search') }}" method="GET">
    <input type="text" name="search" placeholder="Search by name">
    <button type="submit" class="search-button">Search</button>
</form>
</div>

<!-- In your Blade view (resources/views/admin/students/index.blade.php) -->
<table class="report-table">
    <thead>
        <tr>
            <th class="bordered">No</th>
            <th class="bordered">Staff ID</th>
            <th class="bordered">Staff Name</th>
            <th class="bordered">Gender</th>
            <th class="bordered">Email</th>
           
        </tr>
    </thead>
    <tbody>
        @foreach ($staffs as $staff)
            <tr>
                <td class="bordered">{{ $loop->index + 1 }}</td>
                <td class="bordered">{{ $staff->id }}</td>
                <td class="bordered">{{ $staff->name }}</td>
                <td class="bordered">{{ $staff->gender}}</td>
                <td class="bordered">{{ $staff->email }}</td>
                <td class="button-container" style="border:none; padding:0; margin:0;">
                    <a href="{{ route('admin_edit_staff', ['staff' => $staff->id]) }}" class="update-button">Update</a>
                    <button onclick="confirmAndSubmit({{ $staff->id }})">Remove</button>
                </td>
            </tr>
        @endforeach
        <!-- Add more rows as needed -->
    </tbody>
</table>


<script>
    function confirmAndSubmit(staffId) {
    if (confirm("Are you sure you want to remove this staff?")) {
        $.ajax({
            url: "{{ route('admin_destroy_staff') }}",
            method: 'POST',
            data: {
                staffId: staffId,
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