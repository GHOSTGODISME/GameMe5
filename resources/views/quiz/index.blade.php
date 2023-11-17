
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quiz Management</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>
    <div class="container">
        <h1>Available Quizs</h1>

        <!-- Button to add a new quiz -->
        <a href="{{ route('create-quiz') }}" class="btn btn-primary">Create quiz</a>

        <!-- Table to display available quizs -->
        @if(count($quizzes) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Visibility</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->id }}</td>
                        <td>{{ $quiz->title }}</td>
                        <td>{{ $quiz->description }}</td>
                        <td>{{ $quiz->visibility }}</td>
                        <td>{{ $quiz->created_at->format('Y-m-d H:i:s') }}</td>
        
                        <td>
                            <!-- Link to the detailed quiz page -->
                            
                            {{-- <a href="{{ route('student-view-quiz', ['id' => $quiz->id]) }}" class="btn btn-info">Response</a> --}}
                            
                            {{-- <a href="{{ route('show-response-quiz', ['id' => $quiz->id]) }}" class="btn btn-info">Show Response</a> --}}

                            <a href="{{ route('edit-quiz', ['id' => $quiz->id]) }}" class="btn btn-info">Edit</a>
                            <!-- Delete button -->
                            <button class="btn btn-danger" onclick="confirmDelete({{ $quiz->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No records found.</p>
    @endif
    </div>

    <!-- Add this in the head section of your HTML file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <link rel="stylesheet"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
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
</body>
</html>
