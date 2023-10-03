@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit/Update Category</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('update-category/'.$category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="">Name</label>
                    <input type="text" value="{{ $category->name }}" class="form-control" name="name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Slug</label>
                    <input type="text" value="{{ $category->slug }}" class="form-control" name="slug">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Description</label>
                    <textarea rows="3" class="form-control" name="description">{{ $category->description }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Status</label>
                    <input type="checkbox" {{ $category->status == "1" ? 'checked':'' }} name="status">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Popular</label>
                    <input type="checkbox" {{ $category->popular == "1" ? 'checked':'' }} name="popular">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Meta Title</label>
                    <input type="text" value="{{ $category->meta_title }}" class="form-control" name="meta_title">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Meta Keywords</label>
                    <textarea rows="3" class="form-control" name="meta_keywords">{{ $category->meta_keywords }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">Meta Descripcion</label>
                    <textarea rows="3" class="form-control" name="meta_description">{{ $category->meta_descrip }}</textarea>
                </div>
                @if ($category->image)
                    <img src="{{ asset('assets/uploads/category/'.$category->image)}}" height="440px" width="300px" class="ml-3 mb-2" alt="Category image">
                @endif
                
                <div class="col-md-12">
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
            
            </form>  
        </div>    
    </div>   
@endsection