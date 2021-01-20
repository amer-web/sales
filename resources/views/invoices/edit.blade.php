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
@section('title', 'تعديل فاتورة')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{route('invoice.index')}}">إدارة الفواتير</a></h4>
                <a href="{{route('invoice.show', $invoice->id)}}"><span
                        class="text-muted mt-1 tx-13 mr-2 mb-0"> > فاتورة رقم {{$invoice->id}} للعميل {{$invoice->client->name}} </span></a>
                <span
                    class="text-muted mt-1 tx-13 mr-2 mb-0"> > تعديل فاتورة  </span>
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
                    <form action="{{route('invoice.update', $invoice->id)}}" method="POST" id="formData"
                          style="font-weight: bold"
                          class="pb-5">
                        @csrf
                        @method('PUT')
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">العميل: <span class="tx-danger">*</span></label>
                                    <select name="client_id" class="w-75 clients">
                                        <option></option>
                                        @foreach($clients as $client)
                                            <option
                                                value="{{$client->id}}" {{($invoice->client_id == $client->id)? 'selected' : ''}}>{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-50 mr-auto mt-3">
                                    <a class="modal-effect btn btn-outline-primary btn-sm mory" data-toggle="modal"
                                       data-target="#exampleModal" data-whatever="@mdo">أضف عميل جديد</a>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ الإصدار: <span class="tx-danger">*</span></label>
                                    <input id="checkin" class="form-control border-secondary w-75" name="invoice_date"
                                           placeholder="تاريخ إصدار الفاتورة" value="{{$invoice->invoice_date}}"
                                           required=""
                                           type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mt-3">
                                    <label class="form-label">تاريخ الإستحقاق : </label>
                                    <div class="row ">
                                        <div>
                                            <input class="form-control border-secondary" name="due_date"
                                                   type="text" value="{{$invoice->due_date}}" autocomplete="off">
                                        </div>

                                    </div>
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
                                                @foreach($invoice->bellSales as $bellSale)
                                                    <tr>
                                                        <td class="w-25">
                                                            <select name="invoice[{{$loop->index}}][product_id]"
                                                                    class="products w-100">
                                                                <option></option>
                                                                @foreach($products as $product)
                                                                    <option
                                                                        value="{{$product->id}}" {{$bellSale->product->id == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><input type="number"
                                                                   name="invoice[{{$loop->index}}][sale_price]"
                                                                   placeholder="سعر بيع الوحدة" class="sale_price"
                                                                   data-info="sale_price" style="height: 33px" min="0"
                                                                   value="{{$bellSale->sale_price}}"
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
                                                               value="{{$invoice->discount}}">
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
                                                               value="{{$invoice->vat}}">
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


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة عميل جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('client.store')}}" method="POST">
                        @csrf
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">إسم العميل بالكامل: <span
                                            class="tx-danger">*</span></label>
                                    <input class="form-control" name="name" placeholder="اسم العميل" type="text"
                                           autocomplete="off" value="{{old('name')}}">
                                    @error('name')
                                    <span class="text-danger mb-3 d-block mt-1"
                                          style="font-size: 12px">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">البريد الإلكترونى</label>
                                    <input class="form-control" name="email" placeholder="البريد الإلكترونى" type="text"
                                           autocomplete="off" value="{{old('email')}}">
                                    @error('email')
                                    <span class="text-danger mb-3 d-block mt-1"
                                          style="font-size: 12px">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">العنوان</label>
                                    <input class="form-control" name="address" placeholder="العنوان" type="text"
                                           autocomplete="off" value="{{old('address')}}">
                                    @error('address')
                                    <span class="text-danger mb-3 d-block mt-1"
                                          style="font-size: 12px">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">الهاتف</label>
                                    <input class="form-control" name="phone" placeholder="رقم الهاتف" type="text"
                                           autocomplete="off" value="{{old('phone')}}">
                                    @error('phone')
                                    <span class="text-danger mb-3 d-block mt-1"
                                          style="font-size: 12px">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">إضافة عميل جديد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
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
            @if($errors->any())
            $('.mory').trigger('click')
            @endif

            $('tbody').on('change', '.products', function () {
                let id = $(this).val(),
                    input = $(this);
                $.ajax({
                    method: "POST",
                    url: "{{ route('sale-price') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function (data, two) {
                        if (two === 'success') {
                            let inputSalePrice = input.parent().siblings('td').children('.sale_price'),
                                inputAmount = input.parent().siblings('td').children('.amount');
                            if (data.selling_price != null) {
                                let salePrice = data.selling_price;
                                inputSalePrice.val(salePrice);
                                inputAmount.val(1);
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
                    '        <option value="{{$product->id}}">{{$product->name}}</option>\n' +
                    '           @endforeach\n' +
                    '    </select>\n' +
                    '    </td>\n' +
                    '    <td><input type="number" name="invoice[' + i + '][sale_price]" min="0" placeholder="سعر بيع الوحدة" class="sale_price" data-info="sale_price" style="height: 33px"></td>\n' +
                    '    <td><input type="number" name="invoice[' + i + '][amount]" min="0" placeholder="الكمية" class="amount" style="height: 33px"></td>\n' +
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
