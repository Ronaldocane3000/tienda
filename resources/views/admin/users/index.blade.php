@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Registered Users</h4>
            <hr>
        </div>

        <div class="card-body">
            <div class="input-group mb-3">
                <input type="text" class="form-control mx-4" placeholder="Search..." id="search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="searchButton">Search</button>
                </div>
            </div>

            <div id="user-table">
                <!-- Aquí irá la tabla de resultados de búsqueda -->
                @include('admin.users.search')
            </div>
            <div class="d-flex justify-content-end">
                <nav aria-label="Pagination Navigation">
                    {{ $users->appends(['search' => $search])->onEachSide(1)->links('pagination::bootstrap-4') }}
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
                    url: '{{ route('user.search') }}',
                    type: 'GET',
                    data: {
                        search: search
                    },
                    success: function(data) {
                        $('#user-table').html(data);
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
