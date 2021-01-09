<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
	<div class="main-sidebar-header active">
		<a class="desktop-logo logo-light active" href="{{ url('/' . $page='home') }}"><img
				src="{{URL::asset('assets/img/brand/logo.png')}}" class="main-logo" alt="logo"></a>
		<a class="desktop-logo logo-dark active" href="{{ url('/' . $page='home') }}"><img
				src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
		<a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . $page='home') }}"><img
				src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
		<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . $page='home') }}"><img
				src="{{URL::asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
	</div>
	<div class="main-sidemenu">
		<div class="app-sidebar__user clearfix">
			<div class="dropdown user-pro-body">
				<div class="">
					<img alt="user-img" class="avatar avatar-xl brround"
						src="{{URL::asset('assets/img/faces/6.jpg')}}"><span
						class="avatar-status profile-status bg-green"></span>
				</div>
				<div class="user-info">
					<h4 class="font-weight-semibold mt-3 mb-0">{{ auth()->user()->name }}</h4>
					<span class="mb-0 text-muted">{{ auth()->user()->email }}</span>
				</div>
			</div>
		</div>
		<ul class="side-menu">
			<li class="side-item side-item-category">Main</li>
			<li class="slide">
				<a class="side-menu__item" href="{{ route('home') }}"><svg xmlns="http://www.w3.org/2000/svg"
						class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
						<path
							d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
					</svg><span class="side-menu__label">الرئيسة</span><span
						class="badge badge-success side-badge">1</span></a>
			</li>
			@can('invoices')
			<li class="side-item side-item-category">الفواتير</li>
			<li class="slide">
				<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><svg
						xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none" />
						<path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3" />
						<path
							d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
					</svg><span class="side-menu__label">الفواتير</span><i class="angle fe fe-chevron-down"></i></a>
				<ul class="slide-menu">
					@can('invoices_index')
					<li><a class="slide-item" href="{{ url('/' . $page='invoices') }}">قائمة الفواتير</a></li>
					@endcan
					@can('invoices_archives')
					<li><a class="slide-item" href="{{ route('invoices.archives') }}">الفواتير المُأَرشفة</a></li>
					@endcan
					@can('paid_invoices')
					<li><a class="slide-item" href="{{ url('/' . $page='invoices/paid-invoices') }}">الفواتير
							المدفوعة</a></li>
					@endcan
					@can('part_paid_invoices')
					<li><a class="slide-item" href="{{ url('/' . $page='invoices/part-paid-invoices') }}">الفواتير
							المدفوعة جزئية</a>
					</li>
					@endcan
					@can('unpaid_invoices')
					<li><a class="slide-item" href="{{ url('/' . $page='invoices/unpaid-invoices') }}">الفواتير الغير
							مدفوعة</a>
					</li>
					@endcan
				</ul>
			</li>
			@endcan
			@can('reports')
			<li class="side-item side-item-category">التقارير</li>
			<li class="slide">
				<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
					<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
						<path d="M0 0h24v24H0V0z" fill="none"></path>
						<path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"></path>
						<path
							d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z">
						</path>
					</svg>
					<span class="side-menu__label">التقارير</span><i class="angle fe fe-chevron-down"></i></a>
				<ul class="slide-menu">
					@can('invoices_reports')
					<li><a class="slide-item" href="{{ url('/' . $page='invoices-reports') }}">تقارير الفواتير</a></li>
					@endcan
					@can('customers_reports')
					<li><a class="slide-item" href="{{ url('/' . $page='customers-reports') }}">تقارير العملاء</a></li>
					@endcan
				</ul>
			</li>
			@endcan
			@can('users')
			<li class="side-item side-item-category">المستخدمين</li>
			<li class="slide">
				<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
						stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
						class="feather feather-users" style="margin-left: 14px;color:#5b6e88;fill:#a8b1c7">
						<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>a8b1c7
						<circle cx="9" cy="7" r="4"></circle>
						<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
						<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
					</svg>
					<span class="side-menu__label">المستخدمين</span><i class="angle fe fe-chevron-down"></i></a>
				<ul class="slide-menu">
					@can('users_index')
					<li><a class="slide-item" href="{{ url('/' . $page='users') }}">المستخدمين</a></li>
					@endcan
					@can('roles_index')
					<li><a class="slide-item" href="{{ url('/' . $page='roles') }}">صلاحيات المستخدمين</a></li>
					@endcan
				</ul>
			</li>
			@endcan
			@can('settings')
			<li class="side-item side-item-category">الإعدادات</li>
			<li class="slide">
				<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
						stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
						class="feather feather-settings" style="margin-left: 14px;color:#5b6e88;fill:#a8b1c7">
						<path
							d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
						</path>
						<circle cx="12" cy="12" r="3" style="color:#5b6e88;fill: white"></circle>
					</svg>
					<span class="side-menu__label">الإعدادات</span><i class="angle fe fe-chevron-down"></i></a>
				<ul class="slide-menu">
					@can('sections_index')
					<li><a class="slide-item" href="{{ url('/' . $page='sections') }}">الأقسام</a></li>
					@endcan
					@can('products_index')
					<li><a class="slide-item" href="{{ url('/' . $page='products') }}">المنتجات</a></li>
					@endcan
				</ul>
			</li>
			@endcan
		</ul>
	</div>
</aside>
<!-- main-sidebar -->