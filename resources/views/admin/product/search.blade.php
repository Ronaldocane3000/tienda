<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Categoria</th>
            <th>Name</th>
            <th>Description</th>
            <th>Selling Price</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @if ($products->isEmpty())
            <tr>
                <td colspan="5" class="text-center align-middle">No se encontraron products.</td>
            </tr>
        @else
            @foreach ($products as $item)
                <tr>
                    <td>{{ $item->id }} </td>
                    <td>{{ $item->Category->name }}</td>
                    <td>{{ $item->name }} </td>
                    <td>{{ $item->description }} </td>
                    <td>{{ $item->selling_price }} </td>
                    <td>
                        <img src="{{ asset('assets/uploads/product/' . $item->image) }}" class="cate-image"
                            alt="Image here">
                    </td>
                    <td>
                        <a href="{{ url('edit-product/' . $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{ url('delete-product/' . $item->id) }}" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
