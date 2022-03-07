<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown" id="notify-parent">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge font-weight-bold">
                    @auth
                        {{count(getUnreadNotification())}}  
                    @endauth 
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right active-noty" id="noty-drop">
                <span class="dropdown-item dropdown-header">{{count(getUnreadNotification()) ?? 0 }} Notifications</span>
                <div class="dropdown-divider"></div>
                @php
                    $countNoty = 5;
                    $data = null;
                @endphp
                @if(count(getUnreadNotification()) > 0)
                    @foreach (getUnreadNotification() as $notification)
                        @php
                            $cls        = $loop->iteration > $countNoty ? 'd-nonex hidden-notify':'';
                            $data       = isset($notification['data']) ? json_decode($notification['data']) : null;
                            $body       = $data ? json_decode($data->body) : null;
                            $service    = getService($body->service_id);
                            $client     = getClient($body->client_id);
                        @endphp

                    <a href="{{ route('admin.bookings_show', [$data->booking_id, $notification->id]) }}" class="dropdown-item {{ $cls }}">
                        <i class="fas fa-envelope mr-2"></i> New Booking for {{ isset($service) ? $service->service_name :'N/A' }} <br/>
                        <small>Booked By <mark>{{ isset($client) ? $client->name :'N/A' }}</mark> </small>
                        <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    @endforeach 
                @else 
                    <a href="javascript:void(0)" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i><span class="text-dark">There is no Notifications</span><br />
                    </a>
                @endif
                {{-- <a href="javascript:void(0)" class="dropdown-item dropdown-footer see_all">See All Notifications</a> --}}
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('admin.user_profile', auth()->user()->id) }}" class="dropdown-item">
                    <i class="fa fa-cogs"></i><span class="mx-2">Profile</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="javascript:void(0)" class="dropdown-item">
                    <i class="fa fa-lock"></i>
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="text-center btn btn-sm p-0 mx-2"><span>Log Out</span></button>
                    </form>
                </a>
            </div>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li> --}}
    </ul>
    
</nav>
