@extends('layouts.front')

@section('title')
    My Profile
@endsection

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card px-5 pb-5 pt-3">
              
                <div class="card-header">
                    <h4>User Profile
                        <a href="/" class="btn btn-primary btn-sm" style="float: right !important;">Back</a>
                    </h4>
                    
                </div>
                <form action="{{ url('update-profile/'.Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                <div class="row checkout-form">
                    <div class="col-md-6 mt-3">
                        <label for="">First Name</label>
                        <input type="text" class="form-control firstname" value="{{ Auth::user()->name }}" name="fname" placeholder="Enter First Name">
                        <span id="fname_error" class="text-danger"></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">Last Name</label>
                        <input type="text" class="form-control lastname" value="{{ Auth::user()->lname }}" name="lname" placeholder="Enter Last Name">
                        <span id="lname_error" class="text-danger"></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">Email</label>
                        <input type="text" class="form-control email" value="{{ Auth::user()->email }}" name="email" placeholder="Enter Email">
                        <span id="email_error" class="text-danger"></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">Phone Number</label>
                        <input type="text" class="form-control phone" value="{{ Auth::user()->phone }}" name="phone" placeholder="Enter Phone Number">
                        <span id="phone_error" class="text-danger"></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">Address 1</label>
                        <input type="text" class="form-control address1" value="{{ Auth::user()->address1 }}" name="address1" placeholder="Enter Address 1">
                        <span id="address1_error" class="text-danger"></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">Address 2</label>
                        <input type="text" class="form-control address2" value="{{ Auth::user()->address2 }}" name="address2" placeholder="Enter Address 2">
                        <span id="address2_error" class="text-danger"></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">City</label>
                        <input type="text" class="form-control city" value="{{ Auth::user()->address2 }}" name="city" placeholder="Enter City">
                        <span id="city_error" class="text-danger"></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">State</label>
                        <input type="text" class="form-control state" value="{{ Auth::user()->state }}" name="state" placeholder="Enter State">
                        <span id="state_error" class="text-danger"></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">Country</label>
                        <input type="text" class="form-control country" value="{{ Auth::user()->country }}" name="country" placeholder="Enter Country">
                        <span id="country_error" class="text-danger"></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">Pin Code</label>
                        <input type="text" class="form-control pincode" value="{{ Auth::user()->pincode }}" name="pincode" placeholder="Enter Pin Code">
                        <span id="pincode_error" class="text-danger"></span>
                    </div>
                    
                    <div class="col-md-12 mt-6">
                    <br>
                    <button type="submit" class="btn btn-success w-100">Udpate Profile</button>
                    </div>
                </div>
                </form>
             
            </div>
        </div>
    </div>
</div>
@endsection