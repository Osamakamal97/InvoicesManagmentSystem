<!-- Title -->
<title> @yield('title') </title>
<!-- Favicon -->
<link rel="icon" href="{{URL::asset('assets/img/brand/favicon.png')}}" type="image/x-icon" />
<!-- Icons css -->
<link href="{{URL::asset('assets/css/icons.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" />
<!--  Sidebar css -->
<link href="{{URL::asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
@yield('css')
@if (config('app.locale') == 'ar')
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{URL::asset('assets/css-rtl/sidemenu.css')}}">
<!--- Style css -->
<link href="{{URL::asset('assets/css-rtl/style.css')}}" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{URL::asset('assets/css-rtl/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{URL::asset('assets/css-rtl/skin-modes.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/css-rtl/extra.css')}}" rel="stylesheet">
<style>
    .operations-buttons {
        margin-right: 5px;
    }

    .invoice-search-type {
        padding-right: 12px;
    }

    .notification-number-text{
        text-align: right !important;
    }

    .info-show-nice{
        margin-right: auto;
    }
</style>
@else
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{URL::asset('assets/css/sidemenu.css')}}">
<!--- Style css -->
<link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{URL::asset('assets/css/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{URL::asset('assets/css/skin-modes.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/css/extra.css')}}" rel="stylesheet">
<style>
    .mr-auto,
    .mx-auto {
        margin-left: auto !important;
    }

    .mdi-printer {
        margin-right: 0.25rem !important;
    }

    .operations-buttons {
        margin-left: 5px;
    }

    .invoice-search-type {
        padding-left: 12px;
    }


    .notification-number-text{
        text-align: left !important;
    }

    .info-show-nice{
        margin-left: auto;
    }
</style>
@endif
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />
@livewireStyles
