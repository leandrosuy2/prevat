<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{route('dashboard')}}">
                <img src="{{asset('build/assets/images/brand/prevat_logo.png')}}" class="header-brand-img main-logo"
                    alt="Prevat logo">
                <img src="{{asset('build/assets/images/brand/prevat_logo.png')}}" class="header-brand-img darklogo"
                    alt="Prevat logo">
                <img src="{{asset('build/assets/images/brand/prevat.png')}}" class="header-brand-img icon-logo"
                    alt="Prevat logo">
                <img src="{{asset('build/assets/images/brand/prevat.png')}}" class="header-brand-img icon-logo2"
                    alt="Prevat logo">
            </a>
    </div>
    @if(auth()->user()->company->type == 'admin')
        @include('layouts.menu.menu_admin')
    @elseif(auth()->user()->company->type == 'client')
        @include('layouts.menu.menu_client')
    @elseif(auth()->user()->company->type == 'contractor')
        @include('layouts.menu.menu_contractor')
    @endif
</div>
