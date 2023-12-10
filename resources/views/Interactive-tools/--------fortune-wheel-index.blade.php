@extends('Layout/interactive_tools_master')
@section('content')

    <div class="lecturer-index-body">
        <h1>Fortune Wheels</h1>

        <div class="search-top-container">
            <div class="search-container">
                <form action="{{ route('search-fortune-wheel') }}" method="GET">
                    <label>
                        <span class="fa fa-search"></span>
                        <input type="search" placeholder="Search" name="search" value="{{ request()->input('search') }}">
                    </label>
                    <button type="submit" class="btn btn-dark"><span class="fa fa-search"></span> Search</button>
                </form>
            </div>
            

            <a href="{{ route('create-fortune-wheel') }}" class="btn btn-dark add-btn"><i class="fa-solid fa-plus"></i>Add
                Wheel</a>
        </div>

        <div class="table-responsive lecturer-index-table-container">
            @if (count($fortuneWheels) > 0)
                <table class="table ">
                    <thead>
                        <tr>
                            <th width="10%">No.</th>
                            <th width="45%">Title</th>
                            <th width="30%">Modified Date</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fortuneWheels as $index => $fortuneWheel)
                            <tr>
                                <td>{{ $index + 1 }}</td>
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