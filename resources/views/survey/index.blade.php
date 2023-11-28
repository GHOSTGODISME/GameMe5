
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Survey Management</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style scoped>
        .header_container {
    width: 100%;
    height: 100px;
    display: flex;
    justify-content: space-between;
    background: linear-gradient(to right, #13C1B7, #87DFA8);
}

.lecturer-index-body {
    width: 80%;
    margin: auto;
    margin-top: 20px;
}

.search-container label {
    display: grid;
    grid-template: 1fr / auto 1fr;
    gap: 12px;
    border: 1px solid #CFD5DB;
    border-radius: 5px;
    background: #fafafa;
    padding: 12px;
    color: #6C757D;
    cursor: text;
    align-items: center;
    width: 250px;

}

.search-container label:focus-within {
    border: 1px solid #000;
}

.search-container label>input {
    outline: none;
    border: none;
    background: transparent;
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

.lecturer-index-table-container p:last-child{
    text-align: center;
    font-size: 24px;
    color: #b0b0b0;
    margin: 30px;
}

</style>
</head>
<body>
    <div class="header_container">
        <img src="{{ asset('img/logo_header.png') }}" alt="Logo Header">
        <img src="{{ asset('img/hamburger.png') }}" alt="favicon">
    </div>

    <div class="lecturer-index-body">
        <h1>Surveys</h1>

        <div class="search-top-container">
            <div class="search-container">
                <form action="{{ route('search-survey') }}" method="GET">
                    <label>
                        <span class="fa fa-search"></span>
                        <input type="search" placeholder="Search" name="search" value="{{ request()->input('search') }}">
                    </label>
                    <button type="submit" class="btn btn-dark"><span class="fa fa-search"></span> Search</button>
                </form>
            </div>
            

                    <a href="{{ route('create-survey') }}" class="btn btn-dark add-btn"><i
                        class="fa-solid fa-plus"></i>Add Survey</a>

        </div>

        <div class="table-responsive lecturer-index-table-container">
            @if(count($surveys) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th width="10%">No.</th>
                        <th width="45%">Title</th>
                        <th width="15">Visibility</th>
                        <th width="15%">Modified Date</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surveys as $survey)
                        <tr>
                            <td>{{ $survey->id }}</td>
                            <td>{{ $survey->title }}</td>
                            <td>{{ $survey->visibility }}</td>
                            <td>{{ $survey->updated_at->format('Y-m-d H:i:s') }}</td>

                            <td>
                                <!-- Link to the detailed survey page -->
                                
                                <a href="{{ route('student-view-survey', ['id' => $survey->id]) }}" class="btn btn-info edit-delete-btn">Response</a>
                                
                                <a href="{{ route('show-response-survey', ['id' => $survey->id]) }}" class="btn btn-info edit-delete-btn">Show Response</a>
    
                                <a href="{{ route('edit-survey', ['id' => $survey->id]) }}" class="btn btn-info edit-delete-btn"><i class="fa fa-edit"></i></a>
                                <!-- Delete button -->
                                <a class="btn btn-danger edit-delete-btn" onclick="confirmDelete({{ $survey->id }})"><i class="fa fa-trash"></i></a>
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
    <link rel="stylesheet"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
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
</body>
</html>
