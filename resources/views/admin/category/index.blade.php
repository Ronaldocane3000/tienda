@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Category Page</h4>
            <hr>
        </div>

        <div class="card-body">
            <!-- Agregar esto en la vista -->
            <div class="input-group mb-3">
                <input type="text" class="form-control mx-4" placeholder="Search..." id="search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="searchButton">Search</button>
                </div>
            </div>

            <div id="category-table">
                <!-- Aquí irá la tabla de resultados de búsqueda -->
                @include('admin.category.search')
            </div>
            <!-- Agrega esto antes de la tabla -->
            <div class="d-flex justify-content-end">
                <nav aria-label="Pagination Navigation">
                    {{ $categories->appends(['search' => $search])->onEachSide(1)->links('pagination::bootstrap-4') }}
                </nav>
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
                    url: '{{ route('category.search') }}',
                    type: 'GET',
                    data: {
                        search: search
                    },
                    success: function(data) {
                        $('#category-table').html(data);
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
