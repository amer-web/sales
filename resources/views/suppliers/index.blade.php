@extends('layouts.master')
@section('css')
@endsection
@section('title', 'إدارة الموردين')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الموردين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">> إدارة الموردين</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <!--div-->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2">
                        <form action="{{ route('supplier.index') }}" method="GET">
                            <div class="row">
                                <div class="col-12 col-sm">
                                    <div class="form-group ">
                                        <label class="form-label">البحث بكلمة مفتاحية </label>
                                        <input type="text" placeholder="ابحث عن مورد" name="keywords"
                                               value="{{ old('keywords', request()->keywords) }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-sm">
                                    <div class="form-group mb-0 mt-sm-4">
                                        <input type="submit" value="أبحث" class="btn btn-outline-primary">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive mt-3 ">
                        <h5 class="mb-4 text-muted">النتائج</h5>
                        <table class="table table-striped mg-b-3 text-lg-nowrap ">
                            <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>اسم المورد</th>
                                <th>رقم الهاتف</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($suppliers as $supplier)
                                <tr class="text-center">
                                    <td class="text-capitalize">{{ $loop->iteration }}</td>
                                    <td><a href="{{route('supplier.show', $supplier->id)}}">{{ $supplier->name }}</a></td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>
                                        <a href="{{ route('supplier.show', $supplier->id) }}" class=""><i
                                                class="fa fa-eye fa-fw"></i></a>
                                        <a href="{{route('supplier.edit', $supplier->id)}}"><i
                                                class="fa fa-edit fa-fw text-dark"></i></a>
                                        <a href="" class="btn btn-light p-1 delete_message" data-title="حذف مورد"
                                           data-description="هل تريد حذف المورد ( {{$supplier->name}} )"
                                           data-toggle="modal" data-target="#exampleModal"
                                           data-id="{{ $supplier->id }}"><i
                                                class="fa fa-trash fa-fw text-danger"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted"> لا يوجد عملاء لعرضها أنقر <a
                                            href="{{route('supplier.create')}}" class="tx-bold">هنا</a> لإضافة عميل جديد
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{$suppliers->links()}}
                        </div>

                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
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
            $('#modelDelete').attr('action', '/supplier/' + idMessage + '');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
        });




    </script>
@endsection
