@extends('Layout/index_master')
@section('content')
    <h1 class= "admin_title">Fortune Wheels</h1>

    <div class = "title_bar">
        <div>
            <a href="{{ route('create-fortune-wheel') }}" class="btn btn-dark add-btn"><i class="fa-solid fa-plus">
                </i>Add Wheel</a>
        </div>
        <form action="{{ route('search-fortune-wheel') }}" method="GET" class="search-form">
            <img class="search_icon" src="img/search_icon.png" alt="search_favicon">
            <input type="text" name="search" class="search-input" placeholder="Search">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>


        <div class="table-responsive">
            @if (count($fortuneWheels) > 0)
                <table class="admin_table">
                    <thead>
                        <tr>
                            <th class="bordered">No</th>
                            <th class="bordered">Title</th>
                            <th class="bordered">Modified Date</th>
                            <th class="bordered">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fortuneWheels as $fortuneWheel)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $fortuneWheel->title }}</td>
                                <td>{{ $fortuneWheel->updated_at->format('Y-m-d H:i:s') }}</td>

                                <td>
                                    <a href="{{ route('edit-fortune-wheel', ['id' => $fortuneWheel->id]) }}"
                                        class="btn btn-info edit-delete-btn">
                                        <i class="fa fa-edit"></i></a>
                                    <a class="btn btn-danger edit-delete-btn"
                                        onclick="confirmDelete({{ $fortuneWheel->id }})">
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
@endsection
