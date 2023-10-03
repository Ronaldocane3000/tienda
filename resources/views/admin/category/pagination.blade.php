<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($categories->isEmpty())
            <tr>
                <td colspan="5" class="text-center align-middle">No se encontraron categorías.</td>
            </tr>
        @else
            @foreach ($categories as $item)
                <tr>
                    <td>{{ $categories->firstItem() + $loop->index }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>
                        <img src="{{ asset('assets/uploads/category/' . $item->image) }}" class="cate-image" alt="Image here">
                    </td>
                    <td>
                        <a href="{{ url('edit-category/' . $item->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ url('delete-category/' . $item->id) }}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $categories->links() }}
