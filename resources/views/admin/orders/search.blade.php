
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order Date</th>
            <th>Tracking Number</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($orders->isEmpty())
            <tr>
                <td colspan="5" class="text-center align-middle">No se encontraron products.</td>
            </tr>
        @else
            @foreach ($orders as $item)
                <tr>
                    <td>{{ date('d-m-Y', strtotime($item->created_at)) }} </td>
                    <td>{{ $item->tracking_no }} </td>
                    <td>{{ $item->total_price }}</td>
                    <td>{{ $item->status == '0' ? 'pending' : 'completed' }} </td>
                    <td>
                        <a href="{{ url('admin/view-order/' . $item->id) }}" class="btn btn-primary">View</a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
