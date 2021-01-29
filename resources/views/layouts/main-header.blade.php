<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="{{ url('/' . ($page = 'index')) }}"><img src="{{ URL::asset('assets/img/brand/logo.png') }}"
                        class="logo-1" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/img/brand/logo-white.png') }}" class="dark-logo-1" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                        class="logo-2" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                        class="dark-logo-2" alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>
        </div>
        <div class="main-header-right">
            <ul class="nav">
                <li class="">
                    <div class="d-md-flex">
                        @if (config('app.locale') == 'ar')
                        {{-- <a href="#" class="d-flex nav-item nav-link pl-0 country-flag1">
                            <span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img
                                    src="{{ URL::asset('assets/img/flags/saudi_arabia_flag.jpg') }}" alt="img"></span>
                        </a> --}}
                        <a href="{{ route('change_locale', 'en') }}" class="d-flex pl-0 country-flag1">
                            <span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img
                                    src="{{  URL::asset('assets/img/flags/us_flag.jpg')  }}" alt="img"></span>
                        </a>
                        @else
                        {{-- <a href="#" class="d-flex nav-item nav-link pr-0 country-flag1">
                            <span class="avatar country-Flag ml-0 align-self-center bg-transparent"><img
                                    src="{{ URL::asset('assets/img/flags/us_flag.jpg') }}" alt="img"></span>
                        </a> --}}
                        <a href="{{ route('change_locale', 'ar') }}" class="d-flex pr-0 country-flag1">
                            <span class="avatar country-Flag ml-0 align-self-center bg-transparent"><img
                                    src="{{ URL::asset('assets/img/flags/saudi_arabia_flag.jpg') }}" alt="img"></span>
                        </a>
                        @endif
                    </div>
                </li>
            </ul>
            <div class="nav nav-item  navbar-nav-right ml-auto">
                @can('show_notifications')
                <div class="dropdown nav-item main-header-notification">
                    <a class="new nav-link" href="#" onclick="stopPule()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        @if (auth()->user()->unreadNotifications->count() == 0)
                        <span class="pulse" id="notification_pulse" style='display: none'></span>
                        @else
                        <span class="pulse" id="notification_pulse"></span>
                        @endif
                    </a>
                    <div class="dropdown-menu">
                        <div class="menu-header-content bg-primary notification-number-text">
                            <div class="d-flex">
                                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">
                                    {{ __('frontend.notifications') }}</h6>
                                <a class="badge badge-pill badge-warning float-left info-show-nice"
                                    href="{{ route('notifications.readAll') }}">{{ __('frontend.read_all') }}</a>
                            </div>
                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12"
                                id="notifications_count_p">
                                <h6 style="color: yellow" id="notifications_count">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </h6>
                            </p>
                        </div>
                        <div id="unread_notifications">
                            <div class="main-notification-list Notification-scroll">
                                @foreach (auth()->user()->unreadNotifications as $notification)
                                <a class="d-flex p-3 border-bottom" id="notification_id"
                                    href="{{ route('notifications.read', [$notification, $notification->data['id']]) }}">
                                    <div class="mr-3">
                                        <h5 class="notification-label mb-1">{{ $notification->data['title'] }} :
                                            {{ $notification->data['user'] }}
                                        </h5>
                                        <div class="notification-subtext"> {{ __('frontend.from') }}
                                            @if (now()->diffInHours($notification->created_at) == 0)
                                            {{ now()->diffInMinutes($notification->created_at) }}
                                            {{ __('frontend.minutes') }}
                                            @else
                                            {{ now()->diffInHours($notification->created_at) }}
                                            {{ __('frontend.hour') }}
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="dropdown-footer">
                            <a href="">{{ __('frontend.view_all') }}</a>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-maximize">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                            </path>
                        </svg></a>
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href=""><img alt=""
                            src="{{ URL::asset('assets/img/faces/6.jpg') }}"></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt="" src="{{ URL::asset('assets/img/faces/6.jpg') }}"
                                        class="">
                                </div>
                                <div class="mr-3 my-auto">
                                    <h6>{{ auth()->user()->name }}</h6><span>{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href=""><i
                                class="bx bx-user-circle"></i>{{ __('frontend.profile') }}</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                class="bx bx-log-out"></i>{{ __('frontend.logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
@section('js')
<script>
    function stopPule() {
        document.getElementById('notification_pulse').style.display = 'none';
    }
    function getDropdownLanguages() {
        document.getElementById('langDropdown').style.position: absolute;
    }
</script>
@endsection
