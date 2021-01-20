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
                            <h1 class="invoice-title">كشف حساب</h1>
                            <div class="billed-from">
                                <h6>شركة المصرية للإستيراد والتصدير</h6>
                                <p>قنا - قوص - ش الجمهورية<br>
                                    تليفون : 01112795101<br>
                                    البريد الإلكترونى : amer@gmail.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">كشف حساب للمورد </label>
                                <div class="billed-to">
                                    <h6>{{$supplier->name}}</h6>
                                    <p>العنوان : {{$supplier->address}}<br>
                                        تليفون : {{$supplier->phone}}<br>
                                        البريد الإلكترونى : {{$supplier->email}}</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">بيانات كشف الحساب</label>
                                <p class="invoice-info-row"><span>مـــن تــاريخ : </span> <span></span></p>
                                <p class="invoice-info-row"><span> إلــى تـــاريخ : </span> <span></span></p>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">

                            <table class="table table-striped mg-b-3 text-lg-nowrap ">
                                <thead>
                                <tr class="text-center">
                                    <th style="font-size: 15px;">التاريخ</th>
                                    <th style="font-size: 15px;">العملية</th>
                                    <th style="font-size: 15px;">المبلغ</th>
                                    <th style="font-size: 15px;">المبلغ المستحق</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="tx-bold">رصيد بداية المدة</td>
                                    <td colspan="2"></td>
                                    <td>
                                        <input name="totalDue" class="form-control text-center tx-bold  total-due"
                                               readonly
                                               value="0.00">
                                    </td>
                                </tr>
                                @foreach($accounts as $account)
                                    <tr class="text-center">
                                        <td>{{$account->created_at->format('d-m-Y')}}<br>
                                            <span>{{$account->created_at->format('H:i')}}</span></td>
                                        <td>
                                            @if(isset($account->total_due))
                                                فاتورة رقم {{$account->id}}
                                            @else
                                                عملية دفع رقم {{$account->id}} عن طريق {{$account->methodPayment->name}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($account->total_due))
                                                <input name="total" class="form-control text-center tx-bold price-total"
                                                       readonly
                                                       value="{{$account->total_due}}">
                                            @else
                                                <input name="paid" class="form-control text-center tx-bold price-total"
                                                       readonly
                                                       value="-{{$account->paid}}">
                                            @endif
                                        </td>
                                        <td>
                                            <input name="totalDue" class="form-control text-center tx-bold total-due"
                                                   readonly>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr class="text-center">
                                    <td class="tx-bold">رصيد نهاية المدة</td>
                                    <td></td>
                                    <td class="tx-bold tx-left">المبلغ المستحق</td>
                                    <td class="tx-bold totalPriceDue " style="font-size: 17px "></td>
                                </tr>
                                </tfoot>
                            </table>

                        </div><!-- bd -->


                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->


@endsection
@section('js')
    <script>
        $(document).ready(function () {

            $('input[name="totalDue"]').change();
        });
        $('input[name="totalDue"]').on('change', function () {
            let $row = $(this).closest('tr');
            let totalPricePrev = parseFloat($row.prev('tr').find('.total-due').val());
            let totalCurrent = parseFloat($row.find('.price-total').val());
            if (!$row.is(':first-child')) {
                $(this).val((totalCurrent + totalPricePrev).toFixed(2))
            }
            if ($row.is(':last-child')) {
                $('.totalPriceDue').text(parseFloat($(this).val()).toFixed(2));
            }
        });
    </script>
@endsection
