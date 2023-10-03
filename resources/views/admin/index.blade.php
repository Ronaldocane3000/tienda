@extends('layouts.admin')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')
<div class="card">
    <div class="card card-body">
        <h1>Bienvenido Ronaldo</h1>
    </div>
</div>

<div class="container">
    <div class="container-fluid">
        <div class="row">
            <!-- Sección de tarjetas -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-sitemap"></i>
                        </div>
                        <p class="card-category">Total Categories</p>
                        <h3 class="card-title">{{ $categories }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Last 24 Hours
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <p class="card-category">Total Products</p>
                        <h3 class="card-title">{{ $products }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Last 24 Hours
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <p class="card-category">Total users</p>
                        <h3 class="card-title">{{ $users }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Last 24 Hours
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>
                        <p class="card-category">Total Orders</p>
                        <h3 class="card-title">{{ $orders }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Last 24 Hours
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <p class="card-category">Completed Orders</p>
                        <h3 class="card-title">{{ $orders_completed }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Last 24 Hours
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <p class="card-category">Pending Orders</p>
                        <h3 class="card-title">{{ $orders_pending }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Last 24 Hours
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repite esta estructura para las otras tarjetas -->

            <!-- Primer gráfico en la primera columna y fila -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <canvas id="userRegistrationsChart"></canvas>
                </div>
            </div>

            <!-- Segundo gráfico en la primera columna y segunda fila -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <canvas id="productsAddedLast7DaysChart"></canvas>
                </div>
            </div>

            <!-- Tercer gráfico en la segunda columna y primera fila -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <canvas id="ordersLast30DaysChart"></canvas>
                </div>
            </div>

            <!-- Cuarto gráfico en la segunda columna y segunda fila -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <canvas id="dailyEarningsLast30DaysChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para los gráficos -->
<script>
    // Código del primer gráfico
    var ctx1 = document.getElementById('userRegistrationsChart').getContext('2d');
    var data1 = @json($userRegistrationsData);

    var chart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: data1.map(item => item.date),
            datasets: [{
                label: 'Usuarios Registrados',
                data: data1.map(item => item.count),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Código del segundo gráfico
    var ctx2 = document.getElementById('productsAddedLast7DaysChart').getContext('2d');
    var data2 = @json($productsAddedLast7Days);

    var chart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: data2.map(item => item.date),
            datasets: [{
                label: 'Productos Agregados',
                data: data2.map(item => item.count),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Código del tercer gráfico
    var ctx3 = document.getElementById('ordersLast30DaysChart').getContext('2d');
    var data3 = @json($ordersLast30Days);

    var chart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: data3.map(item => item.date),
            datasets: [{
                label: 'Pedidos Realizados',
                data: data3.map(item => item.count),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Código del cuarto gráfico
    var ctx4 = document.getElementById('dailyEarningsLast30DaysChart').getContext('2d');
    var data4 = @json($dailyEarningsLast30Days);

    var chart4 = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: data4.map(item => item.date),
            datasets: [{
                label: 'Ganancias Diarias',
                data: data4.map(item => item.earnings),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
