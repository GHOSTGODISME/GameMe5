<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


</head>
<body>
    <div class="container">
        <h1>Available Fortune Wheels</h1>

        <!-- Button to add a new fortune wheel -->
        <a href="{{ route('create-fortune-wheel') }}" class="btn btn-primary">Add Wheel</a>

        <!-- Table to display available fortune wheels -->
        @if(count($fortuneWheels) > 0)
        <!-- Table to display available fortune wheels -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Creation Date</th>
                    <th>Update Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fortuneWheels as $fortuneWheel)
                    <tr>
                        <td>{{ $fortuneWheel->id }}</td>
                        <td>{{ $fortuneWheel->title }}</td>
                        <td>{{ $fortuneWheel->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $fortuneWheel->updated_at->format('Y-m-d H:i:s') }}</td>
        
                        <td>
                            <!-- Link to the detailed create wheel page -->
                            <a href="{{ route('edit-fortune-wheel', ['id' => $fortuneWheel->id]) }}" class="btn btn-info">Edit</a>
                            <!-- Delete button -->
                            <button class="btn btn-danger" onclick="confirmDelete({{ $fortuneWheel->id }})">Delete</button>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this record?')) {
            // Make an AJAX request to delete the record
            axios.delete('{{ url('delete-fortune-wheel') }}/' + id, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                // Handle success, e.g., remove the deleted row from the table
                console.log('Record deleted successfully:', response.data);
                location.reload(); // Reload the page
            })
            .catch(error => {
                // Handle error
                console.error('Error deleting record:', error);
            });
        }
    }
</script>


    
    
    
</body>
</html>