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
                            <h1 class="invoice-title">فاتورة بيع</h1>
                            <div class="billed-from">
                                <h6>شركة المصرية للإستيراد والتصدير</h6>
                                <p>قنا - قوص - ش الجمهورية<br>
                                    تليفون : 01112795101<br>
                                    البريد الإلكترونى : amer@gmail.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">فاتورة بيع لــ </label>
                                <div class="billed-to">
                                    <h6>{{$invoice->client->name}}</h6>
                                    <p>العنوان : {{$invoice->client->address}}<br>
                                        تليفون : {{$invoice->client->phone}}<br>
                                        البريد الإلكترونى : {{$invoice->client->email}}</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">بيانات الفاتورة</label>
                                <p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{$invoice->id}}</span></p>
                                <p class="invoice-info-row"><span>تاريخ الإصدار</span>
                                    <span>{{$invoice->invoice_date}}</span></p>
                                <p class="invoice-info-row"><span>تاريخ الإستحقاق</span>
                                    <span>{{$invoice->due_date}}</span></p>
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
                                @foreach($invoice->bellSales as $bell_sale)
                                    <tr class="font-weight-bold">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$bell_sale->product->name}}</td>
                                        <td class="tx-center">{{$bell_sale->sale_price}}</td>
                                        <td class="tx-right">{{$bell_sale->amount}}</td>
                                        <td class="tx-right">{{$bell_sale->total}}</td>
                                    </tr>
                                @endforeach


                                </tbody>
                                <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="3"></td>
                                    <td class="tx-right">الإجمـــالى</td>
                                    <td class="tx-right" colspan="2">{{$invoice->bellSales()->sum('total')}}</td>
                                </tr>
                                @if($invoice->discount != 0)
                                    <tr class="font-weight-bold">
                                        <td colspan="3"></td>
                                        <td class="tx-right">الخصم</td>
                                        <td class="tx-right" colspan="2">- {{$invoice->discount}}</td>
                                    </tr>
                                @endif
                                @if($invoice->vat != 0 && $invoice->value_rate !=0)
                                    <tr class="font-weight-bold">
                                        <td colspan="3"></td>
                                        <td class="tx-right">ضريبة ({{$invoice->vat}} %)</td>
                                        <td class="tx-right" colspan="2"> {{$invoice->value_rate}}</td>
                                    </tr>
                                @endif
                                @if($invoice->vat != 0 || $invoice->discount !=0)
                                    <tr class="font-weight-bold">
                                        <td colspan="3"></td>
                                        <td class="tx-right">الإجمـــالى</td>
                                        <td class="tx-right" colspan="2">{{$invoice->total_due}}</td>
                                    </tr>
                                @endif
                                @if($invoice->invoicesRefund()->sum('total_refund') > 0)
                                    <tr class="font-weight-bold">
                                        <td colspan="3"></td>
                                        <td class="tx-right">مرتجع</td>
                                        <td class="tx-right" colspan="2">{{$invoice->invoicesRefund()->sum('total_refund')}}</td>
                                    </tr>
                                @endif

                                <tr class="font-weight-bold">
                                    <td colspan="3"></td>
                                    <td class="tx-right">المبلغ المدفوع</td>
                                    <td class="tx-right"
                                        colspan="2"> {{number_format($invoice->payments()->sum('paid'),2)}}</td>
                                </tr>

                                <tr>
                                    <td colspan="3"></td>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">المبلغ المستحق</td>
                                    <td class="tx-right" colspan="2">
                                        <h5 class="tx-bold">{{number_format(($invoice->total_due - $invoice->invoicesRefund()->sum('total_refund')) - $invoice->payments()->sum('paid'),2)  }}</h5>
                                    </td>
                                </tr>
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
    {{--    <script>--}}
    {{--        window.print();--}}
    {{--    </script>--}}
@endsection
