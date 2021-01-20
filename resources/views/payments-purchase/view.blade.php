@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المدفوعات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > عملية دفع رقم {{$payment->id}} للمورد {{$payment->invoice->supplier->name}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-6">
            <div class="py-1 my-auto"
                 style="height: 40px; background-color: #247dbd;color: #fff; font-size: 21px;text-align: center">
                بيانات العميل
            </div>
            <div class="mt-3 mb-5">
                <h5>اســـــم المورد : <span class="mr-3">{{$payment->invoice->supplier->name}}</span></h5>
            </div>
            <div class="my-5">
                <h5>رقــــم الهــــــاتف : <span class="mr-3">{{$payment->invoice->supplier->phone}}</span></h5>
            </div>
            <div class="my-5">
                <h5>البريد الإلكترونى : <span class="mr-3">{{$payment->invoice->supplier->email}}</span></h5>
            </div>
            <div class="my-5">
                <h5>العنــــــــــــــوان : <span class="mr-3">{{$payment->invoice->supplier->address}}</span></h5>
            </div>
        </div>
        <div class="col-6">
            <div class="py-1 my-auto"
                 style="height: 40px; background-color: #247dbd;color: #fff; font-size: 21px;text-align: center">
                بيانات الدفع
            </div>
            <div class="mt-3 mb-5">
                <h5>المبلغ : <span class="mr-3">{{$payment->paid}}</span></h5>
            </div>
            <div class="my-5">
                <h5>تاريخ الدفع : <span class="mr-3">{{$payment->created_at->format('d-m-Y')}}</span></h5>
            </div>
            <div class="my-5">
                <h5>الطريقة : <span class="mr-3">{{$payment->methodPayment->name}}</span></h5>
            </div>
            <div class="my-5">
                <h5>بواسطة : <span class="mr-3">{{$payment->user->name}}</span></h5>
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
