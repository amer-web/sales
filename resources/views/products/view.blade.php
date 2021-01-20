@extends('layouts.master')
@section('css')
@endsection
@section('title','عرض منتج')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{route('product.index')}}">إدارة المنتجات</a></h4><h5
                    class="text-muted mt-1 tx-13 mr-2 mb-0"> > {{$product->name}} </h5>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card ">
                <div class="card-body">
                    <div class="card-widget">
                        <h6 class="mb-2">إجمالى القطع المباعة</h6>
                        <h2 class="text-right"><i
                                class="fa fa-cart-plus icon-size float-left text-danger text-danger-shadow"></i><span>{{$products->sum('amount')}}</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card ">
                <div class="card-body">
                    <div class="card-widget">
                        <h6 class="mb-2">إجمالى القطع المباعة آخر 7 أيام</h6>
                        <h2 class="text-right"><i
                                class="fa fa-cart-plus icon-size float-left text-danger text-danger-shadow"></i><span>{{$amountOfWeek}}</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed -->
    <div class="py-1 my-auto"
         style="height: 40px; background-color: #247dbd;color: #fff; font-size: 21px;text-align: center">
        التفاصيل
    </div>
    <div class="form-group d-flex mt-3">
        <h5 class="my-auto">كود المنتج : </h5>
        <p class="mb-0 mr-2 mt-1">{{$product->id}}</p>
    </div>
    <div class="form-group d-flex mt-5">
        <div class="d-flex">
            <h5 class="form-label mr-2 mt-2">سعر الشراء</h5>
            <button class="border-0" data-placement="top" data-toggle="tooltip-primary"
                    title="هو السعر الصادر من آخر فاتورة شراء" type="button"><i class="fa fa-question-circle"
                                                                                aria-hidden="true"></i></button>
        </div>
        <p class="mb-0 mr-2 mt-2"> : {{$purchasePrice == null ? '' : $purchasePrice->purchase_price}}</p>
    </div>
    <div class="form-group d-flex mt-5">
        <h5 class="my-auto">سعر البيع : </h5>
        <p class="mb-0 mr-2 mt-1">{{$product->sellingPrice->selling_price}}</p>
    </div>
    <div class="form-group d-flex mt-5">
        <h5 class="my-auto">الوصف : </h5>
        <p class="mb-0 mr-2 mt-1">{{$product->description}}</p>
    </div>

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
