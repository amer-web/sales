@extends('layouts.master')
@section('css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/date/jquery.datetimepicker.min.css') }}" rel="stylesheet"/>
    <style>
        label.error {
            color: red;
            font-weight: normal;
            font-size: 12px;
            display: block;
        }

        #client_id-error {
            display: block;
            position: absolute;
            right: 17px;
            bottom: 10px;
        }

    </style>
@endsection
@section('title', 'تعديل فاتورة مرتجعة')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{route('purchase-invoice.index')}}">إدارة فواتير الشراء</a></h4>
                <a href="{{route('purchase-invoice.show', $invoice_refund->invoice->id)}}"><span
                        class="text-muted mt-1 tx-13 mr-2 mb-0"> > فاتورة رقم {{$invoice_refund->invoice->id}} للمورد {{$invoice_refund->invoice->supplier->name}} </span></a>
                <span
                    class="text-muted mt-1 tx-13 mr-2 mb-0"> > تعديل فاتورة مرتجعة </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('invoice-refund-purchase.update', $invoice_refund->id)}}" method="POST" id="formData"
                          style="font-weight: bold"
                          class="pb-5">
                        @csrf
                        @method('PUT')
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">المورد: <span class="tx-danger">*</span></label>
                                    <select name="client_id" class="w-75 clients">
                                        <option value="{{$invoice_refund->invoice->supplier->id}}">{{$invoice_refund->invoice->supplier->name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ الفاتورة المرتجعة: <span class="tx-danger">*</span></label>
                                    <input id="checkin" class="form-control border-secondary w-75" name="invoice_date"
                                           placeholder="تاريخ إصدار الفاتورة" value="{{$invoice_refund->invoice_date}}"
                                           required=""
                                           type="text">
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mg-b-0 text-md-nowrap ">
                                                <thead>
                                                <tr>
                                                    <th>أسم المنتج</th>
                                                    <th>سعر الوحدة</th>
                                                    <th>الكمية</th>
                                                    <th>المجموع</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody class="pb-5 data">
                                                @foreach($invoice_refund->purchaseRefund as $bellSale)
                                                    <tr>
                                                        <td class="w-25">
                                                            <select name="invoice[{{$loop->index}}][product_id]"
                                                                    class="products w-100">
                                                                <option></option>
                                                                @foreach($products as $product)
                                                                    @if(in_array($product->id,$products_id))
                                                                        <option
                                                                            value="{{$product->id}}" {{$bellSale->product_id == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td><input type="number"
                                                                   name="invoice[{{$loop->index}}][purchase_price]"
                                                                   placeholder="سعر بيع الوحدة" class="sale_price"
                                                                   data-info="sale_price" style="height: 33px" min="0"
                                                                   value="{{$bellSale->purchase_price}}"
                                                            ></td>
                                                        <td><input type="number"
                                                                   name="invoice[{{$loop->index}}][amount]"
                                                                   placeholder="الكمية" class="amount"
                                                                   style="height: 33px"
                                                                   min="0" value="{{$bellSale->amount}}">

                                                        </td>
                                                        <td class="total">
                                                            0.00
                                                        </td>
                                                        @if($loop->index != 0)
                                                            <td>
                                                                <button type="button"
                                                                        class="close border-0 text-danger opacity-1 close-row">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                                <tfoot>
                                                <tr id="info-total">
                                                    <td colspan="2" class="text-right mr-5">
                                                        <div>
                                                            <a class="btn btn-dark btn-sm text-light font-weight-bold mt-2"
                                                               onclick="event.preventDefault()" id="addInvoice"
                                                               style="cursor: pointer">إضافة سطر جديد <i
                                                                    class="fa fa-plus"></i></a>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" class="text-left mr-5">الإجمـــالــى</td>
                                                    <td class="sum-total"></td>
                                                </tr>
                                                </tfoot>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- tab -->
                            <div class="panel panel-primary tabs-style-3 pt-0 w-100" style="margin-top: -15px">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu ">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">

                                            <li><a href="#tab12" class="active" data-toggle="tab">الخصم والضريبة</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body mt-2">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab12">
                                            <div class="row row-sm">
                                                <div class="col-6">
                                                    <div class="form-group mg-b-0">
                                                        <label class="form-label">الخصم </label>
                                                        <input type="number" name="discount"
                                                               class="form-control border-secondary w-50"
                                                               value="{{$invoice_refund->discount}}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group mg-b-0">

                                                        <label class="form-label mr-2 mt-2">الضريبة (نسبة مئوية)
                                                            <button class="border-0" data-placement="top"
                                                                    data-toggle="tooltip-primary"
                                                                    title="أكتب النسبة بدون العلامة المئوية(%)"
                                                                    type="button"><i class="fa fa-question-circle"
                                                                                     aria-hidden="true"></i></button>
                                                        </label>
                                                        <input type="number" name="vat"
                                                               class="form-control border-secondary w-50"
                                                               value="{{$invoice_refund->vat}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">حفظ الفاتورة</button>
                            </div>
                        </div>
                    </form>
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
    <script src="{{ asset('assets/plugins/date/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-validation/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/plugins/form-validation/messages_ar.js') }}"></script>
    <script src="{{ asset('assets/js/calculate.js') }}"></script>

    <script>
        $(function () {

            $(document).ready(function () {
                $('.amount').keyup();


            });
            // $('#formData').on('keyup','.amount',function(){
            //     let input = $(this).closest('tr').find('.products');
            //     let product_id = $(this).closest('tr').find('.products').val();
            //     let ah = [];
            //     $('.products').each(function (){
            //         if(input[0] != $(this)[0])
            //         {
            //             ah.push($(this).val());
            //         }
            //     });
            //     if(jQuery.inArray(product_id,ah) !== -1){
            //         let increase = parseInt(input.closest('tr').find('.amount').val());
            //         $('.products').each(function (){
            //             if($(this).val() == product_id && $(this)[0] != input[0])
            //             {
            //                 let inputAmount = parseInt( $(this).closest('tr').find('.amount').val());
            //                 $(this).closest('tr').find('.amount').val(inputAmount + increase);
            //                 $(this).closest('tr').find('.amount').focus().select();
            //                 let total = parseFloat($(this).closest('tr').find('.amount').val()) * parseFloat($(this).closest('tr').find('.sale_price').val());
            //                 $(this).closest('tr').find('.total').text(total.toFixed(2));
            //                 input.closest('tr').remove();
            //             }
            //         });
            //     }
            //
            // });

            $('tbody').on('change', '.products', function () {
                let id = $(this).val(),
                    input = $(this);
                $.ajax({
                    method: "POST",
                    url: "{{ route('purchase-price-refund') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                        'invoice_id': {{$invoice_refund->invoice->id}}
                    },
                    success: function (data, two) {
                        if (two === 'success') {
                            let inputSalePrice = input.parent().siblings('td').children('.sale_price'),
                                inputAmount = input.parent().siblings('td').children('.amount');
                            if (data.purchase_price != null) {
                                let salePrice = data.purchase_price.purchase_price;
                                inputSalePrice.val(salePrice);
                                inputAmount.val(1);
                                inputAmount.attr('max',data.available);
                                inputAmount.css('width','95%');
                                inputAmount.focus().select();
                                (inputSalePrice, inputAmount).keyup();

                            } else {
                                inputSalePrice.val(0);
                                inputAmount.val(0);
                                (inputSalePrice, inputAmount).keyup();
                            }
                        }

                    },
                });
            });
            let pluginSelect2 = function (selector, placeholder) {
                $(selector).select2({
                    placeholder: placeholder,
                    dir: 'rtl'
                });
            }
            pluginSelect2('.products', 'أختر المنتج');
            pluginSelect2('.clients', 'أختر العميل');

            $("#formData").on('click', '#addInvoice', function () {
                let i = $('.sale_price').length;
                $("tbody.data").append('<tr>\n' +
                    '   <td class="w-25">\n' +
                    '<select name="invoice[' + i + '][product_id]" class="products w-100">\n' +
                    '         <option></option>\n' +
                    '           @foreach($products as $product)\n' +
                    '      @if(in_array($product->id,$products_id))'+
                    '        <option value="{{$product->id}}">{{$product->name}}</option>\n' +
                    '       @endif' +
                    '           @endforeach\n' +
                    '    </select>\n' +
                    '    </td>\n' +
                    '    <td class="w-25"><input type="number" name="invoice[' + i + '][purchase_price]" min="1" placeholder="سعر بيع الوحدة" class="sale_price" data-info="sale_price" style="height: 33px"></td>\n' +
                    '    <td class="w-25"><input type="number" name="invoice[' + i + '][amount]" min="1" placeholder="الكمية" class="amount" style="height: 33px"></td>\n' +
                    '    <td class="total">0.00\n' +
                    '\n' +
                    '    </td>\n <td>\n' +
                    '  <button type="button" class="close border-0 text-danger opacity-1 close-row" >\n' +
                    '  <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '  </td>' +
                    '  </tr>');
                i++;
                pluginSelect2('.products', 'أختر المنتج');

            });
        });

    </script>
@endsection
