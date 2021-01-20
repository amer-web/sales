@extends('layouts.master')
@section('css')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"/>
@endsection
@section('title','إدارة فواتير الشراء')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">فواتير الشراء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة الفواتير </span>
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
                    <div class="main-content-label mg-b-7">
                        بحث
                    </div>
                    <form action="{{route('purchase-invoice.index')}}" data-parsley-validate="" method="get">
                        <div class="row mg-t-10 mg-b-10">
                            <div class="col-lg-4">
                                <label class="rdiobox"><input {{$requestRadio <= 1 ? 'checked' : '' }} name="rdio" type="radio" value="1"> <span>بحالة الفاتورة أو اسم المورد</span></label>
                            </div>
                            <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label class="rdiobox"><input name="rdio" {{$requestRadio == 2 ? 'checked' : '' }} type="radio" value="2">
                                    <span>برقم الفاتورة</span></label>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-4 " id="tab-search-2">
                                <div class="form-group">
                                    <label class="form-label">رقم الفاتورة </label>
                                    <input class="form-control" name="invoice_id" placeholder="أكتب رقم الفاتورة"
                                           type="text" value="{{request()->invoice_id}}">
                                </div>
                            </div>
                            <div class="col-8" id="tab-search-1">
                                <div class="row row-sm">
                                    <div class="col-6">
                                        <div class="form-group mg-b-0">
                                            <label class="form-label">الحالة </label>
                                            <select name="status" class="w-75 status-invoices">
                                                <option {{$requestStatus == -1 ? 'selected' : ''}}></option>
                                                <option value="1" {{$requestStatus == 1 ? 'selected' : ''}}>مدفوعة</option>
                                                <option value="0" {{$requestStatus == 0 ? 'selected' : ''}}>غير مدفوعة</option>
                                                <option value="4" {{$requestStatus == 4 ? 'selected' : ''}}>متأخرة</option>
                                                <option value="2" {{$requestStatus == 2 ? 'selected' : ''}}>مدفوعة جزئياً</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">اسم المورد</label>
                                            <select name="supplier_id" class="w-75 suppliers">
                                                <option></option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}" {{$requestSupplier == $supplier->id ? 'selected' : ''}}>{{$supplier->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row justify-content-between">
                                <button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">بحث</button>
                                <a class="btn btn-outline-secondary pd-x-20 mg-t-10" href="{{route('purchase-invoice.index')}}"> الغاء الفلتر</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">النتائج</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding-bottom: 274px">
                        <table class="table mg-b-0 text-md-nowrap" >
                            <thead>
                            <tr>
                                <th class="text-center">رقم الفاتورة</th>
                                <th>المورد</th>
                                <th>تاريخ إصدار الفاتورة</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <th scope="row" class="text-center">{{$invoice->id}}</th>
                                    <td><a href="{{route('purchase-invoice.show',$invoice->id)}}">{{$invoice->supplier->name}}</a> </td>
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
                                                <a href="{{route('purchase-invoice.show', $invoice->id)}}" class="dropdown-item" style="cursor: pointer"><i
                                                        class="fa fa-eye fa-fw text-primary ml-1"></i> عرض </a>
                                                <a href="{{route('purchase-invoice.edit', $invoice->id)}}" class="dropdown-item" style="cursor: pointer"><i
                                                        class="fa fa-edit fa-fw ml-1"></i> تعديل </a>
                                                <a class="nav-link text-dark ml-1 " style="font-size: 14px" href="{{route('payment-purchase.create', $invoice->id)}}"><i class="fa fa-credit-card fa-fw text-dark" ></i> إضافة عملية دفع </a>
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
                                                <a href="/invoice-purchase/print/{{$invoice->id}}"  class="dropdown-item btnPrint" style="cursor: pointer"><i class="fa fa-print fa-fw text-info ml-1" aria-hidden="true"></i> طباعة </a>
                                                <a href="" class=" delete_message dropdown-item" data-title="حذف فاتورة"
                                                   data-description="هل تريد حذف فاتورة المورد ({{$invoice->supplier->name}})"
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
        <!-- row closed -->

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $('.delete_message').on('click', function () {
            let idMessage = $(this).data('id');
            console.log(idMessage);
            $('#modelDelete').attr('action', '/purchase-invoice/' + idMessage + '');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
        });
        $('.btnPrint').printPage({
            message:"جارى التجهيز لطباعة الفاتورة",
            afterCallback:function (){
                $('iframe').remove();
            }
        });
        if(1 >= {{$requestRadio}})
        {
            $('#tab-search-2').hide();
        } else {
            $('#tab-search-1').hide();

        }
        $('input[name="rdio"]').on('change', function () {
            $('#tab-search-1').hide();
            $('#tab-search-2').hide();
            let radioVal = $(this).val();
            $('#tab-search-' + radioVal + '').show();

        });
        let pluginSelect2 = function (selector, placeholder) {
            $(selector).select2({
                placeholder: placeholder,
                dir: 'rtl'
            });
        }
        pluginSelect2('.status-invoices', 'أختر الحالة');
        pluginSelect2('.suppliers', 'أختر المورد');
    </script>
@endsection
