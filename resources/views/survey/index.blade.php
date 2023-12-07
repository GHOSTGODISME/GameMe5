@extends('Layout/index_master')

@section('title', 'Available Surveys')

@section('content')
    <h1 class= "admin_title">Surveys</h1>

    <div class = "title_bar">
        <div>
            <a href="{{ route('create-survey') }}" class="btn btn-dark add-btn"><i
                class="fa-solid fa-plus"></i>Add Survey</a>
        </div>
        <form action="{{ route('search-survey') }}" method="GET" class="search-form">
            <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
            <input type="text" name="search" class="search-input" placeholder="Search">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>

    <div class="table-responsive ">
    @if(count($surveys) > 0)
    <table class="admin_table">
        <thead>
            <tr>
                <th class="bordered">No</th>
                <th class="bordered">Title</th>
                <th class="bordered">Status</th>
                <th class="bordered">Modified Date</th>
                <th class="bordered">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surveys as $survey)
                <tr>
                    <td class="bordered">{{ $loop->index + 1 }}</td>
                    <td class="bordered">{{ $survey->title }}</td>
                    <td class="bordered">{{ ucfirst($survey->status) }}</td>
                    <td class="bordered">{{ $survey->updated_at->format('Y-m-d H:i:s') }}</td>

                    <td>
                        <a href="{{ route('student-view-survey', ['id' => $survey->id]) }}" class="btn btn-info edit-delete-btn">Response</a>
                        <a href="{{ route('edit-survey', ['id' => $survey->id]) }}" class="btn btn-info edit-delete-btn"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger edit-delete-btn" onclick="confirmDelete({{ $survey->id }})"><i class="fa fa-trash"></i></a>
            </td>
                </tr>
            @endforeach
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
            if (confirm('Are you sure you want to delete this survey?')) {
                // Make an AJAX request to delete the survey
                axios.delete('{{ url('delete-survey') }}/' + id, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    // Handle success, e.g., remove the deleted row from the table
                    console.log('Survey deleted successfully:', response.data);
                    location.reload(); // Reload the page
                })
                .catch(error => {
                    // Handle error
                    console.error('Error deleting survey:', error);
                });
            }
        }
    </script>

@endsection
