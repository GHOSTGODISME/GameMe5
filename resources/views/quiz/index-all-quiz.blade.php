@extends('Layout/quiz_index_master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


@section('title', 'Available Quizzes')

@section('content')
    <style>
        .admin_subtitle2{
    text-decoration: underline;
}
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class = "title_bar">
        <div class="sub_cont">
            <h1 class="admin_subtitle3">All Quizzes</h1>
        </div>
        <form action="{{ route('all-quiz-search') }}" method="GET" class="search-form">
            <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
            <input type="text" name="search" class="search-input" placeholder="Search">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    <div class="table-responsive ">
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

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this quiz?')) {
                // Make an AJAX request to delete the quiz
                axios.delete('{{ url('delete-quiz') }}/' + id, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    // Handle success, e.g., remove the deleted row from the table
                    console.log('quiz deleted successfully:', response.data);
                    location.reload(); // Reload the page
                })
                .catch(error => {
                    // Handle error
                    console.error('Error deleting quiz:', error);
                });
            }
        }
    </script>

@endsection
