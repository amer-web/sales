@extends('layouts.master')
@section('css')
@endsection
@section('title', 'إضافة منتج جديد')

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المنتجات </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > أضف منتج</span>
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
                                <form action="{{route('product.store')}}" method="POST">
                                    @csrf
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group mg-b-0">
                                                <label class="form-label">إسم المنتج: <span class="tx-danger">*</span></label>
                                                <input class="form-control" name="name" placeholder="اسم المنتج" type="text" autocomplete="off" value="{{old('name')}}">
                                            @error('name')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                            @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group mg-b-0">
                                                <label class="form-label mt-3">سعر بيع المنتج </label>
                                                <input class="form-control" name="selling_price" placeholder="سعر البيع" type="number" autocomplete="off" value="{{old('name')}}">
                                                @error('selling_price')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group mg-b-0 mt-3">
                                                <label class="form-label">الوصف</label>
                                                <textarea name="description" class="form-control" placeholder="وصف المنتج" style="height: 100px;resize: none">{{old('description')}}</textarea>
                                                @error('description')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10 mt-4" type="submit">أضف المنتج</button></div>
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
