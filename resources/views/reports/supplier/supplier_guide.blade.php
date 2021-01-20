@extends('layouts.master')
@section('css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"/>
@endsection
@section('title','تقارير (دليل الموردين)')
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">تقارير الموردين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > دليل الموردين </span>
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
                                <div class="main-content-label mg-b-5">
                                    بحث
                                </div>
                                <form action="{{route('supplier_guide_search')}}" data-parsley-validate="">
                                    <div class="row row-sm">
                                        <div class="col-4">
                                            <div class="form-group mg-b-0">
                                                <label class="form-label">المورد </label>
                                                <select name="supplier_id" class="clients form-control">
                                                    <option></option>
                                                    <option value="0"  {{isset($supplier_id_request) && $supplier_id_request <= 0 ? 'selected' : ''}}>الكل</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}"
                                                                class="form-control" {{isset($supplier_id_request) && $supplier_id_request == $supplier->id ? 'selected' : ''}}>{{$supplier->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 text-left">
                                            <button class="btn btn-outline-success pd-x-20 mg-t-10" type="submit">عرض التقرير
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if(isset($suppliersAccounts))
                        @if($suppliersAccounts->count() > 0 )
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header pb-0 text-center">
                                        <div class="d-flex justify-content-center mb-2">
                                            <h4 class="card-title mg-b-0">دليل الموردين - تجميع حسب {{request()->supplier_id == 0 || request()->supplier_id == null ? 'الكل' : \App\Models\Supplier::find(request()->supplier_id)->name}}</h4>
                                        </div>
                                        <p class="mb-1">الوقت {{date('Y-m-d H:i')}}</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mg-b-0 text-md-nowrap">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">كود المورد</th>
                                                    <th>الاسم</th>
                                                    <th>العنوان</th>
                                                    <th>رقم الهاتف </th>
                                                    <th>البريد الإلكتونى</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($suppliersAccounts as $supplierAccount)
                                                    <tr>
                                                        <th scope="row" class="text-center">{{$supplierAccount->id}}</th>
                                                        <td> <a href="{{route('supplier.show',$supplierAccount->id)}}">{{$supplierAccount->name}}</a> </td>
                                                        <td>{{$supplierAccount->address}}</td>
                                                        <td>{{$supplierAccount->phone}}</td>
                                                        <td>{{$supplierAccount->email}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $('.clients').select2({
            placeholder: 'اختر '
        });
    </script>
@endsection
