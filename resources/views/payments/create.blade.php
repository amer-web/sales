@extends('layouts.master')
@section('css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"/>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
                            <h4 class="content-title mb-0 my-auto"><a href="{{route('invoice.index')}}">إدارة الفواتير</a></h4>
                            <a href="{{route('invoice.show', $invoice->id)}}"><span
                                    class="text-muted mt-1 tx-13 mr-2 mb-0"> > فاتورة رقم {{$invoice->id}} للعميل {{$invoice->client->name}} </span></a>
                            <span
                                class="text-muted mt-1 tx-13 mr-2 mb-0"> > إضافة عملية دفع  </span>
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
                                <form action="{{route('payment.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$invoice->id}}" name="id">
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">الطريقة: <span class="tx-danger">*</span></label>
                                                <select name="method_payment_id" class="w-75 method-payments">
                                                    <option></option>
                                                    @foreach($method_payments as $method_payment)
                                                        <option value="{{$method_payment->id}}">{{$method_payment->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('method_payment_id')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">المبلغ</label>
                                                <input class="form-control" name="paid" placeholder="المبلغ" type="number" autocomplete="off" value="{{ old('paid', ($invoice->total_due - $invoice->invoicesRefund->sum('total_refund')) - $invoice->payments()->sum('paid')) }}">
                                                @error('paid')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group mg-b-0">
                                                <label class="form-label">تم التحصيل بواسطة</label>
                                                <input class="form-control" name="address" placeholder="التحصيل بواسطة"  type="text" autocomplete="off" >
                                                @error('address')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="form-group mt-2">
                                                <label class="form-label">ملاحظات</label>
                                                <textarea class="form-control " style="resize: none; height: 90px"></textarea>
                                                @error('phone')
                                                <span class="text-danger mb-3 d-block mt-1" style="font-size: 12px">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">أضف عملية الدفع</button></div>
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
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(function (){
        let pluginSelect2 = function (selector, placeholder) {
            $(selector).select2({
                placeholder: placeholder,
                dir: 'rtl'
            });
        };
        pluginSelect2('.method-payments', 'أختر طريقة الدفع');

        });
    </script>
@endsection
