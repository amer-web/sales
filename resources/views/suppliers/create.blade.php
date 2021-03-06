@extends('layouts.master')
@section('css')
@endsection
@section('title', 'إضافة مورد جديد')

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الموردين </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > إضافة مورد جديد</span>
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
                                <form action="{{route('supplier.store')}}" method="POST">
                                    @csrf
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group mg-b-0">
                                                <label class="form-label">إسم المورد بالكامل: <span class="tx-danger">*</span></label>
                                                <input class="form-control" name="name" placeholder="اسم المورد" type="text" autocomplete="off" value="{{old('name')}}">
                                            @error('name')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">البريد الإلكترونى</label>
                                                <input class="form-control" name="email" placeholder="البريد الإلكترونى" type="text" autocomplete="off" value="{{old('email')}}">
                                                @error('email')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group mg-b-0">
                                                <label class="form-label">العنوان</label>
                                                <input class="form-control" name="address" placeholder="العنوان"  type="text" autocomplete="off" value="{{old('address')}}">
                                                @error('address')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">الهاتف</label>
                                                <input class="form-control" name="phone" placeholder="رقم الهاتف"  type="text" autocomplete="off" value="{{old('phone')}}">
                                                @error('phone')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">إضافة مورد جديد</button></div>
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
