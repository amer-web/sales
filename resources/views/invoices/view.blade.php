@extends('layouts.master')
@section('css')
@endsection
@section('title')
    فاتورة  {{$invoice->client->name}}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{route('invoice.index')}}">إدارة الفواتير</a></h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0"> > فاتورة رقم {{$invoice->id}} للعميل {{$invoice->client->name}} </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <nav class="nav nav-pills flex-column flex-md-row mt-4">
        <a class="nav-link bg-gray-200 text-dark ml-2 mb-1" href="{{route('invoice.edit', $invoice->id)}}"><i
                class="fa fa-edit fa-fw"></i> تعديل </a>
        <a class="nav-link bg-gray-200 text-dark ml-2 btnPrint mb-1" href="/invoice/print/{{$invoice->id}}"><i
                class="fa fa-print fa-fw" aria-hidden="true"></i> طباعة </a>
        <a class="nav-link bg-gray-200 text-dark ml-2 mb-1" href="{{route('payment.create', $invoice->id)}}"><i
                class="fa fa-credit-card fa-fw"></i> إضافة عملية دفع </a>
        <li class="nav-item dropdown show" style="list-style: none">
            <button class="navbar-toggler btn btn-gray-500 bg-gray-200 p-2" type="button"
                    data-toggle="collapse" data-target="#navbarDropdown{{$invoice->id}}"
                    aria-controls="navbarDropdown" aria-expanded="false"
                    aria-label="Toggle navigation" style="font-size: 14px;position: relative;top: 2px;">
                خيارات أخرى <i class="fas fa-caret-down ml-1"></i>
            </button>
            <div id="navbarDropdown{{$invoice->id}}"
                 class="dropdown-menu box-shadow-primary " role="menu"
                 aria-labelledby="navbarDropdown">
                <a class="dropdown-item  text-dark ml-2 mb-1" href="{{route('invoice-refund.create',$invoice->id)}}"><i
                        class="icon ion-ios-share-alt" aria-hidden="true"></i>
                    إنشاء فاتورة مرتجعة </a>
                <a class="dropdown-item text-dark ml-2 mb-1" href="{{route('send.email.invoice',$invoice->id)}}"><i class="fa fa-envelope fa-fw"></i> إرسال إلى
                    العميل </a>
                <a href="/invoice/pdf/{{$invoice->id}}" target="_blank" class="dropdown-item" style="cursor: pointer"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> عرض PDF </a>
                <a href="/invoice/pdf/{{$invoice->id}}" download="" class="dropdown-item" style="cursor: pointer"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> تحميل PDF </a>
                <a href="" class="delete_invoice dropdown-item" data-title="حذف فاتورة"
                   data-description="هل تريد حذف فاتورة العميل ({{$invoice->client->name}})"
                   data-toggle="modal" data-target="#exampleModal"
                   data-id="{{ $invoice->id }}"><i
                        class="fa fa-trash fa-fw text-danger ml-1"></i>حذف</a>
            </div>
        </li>


    </nav>

    <div class="panel panel-primary tabs-style-2 mt-5">
        <div class=" tab-menu-heading">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs main-nav-line">
                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">فاتورة</a></li>
                    <li><a href="#tab5" class="nav-link" data-toggle="tab">المدفوعات</a></li>
                    @if($invoice->invoicesRefund()->sum('total_refund') > 0)
                        <li><a href="#tab6" class="nav-link" data-toggle="tab">الفواتير المرتجعة</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="panel-body tabs-menu-body main-content-body-right border">
            <div class="tab-content">
                <div class="tab-pane active" id="tab4">
                    <iframe src="/invoice/print/{{$invoice->id}}" width="100%" height="600px" class="border-0"></iframe>
                </div>
                <div class="tab-pane" id="tab5">
                    <h5 class="mt-2 mb-4">عمليات الدفع على الفاتورة رقم {{$invoice->id}}</h5>
                    @if($payments->isEmpty())
                        <p class="text-center mt-4">لم تتم عمليات دفع على هذه الفاتورة حتى الآن</p>
                    @else
                        <div class="table-responsive mt-3">

                            <table class="table table-striped mg-b-0 text-lg-nowrap ">
                                <thead>
                                <tr class="text-center font-weight-bold">
                                    <th>#</th>
                                    <th>تاريخ الدفع</th>
                                    <th>بواسطة</th>
                                    <th>المبلغ</th>
                                    <th>عمليات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($payments as $payment)
                                    <tr class="text-center">
                                        <td class="text-capitalize">{{$loop->iteration}}</td>
                                        <td class="">{{ $payment->created_at->format('Y-m-d') }}</td>
                                        <td>{{$payment->user->name}}</td>
                                        <td>{{$payment->paid}}</td>
                                        <td>
                                            <a href="{{ route('payment.show', $payment->id) }}" class=""><i
                                                    class="fa fa-eye fa-fw"></i></a>
                                            <a href="{{ route('payment.edit', $payment->id) }}"><i
                                                    class="fa fa-edit fa-fw text-dark"></i></a>
                                            <a href="" class="btn btn-light p-1 delete_payment"
                                               data-title="حذف عملية دفع"
                                               data-description="هل تريد حذف عملية الدفع هذه ؟؟؟"
                                               data-toggle="modal" data-target="#exampleModal"
                                               data-id="{{ $payment->id }}"><i
                                                    class="fa fa-trash fa-fw text-danger"></i></a>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr class="pt-5 d-block">
                                    <td colspan="5">ملخص الدفع</td>
                                </tr>
                                <tr class="mt-4">
                                    <td>رقم الفاتورة</td>
                                    <td colspan="2">إجمالى الفاتورة</td>
                                    <td colspan="2">مرتجع</td>
                                    <td colspan="2">الباقى</td>
                                </tr>
                                <tr class="mt-4">
                                    <td>{{$invoice->id}}</td>
                                    <td colspan="2">{{$invoice->total_due}}</td>
                                    <td colspan="2">{{number_format($invoice->invoicesRefund->sum('total_refund'),2) }}</td>
                                    <td colspan="2">{{number_format(($invoice->total_due - $invoice->invoicesRefund->sum('total_refund'))- $invoice->payments()->sum('paid'),2)}}</td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    @endif

                </div>
                <div class="tab-pane" id="tab6">
                    <div class="table-responsive mt-3">

                        <table class="table table-striped mg-b-0 text-lg-nowrap ">
                            <thead>
                            <tr class="text-center font-weight-bold">
                                <th>رقم الفاتورة</th>
                                <th>تاريخ الفاتورة</th>
                                <th>المرتجع</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($invoice->invoicesRefund as $invoiceRefund)
                                <tr class="text-center">
                                    <td class="">{{ $invoiceRefund->id }}</td>
                                    <td>{{$invoiceRefund->invoice_date}}</td>
                                    <td>{{$invoiceRefund->total_refund}}</td>
                                    <td>
                                        <a href="{{ route('invoice-refund.show', $invoiceRefund->id) }}" class=""><i
                                                class="fa fa-eye fa-fw"></i></a>
                                        <a href="{{ route('invoice-refund.edit', $invoiceRefund->id) }}"><i
                                                class="fa fa-edit fa-fw text-dark"></i></a>
                                        <a href="" class="btn btn-light p-1 delete_invoice-refund"
                                           data-title="حذف فاتورة مرتجعة"
                                           data-description="هل تريد حذف الفاتورة المرتجعة الحالية؟؟؟"
                                           data-toggle="modal" data-target="#exampleModal"
                                           data-id="{{ $invoiceRefund->id }}"><i
                                                class="fa fa-trash fa-fw text-danger"></i></a>
                                    </td>
                                </tr>
                            @empty

                            @endforelse
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>

                    </div>

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
          let deleteItem =  function (selector, url){
              $(selector).on('click', function () {
                  let idMessage = $(this).data('id');
                  $('#modelDelete').attr('action', '/'+url+'/' + idMessage + '');
                  $("#exampleModalLabel").text($(this).data('title'));
                  $(".modal-body").text($(this).data('description'));
              });
            }

            deleteItem('.delete_invoice','invoice');
            deleteItem('.delete_payment','payment');
            deleteItem('.delete_invoice-refund','invoice-refund');

    </script>
@endsection
