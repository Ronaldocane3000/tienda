@extends('layouts.admin')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4>Order View</h4>
                        <a href="{{ url('orders') }}" class="btn btn-warning float-end">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h4>Shipping Details</h4>
                                <hr>
                                <label for="">First Name</label>
                                <div class="border">{{ $orders->fname }}</div>
                                <label for="">Last Name</label>
                                <div class="border">{{ $orders->lname }}</div>
                                <label for="">Email</label>
                                <div class="border">{{ $orders->email }}</div>
                                <label for="">Contact No.</label>
                                <div class="border">{{ $orders->phone }}</div>
                                <label for="">Shipping Address</label>
                                <div class="border">
                                    {{ $orders->address1 }},<br>
                                    {{ $orders->address2 }},<br>
                                    {{ $orders->city }}, <br>
                                    {{ $orders->state }},
                                    {{ $orders->country }},
                                </div>
                                <label for="">Zip Code</label>
                                <div class="border">{{ $orders->fname }}</div>
                            </div>
                            <div class="col-md-6">
                                <h4>Order Details</h4>
                                <hr>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Quantify</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        @foreach ($orders->orderitems as $item)
                                        <tr>
                                            <td>{{ $item->products->name }} </td>
                                            <td>{{ $item->qty }} </td>
                                            <td>{{ $item->price }}</td>
                                            <td>
                                                <img src="{{ asset('assets/uploads/product/' .$item->products->image) }}" width="50px" alt="Product Image">
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                            
                                    </tbody>
                                </table>
                                <h4 class="px-2"><span class="float-end">Grand Total: {{ $orders->total_price }}</span>
                                </h4>

                                <div class="mt-5 px-2">
                                    
                                <label for="">Order Status</label>
                                    <form action="{{url('update-order/'.$orders->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select class="form-select" name="order_status">
                                            <option selected disabled>Open this select menu</option>
                                            <option {{ $orders->status == '0' ? 'selected' : ''}} value="0">Pending</option>
                                            <option  {{ $orders->status == '1' ? 'selected' : ''}} value="1">Completed</option>
        
                                        </select>
                                        <button class="btn btn-primary mt-3 float-end" type="submit">Update</button>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
