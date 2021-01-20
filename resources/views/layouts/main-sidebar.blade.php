<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="{{ url('/') }}"><img src="{{asset('sales.png')}}" class="main-logo" alt="logo"></a>
				<a class="desktop-logo logo-dark active" href="{{ url('/') }}"><img src="{{asset('sales.png')}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ url('/') }}"><img src="{{asset('sales.png')}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/') }}"><img src="{{asset('sales.png')}}" class="logo-icon dark-theme" alt="logo"></a>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img alt="user-img" class="avatar avatar-xl brround" src="{{auth()->user()->userImage()}}"><span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{auth()->user()->firstname }} {{auth()->user()->lastname}}</h4>
							<span class="mb-0 text-muted">{{auth()->user()->email}}</span>
						</div>
					</div>
				</div>
				<ul class="side-menu">
					<li class="side-item side-item-category">إيزي لإدارة الفواتير</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ url('/') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">الرئيسية</span></a>
					</li>
					<li class="side-item side-item-category">الفواتير</li>
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="fe fe-briefcase side-menu__icon" style="line-height: 23px;color: #5b6e88"></i> <span class="side-menu__label">المبيعات</span><i class="angle fe fe-chevron-down"></i></a>
						<ul class="slide-menu">
							<li><a class="slide-item" href="{{route('invoice.index') }}">إدارة فواتير المبيعات</a></li>
							<li><a class="slide-item" href="{{route('invoice.create') }}">إنشاء فاتورة بيع</a></li>
							<li><a class="slide-item" href="{{route('invoice-refund.index')}}">مرتجعات المبيعات</a></li>
                            <li><a class="slide-item" href="{{ route('payment.index') }}">مدفوعات العملاء</a></li>
						</ul>
					</li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="fa fa-truck side-menu__icon" style="line-height: 23px;color: #5b6e88;font-size: 18px"></i> <span class="side-menu__label">المشتريات</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{route('purchase-invoice.index')}}">إدارة فواتير الشراء</a></li>
                            <li><a class="slide-item" href="{{route('purchase-invoice.create')}}">إنشاء فاتورة شراء</a></li>
                            <li><a class="slide-item" href="{{route('invoice-refund-purchase.index')}}">مرتجعات المشتريات</a></li>


                        </ul>
                    </li>
                    <li class="side-item side-item-category">العملاء</li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="fa fa-user side-menu__icon" style="line-height: 23px;color: #5b6e88"></i> <span class="side-menu__label">العملاء</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('client.index') }}">إدارة العملاء</a></li>
                            <li><a class="slide-item" href="{{ route('client.create') }}">إضافة عميل جديد</a></li>
                        </ul>
                    </li>
                    <li class="side-item side-item-category">الموردين</li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="typcn typcn-group-outline side-menu__icon" style="line-height: 15px;color: #5b6e88"></i> <span class="side-menu__label">الموردين</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('supplier.index') }}">إدارة الموردين</a></li>
                            <li><a class="slide-item" href="{{ route('supplier.create') }}">إضافة مورد جديد</a></li>
                        </ul>
                    </li>

                    <li class="side-item side-item-category">المنتجات</li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="icon ion-md-cube side-menu__icon" style="line-height: 0px;color: #5b6e88"></i> <span class="side-menu__label">المنتجات</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{ route('product.index') }}">إدارة المنتجات</a></li>
                            <li><a class="slide-item" href="{{ route('product.create') }}">إضافة منتج جديد</a></li>
                        </ul>
                    </li>
					<li class="side-item side-item-category"> التقارير</li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="icon ion-ios-stats side-menu__icon" style="line-height: 0px;color: #5b6e88"></i> <span class="side-menu__label ">تقارير العملاء</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{route('client_guide')}}">دليل العملاء</a></li>
                            <li><a class="slide-item" href="{{route('client_balance')}}">أرصدة العملاء</a></li>
                            <li><a class="slide-item" href="{{route('client_payments')}}">مدفوعات العملاء</a></li>
                        </ul>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="icon ion-ios-pie side-menu__icon" style="line-height: 0px;color: #5b6e88"></i> <span class="side-menu__label">تقارير الموردين</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{route('supplier_guide')}}">دليل الموردين</a></li>
                            <li><a class="slide-item" href="{{route('supplier_balance')}}">أرصدة الموردين</a></li>
                            <li><a class="slide-item" href="{{route('supplier_payments')}}">مدفوعات الموردين</a></li>
                        </ul>
                    </li>
                    <li class="side-item side-item-category">المستخدمين</li>
                    <li class="slide mb-5">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}"><i class="mdi mdi-account-location side-menu__icon" style="line-height: 25px;color: #5b6e88"></i> <span class="side-menu__label">المستخدمين</span><i class="angle fe fe-chevron-down"></i></a>
                        <ul class="slide-menu">
                            <li><a class="slide-item" href="{{route('add.user')}}">أضافة مستخدم جديد </a></li>
                        </ul>
                    </li>
				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
