@extends('layouts.master')
@section('css')
@endsection
@section('title','مدفوعات العملاء')
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">العملاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> > مدفوعات العملاء</span>
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
                    <th>رقم عملية الدفع</th>
                    <th>بيان</th>
                    <th>تاريخ الدفع</th>
                    <th>بواسطة</th>
                    <th>المبلغ</th>
                    <th>عمليات</th>
                </tr>
                </thead>
                <tbody>

                    @forelse ($payments as $payment)
                        <tr class="text-center">
                            <td class="">{{$payment->id}}</td>
                            <td class="">فاتورة رقم {{$payment->invoice->id}}
                                للعميل {{$payment->invoice->client->name}}</td>
                            <td class="">{{ $payment->created_at->format('Y-m-d') }}
                                <br>{{ $payment->created_at->format('H:i') }}</td>
                            <td>{{$payment->user->firstname}} {{$payment->user->lastname}}</td>
                            <td>{{$payment->paid}}</td>
                            <td>
                                <a href="{{ route('payment.show', $payment->id) }}" class=""><i
                                        class="fa fa-eye fa-fw"></i></a>
                                <a href="{{ route('payment.edit', $payment->id) }}"><i
                                        class="fa fa-edit fa-fw text-dark"></i></a>
                                <a href="" class="btn btn-light p-1 delete_message" data-title="حذف عملية دفع"
                                   data-description="هل تريد حذف عملية الدفع هذه ؟؟؟"
                                   data-toggle="modal" data-target="#exampleModal"
                                   data-id="{{ $payment->id }}"><i
                                        class="fa fa-trash fa-fw text-danger"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا يوجد مدفوعات للعملاء حتى الآن</td>
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
        $('.delete_message').on('click', function () {
            let idMessage = $(this).data('id');
            $('#modelDelete').attr('action', '/payment/' + idMessage + '');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
        });
    </script>
@endsection
