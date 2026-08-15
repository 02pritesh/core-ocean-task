<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand">
                <img src="{{ asset('assets/images/logo-full.png') }}" alt="{{ config('app.name') }}" class="logo logo-lg" />
                <img src="{{ asset('assets/images/logo-abbr.png') }}" alt="{{ config('app.name') }}" class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>
                <li class="nxl-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span>
                        <span class="nxl-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="nxl-item {{ request()->routeIs('videos.create') ? 'active' : '' }}">
                    <a href="{{ route('videos.create') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-plus-circle"></i></span>
                        <span class="nxl-mtext">Add Video</span>
                    </a>
                </li>
                <li class="nxl-item {{ request()->routeIs('videos.index', 'videos.edit') ? 'active' : '' }}">
                    <a href="{{ route('videos.index') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-edit-2"></i></span>
                        <span class="nxl-mtext">Edit</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
