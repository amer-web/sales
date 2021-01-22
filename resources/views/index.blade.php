@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet"/>
    <!-- Maps css -->
    <link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
    <style>
        div.urgent-action  :hover i {
            color: #fff;
        }
        div.urgent-action  :hover p {
            color: #fff;
        }
    </style>
@endsection
@section('title', 'ذا بيست لإدارة المبيعات')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">
                    مرحباً {{auth()->user()->firstname}} {{auth()->user()->lastname}}</h2>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">إجمالي المبيعات</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{number_format($totalSales,2)}}
                                    <span style="font-size: 13px"> ج.م</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">المبالغ المستحقة على العملاء</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{number_format($totalDue,2)}} <span
                                        style="font-size: 13px"> ج.م</span></h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">عدد فواتير المبيعات</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$invoicesSales}}</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">عدد فواتير المشتريات</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{$invoicesPurchase}}</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <p>ملخص مدفوعات المبيعات</p>
            <div style="width:100%;">
                {!! $chartjs->render() !!}
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <p>اجراءات عاجلة</p>
            <div class="row text-center">
                <div class="col-6 col-sm-4 urgent-action">
                    <div class="btn-outline-secondary p-0">
                        <a href="{{route('client.create')}}">
                            <i class="mdi mdi-account" style="font-size: 40px"></i>
                            <p>اضافة عميل</p>

                        </a>
                    </div>
                </div>
                <div class="col-6 col-sm-4 urgent-action">
                    <div class="btn-outline-secondary p-0">
                        <a href="{{route('invoice.create')}}">
                            <i class="typcn typcn-document-add" style="font-size: 40px"></i>
                            <p>إنشاء فاتورة بيع</p>

                        </a>
                    </div>
                </div>
                <div class="col-6 col-sm-4 urgent-action">
                    <div class="btn-outline-secondary p-0 h-100" >
                        <a href="{{route('payment.index')}}">
                            <i class="fa fa-credit-card" style="font-size: 36px;line-height: 1.85;"></i>
                            <p>مدفوعات العملاء</p>

                        </a>
                    </div>
                </div>


            </div>
            <div class="row text-center">
                <div class="col-6 col-sm-4 urgent-action">
                    <div class="btn-outline-secondary p-0">
                        <a href="{{route('product.create')}}">
                            <i class="fe fe-box" style="font-size: 40px;line-height: 1.7"></i>
                            <p>اضافة منتج</p>

                        </a>
                    </div>
                </div>
                <div class="col-6 col-sm-4 urgent-action">
                    <div class="btn-outline-secondary p-0">
                        <a href="{{route('purchase-invoice.create')}}">
                            <i class="fe fe-briefcase" style="font-size: 40px;line-height: 1.7"></i>
                            <p>إنشاء فاتورة شراء</p>

                        </a>
                    </div>
                </div>
                <div class="col-6 col-sm-4 urgent-action">
                    <div class="btn-outline-secondary p-0 " >
                        <a href="{{route('supplier.create')}}">
                            <i class="fa fa-user-circle" style="font-size: 36px;line-height: 1.9;"></i>
                            <p>أضافة مورد</p>

                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">آخر الفواتير</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding-bottom: 254px">
                        <table class="table mg-b-0 text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="text-center">رقم الفاتورة</th>
                                <th>العميل</th>
                                <th>تاريخ إصدار الفاتورة</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <th scope="row" class="text-center">{{$invoice->id}}</th>
                                    <td><a href="{{route('invoice.show',$invoice->id)}}">{{$invoice->client->name}}</a>
                                    </td>
                                    <td>{{$invoice->invoiceDate()}}</td>
                                    <td class="text-center position-relative">
                                        <span class="label text-{{$invoice->colorStatus()}} d-flex"
                                              style="line-height: 2"><div
                                                class="dot-label bg-{{$invoice->colorStatus()}} ml-1"></div>{{$invoice->setStatus()}}</span>
                                        <br>
                                        @if($invoice->invoicesRefund->count() > 0)
                                            @if($invoice->invoicesRefund->sum('total_refund') < $invoice->total_due)
                                                <span class="label text-right d-block p-1"
                                                      style="position: absolute; bottom: 12px;right: 28px;background-color: #afa3a3; color: #fff;font-size: 10px;border-radius: 5px ">
                                                مرتجع جزئي
                                            @endif
                                        </span>
                                            @endif
                                    </td>
                                    <td>
                                        <!-- Example single danger button -->
                                        <li class="nav-item dropdown show" style="list-style: none">
                                            <button class="navbar-toggler text-primary border-0" type="button"
                                                    data-toggle="collapse" data-target="#navbarDropdown{{$invoice->id}}"
                                                    aria-controls="navbarDropdown" aria-expanded="false"
                                                    aria-label="Toggle navigation">
                                                <i class="si si-options-vertical"></i>
                                            </button>
                                            <div id="navbarDropdown{{$invoice->id}}"
                                                 class="dropdown-menu box-shadow-primary " role="menu"
                                                 aria-labelledby="navbarDropdown">
                                                <a href="{{route('invoice.show', $invoice->id)}}" class="dropdown-item"
                                                   style="cursor: pointer"><i
                                                        class="fa fa-eye fa-fw text-primary ml-1"></i> عرض </a>
                                                <a href="{{route('invoice.edit', $invoice->id)}}" class="dropdown-item"
                                                   style="cursor: pointer"><i
                                                        class="fa fa-edit fa-fw ml-1"></i> تعديل </a>
                                                <a class="dropdown-item text-dark ml-1 " style="font-size: 14px"
                                                   href="{{route('payment.create', $invoice->id)}}"><i
                                                        class="fa fa-credit-card fa-fw text-dark"></i> إضافة عملية دفع
                                                </a>
                                                <a class="dropdown-item text-dark ml-2 mb-1"
                                                   href="{{route('send.email.invoice',$invoice->id)}}"><i
                                                        class="fa fa-envelope fa-fw"></i> إرسال إلى
                                                    العميل </a>
                                                <a href="/invoice/pdf/{{$invoice->id}}" target="_blank"
                                                   class="dropdown-item" style="cursor: pointer"><i
                                                        class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> عرض PDF
                                                </a>
                                                <a href="/invoice/pdf/{{$invoice->id}}" download=""
                                                   class="dropdown-item" style="cursor: pointer"><i
                                                        class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i> تحميل PDF
                                                </a>
                                                <a href="/invoice/print/{{$invoice->id}}" class="dropdown-item btnPrint"
                                                   style="cursor: pointer"><i class="fa fa-print fa-fw text-info ml-1"
                                                                              aria-hidden="true"></i> طباعة </a>
                                                <a href="" class=" delete_message dropdown-item" data-title="حذف فاتورة"
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
                                    <td colspan="5" class="text-center text-muted">لا توجد فواتير لعرضها</td>
                                </tr>
                            @endforelse


                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!--Internal  Flot js-->
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
    <script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
    <script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
    <!--Internal Apexchart js-->
    {{--<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>--}}
    <!-- Internal Map -->
{{--    <script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>--}}
{{--    <script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>--}}
    <script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
    <!--Internal  index js -->
    <script src="{{URL::asset('assets/js/index.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>
    <script>
        $('.delete_message').on('click', function () {
            let idMessage = $(this).data('id');
            console.log(idMessage);
            $('#modelDelete').attr('action', '/invoice/' + idMessage + '');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
        });
        $('.btnPrint').printPage({
            message: "جارى التجهيز لطباعة الفاتورة",
            afterCallback: function () {
                $('iframe').remove();
            }

        });
    </script>
@endsection
