@extends('layouts.master')
@section('css')
@endsection
@section('title', 'إدارة العملاء')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">العملاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">> إدارة العملاء</span>
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
                        <form action="{{ route('client.index') }}" method="GET">
                            <div class="row">
                                <div class="col-12 col-sm">
                                    <div class="form-group ">
                                        <label class="form-label">البحث بكلمة مفتاحية </label>
                                        <input type="text" placeholder="ابحث عن عميل" name="keywords"
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
                                <th>اسم العميل</th>
                                <th>رقم الهاتف</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($clients as $client)
                                <tr class="text-center">
                                    <td class="text-capitalize">{{ $loop->iteration }}</td>
                                    <td><a href="{{route('client.show', $client->id)}}">{{ $client->name }}</a></td>
                                    <td>{{ $client->phone }}</td>
                                    <td>
                                        <a href="{{ route('client.show', $client->id) }}" class=""><i
                                                class="fa fa-eye fa-fw"></i></a>
                                        <a href="{{route('client.edit', $client->id)}}"><i
                                                class="fa fa-edit fa-fw text-dark"></i></a>
                                        <a href="" class="btn btn-light p-1 delete_message" data-title="حذف عميل"
                                           data-description="هل تريد حذف العميل ( {{$client->name}} )"
                                           data-toggle="modal" data-target="#exampleModal"
                                           data-id="{{ $client->id }}"><i
                                                class="fa fa-trash fa-fw text-danger"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted"> لا يوجد عملاء لعرضها أنقر <a
                                            href="{{route('client.create')}}" class="tx-bold">هنا</a> لإضافة عميل جديد
                                    </td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{$clients->links()}}
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
            console.log(idMessage);
            $('#modelDelete').attr('action', '/client/' + idMessage + '');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
        });

        // function print() {
        //     var amer = $('#marmar')[0].innerHTML;
        //     console.log(amer)
        //     var orginal = document.body.innerHTML;
        //     document.body.innerHTML = amer;
        //     window.print();
        //     document.body.innerHTML = orginal;
        //     location.reload();
        // }


    </script>
@endsection
