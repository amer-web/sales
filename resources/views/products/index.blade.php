@extends('layouts.master')
@section('css')
@endsection
@section('title', 'إدارة المنتجات')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المنتجات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">> إدارة المنتجات</span>
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
                        <form action="{{ route('product.index') }}" method="GET">
                            <div class="row">
                                <div class="col-12 col-sm">
                                    <div class="form-group ">
                                        <label class="form-label">البحث بكلمة مفتاحية </label>
                                        <input type="text" placeholder="ابحث عن منتج" name="keywords"
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
                    <div class="table-responsive mt-3">
                        <h5 class="mb-4 text-muted">النتائج</h5>
                        <table class="table table-striped mg-b-0 text-lg-nowrap ">
                            <thead>
                            <tr class="text-center">
                                <th>كود المنتج</th>
                                <th>اسم المنتج</th>
                                <th>سعر البيع</th>
                                <th>عمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($products as $product)
                                <tr class="text-center">
                                    <td class="text-capitalize">{{ $product->id }}</td>
                                    <td><a href="{{route('product.show',$product->name)}}">{{ $product->name }}</a></td>
                                    @if($product->sellingPrice()->count() > 0)
                                        <td>{{ $product->sellingPrice->selling_price }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>
                                        <a href="{{ route('product.show', $product->name) }}" class=""><i
                                                class="fa fa-eye fa-fw"></i></a>
                                        <a href="" class="modal-effect edit-product" data-toggle="modal"
                                           data-target="#exampleModalEdit" id="{{$product->id}}"
                                           data-action="{{route('product.update', $product->id)}}"
                                           data-name="{{$product->name}}" data-description="{{ $product->description}}"
                                           data-price="{{$product->sellingPrice == null ? '' : $product->sellingPrice->selling_price}}"><i
                                                class="fa fa-edit fa-fw text-dark"></i></a>
                                        <a href="" class="btn btn-light p-1 delete_message" data-title="حذف منتج"
                                           data-description="هل تريد حذف المنتج ( {{$product->name}} )"
                                           data-toggle="modal" data-target="#exampleModal" data-id="{{ $product->id }}"><i
                                                class="fa fa-trash fa-fw text-danger"></i></a>
                                    </td>
                                </tr>
                            @empty

                            @endforelse
                            </tbody>
                        </table>

                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
    </div>


    <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="product-form">
                        @csrf
                        @method('PUT')
                        <div class="row row-sm">
                            <div class="col-8">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">إسم المنتج: <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="name" placeholder="اسم المنتج" type="text"
                                           autocomplete="off" value="{{old('name')}}">
                                    @error('name')
                                    <span class="text-danger mb-3 d-block mt-1"
                                          style="font-size: 12px">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm mt-3">
                            <div class="col-8">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">سعر البيع: </label>
                                    <input class="form-control" name="selling_price" placeholder="سعر البيع" type="text"
                                           autocomplete="off" value="{{old('selling_price')}}">
                                    @error('selling_price')
                                    <span class="text-danger mb-3 d-block mt-1"
                                          style="font-size: 12px">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group mg-b-0 mt-3">
                                    <label class="form-label">الوصف</label>
                                    <textarea name="description" class="form-control" placeholder="وصف المنتج"
                                              style="height: 100px;resize: none">{{old('description')}}</textarea>
                                    @error('description')
                                    <span class="text-danger mb-3 d-block mt-1"
                                          style="font-size: 12px">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تعديل المنتج</button>
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
    <script>
        $('.delete_message').on('click', function () {
            let idMessage = $(this).data('id');
            console.log(idMessage);
            $('#modelDelete').attr('action', '/product/' + idMessage + '');
            $("#exampleModalLabel").text($(this).data('title'));
            $(".modal-body").text($(this).data('description'));
        });

        $('.edit-product').on('click', function () {
            let action = $(this).data('action'),
                name = $(this).data('name'),
                price = $(this).data('price'),
                description = $(this).data('description');
            $('#product-form').attr('action', action);
            $('input[name="name"]').val(name);
            $('input[name="selling_price"]').val(price);
            $('textarea[name="description"]').val(description);
        });
        @if($errors->any())
        @if ($errors->has('product_id'))
        let id = "#{{$errors->first('product_id')}}";
        $(id).click();
        @endif
        @endif

    </script>
@endsection
