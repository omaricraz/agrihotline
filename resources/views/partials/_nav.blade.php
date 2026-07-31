<nav class="app-nav">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo">

    <div class="nav-links">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('complaints.index') }}" class="{{ request()->routeIs('complaints.*') ? 'active' : '' }}">Complaints</a>
        @if(auth()->user()->canManageUsers())
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">User Management</a>
        @endif
    </div>

    <div class="nav-title d-none d-lg-block">Complaint Management System</div>

    <div class="nav-right">
        <button type="button" class="theme-toggle" data-theme-toggle aria-label="Toggle theme">
            <i class="bi bi-moon-fill"></i>
        </button>

        <div class="dropdown user-dropdown">
            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ auth()->user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
