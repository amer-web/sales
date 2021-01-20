@extends('layouts.master')
@section('css')
@endsection
@section('title','عرض الملف الشخصي')
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الملف الشخصي</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > عرض الملف الشخصي</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">معلومات شخصية</div>
                                <form class="form-horizontal">
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">الاسم الأول</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p>{{auth()->user()->firstname}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">اسم العائلة</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p>{{auth()->user()->lastname}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">البريد الإلكترونى</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p>{{auth()->user()->email}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mg-b-20">
                            <div class="card-body">
                                <div class="pl-0">
                                    <div class="main-profile-overview text-center" >
                                        <div class="main-img-user profile-user">
                                            <img alt="" src="{{auth()->user()->userImage()}}">
                                        </div>
                                        <div class="d-flex justify-content-center mg-b-20">
                                            <div>
                                                <h5 class="main-profile-name">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</h5>
                                            </div>
                                        </div>
                                        <p>تاريخ الانضمام / {{auth()->user()->created_at->format('Y-n-j')}}</p>
                                    </div><!-- main-profile-overview -->
                                </div>
                            </div>
                        </div>
                    </div>

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection
