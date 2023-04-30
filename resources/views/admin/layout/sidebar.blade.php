<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="{{ url('/') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary animate-charcter"><i class="fa fa-user-edit me-2"></i>Travelix</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ url(Auth::user()->photo !=null ? Auth::user()->photo :'public/backend/img/img_error.png') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                @if (Auth::check())
                    
                @endif
                <h6 class="mb-0">{{ Auth::user()->name !=null ? Auth::user()->name : '' }}</h6>
                <span>{{ Auth::user()->username != null ? Auth::user()->username : '' }}</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ url('/dashboard') }}" class="nav-item nav-link {{ session('module_active') == 'dashboard' ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <div class="nav-item dropdown">
                <a href="{{ url('admin/order/index') }}" class="nav-link {{ session('module_active') == 'order' ? 'active' : '' }} dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>{{ __('Order') }}</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('admin/order/index') }}" class="dropdown-item">{{ __('List order') }}</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="{{ url('admin/coupon/index') }}" class="nav-link {{ session('module_active') == 'coupon' ? 'active' : '' }} dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>{{ __('Coupon') }}</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('admin/coupon/index') }}" class="dropdown-item">{{ __('List coupon') }}</a>
                    <a href="{{ url('admin/coupon/create') }}" class="dropdown-item">{{ __('Create coupon') }}</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="{ url('admin/service/index') }}" class="nav-link {{ session('module_active') == 'service' ? 'active' : '' }} dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>{{ __('Service') }}</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('admin/service/create') }}" class="dropdown-item">{{ __('Create service') }}</a>
                    <a href="{{ url('admin/service/index') }}" class="dropdown-item">{{ __('List service') }}</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="{{ url('admin/slideshow/index') }}" class="nav-link {{ session('module_active') == 'slideshow' ? 'active' : '' }} dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>{{ __('Slideshow') }}</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('admin/slideshow/create') }}" class="dropdown-item">{{ __('Create slideshow') }}</a>
                    <a href="{{ url('admin/slideshow/index') }}" class="dropdown-item">{{ __('List slideshow') }}</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="{{ url('admin/slogan/create') }}" class="nav-link {{ session('module_active') == 'slogan' ? 'active' : '' }} dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Slogan</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('admin/slogan/create') }}" class="dropdown-item">{{ __('Create slogan') }}</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="{{ url('admin/user/index') }}" class="nav-link {{ session('module_active') == 'user' ? 'active' : '' }} dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>{{ __('Member') }}</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('admin/user/create') }}" class="dropdown-item">{{ __('Create member') }}</a>
                    <a href="{{ url('admin/user/index') }}" class="dropdown-item">{{ __('List member') }}</a>
                    <a href="{{ url('admin/user/edit/'.Auth::user()->id) }}" class="dropdown-item">{{ __('Change password member') }}</a>
                </div>
            </div>
        </div>
    </nav>
</div>