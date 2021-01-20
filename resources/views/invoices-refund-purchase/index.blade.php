@extends('layouts.master')
@section('css')
@endsection
@section('title','مرتجعات المشتريات')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{route('purchase-invoice.index')}}">فواتير
                        المشتريات</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > مرتجعات المشتريات  </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <!--div-->
        <div class="table-responsive mt-3">

            <table class="table table-striped mg-b-0 text-lg-nowrap ">
                <thead>
                <tr class="text-center font-weight-bold">
                    <th class="text-center">رقم الفاتورة</th>
                    <th class="text-center">المورد</th>
                    <th class="text-center">تاريخ إصدار الفاتورة</th>
                    <th class="text-center">المبلغ المرتجع</th>
                    <th class="text-center">العمليات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($invoicesRefund as $invoiceRefund)
                    <tr>
                        <th scope="row" class="text-center">{{$invoiceRefund->id}}</th>
                        <td class="text-center"><a href="#">{{$invoiceRefund->invoice->supplier->name}}</a></td>
                        <td class="text-center">{{$invoiceRefund->created_at->format('Y-m-d')}}</td>
                        <td class="text-center">
                            {{$invoiceRefund->total_refund}}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('invoice-refund-purchase.show', $invoiceRefund->id) }}" class=""><i
                                    class="fa fa-eye fa-fw"></i></a>
                            <a href="{{ route('invoice-refund-purchase.edit', $invoiceRefund->id) }}"><i
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
                    <tr>
                        <td colspan="5" class="text-center text-muted">لا توجد فواتير مرتجعة لعرضها</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            <div class="d-flex justify-content-center py-3">
                {{--                {{$payments->links()}}--}}
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
        let deleteItem = function (selector, url) {
            $(selector).on('click', function () {
                let idMessage = $(this).data('id');
                $('#modelDelete').attr('action', '/' + url + '/' + idMessage + '');
                $("#exampleModalLabel").text($(this).data('title'));
                $(".modal-body").text($(this).data('description'));
            });
        }
        deleteItem('.delete_invoice-refund', 'invoice-refund-purchase');

    </script>
@endsection
