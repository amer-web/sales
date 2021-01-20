@extends('layouts.master')
@section('css')

@endsection
@section('title')
    العميل {{$client->name}}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{route('client.index')}}">إدارة العملاء</a></h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0"> > العميل {{$client->name}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="panel panel-primary tabs-style-2 mt-4 w-100">
            <div class=" tab-menu-heading">
                <div class="tabs-menu1">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs main-nav-line">
                        <li><a href="#tab4" class="nav-link" data-toggle="tab">التفاصيل</a></li>
                        <li><a href="#tab5" class="nav-link" data-toggle="tab">الفواتير <span>({{$invoices->count()}})</span></a>
                        </li>
                        <li><a href="#tab6" class="nav-link" data-toggle="tab">المدفوعات <span>({{$payments->where('paid', '!=',0)->count()}})</span></a>
                        </li>
                        <li><a href="#tab7" class="nav-link" data-toggle="tab">حركة الحساب</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body main-content-body-right border">
                <div class="tab-content">
                    <div class="tab-pane" id="tab4">
                        <div class="py-1 my-auto"
                             style="height: 40px; background-color: #247dbd;color: #fff; font-size: 21px;text-align: center">
                            معلومات سريعة
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 col-sm-6">
                                <h5>عدد الفواتير : <span
                                        class="text-primary  mr-3">{{$invoices->count() == 0 ? 'لا يوجد' : $client->invoices->count()}}</span>
                                </h5>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h5>آخر فاتورة منشأة : <span class="text-primary mr-3">
                                                   @if($invoices->count() != 0)
                                            <a href="{{route('invoice.show',$invoices->last()->id)}}">فاتورة رقم  {{$invoices->last()->id}}</a>
                                        @endif
                                                </span></h5>
                            </div>
                        </div>
                        <div class="row pt-sm-3">
                            <div class="col-12 col-sm-6">
                                <h5>عدد الفواتير المتأخرة : <span
                                        class="text-primary mr-3">{{$letBell == 0 ? 'لا يوجد' : $letBell}}</span>
                                </h5>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h5>آخر عملية دفع : <span class="text-primary mr-3">
                                                    @if($listPaid->count() != 0)
                                            <a href="{{route('payment.show',$listPaid->last()->id)}}">عملية دفع رقم  {{$listPaid->last()->id}}</a>
                                        @endif
                                                </span></h5>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="py-1 my-auto"
                                 style="height: 40px; background-color: #247dbd;color: #fff; font-size: 21px;text-align: center">
                                مختصر الحساب
                            </div>
                        </div>
                        <div class="table-responsive mt-3">

                            <table class="table table-striped mg-b-3 text-lg-nowrap ">
                                <thead>
                                <tr class="text-center">
                                    <th style="font-size: 15px;">الإجمالى</th>
                                    <th style="font-size: 15px;">المدفوع حتى تاريخه</th>
                                    <th style="font-size: 15px;">المرتجع</th>
                                    <th style="font-size: 15px;">المبلغ المستحق</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr class="text-center">
                                    <td>{{number_format($invoices->sum('total_due'),2)}}</td>
                                    <td>{{number_format($payments->sum('paid'),2)}}</td>
                                    <td>{{number_format(  $client->invoicesRefund()->sum('total_refund'),2)}}</td>
                                    <td>{{number_format(($invoices->sum('total_due') - $client->invoicesRefund()->sum('total_refund'))- $payments->sum('paid'),2 )}}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div><!-- bd -->
                    </div>
                    <div class="tab-pane" id="tab5">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" style="padding-bottom: 215px">
                                        <table class="table mg-b-0 text-md-nowrap" style="min-height: 200px">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">رقم الفاتورة</th>
                                                <th>تاريخ إصدار الفاتورة</th>
                                                <th>الحالة</th>
                                                <th>العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($invoices as $invoice)
                                                <tr>
                                                    <th scope="row" class="text-center">{{$loop->iteration}}</th>
                                                    <th scope="row" class="text-center">{{$invoice->id}}</th>
                                                    <td>{{$invoice->invoiceDate()}}</td>
                                                    <td class="text-center">
                                        <span class="label text-{{$invoice->colorStatus()}} d-flex"
                                              style="line-height: 2"><div
                                                class="dot-label bg-{{$invoice->colorStatus()}} ml-1"></div>{{$invoice->setStatus()}}</span>
                                                    </td>
                                                    <td>
                                                        <!-- Example single danger button -->
                                                        <li class="nav-item dropdown show" style="list-style: none">
                                                            <button class="navbar-toggler text-primary border-0"
                                                                    type="button"
                                                                    data-toggle="collapse"
                                                                    data-target="#navbarDropdown{{$invoice->id}}"
                                                                    aria-controls="navbarDropdown" aria-expanded="false"
                                                                    aria-label="Toggle navigation">
                                                                <i class="si si-options-vertical"></i>
                                                            </button>
                                                            <div id="navbarDropdown{{$invoice->id}}"
                                                                 class="dropdown-menu box-shadow-primary " role="menu"
                                                                 aria-labelledby="navbarDropdown">
                                                                <a href="{{route('invoice.show', $invoice->id)}}" class="dropdown-item" style="cursor: pointer"><i
                                                                        class="fa fa-eye fa-fw text-primary ml-1"></i> عرض </a>
                                                                <a href="{{route('invoice.edit', $invoice->id)}}" class="dropdown-item" style="cursor: pointer"><i
                                                                        class="fa fa-edit fa-fw ml-1"></i> تعديل </a>
                                                                <a class="nav-link text-dark ml-1 " style="font-size: 14px" href="{{route('payment.create', $invoice->id)}}"><i class="fa fa-credit-card fa-fw text-dark" ></i> إضافة عملية دفع </a>
                                                                <a href="/invoice/pdf/{{$invoice->id}}" target="_blank" class="dropdown-item" style="cursor: pointer"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> عرض PDF </a>
                                                                <a href="/invoice/pdf/{{$invoice->id}}" download="" class="dropdown-item" style="cursor: pointer"><i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> تحميل PDF </a>
                                                                <a href="/invoice/print/{{$invoice->id}}"  class="dropdown-item btnPrint" style="cursor: pointer"><i class="fa fa-print fa-fw text-info ml-1" aria-hidden="true"></i> طباعة </a>
                                                                <a href="" class=" delete_invoice dropdown-item" data-title="حذف فاتورة"
                                                                   data-description="هل تريد حذف فاتورة العميل ({{$invoice->client->name}})"
                                                                   data-toggle="modal" data-target="#exampleModal"
                                                                   data-id="{{ $invoice->id }}"><i
                                                                        class="fa fa-trash fa-fw text-danger ml-1"></i>حذف</a>
                                                            </div>
                                                        </li>


                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">لا توجد فواتير
                                                        لعرضها
                                                    </td>
                                                </tr>
                                            @endforelse


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab6">
                        @if($payments->isEmpty())
                            <p class="text-center mt-4">لم تتم عمليات دفع حتى تاريخه</p>
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
                                            <td class="">{{ $payment->created_at->format('Y-m-d') }}
                                                <br>{{$payment->created_at->format('H:i')}}</td>
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

                                    </tfoot>
                                </table>
                                <div class="d-flex justify-content-center my-2">
                                    {{$payments->links()}}
                                </div>

                            </div>
                        @endif

                    </div>

                    <div class="tab-pane" id="tab7">
                        @if($invoices->isEmpty())
                            <div class="text-muted text-center tx-bold mt-3 py-2">لا يوجد حركات للعميل حتى الآن</div>
                        @else
                            <nav class="nav nav-pills flex-column flex-md-row mt-4">
                                <a class="nav-link bg-gray-200 text-dark ml-2 btnPrint mb-1 d-block"
                                   href="/client/print/{{$client->id}}"><i
                                        class="fa fa-print fa-fw" aria-hidden="true"></i> طباعة </a>
                            </nav>

                            <iframe src="/client/print/{{$client->id}}" width="100%" height="600px"
                                    class="border-0"></iframe>
                        @endif
                    </div>
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
    <script>
        $('.btnPrint').printPage({
            message: "جارى التجهيز للطباعة ...",
            afterCallback: function () {
                $('#printPage').remove();
            }
        });
        $('.delete_invoice').on('click', function () {
            let idMessage = $(this).data('id');
            $('#modelDelete').attr('action', '/invoice/' + idMessage + '');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
            $('input[name="url"]').attr('value',"{{Route::currentRouteName()}}");
        });

        $('.delete_payment').on('click', function () {
            let idMessage = $(this).data('id');
            $('#modelDelete').attr('action', '/payment/' + idMessage + '');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
        });
        localStorage.clear();
        let activeTap = localStorage.getItem('activeTap');
        if(activeTap != null){
            let tapActive = $('a[href="'+ activeTap +'"]');
            $(activeTap).addClass('active');
            tapActive.addClass('active');

        } else {
            localStorage.clear();
            $('.nav.panel-tabs a[href="#tab4"]').addClass('active');
            $("#tab4").addClass('active');

        }

        $('.nav-link').on('click', function (){
            localStorage.setItem('activeTap', $(this).attr('href'));
        });


    </script>
@endsection
