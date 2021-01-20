@extends('layouts.master')
@section('css')
@endsection
@section('title','تغير كلمة السر')
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الملف الشخصي</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > تغير كلمة السر  </span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="main-content-label mg-b-5 font-weight-bold mb-3">
                                    تغير كلمة السر
                                </div>
                                <form action="{{route('change_password.user')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="bg-gray-200 p-4">
                                                <div class="form-group">
                                                    <input class="form-control" type="password" name="old_password" placeholder="اكتب كلمة السر الحالية" type="text">
                                                    @error('old_password')
                                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="password" name="new_password" placeholder="اكتب كلمة السر الجديدة" type="password">
                                                    @error('new_password')
                                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="password" name="new_password_confirmation" placeholder="تأكيد كلمة السر الجديدة" type="password">
                                                </div>
                                                <input class="btn btn-primary" type="submit" value="تحديث">
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
