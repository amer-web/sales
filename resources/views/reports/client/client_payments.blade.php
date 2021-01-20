@extends('layouts.master')
@section('title','تقارير (مدفوعات العملاء)')
@section('css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/date/jquery.datetimepicker.min.css') }}" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">تقارير العملاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > مدفوعات العملاء  </span>
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
                    <form action="{{route('client_payments_search')}}" data-parsley-validate="">
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">العميل </label>
                                    <select name="client_id" class="clients form-control">
                                        <option></option>
                                        <option
                                            value="0" {{isset($client_id_request) && $client_id_request <= 0 ? 'selected' : ''}}>
                                            الكل
                                        </option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}"
                                                    class="form-control" {{isset($client_id_request) && $client_id_request == $client->id ? 'selected' : ''}}>{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">التاريخ من </label>
                                    <input class="form-control" name="start_date"
                                           type="text" autocomplete="off"
                                           value="{{isset($start_date) ? $start_date : ''}}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">التاريخ إلى </label>
                                    <input class="form-control" name="end_date" type="text" autocomplete="off"
                                           value="{{isset($end_date) ? $end_date : ''}}">
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
        @if(isset($clientsAccounts))
            @if($clientsAccounts->count() > 0 )
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header pb-0 text-center">
                            <div class="d-flex justify-content-center mb-2">
                                <h4 class="card-title mg-b-0">مدفوعات العملاء - تجميع
                                    حسب {{request()->client_id == 0 || request()->client_id == null ? 'الكل' : \App\Models\Client::find(request()->client_id)->name}}</h4>
                            </div>
                            <p class="mb-1">الوقت {{date('Y-m-d H:i')}}</p>
                            <p>التاريخ من {{$start_date}} | إلى التاريخ {{$end_date}}</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mg-b-0 text-md-nowrap">
                                    <thead>
                                    <tr>
                                        <th>كود الدفع</th>
                                        <th>التاريخ</th>
                                        <th>أسم العميل</th>
                                        <th class="text-center">رقم الفاتورة</th>
                                        <th class="text-center">وسيلة الدفع</th>
                                        <th>المبلغ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($clientsAccounts as $clientAccount)
                                        <tr>
                                            <td colspan="2" class="tx-bold">{{$clientAccount->name}} كود
                                                ({{$clientAccount->id}})
                                            </td>
                                            <td colspan="4"></td>
                                        </tr>
                                        @foreach($clientAccount->payments as $payment )
                                            <tr>
                                                <td> <a href="{{route('payment.show',$payment->id)}}">{{$payment->id}}</a> </td>
                                                <td>{{$payment->created_at->format('Y-m-d')}}</td>
                                                <td><a href="{{route('client.show',$clientAccount->id)}}">{{$clientAccount->name}}</a> </td>
                                                <td class="text-center"> <a href="{{route('invoice.show',$payment->invoice->id)}}">{{$payment->invoice->id}}</a> </td>
                                                <td class="text-center">{{$payment->methodPayment->name}}</td>
                                                <td>{{$payment->paid}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="tx-bold">المجموع</td>
                                            <td colspan="3"></td>
                                            <td class="tx-bold">{{number_format($clientAccount->payments->sum('paid'),2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"></td>
                                        </tr>

                                    @endforeach
                                        <tr>
                                            <td colspan="2" class="tx-bold">الإجماليات</td>
                                            <td colspan="3"></td>
                                            <td class="tx-bold">{{number_format($totalPaid,2)  }}</td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="tx-bold text-muted w-100 text-center mt-3">
                    لا توجد بيانات توافق معطيات البحث
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
    <script src="{{ asset('assets/plugins/date/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(function () {
            'use strict';
            let date = function (element) {
                $(element).datetimepicker({
                    rtl: true,
                    format: 'Y-m-d',
                    formatTime: false,
                    formatDate: 'd-m-Y',
                    timepicker: false,
                    closeOnDateSelect: true,
                });
            };
            date('input[name="start_date"]');
            date('input[name="end_date"]');
            $('.clients').select2({
                placeholder: 'اختر '
            });

        });
    </script>
@endsection
