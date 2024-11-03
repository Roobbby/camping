<header class="navbar navbar-expand-lg bg-light shadow-sm">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="assets/img/logo.svg" width="47" alt="Berkah Outdoor 45">
            Berkah Outdoor 45
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse2" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="form-check form-switch mode-switch order-lg-2 ms-4 ms-lg-auto me-lg-4" data-bs-toggle="mode">
            <input type="checkbox" class="form-check-input" id="theme-mode">
            <label class="form-check-label d-none d-sm-block d-lg-none d-xl-block" for="theme-mode">Light</label>
            <label class="form-check-label d-none d-sm-block d-lg-none d-xl-block" for="theme-mode">Dark</label>
        </div>
        <a href="{{ route('login') }}" class="btn btn-secondary btn-sm fs-sm rounded order-lg-3 d-none d-lg-inline-flex">
            <i class="bx bx-log-in fs-lg me-2"></i>
            Sign in
        </a>
        <nav id="navbarCollapse2" class="collapse navbar-collapse">
            <hr class="d-lg-none mt-3 mb-2">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a href="{{ route('tools') }}" class="nav-link {{ Request::routeIs('tools') ? 'active' : '' }}">Alat-Alat</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('recomends') }}" class="nav-link {{ Request::routeIs('recomends') ? 'active' : '' }}">Rekomendasi</a>
                </li>
            </ul>
            <a href="{{ route('login') }}" class="btn btn-secondary btn-sm fs-sm rounded my-3 d-lg-none">
                <i class="bx bx-log-in fs-lg me-2"></i>
                Sign in
            </a>
        </nav>
    </div>
</header>
