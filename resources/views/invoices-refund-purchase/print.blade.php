@extends('layouts.app')
@section('css')
@endsection

@section('content')
    <!-- row -->
    <div class="row row-sm mx-0 px-4 tx-bold " style="line-height: 2.3">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">فاتورة مشتريات مرتجعة</h1>
                            <div class="billed-from">
                                <h6>شركة المصرية للإستيراد والتصدير</h6>
                                <p>قنا - قوص - ش الجمهورية<br>
                                    تليفون : 01112795101<br>
                                    البريد الإلكترونى : amer@gmail.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">فاتورة مشتريات مرتجعة </label>
                                <div class="billed-to">
                                    <h6>{{$invoice_refund->invoice->supplier->name}}</h6>
                                    <p>العنوان : {{$invoice_refund->invoice->supplier->address}}<br>
                                        تليفون : {{$invoice_refund->invoice->supplier->phone}}<br>
                                        البريد الإلكترونى : {{$invoice_refund->invoice->supplier->email}}</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">  بيانات الفاتورة المرتجعة</label>
                                <p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{$invoice_refund->id}}</span></p>
                                <p class="invoice-info-row"><span>تاريخ الإصدار</span>
                                    <span>{{$invoice_refund->invoice_date}}</span></p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr class="bg-gray-100 tx-bold">
                                    <th class="wd-10p">#</th>
                                    <th class="wd-20p">الصنف</th>
                                    <th class="tx-center">سعر الوحدة</th>
                                    <th class="tx-right">الكمية</th>
                                    <th class="tx-right">المجموع</th>
                                </tr>
                                </thead>
                                <tbody class="text-dark">
                                @foreach($invoice_refund->purchaseRefund as $purchaseRefund)
                                    <tr class="font-weight-bold">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$purchaseRefund->product->name}}</td>
                                        <td class="tx-center">{{$purchaseRefund->purchase_price}}</td>
                                        <td class="tx-right">{{$purchaseRefund->amount}}</td>
                                        <td class="tx-right">{{$purchaseRefund->total}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="3"></td>
                                    <td class="tx-right">الإجمـــالى</td>
                                    <td class="tx-right" colspan="2">{{number_format($invoice_refund->purchaseRefund->sum('total'),2) }}</td>
                                </tr>
                                @if($invoice_refund->discount != 0)
                                    <tr class="font-weight-bold">
                                        <td colspan="3"></td>
                                        <td class="tx-right">الخصم</td>
                                        <td class="tx-right" colspan="2">- {{$invoice_refund->discount}}</td>
                                    </tr>
                                @endif
                                @if($invoice_refund->vat != 0 && $invoice_refund->value_rate !=0)
                                    <tr class="font-weight-bold">
                                        <td colspan="3"></td>
                                        <td class="tx-right">ضريبة ({{$invoice_refund->vat}} %)</td>
                                        <td class="tx-right" colspan="2"> {{$invoice_refund->value_rate}}</td>
                                    </tr>
                                @endif
                                @if($invoice_refund->vat != 0 || $invoice_refund->discount !=0)
                                    <tr class="font-weight-bold">
                                        <td colspan="3"></td>
                                        <td class="tx-right">الإجمـــالى</td>
                                        <td class="tx-right" colspan="2">{{$invoice_refund->total_refund}}</td>
                                    </tr>
                                @endif

                                </tfoot>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->


@endsection
@section('js')

@endsection
