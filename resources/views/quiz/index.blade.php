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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style scoped>
        .lecturer-index-body {
            width: 80%;
            margin: auto;
            margin-top: 20px;
        }

        .add-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px;
            padding: 10px 20px;
            gap: 10px;
        }

        .search-top-container {
            margin: 20px;
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            align-items: center;
        }

        .edit-delete-btn {
            margin: 3px;
            padding: 10px;
        }

        .lecturer-index-table-container p:last-child {
            text-align: center;
            font-size: 24px;
            color: #b0b0b0;
            margin: 30px;
        }
    </style>
</head>

<body>
    @include('Layout/lect_header')

    <div class="lecturer-index-body">
        <h1>Available Quizzes</h1>

        <div class="search-top-container">
            <div class="search-container">
                <form action="{{ route('find-quiz') }}" method="GET">
                    <label>
                        <span class="fa fa-search"></span>
                        <input type="search" placeholder="Search" name="search"
                            value="{{ request()->input('search') }}">
                    </label>
                    <button type="submit" class="btn btn-dark"><span class="fa fa-search"></span> Search</button>
                </form>
            </div>


            <a href="{{ route('create-quiz') }}" class="btn btn-dark add-btn"><i class="fa-solid fa-plus"></i>Add
                Quiz</a>
        </div>

        <div class="table-responsive lecturer-index-table-container">
            @if (count($quizzes) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th width="10%">No.</th>
                            <th width="45%">Title</th>
                            <th width="15%">Visibility</th>
                            <th width="15%">Modified Date</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quizzes as $quiz)
                            <tr>
                                <td>{{ $quiz->id }}</td>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->visibility }}</td>
                                <td>{{ ucfirst($quiz->visibility) }}</td>

                                <td>{{ $quiz->updated_at->format('Y-m-d H:i:s') }}</td>

                                <td>
                                    <a href="{{ route('view-quiz', ['id' => $quiz->id]) }}"
                                        class="btn btn-info edit-delete-btn">
                                        View</a>
                                    <a href="{{ route('edit-quiz', ['id' => $quiz->id]) }}"
                                        class="btn btn-info edit-delete-btn">
                                        <i class="fa fa-edit"></i></a>
                                    <a class="btn btn-danger edit-delete-btn"
                                        onclick="confirmDelete({{ $quiz->id }})">
                                        <i class="fa fa-trash"></i></a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No records found.</p>
            @endif
        </div>
    </div>

    <!-- Add this in the head section of your HTML file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
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
</body>

</html>
