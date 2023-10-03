@extends('layouts.front')

@section('title')
    My Orders
@endsection

@section('content')
@php
    $search = '';
@endphp
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>My Orders</h4>
                    </div>        
            
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control mx-4" placeholder="Search..." id="search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="searchButton">Search</button>
                            </div>
                        </div>
                        <div id="orderC-table">
                            @include('frontend.orders.search')
                        </div>
                        <div class="d-flex justify-content-end">
                            <nav aria-label="Pagination Navigation">
                                {{ $orders->appends(['search' => $search])->onEachSide(1)->links('pagination::bootstrap-4') }}
                
                
                            </nav>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() {
                performSearch();
            });
    
            $('#search').on('input', function(event) {
                clearTimeout(timer);
                if ($(this).val() === '') {
                    // Si el campo de búsqueda está vacío, muestra la lista completa automáticamente
                    performSearch();
                }
            });
    
            let timer;
    
            function performSearch() {
                const search = $('#search').val();
    
                $.ajax({
                    url: '{{ route('orderC.search') }}',
                    type: 'GET',
                    data: {
                        search: search
                    },
                    success: function(data) {
                        $('#orderC-table').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
    
            $('#search').on('keypress', function(event) {
                if (event.key === 'Enter') {
                    performSearch();
                }
            });
        });
    </script>
    
@endsection
