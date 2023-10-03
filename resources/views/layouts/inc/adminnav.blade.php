<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Dashboard</a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

            <ul class="navbar-nav ms-auto" style="margin-right: 20px !important;">

                <li class="nav-item">
                    <!-- Enlace para abrir y cerrar la lista de notificaciones -->
                    <a class="nav-link" href="#" id="notificationsDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="badge badge-pill bg-danger notification-count">
                        {{ $notificationsCount }}
                    </span>
                     </a>
                 
                    <!-- Menú desplegable para notificaciones -->
                    <!-- Menú desplegable para notificaciones -->
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="min-width: 250px; right: 0;">
                        <!-- Lista de notificaciones -->
                        @if ($notificationsCount > 0)
                            @foreach ($notifications as $notification)
                            @if (!$notification->is_seen)
                            <a class="dropdown-item" href="{{ route('admin.view-order', ['id' => $notification->order_id]) }}" style="text-align: left;">
                                Nuevo pedido de {{ $notification->user->name }}. Click para ver el pedido.
                            </a>
                            @endif
                            @endforeach
                        @else
                            <p class="dropdown-item text-center">No hay notificaciones nuevas</p>
                        @endif
                    </div>

                </li> 

                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <!-- Aplicamos ancho fijo al menú desplegable -->
                        <ul class="dropdown-menu dropdown-menu-end custom-dropdown" aria-labelledby="navbarDropdown" style="width: 90%;">
                            <li>
                                <a href="{{ url('my-profileA') }}" class="dropdown-item">
                                    My Profile
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->