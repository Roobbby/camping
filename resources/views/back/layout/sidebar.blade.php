<!-- Main left sidebar menu -->
<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <a href="#">
            <img src="assets/img/logo.svg" alt="Mooli Logo" class="img-fluid logo">
            <span>Berkah Outdoor45</span>
        </a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right">
            <i class="fa fa-close"></i>
        </button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
                <img  src="{{ !empty($profileData->profile) ? url('images/profile/' . $profileData->profile) : url('images/default-avatar.png') }} " class="user-photo" alt="User Profile Picture"/>
            </div>
            <div class="dropdown">
                <span>Pemilik Toko,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown">
                    <strong>{{ $profileData->name }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                    <li><a href="{{ route('profile') }}"><i class="fa fa-user"></i> My Profile</a></li>
                    <li class="divider"></li>
                    <li><a href={{ route('logout') }}><i class="fa fa-power-off"></i> Logout</a></li>
                </ul>
            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu animation-li-delay">
                <li class="header">Main</li>
                <li class="{{ Route::currentRouteNamed('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="header">Data</li>
                <li class="{{ Route::currentRouteNamed('data') ? 'active' : '' }}">
                    <a href="{{ route('data') }}">
                        <i class="fa fa-folder"></i> <span>Data Alat</span>
                    </a>
                </li>
                <li class="{{ Request::is('result') ? 'active' : '' }}">
                    <a href="{{ route('result') }}">
                        <i class="fa fa-globe"></i> <span>Hasil Rekomendasi</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

