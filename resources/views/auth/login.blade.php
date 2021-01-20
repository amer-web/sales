@extends('layouts.master2')
@section('css')
    <link href="{{URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('title','تسجيل دخول')
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{asset('assets/img/maxresdefault.jpg')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="mb-5 d-flex"> <img src="{{asset('sales.png')}}" class="sign-favicon ht-40 ml-2" alt="logo"><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">إيزى <span>لإدارة </span>المبيعات</h1></div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2>مرحباً بك</h2>
                                            <h5 class="font-weight-semibold mb-4">تسجيل دخول</h5>
                                            <form method="POST" action="{{ route('login')}}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>البريد الإلكترونى</label> <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                    @error('email')
                                                       <span class="invalid-feedback" role="alert">
                                                           <strong>{{ $message }}</strong>
                                                       </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>كلمة المرور</label> <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div><button class="btn btn-main-primary btn-block">تسجيل الدخول</button>

                                            </form>
                                            <div class="main-signin-footer mt-5">
                                                <p><a href="{{ route('password.request') }}">هل نسيت كلمة المرور ؟</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
@endsection
@section('js')
@endsection

