@extends('Layout/quiz_index_master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


@section('title', 'Available Quizzes')

@section('content')
<style>
.admin_subtitle1{
    text-decoration: underline;
}


    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class = "title_bar">
        <div class="sub_cont">
            <h1 class="admin_subtitle3">Owned Quizzes</h1>
            <a class="add_link" href="{{ route('create-quiz') }}">
                <img class="add_icon" src="img/add_icon.png" alt="add_favicon">
            </a>
        </div>
        <form action="{{ route('own-quiz-search') }}" method="GET" class="search-form">
            <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
            <input type="text" name="search" class="search-input" placeholder="Search">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    <!-- In your Blade view (resources/views/admin/students/index.blade.php) -->
    @if(count($quizzes) > 0)
    <table class="admin_table">
        <thead>
            <tr>
                <th class="bordered">No</th>
                <th class="bordered">Title</th>
                <th class="bordered">Visibility</th>
                <th class="bordered">Modified Date</th>
                <th class="bordered">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quizzes as $quiz)
                <tr>
                    <td class="bordered">{{ $loop->index + 1 }}</td>
                    <td class="bordered">{{ $quiz->title }}</td>
                    <td class="bordered">{{ ucfirst($quiz->visibility) }}</td>
                    <td class="bordered">{{ $quiz->updated_at->format('Y-m-d H:i:s') }}</td>

                    <td>
                        <a href="{{ route('view-quiz', ['id' => $quiz->id]) }}" class="btn btn-info edit-delete-btn">
                            View</a>
                        <a href="{{ route('edit-quiz', ['id' => $quiz->id]) }}" class="btn btn-info edit-delete-btn">
                            <i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger edit-delete-btn" onclick="confirmDelete({{ $quiz->id }})">
                            <i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
            <!-- Add more rows as needed -->
        </tbody>
    </table>
    @else
    <p>No records found.</p>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script> 
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        console.log(@json(session('email')));
         function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you really want to delete this quiz?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Make an AJAX request to delete the quiz
            axios.delete('{{ url('delete-quiz') }}/' + id, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                // Handle success, e.g., remove the deleted row from the table
                Swal.fire({
                    title: 'Success!',
                    text: 'Quiz deleted successfully.',
                    icon: 'success',
                }).then(() => {
                    location.reload(); // Reload the page
                });
            })
            .catch(error => {
                // Handle error
                console.error('Error deleting quiz:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to delete quiz. Please try again.',
                    icon: 'error',
                });
            });
        }
    });
}
    </script>

@endsection
