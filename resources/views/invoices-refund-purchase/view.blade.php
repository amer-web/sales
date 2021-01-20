@extends('layouts.master')
@section('css')
@endsection
@section('title')
    فاتورة مرتجعة للمورد {{$invoice_refund->invoice->supplier->name}}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{route('purchase-invoice.index')}}">إدارة فواتير المشتريات</a></h4>
                <a href="{{route('purchase-invoice.show', $invoice_refund->invoice->id)}}">
                <span
                    class="text-muted mt-1 tx-13 mr-2 mb-0"> > فاتورة رقم {{$invoice_refund->invoice->id}} للمورد {{$invoice_refund->invoice->supplier->name}} </span>
                </a>
                <span
                    class="text-muted mt-1 tx-13 mr-2 mb-0"> > فاتورة مرتجعة </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <nav class="nav nav-pills flex-column flex-md-row mt-4">
        <a class="nav-link bg-gray-200 text-dark ml-2 mb-1" href="{{route('invoice-refund-purchase.edit', $invoice_refund->id)}}"><i
                class="fa fa-edit fa-fw"></i> تعديل </a>
        <a class="nav-link bg-gray-200 text-dark ml-2 btnPrint mb-1" href="/invoice-refund-purchase/print/{{$invoice_refund->id}}"><i
                class="fa fa-print fa-fw" aria-hidden="true"></i> طباعة </a>
        <a class="nav-link bg-gray-200 text-dark ml-2 mb-1" href="#"><i class="fa fa-envelope fa-fw"></i> إرسال إلى
            العميل </a>
    </nav>

    <div class="panel panel-primary tabs-style-2 mt-5">
        <div class=" tab-menu-heading">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs main-nav-line">
                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">فاتورة</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body tabs-menu-body main-content-body-right border">
            <div class="tab-content">
                <div class="tab-pane active" id="tab4">
                    <iframe src="/invoice-refund-purchase/print/{{$invoice_refund->id}}" width="100%" height="600px" class="border-0"></iframe>
                </div>
            </div>
        </div>
    </div>



    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        $('.btnPrint').printPage({
            message: "جارى التجهيز لطباعة الفاتورة",
            afterCallback: function () {
                $('#printPage').remove();
            }
        });

        $('.delete_message').on('click', function () {
            let idMessage = $(this).data('id');
            $('#modelDelete').attr('action', '/payment/' + idMessage + '');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
        });


    </script>
@endsection
